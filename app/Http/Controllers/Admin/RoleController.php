<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    public function index(): Response
    {
        $roles = Role::withCount('users')->get()->map(fn($r) => [
            'id'          => $r->id,
            'name'        => $r->name,
            'slug'        => $r->slug,
            'description' => $r->description,
            'permissions' => $r->permissions,
            'is_system'   => $r->is_system,
            'users_count' => $r->users_count,
        ]);

        $allPermissions = $this->getAllPermissions();

        return Inertia::render('Admin/Roles/Index', compact('roles', 'allPermissions'));
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Roles/Form', [
            'allPermissions' => $this->getAllPermissions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'slug'        => ['required', 'string', 'max:100', 'unique:roles,slug'],
            'description' => ['nullable', 'string', 'max:500'],
            'permissions' => ['nullable', 'array'],
        ]);

        Role::create($data);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle créé avec succès.');
    }

    public function edit(Role $role): Response
    {
        return Inertia::render('Admin/Roles/Form', [
            'role'           => $role->toArray(),
            'allPermissions' => $this->getAllPermissions(),
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'permissions' => ['nullable', 'array'],
        ]);

        $role->update($data);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle mis à jour avec succès.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->is_system) {
            return back()->with('error', 'Impossible de supprimer un rôle système.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', 'Ce rôle est attribué à des utilisateurs. Retirez-le d\'abord.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle supprimé.');
    }

    private function getAllPermissions(): array
    {
        return [
            'Dashboard'  => ['dashboard.view'],
            'Utilisateurs' => ['users.view', 'users.create', 'users.edit', 'users.delete'],
            'Rôles'      => ['roles.view', 'roles.create', 'roles.edit', 'roles.delete'],
            'Formations' => ['formations.view', 'formations.create', 'formations.edit', 'formations.delete'],
            'Articles'   => ['articles.view', 'articles.create', 'articles.edit', 'articles.delete'],
            'Avis'       => ['reviews.view', 'reviews.edit', 'reviews.delete'],
            'Contacts'   => ['contacts.view', 'contacts.edit', 'contacts.delete'],
            'Logs'       => ['logs.view'],
            'Pages'      => ['pages.view', 'pages.edit'],
            'Profil'     => ['profile.edit'],
        ];
    }
}