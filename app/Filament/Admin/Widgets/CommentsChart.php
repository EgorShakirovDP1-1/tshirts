<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;

class CommentsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
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
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
