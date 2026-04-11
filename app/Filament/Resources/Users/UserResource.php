<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Icon;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class UserResource extends Resource
{
    protected static ?string $navigationLabel = 'Employés';
    protected static ?string $pluralModelLabel = 'Employés';
    protected static ?string $modelLabel = 'Employé';


    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas(
                'roles',
                fn(Builder $query) =>
                $query->where('name', 'employee')
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
            'view' => ViewUser::route('/{record}')
        ];
    }


    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // SECTION IDENTITÉ
                Section::make('Profil Professionnel')
                    ->icon('heroicon-o-identification')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nom & Prénom')
                            ->weight('bold'),
                        TextEntry::make('email')
                            ->label('Email'),
                        TextEntry::make('roles.display_name')
                            ->label('Poste')
                            ->badge()
                            ->color('info'),
                    ]),

                // SECTION KPIS DE PERFORMANCE
                Grid::make(2)
                    ->schema([
                        // On compte via la relation BelongsToMany (membres)
                        TextEntry::make('assigned_tasks_count')
                            ->label('Tâches Assignées')
                            ->state(fn($record) => $record->tasks()->count())
                            ->icon('heroicon-o-briefcase'),

                        // Tâches dont le statut global est 'termine'
                        TextEntry::make('completed_tasks_count')
                            ->label('Tâches Terminées')
                            ->state(fn($record) => $record->tasks()->where('status', 'valide')->count())
                            ->color('success')
                            ->icon('heroicon-o-check-circle'),

                        // Nombre total de soumissions (versions incluses)
                        TextEntry::make('total_submissions')
                            ->label('Soumissions (Livrables)')
                            ->state(fn($record) => $record->submissions()->count())
                            ->icon('heroicon-o-document-arrow-up'),

                        // Soumissions validées (status 'done' selon ton modèle Submission)
                        TextEntry::make('validated_submissions')
                            ->label('Livrables Validés')
                            ->state(fn($record) => $record->submissions()->where('status', 'done')->count())
                            ->color('primary')
                            ->icon('heroicon-o-shield-check'),
                    ]),

                // DÉTAILS DES ACTIVITÉS
                Tabs::make('Rapport d\'activité')
                    ->columnSpanFull()
                    ->tabs([
                        // Onglet Tâches : On liste les projets sur lesquels il travaille
                        Tab::make('Projets & Tâches')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->schema([
                                RepeatableEntry::make('tasks')
                                    ->label(false)
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextEntry::make('project.name')->label('Projet'),
                                                TextEntry::make('title')->label('Tâche'),
                                                TextEntry::make('status')->label('État de la tâche')
                                                    ->badge()
                                                    ->formatStateUsing(fn(string $state): string => match ($state) {
                                                        'valide' => 'Terminé',
                                                        'en_attente_de_validation' => 'En attente',
                                                        default => 'En cours',
                                                    }),
                                            ]),
                                        ]),
                            ]),

                        // Onglet Soumissions : Le coeur du rapport de performance
                        Tab::make('Historique des Soumissions')
                            ->icon('heroicon-o-arrow-path')
                            ->schema([
                                RepeatableEntry::make('submissions')
                                    ->label(false)
                                    ->schema([
                                        Grid::make(4)
                                            ->schema([
                                                TextEntry::make('task.title')->label('Tâche'),
                                                TextEntry::make('version')
                                                    ->label('Version')
                                                    ->badge(),
                                                TextEntry::make('status')
                                                    ->label('Résultat')
                                                    ->badge(),
                                                TextEntry::make('submitted_at')
                                                    ->label('Date')
                                                    ->dateTime('d/m/Y H:i'),
                                            ]),
                                    ]),
                            ]),
                    ]),
            ]);
    }



}
