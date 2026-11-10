@php
    $profileIntro = \App\Models\SiteSetting::getValue('profile_intro', 'CSIRT Kota Depok berperan dalam mendukung keamanan siber di lingkungan Pemerintah Kota Depok melalui deteksi dini, koordinasi, dan pemulihan insiden keamanan siber yang berdampak pada layanan publik, infrastruktur digital, serta data pemerintah.');
    $contactEmail = \App\Models\SiteSetting::getValue('contact_email', 'csirt@depok.go.id');
    $contactPhone = \App\Models\SiteSetting::getValue('contact_phone', '089515957800');
@endphp

@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="container">
        @include('components.public-page-header', [
            'icon' => 'shield-quarter',
            'badge' => 'Profil CSIRT',
            'title' => 'Profil CSIRT Kota Depok',
            'subtitle' => 'Mandat, struktur organisasi, dan saluran komunikasi resmi yang menjadi rujukan penanganan insiden siber.'
        ])

        <div class="page-grid">
            <div class="page-card">
                <div class="info-chip mb-3"><i class='bx bx-target-lock me-1'></i> Mandat</div>
                <p class="text-white-50">{{ $profileIntro }}</p>
                <ul class="page-list">
                    <li>Melakukan pemantauan dan deteksi dini terhadap ancaman keamanan siber.</li>
                    <li>Memberikan koordinasi teknis terhadap penanggulangan insiden pada instansi/layanan publik.</li>
                    <li>Mendorong penerapan standar keamanan siber sesuai prinsip keamanan dan kesiapsiagaan.</li>
                    <li>Memberikan edukasi dan advisori keamanan untuk memperkuat tata kelola keamanan informasi.</li>
                </ul>
            </div>

            <div class="page-card">
                <div class="info-chip mb-3"><i class='bx bx-sitemap me-1'></i> Struktur</div>
                <ul class="feature-list">
                    <li>Koordinator CSIRT: memimpin arah operasional dan koordinasi lintas unit.</li>
                    <li>Tim Analisis & Tanggap Insiden: menangani monitoring, triase, dan investigasi insiden.</li>
                    <li>Tim Komunikasi & Advokasi: menjalankan edukasi, komunikasi, dan koordinasi eksternal.</li>
                    <li>Tim Pengelola Dokumen & SOP: memastikan kelengkapan SOP, dokumen, dan kebijakan operasional.</li>
                </ul>
            </div>
        </div>

        <div class="page-card mt-4">
            <div class="info-chip mb-3"><i class='bx bx-phone-call me-1'></i> Kontak Resmi</div>
            <div class="contact-stack">
                <div class="contact-item">
                    <i class='bx bx-envelope'></i>
                    <div>
                        <strong class="text-white d-block">Email</strong>
                        <span class="text-white-50">{{ $contactEmail }}</span>
                    </div>
                </div>
                <div class="contact-item">
                    <i class='bx bx-phone'></i>
                    <div>
                        <strong class="text-white d-block">Telepon</strong>
                        <span class="text-white-50">{{ $contactPhone }}</span>
                    </div>
                </div>
                <div class="contact-item">
                    <i class='bx bx-map'></i>
                    <div>
                        <strong class="text-white d-block">Alamat</strong>
                        <span class="text-white-50">Jl. Margonda Raya No. 54, Kota Depok, Jawa Barat</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
