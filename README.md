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
php artisan vendor:publish --tag="custom-fields-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="custom-fields-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="custom-fields-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$customFields = new HungryBus\CustomFields();
echo $customFields->echoPhrase('Hello, HungryBus!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [HungryBus](https://github.com/HungryBus)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
