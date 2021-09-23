<?php


namespace Mouadziani\Mercanet\Support;


class Helper
{
    /**
     * Check if uri is valid
     *
     * @param string $uri
     *
     * @return bool
     */
    public static function isValidatedUri(string $uri): bool
    {
        if(!filter_var($uri, FILTER_VALIDATE_URL) or strlen($uri) > 200) {
            return false;
        }

        return true;
    }

    /**
     * Convert currency to code
     *
     * @param string $currency
     *
     * @return string|null
     */
    public static function convertCurrencyToCode(string $currency = ''): ?string
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

    /**
     * Generate SHA hash
     *
     * @param array $options
     * @param string $secretKey
     *
     * @return ?string
     */
    public static function generateSHASign(array $options, string $secretKey): ?string
    {
        $shaString = '';
        foreach($options as $key => $value) {
            $shaString .= $key . '=' . $value;
            $shaString .= (array_search($key, array_keys($options)) != (count($options)-1))
                ? '|'
                : $secretKey;
        }

        return hash('sha256', $shaString);
    }

    /**
     * Redirect to given url with post method
     *
     * @param string $url
     * @param array $parameters
     */
    public static function redirectPost(string $url, array $parameters = []): void
    {
        $html = '<!doctype html>
            <html>
            <head>
			</head>
			<body>
			<form id="redirect_form" method="post" action="'.$url.'" >';
            foreach($parameters as $name => $value) {
                $html.= "<input type='hidden' name='$name' id='$name' value='$value' />";
            }
        $html .= '</form>
			<script>
			    const form = document.getElementById("redirect_form");
			    form.submit();
			</script>
			</body>
			</html>';
        echo $html;
        exit();
    }
}