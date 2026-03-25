<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormationCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FormationCategoryController extends Controller
{
    public function index(): Response
    {
        $categories = FormationCategory::ordered()
            ->withCount(['formations' => fn($q) => $q->published()])
            ->withCount('formations as formations_total')
            ->get()
            ->map(fn($c) => [
                'id'               => $c->id,
                'name'             => $c->name,
                'slug'             => $c->slug,
                'description'      => $c->description,
                'icon'             => $c->icon,
                'color'            => $c->color,
                'sort_order'       => $c->sort_order,
                'formations_count' => $c->formations_total,
            ]);

        return Inertia::render('Admin/FormationCategories/Index', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:150', 'unique:formation_categories,name'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'color'       => ['nullable', 'string', 'max:50'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required' => 'Le nom de la catégorie est obligatoire.',
            'name.unique'   => 'Une catégorie avec ce nom existe déjà.',
            'name.max'      => 'Le nom ne peut pas dépasser 150 caractères.',
        ]);

        FormationCategory::create($data);

        return back()->with('success', 'Catégorie créée avec succès.');
    }

    public function update(Request $request, FormationCategory $formationCategory): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:150', 'unique:formation_categories,name,' . $formationCategory->id],
            'description' => ['nullable', 'string', 'max:500'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'color'       => ['nullable', 'string', 'max:50'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required' => 'Le nom de la catégorie est obligatoire.',
            'name.unique'   => 'Une catégorie avec ce nom existe déjà.',
        ]);

        $formationCategory->update($data);

        return back()->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(FormationCategory $formationCategory): RedirectResponse
    {
        if ($formationCategory->formations()->count() > 0) {
            return back()->with('error', "Impossible de supprimer cette catégorie : elle contient {$formationCategory->formations()->count()} formation(s). Réaffectez-les d'abord.");
        }

        $formationCategory->delete();

        return back()->with('success', 'Catégorie supprimée.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $request->validate([
            'items'         => ['required', 'array'],
            'items.*.id'    => ['required', 'integer', 'exists:formation_categories,id'],
            'items.*.order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($request->items as $item) {
            FormationCategory::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }

        return back()->with('success', 'Ordre mis à jour.');
    }
}