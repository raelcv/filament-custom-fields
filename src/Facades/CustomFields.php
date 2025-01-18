<?php

namespace HungryBus\CustomFields\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \HungryBus\CustomFields\CustomFields
 */
class CustomFields extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \HungryBus\CustomFields\CustomFields::class;
    }
}
