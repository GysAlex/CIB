<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use HashContext;

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
                ->required(fn (string $context): bool => $context === 'create')
                ->dehydrated(fn(?string $context): string => filled($context))
                ->dehydrateStateUsing(fn (string $context): string => bcrypt($context) ),
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
