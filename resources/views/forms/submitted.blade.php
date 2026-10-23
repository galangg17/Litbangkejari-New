@extends('layouts.app')

@section('content')
<style>
    @media print {
        .no-print { display: none !important; }
        body { background: #FFF !important; padding: 0 !important; }
        .receipt-card { box-shadow: none !important; border: 1.5px solid #000 !important; }
    }
</style>

<div style="min-height: 100vh; background: #F8FAFC; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 2.5rem 1.25rem;">

    <div class="receipt-card" style="background: #FFFFFF; border-radius: 20px; max-width: 620px; width: 100%; border: 1px solid #E2E8F0; box-shadow: 0 10px 30px rgba(6, 46, 29, 0.08); overflow: hidden; text-align: center;">
        
        <!-- Top Executive Accent Strip -->
        <div style="height: 6px; background: linear-gradient(90deg, #062E1D 0%, #C59B27 50%, #064E3B 100%);"></div>

        <div style="padding: 2.5rem 2rem 2.25rem;">
            <!-- SUCCESS BADGE -->
            <div style="width: 64px; height: 64px; border-radius: 50%; background: #F0FDF4; border: 2px solid #86EFAC; color: #166534; font-size: 2rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; box-shadow: 0 6px 16px rgba(22,163,74,0.12);">
                ✓
            </div>

            <div style="display: inline-flex; align-items: center; gap: 0.35rem; background: rgba(197, 155, 39, 0.12); border: 1px solid rgba(197, 155, 39, 0.4); padding: 0.2rem 0.65rem; border-radius: 9999px; font-size: 0.6875rem; font-weight: 800; color: #062E1D; letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 0.5rem;">
                🏛️ LITBANG GAJAH MADA ADHYAKSA
            </div>

            <h1 style="font-size: 1.35rem; font-weight: 800; color: #062E1D; margin: 0 0 0.5rem; line-height: 1.35;">
                Terima kasih, tanggapan Anda untuk Diklat PPPJ 2026 telah terverifikasi aman
            </h1>
            <p style="font-size: 0.84375rem; color: #64748B; margin: 0 0 1.5rem; line-height: 1.5;">
                {{ $form->success_message ?? 'Tanggapan Anda telah berhasil dihimpun ke dalam sistem basis data resmi Litbang.' }}
            </p>

            <!-- BUKTI TANDA PENERIMAAN / SUBMISSION RECEIPT BOX -->
            <div style="background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 14px; padding: 1.25rem 1.5rem; margin-bottom: 1.75rem; text-align: left;">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #E2E8F0; padding-bottom: 0.65rem; margin-bottom: 0.85rem;">
                    <span style="font-size: 0.72rem; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">
                        TANDA BUKTI PENGISIAN
                    </span>
                    <span style="background: #DCFCE7; color: #166534; font-size: 0.6875rem; font-weight: 800; padding: 0.15rem 0.5rem; border-radius: 4px;">
                        ● TERVERIFIKASI
                    </span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.65rem; font-size: 0.84375rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #64748B; font-weight: 600;">Nomor Tiket Respon:</span>
                        <strong style="color: #062E1D; font-family: monospace; font-size: 0.9375rem;">
                            #RES-{{ date('Y') }}-{{ str_pad($response->id ?? rand(100, 999), 5, '0', STR_PAD_LEFT) }}
                        </strong>
                    </div>

                    @if(!empty($response->respondent_name) && $response->respondent_name !== 'Anonim')
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #64748B; font-weight: 600;">Nama Peserta:</span>
                            <strong style="color: #0F172A;">{{ $response->respondent_name }}</strong>
                        </div>
                    @endif

                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #64748B; font-weight: 600;">Instrumen Evaluasi:</span>
                        <span style="color: #0F172A; font-weight: 700; text-align: right; max-width: 320px;">{{ $form->title }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #64748B; font-weight: 600;">Waktu Tercatat:</span>
                        <span style="color: #0F172A; font-weight: 700;">
                            {{ $response ? $response->created_at->format('d F Y, H:i') : date('d F Y, H:i') }} WIB
                        </span>
                    </div>
                </div>

                <div style="margin-top: 0.85rem; padding-top: 0.65rem; border-top: 1px dashed #CBD5E1; font-size: 0.75rem; color: #64748B; line-height: 1.45;">
                    💡 <em>Anda dapat menyimpan atau menangkap layar (screenshot) tanda bukti pengisian ini sebagai bukti keikutsertaan evaluasi kurikulum.</em>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="no-print" style="display: flex; justify-content: center; gap: 0.65rem; flex-wrap: wrap;">
                <button type="button" onclick="window.print()" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; color: #0F172A; font-size: 0.8125rem; font-weight: 800; padding: 0.65rem 1.15rem; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem;">
                    <span>🖨️</span>
                    <span>Cetak / Simpan Bukti</span>
                </button>

                @if($form->allow_multiple_responses && $form->isOpen())
                    <a href="{{ route('forms.show', $form->slug) }}" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; color: #0F172A; font-size: 0.8125rem; font-weight: 750; padding: 0.65rem 1.15rem; border-radius: 8px; text-decoration: none;">
                        📝 Isi Tanggapan Lain
                    </a>
                @endif

                <a href="{{ route('forms.index') }}" style="background: #062E1D; color: #DFB743; font-size: 0.8125rem; font-weight: 800; padding: 0.65rem 1.35rem; border-radius: 8px; text-decoration: none; border: 1px solid rgba(223,183,67,0.4); display: inline-flex; align-items: center; gap: 0.35rem;">
                    <span>📋</span>
                    <span>Daftar Formulir</span>
                </a>
            </div>
        </div>

        <div style="background: #F8FAFC; border-top: 1px solid #F1F5F9; padding: 0.85rem 1.5rem; font-size: 0.72rem; color: #94A3B8; font-weight: 600;">
            🛡️ Sistem Manajemen Kajian & Evaluasi Diklat • Litbang Gajah Mada Adhyaksa
        </div>
    </div>

</div>
@endsection
