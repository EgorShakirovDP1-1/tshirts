<?php

namespace App\Filament\Admin\Resources\ParcelMachineResource\Pages;

use App\Filament\Admin\Resources\ParcelMachineResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParcelMachine extends EditRecord
{
    protected static string $resource = ParcelMachineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
