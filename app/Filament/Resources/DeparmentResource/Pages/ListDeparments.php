<?php

namespace App\Filament\Resources\DeparmentResource\Pages;

use App\Filament\Resources\DeparmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeparments extends ListRecords
{
    protected static string $resource = DeparmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
