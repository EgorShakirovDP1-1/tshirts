<?php

namespace App\Filament\Admin\Resources\ThingResource\Pages;

use App\Filament\Admin\Resources\ThingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditThing extends EditRecord
{
    protected static string $resource = ThingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
