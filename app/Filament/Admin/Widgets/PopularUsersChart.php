<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use App\Models\Like;
use Illuminate\Support\Carbon;

class PopularUsersChart extends ChartWidget
{
    protected static ?string $heading = 'Top Users by Likes';

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
        // Определяем период фильтра
        $filter = $this->filter;
        $start = match ($filter) {
            'today' => Carbon::today(),
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::createFromFormat('Y-m-d', '1970-01-01'),
        };

        // Получаем топ-5 пользователей по количеству лайков за период
        $users = User::withCount(['likes as likes_count' => function ($query) use ($start) {
                $query->where('rating', 1)
                      ->where('created_at', '>=', $start);
            }])
            ->orderByDesc('likes_count')
            ->take(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Likes',
                    'data' => $users->pluck('likes_count'),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#36A2EB',
                ],
            ],
            'labels' => $users->pluck('username'),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
