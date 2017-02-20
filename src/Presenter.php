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
        $meta = $this->repository->get($slug);
        if(is_null($meta)) {
            abort(404);
        }
        return $meta;
    }
}