<?php

use App\Models\User;
use Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource;
use Modules\Kino\Models\Category;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('открывается страница со списком категорий', function () {
    actingAs($this->user)->get(CategoryResource::getUrl('index'))->assertSuccessful();
});

it('открывается страница для создания категории', function () {
    actingAs($this->user)->get(CategoryResource::getUrl('create'))->assertSuccessful();
});

it('открывается страница для редиктирования категории', function () {
    actingAs($this->user)->get(CategoryResource::getUrl('edit', ['record' => Category::factory()->create()]))->assertSuccessful();
});
