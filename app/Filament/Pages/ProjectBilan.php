<?php

namespace App\Filament\Pages;

use App\Livewire\ProjectBilanStats;
use App\Models\Project;
use App\Models\Task;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use UnitEnum;

class ProjectBilan extends Page
{

    protected static ?string $title = 'Centre de Livrables & Bilan';

    #[Url(keep: true)]
    public ?int $project = null;

    #[Url(keep: true)]
    public ?int $task = null;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentCheck;

    protected string $view = 'filament.pages.project-bilan';

    protected static ?string $navigationLabel = 'Bilan projets';
    protected static ?string $pluralModelLabel = 'Bilans projets';
    protected static ?string $modelLabel = 'Bilan projet';

    protected static string|UnitEnum|null $navigationGroup = 'Gestion des projets';


    public function mount(): void
    {
        $this->form->fill([
            'project' => $this->project,
        ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // On injecte l'ID du projet dans le widget
            ProjectBilanStats::make([
                'projectId' => $this->project,
            ]),
        ];
    }

    // Cette méthode réinitialise la tâche si on change de projet
    public function updatedProject()
    {
        $this->task = null;
    }


    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Choisir un projet')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('project')
                                    ->label('projets')
                                    ->options(Project::query()->pluck('name', 'id'))
                                    ->searchable() // Permet la recherche par nom
                                    ->preload()    // Charge les données pour une recherche instantanée
                                    ->placeholder('Tous les projets')
                                    ->live()       // Déclenche une mise à jour dès que la sélection change
                                    ->afterStateUpdated(function ($state, $livewire) {

                                        $livewire->project = $state;

                                        $livewire->dispatch('project-filter-updated', projectId: $state);
                                    }),

                                Select::make('task')
                                    ->label('Tâches')
                                    ->options(Task::query()->pluck('title', 'id'))
                                    ->searchable() // Permet la recherche par nom
                                    ->preload()    // Charge les données pour une recherche instantanée
                                    ->placeholder('Tous les projets')
                                    ->live()       // Déclenche une mise à jour dès que la sélection change
                                    ->afterStateUpdated(function ($state, $livewire) {

                                        $livewire->task = $state;

                                    }),
                            ])->columnSpanFull()


                    ])

            ]);
    }


}
