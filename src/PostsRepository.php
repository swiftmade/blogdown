<?php
namespace Swiftmade\Blogdown;

use Swiftmade\Blogdown\Post\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Swiftmade\Blogdown\Parsers\MetaParser;

class PostsRepository
{
    private const CacheKey = 'blogdown.posts';

    public function all()
    {
        return collect($this->getIndex())
            ->map(function ($post) {
                return new Post($post);
            })
            ->sortByDesc('date');
    }

    public function byTags(...$tags)
    {
        return $this->all()->filter(function ($post) use ($tags) {
            return count(array_intersect(
                $post->tags,
                $tags
            ));
        });
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
        if (!app()->environment('production')) {
            return 0;
        }
        return now()->addMinutes(Config::get('blogdown.index_ttl'));
    }

    protected function getIndex()
    {
        return Cache::remember(self::CacheKey, $this->cacheTtl(), function () {
            $index = collect(File::files($this->blogFolder()))
                ->filter(function ($file) {
                    return pathinfo($file, PATHINFO_EXTENSION) === 'php';
                })
                ->map(function ($path) {
                    return MetaParser::parse($path);
                });

            $diff = array_diff(
                $index->pluck('slug')->toArray(),
                $index->pluck('slug')
                    ->unique()
                    ->toArray()
            );

            if (!empty($diff)) {
                throw new \Exception('Blogdown duplicate slug: /' . $diff[0]);
            }

            return $index->keyBy('slug');
        });
    }

    protected function blogFolder()
    {
        return resource_path('views/' . Config::get('blogdown.blog_folder'));
    }
}
