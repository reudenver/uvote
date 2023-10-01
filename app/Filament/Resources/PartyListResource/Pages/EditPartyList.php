<?php

namespace App\Filament\Resources\PartyListResource\Pages;

use App\Filament\Resources\PartyListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartyList extends EditRecord
{
    protected static string $resource = PartyListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
