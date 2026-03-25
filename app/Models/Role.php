<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'permissions',
        'is_system',
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_system'   => 'boolean',
    ];

    // ── Relations ──────────────────────────────────────────

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // ── Scopes ─────────────────────────────────────────────

    public function scopeAdmin($query)
    {
        return $query->where('slug', 'admin');
    }

    public function scopeSuperAdmin($query)
    {
        return $query->where('slug', 'super-admin');
    }

    // ── Helpers ────────────────────────────────────────────

    public function hasPermission(string $permission): bool
    {
        if (! is_array($this->permissions)) {
            return false;
        }
        return in_array('*', $this->permissions) || in_array($permission, $this->permissions);
    }

    public function grantPermission(string $permission): void
    {
        $permissions = $this->permissions ?? [];
        if (! in_array($permission, $permissions)) {
            $permissions[] = $permission;
            $this->update(['permissions' => $permissions]);
        }
    }

    public function revokePermission(string $permission): void
    {
        $permissions = array_filter($this->permissions ?? [], fn($p) => $p !== $permission);
        $this->update(['permissions' => array_values($permissions)]);
    }

    // ── Predefined roles ───────────────────────────────────

    public static function getDefaultPermissions(): array
    {
        return [
            'super-admin' => ['*'],
            'admin'       => [
                'dashboard.view',
                'users.view', 'users.create', 'users.edit', 'users.delete',
                'roles.view',
                'formations.view', 'formations.create', 'formations.edit', 'formations.delete',
                'articles.view', 'articles.create', 'articles.edit', 'articles.delete',
                'reviews.view', 'reviews.edit', 'reviews.delete',
                'contacts.view', 'contacts.edit', 'contacts.delete',
                'logs.view',
                'pages.view', 'pages.edit',
                'profile.edit',
            ],
            'editor' => [
                'dashboard.view',
                'formations.view', 'formations.create', 'formations.edit',
                'articles.view', 'articles.create', 'articles.edit',
                'reviews.view',
                'contacts.view',
                'profile.edit',
            ],
        ];
    }
}