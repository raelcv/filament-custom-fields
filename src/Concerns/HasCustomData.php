<?php

namespace HungryBus\CustomFields\Concerns;

use HungryBus\CustomFields\Models\CustomData;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasCustomData
{
    public function customData(): MorphMany
    {
        return $this->morphMany(CustomData::class, 'model');
    }
}
