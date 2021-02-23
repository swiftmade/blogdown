<?php

namespace Swiftmade\Blogdown\Models;

use ArrayAccess;
use Swiftmade\Blogdown\Models\Concerns\HasArrayAccess;

class Author implements ArrayAccess
{
    use HasArrayAccess;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    protected function getAttribute($name)
    {
        return $this->data[$name];
    }
}
