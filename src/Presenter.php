<?php

namespace Swiftmade\Blogdown;

class Presenter
{
    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function find($slug)
    {
        $blog = $this->repository->get($slug);
        if (is_null($blog)) {
            abort(404);
        }
        if ($this->isModified($blog)) {
            return $this->refresh($blog);
        }
        return $blog;
    }

    public function recent($take = 10)
    {
        return $this->repository->all()
            ->sortByDesc('date')
            ->take($take);
    }

    public function others($slug, $take = 5)
    {
        return $this->repository->all()
            ->filter(function($blog) use($slug) {
                return $blog->meta->slug !== $slug;
            })
            ->shuffle()
            ->take($take);
    }

    protected function isModified($blog)
    {
        return md5_file($blog->meta->path) !== $blog->hash;
    }

    protected function refresh($blog)
    {
        $blog = Parser::parse($blog->meta->path);
        $this->repository->put($blog);
        return $blog;
    }
}