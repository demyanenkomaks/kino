<?php

namespace Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource\RelationManagers;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource;


class CategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'categories';
    protected static ?string $inverseRelationship = 'mainCategories';
    protected static ?string $title = 'Категории';
    protected static ?string $modelLabel = 'Категория';
    protected static ?string $pluralModelLabel = 'Категории';
    protected static ?string $recordTitleAttribute = 'name';
    protected static bool $isLazy = false;

    public function form(Form $form): Form
    {
        return $form->schema(self::getRepositoryPivotFields());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('pivot.order')
                    ->label('Порядок')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('is_active')
                    ->label('Активный')
                    ->onColor('success')
                    ->offColor('danger'),
                TextColumn::make('name')
                    ->label('Название')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('pivot.title')
                    ->label('Заголовок')
                    ->wrap()
                    ->limit(100)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) return null;
                        return $state;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('pivot.description')
                    ->label('Описание')
                    ->wrap()
                    ->limit(100)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) return null;
                        return $state;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Создано')
                    ->sortable()
                    ->dateTime()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->sortable()
                    ->dateTime()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn(Tables\Actions\AttachAction $action): array => array_merge([$action->getRecordSelect()], self::getRepositoryPivotFields()))
                    ->preloadRecordSelect()
                    ->color('primary'),
                Tables\Actions\CreateAction::make()
                    ->form(fn(Tables\Actions\CreateAction $action, Form $form): array => array_merge(CategoryResource::getFormFields(), self::getRepositoryPivotFields()))
                    ->color('gray'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mountUsing(fn($record, $form) => $form->fill($record->pivot->toArray())),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ])
            ->reorderable('kino_category_sub.order')
            ->defaultSort('kino_category_sub.order');
    }

    public static function getRepositoryPivotFields()
    {
        return [
            TextInput::make('title')
                ->label('Заголовок')
                ->maxLength(255),
            Textarea::make('description')
                ->label('Описание')
                ->rows(6)
                ->autosize()
                ->columnSpan('full'),
        ];
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->categories()->count();
    }
}
