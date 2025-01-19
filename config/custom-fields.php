<?php

return [
    /*
     * The model to use for custom data
     */
    'models' => [
        'custom_data' => \HungryBus\CustomFields\Models\CustomData::class,
        'custom_field' => \HungryBus\CustomFields\Models\Field::class,
        'field_option' => \HungryBus\CustomFields\Models\FieldOption::class,
    ],

    'resources' => [
        'custom_fields' => \HungryBus\CustomFields\Filament\Resources\FieldResource::class,
    ],

    /*
     * The table names to use for custom data
     */
    'table_names' => [
        'custom_data' => 'custom_data',
        'custom_fields' => 'fields',
        'field_options' => 'field_options',
    ],

    /*
     * The morph relationship column to use for custom data
     */
    'morphs' => 'model',
    'morph_type' => 'model_type',
    'morph_id' => 'model_id',

    /*
     * Whether to use soft deletes
     */
    'soft_deletes' => false,

    /*
     * Validation messages
     */
    'messages' => [
        'field_is_unique' => 'Field with the same name already exists',
    ],

    /*
     * Field designations: This is used to display the model name in the field type dropdown
     */
    'field_designations' => [
        // \App\Models\User::class => 'User',
    ],

    /*
     * Whether to use multi-tenancy
     */
    'use_tenants' => false,
];
