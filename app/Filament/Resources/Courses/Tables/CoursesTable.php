<?php

namespace App\Filament\Resources\Courses\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->label('Aperçu')
                    ->collection('course_thumbnails')
                    ->circular(),

                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record): string => $record->summary === '' ? Str::limit($record->summary, 40) : Str::limit($record->title, 40)),

                TextColumn::make('videoCategory.name')
                    ->label('Catégorie')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('views_count')
                    ->label('Vues')
                    ->icon('heroicon-m-eye')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('level')
                    ->label('Niveau')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Débutant' => 'info',
                        'Intermédiaire' => 'warning',
                        'Avancé' => 'danger',
                    }),

                IconColumn::make('is_published')
                    ->label('Publié')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('blog_category_id')
                    ->label('Filtrer par catégorie')
                    ->relationship('videoCategory', 'name'),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ])

            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
