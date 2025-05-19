<?php

namespace App\Filament\Admin\Resources\ParcelMachineResource\Pages;

use App\Filament\Admin\Resources\ParcelMachineResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParcelMachines extends ListRecords
{
    protected static string $resource = ParcelMachineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
