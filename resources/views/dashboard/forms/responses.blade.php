@extends('layouts.app')

@section('content')
<style>
    /* EXECUTIVE RESPONSE CENTER STYLING - LITBANG KEJAKSAAN RI */
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

    .resp-tab-capsule {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: #F1F5F9;
        padding: 0.3rem;
        border-radius: 12px;
        border: 1px solid #CBD5E1;
    }
    .resp-tab-btn {
        border: none !important;
        outline: none !important;
        background: transparent;
        color: #475569;
        font-weight: 750;
        font-size: 0.8125rem;
        padding: 0.5rem 1.15rem;
        border-radius: 9px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.15s ease;
        font-family: inherit;
        user-select: none;
    }
    .resp-tab-btn:hover {
        color: #062E1D;
        background: rgba(255, 255, 255, 0.85);
    }
    .resp-tab-btn.active {
        background: #062E1D !important;
        color: #DFB743 !important;
        font-weight: 800 !important;
        box-shadow: 0 2px 8px rgba(6, 46, 29, 0.25) !important;
    }

    .top-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.78125rem;
        font-weight: 750;
        padding: 0.5rem 0.95rem;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.15s ease;
        border: 1px solid transparent;
        cursor: pointer;
    }
    .top-action-btn:hover {
        transform: translateY(-1px);
    }
    .btn-green-subtle {
        background: #064E3B;
        color: #FFFFFF;
        border-color: rgba(223, 183, 67, 0.4);
    }
    .btn-glass-subtle {
        background: rgba(255, 255, 255, 0.08);
        color: #FFFFFF;
        border-color: rgba(255, 255, 255, 0.2);
    }
    .btn-glass-subtle:hover {
        background: rgba(255, 255, 255, 0.15);
    }

    /* MASTER-DETAIL 2-COLUMN LAYOUT UNTUK INDIVIDUAL */
    .master-detail-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
    @media (min-width: 992px) {
        .master-detail-grid {
            grid-template-columns: 320px 1fr;
            align-items: start;
            gap: 1.5rem;
        }
    }

    .respondent-nav-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 0.95rem;
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        background: #FFFFFF;
        text-decoration: none;
        color: inherit;
        transition: all 0.15s ease;
        margin-bottom: 0.45rem;
    }
    .respondent-nav-item:hover {
        background: #F8FAFC;
        border-color: #CBD5E1;
    }
    .respondent-nav-item.active-item {
        background: #F0FDF4;
        border-color: #064E3B;
        box-shadow: 0 2px 6px rgba(6, 78, 59, 0.08);
    }

    .answer-card-item {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 12px;
        padding: 1.15rem 1.35rem;
        margin-bottom: 1rem;
        transition: border-color 0.15s ease;
    }
    .answer-card-item:hover {
        border-color: #CBD5E1;
    }

    .badge-num {
        background: #062E1D;
        color: #DFB743;
        font-weight: 800;
        font-size: 0.75rem;
        padding: 0.2rem 0.55rem;
        border-radius: 6px;
        flex-shrink: 0;
    }
</style>

