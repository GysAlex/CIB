<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Catégories Métier
        $categories = [
            ['name' => 'Actualités', 'description' => 'Toutes les nouvelles de CIB Construction.'],
            ['name' => 'Innovation & BIM', 'description' => 'Technologie 3D, modélisation et futur du bâtiment.'],
            ['name' => 'Conseils & Guides', 'description' => 'Aide à la planification et gestion de budget.'],
            ['name' => 'Réalisations', 'description' => 'Focus sur nos chantiers emblématiques au Cameroun.'],
            ['name' => 'Réglementation', 'description' => 'Urbanisme et permis de bâtir.'],
        ];

        foreach ($categories as $cat) {
            BlogCategory::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
            ]);
        }

        // 2. Tags Spécialisés
        $tags = [
            'Béton Armé',
            'Second Œuvre',
            'Gros Œuvre',
            'Design Intérieur',
            'Architecture Moderne',
            'Efficacité Énergétique',
            'Douala',
            'Yaoundé',
            'Villas de Luxe',
            'Permis de Bâtir',
            '3D Rendering',
            'Matériaux Locaux'
        ];

        foreach ($tags as $tagName) {
            BlogTag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);
        }
    }
}
