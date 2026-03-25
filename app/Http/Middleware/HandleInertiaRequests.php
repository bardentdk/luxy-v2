<?php

namespace App\Http\Middleware;

use App\Models\Formation;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? [
                    'id'         => $request->user()->id,
                    'full_name'  => $request->user()->full_name,
                    'first_name' => $request->user()->first_name,
                    'last_name'  => $request->user()->last_name,
                    'email'      => $request->user()->email,
                    'avatar_url' => $request->user()->avatar_url,
                    'initials'   => $request->user()->initials,
                    'role'       => $request->user()->role ? [
                        'id'   => $request->user()->role->id,
                        'name' => $request->user()->role->name,
                        'slug' => $request->user()->role->slug,
                    ] : null,
                    'is_admin'         => $request->user()->isAdmin(),
                    'is_super_admin'   => $request->user()->isSuperAdmin(),
                ] : null,
            ],

            'flash' => [
                'success' => fn() => $request->session()->get('success'),
                'error'   => fn() => $request->session()->get('error'),
                'info'    => fn() => $request->session()->get('info'),
                'warning' => fn() => $request->session()->get('warning'),
            ],

            'app' => [
                'name'    => config('app.name'),
                'url'     => config('app.url'),
                'locale'  => app()->getLocale(),
            ],
        ]);
    }
}