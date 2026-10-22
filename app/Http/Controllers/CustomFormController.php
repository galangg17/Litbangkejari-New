<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomForm;
use App\Models\CustomFormField;
use App\Models\CustomFormResponse;
use Illuminate\Support\Str;

class CustomFormController extends Controller
{
    // ==========================================
    // AREA PUBLIK (PENGGUNA / PESERTA)
    // ==========================================

    /**
     * Menampilkan daftar form / event yang sedang aktif & siap diisi
     */
    public function index()
    {
        $forms = CustomForm::withCount('responses')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('forms.index', compact('forms'));
    }

    /**
     * Halaman isi formulir (seperti Google Form)
     */
    public function show($slug)
    {
        $form = CustomForm::where('slug', $slug)
            ->with(['fields' => function($q) {
                $q->orderBy('order_index', 'asc');
            }])
            ->firstOrFail();

        return view('forms.show', compact('form'));
    }

    /**
     * Proses kirim tanggapan (Submit Response)
     */
    public function submit(Request $request, $slug)
    {
        $form = CustomForm::where('slug', $slug)
            ->with(['fields' => function($q) {
                $q->orderBy('order_index', 'asc');
            }])
            ->firstOrFail();

        if (!$form->isOpen()) {
            return redirect()->back()->with('error', 'Mohon maaf, formulir ini sudah ditutup untuk penerimaan tanggapan.');
        }

        $answers = [];
        $rules = [];
        $messages = [];

        foreach ($form->fields as $field) {
            $fieldName = $field->field_name;
            $ruleKey = "fields.{$fieldName}";

            if ($field->is_required) {
                $rules[$ruleKey] = 'required';
                $messages["{$ruleKey}.required"] = "Kolom '{$field->field_label}' wajib diisi.";
            }

            if ($field->field_type === 'file') {
                if ($field->is_required) {
                    $rules["file_{$fieldName}"] = 'required|file|max:15360|mimes:pdf,docx,doc,jpg,jpeg,png,xls,xlsx,pptx,ppt,zip';
                    $messages["file_{$fieldName}.required"] = "Berkas lampiran '{$field->field_label}' wajib diunggah.";
                } else {
                    $rules["file_{$fieldName}"] = 'nullable|file|max:15360|mimes:pdf,docx,doc,jpg,jpeg,png,xls,xlsx,pptx,ppt,zip';
                }
            }
        }

        $request->validate($rules, $messages);

        $inputData = $request->input('fields', []);
        $reasonsData = $request->input('reasons', []);
        $respondentName = null;
        $respondentId = null;

        foreach ($form->fields as $field) {
            $fn = $field->field_name;
            $val = $inputData[$fn] ?? null;

            // Handle file upload
            if ($field->field_type === 'file') {
                if ($request->hasFile("file_{$fn}")) {
                    $uploadedFile = $request->file("file_{$fn}");
                    $filename = time() . '_' . Str::slug(pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $uploadedFile->getClientOriginalExtension();
                    $path = $uploadedFile->storeAs('form_uploads/' . $form->id, $filename, 'public');
                    $val = [
                        'name' => $uploadedFile->getClientOriginalName(),
                        'url' => '/storage/' . $path,
                        'size' => round($uploadedFile->getSize() / 1024, 2) . ' KB',
                    ];
                }
            }

            $reasonVal = $reasonsData[$fn] ?? null;
            if (is_array($reasonVal)) {
                $reasonVal = implode('; ', array_filter($reasonVal));
            }

            $fieldAnswer = [
                'label' => $field->field_label,
                'type' => $field->field_type,
                'value' => $val,
            ];

            if (!empty($reasonVal)) {
                $fieldAnswer['reason'] = trim($reasonVal);
            }

            $answers[$fn] = $fieldAnswer;

            // Deteksi otomatis nama / NIP responden jika ada field bersesuaian
            $labelLower = strtolower($field->field_label);
            if (!$respondentName && (str_contains($labelLower, 'nama') || str_contains($labelLower, 'name'))) {
                $respondentName = is_string($val) ? $val : null;
            }
            if (!$respondentId && (str_contains($labelLower, 'nip') || str_contains($labelLower, 'nrp') || str_contains($labelLower, 'email'))) {
                $respondentId = is_string($val) ? $val : null;
            }
        }

        CustomFormResponse::create([
            'custom_form_id' => $form->id,
            'respondent_name' => $respondentName ?? 'Anonim',
            'respondent_identifier' => $respondentId,
            'answers' => $answers,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('forms.submitted', $form->slug);
    }

    /**
     * Halaman sukses submit (Thank You Page ala Google Form)
     */
    public function submitted($slug)
    {
        $form = CustomForm::where('slug', $slug)->firstOrFail();
        return view('forms.submitted', compact('form'));
    }

    // ==========================================
    // AREA ADMIN (DASHBOARD PENGELOLAAN FORM)
    // ==========================================

    /**
     * Simpan formulir baru dari admin
     */
    public function storeForm(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:open,closed',
            'deadline_at' => 'nullable|date',
            'success_message' => 'nullable|string',
        ]);

        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (CustomForm::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $form = CustomForm::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'deadline_at' => $validated['deadline_at'] ? date('Y-m-d H:i:s', strtotime($validated['deadline_at'])) : null,
            'success_message' => $validated['success_message'] ?? 'Tanggapan Anda telah berhasil disimpan.',
        ]);

        // Default default fields (Nama & Satuan Kerja) agar pembuat form tidak mulai dari nol
        CustomFormField::create([
            'custom_form_id' => $form->id,
            'field_label' => 'Nama Lengkap & Gelar',
            'field_name' => 'nama_lengkap',
            'field_type' => 'text',
            'is_required' => true,
            'order_index' => 1,
        ]);

        CustomFormField::create([
            'custom_form_id' => $form->id,
            'field_label' => 'Satuan Kerja / Asal Kejaksaan',
            'field_name' => 'satuan_kerja',
            'field_type' => 'text',
            'is_required' => true,
            'order_index' => 2,
        ]);

        return redirect()->route('dashboard.forms.builder', $form->id)
            ->with('toast', 'Formulir baru berhasil dibuat! Silakan tambahkan pertanyaan sesuai kebutuhan.');
    }

