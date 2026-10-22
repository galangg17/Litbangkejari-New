@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; background: #F8FAFC; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif;">

    <!-- TOP NAV -->
    <header style="background: #072718; border-bottom: 2px solid #D4AF37; padding: 1rem 1.5rem; color: #FFF; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 0.85rem;">
            <a href="{{ route('dashboard.index', ['tab' => 'custom_forms']) }}" style="color: #D4AF37; text-decoration: none; font-size: 1.25rem;">←</a>
            <div>
                <span style="font-size: 0.6875rem; color: #D4AF37; font-weight: 800; text-transform: uppercase;">FORM BUILDER STUDIO</span>
                <h1 style="font-size: 1.15rem; font-weight: 900; margin: 0; color: #FFF;">{{ $form->title }}</h1>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 0.65rem; flex-wrap: wrap;">
            <a href="{{ route('forms.show', $form->slug) }}" target="_blank" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.3); color: #FFF; font-size: 0.78125rem; font-weight: 800; padding: 0.45rem 0.85rem; border-radius: 8px; text-decoration: none;">
                👁️ Pratinjau Form Publik
            </a>
            <a href="{{ route('dashboard.forms.responses', $form->id) }}" style="background: #16A34A; color: #FFF; font-size: 0.78125rem; font-weight: 900; padding: 0.45rem 1rem; border-radius: 8px; text-decoration: none; box-shadow: 0 2px 8px rgba(22,163,74,0.3);">
                📊 Lihat Respon ({{ $form->responses()->count() }})
            </a>
        </div>
    </header>

    @if(session('toast'))
        <div style="max-width: 1100px; margin: 1rem auto 0; padding: 0 1rem;">
            <div style="background: #ECFDF5; border: 1.5px solid #10B981; color: #065F46; font-weight: 800; font-size: 0.84375rem; padding: 0.85rem 1.25rem; border-radius: 12px;">
                ✨ {{ session('toast') }}
            </div>
        </div>
    @endif

    <!-- MAIN BUILDER LAYOUT -->
    <main style="max-width: 1100px; margin: 1.5rem auto 4rem; padding: 0 1rem; display: grid; grid-template-columns: 1fr 1.6fr; gap: 1.5rem; align-items: start;">

        <!-- LEFT PANEL: SETTINGS & ADD FIELD FORM -->
        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
            
            <!-- CARD 1: FORM SETTINGS -->
            <div style="background: #FFFFFF; border: 1.5px solid #CBD5E1; border-radius: 18px; padding: 1.35rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <h3 style="font-size: 0.9375rem; font-weight: 900; color: #072718; margin: 0 0 1rem; display: flex; align-items: center; gap: 0.4rem;">
                    ⚙️ Pengaturan Formulir
                </h3>

                <form action="{{ route('dashboard.forms.update', $form->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 0.85rem;">
                    @csrf
                    @method('PUT')

                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Judul Formulir *</label>
                        <input type="text" name="title" value="{{ $form->title }}" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;" />
                    </div>

                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Deskripsi / Petunjuk Pengisian</label>
                        <textarea name="description" rows="2" style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;">{{ $form->description }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.65rem;">
                        <div>
                            <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Status Publikasi</label>
                            <select name="status" style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.5rem; font-size: 0.8125rem; outline: none; font-weight: 700;">
                                <option value="open" {{ $form->status === 'open' ? 'selected' : '' }}>🟢 Buka (Aktif)</option>
                                <option value="closed" {{ $form->status === 'closed' ? 'selected' : '' }}>🔴 Ditutup</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Batas Waktu (Opsional)</label>
                            <input type="datetime-local" name="deadline_at" value="{{ $form->deadline_at ? $form->deadline_at->format('Y-m-d\TH:i') : '' }}" style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.5rem; font-size: 0.75rem; outline: none;" />
                        </div>
                    </div>

                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Pesan Sukses (Thank You Note)</label>
                        <input type="text" name="success_message" value="{{ $form->success_message }}" placeholder="Tanggapan Anda telah berhasil disimpan." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;" />
                    </div>

                    <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.78125rem; padding: 0.55rem 1rem; border-radius: 8px; border: 1px solid #C59B27; cursor: pointer;">
                        Simpan Perubahan Pengaturan
                    </button>
                </form>
            </div>

            <!-- CARD 2: ADD NEW FIELD (GOOGLE FORM QUESTION BUILDER) -->
            <div style="background: #FFFFFF; border: 1.5px solid #CBD5E1; border-radius: 18px; padding: 1.35rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);" x-data="{ selectedType: 'text' }">
                <h3 style="font-size: 0.9375rem; font-weight: 900; color: #072718; margin: 0 0 1rem; display: flex; align-items: center; gap: 0.4rem;">
                    ➕ Tambah Pertanyaan Baru
                </h3>

                <form action="{{ route('dashboard.forms.fields.store', $form->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 0.85rem;">
                    @csrf

                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Teks Pertanyaan / Label *</label>
                        <input type="text" name="field_label" placeholder="Contoh: No. Handphone / WhatsApp, Alasan Bergabung..." required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;" />
                    </div>

                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Tipe Jawaban *</label>
                        <select name="field_type" x-model="selectedType" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none; font-weight: 700;">
                            <option value="text">✏️ Jawaban Singkat (Text)</option>
                            <option value="textarea">📝 Paragraf Panjang (Textarea)</option>
                            <option value="radio">🔘 Pilihan Ganda (Radio Button)</option>
                            <option value="checkbox">☑️ Kotak Centang / Multi-pilih (Checkbox)</option>
                            <option value="select">🔽 Dropdown Pilihan</option>
                            <option value="file">📎 Upload Berkas / File</option>
                            <option value="date">📅 Tanggal (Date)</option>
                            <option value="number">🔢 Angka (Number)</option>
                        </select>
                    </div>

                    <!-- OPSIONAL PILIHAN OPSI (UNTUK RADIO, SELECT, CHECKBOX) -->
                    <div x-show="['radio', 'checkbox', 'select'].includes(selectedType)" style="background: #F1F5F9; border: 1px solid #CBD5E1; border-radius: 10px; padding: 0.75rem;">
                        <label style="font-size: 0.72rem; font-weight: 800; color: #0F172A; display: block; margin-bottom: 0.25rem;">
                            Daftar Pilihan Jawaban (Tulis 1 pilihan per baris):
                        </label>
                        <textarea name="options_raw" rows="3" placeholder="Pilihan 1&#10;Pilihan 2&#10;Pilihan 3" style="width: 100%; background: #FFF; border: 1px solid #CBD5E1; border-radius: 6px; padding: 0.4rem 0.6rem; font-size: 0.78125rem; outline: none;"></textarea>
                    </div>

                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Teks Bantuan / Keterangan (Opsional)</label>
                        <input type="text" name="help_text" placeholder="Contoh: Format PDF maksimal 10MB..." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.78125rem; outline: none;" />
                    </div>

                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.78125rem; font-weight: 800; color: #0F172A; cursor: pointer;">
                        <input type="checkbox" name="is_required" value="1" checked style="width: 16px; height: 16px; accent-color: #047857;" />
                        <span>Wajib Diisi (Required *)</span>
                    </label>

                    <button type="submit" style="background: #16A34A; color: #FFF; font-weight: 900; font-size: 0.8125rem; padding: 0.65rem 1rem; border-radius: 10px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.35rem; box-shadow: 0 4px 12px rgba(22,163,74,0.25);">
                        ➕ Tambahkan ke Formulir
                    </button>
                </form>
            </div>

        </div>

        <!-- RIGHT PANEL: PREVIEW & ORDER OF QUESTIONS -->
        <div style="background: #FFFFFF; border: 1.5px solid #CBD5E1; border-radius: 18px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; border-bottom: 1.5px solid #F1F5F9; padding-bottom: 0.85rem;">
                <div>
                    <span style="font-size: 0.72rem; color: #64748B; font-weight: 800; text-transform: uppercase;">STRUKTUR PERTANYAAN</span>
                    <h3 style="font-size: 1.1rem; font-weight: 900; color: #072718; margin: 0;">Daftar Pertanyaan Aktif ({{ $form->fields->count() }})</h3>
                </div>
                <span style="font-size: 0.75rem; color: #16A34A; font-weight: 800; background: #DCFCE7; padding: 0.25rem 0.65rem; border-radius: 9999px;">
                    Google Form Style
                </span>
            </div>

            @if($form->fields->isEmpty())
                <div style="text-align: center; padding: 3rem 1rem; color: #94A3B8; border: 2px dashed #E2E8F0; border-radius: 14px;">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📝</div>
                    <div style="font-weight: 800; font-size: 0.875rem; color: #475569;">Belum Ada Pertanyaan</div>
                    <div style="font-size: 0.78125rem;">Gunakan panel di sebelah kiri untuk menambahkan pertanyaan pertama Anda.</div>
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                    @foreach($form->fields as $index => $field)
                        <div style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 14px; padding: 1.15rem 1.25rem; display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem; flex-wrap: wrap;">
                                    <span style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.6875rem; padding: 0.15rem 0.5rem; border-radius: 6px;">
                                        #{{ $index + 1 }}
                                    </span>
                                    <span style="font-size: 0.6875rem; font-weight: 800; color: #0284C7; background: #E0F2FE; padding: 0.15rem 0.5rem; border-radius: 6px;">
                                        {{ strtoupper($field->field_type) }}
                                    </span>
                                    @if($field->is_required)
                                        <span style="font-size: 0.6875rem; font-weight: 800; color: #991B1B; background: #FEE2E2; padding: 0.15rem 0.5rem; border-radius: 6px;">
                                            WAJIB
                                        </span>
                                    @endif
                                </div>

                                <div style="font-size: 0.9375rem; font-weight: 900; color: #0F172A; line-height: 1.35; margin-bottom: 0.25rem;">
                                    {{ $field->field_label }}
                                </div>

                                @if($field->help_text)
                                    <div style="font-size: 0.75rem; color: #64748B; margin-bottom: 0.4rem;">
                                        💡 {{ $field->help_text }}
                                    </div>
                                @endif

                                @if(!empty($field->options))
                                    <div style="display: flex; gap: 0.35rem; flex-wrap: wrap; margin-top: 0.4rem;">
                                        @foreach($field->options as $opt)
                                            <span style="background: #FFF; border: 1px solid #CBD5E1; color: #475569; font-size: 0.71875rem; font-weight: 700; padding: 0.15rem 0.45rem; border-radius: 4px;">
                                                • {{ $opt }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <form action="{{ route('dashboard.forms.fields.destroy', $field->id) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; width: 32px; height: 32px; border-radius: 8px; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Hapus Pertanyaan">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </main>
</div>
@endsection
