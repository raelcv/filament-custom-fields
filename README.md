# This plugin allows to create custom fields via front-end

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hungrybus/custom-fields.svg?style=flat-square)](https://packagist.org/packages/hungrybus/custom-fields)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/hungrybus/custom-fields/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/hungrybus/custom-fields/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/hungrybus/custom-fields/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/hungrybus/custom-fields/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/hungrybus/custom-fields.svg?style=flat-square)](https://packagist.org/packages/hungrybus/custom-fields)



Filament Custom Fields is a plugin for Laravel Filament that allows you to add custom fields to your Filament resources.

## Installation

You can install the package via composer:

```bash
composer require hungrybus/custom-fields
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-custom-fields-config"
php artisan vendor:publish --tag="filament-custom-fields-migrations"
```

After publishing the migration files, run the migrations:

```bash
php artisan migrate
```

## Configuration

The package provides a configuration file located at `config/filament-custom-fields.php`. 
In this file, you can specify the resources and models that will utilize custom fields. For example:

```php
<?php

use HungryBus\FilamentCustomFields\Resources\CustomFieldResource;
use HungryBus\FilamentCustomFields\Resources\CustomFieldResponseResource;

return [
    'resources' => [
        CustomFieldResource::class,
        CustomFieldResponseResource::class,
    ],
    
    // Models that will have custom fields
    'models' => [
        // \App\Models\YourModel::class => 'your_model',
    ],
    
    'navigation_group' => 'Custom Fields',
    
    'custom_fields_label' => 'Custom Fields',
    
    'custom_field_responses_label' => 'Custom Field Responses',
];
```
## Usage

### Adding Custom Fields to a resource

To integrate custom fields into a Filament resource, follow these steps:
1. Create or Edit a Resource: In your Filament resource, use the `FilamentCustomFieldsHelper` to handle custom fields.
2. Modify the `getFormSchema` Method: Extend the form schema to include custom fields.

```php
use HungryBus\FilamentCustomFields\CustomFields\FilamentCustomFieldsHelper;

protected function getFormSchema(): array
{
    return [
        // Your existing fields
        ...FilamentCustomFieldsHelper::custom_fields_form($this->getModel(), data_get($this->record, 'id')),
    ];
}
```

3. Handle Custom Field Data: After creating or saving a record, ensure that custom field data is processed.
```php
protected function afterSave()
{
    FilamentCustomFieldsHelper::handle_custom_fields_request($this->data, $this->getModel(), $this->record->id);
}
```

### Displaying Custom Field Responses
To display custom field responses in a resource's table, add the custom fields column:

```php
use HungryBus\FilamentCustomFields\CustomFields\FilamentCustomFieldsHelper;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            // Your existing columns
            FilamentCustomFieldsHelper::custom_fields_column(),
        ]);
}
```

## Credits
This package is developed and maintained by HungryBus.

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
```
