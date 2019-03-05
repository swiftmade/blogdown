<?php
namespace Swiftmade\Blogdown\Support;

use stdClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Swiftmade\Blogdown\Repositories\AuthorsRepository;

class Meta extends stdClass
{
    private $_author;

    public function __construct($path)
    {
        $this->path = $path;
        $this->hash = md5_file($path);
        $this->slug = $this->slugFromPath($path);
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
            Config::get('blogdown.date_format'),
            $value
        );
    }

    private function slugFromPath($path)
    {
        return pathinfo($path, PATHINFO_FILENAME);
    }

    public function author()
    {
        if (!$this->_author) {
            $this->_author = resolve(AuthorsRepository::class)->get($this->authorId);
        }
        return $this->_author;
    }
}
