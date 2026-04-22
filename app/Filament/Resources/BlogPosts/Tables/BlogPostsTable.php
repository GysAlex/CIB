<?php

namespace App\Filament\Resources\BlogPosts\Tables;

use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BlogPostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('featured_image')
                    ->label('Image')
                    ->collection('blog_posts')
                    ->circular(),

                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->limit(25)
                    ->sortable(),

                TextColumn::make('blogCategory.name')
                    ->label('Catégorie')
                    ->badge()
                    ->color('gray'),

                BadgeColumn::make('status')
                    ->label('Statut')
                    ->colors([
                        'danger' => 'draft',
                        'success' => 'published',
                    ]),

                TextColumn::make('published_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('blog_category_id')
                    ->label('Catégorie')
                    ->relationship('blogCategory', 'name'),
            ])
            ->recordActions([
                Action::make('publish_now')
                    ->label('Publier')
                    ->icon('heroicon-o-rocket-launch')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn($record): bool => $record->status === 'draft')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'published',
                            'published_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Article publié avec succès')
                            ->success()
                            ->send();
                    }),
                Action::make('schedule_publication')
                    ->label('Programmer')
                    ->icon('heroicon-o-clock')
                    ->color('info')
                    ->visible(fn($record): bool => $record->status === 'draft')
                    ->form([
                        DateTimePicker::make('published_at')
                            ->label('Date et heure de publication')
                            ->required()
                            ->native(false)
                            ->after(now()) // Empêche de choisir une date passée
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => 'published', // On le passe en published, mais il ne sera visible qu'à la date T
                            'published_at' => $data['published_at'],
                        ]);

                        Notification::make()
                            ->title('Publication programmée pour le ' . Carbon::parse($data['published_at'])->format('d/m/Y à H:i'))
                            ->info()
                            ->send();
                    }),
                ActionGroup::make([
                    Action::make('unpublish')
                        ->label('Retirer de la publication')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Retirer l\'article du site ?')
                        ->modalDescription('L\'article repassera en mode "Brouillon" et ne sera plus visible par les visiteurs.')
                        ->modalSubmitActionLabel('Confirmer le retrait')
                        ->visible(fn($record): bool => $record->status === 'published')
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'draft',
                            ]);

                            Notification::make()
                                ->title('L\'article a été retiré du site')
                                ->warning() // Couleur orange pour indiquer un changement d'état vers le bas
                                ->send();
                        }),
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ])

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
