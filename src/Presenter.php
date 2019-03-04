<?php
namespace Swiftmade\Blogdown;

use Swiftmade\Blogdown\Post\Post;

class Presenter
{
    /**
     * @var Repository
     */
    private $repository;

    public function __construct(MetaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find($slug)
    {
        if (!($meta = $this->repository->get($slug))) {
            return null;
        }

        // Update meta data if necessary...
        if ($meta->isFileModified()) {
            $meta = Parser::meta($meta->path);
            $this->repository->put($meta);
        }

        $post = new Post;
        $post->meta = $meta;
        $post->html = Parser::html($meta->path);
        return $post;
    }

    public function findOrFail($slug)
    {
        if ($post = $this->find($slug)) {
            return $post;
        }
        abort(404);
    }

    public function latest($take = 10)
    {
        return $this->repository->all()
            ->sortByDesc('date')
            ->take($take);
    }

    public function others($slug, $take = 5)
    {
        return $this->repository->all()
            ->filter(function ($meta) use ($slug) {
                return $meta->slug !== $slug;
            })
            ->shuffle()
            ->take($take);
    }
}
