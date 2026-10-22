@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; background: #F1F5F9; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 2rem 1rem;">

    <div style="background: #FFFFFF; border-radius: 24px; max-width: 620px; width: 100%; border: 1.5px solid #E2E8F0; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; text-align: center;">
        
        <!-- Top Banner Bar -->
        <div style="height: 10px; background: linear-gradient(90deg, #072718 0%, #D4AF37 50%, #16A34A 100%);"></div>

        <div style="padding: 3rem 2.25rem 2.5rem;">
            <div style="width: 72px; height: 72px; border-radius: 50%; background: #DCFCE7; border: 2px solid #86EFAC; color: #16A34A; font-size: 2.25rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 8px 20px rgba(22,163,74,0.15);">
                ✓
            </div>

            <span style="font-size: 0.72rem; color: #D4AF37; font-weight: 900; letter-spacing: 0.08em; text-transform: uppercase;">
                LITBANG GAJAH MADA ADHYAKSA
            </span>

            <h1 style="font-size: 1.65rem; font-weight: 900; color: #072718; margin: 0.35rem 0 0.85rem; line-height: 1.25;">
                {{ $form->title }}
            </h1>

            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 1.25rem; margin-bottom: 2rem;">
                <p style="font-size: 0.9375rem; color: #1E293B; line-height: 1.65; margin: 0; font-weight: 600;">
                    {{ $form->success_message ?? 'Tanggapan Anda telah berhasil disimpan.' }}
                </p>
            </div>

            <div style="display: flex; justify-content: center; gap: 0.75rem; flex-wrap: wrap;">
                @if($form->allow_multiple_responses && $form->isOpen())
                    <a href="{{ route('forms.show', $form->slug) }}" style="background: #F1F5F9; border: 1.5px solid #CBD5E1; color: #0F172A; font-size: 0.84375rem; font-weight: 800; padding: 0.65rem 1.25rem; border-radius: 10px; text-decoration: none;">
                        📝 Kirim Tanggapan Lain
                    </a>
                @endif

                <a href="{{ route('forms.index') }}" style="background: #072718; color: #FFF; font-size: 0.84375rem; font-weight: 900; padding: 0.65rem 1.35rem; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 12px rgba(7,39,24,0.25);">
                    📋 Lihat Formulir Lain
                </a>

                <a href="{{ route('landing.index') }}" style="background: transparent; color: #64748B; font-size: 0.84375rem; font-weight: 800; padding: 0.65rem 1.15rem; text-decoration: none;">
                    Beranda Utama
                </a>
            </div>
        </div>

        <div style="background: #F8FAFC; border-top: 1px solid #F1F5F9; padding: 1rem; font-size: 0.75rem; color: #94A3B8;">
            Kejaksaan Republik Indonesia • Sistem Manajemen Pengetahuan Terpadu
        </div>
    </div>

</div>
@endsection
