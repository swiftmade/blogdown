<?php

namespace Swiftmade\Blogdown;

use Illuminate\Support\Facades\Cache;

class Repository
{
    public function all()
    {
        return Cache::get('blogdown.meta', collect([]));
    }

    public function get($slug, $default = null)
    {
        $all = $this->all();
        if (!$all->has($slug)) {
            return $default;
        }
        return $all->get($slug);
    }

    public function put($blog)
    {
        $all = $this->all();
        $all->put($blog->meta->slug, $blog);
        Cache::forever('blogdown.meta', $all);
    }

    public function flush()
    {
        Cache::forget('blogdown.meta');
    }
}
