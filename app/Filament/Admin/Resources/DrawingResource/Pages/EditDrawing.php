<?php

namespace App\Filament\Admin\Resources\DrawingResource\Pages;

use App\Filament\Admin\Resources\DrawingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDrawing extends EditRecord
{
    protected static string $resource = DrawingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
