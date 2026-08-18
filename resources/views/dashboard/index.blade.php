@extends('layouts.app')

@section('content')
<div class="dashboard-layout" x-data="{ 
    activeTab: '{{ $activeTab }}',
    isDarkMode: false,
    isNewKajianModalOpen: false,
    isNewUserModalOpen: false,
    isNotificationOpen: false,
    selectedUserEdit: null,
    selectedProposalDisposition: null,
    selectedKajianReview: null,
    selectedKajianRead: null,
    selectedExecSummary: null,
    tableSearchQuery: '',
    activeChapter: 'bab1',
    toggleDarkMode() {
        this.isDarkMode = !this.isDarkMode;
        if (this.isDarkMode) { document.body.classList.add('dark-theme'); }
        else { document.body.classList.remove('dark-theme'); }
    }
}">

    <!-- SIDEBAR NAVIGATION -->
    <div class="sidebar-container">
        <div class="sidebar-header">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo" style="height: 38px;" />
                <div>
                    <div style="font-weight: 800; font-size: 1rem; color: #FFF; line-height: 1.1;">
                        LITBANG MADA
                    </div>
                    <div style="font-size: 0.7rem; color: var(--color-gold-bright); font-weight: 700;">
                        SENAT ADHYAKSA
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="sidebar-nav-item" :class="{ 'active': activeTab === 'dashboard' }" @click="activeTab = 'dashboard'">
                <span>📊 Overview Dashboard</span>
            </div>
            <div class="sidebar-nav-item" :class="{ 'active': activeTab === 'ingestion' || activeTab === 'issues' }" @click="activeTab = 'ingestion'">
                <span>📥 1. Pengajuan (Inbox)</span>
            </div>
            <div class="sidebar-nav-item" :class="{ 'active': activeTab === 'research' }" @click="activeTab = 'research'">
                <span>🔬 2. Dikaji (Studio Kajian)</span>
            </div>
            <div class="sidebar-nav-item" :class="{ 'active': activeTab === 'policy' }" @click="activeTab = 'policy'">
                <span>📑 3. Direspon (Pengesahan)</span>
            </div>
            <div class="sidebar-nav-item" :class="{ 'active': activeTab === 'repository' }" @click="activeTab = 'repository'">
                <span>🔒 4. Publish & Vault</span>
            </div>
            <div class="sidebar-nav-item" :class="{ 'active': activeTab === 'users' }" @click="activeTab = 'users'">
                <span>👥 5. Kelola User & Hak Akses</span>
            </div>
            <div class="sidebar-nav-item" :class="{ 'active': activeTab === 'settings' }" @click="activeTab = 'settings'">
                <span>⚙️ Pengaturan & Kelola Data</span>
            </div>
        </div>

        <div style="padding: 1.25rem; border-top: 1px solid rgba(255,255,255,0.1);">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline btn-full" style="color: #FFF; border-color: rgba(255,255,255,0.2); background: rgba(0,0,0,0.2);">
                    🚪 Keluar Session
                </button>
            </form>
        </div>
    </div>

    <!-- MAIN DASHBOARD CONTENT AREA -->
    <div class="dashboard-main">
        <!-- TOPBAR -->
        <header class="dashboard-topbar">
            <div>
                <h1 style="font-size: 1.375rem; font-weight: 800; color: var(--color-slate-900);">
                    <span x-show="activeTab === 'dashboard'">Overview Ekosistem LITBANG</span>
                    <span x-show="activeTab === 'ingestion' || activeTab === 'issues'">Fase 1: Pengajuan (Inbox Skrining Usulan)</span>
                    <span x-show="activeTab === 'research'">Fase 2: Dikaji (Studio Naskah Dokumen Panjang)</span>
                    <span x-show="activeTab === 'policy'">Fase 3: Direspon (Respon Resmi & Pengesahan Digital)</span>
                    <span x-show="activeTab === 'repository'">Fase 4: Publish & Vault Repositori</span>
                    <span x-show="activeTab === 'users'">Modul Manajemen User & Hak Akses Administrator</span>
                    <span x-show="activeTab === 'settings'">Modul Pengaturan & Management Kategori Data</span>
                </h1>
                <div style="font-size: 0.8125rem; color: var(--color-slate-500); font-weight: 600;">
                    🛡️ Portal Intelijen Riset & Formulasi Kebijakan Strategis Adhyaksa
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 1rem;">
                <!-- NOTIFICATION BELL DROPDOWN -->
                <div style="position: relative;">
                    <button @click="isNotificationOpen = !isNotificationOpen" style="position: relative; background: #F1F5F9; border: 1px solid #CBD5E1; border-radius: 50%; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.125rem;">
                        🔔
                        @if($metrics['ingestionInbox'] > 0)
                            <span style="position: absolute; top: -4px; right: -4px; background: #DC2626; color: #FFF; font-size: 0.6875rem; font-weight: 900; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                {{ $metrics['ingestionInbox'] }}
                            </span>
                        @endif
                    </button>

                    <div x-show="isNotificationOpen" @click.away="isNotificationOpen = false" style="position: absolute; right: 0; top: 50px; width: 320px; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 14px; box-shadow: 0 15px 35px rgba(0,0,0,0.15); z-index: 60; padding: 1.25rem; display: none;">
                        <div style="font-size: 0.875rem; font-weight: 800; color: #0F172A; margin-bottom: 0.75rem; border-bottom: 1px solid #E2E8F0; padding-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center;">
                            <span>Pusat Notifikasi Real-time</span>
                            <span style="font-size: 0.6875rem; background: #EDF7F2; color: #0B3C26; padding: 0.15rem 0.5rem; border-radius: 4px; font-weight: 800;">LIVE</span>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            @if($metrics['ingestionInbox'] > 0)
                                <div style="background: #FFFBF0; border: 1px solid #E8D28B; padding: 0.75rem; border-radius: 8px; font-size: 0.8125rem; color: #0F172A; cursor: pointer;" @click="activeTab = 'ingestion'; isNotificationOpen = false;">
                                    <div style="font-weight: 800; color: #D97706;">📩 {{ $metrics['ingestionInbox'] }} Usulan Publik Baru</div>
                                    <div style="font-size: 0.75rem; color: #475569; margin-top: 2px;">Menunggu skrining & disposisi Admin Sekretariat.</div>
                                </div>
                            @else
                                <div style="font-size: 0.8125rem; color: #64748B; text-align: center; padding: 1rem 0;">Tidak ada notifikasi baru saat ini.</div>
                            @endif
                        </div>
                    </div>
                </div>

                <button onclick="window.print()" class="btn btn-gold" style="font-size: 0.8125rem; padding: 0.5rem 1rem;">
                    📥 Cetak Rekap Laporan
                </button>

                <button @click="toggleDarkMode()" class="btn btn-outline" style="font-size: 0.8125rem;">
                    <span x-text="isDarkMode ? '☀️ Mode Terang' : '🌙 Mode Malam'"></span>
                </button>

                <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.375rem 0.875rem; background-color: var(--color-slate-100); border-radius: 9999px; border: 1px solid var(--color-slate-200);">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background-color: var(--color-primary); color: #FFF; display: flex; align-items: center; justify-content: center; font-weight: 800;">
                        A
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; font-weight: 800; color: var(--color-slate-800);">Admin LITBANG</div>
                        <div style="font-size: 0.6875rem; color: var(--color-slate-500);">Sekretariat Tim Riset</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- DASHBOARD CONTENT SLOT -->
        <div class="dashboard-content">
            <!-- TOAST ALERT -->
            @if(session('toast'))
                <div style="background-color: #0B3C26; color: #FFF; padding: 0.875rem 1.5rem; border-radius: 10px; border: 1px solid #C59B27; font-weight: 700; font-size: 0.875rem;">
                    ✨ {{ session('toast') }}
                </div>
            @endif

            <!-- 1. OVERVIEW DASHBOARD VIEW -->
            <template x-if="activeTab === 'dashboard'">
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    <!-- METRICS GRID 5 -->
                    <div class="metrics-grid-5">
                        <div class="card-metric orange">
                            <div class="metric-lbl">FASE 1: PENGAJUAN</div>
                            <div class="metric-val orange">{{ $metrics['ingestionInbox'] }}</div>
                            <div style="font-size: 0.75rem; color: var(--color-slate-500);">Usulan Masuk</div>
                        </div>

                        <div class="card-metric blue">
                            <div class="metric-lbl">FASE 2: DIKAJI</div>
                            <div class="metric-val blue">{{ $metrics['dalamKajian'] }}</div>
                            <div style="font-size: 0.75rem; color: var(--color-slate-500);">Drafting Dokumen</div>
                        </div>

                        <div class="card-metric gold">
                            <div class="metric-lbl">FASE 3: DIRESPON</div>
                            <div class="metric-val gold">{{ $metrics['dalamReview'] }}</div>
                            <div style="font-size: 0.75rem; color: var(--color-slate-500);">Respon & Pengesahan</div>
                        </div>

                        <div class="card-metric green">
                            <div class="metric-lbl">FASE 4: PUBLISH & VAULT</div>
                            <div class="metric-val green">{{ $metrics['publikasi'] }}</div>
                            <div style="font-size: 0.75rem; color: var(--color-slate-500);">Terbit di Portal</div>
                        </div>

                        <div class="card-metric green">
                            <div class="metric-lbl">USER & HAK AKSES</div>
                            <div class="metric-val green">{{ count($users) }}</div>
                            <div style="font-size: 0.75rem; color: var(--color-slate-500);">User Terdaftar</div>
                        </div>
                    </div>

                    <!-- ANALYTICS CHART SUMMARY BAR -->
                    <div style="background: #FFF; border-radius: 14px; padding: 1.5rem; border: 1px solid var(--color-slate-200); box-shadow: var(--shadow-card);">
                        <h3 style="font-size: 1.0625rem; font-weight: 800; color: var(--color-slate-900); margin-bottom: 1.25rem;">
                            📊 Diagram Distribusi Progres Naskah Kajian
                        </h3>
                        <div style="display: flex; gap: 0.5rem; height: 28px; border-radius: 8px; overflow: hidden; background: #E2E8F0;">
                            <div style="width: 25%; background: #EA580C; display: flex; align-items: center; justify-content: center; color: #FFF; font-size: 0.75rem; font-weight: 900;">25% Pengajuan</div>
                            <div style="width: 35%; background: #0284C7; display: flex; align-items: center; justify-content: center; color: #FFF; font-size: 0.75rem; font-weight: 900;">35% Dikaji</div>
                            <div style="width: 20%; background: #D97706; display: flex; align-items: center; justify-content: center; color: #FFF; font-size: 0.75rem; font-weight: 900;">20% Review</div>
                            <div style="width: 20%; background: #15803D; display: flex; align-items: center; justify-content: center; color: #FFF; font-size: 0.75rem; font-weight: 900;">20% Vault</div>
                        </div>
                    </div>

                    <!-- PIPELINE WORKFLOW STEPPER -->
                    <div class="pipeline-card">
                        <h3 style="font-size: 1.0625rem; font-weight: 800; color: var(--color-slate-900); margin-bottom: 1.25rem;">
                            Visualisasi Pipeline Alur Kerja Terpadu (4 FASE)
                        </h3>

                        <div class="pipeline-flex-row">
                            @foreach($pipelineStages as $index => $stage)
                                <div class="pipeline-node">
                                    <div class="pipeline-num">{{ $index + 1 }}</div>
                                    <div>
                                        <div class="pipeline-text">{{ $stage['label'] }}</div>
                                        <div style="font-size: 0.6875rem; color: var(--color-slate-500); font-weight: 600;">
                                            {{ $stage['count'] }} Item
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- DATA TABLE OPERASIONAL WITH INSTANT LIVE SEARCH -->
                    <div class="table-card-container">
                        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--color-slate-200); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                            <div>
                                <h3 style="font-size: 1.125rem; font-weight: 800; color: var(--color-slate-900);">Tabel Operasional Naskah Kajian Active</h3>
                            </div>
                            
                            <div style="display: flex; gap: 0.75rem; align-items: center;">
                                <input type="text" x-model="tableSearchQuery" placeholder="🔍 Cari instan nama naskah..." style="padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid #CBD5E1; font-size: 0.8125rem; width: 240px;" />
                                <button class="btn btn-primary" @click="isNewKajianModalOpen = true">
                                    ➕ Tambah Kajian Manual
                                </button>
                            </div>
                        </div>

                        <table class="table-clean">
                            <thead>
                                <tr>
                                    <th>Nama Naskah Dokumen</th>
                                    <th>PIC Tim Riset</th>
                                    <th>Review 3-Pintu</th>
                                    <th>Status Tahapan</th>
                                    <th style="text-align: right;">Aksi Naskah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kajianList as $item)
                                    <tr x-show="!tableSearchQuery || '{{ strtolower($item->title) }}'.includes(tableSearchQuery.toLowerCase())">
                                        <td>
                                            <div style="font-weight: 700; color: var(--color-slate-900);">{{ $item->title }}</div>
                                            <div style="font-size: 0.75rem; color: var(--color-gold-bright); font-weight: 800;">No: {{ $item->doc_no }}</div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 700;">{{ $item->pic_team }}</div>
                                        </td>
                                        <td>
                                            <div style="font-size: 0.75rem; font-weight: 700;">
                                                Substansi: {!! $item->review_substansi ? '<span style="color: green;">✔</span>' : '<span style="color: red;">✘</span>' !!} |
                                                Metodologi: {!! $item->review_metodologi ? '<span style="color: green;">✔</span>' : '<span style="color: red;">✘</span>' !!} |
                                                Ketua: {!! $item->signed_by_ketua ? '<span style="color: green;">✔</span>' : '<span style="color: red;">✘</span>' !!}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-pill status-pill-kajian">{{ $item->status }}</span>
                                        </td>
                                        <td style="text-align: right; display: flex; gap: 0.5rem; justify-content: flex-end;">
                                            <button class="btn btn-outline" style="font-size: 0.75rem; padding: 0.25rem 0.625rem;" @click="selectedKajianRead = {{ json_encode($item) }}">
                                                📖 Baca Dokumen
                                            </button>
                                            <button class="btn btn-gold" style="font-size: 0.75rem; padding: 0.25rem 0.625rem;" @click="selectedExecSummary = {{ json_encode($item) }}">
                                                🖨️ Onesheet
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </template>

            <!-- 2. PENGAJUAN VIEW (FASE 1) -->
            <template x-if="activeTab === 'ingestion' || activeTab === 'issues'">
                <div style="background-color: var(--color-white); border-radius: 14px; padding: 2rem; border: 1px solid var(--color-slate-200);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <div>
                            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--color-slate-900);">
                                📥 Fase 1: Pengajuan Isu (Inbox Skrining Usulan)
                            </h2>
                            <p style="font-size: 0.875rem; color: var(--color-slate-500);">
                                Lakukan verifikasi dan disposisi usulan publik ke Tim Riset 1-4.
                            </p>
                        </div>
                    </div>

                    <table class="table-clean">
                        <thead>
                            <tr>
                                <th>No. Tiket & Pengusul</th>
                                <th>Judul Usulan Isu</th>
                                <th>Urgensi</th>
                                <th>Status Skrining</th>
                                <th style="text-align: right;">Aksi Disposisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingProposals as $prop)
                                <tr>
                                    <td>
                                        <div style="font-weight: 800; color: var(--color-gold-bright);">{{ $prop->ticket_no }}</div>
                                        <div style="font-size: 0.8125rem; font-weight: 700;">{{ $prop->name }}</div>
                                        <div style="font-size: 0.75rem; color: var(--color-slate-500);">{{ $prop->institution ?? 'Umum' }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: var(--color-slate-900);">{{ $prop->title }}</div>
                                        <div style="font-size: 0.8125rem; color: var(--color-slate-600); margin-top: 2px;">{{ $prop->description }}</div>
                                    </td>
                                    <td>
                                        <span style="font-size: 0.75rem; font-weight: 800; padding: 0.2rem 0.5rem; border-radius: 4px; background-color: #FEF3C7; color: #D97706;">
                                            {{ $prop->urgency }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-pill status-pill-isu">{{ $prop->status }}</span>
                                    </td>
                                    <td style="text-align: right;">
                                        <button class="btn btn-primary" style="font-size: 0.75rem; padding: 0.35rem 0.75rem;" @click="selectedProposalDisposition = {{ json_encode($prop) }}">
                                            📋 Respon & Disposisi
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </template>

            <!-- 3. DIKAJI VIEW (FASE 2) -->
            <template x-if="activeTab === 'research'">
                <div style="background-color: var(--color-white); border-radius: 14px; padding: 2rem; border: 1px solid var(--color-slate-200);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <div>
                            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--color-slate-900);">
                                🔬 Fase 2: Dikaji (Studio Naskah Dokumen Panjang)
                            </h2>
                            <p style="font-size: 0.875rem; color: var(--color-slate-500);">
                                Penyusunan Naskah Akademis Dokumen Panjang Multi-Bab (BAB I s.d. BAB V).
                            </p>
                        </div>
                        <button class="btn btn-primary" @click="isNewKajianModalOpen = true">
                            ➕ Tambah Naskah Dokumen
                        </button>
                    </div>

                    <table class="table-clean">
                        <thead>
                            <tr>
                                <th>Nama Naskah Dokumen</th>
                                <th>Tim Riset Peneliti</th>
                                <th>Urgensi</th>
                                <th>Status Tahapan</th>
                                <th style="text-align: right;">Aksi Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kajianList as $item)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: var(--color-slate-900);">{{ $item->title }}</div>
                                        <div style="font-size: 0.75rem; color: var(--color-gold-bright); font-weight: 800;">No: {{ $item->doc_no }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; font-size: 0.875rem;">{{ $item->pic_team }}</div>
                                    </td>
                                    <td>
                                        <span style="font-size: 0.75rem; font-weight: 800; padding: 0.2rem 0.5rem; border-radius: 4px; background-color: #FEF3C7; color: #D97706;">
                                            {{ $item->urgency }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-pill status-pill-kajian">{{ $item->status }}</span>
                                    </td>
                                    <td style="text-align: right;">
                                        <button class="btn btn-outline" style="font-size: 0.75rem; padding: 0.35rem 0.75rem;" @click="selectedKajianRead = {{ json_encode($item) }}">
                                            📖 Buka Document Reader
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </template>

            <!-- 4. DIRESPON VIEW (FASE 3) -->
            <template x-if="activeTab === 'policy'">
                <div style="background-color: var(--color-white); border-radius: 14px; padding: 2rem; border: 1px solid var(--color-slate-200);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <div>
                            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--color-slate-900);">
                                📑 Fase 3: Direspon & Pengesahan Digital (Review 3-Pintu)
                            </h2>
                            <p style="font-size: 0.875rem; color: var(--color-slate-500);">
                                Memberikan tanggapan resmi & pengesahan QR Seal Ketua sebelum diterbitkan ke Vault.
                            </p>
                        </div>
                    </div>

                    <table class="table-clean">
                        <thead>
                            <tr>
                                <th>Nama Naskah Policy Brief</th>
                                <th>Status Review 3-Pintu</th>
                                <th>Pengesahan Ketua</th>
                                <th style="text-align: right;">Aksi Pengesahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kajianList as $item)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: var(--color-slate-900);">{{ $item->title }}</div>
                                        <div style="font-size: 0.75rem; color: var(--color-gold-bright); font-weight: 800;">No: {{ $item->doc_no }}</div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.8125rem; font-weight: 700;">
                                            Substansi: {!! $item->review_substansi ? '<span style="color: green;">✔ Lulus</span>' : '<span style="color: red;">✘ Pending</span>' !!}<br />
                                            Metodologi: {!! $item->review_metodologi ? '<span style="color: green;">✔ Lulus</span>' : '<span style="color: red;">✘ Pending</span>' !!}<br />
                                            Legal: {!! $item->review_legal ? '<span style="color: green;">✔ Lulus</span>' : '<span style="color: red;">✘ Pending</span>' !!}
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->signed_by_ketua)
                                            <span style="font-size: 0.75rem; font-weight: 800; color: #16A34A; background-color: #DCFCE7; padding: 0.2rem 0.6rem; border-radius: 4px;">
                                                ✒️ QR SEAL DISAHKAN
                                            </span>
                                        @else
                                            <span style="font-size: 0.75rem; font-weight: 800; color: #D97706; background-color: #FEF3C7; padding: 0.2rem 0.6rem; border-radius: 4px;">
                                                ⏳ BELUM DISAHKAN
                                            </span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">
                                        <button class="btn btn-gold" style="font-size: 0.75rem; padding: 0.35rem 0.75rem;" @click="selectedKajianReview = {{ json_encode($item) }}">
                                            📝 Checklist & Terbitkan
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </template>

            <!-- 5. PUBLISH & VAULT VIEW (FASE 4) -->
            <template x-if="activeTab === 'repository'">
                <div style="background-color: var(--color-white); border-radius: 14px; padding: 2rem; border: 1px solid var(--color-slate-200);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <div>
                            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--color-slate-900);">
                                🔒 Fase 4: Publish & Archival Vault Repositori
                            </h2>
                            <p style="font-size: 0.875rem; color: var(--color-slate-500);">
                                Repositori terenkripsi kekayaan intelektual hasil riset yang tersimpan permanen antar-kepengurusan.
                            </p>
                        </div>
                    </div>

                    <table class="table-clean">
                        <thead>
                            <tr>
                                <th>No. Dokumen & Judul Vault</th>
                                <th>Capaian Utama Dampak</th>
                                <th>Statistik Download</th>
                                <th style="text-align: right;">Aksi Vault</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kajianList->where('status', 'Publish & Vault') as $item)
                                <tr>
                                    <td>
                                        <div style="font-size: 0.75rem; font-weight: 800; color: var(--color-gold-bright);">{{ $item->doc_no }}</div>
                                        <div style="font-weight: 800; color: var(--color-slate-900);">{{ $item->title }}</div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem; font-weight: 900; color: #0B3C26;">{{ $item->impact_score ?? 'Rp 4.2 Triliun' }}</div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.8125rem; font-weight: 700; color: var(--color-slate-600);">{{ $item->downloads_count }}</div>
                                    </td>
                                    <td style="text-align: right;">
                                        <button class="btn btn-primary" style="font-size: 0.75rem; padding: 0.35rem 0.75rem;" @click="selectedKajianRead = {{ json_encode($item) }}">
                                            📖 Buka File Vault
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </template>

            <!-- 6. USER MANAGEMENT TAB VIEW -->
            <template x-if="activeTab === 'users'">
                <div style="background-color: var(--color-white); border-radius: 14px; padding: 2rem; border: 1px solid var(--color-slate-200);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <div>
                            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--color-slate-900);">
                                👥 Modul Manajemen User & Hak Akses Administrator
                            </h2>
                            <p style="font-size: 0.875rem; color: var(--color-slate-500);">
                                Kelola akun tim riset, reviewer akademis, reset password, dan wewenang pengesahan digital.
                            </p>
                        </div>
                        <button class="btn btn-primary" @click="isNewUserModalOpen = true">
                            ➕ Tambah User Akun Baru
                        </button>
                    </div>

                    <table class="table-clean">
                        <thead>
                            <tr>
                                <th>Nama User Pengguna</th>
                                <th>Alamat Email (Username)</th>
                                <th>Peran (Role) Akses</th>
                                <th>Tim Riset / Unit</th>
                                <th style="text-align: right;">Aksi Akun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $usr)
                                <tr>
                                    <td>
                                        <div style="font-weight: 800; color: var(--color-slate-900);">{{ $usr->name }}</div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem; color: var(--color-slate-600);">{{ $usr->email }}</div>
                                    </td>
                                    <td>
                                        <span class="status-pill status-pill-policy" style="font-size: 0.75rem;">
                                            {{ $usr->role ?? 'Tim Riset Peneliti' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.8125rem; font-weight: 700; color: var(--color-slate-700);">
                                            {{ $usr->team ?? 'Sekretariat Utama' }}
                                        </div>
                                    </td>
                                    <td style="text-align: right; display: flex; gap: 0.5rem; justify-content: flex-end;">
                                        <button class="btn btn-gold" style="font-size: 0.75rem; padding: 0.25rem 0.625rem;" @click="selectedUserEdit = {{ json_encode($usr) }}">
                                            ✏️ Edit Role / Pass
                                        </button>
                                        <form action="{{ route('dashboard.users.destroy', $usr->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline" style="font-size: 0.75rem; padding: 0.25rem 0.625rem; color: #DC2626; border-color: #FCA5A5;">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </template>

            <!-- 7. SETTINGS VIEW -->
            <template x-if="activeTab === 'settings'">
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    <!-- MANAGE CATEGORIES -->
                    <div style="background-color: var(--color-white); border-radius: 14px; padding: 2rem; border: 1px solid var(--color-slate-200);">
                        <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--color-slate-900); margin-bottom: 1.5rem;">
                            🏷️ Kelola & Hapus Kategori Domain Hukum Dinamis
                        </h2>

                        <form action="{{ route('dashboard.store_category') }}" method="POST" style="display: flex; gap: 1rem; align-items: flex-end; margin-bottom: 2rem; background-color: #F8FAFC; padding: 1.25rem; border-radius: 10px; border: 1px solid #E2E8F0;">
                            @csrf
                            <div style="flex: 1;">
                                <label style="font-size: 0.8125rem; font-weight: 700; color: var(--color-slate-700);">Nama Kategori Domain *</label>
                                <input type="text" name="name" required placeholder="Contoh: Pengawasan Etik & Anti-Korupsi" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid var(--color-slate-300);" />
                            </div>
                            <div style="flex: 1;">
                                <label style="font-size: 0.8125rem; font-weight: 700; color: var(--color-slate-700);">Deskripsi Ringkas</label>
                                <input type="text" name="description" placeholder="Uraian fokus domain..." style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid var(--color-slate-300);" />
                            </div>
                            <button type="submit" class="btn btn-primary" style="font-size: 0.875rem;">➕ Tambah Kategori</button>
                        </form>

                        <table class="table-clean">
                            <thead>
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th>Slug</th>
                                    <th>Deskripsi Domain</th>
                                    <th style="text-align: right;">Aksi Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $cat)
                                    <tr>
                                        <td>
                                            <div style="font-weight: 800; color: var(--color-slate-900);">{{ $cat->name }}</div>
                                        </td>
                                        <td>
                                            <div style="font-size: 0.8125rem; color: var(--color-slate-500);">{{ $cat->slug }}</div>
                                        </td>
                                        <td>
                                            <div style="font-size: 0.8125rem; color: var(--color-slate-600);">{{ $cat->description }}</div>
                                        </td>
                                        <td style="text-align: right;">
                                            <form action="{{ route('dashboard.destroy_category', $cat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline" style="font-size: 0.75rem; padding: 0.25rem 0.625rem; color: #DC2626; border-color: #FCA5A5;">
                                                    🗑️ Hapus Kategori
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- CONFIGURATION -->
                    <div style="background-color: var(--color-white); border-radius: 14px; padding: 2rem; border: 1px solid var(--color-slate-200);">
                        <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--color-slate-900); margin-bottom: 1.5rem;">
                            ⚙️ Konfigurasi Kelembagaan & Master Reset Data
                        </h2>

                        <form action="{{ route('dashboard.update_settings') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem; margin-bottom: 2.5rem;">
                            @csrf
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                                <div>
                                    <label style="font-size: 0.8125rem; font-weight: 700; color: var(--color-slate-700);">Nama Resmi Institusi</label>
                                    <input type="text" name="institution_name" value="{{ $setting->institution_name }}" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid var(--color-slate-300);" />
                                </div>

                                <div>
                                    <label style="font-size: 0.8125rem; font-weight: 700; color: var(--color-slate-700);">Periode Kepengurusan</label>
                                    <input type="text" name="period" value="{{ $setting->period }}" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid var(--color-slate-300);" />
                                </div>
                            </div>

                            <div>
                                <label style="font-size: 0.8125rem; font-weight: 700; color: var(--color-slate-700);">Tagline Visi Kelembagaan</label>
                                <input type="text" name="tagline" value="{{ $setting->tagline }}" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid var(--color-slate-300);" />
                            </div>

                            <button type="submit" class="btn btn-gold" style="align-self: flex-end;">💾 Simpan Seluruh Pengaturan</button>
                        </form>

                        <hr style="border: none; border-top: 1px solid #E2E8F0; margin: 1.5rem 0;" />

                        <div style="background-color: #FEF2F2; padding: 1.5rem; border-radius: 10px; border: 1.5px solid #FCA5A5; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-size: 0.875rem; font-weight: 800; color: #991B1B;">⚠️ DANGER ZONE: KOSONGKAN SELURUH DATA USULAN & KAJIAN</div>
                                <div style="font-size: 0.8125rem; color: #7F1D1D;">Menghapus seluruh data usulan publik dan naskah kajian simulasi dalam database.</div>
                            </div>
                            <form action="{{ route('dashboard.reset_data') }}" method="POST" onsubmit="return confirm('PERINGATAN! Apakah Anda yakin ingin menghapus/kosongkan seluruh data simulasi?')">
                                @csrf
                                <button type="submit" class="btn btn-outline" style="background-color: #DC2626; color: #FFF; border: none; font-size: 0.8125rem;">
                                    🔥 Reset & Kosongkan Data
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- PRINTABLE EXECUTIVE SUMMARY SHEET MODAL (1-PAGE ONESHEET IN DASHBOARD) -->
    <div x-show="selectedExecSummary !== null" class="modal-overlay" style="display: none;" @click="selectedExecSummary = null">
        <div class="modal-card" style="max-width: 820px; width: 95%; background: #FFF; color: #0F172A; border-radius: 16px; padding: 3rem 3.5rem; font-family: var(--font-body); position: relative; box-shadow: var(--shadow-paper);" @click.stop>
            
            <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px double #072718; padding-bottom: 1.25rem; margin-bottom: 1.75rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo Emblem" style="height: 64px;" />
                    <div>
                        <h2 style="font-size: 1.25rem; font-weight: 900; color: #072718; font-family: var(--font-heading);">SENAT GAJAH MADA ADHYAKSA</h2>
                        <div style="font-size: 0.75rem; font-weight: 800; color: #C59B27; letter-spacing: 0.06em;">LEMBAGA PENELITIAN & PENGEMBANGAN STRATEGIS (LITBANG)</div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.75rem; font-weight: 800; color: #072718; text-transform: uppercase;">EXECUTIVE SUMMARY SHEET</div>
                    <div style="font-size: 0.8125rem; font-weight: 800; color: #C59B27;" x-text="selectedExecSummary ? selectedExecSummary.doc_no : ''"></div>
                </div>
            </div>

            <h1 style="font-size: 1.25rem; font-weight: 900; color: #072718; margin-bottom: 1.25rem; line-height: 1.35;" x-text="selectedExecSummary ? selectedExecSummary.title : ''"></h1>

            <div style="background: #EDF7F2; border-left: 4px solid #072718; padding: 1rem 1.25rem; border-radius: 0 8px 8px 0; margin-bottom: 1.5rem;">
                <div style="font-size: 0.75rem; font-weight: 900; color: #072718; text-transform: uppercase;">RINGKASAN EKSEKUTIF UTAMA</div>
                <p style="font-size: 0.875rem; color: #1E293B; line-height: 1.6; margin-top: 4px;" x-text="selectedExecSummary ? selectedExecSummary.summary : ''"></p>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <div style="font-size: 0.8125rem; font-weight: 900; color: #072718; text-transform: uppercase; margin-bottom: 0.5rem;">FORMULASI REKOMENDASI TAKTIS</div>
                <ul style="font-size: 0.84375rem; color: #334155; padding-left: 1.25rem; display: flex; flex-direction: column; gap: 0.5rem;">
                    <li><strong>Penyempurnaan Regulasi:</strong> Pembentukan Petunjuk Teknis Jaksa Agung Penanganan Perampasan Aset Perdata.</li>
                    <li><strong>Akselerasi Operasional:</strong> Integrasi Basis Data Pelacakan Aset Terpusat dengan PPATK dan Pajak.</li>
                    <li><strong>Pelatihan Terpadu:</strong> Sertifikasi Jaksa Pengacara Negara dalam audit transaksi keuangan modern.</li>
                </ul>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #E2E8F0; padding-top: 1.25rem; margin-top: 2rem;">
                <div style="font-size: 0.75rem; color: #16A34A; font-weight: 800;">
                    ✔ VERIFIED QR SEAL (STAMPED EXECUTIVE WHITE PAPER)
                </div>
                <div style="display: flex; gap: 0.75rem;">
                    <button class="btn btn-gold" onclick="window.print()">🖨️ Cetak Lembar Ini</button>
                    <button class="btn btn-outline" @click="selectedExecSummary = null">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT USER -->
    <div x-show="selectedUserEdit !== null" class="modal-overlay" style="display: none;" @click="selectedUserEdit = null">
        <div class="modal-card" style="max-width: 600px;" @click.stop>
            <div style="padding: 1.25rem 1.75rem; background-color: var(--color-primary); color: #FFF; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.125rem; font-weight: 800; color: #FFF;">Edit User & Reset Password</h3>
                <button @click="selectedUserEdit = null" style="background: none; border: none; color: #FFF; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>

            <form :action="'{{ url('/dashboard/users/update') }}/' + (selectedUserEdit ? selectedUserEdit.id : '')" method="POST" style="padding: 1.75rem; display: flex; flex-direction: column; gap: 1.25rem;">
                @csrf
                <div>
                    <label style="font-size: 0.8125rem; font-weight: 700;">Nama Lengkap Pengguna *</label>
                    <input type="text" name="name" required :value="selectedUserEdit ? selectedUserEdit.name : ''" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid #CBD5E1;" />
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700;">Email (Username) *</label>
                        <input type="email" name="email" required :value="selectedUserEdit ? selectedUserEdit.email : ''" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid #CBD5E1;" />
                    </div>

                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700;">Reset Password (Opsional)</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid #CBD5E1;" />
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700;">Role / Peran Akses *</label>
                        <select name="role" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid #CBD5E1;">
                            <option value="Super Admin" :selected="selectedUserEdit && selectedUserEdit.role === 'Super Admin'">Super Admin Sekretariat</option>
                            <option value="Tim Riset Peneliti" :selected="selectedUserEdit && selectedUserEdit.role === 'Tim Riset Peneliti'">Tim Riset Peneliti</option>
                            <option value="Reviewer Penguji" :selected="selectedUserEdit && selectedUserEdit.role === 'Reviewer Penguji'">Reviewer Penguji Akademis</option>
                            <option value="Ketua Tim Riset" :selected="selectedUserEdit && selectedUserEdit.role === 'Ketua Tim Riset'">Ketua Tim Riset (Pengesahan QR Seal)</option>
                        </select>
                    </div>

                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700;">Tim Riset / Unit</label>
                        <select name="team" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid #CBD5E1;">
                            <option value="Sekretariat Utama" :selected="selectedUserEdit && selectedUserEdit.team === 'Sekretariat Utama'">Sekretariat Utama</option>
                            <option value="Tim Riset 1 (Pidsus & Ekonomi)" :selected="selectedUserEdit && selectedUserEdit.team === 'Tim Riset 1 (Pidsus & Ekonomi)'">Tim Riset 1 (Pidsus & Ekonomi)</option>
                            <option value="Tim Riset 2 (Cyber & Digital)" :selected="selectedUserEdit && selectedUserEdit.team === 'Tim Riset 2 (Cyber & Digital)'">Tim Riset 2 (Cyber & Digital)</option>
                            <option value="Tim Riset 3 (SPBE & Birokrasi)" :selected="selectedUserEdit && selectedUserEdit.team === 'Tim Riset 3 (SPBE & Birokrasi)'">Tim Riset 3 (SPBE & Birokrasi)</option>
                            <option value="Tim Riset 4 (Pengawasan & Etik)" :selected="selectedUserEdit && selectedUserEdit.team === 'Tim Riset 4 (Pengawasan & Etik)'">Tim Riset 4 (Pengawasan & Etik)</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                    <button type="button" class="btn btn-outline" @click="selectedUserEdit = null">Batal</button>
                    <button type="submit" class="btn btn-gold">💾 Update User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL NEW USER -->
    <div x-show="isNewUserModalOpen" class="modal-overlay" style="display: none;" @click="isNewUserModalOpen = false">
        <div class="modal-card" style="max-width: 600px;" @click.stop>
            <div style="padding: 1.25rem 1.75rem; background-color: var(--color-primary); color: #FFF; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.125rem; font-weight: 800; color: #FFF;">Tambah User Akun Administrator Baru</h3>
                <button @click="isNewUserModalOpen = false" style="background: none; border: none; color: #FFF; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>

            <form action="{{ route('dashboard.users.store') }}" method="POST" style="padding: 1.75rem; display: flex; flex-direction: column; gap: 1.25rem;">
                @csrf
                <div>
                    <label style="font-size: 0.8125rem; font-weight: 700;">Nama Lengkap Pengguna *</label>
                    <input type="text" name="name" required placeholder="Contoh: Dr. Supriyadi, S.H., M.H." style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid #CBD5E1;" />
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700;">Email (Username) *</label>
                        <input type="email" name="email" required placeholder="nama@mada-adhyaksa.go.id" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid #CBD5E1;" />
                    </div>

                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700;">Password Akun *</label>
                        <input type="password" name="password" required placeholder="Minimal 6 Karakter" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid #CBD5E1;" />
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700;">Role / Peran Akses *</label>
                        <select name="role" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid #CBD5E1;">
                            <option value="Super Admin">Super Admin Sekretariat</option>
                            <option value="Tim Riset Peneliti">Tim Riset Peneliti</option>
                            <option value="Reviewer Penguji">Reviewer Penguji Akademis</option>
                            <option value="Ketua Tim Riset">Ketua Tim Riset (Pengesahan QR Seal)</option>
                        </select>
                    </div>

                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700;">Tim Riset / Unit</label>
                        <select name="team" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid #CBD5E1;">
                            <option value="Sekretariat Utama">Sekretariat Utama</option>
                            <option value="Tim Riset 1 (Pidsus & Ekonomi)">Tim Riset 1 (Pidsus & Ekonomi)</option>
                            <option value="Tim Riset 2 (Cyber & Digital)">Tim Riset 2 (Cyber & Digital)</option>
                            <option value="Tim Riset 3 (SPBE & Birokrasi)">Tim Riset 3 (SPBE & Birokrasi)</option>
                            <option value="Tim Riset 4 (Pengawasan & Etik)">Tim Riset 4 (Pengawasan & Etik)</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                    <button type="button" class="btn btn-outline" @click="isNewUserModalOpen = false">Batal</button>
                    <button type="submit" class="btn btn-gold">💾 Simpan Akun User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL NEW KAJIAN -->
    <div x-show="isNewKajianModalOpen" class="modal-overlay" style="display: none;" @click="isNewKajianModalOpen = false">
        <div class="modal-card" style="max-width: 620px;" @click.stop>
            <div style="padding: 1.25rem 1.75rem; background-color: var(--color-primary); color: #FFF; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.125rem; font-weight: 800; color: #FFF;">Tambah Naskah Dokumen Baru</h3>
                <button @click="isNewKajianModalOpen = false" style="background: none; border: none; color: #FFF; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>

            <form action="{{ route('dashboard.store_kajian') }}" method="POST" style="padding: 1.75rem; display: flex; flex-direction: column; gap: 1.25rem;">
                @csrf
                <div>
                    <label style="font-size: 0.8125rem; font-weight: 700;">Judul Kajian *</label>
                    <input type="text" name="title" required placeholder="Judul Naskah Dokumen Panjang..." style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid #CBD5E1;" />
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700;">Pilih Tim Riset *</label>
                        <select name="pic_team" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid #CBD5E1;">
                            <option value="Tim Riset 1 (Pidsus & Ekonomi)">Tim Riset 1 (Pidsus & Ekonomi)</option>
                            <option value="Tim Riset 2 (Cyber & Digital)">Tim Riset 2 (Cyber & Digital)</option>
                            <option value="Tim Riset 3 (SPBE & Birokrasi)">Tim Riset 3 (SPBE & Birokrasi)</option>
                            <option value="Tim Riset 4 (Pengawasan & Etik)">Tim Riset 4 (Pengawasan & Etik)</option>
                        </select>
                    </div>

                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700;">Kategori Domain *</label>
                        <select name="category" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid #CBD5E1;">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label style="font-size: 0.8125rem; font-weight: 700;">Uraian Ringkasan Kajian *</label>
                    <textarea name="summary" rows="3" required style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid #CBD5E1;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                    <button type="button" class="btn btn-outline" @click="isNewKajianModalOpen = false">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Kajian</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DISPOSISI & RESPON RESMI USULAN PUBLIK -->
    <div x-show="selectedProposalDisposition !== null" class="modal-overlay" style="display: none;" @click="selectedProposalDisposition = null">
        <div class="modal-card" style="max-width: 600px;" @click.stop>
            <div style="padding: 1.25rem 1.5rem; background-color: var(--color-primary); color: #FFF; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.125rem; font-weight: 800; color: #FFF;">Respon & Disposisi Usulan Publik</h3>
                <button @click="selectedProposalDisposition = null" style="background: none; border: none; color: #FFF; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>

            <form :action="'{{ url('/dashboard/disposition') }}/' + (selectedProposalDisposition ? selectedProposalDisposition.id : '')" method="POST" style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem;">
                @csrf
                <div>
                    <div style="font-size: 0.75rem; font-weight: 800; color: var(--color-gold-bright);" x-text="selectedProposalDisposition ? selectedProposalDisposition.ticket_no : ''"></div>
                    <div style="font-size: 1rem; font-weight: 800; color: var(--color-slate-900);" x-text="selectedProposalDisposition ? selectedProposalDisposition.title : ''"></div>
                </div>

                <div>
                    <label style="font-size: 0.875rem; font-weight: 700;">Keputusan Admin Sekretariat:</label>
                    <select name="action" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid var(--color-slate-300);">
                        <option value="approve">Setujui & Disposisi ke Tim Riset</option>
                        <option value="reject">Tolak Usulan</option>
                    </select>
                </div>

                <div>
                    <label style="font-size: 0.875rem; font-weight: 700;">Disposisi ke Tim Riset:</label>
                    <select name="disposition_team" style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid var(--color-slate-300);">
                        <option value="Tim Riset 1 (Pidsus & Ekonomi)">Tim Riset 1 (Pidsus & Ekonomi)</option>
                        <option value="Tim Riset 2 (Cyber & Digital)">Tim Riset 2 (Cyber & Digital)</option>
                        <option value="Tim Riset 3 (SPBE & Birokrasi)">Tim Riset 3 (SPBE & Birokrasi)</option>
                        <option value="Tim Riset 4 (Pengawasan & Etik)">Tim Riset 4 (Pengawasan & Etik)</option>
                    </select>
                </div>

                <div>
                    <label style="font-size: 0.875rem; font-weight: 700;">Tanggapan / Respon Resmi Tim Riset (Dibaca Pengusul):</label>
                    <textarea name="official_response" rows="3" placeholder="Tuliskan respon resmi tim riset..." style="width: 100%; padding: 0.625rem; border-radius: 6px; border: 1px solid var(--color-slate-300); font-size: 0.875rem;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                    <button type="button" class="btn btn-outline" @click="selectedProposalDisposition = null">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Disposisi & Respon</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL REVIEW 3-PINTU -->
    <div x-show="selectedKajianReview !== null" class="modal-overlay" style="display: none;" @click="selectedKajianReview = null">
        <div class="modal-card" style="max-width: 580px;" @click.stop>
            <div style="padding: 1.25rem 1.75rem; background-color: #072718; color: #FFF; border-bottom: 2px solid #C59B27; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.125rem; font-weight: 800; color: #FFF;">Checklist Verifikasi 3-Pintu Review</h3>
                <button @click="selectedKajianReview = null" style="background: none; border: none; color: #FFF; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>

            <form :action="'{{ url('/dashboard/update-review') }}/' + (selectedKajianReview ? selectedKajianReview.id : '')" method="POST" style="padding: 1.75rem; display: flex; flex-direction: column; gap: 1.25rem;">
                @csrf
                <div>
                    <div style="font-size: 0.75rem; font-weight: 800; color: #C59B27;">NASKAH KAJIAN</div>
                    <div style="font-size: 1rem; font-weight: 800; color: #0F172A;" x-text="selectedKajianReview ? selectedKajianReview.title : ''"></div>
                </div>

                <div style="background-color: #F8FAFC; padding: 1.25rem; border-radius: 10px; border: 1px solid #E2E8F0; display: flex; flex-direction: column; gap: 0.875rem;">
                    <label style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem; font-weight: 700; cursor: pointer;">
                        <input type="checkbox" name="review_substansi" value="1" :checked="selectedKajianReview && selectedKajianReview.review_substansi" style="width: 18px; height: 18px;" />
                        <span>Pintu 1: Verifikasi Substansi & Relevansi Hukum</span>
                    </label>

                    <label style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem; font-weight: 700; cursor: pointer;">
                        <input type="checkbox" name="review_metodologi" value="1" :checked="selectedKajianReview && selectedKajianReview.review_metodologi" style="width: 18px; height: 18px;" />
                        <span>Pintu 2: Audit Metodologi & Kebenaran Data</span>
                    </label>

                    <label style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem; font-weight: 700; cursor: pointer;">
                        <input type="checkbox" name="review_legal" value="1" :checked="selectedKajianReview && selectedKajianReview.review_legal" style="width: 18px; height: 18px;" />
                        <span>Pintu 3: Verifikasi Legalitas & Etik</span>
                    </label>

                    <hr style="border: none; border-top: 1px solid #CBD5E1; margin: 0.25rem 0;" />

                    <label style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem; font-weight: 800; color: #0B3C26; cursor: pointer;">
                        <input type="checkbox" name="signed_by_ketua" value="1" :checked="selectedKajianReview && selectedKajianReview.signed_by_ketua" style="width: 18px; height: 18px;" />
                        <span>✒️ Pengesahan Digital Ketua Tim Riset (QR Seal)</span>
                    </label>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                    <button type="button" class="btn btn-outline" @click="selectedKajianReview = null">Batal</button>
                    <button type="submit" class="btn btn-gold">Simpan Checklist & Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
