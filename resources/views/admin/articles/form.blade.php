@extends('layouts.app')

@section('content')
<div class="admin-dashboard-page admin-article-form-page">
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
                    <span class="cyber-badge"><span class="pulse-dot"></span> Editor</span>
                    <h2 class="mt-3">{{ isset($article->id) ? 'Edit Artikel' : 'Tambah Artikel Baru' }}</h2>
                </div>
                <div class="admin-header-actions">
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-cyber-outline btn-sm"><i class='bx bx-list-ul me-1'></i>Daftar Artikel</a>
                </div>
            </div>

            <div class="admin-form-layout">
                <div class="admin-panel article-editor-panel">
                    @if($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ isset($article->id) ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="POST" class="article-editor-form">
                        @csrf
                        @if(isset($article->id))
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="admin-form-label" for="title">Judul</label>
                                <input id="title" name="title" type="text" class="admin-form-control" value="{{ old('title', $article->title ?? '') }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="admin-form-label" for="category">Kategori</label>
                                <input id="category" name="category" type="text" class="admin-form-control" value="{{ old('category', $article->category ?? '') }}" required>
                            </div>

                            <div class="col-12">
                                <label class="admin-form-label" for="excerpt">Ringkasan</label>
                                <textarea id="excerpt" name="excerpt" class="admin-form-control" rows="3">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="admin-form-label" for="content">Konten</label>
                                <textarea id="content" name="content" class="admin-form-control" rows="11" required>{{ old('content', $article->content ?? '') }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="admin-form-label" for="image_url">URL Gambar</label>
                                <input id="image_url" name="image_url" type="text" class="admin-form-control" value="{{ old('image_url', $article->image_url ?? '') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="admin-form-label" for="status">Status</label>
                                <select id="status" name="status" class="admin-form-control">
                                    <option value="draft" {{ old('status', $article->status ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $article->status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="admin-form-label" for="published_at">Tanggal Publikasi</label>
                                <input id="published_at" name="published_at" type="date" class="admin-form-control" value="{{ old('published_at', isset($article->published_at) ? $article->published_at->format('Y-m-d') : '') }}">
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-cyber-red">Simpan</button>
                            <a href="{{ route('admin.articles.index') }}" class="btn btn-cyber-outline">Batal</a>
                        </div>
                    </form>
                </div>

                <aside class="admin-panel article-preview-panel">
                    <div class="preview-header">
                        <span class="cyber-badge"><span class="pulse-dot"></span> Preview</span>
                    </div>

                    <div class="preview-card">
                        <img src="{{ old('image_url', $article->image_url ?? 'https://csirt.depok.go.id/storage/post-image/poqnhUiZUx5eB3214PrVcD95IAby1wAriAStT9Xc.jpg') }}" alt="Preview thumbnail">
                        <div class="preview-meta">
                            <span class="badge bg-danger text-white">{{ old('category', $article->category ?? 'Kategori') }}</span>
                            <h4>{{ old('title', $article->title ?? 'Judul Artikel') }}</h4>
                            <p>{{ Str::limit(strip_tags(old('excerpt', $article->excerpt ?? $article->content ?? 'Ringkasan artikel akan muncul di sini.')), 140) }}</p>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    </div>
</div>
@endsection
