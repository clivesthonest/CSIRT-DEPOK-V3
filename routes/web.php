<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\IncidentReportController as AdminIncidentReportController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\IncidentReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::view('/profil', 'public.profile')->name('profile');
Route::view('/rfc-2350', 'public.rfc')->name('rfc');
Route::view('/layanan', 'public.services')->name('services');
Route::view('/panduan', 'public.guide')->name('guide');
Route::view('/kontak', 'public.contact')->name('contact');
Route::get('/laporan-insiden', [IncidentReportController::class, 'create'])->name('incident.report');
Route::post('/laporan-insiden', [IncidentReportController::class, 'store'])->name('incident.report.store');
Route::get('/laporan-insiden/sukses', [IncidentReportController::class, 'success'])->name('incident.report.success');
Route::get('/status-laporan', [IncidentReportController::class, 'tracking'])->name('incident.report.tracking');
Route::get('/status-laporan/{ticket}', [IncidentReportController::class, 'showStatus'])->name('incident.report.status');
Route::view('/sop-pelaporan', 'public.sop')->name('sop');

Route::view('/dashboard', 'dashboard')->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/daily-summary', [AdminAuthController::class, 'dailySummary'])->name('admin.daily-summary');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::resource('articles', AdminArticleController::class)->names([
        'index' => 'admin.articles.index',
        'create' => 'admin.articles.create',
        'store' => 'admin.articles.store',
        'show' => 'admin.articles.show',
        'edit' => 'admin.articles.edit',
        'update' => 'admin.articles.update',
        'destroy' => 'admin.articles.destroy',
    ]);
    Route::get('/incidents', [AdminIncidentReportController::class, 'index'])->name('admin.incidents.index');
    Route::get('/incidents/export/csv', [AdminIncidentReportController::class, 'exportCsv'])->name('admin.incidents.export.csv');
    Route::get('/incidents/export/pdf', [AdminIncidentReportController::class, 'exportPdf'])->name('admin.incidents.export.pdf');
    Route::get('/incidents/{incident}', [AdminIncidentReportController::class, 'show'])->name('admin.incidents.show');
    Route::put('/incidents/{incident}', [AdminIncidentReportController::class, 'update'])->name('admin.incidents.update');
    Route::get('/site-settings', [SiteSettingController::class, 'edit'])->name('admin.site-settings.edit');
    Route::put('/site-settings', [SiteSettingController::class, 'update'])->name('admin.site-settings.update');
});