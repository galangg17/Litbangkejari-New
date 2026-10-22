<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Respon - {{ $form->title }} - {{ $response->respondent_name ?? 'Responden' }}</title>
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
            margin-bottom: 1.5rem;
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
        .qa-card {
            border: 1px solid #E2E8F0;
            border-radius: 6px;
            padding: 0.85rem 1rem;
            margin-bottom: 0.75rem;
            page-break-inside: avoid;
        }
        .q-title {
            font-size: 9.5pt;
            font-weight: bold;
            color: #072718;
            margin-bottom: 4px;
        }
        .a-val {
            font-size: 10pt;
            color: #1E293B;
            font-weight: normal;
            white-space: pre-line;
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
        <button class="print-btn" onclick="window.print()">🖨️ Cetak / Simpan sebagai PDF</button>
    </div>

    <div class="header">
        <img src="{{ asset('logo-adhyaksa.png') }}" alt="Logo" />
        <div>
            <div class="inst-title">KEJAKSAAN REPUBLIK INDONESIA</div>
            <div style="font-size: 12pt; font-weight: bold; color: #047857;">LITBANG GAJAH MADA ADHYAKSA</div>
            <div class="inst-sub">Lembar Rekapitulasi Tanggapan Responden Perorangan</div>
        </div>
    </div>

    <div class="meta-box">
        <div class="meta-row">
            <div class="meta-label">Nama Formulir / Event:</div>
            <div class="meta-val">{{ $form->title }}</div>
        </div>
        <div class="meta-row">
            <div class="meta-label">Nama Responden:</div>
            <div class="meta-val">{{ $response->respondent_name ?? 'Anonim' }}</div>
        </div>
        @if($response->respondent_identifier)
        <div class="meta-row">
            <div class="meta-label">NIP / Identitas:</div>
            <div class="meta-val">{{ $response->respondent_identifier }}</div>
        </div>
        @endif
        <div class="meta-row">
            <div class="meta-label">Waktu Pengisian:</div>
            <div class="meta-val">{{ $response->created_at->format('d F Y, H:i:s') }} WIB</div>
        </div>
        <div class="meta-row">
            <div class="meta-label">ID Tanggapan / IP:</div>
            <div class="meta-val">#RESP-{{ $response->id }} • {{ $response->ip_address ?? '127.0.0.1' }}</div>
        </div>
    </div>

    <div style="font-size: 11pt; font-weight: bold; color: #072718; margin-bottom: 0.75rem; border-bottom: 1.5px solid #072718; padding-bottom: 4px;">
        DAFTAR JAWABAN & TANGGAPAN
    </div>

    @foreach($form->fields as $index => $field)
        @php
            $ans = $response->answers[$field->field_name]['value'] ?? null;
        @endphp
        <div class="qa-card">
            <div class="q-title">{{ $index + 1 }}. {{ $field->field_label }}</div>
            <div class="a-val">
                @if(is_array($ans))
                    @if(isset($ans['url']))
                        Lampiran File: {{ $ans['name'] }} ({{ $ans['size'] }})
                    @else
                        {{ implode(', ', $ans) }}
                    @endif
                @else
                    {{ $ans ?? '-' }}
                @endif
            </div>
        </div>
    @endforeach

    <div style="margin-top: 2.5rem; text-align: right; font-size: 9pt; color: #64748B;">
        Dicetak otomatis melalui Sistem Litbang Gajah Mada Adhyaksa pada {{ date('d F Y H:i:s') }}
    </div>

</body>
</html>
