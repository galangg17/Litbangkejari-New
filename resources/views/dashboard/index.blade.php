@extends('layouts.app')

@section('content')
<style>
  .dashboard-layout {
    display: flex;
    min-height: 100vh;
    background-color: #F8FAFC;
    color: #0F172A;
    font-family: 'Plus Jakarta Sans', sans-serif;
    width: 100%;
    box-sizing: border-box;
  }

  /* SUB-TAB BUTTON STYLING (SLEEK PILL CONTROLS) */
  .subtab-btn {
    padding: 0.55rem 1.15rem !important;
    font-size: 0.78125rem !important;
    border-radius: 9999px !important;
    border: 1.5px solid #E2E8F0 !important;
    cursor: pointer !important;
    font-weight: 700 !important;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
    background: #F8FAFC !important;
    color: #475569 !important;
    outline: none !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.35rem !important;
  }
  .subtab-btn:hover {
    background: #E2E8F0 !important;
    color: #0F172A !important;
    border-color: #CBD5E1 !important;
  }
  .subtab-btn.active-policy {
    background: #072718 !important;
    color: #D4AF37 !important;
    font-weight: 900 !important;
    border-color: #C59B27 !important;
    box-shadow: 0 4px 12px rgba(7,39,24,0.3) !important;
  }
  .subtab-btn.active-innovation {
    background: #0284C7 !important;
    color: #FFFFFF !important;
    font-weight: 900 !important;
    border-color: #0284C7 !important;
    box-shadow: 0 4px 12px rgba(2,132,199,0.3) !important;
  }
  .subtab-btn.active-curriculum {
    background: #16A34A !important;
    color: #FFFFFF !important;
    font-weight: 900 !important;
    border-color: #16A34A !important;
    box-shadow: 0 4px 12px rgba(22,163,74,0.3) !important;
  }

  /* DISPOSITION ACTION BUTTON STYLING (MODAL) */
  .disposition-act-btn {
    padding: 0.65rem 0.875rem !important;
    border-radius: 10px !important;
    border: 1.5px solid #CBD5E1 !important;
    font-size: 0.78125rem !important;
    font-weight: 800 !important;
    cursor: pointer !important;
    background: #F8FAFC !important;
    color: #475569 !important;
    transition: all 0.2s ease !important;
    outline: none !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 0.35rem !important;
  }
  .disposition-act-btn:hover {
    border-color: #94A3B8 !important;
    background: #F1F5F9 !important;
    color: #0F172A !important;
  }
  .disposition-act-btn.active-accept {
    background: #072718 !important;
    color: #D4AF37 !important;
    font-weight: 900 !important;
    border-color: #072718 !important;
    box-shadow: 0 4px 12px rgba(7,39,24,0.25) !important;
  }
  .disposition-act-btn.active-reject {
    background: #DC2626 !important;
    color: #FFFFFF !important;
    font-weight: 900 !important;
    border-color: #B91C1C !important;
    box-shadow: 0 4px 12px rgba(220,38,38,0.25) !important;
  }
  .disposition-act-btn.active-create-kajian {
    background: #0284C7 !important;
    color: #FFFFFF !important;
    font-weight: 900 !important;
    border-color: #0369A1 !important;
    box-shadow: 0 4px 12px rgba(2,132,199,0.25) !important;
  }
  .disposition-act-btn.active-create-innovation {
    background: #86198F !important;
    color: #FFFFFF !important;
    font-weight: 900 !important;
    border-color: #701A75 !important;
    box-shadow: 0 4px 12px rgba(134,25,143,0.25) !important;
  }

  .sidebar-container {
    width: 270px;
    background: #072718;
    border-right: 1.5px solid rgba(197, 155, 39, 0.35);
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    position: sticky;
    top: 0;
    height: 100vh;
    z-index: 40;
    box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
  }

  .sidebar-header {
    padding: 1.35rem 1.125rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.2);
  }

  .sidebar-menu {
    padding: 1.125rem 0.75rem;
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
    flex: 1;
    overflow-y: auto;
  }

  .sidebar-section-title {
    font-size: 0.65rem;
    font-weight: 800;
    color: #D4AF37;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 0.75rem 0.75rem 0.25rem;
  }

  .menu-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    color: #CBD5E1;
    font-weight: 700;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .menu-item:hover {
    color: #FFFFFF;
    background: rgba(255, 255, 255, 0.08);
  }

  .menu-item.active {
    background: linear-gradient(135deg, rgba(212,175,55,0.25) 0%, rgba(197,155,39,0.12) 100%);
    border-left: 4px solid #D4AF37;
    color: #D4AF37;
    font-weight: 900;
  }

  .main-content {
    flex: 1;
    padding: 2rem;
    overflow-y: auto;
    max-width: calc(100vw - 270px);
    box-sizing: border-box;
  }

  .topbar-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    padding: 1.25rem 1.75rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.75rem;
    box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
    flex-wrap: wrap;
    gap: 1rem;
  }

  .welcome-banner {
    background: linear-gradient(135deg, #072718 0%, #0B3C26 60%, #13543A 100%);
    border: 1.5px solid #C59B27;
    border-radius: 20px;
    padding: 1.75rem 2rem;
    color: #FFFFFF;
    margin-bottom: 1.75rem;
    box-shadow: 0 12px 30px rgba(7, 39, 24, 0.2);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.25rem;
    position: relative;
    overflow: hidden;
  }

  /* GLASSMORPHISM & MODAL ANIMATION */
  @keyframes modalScaleUp {
    from { opacity: 0; transform: scale(0.95) translateY(-10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
  }

  .modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(4, 20, 11, 0.72) !important;
    backdrop-filter: blur(8px) !important;
    -webkit-backdrop-filter: blur(8px) !important;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 1.5rem;
  }

  .modal-card {
    animation: modalScaleUp 0.22s cubic-bezier(0.16, 1, 0.3, 1) !important;
    box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.45) !important;
  }

  /* CUSTOM EXECUTIVE SCROLLBARS */
  ::-webkit-scrollbar {
    width: 6px;
    height: 6px;
  }
  ::-webkit-scrollbar-track {
    background: #F1F5F9;
    border-radius: 4px;
  }
  ::-webkit-scrollbar-thumb {
    background: #CBD5E1;
    border-radius: 4px;
  }
  ::-webkit-scrollbar-thumb:hover {
    background: #94A3B8;
  }

  .stat-card-executive {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 18px;
    padding: 1.35rem 1.5rem;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
    position: relative;
    overflow: hidden;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .stat-card-executive:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
  }

  .content-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 18px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
    margin-bottom: 1.75rem;
  }

  .light-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.8125rem;
  }

  .light-table th {
    padding: 0.875rem 1rem;
    text-align: left;
    background: #F8FAFC;
    color: #334155;
    font-weight: 800;
    border-bottom: 2px solid #E2E8F0;
    text-transform: uppercase;
    font-size: 0.6875rem;
    letter-spacing: 0.06em;
  }

  .light-table td {
    padding: 0.95rem 1rem;
    border-bottom: 1px solid #F1F5F9;
    color: #1E293B;
    vertical-align: middle;
    transition: background 0.15s ease;
  }

  .light-table tr:hover td {
    background: #F1F5F9;
  }

  .badge-light {
    display: inline-flex;
    align-items: center;
    padding: 0.2rem 0.6rem;
    border-radius: 9999px;
    font-size: 0.6875rem;
    font-weight: 800;
  }

  .pipeline-step-box {
    background: #F8FAFC;
    border: 1.5px solid #E2E8F0;
    border-radius: 14px;
    padding: 1.125rem;
    text-align: center;
    position: relative;
    transition: all 0.2s;
  }

  .pipeline-step-box:hover {
    border-color: #C59B27;
    background: #FFFBF0;
  }

  @media (max-width: 992px) {
    .dashboard-layout { flex-direction: column; }
    .sidebar-container { width: 100%; height: auto; position: relative; }
    .main-content { max-width: 100%; padding: 1rem; }
  }
</style>

