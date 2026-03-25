<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FormationRequest;
use App\Models\Formation;
use App\Models\FormationCategory;
use App\Services\FormationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FormationController extends Controller
{
    public function __construct(private readonly FormationService $formationService)
    {}

    public function index(Request $request): Response
    {
        $formations = Formation::with(['category', 'author'])
            ->when($request->search, fn($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when($request->status === 'published', fn($q) => $q->published())
            ->when($request->status === 'draft', fn($q) => $q->where('is_published', false))
            ->latest()
            ->paginate(15)
            ->through(fn($f) => [
                'id'           => $f->id,
                'title'        => $f->title,
                'slug'         => $f->slug,
                'thumbnail_url'=> $f->thumbnail_url,
                'level'        => $f->level,
                'is_published' => $f->is_published,
                'is_featured'  => $f->is_featured,
                'view_count'   => $f->view_count,
                'current_price'=> $f->current_price,
                'category'     => $f->category?->only(['name', 'slug']),
                'created_at'   => $f->created_at->translatedFormat('d/m/Y'),
            ]);

        $categories = FormationCategory::ordered()->get(['id', 'name', 'slug']);

        return Inertia::render('Admin/Formations/Index', compact('formations', 'categories'));
    }

    public function create(): Response
    {
        $categories = FormationCategory::ordered()->get(['id', 'name', 'slug']);
        return Inertia::render('Admin/Formations/Form', compact('categories'));
    }

    public function store(FormationRequest $request): RedirectResponse
    {
        $this->formationService->create(
            $request->validated(),
            $request->file('thumbnail'),
            $request->file('banner'),
        );

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation créée avec succès.');
    }

    public function edit(Formation $formation): Response
    {
        $categories = FormationCategory::ordered()->get(['id', 'name', 'slug']);
        return Inertia::render('Admin/Formations/Form', [
            'formation' => $formation->toArray(),
            'categories'=> $categories,
        ]);
    }

    public function update(FormationRequest $request, Formation $formation): RedirectResponse
    {
        $this->formationService->update(
            $formation,
            $request->validated(),
            $request->file('thumbnail'),
            $request->file('banner'),
        );

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation mise à jour avec succès.');
    }

    public function destroy(Formation $formation): RedirectResponse
    {
        $this->formationService->delete($formation);

        return redirect()->route('admin.formations.index')
            ->with('success', 'Formation supprimée avec succès.');
    }

    public function togglePublish(Formation $formation): RedirectResponse
    {
        $formation->update([
            'is_published' => ! $formation->is_published,
            'published_at' => ! $formation->is_published ? now() : $formation->published_at,
        ]);

        $status = $formation->is_published ? 'publiée' : 'dépubliée';
        return back()->with('success', "Formation {$status} avec succès.");
    }
}