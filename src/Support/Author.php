<?php
namespace Swiftmade\Blogdown\Support;

use stdClass;

class Author extends stdClass
{
    public static function fromArray(array $author)
    {
        $instance = new self;
        foreach ($author as $key => $value) {
            $instance->$key = $value;
        }
        return $instance;
    }
}
