<?php

namespace Modules\Kino\Filament\Clusters\Kino\Resources;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Modules\Kino\Filament\Clusters\Kino;
use Modules\Kino\Filament\Clusters\Kino\Resources\CountriesResource\Pages;
use Modules\Kino\Models\Countries;

class CountriesResource extends Resource
{
    protected static ?string $model = Countries::class;

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
                Toggle::make('is_active')
                    ->label('Активный')
                    ->onColor('success')
                    ->offColor('danger')
                    ->columnSpan('full'),
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
                ToggleColumn::make('is_active')
                    ->label('Активный')
                    ->onColor('success')
                    ->offColor('danger'),
                TextColumn::make('name')
                    ->label('Название')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Активный')
                    ->placeholder('Все'),
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
            'create' => Pages\CreateCountries::route('/create'),
            'edit' => Pages\EditCountries::route('/{record}/edit'),
        ];
    }
}
