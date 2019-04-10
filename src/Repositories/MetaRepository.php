<?php
namespace Swiftmade\Blogdown\Repositories;

use Swiftmade\Blogdown\Support\Meta;
use Illuminate\Support\Facades\Cache;

class MetaRepository
{
    private $filters = [];

    public function addFilter(callable $filter)
    {
        $this->filters[] = $filter;
    }

    public function all()
    {
        return Cache::get('blogdown.meta', collect([]));
    }

    public function selected()
    {
        $items = $this->all();
        if (!empty($this->filters)) {
            foreach ($this->filters as $filter) {
                $items = $items->filter($filter);
            }
        }
        return $items;
    }

    public function get($slug)
    {
        return $this->selected()->get($slug);
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
