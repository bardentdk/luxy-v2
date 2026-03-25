<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {}

    public function edit(): Response
    {
        return Inertia::render('Admin/Profile', [
            'user' => auth()->user()->only([
                'id', 'first_name', 'last_name', 'email', 'phone', 'avatar_url',
            ]),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'first_name'            => ['required', 'string', 'max:100'],
            'last_name'             => ['required', 'string', 'max:100'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'phone'                 => ['nullable', 'string', 'max:20'],
            'password'              => ['nullable', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['nullable'],
            'avatar'                => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            $user = auth()->user();
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $filename = 'avatars/' . $user->id . '_' . time() . '.webp';
            $image = Image::read($request->file('avatar')->getPathname())
                ->cover(256, 256)
                ->toWebp(90);
            Storage::disk('public')->put($filename, (string) $image);
            $data['avatar'] = $filename;
        }

        $this->authService->updateProfile(auth()->user(), $data);

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}