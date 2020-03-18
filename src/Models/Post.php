<?php
namespace Swiftmade\Blogdown\Models;

use ArrayAccess;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Support\Arrayable;
use Swiftmade\Blogdown\Support\AttributeTypes;
use Swiftmade\Blogdown\Models\Concerns\HasArrayAccess;

class Post implements ArrayAccess, Arrayable
{
    use HasArrayAccess;

    protected $cache;
    protected $data;

    public static $casts = [
        'date' => AttributeTypes::Date,
        'author' => AttributeTypes::Author,
        'tags' => AttributeTypes::Tags,
    ];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function slug()
    {
        return Str::slug($this->data['view_name']);
    }

    public function isDraft()
    {
        return isset($this->data['draft']) && $this->data['draft'];
    }

    public function view()
    {
        return Config::get('blogdown.blog_folder') . '.' . $this->view_name;
    }

    protected function getAttribute($attribute)
    {
        if (!isset(Post::$casts[$attribute])) {
            return $this->data[$attribute];
        }

        return AttributeTypes::cast(
            $this->data[$attribute],
            Post::$casts[$attribute]
        );
    }
}
