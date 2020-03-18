<?php
namespace Swiftmade\Blogdown\Support;

use ArrayAccess;
use Swiftmade\Blogdown\Concerns\HasArrayAccess;

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
