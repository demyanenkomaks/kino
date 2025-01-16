<?php

namespace Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class MainCategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'mainCategories';

    protected static ?string $inverseRelationship = 'categories';

    protected static ?string $title = 'Главные категории';

    protected static ?string $modelLabel = 'Главная категория';

    protected static ?string $pluralModelLabel = 'Главные категории';

    protected static ?string $recordTitleAttribute = 'name';

    protected static bool $isLazy = false;

    public function form(Form $form): Form
    {
        return $form->schema(CategoriesRelationManager::getRepositoryPivotFields());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
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
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        return $state;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('pivot.description')
                    ->label('Описание')
                    ->wrap()
                    ->limit(100)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

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
                    ->multiple()
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mountUsing(fn ($record, $form) => $form->fill($record->pivot->toArray())),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->mainCategories()->count();
    }
}
