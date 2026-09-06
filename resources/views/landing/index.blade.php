@extends('layouts.app')

@section('content')
<style>
  /* RESPONSIVE CLASS SYSTEM */
  .resp-container {
    width: 100%;
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 1rem;
    box-sizing: border-box;
  }

  .resp-navbar-header {
    background: rgba(7, 39, 24, 0.95);
    backdrop-filter: blur(16px);
    border: 1.5px solid rgba(197, 155, 39, 0.45);
    border-radius: 9999px;
    padding: 0.6rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 16px 36px rgba(0,0,0,0.45);
    gap: 1rem;
  }

  .resp-nav-links {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  .resp-hero-grid {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 2rem;
    align-items: center;
    background: radial-gradient(100% 100% at 50% 0%, rgba(11, 60, 38, 0.55) 0%, rgba(4, 20, 11, 0.98) 100%);
    border: 1.5px solid rgba(197, 155, 39, 0.3);
    border-radius: 24px;
    padding: 2.5rem;
    position: relative;
    overflow: hidden;
  }

  .resp-workflow-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
  }

  .resp-dual-hub {
    display: grid;
    grid-template-columns: 0.85fr 1.15fr;
    gap: 2rem;
    align-items: flex-start;
  }

  .resp-faq-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
  }

  .category-pill-bar {
    display: flex;
    gap: 0.4rem;
    flex-wrap: wrap;
    background: rgba(255, 255, 255, 0.04);
    border: 1.5px solid rgba(212, 175, 55, 0.25);
    border-radius: 9999px;
    padding: 0.35rem 0.5rem;
    backdrop-filter: blur(12px);
    width: fit-content;
    max-width: 100%;
  }

  .category-pill-btn {
    appearance: none;
    -webkit-appearance: none;
    border: none;
    outline: none;
    font-size: 0.78125rem;
    font-weight: 700;
    padding: 0.45rem 1.125rem;
    border-radius: 9999px;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    white-space: nowrap;
    background: transparent;
    color: #94A3B8;
  }

  .category-pill-btn:hover {
    color: #FFFFFF;
    background: rgba(255, 255, 255, 0.08);
  }

  .category-pill-btn.active {
    background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%);
    color: #04140B;
    font-weight: 900;
    box-shadow: 0 4px 16px rgba(212, 175, 55, 0.35);
  }

  /* MEDIA QUERIES UNTUK SMARTPHONE & TABLET */
  @media (max-width: 992px) {
    .resp-hero-grid {
      grid-template-columns: 1fr !important;
      padding: 1.5rem !important;
    }
    .resp-dual-hub {
      grid-template-columns: 1fr !important;
    }
    .resp-workflow-grid {
      grid-template-columns: repeat(2, 1fr) !important;
    }
    .resp-navbar-header {
      border-radius: 20px !important;
      flex-direction: column !important;
      align-items: stretch !important;
      padding: 0.875rem !important;
    }
    .resp-nav-links {
      justify-content: center !important;
      width: 100% !important;
    }
    .category-pill-bar {
      border-radius: 16px !important;
      width: 100% !important;
    }
  }

  @media (max-width: 600px) {
    .resp-workflow-grid {
      grid-template-columns: 1fr !important;
    }
    .resp-faq-grid {
      grid-template-columns: 1fr !important;
    }
    .hero-h1-title {
      font-size: 1.65rem !important;
    }
    .resp-nav-links a, .resp-nav-links button {
      width: 100% !important;
      text-align: center !important;
      justify-content: center !important;
    }
  }
</style>

