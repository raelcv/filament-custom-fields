<?php

namespace HungryBus\CustomFields\Concerns;

use Filament\Facades\Filament;
use HungryBus\CustomFields\Models\CustomData;
use HungryBus\CustomFields\Models\Field;
use Illuminate\Database\Eloquent\Model;

trait CreatesWithCustomData
{
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['custom_data']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->saveCustomData($this->record);
    }

    protected function saveCustomData(Model $model): void
    {
        $fieldModel = config('custom-fields.models.custom_field', Field::class);
        $customDataModel = config('custom-fields.models.custom_data', CustomData::class);

        if (config('custom-fields.use_tenants')) {
            $tenant = Filament::getTenant();
            $fields = $tenant->fields()->model(get_class($model))->get();
        } else {
            $fields = $fieldModel::model(get_class($model))
                ->get();
        }

        foreach ($this->data['custom_data'] ?? [] as $key => $value) {
            if (!$fields->contains('name', $key)) {
                continue;
            }

            $customDataModel::create([
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'field_id' => $fields->firstWhere('name', $key)->id,
                'value' => $value,
            ]);
        }
    }
}
