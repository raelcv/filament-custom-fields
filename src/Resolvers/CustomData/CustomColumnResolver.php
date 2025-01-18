<?php

namespace HungryBus\CustomFields\Resolvers\CustomData;

use Filament\Tables\Columns\TextColumn;
use HungryBus\CustomFields\Models\Field;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CustomColumnResolver extends BaseCustomDataResolver
{
    public function __construct(protected Field $field)
    {
        //
    }

    public static function make(Field $field): CustomColumnResolver
    {
        return new CustomColumnResolver($field);
    }

    public function resolve(): TextColumn
    {
        return TextColumn::make('custom_data.' . $this->field->id . '.value')
            ->label($this->field->label)
            ->getStateUsing(fn (Model $record): ?string => $this->getState($record))
            ->sortable($this->field->is_sortable)
            ->searchable(
                $this->field->is_searchable,
                static fn (Builder $query, string $search) => $query->orWhereHas(
                    'customData',
                    static fn (Builder $q) => $q->where('value', 'like', "%$search%")
                        ->orWhereHas(
                            'field.options',
                            static fn (Builder $qq) => $qq->where('label', 'like', "%$search%")
                        )
                )
            );
    }
}
