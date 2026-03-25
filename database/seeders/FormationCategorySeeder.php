<?php

namespace Database\Seeders;

use App\Models\FormationCategory;
use Illuminate\Database\Seeder;

class FormationCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Formation professionnelle', 'icon' => 'PhBriefcase',        'color' => 'blue'],
            ['name' => 'Soutien scolaire',           'icon' => 'PhBooks',            'color' => 'green'],
            ['name' => 'Informatique & Digital',     'icon' => 'PhMonitor',          'color' => 'purple'],
            ['name' => 'Management & Leadership',    'icon' => 'PhUsers',            'color' => 'amber'],
            ['name' => 'Langues',                    'icon' => 'PhTranslate',        'color' => 'coral'],
            ['name' => 'Certification',              'icon' => 'PhCertificate',      'color' => 'gold'],
        ];

        foreach ($categories as $i => $cat) {
            FormationCategory::updateOrCreate(
                ['name' => $cat['name']],
                array_merge($cat, ['sort_order' => $i])
            );
        }

        $this->command->info('✅ Catégories de formation créées');
    }
}