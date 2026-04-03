<?php

namespace App\Filament\Client\Pages;

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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;

class ProjectBilan extends Page
{

    #[Url(keep: true)]
    public ?int $activeProjectId = null;

    #[Url(keep: true)]
    public ?int $task = null;

    protected string $view = 'filament.client.pages.project-bilan';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentCheck;
    protected static ?string $title = 'Bilan des mes projets';

    public function mount()
    {
        $urlProjectId = request()->query('activeProjectId');

        //Verification de sécurité dans l'url
        if ($urlProjectId && Project::where('id', $urlProjectId)->where('client_id', Auth::id())->exists()) {
            $this->activeProjectId = (int) $urlProjectId;
        } else {
            $this->activeProjectId = Project::where('client_id', Auth::id())->latest()->value('id');
        }

        $this->form->fill([
            'activeProjectId' => $this->activeProjectId,
        ]);
    }


    protected function getHeaderWidgets(): array
    {
        return [
            // On injecte l'ID du projet dans le widget
            ProjectBilanStats::make([
                'projectId' => $this->activeProjectId,
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
                                Select::make('activeProjectId')
                                    ->label('projets')
                                    ->options(Project::where('client_id', Auth::id())->pluck('name', 'id'))
                                    ->searchable() 
                                    ->preload()    
                                    ->placeholder('Tous les projets')
                                    ->live()       
                                    ->afterStateUpdated(function ($state, $livewire) {

                                        $livewire->project = $state;

                                        $livewire->dispatch('project-filter-updated', projectId: $state);
                                    }),

                                Select::make('task')
                                    ->label('Tâches')
                                    ->options(Task::whereHas('project', function(Builder $query){
                                        $query->where('client_id', Auth::id());
                                    })->pluck('title', 'id'))
                                    ->searchable()
                                    ->preload()   
                                    ->placeholder('Toutes les tâches')
                                    ->live() 
                                    ->afterStateUpdated(function ($state, $livewire) {

                                        $livewire->task = $state;

                                    }),
                            ])->columnSpanFull()


                    ])

            ]);
    }


}
