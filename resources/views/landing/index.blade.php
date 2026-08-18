@extends('layouts.app')

@section('content')
<div x-data="{ 
    isProposalModalOpen: false, 
    selectedPdf: null, 
    selectedExecSummary: null,
    activeCategory: 'Semua',
    searchQuery: '{{ request('search', '') }}',
    copyToast: false,
    isMobileMenuOpen: false,
    policyBriefs: {{ json_encode($policyBriefs) }},
    copyLink(docNo) {
        navigator.clipboard.writeText(window.location.origin + '/#katalog-hub');
        this.copyToast = true;
        setTimeout(() => { this.copyToast = false; }, 3000);
    }
}" style="min-height: 100vh; display: flex; flex-direction: column; background: #04140B; color: #FFFFFF; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden;">

    <!-- TOP ANNOUNCEMENT TICKER -->
    <div style="background: #020C07; color: #FFFFFF; padding: 0.4rem 1.5rem; font-size: 0.75rem; border-bottom: 1.5px solid #C59B27; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 0.75rem; overflow: hidden;">
            <span style="background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%); color: #04140B; font-weight: 900; padding: 0.15rem 0.6rem; border-radius: 4px; font-size: 0.6875rem; flex-shrink: 0; letter-spacing: 0.05em;">
                🏛️ PUBLIKASI RESMI TERBARU
            </span>
            <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: 600; color: #E2E8F0;">
                ✨ Executive Policy Brief No. <strong>PB-01/LITBANG-MADA/2026</strong> — <em>"Pedoman Perampasan Aset Kejahatan Lintas Batas Tanpa Pemidanaan"</em> — Telah Terbit di Vault.
            </div>
        </div>
        <div style="font-size: 0.6875rem; color: #D4AF37; font-weight: 800; flex-shrink: 0;">
            SENAT GAJAH MADA ADHYAKSA
        </div>
    </div>

    <!-- COPY LINK TOAST -->
    <div x-show="copyToast" style="position: fixed; bottom: 2rem; right: 2rem; z-index: 100; background: #C59B27; color: #04140B; font-weight: 900; padding: 0.875rem 1.5rem; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); display: none;">
        ✨ Tautan Dokumen PDF Berhasil Disalin!
    </div>

    <!-- TOP FLOATING PILL NAVBAR ISLAND -->
    <div style="position: sticky; top: 0.875rem; z-index: 50; padding: 0 1.25rem; max-width: 1160px; margin: 0 auto; width: 100%;">
        <header style="background: rgba(7, 39, 24, 0.92); backdrop-filter: blur(16px); border: 1.5px solid rgba(197, 155, 39, 0.45); border-radius: 9999px; padding: 0.5rem 1.5rem; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 16px 36px rgba(0,0,0,0.45);">
            <div style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;" onclick="window.location.href='{{ route('landing.index') }}'">
                <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo Emblem Adhyaksa" style="height: 36px; width: auto;" />
                <div>
                    <div style="font-weight: 900; font-size: 1rem; color: #FFFFFF; line-height: 1.1;">
                        LITBANG MADA ADHYAKSA
                    </div>
                    <div style="font-size: 0.625rem; color: #D4AF37; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em;">
                        SENAT GAJAH MADA ADHYAKSA
                    </div>
                </div>
            </div>

            <nav style="display: flex; align-items: center; gap: 0.75rem;">
                <a href="#katalog-hub" style="font-size: 0.78125rem; font-weight: 800; color: #E2E8F0; padding: 0.4rem 0.875rem; border-radius: 9999px; transition: all 0.2s;" onmouseover="this.style.color='#D4AF37'" onmouseout="this.style.color='#E2E8F0'">
                    📄 Katalog PDF
                </a>
                <a href="#lacak-tiket-hub" style="font-size: 0.78125rem; font-weight: 800; color: #E2E8F0; padding: 0.4rem 0.875rem; border-radius: 9999px; transition: all 0.2s;" onmouseover="this.style.color='#D4AF37'" onmouseout="this.style.color='#E2E8F0'">
                    🎟️ Pelacakan Tiket
                </a>
                <a href="#faq-section" style="font-size: 0.78125rem; font-weight: 800; color: #E2E8F0; padding: 0.4rem 0.875rem; border-radius: 9999px; transition: all 0.2s;" onmouseover="this.style.color='#D4AF37'" onmouseout="this.style.color='#E2E8F0'">
                    ❓ FAQ
                </a>
                <button @click="isProposalModalOpen = true" style="background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%); color: #04140B; font-weight: 900; font-size: 0.78125rem; padding: 0.45rem 1.125rem; border-radius: 9999px; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(197,155,39,0.3);">
                    ⚡ Ajukan Isu
                </button>

                @if(session('is_logged_in'))
                    <a href="{{ route('dashboard.index') }}" style="background: rgba(255,255,255,0.12); color: #FFF; font-size: 0.78125rem; font-weight: 700; padding: 0.45rem 1rem; border-radius: 9999px; border: 1px solid rgba(255,255,255,0.25);">
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" style="background: rgba(255,255,255,0.12); color: #FFF; font-size: 0.78125rem; font-weight: 700; padding: 0.45rem 1rem; border-radius: 9999px; border: 1px solid rgba(255,255,255,0.25);">
                        Masuk Admin
                    </a>
                @endif
            </nav>
        </header>
    </div>

    <!-- MAIN STAGE CONTAINER -->
    <main style="flex: 1; padding: 2rem 1.25rem 4rem; max-width: 1280px; margin: 0 auto; width: 100%;">
        
        <!-- SUCCESS TICKET ALERT BANNER -->
        @if(session('success_ticket'))
            <div style="background: linear-gradient(135deg, rgba(11,60,38,0.95) 0%, rgba(7,39,24,0.98) 100%); border: 1.5px solid #D4AF37; padding: 1.125rem 1.75rem; border-radius: 18px; margin-bottom: 2.25rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 12px 28px rgba(0,0,0,0.4); backdrop-filter: blur(12px);">
                <div>
                    <div style="font-size: 0.6875rem; font-weight: 900; color: #D4AF37; text-transform: uppercase; letter-spacing: 0.08em;">✅ USULAN HUKUM BERHASIL TERDAFTAR</div>
                    <div style="font-size: 1.15rem; font-weight: 900; color: #FFFFFF; margin-top: 2px;">
                        Nomor Tiket Anda: <span style="color: #D4AF37; background: rgba(0,0,0,0.5); padding: 0.15rem 0.65rem; border-radius: 6px; border: 1px solid #D4AF37;">{{ session('success_ticket.ticket_no') }}</span>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #D4AF37; font-size: 1.35rem; cursor: pointer;">✕</button>
            </div>
        @endif

        <!-- HERO STAGE SECTION -->
        <section style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 2.5rem; align-items: center; margin-bottom: 3.75rem; background: radial-gradient(100% 100% at 50% 0%, rgba(11, 60, 38, 0.55) 0%, rgba(4, 20, 11, 0.98) 100%); border: 1.5px solid rgba(197, 155, 39, 0.3); border-radius: 28px; padding: 3.25rem 3rem; position: relative; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.55);">
            <!-- Background Laser Grid Pattern -->
            <div style="position: absolute; inset: 0; background-image: radial-gradient(rgba(197, 155, 39, 0.08) 1px, transparent 1px); background-size: 32px 32px; opacity: 0.6; pointer-events: none;"></div>

            <!-- Left Command Content -->
            <div style="position: relative; z-index: 2;">
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.35rem 0.875rem; background: rgba(212, 175, 55, 0.12); border: 1px solid #D4AF37; border-radius: 9999px; font-size: 0.6875rem; font-weight: 800; color: #D4AF37; margin-bottom: 1.25rem;">
                    <span>🏛️ SENAT GAJAH MADA ADHYAKSA — RISET STRATEGIS</span>
                </div>

                <h1 style="font-size: clamp(2rem, 3.2vw, 3rem); font-weight: 900; line-height: 1.1; letter-spacing: -0.02em; color: #FFFFFF; margin-bottom: 1rem;">
                    Transformasi Riset Akademis <br />
                    <span style="background: linear-gradient(135deg, #FFFFFF 0%, #D4AF37 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Menjadi Instrumen Kebijakan
                    </span>
                </h1>

                <p style="font-size: 0.9375rem; color: #94A3B8; line-height: 1.65; margin-bottom: 1.85rem; max-width: 540px;">
                    Portal resmi formulasi kebijakan publik, audit metodologi 3-pintu, dan penerbitan Naskah Policy Brief PDF terintegrasi untuk akselerasi penegakan hukum modern.
                </p>

                <!-- LIVE SEARCH ENGINE OVERLAY -->
                <form action="{{ route('landing.index') }}" method="GET" style="display: flex; align-items: center; background: rgba(255,255,255,0.06); border: 1.5px solid rgba(212, 175, 55, 0.4); border-radius: 16px; padding: 0.4rem 0.4rem 0.4rem 1.125rem; box-shadow: 0 10px 25px rgba(0,0,0,0.3); margin-bottom: 1.75rem;">
                    <span style="font-size: 1rem; margin-right: 0.75rem;">🔍</span>
                    <input type="text" name="search" placeholder="Cari naskah akademis atau nomor registrasi PDF..." value="{{ request('search') }}" style="flex: 1; background: transparent; border: none; outline: none; color: #FFF; font-size: 0.875rem;" />
                    <button type="submit" style="background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%); color: #04140B; font-weight: 900; font-size: 0.8125rem; padding: 0.6875rem 1.35rem; border-radius: 12px; border: none; cursor: pointer;">
                        Cari PDF
                    </button>
                </form>

                <!-- STATS RIBBON PILLS -->
                <div style="display: flex; gap: 0.875rem; flex-wrap: wrap;">
                    <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); padding: 0.55rem 1rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700; color: #CBD5E1;">
                        <span style="color: #D4AF37; font-weight: 900;">Rp 4.2 Triliun</span> Pemulihan Aset
                    </div>
                    <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); padding: 0.55rem 1rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700; color: #CBD5E1;">
                        <span style="color: #38BDF8; font-weight: 900;">92%</span> Adopsi SOP
                    </div>
                    <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); padding: 0.55rem 1rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700; color: #CBD5E1;">
                        <span style="color: #4ADE80; font-weight: 900;">AES-256</span> Vault Encrypted
                    </div>
                </div>
            </div>

            <!-- Right Showcase Card -->
            <div style="position: relative; z-index: 2;">
                <div style="background: linear-gradient(145deg, rgba(11,60,38,0.85) 0%, rgba(4,20,11,0.95) 100%); border: 1.5px solid #D4AF37; border-radius: 24px; padding: 2rem; box-shadow: 0 25px 50px rgba(0,0,0,0.6); backdrop-filter: blur(12px);">
                    <template x-if="policyBriefs.length > 0">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.125rem;">
                                <span style="background: #D4AF37; color: #04140B; font-weight: 900; font-size: 0.6875rem; padding: 0.25rem 0.75rem; border-radius: 9999px; text-transform: uppercase; letter-spacing: 0.05em;" x-text="policyBriefs[0].tag || 'POLICY BRIEF UTAMA'">
                                </span>
                                <span style="font-size: 0.6875rem; color: #94A3B8; font-weight: 700;" x-text="policyBriefs[0].doc_no"></span>
                            </div>

                            <h3 style="font-size: 1.1875rem; font-weight: 800; color: #FFF; line-height: 1.35; margin-bottom: 0.875rem;" x-text="policyBriefs[0].title"></h3>

                            <p style="font-size: 0.8125rem; color: #CBD5E1; line-height: 1.6; margin-bottom: 1.5rem;" x-text="policyBriefs[0].summary"></p>

                            <div style="display: flex; gap: 0.5rem;">
                                <button class="btn btn-gold" style="flex: 1; padding: 0.75rem; font-size: 0.8125rem; background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%); color: #04140B; font-weight: 900; border-radius: 12px;" @click="selectedPdf = policyBriefs[0]">
                                    📄 Pratinjau PDF
                                </button>
                                <button class="btn btn-outline" style="padding: 0.75rem; font-size: 0.8125rem; color: #FFF; border-color: rgba(255,255,255,0.3); border-radius: 12px;" @click="selectedExecSummary = policyBriefs[0]">
                                    🖨️ Ringkasan 1-Halaman
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <!-- 4-FASE WORKFLOW SECTION -->
        <section style="margin-bottom: 4rem;">
            <div style="text-align: center; margin-bottom: 2.25rem;">
                <span style="font-size: 0.6875rem; font-weight: 900; color: #D4AF37; text-transform: uppercase; letter-spacing: 0.1em;">SISTEMATIKA DOKUMEN 4 FASE</span>
                <h2 style="font-size: 1.75rem; font-weight: 900; color: #FFF; margin-top: 0.2rem;">Alur Formulasi Isu Hingga Diterbitkan Sebagai Policy Brief PDF</h2>
            </div>

            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.125rem; position: relative;">
                <!-- Phase 1 -->
                <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(212, 175, 55, 0.3); border-radius: 20px; padding: 1.35rem; transition: all 0.3s;" onmouseover="this.style.borderColor='#D4AF37'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='rgba(212, 175, 55, 0.3)'; this.style.transform='none'">
                    <div style="width: 36px; height: 36px; border-radius: 12px; background: rgba(212, 175, 55, 0.15); border: 1.5px solid #D4AF37; color: #D4AF37; font-weight: 900; font-size: 0.875rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                        01
                    </div>
                    <h3 style="font-size: 1rem; font-weight: 800; color: #FFF; margin-bottom: 0.375rem;">1. Pengajuan Aspirasi</h3>
                    <p style="font-size: 0.78125rem; color: #94A3B8; line-height: 1.6;">Masyarakat mengunggah isu hukum strategis & menerima Tiket Registrasi Resmi.</p>
                </div>

                <!-- Phase 2 -->
                <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(56, 189, 248, 0.3); border-radius: 20px; padding: 1.35rem; transition: all 0.3s;" onmouseover="this.style.borderColor='#38BDF8'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='rgba(56, 189, 248, 0.3)'; this.style.transform='none'">
                    <div style="width: 36px; height: 36px; border-radius: 12px; background: rgba(56, 189, 248, 0.15); border: 1.5px solid #38BDF8; color: #38BDF8; font-weight: 900; font-size: 0.875rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                        02
                    </div>
                    <h3 style="font-size: 1rem; font-weight: 800; color: #FFF; margin-bottom: 0.375rem;">2. Formulasi Akademis</h3>
                    <p style="font-size: 0.78125rem; color: #94A3B8; line-height: 1.6;">Tim Riset 1-4 menyusun Naskah Akademis & merumuskan draft naskah kebijakan.</p>
                </div>

                <!-- Phase 3 -->
                <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(232, 121, 249, 0.3); border-radius: 20px; padding: 1.35rem; transition: all 0.3s;" onmouseover="this.style.borderColor='#E879F9'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='rgba(232, 121, 249, 0.3)'; this.style.transform='none'">
                    <div style="width: 36px; height: 36px; border-radius: 12px; background: rgba(232, 121, 249, 0.15); border: 1.5px solid #E879F9; color: #E879F9; font-weight: 900; font-size: 0.875rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                        03
                    </div>
                    <h3 style="font-size: 1rem; font-weight: 800; color: #FFF; margin-bottom: 0.375rem;">3. Review 3-Pintu</h3>
                    <p style="font-size: 0.78125rem; color: #94A3B8; line-height: 1.6;">Pengujian substansi, audit metodologi, & penerbitan Pengesahan QR Seal.</p>
                </div>

                <!-- Phase 4 -->
                <div style="background: rgba(255,255,255,0.03); border: 1.5px solid rgba(74, 222, 128, 0.3); border-radius: 20px; padding: 1.35rem; transition: all 0.3s;" onmouseover="this.style.borderColor='#4ADE80'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='rgba(74, 222, 128, 0.3)'; this.style.transform='none'">
                    <div style="width: 36px; height: 36px; border-radius: 12px; background: rgba(74, 222, 128, 0.15); border: 1.5px solid #4ADE80; color: #4ADE80; font-weight: 900; font-size: 0.875rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                        04
                    </div>
                    <h3 style="font-size: 1rem; font-weight: 800; color: #FFF; margin-bottom: 0.375rem;">4. Terbit PDF & Vault</h3>
                    <p style="font-size: 0.78125rem; color: #94A3B8; line-height: 1.6;">Policy Brief PDF diterbitkan terbuka & tersimpan di Vault Repositori.</p>
                </div>
            </div>
        </section>

        <!-- DUAL HUB ASYMMETRIC GRID -->
        <div style="display: grid; grid-template-columns: 0.85fr 1.15fr; gap: 2.5rem; align-items: flex-start; margin-bottom: 4.5rem;">
            
            <!-- LEFT HUB: TICKET LOOKUP & OFFICIAL RESPONSE CONSOLE -->
            <div id="lacak-tiket-hub" style="background: rgba(7, 39, 24, 0.65); border: 1.5px solid rgba(197, 155, 39, 0.3); border-radius: 24px; padding: 2rem; backdrop-filter: blur(12px); box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.35rem;">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(212, 175, 55, 0.15); border: 1.5px solid #D4AF37; color: #D4AF37; font-size: 1.25rem; display: flex; align-items: center; justify-content: center;">
                        🎟️
                    </div>
                    <div>
                        <h3 style="font-size: 1.1875rem; font-weight: 900; color: #FFF;">Konsol Pelacakan Tiket</h3>
                        <div style="font-size: 0.75rem; color: #94A3B8;">Pantau linimasa & baca Surat Balasan Tim Riset</div>
                    </div>
                </div>

                <form action="{{ route('landing.index') }}" method="GET" style="display: flex; gap: 0.625rem; margin-bottom: 1.5rem;">
                    <input type="text" name="ticket_no" placeholder="Contoh: USUL-2026-892" value="{{ request('ticket_no') }}" style="flex: 1; background: rgba(255,255,255,0.08); border: 1.5px solid rgba(255,255,255,0.2); border-radius: 12px; padding: 0.6875rem 1rem; color: #FFF; font-size: 0.875rem; outline: none;" />
                    <button type="submit" style="background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%); color: #04140B; font-weight: 900; padding: 0.6875rem 1.25rem; border-radius: 12px; border: none; cursor: pointer; font-size: 0.8125rem;">
                        Lacak
                    </button>
                </form>

                @if(isset($trackedTicket))
                    <div style="background: rgba(0,0,0,0.4); border: 1.5px solid #D4AF37; border-radius: 16px; padding: 1.35rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <span style="font-size: 0.75rem; font-weight: 900; color: #D4AF37;" x-text="'{{ $trackedTicket->ticket_no }}'"></span>
                            <span style="font-size: 0.6875rem; font-weight: 800; color: #4ADE80; background: rgba(74,222,128,0.15); padding: 0.2rem 0.5rem; border-radius: 4px; border: 1px solid rgba(74,222,128,0.3);">{{ $trackedTicket->status }}</span>
                        </div>
                        <div style="font-size: 0.9375rem; font-weight: 800; color: #FFF; margin-bottom: 0.5rem; line-height: 1.35;">{{ $trackedTicket->title }}</div>
                        <div style="font-size: 0.75rem; color: #CBD5E1; margin-bottom: 0.875rem;">Pengusul: <strong>{{ $trackedTicket->name }}</strong> ({{ $trackedTicket->institution ?? 'Umum' }})</div>

                        @if($trackedTicket->official_response)
                            <div style="background: rgba(212,175,55,0.12); border: 1px solid rgba(212,175,55,0.3); border-radius: 12px; padding: 1rem; margin-top: 1rem;">
                                <div style="font-size: 0.6875rem; font-weight: 900; color: #D4AF37; margin-bottom: 0.375rem;">💬 TANGGAPAN RESMI TIM RISET:</div>
                                <div style="font-size: 0.8125rem; color: #F1F5F9; line-height: 1.6; white-space: pre-line;">{{ $trackedTicket->official_response }}</div>
                            </div>
                        @endif
                    </div>
                @else
                    <div style="background: rgba(255,255,255,0.03); border: 1.5px dashed rgba(255,255,255,0.18); border-radius: 16px; padding: 1.75rem; text-align: center; color: #94A3B8; font-size: 0.78125rem;">
                        Masukkan Nomor Tiket Registrasi Resmi pada kolom di atas untuk melacak status.
                    </div>
                @endif
            </div>

            <!-- RIGHT HUB: CATALOG PDF POLICY PAPERS -->
            <div id="katalog-hub" style="display: flex; flex-direction: column; gap: 1.35rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <span style="font-size: 0.6875rem; font-weight: 900; color: #D4AF37; text-transform: uppercase; letter-spacing: 0.1em;">KATALOG REPOSITORI DIGITALLY SIGNED</span>
                        <h2 style="font-size: 1.5rem; font-weight: 900; color: #FFF; margin-top: 0.15rem;">Daftar Dokumen Policy Brief PDF</h2>
                    </div>
                </div>

                <!-- CATEGORY PILL FILTER BUTTONS -->
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <button @click="activeCategory = 'Semua'" style="font-size: 0.75rem; font-weight: 800; padding: 0.35rem 0.875rem; border-radius: 9999px; border: 1px solid #D4AF37; cursor: pointer; transition: all 0.2s;" :style="activeCategory === 'Semua' ? 'background: #D4AF37; color: #04140B;' : 'background: rgba(255,255,255,0.06); color: #FFF;'">
                        Semua Domain
                    </button>
                    @foreach($categories as $cat)
                        <button @click="activeCategory = '{{ $cat->name }}'" style="font-size: 0.75rem; font-weight: 800; padding: 0.35rem 0.875rem; border-radius: 9999px; border: 1px solid rgba(212,175,55,0.4); cursor: pointer; transition: all 0.2s;" :style="activeCategory === '{{ $cat->name }}' ? 'background: #D4AF37; color: #04140B;' : 'background: rgba(255,255,255,0.06); color: #FFF;'">
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>

                <!-- PDF Cards Grid (Dynamic Filtering) -->
                <div style="display: flex; flex-direction: column; gap: 1.125rem;">
                    @foreach($policyBriefs as $brief)
                        <div x-show="activeCategory === 'Semua' || activeCategory === '{{ $brief->category }}'" style="background: rgba(7, 39, 24, 0.55); border: 1.5px solid rgba(197, 155, 39, 0.3); border-radius: 20px; padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1.35rem; backdrop-filter: blur(8px); transition: all 0.3s;" onmouseover="this.style.borderColor='#D4AF37'; this.style.transform='translateX(4px)'" onmouseout="this.style.borderColor='rgba(197, 155, 39, 0.3)'; this.style.transform='none'">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.6875rem; font-weight: 800; color: #D4AF37; background: rgba(212,175,55,0.15); padding: 0.2rem 0.6rem; border-radius: 6px; border: 1px solid rgba(212,175,55,0.3);">
                                        {{ $brief->category }}
                                    </span>
                                    <span style="font-size: 0.6875rem; color: #94A3B8; font-weight: 700;">{{ $brief->doc_no }}</span>
                                </div>

                                <h3 style="font-size: 1.0625rem; font-weight: 800; color: #FFF; margin-bottom: 0.5rem; line-height: 1.35;">
                                    {{ $brief->title }}
                                </h3>

                                <p style="font-size: 0.78125rem; color: #CBD5E1; line-height: 1.6;">
                                    {{ $brief->summary }}
                                </p>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 0.5rem; flex-shrink: 0;">
                                <button style="background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%); color: #04140B; font-weight: 900; font-size: 0.78125rem; padding: 0.6875rem 1.125rem; border-radius: 12px; border: none; cursor: pointer;" @click="selectedPdf = {{ json_encode($brief) }}">
                                    📄 Pratinjau PDF
                                </button>
                                <button style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); color: #FFF; font-weight: 700; font-size: 0.71875rem; padding: 0.4rem 0.875rem; border-radius: 8px; cursor: pointer;" @click="selectedExecSummary = {{ json_encode($brief) }}">
                                    🖨️ Ringkasan 1-Halaman
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- FAQ & PRIVACY PROTECTION SECTION -->
        <section id="faq-section" style="background: rgba(7, 39, 24, 0.4); border: 1.5px solid rgba(197, 155, 39, 0.25); border-radius: 28px; padding: 3rem 2.5rem; margin-bottom: 3.5rem;">
            <div style="text-align: center; max-width: 720px; margin: 0 auto 2.5rem;">
                <span style="font-size: 0.6875rem; font-weight: 900; color: #D4AF37; text-transform: uppercase; letter-spacing: 0.1em;">PUSAT BANTUAN & FAQ</span>
                <h2 style="font-size: 1.75rem; font-weight: 900; color: #FFF; margin-top: 0.2rem;">Pertanyaan Umum & Jaminan Perlindungan Pengusul</h2>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 18px; padding: 1.5rem;">
                    <h3 style="font-size: 1rem; font-weight: 800; color: #D4AF37; margin-bottom: 0.5rem;">🔒 Apakah kerahasiaan identitas pengusul terjamin?</h3>
                    <p style="font-size: 0.8125rem; color: #CBD5E1; line-height: 1.65;">Ya. Seluruh data usulan publik dilindungi oleh sistem enkripsi AES-256 dan hanya diakses oleh Sekretariat Utama Senat Gajah Mada Adhyaksa.</p>
                </div>

                <div style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 18px; padding: 1.5rem;">
                    <h3 style="font-size: 1rem; font-weight: 800; color: #D4AF37; margin-bottom: 0.5rem;">⏱️ Berapa lama tahapan audit riset berlangsung?</h3>
                    <p style="font-size: 0.8125rem; color: #CBD5E1; line-height: 1.65;">Proses skrining awal memerlukan waktu 1x24 jam kerja, sedangkan penyusunan naskah akademis lengkap berlangsung dalam waktu 7 s.d. 14 hari kerja.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- PRINTABLE EXECUTIVE SUMMARY SHEET MODAL (1-PAGE OFFICIAL ONESHEET) -->
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

    <!-- PUBLIC PROPOSAL MODAL -->
    <div x-show="isProposalModalOpen" class="modal-overlay" style="display: none;" @click="isProposalModalOpen = false">
        <div class="modal-card" style="max-width: 620px; border-radius: 24px; background: #072718; color: #FFF; border: 2px solid #D4AF37; box-shadow: 0 25px 50px rgba(0,0,0,0.6);" @click.stop>
            <div style="padding: 1.35rem 1.75rem; border-bottom: 1.5px solid rgba(212,175,55,0.3); display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="font-size: 0.6875rem; font-weight: 900; color: #D4AF37; text-transform: uppercase;">FASE 1: PENGAJUAN ASPIRASI HUKUM</div>
                    <h3 style="font-size: 1.1rem; font-weight: 900; color: #FFFFFF;">Formulir Pengusulan Isu Hukum Publik</h3>
                </div>
                <button @click="isProposalModalOpen = false" style="background: none; border: none; color: #FFF; font-size: 1.35rem; cursor: pointer;">✕</button>
            </div>

            <form action="{{ route('landing.submit_proposal') }}" method="POST" enctype="multipart/form-data" style="padding: 1.75rem; display: flex; flex-direction: column; gap: 1.125rem;">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Nama Pengusul *</label>
                        <input type="text" name="name" required placeholder="Nama Lengkap" style="width: 100%; padding: 0.625rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #FFF;" />
                    </div>
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Institusi / Afiliasi</label>
                        <input type="text" name="institution" placeholder="Universitas / Lembaga" style="width: 100%; padding: 0.625rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #FFF;" />
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Kategori Domain Hukum *</label>
                        <select name="category" style="width: 100%; padding: 0.625rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: #072718; color: #FFF;">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Tingkat Urgensi Kebijakan</label>
                        <select name="urgency" style="width: 100%; padding: 0.625rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: #072718; color: #FFF;">
                            <option value="Kritis">Kritis (Urgensi Kebijakan Nasional)</option>
                            <option value="Tinggi">Tinggi (Sangat Mendesak)</option>
                            <option value="Normal">Normal (Penguatan Regulasi)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="font-size: 0.78125rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Judul Isu Strategis *</label>
                    <input type="text" name="title" required placeholder="Judul usulan isu..." style="width: 100%; padding: 0.625rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #FFF;" />
                </div>

                <div>
                    <label style="font-size: 0.78125rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.25rem;">Ringkasan Uraian Permasalahan *</label>
                    <textarea name="description" rows="3" required placeholder="Uraikan secara ringkas permasalahan hukum..." style="width: 100%; padding: 0.625rem; font-size: 0.8125rem; border-radius: 8px; border: 1.5px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #FFF;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                    <button type="button" class="btn btn-outline" style="color: #FFF; border-color: rgba(255,255,255,0.3); font-size: 0.8125rem;" @click="isProposalModalOpen = false">Batal</button>
                    <button type="submit" class="btn btn-gold" style="padding: 0.625rem 1.25rem; font-weight: 900; font-size: 0.8125rem;">📨 Kirim Usulan (Fase 1)</button>
                </div>
            </form>
        </div>
    </div>

    <!-- AUTHENTIC EMBEDDED PDF FILE VIEWER MODAL -->
    <div x-show="selectedPdf !== null" class="modal-overlay" style="display: none;" @click="selectedPdf = null">
        <div class="modal-card" style="max-width: 1140px; width: 95%; height: 90vh; border-radius: 20px; display: flex; flex-direction: column; overflow: hidden; background: #04140B; border: 2px solid #D4AF37;" @click.stop>
            <!-- TOP PDF TOOLBAR HEADER -->
            <div style="padding: 0.875rem 1.75rem; background: #072718; color: #FFFFFF; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #D4AF37;">
                <div style="display: flex; align-items: center; gap: 0.875rem;">
                    <span style="font-size: 1.25rem;">📄</span>
                    <div>
                        <div style="font-size: 0.6875rem; color: #D4AF37; font-weight: 900; text-transform: uppercase; letter-spacing: 0.08em;">EXECUTIVE POLICY BRIEF PDF — DIGITALLY SIGNED</div>
                        <div style="font-size: 1.05rem; font-weight: 800; color: #FFFFFF;" x-text="selectedPdf ? selectedPdf.doc_no : ''"></div>
                    </div>
                </div>
                <div style="display: flex; gap: 0.75rem; align-items: center;">
                    <a :href="selectedPdf ? (selectedPdf.file_path || '/documents/pb_01.pdf') : '#'" download class="btn btn-gold" style="padding: 0.4rem 1.125rem; font-size: 0.78125rem; font-weight: 900;">
                        📥 Unduh Berkas PDF
                    </a>
                    <button class="btn btn-outline" style="padding: 0.4rem 1.125rem; font-size: 0.78125rem; color: #FFF; border-color: rgba(255,255,255,0.3); background: rgba(255,255,255,0.1);" @click="selectedPdf = null">
                        Tutup PDF
                    </button>
                </div>
            </div>

            <!-- REAL EMBEDDED PDF VIEWER CANVAS -->
            <div style="flex: 1; background-color: #525659; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                <template x-if="selectedPdf">
                    <embed :src="selectedPdf.file_path || '/documents/pb_01.pdf'" type="application/pdf" width="100%" height="100%" style="border: none;" />
                </template>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer style="border-top: 1px solid rgba(212, 175, 55, 0.2); padding: 2.25rem 1.25rem; text-align: center; color: #94A3B8; font-size: 0.78125rem; background: #020C07;">
        <div style="max-width: 1160px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div style="font-weight: 900; color: #D4AF37; font-size: 0.9375rem;">SENAT GAJAH MADA ADHYAKSA — LITBANG 2026</div>
            <div>© 2026 Senat Gajah Mada Adhyaksa. All Rights Reserved.</div>
        </div>
    </footer>
</div>
@endsection
