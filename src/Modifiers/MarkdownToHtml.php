<?php
namespace Swiftmade\Blogdown\Modifiers;

use Michelf\MarkdownExtra;
use Swiftmade\Blogdown\Contracts\ModifierInterface;

class MarkdownToHtml implements ModifierInterface
{
    public function apply($input)
    {
        return MarkdownExtra::defaultTransform($input);
    }
}
