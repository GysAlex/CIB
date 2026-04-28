<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class EmployeeWorkLoadChart extends ChartWidget
{
    use InteractsWithPageFilters;
    protected ?string $heading = 'Tâche validées pour chaque employés';

    protected function getData(): array
    {

        $startDate = $this->pageFilters['startDate'] ?? null;
        $endDate = $this->pageFilters['endDate'] ?? null;

        // dd(Task::when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
        //               ->where('status', 'valide')->get()      
        // );

        // dd(User::whereHas('roles', fn($q) => $q->where('name', 'employee'))
        //     ->withCount(['tasks' => fn($k) => $k->whereDate('launch_at', '>=', $startDate)
        // ])->get());

        $employees = User::whereHas('roles', fn($q) => $q->where('name', 'employee'))
            ->withCount(['tasks' => fn($q) => $q->when($startDate, fn(Builder $query) => $query->whereDate('launch_at', '>=', $startDate))
                                            ->when($endDate, fn(Builder $query) => $query->whereDate('launch_at', '<=', $endDate) )
                                                
            ])
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Tâches validées',
                    'data' => $employees->pluck('tasks_count')->toArray(),
                    'backgroundColor' => ['#fbbf24', '#3b82f6', '#10b981', '#f87171'],
                ],
            ],
            'labels' => $employees->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 3;

}
