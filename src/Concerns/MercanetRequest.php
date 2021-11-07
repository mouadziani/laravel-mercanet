<?php

namespace Mouadziani\Mercanet\Concerns;

use Mouadziani\Mercanet\Support\Helper;

trait MercanetRequest
{
    /** @var string */
    private string $checkoutUrl;

    /**
     * List of available fields
     *
     * @var array|string[]
     */
    private array $availableFields = [
        'amount',
        'currencyCode',
        'merchantId',
        'normalReturnUrl',
        'transactionReference',
        'keyVersion',
        'paymentMeanBrand',
        'customerLanguage',
        'billingAddress.city',
        'billingAddress.company',
        'billingAddress.country',
        'billingAddress',
        'billingAddress.postBox',
        'billingAddress.state',
        'billingAddress.street',
        'billingAddress.streetNumber',
        'billingAddress.zipCode',
        'billingContact.email',
        'billingContact.firstname',
        'billingContact.gender',
        'billingContact.lastname',
        'billingContact.mobile',
        'billingContact.phone',
        'customerAddress',
        'customerAddress.city',
        'customerAddress.company',
        'customerAddress.country',
        'customerAddress.postBox',
        'customerAddress.state',
        'customerAddress.street',
        'customerAddress.streetNumber',
        'customerAddress.zipCode',
        'customerContact',
        'customerContact.email',
        'customerContact.firstname',
        'customerContact.gender',
        'customerContact.lastname',
        'customerContact.mobile',
        'customerContact.phone',
        'customerContact.title',
    ];

    /**
     * List of required fields
     *
     * @var array|string[]
     */
    private array $requiredFields = [
        'amount',
        'currencyCode',
        'merchantId',
        'normalReturnUrl',
        'transactionReference',
        'keyVersion',
    ];

    /**
     * List of allowed languages
     *
     * @var array|string[]
     */
    private array $allowedLanguages = [
        'nl', 'fr', 'de', 'it', 'es', 'cy', 'en',
    ];

    /**
     * @param string $transactionReference
     *
     * @return $this
     */
    public function setTransactionReference(string $transactionReference): self
    {
        if (preg_match('/[^a-zA-Z0-9_-]/', $transactionReference)) {
            throw new \InvalidArgumentException('TransactionReference cannot contain special characters');
        }

        $this->options['transactionReference'] = $transactionReference;

        return $this;
    }

    /**
     * @param int $amount
     *
     * @return $this
     */
    public function setAmount(int $amount): self
    {
        if (! is_int($amount)) {
            throw new \InvalidArgumentException('Integer expected. Amount is always in cents');
        }

        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be a positive number');
        }

        $this->options['amount'] = $amount;

