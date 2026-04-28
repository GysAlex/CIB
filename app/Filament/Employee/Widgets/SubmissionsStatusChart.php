<?php

namespace App\Filament\Employee\Widgets;

use App\Models\Submission;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SubmissionsStatusChart extends ChartWidget
{
    protected ?string $heading = 'Analyses des versions soumises';
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = Submission::where('user_id', auth()->id())
            ->select('version', DB::raw('count(*) as total'))
            ->groupBy('version')
            ->orderBy('version')
            ->pluck('total', 'version');

        return [
            'datasets' => [
                [
                    'label' => 'Nombre de soumissions',
                    'data' => $data->values()->toArray(),
                    'backgroundColor' => '#3b82f6',
                ],
            ],

            'labels' => $data->keys()->map(fn($v) => "V" . $v)->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
