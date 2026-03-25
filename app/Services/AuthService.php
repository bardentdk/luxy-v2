<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService
{
    /**
     * Tenter une connexion.
     */
    public function attemptLogin(string $email, string $password, bool $remember = false): bool
    {
        $credentials = ['email' => $email, 'password' => $password];

        if (! Auth::attempt($credentials, $remember)) {
            return false;
        }

        $user = Auth::user();

        // Vérifier que le compte est actif
        if (! $user->is_active) {
            Auth::logout();
            return false;
        }

        // Mettre à jour les infos de connexion
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);

        request()->session()->regenerate();

        Log::info('User logged in', ['user_id' => $user->id, 'email' => $user->email]);

        return true;
    }

    /**
     * Déconnecter l'utilisateur.
     */
    public function logout(): void
    {
        $userId = Auth::id();
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        Log::info('User logged out', ['user_id' => $userId]);
    }

    /**
     * Créer un nouvel utilisateur.
     */
    public function register(array $data): User
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'] ?? null,
            'password'   => Hash::make($data['password']),
            'role_id'    => $data['role_id'] ?? null,
            'is_active'  => true,
        ]);
    }

    /**
     * Mettre à jour le profil d'un utilisateur.
     */
    public function updateProfile(User $user, array $data): User
    {
        $updateData = [
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'] ?? null,
        ];

        if (! empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        if (isset($data['avatar'])) {
            $updateData['avatar'] = $data['avatar'];
        }

        $user->update($updateData);
        return $user->fresh();
    }
}