@php
    $heroTitle = \App\Models\SiteSetting::getValue('hero_title', 'TIM CSIRT DEPOK');
    $heroSubtitle = \App\Models\SiteSetting::getValue('hero_subtitle', 'DEPOK - CSIRT merupakan CSIRT / Tim Tanggap Insiden Siber (Tim TIS) sektor Pemerintah Kota Depok yang ditetapkan dalam Keputusan Wali Kota Depok Nomor 821.27/327/Kpts/Diskominfo/Huk/2024 Tahun 2024.');
    $heroPrimaryText = \App\Models\SiteSetting::getValue('hero_button_text', 'Lapor Insiden Siber');
    $heroSecondaryText = \App\Models\SiteSetting::getValue('hero_secondary_button_text', 'Profil & Detail CSIRT');
    $articles = \App\Models\Article::where('status', 'published')->latest('published_at')->take(3)->get();
@endphp

@extends('layouts.app')
@section('content')
    <div class="public-landing-page">
        <div
            class="hero"
            id="home"
            style="background-image: url('/images/Hacker_launches_cyber_attack_on_80534d16.gif'); background-size: cover; background-position: center; background-repeat: no-repeat;"
        >
            <div class="container py-5">
                <div class="row align-items-center gy-4">
                    <div class="col-lg-8 mx-auto text-center hero-content-block">
                        <div class="cyber-badge hero-badge">
                            <span class="pulse-dot"></span> Portal Resmi CSIRT Kota Depok
                        </div>
                        <h1 class="display-4 fw-bold hero-title-text hero-title-animated">{{ $heroTitle }}</h1>
                        <p class="lead text-cyber-muted fs-5 mb-4 px-lg-4 hero-subtitle">
                            {{ $heroSubtitle }}
                        </p>
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <a href="{{ route('incident.report') }}" class="btn btn-cyber-red btn-lg d-inline-flex align-items-center">
                                <i class='bx bx-shield-quarter fs-4 me-2'></i> {{ $heroPrimaryText }}
                            </a>
                            <a href="{{ route('profile') }}" class="btn btn-cyber-outline btn-lg d-inline-flex align-items-center">
                                <i class='bx bx-info-circle fs-4 me-2'></i> {{ $heroSecondaryText }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main class="m-0 p-0">
            <section class="py-5 border-bottom border-secondary border-opacity-10 stat-section">
                <div class="container">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="stat-box">
                                <div class="stat-number"><i class='bx bx-shield-alt-2 text-cyber-cyan me-2'></i>24/7</div>
                                <div class="text-uppercase fw-bold text-cyber-muted fs-6 mt-1">Monitoring & Response</div>
                                <small class="text-white-50">Layanan Tanggap Insiden Siber</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-box">
                                <div class="stat-number"><i class='bx bx-check-shield text-cyber-cyan me-2'></i>RFC 2350</div>
                                <div class="text-uppercase fw-bold text-cyber-muted fs-6 mt-1">Standar Operasional</div>
                                <small class="text-white-50">Kepatuhan Protokol Siber BSSN</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-box">
                                <div class="stat-number"><i class='bx bx-lock-alt text-cyber-cyan me-2'></i>PGP Encrypted</div>
                                <div class="text-uppercase fw-bold text-cyber-muted fs-6 mt-1">Komunikasi Aman</div>
                                <small class="text-white-50">Enkripsi Pelaporan & Data Instansi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-5 feature-showcase">
                <div class="container">
                    <div class="text-center mb-5">
                        <span class="cyber-badge"><i class='bx bx-git-repo-forked me-1'></i> Peran & Fungsi</span>
                        <h2 class="display-6 fw-bold text-white">Tugas Utama CSIRT Depok</h2>
                        <p class="text-cyber-muted mb-0">Mendukung keamanan siber pemerintah daerah melalui deteksi, koordinasi, dan pemulihan insiden.</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6 col-xl-3">
                            <div class="info-card">
                                <div class="info-icon"><i class='bx bx-signal-5'></i></div>
                                <h4>Deteksi Dini</h4>
                                <p>Memantau aktivitas berisiko, ancaman siber, dan indikator kompromi sistem kritikal.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="info-card">
                                <div class="info-icon"><i class='bx bx-search-alt-2'></i></div>
                                <h4>Analisis Kejadian</h4>
                                <p>Melakukan verifikasi, triase, dan asesmen dampak terhadap layanan pemerintahan.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="info-card">
                                <div class="info-icon"><i class='bx bx-briefcase-alt-2'></i></div>
                                <h4>Koordinasi</h4>
                                <p>Menghubungkan instansi, penyedia layanan, dan tim penanganan insiden untuk respons cepat.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="info-card">
                                <div class="info-icon"><i class='bx bx-shield-x'></i></div>
                                <h4>Pemulihan</h4>
                                <p>Menjaga kelangsungan operasional sistem dan memperkuat post-incident recovery.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-5">
                <div class="container">
                    <div class="text-center mb-5">
                        <span class="cyber-badge"><i class='bx bx-git-repo-forked me-1'></i> Prosedur Resmi</span>
                        <h2 class="display-6 fw-bold text-white">Alur Pelaporan Insiden Siber</h2>
                        <p class="text-cyber-muted">3 langkah cepat penanganan dan pemulihan keamanan siber</p>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="step-box">
                                <div class="step-icon"><i class='bx bx-edit-alt'></i></div>
                                <h4 class="h5 fw-bold text-white">1. Pengajuan Laporan</h4>
                                <p class="small text-white-50 mb-0">Pelapor mengisi formulir insiden siber secara aman dengan bukti pendukung dan kontak resmi.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="step-box">
                                <div class="step-icon"><i class='bx bx-search-alt-2'></i></div>
                                <h4 class="h5 fw-bold text-white">2. Verifikasi & Analisis</h4>
                                <p class="small text-white-50 mb-0">Tim CSIRT melakukan verifikasi tiket laporan, analisis dampak, dan triase insiden siber.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="step-box">
                                <div class="step-icon"><i class='bx bx-shield-quarter'></i></div>
                                <h4 class="h5 fw-bold text-white">3. Penanganan & Pemulihan</h4>
                                <p class="small text-white-50 mb-0">Koordinasi teknis penanggulangan insiden hingga sistem kembali aman dan pulih.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="blog" class="py-5">
                <div class="container">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
                        <div>
                            <span class="cyber-badge"><i class='bx bx-broadcast me-1'></i> Imbauan Keamanan</span>
                            <h2 class="display-6 fw-bold text-white mb-0 mt-3">Artikel & Himbauan Siber</h2>
                        </div>
                        <a href="{{ route('articles.index') }}" class="btn btn-cyber-outline btn-sm">Lihat Semua Artikel <i class='bx bx-right-arrow-alt'></i></a>
                    </div>

                    <div class="row g-4">
                        @forelse($articles as $article)
                            <div class="col-lg-4 col-md-6">
                                <div class="card-cyber d-flex flex-column h-100">
                                    <div class="position-relative mb-3 overflow-hidden rounded">
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <a href="#" class="badge bg-danger text-white text-decoration-none px-3 py-2"><i class='bx bx-tag-alt me-1'></i>{{ $article->category }}</a>
                                        </div>
                                        <img src="{{ $article->image_url ?: 'https://csirt.depok.go.id/storage/post-image/poqnhUiZUx5eB3214PrVcD95IAby1wAriAStT9Xc.jpg' }}" alt="{{ $article->title }}" class="w-100">
                                    </div>
                                    <div class="d-flex flex-column flex-grow-1">
                                        <h5 class="card-title h5 mb-2"><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h5>
                                        <p class="small text-white-50 mb-3"><i class='bx bx-calendar me-1'></i>{{ $article->published_at?->format('d M Y') ?? 'Baru' }} &bull; <i class='bx bx-user me-1'></i>Tim CSIRT Depok</p>
                                        <p class="card-text text-white-50 small mb-4 flex-grow-1">{{ Str::limit(strip_tags($article->content), 150) }}</p>
                                        <a href="{{ route('articles.show', $article) }}" class="btn btn-cyber-outline btn-sm w-100 mt-auto">Baca Selengkapnya <i class='bx bx-right-arrow-alt ms-1'></i></a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-white-50 py-4">
                                Belum ada artikel yang dipublikasikan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection