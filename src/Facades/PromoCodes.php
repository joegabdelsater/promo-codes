<?php
namespace Joegabdelsater\PromoCodes\Facades;

use Illuminate\Support\Facades\Facade;

class PromoCodes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'promo-codes';
    }
}