<?php

namespace Modules\Kino\Filament\Clusters\Kino\Resources\CountryResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Kino\Filament\Clusters\Kino\Resources\CountryResource;

class CreateCountry extends CreateRecord
{
    protected static string $resource = CountryResource::class;
}
