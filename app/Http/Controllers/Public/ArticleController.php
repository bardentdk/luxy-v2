<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(): Response
    {
        $articles = Article::with('author')
            ->published()
            ->latest()
            ->paginate(9)
            ->through(fn($a) => [
                'id'                    => $a->id,
                'title'                 => $a->title,
                'slug'                  => $a->slug,
                'excerpt'               => $a->excerpt,
                'thumbnail_url'         => $a->thumbnail_url,
                'read_time'             => $a->read_time,
                'formatted_published_at'=> $a->formatted_published_at,
                'author'                => $a->author?->only(['full_name', 'avatar_url']),
                'tags'                  => $a->tags,
            ]);

        return Inertia::render('Public/VieduCentre', compact('articles'));
    }

    public function show(string $slug): Response
    {
        $article = Article::with('author')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $article->incrementViewCount();

        return Inertia::render('Public/ArticleShow', [
            'article' => [
                'id'                    => $article->id,
                'title'                 => $article->title,
                'excerpt'               => $article->excerpt,
                'content'               => $article->content,
                'banner_url'            => $article->banner_url,
                'thumbnail_url'         => $article->thumbnail_url,
                'read_time'             => $article->read_time,
                'formatted_published_at'=> $article->formatted_published_at,
                'tags'                  => $article->tags,
                'author'                => $article->author?->only(['full_name', 'avatar_url']),
                'meta_title'            => $article->meta_title,
                'meta_description'      => $article->meta_description,
            ],
        ]);
    }
}