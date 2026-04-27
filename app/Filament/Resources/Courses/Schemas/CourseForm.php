<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Models\Course;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            Group::make()
                ->schema([
                    Section::make()
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->live()
                                ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),
                            
                            TextInput::make('slug')
                                ->disabled()
                                ->required()
                                ->unique(Course::class, 'slug', ignoreRecord: true),
                            Textarea::make('summary')
                            ->label('Résumé de la vidéo')
                            ->columnSpanFull(),

                            RichEditor::make('description')
                                ->required()
                                ->columnSpanFull(),
                        ])->columns(2),

                    Section::make('Contenu Vidéo')
                        ->schema([
                            TextInput::make('youtube_id')
                                ->label('ID de la vidéo YouTube')
                                ->helperText('Exemple: dQw4w9WgXcQ')
                                ->required(),
                            
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('duration')
                                        ->label('Durée (ex: 12:45)')
                                        ->placeholder('00:00'),
                                    
                                    Select::make('level')
                                        ->options([
                                            'Débutant' => 'Débutant',
                                            'Intermédiaire' => 'Intermédiaire',
                                            'Avancé' => 'Avancé',
                                        ])->default('Débutant'),
                                ]),
                        ]),
                ])->columnSpan(['lg' => 2]),

            Grid::make(2)
                ->schema([
                    Section::make('Paramètres')
                        ->schema([
                            Toggle::make('is_published')
                                ->label('Publié'),
                            
                            DateTimePicker::make('published_at')
                                ->label('Date de publication')
                                ->native(false),

                            Select::make('blog_category_id')
                                ->label('Catégorie')
                                ->relationship('videoCategory', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                        ]),

                    Section::make('Miniature')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('thumbnail')
                                ->collection('course_thumbnails')
                                ->image(),
                        ]),
                ])->columnSpanFull(),
            ]);
    }
}
