@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; background: #F1F5F9; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif;" 
     x-data="{ 
         selectedType: 'radio',
         hasReason: true,
         reasonLabel: 'Sebutkan alasan atau penjelasan pilihan Anda...',
         reasonTrigger: 'all',
         editingField: null,
         isEditModalOpen: false,
         openEditModal(field) {
             this.editingField = JSON.parse(JSON.stringify(field));
             this.isEditModalOpen = true;
         },
         applyPreset(type) {
             const labelInput = document.getElementById('field_label_input');
             const optionsInput = document.getElementById('options_raw_input');
             const reasonLabelInput = document.getElementById('reason_label_input');
             
             if (type === 'identity') {
                 labelInput.value = 'Nama Lengkap Peserta';
                 this.selectedType = 'text';
                 this.hasReason = false;
                 if (optionsInput) optionsInput.value = '';
             } else if (type === 'class') {
                 labelInput.value = 'Kelas / Kelompok Belajar';
                 this.selectedType = 'text';
                 this.hasReason = false;
                 if (optionsInput) optionsInput.value = '';
             } else if (type === 'eval_reason') {
                 labelInput.value = 'Apakah ada mata kuliah yang menurut Anda perlu ditambah atau dikurangi jam pelajarannya? Sebutkan alasannya';
                 this.selectedType = 'radio';
                 this.hasReason = true;
                 this.reasonLabel = 'Sebutkan alasan & mata kuliah yang Anda maksud:';
                 if (reasonLabelInput) reasonLabelInput.value = this.reasonLabel;
                 if (optionsInput) {
                     optionsInput.value = 'Perlu Ditambah Jam Pelajarannya\nPerlu Dikurangi Jam Pelajarannya\nSudah Cukup & Sesuai';
                 }
             } else if (type === 'checkbox_eval') {
                 labelInput.value = 'Mata kuliah apa saja yang menurut Anda membutuhkan evaluasi jam pelajaran?';
                 this.selectedType = 'checkbox';
                 this.hasReason = true;
                 this.reasonLabel = 'Tuliskan alasan evaluasi untuk mata kuliah yang dipilih:';
                 if (reasonLabelInput) reasonLabelInput.value = this.reasonLabel;
                 if (optionsInput) {
                     optionsInput.value = 'PBB & Disiplin\nOlahraga & Kesamaptaan\nPemberlakuan KUHP Nasional\nPemberlakuan KUHAP 2025\nSistem Peradilan Pidana Anak\nPenanganan Tindak Pidana Cyber / AI';
                 }
             } else if (type === 'rating_scale') {
                 labelInput.value = 'Tingkat kepuasan Anda terhadap efektivitas kurikulum dan narasumber pengajar:';
                 this.selectedType = 'radio';
                 this.hasReason = true;
                 this.reasonLabel = 'Tuliskan saran konstruktif perbaikan:';
                 if (reasonLabelInput) reasonLabelInput.value = this.reasonLabel;
                 if (optionsInput) {
                     optionsInput.value = '5 - Sangat Memuaskan\n4 - Memuaskan\n3 - Cukup\n2 - Kurang Memuaskan\n1 - Tidak Memuaskan';
                 }
             }
         }
     }">

    <!-- TOP HEADER BAR -->
    <header style="background: linear-gradient(135deg, #072718 0%, #0D3E27 100%); border-bottom: 2.5px solid #D4AF37; padding: 1.15rem 2rem; color: #FFF; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.25);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="{{ route('dashboard.index', ['tab' => 'custom_forms']) }}" style="background: rgba(255,255,255,0.12); color: #D4AF37; border: 1px solid rgba(212,175,55,0.4); text-decoration: none; font-size: 1.1rem; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                ←
            </a>
            <div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 0.65rem; color: #D4AF37; font-weight: 900; letter-spacing: 0.05em; text-transform: uppercase; background: rgba(212,175,55,0.18); border: 1px solid rgba(212,175,55,0.4); padding: 0.15rem 0.5rem; border-radius: 9999px;">
                        STUDIO GOOGLE FORM LITBANG
                    </span>
                    @if($form->isOpen())
                        <span style="font-size: 0.65rem; color: #86EFAC; font-weight: 800; background: rgba(16,185,129,0.2); border: 1px solid #10B981; padding: 0.15rem 0.5rem; border-radius: 9999px;">
                            🟢 AKTIF MENERIMA RESPON
                        </span>
                    @else
                        <span style="font-size: 0.65rem; color: #FCA5A5; font-weight: 800; background: rgba(239,68,68,0.2); border: 1px solid #EF4444; padding: 0.15rem 0.5rem; border-radius: 9999px;">
                            🔴 DITUTUP
                        </span>
                    @endif
                </div>
                <h1 style="font-size: 1.3rem; font-weight: 900; margin: 0.2rem 0 0; color: #FFF; letter-spacing: -0.01em;">
                    {{ $form->title }}
                </h1>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 0.65rem; flex-wrap: wrap;">
            <a href="{{ route('forms.show', $form->slug) }}" target="_blank" style="background: rgba(255,255,255,0.12); border: 1.5px solid rgba(255,255,255,0.3); color: #FFF; font-size: 0.8125rem; font-weight: 800; padding: 0.5rem 1rem; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; backdrop-filter: blur(8px);">
                👁️ Buka Form Publik
            </a>
            <a href="{{ route('dashboard.forms.responses', $form->id) }}" style="background: linear-gradient(135deg, #16A34A 0%, #15803D 100%); color: #FFF; font-size: 0.8125rem; font-weight: 900; padding: 0.5rem 1.15rem; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 15px rgba(22,163,74,0.35); display: inline-flex; align-items: center; gap: 0.4rem;">
                📊 Rekap Respon ({{ $form->responses()->count() }})
            </a>
        </div>
    </header>

    @if(session('toast'))
        <div style="max-width: 1240px; margin: 1.25rem auto 0; padding: 0 1.25rem;">
            <div style="background: #ECFDF5; border: 1.5px solid #10B981; color: #065F46; font-weight: 800; font-size: 0.875rem; padding: 0.85rem 1.25rem; border-radius: 14px; box-shadow: 0 4px 15px rgba(16,185,129,0.15); display: flex; align-items: center; gap: 0.5rem;">
                <span>✨</span>
                <span>{{ session('toast') }}</span>
            </div>
        </div>
    @endif

    <!-- MAIN BUILDER WORKSPACE -->
    <main style="max-width: 1240px; margin: 1.5rem auto 5rem; padding: 0 1.25rem; display: grid; grid-template-columns: 1.15fr 1.65fr; gap: 1.75rem; align-items: start;">

        <!-- LEFT COLUMN: BUILDER STUDIO (PRESETS, ADD FORM, FORM SETTINGS) -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">

            <!-- CARD 1: QUESTION BUILDER STUDIO -->
            <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 1.5rem; box-shadow: 0 6px 20px rgba(0,0,0,0.03);">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.85rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="background: #072718; color: #D4AF37; font-size: 0.85rem; padding: 0.35rem 0.55rem; border-radius: 8px;">➕</span>
                        <h3 style="font-size: 1.05rem; font-weight: 900; color: #072718; margin: 0;">
                            Tambah Pertanyaan Baru
                        </h3>
                    </div>
                    <span style="font-size: 0.72rem; color: #64748B; font-weight: 700;">Drag-and-Drop Ready</span>
                </div>

                <!-- QUICK PRESET TEMPLATES -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 0.75rem; margin-bottom: 1.15rem;">
                    <div style="font-size: 0.6875rem; font-weight: 900; color: #475569; text-transform: uppercase; margin-bottom: 0.45rem;">
                        ⚡ Template Cepat 1-Klik:
                    </div>
                    <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
                        <button type="button" @click="applyPreset('identity')" style="background: #FFF; border: 1px solid #CBD5E1; color: #334155; font-size: 0.71875rem; font-weight: 800; padding: 0.35rem 0.65rem; border-radius: 8px; cursor: pointer;">
                            👤 Nama Peserta
                        </button>
                        <button type="button" @click="applyPreset('class')" style="background: #FFF; border: 1px solid #CBD5E1; color: #334155; font-size: 0.71875rem; font-weight: 800; padding: 0.35rem 0.65rem; border-radius: 8px; cursor: pointer;">
                            🏛️ Kelas/Angkatan
                        </button>
                        <button type="button" @click="applyPreset('eval_reason')" style="background: #ECFDF5; border: 1.5px solid #10B981; color: #065F46; font-size: 0.71875rem; font-weight: 900; padding: 0.35rem 0.65rem; border-radius: 8px; cursor: pointer;">
                            💬 Evaluasi + Alasan
                        </button>
                        <button type="button" @click="applyPreset('checkbox_eval')" style="background: #EFF6FF; border: 1px solid #93C5FD; color: #1E40AF; font-size: 0.71875rem; font-weight: 800; padding: 0.35rem 0.65rem; border-radius: 8px; cursor: pointer;">
                            ☑️ Multi-Pilih MK
                        </button>
                        <button type="button" @click="applyPreset('rating_scale')" style="background: #FFFBEB; border: 1px solid #FCD34D; color: #92400E; font-size: 0.71875rem; font-weight: 800; padding: 0.35rem 0.65rem; border-radius: 8px; cursor: pointer;">
                            ⭐ Rating 1-5
                        </button>
                    </div>
                </div>

                <form action="{{ route('dashboard.forms.fields.store', $form->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
                    @csrf

                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.35rem;">
                            Teks Pertanyaan / Label *
                        </label>
                        <textarea id="field_label_input" name="field_label" rows="2" placeholder="Contoh: Apakah ada mata kuliah yang menurut Anda perlu ditambah atau dikurangi jam pelajarannya? Sebutkan alasannya" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.6rem 0.85rem; font-size: 0.84375rem; outline: none; font-family: inherit; line-height: 1.5;"></textarea>
                    </div>

                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.35rem;">
                            Tipe Jawaban Responden *
                        </label>
                        <select name="field_type" x-model="selectedType" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.6rem 0.85rem; font-size: 0.84375rem; outline: none; font-weight: 700; cursor: pointer;">
                            <option value="radio">🔘 Pilihan Ganda (Satu Pilihan)</option>
                            <option value="checkbox">☑️ Kotak Centang (Bisa Pilih Banyak)</option>
                            <option value="select">🔽 Dropdown Pilihan</option>
                            <option value="text">✏️ Jawaban Singkat (Text Pendek)</option>
                            <option value="textarea">📝 Paragraf Panjang (Uraian)</option>
                            <option value="file">📎 Unggah Berkas / Dokumen / Foto</option>
                            <option value="date">📅 Tanggal (Date)</option>
                            <option value="number">🔢 Angka / Nilai (Number)</option>
                        </select>
                    </div>

                    <!-- OPSIONAL PILIHAN OPSI (UNTUK RADIO, SELECT, CHECKBOX) -->
                    <div x-show="['radio', 'checkbox', 'select'].includes(selectedType)" 
                         x-transition
                         style="background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 12px; padding: 0.85rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                            <label style="font-size: 0.75rem; font-weight: 800; color: #0F172A;">
                                Daftar Pilihan Jawaban (Tulis 1 pilihan per baris):
                            </label>
                            <span style="font-size: 0.6875rem; color: #64748B;">Enter = baris baru</span>
                        </div>
                        <textarea id="options_raw_input" name="options_raw" rows="4" placeholder="Perlu Ditambah Jam Pelajarannya&#10;Perlu Dikurangi Jam Pelajarannya&#10;Sudah Cukup & Sesuai" style="width: 100%; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.55rem 0.75rem; font-size: 0.8125rem; outline: none; font-family: inherit; line-height: 1.5;"></textarea>
                    </div>

                    <!-- FITUR KOTAK ALASAN / PENJELASAN TAMBAHAN (CONDITIONAL REASON BOX) -->
                    <div x-show="['radio', 'checkbox', 'select'].includes(selectedType)"
                         x-transition
                         style="background: #F0FDF4; border: 1.5px solid #86EFAC; border-radius: 12px; padding: 0.85rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; font-weight: 900; color: #166534; cursor: pointer;">
                            <input type="checkbox" name="has_reason" value="1" x-model="hasReason" style="width: 18px; height: 18px; accent-color: #16A34A; cursor: pointer;" />
                            <span>💬 Aktifkan Kotak Alasan / Penjelasan Tambahan</span>
                        </label>
                        <div style="font-size: 0.71875rem; color: #15803D; margin-top: 0.25rem; line-height: 1.4;">
                            Saat responden mengklik pilihan di atas, kotak isian teks untuk menuliskan alasan/pertimbangan akan otomatis muncul.
                        </div>

                        <div x-show="hasReason" style="margin-top: 0.65rem;">
                            <label style="font-size: 0.72rem; font-weight: 800; color: #166534; display: block; margin-bottom: 0.2rem;">
                                Label / Petunjuk Kotak Alasan:
                            </label>
                            <input type="text" id="reason_label_input" name="reason_label" x-model="reasonLabel" placeholder="Contoh: Sebutkan alasan atau mata kuliah yang Anda maksud:" style="width: 100%; background: #FFF; border: 1.5px solid #86EFAC; border-radius: 8px; padding: 0.45rem 0.65rem; font-size: 0.78125rem; outline: none;" />
                        </div>
                    </div>

                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.35rem;">
                            Teks Bantuan / Petunjuk Singkat (Opsional)
                        </label>
                        <input type="text" name="help_text" placeholder="Contoh: Boleh memilih lebih dari satu mata kuliah..." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.55rem 0.75rem; font-size: 0.8125rem; outline: none;" />
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #E2E8F0; padding-top: 0.85rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; font-weight: 800; color: #0F172A; cursor: pointer;">
                            <input type="checkbox" name="is_required" value="1" checked style="width: 18px; height: 18px; accent-color: #072718; cursor: pointer;" />
                            <span>Wajib Diisi (Required *)</span>
                        </label>

                        <button type="submit" style="background: linear-gradient(135deg, #072718 0%, #16A34A 100%); color: #FFF; font-weight: 900; font-size: 0.84375rem; padding: 0.65rem 1.35rem; border-radius: 10px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 15px rgba(7,39,24,0.25); transition: transform 0.2s ease;">
                            ➕ Tambahkan Pertanyaan
                        </button>
                    </div>
                </form>
            </div>

            <!-- CARD 2: FORM METADATA & SETTINGS -->
            <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 1.5rem; box-shadow: 0 6px 20px rgba(0,0,0,0.03);" x-data="{ isSettingsOpen: false }">
                <div style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;" @click="isSettingsOpen = !isSettingsOpen">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="background: #F1F5F9; color: #334155; font-size: 0.85rem; padding: 0.35rem 0.55rem; border-radius: 8px;">⚙️</span>
                        <div>
                            <h3 style="font-size: 0.95rem; font-weight: 900; color: #072718; margin: 0;">
                                Pengaturan & Identitas Formulir
                            </h3>
                            <div style="font-size: 0.72rem; color: #64748B;">Judul, tenggat waktu, dan status buka/tutup</div>
                        </div>
                    </div>
                    <button type="button" style="background: none; border: none; font-size: 1rem; cursor: pointer; color: #64748B;" x-text="isSettingsOpen ? '▲' : '▼'"></button>
                </div>

                <div x-show="isSettingsOpen" x-transition style="margin-top: 1.15rem; border-top: 1px solid #E2E8F0; padding-top: 1rem;">
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
                                <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Batas Waktu</label>
                                <input type="datetime-local" name="deadline_at" value="{{ $form->deadline_at ? $form->deadline_at->format('Y-m-d\TH:i') : '' }}" style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.5rem; font-size: 0.75rem; outline: none;" />
                            </div>
                        </div>

                        <div>
                            <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Pesan Sukses (Thank You Note)</label>
                            <input type="text" name="success_message" value="{{ $form->success_message }}" placeholder="Tanggapan Anda telah berhasil disimpan." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;" />
                        </div>

                        <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.8125rem; padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid #C59B27; cursor: pointer;">
                            💾 Simpan Perubahan Pengaturan
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN: QUESTION LIST & INTERACTIVE REORDERING (GOOGLE FORM PREVIEW) -->
        <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 1.75rem; box-shadow: 0 6px 20px rgba(0,0,0,0.03);">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; border-bottom: 1.5px solid #F1F5F9; padding-bottom: 1rem; flex-wrap: wrap; gap: 0.75rem;">
                <div>
                    <span style="font-size: 0.6875rem; color: #64748B; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em;">STRUKTUR KUESIONER</span>
                    <h2 style="font-size: 1.2rem; font-weight: 900; color: #072718; margin: 0.15rem 0 0;">
                        Daftar Pertanyaan Aktif ({{ $form->fields->count() }})
                    </h2>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 0.75rem; color: #16A34A; font-weight: 800; background: #DCFCE7; border: 1px solid #86EFAC; padding: 0.25rem 0.75rem; border-radius: 9999px;">
                        Interactive Form
                    </span>
                </div>
            </div>

            @if($form->fields->isEmpty())
                <div style="text-align: center; padding: 4rem 1.5rem; color: #94A3B8; border: 2px dashed #CBD5E1; border-radius: 16px; background: #F8FAFC;">
                    <div style="font-size: 3rem; margin-bottom: 0.75rem;">📝</div>
                    <div style="font-weight: 900; font-size: 1.05rem; color: #334155; margin-bottom: 0.35rem;">Belum Ada Pertanyaan di Formulir Ini</div>
                    <div style="font-size: 0.8125rem; max-width: 440px; margin: 0 auto 1.25rem; line-height: 1.5;">
                        Pilih template cepat di panel kiri atau isi formulir tambah pertanyaan untuk membuat butir soal kuesioner Anda.
                    </div>
                    <button type="button" @click="applyPreset('eval_reason')" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.8125rem; padding: 0.6rem 1.25rem; border-radius: 10px; border: 1px solid #C59B27; cursor: pointer;">
                        ✨ Isi Otomatis Contoh Pertanyaan + Alasan
                    </button>
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($form->fields as $index => $field)
                        <div style="background: #FAFAF9; border: 1.5px solid #E2E8F0; border-radius: 16px; padding: 1.25rem 1.35rem; transition: all 0.2s ease; position: relative;">
                            
                            <!-- TOP ROW: NUMBER, TYPE BADGE, REORDER & ACTION BUTTONS -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; flex-wrap: wrap; gap: 0.5rem;">
                                <div style="display: flex; align-items: center; gap: 0.45rem; flex-wrap: wrap;">
                                    <span style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.72rem; padding: 0.2rem 0.55rem; border-radius: 6px;">
                                        #{{ $index + 1 }}
                                    </span>
                                    <span style="font-size: 0.72rem; font-weight: 800; color: #0369A1; background: #E0F2FE; border: 1px solid #BAE6FD; padding: 0.2rem 0.55rem; border-radius: 6px;">
                                        @if($field->field_type === 'radio') 🔘 PILIHAN GANDA
                                        @elseif($field->field_type === 'checkbox') ☑️ KOTAK CENTANG
                                        @elseif($field->field_type === 'select') 🔽 DROPDOWN
                                        @elseif($field->field_type === 'text') ✏️ JAWABAN SINGKAT
                                        @elseif($field->field_type === 'textarea') 📝 PARAGRAF
                                        @elseif($field->field_type === 'file') 📎 BERKAS
                                        @elseif($field->field_type === 'date') 📅 TANGGAL
                                        @elseif($field->field_type === 'number') 🔢 ANGKA
                                        @else {{ strtoupper($field->field_type) }}
                                        @endif
                                    </span>

                                    @if($field->is_required)
                                        <span style="font-size: 0.6875rem; font-weight: 900; color: #991B1B; background: #FEE2E2; border: 1px solid #FECACA; padding: 0.18rem 0.5rem; border-radius: 6px;">
                                            WAJIB
                                        </span>
                                    @endif

                                    @if($field->has_reason)
                                        <span style="font-size: 0.6875rem; font-weight: 900; color: #166534; background: #DCFCE7; border: 1.5px solid #86EFAC; padding: 0.18rem 0.55rem; border-radius: 6px; display: inline-flex; align-items: center; gap: 0.25rem;">
                                            💬 FITUR ALASAN AKTIF
                                        </span>
                                    @endif
                                </div>

                                <!-- ACTION TOOLBAR (REORDER, EDIT, DUPLICATE, DELETE) -->
                                <div style="display: flex; align-items: center; gap: 0.35rem;">
                                    <!-- MOVE UP -->
                                    <form action="{{ route('dashboard.forms.fields.move', [$field->id, 'up']) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" {{ $index === 0 ? 'disabled' : '' }} style="background: #FFF; border: 1px solid #CBD5E1; color: #475569; width: 28px; height: 28px; border-radius: 6px; cursor: {{ $index === 0 ? 'not-allowed' : 'pointer' }}; opacity: {{ $index === 0 ? '0.4' : '1' }}; font-size: 0.72rem; display: flex; align-items: center; justify-content: center;" title="Pindahkan ke Atas">
                                            ▲
                                        </button>
                                    </form>

                                    <!-- MOVE DOWN -->
                                    <form action="{{ route('dashboard.forms.fields.move', [$field->id, 'down']) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" {{ $loop->last ? 'disabled' : '' }} style="background: #FFF; border: 1px solid #CBD5E1; color: #475569; width: 28px; height: 28px; border-radius: 6px; cursor: {{ $loop->last ? 'not-allowed' : 'pointer' }}; opacity: {{ $loop->last ? '0.4' : '1' }}; font-size: 0.72rem; display: flex; align-items: center; justify-content: center;" title="Pindahkan ke Bawah">
                                            ▼
                                        </button>
                                    </form>

                                    <!-- EDIT MODAL TRIGGER -->
                                    <button type="button" @click="openEditModal({{ json_encode($field) }})" style="background: #FFF; border: 1.5px solid #0284C7; color: #0284C7; font-weight: 800; font-size: 0.72rem; padding: 0.25rem 0.6rem; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem;">
                                        ✏️ Edit
                                    </button>

                                    <!-- DUPLICATE -->
                                    <form action="{{ route('dashboard.forms.fields.duplicate', $field->id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" style="background: #FFF; border: 1px solid #CBD5E1; color: #334155; font-size: 0.72rem; padding: 0.25rem 0.55rem; border-radius: 6px; cursor: pointer;" title="Duplikat Pertanyaan">
                                            📋 Salin
                                        </button>
                                    </form>

                                    <!-- DELETE -->
                                    <form action="{{ route('dashboard.forms.fields.destroy', $field->id) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?')" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 6px; cursor: pointer;" title="Hapus Pertanyaan">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- QUESTION LABEL -->
                            <div style="font-size: 0.96875rem; font-weight: 900; color: #0F172A; line-height: 1.4; margin-bottom: 0.4rem;">
                                {{ $field->field_label }}
                            </div>

                            @if($field->help_text)
                                <div style="font-size: 0.78125rem; color: #64748B; margin-bottom: 0.5rem; line-height: 1.4;">
                                    💡 {{ $field->help_text }}
                                </div>
                            @endif

                            <!-- OPTIONS PREVIEW -->
                            @if(!empty($field->options))
                                <div style="margin-top: 0.65rem; background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; padding: 0.75rem;">
                                    <div style="font-size: 0.6875rem; font-weight: 800; color: #64748B; text-transform: uppercase; margin-bottom: 0.4rem;">
                                        Opsi Pilihan ({{ count($field->options) }}):
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                                        @foreach($field->options as $optIndex => $opt)
                                            @php
                                                $cleanOpt = ltrim(trim($opt), "• -*\t ");
                                            @endphp
                                            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; color: #334155;">
                                                <span style="font-size: 0.7rem; color: #64748B; width: 18px; text-align: right; font-weight: 700;">{{ $optIndex + 1 }}.</span>
                                                <span style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 600;">
                                                    {{ $cleanOpt }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- REASON PREVIEW CALLOUT -->
                            @if($field->has_reason)
                                <div style="margin-top: 0.65rem; background: #F0FDF4; border: 1px dashed #86EFAC; border-radius: 10px; padding: 0.6rem 0.85rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.78125rem; color: #166534;">
                                    <span>💬</span>
                                    <span><strong>Kotak Alasan Tambahan:</strong> "{{ $field->reason_label ?? 'Sebutkan alasan atau penjelasan pilihan Anda...' }}"</span>
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>
            @endif

        </div>

    </main>

    <!-- MODAL EDIT PERTANYAAN -->
    <div x-show="isEditModalOpen" 
         x-cloak
         style="position: fixed; inset: 0; z-index: 99999; background: rgba(15,23,42,0.7); backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center; padding: 1.25rem;"
         @keydown.escape.window="isEditModalOpen = false">
        
        <div class="modal-card" 
             style="background: #FFF; width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; border-radius: 20px; border: 2px solid #072718; box-shadow: 0 25px 60px rgba(0,0,0,0.3); padding: 1.5rem;"
             @click.stop>
            
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1.5px solid #F1F5F9; padding-bottom: 0.85rem; margin-bottom: 1.15rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="background: #072718; color: #D4AF37; font-size: 0.9rem; padding: 0.3rem 0.5rem; border-radius: 8px;">✏️</span>
                    <h3 style="font-size: 1.1rem; font-weight: 900; color: #072718; margin: 0;">
                        Edit Pertanyaan Kuesioner
                    </h3>
                </div>
                <button type="button" @click="isEditModalOpen = false" style="background: #F1F5F9; border: none; width: 32px; height: 32px; border-radius: 8px; font-size: 1rem; cursor: pointer; color: #64748B;">✕</button>
            </div>

            <template x-if="editingField">
                <form :action="'/dashboard/forms/fields/' + editingField.id + '/update'" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
                    @csrf
                    @method('PUT')

                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.35rem;">
                            Teks Pertanyaan / Label *
                        </label>
                        <textarea name="field_label" rows="3" x-model="editingField.field_label" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.6rem 0.85rem; font-size: 0.875rem; outline: none; font-family: inherit; line-height: 1.5;"></textarea>
                    </div>

                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.35rem;">
                            Tipe Jawaban *
                        </label>
                        <select name="field_type" x-model="editingField.field_type" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.6rem 0.85rem; font-size: 0.84375rem; outline: none; font-weight: 700; cursor: pointer;">
                            <option value="radio">🔘 Pilihan Ganda (Radio Button)</option>
                            <option value="checkbox">☑️ Kotak Centang (Checkbox Multi-pilih)</option>
                            <option value="select">🔽 Dropdown Pilihan</option>
                            <option value="text">✏️ Jawaban Singkat (Text)</option>
                            <option value="textarea">📝 Paragraf Panjang (Textarea)</option>
                            <option value="file">📎 Upload Berkas / File</option>
                            <option value="date">📅 Tanggal (Date)</option>
                            <option value="number">🔢 Angka (Number)</option>
                        </select>
                    </div>

                    <!-- OPSIONAL PILIHAN OPSI DI MODAL EDIT -->
                    <div x-show="['radio', 'checkbox', 'select'].includes(editingField.field_type)" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 12px; padding: 0.85rem;">
                        <label style="font-size: 0.75rem; font-weight: 800; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                            Daftar Pilihan Jawaban (Tulis 1 pilihan per baris):
                        </label>
                        <textarea name="options_raw" rows="5" :value="editingField.options ? editingField.options.join('\n') : ''" placeholder="Opsi 1&#10;Opsi 2&#10;Opsi 3" style="width: 100%; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.55rem 0.75rem; font-size: 0.8125rem; outline: none; font-family: inherit; line-height: 1.5;"></textarea>
                    </div>

                    <!-- FITUR KOTAK ALASAN DI MODAL EDIT -->
                    <div x-show="['radio', 'checkbox', 'select'].includes(editingField.field_type)" style="background: #F0FDF4; border: 1.5px solid #86EFAC; border-radius: 12px; padding: 0.85rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; font-weight: 900; color: #166534; cursor: pointer;">
                            <input type="checkbox" name="has_reason" value="1" x-model="editingField.has_reason" style="width: 18px; height: 18px; accent-color: #16A34A; cursor: pointer;" />
                            <span>💬 Aktifkan Kotak Alasan / Penjelasan Tambahan</span>
                        </label>
                        <div x-show="editingField.has_reason" style="margin-top: 0.65rem;">
                            <label style="font-size: 0.72rem; font-weight: 800; color: #166534; display: block; margin-bottom: 0.2rem;">
                                Label / Petunjuk Kotak Alasan:
                            </label>
                            <input type="text" name="reason_label" x-model="editingField.reason_label" placeholder="Contoh: Sebutkan alasan atau penjelasan pilihan Anda:" style="width: 100%; background: #FFF; border: 1.5px solid #86EFAC; border-radius: 8px; padding: 0.45rem 0.65rem; font-size: 0.78125rem; outline: none;" />
                        </div>
                    </div>

                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.35rem;">
                            Teks Bantuan / Petunjuk Singkat
                        </label>
                        <input type="text" name="help_text" x-model="editingField.help_text" style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.55rem 0.75rem; font-size: 0.8125rem; outline: none;" />
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #E2E8F0; padding-top: 1rem; margin-top: 0.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; font-weight: 800; color: #0F172A; cursor: pointer;">
                            <input type="checkbox" name="is_required" value="1" x-model="editingField.is_required" style="width: 18px; height: 18px; accent-color: #072718; cursor: pointer;" />
                            <span>Wajib Diisi (Required *)</span>
                        </label>

                        <div style="display: flex; gap: 0.5rem;">
                            <button type="button" @click="isEditModalOpen = false" style="background: #F1F5F9; border: 1.5px solid #CBD5E1; color: #475569; font-weight: 800; font-size: 0.8125rem; padding: 0.6rem 1.15rem; border-radius: 8px; cursor: pointer;">
                                Batal
                            </button>
                            <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.8125rem; padding: 0.6rem 1.35rem; border-radius: 8px; border: 1.5px solid #C59B27; cursor: pointer;">
                                💾 Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </template>
        </div>
    </div>

</div>
@endsection
