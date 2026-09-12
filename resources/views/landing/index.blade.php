@extends('layouts.app')

@section('content')
<style>
  /* RESPONSIVE FRESH ORGANIC GREEN SYSTEM (80% SCALE MATCHING REFERENCE) */
  :root {
    --color-emerald-dark: #1E4620;
    --color-emerald-medium: #2E6F40;
    --color-emerald-light: #4A8F54;
    --color-emerald-mint: #EBF3EC;
    --color-emerald-soft: #F4F8F4;
    --color-accent-gold: #D4AF37;
    --color-accent-gold-dark: #C59B27;
    --color-accent-lime: #D4E157;
    --color-bg-light: #F7FAF7;
    --color-text-dark: #0F172A;
    --color-text-muted: #475569;
  }

  body {
    background-color: var(--color-bg-light);
    color: var(--color-text-dark);
    font-family: 'Plus Jakarta Sans', sans-serif;
    margin: 0;
    padding: 0;
  }

  /* NATIVE 82% ZOOM SCALE ROOT */
  .fresh-landing-root {
    zoom: 0.82;
    -webkit-zoom: 0.82;
    width: 100%;
    min-height: 122vh;
    box-sizing: border-box;
  }

  .resp-container {
    width: 100%;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1.5rem;
    box-sizing: border-box;
  }

  /* CLEAN OFF-WHITE NAVBAR */
  .fresh-navbar-header {
    background: #FFFFFF;
    border: 1.5px solid rgba(46, 111, 64, 0.15);
    border-radius: 9999px;
    padding: 0.65rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 10px 30px rgba(30, 70, 32, 0.06);
    gap: 1rem;
  }

  .resp-nav-links {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    flex-wrap: wrap;
  }

  .resp-nav-links a {
    color: var(--color-emerald-dark);
    text-decoration: none;
    font-size: 0.8125rem;
    font-weight: 800;
    padding: 0.5rem 1rem;
    border-radius: 9999px;
    transition: all 0.2s ease;
  }

  .resp-nav-links a:hover {
    background: var(--color-emerald-mint);
    color: var(--color-emerald-dark);
  }

  /* HERO BANNER WITH GEDUNG KEJAKSAAN AGUNG PHOTO */
  .fresh-hero-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 2.5rem;
    align-items: center;
    background: linear-gradient(135deg, rgba(30, 70, 32, 0.90) 0%, rgba(46, 111, 64, 0.82) 100%), url('{{ asset('gedung-kejaksaan.jpg') }}');
    background-size: cover;
    background-position: center;
    border: 2px solid var(--color-accent-gold);
    border-radius: 28px;
    padding: 3.25rem 2.75rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(30, 70, 32, 0.25);
    color: #FFFFFF;
  }

  .fresh-hero-grid::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(212, 175, 55, 0.25) 0%, rgba(0,0,0,0) 70%);
    pointer-events: none;
  }

  /* 4 FEATURE CARDS ROW (MATCHING REFERENCE IMAGE 4TH CARD ACCENT) */
  .fresh-feature-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-top: -2.5rem;
    position: relative;
    z-index: 10;
  }

  .fresh-feature-card {
    background: #FFFFFF;
    border: 1.5px solid #E2E8F0;
    border-radius: 20px;
    padding: 1.4rem 1.25rem;
    box-shadow: 0 10px 30px rgba(30, 70, 32, 0.06);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
  }

  .fresh-feature-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 40px rgba(30, 70, 32, 0.12);
    border-color: var(--color-emerald-medium);
  }

  /* 4TH CARD HIGHLIGHT: FULL DARK GREEN BACKGROUND LIKE REFERENCE */
  .fresh-feature-card.highlight {
    background: linear-gradient(135deg, var(--color-emerald-dark) 0%, var(--color-emerald-medium) 100%);
    color: #FFFFFF;
    border-color: var(--color-accent-gold);
    box-shadow: 0 12px 32px rgba(30, 70, 32, 0.25);
  }

  /* STATS & ABOUT SPLIT SECTION */
  .fresh-split-section {
    display: grid;
    grid-template-columns: 0.95fr 1.05fr;
    gap: 2.5rem;
    align-items: center;
    margin: 4rem 0;
  }

  .fresh-stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.15rem;
  }

  /* 2X2 STATS BOXES WITH COLOR VARIATIONS MATCHING REFERENCE */
  .fresh-stat-box {
    border-radius: 22px;
    padding: 1.6rem 1.25rem;
    text-align: center;
    box-shadow: 0 8px 24px rgba(30, 70, 32, 0.05);
    transition: all 0.2s ease;
    border: 1.5px solid #E2E8F0;
  }

  .fresh-stat-box.box-white {
    background: #FFFFFF;
  }

  .fresh-stat-box.box-gold {
    background: #FFF9E6;
    border-color: #FDE68A;
  }

  .fresh-stat-box.box-green {
    background: linear-gradient(135deg, var(--color-emerald-dark) 0%, var(--color-emerald-medium) 100%);
    color: #FFFFFF;
    border-color: var(--color-accent-gold);
  }

  .fresh-stat-box:hover {
    transform: translateY(-3px);
  }

  /* SERVICE CARDS GRID (POLICY BRIEF & INOVASI) */
  .fresh-catalog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.6rem;
  }

  .fresh-catalog-card {
    background: #FFFFFF;
    border: 1.5px solid #E2E8F0;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(30, 70, 32, 0.05);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .fresh-catalog-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 40px rgba(30, 70, 32, 0.1);
    border-color: var(--color-emerald-medium);
  }

  .card-thumbnail-header {
    height: 120px;
    background: linear-gradient(135deg, var(--color-emerald-dark) 0%, var(--color-emerald-medium) 100%);
    padding: 1.25rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    position: relative;
  }

  /* CURVED BANNER FOR FORM SUBMISSION */
  .fresh-banner-curved {
    background: linear-gradient(135deg, var(--color-emerald-dark) 0%, var(--color-emerald-medium) 100%);
    border: 2px solid var(--color-accent-gold);
    border-radius: 28px;
    padding: 3.25rem 2.75rem;
    color: #FFFFFF;
    margin: 4rem 0;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 45px rgba(30, 70, 32, 0.2);
  }

  /* CATEGORY PILLS */
  .category-pill-bar {
    display: flex;
    gap: 0.4rem;
    flex-wrap: wrap;
    background: #FFFFFF;
    border: 1.5px solid #CBD5E1;
    border-radius: 9999px;
    padding: 0.35rem 0.5rem;
    box-shadow: 0 4px 14px rgba(0,0,0,0.04);
  }

  .category-pill-btn {
    appearance: none;
    border: none;
    outline: none;
    font-size: 0.78125rem;
    font-weight: 800;
    padding: 0.45rem 1.125rem;
    border-radius: 9999px;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    background: transparent;
    color: var(--color-text-muted);
  }

  .category-pill-btn:hover {
    color: var(--color-emerald-dark);
    background: var(--color-emerald-mint);
  }

  .category-pill-btn.active {
    background: var(--color-emerald-dark);
    color: var(--color-accent-gold);
    font-weight: 900;
    box-shadow: 0 4px 12px rgba(30, 70, 32, 0.2);
  }

  /* MEDIA QUERIES */
  @media (max-width: 992px) {
    .fresh-hero-grid { grid-template-columns: 1fr !important; padding: 2rem 1.5rem !important; }
    .fresh-feature-row { grid-template-columns: repeat(2, 1fr) !important; margin-top: 1.5rem !important; }
    .fresh-split-section { grid-template-columns: 1fr !important; }
    .fresh-navbar-header { flex-direction: column !important; align-items: stretch !important; border-radius: 20px !important; }
    .resp-nav-links { justify-content: center !important; }
  }

  @media (max-width: 600px) {
    .fresh-feature-row { grid-template-columns: 1fr !important; }
    .fresh-stats-grid { grid-template-columns: 1fr !important; }
  }
