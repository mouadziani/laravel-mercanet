<?php

namespace Mouadziani\Mercanet;

class Mercanet
{
    /**
     * Mercanet constructor.
     */
    public function __construct() {
    }

    /**
     * Static constructor
     *
     * @return static
     */
    public static function prepare(): self
    {
        return new static();
    }
}
