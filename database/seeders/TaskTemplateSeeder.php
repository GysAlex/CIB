<?php

namespace Database\Seeders;

use App\Models\CategoryTemplate;
use App\Models\TaskTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // On vide les tables pour éviter les doublons si on relance le seeder
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CategoryTemplate::truncate();
        TaskTemplate::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $templates = [
            "PLANS ARCHITECTURE" => [
                "PLAN DE MASSE",
                "PLANS DISTRIBUTION",
                "FACADES",
                "COUPES",
                "3D",
                "DETAILS",
                "NOMENCLATURES",
            ],
            "PLANS STRUCTURE" => [
                "PLANS COFFRAGE",
                "PLANS FERRAILLAGE",
                "DETAILS",
                "NOMENCLATURE",
            ],
            "PLANS PLOMBERIE" => [
                "PLANS EVACUATION",
                "PLANS ALIMENTATION",
                "DETAILS",
                "NOMENCLATURE",
            ],
            "PLANS ELECTRICITE" => [
                "PLAN ECLAIRAGE",
                "PRISES CONFORT",
                "PLANS DE SECURITE",
                "CONTROLE ACCES",
                "NOMENCLATURE",
            ],
            "NOTE DE CALCUL" => [
                "STRUCTURE",
                "PLOMBERIE",
                "COURANT FORT",
                "COURANT FAIBLE",
                "CLIMATISATION",
            ],
            "DOCUMENTS CONTRACTUELS" => [
                "DEVIS DESCRIPTIF",
                "DEVIS QUANTITATIF",
                "DEVIS ESTIMATION",
            ],
        ];

        $categoryOrder = 1;

        foreach ($templates as $categoryTitle => $tasks) {
            // 1. Création de la catégorie dans le catalogue
            $category = CategoryTemplate::create([
                'title' => $categoryTitle,
                'order' => $categoryOrder++,
                'is_active' => true,
            ]);

            // 2. Création des tâches liées à cette catégorie
            foreach ($tasks as $index => $taskTitle) {
                TaskTemplate::create([
                    'category_template_id' => $category->id,
                    'title' => $taskTitle,
                    'description' => "Procédure standard pour le livrable : " . strtolower($taskTitle),
                    'expected_deliverable' => $this->inferDeliverable($categoryTitle),
                    'default_priority' => 'medium',
                ]);
            }
        }
    }

    private function inferDeliverable(string $category): string
    {
        return match (true) {
            str_contains($category, 'PLANS') => 'Fichier PDF / DWG',
            str_contains($category, 'NOTE') => 'Rapport PDF technique',
            str_contains($category, 'DEVIS') => 'Tableau Excel / PDF signé',
            default => 'Document technique',
        };
    }
}
