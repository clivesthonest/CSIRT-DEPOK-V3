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
                    <span class="cyber-badge"><span class="pulse-dot"></span> Detail Laporan Insiden</span>
                    <h2 class="mt-3">{{ $incident->judul }}</h2>
                </div>
                <div class="admin-header-actions premium-ticket-actions">
                    <a href="{{ route('admin.incidents.export.csv') }}?{{ http_build_query(request()->query()) }}" class="btn btn-cyber-outline btn-sm"><i class='bx bx-download me-1'></i>Export CSV</a>
                    <a href="{{ route('admin.incidents.export.pdf') }}?{{ http_build_query(request()->query()) }}" class="btn btn-cyber-red btn-sm"><i class='bx bx-file-blank me-1'></i>Export PDF</a>
                    <a href="{{ route('admin.incidents.index') }}" class="btn btn-cyber-outline btn-sm">Kembali ke Daftar</a>
                </div>
            </div>

            <div class="admin-panel ticket-detail-panel">
                @if(session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif

                <div class="ticket-header-summary">
                    <div>
                        <div class="meta-label">Nomor tiket</div>
                        <div class="meta-value">{{ $incident->ticket_number ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="meta-label">Status</div>
                        <span class="admin-badge {{ $incident->status === 'new' ? 'warning' : ($incident->status === 'resolved' ? 'success' : ($incident->status === 'rejected' ? 'danger' : 'secondary')) }}">{{ $incident->status }}</span>
                    </div>
                    <div>
                        <div class="meta-label">Prioritas</div>
                        <div class="meta-value accent-text">{{ $incident->prioritas ?? 'Normal' }}</div>
                    </div>
                </div>

                <div class="row g-4 mt-2">
                    <div class="col-lg-7">
                        <div class="detail-card">
                            <h4 class="detail-card-title">Data pelapor</h4>
                            <div class="detail-grid">
                                <div>
                                    <span>Nama</span>
                                    <strong>{{ $incident->nama }}</strong>
                                </div>
                                <div>
                                    <span>Instansi</span>
                                    <strong>{{ $incident->instansi }}</strong>
                                </div>
                                <div>
                                    <span>Email</span>
                                    <strong>{{ $incident->email }}</strong>
                                </div>
                                <div>
                                    <span>Telepon</span>
                                    <strong>{{ $incident->telepon ?? '-' }}</strong>
                                </div>
                                <div>
                                    <span>Kategori</span>
                                    <strong>{{ $incident->kategori }}</strong>
                                </div>
                                <div>
                                    <span>Sumber</span>
                                    <strong>{{ $incident->source ?? 'Portal Laporan' }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="detail-card">
                            <h4 class="detail-card-title">Kronologi kejadian</h4>
                            <p class="ticket-description">{{ $incident->deskripsi }}</p>
                        </div>

                        @if($incident->triage_status || $incident->validation_status)
                            <div class="detail-card">
                                <h4 class="detail-card-title">Triase & validasi</h4>
                                <div class="mini-status-list">
                                    <div><span>Triase</span><strong>{{ $incident->triage_status ?? '-' }}</strong></div>
                                    <div><span>Validasi</span><strong>{{ $incident->validation_status ?? '-' }}</strong></div>
                                </div>
                            </div>
                        @endif

                        @if($incident->admin_notes)
                            <div class="detail-card">
                                <h4 class="detail-card-title">Catatan admin</h4>
                                <p class="ticket-description">{{ $incident->admin_notes }}</p>
                            </div>
                        @endif

                        @if($incident->bukti_path)
                            <div class="detail-card">
                                <h4 class="detail-card-title">Lampiran bukti</h4>
                                <a href="{{ Storage::url($incident->bukti_path) }}" class="btn btn-cyber-outline btn-sm" target="_blank" rel="noopener noreferrer">Lihat Lampiran</a>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-5">
                        <div class="admin-panel status-update-box">
                            <h4 class="mb-3">Update status operasional</h4>
                            <form action="{{ route('admin.incidents.update', $incident) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="status" class="admin-form-label">Status</label>
                                    <select id="status" name="status" class="admin-form-control">
                                        <option value="new" {{ $incident->status === 'new' ? 'selected' : '' }}>Baru</option>
                                        <option value="investigating" {{ $incident->status === 'investigating' ? 'selected' : '' }}>Sedang Ditangani</option>
                                        <option value="waiting_for_customer" {{ $incident->status === 'waiting_for_customer' ? 'selected' : '' }}>Menunggu Respon Pelapor</option>
                                        <option value="resolved" {{ $incident->status === 'resolved' ? 'selected' : '' }}>Selesai</option>
                                        <option value="rejected" {{ $incident->status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="triage_status" class="admin-form-label">Triase awal</label>
                                    <input id="triage_status" name="triage_status" value="{{ old('triage_status', $incident->triage_status) }}" class="admin-form-control" placeholder="Contoh: Triage selesai, host diisolasi">
                                </div>

                                <div class="mb-3">
                                    <label for="validation_status" class="admin-form-label">Validasi</label>
                                    <input id="validation_status" name="validation_status" value="{{ old('validation_status', $incident->validation_status) }}" class="admin-form-control" placeholder="Contoh: Validasi awal berhasil">
                                </div>

                                <div class="mb-3">
                                    <label for="admin_notes" class="admin-form-label">Catatan admin</label>
                                    <textarea id="admin_notes" name="admin_notes" rows="5" class="admin-form-control">{{ old('admin_notes', $incident->admin_notes) }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-cyber-red w-100">Simpan perubahan</button>
                            </form>
                        </div>

                        @if(!empty($incident->timeline))
                            <div class="admin-panel timeline-box">
                                <h4 class="mb-3">Timeline perkembangan</h4>
                                <div class="ticket-timeline">
                                    @foreach($incident->timeline as $entry)
                                        <div class="timeline-item">
                                            <div class="timeline-dot"></div>
                                            <div class="timeline-content">
                                                <div class="timeline-stage">{{ data_get($entry, 'stage') }}</div>
                                                <div class="timeline-time">{{ data_get($entry, 'at') }}</div>
                                                <p>{{ data_get($entry, 'message') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
