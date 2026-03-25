<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Review;
use Inertia\Inertia;
use Inertia\Response;

class ReviewController extends Controller
{
    public function index(): Response
    {
        $reviews = Review::with('formation')
            ->approved()
            ->latest()
            ->paginate(12)
            ->through(fn($r) => [
                'id'             => $r->id,
                'reviewer_name'  => $r->reviewer_name,
                'reviewer_job'   => $r->reviewer_job,
                'reviewer_avatar'=> $r->reviewer_avatar,
                'rating'         => $r->rating,
                'comment'        => $r->comment,
                'formation'      => $r->formation?->only(['title', 'slug']),
                'created_at'     => $r->created_at->translatedFormat('F Y'),
            ]);

        $stats = [
            'average' => round(Review::approved()->avg('rating'), 1),
            'total'   => Review::approved()->count(),
            'five'    => Review::approved()->where('rating', 5)->count(),
            'four'    => Review::approved()->where('rating', 4)->count(),
            'three'   => Review::approved()->where('rating', 3)->count(),
        ];

        return Inertia::render('Public/Avis', compact('reviews', 'stats'));
    }
}