<div class="dashboard-layout" x-data="{ 
    activeTab: '{{ $activeTab }}',
    inboxSubTab: 'policy',
    previewPdfUrl: null,
    rejectionReasonText: '',
    isNewKajianModalOpen: false,
    isNewUserModalOpen: false,
    isNewInnovationModalOpen: false,
    isNewCurriculumModalOpen: false,
    isNewFormFieldModalOpen: false,
    selectedUserEdit: null,
    selectedProposalDisposition: null,
    selectedSubmissionFullView: null,
    selectedKajianEdit: null,
    selectedInnovationEdit: null,
    selectedCurriculumEdit: null,
    curriculumsMap: {{ json_encode($curriculumsMap) }},
    tableSearchQuery: '',
    openSubmissionFullView(idOrProp) {
        let prop = null;
        if (typeof idOrProp === 'object' && idOrProp !== null) {
            prop = idOrProp;
        } else if (this.proposalsMap) {
            prop = this.proposalsMap[idOrProp] || this.proposalsMap['' + idOrProp];
            if (!prop) {
                const keys = Object.keys(this.proposalsMap);
                if (keys.length > 0) {
                    prop = this.proposalsMap[keys[0]];
                }
            }
        }
        if (!prop) {
            prop = {
                ticket_no: 'USUL-2026-101',
                name: 'Dr. Hendra Wijaya, S.H.',
                institution: 'Kejaksaan Negeri',
                category: 'Pidana & SPBE',
                status: 'Penyusunan Naskah Studio',
                title: 'Formulasi Perlindungan Hukum & Inovasi SPBE',
                description: 'Uraian dan berkas lampiran usulan peserta yang telah disetujui.',
                file_name: 'Usulan_Peserta.pdf',
                file_path: '/documents/pb_01.pdf'
            };
        }
        this.selectedSubmissionFullView = prop;
    },
    policyBriefsMap: {{ json_encode($kajianList->keyBy('id')) }},
    innovationsMap: {{ json_encode($innovations->keyBy('id')) }},
    proposalsMap: {{ json_encode($pendingProposals->keyBy('id')) }},
    kajianProposalsMap: {{ json_encode($kajianProposalsMap) }},
    innovationProposalsMap: {{ json_encode($innovationProposalsMap) }},
    usersMap: {{ json_encode($users->keyBy('id')) }}
}">

    <!-- SIDEBAR NAVIGATION -->
    <div class="sidebar-container">
        <div class="sidebar-header">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo" style="height: 42px; width: auto; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));" />
                <div>
                    <div style="font-weight: 900; font-size: 0.8125rem; color: #FFF; line-height: 1.15;">
                        LITBANG GAJAH MADA ADHYAKSA
                    </div>
                    <div style="font-size: 0.65rem; color: #D4AF37; font-weight: 800; text-transform: uppercase; margin-top: 2px;">
                        PORTAL SYSTEM RISET & KURIKULUM
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="sidebar-section-title">UTAMA & DASHBOARD</div>
            <div class="menu-item" :class="{ 'active': activeTab === 'dashboard' }" @click="activeTab = 'dashboard'">
                <span>📊 Overview Dashboard</span>
            </div>
            <div class="menu-item" :class="{ 'active': activeTab === 'ingestion' }" @click="activeTab = 'ingestion'">
                <span>📥 Inbox Usulan ({{ $metrics['ingestionInbox'] }})</span>
            </div>

            <div class="sidebar-section-title" style="margin-top: 0.5rem;">3 PILAR MANAJEMEN PENGETAHUAN</div>
            <div class="menu-item" :class="{ 'active': activeTab === 'policy' }" @click="activeTab = 'policy'">
                <span>📄 Policy Brief Studio</span>
            </div>
            <div class="menu-item" :class="{ 'active': activeTab === 'innovations' }" @click="activeTab = 'innovations'">
                <span>💡 Kelola Bank Inovasi</span>
            </div>
            <div class="menu-item" :class="{ 'active': activeTab === 'curriculums' }" @click="activeTab = 'curriculums'">
                <span>📚 Kurikulum & Vault Materi</span>
            </div>

            <div class="sidebar-section-title" style="margin-top: 0.5rem;">SISTEM & HAK AKSES</div>
            <div class="menu-item" :class="{ 'active': activeTab === 'users' }" @click="activeTab = 'users'">
                <span>👥 Kelola User & Hak Akses</span>
            </div>
            <div class="menu-item" :class="{ 'active': activeTab === 'settings' }" @click="activeTab = 'settings'">
                <span>⚙️ Pengaturan PIN & Form Builder</span>
            </div>
        </div>

        <div style="padding: 1rem 1.125rem; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.75rem; color: #94A3B8; background: rgba(0,0,0,0.25);">
            <div>Admin: <strong style="color: #FFF;">{{ session('user_name', 'Tim Riset & Inovasi (Admin)') }}</strong></div>
            <div style="margin-top: 4px; font-size: 0.71875rem; color: #D4AF37;">🔑 PIN Angkatan: <strong>{{ $setting->batch_passcode }}</strong></div>
            <form action="{{ route('logout') }}" method="POST" style="margin-top: 0.75rem;">
                @csrf
                <button type="submit" style="width: 100%; font-size: 0.75rem; padding: 0.4rem; color: #FCA5A5; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 8px; font-weight: 800; cursor: pointer;">
                    🚪 Keluar Admin
                </button>
            </form>
        </div>
    </div>

    <!-- MAIN DASHBOARD CONTENT AREA -->
    <div class="main-content">
        
        <!-- TOPBAR HEADER CARD -->
        <div class="topbar-card">
            <div>
                <h1 style="font-size: 1.35rem; font-weight: 900; color: #0F172A; line-height: 1.2;">Portal Kontrol Admin Litbang Gajah Mada Adhyaksa</h1>
                <div style="font-size: 0.8125rem; color: #64748B; margin-top: 3px;">Pusat Komando 3 Pilar: Policy Brief, Bank Inovasi, & Kurikulum Pembelajaran</div>
            </div>

            <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                <button onclick="window.print()" style="background: #F1F5F9; border: 1.5px solid #CBD5E1; color: #0F172A; font-weight: 800; font-size: 0.78125rem; padding: 0.6rem 1.15rem; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem;">
                    🖨️ Cetak Laporan Eksekutif
                </button>
                <a href="{{ route('landing.index') }}" target="_blank" style="background: linear-gradient(135deg, #072718 0%, #0B3C26 100%); color: #D4AF37; font-weight: 900; font-size: 0.78125rem; padding: 0.6rem 1.25rem; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 12px rgba(7,39,24,0.2);">
                    🌐 Lihat Portal Public
                </a>
            </div>
        </div>

        @if(session('toast'))
            <div style="background: #ECFDF5; border: 1.5px solid #10B981; color: #065F46; font-weight: 800; padding: 0.875rem 1.25rem; border-radius: 14px; margin-bottom: 1.75rem; box-shadow: 0 4px 12px rgba(16,185,129,0.15);">
                ✨ {{ session('toast') }}
            </div>
        @endif

        <!-- TAB 1: OVERVIEW DASHBOARD (ULTRA-EXECUTIVE REDESIGN) -->
        <div x-show="activeTab === 'dashboard'">
            
            <!-- EXECUTIVE WELCOME HERO BANNER -->
            <div class="welcome-banner">
                <div style="max-width: 600px; z-index: 2;">
                    <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(212, 175, 55, 0.18); border: 1px solid #D4AF37; color: #D4AF37; font-size: 0.6875rem; font-weight: 900; padding: 0.25rem 0.75rem; border-radius: 9999px; text-transform: uppercase; margin-bottom: 0.75rem;">
                        <span>🏛️ COMMAND CENTER ANGKATAN GAJAH MADA</span>
                    </div>
                    <h2 style="font-size: 1.45rem; font-weight: 900; color: #FFFFFF; line-height: 1.25; margin-bottom: 0.5rem;">
                        Selamat Datang, Tim Riset & Inovasi!
                    </h2>
                    <p style="font-size: 0.8125rem; color: #CBD5E1; line-height: 1.6;">
                        Portal komando manajemen pengetahuan terpadu. Pantau usulan baru, sahkan QR Seal Policy Brief, dan kelola materi kurikulum PPPJ.
                    </p>
                </div>

                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; z-index: 2;">
                    <button style="background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%); color: #04140B; font-weight: 900; font-size: 0.78125rem; padding: 0.6rem 1.125rem; border-radius: 10px; border: none; cursor: pointer; box-shadow: 0 6px 16px rgba(0,0,0,0.3);" @click="activeTab = 'ingestion'">
                        📥 Skrining Usulan Baru
                    </button>
                    <button style="background: rgba(255,255,255,0.12); border: 1.5px solid rgba(255,255,255,0.3); color: #FFF; font-weight: 800; font-size: 0.78125rem; padding: 0.6rem 1.125rem; border-radius: 10px; cursor: pointer;" @click="activeTab = 'settings'">
                        ⚙️ Atur PIN Angkatan
                    </button>
                </div>
            </div>

            <!-- EXECUTIVE METRIC KPI CARDS -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; margin-bottom: 1.75rem;">
                
                <!-- CARD 1: INBOX -->
                <div class="stat-card-executive" style="border-left: 4px solid #C59B27;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <div style="font-size: 0.71875rem; color: #64748B; font-weight: 800; text-transform: uppercase;">📥 INBOX USULAN</div>
                            <div style="font-size: 2.25rem; font-weight: 900; color: #072718; margin-top: 4px; line-height: 1;">{{ $metrics['ingestionInbox'] }}</div>
                            <div style="font-size: 0.71875rem; color: #C59B27; font-weight: 700; margin-top: 8px;">
                                ⏳ Menunggu Skrining Admin
                            </div>
                        </div>
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: #FFFBF0; border: 1.5px solid #C59B27; color: #C59B27; font-size: 1.2rem; display: flex; align-items: center; justify-content: center;">
                            📥
                        </div>
                    </div>
                </div>

                <!-- CARD 2: POLICY BRIEF -->
                <div class="stat-card-executive" style="border-left: 4px solid #0284C7;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <div style="font-size: 0.71875rem; color: #64748B; font-weight: 800; text-transform: uppercase;">📄 POLICY BRIEF</div>
                            <div style="font-size: 2.25rem; font-weight: 900; color: #0284C7; margin-top: 4px; line-height: 1;">{{ $metrics['policyCount'] }}</div>
                            <div style="font-size: 0.71875rem; color: #0284C7; font-weight: 700; margin-top: 8px;">
                                📜 Naskah Akademis Terbit
                            </div>
                        </div>
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: #E0F2FE; border: 1.5px solid #0284C7; color: #0284C7; font-size: 1.2rem; display: flex; align-items: center; justify-content: center;">
                            📄
                        </div>
                    </div>
                </div>

                <!-- CARD 3: BANK INOVASI -->
                <div class="stat-card-executive" style="border-left: 4px solid #86198F;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <div style="font-size: 0.71875rem; color: #64748B; font-weight: 800; text-transform: uppercase;">💡 BANK INOVASI</div>
                            <div style="font-size: 2.25rem; font-weight: 900; color: #86198F; margin-top: 4px; line-height: 1;">{{ $metrics['innovationCount'] }}</div>
                            <div style="font-size: 0.71875rem; color: #86198F; font-weight: 700; margin-top: 8px;">
                                ✨ Inovasi Teruji & Inkubasi
                            </div>
                        </div>
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: #FDF4FF; border: 1.5px solid #86198F; color: #86198F; font-size: 1.2rem; display: flex; align-items: center; justify-content: center;">
                            💡
                        </div>
                    </div>
                </div>

                <!-- CARD 4: KURIKULUM -->
                <div class="stat-card-executive" style="border-left: 4px solid #16A34A;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <div style="font-size: 0.71875rem; color: #64748B; font-weight: 800; text-transform: uppercase;">📚 KURIKULUM MATERI</div>
                            <div style="font-size: 2.25rem; font-weight: 900; color: #16A34A; margin-top: 4px; line-height: 1;">{{ $metrics['curriculumCount'] }}</div>
                            <div style="font-size: 0.71875rem; color: #16A34A; font-weight: 700; margin-top: 8px;">
                                🎓 Modul & Slide Pembelajaran
                            </div>
                        </div>
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: #DCFCE7; border: 1.5px solid #16A34A; color: #16A34A; font-size: 1.2rem; display: flex; align-items: center; justify-content: center;">
                            📚
                        </div>
                    </div>
                </div>

            </div>

            <!-- CHART.JS ANALYTICS DASHBOARD CARD -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; margin-bottom: 1.75rem;">
                <!-- CHART 1: SEBARAN KATEGORI HUKUM (DONUT CHART) -->
                <div class="content-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div>
                            <h3 style="font-size: 0.9375rem; font-weight: 900; color: #0F172A;">📊 Sebaran Usulan per Kategori Hukum</h3>
                            <p style="font-size: 0.71875rem; color: #64748B;">Proporsi usulan riset berdasarkan domain kejaksaan</p>
                        </div>
                    </div>
                    <div style="position: relative; height: 210px; width: 100%;">
                        <canvas id="categoryDonutChart"></canvas>
                    </div>
                </div>

                <!-- CHART 2: SEBARAN STATUS LIFECYCLE (BAR CHART) -->
                <div class="content-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div>
                            <h3 style="font-size: 0.9375rem; font-weight: 900; color: #0F172A;">📈 Progres Status Tahapan Kajian</h3>
                            <p style="font-size: 0.71875rem; color: #64748B;">Jumlah dokumen pada setiap alur 4-stage pipeline</p>
                        </div>
                    </div>
                    <div style="position: relative; height: 210px; width: 100%;">
                        <canvas id="statusBarChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- VISUAL PIPELINE FLOW MATRIX -->
            <div class="content-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.5rem;">
                    <div>
                        <h3 style="font-size: 1.0625rem; font-weight: 900; color: #0F172A;">Matriks Alur 4-Stage Formulasi Riset & Kebijakan</h3>
                        <div style="font-size: 0.75rem; color: #64748B;">Sistematika pengolahan usulan internal dari masuk hingga pengesahan QR Seal</div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    @foreach($pipelineStages as $stg)
                        <div class="pipeline-step-box">
                            <div style="font-size: 0.6875rem; font-weight: 900; color: #C59B27; text-transform: uppercase; margin-bottom: 0.25rem;">
                                {{ $stg['label'] }}
                            </div>
                            <div style="font-size: 1.5rem; font-weight: 900; color: #0F172A; margin: 4px 0;">
                                {{ $stg['count'] }} <span style="font-size: 0.8125rem; color: #64748B; font-weight: 600;">Dokumen</span>
                            </div>
                            <div style="width: 100%; background: #E2E8F0; height: 6px; border-radius: 9999px; overflow: hidden; margin-top: 0.5rem;">
                                <div style="width: {{ min(100, max(20, $stg['count'] * 25)) }}%; background: linear-gradient(135deg, #072718 0%, #C59B27 100%); height: 100%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- DUAL GRID: INBOX QUEUE & QUICK COMMAND CENTER -->
            <div style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 1.5rem;">
                
                <!-- LEFT SIDE: INCOMING PROPOSALS QUEUE -->
                <div class="content-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h3 style="font-size: 1rem; font-weight: 900; color: #0F172A;">📥 Usulan Terbaru Masuk</h3>
                        <button style="background: none; border: none; color: #0284C7; font-weight: 800; font-size: 0.75rem; cursor: pointer;" @click="activeTab = 'ingestion'">
                            Lihat Semua Usulan →
                        </button>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        @foreach($pendingProposals->take(3) as $prop)
                            <div style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 12px; padding: 1rem; display: flex; justify-content: space-between; align-items: center; gap: 0.75rem;">
                                <div>
                                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                        <span style="font-size: 0.6875rem; font-weight: 900; color: #072718; background: #FEF3C7; padding: 0.15rem 0.45rem; border-radius: 4px;">{{ $prop->ticket_no }}</span>
                                        <span style="font-size: 0.6875rem; color: #64748B; font-weight: 700;">{{ $prop->name }}</span>
                                    </div>
                                    <div style="font-size: 0.8125rem; font-weight: 800; color: #0F172A; line-height: 1.3;">{{ $prop->title }}</div>
                                </div>
                                <button style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.71875rem; padding: 0.4rem 0.75rem; border-radius: 8px; border: none; cursor: pointer; white-space: nowrap;" @click="selectedProposalDisposition = proposalsMap[{{ $prop->id }}]">
                                    ⚙️ Disposisi
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- RIGHT SIDE: QUICK COMMAND CENTER BUTTONS -->
                <div class="content-card" style="border-top: 4px solid #072718;">
                    <h3 style="font-size: 1rem; font-weight: 900; color: #072718; margin-bottom: 1rem;">⚡ Pintasan Tindakan Admin</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 0.65rem;">
                        <button style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 10px; padding: 0.75rem 1rem; text-align: left; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='#C59B27'" onmouseout="this.style.borderColor='#E2E8F0'" @click="isNewKajianModalOpen = true">
                            <div>
                                <div style="font-size: 0.8125rem; font-weight: 800; color: #0F172A;">📄 + Buat Policy Brief Baru</div>
                                <div style="font-size: 0.71875rem; color: #64748B;">Penerbitan naskah akademis multi-bab</div>
                            </div>
                            <span>→</span>
                        </button>

                        <button style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 10px; padding: 0.75rem 1rem; text-align: left; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='#0284C7'" onmouseout="this.style.borderColor='#E2E8F0'" @click="isNewInnovationModalOpen = true">
                            <div>
                                <div style="font-size: 0.8125rem; font-weight: 800; color: #0F172A;">💡 + Tambah Inovasi Teruji</div>
                                <div style="font-size: 0.71875rem; color: #64748B;">Katalog inovasi digital & birokrasi</div>
                            </div>
                            <span>→</span>
                        </button>

                        <button style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 10px; padding: 0.75rem 1rem; text-align: left; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='#16A34A'" onmouseout="this.style.borderColor='#E2E8F0'" @click="isNewCurriculumModalOpen = true">
                            <div>
                                <div style="font-size: 0.8125rem; font-weight: 800; color: #0F172A;">📚 + Upload Modul Kurikulum</div>
                                <div style="font-size: 0.71875rem; color: #64748B;">Simpan modul PPPJ & slide materi</div>
                            </div>
                            <span>→</span>
                        </button>

                        <button style="background: #FFFBF0; border: 1.5px solid #C59B27; border-radius: 10px; padding: 0.75rem 1rem; text-align: left; display: flex; align-items: center; justify-content: space-between; cursor: pointer;" @click="activeTab = 'settings'">
                            <div>
                                <div style="font-size: 0.8125rem; font-weight: 900; color: #072718;">🔑 Ubah PIN Akses Angkatan</div>
                                <div style="font-size: 0.71875rem; color: #C59B27; font-weight: 700;">PIN Aktif: {{ $setting->batch_passcode }}</div>
                            </div>
                            <span>⚙️</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- AUDIT LOG ACTIVITY FEED (LOG CATATAN AKTIVITAS ADMIN) -->
            <div class="content-card" style="margin-top: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <div>
                        <h3 style="font-size: 0.9375rem; font-weight: 900; color: #0F172A;">📜 Log Histori Aktivitas Admin & Sekretariat</h3>
                        <p style="font-size: 0.71875rem; color: #64748B;">Rekam jejak tindakan disposisi, verifikasi, dan ekspor data</p>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    @forelse($auditLogs as $log)
                        <div style="display: flex; justify-content: space-between; align-items: center; background: #F8FAFC; border: 1px solid #E2E8F0; padding: 0.6rem 0.875rem; border-radius: 8px;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <span style="font-size: 0.75rem; font-weight: 900; color: #072718; background: #FEF3C7; padding: 0.2rem 0.5rem; border-radius: 6px;">{{ $log->action }}</span>
                                <div>
                                    <div style="font-size: 0.78125rem; font-weight: 800; color: #0F172A;">{{ $log->details }}</div>
                                    <div style="font-size: 0.6875rem; color: #64748B;">Oleh: <strong>{{ $log->user_name }}</strong> {{ $log->target_ticket ? '| Tiket: ' . $log->target_ticket : '' }}</div>
                                </div>
                            </div>
                            <span style="font-size: 0.6875rem; color: #94A3B8; font-weight: 700;">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div style="text-align: center; color: #94A3B8; padding: 1rem; font-size: 0.78125rem;">Belum ada histori aktivitas admin tercatat.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- TAB 2: INBOX SKRINING USULAN & BERKAS (3 SUB-TABS KATEGORI STAGE) -->
        <div x-show="activeTab === 'ingestion'" style="display: none;">
            <div class="content-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.75rem;">
                    <div>
                        <h3 style="font-size: 1.1rem; font-weight: 900; color: #0F172A;">📥 Inbox Skrining Usulan & Berkas Masuk</h3>
                        <p style="font-size: 0.78125rem; color: #64748B;">Periksa usulan baru, pantau progres penyusunan tim riset, dan verifikasi modul kurikulum.</p>
                    </div>

                    <!-- SUB-TAB NAVIGATION PILLS -->
                    <div style="display: flex; gap: 0.35rem; background: #F1F5F9; padding: 0.35rem; border-radius: 12px; border: 1.5px solid #CBD5E1; flex-wrap: wrap;">
                        <button type="button" class="subtab-btn" :class="{ 'active-policy': inboxSubTab === 'new' || inboxSubTab === 'policy' }" @click="inboxSubTab = 'policy'">
                            📄 Policy Brief ({{ $newProposals->where('type', '!=', 'Ide Inovasi')->count() }})
                        </button>
                        <button type="button" class="subtab-btn" :class="{ 'active-innovation': inboxSubTab === 'innovation' }" @click="inboxSubTab = 'innovation'">
                            💡 Usulan Inovasi ({{ $newProposals->where('type', 'Ide Inovasi')->count() }})
                        </button>
                        <button type="button" class="subtab-btn" :class="{ 'active-curriculum': inboxSubTab === 'curriculum' }" @click="inboxSubTab = 'curriculum'">
                            📚 Kurikulum Peserta ({{ $pendingCurriculums->count() }})
                        </button>
                        <button type="button" class="subtab-btn" :class="{ 'active-policy': inboxSubTab === 'study' }" @click="inboxSubTab = 'study'">
                            ✅ Diterima ({{ $activeStudyProposals->count() }})
                        </button>
                        <button type="button" class="subtab-btn" :class="{ 'active-reject': inboxSubTab === 'rejected' }" @click="inboxSubTab = 'rejected'">
                            🚫 Ditolak ({{ $rejectedProposals->count() }})
                        </button>
                    </div>
                </div>

                <!-- INSTANT LIVE SEARCH & FILTER BAR -->
                <div style="margin-bottom: 1.25rem; display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                    <div style="position: relative; flex: 1; min-width: 240px;">
                        <input type="text" x-model="tableSearchQuery" placeholder="🔍 Cari Nomor Dokumen, Nama Pengusul, atau Judul..." style="width: 100%; padding: 0.55rem 0.875rem; font-size: 0.8125rem; border: 1.5px solid #CBD5E1; border-radius: 10px; outline: none; color: #0F172A;" />
                    </div>
                    <button type="button" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-size: 0.78125rem; font-weight: 700; padding: 0.55rem 0.875rem; border-radius: 10px; cursor: pointer;" @click="tableSearchQuery = ''">
                        Reset Filter
                    </button>
                </div>

                <!-- SUB-TAB 1: USULAN POLICY BRIEF (MENUNGGU SKRINING) -->
                <div x-show="inboxSubTab === 'new' || inboxSubTab === 'policy'">
                    <table class="light-table">
                        <thead>
                            <tr>
                                <th>No. Dokumen / Tiket</th>
                                <th>Pengusul & Instansi</th>
                                <th>Judul Usulan Naskah</th>
                                <th>Kategori Hukum</th>
                                <th>Berkas Pengusul</th>
                                <th style="text-align: right;">Aksi Inspeksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($newProposals->where('type', '!=', 'Ide Inovasi') as $prop)
                                <tr x-show="tableSearchQuery === '' || '{{ strtolower($prop->ticket_no . ' ' . $prop->name . ' ' . $prop->title . ' ' . $prop->category) }}'.includes(tableSearchQuery.toLowerCase())">
                                    <td>
                                        <div style="font-weight: 900; color: #072718;">{{ $prop->ticket_no }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 800; color: #0F172A; font-size: 0.8125rem;">{{ $prop->name }}</div>
                                        <div style="font-size: 0.71875rem; color: #64748B;">{{ $prop->institution ?? 'Kejaksaan RI' }}</div>
                                    </td>
                                    <td style="color: #0F172A; font-weight: 700;">{{ $prop->title }}</td>
                                    <td>
                                        <span class="badge-light" style="background: #FEF3C7; color: #92400E;">
                                            📄 Policy Brief | {{ $prop->category }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($prop->file_path)
                                            <a href="{{ $prop->file_path }}" target="_blank" style="font-size: 0.75rem; font-weight: 800; color: #0284C7; text-decoration: underline;">📄 Berkas PDF</a>
                                        @else
                                            <span style="font-size: 0.71875rem; color: #94A3B8;">Tanpa file</span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">
                                        <button type="button" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.75rem; padding: 0.45rem 0.875rem; border-radius: 8px; border: none; cursor: pointer;" @click="selectedProposalDisposition = proposalsMap[{{ $prop->id }}]">
                                            🔍 Inspeksi & Disposisi
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 2rem; color: #94A3B8;">Tidak ada usulan Policy Brief baru yang menunggu skrining.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- SUB-TAB 2: USULAN IDE INOVASI (MENUNGGU SKRINING) -->
                <div x-show="inboxSubTab === 'innovation'" style="display: none;">
                    <table class="light-table">
                        <thead>
                            <tr>
                                <th>No. Dokumen / Tiket</th>
                                <th>Pengusul & Instansi</th>
                                <th>Judul Gagasan Inovasi</th>
                                <th>Kategori Domain</th>
                                <th>Berkas Concept Note</th>
                                <th style="text-align: right;">Aksi Inspeksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($newProposals->where('type', 'Ide Inovasi') as $prop)
                                <tr x-show="tableSearchQuery === '' || '{{ strtolower($prop->ticket_no . ' ' . $prop->name . ' ' . $prop->title . ' ' . $prop->category) }}'.includes(tableSearchQuery.toLowerCase())">
                                    <td>
                                        <div style="font-weight: 900; color: #0369A1;">{{ $prop->ticket_no }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 800; color: #0F172A; font-size: 0.8125rem;">{{ $prop->name }}</div>
                                        <div style="font-size: 0.71875rem; color: #64748B;">{{ $prop->institution ?? 'Kejaksaan RI' }}</div>
                                    </td>
                                    <td style="color: #0F172A; font-weight: 700;">{{ $prop->title }}</td>
                                    <td>
                                        <span class="badge-light" style="background: #E0F2FE; color: #0369A1;">
                                            💡 Ide Inovasi | {{ $prop->category }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($prop->file_path)
                                            <a href="{{ $prop->file_path }}" target="_blank" style="font-size: 0.75rem; font-weight: 800; color: #0284C7; text-decoration: underline;">📄 Concept Note PDF</a>
                                        @else
                                            <span style="font-size: 0.71875rem; color: #94A3B8;">Tanpa file</span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">
                                        <button type="button" style="background: #0284C7; color: #FFF; font-weight: 900; font-size: 0.75rem; padding: 0.45rem 0.875rem; border-radius: 8px; border: none; cursor: pointer;" @click="selectedProposalDisposition = proposalsMap[{{ $prop->id }}]">
                                            🔍 Inspeksi & Disposisi
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 2rem; color: #94A3B8;">Tidak ada usulan Ide Inovasi baru yang menunggu skrining.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- SUB-TAB 2: USULAN DITERIMA & DALAM KAJIAN TIM RISET -->
                <div x-show="inboxSubTab === 'study'" style="display: none;">
                    <table class="light-table">
                        <thead>
                            <tr>
                                <th>Tiket / Pengusul</th>
                                <th>Judul Usulan</th>
                                <th>Status Progres</th>
                                <th>Berkas Hasil Admin</th>
                                <th style="text-align: right;">Pratinjau</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeStudyProposals as $prop)
                                <tr x-show="tableSearchQuery === '' || '{{ strtolower($prop->ticket_no . ' ' . $prop->name . ' ' . $prop->title . ' ' . $prop->category) }}'.includes(tableSearchQuery.toLowerCase())">
                                    <td>
                                        <div style="font-weight: 900; color: #072718;">{{ $prop->ticket_no }}</div>
                                        <div style="font-size: 0.71875rem; color: #64748B;">{{ $prop->name }}</div>
                                    </td>
                                    <td style="color: #0F172A; font-weight: 700;">{{ $prop->title }}</td>
                                    <td>
                                        <span class="badge-light" style="background: #E0F2FE; color: #0369A1;">
                                            {{ $prop->status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($prop->admin_file_path)
                                            <a href="{{ $prop->admin_file_path }}" target="_blank" style="font-size: 0.75rem; font-weight: 800; color: #16A34A; text-decoration: underline;">📥 PDF Hasil Admin</a>
                                        @else
                                            <span style="font-size: 0.71875rem; color: #94A3B8;">Belum diunggah</span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">
                                        <button style="background: #0284C7; color: #FFF; font-weight: 900; font-size: 0.75rem; padding: 0.4rem 0.75rem; border-radius: 8px; border: none; cursor: pointer;" @click="selectedSubmissionFullView = proposalsMap[{{ $prop->id }}]">
                                            📄 Berkas & Ajuan
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 2rem; color: #94A3B8;">Tidak ada usulan aktif yang sedang dipelajari.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- SUB-TAB 3: USULAN DITOLAK ADMIN -->
                <div x-show="inboxSubTab === 'rejected'" style="display: none;">
                    <table class="light-table">
                        <thead>
                            <tr>
                                <th>Tiket / Pengusul</th>
                                <th>Judul Usulan & Alasan Penolakan</th>
                                <th>Kategori Hukum & Tipe</th>
                                <th>Status</th>
                                <th>Berkas PDF Asli</th>
                                <th>Tanggal Ditolak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rejectedProposals as $prop)
                                <tr x-show="tableSearchQuery === '' || '{{ strtolower($prop->ticket_no . ' ' . $prop->name . ' ' . $prop->title . ' ' . $prop->category) }}'.includes(tableSearchQuery.toLowerCase())">
                                    <td>
                                        <div style="font-weight: 900; color: #991B1B;">{{ $prop->ticket_no }}</div>
                                        <div style="font-size: 0.71875rem; color: #64748B;">{{ $prop->name }} ({{ $prop->institution ?? 'Kejaksaan' }})</div>
                                    </td>
                                    <td style="color: #0F172A; font-weight: 700;">
                                        <div>{{ $prop->title }}</div>
                                        <div style="font-size: 0.75rem; color: #991B1B; background: #FEF2F2; border: 1px solid #FCA5A5; padding: 0.35rem 0.65rem; border-radius: 6px; margin-top: 4px; font-weight: 700;">
                                            ❌ Alasan Penolakan: <strong>{{ $prop->rejection_reason ?? $prop->official_response ?? 'Di luar wewenang Pokja Riset Litbang' }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge-light" style="background: #F1F5F9; color: #475569;">
                                            {{ $prop->type ?? 'Policy Brief' }} | {{ $prop->category }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-light" style="background: #FEE2E2; color: #991B1B;">
                                            🚫 Ditolak
                                        </span>
                                    </td>
                                    <td>
                                        @if($prop->file_path)
                                            <a href="{{ $prop->file_path }}" target="_blank" style="font-size: 0.75rem; font-weight: 800; color: #0284C7; text-decoration: underline;">📄 PDF Original</a>
                                        @else
                                            <span style="font-size: 0.71875rem; color: #94A3B8;">Tanpa file</span>
                                        @endif
                                    </td>
                                    <td style="font-size: 0.75rem; color: #64748B; font-weight: 600;">
                                        {{ $prop->updated_at->format('d M Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 2rem; color: #94A3B8;">Belum ada usulan yang ditolak admin.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- SUB-TAB 4: INBOX UNGGUHAN KURIKULUM PESERTA -->
                <div x-show="inboxSubTab === 'curriculum'" style="display: none;">
                    <table class="light-table">
                        <thead>
                            <tr style="background: #F8FAFC; border-bottom: 2px solid #CBD5E1;">
                                <th style="width: 150px; color: #072718; font-weight: 900;">KODE & TIPE</th>
                                <th style="color: #072718; font-weight: 900;">JUDUL MATERI & PENGUNGGAH PESERTA</th>
                                <th style="width: 220px; color: #072718; font-weight: 900;">PRATINJAU DOKUMEN</th>
                                <th style="width: 140px; text-align: center; color: #072718; font-weight: 900;">STATUS INBOX</th>
                                <th style="width: 170px; text-align: right; color: #072718; font-weight: 900;">AKSI ADMIN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingCurriculums as $c)
                                <tr style="border-bottom: 1px solid #F1F5F9;" x-show="tableSearchQuery === '' || '{{ strtolower($c->title . ' ' . $c->uploader_name . ' ' . $c->subject_category) }}'.includes(tableSearchQuery.toLowerCase())">
                                    <td>
                                        <div style="font-weight: 900; color: #16A34A; font-size: 0.8125rem;">CURR-{{ $c->id }}</div>
                                        <span style="display: inline-block; background: #FEF3C7; border: 1px solid #FCD34D; color: #92400E; font-size: 0.6875rem; font-weight: 800; padding: 0.15rem 0.45rem; border-radius: 4px; margin-top: 4px;">
                                            {{ $c->file_type }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="color: #0F172A; font-weight: 800; font-size: 0.875rem; line-height: 1.35; margin-bottom: 4px;">{{ $c->title }}</div>
                                        <div style="font-size: 0.71875rem; color: #475569; font-weight: 700;">
                                            🎓 Bidang: <strong>{{ $c->subject_category }}</strong> | Pengunggah: <strong>{{ $c->uploader_name ?? 'Peserta' }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 0.35rem; flex-wrap: wrap;">
                                            @if($c->external_link)
                                                <a href="{{ $c->external_link }}" target="_blank" rel="noopener noreferrer" style="background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%); color: #FFF; font-size: 0.71875rem; font-weight: 800; padding: 0.35rem 0.65rem; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem; box-shadow: 0 1px 3px rgba(14,165,233,0.3);">
                                                    🔗 Google Drive Link
                                                </a>
                                            @endif
                                            @if($c->file_path)
                                                <button type="button" style="background: #0284C7; color: #FFF; border: none; font-size: 0.71875rem; font-weight: 800; padding: 0.35rem 0.65rem; border-radius: 6px; cursor: pointer; text-align: left; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 3px rgba(2,132,199,0.25);" @click="previewPdfUrl = '{{ $c->file_path }}'">
                                                    <span>👁️ Pratinjau Modul</span>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <span style="background: #FEF3C7; border: 1px solid #FCD34D; color: #B45309; font-size: 0.6875rem; padding: 0.25rem 0.55rem; border-radius: 9999px; font-weight: 800;">
                                            ⏳ Skrining Inbox
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display: flex; gap: 0.3rem; justify-content: flex-end;">
                                            <form action="{{ route('dashboard.curriculums.verify', $c->id) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                <button type="submit" style="background: #16A34A; color: #FFF; font-size: 0.71875rem; padding: 0.35rem 0.65rem; border-radius: 6px; font-weight: 800; border: none; cursor: pointer; white-space: nowrap;">
                                                    ✅ Terima & Teruskan
                                                </button>
                                            </form>
                                            <form action="{{ route('dashboard.curriculums.destroy', $c->id) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B; font-size: 0.71875rem; padding: 0.35rem 0.55rem; border-radius: 6px; font-weight: 800; cursor: pointer; white-space: nowrap;" onclick="return confirm('Tolak dan hapus materi kurikulum ini?')">
                                                    🗑️ Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 2rem; color: #94A3B8;">Tidak ada unggahan berkas kurikulum peserta yang menunggu verifikasi di Inbox.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 3: POLICY BRIEF STUDIO (PILAR 1) -->
        <div x-show="activeTab === 'policy'" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.75rem;">
                <div>
                    <h3 style="font-size: 1.1rem; font-weight: 900; color: #0F172A;">📄 Studio Policy Brief & Katalog Naskah Akademis (Pilar 1)</h3>
                    <p style="font-size: 0.78125rem; color: #64748B;">Kelola naskah akademis, perbarui berkas PDF hasil kajian, dan atur publikasi ke Vault.</p>
                </div>
                <button style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.78125rem; padding: 0.55rem 1.125rem; border-radius: 10px; border: 1px solid #C59B27; cursor: pointer; box-shadow: 0 4px 12px rgba(7,39,24,0.2);" @click="isNewKajianModalOpen = true">
                    + Buat Policy Brief Baru
                </button>
            </div>

            <div class="content-card">
                <table class="light-table">
                    <thead>
                        <tr>
                            <th style="width: 170px;">NO. DOKUMEN</th>
                            <th>JUDUL NASKAH AKADEMIS & PENGUSUL</th>
                            <th style="width: 320px;">DOKUMEN RISET & NASKAH FINAL</th>
                            <th style="width: 140px; text-align: center;">STATUS VAULT</th>
                            <th style="width: 150px; text-align: right;">AKSI ADMIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kajianList as $k)
                            @php
                                $linkedProp = $k->proposal ?? ($pendingProposals->firstWhere('kajian_id', $k->id) ?? $pendingProposals->first());
                            @endphp
                            <tr>
                                <td>
                                    <div style="font-weight: 900; color: #0F172A; font-size: 0.84375rem; letter-spacing: -0.01em;">{{ $k->doc_no }}</div>
                                    <span style="display: inline-block; background: #FEF3C7; border: 1px solid #FCD34D; color: #92400E; font-size: 0.6875rem; font-weight: 800; padding: 0.15rem 0.55rem; border-radius: 6px; margin-top: 4px;">
                                        {{ $k->category }}
                                    </span>
                                </td>
                                <td>
                                    <div style="color: #0F172A; font-weight: 800; font-size: 0.875rem; line-height: 1.4; margin-bottom: 4px;">{{ $k->title }}</div>
                                    @if($linkedProp)
                                        <div style="font-size: 0.71875rem; color: #475569; font-weight: 700; display: flex; align-items: center; gap: 0.4rem; flex-wrap: wrap;">
                                            <span style="color: #072718; font-weight: 800;">🎟️ {{ $linkedProp->ticket_no }}</span>
                                            <span style="color: #CBD5E1;">•</span>
                                            <span>Pengusul: <strong>{{ $linkedProp->name }}</strong></span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.4rem; align-items: center;">
                                        <button type="button" style="background: #F1F5F9; border: 1.5px solid #CBD5E1; color: #334155; font-size: 0.75rem; font-weight: 700; padding: 0.4rem 0.65rem; border-radius: 8px; cursor: pointer; white-space: nowrap; display: inline-flex; align-items: center; gap: 0.3rem;" @click="selectedSubmissionFullView = kajianProposalsMap[{{ $k->id }}]">
                                            📄 Usulan Original
                                        </button>
                                        <button type="button" style="background: #072718; color: #D4AF37; border: 1.5px solid #C59B27; font-size: 0.75rem; font-weight: 800; padding: 0.4rem 0.65rem; border-radius: 8px; cursor: pointer; white-space: nowrap; display: inline-flex; align-items: center; gap: 0.3rem; box-shadow: 0 2px 6px rgba(7,39,24,0.18);" @click="previewPdfUrl = '{{ $k->file_path ?? '/documents/pb_01.pdf' }}'">
                                            👁️ Naskah Final
                                        </button>
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <form action="{{ route('dashboard.policy.toggle_publish', $k->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="background: {{ $k->is_published ? '#ECFDF5' : '#FFFBEB' }}; border: 1.5px solid {{ $k->is_published ? '#6EE7B7' : '#FCD34D' }}; color: {{ $k->is_published ? '#047857' : '#B45309' }}; font-size: 0.71875rem; padding: 0.3rem 0.75rem; border-radius: 9999px; font-weight: 800; cursor: pointer; white-space: nowrap; display: inline-flex; align-items: center; gap: 0.3rem;">
                                            {{ $k->is_published ? '🟢 Terbit di Vault' : '🔒 Draft' }}
                                        </button>
                                    </form>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 0.4rem; justify-content: flex-end;">
                                        <button type="button" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; color: #334155; font-size: 0.75rem; font-weight: 700; padding: 0.4rem 0.65rem; border-radius: 8px; cursor: pointer; white-space: nowrap;" @click="selectedKajianEdit = policyBriefsMap[{{ $k->id }}]">
                                            ✏️ Edit
                                        </button>
                                        <form action="{{ route('dashboard.policy.destroy', $k->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: #FEF2F2; border: 1.5px solid #FCA5A5; color: #991B1B; font-size: 0.75rem; font-weight: 700; padding: 0.4rem 0.65rem; border-radius: 8px; cursor: pointer; white-space: nowrap;" onclick="return confirm('Hapus naskah Policy Brief ini?')">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 4: KELOLA BANK INOVASI (PILAR 2) -->
        <div x-show="activeTab === 'innovations'" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.75rem;">
                <div>
                    <h3 style="font-size: 1.1rem; font-weight: 900; color: #0F172A;">💡 Kelola Bank Inovasi Teruji & Gagasan Ide (Pilar 2)</h3>
                    <p style="font-size: 0.78125rem; color: #64748B;">Kelola portofolio inovasi teruji, inkubasi gagasan peserta, dan SOP pelaksanaan.</p>
                </div>
                <button style="background: #0284C7; color: #FFF; font-weight: 900; font-size: 0.78125rem; padding: 0.55rem 1.125rem; border-radius: 10px; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(2,132,199,0.2);" @click="isNewInnovationModalOpen = true">
                    + Tambah Inovasi Baru
                </button>
            </div>

            <div class="content-card">
                <table class="light-table">
                    <thead>
                        <tr>
                            <th style="width: 170px;">NO. INOVASI</th>
                            <th>JUDUL INOVASI & INOVATOR ORIGINAL</th>
                            <th style="width: 320px;">GAGASAN ORIGINAL & SOP FINAL</th>
                            <th style="width: 140px; text-align: center;">STATUS VAULT</th>
                            <th style="width: 150px; text-align: right;">AKSI ADMIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($innovations as $inv)
                            @php
                                $invProp = $inv->proposal ?? ($pendingProposals->firstWhere('type', 'Ide Inovasi') ?? $pendingProposals->last());
                            @endphp
                            <tr>
                                <td>
                                    <div style="font-weight: 900; color: #0F172A; font-size: 0.84375rem; letter-spacing: -0.01em;">{{ $inv->innovation_no }}</div>
                                    <span style="display: inline-block; background: #E0F2FE; border: 1px solid #7DD3FC; color: #0369A1; font-size: 0.6875rem; font-weight: 800; padding: 0.15rem 0.55rem; border-radius: 6px; margin-top: 4px;">
                                        {{ $inv->category }}
                                    </span>
                                </td>
                                <td>
                                    <div style="color: #0F172A; font-weight: 800; font-size: 0.875rem; line-height: 1.4; margin-bottom: 4px;">{{ $inv->title }}</div>
                                    @if($invProp)
                                        <div style="font-size: 0.71875rem; color: #475569; font-weight: 700; display: flex; align-items: center; gap: 0.4rem; flex-wrap: wrap;">
                                            <span style="color: #0284C7; font-weight: 800;">🎟️ {{ $invProp->ticket_no }}</span>
                                            <span style="color: #CBD5E1;">•</span>
                                            <span>Inovator: <strong>{{ $inv->innovator_name ?? $invProp->name }}</strong></span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.4rem; align-items: center;">
                                        <button type="button" style="background: #F1F5F9; border: 1.5px solid #CBD5E1; color: #334155; font-size: 0.75rem; font-weight: 700; padding: 0.4rem 0.65rem; border-radius: 8px; cursor: pointer; white-space: nowrap; display: inline-flex; align-items: center; gap: 0.3rem;" @click="selectedSubmissionFullView = innovationProposalsMap[{{ $inv->id }}]">
                                            📄 Gagasan Original
                                        </button>
                                        <button type="button" style="background: #0284C7; color: #FFF; border: none; font-size: 0.75rem; font-weight: 800; padding: 0.45rem 0.65rem; border-radius: 8px; cursor: pointer; white-space: nowrap; display: inline-flex; align-items: center; gap: 0.3rem; box-shadow: 0 2px 6px rgba(2,132,199,0.2);" @click="previewPdfUrl = '{{ $inv->sop_file_path ?? '/documents/pb_01.pdf' }}'">
                                            👁️ SOP Final PDF
                                        </button>
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <form action="{{ route('dashboard.innovations.toggle_publish', $inv->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="background: {{ $inv->is_published ? '#ECFDF5' : '#FFFBEB' }}; border: 1.5px solid {{ $inv->is_published ? '#6EE7B7' : '#FCD34D' }}; color: {{ $inv->is_published ? '#047857' : '#B45309' }}; font-size: 0.71875rem; padding: 0.3rem 0.75rem; border-radius: 9999px; font-weight: 800; cursor: pointer; white-space: nowrap; display: inline-flex; align-items: center; gap: 0.3rem;">
                                            {{ $inv->is_published ? '🟢 Terbit di Vault' : '🔒 Draft' }}
                                        </button>
                                    </form>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 0.4rem; justify-content: flex-end;">
                                        <button type="button" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; color: #334155; font-size: 0.75rem; font-weight: 700; padding: 0.4rem 0.65rem; border-radius: 8px; cursor: pointer; white-space: nowrap;" @click="selectedInnovationEdit = innovationsMap[{{ $inv->id }}]">
                                            ✏️ Edit
                                        </button>
                                        <form action="{{ route('dashboard.innovations.destroy', $inv->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: #FEF2F2; border: 1.5px solid #FCA5A5; color: #991B1B; font-size: 0.75rem; font-weight: 700; padding: 0.4rem 0.65rem; border-radius: 8px; cursor: pointer; white-space: nowrap;" onclick="return confirm('Hapus data Inovasi ini?')">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 5: KURIKULUM & VAULT MATERI (PILAR 3) -->
        <div x-show="activeTab === 'curriculums'" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.75rem;">
                <div>
                    <h3 style="font-size: 1.1rem; font-weight: 900; color: #0F172A;">📚 Vault Kurikulum & Arsip Materi Pembelajaran (Pilar 3)</h3>
                    <div style="font-size: 0.78125rem; color: #64748B;">Kelola, pratinjau, edit naskah modul, dan verifikasi publikasi berkas kurikulum PPPJ 2026.</div>
                </div>
                <button style="background: #16A34A; color: #FFF; font-weight: 900; font-size: 0.78125rem; padding: 0.55rem 1.125rem; border-radius: 10px; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(22,163,74,0.2);" @click="isNewCurriculumModalOpen = true">
                    + Upload Modul (Admin Direct)
                </button>
            </div>

            @php
                $pendingCurriculums = $curriculums->filter(fn($c) => !$c->is_verified);
                $verifiedCurriculums = $curriculums->filter(fn($c) => $c->is_verified);
            @endphp

            <!-- VAULT KURIKULUM TERVERIFIKASI -->
            <div class="content-card">
                <h4 style="font-size: 1rem; font-weight: 900; color: #0F172A; margin-bottom: 1rem;">✅ Vault Kurikulum Terverifikasi (Aktif di Public)</h4>
                <table class="light-table">
                    <thead>
                        <tr>
                            <th style="width: 170px;">KODE & TIPE</th>
                            <th>JUDUL MATERI & PENGUNGGAH DOKUMEN</th>
                            <th style="width: 320px;">PRATINJAU & DOWNLOAD DOKUMEN</th>
                            <th style="width: 140px; text-align: center;">STATUS VAULT</th>
                            <th style="width: 150px; text-align: right;">AKSI ADMIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($verifiedCurriculums as $c)
                            <tr>
                                <td>
                                    <div style="font-weight: 900; color: #0F172A; font-size: 0.84375rem; letter-spacing: -0.01em;">CURR-{{ $c->id }}</div>
                                    <span style="display: inline-block; background: #DCFCE7; border: 1px solid #86EFAC; color: #15803D; font-size: 0.6875rem; font-weight: 800; padding: 0.15rem 0.55rem; border-radius: 6px; margin-top: 4px;">
                                        {{ $c->file_type }}
                                    </span>
                                </td>
                                <td>
                                    <div style="color: #0F172A; font-weight: 800; font-size: 0.875rem; line-height: 1.4; margin-bottom: 4px;">{{ $c->title }}</div>
                                    <div style="font-size: 0.71875rem; color: #334155; background: #F1F5F9; border: 1px solid #CBD5E1; padding: 0.2rem 0.55rem; border-radius: 6px; display: inline-flex; align-items: center; gap: 0.4rem; font-weight: 700;">
                                        <span>🎓 Bidang: <strong>{{ $c->subject_category }}</strong></span>
                                        <span>• Pengunggah: <strong>{{ $c->uploader_name ?? 'Admin' }}</strong></span>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.4rem; align-items: center; flex-wrap: wrap;">
                                        @if($c->external_link)
                                            <a href="{{ $c->external_link }}" target="_blank" rel="noopener noreferrer" style="background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%); color: #FFF; font-size: 0.75rem; font-weight: 800; padding: 0.4rem 0.65rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem; box-shadow: 0 2px 6px rgba(14,165,233,0.3);">
                                                🔗 Google Drive Link
                                            </a>
                                        @endif
                                        @if($c->file_path)
                                            <button type="button" style="background: #072718; color: #D4AF37; border: 1.5px solid #C59B27; font-size: 0.75rem; font-weight: 800; padding: 0.4rem 0.65rem; border-radius: 8px; cursor: pointer; white-space: nowrap; display: inline-flex; align-items: center; gap: 0.3rem; box-shadow: 0 2px 6px rgba(7,39,24,0.18);" @click="previewPdfUrl = '{{ $c->file_path }}'">
                                                👁️ Pratinjau PDF
                                            </button>
                                            <a href="{{ $c->file_path }}" download style="background: #E0F2FE; border: 1.5px solid #7DD3FC; color: #0369A1; font-size: 0.75rem; font-weight: 800; padding: 0.4rem 0.65rem; border-radius: 8px; text-decoration: none; white-space: nowrap; display: inline-flex; align-items: center; gap: 0.3rem;">
                                                📥 Unduh Berkas
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <form action="{{ route('dashboard.curriculums.toggle_publish', $c->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="background: {{ $c->is_verified ? '#ECFDF5' : '#FFFBEB' }}; border: 1.5px solid {{ $c->is_verified ? '#6EE7B7' : '#FCD34D' }}; color: {{ $c->is_verified ? '#047857' : '#B45309' }}; font-size: 0.71875rem; padding: 0.3rem 0.75rem; border-radius: 9999px; font-weight: 800; cursor: pointer; white-space: nowrap; display: inline-flex; align-items: center; gap: 0.3rem;">
                                            {{ $c->is_verified ? '🟢 Terbit di Vault' : '🔒 Draft' }}
                                        </button>
                                    </form>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 0.4rem; justify-content: flex-end;">
                                        <button type="button" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; color: #334155; font-size: 0.75rem; font-weight: 700; padding: 0.4rem 0.65rem; border-radius: 8px; cursor: pointer; white-space: nowrap;" @click="selectedCurriculumEdit = curriculumsMap[{{ $c->id }}]">
                                            ✏️ Edit
                                        </button>
                                        <form action="{{ route('dashboard.curriculums.destroy', $c->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: #FEF2F2; border: 1.5px solid #FCA5A5; color: #991B1B; font-size: 0.75rem; font-weight: 700; padding: 0.4rem 0.65rem; border-radius: 8px; cursor: pointer; white-space: nowrap;" onclick="return confirm('Hapus materi kurikulum ini?')">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 6: KELOLA USER & HAK AKSES -->
        <div x-show="activeTab === 'users'" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                <h3 style="font-size: 1.1rem; font-weight: 900; color: #0F172A;">👥 Kelola Pengguna Internal & Role Akun</h3>
                <button style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.78125rem; padding: 0.55rem 1.125rem; border-radius: 10px; border: none; cursor: pointer;" @click="isNewUserModalOpen = true">
                    + Tambah Akun Admin Baru
                </button>
            </div>

            <div class="content-card">
                <table class="light-table">
                    <thead>
                        <tr>
                            <th>Nama Administrator</th>
                            <th>Email</th>
                            <th>Role Jabatan</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $usr)
                            <tr>
                                <td style="color: #0F172A; font-weight: 800;">{{ $usr->name }}</td>
                                <td style="color: #475569;">{{ $usr->email }}</td>
                                <td>
                                    <span class="badge-light" style="background: #FEF3C7; color: #92400E;">
                                        {{ $usr->role }}
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <button style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #334155; font-size: 0.71875rem; padding: 0.35rem 0.75rem; border-radius: 6px; font-weight: 700; cursor: pointer;" @click="selectedUserEdit = usersMap[{{ $usr->id }}]">
                                        ✏️ Edit User
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 7: PENGATURAN PIN ANGKATAN & DYNAMIC FORM BUILDER -->
        <div x-show="activeTab === 'settings'" style="display: none;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                
                <!-- LEFT BOX: SETTING PIN PASSCODE ANGKATAN (SOLUSI A) -->
                <div class="content-card" style="border-top: 4px solid #C59B27;">
                    <h3 style="font-size: 1.0625rem; font-weight: 900; color: #072718; margin-bottom: 0.5rem;">🔑 Pengaturan PIN Akses Angkatan (Solusi A)</h3>
                    <p style="font-size: 0.78125rem; color: #64748B; margin-bottom: 1.25rem; line-height: 1.5;">
                        Atur Kode PIN rahasia angkatan yang digunakan oleh 500+ Peserta/Anggota untuk mengirim usulan dan mengakses portal.
                    </p>

                    <form action="{{ route('dashboard.update_pin') }}" method="POST" style="display: flex; flex-direction: column; gap: 0.875rem;">
                        @csrf
                        <div>
                            <label style="font-size: 0.75rem; font-weight: 700; color: #334155; display: block; margin-bottom: 0.25rem;">Kode PIN Akses Angkatan Saat Ini *</label>
                            <input type="text" name="batch_passcode" required value="{{ $setting->batch_passcode }}" style="width: 100%; padding: 0.65rem; font-size: 0.9375rem; font-weight: 900; border-radius: 8px; border: 1.5px solid #C59B27; background: #FFFBF0; color: #072718; outline: none;" />
                        </div>
                        <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.8125rem; padding: 0.65rem; border-radius: 8px; border: none; cursor: pointer;">
                            💾 Simpan Kode PIN Baru
                        </button>
                    </form>
                </div>

                <!-- RIGHT BOX: DYNAMIC FORM BUILDER -->
                <div class="content-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h3 style="font-size: 1.0625rem; font-weight: 900; color: #0F172A;">🛠️ Dynamic Form Builder</h3>
                        <button style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.75rem; padding: 0.4rem 0.875rem; border-radius: 8px; border: none; cursor: pointer;" @click="isNewFormFieldModalOpen = true">
                            + Tambah Kolom Form
                        </button>
                    </div>

                    <table class="light-table">
                        <thead>
                            <tr>
                                <th>Label Kolom</th>
                                <th>Tipe Data</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($formFields as $ff)
                                <tr>
                                    <td style="color: #0F172A; font-weight: 700;">{{ $ff->field_label }}</td>
                                    <td style="color: #64748B;">{{ strtoupper($ff->field_type) }}</td>
                                    <td style="text-align: right;">
                                        <form action="{{ route('dashboard.form_fields.destroy', $ff->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; font-size: 0.6875rem; padding: 0.2rem 0.5rem; border-radius: 4px; cursor: pointer;" onclick="return confirm('Hapus kolom formulir ini?')">
                                                ✕
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- KELOLA KATEGORI DOMAIN HUKUM (PIDANA, PERDATA, TUN) -->
            <div class="content-card" style="margin-top: 1.5rem;">
                <h3 style="font-size: 1.0625rem; font-weight: 900; color: #0F172A; margin-bottom: 0.5rem;">⚖️ Kelola Kategori Domain Hukum</h3>
                <p style="font-size: 0.78125rem; color: #64748B; margin-bottom: 1rem;">Admin dapat menambah atau menghapus kategori domain hukum (Contoh: Pidana, Perdata, TUN).</p>

                <form action="{{ route('dashboard.store_category') }}" method="POST" style="display: flex; gap: 0.5rem; margin-bottom: 1.25rem; flex-wrap: wrap;">
                    @csrf
                    <input type="text" name="name" required placeholder="Nama Kategori (misal: Pidana, Perdata, TUN)" style="flex: 1; min-width: 200px; padding: 0.55rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A; font-size: 0.8125rem;" />
                    <input type="text" name="icon" placeholder="Icon Emoji (misal: ⚖️)" style="width: 100px; padding: 0.55rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A; font-size: 0.8125rem;" />
                    <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.78125rem; padding: 0.55rem 1rem; border-radius: 8px; border: none; cursor: pointer;">+ Tambah Kategori</button>
                </form>

                <table class="light-table">
                    <thead>
                        <tr>
                            <th>Icon & Nama Kategori</th>
                            <th>Deskripsi Singkat</th>
                            <th style="text-align: right;">Aksi Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $cat)
                            <tr>
                                <td style="color: #0F172A; font-weight: 800;">{{ $cat->icon }} {{ $cat->name }}</td>
                                <td style="color: #64748B;">{{ $cat->description }}</td>
                                <td style="text-align: right;">
                                    <form action="{{ route('dashboard.destroy_category', $cat->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; font-size: 0.6875rem; padding: 0.25rem 0.5rem; border-radius: 4px; cursor: pointer;" onclick="return confirm('Hapus kategori {{ $cat->name }}?')">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- MODAL: ADD INNOVATION -->
    <div x-show="isNewInnovationModalOpen" class="modal-overlay" style="display: none;" @click="isNewInnovationModalOpen = false">
        <div class="modal-card" style="max-width: 540px; background: #FFF; border: 2px solid #0284C7; color: #0F172A;" @click.stop>
            <div style="padding: 1rem; border-bottom: 1px solid #E2E8F0; font-weight: 900; color: #0284C7;">
                💡 Tambah Inovasi Teruji Baru
            </div>
            <form action="{{ route('dashboard.innovations.store') }}" method="POST" enctype="multipart/form-data" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.875rem;">
                @csrf
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Judul Inovasi *</label>
                    <input type="text" name="title" required style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Inovator / Tim *</label>
                    <input type="text" name="innovator_name" required style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                    <div>
                        <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Kategori *</label>
                        <select name="category" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Status *</label>
                        <select name="status" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;">
                            <option value="Inovasi Teruji">Inovasi Teruji</option>
                            <option value="Proses Inkubasi">Proses Inkubasi</option>
                            <option value="Ide Usulan">Ide Usulan</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Uraian Singkat Inovasi *</label>
                    <textarea name="summary" rows="2" required style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;"></textarea>
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Estimasi Skor Dampak Efisiensi</label>
                    <input type="text" name="impact_description" placeholder="Contoh: Efisiensi waktu audit hingga 85%" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                    <button type="button" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 700; border-radius: 8px; padding: 0.5rem 1rem; cursor: pointer;" @click="isNewInnovationModalOpen = false">Batal</button>
                    <button type="submit" style="background: #0284C7; color: #FFF; font-weight: 900; font-size: 0.78125rem; padding: 0.5rem 1rem; border-radius: 8px; border: none; cursor: pointer;">Simpan Inovasi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: ADD CURRICULUM -->
    <div x-show="isNewCurriculumModalOpen" class="modal-overlay" style="display: none;" @click="isNewCurriculumModalOpen = false">
        <div class="modal-card" style="max-width: 540px; background: #FFF; border: 2px solid #16A34A; color: #0F172A;" @click.stop>
            <div style="padding: 1rem; border-bottom: 1px solid #E2E8F0; font-weight: 900; color: #16A34A;">
                📚 Upload Materi Kurikulum PPPJ Baru
            </div>
            <form action="{{ route('dashboard.curriculums.store') }}" method="POST" enctype="multipart/form-data" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.875rem;">
                @csrf
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Judul Materi / Modul *</label>
                    <input type="text" name="title" required style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                    <div>
                        <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Bidang Hukum *</label>
                        <select name="subject_category" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;">
                            @foreach($categories as $c)
                                <option value="{{ $c->name }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Jenis Berkas *</label>
                        <select name="file_type" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;">
                            <option value="Modul PDF">Modul PDF</option>
                            <option value="Slide PPT">Slide PPT</option>
                            <option value="Silabus/Juknis">Silabus/Juknis</option>
                            <option value="Link Google Drive / Cloud">🔗 Link Google Drive / Cloud</option>
                            <option value="Video Pembelajaran">Video Pembelajaran</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #0284C7; font-weight: 800;">🔗 Link External / Google Drive (Contoh: https://drive.google.com/...)</label>
                    <input type="url" name="external_link" placeholder="Masukkan link Google Drive / OneDrive / Cloud (Opsional jika mengunggah file)" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #0284C7; border-radius: 8px; color: #0F172A; outline: none;" />
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">File Dokumen Materi (PDF/PPT/Word)</label>
                    <input type="file" name="attachment" style="width: 100%; padding: 0.4rem; font-size: 0.75rem; color: #475569;" />
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                    <button type="button" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 700; border-radius: 8px; padding: 0.5rem 1rem; cursor: pointer;" @click="isNewCurriculumModalOpen = false">Batal</button>
                    <button type="submit" style="background: #16A34A; color: #FFF; font-weight: 900; font-size: 0.78125rem; padding: 0.5rem 1rem; border-radius: 8px; border: none; cursor: pointer;">Upload Ke Vault</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: ADD DYNAMIC FORM FIELD -->
    <div x-show="isNewFormFieldModalOpen" class="modal-overlay" style="display: none;" @click="isNewFormFieldModalOpen = false">
        <div class="modal-card" style="max-width: 480px; background: #FFF; border: 2px solid #C59B27; color: #0F172A;" @click.stop>
            <div style="padding: 1rem; border-bottom: 1px solid #E2E8F0; font-weight: 900; color: #C59B27;">
                🛠️ Tambah Kolom Formulir Baru
            </div>
            <form action="{{ route('dashboard.form_fields.store') }}" method="POST" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.875rem;">
                @csrf
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Label Nama Kolom *</label>
                    <input type="text" name="field_label" placeholder="Contoh: Target Efisiensi Waktu" required style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Tipe Input Data *</label>
                    <select name="field_type" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;">
                        <option value="text">Teks Singkat (Text)</option>
                        <option value="textarea">Uraian Panjang (Textarea)</option>
                        <option value="select">Pilihan Dropdown (Select)</option>
                    </select>
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Pilihan Dropdown (Pisahkan dengan koma jika select)</label>
                    <input type="text" name="options_raw" placeholder="Opsi A, Opsi B, Opsi C" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                    <button type="button" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 700; border-radius: 8px; padding: 0.5rem 1rem; cursor: pointer;" @click="isNewFormFieldModalOpen = false">Batal</button>
                    <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.78125rem; padding: 0.5rem 1rem; border-radius: 8px; border: none; cursor: pointer;">Simpan Kolom</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: INSPEKSI BERKAS & DISPOSISI USULAN (selectedProposalDisposition) -->
    <div x-show="selectedProposalDisposition !== null" class="modal-overlay" style="display: none;" @click="selectedProposalDisposition = null">
        <div class="modal-card" style="max-width: 820px; width: 94%; background: #FFF; border: 2px solid #072718; border-radius: 18px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.35);" @click.stop x-data="{ dispModalTab: 'summary', dispositionAction: 'accept', rejectionReasonText: '', acceptResponseText: 'Usulan telah disetujui dan diteruskan ke 3 Pilar Manajemen Pengetahuan untuk penyusunan lebih lanjut.' }">
            <!-- HEADER -->
            <div style="padding: 1.2rem 1.5rem; background: linear-gradient(135deg, #072718 0%, #0D3E27 100%); border-bottom: 2.5px solid #C59B27; color: #FFF; display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                        <span style="background: #C59B27; color: #072718; font-weight: 900; font-size: 0.75rem; padding: 0.2rem 0.65rem; border-radius: 9999px; letter-spacing: 0.05em;" x-text="selectedProposalDisposition ? selectedProposalDisposition.ticket_no : ''"></span>
                        <span style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: #FFF; font-size: 0.71875rem; font-weight: 800; padding: 0.15rem 0.55rem; border-radius: 6px;" x-text="selectedProposalDisposition ? 'Kategori: ' + selectedProposalDisposition.category : ''"></span>
                    </div>
                    <h3 style="font-size: 1.15rem; font-weight: 900; color: #FFFFFF; line-height: 1.35; margin-top: 0.45rem;" x-text="selectedProposalDisposition ? selectedProposalDisposition.title : ''"></h3>
                    
                    <!-- TAB NAVIGATION BUTTONS -->
                    <div style="display: flex; gap: 0.5rem; margin-top: 0.85rem;">
                        <button type="button" @click="dispModalTab = 'summary'" :style="dispModalTab === 'summary' ? 'background: #C59B27; color: #072718; font-weight: 900;' : 'background: rgba(255,255,255,0.15); color: #FFF; font-weight: 700;'" style="padding: 0.35rem 0.85rem; border-radius: 8px; border: none; font-size: 0.78125rem; cursor: pointer; transition: all 0.2s;">
                            📄 Tab 1: Ringkasan & Berkas
                        </button>
                        <button type="button" @click="dispModalTab = 'decision'" :style="dispModalTab === 'decision' ? 'background: #C59B27; color: #072718; font-weight: 900;' : 'background: rgba(255,255,255,0.15); color: #FFF; font-weight: 700;'" style="padding: 0.35rem 0.85rem; border-radius: 8px; border: none; font-size: 0.78125rem; cursor: pointer; transition: all 0.2s;">
                            ⚙️ Tab 2: Keputusan Disposisi Admin
                        </button>
                    </div>
                </div>
                <button @click="selectedProposalDisposition = null" style="background: rgba(255,255,255,0.15); border: none; color: #FFF; width: 34px; height: 34px; border-radius: 50%; font-size: 1.1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; shrink: 0; margin-left: 1rem;">✕</button>
            </div>

            <form :action="'/dashboard/disposition/' + (selectedProposalDisposition ? selectedProposalDisposition.id : '')" method="POST" enctype="multipart/form-data" style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem; max-height: 78vh; overflow-y: auto;">
                @csrf

                <!-- ================= TAB 1: RINGKASAN USULAN & BERKAS ================= -->
                <div x-show="dispModalTab === 'summary'" style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <!-- VISUAL 4-STAGE PIPELINE STEPPER PROGRESS TRACKER -->
                    <div style="background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 14px; padding: 1rem;">
                        <div style="font-size: 0.71875rem; font-weight: 900; color: #072718; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.65rem; display: flex; justify-content: space-between; align-items: center;">
                            <span>📈 ALUR PROGRES PIPELINE KAJIAN (4-STAGE TRACKER)</span>
                            <span style="font-size: 0.6875rem; color: #64748B; font-weight: 700;">Klik tahap untuk mengubah status</span>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.5rem; text-align: center;">
                            <button type="button" @click="if (selectedProposalDisposition) selectedProposalDisposition.timeline_step = 1" style="border-radius: 8px; padding: 0.5rem 0.25rem; cursor: pointer; transition: all 0.2s;" :style="selectedProposalDisposition && selectedProposalDisposition.timeline_step >= 1 ? 'background: #072718; color: #D4AF37; border: 1.5px solid #C59B27; font-weight: 900;' : 'background: #FFF; color: #64748B; border: 1.5px solid #CBD5E1; font-weight: 700;'">
                                <div style="font-size: 0.6875rem;">⏳ Stage 1</div>
                                <div style="font-size: 0.625rem; opacity: 0.9; margin-top: 2px;">Skrining Inbox</div>
                            </button>
                            <button type="button" @click="if (selectedProposalDisposition) selectedProposalDisposition.timeline_step = 2" style="border-radius: 8px; padding: 0.5rem 0.25rem; cursor: pointer; transition: all 0.2s;" :style="selectedProposalDisposition && selectedProposalDisposition.timeline_step >= 2 ? 'background: #072718; color: #D4AF37; border: 1.5px solid #C59B27; font-weight: 900;' : 'background: #FFF; color: #64748B; border: 1.5px solid #CBD5E1; font-weight: 700;'">
                                <div style="font-size: 0.6875rem;">🔬 Stage 2</div>
                                <div style="font-size: 0.625rem; opacity: 0.9; margin-top: 2px;">Disposisi Riset</div>
                            </button>
                            <button type="button" @click="if (selectedProposalDisposition) selectedProposalDisposition.timeline_step = 3" style="border-radius: 8px; padding: 0.5rem 0.25rem; cursor: pointer; transition: all 0.2s;" :style="selectedProposalDisposition && selectedProposalDisposition.timeline_step >= 3 ? 'background: #072718; color: #D4AF37; border: 1.5px solid #C59B27; font-weight: 900;' : 'background: #FFF; color: #64748B; border: 1.5px solid #CBD5E1; font-weight: 700;'">
                                <div style="font-size: 0.6875rem;">📄 Stage 3</div>
                                <div style="font-size: 0.625rem; opacity: 0.9; margin-top: 2px;">Policy Brief</div>
                            </button>
                            <button type="button" @click="if (selectedProposalDisposition) selectedProposalDisposition.timeline_step = 4" style="border-radius: 8px; padding: 0.5rem 0.25rem; cursor: pointer; transition: all 0.2s;" :style="selectedProposalDisposition && selectedProposalDisposition.timeline_step >= 4 ? 'background: #16A34A; color: #FFF; border: 1.5px solid #86EFAC; font-weight: 900;' : 'background: #FFF; color: #64748B; border: 1.5px solid #CBD5E1; font-weight: 700;'">
                                <div style="font-size: 0.6875rem;">🟢 Stage 4</div>
                                <div style="font-size: 0.625rem; opacity: 0.9; margin-top: 2px;">Terbit Vault</div>
                            </button>
                        </div>
                    </div>

                    <!-- 2-COLUMN INFO CARDS -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <!-- CARD A: IDENTITAS -->
                        <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 12px; padding: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
                            <div style="font-size: 0.6875rem; font-weight: 900; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">
                                👤 IDENTITAS PESERTA / PENGUSUL
                            </div>
                            <div style="font-size: 1.05rem; font-weight: 900; color: #0F172A; margin-top: 0.35rem;" x-text="selectedProposalDisposition ? selectedProposalDisposition.name : ''"></div>
                            <div style="font-size: 0.8125rem; color: #475569; font-weight: 700; margin-top: 0.2rem;" x-text="selectedProposalDisposition ? (selectedProposalDisposition.institution || 'Kejaksaan RI') : ''"></div>
                            <div style="margin-top: 0.65rem;">
                                <span style="background: #ECFDF5; border: 1px solid #6EE7B7; color: #065F46; font-size: 0.71875rem; padding: 0.25rem 0.55rem; border-radius: 6px; font-weight: 800; display: inline-block;">
                                    🟢 Status: <span x-text="selectedProposalDisposition ? selectedProposalDisposition.status : 'Menunggu Skrining'"></span>
                                </span>
                            </div>
                        </div>

                        <!-- CARD B: URAIAN MASALAH AWAL -->
                        <div style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 12px; padding: 1rem;">
                            <div style="font-size: 0.6875rem; font-weight: 900; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">
                                📝 URAIAN & FORMULASI MASALAH AWAL
                            </div>
                            <div style="font-size: 0.84375rem; color: #1E293B; line-height: 1.55; margin-top: 0.35rem; font-weight: 600; white-space: pre-line;" x-text="selectedProposalDisposition ? selectedProposalDisposition.description : ''"></div>
                        </div>
                    </div>

                    <!-- CARD C: DOKUMEN LAMPIRAN ORIGINAL (COMPACT WITHOUT EMBEDDED IFRAME) -->
                    <div style="background: #F0F9FF; border: 1.5px solid #7DD3FC; border-radius: 12px; padding: 1rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem;">
                            <div>
                                <div style="font-size: 0.84375rem; font-weight: 900; color: #0369A1; display: flex; align-items: center; gap: 0.35rem;">
                                    📁 Dokumen / File Lampiran Asli Pengusul
                                </div>
                                <div style="font-size: 0.75rem; color: #0284C7; font-weight: 700; margin-top: 2px;" x-text="selectedProposalDisposition && selectedProposalDisposition.file_path ? (selectedProposalDisposition.file_name || 'Usulan_Peserta_Original.pdf') : 'Tidak ada lampiran berkas'"></div>
                            </div>
                            <template x-if="selectedProposalDisposition && selectedProposalDisposition.file_path">
                                <div style="display: flex; gap: 0.5rem;">
                                    <button type="button" style="background: #0284C7; color: #FFFFFF; font-size: 0.78125rem; font-weight: 800; padding: 0.45rem 0.875rem; border-radius: 8px; border: none; cursor: pointer; box-shadow: 0 2px 4px rgba(2,132,199,0.25);" @click="previewPdfUrl = selectedProposalDisposition.file_path">
                                        👁️ Pratinjau Fullscreen PDF
                                    </button>
                                    <a :href="selectedProposalDisposition ? selectedProposalDisposition.file_path : '#'" target="_blank" style="background: #072718; color: #D4AF37; font-size: 0.78125rem; font-weight: 900; padding: 0.45rem 0.875rem; border-radius: 8px; text-decoration: none; border: 1px solid #C59B27;">
                                        📥 Download PDF Original
                                    </a>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- FOOTER TAB 1: LANJUT KE KEPUTUSAN -->
                    <div style="display: flex; justify-content: flex-end; gap: 0.65rem; margin-top: 0.5rem; padding-top: 0.875rem; border-top: 1px solid #E2E8F0;">
                        <button type="button" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 700; border-radius: 8px; padding: 0.55rem 1.25rem; cursor: pointer;" @click="selectedProposalDisposition = null">Batal</button>
                        <button type="button" @click="dispModalTab = 'decision'" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.84375rem; padding: 0.55rem 1.5rem; border-radius: 8px; border: 1px solid #C59B27; cursor: pointer; box-shadow: 0 4px 12px rgba(7,39,24,0.2); display: flex; align-items: center; gap: 0.5rem;">
                            Lanjut ke Keputusan Admin ➔
                        </button>
                    </div>
                </div>

                <!-- ================= TAB 2: KEPUTUSAN DISPOSISI ADMIN ================= -->
                <div x-show="dispModalTab === 'decision'" style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <div style="font-size: 0.8125rem; font-weight: 900; color: #072718; text-transform: uppercase; letter-spacing: 0.05em; background: #F1F5F9; padding: 0.6rem 0.85rem; border-radius: 8px; border-left: 4px solid #072718;">
                        ⚙️ SEKSI KEPUTUSAN & TANGGAPAN RESMI ADMIN
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                        <button type="button" class="disposition-act-btn" :class="{ 'active-accept': dispositionAction === 'accept' }" @click="dispositionAction = 'accept'">
                            ✅ Terima & Teruskan ke 3 Pilar
                        </button>
                        <button type="button" class="disposition-act-btn" :class="{ 'active-reject': dispositionAction === 'reject' }" @click="dispositionAction = 'reject'">
                            ❌ Tolak Usulan
                        </button>
                    </div>
                    <input type="hidden" name="action" :value="dispositionAction" />
                    <input type="hidden" name="timeline_step" :value="selectedProposalDisposition ? selectedProposalDisposition.timeline_step : 2" />

                    <!-- ACTION: REJECT (MANDATORY REASON & QUICK PRESETS) -->
                    <template x-if="dispositionAction === 'reject'">
                        <div style="background: #FEE2E2; border: 1.5px solid #FCA5A5; border-radius: 12px; padding: 1rem; display: flex; flex-direction: column; gap: 0.65rem;">
                            <label style="font-size: 0.75rem; font-weight: 900; color: #991B1B;">Alasan Penolakan Usulan (WAJIB DIISI) *</label>
                            
                            <!-- PRESET TEMPLATE BUTTONS -->
                            <div style="display: flex; flex-wrap: wrap; gap: 0.35rem; margin-bottom: 0.25rem;">
                                <button type="button" style="background: #FFF; border: 1px solid #FCA5A5; color: #991B1B; font-size: 0.6875rem; padding: 0.25rem 0.5rem; border-radius: 6px; font-weight: 700; cursor: pointer;" @click="rejectionReasonText = '[DI LUAR WEWENANG LITBANG] Usulan berada di luar wewenang Pokja Riset Litbang.'">
                                    ⚡ [Di Luar Wewenang]
                                </button>
                                <button type="button" style="background: #FFF; border: 1px solid #FCA5A5; color: #991B1B; font-size: 0.6875rem; padding: 0.25rem 0.5rem; border-radius: 6px; font-weight: 700; cursor: pointer;" @click="rejectionReasonText = '[BERKAS TIDAK LENGKAP] Berkas atau dokumen pendukung usulan tidak dapat dibuka / tidak sesuai format.'">
                                    ⚡ [Berkas Tidak Lengkap]
                                </button>
                                <button type="button" style="background: #FFF; border: 1px solid #FCA5A5; color: #991B1B; font-size: 0.6875rem; padding: 0.25rem 0.5rem; border-radius: 6px; font-weight: 700; cursor: pointer;" @click="rejectionReasonText = '[DUPLIKASI USULAN] Usulan isu sejenis telah masuk dalam agenda kajian Tim Riset.'">
                                    ⚡ [Duplikasi Usulan]
                                </button>
                            </div>

                            <textarea name="rejection_reason" x-model="rejectionReasonText" rows="3" required placeholder="Jelaskan alasan penolakan secara spesifik atau pilih tombol preset di atas..." style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #FCA5A5; background: #FFF; color: #0F172A;"></textarea>
                        </div>
                    </template>

                    <!-- ACTION: ACCEPT & FORWARD TO 3 PILLARS (WITH PRESETS) -->
                    <template x-if="dispositionAction === 'accept'">
                        <div style="display: flex; flex-direction: column; gap: 0.65rem; background: #ECFDF5; border: 1.5px solid #6EE7B7; border-radius: 12px; padding: 1rem;">
                            <label style="font-size: 0.75rem; font-weight: 900; color: #065F46;">Tanggapan / Catatan Kajian Resmi (WAJIB DIISI) *</label>

                            <!-- PRESET TEMPLATE BUTTONS FOR ACCEPTANCE -->
                            <div style="display: flex; flex-wrap: wrap; gap: 0.35rem; margin-bottom: 0.25rem;">
                                <button type="button" style="background: #FFF; border: 1px solid #6EE7B7; color: #065F46; font-size: 0.6875rem; padding: 0.25rem 0.5rem; border-radius: 6px; font-weight: 700; cursor: pointer;" @click="acceptResponseText = '[DISETUJUI] Usulan telah disetujui dan diteruskan ke 3 Pilar Manajemen Pengetahuan.'">
                                    ⚡ [Disetujui Diteruskan]
                                </button>
                                <button type="button" style="background: #FFF; border: 1px solid #6EE7B7; color: #065F46; font-size: 0.6875rem; padding: 0.25rem 0.5rem; border-radius: 6px; font-weight: 700; cursor: pointer;" @click="acceptResponseText = '[AGENDA RISET] Usulan masuk dalam prioritas agenda riset dan penyusunan naskah akademis oleh Tim Riset.'">
                                    ⚡ [Masuk Agenda Riset]
                                </button>
                                <button type="button" style="background: #FFF; border: 1px solid #6EE7B7; color: #065F46; font-size: 0.6875rem; padding: 0.25rem 0.5rem; border-radius: 6px; font-weight: 700; cursor: pointer;" @click="acceptResponseText = '[GAGASAN INOVASI] Gagasan disetujui untuk pengkajian SOP dan pengujian pada Bank Inovasi.'">
                                    ⚡ [Rekomendasi Inovasi]
                                </button>
                            </div>

                            <textarea name="official_response" x-model="acceptResponseText" rows="3" required placeholder="Berikan catatan kajian resmi bahwa usulan diterima dan diteruskan..." style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #6EE7B7; background: #FFF; color: #0F172A;"></textarea>
                        </div>
                    </template>

                    <!-- LAMPIRAN SURAT / DOKUMEN DISPOSISI ADMIN (OPTIONAL) -->
                    <div style="background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 12px; padding: 0.85rem;">
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.35rem;">
                            📎 Lampiran Surat Disposisi / Catatan Tambahan Admin (Opsional)
                        </label>
                        <input type="file" name="admin_file" accept=".pdf,.doc,.docx" style="font-size: 0.78125rem; color: #475569;" />
                    </div>

                    <!-- FOOTER TAB 2: KEMBALI & SIMPAN KEPUTUSAN -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem; padding-top: 0.875rem; border-top: 1px solid #E2E8F0;">
                        <button type="button" @click="dispModalTab = 'summary'" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; color: #334155; font-weight: 800; border-radius: 8px; padding: 0.55rem 1.15rem; font-size: 0.8125rem; cursor: pointer; display: flex; align-items: center; gap: 0.4rem;">
                            ⬅️ Kembali ke Ringkasan
                        </button>
                        <div style="display: flex; gap: 0.65rem;">
                            <button type="button" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 700; border-radius: 8px; padding: 0.55rem 1.25rem; cursor: pointer;" @click="selectedProposalDisposition = null">Batal</button>
                            <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.84375rem; padding: 0.55rem 1.5rem; border-radius: 8px; border: 1px solid #C59B27; cursor: pointer; box-shadow: 0 4px 12px rgba(7,39,24,0.2);">
                                💾 Simpan Keputusan Admin & Teruskan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL INSPEKSI DOKUMEN USULAN ORIGINAL PESERTA (selectedSubmissionFullView) -->
    <div x-show="selectedSubmissionFullView !== null" class="modal-overlay" style="display: none;" @click="selectedSubmissionFullView = null">
        <div class="modal-card" style="max-width: 820px; width: 94%; background: #FFF; border: 2px solid #072718; border-radius: 18px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.35);" @click.stop>
            <div style="padding: 1.2rem 1.5rem; background: linear-gradient(135deg, #072718 0%, #0D3E27 100%); border-bottom: 2.5px solid #C59B27; color: #FFF; display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                        <span style="background: #C59B27; color: #072718; font-weight: 900; font-size: 0.75rem; padding: 0.2rem 0.65rem; border-radius: 9999px; letter-spacing: 0.05em;" x-text="selectedSubmissionFullView ? '🎟️ TIKET: ' + selectedSubmissionFullView.ticket_no : ''"></span>
                        <span style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: #FFF; font-size: 0.71875rem; font-weight: 800; padding: 0.15rem 0.55rem; border-radius: 6px;" x-text="selectedSubmissionFullView ? 'Kategori: ' + selectedSubmissionFullView.category : ''"></span>
                    </div>
                    <h3 style="font-size: 1.15rem; font-weight: 900; color: #FFFFFF; line-height: 1.35; margin-top: 0.45rem;" x-text="selectedSubmissionFullView ? selectedSubmissionFullView.title : ''"></h3>
                </div>
                <button @click="selectedSubmissionFullView = null" style="background: rgba(255,255,255,0.15); border: none; color: #FFF; width: 34px; height: 34px; border-radius: 50%; font-size: 1.1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; shrink: 0; margin-left: 1rem;">✕</button>
            </div>

            <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem; max-height: 78vh; overflow-y: auto;">
                <!-- 2-COLUMN METADATA GRID -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <!-- CARD A: IDENTITAS -->
                    <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 12px; padding: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">
                        <div style="font-size: 0.6875rem; font-weight: 900; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">
                            👤 IDENTITAS PESERTA / PENGUSUL
                        </div>
                        <div style="font-size: 1.05rem; font-weight: 900; color: #0F172A; margin-top: 0.35rem;" x-text="selectedSubmissionFullView ? selectedSubmissionFullView.name : ''"></div>
                        <div style="font-size: 0.8125rem; color: #475569; font-weight: 700; margin-top: 0.2rem;" x-text="selectedSubmissionFullView ? (selectedSubmissionFullView.institution || 'Kejaksaan RI') : ''"></div>
                        <div style="margin-top: 0.65rem;">
                            <span style="background: #ECFDF5; border: 1px solid #6EE7B7; color: #065F46; font-size: 0.71875rem; padding: 0.25rem 0.55rem; border-radius: 6px; font-weight: 800; display: inline-block;">
                                🟢 Status: <span x-text="selectedSubmissionFullView ? selectedSubmissionFullView.status : 'Terdaftar'"></span>
                            </span>
                        </div>
                    </div>

                    <!-- CARD B: URAIAN MASALAH AWAL -->
                    <div style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 12px; padding: 1rem;">
                        <div style="font-size: 0.6875rem; font-weight: 900; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">
                            📝 URAIAN & FORMULASI MASALAH AWAL
                        </div>
                        <div style="font-size: 0.84375rem; color: #1E293B; line-height: 1.55; margin-top: 0.35rem; font-weight: 600; white-space: pre-line;" x-text="selectedSubmissionFullView ? (selectedSubmissionFullView.description || selectedSubmissionFullView.summary || 'Uraian gagasan resmi usulan naskah akademis.') : ''"></div>
                    </div>
                </div>

                <!-- CARD C: DOKUMEN LAMPIRAN ORIGINAL & CLEAN VIEWER -->
                <div style="background: #F0F9FF; border: 1.5px solid #7DD3FC; border-radius: 12px; padding: 1rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem;">
                        <div>
                            <div style="font-size: 0.84375rem; font-weight: 900; color: #0369A1; display: flex; align-items: center; gap: 0.35rem;">
                                📁 Dokumen / File Lampiran Asli Pengusul
                            </div>
                            <div style="font-size: 0.75rem; color: #0284C7; font-weight: 700; margin-top: 2px;" x-text="selectedSubmissionFullView ? (selectedSubmissionFullView.file_name || 'Usulan_Original_Peserta.pdf') : ''"></div>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <button type="button" style="background: #0284C7; color: #FFFFFF; font-size: 0.78125rem; font-weight: 800; padding: 0.45rem 0.875rem; border-radius: 8px; border: none; cursor: pointer; box-shadow: 0 2px 4px rgba(2,132,199,0.25);" @click="previewPdfUrl = (selectedSubmissionFullView && selectedSubmissionFullView.file_path ? selectedSubmissionFullView.file_path : '/documents/pb_01.pdf'); selectedSubmissionFullView = null;">
                                👁️ Pratinjau Fullscreen PDF
                            </button>
                            <a :href="selectedSubmissionFullView && selectedSubmissionFullView.file_path ? selectedSubmissionFullView.file_path : '/documents/pb_01.pdf'" target="_blank" style="background: #072718; color: #D4AF37; font-size: 0.78125rem; font-weight: 900; padding: 0.45rem 0.875rem; border-radius: 8px; text-decoration: none; border: 1px solid #C59B27;">
                                📥 Download PDF Original
                            </a>
                        </div>
                    </div>

                    <!-- RESPONSIVE EMBEDDED VIEWER FRAME (NO DOUBLE SCROLLBARS) -->
                    <div style="margin-top: 0.875rem; height: 380px; width: 100%; border-radius: 10px; overflow: hidden; border: 1.5px solid #CBD5E1; background: #525659;">
                        <iframe :src="(selectedSubmissionFullView && selectedSubmissionFullView.file_path ? selectedSubmissionFullView.file_path : '/documents/pb_01.pdf') + '#toolbar=1&navpanes=0'" style="width: 100%; height: 100%; border: none;"></iframe>
                    </div>
                </div>
            </div>

            <div style="padding: 1rem 1.5rem; background: #F8FAFC; border-top: 1px solid #E2E8F0; display: flex; justify-content: flex-end;">
                <button type="button" style="background: #072718; color: #D4AF37; font-weight: 800; font-size: 0.84375rem; padding: 0.55rem 1.5rem; border-radius: 8px; border: 1px solid #C59B27; cursor: pointer;" @click="selectedSubmissionFullView = null">Tutup Inspeksi</button>
            </div>
        </div>
    </div>

    <!-- MODAL LIVE PDF PREVIEWER -->
    <div x-show="previewPdfUrl !== null" class="modal-overlay" style="display: none;" @click="previewPdfUrl = null">
        <div class="modal-card" style="max-width: 900px; width: 95%; background: #FFF; border: 2px solid #072718; color: #0F172A;" @click.stop>
            <div style="padding: 0.875rem 1.25rem; background: #072718; color: #D4AF37; display: flex; justify-content: space-between; align-items: center;">
                <div style="font-weight: 900; font-size: 0.875rem;">👁️ Pratinjau Dokumen PDF</div>
                <button @click="previewPdfUrl = null" style="background: none; border: none; color: #FFF; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>
            <div style="padding: 0.5rem; background: #525659;">
                <iframe :src="previewPdfUrl" style="width: 100%; height: 75vh; border: none; border-radius: 4px;"></iframe>
            </div>
        </div>
    </div>

    <!-- MODAL 1: ADD NEW POLICY BRIEF / KAJIAN (isNewKajianModalOpen) -->
    <div x-show="isNewKajianModalOpen" class="modal-overlay" style="display: none;" @click="isNewKajianModalOpen = false">
        <div class="modal-card" style="max-width: 640px; background: #FFF; border: 2px solid #072718; color: #0F172A;" @click.stop>
            <div style="padding: 1rem 1.25rem; border-bottom: 1.5px solid #E2E8F0; background: #F8FAFC; display: flex; justify-content: space-between; align-items: center;">
                <div style="font-weight: 900; color: #072718; font-size: 1rem;">📄 Buat Naskah Policy Brief Baru</div>
                <button @click="isNewKajianModalOpen = false" style="background: none; border: none; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>
            <form action="{{ route('dashboard.store_kajian') }}" method="POST" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.875rem;">
                @csrf
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Judul Naskah Akademis / Policy Brief *</label>
                    <input type="text" name="title" required placeholder="Judul resmi naskah akademis..." style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Kategori Domain Hukum *</label>
                    <select name="category" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Ringkasan Eksekutif (Executive Summary) *</label>
                    <textarea name="summary" rows="3" required placeholder="Uraian ringkas latar belakang dan formulasi rekomendasi..." style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;"></textarea>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="is_published" value="1" id="kajian_pub_new" checked style="width: 16px; height: 16px;" />
                    <label for="kajian_pub_new" style="font-size: 0.78125rem; font-weight: 800; color: #072718;">👁️ Langsung Publish ke Katalog Publik</label>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                    <button type="button" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 700; border-radius: 8px; padding: 0.5rem 1rem; cursor: pointer;" @click="isNewKajianModalOpen = false">Batal</button>
                    <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.78125rem; padding: 0.5rem 1rem; border-radius: 8px; border: none; cursor: pointer;">Simpan Policy Brief</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: EDIT NASKAH POLICY BRIEF (selectedKajianEdit) -->
    <div x-show="selectedKajianEdit !== null" class="modal-overlay" style="display: none;" @click="selectedKajianEdit = null">
        <div class="modal-card" style="max-width: 600px; background: #FFF; border: 2px solid #072718; color: #0F172A;" @click.stop>
            <div style="padding: 1rem 1.25rem; border-bottom: 1.5px solid #E2E8F0; background: #072718; color: #D4AF37; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="font-size: 0.6875rem; font-weight: 900; color: #D4AF37;" x-text="selectedKajianEdit ? selectedKajianEdit.doc_no : ''"></div>
                    <h3 style="font-size: 1rem; font-weight: 900; color: #FFF;" x-text="selectedKajianEdit ? selectedKajianEdit.title : ''"></h3>
                </div>
                <button @click="selectedKajianEdit = null" style="background: none; border: none; color: #FFF; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>
            <form :action="'/dashboard/policy/update/' + (selectedKajianEdit ? selectedKajianEdit.id : '')" method="POST" enctype="multipart/form-data" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.875rem;">
                @csrf
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Judul Naskah Akademis *</label>
                    <input type="text" name="title" :value="selectedKajianEdit ? selectedKajianEdit.title : ''" required style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Kategori Domain Hukum *</label>
                    <select name="category" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Ringkasan / Abstrak Naskah *</label>
                    <textarea name="summary" rows="3" required style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" x-text="selectedKajianEdit ? selectedKajianEdit.summary : ''"></textarea>
                </div>
                <div style="background: #F8FAFC; border: 1.5px dashed #CBD5E1; border-radius: 8px; padding: 0.75rem;">
                    <label style="font-size: 0.75rem; font-weight: 800; color: #072718; display: block; margin-bottom: 0.25rem;">📄 Unggah / Perbarui Berkas PDF Resmi Naskah (Opsional)</label>
                    <input type="file" name="pdf_file" accept=".pdf" style="width: 100%; font-size: 0.75rem;" />
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="is_published" value="1" id="edit_kajian_pub" :checked="selectedKajianEdit && selectedKajianEdit.is_published" style="width: 16px; height: 16px;" />
                    <label for="edit_kajian_pub" style="font-size: 0.78125rem; font-weight: 800; color: #072718;">👁️ Publikasikan ke Vault Publik</label>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                    <button type="button" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 700; border-radius: 8px; padding: 0.5rem 1rem; cursor: pointer;" @click="selectedKajianEdit = null">Batal</button>
                    <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.78125rem; padding: 0.5rem 1.25rem; border-radius: 8px; border: none; cursor: pointer;">💾 Simpan Perubahan Naskah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT INOVASI (selectedInnovationEdit) -->
    <div x-show="selectedInnovationEdit !== null" class="modal-overlay" style="display: none;" @click="selectedInnovationEdit = null">
        <div class="modal-card" style="max-width: 600px; background: #FFF; border: 2px solid #0284C7; color: #0F172A;" @click.stop>
            <div style="padding: 1rem 1.25rem; border-bottom: 1.5px solid #E2E8F0; background: #F0F9FF; display: flex; justify-content: space-between; align-items: center;">
                <div style="font-weight: 900; color: #0284C7; font-size: 1rem;">✏️ Edit Data & Berkas SOP Inovasi</div>
                <button @click="selectedInnovationEdit = null" style="background: none; border: none; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>
            <form :action="'/dashboard/innovations/update/' + (selectedInnovationEdit ? selectedInnovationEdit.id : '')" method="POST" enctype="multipart/form-data" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.875rem;">
                @csrf
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Judul Inovasi *</label>
                    <input type="text" name="title" :value="selectedInnovationEdit ? selectedInnovationEdit.title : ''" required style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                    <div>
                        <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Nama Inovator / Tim</label>
                        <input type="text" name="innovator_name" :value="selectedInnovationEdit ? selectedInnovationEdit.innovator_name : ''" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Kategori Domain Hukum</label>
                        <select name="category" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Ringkasan Gagasan Inovasi</label>
                    <textarea name="summary" rows="2" :value="selectedInnovationEdit ? selectedInnovationEdit.summary : ''" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;"></textarea>
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Dampak & Indikator Keberhasilan</label>
                    <input type="text" name="impact_description" :value="selectedInnovationEdit ? selectedInnovationEdit.impact_description : ''" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Perbarui File SOP / Modul Inovasi (PDF / DOCX)</label>
                    <input type="file" name="sop_file" accept=".pdf,.docx,.pptx" style="width: 100%; font-size: 0.75rem;" />
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="is_published" value="1" id="edit_inov_pub" :checked="selectedInnovationEdit && selectedInnovationEdit.is_published" style="width: 16px; height: 16px;" />
                    <label for="edit_inov_pub" style="font-size: 0.78125rem; font-weight: 800; color: #0284C7;">👁️ Publikasikan ke Vault Publik</label>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                    <button type="button" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 700; border-radius: 8px; padding: 0.5rem 1rem; cursor: pointer;" @click="selectedInnovationEdit = null">Batal</button>
                    <button type="submit" style="background: #0284C7; color: #FFF; font-weight: 900; font-size: 0.78125rem; padding: 0.5rem 1.25rem; border-radius: 8px; border: none; cursor: pointer;">💾 Simpan Perubahan Inovasi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 3: TAMBAH AKUN ADMIN BARU (isNewUserModalOpen) -->
    <div x-show="isNewUserModalOpen" class="modal-overlay" style="display: none;" @click="isNewUserModalOpen = false">
        <div class="modal-card" style="max-width: 500px; background: #FFF; border: 2px solid #072718; color: #0F172A;" @click.stop>
            <div style="padding: 1rem 1.25rem; border-bottom: 1.5px solid #E2E8F0; background: #F8FAFC; display: flex; justify-content: space-between; align-items: center;">
                <div style="font-weight: 900; color: #072718; font-size: 1rem;">👥 Tambah Akun Administrator Baru</div>
                <button @click="isNewUserModalOpen = false" style="background: none; border: none; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>
            <form action="{{ route('dashboard.users.store') }}" method="POST" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.875rem;">
                @csrf
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Nama Administrator *</label>
                    <input type="text" name="name" required placeholder="Nama & Gelar Admin" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Email Pengguna *</label>
                    <input type="email" name="email" required placeholder="admin@mada-adhyaksa.go.id" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                    <div>
                        <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Role Jabatan *</label>
                        <select name="role" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;">
                            <option value="Tim Riset & Inovasi (Admin)">Tim Riset & Inovasi (Admin)</option>
                            <option value="Ketua Tim Riset">Ketua Tim Riset</option>
                            <option value="Sekretariat Angkatan">Sekretariat Angkatan</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Password Login *</label>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                    <button type="button" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 700; border-radius: 8px; padding: 0.5rem 1rem; cursor: pointer;" @click="isNewUserModalOpen = false">Batal</button>
                    <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.78125rem; padding: 0.5rem 1rem; border-radius: 8px; border: none; cursor: pointer;">Simpan User Admin</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 4: EDIT USER ADMIN (selectedUserEdit) -->
    <div x-show="selectedUserEdit !== null" class="modal-overlay" style="display: none;" @click="selectedUserEdit = null">
        <div class="modal-card" style="max-width: 500px; background: #FFF; border: 2px solid #072718; color: #0F172A;" @click.stop>
            <div style="padding: 1rem 1.25rem; border-bottom: 1.5px solid #E2E8F0; background: #F8FAFC; display: flex; justify-content: space-between; align-items: center;">
                <div style="font-weight: 900; color: #072718; font-size: 1rem;">✏️ Edit Data User Admin</div>
                <button @click="selectedUserEdit = null" style="background: none; border: none; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>
            <form :action="'/dashboard/users/update/' + (selectedUserEdit ? selectedUserEdit.id : '')" method="POST" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.875rem;">
                @csrf
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Nama Administrator *</label>
                    <input type="text" name="name" :value="selectedUserEdit ? selectedUserEdit.name : ''" required style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                </div>
                <div>
                    <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Email Pengguna *</label>
                    <input type="email" name="email" :value="selectedUserEdit ? selectedUserEdit.email : ''" required style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                    <div>
                        <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Role Jabatan *</label>
                        <select name="role" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;">
                            <option value="Tim Riset & Inovasi (Admin)">Tim Riset & Inovasi (Admin)</option>
                            <option value="Ketua Tim Riset">Ketua Tim Riset</option>
                            <option value="Sekretariat Angkatan">Sekretariat Angkatan</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; color: #475569; font-weight: 700;">Password Baru (Opsional)</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tak diubah" style="width: 100%; padding: 0.5rem; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; color: #0F172A;" />
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                    <button type="button" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 700; border-radius: 8px; padding: 0.5rem 1rem; cursor: pointer;" @click="selectedUserEdit = null">Batal</button>
                    <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.78125rem; padding: 0.5rem 1rem; border-radius: 8px; border: none; cursor: pointer;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT KURIKULUM & FILE MODUL (PILAR 3) -->
    <div x-show="selectedCurriculumEdit !== null" class="modal-overlay" style="display: none;" @click="selectedCurriculumEdit = null">
        <div class="modal-card" style="max-width: 580px; border-radius: 20px; background: #FFFFFF; color: #0F172A; border: 2px solid #16A34A;" @click.stop>
            <div style="padding: 1.125rem 1.35rem; border-bottom: 1.5px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center; background: #F0FDF4;">
                <div>
                    <div style="font-size: 0.6875rem; font-weight: 900; color: #16A34A; text-transform: uppercase;">EDIT PILAR 3: KURIKULUM & MATERI</div>
                    <h3 style="font-size: 1rem; font-weight: 900; color: #0F172A;" x-text="selectedCurriculumEdit ? 'Edit: ' + selectedCurriculumEdit.title : 'Edit Modul'"></h3>
                </div>
                <button @click="selectedCurriculumEdit = null" style="background: none; border: none; color: #64748B; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>

            <template x-if="selectedCurriculumEdit">
                <form :action="'{{ url('/dashboard/curriculums/update') }}/' + selectedCurriculumEdit.id" method="POST" enctype="multipart/form-data" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.875rem;">
                    @csrf

                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Judul Materi / Modul *</label>
                        <input type="text" name="title" required :value="selectedCurriculumEdit.title" style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF;" />
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                        <div>
                            <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Bidang Hukum *</label>
                            <select name="subject_category" style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF;">
                                @foreach($categories as $cat)
                                    <option :selected="selectedCurriculumEdit.subject_category === '{{ $cat->name }}'" value="{{ $cat->name }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Jenis Berkas *</label>
                            <select name="file_type" style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF;">
                                <option :selected="selectedCurriculumEdit.file_type === 'Modul PDF'" value="Modul PDF">📚 Modul PDF Akademis</option>
                                <option :selected="selectedCurriculumEdit.file_type === 'Slide PPT'" value="Slide PPT">📊 Slide Paparan PPT</option>
                                <option :selected="selectedCurriculumEdit.file_type === 'Link Google Drive / Cloud'" value="Link Google Drive / Cloud">🔗 Link Google Drive / Cloud</option>
                                <option :selected="selectedCurriculumEdit.file_type === 'Video Pembelajaran'" value="Video Pembelajaran">🎥 Video Pembelajaran</option>
                                <option :selected="selectedCurriculumEdit.file_type === 'Silabus / Juknis'" value="Silabus / Juknis">📋 Silabus / Juknis</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #0284C7; display: block; margin-bottom: 0.25rem;">🔗 Link External / Google Drive</label>
                        <input type="url" name="external_link" :value="selectedCurriculumEdit.external_link" placeholder="https://drive.google.com/file/d/..." style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #0284C7; background: #FFF; outline: none;" />
                    </div>

                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Nama Pengunggah (Pengajar / Peserta)</label>
                        <input type="text" name="uploader_name" :value="selectedCurriculumEdit.uploader_name" style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF;" />
                    </div>

                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Deskripsi / Catatan Modul</label>
                        <textarea name="description" rows="2" style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF;" x-text="selectedCurriculumEdit.description"></textarea>
                    </div>

                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.25rem;">Ganti File Modul / Materi (PDF / PPT / MP4)</label>
                        <input type="file" name="attachment" style="width: 100%; padding: 0.4rem; font-size: 0.75rem; color: #475569;" />
                        <div style="font-size: 0.6875rem; color: #64748B; margin-top: 2px;">File saat ini: <span style="font-weight: 700; color: #16A34A;" x-text="selectedCurriculumEdit.file_path"></span></div>
                    </div>

                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 0.75rem; border-radius: 8px; display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" name="is_verified" value="1" id="curr_edit_pub" :checked="selectedCurriculumEdit.is_verified" style="width: 16px; height: 16px; cursor: pointer;" />
                        <label for="curr_edit_pub" style="font-size: 0.78125rem; font-weight: 800; color: #0F172A; cursor: pointer;">🟢 Verifikasi & Terbitkan Langsung ke Vault Publik</label>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 0.5rem; margin-top: 0.5rem;">
                        <button type="button" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 700; border-radius: 8px; padding: 0.5rem 1rem; font-size: 0.78125rem; cursor: pointer;" @click="selectedCurriculumEdit = null">Batal</button>
                        <button type="submit" style="background: #16A34A; color: #FFF; font-weight: 900; border: none; border-radius: 8px; padding: 0.5rem 1.25rem; font-size: 0.78125rem; cursor: pointer;">💾 Simpan Perubahan</button>
                    </div>
                </form>
            </template>
        </div>
    </div>
    <!-- MODAL POPUP: LIHAT BERKAS & AJUAN PESERTA (FULL PREVIEW) -->
    <div x-show="!!selectedSubmissionFullView" class="modal-overlay" style="display: none;" @click="selectedSubmissionFullView = null">
        <div class="modal-card" style="max-width: 920px; width: 95%; background: #FFF; border: 2px solid #072718; color: #0F172A;" @click.stop>
            <!-- HEADER MODAL -->
            <div style="padding: 1rem 1.25rem; background: #072718; color: #FFF; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="background: #D4AF37; color: #072718; font-size: 0.6875rem; font-weight: 900; padding: 0.15rem 0.5rem; border-radius: 4px;" x-text="selectedSubmissionFullView ? selectedSubmissionFullView.ticket_no : ''"></span>
                        <span style="font-size: 0.75rem; color: #CBD5E1; font-weight: 700;" x-text="selectedSubmissionFullView ? ('Kategori: ' + selectedSubmissionFullView.category) : ''"></span>
                    </div>
                    <h3 style="font-size: 1.05rem; font-weight: 900; color: #D4AF37; margin-top: 4px;" x-text="selectedSubmissionFullView ? selectedSubmissionFullView.title : ''"></h3>
                </div>
                <button @click="selectedSubmissionFullView = null" style="background: none; border: none; color: #FFF; font-size: 1.5rem; cursor: pointer; line-height: 1;">✕</button>
            </div>

            <!-- BODY MODAL -->
            <div style="padding: 1.25rem; max-height: 78vh; overflow-y: auto; display: flex; flex-direction: column; gap: 1.25rem;">
                
                <!-- GRID IDENTITAS PENGUSUL & RINGKASAN ISU -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <!-- KOTAK PENGUSUL -->
                    <div style="background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 1rem;">
                        <div style="font-size: 0.75rem; font-weight: 900; color: #072718; text-transform: uppercase; margin-bottom: 0.5rem;">👤 Identitas Peserta / Pengusul</div>
                        <div style="font-size: 0.9375rem; font-weight: 900; color: #0F172A;" x-text="selectedSubmissionFullView ? selectedSubmissionFullView.name : ''"></div>
                        <div style="font-size: 0.8125rem; color: #475569; font-weight: 700; margin-top: 2px;" x-text="selectedSubmissionFullView ? selectedSubmissionFullView.institution : ''"></div>
                        <div style="margin-top: 0.5rem; font-size: 0.71875rem; color: #64748B;">
                            Status Ajuan: <span style="font-weight: 800; color: #072718;" x-text="selectedSubmissionFullView ? selectedSubmissionFullView.status : ''"></span>
                        </div>
                    </div>

                    <!-- KOTAK URANG MASALAH -->
                    <div style="background: #FFFBF0; border: 1.5px solid #FCD34D; border-radius: 10px; padding: 1rem;">
                        <div style="font-size: 0.75rem; font-weight: 900; color: #92400E; text-transform: uppercase; margin-bottom: 0.5rem;">📝 Uraian & Formulasi Masalah Awal</div>
                        <div style="font-size: 0.8125rem; color: #451A03; line-height: 1.5; font-weight: 600;" x-text="selectedSubmissionFullView ? selectedSubmissionFullView.description : ''"></div>
                    </div>
                </div>

                <!-- PREVIEW PRATINJAU FILE PDF PESERTA -->
                <div style="background: #F1F5F9; border: 2px solid #CBD5E1; border-radius: 12px; padding: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                        <div style="font-size: 0.875rem; font-weight: 900; color: #072718; display: flex; align-items: center; gap: 0.5rem;">
                            <span>📁 Dokumen / File Lampiran Asli Pengusul</span>
                            <span style="font-size: 0.75rem; color: #64748B; font-weight: 600;" x-text="selectedSubmissionFullView && selectedSubmissionFullView.file_name ? ('(' + selectedSubmissionFullView.file_name + ')') : ''"></span>
                        </div>
                        <template x-if="selectedSubmissionFullView && selectedSubmissionFullView.file_path">
                            <a :href="selectedSubmissionFullView ? selectedSubmissionFullView.file_path : '#'" target="_blank" style="background: #072718; color: #D4AF37; font-size: 0.75rem; font-weight: 900; padding: 0.4rem 0.875rem; border-radius: 8px; text-decoration: none;">
                                📥 Download PDF Original
                            </a>
                        </template>
                    </div>

                    <!-- IFRAME PDF VIEWER -->
                    <template x-if="selectedSubmissionFullView && selectedSubmissionFullView.file_path">
                        <div style="border: 1px solid #94A3B8; border-radius: 8px; overflow: hidden; background: #525659;">
                            <iframe :src="selectedSubmissionFullView ? selectedSubmissionFullView.file_path : ''" style="width: 100%; height: 500px; border: none;"></iframe>
                        </div>
                    </template>

                    <template x-if="!selectedSubmissionFullView || !selectedSubmissionFullView.file_path">
                        <div style="text-align: center; color: #94A3B8; padding: 2rem; font-size: 0.8125rem;">
                            Tidak ada berkas PDF lampiran yang dapat dipratinjau.
                        </div>
                    </template>
                </div>

            </div>

            <!-- FOOTER MODAL -->
            <div style="padding: 0.875rem 1.25rem; background: #F8FAFC; border-top: 1.5px solid #E2E8F0; display: flex; justify-content: flex-end;">
                <button type="button" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.8125rem; padding: 0.5rem 1.5rem; border-radius: 8px; border: none; cursor: pointer;" @click="selectedSubmissionFullView = null">
                    Tutup Pratinjau Dokumen
                </button>
            </div>
        </div>
    </div>

</div>

<!-- CHART.JS LIBRARY & INITIALIZATION SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const elDonut = document.getElementById('categoryDonutChart');
        if (elDonut) {
            new Chart(elDonut.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Pidsus & Ekonomi', 'Pidum & Humanisme', 'Datun & Aset', 'Inovasi Digital SPBE'],
                    datasets: [{
                        data: [
                            {{ $pendingProposals->where('category', 'Pidsus & Ekonomi')->count() ?: 3 }},
                            {{ $pendingProposals->where('category', 'Pidum & Humanisme')->count() ?: 2 }},
                            {{ $pendingProposals->where('category', 'Datun & Pemulihan Aset')->count() ?: 1 }},
                            {{ $pendingProposals->where('category', 'Inovasi & Digital SPBE')->count() ?: 2 }}
                        ],
                        backgroundColor: ['#072718', '#0284C7', '#86198F', '#D4AF37'],
                        borderWidth: 2,
                        borderColor: '#FFFFFF'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { family: 'Plus Jakarta Sans', size: 11, weight: 'bold' } } }
                    }
                }
            });
        }

        const elBar = document.getElementById('statusBarChart');
        if (elBar) {
            new Chart(elBar.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['1. Pengajuan', '2. Skrining', '3. Berkas Admin', '4. Terbit & Vault'],
                    datasets: [{
                        label: 'Jumlah Dokumen',
                        data: [
                            {{ $pipelineStages[0]['count'] }},
                            {{ $pipelineStages[1]['count'] }},
                            {{ $pipelineStages[2]['count'] }},
                            {{ $pipelineStages[3]['count'] }}
                        ],
                        backgroundColor: ['#FEF3C7', '#E0F2FE', '#ECFDF5', '#DCFCE7'],
                        borderColor: ['#D4AF37', '#0284C7', '#10B981', '#16A34A'],
                        borderWidth: 2,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        }
    });
</script>
@endsection
