<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Like;
use Illuminate\Support\Carbon;

class LikesChart extends ChartWidget
{
    protected static ?string $heading = 'Likes by Day';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'This Week',
            'month' => 'This Month',
            'year' => 'This Year',
        ];
    }

    protected function getData(): array
    {
        $filter = $this->filter;
        $start = match ($filter) {
            'today' => Carbon::today(),
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::createFromFormat('Y-m-d', '1970-01-01'),
        };

        // Определяем диапазон дат
        $end = Carbon::now();
        $period = match ($filter) {
            'today' => [$start],
            'week' => collect(range(0, 6))->map(fn($i) => $start->copy()->addDays($i)),
            'month' => collect(range(0, $end->diffInDays($start)))->map(fn($i) => $start->copy()->addDays($i)),
            'year' => collect(range(0, $end->diffInMonths($start)))->map(fn($i) => $start->copy()->addMonths($i)),
            default => [$start],
        };

        $labels = [];
        $data = [];

        if ($filter === 'year') {
            foreach ($period as $date) {
                $labels[] = $date->format('M Y');
                $data[] = Like::where('rating', 1)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
            }
        } else {
            foreach ($period as $date) {
                $labels[] = $date->format('M d');
                $data[] = Like::where('rating', 1)
                    ->whereDate('created_at', $date->format('Y-m-d'))
                    ->count();
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Likes',
                    'data' => $data,
                    'backgroundColor' => '#36A2EB',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
