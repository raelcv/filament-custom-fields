<?php

namespace HungryBus\CustomFields\Concerns;

use HungryBus\CustomFields\Models\Field;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasTenantCustomFields
{
    public function fields(): HasMany
    {
        return $this->hasMany(config('custom-fields.models.custom_field', Field::class), 'company_id');
    }
}
