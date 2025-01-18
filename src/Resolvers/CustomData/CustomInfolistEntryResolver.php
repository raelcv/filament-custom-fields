<?php

namespace HungryBus\CustomFields\Resolvers\CustomData;

use Filament\Infolists\Components\TextEntry;
use HungryBus\CustomFields\Models\Field;

class CustomInfolistEntryResolver extends BaseCustomDataResolver
{
    public function __construct(protected Field $field)
    {
        //
    }

    public static function make(Field $field): CustomInfolistEntryResolver
    {
        return new CustomInfolistEntryResolver($field);
    }

    public function resolve(): TextEntry
    {
        return match ($this->field->field_type) {
            default => TextEntry::make('custom_data.' . $this->field->name)
                ->label($this->field->label)
                ->getStateUsing(
                    fn ($record): mixed => $record
                        ->customData
                        ->where('field_id', $this->field->id)
                        ->first()
                        ?->value
                ),
        };
    }
}
