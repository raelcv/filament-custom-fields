<?php

namespace HungryBus\CustomFields\Models;

use Carbon\Carbon;
use HungryBus\CustomFields\Concerns\HasTenancy;
use HungryBus\CustomFields\Enum\FieldType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $uuid
 * @property FieldType $field_type
 * @property string $name
 * @property string $label
 * @property string $placeholder
 * @property bool $required
 * @property int $min
 * @property int $max
 * @property string $description
 * @property string $group
 * @property int $group_order
 * @property string $designation
 * @property int $order
 * @property int $company_id
 * @property bool $is_readonly
 * @property bool $is_table_visible
 * @property bool $is_sortable
 * @property bool $is_filterable
 * @property bool $is_searchable
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method Builder model(string $model)
 */
class Field extends Model
{
    use HasTenancy;

    protected $guarded = [];

    protected $casts = [
        'field_type' => FieldType::class,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('custom-fields.table_names.custom_fields', 'fields');
    }

    /*
     * Relations
     */

    public function customData(): HasMany
    {
        return $this->hasMany(
            config('custom-fields.models.custom_data', CustomData::class),
            'field_id'
        );
    }

    public function options(): HasMany
    {
        return $this->hasMany(
            config('custom-fields.models.field_option', FieldOption::class),
        )->orderBy('order');
    }

    /*
     * Scopes
     */
    public function scopeModel(Builder $query, string $model): Builder
    {
        return $query->where('designation', $model);
    }
}
