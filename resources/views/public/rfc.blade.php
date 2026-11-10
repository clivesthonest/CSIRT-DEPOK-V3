@php
    $rfcIntro = \App\Models\SiteSetting::getValue('rfc_intro', 'Dokumen resmi yang menjelaskan cakupan, kontak, layanan, dan prosedur operasional CSIRT Kota Depok.');
@endphp

@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="container">
        @include('components.public-page-header', [
            'icon' => 'file',
            'badge' => 'RFC 2350',
            'title' => 'RFC 2350 CSIRT Kota Depok',
            'subtitle' => $rfcIntro
        ])

        <div class="page-grid">
            <div class="page-card">
                <div class="info-chip mb-3"><i class='bx bx-book-content me-1'></i> Informasi Umum</div>
                <ul class="page-list">
                    <li>Nama unit: CSIRT Kota Depok.</li>
                    <li>Jenis organisasi: tim penanggulangan insiden siber pemerintah daerah.</li>
                    <li>Area layanan: infrastruktur digital, aplikasi layanan publik, dan data pemerintahan.</li>
                    <li>Metode komunikasi: email resmi, kanal kontak prioritas, dan koordinasi operasional internal.</li>
                </ul>
            </div>

            <div class="page-card">
                <div class="info-chip mb-3"><i class='bx bx-history me-1'></i> Riwayat Versi</div>
                <ul class="page-list">
                    <li>Versi 1.0 - Penerbitan dokumen awal.</li>
                    <li>Versi 1.1 - Penyesuaian kontak dan layanan operasional.</li>
                    <li>Versi 1.2 - Penyempurnaan SOP dan alur koordinasi incident response.</li>
                    <li>Versi aktif - Dokumentasi yang digunakan sebagai referensi layanan CSIRT.</li>
                </ul>
            </div>
        </div>

        <div class="page-card mt-4">
            <div class="info-chip mb-3"><i class='bx bx-download me-1'></i> Dokumen Tersedia</div>
            <div class="contact-stack">
                <div class="contact-item">
                    <i class='bx bx-file-pdf'></i>
                    <div>
                        <strong class="text-white d-block">RFC 2350</strong>
                        <span class="text-white-50">Dokumen resmi saat ini dalam format PDF untuk diunduh dan dibagikan internal maupun eksternal.</span>
                    </div>
                </div>
                <div class="contact-item">
                    <i class='bx bx-file-doc'></i>
                    <div>
                        <strong class="text-white d-block">Versi dokumen</strong>
                        <span class="text-white-50">Dapat ditinjau ulang pada saat ada perubahan kebijakan, layanan, atau koordinasi operasional.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
