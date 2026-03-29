<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Models\Project;
use App\Models\Task;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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
                                ->required()
                                ->live(), // Important pour le minDate du step 2

                            Select::make('user_id') // Utilise la relation Task-User (task_user)
                                ->label('Assigner à (Employés)')
                                ->multiple()
                                ->relationship('members', 'name')
                                ->preload()
                                ->required(),

                            TextInput::make('title')
                                ->label('Intitulé de la tâche')
                                ->placeholder('Ex: Coffrage du radier')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
                        ]),

                    Step::make('Exécution')
                        ->description('Définir l\'urgence et les points de contrôle.')
                        ->icon('heroicon-o-clipboard-document-check')
                        ->schema([
                            // On peut masquer le statut au profit du bouton "Lancer" plus tard, 
                            // ou le laisser pour une gestion manuelle fine.
                            ToggleButtons::make('priority')
                                ->label('Niveau de priorité')
                                ->inline()
                                ->options([
                                    'low' => 'Basse',
                                    'medium' => 'Normale',
                                    'high' => 'Haute',
                                ])
                                ->colors([
                                    'low' => 'gray',
                                    'medium' => 'info',
                                    'high' => 'danger',
                                ])
                                ->default('medium'),

                            DatePicker::make('deadline')
                                ->label('Date d\'échéance')
                                ->required()
                                ->minDate(fn(Get $get) => Project::find($get('project_id'))?->start_date)
                                ->native(false),

                            TextInput::make('expected_deliverable')
                                ->label('Livrable attendu')
                                ->placeholder('Ex: PV de réception de ferraillage')
                                ->columnSpanFull(),

                            // Utilisation de la colonne 'objectives' (JSON) pour la checklist
                            Repeater::make('objectives')
                                ->label('Checklist technique (Points de contrôle)')
                                ->schema([
                                    TextInput::make('item')
                                        ->label('Objectif')
                                        ->required(),
                                ])
                                ->addActionLabel('Ajouter un point')
                                ->columnSpanFull(),
                        ])->columns(2),
                    // Dans TaskResource.php -> form()

                    Step::make('Documents')
                        ->description('Joindre des plans ou photos techniques.')
                        ->icon('heroicon-o-document-plus')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('attachements')
                                ->label('Photos et Notes de terrain')
                                ->collection('attachements') 
                                ->multiple() 
                                ->image() 
                                ->reorderable()
                                ->downloadable()
                                ->columnSpanFull(),

                            SpatieMediaLibraryFileUpload::make('documents')
                                ->label('Documents Techniques (PDF, DWG, Plans)')
                                ->collection('documents')
                                ->multiple()
                                ->acceptedFileTypes(['application/pdf', 'application/x-dwg', 'image/vnd.dwg'])
                                ->maxSize(10240) 
                                ->downloadable()
                                ->columnSpanFull(),
                        ])
                ])
                    ->columnSpanFull()
                    ->skippable()
            ]);
    }
}
