@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: radial-gradient(120% 120% at 20% 20%, #072718 0%, #04180E 60%, #020C07 100%); color: #FFFFFF; font-family: 'Plus Jakarta Sans', sans-serif; padding: 2rem; position: relative; overflow: hidden;">

    <!-- Glowing Background Graphic Orbs -->
    <div style="position: absolute; top: -120px; left: -120px; width: 600px; height: 600px; border-radius: 50%; background: radial-gradient(circle, rgba(197, 155, 39, 0.18) 0%, rgba(0,0,0,0) 70%); pointer-events: none;"></div>
    <div style="position: absolute; bottom: -100px; right: -100px; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(11, 60, 38, 0.4) 0%, rgba(0,0,0,0) 70%); pointer-events: none;"></div>

    <!-- MAIN SPLIT LOGIN CONTAINER (MATCHING USER REFERENCE LAYOUT) -->
    <div style="width: 100%; max-width: 1240px; display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 4rem; align-items: center; position: relative; z-index: 2;">
        
        <!-- LEFT SIDE: BRAND ARTWORK & INSTITUTIONAL DESCRIPTION -->
        <div style="padding-right: 1.5rem;">
            <!-- Official Emblem Crest -->
            <div style="display: flex; align-items: center; gap: 1.25rem; margin-bottom: 2.5rem;">
                <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo Kejaksaan Senat Gajah Mada Adhyaksa" style="height: 80px; width: auto; filter: drop-shadow(0 10px 20px rgba(197,155,39,0.3));" />
                <div>
                    <div style="font-family: var(--font-heading); font-weight: 900; font-size: 1.85rem; color: #FFFFFF; line-height: 1.1; letter-spacing: -0.02em;">
                        Litbang Gajah Mada Adhyaksa™
                    </div>
                    <div style="font-size: 0.875rem; color: #D4AF37; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; margin-top: 4px;">
                        Portal Penelitian dan Pengembangan
                    </div>
                </div>
            </div>

            <!-- Main Heading & Description Text -->
            <h1 style="font-size: clamp(2rem, 3.2vw, 2.75rem); font-weight: 900; line-height: 1.2; color: #FFFFFF; margin-bottom: 1.5rem; letter-spacing: -0.02em;">
                Portal Penelitian dan <br />
                <span style="color: #D4AF37; text-shadow: 0 4px 15px rgba(212, 175, 55, 0.25);">
                    Pengembangan
                </span>
            </h1>

            <p style="font-size: 1.0625rem; color: #CBD5E1; line-height: 1.75; margin-bottom: 2.75rem; max-width: 540px;">
                Anda akan mengakses pusat kontrol eksekutif LITBANG Senat Adhyaksa untuk pengisian riset, audit metodologi 3-pintu, dan pengesahan digital dokumen resmi.
            </p>

            <!-- Bottom Action Pills Row -->
            <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                <a href="{{ route('landing.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border-radius: 9999px; border: 1.5px solid rgba(212, 175, 55, 0.4); background: rgba(255, 255, 255, 0.06); color: #FFFFFF; font-weight: 700; font-size: 0.875rem; backdrop-filter: blur(8px); transition: all 0.2s;" onmouseover="this.style.borderColor='#D4AF37'; this.style.color='#D4AF37'" onmouseout="this.style.borderColor='rgba(212, 175, 55, 0.4)'; this.style.color='#FFFFFF'">
                    🏠 Beranda Portal Publik
                </a>
                <span style="font-size: 0.875rem; color: #64748B; font-weight: 600;">• Akses Terverifikasi Admin</span>
            </div>
        </div>

        <!-- RIGHT SIDE: FLOATING GLASSMORPHIC FORM CARD -->
        <div>
            <div style="background: rgba(7, 39, 24, 0.65); border: 2px solid rgba(197, 155, 39, 0.4); border-radius: 28px; padding: 2.75rem 2.5rem; backdrop-filter: blur(24px); box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5); position: relative;" x-data="{ showPass: false }">
                
                <!-- Card Header -->
                <div style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; font-weight: 900; color: #FFFFFF; margin-bottom: 0.375rem; letter-spacing: -0.02em;">
                        Log In to LITBANG™
                    </h2>
                    <p style="font-size: 0.875rem; color: #94A3B8;">
                        Masukkan kredensial akun Sekretariat Tim Riset
                    </p>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.35rem;">
                    @csrf

                    <!-- Email / Username Field -->
                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.5rem;">Email atau Username</label>
                        <div style="position: relative; display: flex; align-items: center;">
                            <input type="text" name="email" value="admin@mada-adhyaksa.go.id" required style="width: 100%; padding: 0.875rem 2.75rem 0.875rem 1.125rem; border-radius: 12px; border: 1.5px solid rgba(255, 255, 255, 0.2); background: rgba(255, 255, 255, 0.08); color: #FFFFFF; font-size: 0.9375rem; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#D4AF37'; this.style.background='rgba(255, 255, 255, 0.12)';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.2)'; this.style.background='rgba(255, 255, 255, 0.08)';" />
                            <span style="position: absolute; right: 1rem; color: #94A3B8; font-size: 1.125rem; pointer-events: none;">👤</span>
                        </div>
                    </div>

                    <!-- Password Field with Interactive Eye Toggle -->
                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700; color: #CBD5E1; display: block; margin-bottom: 0.5rem;">Password</label>
                        <div style="position: relative; display: flex; align-items: center;">
                            <input :type="showPass ? 'text' : 'password'" name="password" value="secret123" required style="width: 100%; padding: 0.875rem 2.75rem 0.875rem 1.125rem; border-radius: 12px; border: 1.5px solid rgba(255, 255, 255, 0.2); background: rgba(255, 255, 255, 0.08); color: #FFFFFF; font-size: 0.9375rem; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#D4AF37'; this.style.background='rgba(255, 255, 255, 0.12)';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.2)'; this.style.background='rgba(255, 255, 255, 0.08)';" />
                            <button type="button" @click="showPass = !showPass" style="position: absolute; right: 0.75rem; background: none; border: none; color: #D4AF37; font-size: 1.125rem; cursor: pointer; padding: 0.25rem 0.5rem; display: flex; align-items: center;" title="Tampilkan / Sembunyikan Password">
                                <span x-text="showPass ? '🙈' : '👁️'"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Remember & Forgotten Row -->
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8125rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; color: #CBD5E1; cursor: pointer;">
                            <input type="checkbox" name="remember" checked style="width: 16px; height: 16px; accent-color: #D4AF37; cursor: pointer;" />
                            <span>Ingat Sesi Saya</span>
                        </label>
                        <a href="#" style="color: #D4AF37; font-weight: 700; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Primary Submit Button -->
                    <button type="submit" style="background: linear-gradient(135deg, #D4AF37 0%, #C59B27 100%); color: #04180E; font-weight: 900; font-size: 1rem; padding: 0.95rem; border-radius: 12px; border: none; cursor: pointer; box-shadow: 0 6px 20px rgba(197, 155, 39, 0.35); transition: all 0.2s; margin-top: 0.35rem;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                        Log In Ke Portal →
                    </button>

                    <!-- KEJAKSAAN RI INTERNAL SECURITY BADGE CARD -->
                    <div style="margin-top: 0.75rem; background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(52, 211, 153, 0.35); border-radius: 12px; padding: 0.75rem 1rem; display: flex; align-items: center; gap: 0.75rem;">
                        <span style="font-size: 1.25rem;">🛡️</span>
                        <div>
                            <div style="font-size: 0.71875rem; font-weight: 900; color: #34D399; letter-spacing: 0.04em;">ENKRIPSI KEAMANAN TERVERIFIKASI</div>
                            <div style="font-size: 0.6875rem; color: #94A3B8; margin-top: 1px;">Sistem Server Terenkripsi SSL 256-bit Kejaksaan RI</div>
                        </div>
                    </div>

                    <!-- Secondary Return Button -->
                    <a href="{{ route('landing.index') }}" style="display: flex; align-items: center; justify-content: center; width: 100%; padding: 0.75rem; border-radius: 12px; border: 1.5px solid rgba(255, 255, 255, 0.15); background: rgba(255, 255, 255, 0.05); color: #CBD5E1; font-weight: 700; font-size: 0.8125rem; text-decoration: none; text-align: center; transition: all 0.2s; margin-top: 0.25rem;" onmouseover="this.style.borderColor='#D4AF37'; this.style.color='#D4AF37'" onmouseout="this.style.borderColor='rgba(255, 255, 255, 0.15)'; this.style.color='#CBD5E1'">
                        ⬅️ Kembali ke Beranda Portal
                    </a>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
