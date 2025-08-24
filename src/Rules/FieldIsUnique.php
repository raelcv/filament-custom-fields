<?php

namespace HungryBus\CustomFields\Rules;

use Closure;
use HungryBus\CustomFields\Models\Field;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class FieldIsUnique implements ValidationRule
{
    private int | string $tenantId;

    private ?int $fieldId;

    public function __construct(?int $fieldId = null, ?string $tenantId = null)
    {
        if (config('custom-fields.use_tenants')) {
            $this->tenantId = $tenantId;
        }

        $this->fieldId = $fieldId;
    }

    /**
     * {@inheritDoc}
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        ! Field::where('name', Str::slug($value))
            ->when(
                config('custom-fields.use_tenants'),
                fn(Builder $query) => $query->where(config('custom-fields.tenant_key', 'tenant_id'), $this->tenantId)
            )
            ->when(
                $this->fieldId,
                fn(Builder $query) => $query->where('id', '!=', $this->fieldId)
            )
            ->count() ?: $fail($this->message());
    }

    public function message(): string
    {
        return config('custom-fields.messages.field_is_unique');
    }
}
