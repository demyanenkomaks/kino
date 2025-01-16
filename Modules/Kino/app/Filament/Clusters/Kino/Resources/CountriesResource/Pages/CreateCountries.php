<?php

namespace Modules\Kino\Filament\Clusters\Kino\Resources\CountriesResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Kino\Filament\Clusters\Kino\Resources\CountriesResource;

class CreateCountries extends CreateRecord
{
    protected static string $resource = CountriesResource::class;
}
