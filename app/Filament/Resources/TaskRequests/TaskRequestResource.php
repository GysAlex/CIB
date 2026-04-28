<?php

namespace App\Filament\Resources\TaskRequests;

use App\Filament\Resources\TaskRequests\Pages\CreateTaskRequest;
use App\Filament\Resources\TaskRequests\Pages\EditTaskRequest;
use App\Filament\Resources\TaskRequests\Pages\ListTaskRequests;
use App\Filament\Resources\TaskRequests\Pages\ViewTaskRequest;
use App\Filament\Resources\TaskRequests\Schemas\TaskRequestForm;
use App\Filament\Resources\TaskRequests\Schemas\TaskRequestInfolist;
use App\Filament\Resources\TaskRequests\Tables\TaskRequestsTable;
use App\Models\TaskRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TaskRequestResource extends Resource
{
    protected static ?string $model = TaskRequest::class;

    protected static string | UnitEnum | null $navigationGroup = 'Gestion des projets';

    protected static ?string $navigationLabel = 'Demandes Clients';
    protected static ?string $pluralModelLabel = 'Demandes de Tâches';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxStack;


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'en_attente')->count() ?: null;
    }

    protected static ?string $recordTitleAttribute = 'Demande Client';

    public static function form(Schema $schema): Schema
    {
        return TaskRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TaskRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TaskRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Demandes de tâche en attente de traitement';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTaskRequests::route('/'),
            'create' => CreateTaskRequest::route('/create'),
            'view' => ViewTaskRequest::route('/{record}'),
            'edit' => EditTaskRequest::route('/{record}/edit'),
        ];
    }
}
