<?php
namespace Swiftmade\Blogdown\Support;

use stdClass;
use Carbon\Carbon;

class Meta extends stdClass
{
    public function __construct($path)
    {
        $this->path = $path;
        $this->hash = md5_file($path);
    }

    public function parseLine($line)
    {
        list($key, $value) = $this->breakMetaLine($line);

        $setterMethod = 'set' . ucwords($key) . 'Attribute';

        if (method_exists($this, $setterMethod)) {
            return $this->$setterMethod($value);
        }

        $this->$key = $value;
    }

    public function isFileModified()
    {
        return md5_file($this->path) !== $this->hash;
    }

    private function breakMetaLine($line)
    {
        $firstColon = strpos($line, ':');
        return array_map('trim', [
            substr($line, 0, $firstColon),
            substr($line, $firstColon + 1, strlen($line) - $firstColon)
        ]);
    }

    private function setDateAttribute($value)
    {
        $this->date = Carbon::createFromFormat(
            config('blogdown.date_format'),
            $value
        );
    }
}
