@php
    $guideIntro = \App\Models\SiteSetting::getValue('guide_intro', 'Panduan dan dokumen pendukung membantu pengguna memahami kebijakan serta tata cara keamanan siber.');
@endphp

@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="container">
        @include('components.public-page-header', [
            'icon' => 'book-open',
            'badge' => 'Panduan',
            'title' => 'Panduan & Dokumen Pendukung',
            'subtitle' => $guideIntro
        ])

        <div class="page-grid">
            <div class="page-card">
                <div class="info-chip mb-3"><i class='bx bx-code-alt me-1'></i> Panduan Teknis</div>
                <ul class="page-list">
                    <li>Pedoman keamanan perangkat dan infrastruktur layanan publik.</li>
                    <li>Prosedur validasi keamanan aplikasi berbasis web dan sistem informasi.</li>
                    <li>Panduan pencegahan serangan credential stuffing, phishing, dan malware.</li>
                    <li>Persyaratan keamanan update aplikasi dan pemeliharaan server.</li>
                </ul>
            </div>

            <div class="page-card">
                <div class="info-chip mb-3"><i class='bx bx-group me-1'></i> Panduan Nonteknis</div>
                <ul class="page-list">
                    <li>Kesadaran keamanan siber bagi pegawai dan stakeholder pemerintah.</li>
                    <li>Pedoman pelaporan kejadian keamanan siber secara aman dan cepat.</li>
                    <li>Penetapan peran tim internal dan koordinasi peristiwa keamanan.</li>
                    <li>Dokumen lampiran untuk penggunaan sistem informasi dan email resmi.</li>
                </ul>
            </div>
        </div>

        <div class="page-card mt-4">
            <div class="info-chip mb-3"><i class='bx bx-paperclip me-1'></i> Lampiran</div>
            <ul class="page-list">
                <li>Template pelaporan insiden.</li>
                <li>Daftar kontak internal dan eksternal CSIRT.</li>
                <li>Dokumen SOP operasional.</li>
                <li>Arsip advisori keamanan dan himbauan keamanan.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
