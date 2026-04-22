<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Models\BlogPost;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(5) // On utilise une grille de 3 colonnes pour optimiser l'espace
                    ->schema([

                        Section::make('Contenu de l\'article')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Titre de l\'article')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn($set, $state) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated() // Important pour que le slug soit quand même envoyé en BDD
                                    ->unique(BlogPost::class, 'slug', ignoreRecord: true),

                                RichEditor::make('content')
                                    ->label('Corps de l\'article')
                                    ->required()
                                    ->columnSpanFull()
                                    ->toolbarButtons([
                                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                                        ['h2', 'h3'],
                                        ['alignStart', 'alignCenter', 'alignEnd'],
                                        ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                        ['table', 'attachFiles'], // The `customBlocks` and `mergeTags` tools are also added here if those features are used.
                                        ['undo', 'redo'],
                                    ])

                            ])->columnSpan(3),

                        // Colonne latérale (Paramètres & Média)
                        Section::make('Paramètres & Image')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('featured_image')
                                    ->label('Image à la une')
                                    ->collection('blog_posts') // Collection Spatie
                                    ->image(),
                                Select::make('blog_category_id')
                                    ->label('Catégorie')
                                    ->relationship('blogCategory', 'name') // Relation BelongsTo
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('blogTags')
                                    ->label('Tags')
                                    ->relationship('blogTags', 'name') // Relation BelongsToMany
                                    ->multiple() // Permet la sélection multiple
                                    ->searchable()
                                    ->preload(),

                                Select::make('status')
                                    ->label('Statut')
                                    ->options([
                                        'draft' => 'Brouillon',
                                        'published' => 'Publié',
                                    ])
                                    ->default('draft')
                                    ->required(),
                            ])->columnSpan(2),
                    ])->columnSpanFull(),
            ]);
    }
}
