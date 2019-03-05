<?php
namespace Swiftmade\Blogdown\Modifiers\TagModifier;

use Swiftmade\Blogdown\Contracts\ModifierInterface;

class AddAttribute implements ModifierInterface
{
    private $rules = [];

    public function rules()
    {
        $args = func_get_args();
        foreach ($args as $rule) {
            $this->rules[] = $rule;
        }
    }

    public function apply($html)
    {
        foreach ($this->rules as $rule) {
            $html = $rule->apply($html);
        }

        return $html;
    }
}
