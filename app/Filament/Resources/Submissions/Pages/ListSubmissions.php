<?php

namespace App\Filament\Resources\Submissions\Pages;

use App\Filament\Resources\Submissions\SubmissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListSubmissions extends ListRecords
{
    protected static string $resource = SubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }


    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Toutes'),

            'pending' => Tab::make('À évaluer')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'pending'))
                ->badge(\App\Models\Submission::where('status', 'pending')->count())
                ->badgeColor('warning')
                ->icon('heroicon-m-clock'),

            'rejected' => Tab::make('À corriger')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'rejected'))
                ->icon('heroicon-m-x-circle'),

            'done' => Tab::make('Validées')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'done'))
                ->icon('heroicon-m-check-badge'),
        ];
    }
}
