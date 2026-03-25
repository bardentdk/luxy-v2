<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id',
        'reviewer_name',
        'reviewer_email',
        'reviewer_job',
        'reviewer_avatar',
        'rating',
        'comment',
        'is_approved',
        'is_featured',
    ];

    protected $casts = [
        'rating'      => 'integer',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // ── Relations ──────────────────────────────────────────

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    // ── Scopes ─────────────────────────────────────────────

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeHighRated($query, int $minRating = 4)
    {
        return $query->where('rating', '>=', $minRating);
    }
}