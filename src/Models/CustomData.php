<?php

namespace HungryBus\CustomFields\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $model_type
 * @property int $model_id
 * @property int $field_id
 * @property string $value
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Field $field
 * @property mixed $model
 */
class CustomData extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('custom-fields.table_names.custom_data', 'custom_data');
    }

    /*
     * Relations
     */

    public function model(): MorphTo
    {
        return $this->morphTo(
            config('custom-fields.morphs', 'model'),
            config('custom-fields.morph_type', 'model_type'),
            config('custom-fields.morph_id', 'model_id')
        );
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(
            config('custom-fields.models.custom_field', Field::class),
            'field_id'
        );
    }
}
