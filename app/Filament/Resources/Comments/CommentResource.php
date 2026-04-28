<?php

namespace App\Filament\Resources\Comments;

use App\Filament\Resources\Comments\Pages\ManageComments;
use App\Models\Comment;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $recordTitleAttribute = 'content';

    protected static ?string $pluralModelLabel = 'Commentaires';
    protected static ?string $modelLabel = 'Commentaire';
    protected static UnitEnum|string|null $navigationGroup = 'Gestion des contenus';
    protected static ?string $navigationLabel = 'Commentaires';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(1)
                    ->schema([
                        Toggle::make('is_approved')
                            ->label('Approuvé pour publication')
                            ->default(true),

                        TextEntry::make('author_info')
                            ->label('Informations sur l\'auteur')
                            ->state(fn($record): string => $record?->user
                                ? "Utilisateur : {$record->user->name} ({$record->user->email})"
                                : "Invité : {$record?->guest_name} ({$record?->guest_email})"),

                        Textarea::make('content')
                            ->label('Message')
                            ->required()
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(1)
                    ->schema([
                        Toggle::make('is_approved')
                            ->label('Approuvé pour publication')
                            ->default(true),

                        TextEntry::make('author_info')
                            ->label('Informations sur l\'auteur')
                            ->state(fn(Comment $record): string => $record->user
                                ? "Utilisateur : {$record->user->name} ({$record->user->email})"
                                : "Invité : {$record->guest_name} ({$record->guest_email})"),

                        Textarea::make('content')
                            ->label('Message')
                            ->required()
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('content')
            ->columns([
                // Auteur (Utilisateur ou Invité)
                TextColumn::make('author')
                    ->label('Auteur')
                    ->state(function (Comment $record): string {
                        return $record->user ? $record->user->name : $record->guest_name . ' (Invité)';
                    })
                    ->searchable(['guest_name']),

                // Contenu tronqué
                TextColumn::make('content')
                    ->label('Commentaire')
                    ->limit(50)
                    ->searchable(),

                // Cible (Blog ou Formation) via le polymorphisme
                TextColumn::make('commentable_type')
                    ->label('Cible')
                    ->formatStateUsing(fn(string $state): string => str_contains($state, 'Post') ? 'Article' : 'Formation')
                    ->badge()
                    ->color(fn(string $state): string => str_contains($state, 'Post') ? 'info' : 'warning'),

                // Statut de modération
                IconColumn::make('is_approved')
                    ->label('Approuvé')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([

                SelectFilter::make('type')
                    ->options([
                        'App\Models\BlogPost' => 'Articles',
                        'App\Models\Course' => 'Formations',
                    ])
                    ->attribute('commentable_type')
            ])
            ->actions([
                // Action rapide pour approuver un commentaire
                Action::make('approve')
                    ->label('Approuver')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->hidden(fn(Comment $record): bool => $record->is_approved)
                    ->action(fn(Comment $record) => $record->update(['is_approved' => true])),

                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ])

            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_approved', false)->count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Commentaires en attente de validation';
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageComments::route('/'),
        ];
    }
}
