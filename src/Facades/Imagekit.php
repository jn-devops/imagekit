<?php

namespace Homeful\Imagekit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Homeful\Imagekit\Imagekit
 */
class Imagekit extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Homeful\Imagekit\Imagekit::class;
    }
}
