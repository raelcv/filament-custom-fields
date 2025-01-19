# This plugin allows to create custom fields via front-end

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hungrybus/filament-custom-fields.svg?style=flat-square)](https://packagist.org/packages/hungrybus/filament-custom-fields)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/hungrybus/filament-custom-fields/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/hungrybus/filament-custom-fields/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/hungrybus/filament-custom-fields/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/hungrybus/filament-custom-fields/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/hungrybus/filament-custom-fields.svg?style=flat-square)](https://packagist.org/packages/hungrybus/filament-custom-fields)

Filament Custom Fields is a plugin for Laravel Filament that allows you to add custom fields to your Filament resources.

## Installation

You can install the package via composer:

```bash
composer require hungrybus/filament-custom-fields
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="HungryBus\FilamentCustomFields\FilamentCustomFieldsServiceProvider"
```

After publishing the migration files, run the migrations:

```bash
php artisan migrate
```

## Configuration

The package provides a configuration file located at `config/custom-fields.php`. 
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

In order to save and/or display custom fields for a model, you need to add the `HasCustomData` trait to the model:

```php
use HungryBus\FilamentCustomFields\Traits\HasCustomData;

class Vehicle extends Model
{
    use HasCustomData;
}
```

If you have multi-tenancy enabled, you can specify the tenant column in the model:

```php
// Company is a tenant model
class Company extends \Illuminate\Database\Eloquent\Model
{
    use \HungryBus\CustomFields\Concerns\HasTenantCustomFields;
}
```

### Displaying Custom Field Responses
To display custom field responses in a resource's table, add the custom fields column:

```php
use HungryBus\FilamentCustomFields\CustomFields\FilamentCustomFieldsHelper;

public static function table(Table $table): Table
{
    $columns = [
        // Your existing columns
    ];

    return $table
        ->columns([
            // Your existing columns
            FieldsService::buildTable(Vehicle::class, $columns))
        ]);
}
```

### Displaying Custom Field Responses in a Form

To display custom field responses in a form, add the custom fields to the form:

```php
return $form->schema([
    // Your existing fields
    \HungryBus\CustomFields\Services\FieldsService::buildForm(Vehicle::class)
]);
```

In Create page, add the `CreatesWithCustomData` trait to the resource:

```php
class CreateVehicle extends \Filament\Resources\Pages\CreateRecord
{
    use CreatesWithCustomData;
}
```

Then, in the Edit page, add the `UpdatesWithCustomData` trait to the resource:

```php
class EditVehicle extends \Filament\Resources\Pages\EditRecord
{
    use UpdatesWithCustomData;
}
```

### Displaying Custom Field Responses in Infolist

To display custom field responses in an infolist, add the custom fields to the infolist:

```php
return $infolist->schema([
    // Your existing fields
    \HungryBus\CustomFields\Services\FieldsService::buildInfolist(Vehicle::class)
]);
```

## Credits
This package is developed and maintained by HungryBus.

## Disclaimer
This is my very first open-source package. I am still learning the open-source topic, and I am open to any constructive 
feedback or suggestions. Please feel free to open an issue to express an opinion or ask a question. If you think you can 
help this package to grow, please feel free to open a pull request.

Due to my job and some personal stuff, I am extremely busy at the moment, and it is quite hard to me to find time to 
work on this on everyday basis. I will try to find time to work on this package as much as I can.

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
