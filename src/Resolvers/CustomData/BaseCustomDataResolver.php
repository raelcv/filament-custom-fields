<?php

namespace HungryBus\CustomFields\Resolvers\CustomData;

use Illuminate\Database\Eloquent\Model;

abstract class BaseCustomDataResolver
{
    protected function getState(Model $record): ?string
    {
        return $this->field->field_type->hasOptions() && $this->field->options
            ? $this->getOptionLabel($record)
            : $this->getValue($record);
    }

    protected function getFormFieldName(): string
    {
        return 'custom_data.' . $this->field->name;
    }

    private function getOptionLabel(Model $model): ?string
    {
        $value = $this->getValue($model);

        $option = collect($this->field->options)
            ->where('value', $value)
            ->first();

        return $option['label'] ?? $value;
    }

    private function getValue(Model $model): ?string
    {
        return $model
            ->customData
            ->where('field_id', $this->field->id)
            ->first()
            ?->value;
    }
}
