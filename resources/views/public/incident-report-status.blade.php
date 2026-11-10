@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="container">
        <div class="page-card mx-auto" style="max-width: 980px;">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="info-icon"><i class='bx bx-search-alt-2'></i></div>
                <div>
                    <div class="info-chip mb-2"><i class='bx bx-shield-alt-2 me-1'></i> Status Laporan Saya</div>
                    <h1 class="h2 mb-0 text-white">Pantau perkembangan laporan insiden Anda</h1>
                </div>
            </div>

            <div class="ticket-status-search mb-4">
                <form action="{{ route('incident.report.tracking') }}" method="GET" class="ticket-status-form">
                    <div class="ticket-search-field">
                        <label for="ticket" class="form-label text-white-50">Nomor tiket</label>
                        <input id="ticket" type="text" name="ticket" value="{{ request('ticket') }}" placeholder="Contoh: INC-20261107-0001" required>
                    </div>
                    <div class="ticket-search-action">
                        <button type="submit" class="btn btn-cyber-red">Cari</button>
                    </div>
                </form>
            </div>

            @if($report)
                <div class="row g-4 mt-2">
                    <div class="col-lg-5">
                        <div class="page-card official-ticket-box">
                            <div class="small text-uppercase text-white-50 mb-2">Nomor tiket</div>
                            <h3 class="text-white mb-3">{{ $report->ticket_number }}</h3>

                            <div class="mb-3">
                                <div class="small text-uppercase text-white-50 mb-1">Status laporan</div>
                                <span class="admin-badge {{ $report->status === 'new' ? 'warning' : ($report->status === 'resolved' ? 'success' : ($report->status === 'rejected' ? 'danger' : 'secondary')) }}">
                                    {{ $report->status }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <div class="small text-uppercase text-white-50 mb-1">Judul</div>
                                <p class="mb-0 text-white">{{ $report->judul }}</p>
                            </div>

                            <div class="mb-3">
                                <div class="small text-uppercase text-white-50 mb-1">Pelapor</div>
                                <p class="mb-0 text-white-50">{{ $report->nama }} / {{ $report->instansi }}</p>
                            </div>

                            <div class="mb-3">
                                <div class="small text-uppercase text-white-50 mb-1">Kategori & prioritas</div>
                                <p class="mb-0 text-white-50">{{ $report->kategori }} • {{ $report->prioritas ?? 'Normal' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="page-card official-ticket-box">
                            <div class="small text-uppercase text-white-50 mb-3">Log perkembangan</div>

                            @forelse($report->timeline ?? [] as $entry)
                                <div class="official-timeline-row">
                                    <div class="official-timeline-dot"></div>
                                    <div class="official-timeline-content">
                                        <div class="official-timeline-title">
                                            {{ data_get($entry, 'stage', 'Update') }}
                                            <span>{{ data_get($entry, 'at') }}</span>
                                        </div>
                                        <p>{{ data_get($entry, 'message') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-white-50 mb-0">Belum ada log perkembangan untuk laporan ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @elseif(request('ticket'))
                <div class="alert alert-warning mt-4 mb-0">
                    Nomor tiket <strong>{{ request('ticket') }}</strong> tidak ditemukan atau belum terdaftar pada sistem CSIRT.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
