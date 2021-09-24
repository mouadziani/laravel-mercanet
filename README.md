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

## Configuration
First, you need to change the following credentials located in the ```app/config/mercanet.php``` file, with your own credentials given from your account mercanet.

```php
return [
    /**
     * Can only be 'TEST' Or 'Production'. If empty or invalid, 'TEST' will be used.
     */
    'mode' => env('MERCANET_MODE', 'TEST'),

    // Credentials of testing environment
    'test' => [
        'merchant_id' => env('MERCANET_TEST_MERCHANT_ID', ''), // Required
        'key_version' => env('MERCANET_TEST_KEY_VERSION', '1'),
        'secret_key' => env('MERCANET_TEST_SECRET_KEY', ''), // Required
    ],

    // Credentials of production environment
    'production' => [
        'merchant_id' => env('MERCANET_PRODUCTION_MERCHANT_ID', ''), // Required
        'key_version' => env('MERCANET_PRODUCTION_KEY_VERSION', '1'), // Required
        'secret_key' => env('MERCANET_PRODUCTION_SECRET_KEY', ''), // Required
    ],

    'currency' => env('MERCANET_CURRENCY', 'USD'),

    // Should be replaced with a url of your callback post route,
    // which will be invoked by mercanet service after processing of any payment.
    'normal_return_url' => env('MERCANET_NORMAL_RETURN_URL', 'https://example.com/payments/callback'),

    /**
    * You can set the default locale that you need to be use in mercanet payment page
     * Allowed languages 'nl', 'fr', 'de', 'it', 'es', 'cy', 'en'
     */
    'language' => env('MERCANET_LOCALE', 'en'),
];
```

## Usage
Following are some ways through which you can bootstrap the process of payment:

```php
// Import the class namespaces first, before using it directly
use Mouadziani\Mercanet\Mercanet;

// You can either create new instance from Mercanet
$mercanet = new Mercanet();

// Or through static constructor boot.
$mercanet = Mercanet::boot();
```

### Process new payment
In order to process new payment you need to call ``` newPaymentRequest() ``` from the existing mercanet instance and then set the following arguments 
```php
$mercanet->newPaymentRequest();

// Required
$mercanet->setTransactionReference('123456789'); 

// By default the currency used is USD. If you wish to change it,
// you may call setCurrency method to set a different currency before calling pay() method
$mercanet->setCurrency('USD');

// Optional, You can also call setLanguage method to change the default locale of checkout page
$mercanet->setLanguage('fr');

// Required and it should be integer
$mercanet->setAmount(19000);

// Optional
$mercanet->setBillingContactFirstname('John');

 // Optional
$mercanet->setBillingContactLastname('Doe');

 // Optional
$mercanet->setCustomerContactEmail('john@doe.com');

// Then you can call pay() method to redirect user to the payment page of mercanet website.
$mercanet->pay();
```
Instead of creation new instance from Mercanet class and call method on it separately, also use the static constructor as the following example:
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


### Callback request
```php
use Mouadziani\Mercanet\Mercanet;

$paymentResponse = Mercanet::boot()->fromResponse(request()->all());

if($paymentResponse->isSuccessfullyPassed()) {
    Order::query()
        ->where('transaction_reference', $paymentResponse->getTransactionReference())
        ->markAsPaid();
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [MouadZIANI](https://github.com/mouadziani)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
