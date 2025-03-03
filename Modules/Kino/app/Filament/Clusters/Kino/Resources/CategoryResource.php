<?php

namespace Modules\Kino\Filament\Clusters\Kino\Resources;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Maksde\Helpers\Resource\Boolean;
use Maksde\Helpers\Resource\Datetime;
use Modules\Kino\Filament\Clusters\Kino;
use Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource\Pages;
use Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource\RelationManagers\CategoriesRelationManager;
use Modules\Kino\Filament\Clusters\Kino\Resources\CategoryResource\RelationManagers\MainCategoriesRelationManager;
use Modules\Kino\Models\Category;

class CategoryResource extends Resource
{
    use Boolean, Datetime;

    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-s-tag';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?string $modelLabel = 'Категория';

    protected static ?string $pluralModelLabel = 'Категории';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $cluster = Kino::class;

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(array_merge(
                self::getFormFields(),
                [
                    TextInput::make('title')
                        ->label('Заголовок')
                        ->maxLength(255)
                        ->visible(fn (?Category $record) => $record?->categories()->exists()),
                    Textarea::make('description')
                        ->label('Описание')
                        ->rows(6)
                        ->autosize()
                        ->columnSpan('full')
                        ->visible(fn (?Category $record) => $record?->categories()->exists()),
                ]
            ));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('order')
                    ->label('Порядок')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                self::toggleColumn('is_active', 'Активный'),
                TextColumn::make('name')
                    ->label('Название')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('mainCategories.name')
                    ->label('Главные категории')
                    ->listWithLineBreaks()
                    ->limitList(3)
                    ->expandableLimitedList()
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('categories.name')
                    ->label('Категории')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')
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
                TextColumn::make('description')
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
                self::datetimeTextColumn('created_at', 'Добавлена'),
                self::datetimeTextColumn('updated_at', 'Отредактирована'),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Активный')
                    ->placeholder('Все'),
                TernaryFilter::make('isset')
                    ->label('Категории')
                    ->placeholder('Все')
                    ->trueLabel('Главные категории')
                    ->falseLabel('Категории')
                    ->queries(
                        true: fn (Builder $query) => $query->has('categories'),
                        false: fn (Builder $query) => $query->has('mainCategories'),
                        blank: fn (Builder $query) => $query,
                    ),
                self::datetimeFilter('created_at', 'Добавлена'),
                self::datetimeFilter('updated_at', 'Отредактирована'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order')
            ->defaultSort('order');
    }

    public static function getRelations(): array
    {
        return [
            CategoriesRelationManager::class,
            MainCategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<int, Placeholder|TextInput|Toggle>
     */
    public static function getFormFields(): array
    {
        return [
            self::datetimePlaceholder('created_at', 'Добавлена'),
            self::datetimePlaceholder('updated_at', 'Отредактирована'),
            self::toggleForm('is_active', 'Активный', 'full'),
            TextInput::make('name')
                ->label('Название')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function (Set $set, ?string $state, string $operation) {
                    if ($operation === 'create') {
                        $set('slug', Str::slug($state));
                    }
                }),
            TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->suffixActions([
                    Action::make('Обновить')
                        ->icon('heroicon-o-arrow-path')
                        ->action(function (Get $get, Set $set) {
                            $set('slug', Str::slug($get('name')));
                        }),
                ]),
        ];
    }
}
