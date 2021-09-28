<?php

namespace Mouadziani\Mercanet;

use Mouadziani\Mercanet\Concerns\MercanetRequest;
use Mouadziani\Mercanet\Concerns\MercanetResponse;

class Mercanet
{
    use MercanetRequest;
    use MercanetResponse;

    public const INTERFACE_VERSION = 'HP_2.20';

    /** @var string */
    protected string $secretKey;

    /** @var array */
    protected array $config = [];

    /** @var array */
    protected array $options = [];

    /**
     * Mercanet constructor.
     */
    public function __construct()
    {
        $this->config = config('mercanet');

        $credentials = $this->config['mode'] == 'PRODUCTION'
            ? $this->config['production']
            : $this->config['test'];

        $this->options['merchantId'] = $credentials['merchant_id'];
        $this->secretKey = $credentials['secret_key'];
        $this->options['keyVersion'] = $credentials['key_version'];
        $this->options['normalReturnUrl'] = $this->config['normal_return_url'];
    }

    /**
     * Static constructor
     *
     * @return static
     */
    public static function boot(): self
    {
        return (new static());
    }
}
