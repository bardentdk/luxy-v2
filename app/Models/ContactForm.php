<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'subject',
        'message',
        'formation_interest',
        'is_read',
        'is_replied',
        'admin_notes',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'is_read'    => 'boolean',
        'is_replied' => 'boolean',
    ];

    // ── Scopes ─────────────────────────────────────────────

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeUnreplied($query)
    {
        return $query->where('is_replied', false);
    }

    // ── Helpers ────────────────────────────────────────────

    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }

    public function markAsReplied(): void
    {
        $this->update(['is_replied' => true]);
    }
}