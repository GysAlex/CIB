<?php

namespace App\Filament\Resources\Comments\Pages;

use App\Filament\Resources\Comments\CommentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ManageComments extends ManageRecords
{
    protected static string $resource = CommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
            ->label('Tous'),
            'active' => Tab::make()
                ->label('approvés')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_approved', true)),
            'inactive' => Tab::make()
                ->label('refusés')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_approved', false)),
        ];
    }

}
