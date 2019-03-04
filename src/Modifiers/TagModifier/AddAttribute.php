<?php
namespace Swiftmade\Blogdown\Modifiers\TagModifier;

use Swiftmade\Blogdown\Contracts\ModifierInterface;

class AddAttribute implements ModifierInterface
{
    private $rules = [];

    public function rule(AttributeRule $rule)
    {
        $this->rules[] = $rule;
    }

    public function apply($html)
    {
        foreach ($this->rules as $rule) {
            $html = $rule->apply($html);
        }

        return $html;
    }
}
