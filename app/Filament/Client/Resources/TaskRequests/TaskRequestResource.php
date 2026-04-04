<?php

namespace App\Filament\Client\Resources\TaskRequests;

use App\Filament\Client\Resources\TaskRequests\Pages\CreateTaskRequest;
use App\Filament\Client\Resources\TaskRequests\Pages\EditTaskRequest;
use App\Filament\Client\Resources\TaskRequests\Pages\ListTaskRequests;
use App\Filament\Client\Resources\TaskRequests\Pages\ViewTaskRequest;
use App\Filament\Client\Resources\TaskRequests\Schemas\TaskRequestForm;
use App\Filament\Client\Resources\TaskRequests\Schemas\TaskRequestInfolist;
use App\Filament\Client\Resources\TaskRequests\Tables\TaskRequestsTable;
use App\Models\TaskRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TaskRequestResource extends Resource
{
    protected static ?string $model = TaskRequest::class;

    protected static ?string $navigationLabel = 'Mes Demandes';

    protected static ?string $modelLabel = 'Demande de tâche';

    protected static ?string $pluralModelLabel = 'Mes Demandes de tâches';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChatBubbleLeftRight;

    protected static ?string $recordTitleAttribute = 'Demandes';

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


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('client_id', Auth::id())
            ->latest();
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


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('client_id', auth()->id())
            ->where('status', 'en_attente')
            ->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
