@extends('layouts.app')

@section('content')
<div class="dashboard-page article-detail-page">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card-cyber article-featured-card p-3 p-md-4">
                    <div class="mb-4">
                        <span class="badge bg-danger text-white px-3 py-2 mb-3">
                            <i class='bx bx-tag-alt me-1'></i>{{ $article->category }}
                        </span>
                        <h1 class="display-6 fw-bold text-white mb-3">{{ $article->title }}</h1>
                        <div class="text-white-50 small d-flex flex-wrap gap-3 align-items-center">
                            <span><i class='bx bx-calendar me-1'></i>{{ $article->published_at?->format('d M Y') ?? 'Baru' }}</span>
                            <span><i class='bx bx-user me-1'></i>Tim CSIRT Depok</span>
                        </div>
                    </div>

                    @if($article->image_url)
                        <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="img-fluid rounded-4 shadow mb-4 article-detail-image">
                    @endif

                    @if($article->excerpt)
                        <p class="lead text-cyber-muted mb-4">{{ $article->excerpt }}</p>
                    @endif

                    <article class="article-content text-white-75">
                        {!! nl2br(e($article->content)) !!}
                    </article>
                </div>
            </div>

            <aside class="col-lg-4">
                <div class="card-cyber p-3 p-md-4 sticky-top" style="top: 100px;">
                    <h3 class="h5 fw-bold text-white mb-3"><i class='bx bx-news me-2 text-cyber-cyan'></i>Artikel Lainnya</h3>
                    <div class="d-grid gap-3">
                        @forelse($related as $item)
                            <a href="{{ route('articles.show', $item) }}" class="text-decoration-none d-block article-side-item">
                                <div class="d-flex align-items-start gap-3">
                                    <img src="{{ $item->image_url ?: 'https://csirt.depok.go.id/storage/post-image/poqnhUiZUx5eB3214PrVcD95IAby1wAriAStT9Xc.jpg' }}" alt="{{ $item->title }}" class="article-thumbnail">
                                    <div>
                                        <div class="small text-cyber-cyan mb-1">{{ $item->category }}</div>
                                        <h4 class="h6 text-white mb-1">{{ $item->title }}</h4>
                                        <small class="text-white-50">{{ $item->published_at?->format('d M Y') ?? 'Baru' }}</small>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-white-50 small mb-0">Belum ada artikel terkait.</p>
                        @endforelse
                    </div>

                    <div class="mt-4 pt-3 border-top border-secondary border-opacity-10">
                        <a href="{{ route('articles.index') }}" class="btn btn-cyber-outline w-100">
                            <i class='bx bx-list-ul me-2'></i>Lihat Semua Artikel
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
