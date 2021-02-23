<?php

namespace Swiftmade\Blogdown\Models\Concerns;

trait HasArrayAccess
{
    public function __get($name)
    {
        return $this->getAttribute($name);
    }

    public function offsetExists($offset)
    {
        return ! is_null($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function toArray()
    {
        $array = [];

        foreach (array_keys($this->data) as $key) {
            $array[$key] = $this->getAttribute($key);
        }

        return $array;
    }
}
