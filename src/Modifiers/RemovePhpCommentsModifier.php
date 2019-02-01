<?php

namespace Swiftmade\Blogdown\Modifiers;

use Swiftmade\Blogdown\Contracts\ModifierInterface;

class RemovePhpCommentsModifier implements ModifierInterface
{
    public function apply($html) 
    {
        return preg_replace('/\/\*(.+?)\*\//ms', '', $html);
    }
}
