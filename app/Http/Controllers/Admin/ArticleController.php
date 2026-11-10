<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereJsonContains('tags', $search);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('year')) {
            $query->whereYear('published_at', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('published_at', $request->month);
        }

        $articles = $query->latest()->paginate(10)->appends($request->query());
        $categories = Article::validCategories();
        $archives = Article::published()
            ->selectRaw('YEAR(published_at) as year, MONTH(published_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.articles.index', compact('articles', 'categories', 'archives'));
    }

    public function create()
    {
        return view('admin.articles.form', [
            'article' => new Article(),
            'method' => 'POST',
            'routeName' => 'admin.articles.store',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image_url' => 'nullable|string|max:255',
            'status' => 'required|in:published,draft',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if (empty($validated['excerpt'])) {
            $validated['excerpt'] = Str::limit(strip_tags($validated['content']), 160);
        }

        if (! empty($validated['published_at']) && $validated['status'] === 'published') {
            $validated['published_at'] = $validated['published_at'];
        } elseif ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        } else {
            $validated['published_at'] = null;
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dibuat.');
    }

    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('admin.articles.form', [
            'article' => $article,
            'method' => 'PUT',
            'routeName' => 'admin.articles.update',
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image_url' => 'nullable|string|max:255',
            'status' => 'required|in:published,draft',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if (empty($validated['excerpt'])) {
            $validated['excerpt'] = Str::limit(strip_tags($validated['content']), 160);
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = $validated['published_at'] ?? now();
        } else {
            $validated['published_at'] = null;
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
