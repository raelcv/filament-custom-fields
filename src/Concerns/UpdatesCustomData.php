<?php

namespace HungryBus\CustomFields\Concerns;

use Filament\Facades\Filament;
use HungryBus\CustomFields\Models\CustomData;
use HungryBus\CustomFields\Services\CustomDataService;
use Illuminate\Database\Eloquent\Model;

trait UpdatesCustomData
{
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return CustomDataService::getCustomData($this->record, $data);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $customData = $data['custom_data'] ?? [];
        unset($data['custom_data']);

        $this->saveModelData($this->record, $customData);

        return $data;
    }

    protected function saveModelData(Model $model, array $customData): void
    {
        $company = Filament::getTenant();
        $fields = $company->fields;
        $customDataModel = config('custom-fields.models.custom_data', CustomData::class);

        foreach ($customData as $key => $value) {
            if (! $fields->contains('name', $key)) {
                continue;
            }

            $fieldId = $fields->where('name', $key)->first()->id;

            $customDataModel::updateOrCreate(
                [
                    'model_type' => $model::class,
                    'model_id' => $model->id,
                    'field_id' => $fieldId,
                ],
                ['value' => $value]
            );
        }
    }
}
