@extends('layouts.app')

@section('content')
<div class="admin-dashboard-page">
    <div class="container py-5">
        <div class="admin-panel">
            <h2>{{ $article->title }}</h2>
            <p class="text-white-50">{{ $article->category }} • {{ $article->status }}</p>
            <div class="mt-3">{!! nl2br(e($article->content)) !!}</div>
            <div class="mt-4">
                <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-cyber-red">Edit</a>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-cyber-outline">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
