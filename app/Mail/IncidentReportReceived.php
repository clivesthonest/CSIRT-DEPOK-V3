<?php

namespace App\Mail;

use App\Models\IncidentReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class IncidentReportReceived extends Mailable
{
    use Queueable;

    public function __construct(public IncidentReport $report)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Laporan Insiden Anda telah diterima - ' . $this->report->ticket_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.incident-received',
            with: [
                'report' => $this->report,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
