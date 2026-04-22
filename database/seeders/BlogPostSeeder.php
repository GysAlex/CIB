<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
    */
    public function run(): void
    {
        // On récupère les données de base pour les lier
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        $admin = User::first() ?? User::factory()->create();

        $posts = [
            [
                'title' => 'L\'importance du BIM dans la construction au Cameroun',
                'subtitle' => 'Comment la modélisation 3D réduit les coûts de vos chantiers.',
                'content' => 'Le Building Information Modeling (BIM) n\'est plus une option mais une nécessité...',
                'category_name' => 'Innovation & BIM',
                'status' => 'published',
            ],
            [
                'title' => '5 conseils pour obtenir son permis de bâtir à Douala',
                'subtitle' => 'Évitez les pièges administratifs et gagnez du temps.',
                'content' => 'Obtenir un permis de construire peut s\'avérer complexe sans une préparation rigoureuse...',
                'category_name' => 'Réglementation',
                'status' => 'published',
            ],
            [
                'title' => 'CIB Construction : Retour sur le projet Villa Horizon',
                'subtitle' => 'Un défi architectural alliant modernité et écologie.',
                'content' => 'Située sur les collines de Yaoundé, la Villa Horizon représente notre vision du luxe...',
                'category_name' => 'Réalisations',
                'status' => 'draft',
            ],
        ];

        foreach ($posts as $data) {
            $category = $categories->where('name', $data['category_name'])->first();

            $post = BlogPost::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'content' => $data['content'],
                'blog_category_id' => $category->id,
                'status' => $data['status'],
                'published_at' => $data['status'] === 'published' ? now() : null,
                'user_id' => $admin->id,
            ]);

            // Liaison des tags (aléatoires pour le test)
            $randomTags = $tags->random(rand(2, 4))->pluck('id');
            $post->blogTags()->attach($randomTags);


            $post->addMediaFromUrl('https://picsum.photos/1280/720')
                ->toMediaCollection('blog_posts');
        }
    }
}
