<?php
namespace Swiftmade\Blogdown\Repositories;

use Illuminate\Support\Facades\Config;
use Swiftmade\Blogdown\Support\Author;

class AuthorsRepository
{
    public function get($id)
    {
        if ($author = Config::get('blogdown.authors.' . $id)) {
            return Author::fromArray($author);
        }

        return null;
    }
}
