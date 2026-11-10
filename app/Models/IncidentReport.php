<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'instansi',
        'email',
        'telepon',
        'kategori',
        'source',
        'impact_area',
        'waktu_kejadian',
        'prioritas',
        'judul',
        'deskripsi',
        'bukti_path',
        'status',
        'ticket_number',
        'triage_status',
        'validation_status',
        'admin_notes',
        'timeline',
        'last_status_update',
    ];

    protected $casts = [
        'timeline' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $report): void {
            $report->ticket_number ??= self::generateTicketNumber();
            $report->status ??= 'new';
            $report->last_status_update ??= now()->toDateTimeString();
            $report->timeline = self::normalizeTimeline($report->timeline ?: [
                [
                    'stage' => 'Laporan Diterima',
                    'message' => 'Laporan insiden berhasil diterima oleh CSIRT Kota Depok.',
                    'at' => now()->toDateTimeString(),
                ],
            ]);
        });
    }

    public static function generateTicketNumber(): string
    {
        $dateKey = now()->format('Ymd');
        $sequence = self::whereDate('created_at', now()->toDateString())->count() + 1;

        return sprintf('INC-%s-%04d', $dateKey, $sequence);
    }

    public static function normalizeTimeline($timeline): array
    {
        if (empty($timeline)) {
            return [];
        }

        if (is_string($timeline)) {
            $decoded = json_decode($timeline, true);

            return is_array($decoded) ? $decoded : [];
        }

        return is_array($timeline) ? $timeline : [$timeline];
    }

    public function addTimeline(string $stage, string $message): void
    {
        $entries = self::normalizeTimeline($this->timeline);
        $entries[] = [
            'stage' => $stage,
            'message' => $message,
            'at' => now()->toDateTimeString(),
        ];

        $this->timeline = $entries;
        $this->last_status_update = now()->toDateTimeString();
        $this->saveQuietly();
    }
}
