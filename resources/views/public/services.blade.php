@php
    $servicesIntro = \App\Models\SiteSetting::getValue('services_intro', 'Layanan CSIRT mencakup pemantauan, triase, koordinasi, dan pemulihan insiden keamanan siber.');
    $contactEmail = \App\Models\SiteSetting::getValue('contact_email', 'csirt@depok.go.id');
@endphp

@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="container">
        @include('components.public-page-header', [
            'icon' => 'cog',
            'badge' => 'Layanan',
            'title' => 'Layanan CSIRT Kota Depok',
            'subtitle' => $servicesIntro
        ])

        <div class="page-grid">
            <div class="page-card">
                <div class="info-chip mb-3"><i class='bx bx-briefcase-alt-2 me-1'></i> Deskripsi Layanan</div>
                <ul class="page-list">
                    <li>Penanganan insiden keamanan siber untuk instansi dan layanan publik Kota Depok.</li>
                    <li>Analisis awal dampak insiden terhadap data, layanan, dan infrastruktur.</li>
                    <li>Koordinasi dan bimbingan teknis pemulihan pasca insiden.</li>
                    <li>Advisori keamanan dan laporan situasi keamanan digital secara periodik.</li>
                </ul>
            </div>

            <div class="page-card">
                <div class="info-chip mb-3"><i class='bx bx-user-check me-1'></i> Sasaran Layanan</div>
                <ul class="page-list">
                    <li>Instansi pemerintah daerah dan unit kerja penyelenggara layanan.</li>
                    <li>Operator sistem, admin aplikasi, dan pengelola data pemerintah.</li>
                    <li>Pengguna layanan publik yang membutuhkan arahan keamanan siber.</li>
                    <li>Stakeholder eksternal dalam koordinasi penanganan insiden.</li>
                </ul>
            </div>
        </div>

        <div class="page-card mt-4">
            <div class="info-chip mb-3"><i class='bx bx-support me-1'></i> Kanal & Jam Layanan</div>
            <div class="contact-stack">
                <div class="contact-item">
                    <i class='bx bx-envelope-open'></i>
                    <div>
                        <strong class="text-white d-block">Kanal utama</strong>
                        <span class="text-white-50">Email keamanan: {{ $contactEmail }}</span>
                    </div>
                </div>
                <div class="contact-item">
                    <i class='bx bx-time-five'></i>
                    <div>
                        <strong class="text-white d-block">Jam operasional</strong>
                        <span class="text-white-50">Senin-Jumat, 08.00-16.00 WIB, dengan prioritas penanganan saat insiden aktif.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
