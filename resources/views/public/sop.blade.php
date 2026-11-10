@php
    $sopIntro = \App\Models\SiteSetting::getValue('sop_intro', 'SOP pelaporan dan penerbitan sertifikat disusun untuk memastikan proses penanganan insiden berjalan secara tertib dan terdokumentasi.');
@endphp

@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="container">
        @include('components.public-page-header', [
            'icon' => 'book',
            'badge' => 'SOP & Sertifikat',
            'title' => 'SOP Pelaporan & Penerbitan Sertifikat',
            'subtitle' => $sopIntro
        ])

        <div class="page-grid">
            <div class="page-card">
                <div class="info-chip mb-3"><i class='bx bx-list-check me-1'></i> SOP Pelaporan</div>
                <ul class="page-list">
                    <li>Pelapor mengisi form intake dengan data lengkap dan bukti awal.</li>
                    <li>CSIRT melakukan triase dan verifikasi terhadap tingkat urgensi kejadian.</li>
                    <li>Tim analisis menyusun langkah penanganan dan jadwal koordinasi.</li>
                    <li>Hasil penanganan diberitahukan kepada instansi terkait dan pemangku kepentingan.</li>
                </ul>
            </div>

            <div class="page-card">
                <div class="info-chip mb-3"><i class='bx bx-award me-1'></i> Penerbitan Sertifikat</div>
                <ul class="page-list">
                    <li>Sertifikat diterbitkan setelah proses validasi dan penutupan insiden selesai.</li>
                    <li>Pengajuan sertifikat disesuaikan dengan jenis layanan, dampak, dan status penanganan.</li>
                    <li>Dokumen pendukung dapat diunduh untuk keperluan administrasi internal atau eksternal.</li>
                    <li>Rekaman status dan riwayat dokumen dipelihara untuk audit dan transparansi.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
