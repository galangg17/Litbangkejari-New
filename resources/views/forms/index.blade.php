@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; background: #F8FAFC; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif;">
    <!-- HEADER -->
    <header style="background: linear-gradient(135deg, #072718 0%, #14452F 100%); border-bottom: 2px solid #D4AF37; padding: 1.5rem 1rem; color: #FFF;">
        <div style="max-width: 1000px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <a href="{{ route('landing.index') }}">
                    <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo" style="height: 50px; width: auto;" />
                </a>
                <div>
                    <span style="font-size: 0.72rem; color: #D4AF37; font-weight: 900; text-transform: uppercase; letter-spacing: 0.08em;">LITBANG GAJAH MADA ADHYAKSA</span>
                    <h1 style="font-size: 1.25rem; font-weight: 900; color: #FFF; margin: 0; line-height: 1.2;">Portal Formulir, Survei & Kegiatan Terbuka</h1>
                </div>
            </div>
            <div>
                <a href="{{ route('landing.index') }}" style="background: rgba(255,255,255,0.12); border: 1.5px solid rgba(212,175,55,0.5); color: #FFF; font-size: 0.8125rem; font-weight: 800; padding: 0.5rem 1rem; border-radius: 9999px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                    🏠 Kembali ke Beranda
                </a>
            </div>
        </div>
    </header>

    <!-- CONTENT -->
    <main style="max-width: 1000px; margin: 2rem auto; padding: 0 1rem 4rem;">
        <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 1.75rem; margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: center; gap: 0.65rem; margin-bottom: 0.5rem;">
                <span style="font-size: 1.4rem;">📋</span>
                <h2 style="font-size: 1.35rem; font-weight: 900; color: #072718; margin: 0;">Daftar Formulir & Kuesioner Resmi</h2>
            </div>
            <p style="font-size: 0.875rem; color: #64748B; margin: 0; line-height: 1.6;">
                Silakan pilih formulir atau kuesioner yang sedang aktif untuk memberikan tanggapan, data evaluasi, atau pendaftaran kegiatan di lingkungan Kejaksaan RI.
            </p>
        </div>

        @if($forms->isEmpty())
            <div style="text-align: center; padding: 4rem 1.5rem; background: #FFFFFF; border: 2px dashed #CBD5E1; border-radius: 20px;">
                <div style="font-size: 3rem; margin-bottom: 0.75rem;">📭</div>
                <h3 style="font-size: 1.15rem; font-weight: 900; color: #0F172A; margin: 0 0 0.5rem;">Belum Ada Formulir yang Dibuka</h3>
                <p style="font-size: 0.84375rem; color: #64748B; margin: 0;">Saat ini belum ada kuesioner atau formulir kegiatan aktif. Silakan cek kembali secara berkala.</p>
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.25rem;">
                @foreach($forms as $form)
                    <div style="background: #FFFFFF; border: 1.5px solid {{ $form->isOpen() ? '#86EFAC' : '#E2E8F0' }}; border-radius: 18px; padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 16px rgba(0,0,0,0.03); position: relative; overflow: hidden;">
                        @if($form->isOpen())
                            <div style="position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, #10B981, #059669);"></div>
                        @else
                            <div style="position: absolute; top: 0; left: 0; right: 0; height: 5px; background: #94A3B8;"></div>
                        @endif

                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.85rem;">
                                @if($form->isOpen())
                                    <span style="background: #DCFCE7; color: #15803D; font-size: 0.71875rem; font-weight: 900; padding: 0.25rem 0.65rem; border-radius: 9999px; border: 1px solid #86EFAC; display: inline-flex; align-items: center; gap: 0.35rem;">
                                        🟢 SEDANG BUKA
                                    </span>
                                @else
                                    <span style="background: #F1F5F9; color: #64748B; font-size: 0.71875rem; font-weight: 900; padding: 0.25rem 0.65rem; border-radius: 9999px; border: 1px solid #CBD5E1;">
                                        🔴 DITUTUP
                                    </span>
                                @endif

                                <span style="font-size: 0.71875rem; color: #64748B; font-weight: 700;">
                                    👥 {{ $form->responses_count }} Respon
                                </span>
                            </div>

                            <h3 style="font-size: 1.05rem; font-weight: 900; color: #072718; margin: 0 0 0.5rem; line-height: 1.35;">
                                {{ $form->title }}
                            </h3>

                            <p style="font-size: 0.8125rem; color: #475569; margin: 0 0 1.25rem; line-height: 1.55;">
                                {{ Str::limit($form->description ?? 'Formulir survei / kuesioner resmi Litbang Gajah Mada Adhyaksa.', 120) }}
                            </p>
                        </div>

                        <div>
                            @if($form->deadline_at)
                                <div style="font-size: 0.71875rem; color: #B45309; background: #FEF3C7; padding: 0.35rem 0.65rem; border-radius: 8px; margin-bottom: 1rem; font-weight: 700;">
                                    ⏳ Batas: {{ $form->deadline_at->format('d M Y, H:i') }} WIB
                                </div>
                            @endif

                            @if($form->isOpen())
                                <a href="{{ route('forms.show', $form->slug) }}" style="display: block; text-align: center; background: linear-gradient(135deg, #072718 0%, #16A34A 100%); color: #FFF; font-weight: 900; font-size: 0.84375rem; padding: 0.75rem 1rem; border-radius: 12px; text-decoration: none; box-shadow: 0 4px 14px rgba(7,39,24,0.25);">
                                    📝 Buka & Isi Formulir
                                </a>
                            @else
                                <button disabled style="width: 100%; text-align: center; background: #E2E8F0; color: #94A3B8; font-weight: 800; font-size: 0.84375rem; padding: 0.75rem 1rem; border-radius: 12px; border: none; cursor: not-allowed;">
                                    Penerimaan Ditutup
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
</div>
@endsection
