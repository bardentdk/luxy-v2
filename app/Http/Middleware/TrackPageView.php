<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // On ne track que les GET et pas les pages admin
        if ($request->isMethod('GET') && ! $request->is('admin/*')) {
            PageView::record(
                url: $request->fullUrl(),
                routeName: $request->route()?->getName(),
            );
        }

        return $response;
    }
}