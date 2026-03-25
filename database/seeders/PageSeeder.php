<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title'            => 'Mentions légales',
                'slug'             => 'mentions-legales',
                'meta_title'       => 'Mentions légales — Luxy Coaching & Formation',
                'meta_description' => 'Mentions légales de Luxy Coaching & Formation.',
                'content'          => '<h2>Mentions légales</h2><p>Contenu à compléter...</p>',
                'is_published'     => true,
            ],
            [
                'title'            => 'CGV',
                'slug'             => 'cgv',
                'meta_title'       => 'Conditions Générales de Vente',
                'meta_description' => 'CGV de Luxy Coaching & Formation.',
                'content'          => '<h2>Conditions Générales de Vente</h2><p>Contenu à compléter...</p>',
                'is_published'     => true,
            ],
            [
                'title'            => 'CGU',
                'slug'             => 'cgu',
                'meta_title'       => 'Conditions Générales d\'Utilisation',
                'meta_description' => 'CGU de Luxy Coaching & Formation.',
                'content'          => '<h2>Conditions Générales d\'Utilisation</h2><p>Contenu à compléter...</p>',
                'is_published'     => true,
            ],
            [
                'title'            => 'Politique des cookies',
                'slug'             => 'politique-cookies',
                'meta_title'       => 'Politique des cookies',
                'meta_description' => 'Politique des cookies de Luxy Coaching & Formation.',
                'content'          => '<h2>Politique des cookies</h2><p>Contenu à compléter...</p>',
                'is_published'     => true,
            ],
            [
                'title'            => 'Politique de confidentialité',
                'slug'             => 'politique-confidentialite',
                'meta_title'       => 'Politique de confidentialité',
                'meta_description' => 'Politique de confidentialité de Luxy Coaching & Formation.',
                'content'          => '<h2>Politique de confidentialité</h2><p>Contenu à compléter...</p>',
                'is_published'     => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }

        $this->command->info('✅ Pages légales créées');
    }
}