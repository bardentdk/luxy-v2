<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Formation;
use App\Models\Review;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $featuredFormations = Formation::with('category')
            ->published()
            ->featured()
            ->ordered()
            ->limit(3)
            ->get()
            ->map(fn($f) => [
                'id'                => $f->id,
                'title'             => $f->title,
                'slug'              => $f->slug,
                'short_description' => $f->short_description,
                'thumbnail_url'     => $f->thumbnail_url,
                'level'             => $f->level,
                'duration'          => $f->duration,
                'current_price'     => $f->current_price,
                'price_promo'       => $f->price_promo,
                'is_on_promo'       => $f->is_on_promo,
                'has_certification' => $f->has_certification,
                'average_rating'    => $f->average_rating,
                'category'          => $f->category?->only(['name', 'slug', 'icon', 'color']),
            ]);

        $featuredReviews = Review::with('formation')
            ->approved()
            ->featured()
            ->highRated()
            ->latest()
            ->limit(6)
            ->get()
            ->map(fn($r) => [
                'id'             => $r->id,
                'reviewer_name'  => $r->reviewer_name,
                'reviewer_job'   => $r->reviewer_job,
                'reviewer_avatar'=> $r->reviewer_avatar,
                'rating'         => $r->rating,
                'comment'        => $r->comment,
                'formation'      => $r->formation?->only(['title', 'slug']),
            ]);

        $latestArticles = Article::with('author')
            ->published()
            ->latest()
            ->limit(3)
            ->get()
            ->map(fn($a) => [
                'id'                    => $a->id,
                'title'                 => $a->title,
                'slug'                  => $a->slug,
                'excerpt'               => $a->excerpt,
                'thumbnail_url'         => $a->thumbnail_url,
                'formatted_published_at'=> $a->formatted_published_at,
                'read_time'             => $a->read_time,
                'author'                => $a->author?->only(['full_name', 'avatar_url']),
            ]);

        $stats = [
            'formations' => Formation::published()->count(),
            'reviews'    => Review::approved()->count(),
            'students'   => 320,   // Peut être dynamique si table étudiants existe
            'years'      => (int) date('Y') - 2018,
        ];

        return Inertia::render('Public/Home', compact(
            'featuredFormations',
            'featuredReviews',
            'latestArticles',
            'stats',
        ));
    }
}