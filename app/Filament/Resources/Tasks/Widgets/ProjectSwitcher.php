<?php

namespace App\Filament\Resources\Tasks\Widgets;

use App\Filament\Resources\Tasks\TaskResource;
use App\Models\Project;
use Filament\Forms\Components\Select;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;
use Livewire\Attributes\Url;

class ProjectSwitcher extends Widget implements HasSchemas
{
    use InteractsWithSchemas;

    protected string $view = 'filament.resources.tasks.widgets.project-switcher';


    #[Url(keep: true)]
    public ?string $project = null;

    public function mount(): void
    {
        $this->form->fill([
            'project' => $this->project,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project')
                    ->label('Filtrer par projet')
                    ->options(Project::query()->pluck('name', 'id'))
                    ->searchable() // Permet la recherche par nom
                    ->preload()    // Charge les données pour une recherche instantanée
                    ->placeholder('Tous les projets')
                    ->live()       // Déclenche une mise à jour dès que la sélection change
                    ->afterStateUpdated(function ($state, $livewire) {

                        $livewire->project = $state;

                        $livewire->dispatch('project-filter-updated', projectId: $state);
                    }),
            ]);
    }
}
