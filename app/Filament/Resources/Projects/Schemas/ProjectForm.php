<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\CategoryTemplate;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Icon;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(
                Wizard::make([
                    Step::make('Détails du Chantier')
                        ->description('Informations générales sur le projet.')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nom du projet')
                                ->required()
                                ->placeholder('ex: Construction Pont de la Sanaga')
                                ->maxLength(255),
                            Select::make('client_id')
                                ->label('Client propriétaire')
                                ->relationship(
                                    name: 'client',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn(Builder $query) => $query->whereHas('roles', fn($q) => $q->where('name', 'client'))
                                )
                                ->searchable()
                                ->preload()
                                ->required(),
                            ToggleButtons::make('status')
                                ->label('État d’avancement')
                                ->options([
                                    'etude' => 'En Étude',
                                    'en_cours' => 'En Cours',
                                    'termine' => 'Terminé / Livré',
                                    'suspendu' => 'Suspendu',
                                ])
                                ->icons([
                                    'etude' => Heroicon::OutlinedPencilSquare,
                                    'en_cours' => Heroicon::OutlinedPlay,
                                    'termine' => Heroicon::OutlinedCheckCircle,
                                    'suspendu' => Heroicon::OutlinedPause,
                                ])
                                ->colors([
                                    'etude' => 'gray',
                                    'en_cours' => 'warning',
                                    'termine' => 'success',
                                    'suspendu' => 'danger',
                                ])
                                ->default('etude')
                                ->inline()
                                ->required(),

                            TextInput::make('location')
                                ->label('Localisation / Ville')
                                ->afterLabel([
                                    Icon::make(Heroicon::OutlinedMapPin)
                                ]),

                            Textarea::make('description')
                                ->label('Description sommaire')
                                ->columnSpanFull(),
                        ]),

                    Step::make('Planning et Visuels')
                        ->schema([
                            DatePicker::make('start_date')
                                ->label('Date de début')
                                ->live(true)
                                ->closeOnDateSelection()
                                ->native(false),

                            DatePicker::make('end_date')
                                ->label('Prévision de fin')
                                ->minDate(
                                    fn(Get $get) =>
                                    $get('start_date')
                                )
                                ->afterOrEqual('start_date') // La validation native de Laravel
                                ->validationMessages([
                                    'after_or_equal' => 'La date de fin ne peut pas être antérieure au début du chantier.',
                                ])
                                ->native(false)
                                ->closeOnDateSelection()
                                ->live(true)
                            ,

                            FileUpload::make('image_path')
                                ->label('Photo de couverture du projet')
                                ->image()
                                ->directory('projects')
                                ->imageEditor()
                                ->columnSpanFull(),
                        ])->columns(2),

                    Step::make('Sélection des Livrables')
                        ->description('Cochez les documents spécifiques à produire.')
                        ->schema([
                            // On enveloppe le tout dans une grille de 2 colonnes
                            Grid::make(2)
                                ->schema(function () {
                                    $categories = CategoryTemplate::with('taskTemplates')->get();
                                    $fields = [];

                                    foreach ($categories as $category) {
                                        $fields[] = Section::make($category->title)
                                            ->collapsible() // Permet de replier une catégorie si besoin
                                            ->schema([
                                                CheckboxList::make("temp_tasks_{$category->id}")
                                                    ->label($category->taskTemplates->count() . ' tâches à réaliser') // On vide le label car le titre de la section suffit
                                                    ->options($category->taskTemplates->pluck('title', 'id'))
                                                    ->columns(2) // 2 colonnes à l'intérieur de la section
                                                    ->bulkToggleable()
                                                    ->dehydrated(false),
                                            ])
                                            ->columnSpan(1); // Chaque section prend une colonne de la grille
                                    }

                                    return $fields;
                                })
                        ]),
                ])->columnSpanFull()
                    ->skippable(),


            );
    }
}
