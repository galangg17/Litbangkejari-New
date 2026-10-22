<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Hasil Formulir - {{ $form->title }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1.5cm 1.5cm 2cm 1.5cm;
        }
        body {
            font-family: 'Plus Jakarta Sans', Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 2rem 2.5rem;
            color: #0F172A;
            line-height: 1.5;
            background: #FFFFFF;
            font-size: 9.5pt;
        }

        /* APPLICATION HEADER (BUKAN KOP LEMBAGA RESMI, DARI APLIKASI KITA) */
        .app-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2.5px solid #062E1D;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }
        .header-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .header-logo {
            height: 58px;
            width: auto;
        }
        .header-app-title {
            font-size: 13pt;
            font-weight: 800;
            color: #062E1D;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            line-height: 1.2;
            margin: 0;
        }
        .header-app-sub {
            font-size: 8.5pt;
            color: #64748B;
            font-weight: 600;
            margin-top: 3px;
        }
        .header-doc-badge {
            background: #F1F5F9;
            border: 1px solid #CBD5E1;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            text-align: right;
        }
        .doc-badge-title {
            font-size: 7pt;
            font-weight: 800;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .doc-badge-name {
            font-size: 9pt;
            font-weight: 800;
            color: #062E1D;
        }

        /* METADATA BOX */
        .meta-container {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 0.95rem 1.25rem;
            margin-bottom: 1.75rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.65rem 1.5rem;
            font-size: 9pt;
        }
        .meta-item {
            display: flex;
            flex-direction: column;
        }
        .meta-item.full-width {
            grid-column: span 2;
        }
        .meta-label {
            font-size: 7.5pt;
            font-weight: 800;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 2px;
        }
        .meta-val {
            font-size: 9.5pt;
            font-weight: 700;
            color: #0F172A;
            line-height: 1.35;
        }

        /* SECTION TITLE */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1.5px solid #062E1D;
            padding-bottom: 0.4rem;
            margin-bottom: 1.25rem;
            margin-top: 1rem;
        }
        .section-title {
            font-size: 10.5pt;
            font-weight: 800;
            color: #062E1D;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin: 0;
        }
        .section-count {
            font-size: 8pt;
            font-weight: 700;
            color: #475569;
        }

        /* QUESTION CARD */
        .q-card {
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.25rem;
            page-break-inside: avoid;
        }
        .q-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid #F1F5F9;
            padding-bottom: 0.5rem;
            margin-bottom: 0.85rem;
            gap: 0.75rem;
        }
        .q-num {
            background: #062E1D;
            color: #DFB743;
            font-size: 7.5pt;
            font-weight: 800;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
            margin-right: 0.4rem;
        }
        .q-title {
            font-size: 10pt;
            font-weight: 800;
            color: #0F172A;
            line-height: 1.4;
            flex: 1;
        }
        .q-type-badge {
            font-size: 7pt;
            font-weight: 800;
            color: #475569;
            background: #F1F5F9;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            white-space: nowrap;
            text-transform: uppercase;
        }

        /* DIAGRAM / VISUAL BAR CHART */
        .chart-container {
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
            margin-bottom: 1rem;
        }
        .chart-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 8.5pt;
        }
        .chart-label {
            width: 220px;
            font-weight: 700;
            color: #1E293B;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .chart-track {
            flex: 1;
            height: 14px;
            background: #F1F5F9;
            border: 1px solid #E2E8F0;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }
        .chart-fill {
            height: 100%;
            background: #064E3B;
            border-radius: 3px;
        }
        .chart-meta {
            width: 90px;
            text-align: right;
            font-weight: 800;
            color: #062E1D;
            font-size: 8pt;
            flex-shrink: 0;
        }

        /* SUMMARY DATA TABLE */
        table.stat-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
            margin-top: 0.65rem;
        }
        table.stat-table th, table.stat-table td {
            border: 1px solid #E2E8F0;
            padding: 5px 8px;
            text-align: left;
        }
        table.stat-table th {
            background: #F8FAFC;
            font-weight: 800;
            color: #334155;
            font-size: 7.5pt;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        /* REASON BOX */
        .reason-section {
            margin-top: 0.85rem;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-left: 3px solid #C59B27;
            border-radius: 6px;
            padding: 0.65rem 0.85rem;
            font-size: 8pt;
        }
        .reason-head {
            font-weight: 800;
            color: #78350F;
            margin-bottom: 0.35rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        .reason-list {
            margin: 0;
            padding-left: 1rem;
            color: #334155;
            line-height: 1.45;
        }
        .reason-item {
            margin-bottom: 0.3rem;
        }

        /* TEXT SAMPLES */
        .sample-list {
            margin: 0;
            padding-left: 1.15rem;
            color: #1E293B;
            font-size: 8.5pt;
            line-height: 1.5;
        }
        .sample-item {
            margin-bottom: 0.35rem;
        }

        /* DOCUMENT CLOSING & QR VERIFICATION (SESUAI REQUEST USER) */
        .doc-footer-section {
            margin-top: 3rem;
            padding-top: 1.5rem;
            border-top: 1.5px solid #E2E8F0;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            page-break-inside: avoid;
        }
        .footer-note {
            font-size: 8pt;
            color: #64748B;
            max-width: 380px;
            line-height: 1.5;
        }
        .qr-verification-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .qr-date {
            font-size: 8.5pt;
            font-weight: 750;
            color: #0F172A;
            margin-bottom: 0.5rem;
        }
        .qr-image-wrapper {
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            padding: 5px;
            border-radius: 8px;
            display: inline-block;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .qr-image {
            width: 85px;
            height: 85px;
            display: block;
        }
        .qr-brand-label {
            font-size: 9pt;
            font-weight: 800;
            color: #062E1D;
            margin-top: 0.45rem;
            letter-spacing: 0.02em;
        }

        /* NO PRINT CONTROLS */
        .no-print {
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }
        .print-action-btn {
            background: #062E1D;
            color: #DFB743;
            font-weight: 800;
            padding: 0.6rem 1.4rem;
            border: 1px solid #C59B27;
            border-radius: 8px;
            cursor: pointer;
            font-size: 9.5pt;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.15s ease;
        }
        .print-action-btn:hover {
            background: #0B462C;
        }

        @media print {
            .no-print { display: none !important; }
            body { padding: 0 !important; }
            .q-card { box-shadow: none; }
        }
    </style>
</head>
<body>

    @php
        // FORMAT TANGGAL INDONESIA: HARI, TANGGAL BULAN TAHUN
        $hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $now = now();
        $hari = $hariIndo[$now->dayOfWeek];
        $tgl = $now->day;
        $bln = $bulanIndo[$now->month];
        $thn = $now->year;
        $jam = $now->format('H:i');
        $tanggalLengkap = "{$hari}, {$tgl} {$bln} {$thn}";
        $formUrl = route('forms.show', $form->slug);
    @endphp

    <!-- TOMBOL CETAK -->
    <div class="no-print">
        <button class="print-action-btn" onclick="window.print()">
            <span>🖨️</span>
            <span>Cetak / Simpan Laporan PDF</span>
        </button>
    </div>

    <!-- HEADER RESMI APLIKASI KITA (BUKAN KOP LEMBAGA KEJAKSAAN) -->
    <header class="app-header">
        <div class="header-brand">
            <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo" class="header-logo" onerror="this.style.display='none'" />
            <div>
                <h1 class="header-app-title">LITBANG GAJAH MADA ADHYAKSA</h1>
                <div class="header-app-sub">Sistem Informasi Riset, Evaluasi Akademik & Inovasi Diklat</div>
            </div>
        </div>
        <div class="header-doc-badge">
            <div class="doc-badge-title">DOKUMEN REKAPITULASI</div>
            <div class="doc-badge-name">HASIL EVALUASI FORMULIR</div>
        </div>
    </header>

    <!-- METADATA BOX -->
    <div class="meta-container">
        <div class="meta-item full-width">
            <span class="meta-label">Nama Formulir / Instrumen Kuesioner:</span>
            <span class="meta-val">{{ $form->title }}</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Total Responden Terdata:</span>
            <span class="meta-val" style="color: #064E3B;">{{ $responses->count() }} Orang / Responden</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Status Penerimaan Formulir:</span>
            <span class="meta-val">{{ $form->isOpen() ? '🟢 Sesi Aktif (Terbuka)' : '🔴 Penerimaan Ditutup' }}</span>
        </div>
        <div class="meta-item full-width">
            <span class="meta-label">Waktu Penarikan Data Dokumen:</span>
            <span class="meta-val">{{ $tanggalLengkap }}, Pukul {{ $jam }} WIB</span>
        </div>
    </div>

    <!-- SECTION TITLE -->
    <div class="section-header">
        <h2 class="section-title">Ringkasan & Visualisasi Statistik Per Butir Pertanyaan</h2>
        <span class="section-count">Total {{ count($summary) }} Butir Soal</span>
    </div>

    <!-- LOOPING PERTANYAAN BESERTA DIAGRAM VISUAL -->
    @foreach($summary as $fn => $data)
        <div class="q-card">
            
            <div class="q-header">
                <div class="q-title">
                    <span class="q-num">#{{ $loop->iteration }}</span>
                    <span>{{ $data['label'] }}</span>
                </div>
                <span class="q-type-badge">
                    @if($data['type'] === 'radio') Pilihan Tunggal
                    @elseif($data['type'] === 'checkbox') Kotak Centang
                    @elseif($data['type'] === 'select') Dropdown
                    @elseif($data['type'] === 'textarea') Uraian Panjang
                    @else Isian Teks
                    @endif
                </span>
            </div>

            <!-- DIAGRAM VISUAL PERSENTASE (UNTUK PERTANYAAN PILIHAN) -->
            @if(isset($data['counts']))
                @php
                    $totalVotes = array_sum($data['counts']);
                    // Urutkan opsi berdasarkan jumlah suara terbanyak untuk kemudahan analisis pimpinan
                    $sortedCounts = $data['counts'];
                    arsort($sortedCounts);
                @endphp

                <!-- 1. DIAGRAM BATANG VISUAL (HORIZONTAL BAR CHART) -->
                <div class="chart-container">
                    @foreach($sortedCounts as $optName => $count)
                        @php
                            $cleanOpt = ltrim(trim($optName), "• -*\t ");
                            $pct = $totalVotes > 0 ? round(($count / $totalVotes) * 100, 1) : 0;
                        @endphp
                        <div class="chart-row">
                            <div class="chart-label" title="{{ $cleanOpt }}">
                                {{ $cleanOpt }}
                            </div>
                            <div class="chart-track">
                                <div class="chart-fill" style="width: {{ $pct }}%;"></div>
                            </div>
                            <div class="chart-meta">
                                {{ $count }} suara ({{ $pct }}%)
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- 2. TABEL STATISTIK RINGKAS -->
                <table class="stat-table">
                    <thead>
                        <tr>
                            <th>Opsi Jawaban</th>
                            <th style="width: 100px; text-align: center;">Jumlah Suara</th>
                            <th style="width: 90px; text-align: center;">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sortedCounts as $optName => $count)
                            @php
                                $cleanOpt = ltrim(trim($optName), "• -*\t ");
                                $pct = $totalVotes > 0 ? round(($count / $totalVotes) * 100, 1) : 0;
                            @endphp
                            <tr>
                                <td>{{ $cleanOpt }}</td>
                                <td style="text-align: center; font-weight: 700;">{{ $count }}</td>
                                <td style="text-align: center; font-weight: 700; color: #064E3B;">{{ $pct }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- 3. KUMPULAN ALASAN PESERTA JIKA ADA -->
                @if(!empty($data['reasons']))
                    <div class="reason-section">
                        <div class="reason-head">
                            <span>💬</span>
                            <span>Catatan & Alasan Responden ({{ count($data['reasons']) }} Catatan Masuk):</span>
                        </div>
                        <ul class="reason-list">
                            @foreach($data['reasons'] as $rItem)
                                <li class="reason-item">
                                    <strong>{{ $rItem['respondent'] }}</strong> 
                                    (Opsi: <em>{{ ltrim(trim($rItem['selected']), "• -*\t ") }}</em>): 
                                    "{{ $rItem['reason'] }}"
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            <!-- UNTUK PERTANYAAN ISIAN TEKS -->
            @elseif(isset($data['samples']))
                <div style="font-size: 8pt; font-weight: 700; color: #64748B; margin-bottom: 0.4rem; text-transform: uppercase;">
                    Cuplikan Jawaban Responden:
                </div>
                <ul class="sample-list">
                    @forelse($data['samples'] as $textSample)
                        <li class="sample-item">{{ $textSample }}</li>
                    @empty
                        <li class="sample-item" style="color: #94A3B8; font-style: italic;">Belum ada tanggapan teks yang masuk.</li>
                    @endforelse
                </ul>
            @endif

        </div>
    @endforeach

    <!-- PENUTUP DOKUMEN SESUAI KEBUTUHAN USER: HARI, TANGGAL, BULAN, TAHUN + QR + LITBANG GAJAH MADA ADHYAKSA -->
    <div class="doc-footer-section">
        <div class="footer-note">
            Dokumen ini dihasilkan secara otomatis melalui sistem rekapitulasi data terenkripsi <strong>Litbang Gajah Mada Adhyaksa</strong> untuk keperluan evaluasi akademik, kurikulum, dan penyusunan policy brief Diklat.
        </div>

        <div class="qr-verification-box">
            <!-- HARI, TANGGAL, BULAN, TAHUN -->
            <div class="qr-date">
                {{ $tanggalLengkap }}
            </div>

            <!-- QR CODE -->
            <div class="qr-image-wrapper">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&data={{ urlencode($formUrl) }}" 
                     alt="QR Code" 
                     class="qr-image" />
            </div>

            <!-- NAMA APLIKASI DI BAWAH QR -->
            <div class="qr-brand-label">
                Litbang Gajah Mada Adhyaksa
            </div>
        </div>
    </div>

</body>
</html>
