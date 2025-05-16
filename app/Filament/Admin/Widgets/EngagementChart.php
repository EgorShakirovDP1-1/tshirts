<?php

namespace App\Filament\Widgets;

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
        $labels = collect(range(0, 6))->map(function ($i) {
            return Carbon::now()->subDays($i)->format('M d');
        })->reverse()->values();

        $likesData = $labels->map(function ($date) {
            return Like::whereDate('created_at', Carbon::parse($date))->count();
        });

        $commentsData = $labels->map(function ($date) {
            return Comment::whereDate('created_at', Carbon::parse($date))->count();
        });

        $usersData = $labels->map(function ($date) {
            return User::whereDate('created_at', Carbon::parse($date))->count();
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
