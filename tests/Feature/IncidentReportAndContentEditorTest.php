<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncidentReportAndContentEditorTest extends TestCase
{
    use RefreshDatabase;

    public function test_incident_report_can_be_submitted_and_stored(): void
    {
        $response = $this->post(route('incident.report.store'), [
            'nama' => 'Asep Pratama',
            'instansi' => 'Dinas Kominfo',
            'email' => 'asep@example.com',
            'telepon' => '081234567890',
            'kategori' => 'Phishing',
            'prioritas' => 'Tinggi',
            'judul' => 'Email phishing internal',
            'deskripsi' => 'Seseorang mengirim email berisi link mencurigakan ke staff.',
        ]);

        $response->assertRedirect(route('incident.report.success'));

        $report = \App\Models\IncidentReport::query()->first();

        $this->assertNotNull($report->ticket_number);
        $this->assertSame('new', $report->status);
        $this->assertNotEmpty($report->timeline);
        $this->assertDatabaseHas('incident_reports', [
            'nama' => 'Asep Pratama',
            'judul' => 'Email phishing internal',
            'kategori' => 'Phishing',
            'status' => 'new',
        ]);
    }

    public function test_public_can_lookup_report_status_by_ticket_number(): void
    {
        $report = \App\Models\IncidentReport::create([
            'nama' => 'Budi Santoso',
            'instansi' => 'Dinas Kominfo',
            'email' => 'budi@example.com',
            'telepon' => '081298765432',
            'kategori' => 'Malware',
            'prioritas' => 'Tinggi',
            'judul' => 'Malware di workstation',
            'deskripsi' => 'Workstation menunjukkan aktivitas mencurigakan.',
            'ticket_number' => 'INC-2026-0001',
            'status' => 'investigating',
            'timeline' => json_encode([
                ['stage' => 'Diterima', 'message' => 'Laporan berhasil masuk ke CSIRT', 'at' => now()->toDateTimeString()],
            ]),
        ]);

        $this->get(route('incident.report.status', ['ticket' => $report->ticket_number]))
            ->assertOk()
            ->assertSee('INC-2026-0001')
            ->assertSee('Malware di workstation');
    }

    public function test_admin_can_view_incident_detail_and_update_status(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $report = \App\Models\IncidentReport::create([
            'nama' => 'Rina Dewi',
            'instansi' => 'Bagian IT',
            'email' => 'rina@example.com',
            'telepon' => '081200000000',
            'kategori' => 'Malware',
            'prioritas' => 'Tinggi',
            'judul' => 'Deteksi malware di server',
            'deskripsi' => 'Server menunjukkan proses mencurigakan.',
            'status' => 'new',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.incidents.show', $report))
            ->assertOk()
            ->assertSee('Deteksi malware di server');

        $this->actingAs($admin)
            ->put(route('admin.incidents.update', $report), [
                'status' => 'investigating',
                'triage_status' => 'Triage selesai',
                'validation_status' => 'Validasi awal berhasil',
                'admin_notes' => 'Tim sedang melakukan triase dan isolasi host.',
            ])
            ->assertRedirect(route('admin.incidents.show', $report));

        $this->assertDatabaseHas('incident_reports', [
            'id' => $report->id,
            'status' => 'investigating',
            'triage_status' => 'Triage selesai',
            'validation_status' => 'Validasi awal berhasil',
            'admin_notes' => 'Tim sedang melakukan triase dan isolasi host.',
        ]);
    }

    public function test_admin_can_update_public_content_settings(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $this->actingAs($admin)
            ->put(route('admin.site-settings.update'), [
                'profile_intro' => 'Layanan CSIRT Kota Depok',
                'contact_email' => 'info@depok.go.id',
                'contact_phone' => '081212121212',
            ])
            ->assertRedirect(route('admin.site-settings.edit'));

        $this->assertSame('Layanan CSIRT Kota Depok', SiteSetting::getValue('profile_intro'));
        $this->assertSame('info@depok.go.id', SiteSetting::getValue('contact_email'));
    }
}
