<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReviewController extends Controller
{
    public function index(Request $request): Response
    {
        $reviews = Review::with('formation')
            ->when($request->status === 'pending', fn($q) => $q->where('is_approved', false))
            ->when($request->status === 'approved', fn($q) => $q->approved())
            ->latest()
            ->paginate(20)
            ->through(fn($r) => [
                'id'             => $r->id,
                'reviewer_name'  => $r->reviewer_name,
                'reviewer_email' => $r->reviewer_email,
                'reviewer_job'   => $r->reviewer_job,
                'rating'         => $r->rating,
                'comment'        => $r->comment,
                'is_approved'    => $r->is_approved,
                'is_featured'    => $r->is_featured,
                'formation'      => $r->formation?->only(['title', 'slug']),
                'created_at'     => $r->created_at->translatedFormat('d/m/Y'),
            ]);

        return Inertia::render('Admin/Reviews/Index', compact('reviews'));
    }

    public function approve(Review $review): RedirectResponse
    {
        $review->update(['is_approved' => true]);
        return back()->with('success', 'Avis approuvé.');
    }

    public function reject(Review $review): RedirectResponse
    {
        $review->update(['is_approved' => false]);
        return back()->with('success', 'Avis rejeté.');
    }

    public function toggleFeatured(Review $review): RedirectResponse
    {
        $review->update(['is_featured' => ! $review->is_featured]);
        return back()->with('success', 'Avis mis à jour.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Avis supprimé.');
    }
}