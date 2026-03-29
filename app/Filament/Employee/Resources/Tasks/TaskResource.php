<?php

namespace App\Filament\Employee\Resources\Tasks;

use App\Filament\Employee\Resources\Tasks\Pages\CreateTask;
use App\Filament\Employee\Resources\Tasks\Pages\EditTask;
use App\Filament\Employee\Resources\Tasks\Pages\ListTasks;
use App\Filament\Employee\Resources\Tasks\Pages\ViewTask;
use App\Filament\Employee\Resources\Tasks\Schemas\TaskForm;
use App\Filament\Employee\Resources\Tasks\Schemas\TaskInfolist;
use App\Filament\Employee\Resources\Tasks\Tables\TasksTable;
use App\Models\Task;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;


    protected static ?string $navigationLabel = 'Tâches';

    protected static ?string $pluralModelLabel = 'Tâches';

    protected static ?string $modelLabel = 'Tâche';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Tâches';

    public static function form(Schema $schema): Schema
    {
        return TaskForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TaskInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TasksTable::configure($table);
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
            'index' => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'view' => ViewTask::route('/{record}'),
            'edit' => EditTask::route('/{record}/edit'),
        ];
    
    }



    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('members', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->where('is_launched', true);
    }
}
