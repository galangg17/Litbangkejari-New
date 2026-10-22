@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; background: #F8FAFC; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif;" 
     x-data="{ 
         responseTab: 'individual',
         searchQuery: '',
         filterQuestion: 'all'
     }">

    <style>
        .resp-tab-group {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: #F1F5F9;
            padding: 0.35rem;
            border-radius: 14px;
            border: 1.5px solid #CBD5E1;
        }
        .resp-tab-btn {
            appearance: none;
            -webkit-appearance: none;
            border: none !important;
            outline: none !important;
            background: transparent;
            color: #475569;
            font-weight: 800;
            font-size: 0.84375rem;
            padding: 0.6rem 1.25rem;
            border-radius: 10px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            transition: all 0.2s ease;
            font-family: inherit;
            user-select: none;
            box-shadow: none !important;
        }
        .resp-tab-btn:hover {
            color: #072718;
            background: rgba(255, 255, 255, 0.8);
        }
        .resp-tab-btn.active {
            background: linear-gradient(135deg, #072718 0%, #15803D 100%) !important;
            color: #FFFFFF !important;
            font-weight: 900 !important;
            box-shadow: 0 4px 14px rgba(7, 39, 24, 0.25) !important;
        }
        .header-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8125rem;
            font-weight: 800;
            padding: 0.55rem 1.1rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }
        .header-btn:hover {
            transform: translateY(-1px);
        }
        .header-btn-green {
            background: linear-gradient(135deg, #16A34A 0%, #15803D 100%);
            color: #FFFFFF;
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.35);
        }
        .header-btn-blue {
            background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%);
            color: #FFFFFF;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
        }
        .header-btn-glass {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: #FFFFFF;
            backdrop-filter: blur(8px);
        }
        .header-btn-glass:hover {
            background: rgba(255, 255, 255, 0.22);
        }
        .header-btn-gold {
            background: rgba(212, 175, 55, 0.2);
            border: 1px solid #D4AF37 !important;
            color: #FDE68A;
        }
        .header-btn-gold:hover {
            background: rgba(212, 175, 55, 0.32);
        }
    </style>

    <!-- 1. TOP EXECUTIVE HEADER (DARK EMERALD & GOLD ACCENT) -->
    <header style="background: linear-gradient(135deg, #072718 0%, #0D3E27 100%); border-bottom: 2.5px solid #D4AF37; padding: 1.25rem 2rem; color: #FFFFFF; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
        <div style="max-width: 1240px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.25rem;">
            
            <div style="display: flex; align-items: center; gap: 1rem;">
                <a href="{{ route('dashboard.index', ['tab' => 'custom_forms']) }}" 
                   style="background: rgba(255,255,255,0.12); color: #D4AF37; border: 1px solid rgba(212,175,55,0.4); text-decoration: none; font-size: 1.15rem; width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                    ←
                </a>
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.2rem;">
                        <span style="font-size: 0.6875rem; color: #D4AF37; font-weight: 900; letter-spacing: 0.06em; text-transform: uppercase; background: rgba(212,175,55,0.18); border: 1px solid rgba(212,175,55,0.4); padding: 0.2rem 0.6rem; border-radius: 9999px;">
                            PUSAT REKAPITULASI & ANALISIS RESPON
                        </span>
                        @if($form->isOpen())
                            <span style="font-size: 0.6875rem; color: #86EFAC; font-weight: 800; background: rgba(16,185,129,0.2); border: 1px solid #10B981; padding: 0.2rem 0.6rem; border-radius: 9999px;">
                                🟢 BUKA (MENERIMA TANGGAPAN)
                            </span>
                        @else
                            <span style="font-size: 0.6875rem; color: #FCA5A5; font-weight: 800; background: rgba(239,68,68,0.2); border: 1px solid #EF4444; padding: 0.2rem 0.6rem; border-radius: 9999px;">
                                🔴 PENERIMAAN DITUTUP
                            </span>
                        @endif
                    </div>
                    <h1 style="font-size: 1.35rem; font-weight: 900; margin: 0; color: #FFFFFF; line-height: 1.25; letter-spacing: -0.01em;">
                        {{ $form->title }}
                    </h1>
                </div>
            </div>

            <!-- EXPORT & ACTION TOOLBAR -->
            <div style="display: flex; align-items: center; gap: 0.65rem; flex-wrap: wrap;">
                <a href="{{ route('dashboard.forms.builder', $form->id) }}" class="header-btn header-btn-glass">
                    ✏️ Edit Formulir
                </a>
                <a href="{{ route('dashboard.forms.export.csv', $form->id) }}" class="header-btn header-btn-green">
                    📥 Unduh Excel (CSV)
                </a>
                <a href="{{ route('dashboard.forms.export.pdf.summary', $form->id) }}" target="_blank" class="header-btn header-btn-blue">
                    🖨️ Cetak PDF Kesimpulan
                </a>
                <a href="{{ route('forms.show', $form->slug) }}" target="_blank" class="header-btn header-btn-gold">
                    🌐 Buka Form Publik
                </a>
            </div>

        </div>
    </header>

    <!-- 2. MAIN WORKSPACE CONTAINER -->
    <main style="max-width: 1240px; margin: 2rem auto 5rem; padding: 0 1.5rem;">

        <!-- TOP METRICS & 3-WAY TAB SELECTOR -->
        <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 22px; padding: 1.5rem 1.75rem; margin-bottom: 2rem; box-shadow: 0 8px 25px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.25rem;">
                
                <!-- KPI METRICS SUMMARY -->
                <div style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
                    <div>
                        <div style="font-size: 0.72rem; font-weight: 900; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">
                            TOTAL TANGGAPAN MASUK
                        </div>
                        <div style="font-size: 2.25rem; font-weight: 900; color: #072718; line-height: 1.1; margin-top: 0.2rem; display: flex; align-items: baseline; gap: 0.4rem;">
                            {{ $responses->count() }}
                            <span style="font-size: 0.95rem; color: #64748B; font-weight: 700;">Responden Terdata</span>
                        </div>
                    </div>

                    <div style="height: 42px; width: 1.5px; background: #E2E8F0;"></div>

                    <div>
                        <div style="font-size: 0.72rem; font-weight: 900; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">
                            JUMLAH PERTANYAAN
                        </div>
                        <div style="font-size: 1.45rem; font-weight: 900; color: #0F172A; line-height: 1.2; margin-top: 0.2rem;">
                            {{ $form->fields->count() }} <span style="font-size: 0.85rem; color: #64748B; font-weight: 700;">Butir Soal</span>
                        </div>
                    </div>

                    <div style="height: 42px; width: 1.5px; background: #E2E8F0;"></div>

                    <div>
                        <div style="font-size: 0.72rem; font-weight: 900; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">
                            RESPON TERAKHIR
                        </div>
                        <div style="font-size: 0.9375rem; font-weight: 800; color: #166534; line-height: 1.3; margin-top: 0.25rem;">
                            {{ $responses->first() ? $responses->first()->created_at->format('d M Y, H:i') . ' WIB' : 'Belum Ada' }}
                        </div>
                    </div>
                </div>

                <!-- SLEEK 3-WAY TAB CAPSULE (GOOGLE FORMS EXECUTIVE STYLE) -->
                <div class="resp-tab-group">
                    <button type="button" 
                            @click="responseTab = 'individual'" 
                            class="resp-tab-btn" 
                            :class="{ 'active': responseTab === 'individual' }">
                        <span>👤</span>
                        <span>Perorangan (Individual)</span>
                    </button>

                    <button type="button" 
                            @click="responseTab = 'table'" 
                            class="resp-tab-btn" 
                            :class="{ 'active': responseTab === 'table' }">
                        <span>📋</span>
                        <span>Tabel Respon (Spreadsheet)</span>
                    </button>

                    <button type="button" 
                            @click="responseTab = 'summary'" 
                            class="resp-tab-btn" 
                            :class="{ 'active': responseTab === 'summary' }">
                        <span>📊</span>
                        <span>Ringkasan / Statistik</span>
                    </button>
                </div>

            </div>
        </div>

        @if($responses->isEmpty())
            <!-- EMPTY STATE -->
            <div style="background: #FFFFFF; border: 2px dashed #CBD5E1; border-radius: 22px; padding: 4.5rem 2rem; text-align: center; color: #64748B; box-shadow: 0 6px 20px rgba(0,0,0,0.02);">
                <div style="font-size: 3.5rem; margin-bottom: 0.75rem;">📊</div>
                <h3 style="font-size: 1.25rem; font-weight: 900; color: #0F172A; margin: 0 0 0.5rem;">
                    Belum Ada Tanggapan yang Masuk
                </h3>
                <p style="font-size: 0.875rem; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.6;">
                    Bagikan tautan formulir ini kepada peserta PPPJ atau responden terkait untuk mulai menghimpun aspirasi dan evaluasi akademik.
                </p>
                <div style="display: flex; gap: 0.75rem; justify-content: center;">
                    <a href="{{ route('forms.show', $form->slug) }}" target="_blank" 
                       style="background: #072718; color: #D4AF37; font-size: 0.84375rem; font-weight: 900; padding: 0.65rem 1.5rem; border-radius: 12px; text-decoration: none; border: 1.5px solid #C59B27; box-shadow: 0 4px 14px rgba(7,39,24,0.2);">
                        Buka & Isi Formulir Publik →
                    </a>
                </div>
            </div>
        @else

            <!-- ============================================================== -->
            <!-- TAB 1: DATA PERORANGAN (INDIVIDUAL DOSSIER REVIEW VIEW)        -->
            <!-- ============================================================== -->
            <div x-show="responseTab === 'individual'" style="display: none;">
                @if($currentResponse)
                    <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 22px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.04);">
                        
                        <!-- 1. EXECUTIVE PAGINATOR & QUICK JUMP TOOLBAR -->
                        <div style="background: #F8FAFC; border-bottom: 1.5px solid #E2E8F0; padding: 1rem 1.75rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                            
                            <!-- PREV / COUNTER / NEXT CONTROLS -->
                            <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap;">
                                <!-- PREVIOUS BUTTON -->
                                <a href="{{ route('dashboard.forms.responses', ['id' => $form->id, 'index' => $currentIndex - 1]) }}" 
                                   style="{{ $currentIndex > 0 ? '' : 'pointer-events: none; opacity: 0.35;' }} background: #FFFFFF; border: 1.5px solid #CBD5E1; color: #0F172A; font-weight: 800; font-size: 0.8125rem; padding: 0.5rem 0.95rem; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                    ◀ Sebelumnya
                                </a>

                                <!-- CURRENT INDICATOR PILL -->
                                <div style="background: #072718; color: #D4AF37; font-size: 0.8125rem; font-weight: 900; padding: 0.5rem 1rem; border-radius: 10px; border: 1px solid #C59B27; letter-spacing: 0.02em; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    <span>👤 Responden {{ $currentIndex + 1 }}</span>
                                    <span style="color: rgba(212,175,55,0.6);">/</span>
                                    <span style="color: #FFFFFF;">{{ $responses->count() }}</span>
                                </div>

                                <!-- NEXT BUTTON -->
                                <a href="{{ route('dashboard.forms.responses', ['id' => $form->id, 'index' => $currentIndex + 1]) }}" 
                                   style="{{ $currentIndex < $responses->count() - 1 ? '' : 'pointer-events: none; opacity: 0.35;' }} background: #FFFFFF; border: 1.5px solid #CBD5E1; color: #0F172A; font-weight: 800; font-size: 0.8125rem; padding: 0.5rem 0.95rem; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                    Berikutnya ▶
                                </a>
                            </div>

                            <!-- DIRECT RESPONDENT SELECTOR & ACTIONS -->
                            <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                                <!-- DIRECT JUMP DROPDOWN -->
                                <div style="display: flex; align-items: center; gap: 0.45rem;">
                                    <span style="font-size: 0.78125rem; font-weight: 800; color: #64748B;">Lompat Ke:</span>
                                    <select onchange="window.location.href=this.value" 
                                            style="background: #FFFFFF; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.48rem 0.85rem; font-size: 0.8125rem; font-weight: 800; color: #072718; outline: none; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
                                        @foreach($responses as $rIdx => $rItem)
                                            <option value="{{ route('dashboard.forms.responses', ['id' => $form->id, 'index' => $rIdx]) }}" {{ $rIdx === $currentIndex ? 'selected' : '' }}>
                                                #{{ $rIdx + 1 }} • {{ $rItem->respondent_name ?? 'Anonim' }} ({{ $rItem->created_at->format('d/m H:i') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- PRINT INDIVIDUAL PDF -->
                                <a href="{{ route('dashboard.forms.export.pdf.individual', ['id' => $form->id, 'responseId' => $currentResponse->id]) }}" 
                                   target="_blank" 
                                   style="background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%); color: #FFFFFF; font-size: 0.8125rem; font-weight: 900; padding: 0.52rem 1.15rem; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 12px rgba(2,132,199,0.25);">
                                    🖨️ Cetak PDF Respon Ini
                                </a>
                            </div>
                        </div>

                        <!-- 2. RESPONDENT DOSSIER PROFILE CARD -->
                        <div style="background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%); border-bottom: 1.5px solid #E2E8F0; padding: 1.5rem 2rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.25rem;">
                                
                                <div style="display: flex; align-items: center; gap: 1.15rem;">
                                    <!-- AVATAR BADGE -->
                                    <div style="width: 58px; height: 58px; border-radius: 16px; background: linear-gradient(135deg, #072718 0%, #15803D 100%); color: #D4AF37; font-weight: 900; font-size: 1.45rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 18px rgba(7,39,24,0.2); border: 2px solid #C59B27; flex-shrink: 0;">
                                        {{ strtoupper(substr($currentResponse->respondent_name ?? 'R', 0, 1)) }}
                                    </div>
                                    
                                    <div>
                                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.2rem;">
                                            <span style="font-size: 0.6875rem; font-weight: 900; color: #166534; text-transform: uppercase; letter-spacing: 0.06em; background: #DCFCE7; border: 1px solid #86EFAC; padding: 0.15rem 0.55rem; border-radius: 6px;">
                                                LEMBAR EVALUASI PESERTA RESMI
                                            </span>
                                            <span style="font-size: 0.6875rem; font-weight: 800; color: #64748B;">
                                                ID: #{{ $currentResponse->id }}
                                            </span>
                                        </div>

                                        <h2 style="font-size: 1.4rem; font-weight: 900; color: #072718; margin: 0 0 0.25rem; line-height: 1.2;">
                                            {{ $currentResponse->respondent_name ?? 'Responden Anonim' }}
                                            @if($currentResponse->respondent_identifier)
                                                <span style="font-size: 0.875rem; color: #475569; font-weight: 700; margin-left: 0.35rem;">
                                                    • {{ $currentResponse->respondent_identifier }}
                                                </span>
                                            @endif
                                        </h2>

                                        <!-- METADATA CHIPS -->
                                        <div style="display: flex; align-items: center; gap: 0.85rem; font-size: 0.78125rem; color: #64748B; flex-wrap: wrap;">
                                            <span style="display: inline-flex; align-items: center; gap: 0.3rem;">
                                                <span>⏱️</span>
                                                <span>Diserahkan: <strong style="color: #1E293B;">{{ $currentResponse->created_at->format('d F Y, H:i') }} WIB</strong></span>
                                            </span>
                                            <span>•</span>
                                            <span style="display: inline-flex; align-items: center; gap: 0.3rem;">
                                                <span>🌐</span>
                                                <span>IP: <code style="color: #475569; font-weight: 700;">{{ $currentResponse->ip_address ?? '127.0.0.1' }}</code></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.35rem;">
                                    <span style="background: #DCFCE7; color: #15803D; font-weight: 900; font-size: 0.78125rem; padding: 0.4rem 0.95rem; border-radius: 9999px; border: 1.5px solid #86EFAC; display: inline-flex; align-items: center; gap: 0.35rem;">
                                        <span>✅</span>
                                        <span>Respon Terverifikasi</span>
                                    </span>
                                    <span style="font-size: 0.72rem; color: #94A3B8; font-weight: 700;">
                                        Tersimpan Aman di Database
                                    </span>
                                </div>

                            </div>
                        </div>

                        <!-- 3. QUESTION & ANSWER DOSSIER LIST -->
                        <div style="padding: 2rem; display: flex; flex-direction: column; gap: 1.35rem; background: #FFFFFF;">
                            @foreach($form->fields as $index => $field)
                                @php
                                    $fieldData = $currentResponse->answers[$field->field_name] ?? null;
                                    $ans = $fieldData['value'] ?? null;
                                    $reason = $fieldData['reason'] ?? null;
                                    $type = strtolower($field->field_type);
                                @endphp

                                <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 16px; padding: 1.4rem 1.6rem; transition: all 0.2s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                                    
                                    <!-- QUESTION HEADER ROW -->
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-bottom: 0.85rem;">
                                        <div style="display: flex; align-items: flex-start; gap: 0.65rem;">
                                            <!-- NUMBER BADGE -->
                                            <div style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.75rem; padding: 0.25rem 0.6rem; border-radius: 8px; border: 1px solid #C59B27; flex-shrink: 0; margin-top: 0.1rem;">
                                                #{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                            </div>
                                            
                                            <div>
                                                <!-- QUESTION LABEL -->
                                                <h4 style="font-size: 0.96875rem; font-weight: 800; color: #0F172A; margin: 0; line-height: 1.45;">
                                                    {{ $field->field_label }}
                                                    @if($field->is_required)
                                                        <span style="color: #EF4444; font-weight: 900;" title="Wajib Diisi">*</span>
                                                    @endif
                                                </h4>

                                                @if($field->help_text)
                                                    <div style="font-size: 0.75rem; color: #64748B; margin-top: 0.2rem; font-style: italic;">
                                                        ℹ️ {{ $field->help_text }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- FIELD TYPE TAG -->
                                        <span style="font-size: 0.6875rem; font-weight: 800; color: #475569; background: #F1F5F9; border: 1px solid #CBD5E1; padding: 0.2rem 0.6rem; border-radius: 6px; white-space: nowrap; text-transform: uppercase;">
                                            @if($type === 'radio') Pilihan Tunggal
                                            @elseif($type === 'checkbox') Kotak Centang
                                            @elseif($type === 'select') Pilihan Dropdown
                                            @elseif($type === 'textarea') Uraian Panjang
                                            @elseif($type === 'file') Berkas Lampiran
                                            @else Jawaban Teks
                                            @endif
                                        </span>
                                    </div>

                                    <!-- ANSWER VALUE CONTAINER (STYLED BY DATA TYPE) -->
                                    <div style="margin-left: 2.25rem;">
                                        @if(is_array($ans))
                                            @if(isset($ans['url']))
                                                <!-- ATTACHED FILE -->
                                                <div style="display: inline-flex; align-items: center; justify-content: space-between; gap: 1.25rem; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 12px; padding: 0.85rem 1.25rem;">
                                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                                        <span style="font-size: 1.85rem;">📁</span>
                                                        <div>
                                                            <div style="font-weight: 900; font-size: 0.875rem; color: #0F172A;">{{ $ans['name'] }}</div>
                                                            <div style="font-size: 0.72rem; color: #64748B;">Ukuran Berkas: {{ $ans['size'] }}</div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ $ans['url'] }}" target="_blank" 
                                                       style="background: #0284C7; color: #FFF; font-weight: 900; font-size: 0.75rem; padding: 0.45rem 1rem; border-radius: 8px; text-decoration: none; box-shadow: 0 2px 6px rgba(2,132,199,0.25);">
                                                        ⬇️ Unduh Berkas
                                                    </a>
                                                </div>
                                            @else
                                                <!-- MULTIPLE CHECKBOX PILLS -->
                                                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                                    @foreach($ans as $subVal)
                                                        @php $cleanSubVal = ltrim(trim($subVal), "• -*\t "); @endphp
                                                        <div style="display: inline-flex; align-items: center; gap: 0.45rem; background: #EFF6FF; border: 1.5px solid #93C5FD; color: #1E40AF; font-weight: 800; font-size: 0.84375rem; padding: 0.45rem 0.95rem; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                                                            <span style="color: #2563EB;">☑️</span>
                                                            <span>{{ $cleanSubVal }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @elseif($type === 'radio' || $type === 'select')
                                            <!-- SINGLE CHOICE PILL (HIGHLIGHTED AS ACTIVE DECISION) -->
                                            @php $cleanAns = ltrim(trim($ans ?? ''), "• -*\t "); @endphp
                                            <div style="display: inline-flex; align-items: center; gap: 0.6rem; background: #ECFDF5; border: 1.5px solid #10B981; color: #065F46; padding: 0.55rem 1.15rem; border-radius: 12px; font-weight: 900; font-size: 0.90625rem; box-shadow: 0 2px 6px rgba(16,185,129,0.12);">
                                                <span style="color: #10B981; font-size: 1rem;">🔘</span>
                                                <span>{{ !empty($cleanAns) ? $cleanAns : '(Tidak memilih)' }}</span>
                                            </div>
                                        @elseif($type === 'textarea')
                                            <!-- LONG TEXT / ESSAY ANSWER -->
                                            @php $cleanAns = trim($ans ?? ''); @endphp
                                            <div style="background: #F8FAFC; border-left: 4px solid #072718; border-top: 1px solid #E2E8F0; border-right: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0; border-radius: 0 12px 12px 0; padding: 0.95rem 1.25rem; font-size: 0.90625rem; color: #1E293B; line-height: 1.6; font-weight: 600;">
                                                {{ !empty($cleanAns) ? $cleanAns : '-' }}
                                            </div>
                                        @else
                                            <!-- SHORT TEXT (E.G. NAMA, KELAS, NIP) -->
                                            @php $cleanAns = trim($ans ?? ''); @endphp
                                            <div style="display: inline-flex; align-items: center; gap: 0.6rem; background: #F8FAFC; border: 1.5px solid #CBD5E1; color: #0F172A; padding: 0.5rem 1.1rem; border-radius: 10px; font-weight: 800; font-size: 0.90625rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                                                <span style="color: #64748B;">✍️</span>
                                                <span>{{ !empty($cleanAns) ? $cleanAns : '-' }}</span>
                                            </div>
                                        @endif

                                        <!-- HIGHLIGHTED REASON / PENJELASAN CALLOUT -->
                                        @if(!empty($reason))
                                            <div style="margin-top: 0.85rem; background: linear-gradient(135deg, #FEFCE8 0%, #FEF9C3 100%); border: 1.5px solid #FACC15; border-radius: 14px; padding: 0.95rem 1.25rem; display: flex; align-items: flex-start; gap: 0.85rem; box-shadow: 0 3px 10px rgba(234,179,8,0.1);">
                                                <span style="font-size: 1.35rem; line-height: 1;">💡</span>
                                                <div style="flex: 1;">
                                                    <div style="font-size: 0.72rem; font-weight: 900; color: #854D0E; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">
                                                        Alasan & Penjelasan Responden:
                                                    </div>
                                                    <div style="font-size: 0.90625rem; font-weight: 800; color: #713F12; line-height: 1.55; font-style: italic;">
                                                        “{{ $reason }}”
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        <!-- 4. BOTTOM FOOTER NAVIGATION -->
                        <div style="background: #F8FAFC; border-top: 1.5px solid #E2E8F0; padding: 1.15rem 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                            <div style="font-size: 0.78125rem; color: #64748B; font-weight: 700;">
                                Menampilkan Responden #{{ $currentIndex + 1 }} dari Total {{ $responses->count() }} Data
                            </div>

                            <div style="display: flex; align-items: center; gap: 0.6rem;">
                                <a href="{{ route('dashboard.forms.responses', ['id' => $form->id, 'index' => $currentIndex - 1]) }}" 
                                   style="{{ $currentIndex > 0 ? '' : 'pointer-events: none; opacity: 0.35;' }} background: #FFFFFF; border: 1.5px solid #CBD5E1; color: #0F172A; font-weight: 800; font-size: 0.8125rem; padding: 0.5rem 0.95rem; border-radius: 10px; text-decoration: none;">
                                    ◀ Sebelumnya
                                </a>
                                <a href="{{ route('dashboard.forms.responses', ['id' => $form->id, 'index' => $currentIndex + 1]) }}" 
                                   style="{{ $currentIndex < $responses->count() - 1 ? '' : 'pointer-events: none; opacity: 0.35;' }} background: #FFFFFF; border: 1.5px solid #CBD5E1; color: #0F172A; font-weight: 800; font-size: 0.8125rem; padding: 0.5rem 0.95rem; border-radius: 10px; text-decoration: none;">
                                    Berikutnya ▶
                                </a>
                            </div>
                        </div>

                    </div>
                @endif
            </div>

            <!-- ============================================================== -->
            <!-- TAB 2: TABEL SPREADSHEET RESPON (CALLSET DATA GRID)             -->
            <!-- ============================================================== -->
            <div x-show="responseTab === 'table'" style="display: none;">
                <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 22px; padding: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.04);">
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.75rem;">
                        <div>
                            <h3 style="font-size: 1.1rem; font-weight: 900; color: #072718; margin: 0 0 0.2rem;">
                                📋 Lembar Spreadsheet Data Responden
                            </h3>
                            <div style="font-size: 0.78125rem; color: #64748B;">
                                Tampilan tabular menyeluruh ala Google Sheet / Excel untuk audit data cepat.
                            </div>
                        </div>

                        <div>
                            <input type="text" x-model="searchQuery" placeholder="🔍 Cari nama peserta atau jawaban..." style="background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.5rem 0.85rem; font-size: 0.8125rem; outline: none; width: 280px;" />
                        </div>
                    </div>

                    <div style="overflow-x: auto; border: 1.5px solid #E2E8F0; border-radius: 14px;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.8125rem; text-align: left;">
                            <thead style="background: #072718; color: #FFFFFF;">
                                <tr>
                                    <th style="padding: 0.75rem 1rem; border-right: 1px solid rgba(255,255,255,0.15); white-space: nowrap; width: 45px;">No</th>
                                    <th style="padding: 0.75rem 1rem; border-right: 1px solid rgba(255,255,255,0.15); white-space: nowrap; width: 140px;">Waktu</th>
                                    <th style="padding: 0.75rem 1rem; border-right: 1px solid rgba(255,255,255,0.15); white-space: nowrap; width: 160px;">Nama Responden</th>
                                    @foreach($form->fields as $fld)
                                        <th style="padding: 0.75rem 1rem; border-right: 1px solid rgba(255,255,255,0.15); min-width: 200px; max-width: 280px;">
                                            {{ $fld->field_label }}
                                        </th>
                                    @endforeach
                                    <th style="padding: 0.75rem 1rem; text-align: center; white-space: nowrap; width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($responses as $idx => $resp)
                                    <tr style="border-bottom: 1px solid #E2E8F0; background: {{ $idx % 2 === 0 ? '#FFFFFF' : '#F8FAFC' }};">
                                        <td style="padding: 0.75rem 1rem; font-weight: 900; color: #64748B; border-right: 1px solid #E2E8F0; text-align: center;">
                                            {{ $idx + 1 }}
                                        </td>
                                        <td style="padding: 0.75rem 1rem; border-right: 1px solid #E2E8F0; white-space: nowrap; color: #64748B;">
                                            {{ $resp->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td style="padding: 0.75rem 1rem; border-right: 1px solid #E2E8F0; font-weight: 800; color: #072718; white-space: nowrap;">
                                            {{ $resp->respondent_name ?? 'Anonim' }}
                                        </td>
                                        @foreach($form->fields as $fld)
                                            @php
                                                $cell = $resp->answers[$fld->field_name] ?? null;
                                                $cellVal = $cell['value'] ?? '-';
                                                $cellReason = $cell['reason'] ?? null;
                                            @endphp
                                            <td style="padding: 0.75rem 1rem; border-right: 1px solid #E2E8F0; color: #1E293B; vertical-align: top;">
                                                @if(is_array($cellVal))
                                                    @if(isset($cellVal['url']))
                                                        <a href="{{ $cellVal['url'] }}" target="_blank" style="color: #0284C7; font-weight: 700; text-decoration: underline;">
                                                            📎 {{ $cellVal['name'] }}
                                                        </a>
                                                    @else
                                                        {{ implode(', ', array_map(function($v){ return ltrim(trim($v), "• -*\t "); }, $cellVal)) }}
                                                    @endif
                                                @else
                                                    {{ ltrim(trim($cellVal ?? '-'), "• -*\t ") }}
                                                @endif

                                                @if(!empty($cellReason))
                                                    <div style="margin-top: 0.35rem; font-size: 0.75rem; color: #166534; background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 6px; padding: 0.25rem 0.5rem;">
                                                        💬 <em>"{{ $cellReason }}"</em>
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td style="padding: 0.75rem 1rem; text-align: center; white-space: nowrap;">
                                            <a href="{{ route('dashboard.forms.responses', ['id' => $form->id, 'index' => $idx]) }}" 
                                               @click="responseTab = 'individual'"
                                               style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.72rem; padding: 0.35rem 0.65rem; border-radius: 6px; text-decoration: none;">
                                                👁️ Buka
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- ============================================================== -->
            <!-- TAB 3: RINGKASAN & STATISTIK AGREGAT (VISUAL ANALYTICS)         -->
            <!-- ============================================================== -->
            <div x-show="responseTab === 'summary'" style="display: none;">
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    @foreach($summary as $fn => $data)
                        <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 1.65rem; box-shadow: 0 6px 20px rgba(0,0,0,0.03);">
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.15rem; border-bottom: 1.5px solid #F1F5F9; padding-bottom: 0.75rem;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.72rem; padding: 0.15rem 0.55rem; border-radius: 6px;">
                                        #{{ $loop->iteration }}
                                    </span>
                                    <h3 style="font-size: 1.05rem; font-weight: 900; color: #072718; margin: 0;">
                                        {{ $data['label'] }}
                                    </h3>
                                </div>
                                <span style="font-size: 0.72rem; font-weight: 800; color: #0284C7; background: #E0F2FE; padding: 0.2rem 0.6rem; border-radius: 9999px;">
                                    {{ strtoupper($data['type']) }}
                                </span>
                            </div>

                            <!-- STATISTIK OPSI DENGAN PROGRESS BAR MODERN -->
                            @if(isset($data['counts']))
                                <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                                    @php
                                        $totalVotes = array_sum($data['counts']);
                                    @endphp
                                    @foreach($data['counts'] as $optName => $count)
                                        @php
                                            $cleanOptName = ltrim(trim($optName), "• -*\t ");
                                            $percent = $totalVotes > 0 ? round(($count / $totalVotes) * 100, 1) : 0;
                                        @endphp
                                        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 0.85rem 1rem;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.875rem; font-weight: 800; color: #1E293B; margin-bottom: 0.45rem;">
                                                <span>{{ $cleanOptName }}</span>
                                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                    <span style="font-size: 0.75rem; color: #64748B; font-weight: 700;">{{ $count }} Suara</span>
                                                    <span style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.75rem; padding: 0.15rem 0.5rem; border-radius: 6px;">
                                                        {{ $percent }}%
                                                    </span>
                                                </div>
                                            </div>
                                            <div style="width: 100%; height: 10px; background: #E2E8F0; border-radius: 9999px; overflow: hidden;">
                                                <div style="width: {{ $percent }}%; height: 100%; background: linear-gradient(90deg, #10B981 0%, #047857 100%); border-radius: 9999px; transition: width 0.5s ease;"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- ACCORDION ALASAN & URAIAN RESPOSEN -->
                                @if(!empty($data['reasons']))
                                    <div style="margin-top: 1.25rem; border-top: 1.5px dashed #CBD5E1; padding-top: 1rem;">
                                        <div style="font-size: 0.8125rem; font-weight: 900; color: #166534; margin-bottom: 0.65rem; display: flex; align-items: center; gap: 0.4rem;">
                                            <span>💬</span>
                                            <span>Rincian Alasan Responden ({{ count($data['reasons']) }} Catatan Masuk):</span>
                                        </div>
                                        <div style="display: flex; flex-direction: column; gap: 0.55rem; max-height: 280px; overflow-y: auto;">
                                            @foreach($data['reasons'] as $rItem)
                                                <div style="background: #F0FDF4; border: 1.5px solid #86EFAC; border-radius: 10px; padding: 0.75rem 1rem; font-size: 0.8125rem;">
                                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                                                        <span style="font-weight: 900; color: #166534;">
                                                            {{ $rItem['respondent'] }}
                                                        </span>
                                                        <span style="font-size: 0.7rem; font-weight: 800; color: #072718; background: rgba(212,175,55,0.2); border: 1px solid #D4AF37; padding: 0.15rem 0.45rem; border-radius: 6px;">
                                                            Pilihan: {{ ltrim(trim($rItem['selected']), "• -*\t ") }}
                                                        </span>
                                                    </div>
                                                    <div style="color: #334155; line-height: 1.5; font-style: italic;">
                                                        "{{ $rItem['reason'] }}"
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                            <!-- DAFTAR CUPLIKAN JAWABAN TEKS -->
                            @elseif(isset($data['samples']))
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; max-height: 280px; overflow-y: auto;">
                                    @forelse($data['samples'] as $sampleText)
                                        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 0.75rem 1rem; border-radius: 10px; font-size: 0.84375rem; color: #1E293B; line-height: 1.5;">
                                            {{ $sampleText }}
                                        </div>
                                    @empty
                                        <div style="font-size: 0.8125rem; color: #94A3B8;">Belum ada tanggapan teks yang masuk.</div>
                                    @endforelse
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>
            </div>

        @endif

    </main>

</div>
@endsection
