<?php
namespace Swiftmade\Blogdown;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Presenter
{
    /**
     * @var \Swiftmade\Blogdown\PostsRepository
     */
    private $repository;

    public function __construct(PostsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find($slug)
    {
        return $this->repository->find($slug);
    }

    public function findOrFail($slug)
    {
        if ($post = $this->find($slug)) {
            return $post;
        }
        abort(404);
    }

    public function latest($paginate = 10)
    {
        $posts = $this->repository->all()->sortByDesc('date');

        return $this->paginate(
            $posts,
            $paginate
        );
    }

    private function paginate(Collection $items, $perPage)
    {
        $page = Paginator::resolveCurrentPage();

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page
        );
    }

    public function others($slug, $take = 5)
    {
        return $this->repository->all()
            ->filter(function ($post) use ($slug) {
                return $post->slug !== $slug;
            })
            ->shuffle()
            ->take($take);
    }
}
