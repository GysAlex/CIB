<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Models\Project;
use App\Models\Task;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Assignation')
                        ->description('Lier la tâche à un projet et aux intervenants.')
                        ->icon('heroicon-o-user-group')
                        ->schema([
                            Select::make('project_id')
                                ->label('Projet de génie civil')
                                ->relationship('project', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),

                            Select::make('employees')
                                ->label('Assigner à (Employés)')
                                ->multiple()
                                ->relationship('employees', 'name')
                                ->preload()
                                ->required(),

                            TextInput::make('title')
                                ->label('Intitulé de la tâche')
                                ->placeholder('Ex: Coffrage du radier')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
                        ]),

                    // ÉTAPE 2 : PLANIFICATION ET CONTRÔLE
                    Step::make('Exécution')
                        ->description('Définir l\'urgence et les points de contrôle.')
                        ->icon('heroicon-o-clipboard-document-check')
                        ->schema([
                            ToggleButtons::make('status')
                                ->label('Statut de la tâche')
                                ->inline()
                                ->options([
                                    'a_faire' => 'À faire',
                                    'en_cours' => 'En cours',
                                    'en_attente_validation' => 'En attente',
                                    'valide' => 'Validé',
                                ])
                                ->colors([
                                    'a_faire' => 'gray',
                                    'en_cours' => 'warning',
                                    'en_attente_validation' => 'info',
                                    'valide' => 'success',
                                ])
                                ->icons([
                                    'a_faire' => Heroicon::OutlinedClipboard,
                                    'en_cours' => Heroicon::OutlinedPlay,
                                    'en_attente_validation' => Heroicon::OutlinedClock,
                                    'valide' => Heroicon::OutlinedCheckCircle,
                                ])
                                ->default('a_faire')
                                ->required()
                                ->columnSpanFull(),
                            ToggleButtons::make('priority')
                                ->label('Niveau de priorité')
                                ->inline()
                                ->options([
                                    'basse' => 'Basse',
                                    'normale' => 'Normale',
                                    'haute' => 'Haute',
                                    'critique' => 'Critique',
                                ])
                                ->colors([
                                    'basse' => 'gray',
                                    'normale' => 'info',
                                    'haute' => 'warning',
                                    'critique' => 'danger',
                                ])
                                ->icons([
                                    'basse' => Heroicon::OutlinedFlag,
                                    'critique' => Heroicon::OutlinedFire,
                                ])
                                ->default('normale'),

                            DatePicker::make('deadline')
                                ->label('Date d\'échéance')
                                ->required()
                                ->minDate(fn(Get $get) => Project::find($get('project_id'))?->start_date)
                                ->native(false)
                                ->suffixIcon(Heroicon::OutlinedCalendarDays),

                            Repeater::make('checklist')
                                ->label('Checklist technique (Points de contrôle)')
                                ->schema([
                                    TextInput::make('item')
                                        ->label('Objectif à atteindre')
                                        ->placeholder('Ex: Vérifier l\'enrobage des aciers'),
                                ])
                                ->addActionLabel('Ajouter un point de contrôle')
                                ->reorderableWithButtons()
                                ->columnSpanFull(),
                        ])->columns(2),
                ])
                    ->columnSpanFull() // Le wizard prend toute la largeur
                    ->skippable() // Permet au gérant de naviguer entre les étapes s'il veut corriger
            ]);
    }
}
