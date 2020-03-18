<?php
namespace Swiftmade\Blogdown;

class Blogdown
{
    public static $markdownSupport = true;

    public static function disableMarkdown()
    {
        self::$markdownSupport = false;
    }
}
