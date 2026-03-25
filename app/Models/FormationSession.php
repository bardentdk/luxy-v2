<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormationSession extends Model
{
    protected $fillable = [
        'formation_id',
        'label',
        'start_date',
        'end_date',
        'schedule',
        'location',
        'modality',
        'seats_total',
        'seats_taken',
        'price_override',
        'is_open',
        'is_published',
        'notes',
    ];

    protected $casts = [
        'start_date'     => 'date',
        'end_date'       => 'date',
        'is_open'        => 'boolean',
        'is_published'   => 'boolean',
        'price_override' => 'decimal:2',
    ];

    // ── Relations ──────────────────────────────────────────

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    // ── Accessors ──────────────────────────────────────────

    public function getSeatsAvailableAttribute(): ?int
    {
        if ($this->seats_total === null) return null;
        return max(0, $this->seats_total - $this->seats_taken);
    }

    public function getIsFullAttribute(): bool
    {
        if ($this->seats_total === null) return false;
        return $this->seats_taken >= $this->seats_total;
    }

    public function getModalityLabelAttribute(): string
    {
        return match ($this->modality) {
            'presentiel'  => 'Présentiel',
            'distanciel'  => 'En ligne',
            'hybride'     => 'Hybride',
            default       => $this->modality,
        };
    }

    public function getModalityColorAttribute(): string
    {
        return match ($this->modality) {
            'presentiel'  => '#0D9488',
            'distanciel'  => '#3B82F6',
            'hybride'     => '#8B5CF6',
            default       => '#6B7280',
        };
    }

    public function getFormattedStartDateAttribute(): string
    {
        return $this->start_date->translatedFormat('d F Y');
    }

    public function getFormattedEndDateAttribute(): ?string
    {
        return $this->end_date?->translatedFormat('d F Y');
    }

    public function getStatusAttribute(): string
    {
        if (! $this->is_open || $this->is_full) return 'complet';
        if ($this->start_date->isPast()) return 'en_cours';
        if ($this->start_date->diffInDays(now()) <= 7) return 'bientot';
        return 'ouvert';
    }

    // ── Scopes ─────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->subDay())
                     ->orderBy('start_date');
    }

    public function scopeOpen($query)
    {
        return $query->where('is_open', true);
    }
}