<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nom & Prénom')->required(),
                TextInput::make('email')->label('Email')->required(),
                TextInput::make('password')->label('Mot de passe')
                ->password()
                ->revealable()
                ->required(fn (string $context): bool => $context === 'create'),
                Select::make('roles')
                ->label('Poste')
                ->relationship('roles', 'display_name')
                ->multiple()          // si un user peut avoir plusieurs rôles
                ->preload()
                ->searchable()
                ->required(),
                
            ]);
    }
}
