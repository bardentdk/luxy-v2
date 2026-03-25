<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::where('slug', 'super-admin')->first();

        User::updateOrCreate(
            ['email' => 'admin@luxyformation.re'],
            [
                'first_name' => 'Super',
                'last_name'  => 'Admin',
                'password'   => Hash::make('Luxy@2026!'),
                'role_id'    => $superAdminRole?->id,
                'is_active'  => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Super admin créé — admin@luxyformation.re / Luxy@2026!');
        $this->command->warn('⚠️  Changez le mot de passe dès la première connexion !');
    }
}