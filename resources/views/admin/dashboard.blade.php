@extends('layouts.app')

@section('content')
<div class="admin-dashboard-page admin-overview-page">
    <div class="container admin-dashboard-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <div class="admin-brand-icon"><i class='bx bx-shield-quarter'></i></div>
                <div>
                    <h4>CSIRT Admin</h4>
                    <small class="text-white-50">Control Center</small>
                </div>
            </div>

            <ul class="admin-menu">
                <li><a href="{{ route('admin.dashboard') }}" class="active"><i class='bx bx-grid-alt'></i>Overview</a></li>
                <li><a href="{{ route('admin.articles.index') }}"><i class='bx bx-news'></i>Artikel</a></li>
                <li><a href="{{ route('admin.incidents.index') }}"><i class='bx bx-error-circle'></i>Laporan Insiden</a></li>
                <li><a href="{{ route('admin.site-settings.edit') }}"><i class='bx bx-cog'></i>Halaman Publik</a></li>
                <li><a href="{{ route('home') }}"><i class='bx bx-arrow-back'></i>Kembali ke Website</a></li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link text-white text-decoration-none p-0 m-0 d-flex align-items-center gap-2">
                            <i class='bx bx-log-out'></i>Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <main class="admin-main">
            <div class="admin-topbar admin-module-topbar">
                <div>
                    <span class="cyber-badge"><span class="pulse-dot"></span> Operasional CSIRT</span>
                    <h2 class="mt-3">Dashboard Monitoring Insiden & Konten</h2>
                </div>
                <div class="admin-header-actions">
                    <a href="{{ route('admin.daily-summary') }}" class="btn btn-cyber-outline btn-sm"><i class='bx bx-calendar me-1'></i>Ringkasan Harian</a>
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-cyber-red btn-sm"><i class='bx bx-plus me-1'></i>Tambah Konten</a>
                </div>
            </div>

            <form class="dashboard-filter-panel" method="GET" action="{{ route('admin.dashboard') }}">
                <div class="filter-grid">
                    <div class="filter-field">
                        <label for="kategori">Kategori ancaman</label>
                        <select id="kategori" name="kategori">
                            <option value="">Semua</option>
                            @foreach($filterCategories as $category)
                                <option value="{{ $category }}" {{ request('kategori') === $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-field">
                        <label for="prioritas">Prioritas</label>
                        <select id="prioritas" name="prioritas">
                            <option value="">Semua</option>
                            @foreach($filterPriorities as $priority)
                                <option value="{{ $priority }}" {{ request('prioritas') === $priority ? 'selected' : '' }}>{{ $priority }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-field">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="">Semua</option>
                            @foreach($filterStatuses as $status)
                                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-field">
                        <label for="instansi">Instansi pelapor</label>
                        <select id="instansi" name="instansi">
                            <option value="">Semua</option>
                            @foreach($filterInstansi as $instansi)
                                <option value="{{ $instansi }}" {{ request('instansi') === $instansi ? 'selected' : '' }}>{{ $instansi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-field">
                        <label for="tanggal_mulai">Tanggal kejadian dari</label>
                        <input id="tanggal_mulai" type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                    </div>
                    <div class="filter-field">
                        <label for="tanggal_selesai">Tanggal kejadian sampai</label>
                        <input id="tanggal_selesai" type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
                    </div>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-cyber-red btn-sm">Terapkan Filter</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-cyber-outline btn-sm">Reset</a>
                </div>
            </form>

            <section class="admin-metrics">
                <div class="admin-metric metric-blue">
                    <div class="admin-metric-top">
                        <div>
                            <div class="admin-metric-label">Laporan masuk bulan ini</div>
                            <div class="admin-metric-value">{{ $stats['this_month_reports'] }}</div>
                        </div>
                        <div class="admin-metric-icon"><i class='bx bx-calendar-event'></i></div>
                    </div>
                    <div class="admin-metric-note">{{ now()->translatedFormat('F Y') }}</div>
                </div>

                <div class="admin-metric metric-purple">
                    <div class="admin-metric-top">
                        <div>
                            <div class="admin-metric-label">Belum ditangani</div>
                            <div class="admin-metric-value">{{ $stats['unhandled_reports'] }}</div>
                        </div>
                        <div class="admin-metric-icon"><i class='bx bx-time-five'></i></div>
                    </div>
                    <div class="admin-metric-note">Masih aktif dalam pipeline</div>
                </div>

                <div class="admin-metric metric-red">
                    <div class="admin-metric-top">
                        <div>
                            <div class="admin-metric-label">Darurat / kritis</div>
                            <div class="admin-metric-value">{{ $stats['emergency_reports'] }}</div>
                        </div>
                        <div class="admin-metric-icon"><i class='bx bx-error-circle'></i></div>
                    </div>
                    <div class="admin-metric-note">Prioritas tinggi dan kritis</div>
                </div>

                <div class="admin-metric metric-green">
                    <div class="admin-metric-top">
                        <div>
                            <div class="admin-metric-label">Artikel terbaru</div>
                            <div class="admin-metric-value text-truncate" style="font-size: 1rem; line-height: 1.35; max-width: 180px;">
                                {{ $articleNews ? $articleNews->title : 'Belum ada artikel' }}
                            </div>
                        </div>
                        <div class="admin-metric-icon"><i class='bx bx-news'></i></div>
                    </div>
                    <div class="admin-metric-note">
                        @if($articleNews)
                            <a href="{{ route('admin.articles.index') }}" class="small-link">Lihat daftar</a>
                        @else
                            <span>Belum tersedia</span>
                        @endif
                    </div>
                </div>
            </section>

            <section class="admin-grid admin-dashboard-main-grid">
                <div class="admin-panel overview-table-panel">
                    <div class="panel-heading-row">
                        <h3>Kejadian memerlukan validasi</h3>
                        <span class="small text-white-50">Queue</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table admin-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Instansi</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($validationQueue as $item)
                                    <tr>
                                        <td><a href="{{ route('admin.incidents.show', $item) }}" class="text-cyber-cyan text-decoration-none">{{ $item->judul }}</a></td>
                                        <td>{{ $item->instansi }}</td>
                                        <td>{{ $item->prioritas ?? 'Normal' }}</td>
                                        <td><span class="admin-badge {{ $item->status === 'new' ? 'warning' : 'secondary' }}">{{ $item->status }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-white-50 py-3">Tidak ada laporan yang menunggu validasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="admin-panel overview-activity-panel">
                    <div class="panel-heading-row">
                        <h3>Trend insiden per bulan</h3>
                        <span class="small text-cyber-cyan">12 bulan</span>
                    </div>
                    <div class="incident-chart">
                        @foreach($trend as $point)
                            @php
                                $barHeight = $maxTrendValue > 0 ? max(8, (int) round(($point['count'] / $maxTrendValue) * 100)) : 0;
                            @endphp
                            <div class="chart-column" title="{{ $point['label'] }}: {{ $point['count'] }} laporan">
                                <span class="chart-bar" style="height: {{ $barHeight }}%;"></span>
                                <small>{{ $point['label'] }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="admin-grid mt-4">
                <div class="admin-panel overview-table-panel">
                    <div class="panel-heading-row">
                        <h3>Laporan insiden terfilter</h3>
                        <a href="{{ route('admin.incidents.index') }}" class="small-link">Lihat semua</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table admin-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Pelapor</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentReports as $report)
                                    <tr>
                                        <td><a href="{{ route('admin.incidents.show', $report) }}" class="text-cyber-cyan text-decoration-none">{{ $report->nama }}</a></td>
                                        <td>{{ $report->judul }}</td>
                                        <td>{{ $report->kategori }}</td>
                                        <td>{{ $report->prioritas ?? 'Normal' }}</td>
                                        <td><span class="admin-badge {{ $report->status === 'new' ? 'warning' : ($report->status === 'resolved' ? 'success' : ($report->status === 'rejected' ? 'danger' : 'secondary')) }}">{{ $report->status }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-white-50 py-3">Belum ada data sesuai filter.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="admin-panel overview-activity-panel">
                    <div class="panel-heading-row">
                        <h3>Artikel terbaru</h3>
                    </div>
                    <div class="article-summary-list">
                        @forelse($recentArticles as $article)
                            <div class="article-summary-item">
                                <div class="article-summary-tag">{{ $article->category }}</div>
                                <div class="article-summary-title">{{ $article->title }}</div>
                                <div class="article-summary-meta">{{ $article->published_at ? $article->published_at->format('d M Y') : $article->updated_at->format('d M Y') }}</div>
                            </div>
                        @empty
                            <div class="text-white-50 py-3">Belum ada artikel.</div>
                        @endforelse
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>

<style>
    .dashboard-filter-panel {
        background: rgba(9, 18, 33, 0.88);
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 22px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 14px;
    }

    .filter-field {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-field label {
        color: rgba(255,255,255,0.75);
        font-size: 0.74rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .filter-field select,
    .filter-field input {
        width: 100%;
        border: 1px solid rgba(148, 163, 184, 0.25);
        background: rgba(15, 23, 42, 0.9);
        border-radius: 10px;
        padding: 10px 12px;
        color: #fff;
        min-height: 42px;
    }

    .filter-actions {
        margin-top: 16px;
        display: flex;
        gap: 10px;
    }

    .admin-dashboard-main-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 18px;
    }

    .incident-chart {
        display: flex;
        align-items: end;
        gap: 10px;
        min-height: 230px;
        padding-top: 12px;
        border-top: 1px solid rgba(148, 163, 184, 0.14);
    }

    .chart-column {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        min-width: 0;
    }

    .chart-bar {
        display: block;
        width: 100%;
        max-width: 32px;
        min-height: 8px;
        border-radius: 8px 8px 0 0;
        background: linear-gradient(180deg, #50d7ff 0%, #1e8ddf 100%);
        box-shadow: 0 0 14px rgba(80, 215, 255, 0.35);
    }

    .chart-column small {
        color: rgba(255,255,255,0.7);
        font-size: 0.72rem;
    }

    .article-summary-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .article-summary-item {
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 12px;
        background: rgba(15, 23, 42, 0.65);
        padding: 12px 14px;
    }

    .article-summary-tag {
        display: inline-block;
        background: rgba(59, 130, 246, 0.15);
        color: #bfe9ff;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.7rem;
        margin-bottom: 8px;
    }

    .article-summary-title {
        color: #fff;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .article-summary-meta {
        color: rgba(255,255,255,0.6);
        font-size: 0.78rem;
    }

    @media (max-width: 1200px) {
        .filter-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }

        .admin-dashboard-main-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
