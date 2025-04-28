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
use Maksde\Helpers\Filament\Forms\Components\BooleanToggleForm;
use Maksde\Helpers\Filament\Forms\Components\CreateUpdatePlaceholders;
use Maksde\Helpers\Filament\Tables\Columns\BooleanIconColumn;
use Maksde\Helpers\Filament\Tables\Columns\CreateUpdateColumns;
use Maksde\Helpers\Filament\Tables\Filters\CreateUpdateFilters;
use Modules\Kino\Filament\Clusters\Kino;
use Modules\Kino\Filament\Clusters\Kino\Resources\CountryResource\Pages;
use Modules\Kino\Models\Country;

class CountryResource extends Resource
{
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
                ...CreateUpdatePlaceholders::make(),
                BooleanToggleForm::make('is_active', 'Активный'),
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, ?string $state, string $operation): void {
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
                            ->action(function (Get $get, Set $set): void {
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
                BooleanIconColumn::make('is_active', 'Активный'),
                TextColumn::make('name')
                    ->label('Название')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ...CreateUpdateColumns::make(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Активный')
                    ->placeholder('Все'),
                ...CreateUpdateFilters::make(),
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
