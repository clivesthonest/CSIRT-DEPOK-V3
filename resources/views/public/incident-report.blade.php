@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="container">
        @include('components.public-page-header', [
            'icon' => 'error-circle',
            'badge' => 'Laporan Insiden',
            'title' => 'Form Intake Laporan Insiden Siber',
            'subtitle' => 'Formulir pelaporan yang memudahkan pengguna menyampaikan kejadian keamanan siber dengan data yang lengkap dan terukur.'
        ])

        <div class="page-card">
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="report-form" action="{{ route('incident.report.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="page-grid">
                    <div class="form-group">
                        <label for="nama">Nama Pelapor</label>
                        <input id="nama" type="text" name="nama" placeholder="Nama lengkap" required>
                    </div>

                    <div class="form-group">
                        <label for="instansi">Instansi / Unit</label>
                        <input id="instansi" type="text" name="instansi" placeholder="Nama instansi atau unit kerja" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" placeholder="contoh@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="telepon">Nomor Telepon</label>
                        <input id="telepon" type="tel" name="telepon" placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="form-group">
                        <label for="kategori">Kategori Insiden</label>
                        <select id="kategori" name="kategori" required>
                            <option value="">Pilih kategori</option>
                            <option>Malware</option>
                            <option>Phishing</option>
                            <option>Ransomware</option>
                            <option>Penyusupan</option>
                            <option>Data Breach</option>
                            <option>Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="prioritas">Prioritas</label>
                        <select id="prioritas" name="prioritas">
                            <option value="">Pilih prioritas</option>
                            <option>Rendah</option>
                            <option>Menengah</option>
                            <option>Tinggi</option>
                            <option>Kritis</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="source">Sumber Laporan</label>
                        <select id="source" name="source">
                            <option value="">Pilih sumber</option>
                            <option>Portal Laporan</option>
                            <option>Email Resmi</option>
                            <option>Telepon</option>
                            <option>WhatsApp</option>
                            <option>Media Sosial</option>
                            <option>Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="impact_area">Area Dampak</label>
                        <input id="impact_area" type="text" name="impact_area" placeholder="Contoh: Server utama, jaringan kantor, layanan publik">
                    </div>

                    <div class="form-group">
                        <label for="waktu_kejadian">Waktu Kejadian</label>
                        <input id="waktu_kejadian" type="datetime-local" name="waktu_kejadian">
                    </div>
                </div>

                <div class="form-group">
                    <label for="judul">Judul Kejadian</label>
                    <input id="judul" type="text" name="judul" placeholder="Ringkas kejadian dalam satu kalimat" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi Kejadian</label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Jelaskan kronologi, dampak, dan indikator kejadian yang ditemukan." required></textarea>
                </div>

                <div class="form-group">
                    <label for="bukti">Lampiran Bukti / Evidence</label>
                    <input id="bukti" type="file" name="bukti" accept=".pdf,.jpg,.jpeg,.png,.zip,.doc,.docx,.csv">
                </div>

                <div class="d-flex flex-wrap gap-3 align-items-center mt-4">
                    <button type="submit" class="btn btn-cyber-red d-inline-flex align-items-center align-self-start">
                        <i class='bx bx-send me-2'></i> Kirim Laporan
                    </button>
                    <a href="{{ route('incident.report.tracking') }}" class="btn btn-cyber-outline">Status Laporan Saya</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
