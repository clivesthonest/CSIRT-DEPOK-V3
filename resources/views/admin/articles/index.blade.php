@extends('layouts.app')

@section('content')
<div class="admin-dashboard-page admin-article-page">
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
                <li><a href="{{ route('admin.articles.index') }}" class="active"><i class='bx bx-news'></i>Artikel</a></li>
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
                    <span class="cyber-badge"><span class="pulse-dot"></span> Konten</span>
                    <h2 class="mt-3">Kelola Artikel</h2>
                </div>
                <div class="admin-header-actions">
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-cyber-red btn-sm">
                        <i class='bx bx-plus me-1'></i>Tambah Artikel
                    </a>
                </div>
            </div>

            <div class="admin-content-summary">
                <div class="summary-card">
                    <span>Jumlah Artikel</span>
                    <strong>{{ $articles->total() }}</strong>
                </div>
                <div class="summary-card">
                    <span>Published</span>
                    <strong>{{ \App\Models\Article::where('status', 'published')->count() }}</strong>
                </div>
                <div class="summary-card">
                    <span>Draft</span>
                    <strong>{{ \App\Models\Article::where('status', 'draft')->count() }}</strong>
                </div>
            </div>

            <div class="admin-panel article-manager-panel">
                @if(session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif

                <form method="GET" action="{{ route('admin.articles.index') }}" class="article-filter-bar">
                    <div class="input-group search-input-group">
                        <span class="input-group-text"><i class='bx bx-search'></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari judul, kategori, atau isi artikel...">
                    </div>

                    <div class="filter-selects">
                        <select name="status" class="form-select admin-filter-select">
                            <option value="">Semua status</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>

                        <select name="category" class="form-select admin-filter-select">
                            <option value="">Semua kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-cyber-red btn-sm">Filter</button>
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-cyber-outline btn-sm">Reset</a>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table admin-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Dipublikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                                <tr>
                                    <td>
                                        <div class="article-title-cell">
                                            <strong>{{ $article->title }}</strong>
                                            <small>{{ Str::limit(strip_tags($article->excerpt ?: $article->content), 60) }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $article->category }}</td>
                                    <td>
                                        <span class="admin-badge {{ $article->status === 'published' ? 'success' : 'warning' }}">
                                            {{ $article->status }}
                                        </span>
                                    </td>
                                    <td>{{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</td>
                                    <td>
                                        <div class="admin-action-group">
                                            @if($article->status === 'published')
                                                <a href="{{ route('articles.show', $article) }}" class="btn btn-cyber-outline btn-sm" target="_blank">Preview</a>
                                            @endif
                                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-cyber-outline btn-sm">Edit</a>
                                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-white-50 py-4">Belum ada artikel sesuai filter yang dipilih.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($articles->hasPages())
                    <div class="pagination-wrap">
                        {{ $articles->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
