@extends('layouts.app')

@section('content')
<style>
    /* CUSTOM MODERN FORM STYLING */
    .form-hero-wrapper {
        position: relative;
        background: linear-gradient(135deg, rgba(7, 39, 24, 0.95) 0%, rgba(20, 69, 47, 0.92) 100%), url('{{ asset("gedung-kejaksaan.jpg") }}?v=3');
        background-size: cover;
        background-position: center;
        border-radius: 28px;
        color: #FFFFFF;
        padding: 2.5rem 2.25rem 2.25rem;
        box-shadow: 0 20px 50px rgba(7, 39, 24, 0.35);
        border: 2px solid rgba(212, 175, 55, 0.5);
        overflow: hidden;
        backdrop-filter: blur(12px);
    }
    .form-hero-wrapper::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.25) 0%, rgba(0,0,0,0) 70%);
        pointer-events: none;
    }
    .question-card {
        background: #FFFFFF;
        border-radius: 22px;
        padding: 1.75rem 2rem;
        border: 1.5px solid #E2E8F0;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.03);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }
    .question-card:hover, .question-card:focus-within {
        border-color: #10B981;
        box-shadow: 0 12px 30px rgba(16, 185, 129, 0.12);
        transform: translateY(-2px);
    }
    .question-badge {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #ECFDF5;
        border: 1.5px solid #86EFAC;
        color: #047857;
        font-weight: 900;
        font-size: 0.8125rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .custom-input {
        width: 100%;
        background: #F8FAFC;
        border: 1.5px solid #CBD5E1;
        border-radius: 12px;
        padding: 0.8rem 1rem;
        font-size: 0.90625rem;
        color: #0F172A;
        font-family: inherit;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .custom-input:focus {
        background: #FFFFFF;
        border-color: #047857;
        box-shadow: 0 0 0 4px rgba(4, 120, 87, 0.12);
    }
    .radio-card-option {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.85rem 1.15rem;
        border-radius: 14px;
        border: 1.5px solid #E2E8F0;
        background: #F8FAFC;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }
    .radio-card-option:hover {
        background: #F0FDF4;
        border-color: #86EFAC;
    }
    .radio-card-option.active-card-opt {
        background: #ECFDF5;
        border-color: #10B981;
    }
    .radio-card-option input[type="radio"]:checked + span,
    .radio-card-option input[type="checkbox"]:checked + span {
        font-weight: 900;
        color: #047857;
    }
    .file-dropzone {
        background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
        border: 2px dashed #94A3B8;
        border-radius: 16px;
        padding: 1.75rem 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .file-dropzone:hover {
        background: #ECFDF5;
        border-color: #10B981;
    }

    /* 2-COLUMN RESPONSIVE LAYOUT */
    .form-workspace-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.75rem;
    }
    @media (min-width: 992px) {
        .form-workspace-grid {
            grid-template-columns: 390px 1fr;
            align-items: start;
            gap: 2.25rem;
        }
        .form-sticky-panel {
            position: sticky;
            top: 85px;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
    }
</style>

<div style="min-height: 100vh; background: #F8FAFC; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif; padding-bottom: 5rem;">

    <!-- TOP BAR -->
    <header style="background: rgba(7, 39, 24, 0.98); border-bottom: 2px solid #D4AF37; padding: 1rem 1.5rem; color: #FFF; position: sticky; top: 0; z-index: 50; backdrop-filter: blur(12px); box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
        <div style="max-width: 1240px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
            <div style="display: flex; align-items: center; gap: 0.85rem;">
                <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo" style="height: 42px; width: auto; filter: drop-shadow(0 2px 6px rgba(0,0,0,0.4));" />
                <div>
                    <div style="font-size: 0.65rem; color: #D4AF37; font-weight: 900; letter-spacing: 0.08em; text-transform: uppercase;">KEJAKSAAN REPUBLIK INDONESIA</div>
                    <div style="font-size: 0.90625rem; font-weight: 900; color: #FFF; line-height: 1.15;">Litbang Gajah Mada Adhyaksa</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <a href="{{ route('forms.index') }}" style="background: rgba(255,255,255,0.12); border: 1.5px solid rgba(212,175,55,0.4); color: #FFF; font-size: 0.75rem; font-weight: 800; padding: 0.45rem 1rem; border-radius: 9999px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; transition: background 0.2s;">
                    ← Semua Formulir
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN FORM BODY -->
    <main style="max-width: 1240px; margin: 2rem auto 0; padding: 0 1.25rem;">

        @if(!$form->isOpen())
            <!-- CLOSED NOTICE -->
            <div style="background: #FFFFFF; border-radius: 22px; padding: 4rem 2rem; text-align: center; border: 1.5px solid #E2E8F0; box-shadow: 0 8px 30px rgba(0,0,0,0.04); max-width: 680px; margin: 2rem auto;">
                <div style="font-size: 3.5rem; margin-bottom: 0.75rem;">🔒</div>
                <h3 style="font-size: 1.35rem; font-weight: 900; color: #991B1B; margin: 0 0 0.5rem;">Penerimaan Tanggapan Telah Ditutup</h3>
                <p style="font-size: 0.90625rem; color: #64748B; margin: 0 0 1.75rem; max-width: 500px; margin-left: auto; margin-right: auto; line-height: 1.6;">
                    Mohon maaf, pengelola sistem telah menutup sesi pengisian untuk formulir atau survei kegiatan ini.
                </p>
                <a href="{{ route('forms.index') }}" style="background: #072718; color: #D4AF37; font-weight: 900; padding: 0.75rem 1.5rem; border-radius: 12px; text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 15px rgba(7,39,24,0.2);">
                    Lihat Formulir Lain yang Tersedia →
                </a>
            </div>
        @else

            <!-- 2-COLUMN WORKSPACE: LEFT STICKY HERO & INFO | RIGHT FORM QUESTIONS -->
            <div class="form-workspace-grid">
                
                <!-- SISI KIRI: STICKY HERO & PETUNJUK RESMI FORMULIR -->
                <aside class="form-sticky-panel">
                    
                    <!-- HERO CARD -->
                    <div class="form-hero-wrapper">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 0.85rem;">
                            <div style="display: inline-flex; align-items: center; gap: 0.35rem; background: rgba(212, 175, 55, 0.2); border: 1.5px solid #D4AF37; padding: 0.3rem 0.75rem; border-radius: 9999px; font-size: 0.6875rem; font-weight: 900; color: #D4AF37; letter-spacing: 0.05em; text-transform: uppercase;">
                                <span>🏛️ INSTRUMEN RESMI</span>
                            </div>

                            <span style="background: rgba(16, 185, 129, 0.25); color: #86EFAC; border: 1px solid #10B981; font-size: 0.72rem; font-weight: 900; padding: 0.25rem 0.65rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.35rem;">
                                🟢 PENERIMAAN AKTIF
                            </span>
                        </div>

                        <h1 style="font-size: 1.35rem; font-weight: 900; color: #FFFFFF; line-height: 1.3; margin: 0 0 0.85rem; letter-spacing: -0.01em;">
                            {{ $form->title }}
                        </h1>

                        @if($form->description)
                            <div style="font-size: 0.84375rem; color: #E2E8F0; line-height: 1.6; margin: 0 0 1.15rem; white-space: pre-line;">
                                {{ $form->description }}
                            </div>
                        @endif

                        <div style="border-top: 1px solid rgba(255,255,255,0.18); padding-top: 0.85rem; font-size: 0.75rem; color: #CBD5E1; display: flex; flex-direction: column; gap: 0.45rem;">
                            <div style="display: flex; align-items: center; gap: 0.4rem;">
                                <span style="color: #F87171; font-size: 1rem; line-height: 1;">*</span>
                                <span>Tanda bintang merah menunjukkan butir wajib diisi.</span>
                            </div>
                            @if($form->deadline_at)
                                <div style="color: #FDE68A; font-weight: 800;">
                                    ⏳ Batas Waktu: {{ $form->deadline_at->format('d M Y, H:i') }} WIB
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- SUMMARY & TRUST BADGE CARD -->
                    <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 18px; padding: 1.25rem 1.4rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                        <div style="font-size: 0.7rem; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
                            RINGKASAN KUESIONER
                        </div>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #F1F5F9;">
                            <span style="font-size: 0.84375rem; font-weight: 700; color: #334155;">Jumlah Pertanyaan</span>
                            <span style="font-size: 0.90625rem; font-weight: 900; color: #072718; background: #F1F5F9; padding: 0.2rem 0.6rem; border-radius: 6px;">{{ $form->fields->count() }} Butir</span>
                        </div>
                        <div style="font-size: 0.78125rem; color: #64748B; line-height: 1.5;">
                            🔒 Seluruh tanggapan Anda dihimpun secara aman ke sistem basis data Diklat PPPJ Kejaksaan RI.
                        </div>
                    </div>

                </aside>

                <!-- SISI KANAN: STREAM BUTIR PERTANYAAN -->
                <div class="form-questions-stream">
                    <!-- VALIDATION ERRORS -->
                    @if ($errors->any())
                        <div style="background: #FEF2F2; border: 2px solid #EF4444; color: #991B1B; border-radius: 18px; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; font-size: 0.875rem; box-shadow: 0 8px 24px rgba(239,68,68,0.12);">
                            <div style="font-weight: 900; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.9375rem;">
                                <span>⚠️</span> Mohon lengkapi isian formulir yang belum sesuai:
                            </div>
                            <ul style="margin: 0; padding-left: 1.25rem; line-height: 1.6;">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

            <!-- MAIN SUBMISSION FORM -->
            <form action="{{ route('forms.submit', $form->slug) }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.15rem;">
                @csrf

                @foreach($form->fields as $index => $field)
                    <div class="question-card">
                        
                        <!-- Header Question with Counter Badge -->
                        <div style="display: flex; align-items: flex-start; gap: 0.85rem; margin-bottom: 0.85rem;">
                            <div class="question-badge">{{ $index + 1 }}</div>
                            <div style="flex: 1;">
                                @if(!empty($field->category))
                                    <div style="font-size: 0.72rem; font-weight: 800; color: #166534; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.3rem; display: inline-flex; align-items: center; gap: 0.3rem; background: #F0FDF4; border: 1px solid #BBF7D0; padding: 0.15rem 0.6rem; border-radius: 6px;">
                                        <span>📁</span>
                                        <span>{{ $field->category }}</span>
                                    </div>
                                @endif

                                <label style="display: block; font-size: 1.05rem; font-weight: 900; color: #072718; line-height: 1.35;">
                                    {{ $field->field_label }}
                                    @if($field->is_required)
                                        <span style="color: #DC2626; font-size: 1.1rem; line-height: 1;" title="Wajib Diisi">*</span>
                                    @endif
                                </label>

                                @if($field->help_text)
                                    <div style="font-size: 0.84375rem; color: #475569; margin-top: 0.35rem; line-height: 1.5; font-weight: 500;">
                                        {{ $field->help_text }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- INPUT CONTROLS -->
                        <div style="padding-left: 0;">
                            @if($field->field_type === 'text')
                                <input type="text" 
                                       name="fields[{{ $field->field_name }}]" 
                                       value="{{ old('fields.' . $field->field_name) }}" 
                                       placeholder="Ketik jawaban Anda di sini..." 
                                       {{ $field->is_required ? 'required' : '' }}
                                       class="custom-input" />

                            @elseif($field->field_type === 'number')
                                <input type="number" 
                                       name="fields[{{ $field->field_name }}]" 
                                       value="{{ old('fields.' . $field->field_name) }}" 
                                       placeholder="0" 
                                       {{ $field->is_required ? 'required' : '' }}
                                       class="custom-input" style="max-width: 260px;" />

                            @elseif($field->field_type === 'date')
                                <input type="date" 
                                       name="fields[{{ $field->field_name }}]" 
                                       value="{{ old('fields.' . $field->field_name) }}" 
                                       {{ $field->is_required ? 'required' : '' }}
                                       class="custom-input" style="max-width: 280px;" />

                            @elseif($field->field_type === 'textarea')
                                <textarea name="fields[{{ $field->field_name }}]" 
                                          rows="3" 
                                          placeholder="Tuliskan jawaban atau penjelasan Anda secara lengkap..." 
                                          {{ $field->is_required ? 'required' : '' }}
                                          class="custom-input" style="resize: vertical; line-height: 1.6;">{{ old('fields.' . $field->field_name) }}</textarea>

                            @elseif($field->field_type === 'select')
                                <div x-data="{ selectedVal: '{{ old('fields.' . $field->field_name) }}' }">
                                    <select name="fields[{{ $field->field_name }}]" 
                                            x-model="selectedVal"
                                            {{ $field->is_required ? 'required' : '' }}
                                            class="custom-input" style="max-width: 480px; cursor: pointer;">
                                        <option value="">-- Silakan Pilih Opsi --</option>
                                        @if(!empty($field->options))
                                            @foreach($field->options as $opt)
                                                @php $cleanOpt = ltrim(trim($opt), "• -*\t "); @endphp
                                                <option value="{{ $cleanOpt }}" {{ old('fields.' . $field->field_name) == $cleanOpt ? 'selected' : '' }}>{{ $cleanOpt }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                    @if($field->has_reason)
                                        <div x-show="selectedVal" 
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 -translate-y-2"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             style="display: none; margin-top: 0.85rem; max-width: 580px; background: #F0FDF4; border: 1.5px solid #86EFAC; border-radius: 12px; padding: 0.95rem; box-shadow: 0 4px 12px rgba(16,185,129,0.1);">
                                            <label style="display: block; font-size: 0.8125rem; font-weight: 800; color: #166534; margin-bottom: 0.35rem;">
                                                💬 {{ $field->reason_label ?? 'Sebutkan alasan atau penjelasan pilihan Anda:' }}
                                            </label>
                                            <textarea name="reasons[{{ $field->field_name }}]" 
                                                      rows="2" 
                                                      placeholder="Ketikkan alasan Anda di sini..."
                                                      style="width: 100%; border: 1.5px solid #86EFAC; border-radius: 8px; padding: 0.6rem 0.75rem; font-size: 0.84375rem; background: #FFF; outline: none; line-height: 1.5; font-family: inherit;">{{ old('reasons.' . $field->field_name) }}</textarea>
                                        </div>
                                    @endif
                                </div>

                            @elseif($field->field_type === 'radio')
                                <div style="display: flex; flex-direction: column; gap: 0.65rem;" 
                                     x-data="{ selectedVal: '{{ old('fields.' . $field->field_name) }}' }">
                                    @if(!empty($field->options))
                                        @foreach($field->options as $opt)
                                            @php $cleanOpt = ltrim(trim($opt), "• -*\t "); @endphp
                                            <label class="radio-card-option" 
                                                   :class="{ 'active-card-opt': selectedVal === '{{ addslashes($cleanOpt) }}' }"
                                                   @click="selectedVal = '{{ addslashes($cleanOpt) }}'">
                                                <input type="radio" 
                                                       name="fields[{{ $field->field_name }}]" 
                                                       value="{{ $cleanOpt }}" 
                                                       x-model="selectedVal"
                                                       {{ old('fields.' . $field->field_name) == $cleanOpt ? 'checked' : '' }}
                                                       {{ $field->is_required ? 'required' : '' }}
                                                       style="width: 20px; height: 20px; accent-color: #047857; cursor: pointer;" />
                                                <span style="font-size: 0.90625rem; font-weight: 700; color: #1E293B;">{{ $cleanOpt }}</span>
                                            </label>
                                        @endforeach
                                    @endif

                                    @if($field->has_reason)
                                        <div x-show="selectedVal" 
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 -translate-y-2"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             style="display: none; margin-top: 0.85rem; background: #F0FDF4; border: 1.5px solid #86EFAC; border-radius: 12px; padding: 0.95rem; box-shadow: 0 4px 12px rgba(16,185,129,0.1);">
                                            <label style="display: block; font-size: 0.8125rem; font-weight: 800; color: #166534; margin-bottom: 0.35rem;">
                                                💬 {{ $field->reason_label ?? 'Sebutkan alasan atau penjelasan pilihan Anda:' }}
                                            </label>
                                            <textarea name="reasons[{{ $field->field_name }}]" 
                                                      rows="2" 
                                                      placeholder="Ketikkan alasan atau penjelasan Anda di sini..."
                                                      style="width: 100%; border: 1.5px solid #86EFAC; border-radius: 8px; padding: 0.6rem 0.75rem; font-size: 0.84375rem; background: #FFF; outline: none; line-height: 1.5; font-family: inherit;">{{ old('reasons.' . $field->field_name) }}</textarea>
                                        </div>
                                    @endif
                                </div>

                            @elseif($field->field_type === 'checkbox')
                                <div style="display: flex; flex-direction: column; gap: 0.65rem;" 
                                     x-data="{ checkedItems: {{ json_encode(old('fields.' . $field->field_name, [])) }} }">
                                    @if(!empty($field->options))
                                        @foreach($field->options as $opt)
                                            @php $cleanOpt = ltrim(trim($opt), "• -*\t "); @endphp
                                            <label class="radio-card-option" 
                                                   :class="{ 'active-card-opt': checkedItems.includes('{{ addslashes($cleanOpt) }}') }">
                                                <input type="checkbox" 
                                                       name="fields[{{ $field->field_name }}][]" 
                                                       value="{{ $cleanOpt }}" 
                                                       x-model="checkedItems"
                                                       style="width: 20px; height: 20px; accent-color: #047857; cursor: pointer;" />
                                                <span style="font-size: 0.90625rem; font-weight: 700; color: #1E293B;">{{ $cleanOpt }}</span>
                                            </label>
                                        @endforeach
                                    @endif

                                    @if($field->has_reason)
                                        <div x-show="checkedItems.length > 0" 
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 -translate-y-2"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             style="display: none; margin-top: 0.85rem; background: #F0FDF4; border: 1.5px solid #86EFAC; border-radius: 12px; padding: 0.95rem; box-shadow: 0 4px 12px rgba(16,185,129,0.1);">
                                            <label style="display: block; font-size: 0.8125rem; font-weight: 800; color: #166534; margin-bottom: 0.35rem;">
                                                💬 {{ $field->reason_label ?? 'Sebutkan alasan atau pertimbangan untuk mata kuliah / opsi yang Anda pilih:' }}
                                            </label>
                                            <textarea name="reasons[{{ $field->field_name }}]" 
                                                      rows="2" 
                                                      placeholder="Ketikkan alasan untuk mata kuliah / opsi yang Anda pilih di atas..."
                                                      style="width: 100%; border: 1.5px solid #86EFAC; border-radius: 8px; padding: 0.6rem 0.75rem; font-size: 0.84375rem; background: #FFF; outline: none; line-height: 1.5; font-family: inherit;">{{ old('reasons.' . $field->field_name) }}</textarea>
                                        </div>
                                    @endif
                                </div>

                            @elseif($field->field_type === 'file')
                                <div class="file-dropzone" onclick="document.getElementById('file_input_{{ $field->id }}').click()">
                                    <div style="font-size: 2.25rem; margin-bottom: 0.5rem;">📁</div>
                                    <div style="font-size: 0.90625rem; font-weight: 800; color: #0F172A; margin-bottom: 0.25rem;">
                                        Pilih Berkas Lampiran untuk Diunggah
                                    </div>
                                    <div style="font-size: 0.78125rem; color: #64748B;">
                                        Mendukung PDF, Word (DOCX), Foto, Excel, PPT (Maks. 15MB)
                                    </div>
                                    <input type="file" 
                                           id="file_input_{{ $field->id }} "
                                           name="file_{{ $field->field_name }}" 
                                           {{ $field->is_required ? 'required' : '' }}
                                           style="display: none;" 
                                           onchange="this.parentElement.querySelector('.selected-file-label').innerText = '✅ Berkas dipilih: ' + this.files[0].name" />
                                    <div class="selected-file-label" style="font-size: 0.8125rem; font-weight: 800; color: #047857; margin-top: 0.75rem;"></div>
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach

                <!-- SUBMIT ACTIONS -->
                <div style="background: #FFFFFF; border-radius: 20px; padding: 1.5rem 2rem; border: 1.5px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; box-shadow: 0 6px 20px rgba(0,0,0,0.03); margin-top: 0.5rem;">
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 800; color: #64748B;">PASTIKAN SELURUH DATA BENAR</div>
                        <div style="font-size: 0.875rem; color: #0F172A; font-weight: 900;">Tanggapan akan disimpan langsung ke database resmi.</div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <button type="reset" style="background: #F1F5F9; border: 1.5px solid #CBD5E1; color: #475569; font-weight: 800; font-size: 0.84375rem; padding: 0.8rem 1.25rem; border-radius: 12px; cursor: pointer;">
                            Reset
                        </button>
                        <button type="submit" style="background: linear-gradient(135deg, #072718 0%, #16A34A 100%); color: #FFF; font-weight: 900; font-size: 0.9375rem; padding: 0.85rem 2.25rem; border-radius: 12px; border: 1px solid #C59B27; cursor: pointer; box-shadow: 0 8px 24px rgba(7,39,24,0.3); display: inline-flex; align-items: center; gap: 0.5rem; transition: transform 0.2s ease;">
                            <span>Kirimkan Tanggapan</span>
                            <span style="font-size: 1.1rem;">➔</span>
                        </button>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 1.5rem; font-size: 0.75rem; color: #94A3B8; font-weight: 600;">
                    🛡️ Sistem Formulir Aman & Terenkripsi • Litbang Gajah Mada Adhyaksa Kejaksaan RI
                </div>
            </form>
            </div>
            </div>
        @endif

    </main>
</div>
@endsection
