<?php

namespace Swiftmade\Blogdown\Support;

use Illuminate\Support\Carbon;
use Swiftmade\Blogdown\Models\Author;
use Illuminate\Support\Facades\Config;

class AttributeTypes
{
    const Tags = 'tags';

    const Date = 'date';

    const Author = 'author';

    public static function cast($value, $type)
    {
        switch ($type) {
            case self::Tags:
                return explode(',', $value);

            case self::Author:
                return new Author(
                    Config::get('blogdown.authors.' . $value)
                );

            case self::Date:
                return Carbon::createFromFormat(
                    Config::get('blogdown.date_format'),
                    $value
                );

            default:
                return $value;
        }
    }
}
