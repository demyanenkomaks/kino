<?php

namespace Modules\Kino\Filament\Clusters\Kino\Resources\CountriesResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Kino\Filament\Clusters\Kino\Resources\CountriesResource;

class EditCountries extends EditRecord
{
    protected static string $resource = CountriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
