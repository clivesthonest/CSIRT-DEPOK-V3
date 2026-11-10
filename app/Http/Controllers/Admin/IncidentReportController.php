<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncidentReport;
use Illuminate\Http\Request;

class IncidentReportController extends Controller
{
    private function buildQuery(Request $request)
    {
        $query = IncidentReport::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', '%' . $search . '%')
                  ->orWhere('judul', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%')
                  ->orWhere('instansi', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->input('prioritas'));
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        if ($request->filled('instansi')) {
            $query->where('instansi', 'like', '%' . $request->input('instansi') . '%');
        }

        return $query;
    }

    public function index(Request $request)
    {
        $query = $this->buildQuery($request);
        $reports = $query->latest()->paginate(10)->appends($request->query());

        $filterCategories = IncidentReport::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori')->filter();
        $filterPriorities = IncidentReport::select('prioritas')->distinct()->orderBy('prioritas')->pluck('prioritas')->filter();
        $filterStatuses = IncidentReport::select('status')->distinct()->orderBy('status')->pluck('status')->filter();
        $filterInstansi = IncidentReport::select('instansi')->distinct()->orderBy('instansi')->pluck('instansi')->filter();

        return view('admin.incidents.index', compact('reports', 'filterCategories', 'filterPriorities', 'filterStatuses', 'filterInstansi'));
    }

    public function exportCsv(Request $request)
    {
        $reports = $this->buildQuery($request)->latest()->get();
        $filename = 'laporan-insiden-csirt-' . now()->format('Ymd_His') . '.csv';
        $headers = ['Nomor Ticket', 'Judul', 'Pelapor', 'Instansi', 'Kategori', 'Prioritas', 'Status', 'Waktu Kejadian', 'Tanggal Lapor'];

        $callback = function () use ($reports, $headers) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, $headers, ';');

            foreach ($reports as $report) {
                fputcsv($handle, [
                    $report->ticket_number ?? '-',
                    $report->judul ?? '-',
                    $report->nama ?? '-',
                    $report->instansi ?? '-',
                    $report->kategori ?? '-',
                    $report->prioritas ?? 'Normal',
                    $report->status ?? '-',
                    $report->waktu_kejadian ? $report->waktu_kejadian : '-',
                    $report->created_at ? $report->created_at->format('d-m-Y H:i') : '-',
                ], ';');
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'Pragma' => 'no-cache',
        ]);
    }

    public function exportPdf(Request $request)
    {
        $reports = $this->buildQuery($request)->latest()->get();
        $pdfContent = $this->buildPdfDocument($reports);

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="laporan-insiden-csirt-' . now()->format('Ymd_His') . '.pdf"',
        ]);
    }

    protected function buildPdfDocument($reports): string
    {
        $lines = [
            'LAPORAN INSIDEN CSIRT KOTA DEPOK',
            'Tanggal generate: ' . now()->translatedFormat('d F Y H:i'),
            '',
        ];

        foreach ($reports as $index => $report) {
            $lines[] = sprintf('%d. %s | %s | %s | %s | %s', $index + 1, $report->ticket_number ?? '-', $report->judul ?? '-', $report->status ?? '-', $report->prioritas ?? 'Normal', $report->instansi ?? '-');
            $lines[] = '   Pelapor: ' . ($report->nama ?? '-') . ' | Email: ' . ($report->email ?? '-') . ' | Kategori: ' . ($report->kategori ?? '-');
            $lines[] = '   Waktu kejadian: ' . ($report->waktu_kejadian ?? '-') . ' | Tanggal masuk: ' . ($report->created_at ? $report->created_at->format('d-m-Y H:i') : '-');
            $lines[] = '';
        }

        if ($reports->isEmpty()) {
            $lines[] = 'Tidak ada data laporan insiden pada filter yang dipilih.';
        }

        $stream = "BT\n/F1 16 Tf\n50 790 Td\n(" . $this->escapePdfText($lines[0]) . ") Tj\nET\n";
        $y = 760;

        for ($i = 1; $i < count($lines); $i++) {
            $line = $lines[$i];
            if ($y < 40) {
                break;
            }

            $stream .= "BT\n/F1 10 Tf\n50 {$y} Td\n(" . $this->escapePdfText($line) . ") Tj\nET\n";
            $y -= 16;
        }

        $objects = [
            "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n",
            "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n",
            "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n",
            "4 0 obj\n<< /Length " . strlen($stream) . " >>\nstream\n" . $stream . "endstream\nendobj\n",
            "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object;
        }

        $xrefStart = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        foreach ($offsets as $offset) {
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }

        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n{$xrefStart}\n%%EOF";

        return $pdf;
    }

    protected function escapePdfText(string $text): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }

    public function show(IncidentReport $incident)
    {
        return view('admin.incidents.show', compact('incident'));
    }

    public function update(Request $request, IncidentReport $incident)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,investigating,waiting_for_customer,resolved,rejected'],
            'triage_status' => ['nullable', 'string', 'max:255'],
            'validation_status' => ['nullable', 'string', 'max:255'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $incident->fill($validated);
        $incident->last_status_update = now()->toDateTimeString();
        $incident->save();

        $statusLabels = [
            'new' => 'Diterima',
            'investigating' => 'Sedang Ditinjau',
            'waiting_for_customer' => 'Menunggu Respon Pelapor',
            'resolved' => 'Selesai',
            'rejected' => 'Ditolak',
        ];

        $timelineMessage = 'Status laporan diperbarui menjadi ' . ($statusLabels[$validated['status']] ?? ucfirst($validated['status'])) . '.';

        if (!empty($validated['triage_status'])) {
            $incident->triage_status = $validated['triage_status'];
            $incident->addTimeline('Triase', $validated['triage_status']);
        }

        if (!empty($validated['validation_status'])) {
            $incident->validation_status = $validated['validation_status'];
            $incident->addTimeline('Validasi', $validated['validation_status']);
        }

        if (!empty($validated['admin_notes'])) {
            $incident->addTimeline('Catatan Admin', $validated['admin_notes']);
        }

        $incident->addTimeline('Status', $timelineMessage);
        $incident->save();

        return redirect()->route('admin.incidents.show', $incident)->with('success', 'Status laporan insiden berhasil diperbarui.');
    }
}
