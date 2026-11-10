@extends('layouts.app')

@section('content')
<div class="admin-dashboard-page admin-overview-page">
    <div class="container admin-dashboard-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <div class="admin-brand-icon"><i class='bx bx-shield-quarter'></i></div>
                <div>
                    <h4>CSIRT Admin</h4>
                    <small class="text-white-50">Operasional Harian</small>
                </div>
            </div>

            <ul class="admin-menu">
                <li><a href="{{ route('admin.dashboard') }}"><i class='bx bx-grid-alt'></i>Overview</a></li>
                <li><a href="{{ route('admin.daily-summary') }}" class="active"><i class='bx bx-calendar-star'></i>Ringkasan Harian</a></li>
                <li><a href="{{ route('admin.incidents.index') }}"><i class='bx bx-error-circle'></i>Laporan Insiden</a></li>
                <li><a href="{{ route('admin.site-settings.edit') }}"><i class='bx bx-cog'></i>Halaman Publik</a></li>
                <li><a href="{{ route('home') }}"><i class='bx bx-arrow-back'></i>Kembali ke Website</a></li>
            </ul>
        </aside>

        <main class="admin-main">
            <div class="admin-topbar official-topbar">
                <div>
                    <span class="cyber-badge"><span class="pulse-dot"></span> Ringkasan Operasional</span>
                    <h2 class="mt-3">Ringkasan Harian CSIRT</h2>
                </div>
                <div class="admin-header-actions">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-cyber-outline btn-sm">Kembali ke Dashboard</a>
                </div>
            </div>

            <div class="daily-summary-toolbar">
                <form method="GET" action="{{ route('admin.daily-summary') }}" class="daily-filter-form">
                    <label for="date">Tanggal</label>
                    <input id="date" type="date" name="date" value="{{ $selectedDate }}">
                    <button type="submit" class="btn btn-cyber-red btn-sm">Tampilkan</button>
                </form>
            </div>

            <section class="admin-metrics">
                <div class="admin-metric metric-blue">
                    <div class="admin-metric-top">
                        <div>
                            <div class="admin-metric-label">Total laporan</div>
                            <div class="admin-metric-value">{{ $dailyReports->count() }}</div>
                        </div>
                        <div class="admin-metric-icon"><i class='bx bx-file'></i></div>
                    </div>
                    <div class="admin-metric-note">Pada {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</div>
                </div>

                <div class="admin-metric metric-purple">
                    <div class="admin-metric-top">
                        <div>
                            <div class="admin-metric-label">Masih aktif</div>
                            <div class="admin-metric-value">{{ $openReports }}</div>
                        </div>
                        <div class="admin-metric-icon"><i class='bx bx-timer'></i></div>
                    </div>
                    <div class="admin-metric-note">Belum selesai ditangani</div>
                </div>

                <div class="admin-metric metric-red">
                    <div class="admin-metric-top">
                        <div>
                            <div class="admin-metric-label">Prioritas kritis</div>
                            <div class="admin-metric-value">{{ $criticalReports }}</div>
                        </div>
                        <div class="admin-metric-icon"><i class='bx bx-error-alt'></i></div>
                    </div>
                    <div class="admin-metric-note">Segera ditindaklanjuti</div>
                </div>

                <div class="admin-metric metric-green">
                    <div class="admin-metric-top">
                        <div>
                            <div class="admin-metric-label">Tertutup hari ini</div>
                            <div class="admin-metric-value">{{ $resolvedReports }}</div>
                        </div>
                        <div class="admin-metric-icon"><i class='bx bx-check-circle'></i></div>
                    </div>
                    <div class="admin-metric-note">Laporan selesai</div>
                </div>
            </section>

            <section class="summary-grid">
                <div class="admin-panel summary-panel">
                    <div class="panel-heading-row">
                        <h3>Status operasional</h3>
                        <span class="small text-white-50">Tiket hari ini</span>
                    </div>

                    <div class="status-breakdown">
                        @foreach($statusBreakdown as $key => $value)
                            @php
                                $label = [
                                    'new' => 'Baru',
                                    'investigating' => 'Diselidiki',
                                    'waiting_for_customer' => 'Menunggu Pelapor',
                                    'resolved' => 'Selesai',
                                    'rejected' => 'Ditolak',
                                ][$key] ?? ucfirst($key);
                            @endphp
                            <div class="breakdown-item">
                                <div class="breakdown-label">{{ $label }}</div>
                                <div class="breakdown-value">{{ $value }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="admin-panel summary-panel">
                    <div class="panel-heading-row">
                        <h3>Distribusi kategori</h3>
                        <span class="small text-cyber-cyan">Per kategori</span>
                    </div>

                    <div class="category-list">
                        @forelse($categoryBreakdown as $item)
                            <div class="category-item">
                                <div class="category-name">{{ $item['label'] }}</div>
                                <div class="category-bar-wrap">
                                    <span class="category-bar" style="width: {{ $dailyReports->count() > 0 ? min(100, ($item['count'] / $dailyReports->count()) * 100) : 0 }}%"></span>
                                </div>
                                <div class="category-count">{{ $item['count'] }}</div>
                            </div>
                        @empty
                            <div class="text-white-50 py-3">Belum ada kategori untuk tanggal ini.</div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="admin-panel summary-panel mt-4">
                <div class="panel-heading-row">
                    <h3>Aktivitas terbaru</h3>
                    <span class="small text-white-50">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</span>
                </div>

                <div class="table-responsive">
                    <table class="table admin-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Ticket</th>
                                <th>Judul</th>
                                <th>Instansi</th>
                                <th>Prioritas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities as $report)
                                <tr>
                                    <td><a href="{{ route('admin.incidents.show', $report) }}" class="text-cyber-cyan text-decoration-none">{{ $report->ticket_number }}</a></td>
                                    <td>{{ $report->judul }}</td>
                                    <td>{{ $report->instansi }}</td>
                                    <td>{{ $report->prioritas ?? 'Normal' }}</td>
                                    <td><span class="admin-badge {{ $report->status === 'new' ? 'warning' : ($report->status === 'resolved' ? 'success' : ($report->status === 'rejected' ? 'danger' : 'secondary')) }}">{{ $report->status }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-white-50 py-3">Tidak ada aktivitas pada tanggal ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</div>

<style>
    .daily-summary-toolbar {
        background: rgba(9, 18, 33, 0.88);
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 16px;
        padding: 1rem 1.1rem;
        margin-bottom: 1.2rem;
    }

    .daily-filter-form {
        display: flex;
        align-items: end;
        gap: 12px;
        flex-wrap: wrap;
    }

    .daily-filter-form label {
        color: rgba(255,255,255,0.7);
        font-size: 0.72rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .daily-filter-form input {
        min-width: 200px;
        border: 1px solid rgba(148, 163, 184, 0.22);
        background: rgba(15, 23, 42, 0.9);
        color: white;
        border-radius: 10px;
        padding: 0.7rem 0.8rem;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .status-breakdown {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .breakdown-item {
        background: rgba(15, 23, 42, 0.68);
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 12px;
        padding: 12px 14px;
    }

    .breakdown-label {
        font-size: 0.72rem;
        letter-spacing: 0.06em;
        color: rgba(255,255,255,0.7);
        text-transform: uppercase;
    }

    .breakdown-value {
        font-size: 1.65rem;
        font-weight: 700;
        color: white;
        margin-top: 0.3rem;
    }

    .category-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .category-item {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 2fr) auto;
        gap: 10px;
        align-items: center;
    }

    .category-name {
        color: rgba(255,255,255,0.82);
        font-weight: 600;
    }

    .category-bar-wrap {
        width: 100%;
        height: 10px;
        border-radius: 999px;
        background: rgba(148, 163, 184, 0.12);
        overflow: hidden;
    }

    .category-bar {
        display: block;
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #50d7ff, #78f1c7);
    }

    .category-count {
        color: var(--cyber-cyan);
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .summary-grid {
            grid-template-columns: 1fr;
        }

        .status-breakdown {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
