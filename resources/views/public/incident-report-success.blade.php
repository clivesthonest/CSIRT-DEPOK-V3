@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="container">
        <div class="page-card mx-auto" style="max-width: 760px;">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="info-icon"><i class='bx bx-check-shield'></i></div>
                <div>
                    <div class="info-chip mb-2"><i class='bx bx-badge-check me-1'></i> Laporan Diterima</div>
                    <h1 class="h2 mb-0 text-white">Terima kasih, laporan Anda telah berhasil dikirim.</h1>
                </div>
            </div>

            <p class="text-white-50 mb-4">
                Tim CSIRT Kota Depok akan menindaklanjuti laporan Anda sesuai prioritas dan kebutuhan penanganan insiden.
            </p>

            @if (session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif

            @if (session('ticket_number'))
                <div class="alert alert-info mb-4">
                    Nomor tiket Anda: <strong>{{ session('ticket_number') }}</strong>
                </div>
            @endif

            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('incident.report.tracking') }}?ticket={{ urlencode(session('ticket_number') ?? '') }}" class="btn btn-cyber-red">Lihat Status Laporan</a>
                <a href="{{ route('home') }}" class="btn btn-cyber-outline">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection
