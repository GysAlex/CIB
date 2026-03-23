<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Icon;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Détails du Chantier')
                    ->description('Informations générales sur le projet.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom du projet')
                            ->required()
                            ->placeholder('ex: Construction Pont de la Sanaga')
                            ->maxLength(255),

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

                Section::make('Planning et Visuels')
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Date de début')
                            ->live(true)
                            ->closeOnDateSelection()
                            ->native(false),

                        DatePicker::make('end_date')
                            ->label('Prévision de fin')
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
            ]);
    }
}
