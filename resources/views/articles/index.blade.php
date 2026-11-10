@extends('layouts.app')

@section('content')
<div class="dashboard-page article-list-page">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="cyber-badge"><i class='bx bx-news me-1'></i> Berita & Informasi</span>
            <h1 class="display-6 fw-bold text-white mt-4 mb-3">Artikel CSIRT Depok</h1>
            <p class="text-cyber-muted mb-0">Kumpulan himbauan, berita, dan penanganan keamanan siber terbaru.</p>
        </div>

        <div class="row g-4">
            @forelse($articles as $article)
                <div class="col-lg-4 col-md-6">
                    <div class="card-cyber d-flex flex-column h-100">
                        <div class="position-relative mb-3 overflow-hidden rounded">
                            <div class="position-absolute top-0 start-0 m-3 z-2">
                                <span class="badge bg-danger text-white px-3 py-2">
                                    <i class='bx bx-tag-alt me-1'></i>{{ $article->category }}
                                </span>
                            </div>
                            <img src="{{ $article->image_url ?: 'https://csirt.depok.go.id/storage/post-image/poqnhUiZUx5eB3214PrVcD95IAby1wAriAStT9Xc.jpg' }}" alt="{{ $article->title }}" class="w-100">
                        </div>

                        <div class="d-flex flex-column flex-grow-1">
                            <h3 class="card-title h5 mb-2">
                                <a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
                            </h3>
                            <p class="small text-white-50 mb-3">
                                <i class='bx bx-calendar me-1'></i>{{ $article->published_at?->format('d M Y') ?? 'Baru' }}
                                &bull; <i class='bx bx-user me-1'></i>Tim CSIRT Depok
                            </p>
                            <p class="card-text text-white-50 small mb-4 flex-grow-1">
                                {{ Str::limit(strip_tags($article->content), 150) }}
                            </p>
                            <a href="{{ route('articles.show', $article) }}" class="btn btn-cyber-outline btn-sm w-100 mt-auto">
                                Baca Selengkapnya <i class='bx bx-right-arrow-alt ms-1'></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card-cyber text-center py-5">
                        <p class="text-white-50 mb-0">Belum ada artikel yang dipublikasikan.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($articles->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
