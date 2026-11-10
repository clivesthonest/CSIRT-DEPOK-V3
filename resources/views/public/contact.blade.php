@php
    $contactIntro = \App\Models\SiteSetting::getValue('contact_intro', 'Gunakan kanal komunikasi resmi untuk pelaporan insiden dan konsultasi keamanan siber.');
    $contactEmail = \App\Models\SiteSetting::getValue('contact_email', 'csirt@depok.go.id');
    $contactPhone = \App\Models\SiteSetting::getValue('contact_phone', '089515957800');
@endphp

@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="container">
        @include('components.public-page-header', [
            'icon' => 'envelope',
            'badge' => 'Kontak',
            'title' => 'Kontak Resmi CSIRT Kota Depok',
            'subtitle' => $contactIntro
        ])

        <div class="page-grid">
            <div class="page-card">
                <div class="info-chip mb-3"><i class='bx bx-chat me-1'></i> Kanal Komunikasi</div>
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
                            <span class="text-white-50">Jl. Margonda Raya No. 54, Kota Depok</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-card">
                <div class="info-chip mb-3"><i class='bx bx-info-circle me-1'></i> Petunjuk Penggunaan</div>
                <ul class="page-list">
                    <li>Gunakan email resmi untuk konsultasi umum dan pengiriman dokumen pendukung.</li>
                    <li>Laporkan insiden dengan menyertakan subjek jelas, kronologi kejadian, dan bukti awal.</li>
                    <li>Hindari pengiriman informasi sensitif melalui kanal yang tidak resmi.</li>
                    <li>Untuk kebutuhan prioritas, dapat menggunakan kanal telepon sesuai jam operasional.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
