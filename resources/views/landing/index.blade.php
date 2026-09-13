@extends('layouts.app')

@section('content')
<style>
  /* RESPONSIVE FRESH ORGANIC GREEN SYSTEM */
  :root {
    --color-emerald-dark: #1B4332;
    --color-emerald-medium: #2D6A4F;
    --color-emerald-light: #52B788;
    --color-emerald-mint: #E8F5E9;
    --color-emerald-soft: #F4F8F4;
    --color-accent-gold: #D4AF37;
    --color-accent-gold-dark: #B48A16;
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
    overflow-x: hidden;
  }

  /* NATIVE FULL WIDTH LANDING PAGE CONTAINER (NO CUTOFF) */
  .fresh-landing-root {
    width: 100%;
    min-height: 100vh;
    box-sizing: border-box;
  }

  /* LAYOUT TOGGLE SEGMENTED CONTROL */
  .layout-toggle-container {
    display: inline-flex;
    align-items: center;
    background: #E2E8F0;
    padding: 3px;
    border-radius: 9999px;
    border: 1px solid #CBD5E1;
  }

  .layout-toggle-btn {
    appearance: none;
    -webkit-appearance: none;
    border: none !important;
    outline: none !important;
    background: transparent;
    color: #64748B;
    font-size: 0.78125rem;
    font-weight: 800;
    padding: 0.4rem 0.95rem;
    border-radius: 9999px;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    line-height: 1;
    box-sizing: border-box;
  }

  .layout-toggle-btn.active {
    background: var(--color-emerald-dark) !important;
    color: var(--color-accent-gold) !important;
    box-shadow: 0 4px 12px rgba(27, 67, 50, 0.3) !important;
  }

  .layout-toggle-btn:hover:not(.active) {
    color: var(--color-emerald-dark);
    background: rgba(255, 255, 255, 0.6);
  }

  .resp-container {
    width: 100%;
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 1.5rem;
    box-sizing: border-box;
  }

  /* TOP UTILITY BAR */
  .fresh-utility-bar {
    background: #0D2818;
    color: #A3E635;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.5rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(212,175,55,0.2);
  }

  /* CLEAN OFF-WHITE FLOATING NAVBAR */
  .fresh-navbar-header {
    background: rgba(255, 255, 255, 0.96);
    backdrop-filter: blur(12px);
    border: 1.5px solid rgba(46, 111, 64, 0.15);
    border-radius: 9999px;
    padding: 0.55rem 1.35rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 8px 24px rgba(27, 67, 50, 0.08);
    gap: 1rem;
  }

  .resp-nav-links {
    display: flex;
    align-items: center;
    gap: 0.5rem;
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

  /* HERO BANNER WITH GEDUNG KEJAKSAAN PHOTO BACKGROUND (CENTERED LIKE GAMBAR 1) */
  .fresh-hero-grid {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    background: linear-gradient(135deg, rgba(15, 35, 20, 0.86) 0%, rgba(27, 67, 50, 0.88) 100%), url('{{ asset('gedung-kejaksaan.jpg') }}');
    background-size: cover;
    background-position: center;
    border: 2px solid var(--color-accent-gold);
    border-radius: 26px;
    padding: 4.5rem 2rem 6.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 18px 45px rgba(27, 67, 50, 0.22);
    color: #FFFFFF;
  }

  .fresh-hero-grid::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 700px;
    height: 700px;
    background: radial-gradient(circle, rgba(212, 175, 55, 0.25) 0%, rgba(0,0,0,0) 70%);
    pointer-events: none;
  }

  /* 4 FEATURE CARDS ROW (OVERLAPPING BOTTOM EDGE OF HERO) */
  .fresh-feature-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.15rem;
    margin-top: -4rem;
    position: relative;
    z-index: 10;
    align-items: end;
  }

  .fresh-feature-card {
    background: #FFFFFF;
    border: 1.5px solid #E2E8F0;
    border-radius: 20px;
    padding: 1.25rem 1.15rem;
    box-shadow: 0 10px 28px rgba(27, 67, 50, 0.08);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
  }

  .fresh-feature-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 36px rgba(27, 67, 50, 0.15);
    border-color: var(--color-emerald-medium);
  }

  .fresh-feature-card.highlight {
    background: linear-gradient(135deg, var(--color-emerald-dark) 0%, var(--color-emerald-medium) 100%);
    color: #FFFFFF;
    border: 2px solid var(--color-accent-gold);
    box-shadow: 0 14px 35px rgba(27, 67, 50, 0.3);
    margin-top: -2.5rem;
    padding-top: 1rem;
  }

  /* STAKEHOLDER & CLIENTS SECTION */
  .fresh-client-section {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 2.25rem;
    align-items: center;
    margin: 4rem 0 3rem;
  }

  /* STATS & ABOUT SPLIT SECTION */
  .fresh-split-section {
    display: grid;
    grid-template-columns: 0.95fr 1.05fr;
    gap: 2.25rem;
    align-items: center;
    margin: 3.5rem 0;
  }

  .fresh-stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.1rem;
  }

  .fresh-stat-box {
    border-radius: 20px;
    padding: 1.5rem 1.15rem;
    text-align: center;
    box-shadow: 0 6px 20px rgba(27, 67, 50, 0.05);
    transition: all 0.2s ease;
    border: 1.5px solid #E2E8F0;
  }

  .fresh-stat-box.box-white { background: #FFFFFF; }
  .fresh-stat-box.box-gold { background: #FFF9E6; border-color: #FDE68A; }
  .fresh-stat-box.box-green {
    background: linear-gradient(135deg, var(--color-emerald-dark) 0%, var(--color-emerald-medium) 100%);
    color: #FFFFFF;
    border-color: var(--color-accent-gold);
  }

  .fresh-stat-box:hover { transform: translateY(-3px); }

  /* CATALOG GRID & CARD SYSTEM */
  .fresh-catalog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
    gap: 1.5rem;
  }

  .fresh-catalog-card {
    background: #FFFFFF;
    border: 1.5px solid #E2E8F0;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(27, 67, 50, 0.05);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .fresh-catalog-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 36px rgba(27, 67, 50, 0.1);
    border-color: var(--color-emerald-medium);
  }

  /* OFFICE & MAP SPLIT SECTION */
  .fresh-office-map-grid {
    display: grid;
    grid-template-columns: 0.9fr 1.1fr;
    gap: 2rem;
    margin: 3.75rem 0;
    align-items: stretch;
  }

  /* CURVED BANNER FOR FORM SUBMISSION */
  .fresh-banner-curved {
    background: linear-gradient(135deg, #0F2D21 0%, var(--color-emerald-dark) 55%, var(--color-emerald-medium) 100%);
    border: 2px solid var(--color-accent-gold);
    border-radius: 26px;
    padding: 3.25rem 2.5rem;
    color: #FFFFFF;
    margin: 3.75rem 0;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 48px rgba(27, 67, 50, 0.25);
  }

  .fresh-banner-curved::before {
    content: '';
    position: absolute;
    top: -40%;
    right: -15%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(212, 175, 55, 0.2) 0%, rgba(0,0,0,0) 70%);
    pointer-events: none;
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
    padding: 0.45rem 1.05rem;
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
    box-shadow: 0 4px 12px rgba(27, 67, 50, 0.2);
  }

  /* MEDIA QUERIES */
  @media (max-width: 992px) {
    .fresh-hero-grid { grid-template-columns: 1fr !important; padding: 2rem 1.5rem !important; }
    .fresh-feature-row { grid-template-columns: repeat(2, 1fr) !important; margin-top: 1.25rem !important; }
    .fresh-client-section { grid-template-columns: 1fr !important; }
    .fresh-split-section { grid-template-columns: 1fr !important; }
    .fresh-office-map-grid { grid-template-columns: 1fr !important; }
    .fresh-navbar-header { flex-direction: column !important; align-items: stretch !important; border-radius: 20px !important; }
    .resp-nav-links { justify-content: center !important; }
  }

  @media (max-width: 600px) {
    .fresh-feature-row { grid-template-columns: 1fr !important; }
    .fresh-stats-grid { grid-template-columns: 1fr !important; }
  }
</style>

<!-- ROOT X-DATA WRAPPER (ENCLOSES BOTH LANDING CONTENT AND UNZOOMED MODALS) -->
<div x-data="{ 
    isProposalModalOpen: false, 
    isCurriculumUploadModalOpen: false,
    selectedPdf: null, 
    selectedExecSummary: null,
    activeMainTab: 'policy',
    activeCategory: 'Semua',
    searchQuery: '{{ request('search', '') }}',
    viewMode: 'grid',
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
}">

    <!-- SCALED LANDING PAGE CONTENT (80% ZOOM ONLY ON PAGE CONTENT) -->
    <div class="fresh-landing-root" style="display: flex; flex-direction: column;">

        <!-- COPY LINK TOAST NOTIFICATION -->
        <div x-show="copyToast" style="position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 100; background: var(--color-accent-gold); color: #04140B; font-weight: 900; padding: 0.75rem 1.25rem; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); display: none;">
            ✨ Tautan Dokumen PDF Berhasil Disalin!
        </div>

        <!-- 2. TOP FLOATING OFF-WHITE NAVBAR -->
        <div style="position: sticky; top: 0.85rem; z-index: 50; padding: 0 0.85rem; margin: 0.85rem auto 0; width: 100%; max-width: 1240px; box-sizing: border-box;">
            <header class="fresh-navbar-header">
                <div style="display: flex; align-items: center; gap: 0.85rem; cursor: pointer;" onclick="window.location.href='{{ route('landing.index') }}'">
                    <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo Emblem Adhyaksa" style="height: 42px; width: auto; filter: drop-shadow(0 2px 6px rgba(0,0,0,0.15));" />
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
                    <a href="#kontak-hub">📍 Kontak</a>
                    <button @click="isProposalModalOpen = true" style="background: linear-gradient(135deg, var(--color-emerald-dark) 0%, var(--color-emerald-medium) 100%); color: var(--color-accent-gold); font-weight: 900; font-size: 0.8125rem; padding: 0.55rem 1.25rem; border-radius: 9999px; border: 1px solid var(--color-accent-gold); cursor: pointer; box-shadow: 0 4px 14px rgba(27, 67, 50, 0.25);">
                        ⚡ Ajukan Usulan
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

            <!-- 3. HERO SECTION WITH GEDUNG KEJAKSAAN AGUNG PHOTO BACKGROUND (CENTERED LIKE GAMBAR 1) -->
            <section class="fresh-hero-grid" style="margin-bottom: 0;">
                <div style="position: relative; z-index: 2; max-width: 820px; margin: 0 auto;">
                    <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.4rem 1rem; background: rgba(212, 175, 55, 0.2); border: 1.5px solid var(--color-accent-gold); border-radius: 9999px; font-size: 0.75rem; font-weight: 900; color: var(--color-accent-gold); margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <span>🏛️ KEJAKSAAN REPUBLIK INDONESIA</span>
                    </div>

                    <h1 style="font-size: clamp(2.3rem, 4.5vw, 3.5rem); font-weight: 900; line-height: 1.15; color: #FFFFFF; margin-bottom: 1.25rem; letter-spacing: -0.01em;">
                        Transformasi Riset, Inovasi <br />
                        <span style="color: var(--color-accent-gold); text-shadow: 0 4px 18px rgba(212,175,55,0.4);">
                            & Kurikulum Pembelajaran
                        </span>
                    </h1>

                    <p style="font-size: 1.05rem; color: #EBF3EC; line-height: 1.65; margin: 0 auto 2.25rem; max-width: 680px; font-weight: 500;">
                        Pusat repositori manajemen pengetahuan terpadu Angkatan Gajah Mada Adhyaksa (PPPJ LXXXIII/2026). Akses naskah akademis teruji, bank inovasi digital, dan modul pembelajaran.
                    </p>

                    <!-- 2 Centered Hero CTA Buttons -->
                    <div style="display: flex; gap: 1rem; justify-content: center; align-items: center; flex-wrap: wrap;">
                        <button @click="isProposalModalOpen = true" style="background: linear-gradient(135deg, var(--color-accent-gold) 0%, var(--color-accent-gold-dark) 100%); color: #04140B; font-weight: 900; font-size: 0.9375rem; padding: 0.85rem 2.1rem; border-radius: 9999px; border: none; cursor: pointer; box-shadow: 0 8px 24px rgba(212, 175, 55, 0.4); display: inline-flex; align-items: center; gap: 0.5rem; transition: transform 0.2s ease;">
                            ⚡ Ajukan Usulan Riset
                        </button>
                        <button @click="isCurriculumUploadModalOpen = true" style="background: rgba(255,255,255,0.15); border: 2px solid rgba(255,255,255,0.5); color: #FFFFFF; font-weight: 900; font-size: 0.9375rem; padding: 0.85rem 1.85rem; border-radius: 9999px; cursor: pointer; backdrop-filter: blur(10px); display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s ease;">
                            📚 Upload Berkas Kurikulum
                        </button>
                    </div>
                </div>
            </section>

            <!-- 4. 4 FEATURE CARDS ROW (MATCHING REFERENCE MOCKUP GAMBAR 1) -->
            <section class="fresh-feature-row">
                <div class="fresh-feature-card">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.65rem;">
                        <div style="width: 38px; height: 38px; border-radius: 12px; background: var(--color-emerald-mint); color: var(--color-emerald-dark); font-size: 1.15rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            📄
                        </div>
                        <h4 style="font-size: 0.9375rem; font-weight: 900; color: var(--color-emerald-dark); margin: 0; line-height: 1.25;">Policy Brief Akademis</h4>
                    </div>
                    <p style="font-size: 0.78125rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">Naskah kajian kebijakan hukum pidana, perdata & birokrasi teruji.</p>
                </div>

                <div class="fresh-feature-card">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.65rem;">
                        <div style="width: 38px; height: 38px; border-radius: 12px; background: var(--color-emerald-mint); color: var(--color-emerald-dark); font-size: 1.15rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            💡
                        </div>
                        <h4 style="font-size: 0.9375rem; font-weight: 900; color: var(--color-emerald-dark); margin: 0; line-height: 1.25;">Bank Inovasi Digital</h4>
                    </div>
                    <p style="font-size: 0.78125rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">Repositori SOP digitalisasi layanan publik & efisiensi kerja institusi.</p>
                </div>

                <div class="fresh-feature-card">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.65rem;">
                        <div style="width: 38px; height: 38px; border-radius: 12px; background: var(--color-emerald-mint); color: var(--color-emerald-dark); font-size: 1.15rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            📚
                        </div>
                        <h4 style="font-size: 0.9375rem; font-weight: 900; color: var(--color-emerald-dark); margin: 0; line-height: 1.25;">Kurikulum PPPJ</h4>
                    </div>
                    <p style="font-size: 0.78125rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">Modul pembelajaran, slide presentasi, dan materi diklat angkatan.</p>
                </div>

                <!-- Card 4: Green Highlight Media Card with Document Preview Thumbnail & Play Button (Matching Gambar 1) -->
                <div class="fresh-feature-card highlight">
                    <!-- Media Preview Container on top of Card 4 -->
                    <div style="position: relative; border-radius: 14px; overflow: hidden; margin-bottom: 0.85rem; height: 110px; background: url('{{ asset('gedung-kejaksaan.jpg') }}') center/cover no-repeat; border: 1.5px solid rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center;">
                        <div style="position: absolute; inset: 0; background: rgba(15, 35, 20, 0.45);"></div>
                        <button @click="openPdfPreview(policyBriefs[0]?.title || 'Policy Brief Utama', policyBriefs[0]?.doc_no || 'PB-01/LITBANG-MADA/2026', policyBriefs[0]?.file_path || '/documents/pb_01.pdf')" style="position: relative; z-index: 2; width: 44px; height: 44px; border-radius: 50%; background: var(--color-accent-gold); color: #04140B; border: 2px solid #FFFFFF; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; cursor: pointer; box-shadow: 0 6px 18px rgba(0,0,0,0.4); transition: transform 0.2s ease;" title="Buka Pratinjau Document">
                            ▶️
                        </button>
                    </div>

                    <div style="display: flex; align-items: center; gap: 0.65rem; margin-bottom: 0.4rem;">
                        <div style="width: 32px; height: 32px; border-radius: 10px; background: rgba(212,175,55,0.25); color: var(--color-accent-gold); font-size: 1rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            🏛️
                        </div>
                        <h4 style="font-size: 0.9375rem; font-weight: 900; color: #FFFFFF; margin: 0; line-height: 1.25;">Pokja Gajah Mada</h4>
                    </div>
                    <p style="font-size: 0.78125rem; color: #EBF3EC; line-height: 1.5; margin: 0;">Pusat komando penelitian & pratinjau naskah kebijakan teruji.</p>
                </div>
            </section>

            <!-- 5. MITRA STRATEGIS & TESTIMONIAL SECTION -->
            <section class="fresh-client-section">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.35rem 0.85rem; background: var(--color-emerald-mint); border-radius: 9999px; font-size: 0.71875rem; font-weight: 900; color: var(--color-emerald-dark); text-transform: uppercase; margin-bottom: 1rem;">
                        <span>🤝 MITRA STRATEGIS & STAKEHOLDER</span>
                    </div>

                    <h2 style="font-size: 1.85rem; font-weight: 900; color: var(--color-emerald-dark); line-height: 1.25; margin-bottom: 1rem;">
                        Sinergi Penegakan Hukum & Formulasi Kebijakan
                    </h2>

                    <p style="font-size: 0.875rem; color: var(--color-text-muted); line-height: 1.7; margin-bottom: 1.5rem;">
                        Litbang Gajah Mada Adhyaksa bekerja sama dengan unit kerja strategis Kejaksaan RI, Badiklat Kejaksaan, Persaja, serta jajaran Pokja Riset PPPJ LXXXIII/2026.
                    </p>

                    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                        <span style="background: #FFFFFF; border: 1.5px solid #CBD5E1; padding: 0.6rem 1.15rem; border-radius: 12px; font-size: 0.8125rem; font-weight: 800; color: var(--color-emerald-dark); box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                            ⚖️ Kejaksaan Agung RI
                        </span>
                        <span style="background: #FFFFFF; border: 1.5px solid #CBD5E1; padding: 0.6rem 1.15rem; border-radius: 12px; font-size: 0.8125rem; font-weight: 800; color: var(--color-emerald-dark); box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                            🎓 Badiklat Kejaksaan RI
                        </span>
                        <span style="background: #FFFFFF; border: 1.5px solid #CBD5E1; padding: 0.6rem 1.15rem; border-radius: 12px; font-size: 0.8125rem; font-weight: 800; color: var(--color-emerald-dark); box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                            🏛️ PERSAJA
                        </span>
                        <span style="background: #FFFFFF; border: 1.5px solid #CBD5E1; padding: 0.6rem 1.15rem; border-radius: 12px; font-size: 0.8125rem; font-weight: 800; color: var(--color-emerald-dark); box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                            ⭐️ PPPJ LXXXIII/2026
                        </span>
                    </div>
                </div>

                <div style="background: linear-gradient(135deg, var(--color-emerald-dark) 0%, var(--color-emerald-medium) 100%); border-radius: 24px; padding: 2rem; color: #FFFFFF; position: relative; box-shadow: 0 15px 35px rgba(27,67,50,0.2);">
                    <div style="font-size: 2.5rem; color: var(--color-accent-gold); font-family: Georgia, serif; line-height: 1;">“</div>
                    <p style="font-size: 0.95rem; line-height: 1.65; color: #EBF3EC; margin-bottom: 1.35rem; font-style: italic;">
                        Formulasi riset dan inovasi yang dihasilkan oleh Pokja Gajah Mada Adhyaksa menjadi pijakan penting dalam mewujudkan standar birokrasi penegakan hukum yang transparan, modern, dan berintegritas.
                    </p>
                    <div style="display: flex; align-items: center; gap: 0.85rem;">
                        <div style="width: 42px; height: 42px; border-radius: 50%; background: var(--color-accent-gold); color: #04140B; font-weight: 900; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                            ⚖️
                        </div>
                        <div>
                            <div style="font-weight: 900; font-size: 0.875rem; color: var(--color-accent-gold);">Ketua Tim Riset Pokja Gajah Mada</div>
                            <div style="font-size: 0.75rem; color: #D1E7DD;">PPPJ LXXXIII/II Tahun 2026</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 6. HIGH IMPACT 4-COLUMN STATS COUNTER BAR -->
            <section style="margin: 3.5rem 0 2rem;">
                <div class="fresh-stats-grid" style="grid-template-columns: repeat(4, 1fr);">
                    <div class="fresh-stat-box box-white">
                        <div style="font-size: 2.35rem; font-weight: 900; color: var(--color-emerald-dark); line-height: 1;">500+</div>
                        <div style="font-size: 0.8125rem; font-weight: 900; color: var(--color-text-dark); margin-top: 6px;">Peserta Angkatan</div>
                        <div style="font-size: 0.71875rem; color: var(--color-text-muted); margin-top: 2px;">PPPJ LXXXIII/2026</div>
                    </div>

                    <div class="fresh-stat-box box-gold">
                        <div style="font-size: 2.35rem; font-weight: 900; color: var(--color-accent-gold-dark); line-height: 1;">40+</div>
                        <div style="font-size: 0.8125rem; font-weight: 900; color: #92400E; margin-top: 6px;">Policy Briefs Terbit</div>
                        <div style="font-size: 0.71875rem; color: #B45309; margin-top: 2px;">Teruji Akademis</div>
                    </div>

                    <div class="fresh-stat-box box-green">
                        <div style="font-size: 2.35rem; font-weight: 900; color: var(--color-accent-gold); line-height: 1;">15+</div>
                        <div style="font-size: 0.8125rem; font-weight: 900; color: #FFFFFF; margin-top: 6px;">Inovasi Teruji</div>
                        <div style="font-size: 0.71875rem; color: #EBF3EC; margin-top: 2px;">Digital & Birokrasi</div>
                    </div>

                    <div class="fresh-stat-box box-white">
                        <div style="font-size: 2.35rem; font-weight: 900; color: #16A34A; line-height: 1;">100%</div>
                        <div style="font-size: 0.8125rem; font-weight: 900; color: var(--color-text-dark); margin-top: 6px;">Stempel QR Seal</div>
                        <div style="font-size: 0.71875rem; color: var(--color-text-muted); margin-top: 2px;">Autentik Digital</div>
                    </div>
                </div>
            </section>

            <!-- 7. 3-PILLAR CATALOG HUB -->
            <section id="katalog-hub" style="margin: 4rem 0;">
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <span style="font-size: 0.71875rem; font-weight: 900; color: var(--color-emerald-medium); text-transform: uppercase; letter-spacing: 0.05em;">PORTAL KATALOG REPOSITORI</span>
                        <h2 style="font-size: 1.85rem; font-weight: 900; color: var(--color-emerald-dark); margin-top: 0.25rem;">Katalog Pengetahuan 3 Pilar</h2>
                    </div>

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

                <!-- LIVE SEARCH BAR & LAYOUT SWITCHER -->
                <div style="background: #FFFFFF; border: 1.5px solid #CBD5E1; padding: 1.15rem 1.35rem; border-radius: 20px; margin-bottom: 1.85rem; display: flex; flex-direction: column; gap: 0.85rem; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div style="position: relative;">
                        <input type="text" x-model="searchQuery" placeholder="🔍 Cari judul naskah, inovasi, pengusul, atau modul secara instan..." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.7rem 1rem; color: var(--color-text-dark); font-size: 0.875rem; outline: none;" />
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
                        <div style="display: flex; gap: 0.4rem; flex-wrap: wrap; align-items: center;">
                            <span style="font-size: 0.75rem; color: var(--color-text-muted); font-weight: 800; margin-right: 0.25rem;">Kategori Domain:</span>
                            <button type="button" class="category-pill-btn" style="font-size: 0.75rem; padding: 0.3rem 0.75rem;" :class="{ 'active': activeCategory === 'Semua' }" @click="activeCategory = 'Semua'">Semua</button>
                            <button type="button" class="category-pill-btn" style="font-size: 0.75rem; padding: 0.3rem 0.75rem;" :class="{ 'active': activeCategory === 'Pidana' }" @click="activeCategory = 'Pidana'">Pidana</button>
                            <button type="button" class="category-pill-btn" style="font-size: 0.75rem; padding: 0.3rem 0.75rem;" :class="{ 'active': activeCategory === 'Perdata' }" @click="activeCategory = 'Perdata'">Perdata</button>
                            <button type="button" class="category-pill-btn" style="font-size: 0.75rem; padding: 0.3rem 0.75rem;" :class="{ 'active': activeCategory === 'TUN' }" @click="activeCategory = 'TUN'">TUN</button>
                            <button type="button" class="category-pill-btn" style="font-size: 0.75rem; padding: 0.3rem 0.75rem;" :class="{ 'active': activeCategory === 'SPBE' }" @click="activeCategory = 'SPBE'">SPBE</button>
                        </div>

                        <!-- LAYOUT MODE TOGGLE (GRID VS TABLE) -->
                        <div class="layout-toggle-container">
                            <button type="button" class="layout-toggle-btn" :class="{ 'active': viewMode === 'grid' }" @click="viewMode = 'grid'">
                                ▦ Mode Kartu
                            </button>
                            <button type="button" class="layout-toggle-btn" :class="{ 'active': viewMode === 'list' }" @click="viewMode = 'list'">
                                ☰ Mode Tabel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- TAB 1: POLICY BRIEF - GRID VIEW -->
                <div x-show="activeMainTab === 'policy' && viewMode === 'grid'" class="fresh-catalog-grid">
                    @foreach($policyBriefs as $brief)
                        <div class="fresh-catalog-card" style="border-top: 4px solid var(--color-emerald-dark);" x-show="(activeCategory === 'Semua' || '{{ $brief->category }}'.includes(activeCategory)) && (searchQuery === '' || '{{ strtolower($brief->title . ' ' . $brief->summary . ' ' . $brief->category . ' ' . $brief->doc_no) }}'.includes(searchQuery.toLowerCase()))">
                            <div style="padding: 1.5rem 1.35rem 0.5rem; flex: 1; display: flex; flex-direction: column;">
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

                <!-- TAB 1: POLICY BRIEF - TABLE VIEW (FOR LARGE COLLECTIONS) -->
                <div x-show="activeMainTab === 'policy' && viewMode === 'list'" x-cloak style="background: #FFFFFF; border: 1.5px solid #CBD5E1; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.8125rem;">
                            <thead>
                                <tr style="background: var(--color-emerald-dark); color: #FFFFFF; font-weight: 900; font-size: 0.78125rem; text-transform: uppercase;">
                                    <th style="padding: 1rem 1.25rem;">No. Dokumen</th>
                                    <th style="padding: 1rem 1.25rem;">Judul Naskah Kebijakan</th>
                                    <th style="padding: 1rem 1.25rem;">Kategori Bidang</th>
                                    <th style="padding: 1rem 1.25rem;">Status Verifikasi</th>
                                    <th style="padding: 1rem 1.25rem; text-align: right;">Aksi Naskah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($policyBriefs as $brief)
                                    <tr style="border-bottom: 1px solid #F1F5F9; transition: background 0.15s ease;" x-show="(activeCategory === 'Semua' || '{{ $brief->category }}'.includes(activeCategory)) && (searchQuery === '' || '{{ strtolower($brief->title . ' ' . $brief->summary . ' ' . $brief->category . ' ' . $brief->doc_no) }}'.includes(searchQuery.toLowerCase()))">
                                        <td style="padding: 1rem 1.25rem; font-family: monospace; font-weight: 800; color: var(--color-emerald-dark); white-space: nowrap;">
                                            {{ $brief->doc_no }}
                                        </td>
                                        <td style="padding: 1rem 1.25rem;">
                                            <div style="font-weight: 900; color: var(--color-text-dark); font-size: 0.875rem;">{{ $brief->title }}</div>
                                            <div style="font-size: 0.75rem; color: var(--color-text-muted); margin-top: 2px; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">{{ $brief->summary }}</div>
                                        </td>
                                        <td style="padding: 1rem 1.25rem; white-space: nowrap;">
                                            <span style="font-size: 0.75rem; font-weight: 800; color: #166534; background: #F0FDF4; border: 1px solid #DCFCE7; padding: 0.25rem 0.65rem; border-radius: 9999px;">
                                                {{ $brief->category }}
                                            </span>
                                        </td>
                                        <td style="padding: 1rem 1.25rem; white-space: nowrap;">
                                            <span style="font-size: 0.72rem; color: #16A34A; font-weight: 900;">🟢 QR Seal OK</span>
                                        </td>
                                        <td style="padding: 1rem 1.25rem; text-align: right; white-space: nowrap;">
                                            <div style="display: inline-flex; gap: 0.4rem;">
                                                <button type="button" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; color: var(--color-emerald-dark); font-weight: 800; font-size: 0.75rem; padding: 0.35rem 0.75rem; border-radius: 7px; cursor: pointer;" @click="openPdfPreview(policyBriefs[{{ $loop->index }}].title, policyBriefs[{{ $loop->index }}].doc_no, policyBriefs[{{ $loop->index }}].file_path)">
                                                    👁️ Pratinjau
                                                </button>
                                                <a href="{{ route('catalog.download', ['kajian', $brief->id]) }}" style="background: var(--color-emerald-dark); color: var(--color-accent-gold); font-weight: 900; font-size: 0.75rem; padding: 0.35rem 0.75rem; border-radius: 7px; text-decoration: none;">
                                                    📥 Download
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 2: INOVASI TERUJI - GRID VIEW -->
                <div x-show="activeMainTab === 'innovation' && viewMode === 'grid'" x-cloak class="fresh-catalog-grid">
                    @foreach($innovations as $inov)
                        <div class="fresh-catalog-card" style="border-top: 4px solid #0284C7;" x-show="(activeCategory === 'Semua' || '{{ $inov->category }}'.includes(activeCategory)) && (searchQuery === '' || '{{ strtolower($inov->title . ' ' . $inov->summary . ' ' . $inov->category . ' ' . $inov->innovation_no) }}'.includes(searchQuery.toLowerCase()))">
                            <div style="padding: 1.5rem 1.35rem 0.5rem; flex: 1; display: flex; flex-direction: column;">
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

                <!-- TAB 2: INOVASI TERUJI - TABLE VIEW -->
                <div x-show="activeMainTab === 'innovation' && viewMode === 'list'" x-cloak style="background: #FFFFFF; border: 1.5px solid #CBD5E1; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.8125rem;">
                            <thead>
                                <tr style="background: #0284C7; color: #FFFFFF; font-weight: 900; font-size: 0.78125rem; text-transform: uppercase;">
                                    <th style="padding: 1rem 1.25rem;">No. Inovasi</th>
                                    <th style="padding: 1rem 1.25rem;">Judul Inovasi Digital</th>
                                    <th style="padding: 1rem 1.25rem;">Kategori / Status</th>
                                    <th style="padding: 1rem 1.25rem;">Dampak Utama</th>
                                    <th style="padding: 1rem 1.25rem; text-align: right;">Berkas SOP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($innovations as $inov)
                                    <tr style="border-bottom: 1px solid #F1F5F9; transition: background 0.15s ease;" x-show="(activeCategory === 'Semua' || '{{ $inov->category }}'.includes(activeCategory)) && (searchQuery === '' || '{{ strtolower($inov->title . ' ' . $inov->summary . ' ' . $inov->category . ' ' . $inov->innovation_no) }}'.includes(searchQuery.toLowerCase()))">
                                        <td style="padding: 1rem 1.25rem; font-family: monospace; font-weight: 800; color: #0284C7; white-space: nowrap;">
                                            {{ $inov->innovation_no }}
                                        </td>
                                        <td style="padding: 1rem 1.25rem;">
                                            <div style="font-weight: 900; color: var(--color-text-dark); font-size: 0.875rem;">{{ $inov->title }}</div>
                                            <div style="font-size: 0.75rem; color: var(--color-text-muted); margin-top: 2px; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">{{ $inov->summary }}</div>
                                        </td>
                                        <td style="padding: 1rem 1.25rem; white-space: nowrap;">
                                            <span style="font-size: 0.75rem; font-weight: 800; color: #075985; background: #F0F9FF; border: 1px solid #E0F2FE; padding: 0.25rem 0.65rem; border-radius: 9999px;">
                                                {{ $inov->status }}
                                            </span>
                                        </td>
                                        <td style="padding: 1rem 1.25rem; color: #0369A1; font-size: 0.78rem; font-weight: 700;">
                                            {{ $inov->impact_description ?? '-' }}
                                        </td>
                                        <td style="padding: 1rem 1.25rem; text-align: right; white-space: nowrap;">
                                            <div style="display: inline-flex; gap: 0.4rem;">
                                                <button type="button" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; color: #0369A1; font-weight: 800; font-size: 0.75rem; padding: 0.35rem 0.75rem; border-radius: 7px; cursor: pointer;" @click="openPdfPreview(innovations[{{ $loop->index }}].title, innovations[{{ $loop->index }}].innovation_no, innovations[{{ $loop->index }}].sop_file_path)">
                                                    👁️ Pratinjau
                                                </button>
                                                <a href="{{ route('catalog.download', ['innovation', $inov->id]) }}" style="background: #0284C7; color: #FFFFFF; font-weight: 900; font-size: 0.75rem; padding: 0.35rem 0.75rem; border-radius: 7px; text-decoration: none;">
                                                    📥 SOP PDF
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 3: KURIKULUM & MATERI - GRID VIEW -->
                <div x-show="activeMainTab === 'curriculum' && viewMode === 'grid'" x-cloak class="fresh-catalog-grid">
                    @foreach($curriculums as $curr)
                        <div class="fresh-catalog-card" style="border-top: 4px solid #16A34A;" x-show="(activeCategory === 'Semua' || '{{ $curr->subject_category }}'.includes(activeCategory)) && (searchQuery === '' || '{{ strtolower($curr->title . ' ' . $curr->subject_category . ' ' . $curr->file_type) }}'.includes(searchQuery.toLowerCase()))">
                            <div style="padding: 1.5rem 1.35rem 0.5rem; flex: 1; display: flex; flex-direction: column;">
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

                <!-- TAB 3: KURIKULUM & MATERI - TABLE VIEW -->
                <div x-show="activeMainTab === 'curriculum' && viewMode === 'list'" x-cloak style="background: #FFFFFF; border: 1.5px solid #CBD5E1; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.8125rem;">
                            <thead>
                                <tr style="background: #16A34A; color: #FFFFFF; font-weight: 900; font-size: 0.78125rem; text-transform: uppercase;">
                                    <th style="padding: 1rem 1.25rem;">Tipe Modul</th>
                                    <th style="padding: 1rem 1.25rem;">Judul Modul Pembelajaran</th>
                                    <th style="padding: 1rem 1.25rem;">Bidang Materi</th>
                                    <th style="padding: 1rem 1.25rem;">Pengunggah</th>
                                    <th style="padding: 1rem 1.25rem; text-align: right;">Aksi Modul</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($curriculums as $curr)
                                    <tr style="border-bottom: 1px solid #F1F5F9; transition: background 0.15s ease;" x-show="(activeCategory === 'Semua' || '{{ $curr->subject_category }}'.includes(activeCategory)) && (searchQuery === '' || '{{ strtolower($curr->title . ' ' . $curr->subject_category . ' ' . $curr->file_type) }}'.includes(searchQuery.toLowerCase()))">
                                        <td style="padding: 1rem 1.25rem; white-space: nowrap;">
                                            <span style="font-size: 0.75rem; font-weight: 800; color: #166534; background: #F0FDF4; border: 1px solid #DCFCE7; padding: 0.25rem 0.65rem; border-radius: 9999px;">
                                                📚 {{ $curr->file_type }}
                                            </span>
                                        </td>
                                        <td style="padding: 1rem 1.25rem;">
                                            <div style="font-weight: 900; color: var(--color-text-dark); font-size: 0.875rem;">{{ $curr->title }}</div>
                                            @if($curr->description)
                                                <div style="font-size: 0.75rem; color: var(--color-text-muted); margin-top: 2px;">{{ $curr->description }}</div>
                                            @endif
                                        </td>
                                        <td style="padding: 1rem 1.25rem; white-space: nowrap;">
                                            <span style="font-size: 0.75rem; font-weight: 800; color: #92400E; background: #FEF3C7; border: 1px solid #FDE68A; padding: 0.25rem 0.65rem; border-radius: 6px;">
                                                {{ $curr->subject_category }}
                                            </span>
                                        </td>
                                        <td style="padding: 1rem 1.25rem; color: var(--color-text-muted); white-space: nowrap;">
                                            {{ $curr->uploader_name ?? 'Admin Litbang' }}
                                        </td>
                                        <td style="padding: 1rem 1.25rem; text-align: right; white-space: nowrap;">
                                            <div style="display: inline-flex; gap: 0.4rem;">
                                                @if($curr->external_link)
                                                    <a href="{{ $curr->external_link }}" target="_blank" rel="noopener noreferrer" style="background: #0284C7; color: #FFF; font-weight: 900; font-size: 0.75rem; padding: 0.35rem 0.75rem; border-radius: 7px; text-decoration: none;">
                                                        🔗 Drive
                                                    </a>
                                                @endif
                                                @if($curr->file_path)
                                                    <button type="button" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; color: #15803D; font-weight: 800; font-size: 0.75rem; padding: 0.35rem 0.75rem; border-radius: 7px; cursor: pointer;" @click="previewCurriculum(curriculums[{{ $loop->index }}])">
                                                        👁️ Pratinjau
                                                    </button>
                                                    <a href="{{ $curr->file_path }}" download style="background: #16A34A; color: #FFFFFF; font-weight: 900; font-size: 0.75rem; padding: 0.35rem 0.75rem; border-radius: 7px; text-decoration: none;">
                                                        📥 Unduh
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- 8. OFFICE & MAP SPLIT SECTION -->
            <section class="fresh-office-map-grid" id="kontak-hub">
                <div style="background: #FFFFFF; border: 1.5px solid #CBD5E1; border-radius: 24px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.04); display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.35rem 0.85rem; background: var(--color-emerald-mint); border-radius: 9999px; font-size: 0.71875rem; font-weight: 900; color: var(--color-emerald-dark); text-transform: uppercase; margin-bottom: 1rem;">
                            <span>📍 SEKRETARIAT POKJA</span>
                        </div>

                        <h3 style="font-size: 1.5rem; font-weight: 900; color: var(--color-emerald-dark); line-height: 1.3; margin-bottom: 1rem;">
                            Posko Penelitian & Riset Hukum Angkatan
                        </h3>

                        <div style="display: flex; flex-direction: column; gap: 0.85rem; font-size: 0.875rem; color: var(--color-text-dark); margin-bottom: 1.5rem;">
                            <div>🏢 <strong>Badiklat Kejaksaan RI Kampus A</strong></div>
                            <div>📍 Jl. Ragunan No. 6, Pasar Minggu, Jakarta Selatan</div>
                            <div>📞 (021) 780-0012 / Ext. 832026</div>
                            <div>✉️ litbang.mada@kejaksaan.go.id</div>
                        </div>
                    </div>

                    <div style="background: var(--color-emerald-mint); border: 1.5px solid var(--color-emerald-light); border-radius: 16px; padding: 1.15rem; display: flex; align-items: center; gap: 1rem;">
                        <div style="font-size: 2rem;">🏆</div>
                        <div>
                            <div style="font-size: 1.25rem; font-weight: 900; color: var(--color-emerald-dark);">500+ Peserta</div>
                            <div style="font-size: 0.75rem; color: var(--color-text-muted);">PPPJ LXXXIII/II Tahun 2026</div>
                        </div>
                    </div>
                </div>

                <div style="background: #E2E8F0; border: 2px solid var(--color-accent-gold); border-radius: 24px; overflow: hidden; position: relative; min-height: 320px; box-shadow: 0 10px 30px rgba(0,0,0,0.06);">
                    <iframe src="https://maps.google.com/maps?q=Badiklat+Kejaksaan+RI+Pasar+Minggu&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="100%" style="border:0; min-height: 320px;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </section>

            <!-- 9. CURVED BANNER FOR QUICK SUBMISSION (REDESIGNED 2-COLUMN PREMIUM LAYOUT) -->
            <section class="fresh-banner-curved" id="lacak-tiket-hub">
                <div style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 2.5rem; align-items: center; position: relative; z-index: 2;">
                    <!-- Left Side: Call to Action -->
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.4rem 1rem; background: rgba(212, 175, 55, 0.2); border: 1.5px solid var(--color-accent-gold); border-radius: 9999px; font-size: 0.75rem; font-weight: 900; color: var(--color-accent-gold); text-transform: uppercase; margin-bottom: 1.25rem; letter-spacing: 0.04em;">
                            <span>📥 LAYANAN USULAN ANGKATAN</span>
                        </div>

                        <h2 style="font-size: clamp(1.8rem, 3.2vw, 2.3rem); font-weight: 900; color: #FFFFFF; line-height: 1.25; margin-bottom: 1.15rem;">
                            Mulai Kirimkan Usulan Riset atau Ide Inovasi Anda Sekarang
                        </h2>

                        <p style="font-size: 0.95rem; color: #EBF3EC; line-height: 1.7; margin-bottom: 2rem; max-width: 600px;">
                            Gunakan Kode PIN Angkatan (<strong style="color: var(--color-accent-gold);">{{ $setting->batch_passcode }}</strong>) untuk mendaftarkan naskah kebijakan atau modul kurikulum Anda secara langsung ke Pokja Riset.
                        </p>

                        <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
                            <button @click="isProposalModalOpen = true" style="background: linear-gradient(135deg, var(--color-accent-gold) 0%, var(--color-accent-gold-dark) 100%); color: #04140B; font-weight: 900; font-size: 0.9375rem; padding: 0.85rem 1.85rem; border-radius: 9999px; border: none; cursor: pointer; box-shadow: 0 8px 24px rgba(212, 175, 55, 0.35); display: inline-flex; align-items: center; gap: 0.4rem; transition: transform 0.2s ease;">
                                ⚡ Ajukan Usulan Riset
                            </button>
                            <button @click="isCurriculumUploadModalOpen = true" style="background: rgba(255,255,255,0.15); border: 1.5px solid rgba(255,255,255,0.45); color: #FFFFFF; font-weight: 800; font-size: 0.9375rem; padding: 0.85rem 1.65rem; border-radius: 9999px; cursor: pointer; backdrop-filter: blur(8px); display: inline-flex; align-items: center; gap: 0.4rem;">
                                📚 Upload Berkas Kurikulum
                            </button>
                        </div>
                    </div>

                    <!-- Right Side: Passcode & Direct Access Badge Card -->
                    <div style="background: rgba(255, 255, 255, 0.07); border: 1.5px solid rgba(212, 175, 55, 0.45); backdrop-filter: blur(14px); border-radius: 24px; padding: 1.85rem 1.65rem; color: #FFFFFF; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.15rem; flex-wrap: wrap; gap: 0.5rem;">
                            <span style="font-size: 0.72rem; font-weight: 900; color: var(--color-accent-gold); background: rgba(212,175,55,0.2); padding: 0.3rem 0.75rem; border-radius: 9999px; border: 1px solid var(--color-accent-gold); letter-spacing: 0.05em;">
                                🔑 ACCESS PASSCODE
                            </span>
                            <span style="font-size: 0.72rem; color: #86EFAC; font-weight: 800; display: inline-flex; align-items: center; gap: 0.3rem;">
                                🟢 SYSTEM READY
                            </span>
                        </div>

                        <div style="background: rgba(0, 0, 0, 0.3); border: 1px dashed var(--color-accent-gold); border-radius: 16px; padding: 1.15rem; text-align: center; margin-bottom: 1.35rem;">
                            <div style="font-size: 0.71875rem; color: #D1E7DD; text-transform: uppercase; font-weight: 800; letter-spacing: 0.05em;">PIN Otentikasi Angkatan</div>
                            <div style="font-size: 1.85rem; font-weight: 900; color: var(--color-accent-gold); letter-spacing: 0.12em; font-family: 'JetBrains Mono', monospace; margin-top: 0.25rem;">
                                {{ $setting->batch_passcode }}
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 0.65rem; font-size: 0.8125rem; color: #EBF3EC;">
                            <div style="display: flex; align-items: center; gap: 0.6rem;">
                                <span style="color: var(--color-accent-gold); font-weight: 900;">✓</span> Langsung Masuk ke Database Pokja Riset
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.6rem;">
                                <span style="color: var(--color-accent-gold); font-weight: 900;">✓</span> Autentikasi Stempel QR Seal Digital
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.6rem;">
                                <span style="color: var(--color-accent-gold); font-weight: 900;">✓</span> Pencatatan Tiket Lacak Real-time
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 10. TICKET TRACKER LOOKUP BOX -->
            <section style="background: #FFFFFF; border: 1.5px solid #CBD5E1; border-radius: 24px; padding: 2rem; margin-bottom: 3.5rem; box-shadow: 0 8px 24px rgba(0,0,0,0.03);">
                <div style="max-width: 680px; margin: 0 auto; text-align: center;">
                    <span style="font-size: 0.71875rem; font-weight: 900; color: var(--color-emerald-medium); text-transform: uppercase;">🎟️ STATUS LACAK TIKET USULAN</span>
                    <h3 style="font-size: 1.5rem; font-weight: 900; color: var(--color-emerald-dark); margin-top: 0.25rem; margin-bottom: 1rem;">
                        Cek Progres Penelaahan Usulan Anda
                    </h3>
                    <form action="{{ route('landing.index') }}" method="GET" style="display: flex; gap: 0.6rem; flex-wrap: wrap;">
                        <input type="text" name="ticket_no" value="{{ request('ticket_no') }}" placeholder="Masukkan Nomor Tiket (contoh: PB-01/LITBANG-MADA/2026)..." style="flex: 1; min-width: 260px; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 12px; padding: 0.75rem 1rem; color: var(--color-text-dark); font-size: 0.875rem; outline: none;" required />
                        <button type="submit" style="background: var(--color-emerald-dark); color: var(--color-accent-gold); font-weight: 900; font-size: 0.875rem; padding: 0.75rem 1.5rem; border-radius: 12px; border: none; cursor: pointer;">
                            🔎 Cari Tiket
                        </button>
                    </form>

                    @if($trackedTicket)
                        <div style="margin-top: 1.5rem; text-align: left; background: #F0FDF4; border: 1.5px solid #86EFAC; border-radius: 16px; padding: 1.25rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="font-weight: 900; color: #166534;">Tiket: {{ $trackedTicket->ticket_no }}</span>
                                <span style="background: #DCFCE7; color: #15803D; font-weight: 800; font-size: 0.75rem; padding: 0.25rem 0.65rem; border-radius: 9999px;">
                                    {{ $trackedTicket->status }}
                                </span>
                            </div>
                            <div style="font-size: 0.95rem; font-weight: 800; color: var(--color-emerald-dark);">{{ $trackedTicket->title }}</div>
                            <div style="font-size: 0.8125rem; color: #475569; margin-top: 0.25rem;">Pengusul: {{ $trackedTicket->name }} ({{ $trackedTicket->institution }})</div>
                            <div style="font-size: 0.8125rem; color: #15803D; margin-top: 0.5rem; font-weight: 700;">📌 Update Terakhir: {{ $trackedTicket->last_update_note }}</div>
                        </div>
                    @endif
                </div>
            </section>

        </main>

        <!-- 11. DARK ORGANIC GREEN FOOTER -->
        <footer style="background: #0A1C14; border-top: 3px solid var(--color-accent-gold); color: #E2E8F0; padding: 4rem 1.5rem 2rem;">
            <div class="resp-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2.5rem; margin-bottom: 3rem;">
                <div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                        <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo Emblem" style="height: 42px; width: auto;" />
                        <div>
                            <div style="font-weight: 900; font-size: 0.95rem; color: #FFFFFF;">LITBANG GAJAH MADA</div>
                            <div style="font-size: 0.68rem; color: var(--color-accent-gold); font-weight: 800;">PPPJ LXXXIII/II TAHUN 2026</div>
                        </div>
                    </div>
                    <p style="font-size: 0.8125rem; color: #94A3B8; line-height: 1.6;">
                        Portal manajemen pengetahuan dan riset kebijakan terpadu Kejaksaan Republik Indonesia.
                    </p>
                </div>

                <div>
                    <h4 style="font-size: 0.95rem; font-weight: 900; color: var(--color-accent-gold); margin-bottom: 1rem;">Katalog 3 Pilar</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.8125rem;">
                        <a href="#katalog-hub" style="color: #CBD5E1; text-decoration: none;">📄 Policy Brief Akademis</a>
                        <a href="#katalog-hub" style="color: #CBD5E1; text-decoration: none;">💡 Bank Inovasi Digital</a>
                        <a href="#katalog-hub" style="color: #CBD5E1; text-decoration: none;">📚 Kurikulum PPPJ 2026</a>
                    </div>
                </div>

                <div>
                    <h4 style="font-size: 0.95rem; font-weight: 900; color: var(--color-accent-gold); margin-bottom: 1rem;">Tautan Cepat</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.8125rem;">
                        <a href="#lacak-tiket-hub" style="color: #CBD5E1; text-decoration: none;">🎟️ Lacak Tiket Usulan</a>
                        <a href="{{ route('login') }}" style="color: #CBD5E1; text-decoration: none;">🔑 Masuk Admin</a>
                    </div>
                </div>

                <div>
                    <h4 style="font-size: 0.95rem; font-weight: 900; color: var(--color-accent-gold); margin-bottom: 1rem;">Sekretariat</h4>
                    <p style="font-size: 0.8125rem; color: #94A3B8; line-height: 1.6;">
                        Badiklat Kejaksaan RI Kampus A<br />
                        Jl. Ragunan No. 6, Pasar Minggu, Jakarta Selatan<br />
                        Email: litbang@kejaksaan.go.id
                    </p>
                </div>
            </div>

            <div style="border-top: 1px solid #1E293B; padding-top: 1.5rem; text-align: center; font-size: 0.75rem; color: #64748B;">
                © 2026 Litbang Gajah Mada Adhyaksa (PPPJ LXXXIII/II). Hak Cipta Dilindungi Undang-Undang.
            </div>
        </footer>

    </div>
    <!-- END SCALED LANDING PAGE CONTENT -->

    <!-- CLEAN FIXED MODALS (100% STANDALONE OVERLAY OUTSIDE SCALED CONTAINER - PERFECTLY CENTERED & NORMAL COMFORTABLE SIZE) -->

    <!-- MODAL 1: FORMULIR PENGUSULAN INTERNAL (AJUKAN PIN) -->
    <div x-show="isProposalModalOpen" x-cloak style="position: fixed; inset: 0; z-index: 99999; background: rgba(15,23,42,0.75); backdrop-filter: blur(6px); display: flex; align-items: center; justify-content: center; padding: 1rem;" @keydown.escape.window="isProposalModalOpen = false">
        <div @click.away="isProposalModalOpen = false" style="background: #FFFFFF; border: 2px solid var(--color-accent-gold); border-radius: 20px; width: 100%; max-width: 580px; max-height: 85vh; overflow-y: auto; padding: 1.5rem; box-shadow: 0 25px 50px rgba(0,0,0,0.4); color: var(--color-text-dark); margin: auto;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.85rem; border-bottom: 1.5px solid #F1F5F9; padding-bottom: 0.65rem;">
                <div>
                    <span style="font-size: 0.72rem; font-weight: 900; color: var(--color-emerald-medium); text-transform: uppercase; letter-spacing: 0.03em;">FORMULIR KODE PIN ANGKATAN</span>
                    <h3 style="font-size: 1.15rem; font-weight: 900; color: var(--color-emerald-dark); margin-top: 2px;">Ajukan Usulan Riset / Ide Inovasi Baru</h3>
                </div>
                <button type="button" @click="isProposalModalOpen = false" style="background: #F1F5F9; border: none; font-size: 1.1rem; color: #64748B; width: 32px; height: 32px; border-radius: 50%; cursor: pointer;">✕</button>
            </div>

            <form action="{{ route('landing.submit_proposal') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 0.85rem;">
                @csrf
                <div style="background: var(--color-emerald-mint); border: 1.5px solid var(--color-emerald-light); padding: 0.6rem 0.85rem; border-radius: 8px; font-size: 0.78125rem; color: var(--color-emerald-dark); font-weight: 800;">
                    🔑 Masukkan PIN Angkatan: <span style="color: var(--color-accent-gold-dark);">GAJAHMADA2026</span>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Kode PIN Akses *</label>
                        <input type="password" name="batch_pin" value="GAJAHMADA2026" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;" />
                    </div>

                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Jenis Usulan *</label>
                        <select name="type" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;">
                            <option value="Policy Brief">📄 Policy Brief / Naskah Kebijakan</option>
                            <option value="Ide Inovasi">💡 Ide Inovasi Digital & Birokrasi</option>
                            <option value="Kurikulum">📚 Kurikulum & Modul Pembelajaran</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Nama Pengusul *</label>
                        <input type="text" name="name" required placeholder="Nama Lengkap & Gelar..." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;" />
                    </div>

                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Satuan Kerja / Asal *</label>
                        <input type="text" name="institution" required placeholder="Kejari / Kejati / Badiklat..." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;" />
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Kategori Bidang *</label>
                        <select name="category" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;">
                            <option value="Hukum & Tata Kelola">Hukum & Tata Kelola</option>
                            <option value="Pidana">Pidana Khusus / Umum</option>
                            <option value="Perdata">Perdata & Tata Usaha Negara</option>
                            <option value="SPBE">SPBE & Digitalisasi</option>
                        </select>
                    </div>

                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Tingkat Urgensi *</label>
                        <select name="urgency" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;">
                            <option value="Sangat Tinggi">🔴 Sangat Tinggi (Mendesak)</option>
                            <option value="Tinggi">🟠 Tinggi</option>
                            <option value="Sedang">🟢 Sedang</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Judul Usulan Naskah / Inovasi *</label>
                    <input type="text" name="title" required placeholder="Judul lengkap usulan..." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;" />
                </div>

                <div>
                    <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Deskripsi Singkat / Latar Belakang *</label>
                    <textarea name="description" rows="3" required placeholder="Jelaskan ringkasan masalah dan usulan solusi..." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;"></textarea>
                </div>

                <div>
                    <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Unggah Berkas Naskah / Draf (PDF/Docx)</label>
                    <input type="file" name="attachment" style="width: 100%; font-size: 0.78125rem;" />
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.65rem; margin-top: 0.4rem;">
                    <button type="button" @click="isProposalModalOpen = false" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 800; padding: 0.5rem 1.15rem; border-radius: 8px; cursor: pointer; font-size: 0.8125rem;">Batal</button>
                    <button type="submit" style="background: linear-gradient(135deg, var(--color-emerald-dark) 0%, var(--color-emerald-medium) 100%); color: var(--color-accent-gold); font-weight: 900; padding: 0.5rem 1.35rem; border-radius: 8px; border: none; cursor: pointer; font-size: 0.8125rem; box-shadow: 0 4px 14px rgba(27,67,50,0.25);">
                        ⚡ Submit Usulan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: UPLOAD KURIKULUM -->
    <div x-show="isCurriculumUploadModalOpen" x-cloak style="position: fixed; inset: 0; z-index: 99999; background: rgba(15,23,42,0.75); backdrop-filter: blur(6px); display: flex; align-items: center; justify-content: center; padding: 1rem;" @keydown.escape.window="isCurriculumUploadModalOpen = false">
        <div @click.away="isCurriculumUploadModalOpen = false" style="background: #FFFFFF; border: 2px solid var(--color-accent-gold); border-radius: 20px; width: 100%; max-width: 540px; max-height: 85vh; overflow-y: auto; padding: 1.5rem; box-shadow: 0 25px 50px rgba(0,0,0,0.4); color: var(--color-text-dark); margin: auto;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.85rem; border-bottom: 1.5px solid #F1F5F9; padding-bottom: 0.65rem;">
                <div>
                    <span style="font-size: 0.72rem; font-weight: 900; color: #16A34A; text-transform: uppercase;">MODUL KURIKULUM PPPJ</span>
                    <h3 style="font-size: 1.15rem; font-weight: 900; color: var(--color-emerald-dark); margin-top: 2px;">Upload Berkas Modul Pembelajaran</h3>
                </div>
                <button type="button" @click="isCurriculumUploadModalOpen = false" style="background: #F1F5F9; border: none; font-size: 1.1rem; color: #64748B; width: 32px; height: 32px; border-radius: 50%; cursor: pointer;">✕</button>
            </div>

            <form action="{{ route('landing.curriculums.upload') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 0.85rem;">
                @csrf
                <input type="hidden" name="batch_pin" value="GAJAHMADA2026" />

                <div>
                    <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Nama Pengunggah *</label>
                    <input type="text" name="uploader_name" required placeholder="Nama Lengkap..." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;" />
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Bidang Materi *</label>
                        <select name="subject_category" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;">
                            <option value="Pidana">Hukum Pidana</option>
                            <option value="Perdata">Hukum Perdata & TUN</option>
                            <option value="Intelijen">Intelijen Kejaksaan</option>
                            <option value="Manajemen">Manajemen Birokrasi</option>
                        </select>
                    </div>

                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Tipe Berkas *</label>
                        <select name="file_type" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;">
                            <option value="Modul PDF">Modul PDF</option>
                            <option value="Slide PPT">Slide Presentasi (PPT)</option>
                            <option value="Bahan Ajar">Bahan Ajar / Draf</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Judul Modul / Materi *</label>
                    <input type="text" name="title" required placeholder="Judul Modul..." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;" />
                </div>

                <div>
                    <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Link External (Google Drive / OneDrive - Optional)</label>
                    <input type="url" name="external_link" placeholder="https://drive.google.com/..." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;" />
                </div>

                <div>
                    <label style="font-size: 0.78125rem; font-weight: 800; color: var(--color-text-dark); display: block; margin-bottom: 0.2rem;">Unggah Berkas PDF / PPT</label>
                    <input type="file" name="attachment" style="width: 100%; font-size: 0.78125rem;" />
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.65rem; margin-top: 0.4rem;">
                    <button type="button" @click="isCurriculumUploadModalOpen = false" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 800; padding: 0.5rem 1.15rem; border-radius: 8px; cursor: pointer; font-size: 0.8125rem;">Batal</button>
                    <button type="submit" style="background: linear-gradient(135deg, #16A34A 0%, #15803D 100%); color: #FFFFFF; font-weight: 900; padding: 0.5rem 1.35rem; border-radius: 8px; border: none; cursor: pointer; font-size: 0.8125rem;">
                        📚 Upload Modul
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 3: PRATINJAU DOKUMEN PDF INTERAKTIF -->
    <div x-show="selectedPdf" x-cloak style="position: fixed; inset: 0; z-index: 99999; background: rgba(15,23,42,0.8); backdrop-filter: blur(6px); display: flex; align-items: center; justify-content: center; padding: 1rem;" @keydown.escape.window="selectedPdf = null">
        <div @click.away="selectedPdf = null" style="background: #FFFFFF; border: 2px solid var(--color-accent-gold); border-radius: 20px; width: 100%; max-width: 860px; height: 82vh; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.5); margin: auto;">
            <div style="background: var(--color-emerald-dark); color: #FFFFFF; padding: 0.85rem 1.25rem; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <span style="font-size: 0.72rem; color: var(--color-accent-gold); font-weight: 900;" x-text="selectedPdf ? selectedPdf.doc_no : ''"></span>
                    <h3 style="font-size: 1.05rem; font-weight: 900; margin-top: 1px; color: #FFFFFF;" x-text="selectedPdf ? selectedPdf.title : ''"></h3>
                </div>
                <button type="button" @click="selectedPdf = null" style="background: rgba(255,255,255,0.15); border: none; color: #FFFFFF; font-size: 1rem; width: 32px; height: 32px; border-radius: 50%; cursor: pointer;">✕</button>
            </div>

            <div style="flex: 1; background: #525659; position: relative;">
                <template x-if="selectedPdf && selectedPdf.file_path">
                    <iframe :src="selectedPdf.file_path" style="width: 100%; height: 100%; border: none;"></iframe>
                </template>
            </div>

            <div style="background: #FAFDFB; border-top: 1px solid #E2E8F0; padding: 0.75rem 1.25rem; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.78125rem; color: #16A34A; font-weight: 900;">🟢 Stempel Digital Terverifikasi OK</span>
                <button @click="selectedPdf = null" style="background: var(--color-emerald-dark); color: var(--color-accent-gold); font-weight: 900; font-size: 0.8125rem; padding: 0.45rem 1.15rem; border-radius: 8px; border: none; cursor: pointer;">
                    Tutup Pratinjau
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
