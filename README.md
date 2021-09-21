# Laravel Mercanet
A laravel wrapper for BnpParibas Mercanet payment gateway

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mouadziani/laravel-mercanet.svg?style=flat-square)](https://packagist.org/packages/mouadziani/laravel-mercanet)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mouadziani/laravel-mercanet/run-tests?label=tests)](https://github.com/mouadziani/laravel-mercanet/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/mouadziani/laravel-mercanet/Check%20&%20fix%20styling?label=code%20style)](https://github.com/mouadziani/laravel-mercanet/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)


## Installation

You can install the package via composer:

```bash
composer require mouadziani/laravel-mercanet
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Mouadziani\Mercanet\MercanetServiceProvider" --tag="laravel-mercanet-config"
```

## Usage

```php
use Mouadziani\Mercanet\Mercanet;

Mercanet::boot()
    ->newPaymentRequest()
    ->setTransactionReference('123456789')
    ->setCurrency('USD')
    ->setLanguage('fr')
    ->setAmount(19000.50)
    ->setBillingContactFirstname('John')
    ->setBillingContactLastname('Doe')
    ->setCustomerContactEmail('john@doe.com')
    ->pay();
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

- [MouadZIANI](https://github.com/mouadziani)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
