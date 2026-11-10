<?php

namespace App\Http\Controllers;

use App\Mail\IncidentReportReceived;
use App\Models\IncidentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IncidentReportController extends Controller
{
    public function create()
    {
        return view('public.incident-report');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'instansi' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:filter', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'kategori' => ['required', 'string', 'max:100'],
            'source' => ['nullable', 'string', 'max:100'],
            'impact_area' => ['nullable', 'string', 'max:255'],
            'prioritas' => ['nullable', 'string', 'max:50'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'waktu_kejadian' => ['nullable', 'date'],
            'bukti' => ['nullable', 'file', 'max:2048', 'mimes:pdf,jpg,jpeg,png,zip,doc,docx,csv'],
        ]);

        $path = null;
        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('incident-evidence', 'public');
        }

        $report = IncidentReport::create([
            'nama' => $validated['nama'],
            'instansi' => $validated['instansi'],
            'email' => $validated['email'],
            'telepon' => $validated['telepon'] ?? null,
            'kategori' => $validated['kategori'],
            'source' => $validated['source'] ?? 'Portal Laporan',
            'impact_area' => $validated['impact_area'] ?? null,
            'waktu_kejadian' => $validated['waktu_kejadian'] ?? null,
            'prioritas' => $validated['prioritas'] ?? 'Normal',
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'bukti_path' => $path,
            'status' => 'new',
            'timeline' => [[
                'stage' => 'Laporan Diterima',
                'message' => 'Laporan insiden berhasil masuk ke sistem CSIRT Kota Depok dan menunggu triase awal.',
                'at' => now()->toDateTimeString(),
            ]],
        ]);

        try {
            Mail::to($report->email)->send(new IncidentReportReceived($report));
        } catch (\Throwable $exception) {
            // Log the notification failure without breaking the flow for the reporter.
        }

        return redirect()->route('incident.report.success')->with('success', 'Laporan insiden berhasil dikirim. Nomor tiket Anda: ' . $report->ticket_number)->with('ticket_number', $report->ticket_number);
    }

    public function success()
    {
        return view('public.incident-report-success');
    }

    public function tracking(Request $request)
    {
        $ticket = trim((string) $request->query('ticket', ''));
        $report = $ticket !== '' ? IncidentReport::where('ticket_number', strtoupper($ticket))->first() : null;

        return view('public.incident-report-status', compact('report', 'ticket'));
    }

    public function showStatus(string $ticket)
    {
        $report = IncidentReport::where('ticket_number', strtoupper($ticket))->firstOrFail();

        return view('public.incident-report-status', compact('report', 'ticket'));
    }
}
