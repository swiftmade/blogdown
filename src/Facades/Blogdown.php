<?php

namespace Swiftmade\Blogdown\Facades;

use Illuminate\Support\Facades\Facade;

class Blogdown extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'swiftmade.blogdown';
    }
}
