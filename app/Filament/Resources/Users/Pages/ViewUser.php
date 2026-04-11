<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Flowframe\Trend\Trend;
use Illuminate\Support\Carbon;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;


    public static function generatePdf(User $employee, array $data)
    {
        $startDate = Carbon::createFromDate($data['year'], $data['month'], 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // On récupère les soumissions détaillées
        $submissions = $employee->submissions()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('task.project')
            ->get();

        $stats = [
            'total' => $submissions->count(),
            'validated' => $submissions->where('status', 'done')->count(),
            'avg_version' => round($submissions->avg('version') ?? 1, 1),
        ];

        $pdf = Pdf::loadView('pdf.employee-performance', [
            'employee' => $employee,
            'submissions' => $submissions,
            'stats' => $stats,
            'observations' => $data['admin_observations'] ?? null,
            'period' => $startDate->translatedFormat('F Y'),
        ]);

        return $pdf->output();
    }
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('generateMonthlyReport')
                ->label('Rapport Mensuel')
                ->icon('heroicon-o-chart-bar')
                ->modalWidth('2xl')
                ->form([
                    Grid::make(2)
                        ->schema([
                            Select::make('month')
                                ->label('Mois')
                                ->options(['01' => 'Janvier', '02' => 'Février', '03' => 'Mars', '04' => 'Avril', '05' => 'Mai', '06' => 'Juin', '07' => 'Juillet', '08' => 'Août', '09' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre'])
                                ->default(now()->format('m')),
                            Select::make('year')
                                ->label('Année')
                                ->options(array_combine(range(2025, 2030), range(2025, 2030)))
                                ->default(now()->year),
                        ]),

                ])
                ->action(function (User $record, array $data) {
                    return response()->streamDownload(function () use ($record, $data) {
                        echo self::generatePdf($record, $data);
                    }, "Rapport_{$record->name}_{$data['month']}.pdf");
                })
        ];
    }


    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->hasInfolist() // This method returns `true` if the page has an infolist defined
                ? $this->getInfolistContentComponent() // This method returns a component to display the infolist that is defined in this resource
                : $this->getFormContentComponent(), // This method returns a component to display the form that is defined in this resource
                $this->getRelationManagersContentComponent(), // This method returns a component to display the relation managers that are defined in this resource
            ]);
    }
}
