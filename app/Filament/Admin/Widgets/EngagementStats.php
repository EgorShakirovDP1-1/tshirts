<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;

class EngagementStats extends BaseWidget
{
    protected function getStats(): array
    {
        $topUser = User::withCount(['likes' => function($q) {
                $q->where('rating', 1);
            }])
            ->orderByDesc('likes_count')
            ->first();

        return [
            Stat::make('Total Likes', Like::where('rating', 1)->count())
                ->description('Total number of likes')
                ->color('success'),
            Stat::make('Total Dislikes', Like::where('rating', -1)->count())
                ->description('Total number of dislikes')
                ->color('danger'),
            Stat::make('Total Comments', Comment::count())
                ->description('Total number of comments')
                ->color('primary'),
            Stat::make('Top User', $topUser ? $topUser->username : 'N/A')
                ->description('User with the most likes')
                ->color('info'),
        ];
    }
}
