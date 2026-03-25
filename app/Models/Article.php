<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Article extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'banner',
        'tags',
        'category',
        'is_published',
        'is_featured',
        'view_count',
        'read_time',
        'meta_title',
        'meta_description',
        'published_at',
    ];

    protected $casts = [
        'tags'         => 'array',
        'is_published' => 'boolean',
        'is_featured'  => 'boolean',
        'published_at' => 'datetime',
    ];

    // ── Slug automatique ───────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Article $article) {
            if (empty($article->slug)) {
                $article->slug = static::generateUniqueSlug($article->title);
            }
        });

        static::updating(function (Article $article) {
            if ($article->isDirty('title') && $article->slug === $article->getOriginal('slug')) {
                $article->slug = static::generateUniqueSlug($article->title, $article->id);
            }
        });
    }

    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base  = Str::slug($title);
        $slug  = $base;
        $count = 1;

        while (
            static::where('slug', $slug)
                  ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                  ->withTrashed()
                  ->exists()
        ) {
            $slug = "{$base}-{$count}";
            $count++;
        }

        return $slug;
    }

    // ── Activity log ───────────────────────────────────────

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'is_published'])
            ->logOnlyDirty()
            ->useLogName('article');
    }

    // ── Relations ──────────────────────────────────────────

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // ── Accessors ──────────────────────────────────────────

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : asset('images/article-placeholder.jpg');
    }

    public function getBannerUrlAttribute(): string
    {
        return $this->banner
            ? asset('storage/' . $this->banner)
            : asset('images/banner-placeholder.jpg');
    }

    public function getFormattedPublishedAtAttribute(): string
    {
        return $this->published_at
            ? $this->published_at->translatedFormat('d F Y')
            : '';
    }

    // ── Scopes ─────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    // ── Helpers ────────────────────────────────────────────

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }
}