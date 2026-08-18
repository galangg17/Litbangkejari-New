<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kajian;
use App\Models\PublicProposal;
use App\Models\SystemSetting;
use App\Models\Category;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $setting = SystemSetting::first() ?? new SystemSetting();
        $categories = Category::all();
        
        $query = Kajian::where('status', 'Publish & Vault')
                        ->orWhere('status', 'Final & Publikasi')
                        ->orWhere('status', 'Policy Brief');

        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(summary) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(category) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->has('category') && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        if ($request->has('access_type') && $request->access_type !== 'Semua') {
            $query->where('access_type', $request->access_type);
        }

        $policyBriefs = $query->orderBy('updated_at', 'desc')->get();
        $heroBriefs = Kajian::whereNotNull('tag')->get();

        $trackedTicket = null;
        if ($request->has('ticket_no') && !empty($request->ticket_no)) {
            $trackedTicket = PublicProposal::where('ticket_no', strtoupper(trim($request->ticket_no)))->first();
        }

        return view('landing.index', compact('setting', 'policyBriefs', 'heroBriefs', 'trackedTicket', 'categories'));
    }

    public function submitProposal(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'category' => 'required|string',
            'title' => 'required|string|max:255',
            'urgency' => 'required|string',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,docx,doc,jpg,png|max:10240',
        ]);

        $randomNo = 'USUL-2026-' . rand(100, 999);
        $fileName = null;
        $filePath = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('proposals', time() . '_' . $fileName, 'public');
        }

        // Save ONLY in public_proposals table for Admin Ingestion Screening
        $proposal = PublicProposal::create([
            'ticket_no' => $randomNo,
            'name' => $validated['name'],
            'institution' => $validated['institution'] ?? 'Umum',
            'category' => $validated['category'],
            'title' => $validated['title'],
            'urgency' => $validated['urgency'],
            'description' => $validated['description'],
            'file_name' => $fileName,
            'file_path' => $filePath,
            'status' => 'Pengajuan (Menunggu Skrining)',
            'timeline_step' => 1,
            'last_update_note' => 'Usulan baru saja diterima oleh sistem. Menunggu proses skrining & disposisi Admin Sekretariat.',
        ]);

        return redirect()->back()->with('success_ticket', [
            'ticket_no' => $randomNo,
            'title' => $validated['title'],
            'name' => $validated['name'],
            'file_name' => $fileName
        ]);
    }
}
