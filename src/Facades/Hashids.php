<?php

namespace Litepie\Hashids\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string encode(array $numbers)
 * @method static array decode(string $id)
 *
 * @see \Sqids\Sqids
 */
class Hashids extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'hashids';
    }
}
