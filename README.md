<p align="center" style="margin-top: 2rem; margin-bottom: 2rem;">
    <img src="/art/banner.png" alt="Logo Laravel Mercanet"/>
</p>

# Laravel Mercanet

A laravel wrapper for [BnpParibas Mercanet](https://mabanquepro.bnpparibas/fr/notre-offre-pro/comptes-cartes-et-services/solutions-d-encaissement/encaissement-internet-et-mobile/offre-e-commerce-mercanet) which provide a lightweight public api to process your online payments from your laravel application.

[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mouadziani/laravel-mercanet/run-tests?label=tests)](https://github.com/mouadziani/laravel-mercanet/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/mouadziani/laravel-mercanet/Check%20&%20fix%20styling?label=code%20style)](https://github.com/mouadziani/laravel-mercanet/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
![License](https://img.shields.io/packagist/l/mouadziani/laravel-mercanet)


## Installation

You can install the package via composer:

```bash
composer require mouadziani/laravel-mercanet
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Mouadziani\Mercanet\MercanetServiceProvider"
```

## Configuration
As a first, you need to change the following credentials located in the ```config/mercanet.php``` file, with your own credentials given from your mercanet account.

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

    'currency' => env('MERCANET_CURRENCY', 'EUR'),

    // Should be replaced with a url of your callback post route,
    // which will be invoked by mercanet service after processing of any payment.
    'normal_return_url' => env('MERCANET_NORMAL_RETURN_URL', 'https://example.com/payments/callback'),

    /**
    * You can set the default locale that you need to be used to translate the mercanet payment page
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

### Prepare and process payment request
In order to process new payment you need to call ``` newPaymentRequest() ``` from the existing mercanet instance and then set the following arguments 
```php
$mercanet->newPaymentRequest();

// Required
$mercanet->setTransactionReference('123456789'); 

// By default the currency used is EUR. If you wish to change it,
// you may call setCurrency method to set a different currency before calling pay() method
$mercanet->setCurrency('EUR');

// Optionally, You can also call setLanguage method to change the default locale of payment page
$mercanet->setLanguage('fr');

// Required and it should be integer 
// Make sure to multiply the original amount * 100 (eg: 199.00 * 100 = 19000)
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
Instead of creation new instance from Mercanet class and call method separately on it, you can use also the static constructor as the following example:

```php
use Mouadziani\Mercanet\Mercanet;

Mercanet::boot()
    ->newPaymentRequest()
    ->setTransactionReference('123456789')
    ->setCurrency('EUR')
    ->setLanguage('fr')
    ->setAmount(19000)
    ->setBillingContactFirstname('John')
    ->setBillingContactLastname('Doe')
    ->setCustomerContactEmail('john@doe.com')
    ->pay();
```

### Validate payment transaction from callback request

In order to retrieve transaction reference and payment status from the given callback request, you can use the following methods.

```php
use Mouadziani\Mercanet\Mercanet;

// Create new instance or call the static constructor from Mercanet class 
// and then call fromRequest() method and pass request parameters into it. 
$paymentResponse = Mercanet::boot()->fromResponse(request()->all());

// Then you can check if the given payment response is successfully passed by calling isSuccessfullyPassed() method
if($paymentResponse->isSuccessfullyPassed()) {
    // The payment is accepted.
    
    // You can get the transaction reference from the initialized payment request object
    $transactionReference = $paymentResponse->getTransactionReference();
    
    // Then you can do what you want, eg. change the status of the order related to the transaction reference, or mark it as paid...
    App\Order::query()
        ->where('transaction_reference', $transactionReference)
        ->update([
            'is_paid' => true
        ]);
} else {
    // The payment is failed 
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

## Sponsors

<table>
  <tbody>
    <tr>
      <td align="center" valign="middle">
        <a href="https://www.jetbrains.com/?from=https://github.com/mouadziani" target="_blank">
          <img width="222px" src="https://user-images.githubusercontent.com/15586492/96636404-2c18dd00-1315-11eb-9520-736dffaaf0a7.png">
        </a>
      </td>
    </tr>
  </tbody>
</table>

