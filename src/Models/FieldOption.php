<?php

namespace HungryBus\CustomFields\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $field_id
 * @property string $value
 * @property string $label
 * @property int $order
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class FieldOption extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('custom-fields.table_names.field_options', 'field_options');
    }

    /*
     * Relations
     */

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class, 'field_id');
    }
}
