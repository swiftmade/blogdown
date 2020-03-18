<?php
namespace Swiftmade\Blogdown;

use Swiftmade\Blogdown\Models\Post;
use Illuminate\Support\Facades\Cache;
use Swiftmade\Blogdown\Support\Posts;
use Illuminate\Support\Facades\Config;

class PostsRepository
{
    private const CacheKey = 'blogdown.posts';

    public function all()
    {
        return new Posts(
            $this->getIndex()->map(function ($post) {
                return new Post($post);
            })
        );
    }

    public function find($slug)
    {
        $index = $this->getIndex();

        if (!isset($index[$slug])) {
            return null;
        }

        return new Post($index[$slug]);
    }

    public function forget()
    {
        return Cache::forget(self::CacheKey);
    }

    protected function cacheTtl()
    {
        if (app()->environment('local')) {
            return 0;
        }
        return now()->addMinutes(Config::get('blogdown.index_ttl'));
    }

    protected function getIndex()
    {
        $index = Cache::remember(self::CacheKey, $this->cacheTtl(), function () {
            return (new PostScanner)();
        });

        if (app()->environment('production')) {
            return $index->filter(function ($post) {
                return !$post['is_draft'];
            });
        }

        return $index;
    }
}
