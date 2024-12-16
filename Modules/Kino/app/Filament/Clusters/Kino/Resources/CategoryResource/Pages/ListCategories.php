<?php

namespace Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource\Pages;

use Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
