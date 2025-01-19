<?php

namespace HungryBus\CustomFields\Concerns;

use Illuminate\Database\Eloquent\RelationNotFoundException;

trait HasTenancy
{
    public function tenantRelationship()
    {
        if (! config('custom-fields.models.tenant_model') && config('custom-fields.use_tenants')) {
            throw new RelationNotFoundException('Tenant model not found');
        }

        return $this->belongsTo(
            config('custom-fields.models.tenant_model'),
            config('custom-fields.tenant_key', 'tenant_id'),
        );
    }
}
