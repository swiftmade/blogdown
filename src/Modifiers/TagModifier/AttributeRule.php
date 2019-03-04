<?php
namespace Swiftmade\Blogdown\Modifiers\TagModifier;

class AttributeRule
{
    private $tagMatcher;
    private $value;
    private $attribute;

    public function __construct($tagMatcher, $value, $attribute = 'class')
    {
        $this->tagMatcher = $tagMatcher;
        $this->value = $value;
        $this->attribute = $attribute;
    }

    public static function Tags($name, $value, $attribute = 'class')
    {
        return new self("/\<($name)/", $value, $attribute);
    }

    public static function HTags($value, $attribute = 'class')
    {
        return self::Tags('h\\d', $value, $attribute);
    }

    public static function P($value, $attribute = 'class')
    {
        return self::Tags('p', $value, $attribute);
    }

    public static function A($value, $attribute = 'class')
    {
        return self::Tags('a', $value, $attribute);
    }

    public static function Table($value, $attribute = 'class')
    {
        return self::Tags('table', $value, $attribute);
    }

    public static function Img($value, $attribute = 'class')
    {
        return self::Tags('img', $value, $attribute);
    }

    public function apply($html)
    {
        return preg_replace_callback(
            $this->tagMatcher,
            function ($matches) {
                return sprintf(
                    '<%s %s="%s"',
                    $matches[1],
                    $this->attribute,
                    $this->value
                );
            },
            $html
        );
    }
}
