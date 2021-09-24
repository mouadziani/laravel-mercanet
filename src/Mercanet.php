<?php

namespace Mouadziani\Mercanet;

use Mouadziani\Mercanet\Concerns\MercanetRequest;
use Mouadziani\Mercanet\Concerns\MercanetResponse;

class Mercanet
{
    use MercanetRequest;
    use MercanetResponse;

    const INTERFACE_VERSION = 'HP_2.20';

    /** @var string */
    protected string $secretKey;

    /** @var array */
    protected array $config = [];

    /**
     * Mercanet constructor.
     */
    public function __construct()
    {
        $this->config = config('mercanet');
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
