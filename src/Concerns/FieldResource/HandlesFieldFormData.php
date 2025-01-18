<?php

namespace HungryBus\CustomFields\Concerns\FieldResource;

use Filament\Facades\Filament;
use HungryBus\CustomFields\Rules\FieldIsUnique;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HandlesFieldFormData
{
    protected function prepareData(array $data): array
    {
        if (config('custom-fields.use_tenants')) {
            $data['tenant_id'] = Filament::getTenant()->getKey();
        }
        $data['name'] = Str::slug($data['label']);

        return $data;
    }

    protected function validateFieldData(array $data, ?Model $record = null): void
    {
        validator($data, [
            'name' => ['required', new FieldIsUnique($record?->getKey(), $data['tenant_id'] ?? null)],
        ])->validate();
    }
}
