<?php

namespace App\Filament\Resources\Tasks\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';
    protected static ?string $title = 'Intervenants assignés';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar_url') // Si tu as des avatars
                    ->circular()
                    ->label('Photo'),
                TextColumn::make('name')
                    ->label('Nom complet')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email professionnel'),
                // Optionnel : Ajouter le rôle ou le poste si disponible dans le modèle User
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make() // Permet d'ajouter un membre existant
                    ->label('Assigner un intervenant')
                    ->preloadRecordSelect(),
            ])
            ->actions([
                DetachAction::make() // Retire le membre de cette tâche spécifique
                    ->label('Désassigner'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
