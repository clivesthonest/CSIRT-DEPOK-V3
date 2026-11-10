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
                <li><a href="{{ route('admin.incidents.index') }}"><i class='bx bx-error-circle'></i>Laporan Insiden</a></li>
                <li><a href="{{ route('admin.site-settings.edit') }}" class="active"><i class='bx bx-cog'></i>Halaman Publik</a></li>
                <li><a href="{{ route('home') }}"><i class='bx bx-arrow-back'></i>Kembali ke Website</a></li>
            </ul>
        </aside>

        <main class="admin-main">
            <div class="admin-topbar">
                <div>
                    <span class="cyber-badge"><span class="pulse-dot"></span> Publik</span>
                    <h2 class="mt-3">Edit Halaman Publik</h2>
                </div>
            </div>

            <div class="admin-panel">
                @if(session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.site-settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="admin-form-label" for="hero_title">Judul Hero</label>
                            <input id="hero_title" name="hero_title" class="admin-form-control" value="{{ old('hero_title', $settings['hero_title'] ?? 'Tim CSIRT Depok') }}">
                        </div>

                        <div class="col-12">
                            <label class="admin-form-label" for="hero_subtitle">Subjudul Hero</label>
                            <textarea id="hero_subtitle" name="hero_subtitle" class="admin-form-control" rows="4">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? 'DEPOK - CSIRT merupakan CSIRT / Tim Tanggap Insiden Siber ...') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="admin-form-label" for="hero_button_text">Teks Tombol Utama</label>
                            <input id="hero_button_text" name="hero_button_text" class="admin-form-control" value="{{ old('hero_button_text', $settings['hero_button_text'] ?? 'Lapor Insiden Siber') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="admin-form-label" for="hero_secondary_button_text">Teks Tombol Kedua</label>
                            <input id="hero_secondary_button_text" name="hero_secondary_button_text" class="admin-form-control" value="{{ old('hero_secondary_button_text', $settings['hero_secondary_button_text'] ?? 'Profil & Detail CSIRT') }}">
                        </div>

                        <div class="col-12">
                            <label class="admin-form-label" for="profile_intro">Konten Profil</label>
                            <textarea id="profile_intro" name="profile_intro" class="admin-form-control" rows="4">{{ old('profile_intro', $settings['profile_intro'] ?? 'CSIRT Kota Depok berperan dalam mendukung keamanan siber di lingkungan Pemerintah Kota Depok melalui deteksi dini, koordinasi, dan pemulihan insiden.') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="admin-form-label" for="rfc_intro">Konten RFC 2350</label>
                            <textarea id="rfc_intro" name="rfc_intro" class="admin-form-control" rows="4">{{ old('rfc_intro', $settings['rfc_intro'] ?? 'Dokumen resmi yang menjelaskan cakupan, kontak, layanan, dan prosedur operasional CSIRT Kota Depok.') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="admin-form-label" for="services_intro">Konten Layanan</label>
                            <textarea id="services_intro" name="services_intro" class="admin-form-control" rows="4">{{ old('services_intro', $settings['services_intro'] ?? 'Layanan CSIRT mencakup pemantauan, triase, koordinasi, dan pemulihan insiden keamanan siber.') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="admin-form-label" for="guide_intro">Konten Panduan</label>
                            <textarea id="guide_intro" name="guide_intro" class="admin-form-control" rows="4">{{ old('guide_intro', $settings['guide_intro'] ?? 'Panduan dan dokumen pendukung membantu pengguna memahami kebijakan serta tata cara keamanan siber.') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="admin-form-label" for="contact_email">Email Kontak</label>
                            <input id="contact_email" name="contact_email" class="admin-form-control" value="{{ old('contact_email', $settings['contact_email'] ?? 'csirt@depok.go.id') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="admin-form-label" for="contact_phone">Telepon Kontak</label>
                            <input id="contact_phone" name="contact_phone" class="admin-form-control" value="{{ old('contact_phone', $settings['contact_phone'] ?? '089515957800') }}">
                        </div>

                        <div class="col-12">
                            <label class="admin-form-label" for="contact_intro">Konten Kontak</label>
                            <textarea id="contact_intro" name="contact_intro" class="admin-form-control" rows="4">{{ old('contact_intro', $settings['contact_intro'] ?? 'Gunakan kanal komunikasi resmi untuk pelaporan insiden dan konsultasi keamanan siber.') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="admin-form-label" for="sop_intro">Konten SOP</label>
                            <textarea id="sop_intro" name="sop_intro" class="admin-form-control" rows="4">{{ old('sop_intro', $settings['sop_intro'] ?? 'SOP pelaporan dan penerbitan sertifikat disusun untuk memastikan proses penanganan insiden berjalan secara tertib dan terdokumentasi.') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="admin-form-label" for="footer_text">Footer Situs</label>
                            <textarea id="footer_text" name="footer_text" class="admin-form-control" rows="3">{{ old('footer_text', $settings['footer_text'] ?? 'Tim CSIRT Depok siap membantu menjaga keamanan siber layanan publik dan data pemerintah.') }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-cyber-red">Simpan Pengaturan</button>
                        <a href="{{ route('home') }}" class="btn btn-cyber-outline">Lihat Halaman Publik</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
