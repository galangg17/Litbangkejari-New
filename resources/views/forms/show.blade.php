@extends('layouts.app')

@section('content')
<style>
    /* EXECUTIVE CALM FULL-WIDTH FORM STYLING - LITBANG KEJAKSAAN RI */
    :root {
        --kj-primary: #062E1D;
        --kj-primary-dark: #031B11;
        --kj-accent: #C59B27;
        --kj-accent-light: #DFB743;
        --kj-slate-dark: #0F172A;
        --kj-slate-body: #334155;
        --kj-slate-muted: #64748B;
        --kj-border: #E2E8F0;
        --kj-bg-soft: #F8FAFC;
    }

    body {
        background-color: #F8FAFC !important;
    }

    /* CENTRAL WORKSPACE CONTAINER */
    .form-central-container {
        max-width: 900px;
        margin: 2rem auto 0;
        padding: 0 1.25rem;
    }

    /* FULL-WIDTH TOP HERO CARD */
    .form-hero-full {
        background: linear-gradient(145deg, #062E1D 0%, #0A432A 100%);
        border-radius: 18px;
        color: #FFFFFF;
        padding: 2rem 2.25rem;
        box-shadow: 0 10px 25px rgba(6, 46, 29, 0.15);
        border: 1px solid rgba(197, 155, 39, 0.35);
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .form-hero-full::after {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(197, 155, 39, 0.2) 0%, rgba(0,0,0,0) 70%);
        pointer-events: none;
    }

    .hero-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #FFFFFF;
        line-height: 1.45;
        margin: 0 0 0.85rem;
        letter-spacing: -0.01em;
    }
    @media (min-width: 640px) {
        .hero-title {
            font-size: 1.35rem;
        }
    }

    .hero-description {
        font-size: 0.875rem;
        color: #E2E8F0;
        line-height: 1.65;
        margin-bottom: 1.25rem;
        white-space: pre-line;
        border-top: 1px solid rgba(255, 255, 255, 0.12);
        padding-top: 0.85rem;
    }

    .hero-meta-bar {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        font-size: 0.78125rem;
        color: #CBD5E1;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* QUESTION CARD */
    .question-card {
        background: #FFFFFF;
        border-radius: 16px;
        padding: 1.5rem 1.75rem;
        border: 1.5px solid #E2E8F0;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.02);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        position: relative;
    }
    .question-card:hover, .question-card:focus-within {
        border-color: #064E3B;
        box-shadow: 0 6px 18px rgba(6, 78, 59, 0.06);
    }

    .question-num-badge {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: #062E1D;
        color: #FFFFFF;
        font-weight: 800;
        font-size: 0.8125rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .category-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: #F1F5F9;
        border: 1px solid #CBD5E1;
        color: #334155;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        padding: 0.15rem 0.55rem;
        border-radius: 6px;
        margin-bottom: 0.35rem;
    }

    .question-title {
        font-size: 1rem;
        font-weight: 750;
        color: #0F172A;
        line-height: 1.45;
        margin: 0;
    }

    .question-help {
        font-size: 0.84375rem;
        color: #64748B;
        margin-top: 0.3rem;
        line-height: 1.5;
        font-weight: 500;
    }

    /* INPUTS */
    .calm-input {
        width: 100%;
        background: #FFFFFF;
        border: 1.5px solid #CBD5E1;
        border-radius: 10px;
        padding: 0.7rem 0.95rem;
        font-size: 0.90625rem;
        color: #0F172A;
        font-family: inherit;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .calm-input:focus {
        border-color: #064E3B;
        box-shadow: 0 0 0 3px rgba(6, 78, 59, 0.12);
    }

    /* SMART 2-COLUMN OPTIONS GRID */
    .options-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
    @media (min-width: 640px) {
        .options-grid.multi-col {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* OPTION ITEM CARD */
    .option-card-label {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.75rem 0.95rem;
        border-radius: 10px;
        border: 1.5px solid #E2E8F0;
        background: #FFFFFF;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
    }
    .option-card-label:hover {
        background: #F8FAFC;
        border-color: #94A3B8;
    }
    .option-card-label.selected-active {
        background: #F0FDF4;
        border-color: #064E3B;
        box-shadow: 0 1px 4px rgba(6, 78, 59, 0.08);
    }
    .option-card-label input[type="radio"],
    .option-card-label input[type="checkbox"] {
        margin-top: 0.15rem;
        width: 17px;
        height: 17px;
        accent-color: #064E3B;
        cursor: pointer;
        flex-shrink: 0;
    }
    .option-text {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1E293B;
        line-height: 1.4;
    }
    .option-card-label.selected-active .option-text {
        color: #062E1D;
        font-weight: 700;
    }

    /* REASON CALLOUT BOX */
    .reason-box {
        margin-top: 0.85rem;
        background: #F8FAFC;
        border: 1px solid #CBD5E1;
        border-left: 3.5px solid #064E3B;
        border-radius: 10px;
        padding: 0.85rem 1rem;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
    }
    .reason-box label {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8125rem;
        font-weight: 750;
        color: #0F172A;
        margin-bottom: 0.4rem;
    }
    .reason-textarea {
        width: 100%;
        border: 1.5px solid #CBD5E1;
        border-radius: 8px;
        padding: 0.6rem 0.8rem;
        font-size: 0.84375rem;
        background: #FFFFFF;
        outline: none;
        line-height: 1.5;
        font-family: inherit;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }
    .reason-textarea:focus {
        border-color: #064E3B;
        box-shadow: 0 0 0 3px rgba(6, 78, 59, 0.1);
    }

    /* FILE DROPZONE */
    .file-dropzone-box {
        background: #F8FAFC;
        border: 2px dashed #CBD5E1;
        border-radius: 12px;
        padding: 1.5rem 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .file-dropzone-box:hover {
        background: #F1F5F9;
        border-color: #064E3B;
    }
</style>

<div style="min-height: 100vh; background: #F8FAFC; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif; padding-bottom: 5rem;">

    <!-- TOP HEADER -->
    <header style="background: #062E1D; border-bottom: 2px solid #C59B27; padding: 0.85rem 1.5rem; color: #FFF; position: sticky; top: 0; z-index: 50; box-shadow: 0 4px 18px rgba(0,0,0,0.12);">
        <div style="max-width: 900px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo Adhyaksa" style="height: 38px; width: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));" />
                <div>
                    <div style="font-size: 0.625rem; color: #DFB743; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase;">KEJAKSAAN REPUBLIK INDONESIA</div>
                    <div style="font-size: 0.875rem; font-weight: 800; color: #FFF; line-height: 1.2;">Litbang Gajah Mada Adhyaksa</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <a href="{{ route('forms.index') }}" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(223,183,67,0.4); color: #FFF; font-size: 0.75rem; font-weight: 700; padding: 0.4rem 0.85rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; transition: all 0.2s;">
                    ← Beranda Formulir
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN FORM BODY -->
    <main class="form-central-container">

        @if(!$form->isOpen())
            <!-- CLOSED NOTICE -->
            <div style="background: #FFFFFF; border-radius: 18px; padding: 3.5rem 2rem; text-align: center; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin: 2rem 0;">
                <div style="font-size: 3rem; margin-bottom: 0.75rem;">🔒</div>
                <h3 style="font-size: 1.25rem; font-weight: 800; color: #991B1B; margin: 0 0 0.5rem;">Penerimaan Tanggapan Telah Ditutup</h3>
                <p style="font-size: 0.875rem; color: #64748B; margin: 0 0 1.5rem; max-width: 480px; margin-left: auto; margin-right: auto; line-height: 1.6;">
                    Mohon maaf, sesi penerimaan tanggapan untuk kuesioner kegiatan ini telah resmi ditutup oleh pengelola sistem.
                </p>
                <a href="{{ route('forms.index') }}" style="background: #062E1D; color: #DFB743; font-weight: 800; padding: 0.75rem 1.4rem; border-radius: 10px; text-decoration: none; font-size: 0.84375rem; display: inline-flex; align-items: center; gap: 0.4rem;">
                    Lihat Formulir Lain yang Tersedia →
                </a>
            </div>
        @else

            <!-- FULL-WIDTH HERO SECTION (ATAS) -->
            <div class="form-hero-full">
                <!-- Badges -->
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; margin-bottom: 0.85rem; flex-wrap: wrap;">
                    <span style="display: inline-flex; align-items: center; gap: 0.35rem; background: rgba(197, 155, 39, 0.15); border: 1px solid rgba(223, 183, 67, 0.5); padding: 0.25rem 0.65rem; border-radius: 9999px; font-size: 0.6875rem; font-weight: 800; color: #DFB743; letter-spacing: 0.05em; text-transform: uppercase;">
                        🏛️ INSTRUMEN RESMI BADIKLAT KEJAKSAAN RI
                    </span>

                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="background: rgba(16, 185, 129, 0.2); color: #A7F3D0; border: 1px solid rgba(16, 185, 129, 0.4); font-size: 0.6875rem; font-weight: 800; padding: 0.2rem 0.6rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.3rem;">
                            ● PENERIMAAN AKTIF
                        </span>
                        <span style="background: rgba(255, 255, 255, 0.1); color: #FFFFFF; font-size: 0.6875rem; font-weight: 750; padding: 0.2rem 0.6rem; border-radius: 9999px;">
                            {{ $form->fields->count() }} Butir Pertanyaan
                        </span>
                    </div>
                </div>

                <!-- Form Title -->
                <h1 class="hero-title">
                    {{ $form->title }}
                </h1>

                <!-- Description & Petunjuk Pengisian -->
                @if($form->description)
                    <div class="hero-description">
                        {{ $form->description }}
                    </div>
                @endif

                <!-- Meta bar (Batas Waktu, Tanda Bintang, Jaminan Kerahasiaan) -->
                <div class="hero-meta-bar">
                    <div style="display: flex; align-items: center; gap: 0.4rem;">
                        <span style="color: #F87171; font-weight: 900; font-size: 0.95rem;">*</span>
                        <span>Tanda bintang merah menunjukkan butir wajib diisi.</span>
                    </div>

                    @if($form->deadline_at)
                        <div style="color: #FDE68A; font-weight: 700; display: flex; align-items: center; gap: 0.35rem;">
                            <span>⏳</span>
                            <span>Batas Pengisian: {{ $form->deadline_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                    @else
                        <div style="display: flex; align-items: center; gap: 0.35rem; color: #CBD5E1;">
                            <span>🔒</span>
                            <span>Kerahasiaan jawaban dijamin sepenuhnya</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- VALIDATION ERRORS -->
            @if ($errors->any())
                <div style="background: #FEF2F2; border: 1.5px solid #F87171; color: #991B1B; border-radius: 14px; padding: 1.15rem 1.4rem; margin-bottom: 1.5rem; font-size: 0.875rem; box-shadow: 0 4px 16px rgba(239,68,68,0.06);">
                    <div style="font-weight: 800; margin-bottom: 0.4rem; display: flex; align-items: center; gap: 0.45rem;">
                        <span>⚠️</span> Mohon periksa kembali isian formulir:
                    </div>
                    <ul style="margin: 0; padding-left: 1.25rem; line-height: 1.6;">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- MAIN SUBMISSION FORM (SEQUENTIAL STREAM) -->
            <form action="{{ route('forms.submit', $form->slug) }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.25rem;">
                @csrf

                @foreach($form->fields as $index => $field)
                    @php
                        $optCount = is_array($field->options) ? count($field->options) : 0;
                        $isMultiCol = $optCount >= 4;
                    @endphp

                    <div class="question-card">
                        
                        <!-- Header Question with Counter Badge & Category -->
                        <div style="display: flex; align-items: flex-start; gap: 0.85rem; margin-bottom: 0.95rem;">
                            <div class="question-num-badge">{{ $index + 1 }}</div>
                            <div style="flex: 1;">
                                @if(!empty($field->category))
                                    <div>
                                        <span class="category-chip">
                                            <span>📁</span>
                                            <span>{{ $field->category }}</span>
                                        </span>
                                    </div>
                                @endif

                                <label class="question-title">
                                    {{ $field->field_label }}
                                    @if($field->is_required)
                                        <span style="color: #DC2626; font-size: 1.05rem; line-height: 1;" title="Wajib Diisi">*</span>
                                    @endif
                                </label>

                                @if($field->help_text)
                                    <div class="question-help">
                                        {{ $field->help_text }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- INPUT CONTROLS -->
                        <div>
                            @if($field->field_type === 'text')
                                <input type="text" 
                                       name="fields[{{ $field->field_name }}]" 
                                       value="{{ old('fields.' . $field->field_name) }}" 
                                       placeholder="Ketik jawaban Anda di sini..." 
                                       {{ $field->is_required ? 'required' : '' }}
                                       class="calm-input" />

                            @elseif($field->field_type === 'number')
                                <input type="number" 
                                       name="fields[{{ $field->field_name }}]" 
                                       value="{{ old('fields.' . $field->field_name) }}" 
                                       placeholder="0" 
                                       {{ $field->is_required ? 'required' : '' }}
                                       class="calm-input" style="max-width: 240px;" />

                            @elseif($field->field_type === 'date')
                                <input type="date" 
                                       name="fields[{{ $field->field_name }}]" 
                                       value="{{ old('fields.' . $field->field_name) }}" 
                                       {{ $field->is_required ? 'required' : '' }}
                                       class="calm-input" style="max-width: 260px;" />

                            @elseif($field->field_type === 'textarea')
                                <textarea name="fields[{{ $field->field_name }}]" 
                                          rows="3" 
                                          placeholder="Tuliskan jawaban atau penjelasan Anda secara lengkap..." 
                                          {{ $field->is_required ? 'required' : '' }}
                                          class="calm-input" style="resize: vertical; line-height: 1.6;">{{ old('fields.' . $field->field_name) }}</textarea>

                            @elseif($field->field_type === 'select')
                                <div x-data="{ selectedVal: '{{ old('fields.' . $field->field_name) }}' }">
                                    <select name="fields[{{ $field->field_name }}]" 
                                            x-model="selectedVal"
                                            {{ $field->is_required ? 'required' : '' }}
                                            class="calm-input" style="max-width: 520px; cursor: pointer;">
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
                                             style="display: none;"
                                             class="reason-box">
                                            <label>
                                                <span>💬</span>
                                                <span>{{ $field->reason_label ?? 'Alasan atau penjelasan pilihan Anda:' }}</span>
                                            </label>
                                            <textarea name="reasons[{{ $field->field_name }}]" 
                                                      rows="2" 
                                                      placeholder="Tuliskan alasan atau keterangan pilihan Anda di sini..."
                                                      class="reason-textarea">{{ old('reasons.' . $field->field_name) }}</textarea>
                                        </div>
                                    @endif
                                </div>

                            @elseif($field->field_type === 'radio')
                                <div x-data="{ selectedVal: '{{ old('fields.' . $field->field_name) }}' }">
                                    <div class="options-grid {{ $isMultiCol ? 'multi-col' : '' }}">
                                        @if(!empty($field->options))
                                            @foreach($field->options as $opt)
                                                @php $cleanOpt = ltrim(trim($opt), "• -*\t "); @endphp
                                                <label class="option-card-label" 
                                                       :class="{ 'selected-active': selectedVal === '{{ addslashes($cleanOpt) }}' }"
                                                       @click="selectedVal = '{{ addslashes($cleanOpt) }}'">
                                                    <input type="radio" 
                                                           name="fields[{{ $field->field_name }}]" 
                                                           value="{{ $cleanOpt }}" 
                                                           x-model="selectedVal"
                                                           {{ old('fields.' . $field->field_name) == $cleanOpt ? 'checked' : '' }}
                                                           {{ $field->is_required ? 'required' : '' }} />
                                                    <span class="option-text">{{ $cleanOpt }}</span>
                                                </label>
                                            @endforeach
                                        @endif
                                    </div>

                                    @if($field->has_reason)
                                        <div x-show="selectedVal" 
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 -translate-y-2"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             style="display: none;"
                                             class="reason-box">
                                            <label>
                                                <span>💬</span>
                                                <span>{{ $field->reason_label ?? 'Alasan atau penjelasan pilihan Anda:' }}</span>
                                            </label>
                                            <textarea name="reasons[{{ $field->field_name }}]" 
                                                      rows="2" 
                                                      placeholder="Tuliskan alasan atau penjelasan pertimbangan Anda di sini..."
                                                      class="reason-textarea">{{ old('reasons.' . $field->field_name) }}</textarea>
                                        </div>
                                    @endif
                                </div>

                            @elseif($field->field_type === 'checkbox')
                                <div x-data="{ checkedItems: {{ json_encode(old('fields.' . $field->field_name, [])) }} }">
                                    <div class="options-grid {{ $isMultiCol ? 'multi-col' : '' }}">
                                        @if(!empty($field->options))
                                            @foreach($field->options as $opt)
                                                @php $cleanOpt = ltrim(trim($opt), "• -*\t "); @endphp
                                                <label class="option-card-label" 
                                                       :class="{ 'selected-active': checkedItems.includes('{{ addslashes($cleanOpt) }}') }">
                                                    <input type="checkbox" 
                                                           name="fields[{{ $field->field_name }}][]" 
                                                           value="{{ $cleanOpt }}" 
                                                           x-model="checkedItems" />
                                                    <span class="option-text">{{ $cleanOpt }}</span>
                                                </label>
                                            @endforeach
                                        @endif
                                    </div>

                                    @if($field->has_reason)
                                        <div x-show="checkedItems.length > 0" 
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 -translate-y-2"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             style="display: none;"
                                             class="reason-box">
                                            <label>
                                                <span>💬</span>
                                                <span>{{ $field->reason_label ?? 'Alasan atau pertimbangan untuk opsi / mata kuliah yang Anda pilih:' }}</span>
                                            </label>
                                            <textarea name="reasons[{{ $field->field_name }}]" 
                                                      rows="2" 
                                                      placeholder="Tuliskan alasan untuk opsi atau mata kuliah yang Anda centang di atas..."
                                                      class="reason-textarea">{{ old('reasons.' . $field->field_name) }}</textarea>
                                        </div>
                                    @endif
                                </div>

                            @elseif($field->field_type === 'file')
                                <div class="file-dropzone-box" onclick="document.getElementById('file_input_{{ $field->id }}').click()">
                                    <div style="font-size: 2.25rem; margin-bottom: 0.4rem;">📁</div>
                                    <div style="font-size: 0.875rem; font-weight: 750; color: #0F172A; margin-bottom: 0.25rem;">
                                        Klik untuk Memilih Berkas Lampiran
                                    </div>
                                    <div style="font-size: 0.78125rem; color: #64748B;">
                                        Mendukung PDF, Word (DOCX), Foto, Excel, PPT (Maks. 15MB)
                                    </div>
                                    <input type="file" 
                                           id="file_input_{{ $field->id }}"
                                           name="file_{{ $field->field_name }}" 
                                           {{ $field->is_required ? 'required' : '' }}
                                           style="display: none;" 
                                           onchange="this.parentElement.querySelector('.selected-file-label').innerText = '✅ Berkas dipilih: ' + this.files[0].name" />
                                    <div class="selected-file-label" style="font-size: 0.8125rem; font-weight: 700; color: #064E3B; margin-top: 0.65rem;"></div>
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach

                <!-- SUBMIT ACTIONS -->
                <div style="background: #FFFFFF; border-radius: 16px; padding: 1.5rem 1.85rem; border: 1.5px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; box-shadow: 0 4px 16px rgba(0,0,0,0.03); margin-top: 0.5rem;">
                    <div>
                        <div style="font-size: 0.6875rem; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">FINALISASI TANGGAPAN</div>
                        <div style="font-size: 0.875rem; color: #0F172A; font-weight: 750;">Pastikan seluruh pertanyaan telah dijawab dengan benar.</div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <button type="reset" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; color: #475569; font-weight: 700; font-size: 0.84375rem; padding: 0.75rem 1.25rem; border-radius: 10px; cursor: pointer; transition: background 0.15s;">
                            Reset
                        </button>
                        <button type="submit" style="background: #062E1D; color: #DFB743; font-weight: 800; font-size: 0.90625rem; padding: 0.8rem 2rem; border-radius: 10px; border: 1px solid rgba(223,183,67,0.5); cursor: pointer; box-shadow: 0 4px 16px rgba(6,46,29,0.25); display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s ease;">
                            <span>Kirimkan Tanggapan</span>
                            <span style="font-size: 1rem;">➔</span>
                        </button>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 1.5rem; font-size: 0.75rem; color: #94A3B8; font-weight: 600;">
                    🛡️ Sistem Formulir Aman & Terenkripsi • Litbang Gajah Mada Adhyaksa Kejaksaan RI
                </div>
            </form>
        @endif

    </main>
</div>
@endsection
