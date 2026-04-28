<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectDashboard extends BaseDashboard
{
    protected static ?string $title = 'Etats des projets';

    use HasFiltersForm;

    protected function getHeaderActions(): array
    {
        return [
            FilterAction::make()
                ->schema([
                    DatePicker::make('startDate')
                        ->label('Date de début')
                        ->native(false)
                        ->columns(6),
                    DatePicker::make('endDate')
                        ->label('Date de fin')
                        ->columns(6)
                        ->native(false),
                    // ...
                ]),
        ];
    }
}