@extends('layouts.app')

@section('content')
<style>
    /* EXECUTIVE 2-SISI (SPLIT STUDIO) FORM STYLING - LITBANG KEJAKSAAN RI */
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

    /* 2-COLUMN WORKSPACE GRID */
    .form-workspace-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    @media (min-width: 992px) {
        .form-workspace-grid {
            grid-template-columns: 380px 1fr;
            align-items: start;
            gap: 2rem;
        }
        .form-sticky-panel {
            position: sticky;
            top: 80px;
            max-height: calc(100vh - 100px);
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(197, 155, 39, 0.4) transparent;
            padding-right: 4px;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .form-sticky-panel::-webkit-scrollbar {
            width: 5px;
        }
        .form-sticky-panel::-webkit-scrollbar-thumb {
            background: rgba(197, 155, 39, 0.4);
            border-radius: 9999px;
        }
    }

    /* SISI KIRI: HERO & PETUNJUK RESMI CARD */
    .form-hero-card {
        background: linear-gradient(145deg, #062E1D 0%, #0A432A 100%);
        border-radius: 16px;
        color: #FFFFFF;
        padding: 1.5rem 1.6rem;
        box-shadow: 0 8px 24px rgba(6, 46, 29, 0.15);
        border: 1px solid rgba(197, 155, 39, 0.35);
        position: relative;
        overflow: hidden;
    }
    .form-hero-card::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(197, 155, 39, 0.2) 0%, rgba(0,0,0,0) 70%);
        pointer-events: none;
    }

    .hero-title {
        font-size: 1.125rem;
        font-weight: 800;
        color: #FFFFFF;
        line-height: 1.4;
        margin: 0 0 0.75rem;
        letter-spacing: -0.01em;
    }

    .hero-desc {
        font-size: 0.8125rem;
        color: #E2E8F0;
        line-height: 1.55;
        margin-bottom: 1rem;
        white-space: pre-line;
        border-top: 1px solid rgba(255, 255, 255, 0.12);
        padding-top: 0.75rem;
    }

    .hero-guideline-box {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        padding: 0.65rem 0.85rem;
        font-size: 0.75rem;
        color: #CBD5E1;
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* SISI KANAN: QUESTION CARD */
    .question-card {
        background: #FFFFFF;
        border-radius: 14px;
        padding: 1.35rem 1.6rem;
        border: 1.5px solid #E2E8F0;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        position: relative;
    }
    .question-card:hover, .question-card:focus-within {
        border-color: #064E3B;
        box-shadow: 0 4px 14px rgba(6, 78, 59, 0.06);
    }

    .question-num-badge {
        width: 28px;
        height: 28px;
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
        gap: 0.3rem;
        background: #F1F5F9;
        border: 1px solid #CBD5E1;
        color: #334155;
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        padding: 0.15rem 0.5rem;
        border-radius: 5px;
        margin-bottom: 0.35rem;
    }

    .question-title {
        font-size: 0.96875rem;
        font-weight: 750;
        color: #0F172A;
        line-height: 1.45;
        margin: 0;
    }

    .question-help {
        font-size: 0.8125rem;
        color: #64748B;
        margin-top: 0.25rem;
        line-height: 1.5;
        font-weight: 500;
    }

    /* INPUTS */
    .calm-input {
        width: 100%;
        background: #FFFFFF;
        border: 1.5px solid #CBD5E1;
        border-radius: 9px;
        padding: 0.65rem 0.85rem;
        font-size: 0.875rem;
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

    /* 2-COLUMN OPTIONS GRID UNTUK PILIHAN BANYAK (MATA KULIAH DLL) */
    .options-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.45rem;
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
        gap: 0.65rem;
        padding: 0.65rem 0.85rem;
        border-radius: 9px;
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
        box-shadow: 0 1px 3px rgba(6, 78, 59, 0.08);
    }
    .option-card-label input[type="radio"],
    .option-card-label input[type="checkbox"] {
        margin-top: 0.15rem;
        width: 16px;
        height: 16px;
        accent-color: #064E3B;
        cursor: pointer;
        flex-shrink: 0;
    }
    .option-text {
        font-size: 0.84375rem;
        font-weight: 600;
        color: #1E293B;
        line-height: 1.35;
    }
    .option-card-label.selected-active .option-text {
        color: #062E1D;
        font-weight: 700;
    }

    /* REASON CALLOUT BOX */
    .reason-box {
        margin-top: 0.75rem;
        background: #F8FAFC;
        border: 1px solid #CBD5E1;
        border-left: 3.5px solid #064E3B;
        border-radius: 9px;
        padding: 0.75rem 0.95rem;
        box-shadow: 0 2px 5px rgba(15, 23, 42, 0.02);
    }
    .reason-box label {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.78125rem;
        font-weight: 750;
        color: #0F172A;
        margin-bottom: 0.35rem;
    }
    .reason-textarea {
        width: 100%;
        border: 1.5px solid #CBD5E1;
        border-radius: 7px;
        padding: 0.55rem 0.75rem;
        font-size: 0.8125rem;
        background: #FFFFFF;
        outline: none;
        line-height: 1.45;
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
        padding: 1.4rem 1.2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .file-dropzone-box:hover {
        background: #F1F5F9;
        border-color: #064E3B;
    }

    /* SIDEBAR INFO ITEMS */
    .info-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.55rem 0;
        border-bottom: 1px solid #F1F5F9;
        font-size: 0.8125rem;
    }
    .info-item-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
</style>

<div style="min-height: 100vh; background: #F8FAFC; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif; padding-bottom: 5rem;">

    <!-- TOP HEADER -->
    <header style="background: #062E1D; border-bottom: 2px solid #C59B27; padding: 0.8rem 1.5rem; color: #FFF; position: sticky; top: 0; z-index: 50; box-shadow: 0 4px 18px rgba(0,0,0,0.12);">
        <div style="max-width: 1240px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
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

    <!-- MAIN FORM BODY (2-SISI WORKSPACE) -->
    <main style="max-width: 1240px; margin: 1.75rem auto 0; padding: 0 1.25rem;">

        @if(!$form->isOpen())
            <!-- CLOSED NOTICE -->
            <div style="background: #FFFFFF; border-radius: 18px; padding: 3.5rem 2rem; text-align: center; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0,0,0,0.03); max-width: 600px; margin: 2rem auto;">
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

            <!-- 2-COLUMN WORKSPACE: SISI KIRI (STICKY HERO & PETUNJUK) | SISI KANAN (STREAM PERTANYAAN) -->
            <div class="form-workspace-grid">
                
                <!-- SISI KIRI: STICKY HERO & PETUNJUK RESMI (TIDAK AKAN TERPOTONG KARENA SCROLLABLE & PROPORSI PAS) -->
                <aside class="form-sticky-panel">
                    
                    <!-- HERO CARD -->
                    <div class="form-hero-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem; flex-wrap: wrap;">
                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: rgba(197, 155, 39, 0.15); border: 1px solid rgba(223, 183, 67, 0.5); padding: 0.2rem 0.55rem; border-radius: 9999px; font-size: 0.65rem; font-weight: 800; color: #DFB743; letter-spacing: 0.05em; text-transform: uppercase;">
                                🏛️ INSTRUMEN RESMI
                            </span>

                            <span style="background: rgba(16, 185, 129, 0.2); color: #A7F3D0; border: 1px solid rgba(16, 185, 129, 0.4); font-size: 0.65rem; font-weight: 800; padding: 0.15rem 0.5rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.25rem;">
                                ● SESI AKTIF
                            </span>
                        </div>

                        <h1 class="hero-title">
                            {{ $form->title }}
                        </h1>

                        @if($form->description)
                            <div class="hero-desc">
                                {{ $form->description }}
                            </div>
                        @endif

                        <div class="hero-guideline-box">
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
                                    <span>Kerahasiaan data dijamin sepenuhnya.</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- RINGKASAN & JAMINAN DATA -->
                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 1.15rem 1.25rem; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                        <div style="font-size: 0.6875rem; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
                            INFORMASI KUESIONER
                        </div>

                        <div class="info-item-row">
                            <span style="color: #64748B; font-weight: 600;">Jumlah Pertanyaan</span>
                            <span style="font-weight: 800; color: #0F172A; background: #F1F5F9; padding: 0.15rem 0.5rem; border-radius: 6px; font-size: 0.8125rem;">
                                {{ $form->fields->count() }} Butir
                            </span>
                        </div>

                        <div class="info-item-row">
                            <span style="color: #64748B; font-weight: 600;">Keamanan & Arsip</span>
                            <span style="font-weight: 700; color: #064E3B; display: inline-flex; align-items: center; gap: 0.25rem;">
                                <span>🛡️</span> Database Resmi Diklat
                            </span>
                        </div>
                    </div>

                </aside>

                <!-- SISI KANAN: STREAM BUTIR PERTANYAAN -->
                <div class="form-questions-stream">
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

                    <!-- MAIN SUBMISSION FORM -->
                    <form action="{{ route('forms.submit', $form->slug) }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.15rem;">
                        @csrf

                        @foreach($form->fields as $index => $field)
                            @php
                                $optCount = is_array($field->options) ? count($field->options) : 0;
                                $isMultiCol = $optCount >= 4;
                            @endphp

                            <div class="question-card">
                                
                                <!-- Header Question with Counter Badge & Category -->
                                <div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 0.85rem;">
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
                                                  class="calm-input" style="resize: vertical; line-height: 1.55;">{{ old('fields.' . $field->field_name) }}</textarea>

                                    @elseif($field->field_type === 'select')
                                        <div x-data="{ selectedVal: '{{ old('fields.' . $field->field_name) }}' }">
                                            <select name="fields[{{ $field->field_name }}]" 
                                                    x-model="selectedVal"
                                                    {{ $field->is_required ? 'required' : '' }}
                                                    class="calm-input" style="max-width: 480px; cursor: pointer;">
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
                                            <div style="font-size: 2rem; margin-bottom: 0.35rem;">📁</div>
                                            <div style="font-size: 0.875rem; font-weight: 750; color: #0F172A; margin-bottom: 0.2rem;">
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
                                            <div class="selected-file-label" style="font-size: 0.8125rem; font-weight: 700; color: #064E3B; margin-top: 0.5rem;"></div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        @endforeach

                        <!-- SUBMIT ACTIONS -->
                        <div style="background: #FFFFFF; border-radius: 14px; padding: 1.25rem 1.6rem; border: 1.5px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.02); margin-top: 0.5rem;">
                            <div>
                                <div style="font-size: 0.6875rem; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">FINALISASI TANGGAPAN</div>
                                <div style="font-size: 0.84375rem; color: #0F172A; font-weight: 750;">Pastikan seluruh data telah sesuai sebelum dikirim.</div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 0.65rem;">
                                <button type="reset" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; color: #475569; font-weight: 700; font-size: 0.8125rem; padding: 0.7rem 1.15rem; border-radius: 9px; cursor: pointer; transition: background 0.15s;">
                                    Reset
                                </button>
                                <button type="submit" style="background: #062E1D; color: #DFB743; font-weight: 800; font-size: 0.875rem; padding: 0.75rem 1.75rem; border-radius: 9px; border: 1px solid rgba(223,183,67,0.5); cursor: pointer; box-shadow: 0 4px 14px rgba(6,46,29,0.22); display: inline-flex; align-items: center; gap: 0.45rem; transition: all 0.2s ease;">
                                    <span>Kirimkan Tanggapan</span>
                                    <span style="font-size: 0.95rem;">➔</span>
                                </button>
                            </div>
                        </div>

                        <div style="text-align: center; margin-top: 1.25rem; font-size: 0.75rem; color: #94A3B8; font-weight: 600;">
                            🛡️ Sistem Formulir Aman & Terenkripsi • Litbang Gajah Mada Adhyaksa Kejaksaan RI
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </main>
</div>
@endsection
