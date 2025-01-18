<?php

namespace HungryBus\CustomFields\Services;

use Illuminate\Database\Eloquent\Model;

class CustomDataService
{
    public static function getCustomData(Model $model, array $data = [], ?int $modelId = null): array
    {
        if ($modelId) {
            $model = $model::find($modelId);
        }

        if (! method_exists($model, 'customData')) {
            throw new \InvalidArgumentException('Model does not have custom data');
        }

        return array_merge($data, [
            'custom_data' => $model->customData()
                ->with('field')
                ->get()
                ->pluck('value', 'field.name')
                ->toArray(),
        ]);
    }
}
