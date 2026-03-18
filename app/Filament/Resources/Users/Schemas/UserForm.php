<?php

namespace App\Filament\Resources\Users\Schemas;

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
                TextInput::make('password')->label('Mot de passe')->password()
            ]);
    }
}
