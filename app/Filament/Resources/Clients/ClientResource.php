<?php

namespace App\Filament\Resources\Clients;

use App\Filament\Resources\Clients\Pages\ManageClients;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClientResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserPlus;

    protected static ?string $navigationLabel = 'Portefeuille Clients';
    protected static ?string $recordTitleAttribute = 'Clients';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
            TextInput::make('name')
                ->label('Nom complet / Contact')
                ->required(),
            TextInput::make('company_name')
                ->label('Entreprise (Raison sociale)'),
            TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),
            TextInput::make('phone')
                ->label('Téléphone')
                ->tel(),
            TextInput::make('password')
                ->password()
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn (string $context): bool => $context === 'create'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Clients')
            ->columns([
                TextColumn::make('name')
                    ->label('Nom du Client')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('company_name')
                    ->label('Entreprise')
                    ->placeholder('Particulier')
                    ->searchable(),

                TextColumn::make('projects_count')
                    ->label('Projets Actifs')
                    ->counts('projects') 
                    ->badge()
                    ->color(fn($state): string => match (true) {
                        $state > 5 => 'success',
                        $state > 0 => 'info',
                        default => 'gray',
                    })
                    ->sortable(),
                
                TextColumn::make('phone')
                    ->label('Téléphone')
                    ->placeholder('aucun contact'),

                TextColumn::make('email')
                    ->label('Email')
                    ->copyable()
                    ->limit(15)
                    ->icon('heroicon-m-envelope'),
            ])
            ->filters([
                
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('roles', function (Builder $query) {
                $query->where('name', 'client');
            });
    }


    public static function getPages(): array
    {
        return [
            'index' => ManageClients::route('/'),
        ];
    }
}
