<?php

namespace App\Filament\Client\Resources\TaskRequests\Schemas;

use App\Models\CategoryTemplate;
use App\Models\Project;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TaskRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(1)
                    ->schema([
                        Select::make('project_id')
                            ->label('Projet cible')
                            ->options(fn() => Project::where('client_id', auth()->id())->pluck('name', 'id'))
                            ->required()
                            ->native(false)
                            ->default(fn() => Project::where('client_id', auth()->id())->latest()->value('name')),

                        Grid::make(2)
                            ->schema([
                                Section::make('Sélection des prestations')
                                    ->description('Cochez les tâches que vous souhaitez ajouter.')
                                    ->schema([
                                        Grid::make(1)
                                            ->schema(function () {
                                                $categories = CategoryTemplate::with('taskTemplates')->get();
                                                $fields = [];
                                                foreach ($categories as $category) {
                                                    $fields[] = Section::make($category->title)
                                                        ->collapsible()
                                                        ->schema([
                                                            CheckboxList::make("temp_tasks_{$category->id}")
                                                                ->options($category->taskTemplates->pluck('title', 'id'))
                                                                ->columns(2)
                                                                ->dehydrated(true),
                                                        ]);
                                                }
                                                return $fields;
                                            }),

                                    ])->columnSpan(1),

                                Section::make('Autres demandes (Hors catalogue)')
                                    ->description('Si votre besoin ne figure pas dans la liste ci-dessus, précisez-le ici.')
                                    ->icon('heroicon-o-plus-circle')
                                    ->collapsible()
                                    ->schema([
                                        Repeater::make('custom_tasks')
                                            ->label('Tâches sur mesure')
                                            ->schema([
                                                TextInput::make('title')
                                                    ->label('Nom de la tâche')
                                                    ->placeholder('Ex: Installation d\'une clôture de sécurité')
                                                    ->required(),
                                                Textarea::make('description')
                                                    ->label('Précisions / Justification')
                                                    ->rows(2),
                                                Select::make('priority')
                                                    ->label('Urgence')
                                                    ->options([
                                                        'low' => 'Basse',
                                                        'medium' => 'Normale',
                                                        'high' => 'Haute',
                                                    ])
                                                    ->default('medium'),
                                            ])
                                            ->createItemButtonLabel('Ajouter un besoin spécifique')
                                            ->dehydrated(true),
                                    ])->columnSpan(1)
                            ]),

                    ])->columnSpanFull()

            ]);
    }
}
