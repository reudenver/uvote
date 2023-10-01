<?php

namespace App\Filament\Resources\DeparmentResource\Pages;

use App\Filament\Resources\DeparmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeparment extends EditRecord
{
    protected static string $resource = DeparmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
