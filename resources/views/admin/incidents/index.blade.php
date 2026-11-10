@extends('layouts.app')

@section('content')
<div class="admin-dashboard-page">
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
                <li><a href="{{ route('admin.dashboard') }}"><i class='bx bx-grid-alt'></i>Overview</a></li>
                <li><a href="{{ route('admin.articles.index') }}"><i class='bx bx-news'></i>Artikel</a></li>
                <li><a href="{{ route('admin.incidents.index') }}" class="active"><i class='bx bx-error-circle'></i>Laporan Insiden</a></li>
                <li><a href="{{ route('admin.site-settings.edit') }}"><i class='bx bx-cog'></i>Halaman Publik</a></li>
                <li><a href="{{ route('home') }}"><i class='bx bx-arrow-back'></i>Kembali ke Website</a></li>
            </ul>
        </aside>

        <main class="admin-main">
            <div class="admin-topbar official-topbar">
                <div>
                    <span class="cyber-badge"><span class="pulse-dot"></span> Operasional CSIRT</span>
                    <h2 class="mt-3">Daftar Laporan Insiden</h2>
                </div>
                <div class="admin-header-actions premium-ticket-actions">
                    <a href="{{ route('admin.incidents.export.csv') }}?{{ http_build_query(request()->query()) }}" class="btn btn-cyber-outline btn-sm"><i class='bx bx-download me-1'></i>Export CSV</a>
                    <a href="{{ route('admin.incidents.export.pdf') }}?{{ http_build_query(request()->query()) }}" class="btn btn-cyber-red btn-sm"><i class='bx bx-file-blank me-1'></i>Export PDF</a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-cyber-outline btn-sm">Kembali ke Dashboard</a>
                </div>
            </div>

            <div class="admin-panel ticket-search-panel">
                <form method="GET" action="{{ route('admin.incidents.index') }}" class="search-form-grid">
                    <div class="search-field wide-field">
                        <label for="search">Pencarian</label>
                        <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor tiket, judul, pelapor, instansi, kategori...">
                    </div>
                    <div class="search-field">
                        <label for="statusFilter">Status</label>
                        <select id="statusFilter" name="status">
                            <option value="">Semua</option>
                            @foreach($filterStatuses as $status)
                                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search-field">
                        <label for="priorityFilter">Prioritas</label>
                        <select id="priorityFilter" name="prioritas">
                            <option value="">Semua</option>
                            @foreach($filterPriorities as $priority)
                                <option value="{{ $priority }}" {{ request('prioritas') === $priority ? 'selected' : '' }}>{{ $priority }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search-field">
                        <label for="categoryFilter">Kategori</label>
                        <select id="categoryFilter" name="kategori">
                            <option value="">Semua</option>
                            @foreach($filterCategories as $category)
                                <option value="{{ $category }}" {{ request('kategori') === $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search-field">
                        <label for="instansiFilter">Instansi</label>
                        <select id="instansiFilter" name="instansi">
                            <option value="">Semua</option>
                            @foreach($filterInstansi as $instansi)
                                <option value="{{ $instansi }}" {{ request('instansi') === $instansi ? 'selected' : '' }}>{{ $instansi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search-actions">
                        <button type="submit" class="btn btn-cyber-red btn-sm">Cari</button>
                        <a href="{{ route('admin.incidents.index') }}" class="btn btn-cyber-outline btn-sm">Reset</a>
                    </div>
                </form>
            </div>

            <div class="admin-panel">
                @if(session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table admin-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Ticket</th>
                                <th>Pelapor</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Prioritas</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <td><div class="fw-semibold text-cyber-cyan">{{ $report->ticket_number ?? '-' }}</div></td>
                                    <td>
                                        <div class="fw-semibold text-white">{{ $report->nama }}</div>
                                        <small class="text-white-50">{{ $report->instansi }}</small>
                                    </td>
                                    <td><a href="{{ route('admin.incidents.show', $report) }}" class="text-decoration-none text-white fw-semibold">{{ $report->judul }}</a></td>
                                    <td>{{ $report->kategori }}</td>
                                    <td>{{ $report->prioritas ?? 'Normal' }}</td>
                                    <td><span class="admin-badge {{ $report->status === 'new' ? 'warning' : ($report->status === 'resolved' ? 'success' : ($report->status === 'rejected' ? 'danger' : 'secondary')) }}">{{ $report->status }}</span></td>
                                    <td>{{ $report->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-white-50 py-3">Belum ada laporan insiden sesuai filter yang dipilih.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $reports->links() }}
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
