<?php

namespace Swiftmade\Blogdown;

use Swiftmade\Blogdown\Support\Meta;
use Illuminate\Support\Facades\Cache;

class MetaRepository
{
    public function all()
    {
        return Cache::get('blogdown.meta', collect([]));
    }

    public function get($slug)
    {
        return $this->all()->get($slug);
    }

    public function put(Meta $meta)
    {
        $all = $this->all();
        $all->put($meta->slug, $meta);
        Cache::forever('blogdown.meta', $all);
    }

    public function flush()
    {
        Cache::forget('blogdown.meta');
    }
}
