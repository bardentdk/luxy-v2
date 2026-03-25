<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {}

    public function index(Request $request): Response
    {
        $users = User::with('role')
            ->when($request->search, fn($q, $s) => $q->where(fn($q) =>
                $q->where('first_name', 'like', "%{$s}%")
                  ->orWhere('last_name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
            ))
            ->when($request->role, fn($q, $r) => $q->whereHas('role', fn($q) => $q->where('slug', $r)))
            ->latest()
            ->paginate(15)
            ->through(fn($u) => [
                'id'         => $u->id,
                'full_name'  => $u->full_name,
                'email'      => $u->email,
                'phone'      => $u->phone,
                'avatar_url' => $u->avatar_url,
                'is_active'  => $u->is_active,
                'role'       => $u->role?->only(['id', 'name', 'slug']),
                'created_at' => $u->created_at->translatedFormat('d/m/Y'),
                'last_login_at' => $u->last_login_at?->diffForHumans(),
            ]);

        $roles = Role::all(['id', 'name', 'slug']);

        return Inertia::render('Admin/Users/Index', compact('users', 'roles'));
    }

    public function create(): Response
    {
        $roles = Role::all(['id', 'name', 'slug']);
        return Inertia::render('Admin/Users/Form', compact('roles'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $this->authService->register($request->validated());

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $user): Response
    {
        $roles = Role::all(['id', 'name', 'slug']);
        return Inertia::render('Admin/Users/Form', [
            'user'  => $user->only(['id', 'first_name', 'last_name', 'email', 'phone', 'role_id', 'is_active', 'avatar_url']),
            'roles' => $roles,
        ]);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Impossible de supprimer un super administrateur.');
        }
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function toggleActive(User $user): RedirectResponse
    {
        $user->update(['is_active' => ! $user->is_active]);
        $status = $user->is_active ? 'activé' : 'désactivé';

        return back()->with('success', "Compte {$status} avec succès.");
    }
}