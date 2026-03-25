<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Intervention\Image\Laravel\Facades\Image;

class ArticleController extends Controller
{
    public function index(Request $request): Response
    {
        $articles = Article::with('author')
            ->when($request->search, fn($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when($request->status === 'published', fn($q) => $q->published())
            ->when($request->status === 'draft', fn($q) => $q->where('is_published', false))
            ->latest()
            ->paginate(15)
            ->through(fn($a) => [
                'id'           => $a->id,
                'title'        => $a->title,
                'slug'         => $a->slug,
                'thumbnail_url'=> $a->thumbnail_url,
                'is_published' => $a->is_published,
                'is_featured'  => $a->is_featured,
                'view_count'   => $a->view_count,
                'read_time'    => $a->read_time,
                'author'       => $a->author?->only(['full_name']),
                'created_at'   => $a->created_at->translatedFormat('d/m/Y'),
            ]);

        return Inertia::render('Admin/Articles/Index', compact('articles'));
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Articles/Form');
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['author_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->uploadThumbnail($request->file('thumbnail'));
        }

        if (! empty($data['is_published']) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article créé avec succès.');
    }

    public function edit(Article $article): Response
    {
        return Inertia::render('Admin/Articles/Form', [
            'article' => $article->toArray() + ['thumbnail_url' => $article->thumbnail_url],
        ]);
    }

    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $data['thumbnail'] = $this->uploadThumbnail($request->file('thumbnail'));
        }

        if (! empty($data['is_published']) && ! $article->published_at) {
            $data['published_at'] = now();
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article supprimé avec succès.');
    }

    private function uploadThumbnail($file): string
    {
        $filename = uniqid() . '_' . time() . '.webp';
        $path     = 'articles/thumbnails/' . $filename;

        $image = Image::read($file->getPathname())
            ->cover(800, 500)
            ->toWebp(85);

        Storage::disk('public')->put($path, (string) $image);
        return $path;
    }
}