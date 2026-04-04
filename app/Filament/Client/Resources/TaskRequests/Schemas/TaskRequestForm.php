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
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

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
                            ->options(fn(): array => Project::where('client_id', auth()->id())->pluck('name', 'id')->toArray())
                            ->required()
                            ->live()
                            ->native(false)
                            ->afterStateUpdated(fn(Set $set) => $set('refresh_tasks', now())),

                        Grid::make(2)
                            ->schema([
                                Section::make('Sélection des prestations')
                                    ->description('Cochez les tâches que vous souhaitez ajouter.')
                                    ->schema([
                                        Grid::make(1)
                                            ->schema(function (Get $get) {



                                                $projectId = $get('project_id');

                                                $existingId = [];

                                                // if(!empty($projectId))
                                                //     dd($projectId);
                                    
                                                $existingProject = Project::where('client_id', Auth::id())
                                                    ->where('id', $projectId)->first();
                                                if (!empty($existingProject))
                                                    $existingId = $existingProject->tasks()
                                                        ->whereNotNull('task_template_id')
                                                        ->pluck('task_template_id')
                                                        ->toArray();


                                                $categories = CategoryTemplate::with('taskTemplates')->get();
                                                $fields = [];
                                                foreach ($categories as $category) {
                                                    $fields[] = Section::make($category->title)
                                                        ->collapsible()
                                                        ->schema([
                                                            CheckboxList::make("temp_tasks_{$category->id}")
                                                                ->options($category->taskTemplates->pluck('title', 'id'))
                                                                ->columns(2)
                                                                ->descriptions($category->taskTemplates->mapWithKeys(function ($item) use ($existingId) {
                                                                    return [
                                                                        $item->id => in_array($item->id, $existingId)
                                                                            ? 'Déjà inclus dans le projet'
                                                                            : null
                                                                    ];
                                                                }))
                                                                ->disableOptionWhen(fn($value): bool => in_array($value, $existingId))
                                                                ->dehydrated(false)
                                                                ->extraAttributes(fn($state) => [
                                                                    'class' => 'opacity-75',
                                                                ])
                                                                ->default($existingId),

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
