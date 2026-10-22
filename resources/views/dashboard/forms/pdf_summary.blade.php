<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kesimpulan & Rekapitulasi - {{ $form->title }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 2.5rem 3rem;
            color: #0F172A;
            line-height: 1.5;
            background: #FFF;
        }
        .header {
            display: flex;
            align-items: center;
            border-bottom: 3px double #0F172A;
            padding-bottom: 1.25rem;
            margin-bottom: 1.5rem;
        }
        .header img {
            height: 70px;
            width: auto;
            margin-right: 1.5rem;
        }
        .inst-title {
            font-size: 14pt;
            font-weight: bold;
            color: #072718;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .inst-sub {
            font-size: 10pt;
            color: #475569;
            margin-top: 4px;
        }
        .meta-box {
            background: #F8FAFC;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.75rem;
            font-size: 9.5pt;
        }
        .meta-row {
            display: flex;
            margin-bottom: 4px;
        }
        .meta-label {
            width: 170px;
            font-weight: bold;
            color: #475569;
        }
        .meta-val {
            font-weight: bold;
            color: #0F172A;
        }
        .summary-card {
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.25rem;
            page-break-inside: avoid;
        }
        .q-title {
            font-size: 10.5pt;
            font-weight: bold;
            color: #072718;
            margin-bottom: 0.75rem;
            border-bottom: 1px solid #E2E8F0;
            padding-bottom: 4px;
        }
        table.stat-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        table.stat-table th, table.stat-table td {
            border: 1px solid #CBD5E1;
            padding: 6px 10px;
            text-align: left;
        }
        table.stat-table th {
            background: #F1F5F9;
            font-weight: bold;
            color: #334155;
        }
        .no-print {
            margin-bottom: 1.5rem;
            text-align: right;
        }
        .print-btn {
            background: #072718;
            color: #FFF;
            padding: 0.6rem 1.25rem;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 10pt;
        }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="print-btn" onclick="window.print()">🖨️ Cetak / Simpan Laporan PDF</button>
    </div>

    <div class="header">
        <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo" />
        <div>
            <div class="inst-title">KEJAKSAAN REPUBLIK INDONESIA</div>
            <div style="font-size: 12pt; font-weight: bold; color: #047857;">LITBANG GAJAH MADA ADHYAKSA</div>
            <div class="inst-sub">Laporan Rekapitulasi Kesimpulan & Analisis Hasil Responden</div>
        </div>
    </div>

    <div class="meta-box">
        <div class="meta-row">
            <div class="meta-label">Nama Formulir / Event:</div>
            <div class="meta-val">{{ $form->title }}</div>
        </div>
        <div class="meta-row">
            <div class="meta-label">Total Responden:</div>
            <div class="meta-val">{{ $responses->count() }} Orang / Responden</div>
        </div>
        <div class="meta-row">
            <div class="meta-label">Status Formulir:</div>
            <div class="meta-val">{{ $form->isOpen() ? 'Aktif (Terbuka)' : 'Ditutup' }}</div>
        </div>
        <div class="meta-row">
            <div class="meta-label">Tanggal Cetak:</div>
            <div class="meta-val">{{ date('d F Y, H:i') }} WIB</div>
        </div>
    </div>

    <div style="font-size: 12pt; font-weight: bold; color: #072718; margin-bottom: 1rem; border-bottom: 2px solid #072718; padding-bottom: 4px;">
        RINGKASAN & STATISTIK TANGGAPAN PER PERTANYAAN
    </div>

    @foreach($summary as $fn => $data)
        <div class="summary-card">
            <div class="q-title">{{ $loop->iteration }}. {{ $data['label'] }}</div>

            @if(isset($data['counts']))
                @php $total = array_sum($data['counts']); @endphp
                <table class="stat-table">
                    <thead>
                        <tr>
                            <th>Opsi Pilihan Jawaban</th>
                            <th style="width: 120px; text-align: center;">Jumlah Respon</th>
                            <th style="width: 100px; text-align: center;">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['counts'] as $opt => $count)
                            @php $pct = $total > 0 ? round(($count / $total) * 100, 1) : 0; @endphp
                            <tr>
                                <td>{{ $opt }}</td>
                                <td style="text-align: center; font-weight: bold;">{{ $count }}</td>
                                <td style="text-align: center;">{{ $pct }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if(!empty($data['reasons']))
                    <div style="margin-top: 8px; font-size: 9pt; font-weight: bold; color: #166534;">
                        💬 Alasan & Penjelasan Responden:
                    </div>
                    <ul style="margin: 4px 0 0 0; padding-left: 1.2rem; font-size: 9pt; color: #334155;">
                        @foreach($data['reasons'] as $rItem)
                            <li style="margin-bottom: 3px;">
                                <strong>{{ $rItem['respondent'] }} (Opsi: {{ $rItem['selected'] }}):</strong> "{{ $rItem['reason'] }}"
                            </li>
                        @endforeach
                    </ul>
                @endif
            @elseif(isset($data['samples']))
                <div style="font-size: 9pt; color: #475569; margin-bottom: 4px;">Cuplikan Jawaban Teks:</div>
                <ul style="margin: 0; padding-left: 1.25rem; font-size: 9.5pt; color: #1E293B;">
                    @forelse($data['samples'] as $text)
                        <li style="margin-bottom: 4px;">{{ $text }}</li>
                    @empty
                        <li style="color: #94A3B8;">Belum ada tanggapan teks.</li>
                    @endforelse
                </ul>
            @endif
        </div>
    @endforeach

    <div style="margin-top: 3rem; display: flex; justify-content: flex-end;">
        <div style="text-align: center; width: 250px;">
            <div style="font-size: 9.5pt; margin-bottom: 4rem;">
                Jakarta, {{ date('d F Y') }}<br />
                <strong>Tim Pokja Riset & Inovasi</strong>
            </div>
            <div style="border-bottom: 1px solid #0F172A; width: 180px; margin: 0 auto 4px;"></div>
            <div style="font-size: 9pt; color: #475569;">Litbang Gajah Mada Adhyaksa</div>
        </div>
    </div>

</body>
</html>