        return $this;
    }

    /**
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency(string $currency): self
    {
        if (! $currencyCode = Helper::convertCurrencyToCode($currency)) {
            throw new \InvalidArgumentException('Unknown currency');
        }

        $this->options['currencyCode'] = $currencyCode;

        return $this;
    }

    /**
     * @param string $language
     *
     * @return $this
     */
    public function setLanguage(string $language): self
    {
        if (! in_array($language, $this->allowedLanguages, true)) {
            throw new \InvalidArgumentException('Invalid language locale');
        }

        $this->options['customerLanguage'] = $language;

        return $this;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setNormalReturnUrl(string $url): self
    {
        if (! Helper::isValidatedUri($url)) {
            throw new \InvalidArgumentException('Uri is not valid');
        }

        $this->options['normalReturnUrl'] = $url;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setCustomerContactEmail(string $email): self
    {
        if (strlen($email) > 50) {
            throw new \InvalidArgumentException('Email is too long');
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email is invalid');
        }

        $this->options['customerContact.email'] = $email;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setBillingContactEmail(string $email): self
    {
        if (strlen($email) > 50) {
            throw new \InvalidArgumentException('Email is too long');
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email is invalid');
        }

        $this->options['billingContact.email'] = $email;

        return $this;
    }

    /**
     * @param string $street
     *
     * @return $this
     */
    public function setBillingAddressStreet(string $street): self
    {
        if (strlen($street) > 35) {
            throw new \InvalidArgumentException('street is too long');
        }

        $this->options['billingAddress.street'] = \Normalizer::normalize($street);

        return $this;
    }

    /**
     * @param string $streetNumber
     *
     * @return $this
     */
    public function setBillingAddressStreetNumber(string $streetNumber): self
    {
        if (strlen($streetNumber) > 10) {
            throw new \InvalidArgumentException('streetNumber is too long');
        }

        $this->options['billingAddress.streetNumber'] = \Normalizer::normalize($streetNumber);

        return $this;
    }

    /**
     * @param string $zipCode
     *
     * @return $this
     */
    public function setBillingAddressZipCode(string $zipCode): self
    {
        if (strlen($zipCode) > 10) {
            throw new \InvalidArgumentException('zipCode is too long');
        }

        $this->options['billingAddress.zipCode'] = \Normalizer::normalize($zipCode);

        return $this;
    }

    /**
     * @param string $city
     *
     * @return $this
     */
    public function setBillingAddressCity(string $city): self
    {
        if (strlen($city) > 25) {
            throw new \InvalidArgumentException('city is too long');
        }

        $this->options['billingAddress.city'] = \Normalizer::normalize($city);

        return $this;
    }

    /**
     * @param string $phone
     *
     * @return $this
     */
    public function setBillingContactPhone(string $phone): self
    {
        if (strlen($phone) > 30) {
            throw new \InvalidArgumentException('phone is too long');
        }

        $this->options['billingContact.phone'] = $phone;

        return $this;
    }

    /**
     * @param string $firstname
     *
     * @return $this
     */
    public function setBillingContactFirstname(string $firstname): self
    {
        $this->options['billingContact.firstname'] = str_replace(["'", '"'], '', \Normalizer::normalize($firstname));

        return $this;
    }

    /**
     * @param string $lastname
     *
     * @return $this
     */
    public function setBillingContactLastname(string $lastname): self
    {
        $this->options['billingContact.lastname'] = str_replace(["'", '"'], '', \Normalizer::normalize($lastname));

        return $this;
    }

    public function __call($method, $args)
    {
        if (0 === strpos($method, 'set')) {
            $field = lcfirst(substr($method, 3));

            if (in_array($field, $this->availableFields, true)) {
                $this->options[$field] = $args[0];

                return $this;
            }
        }

        if (0 === strpos($method, 'get')) {
            $field = lcfirst(substr($method, 3));

            if (array_key_exists($field, $this->options)) {
                return $this->options[$field];
            }
        }

        throw new \BadMethodCallException("Unknown method $method");
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return string
     */
    private function optionsToString(): string
    {
        $optionString = '';
        foreach ($this->options as $key => $value) {
            $optionString .= $key . '=' . $value;
            $optionString .= (array_search($key, array_keys($this->options), true) !== (count($this->options) - 1))
                ? '|'
                : '';
        }

        return utf8_decode($optionString);
    }

    public function validateRequiredOptions(): void
    {
        foreach ($this->requiredFields as $field) {
            if (empty($this->options[$field])) {
                throw new \RuntimeException($field . ' can not be empty');
            }
        }
    }

    /**
     * Prepare payment request
     *
     * @return self
     */
    public function newPaymentRequest(): self
    {
        $this->checkoutUrl = $this->config['mode'] == 'Production'
            ? 'https://payment-webinit.mercanet.bnpparibas.net/paymentInit'
            : 'https://payment-webinit-mercanet.test.sips-atos.com/paymentInit';

        $this->setLanguage($this->config['language']);
        $this->setCurrency($this->config['currency']);

        return $this;
    }

    /**
     * Handle payment process
     */
    public function pay(): void
    {
        $this->validateRequiredOptions();

        Helper::redirectPost($this->checkoutUrl, [
            'Data' => $this->optionsToString(),
            'InterfaceVersion' => self::INTERFACE_VERSION,
            'Seal' => Helper::generateSHASign($this->options, $this->secretKey),
        ]);
    }
}
