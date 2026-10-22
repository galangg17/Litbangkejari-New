@extends('layouts.app')

@section('content')
<style>
    /* EXECUTIVE CALM FORM STYLING - LITBANG KEJAKSAAN RI */
    :root {
        --kj-primary: #062E1D;
        --kj-primary-dark: #031B11;
        --kj-primary-light: #0B462C;
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

    /* 2-COLUMN RESPONSIVE LAYOUT */
    .form-workspace-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.75rem;
    }
    @media (min-width: 992px) {
        .form-workspace-grid {
            grid-template-columns: 380px 1fr;
            align-items: start;
            gap: 2.25rem;
        }
        .form-sticky-panel {
            position: sticky;
            top: 86px;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
    }

    /* LEFT HERO CARD */
    .form-hero-card {
        background: linear-gradient(145deg, #062E1D 0%, #0A432A 100%);
        border-radius: 20px;
        color: #FFFFFF;
        padding: 2rem 1.85rem;
        box-shadow: 0 10px 30px rgba(6, 46, 29, 0.18);
        border: 1px solid rgba(197, 155, 39, 0.35);
        position: relative;
        overflow: hidden;
    }
    .form-hero-card::after {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(197, 155, 39, 0.2) 0%, rgba(0,0,0,0) 70%);
        pointer-events: none;
    }

    /* QUESTION CARD */
    .question-card {
        background: #FFFFFF;
        border-radius: 18px;
        padding: 1.75rem 2rem;
        border: 1px solid #E2E8F0;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        position: relative;
    }
    .question-card:hover, .question-card:focus-within {
        border-color: #064E3B;
        box-shadow: 0 8px 24px rgba(6, 78, 59, 0.08);
    }

    .question-num-badge {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #062E1D;
        color: #FFFFFF;
        font-weight: 800;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(6, 46, 29, 0.2);
    }

    .category-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: #F1F5F9;
        border: 1px solid #CBD5E1;
        color: #334155;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        padding: 0.2rem 0.65rem;
        border-radius: 6px;
        margin-bottom: 0.45rem;
    }

    .question-title {
        font-size: 1.0625rem;
        font-weight: 800;
        color: #0F172A;
        line-height: 1.45;
        margin: 0;
    }

    .question-help {
        font-size: 0.875rem;
        color: #64748B;
        margin-top: 0.35rem;
        line-height: 1.55;
        font-weight: 500;
    }

    /* INPUTS */
    .calm-input {
        width: 100%;
        background: #FFFFFF;
        border: 1.5px solid #CBD5E1;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.9375rem;
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

    /* SMART RESPONSIVE OPTIONS GRID */
    .options-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.55rem;
    }
    @media (min-width: 640px) {
        .options-grid.multi-col {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }

    /* OPTION ITEM CARD */
    .option-card-label {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.85rem 1rem;
        border-radius: 12px;
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
        box-shadow: 0 2px 8px rgba(6, 78, 59, 0.08);
    }
    .option-card-label input[type="radio"],
    .option-card-label input[type="checkbox"] {
        margin-top: 0.15rem;
        width: 18px;
        height: 18px;
        accent-color: #064E3B;
        cursor: pointer;
        flex-shrink: 0;
    }
    .option-text {
        font-size: 0.90625rem;
        font-weight: 600;
        color: #1E293B;
        line-height: 1.4;
    }
    .option-card-label.selected-active .option-text {
        color: #062E1D;
        font-weight: 750;
    }

    /* REASON CALLOUT BOX (TENANG, ELEGAN, TIDAK SAKIT MATA) */
    .reason-box {
        margin-top: 1rem;
        background: #F8FAFC;
        border: 1px solid #CBD5E1;
        border-left: 4px solid #064E3B;
        border-radius: 12px;
        padding: 1rem 1.15rem;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    }
    .reason-box label {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8125rem;
        font-weight: 800;
        color: #0F172A;
        margin-bottom: 0.45rem;
    }
    .reason-textarea {
        width: 100%;
        border: 1.5px solid #CBD5E1;
        border-radius: 8px;
        padding: 0.65rem 0.85rem;
        font-size: 0.875rem;
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
        border-radius: 14px;
        padding: 1.75rem 1.25rem;
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
        padding: 0.65rem 0;
        border-bottom: 1px solid #F1F5F9;
        font-size: 0.84375rem;
    }
    .info-item-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
</style>

<div style="min-height: 100vh; background: #F8FAFC; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif; padding-bottom: 5rem;">

    <!-- TOP BAR -->
    <header style="background: #062E1D; border-bottom: 2px solid #C59B27; padding: 0.9rem 1.5rem; color: #FFF; position: sticky; top: 0; z-index: 50; box-shadow: 0 4px 18px rgba(0,0,0,0.12);">
        <div style="max-width: 1240px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
            <div style="display: flex; align-items: center; gap: 0.85rem;">
                <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo Adhyaksa" style="height: 40px; width: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));" />
                <div>
                    <div style="font-size: 0.65rem; color: #DFB743; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase;">KEJAKSAAN REPUBLIK INDONESIA</div>
                    <div style="font-size: 0.90625rem; font-weight: 800; color: #FFF; line-height: 1.2;">Litbang Gajah Mada Adhyaksa</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <a href="{{ route('forms.index') }}" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(223,183,67,0.4); color: #FFF; font-size: 0.75rem; font-weight: 700; padding: 0.45rem 0.95rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; transition: all 0.2s;">
                    ← Beranda Formulir
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN FORM BODY -->
    <main style="max-width: 1240px; margin: 2rem auto 0; padding: 0 1.25rem;">

        @if(!$form->isOpen())
            <!-- CLOSED NOTICE -->
            <div style="background: #FFFFFF; border-radius: 20px; padding: 4rem 2rem; text-align: center; border: 1px solid #E2E8F0; box-shadow: 0 8px 30px rgba(0,0,0,0.04); max-width: 640px; margin: 2rem auto;">
                <div style="font-size: 3rem; margin-bottom: 0.75rem;">🔒</div>
                <h3 style="font-size: 1.35rem; font-weight: 800; color: #991B1B; margin: 0 0 0.5rem;">Penerimaan Tanggapan Telah Ditutup</h3>
                <p style="font-size: 0.90625rem; color: #64748B; margin: 0 0 1.75rem; max-width: 480px; margin-left: auto; margin-right: auto; line-height: 1.6;">
                    Mohon maaf, pengelola sistem telah menutup sesi penerimaan tanggapan untuk kuesioner kegiatan ini.
                </p>
                <a href="{{ route('forms.index') }}" style="background: #062E1D; color: #DFB743; font-weight: 800; padding: 0.75rem 1.5rem; border-radius: 10px; text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 15px rgba(6,46,29,0.2);">
                    Lihat Formulir Lain yang Tersedia →
                </a>
            </div>
        @else

            <!-- 2-COLUMN WORKSPACE: LEFT STICKY HERO & INFO | RIGHT FORM QUESTIONS -->
            <div class="form-workspace-grid">
                
                <!-- SISI KIRI: STICKY HERO & PETUNJUK RESMI FORMULIR -->
                <aside class="form-sticky-panel">
                    
                    <!-- HERO CARD -->
                    <div class="form-hero-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap;">
                            <span style="display: inline-flex; align-items: center; gap: 0.35rem; background: rgba(197, 155, 39, 0.15); border: 1px solid rgba(223, 183, 67, 0.5); padding: 0.25rem 0.65rem; border-radius: 9999px; font-size: 0.6875rem; font-weight: 800; color: #DFB743; letter-spacing: 0.05em; text-transform: uppercase;">
                                🏛️ BADIKLAT KEJAKSAAN RI
                            </span>

                            <span style="background: rgba(16, 185, 129, 0.2); color: #A7F3D0; border: 1px solid rgba(16, 185, 129, 0.4); font-size: 0.6875rem; font-weight: 800; padding: 0.2rem 0.6rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.3rem;">
                                ● SESI AKTIF
                            </span>
                        </div>

                        <h1 style="font-size: 1.25rem; font-weight: 800; color: #FFFFFF; line-height: 1.4; margin: 0 0 0.85rem; letter-spacing: -0.01em;">
                            {{ $form->title }}
                        </h1>

                        @if($form->description)
                            <div style="font-size: 0.84375rem; color: #E2E8F0; line-height: 1.6; margin: 0 0 1.25rem; white-space: pre-line; border-top: 1px solid rgba(255,255,255,0.12); padding-top: 0.85rem;">
                                {{ $form->description }}
                            </div>
                        @endif

                        <div style="background: rgba(0,0,0,0.18); border-radius: 12px; padding: 0.75rem 0.95rem; font-size: 0.78125rem; color: #CBD5E1; display: flex; flex-direction: column; gap: 0.4rem;">
                            <div style="display: flex; align-items: center; gap: 0.4rem;">
                                <span style="color: #F87171; font-weight: 900; font-size: 0.95rem;">*</span>
                                <span>Tanda bintang merah menunjukkan butir wajib diisi.</span>
                            </div>
                            @if($form->deadline_at)
                                <div style="color: #FDE68A; font-weight: 700; display: flex; align-items: center; gap: 0.35rem;">
                                    <span>⏳</span>
                                    <span>Batas Pengisian: {{ $form->deadline_at->format('d M Y, H:i') }} WIB</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- SUMMARY CARD -->
                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 1.25rem 1.4rem; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                        <div style="font-size: 0.6875rem; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.65rem;">
                            INFORMASI KUESIONER
                        </div>

                        <div class="info-item-row">
                            <span style="color: #64748B; font-weight: 600;">Total Pertanyaan</span>
                            <span style="font-weight: 800; color: #0F172A; background: #F1F5F9; padding: 0.2rem 0.6rem; border-radius: 6px; font-size: 0.84375rem;">
                                {{ $form->fields->count() }} Butir
                            </span>
                        </div>

                        <div class="info-item-row">
                            <span style="color: #64748B; font-weight: 600;">Keamanan Data</span>
                            <span style="font-weight: 700; color: #064E3B; display: inline-flex; align-items: center; gap: 0.3rem;">
                                <span>🔒</span> Terenkripsi
                            </span>
                        </div>

                        <div style="margin-top: 0.85rem; padding-top: 0.75rem; border-top: 1px solid #F1F5F9; font-size: 0.75rem; color: #64748B; line-height: 1.5;">
                            Tanggapan yang Anda berikan digunakan murni sebagai bahan kajian evaluasi akademik dan penyempurnaan kurikulum Diklat PPPJ Kejaksaan RI.
                        </div>
                    </div>

                </aside>

                <!-- SISI KANAN: STREAM BUTIR PERTANYAAN -->
                <div class="form-questions-stream">
                    <!-- VALIDATION ERRORS -->
                    @if ($errors->any())
                        <div style="background: #FEF2F2; border: 1.5px solid #F87171; color: #991B1B; border-radius: 14px; padding: 1.15rem 1.4rem; margin-bottom: 1.5rem; font-size: 0.875rem; box-shadow: 0 4px 16px rgba(239,68,68,0.08);">
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
                    <form action="{{ route('forms.submit', $form->slug) }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.25rem;">
                        @csrf

                        @foreach($form->fields as $index => $field)
                            @php
                                $optCount = is_array($field->options) ? count($field->options) : 0;
                                $isMultiCol = $optCount >= 5;
                            @endphp

                            <div class="question-card">
                                
                                <!-- Header Question with Counter Badge & Category -->
                                <div style="display: flex; align-items: flex-start; gap: 0.85rem; margin-bottom: 1rem;">
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
                                                <span style="color: #DC2626; font-size: 1.1rem; line-height: 1;" title="Wajib Diisi">*</span>
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
                                            <div style="font-size: 0.90625rem; font-weight: 750; color: #0F172A; margin-bottom: 0.25rem;">
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
                        <div style="background: #FFFFFF; border-radius: 18px; padding: 1.5rem 1.85rem; border: 1px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; box-shadow: 0 4px 16px rgba(0,0,0,0.03); margin-top: 0.5rem;">
                            <div>
                                <div style="font-size: 0.7rem; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">FINALISASI TANGGAPAN</div>
                                <div style="font-size: 0.875rem; color: #0F172A; font-weight: 750;">Pastikan data telah terisi sebelum mengirimkan.</div>
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
                </div>
            </div>
        @endif

    </main>
</div>
@endsection
