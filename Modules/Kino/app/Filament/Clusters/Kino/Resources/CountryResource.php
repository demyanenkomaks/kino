<?php

namespace Modules\Kino\Filament\Clusters\Kino\Resources;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Maksde\Helpers\Resource\Boolean;
use Maksde\Helpers\Resource\Datetime;
use Modules\Kino\Filament\Clusters\Kino;
use Modules\Kino\Filament\Clusters\Kino\Resources\CountryResource\Pages;
use Modules\Kino\Models\Country;

class CountryResource extends Resource
{
    use Boolean, Datetime;

    protected static ?string $model = Country::class;

    protected static ?string $navigationIcon = 'heroicon-s-tag';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?string $modelLabel = 'Страны';

    protected static ?string $pluralModelLabel = 'Страны';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $cluster = Kino::class;

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ]);
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
                self::datetimeTextColumn('created_at', 'Добавлена'),
                self::datetimeTextColumn('updated_at', 'Отредактирована'),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Активный')
                    ->placeholder('Все'),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
