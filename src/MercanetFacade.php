<?php

namespace Mouadziani\Mercanet;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mouadziani\Mercanet\Mercanet
 */
class MercanetFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-mercanet';
    }
}
