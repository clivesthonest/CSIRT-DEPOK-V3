@extends('layouts.app')

@section('content')
<div class="dashboard-page">
    <div class="container dashboard-shell">
        <aside class="dashboard-sidebar">
            <div class="sidebar-brand">
                <div class="brand-badge"><i class='bx bx-shield-quarter'></i></div>
                <div>
                    <h5>CSIRT Depok</h5>
                    <small class="text-white-50">Security Operations</small>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li><a href="{{ route('dashboard') }}" class="active"><i class='bx bx-grid-alt'></i>Overview</a></li>
                <li><a href="#"><i class='bx bx-shield-alt-2'></i>Incidents</a></li>
                <li><a href="#"><i class='bx bx-server'></i>Assets</a></li>
                <li><a href="#"><i class='bx bx-bell'></i>Alerts</a></li>
                <li><a href="#"><i class='bx bx-briefcase'></i>Report</a></li>
                <li><a href="#"><i class='bx bx-cog'></i>Settings</a></li>
            </ul>
        </aside>

        <div class="dashboard-main">
            <div class="dashboard-topbar">
                <div>
                    <span class="cyber-badge"><span class="pulse-dot"></span> SOC Command</span>
                    <h1>Dashboard Keamanan Siber</h1>
                </div>
                <div class="top-actions">
                    <button class="btn btn-cyber-outline btn-sm">Export</button>
                    <a href="#" class="btn btn-cyber-red btn-sm"><i class='bx bx-error-circle me-1'></i>Lapor Insiden</a>
                </div>
            </div>

            <section class="metrics-grid">
                <div class="dashboard-metric">
                    <div class="metric-head">
                        <div>
                            <div class="metric-label">Insiden Aktif</div>
                            <div class="metric-value">24</div>
                        </div>
                        <div class="metric-icon"><i class='bx bx-alarm'></i></div>
                    </div>
                    <div class="metric-trend positive"><i class='bx bx-trending-up'></i> +12% dari minggu lalu</div>
                </div>

                <div class="dashboard-metric">
                    <div class="metric-head">
                        <div>
                            <div class="metric-label">Jaringan Aman</div>
                            <div class="metric-value">96.8%</div>
                        </div>
                        <div class="metric-icon"><i class='bx bx-check-shield'></i></div>
                    </div>
                    <div class="metric-trend positive"><i class='bx bx-check'></i> Stabil</div>
                </div>

                <div class="dashboard-metric">
                    <div class="metric-head">
                        <div>
                            <div class="metric-label">Alert Baru</div>
                            <div class="metric-value">09</div>
                        </div>
                        <div class="metric-icon"><i class='bx bx-bell-ring'></i></div>
                    </div>
                    <div class="metric-trend warning"><i class='bx bx-time-five'></i> Perlu review</div>
                </div>

                <div class="dashboard-metric">
                    <div class="metric-head">
                        <div>
                            <div class="metric-label">SLA Tertangani</div>
                            <div class="metric-value">89%</div>
                        </div>
                        <div class="metric-icon"><i class='bx bx-target-lock'></i></div>
                    </div>
                    <div class="metric-trend negative"><i class='bx bx-down-arrow-alt'></i> -4% vs target</div>
                </div>
            </section>

            <section class="content-grid">
                <div class="dashboard-panel">
                    <div class="panel-header">
                        <h3>Daftar Insiden Terkini</h3>
                        <a href="#" class="btn btn-cyber-outline btn-sm">Lihat Semua</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Kasus</th>
                                    <th>Instansi</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Phishing Domain</td>
                                    <td>Diskominfo</td>
                                    <td>Critical</td>
                                    <td><span class="badge-status critical">Critical</span></td>
                                </tr>
                                <tr>
                                    <td>Bruteforce VPN</td>
                                    <td>RSUD Depok</td>
                                    <td>High</td>
                                    <td><span class="badge-status warning">Investigasi</span></td>
                                </tr>
                                <tr>
                                    <td>Malware Endpoint</td>
                                    <td>BPBD</td>
                                    <td>Medium</td>
                                    <td><span class="badge-status warning">Mitigasi</span></td>
                                </tr>
                                <tr>
                                    <td>Peningkatan Traffic</td>
                                    <td>Bagian Humas</td>
                                    <td>Low</td>
                                    <td><span class="badge-status safe">Tertutup</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="dashboard-panel">
                    <div class="panel-header">
                        <h3>Network Status</h3>
                        <span class="text-cyber-cyan small fw-bold">Live</span>
                    </div>

                    <div class="radar-box">
                        <div class="radar-scan"></div>
                        <span class="node n1"></span>
                        <span class="node n2"></span>
                        <span class="node n3"></span>
                        <span class="node n4"></span>
                    </div>

                    <div class="alert-list">
                        <div class="alert-item">
                            <span class="alert-dot red"></span>
                            <div>
                                <h4>Ransomware Detection</h4>
                                <p>3 endpoint terdeteksi berbahaya</p>
                            </div>
                        </div>
                        <div class="alert-item">
                            <span class="alert-dot yellow"></span>
                            <div>
                                <h4>Traffic Anomaly</h4>
                                <p>Peningkatan volume 18% di jaringan kota</p>
                            </div>
                        </div>
                        <div class="alert-item">
                            <span class="alert-dot green"></span>
                            <div>
                                <h4>Patch Status</h4>
                                <p>88% perangkat sudah terkini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bottom-grid">
                <div class="scan-card">
                    <div class="panel-header">
                        <h3>Service Health</h3>
                        <span class="text-cyber-cyan small fw-bold">24/7</span>
                    </div>

                    <div class="service-list">
                        <div class="service-row">
                            <div>
                                <strong>Portal CSIRT</strong>
                            </div>
                            <div class="progress" style="width: 130px">
                                <div class="progress-bar" style="width: 92%"></div>
                            </div>
                            <div class="text-cyber-cyan fw-bold">92%</div>
                        </div>
                        <div class="service-row">
                            <div>
                                <strong>Mail Gateway</strong>
                            </div>
                            <div class="progress" style="width: 130px">
                                <div class="progress-bar" style="width: 87%"></div>
                            </div>
                            <div class="text-cyber-cyan fw-bold">87%</div>
                        </div>
                        <div class="service-row">
                            <div>
                                <strong>VPN Access</strong>
                            </div>
                            <div class="progress" style="width: 130px">
                                <div class="progress-bar" style="width: 76%"></div>
                            </div>
                            <div class="text-cyber-cyan fw-bold">76%</div>
                        </div>
                    </div>
                </div>

                <div class="activity-feed">
                    <div class="panel-header">
                        <h3>Aktivitas Terbaru</h3>
                    </div>

                    <div class="feed-list">
                        <div class="feed-item">
                            <div class="feed-time">09:40</div>
                            <p>Tim SOC menutup laporan phishing domain dan mengamankan akun tersebut.</p>
                        </div>
                        <div class="feed-item">
                            <div class="feed-time">08:15</div>
                            <p>Patch keamanan untuk server email telah diterapkan secara otomatis.</p>
                        </div>
                        <div class="feed-item">
                            <div class="feed-time">Yesterday</div>
                            <p>Monitoring jaringan menunjukkan penurunan anomali trafik setelah pemulihan.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