    /**
     * Builder Form (Tambah / Edit Pertanyaan & Field)
     */
    public function builder($id)
    {
        $form = CustomForm::with(['fields' => function($q) {
            $q->orderBy('order_index', 'asc');
        }])->findOrFail($id);

        return view('dashboard.forms.builder', compact('form'));
    }

    /**
     * Update detail form (Judul, deskripsi, status buka/tutup)
     */
    public function updateForm(Request $request, $id)
    {
        $form = CustomForm::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:open,closed',
            'deadline_at' => 'nullable|date',
            'success_message' => 'nullable|string',
        ]);

        $form->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'deadline_at' => $validated['deadline_at'] ? date('Y-m-d H:i:s', strtotime($validated['deadline_at'])) : null,
            'success_message' => $validated['success_message'] ?? $form->success_message,
        ]);

        return redirect()->back()->with('toast', 'Pengaturan formulir berhasil diperbarui!');
    }

    /**
     * Tambah Pertanyaan / Field ke Formulir
     */
    public function storeField(Request $request, $formId)
    {
        $form = CustomForm::findOrFail($formId);

        $validated = $request->validate([
            'category' => 'nullable|string|max:255',
            'field_label' => 'required|string|max:500',
            'field_type' => 'required|in:text,textarea,select,radio,checkbox,file,date,number',
            'options_raw' => 'nullable|string',
            'has_reason' => 'nullable',
            'reason_label' => 'nullable|string|max:255',
            'reason_trigger' => 'nullable|string',
            'help_text' => 'nullable|string',
            'is_required' => 'nullable',
        ]);

        $options = null;
        if (in_array($validated['field_type'], ['select', 'radio', 'checkbox']) && !empty($validated['options_raw'])) {
            $lines = explode("\n", str_replace("\r", "", $validated['options_raw']));
            $options = array_values(array_filter(array_map(function($line) {
                $clean = trim($line);
                // Bersihkan bullet atau titik double di awal teks
                return ltrim($clean, "• -*\t ");
            }, $lines)));
        }

        $cleanFieldName = Str::slug($validated['field_label'], '_');
        if (empty($cleanFieldName)) {
            $cleanFieldName = 'pertanyaan_' . time();
        }
        $fieldName = $cleanFieldName;
        $counter = 1;
        while (CustomFormField::where('custom_form_id', $form->id)->where('field_name', $fieldName)->exists()) {
            $fieldName = $cleanFieldName . '_' . $counter++;
        }

        $maxOrder = CustomFormField::where('custom_form_id', $form->id)->max('order_index') ?? 0;

        CustomFormField::create([
            'custom_form_id' => $form->id,
            'category' => $validated['category'] ?? null,
            'field_label' => $validated['field_label'],
            'field_name' => $fieldName,
            'field_type' => $validated['field_type'],
            'options' => $options,
            'has_reason' => $request->has('has_reason'),
            'reason_label' => $request->input('reason_label') ?: 'Sebutkan alasan atau penjelasan pilihan Anda...',
            'reason_trigger' => $request->input('reason_trigger') ?: 'all',
            'help_text' => $validated['help_text'] ?? null,
            'is_required' => $request->has('is_required'),
            'order_index' => $maxOrder + 1,
        ]);

        return redirect()->back()->with('toast', 'Pertanyaan baru berhasil ditambahkan!');
    }

    /**
     * Perbarui Pertanyaan / Field yang sudah ada
     */
    public function updateField(Request $request, $fieldId)
    {
        $field = CustomFormField::findOrFail($fieldId);

        $validated = $request->validate([
            'category' => 'nullable|string|max:255',
            'field_label' => 'required|string|max:500',
            'field_type' => 'required|in:text,textarea,select,radio,checkbox,file,date,number',
            'options_raw' => 'nullable|string',
            'has_reason' => 'nullable',
            'reason_label' => 'nullable|string|max:255',
            'reason_trigger' => 'nullable|string',
            'help_text' => 'nullable|string',
            'is_required' => 'nullable',
        ]);

        $options = null;
        if (in_array($validated['field_type'], ['select', 'radio', 'checkbox']) && !empty($validated['options_raw'])) {
            $lines = explode("\n", str_replace("\r", "", $validated['options_raw']));
            $options = array_values(array_filter(array_map(function($line) {
                $clean = trim($line);
                return ltrim($clean, "• -*\t ");
            }, $lines)));
        }

        $field->update([
            'category' => $validated['category'] ?? null,
            'field_label' => $validated['field_label'],
            'field_type' => $validated['field_type'],
            'options' => $options,
            'has_reason' => $request->has('has_reason'),
            'reason_label' => $request->input('reason_label') ?: 'Sebutkan alasan atau penjelasan pilihan Anda...',
            'reason_trigger' => $request->input('reason_trigger') ?: 'all',
            'help_text' => $validated['help_text'] ?? null,
            'is_required' => $request->has('is_required'),
        ]);

        return redirect()->back()->with('toast', 'Pertanyaan #' . $field->order_index . ' berhasil diperbarui!');
    }

    /**
     * Ubah Urutan Pertanyaan (Move Up / Down)
     */
    public function moveField($fieldId, $direction)
    {
        $field = CustomFormField::findOrFail($fieldId);
        $formId = $field->custom_form_id;

        if ($direction === 'up') {
            $swapWith = CustomFormField::where('custom_form_id', $formId)
                ->where('order_index', '<', $field->order_index)
                ->orderBy('order_index', 'desc')
                ->first();
        } else {
            $swapWith = CustomFormField::where('custom_form_id', $formId)
                ->where('order_index', '>', $field->order_index)
                ->orderBy('order_index', 'asc')
                ->first();
        }

        if ($swapWith) {
            $temp = $field->order_index;
            $field->order_index = $swapWith->order_index;
            $swapWith->order_index = $temp;
            $field->save();
            $swapWith->save();
        }

        return redirect()->back()->with('toast', 'Urutan pertanyaan berhasil diubah.');
    }

    /**
     * Duplikat Pertanyaan
     */
    public function duplicateField($fieldId)
    {
        $field = CustomFormField::findOrFail($fieldId);
        $maxOrder = CustomFormField::where('custom_form_id', $field->custom_form_id)->max('order_index') ?? 0;

        $newField = $field->replicate();
        $newField->field_label = $field->field_label . ' (Salinan)';
        $newField->field_name = Str::slug($newField->field_label, '_') . '_' . time();
        $newField->order_index = $maxOrder + 1;
        $newField->save();

        return redirect()->back()->with('toast', 'Pertanyaan berhasil diduplikat.');
    }

    /**
     * Hapus Field / Pertanyaan
     */
    public function destroyField($fieldId)
    {
        $field = CustomFormField::findOrFail($fieldId);
        $field->delete();

        return redirect()->back()->with('toast', 'Pertanyaan berhasil dihapus.');
    }

    /**
     * Hapus Formulir beserta seluruh responnya
     */
    public function destroyForm($id)
    {
        $form = CustomForm::findOrFail($id);
        $form->delete();

        return redirect()->route('dashboard.index', ['tab' => 'custom_forms'])
            ->with('toast', 'Formulir berhasil dihapus.');
    }

    // ==========================================
    // REKAP & HASIL RESPON (RINGKASAN, INDIVIDUAL, EXCEL, PDF)
    // ==========================================

    /**
     * Halaman Hasil Respon (Google Form Response Center)
     * Dilengkapi Tab: Ringkasan / Kesimpulan & Perorangan (Individual)
     */
    public function responses(Request $request, $id)
    {
        $form = CustomForm::with(['fields' => function($q) {
            $q->orderBy('order_index', 'asc');
        }])->findOrFail($id);

        $responses = CustomFormResponse::where('custom_form_id', $form->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Indeks individual view
        $currentIndex = (int) $request->get('index', 0);
        if ($currentIndex < 0) $currentIndex = 0;
        if ($currentIndex >= $responses->count() && $responses->count() > 0) {
            $currentIndex = $responses->count() - 1;
        }

        $currentResponse = $responses->count() > 0 ? $responses->get($currentIndex) : null;

        // Analisis & Kesimpulan Otomatis untuk Ringkasan
        $summary = [];
        foreach ($form->fields as $field) {
            $fn = $field->field_name;
            $type = $field->field_type;

            if (in_array($type, ['select', 'radio', 'checkbox'])) {
                $optionCounts = [];
                if (!empty($field->options)) {
                    foreach ($field->options as $opt) {
                        $optionCounts[$opt] = 0;
                    }
                }
                foreach ($responses as $resp) {
                    $ans = $resp->answers[$fn]['value'] ?? null;
                    if (is_array($ans)) {
                        foreach ($ans as $subAns) {
                            $optionCounts[$subAns] = ($optionCounts[$subAns] ?? 0) + 1;
                        }
                    } elseif ($ans) {
                        $optionCounts[$ans] = ($optionCounts[$ans] ?? 0) + 1;
                    }
                }
                $fieldReasons = [];
                foreach ($responses as $resp) {
                    $reasonText = $resp->answers[$fn]['reason'] ?? null;
                    if ($reasonText && is_string($reasonText)) {
                        $selVal = $resp->answers[$fn]['value'] ?? '-';
                        if (is_array($selVal)) $selVal = implode(', ', $selVal);
                        $fieldReasons[] = [
                            'respondent' => $resp->respondent_name ?? 'Anonim',
                            'selected' => $selVal,
                            'reason' => $reasonText,
                        ];
                    }
                }

                $summary[$fn] = [
                    'label' => $field->field_label,
                    'type' => $type,
                    'counts' => $optionCounts,
                    'reasons' => $fieldReasons,
                ];
            } else {
                $recentText = [];
                foreach ($responses->take(15) as $resp) {
                    $ans = $resp->answers[$fn]['value'] ?? null;
                    if ($ans && is_string($ans)) {
                        $recentText[] = $ans;
                    }
                }
                $summary[$fn] = [
                    'label' => $field->field_label,
                    'type' => $type,
                    'samples' => $recentText,
                ];
            }
        }

        return view('dashboard.forms.responses', compact('form', 'responses', 'currentResponse', 'currentIndex', 'summary'));
    }

    /**
     * Export Keseluruhan Jawaban ke Excel / CSV
     */
    public function exportCsv($id)
    {
        $form = CustomForm::with(['fields' => function($q) {
            $q->orderBy('order_index', 'asc');
        }])->findOrFail($id);

        $responses = CustomFormResponse::where('custom_form_id', $form->id)
            ->orderBy('created_at', 'asc')
            ->get();

        $filename = 'Respon_' . Str::slug($form->title) . '_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($form, $responses) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM untuk Excel

            // Headers kolom
            $headerRow = ['No', 'Waktu Pengisian', 'Nama Responden', 'NIP/NRP/Identitas'];
            foreach ($form->fields as $field) {
                $headerRow[] = $field->field_label;
                if ($field->has_reason) {
                    $headerRow[] = $field->field_label . ' (Alasan / Penjelasan)';
                }
            }
            fputcsv($file, $headerRow);

            $no = 1;
            foreach ($responses as $resp) {
                $row = [
                    $no++,
                    $resp->created_at->format('Y-m-d H:i:s'),
                    $resp->respondent_name ?? '-',
                    $resp->respondent_identifier ?? '-',
                ];

                foreach ($form->fields as $field) {
                    $fn = $field->field_name;
                    $val = $resp->answers[$fn]['value'] ?? null;
                    $reason = $resp->answers[$fn]['reason'] ?? null;

                    if (is_array($val)) {
                        if (isset($val['url'])) {
                            // File link
                            $row[] = url($val['url']);
                        } else {
                            // Checkbox
                            $row[] = implode(', ', $val);
                        }
                    } else {
                        $row[] = $val ?? '-';
                    }

                    if ($field->has_reason) {
                        $row[] = $reason ?? '-';
                    }
                }

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Cetak / Download PDF Respon Perorangan (Individual Printable PDF View)
     */
    public function exportIndividualPdf($id, $responseId)
    {
        $form = CustomForm::with(['fields' => function($q) {
            $q->orderBy('order_index', 'asc');
        }])->findOrFail($id);

        $response = CustomFormResponse::where('custom_form_id', $form->id)
            ->where('id', $responseId)
            ->firstOrFail();

        return view('dashboard.forms.pdf_individual', compact('form', 'response'));
    }

    /**
     * Cetak / Download PDF Rekapitulasi & Kesimpulan (Summary Printable PDF Report)
     */
    public function exportSummaryPdf($id)
    {
        $form = CustomForm::with(['fields' => function($q) {
            $q->orderBy('order_index', 'asc');
        }])->findOrFail($id);

        $responses = CustomFormResponse::where('custom_form_id', $form->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Hitung statistik
        $summary = [];
        foreach ($form->fields as $field) {
            $fn = $field->field_name;
            $type = $field->field_type;

            if (in_array($type, ['select', 'radio', 'checkbox'])) {
                $counts = [];
                if (!empty($field->options)) {
                    foreach ($field->options as $opt) {
                        $counts[$opt] = 0;
                    }
                }
                foreach ($responses as $resp) {
                    $ans = $resp->answers[$fn]['value'] ?? null;
                    if (is_array($ans)) {
                        foreach ($ans as $sub) {
                            $counts[$sub] = ($counts[$sub] ?? 0) + 1;
                        }
                    } elseif ($ans) {
                        $counts[$ans] = ($counts[$ans] ?? 0) + 1;
                    }
                }
                $summary[$fn] = [
                    'label' => $field->field_label,
                    'type' => $type,
                    'counts' => $counts,
                ];
            } else {
                $texts = [];
                foreach ($responses as $resp) {
                    $ans = $resp->answers[$fn]['value'] ?? null;
                    if ($ans && is_string($ans)) {
                        $texts[] = $ans;
                    }
                }
                $summary[$fn] = [
                    'label' => $field->field_label,
                    'type' => $type,
                    'samples' => $texts,
                ];
            }
        }

        return view('dashboard.forms.pdf_summary', compact('form', 'responses', 'summary'));
    }
}
