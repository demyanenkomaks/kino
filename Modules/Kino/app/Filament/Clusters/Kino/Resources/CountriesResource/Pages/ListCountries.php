<?php

namespace Modules\Kino\Filament\Clusters\Kino\Resources\CountriesResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Kino\Filament\Clusters\Kino\Resources\CountriesResource;

class ListCountries extends ListRecords
{
    protected static string $resource = CountriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
