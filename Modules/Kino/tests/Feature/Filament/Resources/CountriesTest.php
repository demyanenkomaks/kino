<?php

use Filament\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Support\Str;
use Modules\Kino\Filament\Clusters\Kino\Resources\CountryResource\Pages\CreateCountry;
use Modules\Kino\Filament\Clusters\Kino\Resources\CountryResource\Pages\EditCountry;
use Modules\Kino\Filament\Clusters\Kino\Resources\CountryResource\Pages\ListCountries;
use Modules\Kino\Models\Country;

use function Pest\Livewire\livewire;

it('открывается страница со списком', function () {
    livewire(ListCountries::class)
        ->assertSuccessful();
});

it('открывается страница для создания', function () {
    livewire(CreateCountry::class)
        ->assertSuccessful();
});

it('открывается страница для редиктирования', function () {
    $record = Country::factory()->create();

    livewire(EditCountry::class, ['record' => $record->getRouteKey()])
        ->assertSuccessful();
});

it('имеется столбец в списке', function (string $column) {
    livewire(ListCountries::class)
        ->assertTableColumnExists($column);
})->with(['id', 'order', 'is_active', 'name', 'slug', 'created_at', 'updated_at']);

it('отображается столбец в списке', function (string $column) {
    livewire(ListCountries::class)
        ->assertCanRenderTableColumn($column);
})->with(['name']);

/** Todo: Найти как проверять сортировку по столбцу! */
// it('сортировка по столбцу', function (string $column) {
//    $records = Country::factory(5)->create();
//
//    livewire(ListCountries::class)
//        ->sortTable($column)
//        ->assertCanSeeTableRecords($records->sortBy($column), inOrder: true)
//        ->sortTable($column, 'desc')
//        ->assertCanSeeTableRecords($records->sortByDesc($column), inOrder: true);
// })->with(['name']);

it('поиск по столбцу', function (string $column) {
    $records = Country::factory(5)->create();

    $value = $records->first()->{$column};

    livewire(ListCountries::class)
        ->searchTable($value)
        ->assertCanSeeTableRecords($records->where($column, $value))
        ->assertCanNotSeeTableRecords($records->where($column, '!=', $value));
})->with(['name', 'slug']);

it('создание записи', function () {
    $record = Country::factory()->make();

    livewire(CreateCountry::class)
        ->fillForm([
            'name' => $record->name,
            'slug' => $record->slug,
        ])
        ->assertActionExists('create')
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Country::class, [
        'name' => $record->name,
        'slug' => $record->slug,
    ]);
});

it('редактирование записи', function () {
    $record = Country::factory()->create();
    $newRecord = Country::factory()->make();

    livewire(EditCountry::class, ['record' => $record->getRouteKey()])
        ->fillForm([
            'name' => $newRecord->name,
            'slug' => $newRecord->slug,
        ])
        ->assertActionExists('save')
        ->call('save')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Country::class, [
        'name' => $newRecord->name,
        'slug' => $newRecord->slug,
    ]);
});

it('удаление записи', function () {
    $record = Country::factory()->create();

    livewire(EditCountry::class, ['record' => $record->getRouteKey()])
        ->assertActionExists('delete')
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($record);
});

it('массовое удаление записей', function () {
    $records = Country::factory(5)->create();

    livewire(ListCountries::class)
        ->assertTableBulkActionExists('delete')
        ->callTableBulkAction(DeleteBulkAction::class, $records);

    foreach ($records as $record) {
        $this->assertModelMissing($record);
    }
});

it('валидация required', function (string $column) {
    livewire(CreateCountry::class)
        ->fillForm([$column => null])
        ->assertActionExists('create')
        ->call('create')
        ->assertHasFormErrors([$column => ['required']]);
})->with(['name', 'slug']);

it('валидация max length', function (string $column) {
    livewire(CreateCountry::class)
        ->fillForm([$column => Str::random(256)])
        ->assertActionExists('create')
        ->call('create')
        ->assertHasFormErrors([$column => ['max:255']]);
})->with(['name', 'slug']);
