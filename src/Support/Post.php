<?php
namespace Swiftmade\Blogdown\Post;

use stdClass;
use Swiftmade\Blogdown\Repositories\AuthorsRepository;

class Post extends stdClass
{
    private $_author;

    public static function fromHtml($html, $meta)
    {
        $instance = new self;
        $instance->html = $html;
        $instance->meta = $meta;

        return $instance;
    }

    public function author()
    {
        if (!$this->_author) {
            $this->_author = resolve(AuthorsRepository::class)->get($this->meta->author);
        }

        return $this->_author;
    }
}
