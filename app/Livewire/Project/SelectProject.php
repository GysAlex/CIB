<?php

namespace App\Livewire\Project;

use App\Models\Project;
use Filament\Forms\Components\Select;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Livewire\Attributes\Url;
use Livewire\Component;
use Filament\Schemas\Schema;

class SelectProject extends Component implements HasSchemas
{
    use InteractsWithSchemas;

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
                    ->label('filter mes tâches par projets')
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
