<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = BlogCategory::all();
        $user = User::find(43) ?? User::factory()->create(['name' => 'Expert CIB']);

        if ($categories->isEmpty()) {
            $this->command->warn("Veuillez peupler les catégories du blog avant de lancer ce seeder.");
            return;
        }

        $data = [
            [
                'title' => 'Maîtriser le Dossier de Permis de Construire au Cameroun',
                'summary' => 'Un guide étape par étape pour constituer votre dossier technique et administratif sans erreurs.',
                'duration' => '25:40',
                'level' => 'Intermédiaire',
                'youtube_id' => 'dQw4w9WgXcQ', // À remplacer par vos IDs réels
                'description' => '
                    <h2>Pourquoi le permis de construire est-il crucial ?</h2>
                    <p>Trop de projets au Cameroun sont arrêtés faute de conformité. Dans cette vidéo, nous détaillons :</p>
                    <ul>
                        <li>Les pièces graphiques nécessaires (plans de situation, masse, coupes).</li>
                        <li>Le rôle du certificat d\'urbanisme.</li>
                        <li>Les délais d\'obtention selon les mairies de ville (Douala, Yaoundé).</li>
                    </ul>
                    <blockquote>"Un chantier bien préparé administrativement est un chantier qui finit à temps."</blockquote>
                ',
            ],
            [
                'title' => 'Fondations Spéciales : Gérer les Sols Marécageux',
                'summary' => 'Découvrez les techniques de radier général et de pieux pour construire durablement en zone humide.',
                'duration' => '42:15',
                'level' => 'Avancé',
                'youtube_id' => 'u9Y_h68V0Yk',
                'description' => '
                    <h2>Techniques de fondations en zones difficiles</h2>
                    <p>Le littoral camerounais présente des défis géotechniques majeurs.</p>
                    <h3>Au programme de ce cours :</h3>
                    <ol>
                        <li>Interprétation d\'une étude de sol (Essai pénétrométrique).</li>
                        <li>Différence entre semelles isolées et radier.</li>
                        <li>Le dosage du béton pour les milieux agressifs.</li>
                    </ol>
                    <p>Nous analysons un cas réel de chantier réalisé par CIB Construction à Bonamoussadi.</p>
                ',
            ],
            [
                'title' => 'Lecture de Devis : Éviter les Pièges des Quantitatifs',
                'summary' => 'Apprenez à lire un Devis Estimatif (DQE) pour ne plus vous faire surprendre par les coûts imprévus.',
                'duration' => '15:20',
                'level' => 'Débutant',
                'youtube_id' => 'J3_8H-vO_wM',
                'description' => '
                    <h2>Ne soyez plus perdu face aux chiffres</h2>
                    <p>Beaucoup de clients se focalisent uniquement sur le prix final. Mais que contient réellement votre devis ?</p>
                    <ul>
                        <li>Comprendre les unités : m3, m2, ml et forfait.</li>
                        <li>Vérifier la qualité des matériaux spécifiés (Ciment 42.5 vs 32.5).</li>
                        <li>Les ratios acier/béton : comment savoir si on en met trop ou pas assez.</li>
                    </ul>
                ',
            ],
            [
                'title' => 'Étanchéité des Toitures-Terrasses au Cameroun',
                'summary' => 'Solutions durables contre les infiltrations d\'eau pendant la grande saison des pluies.',
                'duration' => '18:50',
                'level' => 'Intermédiaire',
                'youtube_id' => 'q7vX0T-6oJk',
                'description' => '
                    <h2>Dites adieu aux moisissures au plafond</h2>
                    <p>L\'humidité est l\'ennemi n°1 du bâtiment en zone équatoriale.</p>
                    <p>Nous passons en revue les différentes membranes :</p>
                    <ul>
                        <li>Le bitume armé (Paxalu).</li>
                        <li>Les résines polyuréthanes.</li>
                        <li>La gestion des pentes et des eaux pluviales (gargouilles).</li>
                    </ul>
                ',
            ]
        ];

        foreach ($data as $courseData) {
            Course::create([
                'user_id' => $user->id,
                'title' => $courseData['title'],
                'slug' => Str::slug($courseData['title']),
                'summary' => $courseData['summary'],
                'description' => $courseData['description'],
                'youtube_id' => $courseData['youtube_id'],
                'duration' => $courseData['duration'],
                'level' => $courseData['level'],
                'views_count' => rand(100, 5000),
                'blog_category_id' => $categories->random()->id,
                'is_published' => true,
                'published_at' => now()->subDays(rand(1, 60)),
            ]);
        }

        $this->command->info('Cours créés avec succès avec un contenu riche !');
    }
}
