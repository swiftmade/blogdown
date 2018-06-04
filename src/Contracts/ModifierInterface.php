<?php

namespace Swiftmade\Blogdown\Contracts;

interface ModifierInterface
{
    public function apply($html);
}