</style>

<div class="fresh-landing-root" x-data="{ 
    isProposalModalOpen: false, 
    isCurriculumUploadModalOpen: false,
    selectedPdf: null, 
    selectedExecSummary: null,
    activeMainTab: 'policy',
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
}" style="display: flex; flex-direction: column;">

    <!-- COPY LINK TOAST NOTIFICATION -->
    <div x-show="copyToast" style="position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 100; background: var(--color-accent-gold); color: #04140B; font-weight: 900; padding: 0.75rem 1.25rem; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); display: none;">
        ✨ Tautan Dokumen PDF Berhasil Disalin!
    </div>

    <!-- TOP FLOATING OFF-WHITE NAVBAR (MATCHING REFERENCE HEADER STYLE) -->
    <div style="position: sticky; top: 0.85rem; z-index: 50; padding: 0 0.85rem; margin: 0.85rem auto 0; width: 100%; max-width: 1240px; box-sizing: border-box;">
        <header class="fresh-navbar-header">
            <div style="display: flex; align-items: center; gap: 0.85rem; cursor: pointer;" onclick="window.location.href='{{ route('landing.index') }}'">
                <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo Emblem Adhyaksa" style="height: 44px; width: auto; filter: drop-shadow(0 2px 6px rgba(0,0,0,0.15));" />
                <div>
                    <div style="font-weight: 900; font-size: 0.95rem; color: var(--color-emerald-dark); line-height: 1.1;">
                        LITBANG GAJAH MADA ADHYAKSA
                    </div>
                    <div style="font-size: 0.65rem; color: var(--color-accent-gold-dark); font-weight: 900; text-transform: uppercase; margin-top: 1px;">
                        PORTAL PENELITIAN DAN PENGEMBANGAN 2026
                    </div>
                </div>
            </div>

            <nav class="resp-nav-links">
                <a href="#katalog-hub">📄 Katalog 3 Pilar</a>
                <a href="#lacak-tiket-hub">🎟️ Lacak Usulan</a>
                <button @click="isProposalModalOpen = true" style="background: linear-gradient(135deg, var(--color-emerald-dark) 0%, var(--color-emerald-medium) 100%); color: var(--color-accent-gold); font-weight: 900; font-size: 0.8125rem; padding: 0.55rem 1.25rem; border-radius: 9999px; border: 1px solid var(--color-accent-gold); cursor: pointer; box-shadow: 0 4px 14px rgba(30, 70, 32, 0.25);">
                    ⚡ Ajukan Usulan (PIN) →
                </button>

                @if(session('is_logged_in'))
                    <a href="{{ route('dashboard.index') }}" style="background: var(--color-emerald-mint); color: var(--color-emerald-dark); font-size: 0.8125rem; font-weight: 800; padding: 0.5rem 1rem; border-radius: 9999px; border: 1.5px solid var(--color-emerald-medium);">
                        📊 Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" style="background: var(--color-emerald-mint); color: var(--color-emerald-dark); font-size: 0.8125rem; font-weight: 800; padding: 0.5rem 1rem; border-radius: 9999px; border: 1.5px solid var(--color-emerald-medium);">
                        🔑 Masuk Admin
                    </a>
                @endif
            </nav>
        </header>
    </div>

    <!-- MAIN CONTENT CONTAINER -->
    <main class="resp-container" style="flex: 1; padding-top: 1.75rem; padding-bottom: 4rem;">
        
        <!-- ALERTS -->
        @if(session('error_passcode'))
            <div style="background: #FEF2F2; border: 1.5px solid #EF4444; color: #991B1B; padding: 1rem 1.25rem; border-radius: 16px; margin-bottom: 1.5rem; font-weight: 800; font-size: 0.875rem;">
                ⚠️ {{ session('error_passcode') }}
            </div>
        @endif

        @if(session('success_ticket'))
            <div style="background: #ECFDF5; border: 1.5px solid #10B981; padding: 1rem 1.25rem; border-radius: 16px; margin-bottom: 1.75rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 8px 24px rgba(16,185,129,0.15);">
                <div>
                    <div style="font-size: 0.71875rem; font-weight: 900; color: #047857; text-transform: uppercase;">✅ USULAN BERHASIL TERDAFTAR</div>
                    <div style="font-size: 1rem; font-weight: 900; color: #065F46; margin-top: 2px;">
                        Nomor Tiket: <span style="color: #047857; background: #D1FAE5; padding: 0.15rem 0.5rem; border-radius: 6px;">{{ session('success_ticket.ticket_no') }}</span>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #047857; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>
        @endif

        <!-- HERO SECTION WITH GEDUNG KEJAKSAAN AGUNG PHOTO BACKGROUND -->
        <section class="fresh-hero-grid" style="margin-bottom: 2rem;">
            <!-- Left Text Content -->
            <div style="position: relative; z-index: 2;">
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.35rem 0.85rem; background: rgba(212, 175, 55, 0.2); border: 1.5px solid var(--color-accent-gold); border-radius: 9999px; font-size: 0.71875rem; font-weight: 900; color: var(--color-accent-gold); margin-bottom: 1.25rem; text-transform: uppercase;">
                    <span>🏛️ KEJAKSAAN REPUBLIK INDONESIA</span>
                </div>

                <h1 style="font-size: clamp(2rem, 3.8vw, 3rem); font-weight: 900; line-height: 1.15; color: #FFFFFF; margin-bottom: 1rem; letter-spacing: -0.01em;">
                    Transformasi Riset, Inovasi <br />
                    <span style="color: var(--color-accent-gold); text-shadow: 0 4px 15px rgba(212,175,55,0.35);">
                        & Kurikulum Pembelajaran
                    </span>
                </h1>

                <p style="font-size: 0.95rem; color: #EBF3EC; line-height: 1.65; margin-bottom: 1.85rem; max-width: 580px;">
                    Pusat repositori manajemen pengetahuan terpadu Angkatan Gajah Mada Adhyaksa (PPPJ LXXXIII/2026). Akses naskah akademis teruji, bank inovasi digital, dan modul pembelajaran.
                </p>

                <!-- Hero Action Buttons -->
                <div style="display: flex; gap: 0.85rem; flex-wrap: wrap; align-items: center;">
                    <a href="#katalog-hub" style="background: linear-gradient(135deg, var(--color-accent-gold) 0%, var(--color-accent-gold-dark) 100%); color: #04140B; font-weight: 900; font-size: 0.875rem; padding: 0.8rem 1.65rem; border-radius: 12px; text-decoration: none; box-shadow: 0 6px 20px rgba(212, 175, 55, 0.35); display: inline-flex; align-items: center; gap: 0.4rem;">
                        🌐 Jelajahi Vault Naskah →
                    </a>
                    <button @click="isProposalModalOpen = true" style="background: rgba(255,255,255,0.14); border: 1.5px solid rgba(255,255,255,0.4); color: #FFFFFF; font-weight: 800; font-size: 0.875rem; padding: 0.8rem 1.4rem; border-radius: 12px; cursor: pointer; backdrop-filter: blur(8px); display: inline-flex; align-items: center; gap: 0.4rem;">
                        📥 Kirim Usulan (PIN)
                    </button>
                </div>
            </div>

            <!-- Right Floating Showcase Card -->
            <div style="position: relative; z-index: 2;">
                <template x-if="policyBriefs && policyBriefs.length > 0">
                    <div style="background: #FFFFFF; border: 2px solid var(--color-accent-gold); border-radius: 24px; padding: 1.65rem; color: var(--color-text-dark); box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.875rem; flex-wrap: wrap; gap: 0.5rem;">
                            <span style="background: var(--color-emerald-dark); color: var(--color-accent-gold); font-weight: 900; font-size: 0.6875rem; padding: 0.25rem 0.65rem; border-radius: 9999px;" x-text="policyBriefs[0].category || 'POLICY BRIEF UTAMA'">
                            </span>
                            <span style="font-size: 0.72rem; color: var(--color-emerald-medium); font-weight: 800;" x-text="policyBriefs[0].doc_no"></span>
                        </div>

                        <h3 style="font-size: 1.05rem; font-weight: 900; color: var(--color-emerald-dark); line-height: 1.35; margin-bottom: 0.75rem;" x-text="policyBriefs[0].title"></h3>

                        <p style="font-size: 0.8125rem; color: var(--color-text-muted); line-height: 1.55; margin-bottom: 1.25rem;" x-text="policyBriefs[0].summary"></p>

                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                            <button style="background: var(--color-emerald-mint); border: 1px solid var(--color-emerald-medium); color: var(--color-emerald-dark); font-weight: 800; font-size: 0.75rem; padding: 0.45rem 0.85rem; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 0.3rem;" @click="openPdfPreview(policyBriefs[0].title, policyBriefs[0].doc_no, policyBriefs[0].file_path)">
                                👁️ Pratinjau PDF
                            </button>
                            <a href="{{ route('catalog.download', ['kajian', $policyBriefs[0]->id ?? 1]) }}" style="background: var(--color-emerald-dark); color: var(--color-accent-gold); font-weight: 900; font-size: 0.75rem; padding: 0.45rem 0.85rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                                📥 Download PDF
                            </a>
                        </div>
                    </div>
                </template>
            </div>
        </section>

        <!-- 4 FEATURE CARDS ROW (WITH 4TH DARK GREEN ACCENT CARD MATCHING REFERENCE) -->
        <section class="fresh-feature-row" style="margin-bottom: 4rem;">
            <!-- CARD 1 -->
            <div class="fresh-feature-card">
                <div style="width: 44px; height: 44px; border-radius: 14px; background: var(--color-emerald-mint); color: var(--color-emerald-dark); font-size: 1.25rem; display: flex; align-items: center; justify-content: center; margin-bottom: 0.95rem;">
                    📄
                </div>
                <h4 style="font-size: 0.95rem; font-weight: 900; color: var(--color-emerald-dark); margin-bottom: 0.35rem;">Policy Brief Studio</h4>
                <p style="font-size: 0.78125rem; color: var(--color-text-muted); line-height: 1.55;">Naskah akademis teruji dengan pengesahan digital QR Seal resmi Kejaksaan RI.</p>
            </div>

            <!-- CARD 2 -->
            <div class="fresh-feature-card">
                <div style="width: 44px; height: 44px; border-radius: 14px; background: #E0F2FE; color: #0284C7; font-size: 1.25rem; display: flex; align-items: center; justify-content: center; margin-bottom: 0.95rem;">
                    💡
                </div>
                <h4 style="font-size: 0.95rem; font-weight: 900; color: var(--color-emerald-dark); margin-bottom: 0.35rem;">Bank Inovasi Teruji</h4>
                <p style="font-size: 0.78125rem; color: var(--color-text-muted); line-height: 1.55;">Katalog inovasi digital & birokrasi pendukung efisiensi tata kelola penegakan hukum.</p>
            </div>

            <!-- CARD 3 -->
            <div class="fresh-feature-card">
                <div style="width: 44px; height: 44px; border-radius: 14px; background: #DCFCE7; color: #16A34A; font-size: 1.25rem; display: flex; align-items: center; justify-content: center; margin-bottom: 0.95rem;">
                    📚
                </div>
                <h4 style="font-size: 0.95rem; font-weight: 900; color: var(--color-emerald-dark); margin-bottom: 0.35rem;">Vault Kurikulum PPPJ</h4>
                <p style="font-size: 0.78125rem; color: var(--color-text-muted); line-height: 1.55;">Arsip modul, slide materi, dan juknis pembelajaran angkatan terverifikasi.</p>
            </div>

            <!-- CARD 4 (HIGHLIGHTED FULL DARK GREEN MATCHING REFERENCE) -->
            <div class="fresh-feature-card highlight">
                <div style="width: 44px; height: 44px; border-radius: 14px; background: rgba(212,175,55,0.22); color: var(--color-accent-gold); font-size: 1.25rem; display: flex; align-items: center; justify-content: center; margin-bottom: 0.95rem;">
                    🏛️
                </div>
                <h4 style="font-size: 0.95rem; font-weight: 900; color: #FFFFFF; margin-bottom: 0.35rem;">Pokja Gajah Mada</h4>
                <p style="font-size: 0.78125rem; color: #EBF3EC; line-height: 1.55;">Pusat komando penelitian dan formulasi kebijakan riset angkatan.</p>
            </div>
        </section>

        <!-- STATS & ABOUT SPLIT SECTION (WITH 2X2 COLOR VARIATION BOXES) -->
        <section class="fresh-split-section">
            <!-- LEFT 2X2 STATS GRID MATCHING REFERENCE COLOR SCHEME -->
            <div class="fresh-stats-grid">
                <!-- BOX 1: WHITE -->
                <div class="fresh-stat-box box-white">
                    <div style="font-size: 2.35rem; font-weight: 900; color: var(--color-emerald-dark); line-height: 1;">500+</div>
                    <div style="font-size: 0.8125rem; font-weight: 900; color: var(--color-text-dark); margin-top: 6px;">Peserta Angkatan</div>
                    <div style="font-size: 0.71875rem; color: var(--color-text-muted); margin-top: 2px;">PPPJ LXXXIII/2026</div>
                </div>

                <!-- BOX 2: GOLD / LIME SOFT SOFT BACKGROUND -->
                <div class="fresh-stat-box box-gold">
                    <div style="font-size: 2.35rem; font-weight: 900; color: var(--color-accent-gold-dark); line-height: 1;">40+</div>
                    <div style="font-size: 0.8125rem; font-weight: 900; color: #92400E; margin-top: 6px;">Policy Briefs Terbit</div>
                    <div style="font-size: 0.71875rem; color: #B45309; margin-top: 2px;">Teruji Akademis</div>
                </div>

                <!-- BOX 3: FULL DARK FRESH GREEN BACKGROUND -->
                <div class="fresh-stat-box box-green">
                    <div style="font-size: 2.35rem; font-weight: 900; color: var(--color-accent-gold); line-height: 1;">15+</div>
                    <div style="font-size: 0.8125rem; font-weight: 900; color: #FFFFFF; margin-top: 6px;">Inovasi Teruji</div>
                    <div style="font-size: 0.71875rem; color: #EBF3EC; margin-top: 2px;">Digital & Birokrasi</div>
                </div>

                <!-- BOX 4: WHITE -->
                <div class="fresh-stat-box box-white">
                    <div style="font-size: 2.35rem; font-weight: 900; color: #16A34A; line-height: 1;">100%</div>
                    <div style="font-size: 0.8125rem; font-weight: 900; color: var(--color-text-dark); margin-top: 6px;">Stempel QR Seal</div>
                    <div style="font-size: 0.71875rem; color: var(--color-text-muted); margin-top: 2px;">Autentik Digital</div>
                </div>
            </div>

            <!-- RIGHT ABOUT DESCRIPTION CARD -->
            <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 24px; padding: 2.35rem; box-shadow: 0 10px 30px rgba(30,70,32,0.06);">
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.35rem 0.85rem; background: var(--color-emerald-mint); border-radius: 9999px; font-size: 0.71875rem; font-weight: 900; color: var(--color-emerald-dark); text-transform: uppercase; margin-bottom: 1rem;">
                    <span>🌱 TENTANG LITBANG GAJAH MADA ADHYAKSA</span>
                </div>
                <h2 style="font-size: 1.75rem; font-weight: 900; color: var(--color-emerald-dark); line-height: 1.25; margin-bottom: 1rem;">
                    Mengabdi Melalui Formulasi Riset & Inovasi Penegakan Hukum
                </h2>
                <p style="font-size: 0.875rem; color: var(--color-text-muted); line-height: 1.7; margin-bottom: 1.35rem;">
                    Litbang Gajah Mada Adhyaksa merupakan wadah penelitian dan pengolahan pengetahuan resmi bagi Anggota PPPJ LXXXIII/II Tahun 2026. Kami berkomitmen menyusun formulasi naskah kebijakan, menginkubasi gagasan inovasi layanan publik, dan mengarsipkan modul kurikulum pembelajaran secara aman dan terverifikasi.
                </p>
                <div style="display: flex; gap: 0.75rem; align-items: center;">
                    <a href="#lacak-tiket-hub" style="background: var(--color-emerald-dark); color: var(--color-accent-gold); font-weight: 900; font-size: 0.8125rem; padding: 0.65rem 1.35rem; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                        🎟️ Lacak Tiket Usulan →
                    </a>
                </div>
            </div>
        </section>

        <!-- MAIN CATALOG HUB (POLICY BRIEF, INOVASI, KURIKULUM) -->
        <section id="katalog-hub" style="margin: 4rem 0;">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <span style="font-size: 0.71875rem; font-weight: 900; color: var(--color-emerald-medium); text-transform: uppercase; letter-spacing: 0.05em;">PORTAL KATALOG REPOSITORI</span>
                    <h2 style="font-size: 1.85rem; font-weight: 900; color: var(--color-emerald-dark); margin-top: 0.25rem;">Katalog Pengetahuan 3 Pilar</h2>
                </div>

                <!-- MAIN TAB PILLS -->
                <div class="category-pill-bar">
                    <button class="category-pill-btn" :class="{ 'active': activeMainTab === 'policy' }" @click="activeMainTab = 'policy'">
                        📄 Policy Brief
                    </button>
                    <button class="category-pill-btn" :class="{ 'active': activeMainTab === 'innovation' }" @click="activeMainTab = 'innovation'">
                        💡 Bank Inovasi
                    </button>
                    <button class="category-pill-btn" :class="{ 'active': activeMainTab === 'curriculum' }" @click="activeMainTab = 'curriculum'">
                        📚 Kurikulum PPPJ
                    </button>
                </div>
            </div>

            <!-- INSTANT LIVE SEARCH & FILTER BAR -->
            <div style="background: #FFFFFF; border: 1.5px solid #CBD5E1; padding: 1.15rem 1.35rem; border-radius: 20px; margin-bottom: 1.85rem; display: flex; flex-direction: column; gap: 0.85rem; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                <div style="position: relative;">
                    <input type="text" x-model="searchQuery" placeholder="🔍 Cari judul naskah, inovasi, pengusul, atau modul secara instan..." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.7rem 1rem; color: var(--color-text-dark); font-size: 0.875rem; outline: none;" />
                </div>

                <div style="display: flex; gap: 0.4rem; flex-wrap: wrap; align-items: center;">
                    <span style="font-size: 0.75rem; color: var(--color-text-muted); font-weight: 800; margin-right: 0.25rem;">Kategori Domain:</span>
                    <button type="button" class="category-pill-btn" style="font-size: 0.75rem; padding: 0.3rem 0.75rem;" :class="{ 'active': activeCategory === 'Semua' }" @click="activeCategory = 'Semua'">Semua</button>
                    <button type="button" class="category-pill-btn" style="font-size: 0.75rem; padding: 0.3rem 0.75rem;" :class="{ 'active': activeCategory === 'Pidana' }" @click="activeCategory = 'Pidana'">Pidana</button>
                    <button type="button" class="category-pill-btn" style="font-size: 0.75rem; padding: 0.3rem 0.75rem;" :class="{ 'active': activeCategory === 'Perdata' }" @click="activeCategory = 'Perdata'">Perdata</button>
                    <button type="button" class="category-pill-btn" style="font-size: 0.75rem; padding: 0.3rem 0.75rem;" :class="{ 'active': activeCategory === 'TUN' }" @click="activeCategory = 'TUN'">TUN</button>
                    <button type="button" class="category-pill-btn" style="font-size: 0.75rem; padding: 0.3rem 0.75rem;" :class="{ 'active': activeCategory === 'SPBE' }" @click="activeCategory = 'SPBE'">SPBE</button>
                </div>
            </div>

            <!-- TAB 1: POLICY BRIEF GRID -->
            <div x-show="activeMainTab === 'policy'" class="fresh-catalog-grid">
                @foreach($policyBriefs as $brief)
                    <div class="fresh-catalog-card" style="border-top: 4px solid var(--color-emerald-dark);" x-show="(activeCategory === 'Semua' || '{{ $brief->category }}'.includes(activeCategory)) && (searchQuery === '' || '{{ strtolower($brief->title . ' ' . $brief->summary . ' ' . $brief->category . ' ' . $brief->doc_no) }}'.includes(searchQuery.toLowerCase()))">
                        <div style="padding: 1.5rem 1.35rem 0.5rem; flex: 1; display: flex; flex-direction: column;">
                            <!-- TOP METADATA ROW -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.4rem;">
                                <span style="font-size: 0.75rem; font-weight: 800; color: #166534; background: #F0FDF4; border: 1px solid #DCFCE7; padding: 0.35rem 0.75rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.3rem;">
                                    📄 {{ $brief->category }}
                                </span>
                                <span style="font-size: 0.75rem; font-weight: 800; color: #64748B; background: #F8FAFC; border: 1px solid #E2E8F0; padding: 0.25rem 0.6rem; border-radius: 6px; font-family: monospace;">
                                    {{ $brief->doc_no }}
                                </span>
                            </div>

                            <h3 style="font-size: 1.05rem; font-weight: 900; color: var(--color-emerald-dark); margin-bottom: 0.6rem; line-height: 1.4;">
                                {{ $brief->title }}
                            </h3>

                            <p style="font-size: 0.8125rem; color: var(--color-text-muted); line-height: 1.65; margin-bottom: 1.25rem; flex: 1;">
                                {{ $brief->summary }}
                            </p>
                        </div>

                        <div style="border-top: 1px solid #F1F5F9; padding: 1rem 1.35rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; background: #FAFDFB;">
                            <span style="font-size: 0.72rem; color: #16A34A; font-weight: 900; display: inline-flex; align-items: center; gap: 0.3rem;">
                                🟢 QR Seal Verified
                            </span>
                            <div style="display: flex; gap: 0.4rem;">
                                <button type="button" style="background: #FFFFFF; border: 1.5px solid #CBD5E1; color: var(--color-emerald-dark); font-weight: 800; font-size: 0.75rem; padding: 0.45rem 0.85rem; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;" @click="openPdfPreview(policyBriefs[{{ $loop->index }}].title, policyBriefs[{{ $loop->index }}].doc_no, policyBriefs[{{ $loop->index }}].file_path)">
                                    👁️ Pratinjau
                                </button>
                                <a href="{{ route('catalog.download', ['kajian', $brief->id]) }}" style="background: linear-gradient(135deg, var(--color-emerald-dark) 0%, var(--color-emerald-medium) 100%); color: var(--color-accent-gold); font-weight: 900; font-size: 0.75rem; padding: 0.45rem 0.85rem; border-radius: 8px; text-decoration: none; box-shadow: 0 2px 6px rgba(30,70,32,0.2);">
                                    📥 Download
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- TAB 2: INOVASI TERUJI GRID -->
            <div x-show="activeMainTab === 'innovation'" x-cloak class="fresh-catalog-grid">
                @foreach($innovations as $inov)
                    <div class="fresh-catalog-card" style="border-top: 4px solid #0284C7;" x-show="(activeCategory === 'Semua' || '{{ $inov->category }}'.includes(activeCategory)) && (searchQuery === '' || '{{ strtolower($inov->title . ' ' . $inov->summary . ' ' . $inov->category . ' ' . $inov->innovation_no) }}'.includes(searchQuery.toLowerCase()))">
                        <div style="padding: 1.5rem 1.35rem 0.5rem; flex: 1; display: flex; flex-direction: column;">
                            <!-- TOP METADATA ROW -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.4rem;">
                                <span style="font-size: 0.75rem; font-weight: 800; color: #075985; background: #F0F9FF; border: 1px solid #E0F2FE; padding: 0.35rem 0.75rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.3rem;">
                                    💡 {{ $inov->status }}
                                </span>
                                <span style="font-size: 0.75rem; font-weight: 800; color: #64748B; background: #F8FAFC; border: 1px solid #E2E8F0; padding: 0.25rem 0.6rem; border-radius: 6px; font-family: monospace;">
                                    {{ $inov->innovation_no }}
                                </span>
                            </div>

                            <h3 style="font-size: 1.05rem; font-weight: 900; color: var(--color-emerald-dark); margin-bottom: 0.6rem; line-height: 1.4;">
                                {{ $inov->title }}
                            </h3>

                            <p style="font-size: 0.8125rem; color: var(--color-text-muted); line-height: 1.65; margin-bottom: 1.25rem; flex: 1;">
                                {{ $inov->summary }}
                            </p>

                            @if($inov->impact_description)
                                <div style="background: #F0F9FF; border-left: 3px solid #0284C7; padding: 0.5rem 0.75rem; border-radius: 0 8px 8px 0; font-size: 0.78rem; color: #0369A1; font-weight: 700; margin-bottom: 1rem;">
                                    ✨ {{ $inov->impact_description }}
                                </div>
                            @endif
                        </div>

                        <div style="border-top: 1px solid #F1F5F9; padding: 1rem 1.35rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; background: #F8FAFC;">
                            <span style="font-size: 0.72rem; color: #0284C7; font-weight: 900; display: inline-flex; align-items: center; gap: 0.3rem;">
                                ⚡ Teruji Birokrasi
                            </span>
                            <div style="display: flex; gap: 0.4rem;">
                                <button type="button" style="background: #FFFFFF; border: 1.5px solid #CBD5E1; color: #0369A1; font-weight: 800; font-size: 0.75rem; padding: 0.45rem 0.85rem; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;" @click="openPdfPreview(innovations[{{ $loop->index }}].title, innovations[{{ $loop->index }}].innovation_no, innovations[{{ $loop->index }}].sop_file_path)">
                                    👁️ Pratinjau
                                </button>
                                <a href="{{ route('catalog.download', ['innovation', $inov->id]) }}" style="background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%); color: #FFFFFF; font-weight: 900; font-size: 0.75rem; padding: 0.45rem 0.85rem; border-radius: 8px; text-decoration: none; box-shadow: 0 2px 6px rgba(2,132,199,0.25);">
                                    📥 SOP PDF
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- TAB 3: KURIKULUM & MATERI GRID -->
            <div x-show="activeMainTab === 'curriculum'" x-cloak class="fresh-catalog-grid">
                @foreach($curriculums as $curr)
                    <div class="fresh-catalog-card" style="border-top: 4px solid #16A34A;" x-show="(activeCategory === 'Semua' || '{{ $curr->subject_category }}'.includes(activeCategory)) && (searchQuery === '' || '{{ strtolower($curr->title . ' ' . $curr->subject_category . ' ' . $curr->file_type) }}'.includes(searchQuery.toLowerCase()))">
                        <div style="padding: 1.5rem 1.35rem 0.5rem; flex: 1; display: flex; flex-direction: column;">
                            <!-- TOP METADATA ROW -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.4rem;">
                                <span style="font-size: 0.75rem; font-weight: 800; color: #166534; background: #F0FDF4; border: 1px solid #DCFCE7; padding: 0.35rem 0.75rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.3rem;">
                                    📚 {{ $curr->file_type }}
                                </span>
                                <span style="font-size: 0.75rem; font-weight: 800; color: #92400E; background: #FEF3C7; border: 1px solid #FDE68A; padding: 0.25rem 0.65rem; border-radius: 6px;">
                                    Bidang: {{ $curr->subject_category }}
                                </span>
                            </div>

                            <h3 style="font-size: 1.05rem; font-weight: 900; color: var(--color-emerald-dark); margin-bottom: 0.6rem; line-height: 1.4;">
                                {{ $curr->title }}
                            </h3>

                            <p style="font-size: 0.8125rem; color: var(--color-text-muted); line-height: 1.65; margin-bottom: 1.25rem; flex: 1;">
                                Pengunggah: <strong style="color: var(--color-text-dark);">{{ $curr->uploader_name ?? 'Admin Litbang' }}</strong>
                                @if($curr->description)
                                    <span style="display: block; margin-top: 0.35rem; color: #64748B;">{{ $curr->description }}</span>
                                @endif
                            </p>
                        </div>

                        <div style="border-top: 1px solid #F1F5F9; padding: 1rem 1.35rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; background: #F8FAFC;">
                            <span style="font-size: 0.72rem; color: #16A34A; font-weight: 900; display: inline-flex; align-items: center; gap: 0.3rem;">
                                🎓 Modul Terverifikasi
                            </span>
                            <div style="display: flex; gap: 0.4rem;">
                                @if($curr->external_link)
                                    <a href="{{ $curr->external_link }}" target="_blank" rel="noopener noreferrer" style="background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%); color: #FFF; font-weight: 900; font-size: 0.75rem; padding: 0.45rem 0.85rem; border-radius: 8px; text-decoration: none;">
                                        🔗 Drive
                                    </a>
                                @endif
                                @if($curr->file_path)
                                    <button type="button" style="background: #FFFFFF; border: 1.5px solid #CBD5E1; color: #15803D; font-weight: 800; font-size: 0.75rem; padding: 0.45rem 0.85rem; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;" @click="previewCurriculum(curriculums[{{ $loop->index }}])">
                                        👁️ Pratinjau
                                    </button>
                                    <a href="{{ $curr->file_path }}" download style="background: linear-gradient(135deg, #16A34A 0%, #15803D 100%); color: #FFFFFF; font-weight: 900; font-size: 0.75rem; padding: 0.45rem 0.85rem; border-radius: 8px; text-decoration: none; box-shadow: 0 2px 6px rgba(22,163,74,0.25);">
                                        📥 Unduh
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- CURVED BANNER FOR QUICK SUBMISSION -->
        <section class="fresh-banner-curved" id="lacak-tiket-hub">
            <div style="max-width: 720px; position: relative; z-index: 2;">
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.35rem 0.85rem; background: rgba(212, 175, 55, 0.2); border: 1.5px solid var(--color-accent-gold); border-radius: 9999px; font-size: 0.71875rem; font-weight: 900; color: var(--color-accent-gold); text-transform: uppercase; margin-bottom: 1.15rem;">
                    <span>📥 LAYANAN USULAN ANGKATAN</span>
                </div>

                <h2 style="font-size: 2rem; font-weight: 900; color: #FFFFFF; line-height: 1.25; margin-bottom: 1rem;">
                    Mulai Kirimkan Usulan Riset atau Ide Inovasi Anda Now
                </h2>
                <p style="font-size: 0.95rem; color: #EBF3EC; line-height: 1.65; margin-bottom: 1.85rem;">
                    Gunakan Kode PIN Angkatan (<strong style="color: var(--color-accent-gold);">{{ $setting->batch_passcode }}</strong>) untuk mendaftarkan naskah atau ide inovasi Anda secara langsung ke Pokja Riset.
                </p>

                <div style="display: flex; gap: 0.85rem; flex-wrap: wrap;">
                    <button @click="isProposalModalOpen = true" style="background: linear-gradient(135deg, var(--color-accent-gold) 0%, var(--color-accent-gold-dark) 100%); color: #04140B; font-weight: 900; font-size: 0.875rem; padding: 0.8rem 1.75rem; border-radius: 12px; border: none; cursor: pointer; box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);">
                        ⚡ Kirim Usulan Riset Baru (PIN) →
                    </button>
                    <button @click="isCurriculumUploadModalOpen = true" style="background: rgba(255,255,255,0.14); border: 1.5px solid rgba(255,255,255,0.4); color: #FFFFFF; font-weight: 800; font-size: 0.875rem; padding: 0.8rem 1.5rem; border-radius: 12px; cursor: pointer;">
                        📚 Upload Berkas Kurikulum
                    </button>
                </div>
            </div>
        </section>

    </main>

    <!-- FORMULIR PENGUSULAN INTERNAL MODAL -->
    <div x-show="isProposalModalOpen" x-cloak class="modal-overlay" @click="isProposalModalOpen = false">
        <div class="modal-card" style="max-width: 580px; border-radius: 24px; background: #FFFFFF; color: var(--color-text-dark); border: 2px solid var(--color-emerald-dark);" @click.stop>
            <div style="padding: 1.25rem 1.5rem; background: var(--color-emerald-dark); color: #FFFFFF; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--color-accent-gold);">
                <div>
                    <div style="font-size: 0.6875rem; font-weight: 900; color: var(--color-accent-gold); text-transform: uppercase;">FORMULIR PENGUSULAN ANGKATAN</div>
                    <h3 style="font-size: 1.05rem; font-weight: 900; color: #FFFFFF;">Pengajuan Policy Brief / Ide Inovasi</h3>
                </div>
                <button @click="isProposalModalOpen = false" style="background: none; border: none; color: #FFF; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>

            <form action="{{ route('landing.submit_proposal') }}" method="POST" enctype="multipart/form-data" style="padding: 1.35rem; display: flex; flex-direction: column; gap: 0.875rem;">
                @csrf

                <!-- PIN PASSCODE AUTHENTICATION -->
                <div style="background: var(--color-emerald-mint); border: 1.5px solid var(--color-emerald-medium); border-radius: 12px; padding: 0.875rem;">
                    <label style="font-size: 0.75rem; font-weight: 900; color: var(--color-emerald-dark); display: block; margin-bottom: 0.25rem;">🔑 KODE PIN AKSES ANGKATAN *</label>
                    <input type="password" name="batch_pin" required placeholder="Masukkan Kode PIN Angkatan (Contoh: {{ $setting->batch_passcode }})" style="width: 100%; padding: 0.55rem; font-size: 0.875rem; border-radius: 8px; border: 1.5px solid var(--color-emerald-medium); background: #FFFFFF; color: var(--color-emerald-dark); outline: none; font-weight: 800;" />
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.25rem;">Nama Pengusul *</label>
                        <input type="text" name="name" required placeholder="Nama Lengkap" style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF; color: #0F172A;" />
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.25rem;">Pilar Pengajuan *</label>
                        <select name="type" style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF; color: #0F172A;">
                            <option value="Policy Brief">📄 Policy Brief / Naskah Akademis</option>
                            <option value="Ide Inovasi">💡 Gagasan Ide Inovasi</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.25rem;">Kategori Domain *</label>
                        <select name="category" style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF; color: #0F172A;">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.25rem;">Tingkat Urgensi</label>
                        <select name="urgency" style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF; color: #0F172A;">
                            <option value="Kritis">Kritis (Urgensi Kebijakan)</option>
                            <option value="Tinggi">Tinggi (Sangat Mendesak)</option>
                            <option value="Normal">Normal (Penguatan Regulasi)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="font-size: 0.75rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.25rem;">Judul Usulan / Gagasan Inovasi *</label>
                    <input type="text" name="title" required placeholder="Judul usulan..." style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF; color: #0F172A;" />
                </div>

                <div>
                    <label style="font-size: 0.75rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.25rem;">Uraian Ringkasan Permasalahan / Konsep Inovasi *</label>
                    <textarea name="description" rows="3" required placeholder="Uraikan secara ringkas..." style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF; color: #0F172A;"></textarea>
                </div>

                <!-- DYNAMIC CUSTOM FORM FIELDS -->
                @foreach($formFields as $field)
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.25rem;">
                            {{ $field->field_label }} {{ $field->is_required ? '*' : '' }}
                        </label>
                        @if($field->field_type === 'textarea')
                            <textarea name="{{ $field->field_name }}" rows="2" {{ $field->is_required ? 'required' : '' }} style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF; color: #0F172A;"></textarea>
                        @elseif($field->field_type === 'select' && $field->options)
                            <select name="{{ $field->field_name }}" {{ $field->is_required ? 'required' : '' }} style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF; color: #0F172A;">
                                @foreach($field->options as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" name="{{ $field->field_name }}" {{ $field->is_required ? 'required' : '' }} style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF; color: #0F172A;" />
                        @endif
                    </div>
                @endforeach

                <div>
                    <label style="font-size: 0.75rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.25rem;">Lampiran File Pendukung (PDF / Word / PPT)</label>
                    <input type="file" name="attachment" style="width: 100%; padding: 0.4rem; font-size: 0.75rem; color: var(--color-text-muted);" />
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.5rem; margin-top: 0.5rem;">
                    <button type="button" style="background: #F1F5F9; border: 1.5px solid #CBD5E1; color: #475569; font-weight: 800; border-radius: 10px; padding: 0.55rem 1.125rem; font-size: 0.78125rem; cursor: pointer;" @click="isProposalModalOpen = false">Batal</button>
                    <button type="submit" style="background: var(--color-emerald-dark); color: var(--color-accent-gold); font-weight: 900; font-size: 0.8125rem; padding: 0.55rem 1.25rem; border-radius: 10px; border: none; cursor: pointer;">📨 Kirim Usulan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- EMBEDDED PDF VIEWER MODAL -->
    <div x-show="selectedPdf !== null" x-cloak class="modal-overlay" @click="selectedPdf = null">
        <div class="modal-card" style="max-width: 1000px; width: 95%; height: 85vh; border-radius: 20px; display: flex; flex-direction: column; overflow: hidden; background: #FFFFFF; border: 2px solid var(--color-emerald-dark);" @click.stop>
            <div style="padding: 0.85rem 1.35rem; background: var(--color-emerald-dark); color: #FFFFFF; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--color-accent-gold); flex-wrap: wrap; gap: 0.5rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 1.1rem;">📄</span>
                    <div>
                        <div style="font-size: 0.625rem; color: var(--color-accent-gold); font-weight: 900; text-transform: uppercase;">EXECUTIVE POLICY BRIEF PDF</div>
                        <div style="font-size: 0.875rem; font-weight: 800; color: #FFFFFF;" x-text="selectedPdf ? selectedPdf.doc_no : ''"></div>
                    </div>
                </div>
                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <a :href="selectedPdf ? (selectedPdf.file_path || '/documents/pb_01.pdf') : '#'" download style="background: var(--color-accent-gold); color: #04140B; font-size: 0.75rem; font-weight: 900; padding: 0.4rem 0.875rem; border-radius: 8px; text-decoration: none;">
                        📥 Unduh PDF
                    </a>
                    <button style="padding: 0.4rem 0.875rem; font-size: 0.75rem; color: #FFF; border: 1px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.1); border-radius: 8px; cursor: pointer;" @click="selectedPdf = null">
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
        <div class="modal-card" style="max-width: 580px; border-radius: 24px; background: #FFFFFF; color: var(--color-text-dark); border: 2px solid #16A34A;" @click.stop>
            <div style="padding: 1.25rem 1.5rem; background: #16A34A; color: #FFFFFF; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #86EFAC;">
                <div>
                    <div style="font-size: 0.6875rem; font-weight: 900; color: #DCFCE7; text-transform: uppercase;">UNGGAH BERKAS KURIKULUM ANGKATAN</div>
                    <h3 style="font-size: 1.05rem; font-weight: 900; color: #FFFFFF;">Unggah Modul, Slide PPT, atau Silabus Pembelajaran</h3>
                </div>
                <button @click="isCurriculumUploadModalOpen = false" style="background: none; border: none; color: #FFF; font-size: 1.25rem; cursor: pointer;">✕</button>
            </div>

            <form action="{{ route('landing.curriculums.upload') }}" method="POST" enctype="multipart/form-data" style="padding: 1.35rem; display: flex; flex-direction: column; gap: 0.875rem;">
                @csrf

                <!-- PIN PASSCODE AUTHENTICATION -->
                <div style="background: #DCFCE7; border: 1.5px solid #86EFAC; border-radius: 12px; padding: 0.875rem;">
                    <label style="font-size: 0.75rem; font-weight: 900; color: #15803D; display: block; margin-bottom: 0.25rem;">🔑 KODE PIN AKSES ANGKATAN *</label>
                    <input type="password" name="batch_pin" required placeholder="Masukkan Kode PIN Angkatan (Contoh: {{ $setting->batch_passcode }})" style="width: 100%; padding: 0.55rem; font-size: 0.875rem; border-radius: 8px; border: 1.5px solid #86EFAC; background: #FFFFFF; color: #15803D; outline: none; font-weight: 800;" />
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.25rem;">Nama Pengunggah / Peserta *</label>
                        <input type="text" name="uploader_name" required placeholder="Nama & Gelar Peserta" style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF; color: #0F172A;" />
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.25rem;">Bidang Hukum *</label>
                        <select name="subject_category" required style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF; color: #0F172A;">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label style="font-size: 0.75rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.25rem;">Judul Materi / Modul Pembelajaran *</label>
                    <input type="text" name="title" required placeholder="Contoh: Slide Rangkuman Perkuliahan Pembuktian Pidana Khusus" style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF; color: #0F172A;" />
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.25rem;">Jenis Berkas *</label>
                        <select name="file_type" required style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF; color: #0F172A;">
                            <option value="Modul PDF">Modul PDF</option>
                            <option value="Slide PPT">Slide PPT</option>
                            <option value="Silabus/Juknis">Silabus/Juknis</option>
                            <option value="Link Google Drive / Cloud">Link Google Drive / Cloud</option>
                            <option value="Video Pembelajaran">Video Pembelajaran</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.25rem;">File Dokumen (PDF/PPT/Word)</label>
                        <input type="file" name="attachment" style="width: 100%; padding: 0.4rem; font-size: 0.75rem; color: var(--color-text-muted);" />
                    </div>
                </div>

                <div>
                    <label style="font-size: 0.75rem; font-weight: 800; color: #0284C7; display: block; margin-bottom: 0.25rem;">🔗 Link External / Google Drive (Contoh: https://drive.google.com/...)</label>
                    <input type="url" name="external_link" placeholder="Tautkan link Google Drive / OneDrive / Cloud (Opsional jika mengunggah file)" style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #7DD3FC; background: #F0F9FF; color: #0369A1; outline: none;" />
                </div>

                <div>
                    <label style="font-size: 0.75rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.25rem;">Uraian Singkat / Catatan Materi</label>
                    <textarea name="description" rows="2" placeholder="Jelaskan secara singkat isi materi / modul yang diunggah..." style="width: 100%; padding: 0.55rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid #CBD5E1; background: #FFF; color: #0F172A;"></textarea>
                </div>

                <div style="background: #F8FAFC; border: 1px dashed #CBD5E1; border-radius: 8px; padding: 0.6rem 0.875rem; font-size: 0.71875rem; color: var(--color-text-muted);">
                    ℹ️ <em>Materi yang diunggah peserta akan diverifikasi terlebih dahulu oleh Tim Admin sebelum diterbitkan di Vault Publik.</em>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.5rem; margin-top: 0.5rem;">
                    <button type="button" style="background: #F1F5F9; border: 1.5px solid #CBD5E1; color: #475569; font-weight: 800; border-radius: 10px; padding: 0.55rem 1.125rem; font-size: 0.78125rem; cursor: pointer;" @click="isCurriculumUploadModalOpen = false">Batal</button>
                    <button type="submit" style="background: #16A34A; color: #FFFFFF; font-weight: 900; font-size: 0.78125rem; padding: 0.55rem 1.25rem; border-radius: 10px; border: none; cursor: pointer;">📤 Unggah untuk Verifikasi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- FOOTER (FRESH EMERALD GREEN EDITION MATCHING REFERENCE) -->
    <footer style="border-top: 2px solid var(--color-accent-gold); padding: 2.25rem 1rem; text-align: center; color: #EBF3EC; background: var(--color-emerald-dark);">
        <div class="resp-container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.85rem;">
                <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo Adhyaksa" style="height: 40px; width: auto;" />
                <div style="text-align: left;">
                    <div style="font-weight: 900; color: var(--color-accent-gold); font-size: 0.9rem;">Portal Manajemen Pengetahuan — LITBANG 2026</div>
                    <div style="font-size: 0.75rem; color: #CBD5E1;">Gajah Mada Adhyaksa (PPPJ LXXXIII/II Tahun 2026)</div>
                </div>
            </div>
            <div style="font-size: 0.78125rem; color: #CBD5E1;">© 2026 Litbang Gajah Mada Adhyaksa. All Rights Reserved.</div>
        </div>
    </footer>
</div>
@endsection
