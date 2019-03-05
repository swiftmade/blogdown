<?php

namespace Swiftmade\Blogdown\Facades;

use Illuminate\Support\Facades\Facade;

class AddAttribute extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Swiftmade\Blogdown\Modifiers\TagModifier\AddAttribute::class;
    }
}
