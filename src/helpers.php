<?php

if(function_exists('validate_uri')) {
    function is_validated_uri(string $uri): bool
    {
        if(!filter_var($uri, FILTER_VALIDATE_URL) or strlen($uri) > 200) {
            return false;
        }

        return true;
    }
}

if(!function_exists('convert_currency_to_code')) {
    /**
     * Convert currency to code
     *
     * @param $currency
     *
     * @return string|null
     */
    function convert_currency_to_code($currency): ?string
    {
        $currencies = [
            'EUR' => '978', 'USD' => '840', 'CHF' => '756', 'GBP' => '826',
            'CAD' => '124', 'JPY' => '392', 'MXP' => '484', 'TRY' => '949',
            'AUD' => '036', 'NZD' => '554', 'NOK' => '578', 'BRC' => '986',
            'ARP' => '032', 'KHR' => '116', 'TWD' => '901', 'SEK' => '752',
            'DKK' => '208', 'KRW' => '410', 'SGD' => '702', 'XPF' => '953',
            'XOF' => '952'
        ];

        return (!in_array($currency, array_keys($currencies)))
            ? null
            : $currencies[$currency];
    }
}
