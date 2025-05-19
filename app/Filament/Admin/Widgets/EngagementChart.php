<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Like;
use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class EngagementChart extends ChartWidget
{
    protected static ?string $heading = 'Engagement Over Time';

    protected function getData(): array
    {
        // Собираем даты за последние 7 дней в формате Y-m-d
        $dates = collect(range(0, 6))->map(function ($i) {
            return Carbon::now()->subDays($i)->format('Y-m-d');
        })->reverse()->values();

        // Для отображения на графике используем более удобный формат
        $labels = $dates->map(function ($date) {
            return Carbon::parse($date)->format('M d');
        });

        $likesData = $dates->map(function ($date) {
            return Like::whereDate('created_at', $date)->count();
        });

        $commentsData = $dates->map(function ($date) {
            return Comment::whereDate('created_at', $date)->count();
        });

        $usersData = $dates->map(function ($date) {
            return User::whereDate('created_at', $date)->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Likes',
                    'data' => $likesData,
                    'backgroundColor' => '#36A2EB',
                ],
                [
                    'label' => 'Comments',
                    'data' => $commentsData,
                    'backgroundColor' => '#FF6384',
                ],
                [
                    'label' => 'New Users',
                    'data' => $usersData,
                    'backgroundColor' => '#FFCE56',
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
