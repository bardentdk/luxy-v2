<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = Role::getDefaultPermissions();

        foreach ($defaults as $slug => $permissions) {
            Role::updateOrCreate(
                ['slug' => $slug],
                [
                    'name'        => ucfirst(str_replace('-', ' ', $slug)),
                    'permissions' => $permissions,
                    'is_system'   => true,
                ]
            );
        }

        $this->command->info('✅ Rôles créés : super-admin, admin, editor');
    }
}