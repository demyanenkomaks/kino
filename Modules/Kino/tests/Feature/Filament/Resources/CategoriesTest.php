<?php

use Filament\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Support\Str;
use Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource\Pages\CreateCategory;
use Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource\Pages\EditCategory;
use Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource\Pages\ListCategories;
use Modules\Kino\Models\Category;

use function Pest\Livewire\livewire;

it('открывается страница со списком', function (): void {
    livewire(ListCategories::class)
        ->assertSuccessful();
});

it('открывается страница для создания', function (): void {
    livewire(CreateCategory::class)
        ->assertSuccessful();
});

it('открывается страница для редактирования', function (): void {
    $record = Category::factory()->create();

    livewire(EditCategory::class, ['record' => $record->getRouteKey()])
        ->assertSuccessful();
});

it('имеется столбец в списке', function (string $column): void {
    livewire(ListCategories::class)
        ->assertTableColumnExists($column);
})->with(['id', 'order', 'is_active', 'name', 'mainCategories.name', 'categories.name', 'title', 'description', 'created_at', 'updated_at']);

it('отображается столбец в списке', function (string $column): void {
    livewire(ListCategories::class)
        ->assertCanRenderTableColumn($column);
})->with(['name']);

/** Todo: Найти как проверять сортировку по столбцу! */
// it('сортировка по столбцу', function (string $column) {
//    $records = Category::factory(5)->create();
//
//    livewire(ListCategories::class)
//        ->sortTable($column)
//        ->assertCanSeeTableRecords($records->sortBy($column), inOrder: true)
//        ->sortTable($column, 'desc')
//        ->assertCanSeeTableRecords($records->sortByDesc($column), inOrder: true);
// })->with(['name']);

it('поиск по столбцу', function (string $column): void {
    $records = Category::factory(5)->create();

    $value = $records->first()->{$column};

    livewire(ListCategories::class)
        ->searchTable($value)
        ->assertCanSeeTableRecords($records->where($column, $value))
        ->assertCanNotSeeTableRecords($records->where($column, '!=', $value));
})->with(['name', 'slug']);

it('создание записи', function (): void {
    $record = Category::factory()->make();

    livewire(CreateCategory::class)
        ->fillForm([
            'name' => $record->name,
            'slug' => $record->slug,
        ])
        ->assertActionExists('create')
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Category::class, [
        'name' => $record->name,
        'slug' => $record->slug,
    ]);
});

it('редактирование записи', function (): void {
    $record = Category::factory()->create();
    $newRecord = Category::factory()->make();

    livewire(EditCategory::class, ['record' => $record->getRouteKey()])
        ->fillForm([
            'name' => $newRecord->name,
            'slug' => $newRecord->slug,
        ])
        ->assertActionExists('save')
        ->call('save')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Category::class, [
        'name' => $newRecord->name,
        'slug' => $newRecord->slug,
    ]);
});

it('удаление записи', function (): void {
    $record = Category::factory()->create();

    livewire(EditCategory::class, ['record' => $record->getRouteKey()])
        ->assertActionExists('delete')
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($record);
});

it('массовое удаление записей', function (): void {
    $records = Category::factory(5)->create();

    livewire(ListCategories::class)
        ->assertTableBulkActionExists('delete')
        ->callTableBulkAction(DeleteBulkAction::class, $records);

    foreach ($records as $record) {
        $this->assertModelMissing($record);
    }
});

it('валидация required', function (string $column): void {
    livewire(CreateCategory::class)
        ->fillForm([$column => null])
        ->assertActionExists('create')
        ->call('create')
        ->assertHasFormErrors([$column => ['required']]);
})->with(['name', 'slug']);

it('валидация max length', function (string $column): void {
    livewire(CreateCategory::class)
        ->fillForm([$column => Str::random(256)])
        ->assertActionExists('create')
        ->call('create')
        ->assertHasFormErrors([$column => ['max:255']]);
})->with(['name', 'slug']);
