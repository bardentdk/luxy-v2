<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function show(string $slug): Response
    {
        $page = Page::findBySlug($slug) ?? abort(404);

        return Inertia::render('Public/StaticPage', [
            'page' => $page->only(['title', 'content', 'meta_title', 'meta_description']),
        ]);
    }
}