<?php

namespace Mouadziani\Mercanet;

use Mouadziani\Mercanet\Concerns\MercanetRequest;
use Mouadziani\Mercanet\Concerns\MercanetResponse;

class Mercanet
{
    use MercanetRequest;
    use MercanetResponse;

    const INTERFACE_VERSION = 'HP_2.20';

    /**
     * @var string
     */
    protected string $secretKey;

    /**
     * @var array
     */
    protected array $config = [];

    /**
     * Static constructor
     *
     * @return static
     */
    public static function boot(): self
    {
        $instance = new static();
        $instance->config = config('mercanet');
        $instance->preparePaymentRequest();

        return $instance;
    }
}
