<?php

namespace Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
