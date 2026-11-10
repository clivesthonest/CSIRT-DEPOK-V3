<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'image_url',
        'status',
        'published_at',
        'tags',
        'related_posts',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'tags' => 'array',
        'related_posts' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $article) {
            $article->slug = $article->slug ?: Str::slug($article->title);
        });

        static::updating(function (self $article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    public static function validCategories(): array
    {
        return [
            'Peringatan Keamanan',
            'Vulnerability',
            'Malware',
            'Phishing',
            'Awareness',
            'Best Practice',
            'Update Sistem',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function tagList(): array
    {
        return array_values(array_filter((array) ($this->tags ?? []), fn ($tag) => is_string($tag) && trim($tag) !== ''));
    }

    public function relatedArticles()
    {
        if (empty($this->related_posts)) {
            return collect();
        }

        return self::whereIn('id', $this->related_posts)
            ->where('status', 'published')
            ->get();
    }
}