<div style="min-height: 100vh; background: #F8FAFC; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif;" 
     x-data="{ 
         responseTab: 'individual',
         searchQuery: '',
         respondentSearch: '',
         selectedKelas: 'all',
         reasonFilter: ''
     }">

    <!-- TOP EXECUTIVE HEADER -->
    <header style="background: #062E1D; border-bottom: 2px solid #C59B27; padding: 1rem 1.5rem; color: #FFFFFF; box-shadow: 0 4px 18px rgba(0,0,0,0.15);">
        <div style="max-width: 1280px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            
            <div style="display: flex; align-items: center; gap: 0.85rem;">
                <a href="{{ route('dashboard.index', ['tab' => 'custom_forms']) }}" 
                   style="background: rgba(255,255,255,0.08); color: #DFB743; border: 1px solid rgba(223,183,67,0.4); text-decoration: none; font-size: 1.1rem; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                    ←
                </a>
                <div>
                    <div style="display: flex; align-items: center; gap: 0.45rem; margin-bottom: 0.2rem;">
                        <span style="font-size: 0.65rem; color: #DFB743; font-weight: 800; letter-spacing: 0.06em; text-transform: uppercase;">
                            PUSAT DATA & ANALISIS RESPON
                        </span>
                        @if($form->isOpen())
                            <span style="font-size: 0.65rem; color: #A7F3D0; font-weight: 750; background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.4); padding: 0.15rem 0.5rem; border-radius: 9999px;">
                                ● Sesi Aktif
                            </span>
                        @else
                            <span style="font-size: 0.65rem; color: #FCA5A5; font-weight: 750; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); padding: 0.15rem 0.5rem; border-radius: 9999px;">
                                ● Selesai / Ditutup
                            </span>
                        @endif
                    </div>
                    <h1 style="font-size: 1.15rem; font-weight: 800; margin: 0; color: #FFFFFF; line-height: 1.3;">
                        {{ $form->title }}
                    </h1>
                </div>
            </div>

            <!-- ACTION TOOLBAR -->
            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                <a href="{{ route('dashboard.forms.builder', $form->id) }}" class="top-action-btn btn-glass-subtle">
                    ✏️ Pengaturan Form
                </a>
                <a href="{{ route('dashboard.forms.export.csv', $form->id) }}" class="top-action-btn btn-green-subtle">
                    📥 Unduh Excel (CSV)
                </a>
                <a href="{{ route('dashboard.forms.export.pdf.summary', $form->id) }}" target="_blank" class="top-action-btn btn-glass-subtle">
                    🖨️ Cetak PDF Rekap
                </a>
                <a href="{{ route('forms.show', $form->slug) }}" target="_blank" class="top-action-btn btn-glass-subtle" style="color: #DFB743; border-color: rgba(223,183,67,0.5);">
                    🌐 Form Publik ➔
                </a>
            </div>

        </div>
    </header>

    <!-- MAIN WORKSPACE -->
    <main style="max-width: 1280px; margin: 1.5rem auto 4rem; padding: 0 1.25rem;">

        <!-- METRICS BAR & TABS -->
        <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 1.15rem 1.4rem; margin-bottom: 1.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                
                <!-- METRICS SUMMARY -->
                <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                    <div>
                        <div style="font-size: 0.6875rem; font-weight: 750; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">
                            Total Respon Masuk
                        </div>
                        <div style="font-size: 1.65rem; font-weight: 800; color: #062E1D; line-height: 1.1; margin-top: 0.15rem;">
                            {{ $responses->count() }}
                            <span style="font-size: 0.8125rem; color: #64748B; font-weight: 600;">Data</span>
                        </div>
                    </div>

                    <div style="height: 34px; width: 1px; background: #E2E8F0;"></div>

                    <div>
                        <div style="font-size: 0.6875rem; font-weight: 750; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">
                            Jumlah Pertanyaan
                        </div>
                        <div style="font-size: 1.2rem; font-weight: 800; color: #0F172A; line-height: 1.2; margin-top: 0.15rem;">
                            {{ $form->fields->count() }} <span style="font-size: 0.75rem; color: #64748B; font-weight: 600;">Butir</span>
                        </div>
                    </div>

                    <div style="height: 34px; width: 1px; background: #E2E8F0;"></div>

                    <div>
                        <div style="font-size: 0.6875rem; font-weight: 750; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">
                            Tanggapan Terakhir
                        </div>
                        <div style="font-size: 0.875rem; font-weight: 750; color: #064E3B; line-height: 1.3; margin-top: 0.2rem;">
                            {{ $responses->first() ? $responses->first()->created_at->format('d/m/Y, H:i') . ' WIB' : 'Belum Ada' }}
                        </div>
                    </div>
                </div>

                <!-- CONTROLS & 3-WAY TAB CAPSULE -->
                <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                    @if(!empty($kelasList) && count($kelasList) > 0)
                        <div style="display: flex; align-items: center; gap: 0.45rem; background: #F1F5F9; border: 1px solid #CBD5E1; padding: 0.3rem 0.65rem; border-radius: 10px;">
                            <span style="font-size: 0.75rem; font-weight: 750; color: #475569;">🏫 Filter Kelas:</span>
                            <select x-model="selectedKelas" 
                                    style="background: #FFFFFF; border: 1px solid #CBD5E1; border-radius: 6px; padding: 0.3rem 0.6rem; font-size: 0.78125rem; font-weight: 700; color: #062E1D; outline: none; cursor: pointer;">
                                <option value="all">Semua Kelas ({{ $responses->count() }})</option>
                                @foreach($kelasList as $k)
                                    <option value="{{ $k }}">{{ $k }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="resp-tab-capsule">
                        <button type="button" 
                                @click="responseTab = 'individual'" 
                                class="resp-tab-btn" 
                                :class="{ 'active': responseTab === 'individual' }">
                            <span>👤</span>
                            <span>Perorangan</span>
                        </button>

                        <button type="button" 
                                @click="responseTab = 'table'" 
                                class="resp-tab-btn" 
                                :class="{ 'active': responseTab === 'table' }">
                            <span>📋</span>
                            <span>Tabel Respon</span>
                        </button>

                        <button type="button" 
                                @click="responseTab = 'summary'" 
                                class="resp-tab-btn" 
                                :class="{ 'active': responseTab === 'summary' }">
                            <span>📊</span>
                            <span>Ringkasan Statistik</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        @if($responses->isEmpty())
            <!-- EMPTY STATE DENGAN KOTAK QUICK SHARE & QR CODE -->
            <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 18px; padding: 2.5rem 2rem; text-align: center; color: #64748B; box-shadow: 0 4px 16px rgba(0,0,0,0.02); max-width: 720px; margin: 0 auto;"
                 x-data="{ copied: false, shareUrl: '{{ route('forms.show', $form->slug) }}' }">
                
                <div style="font-size: 2.75rem; margin-bottom: 0.5rem;">📊</div>
                <h3 style="font-size: 1.25rem; font-weight: 800; color: #062E1D; margin: 0 0 0.35rem;">
                    Belum Ada Tanggapan yang Masuk
                </h3>
                <p style="font-size: 0.84375rem; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.6; color: #64748B;">
                    Kuesioner ini sudah aktif dan siap menerima masukan. Bagikan tautan atau QR Code di bawah kepada peserta PPPJ atau responden.
                </p>

                <!-- QUICK SHARE URL BOX -->
                <div style="background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; text-align: left;">
                    <label style="font-size: 0.72rem; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 0.45rem;">
                        🔗 Tautan Publik Kuesioner:
                    </label>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <input type="text" 
                               readonly 
                               :value="shareUrl" 
                               style="flex: 1; min-width: 260px; background: #FFFFFF; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.55rem 0.85rem; font-size: 0.84375rem; color: #0F172A; font-weight: 600; outline: none;" />
                        <button type="button" 
                                @click="navigator.clipboard.writeText(shareUrl); copied = true; setTimeout(() => copied = false, 2500)"
                                style="background: #062E1D; color: #DFB743; font-weight: 800; font-size: 0.8125rem; padding: 0.55rem 1.2rem; border-radius: 8px; border: 1px solid rgba(223,183,67,0.5); cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem; transition: all 0.15s ease;">
                            <span x-text="copied ? '✅ Berhasil Disalin!' : '📋 Salin Tautan'"></span>
                        </button>
                    </div>
                </div>

                <!-- QR CODE & ACTION BUTTONS -->
                <div style="display: flex; align-items: center; justify-content: center; gap: 2rem; flex-wrap: wrap; margin-bottom: 1rem; border-top: 1px solid #F1F5F9; padding-top: 1.5rem;">
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.4rem;">
                        <div style="background: #FFFFFF; border: 1px solid #CBD5E1; padding: 6px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode(route('forms.show', $form->slug)) }}" 
                                 alt="QR Code" 
                                 style="width: 110px; height: 110px; display: block;" />
                        </div>
                        <a href="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode(route('forms.show', $form->slug)) }}" 
                           target="_blank" 
                           style="font-size: 0.72rem; font-weight: 750; color: #064E3B; text-decoration: underline;">
                            Unduh QR Code HD ↗
                        </a>
                    </div>

                    <div style="text-align: left; max-width: 320px;">
                        <div style="font-size: 0.875rem; font-weight: 800; color: #0F172A; margin-bottom: 0.35rem;">
                            Bisa Dipajang di Layar Kelas
                        </div>
                        <div style="font-size: 0.78125rem; color: #64748B; line-height: 1.5; margin-bottom: 0.85rem;">
                            Peserta dapat langsung memindai (*scan*) QR Code menggunakan kamera ponsel untuk mengisi evaluasi tanpa mengetik tautan.
                        </div>
                        <a href="{{ route('forms.show', $form->slug) }}" target="_blank" 
                           style="background: #F8FAFC; border: 1.5px solid #CBD5E1; color: #0F172A; font-size: 0.78125rem; font-weight: 800; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                            🌐 Uji Buka Formulir ➔
                        </a>
                    </div>
                </div>

            </div>
        @else

            <!-- ============================================================== -->
            <!-- TAB 1: DATA PERORANGAN (MASTER-DETAIL 2-COLUMN DOSSIER VIEW)   -->
            <!-- ============================================================== -->
            <div x-show="responseTab === 'individual'">
                <div class="master-detail-grid">
                    
                    <!-- SISI KIRI: DAFTAR SEMUA RESPONDEN (SEARCHABLE LIST) -->
                    <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                            <span style="font-size: 0.6875rem; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">
                                DAFTAR RESPONDEN ({{ $responses->count() }})
                            </span>
                        </div>

                        <!-- SEARCH INPUT -->
                        <div style="margin-bottom: 0.75rem;">
                            <input type="text" 
                                   x-model="respondentSearch" 
                                   placeholder="🔍 Cari nama peserta..." 
                                   style="width: 100%; background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.45rem 0.65rem; font-size: 0.78125rem; outline: none; box-sizing: border-box;" />
                        </div>

                        <!-- RESPONDENT LIST WITH SLEEK SCROLL -->
                        <div style="max-height: 600px; overflow-y: auto; padding-right: 2px;">
                            @foreach($responses as $rIdx => $rItem)
                                @php
                                    $isCur = ($rIdx === $currentIndex);
                                    $rName = $rItem->respondent_name ?? 'Responden Anonim';
                                @endphp
                                <a href="{{ route('dashboard.forms.responses', ['id' => $form->id, 'index' => $rIdx]) }}" 
                                   class="respondent-nav-item {{ $isCur ? 'active-item' : '' }}"
                                   x-show="(!respondentSearch || '{{ strtolower(addslashes($rName)) }}'.includes(respondentSearch.toLowerCase())) && (selectedKelas === 'all' || '{{ addslashes($rItem->detected_kelas ?? '') }}' === selectedKelas)">
                                    <div style="display: flex; align-items: center; gap: 0.65rem; overflow: hidden;">
                                        <div style="width: 28px; height: 28px; border-radius: 7px; background: {{ $isCur ? '#062E1D' : '#F1F5F9' }}; color: {{ $isCur ? '#DFB743' : '#475569' }}; font-weight: 800; font-size: 0.75rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            {{ $rIdx + 1 }}
                                        </div>
                                        <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            <div style="font-size: 0.8125rem; font-weight: 750; color: {{ $isCur ? '#062E1D' : '#0F172A' }}; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                {{ $rName }}
                                            </div>
                                            <div style="font-size: 0.6875rem; color: #64748B; display: flex; align-items: center; gap: 0.35rem;">
                                                <span>{{ $rItem->created_at->format('d M, H:i') }}</span>
                                                @if(!empty($rItem->detected_kelas))
                                                    <span style="font-size: 0.625rem; font-weight: 750; color: #064E3B; background: #F0FDF4; border: 1px solid #BBF7D0; padding: 0.05rem 0.3rem; border-radius: 4px;">
                                                        {{ $rItem->detected_kelas }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if($isCur)
                                        <span style="font-size: 0.75rem; color: #064E3B; font-weight: 800;">●</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- SISI KANAN: DETAIL LEMBAR JAWABAN RESPONDEN YANG DIPILIH -->
                    <div>
                        @if($currentResponse)
                            <!-- DOSSIER CARD HEADER -->
                            <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 14px; padding: 1.25rem 1.5rem; margin-bottom: 1.25rem; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                                    <div>
                                        <div style="display: flex; align-items: center; gap: 0.45rem; margin-bottom: 0.25rem;">
                                            <span style="font-size: 0.6875rem; font-weight: 800; color: #064E3B; background: #F0FDF4; border: 1px solid #BBF7D0; padding: 0.15rem 0.5rem; border-radius: 5px;">
                                                LEMBAR JAWABAN PESERTA #{{ $currentIndex + 1 }}
                                            </span>
                                            <span style="font-size: 0.6875rem; color: #64748B;">ID: #{{ $currentResponse->id }}</span>
                                        </div>
                                        <h2 style="font-size: 1.2rem; font-weight: 800; color: #062E1D; margin: 0 0 0.25rem;">
                                            {{ $currentResponse->respondent_name ?? 'Responden Anonim' }}
                                            @if($currentResponse->respondent_identifier)
                                                <span style="font-size: 0.84375rem; color: #64748B; font-weight: 600;">({{ $currentResponse->respondent_identifier }})</span>
                                            @endif
                                        </h2>
                                        <div style="font-size: 0.75rem; color: #64748B; display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                                            <span>⏱️ Tanggal: <strong style="color: #1E293B;">{{ $currentResponse->created_at->format('d F Y, H:i') }} WIB</strong></span>
                                            <span>•</span>
                                            <span>🌐 IP: <code>{{ $currentResponse->ip_address ?? '127.0.0.1' }}</code></span>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <!-- PREV & NEXT QUICK BUTTONS -->
                                        <a href="{{ route('dashboard.forms.responses', ['id' => $form->id, 'index' => $currentIndex - 1]) }}" 
                                           style="{{ $currentIndex > 0 ? '' : 'pointer-events: none; opacity: 0.35;' }} background: #F8FAFC; border: 1px solid #CBD5E1; color: #0F172A; font-weight: 750; font-size: 0.78125rem; padding: 0.45rem 0.8rem; border-radius: 8px; text-decoration: none;">
                                            ◀ Sebelumnya
                                        </a>
                                        <a href="{{ route('dashboard.forms.responses', ['id' => $form->id, 'index' => $currentIndex + 1]) }}" 
                                           style="{{ $currentIndex < $responses->count() - 1 ? '' : 'pointer-events: none; opacity: 0.35;' }} background: #F8FAFC; border: 1px solid #CBD5E1; color: #0F172A; font-weight: 750; font-size: 0.78125rem; padding: 0.45rem 0.8rem; border-radius: 8px; text-decoration: none;">
                                            Berikutnya ▶
                                        </a>
                                        <a href="{{ route('dashboard.forms.export.pdf.individual', ['id' => $form->id, 'responseId' => $currentResponse->id]) }}" 
                                           target="_blank" 
                                           style="background: #062E1D; color: #DFB743; font-size: 0.78125rem; font-weight: 750; padding: 0.45rem 0.95rem; border-radius: 8px; text-decoration: none; border: 1px solid rgba(223,183,67,0.4);">
                                            🖨️ Cetak PDF
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- QUESTION & ANSWER STREAM -->
                            <div>
                                @foreach($form->fields as $index => $field)
                                    @php
                                        $fieldData = $currentResponse->answers[$field->field_name] ?? null;
                                        $ans = $fieldData['value'] ?? null;
                                        $reason = $fieldData['reason'] ?? null;
                                        $type = strtolower($field->field_type);
                                    @endphp

                                    <div class="answer-card-item">
                                        <!-- QUESTION HEADER -->
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 0.75rem; margin-bottom: 0.65rem;">
                                            <div style="display: flex; align-items: flex-start; gap: 0.6rem;">
                                                <div class="badge-num">{{ $index + 1 }}</div>
                                                <div>
                                                    @if(!empty($field->category))
                                                        <div style="font-size: 0.6875rem; font-weight: 750; color: #064E3B; text-transform: uppercase; margin-bottom: 0.15rem;">
                                                            📁 {{ $field->category }}
                                                        </div>
                                                    @endif
                                                    <div style="font-size: 0.9375rem; font-weight: 750; color: #0F172A; line-height: 1.4;">
                                                        @formText($field->field_label)
                                                    </div>
                                                </div>
                                            </div>

                                            <span style="font-size: 0.65rem; font-weight: 700; color: #64748B; background: #F1F5F9; border: 1px solid #E2E8F0; padding: 0.15rem 0.5rem; border-radius: 5px; white-space: nowrap; text-transform: uppercase;">
                                                {{ $type }}
                                            </span>
                                        </div>

                                        <!-- ANSWER CONTENT -->
                                        <div style="padding-left: 2.1rem;">
                                            @if(is_array($ans))
                                                @if(isset($ans['url']))
                                                    <!-- FILE -->
                                                    <div style="display: inline-flex; align-items: center; gap: 0.75rem; background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.65rem 0.95rem;">
                                                        <span style="font-size: 1.4rem;">📁</span>
                                                        <div>
                                                            <div style="font-weight: 750; font-size: 0.8125rem; color: #0F172A;">{{ $ans['name'] }}</div>
                                                            <div style="font-size: 0.6875rem; color: #64748B;">{{ $ans['size'] }}</div>
                                                        </div>
                                                        <a href="{{ $ans['url'] }}" target="_blank" style="margin-left: 0.5rem; background: #062E1D; color: #DFB743; font-weight: 750; font-size: 0.72rem; padding: 0.35rem 0.75rem; border-radius: 6px; text-decoration: none;">
                                                            Unduh
                                                        </a>
                                                    </div>
                                                @else
                                                    <!-- MULTIPLE CHECKBOX -->
                                                    <div style="display: flex; flex-wrap: wrap; gap: 0.4rem;">
                                                        @foreach($ans as $subVal)
                                                            @php $cleanSubVal = ltrim(trim($subVal), "• -*\t "); @endphp
                                                            <div style="display: inline-flex; align-items: center; gap: 0.35rem; background: #F0FDF4; border: 1px solid #BBF7D0; color: #064E3B; font-weight: 700; font-size: 0.8125rem; padding: 0.35rem 0.75rem; border-radius: 7px;">
                                                                <span>☑️</span>
                                                                <span>{{ $cleanSubVal }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @elseif($type === 'radio' || $type === 'select')
                                                <!-- SINGLE CHOICE -->
                                                @php $cleanAns = ltrim(trim($ans ?? ''), "• -*\t "); @endphp
                                                <div style="display: inline-flex; align-items: center; gap: 0.45rem; background: #F0FDF4; border: 1px solid #BBF7D0; color: #064E3B; padding: 0.45rem 0.95rem; border-radius: 8px; font-weight: 750; font-size: 0.84375rem;">
                                                    <span>🔘</span>
                                                    <span>{{ !empty($cleanAns) ? $cleanAns : '(Tidak memilih)' }}</span>
                                                </div>
                                            @elseif($type === 'textarea')
                                                <!-- TEXTAREA -->
                                                @php $cleanAns = trim($ans ?? ''); @endphp
                                                <div style="background: #F8FAFC; border-left: 3.5px solid #062E1D; border-top: 1px solid #E2E8F0; border-right: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0; border-radius: 0 8px 8px 0; padding: 0.75rem 1rem; font-size: 0.84375rem; color: #1E293B; line-height: 1.55;">
                                                    {{ !empty($cleanAns) ? $cleanAns : '-' }}
                                                </div>
                                            @else
                                                <!-- SHORT TEXT -->
                                                @php $cleanAns = trim($ans ?? ''); @endphp
                                                <div style="display: inline-flex; align-items: center; gap: 0.45rem; background: #F8FAFC; border: 1px solid #CBD5E1; color: #0F172A; padding: 0.4rem 0.85rem; border-radius: 7px; font-weight: 750; font-size: 0.84375rem;">
                                                    <span>{{ !empty($cleanAns) ? $cleanAns : '-' }}</span>
                                                </div>
                                            @endif

                                            <!-- REASON BOX -->
                                            @if(!empty($reason))
                                                <div style="margin-top: 0.65rem; background: #F8FAFC; border: 1px solid #CBD5E1; border-left: 3.5px solid #C59B27; border-radius: 8px; padding: 0.65rem 0.85rem; font-size: 0.78125rem;">
                                                    <div style="font-weight: 750; color: #78350F; margin-bottom: 0.2rem; display: flex; align-items: center; gap: 0.3rem;">
                                                        <span>💬</span>
                                                        <span>Alasan / Pertimbangan Responden:</span>
                                                    </div>
                                                    <div style="color: #1E293B; line-height: 1.45; font-style: italic;">
                                                        “{{ $reason }}”
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            <!-- ============================================================== -->
            <!-- TAB 2: TABEL SPREADSHEET RESPON (SPREADSHEET GRID)             -->
            <!-- ============================================================== -->
            <div x-show="responseTab === 'table'" style="display: none;">
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 1.25rem; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.75rem;">
                        <div>
                            <h3 style="font-size: 1rem; font-weight: 800; color: #062E1D; margin: 0 0 0.15rem;">
                                📋 Lembar Spreadsheet Data Responden
                            </h3>
                            <div style="font-size: 0.75rem; color: #64748B;">
                                Tampilan tabular menyeluruh seluruh responden untuk audit data cepat.
                            </div>
                        </div>

                        <div>
                            <input type="text" x-model="searchQuery" placeholder="🔍 Cari nama peserta atau jawaban..." style="background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.45rem 0.75rem; font-size: 0.78125rem; outline: none; width: 260px;" />
                        </div>
                    </div>

                    <div style="overflow-x: auto; border: 1px solid #E2E8F0; border-radius: 10px;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.78125rem; text-align: left;">
                            <thead style="background: #062E1D; color: #FFFFFF;">
                                <tr>
                                    <th style="padding: 0.65rem 0.85rem; border-right: 1px solid rgba(255,255,255,0.15); white-space: nowrap; width: 40px;">No</th>
                                    <th style="padding: 0.65rem 0.85rem; border-right: 1px solid rgba(255,255,255,0.15); white-space: nowrap; width: 130px;">Waktu</th>
                                    <th style="padding: 0.65rem 0.85rem; border-right: 1px solid rgba(255,255,255,0.15); white-space: nowrap; width: 150px;">Nama Responden</th>
                                    @foreach($form->fields as $fld)
                                        <th style="padding: 0.65rem 0.85rem; border-right: 1px solid rgba(255,255,255,0.15); min-width: 180px; max-width: 260px;">
                                            {{ $fld->field_label }}
                                        </th>
                                    @endforeach
                                    <th style="padding: 0.65rem 0.85rem; text-align: center; white-space: nowrap; width: 80px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($responses as $idx => $resp)
                                    <tr x-show="(selectedKelas === 'all' || '{{ addslashes($resp->detected_kelas ?? '') }}' === selectedKelas) && (!searchQuery || '{{ strtolower(addslashes(($resp->respondent_name ?? '') . ' ' . json_encode($resp->answers))) }}'.includes(searchQuery.toLowerCase()))"
                                        style="border-bottom: 1px solid #E2E8F0; background: {{ $idx % 2 === 0 ? '#FFFFFF' : '#F8FAFC' }};">
                                        <td style="padding: 0.65rem 0.85rem; font-weight: 800; color: #64748B; border-right: 1px solid #E2E8F0; text-align: center;">
                                            {{ $idx + 1 }}
                                        </td>
                                        <td style="padding: 0.65rem 0.85rem; border-right: 1px solid #E2E8F0; white-space: nowrap; color: #64748B;">
                                            {{ $resp->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td style="padding: 0.65rem 0.85rem; border-right: 1px solid #E2E8F0; font-weight: 750; color: #062E1D; white-space: nowrap;">
                                            <div>{{ $resp->respondent_name ?? 'Anonim' }}</div>
                                            @if(!empty($resp->detected_kelas))
                                                <div style="font-size: 0.65rem; color: #064E3B; font-weight: 700; margin-top: 0.15rem;">
                                                    🏫 {{ $resp->detected_kelas }}
                                                </div>
                                            @endif
                                        </td>
                                        @foreach($form->fields as $fld)
                                            @php
                                                $cell = $resp->answers[$fld->field_name] ?? null;
                                                $cellVal = $cell['value'] ?? '-';
                                                $cellReason = $cell['reason'] ?? null;
                                            @endphp
                                            <td style="padding: 0.65rem 0.85rem; border-right: 1px solid #E2E8F0; color: #1E293B; vertical-align: top;">
                                                @if(is_array($cellVal))
                                                    @if(isset($cellVal['url']))
                                                        <a href="{{ $cellVal['url'] }}" target="_blank" style="color: #064E3B; font-weight: 700; text-decoration: underline;">
                                                            📎 {{ $cellVal['name'] }}
                                                        </a>
                                                    @else
                                                        {{ implode(', ', array_map(function($v){ return ltrim(trim($v), "• -*\t "); }, $cellVal)) }}
                                                    @endif
                                                @else
                                                    {{ ltrim(trim($cellVal ?? '-'), "• -*\t ") }}
                                                @endif

                                                @if(!empty($cellReason))
                                                    <div style="margin-top: 0.25rem; font-size: 0.72rem; color: #064E3B; background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 4px; padding: 0.2rem 0.4rem;">
                                                        💬 <em>"{{ $cellReason }}"</em>
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td style="padding: 0.65rem 0.85rem; text-align: center; white-space: nowrap;">
                                            <a href="{{ route('dashboard.forms.responses', ['id' => $form->id, 'index' => $idx]) }}" 
                                               style="background: #062E1D; color: #DFB743; font-weight: 800; font-size: 0.7rem; padding: 0.3rem 0.6rem; border-radius: 5px; text-decoration: none;">
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
            <!-- TAB 3: RINGKASAN & STATISTIK AGREGAT                           -->
            <!-- ============================================================== -->
            <div x-show="responseTab === 'summary'" style="display: none;">
                <!-- EXECUTIVE HIGHLIGHTS / KEY FINDINGS BOX (KOTAK KESIMPULAN OTOMATIS) -->
                <div style="background: linear-gradient(135deg, #062E1D 0%, #031B11 100%); border: 2px solid #C59B27; border-radius: 16px; padding: 1.5rem 1.75rem; color: #FFFFFF; margin-bottom: 1.5rem; box-shadow: 0 6px 20px rgba(6, 46, 29, 0.25);">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.15rem; border-bottom: 1px solid rgba(223, 183, 67, 0.3); padding-bottom: 0.75rem;">
                        <div style="display: flex; align-items: center; gap: 0.6rem;">
                            <span style="font-size: 1.4rem;">🎯</span>
                            <div>
                                <h3 style="font-size: 1.05rem; font-weight: 800; color: #FFFFFF; margin: 0; letter-spacing: -0.01em;">
                                    Sorotan Analisis Eksekutif (Executive Highlights / Key Findings)
                                </h3>
                                <p style="font-size: 0.75rem; color: #DFB743; margin: 0.15rem 0 0; font-weight: 600;">
                                    Sintesis otomatis evaluasi untuk laporan pimpinan (Kaban Diklat / Kapuslitbang)
                                </p>
                            </div>
                        </div>
                        <span style="background: rgba(223, 183, 67, 0.15); border: 1px solid rgba(223, 183, 67, 0.4); color: #DFB743; font-size: 0.7rem; font-weight: 800; padding: 0.25rem 0.65rem; border-radius: 9999px;">
                            ⚡ Analisis Instan
                        </span>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1rem;">
                        <!-- Card 1: Top Finding / Most Selected -->
                        <div style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 12px; padding: 1rem 1.15rem;">
                            <div style="font-size: 0.7rem; font-weight: 750; color: #DFB743; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">
                                🥇 Mata Kuliah / Usulan Terbanyak
                            </div>
                            @if(!empty($highlights['topFinding']))
                                <div style="font-size: 1.05rem; font-weight: 800; color: #FFFFFF; line-height: 1.35; margin-bottom: 0.25rem;">
                                    {{ $highlights['topFinding']['option'] }}
                                </div>
                                <div style="font-size: 0.75rem; color: #A7F3D0; font-weight: 700;">
                                    {{ $highlights['topFinding']['count'] }} Responden ({{ $highlights['topFinding']['percent'] }}%)
                                </div>
                                <div style="font-size: 0.6875rem; color: #CBD5E1; margin-top: 0.35rem; line-height: 1.3;">
                                    Butir: {{ Str::limit($highlights['topFinding']['question'], 45) }}
                                </div>
                            @else
                                <div style="font-size: 0.85rem; color: #CBD5E1;">Belum cukup data agregat</div>
                            @endif
                        </div>

                        <!-- Card 2: Total Qualitative Reasons -->
                        <div style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 12px; padding: 1rem 1.15rem;">
                            <div style="font-size: 0.7rem; font-weight: 750; color: #DFB743; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">
                                💬 Aspirasi & Catatan Kualitatif
                            </div>
                            <div style="font-size: 1.45rem; font-weight: 800; color: #FFFFFF; line-height: 1.2;">
                                {{ $highlights['totalReasons'] ?? 0 }}
                                <span style="font-size: 0.8rem; color: #CBD5E1; font-weight: 600;">Catatan Alasan</span>
                            </div>
                            <div style="font-size: 0.72rem; color: #A7F3D0; margin-top: 0.35rem;">
                                Masukan kritis tersimpan lengkap untuk evaluasi kurikulum & sarana.
                            </div>
                        </div>

                        <!-- Card 3: Sample Rate / Coverage -->
                        <div style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 12px; padding: 1rem 1.15rem;">
                            <div style="font-size: 0.7rem; font-weight: 750; color: #DFB743; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">
                                📈 Cakupan Partisipasi Siswa
                            </div>
                            <div style="font-size: 1.45rem; font-weight: 800; color: #FFFFFF; line-height: 1.2;">
                                {{ $responses->count() }}
                                <span style="font-size: 0.8rem; color: #CBD5E1; font-weight: 600;">Peserta / Responden</span>
                            </div>
                            <div style="font-size: 0.72rem; color: #A7F3D0; margin-top: 0.35rem;">
                                {{ count($kelasList) > 0 ? count($kelasList) . ' Kelompok Belajar / Kelas terdata' : 'Representasi evaluasi menyeluruh' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                    @foreach($summary as $fn => $data)
                        <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 1.35rem 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid #F1F5F9; padding-bottom: 0.65rem;">
                                <div style="display: flex; align-items: center; gap: 0.45rem;">
                                    <span style="background: #062E1D; color: #DFB743; font-weight: 800; font-size: 0.7rem; padding: 0.15rem 0.5rem; border-radius: 5px;">
                                        #{{ $loop->iteration }}
                                    </span>
                                    <h3 style="font-size: 0.96875rem; font-weight: 750; color: #0F172A; margin: 0;">
                                        @formText($data['label'])
                                    </h3>
                                </div>
                                <span style="font-size: 0.6875rem; font-weight: 700; color: #475569; background: #F1F5F9; border: 1px solid #E2E8F0; padding: 0.15rem 0.5rem; border-radius: 9999px;">
                                    {{ strtoupper($data['type']) }}
                                </span>
                            </div>

                            @if(isset($data['counts']))
                                <div style="display: flex; flex-direction: column; gap: 0.65rem;">
                                    @php
                                        $totalVotes = array_sum($data['counts']);
                                    @endphp
                                    @foreach($data['counts'] as $optName => $count)
                                        @php
                                             $cleanOptName = ltrim(trim($optName), "• -*\t ");
                                             $percent = $totalVotes > 0 ? round(($count / $totalVotes) * 100, 1) : 0;
                                        @endphp
                                        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 9px; padding: 0.65rem 0.85rem;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8125rem; font-weight: 750; color: #1E293B; margin-bottom: 0.35rem;">
                                                <span>{{ $cleanOptName }}</span>
                                                <div style="display: flex; align-items: center; gap: 0.45rem;">
                                                    <span style="font-size: 0.72rem; color: #64748B; font-weight: 600;">{{ $count }} Suara</span>
                                                    <span style="background: #062E1D; color: #DFB743; font-weight: 800; font-size: 0.72rem; padding: 0.1rem 0.45rem; border-radius: 5px;">
                                                        {{ $percent }}%
                                                    </span>
                                                </div>
                                            </div>
                                            <div style="width: 100%; height: 8px; background: #E2E8F0; border-radius: 9999px; overflow: hidden;">
                                                <div style="width: {{ $percent }}%; height: 100%; background: #064E3B; border-radius: 9999px; transition: width 0.5s ease;"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- ACCORDION ALASAN & URAIAN RESPONDEN WITH INSTANT SEARCH -->
                                @if(!empty($data['reasons']))
                                    <div style="margin-top: 1rem; border-top: 1px dashed #CBD5E1; padding-top: 0.85rem;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.65rem; flex-wrap: wrap; gap: 0.5rem;">
                                            <div style="font-size: 0.78125rem; font-weight: 750; color: #064E3B; display: flex; align-items: center; gap: 0.35rem;">
                                                <span>💬</span>
                                                <span>Rincian Alasan Responden ({{ count($data['reasons']) }} Catatan):</span>
                                            </div>
                                            <!-- PENCARIAN CEPAT TEKS ALASAN (SEARCH IN REASONS) -->
                                            <div>
                                                <input type="text" 
                                                       x-model="reasonFilter" 
                                                       placeholder="🔍 Saring alasan (misal: waktu, dosen, praktik)..." 
                                                       style="background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 6px; padding: 0.3rem 0.6rem; font-size: 0.75rem; width: 230px; outline: none;" />
                                            </div>
                                        </div>
                                        <div style="display: flex; flex-direction: column; gap: 0.45rem; max-height: 280px; overflow-y: auto;">
                                            @foreach($data['reasons'] as $rItem)
                                                <div x-show="!reasonFilter || '{{ strtolower(addslashes($rItem['reason'] . ' ' . $rItem['respondent'] . ' ' . $rItem['selected'])) }}'.includes(reasonFilter.toLowerCase())"
                                                     style="background: #F8FAFC; border: 1px solid #E2E8F0; border-left: 3px solid #064E3B; border-radius: 7px; padding: 0.6rem 0.85rem; font-size: 0.78125rem;">
                                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.2rem;">
                                                        <span style="font-weight: 750; color: #062E1D;">
                                                            {{ $rItem['respondent'] }}
                                                        </span>
                                                        <span style="font-size: 0.6875rem; font-weight: 700; color: #475569; background: #F1F5F9; padding: 0.1rem 0.4rem; border-radius: 4px;">
                                                            Pilihan: {{ ltrim(trim($rItem['selected']), "• -*\t ") }}
                                                        </span>
                                                    </div>
                                                    <div style="color: #334155; line-height: 1.45; font-style: italic;">
                                                        "{{ $rItem['reason'] }}"
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                            @elseif(isset($data['samples']))
                                <div style="display: flex; flex-direction: column; gap: 0.45rem; max-height: 250px; overflow-y: auto;">
                                    @forelse($data['samples'] as $sampleText)
                                        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 0.65rem 0.85rem; border-radius: 8px; font-size: 0.8125rem; color: #1E293B; line-height: 1.45;">
                                            {{ $sampleText }}
                                        </div>
                                    @empty
                                        <div style="font-size: 0.78125rem; color: #94A3B8;">Belum ada tanggapan teks yang masuk.</div>
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
