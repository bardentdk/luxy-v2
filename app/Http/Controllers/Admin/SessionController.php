<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\FormationSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SessionController extends Controller
{
    public function index(Formation $formation): Response
    {
        $sessions = $formation->sessions()
            ->orderBy('start_date')
            ->get()
            ->map(fn($s) => [
                'id'                   => $s->id,
                'label'                => $s->label,
                'start_date'           => $s->start_date->format('Y-m-d'),
                'end_date'             => $s->end_date?->format('Y-m-d'),
                'formatted_start_date' => $s->formatted_start_date,
                'formatted_end_date'   => $s->formatted_end_date,
                'schedule'             => $s->schedule,
                'location'             => $s->location,
                'modality'             => $s->modality,
                'modality_label'       => $s->modality_label,
                'modality_color'       => $s->modality_color,
                'seats_total'          => $s->seats_total,
                'seats_taken'          => $s->seats_taken,
                'seats_available'      => $s->seats_available,
                'is_full'              => $s->is_full,
                'is_open'              => $s->is_open,
                'is_published'         => $s->is_published,
                'price_override'       => $s->price_override,
                'status'               => $s->status,
                'notes'                => $s->notes,
            ]);

        return Inertia::render('Admin/Sessions/Index', [
            'formation' => $formation->only(['id', 'title', 'slug', 'thumbnail_url']),
            'sessions'  => $sessions,
        ]);
    }

    public function store(Request $request, Formation $formation): RedirectResponse
    {
        $data = $request->validate([
            'label'          => ['nullable', 'string', 'max:150'],
            'start_date'     => ['required', 'date'],
            'end_date'       => ['nullable', 'date', 'after_or_equal:start_date'],
            'schedule'       => ['nullable', 'string', 'max:150'],
            'location'       => ['nullable', 'string', 'max:200'],
            'modality'       => ['required', 'in:presentiel,distanciel,hybride'],
            'seats_total'    => ['nullable', 'integer', 'min:1'],
            'price_override' => ['nullable', 'numeric', 'min:0'],
            'is_open'        => ['boolean'],
            'is_published'   => ['boolean'],
            'notes'          => ['nullable', 'string', 'max:1000'],
        ]);

        $formation->sessions()->create($data);

        return back()->with('success', 'Session créée avec succès.');
    }

    public function update(Request $request, Formation $formation, FormationSession $session): RedirectResponse
    {
        $data = $request->validate([
            'label'          => ['nullable', 'string', 'max:150'],
            'start_date'     => ['required', 'date'],
            'end_date'       => ['nullable', 'date', 'after_or_equal:start_date'],
            'schedule'       => ['nullable', 'string', 'max:150'],
            'location'       => ['nullable', 'string', 'max:200'],
            'modality'       => ['required', 'in:presentiel,distanciel,hybride'],
            'seats_total'    => ['nullable', 'integer', 'min:1'],
            'seats_taken'    => ['nullable', 'integer', 'min:0'],
            'price_override' => ['nullable', 'numeric', 'min:0'],
            'is_open'        => ['boolean'],
            'is_published'   => ['boolean'],
            'notes'          => ['nullable', 'string', 'max:1000'],
        ]);

        $session->update($data);

        return back()->with('success', 'Session mise à jour.');
    }

    public function destroy(Formation $formation, FormationSession $session): RedirectResponse
    {
        $session->delete();
        return back()->with('success', 'Session supprimée.');
    }

    public function toggle(Formation $formation, FormationSession $session): RedirectResponse
    {
        $session->update(['is_open' => ! $session->is_open]);
        $label = $session->is_open ? 'ouverte' : 'fermée';
        return back()->with('success', "Session {$label} aux inscriptions.");
    }
}