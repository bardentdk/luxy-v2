<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageView extends Model
{
    protected $fillable = [
        'url',
        'route_name',
        'ip_address',
        'user_agent',
        'referer',
        'country',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $url, ?string $routeName = null): void
    {
        static::create([
            'url'        => substr($url, 0, 1000),
            'route_name' => $routeName,
            'ip_address' => request()->ip(),
            'user_agent' => substr(request()->userAgent() ?? '', 0, 500),
            'referer'    => substr(request()->header('referer') ?? '', 0, 500),
            'user_id'    => auth()->id(),
        ]);
    }
}