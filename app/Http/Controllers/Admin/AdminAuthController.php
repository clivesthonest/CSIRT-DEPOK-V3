<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\IncidentReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (! $user || ! $user->is_admin) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Akun ini tidak memiliki akses admin.',
                ])->onlyInput('email');
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function dashboard(Request $request)
    {
        $baseQuery = IncidentReport::query();

        if ($request->filled('kategori')) {
            $baseQuery->where('kategori', $request->input('kategori'));
        }

        if ($request->filled('prioritas')) {
            $baseQuery->where('prioritas', $request->input('prioritas'));
        }

        if ($request->filled('status')) {
            $baseQuery->where('status', $request->input('status'));
        }

        if ($request->filled('instansi')) {
            $baseQuery->where('instansi', 'like', '%' . $request->input('instansi') . '%');
        }

        if ($request->filled('tanggal_mulai')) {
            $baseQuery->whereDate('waktu_kejadian', '>=', $request->input('tanggal_mulai'));
        }

        if ($request->filled('tanggal_selesai')) {
            $baseQuery->whereDate('waktu_kejadian', '<=', $request->input('tanggal_selesai'));
        }

        $filteredReports = $baseQuery->latest()->get();

        $thisMonthReports = IncidentReport::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->when($request->filled('kategori'), fn ($query) => $query->where('kategori', $request->input('kategori')))
            ->when($request->filled('prioritas'), fn ($query) => $query->where('prioritas', $request->input('prioritas')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
            ->when($request->filled('instansi'), fn ($query) => $query->where('instansi', 'like', '%' . $request->input('instansi') . '%'))
            ->when($request->filled('tanggal_mulai'), fn ($query) => $query->whereDate('waktu_kejadian', '>=', $request->input('tanggal_mulai')))
            ->when($request->filled('tanggal_selesai'), fn ($query) => $query->whereDate('waktu_kejadian', '<=', $request->input('tanggal_selesai')))
            ->count();

        $unhandledReports = IncidentReport::whereIn('status', ['new', 'investigating', 'waiting_for_customer'])
            ->when($request->filled('kategori'), fn ($query) => $query->where('kategori', $request->input('kategori')))
            ->when($request->filled('prioritas'), fn ($query) => $query->where('prioritas', $request->input('prioritas')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
            ->when($request->filled('instansi'), fn ($query) => $query->where('instansi', 'like', '%' . $request->input('instansi') . '%'))
            ->when($request->filled('tanggal_mulai'), fn ($query) => $query->whereDate('waktu_kejadian', '>=', $request->input('tanggal_mulai')))
            ->when($request->filled('tanggal_selesai'), fn ($query) => $query->whereDate('waktu_kejadian', '<=', $request->input('tanggal_selesai')))
            ->count();

        $emergencyReports = IncidentReport::where(function ($query) {
                $query->where('prioritas', 'Kritis')
                    ->orWhere('prioritas', 'Critical');
            })
            ->when($request->filled('kategori'), fn ($query) => $query->where('kategori', $request->input('kategori')))
            ->when($request->filled('prioritas'), fn ($query) => $query->where('prioritas', $request->input('prioritas')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
            ->when($request->filled('instansi'), fn ($query) => $query->where('instansi', 'like', '%' . $request->input('instansi') . '%'))
            ->when($request->filled('tanggal_mulai'), fn ($query) => $query->whereDate('waktu_kejadian', '>=', $request->input('tanggal_mulai')))
            ->when($request->filled('tanggal_selesai'), fn ($query) => $query->whereDate('waktu_kejadian', '<=', $request->input('tanggal_selesai')))
            ->count();

        $latestArticle = Article::latest()->first();
        $validationQueue = IncidentReport::where(function ($query) {
                $query->whereNull('triage_status')
                    ->orWhereNull('validation_status');
            })
            ->whereIn('status', ['new', 'investigating'])
            ->latest()
            ->limit(5)
            ->get();

        $trend = [];
        $monthLabels = [];
        $maxTrendValue = 1;

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $monthLabels[] = $date->translatedFormat('M');

            $count = IncidentReport::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->when($request->filled('kategori'), fn ($query) => $query->where('kategori', $request->input('kategori')))
                ->when($request->filled('prioritas'), fn ($query) => $query->where('prioritas', $request->input('prioritas')))
                ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
                ->when($request->filled('instansi'), fn ($query) => $query->where('instansi', 'like', '%' . $request->input('instansi') . '%'))
                ->when($request->filled('tanggal_mulai'), fn ($query) => $query->whereDate('waktu_kejadian', '>=', $request->input('tanggal_mulai')))
                ->when($request->filled('tanggal_selesai'), fn ($query) => $query->whereDate('waktu_kejadian', '<=', $request->input('tanggal_selesai')))
                ->count();

            $trend[] = ['month' => $date->translatedFormat('M'), 'label' => $date->translatedFormat('M'), 'count' => $count];
            $maxTrendValue = max($maxTrendValue, $count);
        }

        $stats = [
            'articles' => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'draft_articles' => Article::where('status', 'draft')->count(),
            'admins' => User::where('is_admin', true)->count(),
            'incident_reports' => IncidentReport::count(),
            'new_incident_reports' => IncidentReport::where('status', 'new')->count(),
            'this_month_reports' => $thisMonthReports,
            'unhandled_reports' => $unhandledReports,
            'emergency_reports' => $emergencyReports,
        ];

        $filterCategories = IncidentReport::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori')->filter()->values();
        $filterPriorities = IncidentReport::select('prioritas')->distinct()->orderBy('prioritas')->pluck('prioritas')->filter()->values();
        $filterStatuses = IncidentReport::select('status')->distinct()->orderBy('status')->pluck('status')->filter()->values();
        $filterInstansi = IncidentReport::select('instansi')->distinct()->orderBy('instansi')->pluck('instansi')->filter()->values();

        $recentArticles = Article::latest()->limit(5)->get();
        $recentReports = $filteredReports->take(6);
        $articleNews = $latestArticle ? $latestArticle : null;

        return view('admin.dashboard', compact(
            'stats',
            'recentArticles',
            'recentReports',
            'validationQueue',
            'trend',
            'maxTrendValue',
            'filterCategories',
            'filterPriorities',
            'filterStatuses',
            'filterInstansi',
            'articleNews'
        ));
    }

    public function dailySummary(Request $request)
    {
        $selectedDate = $request->input('date', now()->toDateString());

        $dailyReports = IncidentReport::whereDate('created_at', $selectedDate)
            ->orWhereDate('waktu_kejadian', $selectedDate)
            ->latest()
            ->get();

        $openReports = $dailyReports->filter(fn ($report) => in_array($report->status, ['new', 'investigating', 'waiting_for_customer'], true))->count();
        $resolvedReports = $dailyReports->filter(fn ($report) => $report->status === 'resolved')->count();
        $criticalReports = $dailyReports->filter(fn ($report) => in_array($report->prioritas, ['Kritis', 'Critical'], true))->count();
        $avgResponseHours = 0;

        $statusBreakdown = [
            'new' => $dailyReports->where('status', 'new')->count(),
            'investigating' => $dailyReports->where('status', 'investigating')->count(),
            'waiting_for_customer' => $dailyReports->where('status', 'waiting_for_customer')->count(),
            'resolved' => $dailyReports->where('status', 'resolved')->count(),
            'rejected' => $dailyReports->where('status', 'rejected')->count(),
        ];

        $categoryBreakdown = $dailyReports->groupBy('kategori')->map(fn ($items, $category) => [
            'label' => $category ?: 'Tidak dikategorikan',
            'count' => $items->count(),
        ])->values();

        $recentActivities = $dailyReports->take(6);

        return view('admin.daily-summary', compact(
            'selectedDate',
            'dailyReports',
            'openReports',
            'resolvedReports',
            'criticalReports',
            'avgResponseHours',
            'statusBreakdown',
            'categoryBreakdown',
            'recentActivities'
        ));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
