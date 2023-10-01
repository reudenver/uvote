<?php

namespace App\Filament\Resources\PartyListResource\Pages;

use App\Filament\Resources\PartyListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPartyLists extends ListRecords
{
    protected static string $resource = PartyListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
