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
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Icon;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
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



    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
            'view' => ViewUser::route('/{record}')
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas(
            'roles',
            fn(Builder $query) =>
            $query->whereNotIn('name', ['admin', 'staff'])
        );
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('something')
                    ->inlineLabel()
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nom & prénom')
                            ->beforeLabel([
                                Icon::make(Heroicon::User)
                            ]),
                        TextEntry::make('email')
                            ->label('Email')
                            ->beforeLabel([
                                Icon::make(Heroicon::Envelope)
                            ])
                        ,
                        TextEntry::make('roles.display_name')
                            ->beforeLabel([
                                Icon::make(Heroicon::Briefcase)
                            ])
                            ->label('Poste')
                    ]),

            ]);
    }



}
