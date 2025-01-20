<?php

namespace HungryBus\CustomFields\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use HungryBus\CustomFields\Enum\FieldType;
use HungryBus\CustomFields\Filament\Resources\FieldResource\Pages;
use HungryBus\CustomFields\Models\Field;
use Illuminate\Database\Eloquent\Builder;
use Vicmans\FilamentNumberInput\NumberInput;

class FieldResource extends Resource
{
    protected static ?string $tenantOwnershipRelationshipName = 'tenantRelationship';

    public static function getModel(): string
    {
        return config('custom-fields.models.custom_field', Field::class);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('custom-fields.designation'))
                    ->schema([
                        Forms\Components\Select::make('designation')
                            ->label(__('custom-fields.designation'))
                            ->options(config('custom-fields.field_designations'))
                            ->required(),
                    ]),

                Forms\Components\Section::make(__('custom-fields.main_info'))
                    ->columns()
                    ->schema([
                        Forms\Components\TextInput::make('label')
                            ->label(__('custom-fields.label'))
                            ->required()
                            ->placeholder('Enter the name of the field'),

                        Forms\Components\TextInput::make('placeholder')
                            ->label(__('custom-fields.placeholder'))
                            ->maxLength(255)
                            ->placeholder(__('custom-fields.placeholder_placeholder')),

                        Forms\Components\TextInput::make('group')
                            ->label(__('custom-fields.group'))
                            ->required()
                            ->placeholder(__('custom-fields.group_placeholder')),

                        NumberInput::make('order')
                            ->label(__('custom-fields.order'))
                            ->minValue(0)
                            ->default(0)
                            ->placeholder(__('custom-fields.order_placeholder')),

                        Forms\Components\Select::make('field_type')
                            ->label(__('custom-fields.field_type'))
                            ->options(FieldType::toSelect())
                            ->reactive()
                            ->afterStateUpdated(
                                static fn (callable $set, $state) => $set(
                                    'has_options',
                                    FieldType::tryFrom($state)?->hasOptions() ?? false
                                )
                            )
                            ->required(),

                        Forms\Components\Textarea::make('description')
                            ->label(__('custom-fields.description'))
                            ->placeholder(__('custom-fields.description_placeholder')),
                    ]),

                Forms\Components\Section::make(__('custom-fields.options'))
                    ->hidden(static fn (callable $get) => ! $get('has_options'))
                    ->schema([
                        Forms\Components\Repeater::make('options')
                            ->label(__('custom-fields.options'))
                            ->addActionLabel(__('custom-fields.add_option'))
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->label(__('custom-fields.label'))
                                    ->required(),

                                Forms\Components\TextInput::make('value')
                                    ->label(__('custom-fields.value'))
                                    ->required(),
                            ])
                            ->relationship('options')
                            ->orderColumn('order')
                            ->collapsible(),
                    ]),

                Forms\Components\Section::make(__('custom-fields.settings'))
                    ->columns(4)
                    ->schema([
                        Forms\Components\Toggle::make('required')
                            ->label(__('custom-fields.required')),

                        Forms\Components\Toggle::make('is_table_visible')
                            ->label(__('custom-fields.is_table_visible')),

                        Forms\Components\Toggle::make('is_searchable')
                            ->label(__('custom-fields.is_searchable')),

                        Forms\Components\Toggle::make('is_sortable')
                            ->label(__('custom-fields.is_sortable')),

                        Forms\Components\TextInput::make('min')
                            ->label(__('custom-fields.min'))
                            ->hidden(static fn (callable $get) => $get('has_options'))
                            ->placeholder(__('custom-fields.min_placeholder')),

                        Forms\Components\TextInput::make('max')
                            ->label(__('custom-fields.max'))
                            ->hidden(static fn (callable $get) => $get('has_options'))
                            ->placeholder(__('custom-fields.max_placeholder')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label(__('custom-fields.label'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('designation')
                    ->label(__('custom-fields.designation'))
                    ->getStateUsing(
                        static fn (Field $record): string => config('custom-fields.field_designations')[$record->designation]
                            ?? ''
                    )
                    ->sortable(),

                Tables\Columns\TextColumn::make('group')
                    ->label(__('custom-fields.group'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('order')
                    ->label(__('custom-fields.order'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('field_type')
                    ->label(__('custom-fields.field_type'))
                    ->searchable()
                    ->badge()
                    ->sortable(),

                Tables\Columns\IconColumn::make('required')
                    ->label(__('custom-fields.required'))
                    ->icon(static fn (Field $record): string => getIcon($record->required))
                    ->color(static fn (Field $record): string => getIconColor($record->required))
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_table_visible')
                    ->label(__('custom-fields.is_table_visible'))
                    ->icon(static fn (Field $record): string => getIcon($record->is_table_visible))
                    ->color(static fn (Field $record): string => getIconColor($record->is_table_visible))
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_searchable')
                    ->label(__('custom-fields.is_searchable'))
                    ->icon(static fn (Field $record): string => getIcon($record->is_searchable))
                    ->color(static fn (Field $record): string => getIconColor($record->is_searchable))
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('designation')
                    ->label(__('custom-fields.designation'))
                    ->options(config('custom-fields.field_designations'))
                    ->query(static function (Builder $query, array $data): Builder {
                        $value = config('custom-fields.field_designations')[$data['value']] ?? '';

                        return $query->where('designation', 'like', '%' . $value . '%');
                    }),

                Tables\Filters\SelectFilter::make('group')
                    ->label(__('custom-fields.group'))
                    ->options(Field::pluck('group', 'group')->filter()->unique())
                    ->query(static function (Builder $query, array $data): Builder {
                        return $query->where('group', 'like', "%{$data['value']}%");
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->visible(auth()->user()->can('Update Field')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->visible(auth()->user()->can('Delete Field')),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('is_readonly', false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFields::route('/'),
            'create' => Pages\CreateField::route('/create'),
            'edit' => Pages\EditField::route('/{record}/edit'),
        ];
    }
}