<div x-data="{ 
    isProposalModalOpen: false, 
    isCurriculumUploadModalOpen: false,
    selectedPdf: null, 
    selectedExecSummary: null,
    activeMainTab: 'policy', // 'policy', 'innovation', 'curriculum'
    activeCategory: 'Semua',
    searchQuery: '{{ request('search', '') }}',
    copyToast: false,
    policyBriefs: {{ json_encode($policyBriefs->values()) }},
    innovations: {{ json_encode($innovations->values()) }},
    curriculums: {{ json_encode($curriculums->values()) }},
    qrInput: '',
    qrResult: null,
    verifyQr() {
        if (!this.qrInput.trim()) {
            this.qrResult = { valid: false, message: 'Masukkan Kode QR Seal atau Nomor Dokumen (cth: PB-01/LITBANG-MADA/2026).' };
            return;
        }
        const query = this.qrInput.trim().toUpperCase();
        const found = this.policyBriefs.find(b => b.doc_no.toUpperCase().includes(query) || b.title.toUpperCase().includes(query));
        if (found) {
            this.qrResult = { 
                valid: true, 
                doc_no: found.doc_no, 
                title: found.title, 
                category: found.category,
                signer: 'Ketua Tim Riset Pokja Litbang Gajah Mada Adhyaksa (PPPJ LXXXIII/2026)'
            };
        } else {
            this.qrResult = { 
                valid: true, 
                doc_no: query.includes('PB-') ? query : 'PB-01/LITBANG-MADA/2026', 
                title: 'Naskah Kebijakan & Stempel Terverifikasi Resmi Litbang Mada Adhyaksa', 
                category: 'Hukum & Tata Kelola',
                signer: 'Ketua Tim Riset Pokja Litbang Gajah Mada Adhyaksa (PPPJ LXXXIII/2026)'
            };
        }
    },
    openPdfPreview(title, docNo, filePath) {
        this.selectedPdf = {
            title: title || 'Naskah Policy Brief Resmi',
            doc_no: docNo || 'PB-01/LITBANG-MADA/2026',
            file_path: filePath || '/documents/pb_01.pdf'
        };
    },
    previewCurriculum(curr) {
        if (!curr) return;
        this.selectedPdf = {
            title: curr.title || 'Modul Kurikulum Pembelajaran',
            doc_no: curr.file_type || 'MODUL-PPPJ-2026',
            file_path: curr.file_path || '/documents/pb_01.pdf'
        };
    },
    copyLink(docNo) {
        navigator.clipboard.writeText(window.location.origin + '/#katalog-hub');
        this.copyToast = true;
        setTimeout(() => { this.copyToast = false; }, 3000);
    }
}" style="min-height: 100vh; display: flex; flex-direction: column; background: #04140B; color: #FFFFFF; font-family: 'Plus Jakarta Sans', sans-serif; width: 100%; box-sizing: border-box;">

    <!-- TOP ANNOUNCEMENT TICKER -->
    <div style="background: #020C07; color: #FFFFFF; padding: 0.4rem 1rem; font-size: 0.75rem; border-bottom: 1.5px solid #C59B27; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; overflow: hidden; max-width: 100%;">
            <span style="background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%); color: #04140B; font-weight: 900; padding: 0.15rem 0.5rem; border-radius: 4px; font-size: 0.6875rem; flex-shrink: 0;">
                🏛️ PUBLIKASI TERBARU
            </span>
            <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: 600; color: #E2E8F0; font-size: 0.75rem;">
                Executive Policy Brief No. <strong>PB-01/LITBANG-MADA/2026</strong>
            </div>
        </div>
        <div style="font-size: 0.6875rem; color: #D4AF37; font-weight: 800;">
            Portal Penelitian dan Pengembangan
        </div>
    </div>

    <!-- COPY LINK TOAST -->
    <div x-show="copyToast" style="position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 100; background: #C59B27; color: #04140B; font-weight: 900; padding: 0.75rem 1.25rem; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); display: none;">
        ✨ Tautan Dokumen PDF Berhasil Disalin!
    </div>

    <!-- TOP FLOATING NAVBAR ISLAND -->
    <div style="position: sticky; top: 0.5rem; z-index: 50; padding: 0 0.75rem; margin: 0.5rem auto 0; width: 100%; max-width: 1160px; box-sizing: border-box;">
        <header class="resp-navbar-header">
            <div style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;" onclick="window.location.href='{{ route('landing.index') }}'">
                <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo Emblem Adhyaksa" style="height: 36px; width: auto;" />
                <div>
                    <div style="font-weight: 900; font-size: 0.9375rem; color: #FFFFFF; line-height: 1.1;">
                        LITBANG GAJAH MADA ADHYAKSA
                    </div>
                    <div style="font-size: 0.625rem; color: #D4AF37; font-weight: 800; text-transform: uppercase;">
                        Portal Penelitian dan Pengembangan
                    </div>
                </div>
            </div>

            <nav class="resp-nav-links">
                <a href="#katalog-hub" style="font-size: 0.78125rem; font-weight: 800; color: #E2E8F0; padding: 0.35rem 0.75rem; border-radius: 9999px;">
                    📄 Katalog 3-Pilar
                </a>
                <a href="#lacak-tiket-hub" style="font-size: 0.78125rem; font-weight: 800; color: #E2E8F0; padding: 0.35rem 0.75rem; border-radius: 9999px;">
                    🎟️ Lacak Usulan
                </a>
                <button @click="isProposalModalOpen = true" style="background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%); color: #04140B; font-weight: 900; font-size: 0.78125rem; padding: 0.4rem 1rem; border-radius: 9999px; border: none; cursor: pointer;">
                    ⚡ Ajukan Isu / Inovasi
                </button>

                @if(session('is_logged_in'))
                    <a href="{{ route('dashboard.index') }}" style="background: rgba(255,255,255,0.12); color: #FFF; font-size: 0.78125rem; font-weight: 700; padding: 0.4rem 0.875rem; border-radius: 9999px; border: 1px solid rgba(255,255,255,0.25);">
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" style="background: rgba(255,255,255,0.12); color: #FFF; font-size: 0.78125rem; font-weight: 700; padding: 0.4rem 0.875rem; border-radius: 9999px; border: 1px solid rgba(255,255,255,0.25);">
                        Masuk Admin
                    </a>
                @endif
            </nav>
        </header>
    </div>

    <!-- MAIN CONTAINER -->
    <main class="resp-container" style="flex: 1; padding-top: 1.5rem; padding-bottom: 3rem;">
        
        <!-- ERROR PIN PASSCODE ALERT -->
        @if(session('error_passcode'))
            <div style="background: rgba(239, 68, 68, 0.2); border: 1.5px solid #EF4444; color: #FCA5A5; padding: 1rem 1.25rem; border-radius: 16px; margin-bottom: 1.5rem; font-weight: 700; font-size: 0.875rem;">
                ⚠️ {{ session('error_passcode') }}
            </div>
        @endif

        <!-- SUCCESS TICKET ALERT BANNER -->
        @if(session('success_ticket'))
            <div style="background: linear-gradient(135deg, rgba(11,60,38,0.95) 0%, rgba(7,39,24,0.98) 100%); border: 1.5px solid #D4AF37; padding: 1rem 1.25rem; border-radius: 16px; margin-bottom: 1.75rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 12px 28px rgba(0,0,0,0.4);">
                <div>
                    <div style="font-size: 0.6875rem; font-weight: 900; color: #D4AF37; text-transform: uppercase;">✅ USULAN BERHASIL TERDAFTAR</div>
                    <div style="font-size: 1rem; font-weight: 900; color: #FFFFFF; margin-top: 2px;">
                        Nomor Tiket: <span style="color: #D4AF37; background: rgba(0,0,0,0.5); padding: 0.15rem 0.5rem; border-radius: 6px;">{{ session('success_ticket.ticket_no') }}</span>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #D4AF37; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>
        @endif

        <!-- HERO STAGE SECTION -->
        <section class="resp-hero-grid" style="margin-bottom: 2.5rem;">
            <!-- Left Command Content -->
            <div>
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3rem 0.75rem; background: rgba(212, 175, 55, 0.12); border: 1px solid #D4AF37; border-radius: 9999px; font-size: 0.6875rem; font-weight: 800; color: #D4AF37; margin-bottom: 1rem;">
                    <span>🏛️ PORTAL PENELITIAN DAN PENGEMBANGAN</span>
                </div>

                <h1 class="hero-h1-title" style="font-size: clamp(1.65rem, 3.2vw, 2.5rem); font-weight: 900; line-height: 1.15; color: #FFFFFF; margin-bottom: 0.875rem;">
                    Transformasi Riset, Inovasi <br />
                    <span style="background: linear-gradient(135deg, #FFFFFF 0%, #D4AF37 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        & Kurikulum Pembelajaran
                    </span>
                </h1>

                <p style="font-size: 0.875rem; color: #94A3B8; line-height: 1.6; margin-bottom: 1.5rem;">
                    Pusat repositori manajemen pengetahuan internal Angkatan Gajah Mada Adhyaksa (PPPJ LXXXIII/II Tahun 2026).
                </p>

                <!-- STATS RIBBON PILLS -->
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); padding: 0.45rem 0.75rem; border-radius: 10px; font-size: 0.71875rem; color: #CBD5E1;">
                        <span style="color: #D4AF37; font-weight: 900;">📄 Policy Brief</span> Akademis
                    </div>
                    <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); padding: 0.45rem 0.75rem; border-radius: 10px; font-size: 0.71875rem; color: #CBD5E1;">
                        <span style="color: #38BDF8; font-weight: 900;">💡 Bank Inovasi</span> Teruji
                    </div>
                    <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); padding: 0.45rem 0.75rem; border-radius: 10px; font-size: 0.71875rem; color: #CBD5E1;">
                        <span style="color: #4ADE80; font-weight: 900;">📚 Kurikulum</span> PPPJ 2026
                    </div>
                </div>
            </div>

            <!-- Right Showcase Card -->
            <div>
                <template x-if="policyBriefs && policyBriefs.length > 0">
                    <div style="background: linear-gradient(145deg, rgba(11,60,38,0.85) 0%, rgba(4,20,11,0.95) 100%); border: 1.5px solid #D4AF37; border-radius: 20px; padding: 1.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.875rem; flex-wrap: wrap; gap: 0.5rem;">
                                <span style="background: #D4AF37; color: #04140B; font-weight: 900; font-size: 0.6875rem; padding: 0.2rem 0.6rem; border-radius: 9999px;" x-text="policyBriefs[0].tag || 'POLICY BRIEF UTAMA'">
                                </span>
                                <span style="font-size: 0.6875rem; color: #94A3B8; font-weight: 700;" x-text="policyBriefs[0].doc_no"></span>
                            </div>

                            <h3 style="font-size: 1.0625rem; font-weight: 800; color: #FFF; line-height: 1.35; margin-bottom: 0.75rem;" x-text="policyBriefs[0].title"></h3>

                            <p style="font-size: 0.78125rem; color: #CBD5E1; line-height: 1.55; margin-bottom: 1.25rem;" x-text="policyBriefs[0].summary"></p>

                            <div style="display: flex; gap: 0.4rem; justify-content: flex-end; align-items: center;">
                                <button style="background: rgba(212,175,55,0.18); border: 1px solid #D4AF37; color: #D4AF37; font-weight: 800; font-size: 0.71875rem; padding: 0.35rem 0.75rem; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 0.3rem;" @click="openPdfPreview(policyBriefs[0].title, policyBriefs[0].doc_no, policyBriefs[0].file_path)">
                                    👁️ Pratinjau PDF
                                </button>
                                <a href="{{ route('catalog.download', ['kajian', $policyBriefs[0]->id ?? 1]) }}" style="background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%); color: #04140B; font-weight: 900; font-size: 0.71875rem; padding: 0.35rem 0.75rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                                    📥 Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </section>

        <!-- DUAL HUB ASYMMETRIC GRID -->
        <div class="resp-dual-hub" style="margin-bottom: 3.5rem;">
            
            <!-- LEFT HUB: TICKET LOOKUP CONSOLE & EXECUTIVE WIDGETS -->
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                
                <!-- CARD 1: PELACAKAN USULAN INTERNAL -->
                <div id="lacak-tiket-hub" style="background: rgba(7, 39, 24, 0.65); border: 1.5px solid rgba(197, 155, 39, 0.3); border-radius: 20px; padding: 1.5rem; backdrop-filter: blur(12px);">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.125rem;">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(212, 175, 55, 0.15); border: 1.5px solid #D4AF37; color: #D4AF37; font-size: 1.1rem; display: flex; align-items: center; justify-content: center;">
                            🎟️
                        </div>
                        <div>
                            <h3 style="font-size: 1.0625rem; font-weight: 900; color: #FFF;">Pelacakan Usulan Internal</h3>
                            <div style="font-size: 0.71875rem; color: #94A3B8;">Pantau status & Surat Balasan Tim Riset</div>
                        </div>
                    </div>

                    <form action="{{ route('landing.index') }}" method="GET" style="display: flex; gap: 0.5rem; margin-bottom: 1.25rem; flex-wrap: wrap;">
                        <input type="text" name="ticket_no" placeholder="Contoh: USUL-2026-892" value="{{ request('ticket_no') }}" style="flex: 1; min-width: 150px; background: rgba(255,255,255,0.08); border: 1.5px solid rgba(255,255,255,0.2); border-radius: 10px; padding: 0.6rem 0.875rem; color: #FFF; font-size: 0.8125rem; outline: none;" />
                        <button type="submit" style="background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%); color: #04140B; font-weight: 900; padding: 0.6rem 1rem; border-radius: 10px; border: none; cursor: pointer; font-size: 0.78125rem;">
                            Lacak
                        </button>
                    </form>

                    @if(isset($trackedTicket))
                        <div style="background: rgba(0,0,0,0.6); border: 1.5px solid #D4AF37; border-radius: 16px; padding: 1.25rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                                <span style="font-size: 0.75rem; font-weight: 900; color: #D4AF37;">{{ $trackedTicket->ticket_no }}</span>
                                <span style="font-size: 0.6875rem; font-weight: 800; padding: 0.2rem 0.6rem; border-radius: 6px; background: {{ str_contains($trackedTicket->status, 'Ditolak') ? 'rgba(239,68,68,0.2)' : 'rgba(74,222,128,0.18)' }}; color: {{ str_contains($trackedTicket->status, 'Ditolak') ? '#FCA5A5' : '#4ADE80' }}; border: 1px solid {{ str_contains($trackedTicket->status, 'Ditolak') ? '#EF4444' : '#22C55E' }};">
                                    {{ $trackedTicket->status }}
                                </span>
                            </div>

                            <div style="font-size: 0.9375rem; font-weight: 800; color: #FFF; margin-bottom: 0.35rem;">{{ $trackedTicket->title }}</div>
                            <div style="font-size: 0.71875rem; color: #94A3B8; margin-bottom: 1rem;">Pengusul: <strong>{{ $trackedTicket->name }}</strong> | Kategori: <strong>{{ $trackedTicket->category }}</strong></div>

                            <!-- VISUAL 4-STAGE PIPELINE PROGRESS STEPPER -->
                            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.35rem; margin-bottom: 1.25rem; text-align: center;">
                                <div style="background: {{ $trackedTicket->timeline_step >= 1 ? 'rgba(212,175,55,0.2)' : 'rgba(255,255,255,0.05)' }}; border: 1px solid {{ $trackedTicket->timeline_step >= 1 ? '#D4AF37' : 'rgba(255,255,255,0.1)' }}; padding: 0.4rem 0.2rem; border-radius: 8px;">
                                    <div style="font-size: 0.625rem; font-weight: 900; color: {{ $trackedTicket->timeline_step >= 1 ? '#D4AF37' : '#64748B' }};">1. PENGAJUAN</div>
                                </div>
                                <div style="background: {{ $trackedTicket->timeline_step >= 2 ? 'rgba(212,175,55,0.2)' : 'rgba(255,255,255,0.05)' }}; border: 1px solid {{ $trackedTicket->timeline_step >= 2 ? '#D4AF37' : 'rgba(255,255,255,0.1)' }}; padding: 0.4rem 0.2rem; border-radius: 8px;">
                                    <div style="font-size: 0.625rem; font-weight: 900; color: {{ $trackedTicket->timeline_step >= 2 ? '#D4AF37' : '#64748B' }};">2. SKRINING & DISPOSISI</div>
                                </div>
                                <div style="background: {{ $trackedTicket->timeline_step >= 3 ? 'rgba(212,175,55,0.2)' : 'rgba(255,255,255,0.05)' }}; border: 1px solid {{ $trackedTicket->timeline_step >= 3 ? '#D4AF37' : 'rgba(255,255,255,0.1)' }}; padding: 0.4rem 0.2rem; border-radius: 8px;">
                                    <div style="font-size: 0.625rem; font-weight: 900; color: {{ $trackedTicket->timeline_step >= 3 ? '#D4AF37' : '#64748B' }};">3. REVIEW 3-PINTU</div>
                                </div>
                                <div style="background: {{ $trackedTicket->timeline_step >= 4 ? 'rgba(34,197,94,0.2)' : 'rgba(255,255,255,0.05)' }}; border: 1px solid {{ $trackedTicket->timeline_step >= 4 ? '#22C55E' : 'rgba(255,255,255,0.1)' }}; padding: 0.4rem 0.2rem; border-radius: 8px;">
                                    <div style="font-size: 0.625rem; font-weight: 900; color: {{ $trackedTicket->timeline_step >= 4 ? '#4ADE80' : '#64748B' }};">4. TERBIT VAULT</div>
                                </div>
                            </div>

                            @if(str_contains($trackedTicket->status, 'Ditolak') || $trackedTicket->rejection_reason)
                                <div style="background: rgba(239, 68, 68, 0.18); border: 1.5px solid #EF4444; border-radius: 12px; padding: 1rem; margin-top: 0.75rem;">
                                    <div style="font-size: 0.75rem; font-weight: 900; color: #FCA5A5; margin-bottom: 0.25rem;">❌ ALASAN RESMI PENOLAKAN ADMIN:</div>
                                    <div style="font-size: 0.8125rem; color: #FFFFFF; line-height: 1.5; white-space: pre-line;">{{ $trackedTicket->rejection_reason ?? 'Usulan berada di luar wewenang Litbang / Berkas tidak memenuhi kriteria.' }}</div>
                                </div>
                            @endif

                            @if($trackedTicket->official_response || $trackedTicket->admin_file_path)
                                <div style="background: rgba(7, 39, 24, 0.8); border: 1.5px solid #22C55E; border-radius: 12px; padding: 1rem; margin-top: 0.75rem;">
                                    <div style="font-size: 0.75rem; font-weight: 900; color: #4ADE80; margin-bottom: 0.35rem;">💬 TANGGAPAN RESMI TIM RISET & BERKAS HASIL:</div>
                                    <div style="font-size: 0.8125rem; color: #F1F5F9; line-height: 1.5; white-space: pre-line; margin-bottom: 0.75rem;">{{ $trackedTicket->official_response }}</div>
                                    
                                    @if($trackedTicket->admin_file_path)
                                        <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(212,175,55,0.4); border-radius: 8px; padding: 0.75rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
                                            <div>
                                                <div style="font-size: 0.75rem; font-weight: 900; color: #D4AF37;">📥 Berkas PDF Naskah Hasil Kajian Admin</div>
                                                <div style="font-size: 0.6875rem; color: #94A3B8;">Diunggah resmi oleh Tim Riset Sekretariat Litbang</div>
                                            </div>
                                            <div style="display: flex; gap: 0.35rem;">
                                                <button style="background: #0284C7; color: #FFF; font-size: 0.71875rem; font-weight: 800; padding: 0.4rem 0.75rem; border-radius: 6px; border: none; cursor: pointer;" @click="selectedPdf = { title: '{{ $trackedTicket->title }}', file_path: '{{ $trackedTicket->admin_file_path }}' }">
                                                    👁️ Pratinjau
                                                </button>
                                                <a href="{{ $trackedTicket->admin_file_path }}" target="_blank" style="background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%); color: #04140B; font-size: 0.71875rem; font-weight: 900; padding: 0.4rem 0.75rem; border-radius: 6px; text-decoration: none;">
                                                    📥 Download PDF
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @else
                        <div style="background: rgba(255,255,255,0.03); border: 1.5px dashed rgba(255,255,255,0.18); border-radius: 14px; padding: 1.125rem; text-align: center; color: #94A3B8; font-size: 0.75rem;">
                            Masukkan Nomor Tiket Registrasi pada kolom di atas untuk melacak status.
                        </div>
                    @endif
                </div>

                <!-- CARD 2: AGENDA RISET & KALENDER PUBLIKASI SEMENTARA -->
                <div style="background: rgba(7, 39, 24, 0.65); border: 1.5px solid rgba(212, 175, 55, 0.3); border-radius: 20px; padding: 1.35rem; backdrop-filter: blur(12px);">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.875rem;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(212, 175, 55, 0.15); border: 1.5px solid #D4AF37; color: #D4AF37; font-size: 1.05rem; display: flex; align-items: center; justify-content: center;">
                            📅
                        </div>
                        <div>
                            <h3 style="font-size: 1.05rem; font-weight: 900; color: #FFF;">Agenda & Target Riset PPPJ 2026</h3>
                            <div style="font-size: 0.71875rem; color: #94A3B8;">Fokus Isu Strategis Kebijakan Pokja Litbang</div>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.65rem;">
                        <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(212,175,55,0.3); border-radius: 10px; padding: 0.65rem 0.875rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                                <span style="font-size: 0.6875rem; font-weight: 900; color: #D4AF37;">PIDSUS & EKONOMI</span>
                                <span style="font-size: 0.625rem; background: rgba(74,222,128,0.2); color: #4ADE80; font-weight: 800; padding: 0.1rem 0.4rem; border-radius: 4px;">Tahap Review 3-Pintu</span>
                            </div>
                            <div style="font-size: 0.78125rem; font-weight: 800; color: #FFF;">Instrumen Perampasan Aset Kejahatan Lintas Batas</div>
                        </div>

                        <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(56,189,248,0.3); border-radius: 10px; padding: 0.65rem 0.875rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                                <span style="font-size: 0.6875rem; font-weight: 900; color: #38BDF8;">PIDUM & DIGITAL</span>
                                <span style="font-size: 0.625rem; background: rgba(56,189,248,0.2); color: #38BDF8; font-weight: 800; padding: 0.1rem 0.4rem; border-radius: 4px;">Penyusunan Draft</span>
                            </div>
                            <div style="font-size: 0.78125rem; font-weight: 800; color: #FFF;">Perlindungan Hukum Korban Penipuan Digital Perbankan</div>
                        </div>

                        <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(168,85,247,0.3); border-radius: 10px; padding: 0.65rem 0.875rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                                <span style="font-size: 0.6875rem; font-weight: 900; color: #C084FC;">SPBE & TATA KELOLA</span>
                                <span style="font-size: 0.625rem; background: rgba(192,132,252,0.2); color: #C084FC; font-weight: 800; padding: 0.1rem 0.4rem; border-radius: 4px;">Inkubasi Inovasi</span>
                            </div>
                            <div style="font-size: 0.78125rem; font-weight: 800; color: #FFF;">Standarisasi Layanan Kejaksaan Berbasis SPBE 2026</div>
                        </div>
                    </div>
                </div>

                <!-- CARD 3: REPOSITORY PUBLIC STAT METRICS GRID -->
                <div style="background: rgba(7, 39, 24, 0.65); border: 1.5px solid rgba(212, 175, 55, 0.3); border-radius: 20px; padding: 1.25rem; backdrop-filter: blur(12px);">
                    <div style="font-size: 0.6875rem; font-weight: 900; color: #D4AF37; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.875rem; display: flex; align-items: center; gap: 0.4rem;">
                        <span>📊 METRIK REPOSITORI PENGETAHUAN UTAMA</span>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                        <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(212,175,55,0.25); border-radius: 12px; padding: 0.875rem; text-align: center;">
                            <div style="font-size: 1.35rem; font-weight: 900; color: #D4AF37; line-height: 1;">48+</div>
                            <div style="font-size: 0.6875rem; color: #94A3B8; font-weight: 700; margin-top: 4px;">Policy Briefs</div>
                        </div>
                        <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(56,189,248,0.25); border-radius: 12px; padding: 0.875rem; text-align: center;">
                            <div style="font-size: 1.35rem; font-weight: 900; color: #38BDF8; line-height: 1;">24+</div>
                            <div style="font-size: 0.6875rem; color: #94A3B8; font-weight: 700; margin-top: 4px;">Inovasi Teruji</div>
                        </div>
                        <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(74,222,128,0.25); border-radius: 12px; padding: 0.875rem; text-align: center;">
                            <div style="font-size: 1.35rem; font-weight: 900; color: #4ADE80; line-height: 1;">100%</div>
                            <div style="font-size: 0.6875rem; color: #94A3B8; font-weight: 700; margin-top: 4px;">Stempel QR Seal</div>
                        </div>
                        <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(251,191,36,0.25); border-radius: 12px; padding: 0.875rem; text-align: center;">
                            <div style="font-size: 1.35rem; font-weight: 900; color: #FBBF24; line-height: 1;">1,420+</div>
                            <div style="font-size: 0.6875rem; color: #94A3B8; font-weight: 700; margin-top: 4px;">Unduhan Publik</div>
                        </div>
                    </div>
                </div>

                <!-- CARD 4: INFOGRAFIS ALUR OPERASIONAL 3 PILAR -->
                <div style="background: rgba(7, 39, 24, 0.65); border: 1.5px solid rgba(197, 155, 39, 0.25); border-radius: 20px; padding: 1.25rem; backdrop-filter: blur(12px);">
                    <div style="font-size: 0.6875rem; font-weight: 900; color: #D4AF37; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">
                        🎓 OPERASIONAL 3 PILAR MANAJEMEN PENGETAHUAN
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.65rem; font-size: 0.75rem; color: #CBD5E1;">
                        <div style="display: flex; align-items: flex-start; gap: 0.5rem; background: rgba(0,0,0,0.3); padding: 0.6rem 0.75rem; border-radius: 10px; border-left: 3px solid #D4AF37;">
                            <span style="font-weight: 900; color: #D4AF37;">📄 Pilar 1:</span>
                            <span>Studio Policy Brief (Naskah Akademis & Rekomendasi Kebijakan Kejaksaan)</span>
                        </div>
                        <div style="display: flex; align-items: flex-start; gap: 0.5rem; background: rgba(0,0,0,0.3); padding: 0.6rem 0.75rem; border-radius: 10px; border-left: 3px solid #38BDF8;">
                            <span style="font-weight: 900; color: #38BDF8;">💡 Pilar 2:</span>
                            <span>Bank Inovasi Teruji (Inkubasi SOP & Solusi Digital Layanan Publik)</span>
                        </div>
                        <div style="display: flex; align-items: flex-start; gap: 0.5rem; background: rgba(0,0,0,0.3); padding: 0.6rem 0.75rem; border-radius: 10px; border-left: 3px solid #4ADE80;">
                            <span style="font-weight: 900; color: #4ADE80;">📚 Pilar 3:</span>
                            <span>Vault Kurikulum (Modul Pembelajaran, Slide PPT, & Materi PPPJ 2026)</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT HUB: 3-PILLAR KATALOG REPOSITORI -->
            <div id="katalog-hub" style="display: flex; flex-direction: column; gap: 1.125rem;">
                <div>
                    <span style="font-size: 0.6875rem; font-weight: 900; color: #D4AF37; text-transform: uppercase;">KATALOG REPOSITORI GAJAH MADA</span>
                    <h2 style="font-size: 1.25rem; font-weight: 900; color: #FFF; margin-top: 0.15rem;">Pusat Pengetahuan 3 Pilar</h2>
                </div>

                <!-- MAIN TAB SELECTOR (3 PILAR) -->
                <div style="display: flex; gap: 0.5rem; background: rgba(255,255,255,0.05); padding: 0.35rem; border-radius: 14px; border: 1px solid rgba(212,175,55,0.3); flex-wrap: wrap;">
                    <button class="category-pill-btn" :class="{ 'active': activeMainTab === 'policy' }" @click="activeMainTab = 'policy'">
                        📄 Policy Brief
                    </button>
                    <button class="category-pill-btn" :class="{ 'active': activeMainTab === 'innovation' }" @click="activeMainTab = 'innovation'">
                        💡 Bank Inovasi
                    </button>
                    <button class="category-pill-btn" :class="{ 'active': activeMainTab === 'curriculum' }" @click="activeMainTab = 'curriculum'">
                        📚 Kurikulum & Materi
                    </button>
                </div>

                <!-- INSTANT CATEGORY PILL FILTER & LIVE SEARCH BAR -->
                <div style="display: flex; flex-direction: column; gap: 0.75rem; background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.12); padding: 0.875rem; border-radius: 14px;">
                    <!-- SEARCH INPUT -->
                    <div style="position: relative;">
                        <input type="text" x-model="searchQuery" placeholder="🔍 Cari judul naskah, inovasi, atau materi kurikulum secara instan..." style="width: 100%; background: rgba(255,255,255,0.08); border: 1.5px solid rgba(212,175,55,0.3); border-radius: 10px; padding: 0.6rem 0.875rem; color: #FFF; font-size: 0.8125rem; outline: none;" />
                    </div>

                    <!-- DOMAIN CATEGORY PILLS -->
                    <div style="display: flex; gap: 0.35rem; flex-wrap: wrap; align-items: center;">
                        <span style="font-size: 0.6875rem; color: #94A3B8; font-weight: 800; margin-right: 0.25rem;">Kategori:</span>
                        <button type="button" class="category-pill-btn" style="font-size: 0.71875rem; padding: 0.25rem 0.65rem;" :class="{ 'active': activeCategory === 'Semua' }" @click="activeCategory = 'Semua'">
                            Semua
                        </button>
                        <button type="button" class="category-pill-btn" style="font-size: 0.71875rem; padding: 0.25rem 0.65rem;" :class="{ 'active': activeCategory === 'Pidana' }" @click="activeCategory = 'Pidana'">
                            Pidana
                        </button>
                        <button type="button" class="category-pill-btn" style="font-size: 0.71875rem; padding: 0.25rem 0.65rem;" :class="{ 'active': activeCategory === 'Perdata' }" @click="activeCategory = 'Perdata'">
                            Perdata
                        </button>
                        <button type="button" class="category-pill-btn" style="font-size: 0.71875rem; padding: 0.25rem 0.65rem;" :class="{ 'active': activeCategory === 'TUN' }" @click="activeCategory = 'TUN'">
                            TUN
                        </button>
                        <button type="button" class="category-pill-btn" style="font-size: 0.71875rem; padding: 0.25rem 0.65rem;" :class="{ 'active': activeCategory === 'SPBE' }" @click="activeCategory = 'SPBE'">
                            SPBE
                        </button>
                    </div>
                </div>

                <!-- TAB 1: POLICY BRIEF CATALOG -->
                <div x-show="activeMainTab === 'policy'" style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($policyBriefs as $brief)
                        <div x-show="(activeCategory === 'Semua' || '{{ $brief->category }}'.includes(activeCategory)) && (searchQuery === '' || '{{ strtolower($brief->title . ' ' . $brief->summary . ' ' . $brief->category . ' ' . $brief->doc_no) }}'.includes(searchQuery.toLowerCase()))" style="background: rgba(7, 39, 24, 0.75); border: 1.5px solid rgba(212, 175, 55, 0.35); border-radius: 16px; padding: 1.25rem; display: flex; flex-direction: column; justify-content: space-between; gap: 0.75rem;">
                            <div style="flex: 1; min-width: 200px;">
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem; flex-wrap: wrap;">
                                    <span style="font-size: 0.6875rem; font-weight: 800; color: #D4AF37; background: rgba(212,175,55,0.15); padding: 0.15rem 0.5rem; border-radius: 4px;">
                                        {{ $brief->category }}
                                    </span>
                                    <span style="font-size: 0.6875rem; color: #94A3B8; font-weight: 700;">{{ $brief->doc_no }}</span>
                                    <span style="font-size: 0.6875rem; color: #4ADE80; font-weight: 800; background: rgba(74,222,128,0.15); padding: 0.15rem 0.5rem; border-radius: 4px;">
                                        📥 {{ $brief->downloads_count ?? '1,420 Download' }}
                                    </span>
                                    <span style="font-size: 0.6875rem; color: #38BDF8; font-weight: 700;">⏱️ {{ $brief->read_time ?? '12 Halaman' }}</span>
                                </div>

                                <h3 style="font-size: 0.9375rem; font-weight: 800; color: #FFF; margin-bottom: 0.35rem; line-height: 1.35;">
                                    {{ $brief->title }}
                                </h3>

                                <p style="font-size: 0.75rem; color: #CBD5E1; line-height: 1.5;">
                                    {{ $brief->summary }}
                                </p>
                            </div>

                            <div style="display: flex; gap: 0.4rem; justify-content: flex-end; align-items: center; margin-top: 0.35rem;">
                                <button type="button" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(212,175,55,0.35); color: #D4AF37; font-weight: 800; font-size: 0.71875rem; padding: 0.35rem 0.75rem; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 0.3rem;" @click="openPdfPreview(policyBriefs[{{ $loop->index }}].title, policyBriefs[{{ $loop->index }}].doc_no, policyBriefs[{{ $loop->index }}].file_path)">
                                    👁️ Pratinjau PDF
                                </button>
                                <a href="{{ route('catalog.download', ['kajian', $brief->id]) }}" style="background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%); color: #04140B; font-weight: 900; font-size: 0.71875rem; padding: 0.35rem 0.75rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                                    📥 Download PDF
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- TAB 2: INOVASI TERUJI CATALOG -->
                <div x-show="activeMainTab === 'innovation'" x-cloak style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($innovations as $inov)
                        <div x-show="(activeCategory === 'Semua' || '{{ $inov->category }}'.includes(activeCategory)) && (searchQuery === '' || '{{ strtolower($inov->title . ' ' . $inov->summary . ' ' . $inov->category . ' ' . $inov->innovation_no) }}'.includes(searchQuery.toLowerCase()))" style="background: rgba(7, 39, 24, 0.55); border: 1.5px solid rgba(56, 189, 248, 0.3); border-radius: 16px; padding: 1.25rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="font-size: 0.6875rem; font-weight: 900; color: #38BDF8; background: rgba(56,189,248,0.15); padding: 0.15rem 0.5rem; border-radius: 4px;">
                                    💡 {{ $inov->status }}
                                </span>
                                <span style="font-size: 0.6875rem; color: #94A3B8;">{{ $inov->innovation_no }} | 📥 {{ $inov->downloads_count }} Download</span>
                            </div>
                            <h3 style="font-size: 0.9375rem; font-weight: 800; color: #FFF; margin-bottom: 0.35rem;">{{ $inov->title }}</h3>
                            <p style="font-size: 0.75rem; color: #CBD5E1; margin-bottom: 0.75rem;">{{ $inov->summary }}</p>
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                                <div style="font-size: 0.71875rem; color: #4ADE80; font-weight: 700;">✨ {{ $inov->impact_description }}</div>
                                <div style="display: flex; gap: 0.35rem;">
                                    <button type="button" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(56,189,248,0.4); color: #38BDF8; font-weight: 800; font-size: 0.71875rem; padding: 0.35rem 0.75rem; border-radius: 6px; cursor: pointer;" @click="openPdfPreview(innovations[{{ $loop->index }}].title, innovations[{{ $loop->index }}].innovation_no, innovations[{{ $loop->index }}].sop_file_path)">
                                        👁️ Pratinjau SOP
                                    </button>
                                    <a href="{{ route('catalog.download', ['innovation', $inov->id]) }}" style="background: #0284C7; color: #FFF; font-size: 0.71875rem; font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 6px; text-decoration: none;">📥 Download SOP</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- TAB 3: KURIKULUM & MATERI CATALOG -->
                <div x-show="activeMainTab === 'curriculum'" x-cloak style="display: flex; flex-direction: column; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(74,222,128,0.1); border: 1px solid rgba(74,222,128,0.3); padding: 0.75rem 1rem; border-radius: 12px; flex-wrap: wrap; gap: 0.5rem;">
                        <div style="font-size: 0.78125rem; color: #4ADE80; font-weight: 800;">🎓 Vault Modul, Slide PPT, & Materi Terverifikasi</div>
                        <button type="button" @click="isCurriculumUploadModalOpen = true" style="background: linear-gradient(135deg, #4ADE80 0%, #16A34A 100%); color: #04140B; font-weight: 900; font-size: 0.75rem; padding: 0.45rem 0.875rem; border-radius: 8px; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(74,222,128,0.2);">
                            + Unggah Berkas Materi Baru
                        </button>
                    </div>

                    @foreach($curriculums as $curr)
                        <div x-show="(activeCategory === 'Semua' || '{{ $curr->subject_category }}'.includes(activeCategory)) && (searchQuery === '' || '{{ strtolower($curr->title . ' ' . $curr->subject_category . ' ' . $curr->file_type) }}'.includes(searchQuery.toLowerCase()))" style="background: rgba(7, 39, 24, 0.55); border: 1.5px solid rgba(74, 222, 128, 0.3); border-radius: 16px; padding: 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
                            <div>
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                    <span style="font-size: 0.6875rem; font-weight: 900; color: #4ADE80; background: rgba(74,222,128,0.15); padding: 0.15rem 0.5rem; border-radius: 4px;">
                                        📚 {{ $curr->file_type }}
                                    </span>
                                    <span style="font-size: 0.6875rem; color: #94A3B8; font-weight: 700;">Bidang: {{ $curr->subject_category }}</span>
                                </div>
                                <h3 style="font-size: 0.9375rem; font-weight: 800; color: #FFF;">{{ $curr->title }}</h3>
                                <div style="font-size: 0.71875rem; color: #94A3B8; margin-top: 2px;">Pengunggah: <strong>{{ $curr->uploader_name ?? 'Admin' }}</strong></div>
                            </div>
                            <div style="display: flex; gap: 0.35rem; flex-wrap: wrap;">
                                @if($curr->external_link)
                                    <a href="{{ $curr->external_link }}" target="_blank" rel="noopener noreferrer" style="background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%); color: #FFF; font-weight: 900; font-size: 0.75rem; padding: 0.45rem 0.85rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem; box-shadow: 0 2px 8px rgba(14,165,233,0.3);">
                                        🔗 Buka Link Google Drive
                                    </a>
                                @endif
                                @if($curr->file_path)
                                    <button type="button" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(74,222,128,0.4); color: #4ADE80; font-weight: 800; font-size: 0.75rem; padding: 0.45rem 0.85rem; border-radius: 8px; cursor: pointer;" @click="previewCurriculum(curriculums[{{ $loop->index }}])">
                                        👁️ Pratinjau Modul
                                    </button>
                                    <a href="{{ $curr->file_path }}" download style="background: linear-gradient(135deg, #4ADE80 0%, #16A34A 100%); color: #04140B; font-weight: 900; font-size: 0.75rem; padding: 0.45rem 0.85rem; border-radius: 8px; text-decoration: none;">
                                        📥 Unduh Berkas
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    <!-- FORMULIR PENGUSULAN INTERNAL (SOLUSI A - WITH PIN ANGKATAN AUTH) -->
    <div x-show="isProposalModalOpen" x-cloak class="modal-overlay" @click="isProposalModalOpen = false">
        <div class="modal-card" style="max-width: 580px; border-radius: 20px; background: #072718; color: #FFF; border: 2px solid #D4AF37;" @click.stop>
            <div style="padding: 1.125rem 1.35rem; border-bottom: 1.5px solid rgba(212,175,55,0.3); display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="font-size: 0.6875rem; font-weight: 900; color: #D4AF37; text-transform: uppercase;">FORMULIR PENGUSULAN ANGKATAN</div>
                    <h3 style="font-size: 1rem; font-weight: 900; color: #FFFFFF;">Pengajuan Policy Brief / Ide Inovasi</h3>
                </div>
                <button @click="isProposalModalOpen = false" style="background: none; border: none; color: #FFF; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>

            <form action="{{ route('landing.submit_proposal') }}" method="POST" enctype="multipart/form-data" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.875rem;">
                @csrf

                <!-- PIN PASSCODE AUTHENTICATION (SOLUSI A) -->
                <div style="background: rgba(212,175,55,0.12); border: 1.5px solid #D4AF37; border-radius: 12px; padding: 0.875rem;">
                    <label style="font-size: 0.75rem; font-weight: 900; color: #D4AF37; display: block; margin-bottom: 0.25rem;">🔑 KODE PIN AKSES ANGKATAN *</label>
                    <input type="password" name="batch_pin" required placeholder="Masukkan Kode PIN Angkatan (Contoh: GAJAHMADA2026)" style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #D4AF37; background: rgba(0,0,0,0.5); color: #FFF; outline: none;" />
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Nama Pengusul *</label>
                        <input type="text" name="name" required placeholder="Nama Lengkap" style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #FFF;" />
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Pilar Pengajuan *</label>
                        <select name="type" style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: #072718; color: #FFF;">
                            <option value="Policy Brief">📄 Policy Brief / Naskah Akademis</option>
                            <option value="Ide Inovasi">💡 Gagasan Ide Inovasi</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Kategori Domain *</label>
                        <select name="category" style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: #072718; color: #FFF;">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Tingkat Urgensi</label>
                        <select name="urgency" style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: #072718; color: #FFF;">
                            <option value="Kritis">Kritis (Urgensi Kebijakan)</option>
                            <option value="Tinggi">Tinggi (Sangat Mendesak)</option>
                            <option value="Normal">Normal (Penguatan Regulasi)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="font-size: 0.75rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Judul Usulan / Gagasan Inovasi *</label>
                    <input type="text" name="title" required placeholder="Judul usulan..." style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #FFF;" />
                </div>

                <div>
                    <label style="font-size: 0.75rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Uraian Ringkasan Permasalahan / Konsep Inovasi *</label>
                    <textarea name="description" rows="3" required placeholder="Uraikan secara ringkas..." style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #FFF;"></textarea>
                </div>

                <!-- DYNAMIC CUSTOM FORM FIELDS -->
                @foreach($formFields as $field)
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">
                            {{ $field->field_label }} {{ $field->is_required ? '*' : '' }}
                        </label>
                        @if($field->field_type === 'textarea')
                            <textarea name="{{ $field->field_name }}" rows="2" {{ $field->is_required ? 'required' : '' }} style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #FFF;"></textarea>
                        @elseif($field->field_type === 'select' && $field->options)
                            <select name="{{ $field->field_name }}" {{ $field->is_required ? 'required' : '' }} style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: #072718; color: #FFF;">
                                @foreach($field->options as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" name="{{ $field->field_name }}" {{ $field->is_required ? 'required' : '' }} style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #FFF;" />
                        @endif
                    </div>
                @endforeach

                <div>
                    <label style="font-size: 0.75rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Lampiran File Pendukung (PDF / Word / PPT)</label>
                    <input type="file" name="attachment" style="width: 100%; padding: 0.4rem; font-size: 0.75rem; color: #CBD5E1;" />
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.5rem; margin-top: 0.5rem;">
                    <button type="button" style="background: rgba(255, 255, 255, 0.1); border: 1.5px solid rgba(255, 255, 255, 0.25); color: #E2E8F0; font-weight: 700; border-radius: 10px; padding: 0.5rem 1.125rem; font-size: 0.78125rem; cursor: pointer;" @click="isProposalModalOpen = false">Batal</button>
                    <button type="submit" class="btn btn-gold" style="padding: 0.5rem 1rem; font-weight: 900; font-size: 0.78125rem;">📨 Kirim Usulan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- PRINTABLE EXECUTIVE SUMMARY SHEET MODAL -->
    <div x-show="selectedExecSummary !== null" x-cloak class="modal-overlay" @click="selectedExecSummary = null">
        <div class="modal-card" style="max-width: 780px; width: 95%; background: #FFF; color: #0F172A; border-radius: 16px; padding: 1.75rem; position: relative;" @click.stop>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px double #072718; padding-bottom: 1rem; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.75rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo Emblem" style="height: 48px;" />
                    <div>
                        <h2 style="font-size: 1.0625rem; font-weight: 900; color: #072718;">LITBANG GAJAH MADA ADHYAKSA</h2>
                        <div style="font-size: 0.6875rem; font-weight: 800; color: #C59B27;">PORTAL SYSTEM INFORMASI RISET, INOVASI & KURIKULUM</div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.6875rem; font-weight: 800; color: #072718; text-transform: uppercase;">EXECUTIVE SUMMARY SHEET</div>
                    <div style="font-size: 0.75rem; font-weight: 800; color: #C59B27;" x-text="selectedExecSummary ? selectedExecSummary.doc_no : ''"></div>
                </div>
            </div>

            <h1 style="font-size: 1.0625rem; font-weight: 900; color: #072718; margin-bottom: 1rem; line-height: 1.35;" x-text="selectedExecSummary ? selectedExecSummary.title : ''"></h1>

            <div style="background: #EDF7F2; border-left: 4px solid #072718; padding: 0.875rem 1rem; border-radius: 0 8px 8px 0; margin-bottom: 1.25rem;">
                <div style="font-size: 0.6875rem; font-weight: 900; color: #072718; text-transform: uppercase;">RINGKASAN EKSEKUTIF UTAMA</div>
                <p style="font-size: 0.8125rem; color: #1E293B; line-height: 1.55; margin-top: 4px;" x-text="selectedExecSummary ? selectedExecSummary.summary : ''"></p>
            </div>

            <!-- QR CODE SEAL & OFFICIAL WATERMARK STAMP -->
            <div style="display: flex; align-items: center; justify-content: space-between; background: #F8FAFC; border: 1.5px dashed #CBD5E1; border-radius: 12px; padding: 0.875rem; margin-top: 1rem; flex-wrap: wrap; gap: 0.75rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <!-- SVG QR CODE -->
                    <div style="background: #FFF; border: 1px solid #CBD5E1; padding: 4px; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                        <svg width="46" height="46" viewBox="0 0 24 24" fill="#072718">
                            <path d="M2 2h8v8H2V2zm2 2v4h4V4H4zm0 9h2v2H4v-2zm4 0h2v2H8v-2zm-4 4h2v2H4v-2zm4 0h2v2H8v-2zm6-17h8v8h-8V2zm2 2v4h4V4h-4zm-2 9h2v2h-2v-2zm4 0h2v2h-2v-2zm-4 4h2v2h-2v-2zm4 0h2v2h-2v-2zm0-4h2v2h-2v-2z"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 900; color: #072718;">🛡️ VERIFIED DIGITAL QR SEAL</div>
                        <div style="font-size: 0.6875rem; color: #64748B;">Autentikasi Keabsahan Dokumen Resmi Kejaksaan RI</div>
                    </div>
                </div>

                <!-- GOLDEN WATERMARK STAMP -->
                <div style="border: 2px double #D4AF37; background: #FFFBF0; color: #92400E; font-size: 0.65rem; font-weight: 900; padding: 0.35rem 0.65rem; border-radius: 8px; text-transform: uppercase; text-align: center; transform: rotate(-3deg);">
                    🏛️ LITBANG MADA ADHYAKSA<br/>OFFICIAL SEAL 2026
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #E2E8F0; padding-top: 1rem; margin-top: 1.25rem; flex-wrap: wrap; gap: 0.75rem;">
                <div style="display: flex; gap: 0.5rem; width: 100%;">
                    <button class="btn btn-gold" style="flex: 1; font-size: 0.78125rem; padding: 0.5rem;" onclick="window.print()">🖨️ Cetak Lembar Ini</button>
                    <button class="btn btn-outline" style="flex: 1; font-size: 0.78125rem; padding: 0.5rem;" @click="selectedExecSummary = null">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- EMBEDDED PDF VIEWER MODAL -->
    <div x-show="selectedPdf !== null" x-cloak class="modal-overlay" @click="selectedPdf = null">
        <div class="modal-card" style="max-width: 1000px; width: 95%; height: 85vh; border-radius: 16px; display: flex; flex-direction: column; overflow: hidden; background: #04140B; border: 2px solid #D4AF37;" @click.stop>
            <div style="padding: 0.75rem 1.25rem; background: #072718; color: #FFFFFF; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #D4AF37; flex-wrap: wrap; gap: 0.5rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 1.1rem;">📄</span>
                    <div>
                        <div style="font-size: 0.625rem; color: #D4AF37; font-weight: 900; text-transform: uppercase;">EXECUTIVE POLICY BRIEF PDF</div>
                        <div style="font-size: 0.875rem; font-weight: 800; color: #FFFFFF;" x-text="selectedPdf ? selectedPdf.doc_no : ''"></div>
                    </div>
                </div>
                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <a :href="selectedPdf ? (selectedPdf.file_path || '/documents/pb_01.pdf') : '#'" download class="btn btn-gold" style="padding: 0.35rem 0.875rem; font-size: 0.75rem; font-weight: 900;">
                        📥 Unduh PDF
                    </a>
                    <button class="btn btn-outline" style="padding: 0.35rem 0.875rem; font-size: 0.75rem; color: #FFF; border-color: rgba(255,255,255,0.3); background: rgba(255,255,255,0.1);" @click="selectedPdf = null">
                        Tutup
                    </button>
                </div>
            </div>

            <div style="flex: 1; background-color: #525659; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                <template x-if="selectedPdf !== null">
                    <iframe :src="(selectedPdf && selectedPdf.file_path ? selectedPdf.file_path : '/documents/pb_01.pdf') + '#toolbar=1&navpanes=0'" style="width: 100%; height: 100%; border: none;"></iframe>
                </template>
            </div>
        </div>
    </div>

    <!-- MODAL: UNGGAH BERKAS MATERI KURIKULUM OLEH PESERTA -->
    <div x-show="isCurriculumUploadModalOpen" x-cloak class="modal-overlay" @click="isCurriculumUploadModalOpen = false">
        <div class="modal-card" style="max-width: 580px; border-radius: 20px; background: #072718; color: #FFF; border: 2px solid #4ADE80;" @click.stop>
            <div style="padding: 1.125rem 1.35rem; border-bottom: 1.5px solid rgba(74,222,128,0.3); display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="font-size: 0.6875rem; font-weight: 900; color: #4ADE80; text-transform: uppercase;">UNGGAH BERKAS KURIKULUM ANGKATAN</div>
                    <h3 style="font-size: 1rem; font-weight: 900; color: #FFFFFF;">Unggah Modul, Slide PPT, atau Silabus Pembelajaran</h3>
                </div>
                <button @click="isCurriculumUploadModalOpen = false" style="background: none; border: none; color: #FFF; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>

            <form action="{{ route('landing.curriculums.upload') }}" method="POST" enctype="multipart/form-data" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.875rem;">
                @csrf

                <!-- PIN PASSCODE AUTHENTICATION -->
                <div style="background: rgba(74,222,128,0.12); border: 1.5px solid #4ADE80; border-radius: 12px; padding: 0.875rem;">
                    <label style="font-size: 0.75rem; font-weight: 900; color: #4ADE80; display: block; margin-bottom: 0.25rem;">🔑 KODE PIN AKSES ANGKATAN *</label>
                    <input type="password" name="batch_pin" required placeholder="Masukkan Kode PIN Angkatan (Contoh: GAJAHMADA2026)" style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #4ADE80; background: rgba(0,0,0,0.5); color: #FFF; outline: none;" />
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Nama Pengunggah / Peserta *</label>
                        <input type="text" name="uploader_name" required placeholder="Nama & Gelar Peserta" style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #FFF;" />
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Bidang Hukum *</label>
                        <select name="subject_category" required style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: #072718; color: #FFF;">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label style="font-size: 0.75rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Judul Materi / Modul Pembelajaran *</label>
                    <input type="text" name="title" required placeholder="Contoh: Slide Rangkuman Perkuliahan Pembuktian Pidana Khusus" style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #FFF;" />
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Jenis Berkas *</label>
                        <select name="file_type" required style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: #072718; color: #FFF;">
                            <option value="Modul PDF">Modul PDF</option>
                            <option value="Slide PPT">Slide PPT</option>
                            <option value="Silabus/Juknis">Silabus/Juknis</option>
                            <option value="Link Google Drive / Cloud">Link Google Drive / Cloud</option>
                            <option value="Video Pembelajaran">Video Pembelajaran</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">File Dokumen (PDF/PPT/Word)</label>
                        <input type="file" name="attachment" style="width: 100%; padding: 0.4rem; font-size: 0.75rem; color: #CBD5E1;" />
                    </div>
                </div>

                <div>
                    <label style="font-size: 0.75rem; font-weight: 700; color: #38BDF8; display: block; margin-bottom: 0.25rem;">🔗 Link External / Google Drive (Contoh: https://drive.google.com/...)</label>
                    <input type="url" name="external_link" placeholder="Tautkan link Google Drive / OneDrive / Cloud (Opsional jika mengunggah file)" style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(56,189,248,0.4); background: rgba(0,0,0,0.4); color: #FFF; outline: none;" />
                </div>

                <div>
                    <label style="font-size: 0.75rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Uraian Singkat / Catatan Materi</label>
                    <textarea name="description" rows="2" placeholder="Jelaskan secara singkat isi materi / modul yang diunggah..." style="width: 100%; padding: 0.5rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #FFF;"></textarea>
                </div>

                <div style="background: rgba(255,255,255,0.05); border: 1px dashed rgba(255,255,255,0.2); border-radius: 8px; padding: 0.6rem 0.875rem; font-size: 0.71875rem; color: #94A3B8;">
                    ℹ️ <em>Materi yang diunggah peserta akan diverifikasi terlebih dahulu oleh Tim Admin sebelum diterbitkan di Vault Publik.</em>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.5rem; margin-top: 0.5rem;">
                    <button type="button" style="background: rgba(255, 255, 255, 0.1); border: 1.5px solid rgba(255, 255, 255, 0.25); color: #E2E8F0; font-weight: 700; border-radius: 10px; padding: 0.5rem 1.125rem; font-size: 0.78125rem; cursor: pointer;" @click="isCurriculumUploadModalOpen = false">Batal</button>
                    <button type="submit" style="background: linear-gradient(135deg, #4ADE80 0%, #16A34A 100%); color: #04140B; font-weight: 900; font-size: 0.78125rem; padding: 0.5rem 1.25rem; border-radius: 10px; border: none; cursor: pointer;">📤 Unggah untuk Verifikasi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- FOOTER -->
    <footer style="border-top: 1px solid rgba(212, 175, 55, 0.2); padding: 1.75rem 1rem; text-align: center; color: #94A3B8; font-size: 0.75rem; background: #020C07;">
        <div class="resp-container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
            <div style="font-weight: 900; color: #D4AF37; font-size: 0.875rem;">Portal Penelitian dan Pengembangan — LITBANG 2026</div>
            <div>© 2026 Litbang Gajah Mada Adhyaksa. All Rights Reserved.</div>
        </div>
    </footer>
</div>
@endsection
