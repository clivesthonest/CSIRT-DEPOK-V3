<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('status', 'published')->latest('published_at')->paginate(6);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        abort_unless($article->status === 'published', 404);

        $related = collect();
        $relatedIds = array_values(array_filter((array) ($article->related_posts ?? []), 'is_numeric'));

        if (! empty($relatedIds)) {
            $related = Article::where('status', 'published')
                ->whereIn('id', $relatedIds)
                ->where('id', '!=', $article->id)
                ->get();
        }

        if ($related->count() < 3) {
            $fallback = Article::where('status', 'published')
                ->where('id', '!=', $article->id)
                ->when($article->category, fn ($query) => $query->where('category', $article->category))
                ->latest('published_at')
                ->take(3)
                ->get();

            $related = $related->merge($fallback)->unique('id')->take(3);
        }

        return view('articles.show', compact('article', 'related'));
    }
}
