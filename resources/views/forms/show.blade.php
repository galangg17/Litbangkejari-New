@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; background: #F1F5F9; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif; padding-bottom: 5rem;">

    <!-- TOP HEADER -->
    <header style="background: linear-gradient(135deg, #072718 0%, #14452F 100%); border-bottom: 3px solid #D4AF37; padding: 1.25rem 1rem; color: #FFF; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
        <div style="max-width: 760px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
            <div style="display: flex; align-items: center; gap: 0.85rem;">
                <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo" style="height: 42px; width: auto;" />
                <div>
                    <div style="font-size: 0.6875rem; color: #D4AF37; font-weight: 900; letter-spacing: 0.08em; text-transform: uppercase;">KEJAKSAAN REPUBLIK INDONESIA</div>
                    <div style="font-size: 0.9375rem; font-weight: 900; color: #FFF;">Litbang Gajah Mada Adhyaksa</div>
                </div>
            </div>
            <a href="{{ route('forms.index') }}" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: #FFF; font-size: 0.75rem; font-weight: 800; padding: 0.4rem 0.85rem; border-radius: 9999px; text-decoration: none;">
                ← Daftar Formulir Lain
            </a>
        </div>
    </header>

    <!-- FORM CARD CONTAINER (GOOGLE FORM STYLE) -->
    <main style="max-width: 760px; margin: 1.75rem auto 0; padding: 0 1rem;">

        <!-- FORM TITLE HERO CARD -->
        <div style="background: #FFFFFF; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.04); margin-bottom: 1.25rem; border: 1px solid #E2E8F0; position: relative;">
            <!-- Top Color Bar -->
            <div style="height: 10px; background: linear-gradient(90deg, #072718 0%, #D4AF37 50%, #16A34A 100%);"></div>

            <div style="padding: 2rem 2rem 1.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; flex-wrap: wrap; margin-bottom: 0.5rem;">
                    <h1 style="font-size: clamp(1.4rem, 2.5vw, 1.85rem); font-weight: 900; color: #072718; line-height: 1.25; margin: 0; flex: 1;">
                        {{ $form->title }}
                    </h1>
                    @if($form->isOpen())
                        <span style="background: #DCFCE7; color: #15803D; font-size: 0.72rem; font-weight: 900; padding: 0.3rem 0.75rem; border-radius: 9999px; border: 1px solid #86EFAC;">
                            🟢 AKTIF / TERBUKA
                        </span>
                    @else
                        <span style="background: #FEE2E2; color: #991B1B; font-size: 0.72rem; font-weight: 900; padding: 0.3rem 0.75rem; border-radius: 9999px; border: 1px solid #FCA5A5;">
                            🔴 DITUTUP
                        </span>
                    @endif
                </div>

                @if($form->description)
                    <p style="font-size: 0.90625rem; color: #475569; line-height: 1.65; margin: 0 0 1rem; white-space: pre-line;">
                        {{ $form->description }}
                    </p>
                @endif

                <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #F1F5F9; padding-top: 1rem; font-size: 0.78125rem; color: #64748B; flex-wrap: wrap; gap: 0.5rem;">
                    <span>Tanda (<strong style="color: #DC2626;">*</strong>) Menunjukkan pertanyaan yang wajib diisi</span>
                    @if($form->deadline_at)
                        <span style="color: #B45309; font-weight: 700;">⏳ Batas Waktu: {{ $form->deadline_at->format('d M Y, H:i') }} WIB</span>
                    @endif
                </div>
            </div>
        </div>

        @if(!$form->isOpen())
            <div style="background: #FFF; border-radius: 18px; padding: 3rem 2rem; text-align: center; border: 1px solid #E2E8F0; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                <div style="font-size: 3rem; margin-bottom: 0.5rem;">🔒</div>
                <h3 style="font-size: 1.25rem; font-weight: 900; color: #991B1B; margin: 0 0 0.5rem;">Formulir Ini Telah Ditutup</h3>
                <p style="font-size: 0.875rem; color: #64748B; margin: 0 0 1.5rem;">Pengelola telah menutup penerimaan tanggapan untuk kuesioner/kegiatan ini.</p>
                <a href="{{ route('forms.index') }}" style="background: #072718; color: #FFF; font-weight: 900; padding: 0.65rem 1.25rem; border-radius: 10px; text-decoration: none; font-size: 0.8125rem;">
                    Lihat Formulir Lainnya →
                </a>
            </div>
        @else
            <!-- ERROR ALERTS -->
            @if ($errors->any())
                <div style="background: #FEF2F2; border: 1.5px solid #EF4444; color: #991B1B; border-radius: 16px; padding: 1.15rem 1.5rem; margin-bottom: 1.25rem; font-size: 0.84375rem; box-shadow: 0 4px 12px rgba(239,68,68,0.1);">
                    <div style="font-weight: 900; margin-bottom: 0.4rem; display: flex; align-items: center; gap: 0.4rem;">
                        <span>⚠️</span> Mohon periksa kembali isian formulir Anda:
                    </div>
                    <ul style="margin: 0; padding-left: 1.25rem;">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- GOOGLE FORM INPUT FORM -->
            <form action="{{ route('forms.submit', $form->slug) }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1rem;">
                @csrf

                @foreach($form->fields as $field)
                    <div style="background: #FFFFFF; border-radius: 18px; padding: 1.5rem 1.75rem; border: 1.5px solid #E2E8F0; box-shadow: 0 2px 8px rgba(0,0,0,0.02); transition: border-color 0.2s;" onfocusin="this.style.borderColor='#10B981'" onfocusout="this.style.borderColor='#E2E8F0'">
                        
                        <!-- Question Label -->
                        <label style="display: block; font-size: 0.9375rem; font-weight: 900; color: #0F172A; margin-bottom: 0.35rem; line-height: 1.35;">
                            {{ $field->field_label }}
                            @if($field->is_required)
                                <span style="color: #DC2626; font-size: 1rem;" title="Wajib diisi">*</span>
                            @endif
                        </label>

                        @if($field->help_text)
                            <div style="font-size: 0.78125rem; color: #64748B; margin-bottom: 0.85rem; line-height: 1.5;">
                                {{ $field->help_text }}
                            </div>
                        @else
                            <div style="margin-bottom: 0.65rem;"></div>
                        @endif

                        <!-- INPUT TYPE SWITCHER -->
                        @if($field->field_type === 'text')
                            <input type="text" 
                                   name="fields[{{ $field->field_name }}]" 
                                   value="{{ old('fields.' . $field->field_name) }}" 
                                   placeholder="Jawaban teks Anda..." 
                                   {{ $field->is_required ? 'required' : '' }}
                                   style="width: 100%; border: none; border-bottom: 2px solid #CBD5E1; padding: 0.5rem 0.25rem; font-size: 0.90625rem; outline: none; background: transparent; transition: border-color 0.2s; color: #0F172A;" 
                                   onfocus="this.style.borderBottomColor='#047857'" 
                                   onblur="this.style.borderBottomColor='#CBD5E1'" />

                        @elseif($field->field_type === 'number')
                            <input type="number" 
                                   name="fields[{{ $field->field_name }}]" 
                                   value="{{ old('fields.' . $field->field_name) }}" 
                                   placeholder="0" 
                                   {{ $field->is_required ? 'required' : '' }}
                                   style="width: 100%; max-width: 250px; border: none; border-bottom: 2px solid #CBD5E1; padding: 0.5rem 0.25rem; font-size: 0.90625rem; outline: none; background: transparent; transition: border-color 0.2s; color: #0F172A;" 
                                   onfocus="this.style.borderBottomColor='#047857'" 
                                   onblur="this.style.borderBottomColor='#CBD5E1'" />

                        @elseif($field->field_type === 'date')
                            <input type="date" 
                                   name="fields[{{ $field->field_name }}]" 
                                   value="{{ old('fields.' . $field->field_name) }}" 
                                   {{ $field->is_required ? 'required' : '' }}
                                   style="width: 100%; max-width: 260px; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.6rem 0.85rem; font-size: 0.875rem; outline: none; color: #0F172A;" />

                        @elseif($field->field_type === 'textarea')
                            <textarea name="fields[{{ $field->field_name }}]" 
                                      rows="3" 
                                      placeholder="Tuliskan jawaban lengkap Anda di sini..." 
                                      {{ $field->is_required ? 'required' : '' }}
                                      style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 12px; padding: 0.75rem 1rem; font-size: 0.875rem; outline: none; color: #0F172A; line-height: 1.55;"></textarea>

                        @elseif($field->field_type === 'select')
                            <select name="fields[{{ $field->field_name }}]" 
                                    {{ $field->is_required ? 'required' : '' }}
                                    style="width: 100%; max-width: 400px; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.65rem 0.85rem; font-size: 0.875rem; outline: none; color: #0F172A;">
                                <option value="">-- Pilih salah satu opsi --</option>
                                @if(!empty($field->options))
                                    @foreach($field->options as $opt)
                                        <option value="{{ $opt }}" {{ old('fields.' . $field->field_name) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                    @endforeach
                                @endif
                            </select>

                        @elseif($field->field_type === 'radio')
                            <div style="display: flex; flex-direction: column; gap: 0.65rem;">
                                @if(!empty($field->options))
                                    @foreach($field->options as $opt)
                                        <label style="display: flex; align-items: center; gap: 0.65rem; font-size: 0.875rem; color: #1E293B; cursor: pointer; padding: 0.25rem 0;">
                                            <input type="radio" 
                                                   name="fields[{{ $field->field_name }}]" 
                                                   value="{{ $opt }}" 
                                                   {{ old('fields.' . $field->field_name) == $opt ? 'checked' : '' }}
                                                   {{ $field->is_required ? 'required' : '' }}
                                                   style="width: 18px; height: 18px; accent-color: #047857;" />
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>

                        @elseif($field->field_type === 'checkbox')
                            <div style="display: flex; flex-direction: column; gap: 0.65rem;">
                                @if(!empty($field->options))
                                    @foreach($field->options as $opt)
                                        <label style="display: flex; align-items: center; gap: 0.65rem; font-size: 0.875rem; color: #1E293B; cursor: pointer; padding: 0.25rem 0;">
                                            <input type="checkbox" 
                                                   name="fields[{{ $field->field_name }}][]" 
                                                   value="{{ $opt }}" 
                                                   style="width: 18px; height: 18px; accent-color: #047857;" />
                                            <span>{{ $opt }}</span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>

                        @elseif($field->field_type === 'file')
                            <div style="background: #F8FAFC; border: 2px dashed #CBD5E1; border-radius: 12px; padding: 1.25rem; text-align: center;">
                                <div style="font-size: 1.8rem; margin-bottom: 0.35rem;">📎</div>
                                <div style="font-size: 0.8125rem; font-weight: 700; color: #475569; margin-bottom: 0.5rem;">
                                    Unggah Berkas Lampiran (PDF, DOCX, Foto, Excel, dll - Maks 15MB)
                                </div>
                                <input type="file" 
                                       name="file_{{ $field->field_name }}" 
                                       {{ $field->is_required ? 'required' : '' }}
                                       style="font-size: 0.8125rem; color: #0F172A;" />
                            </div>
                        @endif

                    </div>
                @endforeach

                <!-- SUBMIT ACTIONS -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; flex-wrap: wrap; gap: 1rem;">
                    <button type="submit" style="background: linear-gradient(135deg, #072718 0%, #16A34A 100%); color: #FFF; font-weight: 900; font-size: 0.95rem; padding: 0.85rem 2.25rem; border-radius: 14px; border: none; cursor: pointer; box-shadow: 0 6px 20px rgba(7,39,24,0.3); display: inline-flex; align-items: center; gap: 0.5rem;">
                        <span>Kirim Tanggapan</span>
                        <span>➔</span>
                    </button>

                    <button type="reset" style="background: transparent; border: none; color: #64748B; font-weight: 700; font-size: 0.8125rem; cursor: pointer;">
                        Kosongkan Formulir
                    </button>
                </div>

                <div style="text-align: center; margin-top: 1.5rem; font-size: 0.75rem; color: #94A3B8;">
                    Formulir Resmi Sistem Litbang Gajah Mada Adhyaksa • Kejaksaan Republik Indonesia
                </div>
            </form>
        @endif

    </main>
</div>
@endsection
