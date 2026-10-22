@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; background: #F8FAFC; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif;" x-data="{ responseTab: 'summary' }">

    <!-- TOP HEADER -->
    <header style="background: #072718; border-bottom: 2px solid #D4AF37; padding: 1rem 1.5rem; color: #FFF; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 0.85rem;">
            <a href="{{ route('dashboard.index', ['tab' => 'custom_forms']) }}" style="color: #D4AF37; text-decoration: none; font-size: 1.25rem;">←</a>
            <div>
                <span style="font-size: 0.6875rem; color: #D4AF37; font-weight: 800; text-transform: uppercase;">PUSAT TANGGAPAN & RESPOSEN</span>
                <h1 style="font-size: 1.15rem; font-weight: 900; margin: 0; color: #FFF;">{{ $form->title }}</h1>
            </div>
        </div>

        <!-- EXPORT BUTTONS ROW -->
        <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
            <a href="{{ route('dashboard.forms.builder', $form->id) }}" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.3); color: #FFF; font-size: 0.75rem; font-weight: 800; padding: 0.45rem 0.85rem; border-radius: 8px; text-decoration: none;">
                ✏️ Edit Pertanyaan Form
            </a>
            <a href="{{ route('dashboard.forms.export.csv', $form->id) }}" style="background: #16A34A; color: #FFF; font-size: 0.75rem; font-weight: 900; padding: 0.45rem 0.95rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; box-shadow: 0 2px 8px rgba(22,163,74,0.3);">
                📥 Unduh Excel (CSV)
            </a>
            <a href="{{ route('dashboard.forms.export.pdf.summary', $form->id) }}" target="_blank" style="background: #0284C7; color: #FFF; font-size: 0.75rem; font-weight: 900; padding: 0.45rem 0.95rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; box-shadow: 0 2px 8px rgba(2,132,199,0.3);">
                🖨️ Cetak PDF Kesimpulan
            </a>
        </div>
    </header>

    <!-- MAIN RESPONSES CONTAINER -->
    <main style="max-width: 1000px; margin: 1.5rem auto 4rem; padding: 0 1rem;">

        <!-- STATS & SUBTAB NAVIGATOR (GOOGLE FORM STYLE) -->
        <div style="background: #FFFFFF; border: 1.5px solid #CBD5E1; border-radius: 20px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; border-bottom: 1.5px solid #F1F5F9; padding-bottom: 1.25rem;">
                <div>
                    <div style="font-size: 0.75rem; font-weight: 800; color: #64748B; text-transform: uppercase;">TOTAL TANGGAPAN MASUK</div>
                    <div style="font-size: 2.25rem; font-weight: 900; color: #072718; line-height: 1.1; margin-top: 0.25rem;">
                        {{ $responses->count() }} <span style="font-size: 1rem; color: #64748B; font-weight: 700;">Responden</span>
                    </div>
                </div>

                <!-- SUB-TABS: RINGKASAN VS PERORANGAN -->
                <div style="display: flex; gap: 0.4rem; background: #F1F5F9; padding: 0.35rem; border-radius: 12px; border: 1.5px solid #CBD5E1;">
                    <button type="button" 
                            @click="responseTab = 'summary'" 
                            :style="responseTab === 'summary' ? 'background: #072718; color: #D4AF37; font-weight: 900;' : 'background: transparent; color: #475569; font-weight: 700;'"
                            style="padding: 0.55rem 1.25rem; font-size: 0.8125rem; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s;">
                        📊 Ringkasan / Kesimpulan
                    </button>
                    <button type="button" 
                            @click="responseTab = 'individual'" 
                            :style="responseTab === 'individual' ? 'background: #072718; color: #D4AF37; font-weight: 900;' : 'background: transparent; color: #475569; font-weight: 700;'"
                            style="padding: 0.55rem 1.25rem; font-size: 0.8125rem; border-radius: 8px; border: none; cursor: pointer; transition: all 0.2s;">
                        👤 Data Perorangan (Individual)
                    </button>
                </div>
            </div>
        </div>

        @if($responses->isEmpty())
            <div style="background: #FFFFFF; border: 2px dashed #CBD5E1; border-radius: 20px; padding: 4rem 1.5rem; text-align: center; color: #94A3B8;">
                <div style="font-size: 3rem; margin-bottom: 0.5rem;">📊</div>
                <h3 style="font-size: 1.15rem; font-weight: 900; color: #475569; margin: 0 0 0.5rem;">Belum Ada Tanggapan Masuk</h3>
                <p style="font-size: 0.84375rem; margin: 0;">Bagikan tautan formulir ke peserta atau responden untuk mulai mengumpulkan data.</p>
                <div style="margin-top: 1.25rem;">
                    <a href="{{ route('forms.show', $form->slug) }}" target="_blank" style="background: #072718; color: #D4AF37; font-size: 0.8125rem; font-weight: 900; padding: 0.6rem 1.25rem; border-radius: 10px; text-decoration: none;">
                        Buka Formulir Publik →
                    </a>
                </div>
            </div>
        @else

            <!-- ================= TAB 1: RINGKASAN & KESIMPULAN ================= -->
            <div x-show="responseTab === 'summary'" style="display: flex; flex-direction: column; gap: 1.25rem;">
                @foreach($summary as $fn => $data)
                    <div style="background: #FFFFFF; border: 1.5px solid #CBD5E1; border-radius: 18px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                        <div style="font-size: 0.9375rem; font-weight: 900; color: #072718; margin-bottom: 1rem; border-bottom: 1px solid #F1F5F9; padding-bottom: 0.5rem;">
                            {{ $data['label'] }}
                        </div>

                        <!-- STATISTIK OPSI PILIHAN -->
                        @if(isset($data['counts']))
                            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                                @php
                                    $totalVotes = array_sum($data['counts']);
                                @endphp
                                @foreach($data['counts'] as $optName => $count)
                                    @php
                                        $percent = $totalVotes > 0 ? round(($count / $totalVotes) * 100, 1) : 0;
                                    @endphp
                                    <div>
                                        <div style="display: flex; justify-content: space-between; font-size: 0.8125rem; font-weight: 800; color: #1E293B; margin-bottom: 0.25rem;">
                                            <span>{{ $optName }}</span>
                                            <span>{{ $count }} ({{ $percent }}%)</span>
                                        </div>
                                        <div style="width: 100%; height: 10px; background: #F1F5F9; border-radius: 9999px; overflow: hidden;">
                                            <div style="width: {{ $percent }}%; height: 100%; background: linear-gradient(90deg, #10B981, #047857); border-radius: 9999px;"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if(!empty($data['reasons']))
                                <div style="margin-top: 1rem; border-top: 1px dashed #CBD5E1; padding-top: 0.85rem;">
                                    <div style="font-size: 0.75rem; font-weight: 800; color: #166534; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.35rem;">
                                        <span>💬</span>
                                        <span>Alasan & Penjelasan Responden ({{ count($data['reasons']) }} Catatan):</span>
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 0.45rem; max-height: 220px; overflow-y: auto;">
                                        @foreach($data['reasons'] as $rItem)
                                            <div style="background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 8px; padding: 0.55rem 0.75rem; font-size: 0.78125rem;">
                                                <div style="font-weight: 800; color: #15803D; margin-bottom: 0.2rem;">
                                                    {{ $rItem['respondent'] }} &bull; Opsi: <span style="color: #072718;">{{ $rItem['selected'] }}</span>
                                                </div>
                                                <div style="color: #334155; line-height: 1.45;">
                                                    "{{ $rItem['reason'] }}"
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        <!-- DAFTAR CUPLIKAN JAWABAN TEKS -->
                        @elseif(isset($data['samples']))
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; max-height: 250px; overflow-y: auto;">
                                @forelse($data['samples'] as $sampleText)
                                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 0.65rem 0.85rem; border-radius: 8px; font-size: 0.8125rem; color: #334155;">
                                        {{ $sampleText }}
                                    </div>
                                @empty
                                    <div style="font-size: 0.78125rem; color: #94A3B8;">Tidak ada isian teks.</div>
                                @endforelse
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- ================= TAB 2: DATA PERORANGAN (INDIVIDUAL) ================= -->
            <div x-show="responseTab === 'individual'" style="display: none;">
                @if($currentResponse)
                    <div style="background: #FFFFFF; border: 1.5px solid #CBD5E1; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                        
                        <!-- Paginator Responden (Google Form Style: 1 of N) -->
                        <div style="background: #F8FAFC; border-bottom: 1.5px solid #E2E8F0; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <a href="{{ route('dashboard.forms.responses', ['id' => $form->id, 'index' => $currentIndex - 1]) }}" 
                                   style="{{ $currentIndex > 0 ? '' : 'pointer-events: none; opacity: 0.4;' }} background: #FFF; border: 1.5px solid #CBD5E1; color: #0F172A; font-weight: 800; font-size: 0.8125rem; padding: 0.4rem 0.75rem; border-radius: 8px; text-decoration: none;">
                                    ◀ Sebelumnya
                                </a>

                                <span style="font-size: 0.84375rem; font-weight: 800; color: #072718;">
                                    Responden {{ $currentIndex + 1 }} dari {{ $responses->count() }}
                                </span>

                                <a href="{{ route('dashboard.forms.responses', ['id' => $form->id, 'index' => $currentIndex + 1]) }}" 
                                   style="{{ $currentIndex < $responses->count() - 1 ? '' : 'pointer-events: none; opacity: 0.4;' }} background: #FFF; border: 1.5px solid #CBD5E1; color: #0F172A; font-weight: 800; font-size: 0.8125rem; padding: 0.4rem 0.75rem; border-radius: 8px; text-decoration: none;">
                                    Berikutnya ▶
                                </a>
                            </div>

                            <div>
                                <a href="{{ route('dashboard.forms.export.pdf.individual', ['id' => $form->id, 'responseId' => $currentResponse->id]) }}" target="_blank" style="background: #0284C7; color: #FFF; font-size: 0.78125rem; font-weight: 900; padding: 0.45rem 0.85rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    🖨️ Cetak PDF Respon Ini
                                </a>
                            </div>
                        </div>

                        <!-- Respondent Meta Header -->
                        <div style="padding: 1.5rem 1.75rem; border-bottom: 1px solid #F1F5F9; background: #FAFAFA;">
                            <div style="font-size: 0.71875rem; font-weight: 900; color: #047857; text-transform: uppercase;">IDENTITAS TANGGAPAN</div>
                            <div style="font-size: 1.25rem; font-weight: 900; color: #0F172A; margin: 0.25rem 0;">
                                {{ $currentResponse->respondent_name ?? 'Anonim' }}
                                @if($currentResponse->respondent_identifier)
                                    <span style="font-size: 0.84375rem; color: #64748B; font-weight: 700;">({{ $currentResponse->respondent_identifier }})</span>
                                @endif
                            </div>
                            <div style="font-size: 0.75rem; color: #64748B;">
                                ⏱️ Diserahkan pada: {{ $currentResponse->created_at->format('d M Y, H:i:s') }} WIB • IP: {{ $currentResponse->ip_address ?? '-' }}
                            </div>
                        </div>

                        <!-- Q&A List -->
                        <div style="padding: 1.75rem; display: flex; flex-direction: column; gap: 1.25rem;">
                            @foreach($form->fields as $field)
                                @php
                                    $ans = $currentResponse->answers[$field->field_name]['value'] ?? null;
                                @endphp
                                <div style="border-bottom: 1px solid #F1F5F9; padding-bottom: 1rem;">
                                    <div style="font-size: 0.8125rem; font-weight: 800; color: #64748B; margin-bottom: 0.35rem;">
                                        {{ $field->field_label }}
                                    </div>
                                    <div style="font-size: 0.95rem; font-weight: 700; color: #0F172A; line-height: 1.5;">
                                        @if(is_array($ans))
                                            @if(isset($ans['url']))
                                                <!-- Uploaded File -->
                                                <a href="{{ $ans['url'] }}" target="_blank" style="background: #E0F2FE; color: #0369A1; font-weight: 800; font-size: 0.8125rem; padding: 0.35rem 0.75rem; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                                                    📎 Unduh: {{ $ans['name'] }} ({{ $ans['size'] }})
                                                </a>
                                            @else
                                                <!-- Multiple check answers -->
                                                <span>{{ implode(', ', $ans) }}</span>
                                            @endif
                                        @else
                                            <span>{{ $ans ?? '-' }}</span>
                                        @endif

                                        @php
                                            $reason = $currentResponse->answers[$field->field_name]['reason'] ?? null;
                                        @endphp
                                        @if(!empty($reason))
                                            <div style="margin-top: 0.5rem; background: #F0FDF4; border: 1.5px solid #86EFAC; border-radius: 8px; padding: 0.55rem 0.85rem; font-size: 0.8125rem; color: #166534;">
                                                <strong>💬 Alasan / Penjelasan:</strong> {{ $reason }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endif
            </div>

        @endif

    </main>
</div>
@endsection
