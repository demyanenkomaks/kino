<?php

namespace Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource\Pages;

use Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
