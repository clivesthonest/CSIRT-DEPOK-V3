<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal resmi CSIRT Kota Depok untuk laporan insiden dan keamanan siber.">
    <title>Tim CSIRT Depok - Portal Resmi CSIRT</title>
    <link rel="icon" href="https://csirt.depok.go.id/storage/image-property/kRUUbk4sYstbeQYsR1PayVtCwSQCJcyR4FsEucOn.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cyber-dark text-white" x-data="{ mobileMenuOpen: false, alertVisible: true }">
    <a href="#main-content" class="skip-link">Lewati ke konten utama</a>

    @if (session('success') || session('error'))
        <div class="site-alert" x-show="alertVisible" x-transition.opacity.duration.200ms role="status" aria-live="polite">
            <div class="container d-flex align-items-center justify-content-between gap-3 py-2">
                <span class="small fw-semibold text-white">
                    {{ session('success') ?? session('error') }}
                </span>
                <button type="button" class="site-alert-close" @click="alertVisible = false" aria-label="Tutup notifikasi">
                    <i class='bx bx-x'></i>
                </button>
            </div>
        </div>
    @endif

    <header class="site-header" x-data="{ mobileMenuOpen: false }">
        <nav class="navbar navbar-expand-lg fixed-top" aria-label="Menu utama">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}" aria-label="Beranda CSIRT Depok">
                    <div class="brand-crest">
                        <img class="logo" src="https://csirt.depok.go.id/storage/image-property/kRUUbk4sYstbeQYsR1PayVtCwSQCJcyR4FsEucOn.png" alt="Logo CSIRT Depok">
                        <div class="brand-copy">
                            <span class="brand-kicker">CSIRT</span>
                            <span class="brand-label">Kota Depok</span>
                        </div>
                    </div>
                </a>

                <button class="navbar-toggler text-white border-0 d-lg-none" type="button" @click="mobileMenuOpen = !mobileMenuOpen" :aria-expanded="mobileMenuOpen" aria-controls="mobileNav" aria-label="Buka menu navigasi">
                    <i class='bx bx-menu fs-1 text-cyber-cyan' aria-hidden="true"></i>
                </button>

                <div class="d-none d-lg-flex ms-auto align-items-center">
                    <ul class="navbar-nav align-items-center gap-1">
                        <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}"><span class="nav-link-icon"><i class='bx bx-home-alt'></i></span><span class="nav-link-text">Beranda</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile') }}"><span class="nav-link-icon"><i class='bx bx-shield-quarter'></i></span><span class="nav-link-text">Profil</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('articles.index') }}"><span class="nav-link-icon"><i class='bx bx-news'></i></span><span class="nav-link-text">Artikel</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('rfc') }}"><span class="nav-link-icon"><i class='bx bx-file'></i></span><span class="nav-link-text">RFC 2350</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('services') }}"><span class="nav-link-icon"><i class='bx bx-cog'></i></span><span class="nav-link-text">Layanan</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('guide') }}"><span class="nav-link-icon"><i class='bx bx-book-open'></i></span><span class="nav-link-text">Panduan</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}"><span class="nav-link-icon"><i class='bx bx-envelope'></i></span><span class="nav-link-text">Kontak</span></a></li>
                        <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                            <a class="btn btn-cyber-red d-inline-flex align-items-center" href="{{ route('incident.report') }}">
                                <i class='bx bx-error-circle me-2 fs-5'></i> {{ \App\Models\SiteSetting::getValue('hero_button_text', 'Lapor Insiden') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="mobileNav" class="mobile-nav" x-show="mobileMenuOpen" x-transition:enter="mobile-nav-enter" x-transition:leave="mobile-nav-leave" x-cloak aria-label="Menu navigasi mobile">
            <div class="container py-3">
                <ul class="mobile-nav-list">
                    <li><a href="{{ route('home') }}"><i class='bx bx-home-alt me-2'></i>Beranda</a></li>
                    <li><a href="{{ route('profile') }}"><i class='bx bx-shield-quarter me-2'></i>Profil</a></li>
                    <li><a href="{{ route('articles.index') }}"><i class='bx bx-news me-2'></i>Artikel</a></li>
                    <li><a href="{{ route('rfc') }}"><i class='bx bx-file me-2'></i>RFC 2350</a></li>
                    <li><a href="{{ route('services') }}"><i class='bx bx-cog me-2'></i>Layanan</a></li>
                    <li><a href="{{ route('guide') }}"><i class='bx bx-book-open me-2'></i>Panduan</a></li>
                    <li><a href="{{ route('contact') }}"><i class='bx bx-envelope me-2'></i>Kontak</a></li>
                    <li><a href="{{ route('incident.report') }}"><i class='bx bx-error-circle me-2'></i>Lapor Insiden</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main id="main-content" class="flex-grow" tabindex="-1">
        @yield('content')
    </main>

    <footer class="pt-5" id="contact" aria-label="Footer CSIRT Depok">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <i class='bx bx-shield-quarter fs-2 text-cyber-cyan me-2' aria-hidden="true"></i>
                        <h5 class="text-white mb-0 fw-bold">CSIRT Portal</h5>
                    </div>
                    <p class="small text-white-50">
                        Tim Tanggap Insiden Keamanan Siber Resmi. Bertanggung jawab atas pencegahan, penanganan, dan pemulihan insiden keamanan siber.
                    </p>
                    <div class="mt-3">
                        <a href="{{ route('incident.report') }}" class="btn btn-cyber-red btn-sm">
                            <i class='bx bx-error-circle me-1' aria-hidden="true"></i> Lapor Insiden
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white fw-bold mb-3"><i class='bx bx-category me-2 text-cyber-cyan' aria-hidden="true"></i>Kategori Artikel</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-cyan"><i class='bx bx-chevron-right me-1' aria-hidden="true"></i>Peringatan Keamanan</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-cyan"><i class='bx bx-chevron-right me-1' aria-hidden="true"></i>Berita Keamanan Siber</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-cyan"><i class='bx bx-chevron-right me-1' aria-hidden="true"></i>CSIRT DEPOK</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-cyan"><i class='bx bx-chevron-right me-1' aria-hidden="true"></i>Web Programming</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white fw-bold mb-3"><i class='bx bx-phone-call me-2 text-cyber-cyan' aria-hidden="true"></i>Kontak CSIRT</h5>
                    <ul class="list-unstyled text-white-50 small mb-0">
                        <li class="mb-2"><i class='bx bx-map me-2 text-cyber-cyan' aria-hidden="true"></i>Jl. Margonda Raya No. 54 Kota Depok Jawa Barat Indonesia 16431</li>
                        <li class="mb-2"><i class='bx bx-envelope me-2 text-cyber-cyan' aria-hidden="true"></i>{{ \App\Models\SiteSetting::getValue('contact_email', 'csirt@depok.go.id') }}</li>
                        <li class="mb-2"><i class='bx bx-phone me-2 text-cyber-cyan' aria-hidden="true"></i>{{ \App\Models\SiteSetting::getValue('contact_phone', '089515957800') }}</li>
                        <li class="mt-3">
                            <a href="https://csirt.depok.go.id/storage/public-key/csirt@depok.go.id_0x1F1FC96D4F97960B.asc" class="btn btn-cyber-outline btn-sm py-1 px-2 text-cyber-cyan">
                                <i class='bx bx-key me-1' aria-hidden="true"></i> Unduh PGP Public Key
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white fw-bold mb-3"><i class='bx bx-map-alt me-2 text-cyber-cyan' aria-hidden="true"></i>Lokasi Kantor</h5>
                    <div class="rounded overflow-hidden border border-secondary border-opacity-25">
                        <iframe title="Lokasi kantor CSIRT Depok" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.994433906204!2d106.8184740743778!3d-6.394717893595817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ec086a724fed%3A0xe794929dd620de0c!2sDinas%20Komunikasi%20dan%20Informatika%20(Diskominfo)%20Kota%20Depok!5e0!3m2!1sen!2sid!4v1726029645545!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom text-center py-3">
            <div class="container">
                <small class="text-white-50">
                    {{ \App\Models\SiteSetting::getValue('footer_text', 'Copyright &copy; 2026 Tim CSIRT Depok. All Rights Reserved. Operational Standard RFC 2350 Compliance.') }}
                </small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        var nav = document.querySelector('nav.navbar');
        window.addEventListener('scroll', function () {
            if (window.pageYOffset > 50) {
                nav.classList.add('navbar-scrolled');
            } else {
                nav.classList.remove('navbar-scrolled');
            }
        });
    </script>
</body>
</html>
