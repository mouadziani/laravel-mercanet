<?php

namespace Mouadziani\Mercanet;

class Mercanet
{
    use Concerns\MercanetRequest;
    use Concerns\MercanetResponse;

    public const INTERFACE_VERSION = 'HP_2.20';

    protected string $secretKey;

    protected array $config = [];

    protected array $options = [];

    public function __construct()
    {
        $this->config = config('mercanet');

        $credentials = $this->config['mode'] == 'Production'
            ? $this->config['production']
            : $this->config['test'];

        $this->options['merchantId'] = $credentials['merchant_id'];
        $this->secretKey = $credentials['secret_key'];
        $this->options['keyVersion'] = $credentials['key_version'];
        $this->options['normalReturnUrl'] = $this->config['normal_return_url'];
    }

    public static function boot(): self
    {
        return (new static());
    }
}
