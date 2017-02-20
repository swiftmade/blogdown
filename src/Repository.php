<?php

namespace Swiftmade\Blogdown;

use Illuminate\Support\Facades\Cache;

class Repository
{
    public function all()
    {
        return Cache::get('blogdown.meta', collect([]));
    }

    public function get($slug)
    {
        $all = $this->all();
        if (!$all->has($slug)) {
            return null;
        }
        $meta = $all->get($slug);
        if (!$this->validate($meta)) {
            return $this->store($meta->path);
        }
        return $meta;
    }

    private function validate($meta)
    {
        return md5_file($meta->path) === $meta->hash;
    }

    public function put($key, $meta)
    {
        $all = $this->all();
        $all->put($key, $meta);
        Cache::forever('blogdown.meta', $all);
    }

    public function store($path)
    {
        $parser = new Parser($path);
        $meta = $parser->meta();
        $this->put($meta->slug, $meta);
        return $meta;
    }
}