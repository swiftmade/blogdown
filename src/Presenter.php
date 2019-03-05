<?php
namespace Swiftmade\Blogdown;

use Swiftmade\Blogdown\Post\Post;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Swiftmade\Blogdown\Repositories\MetaRepository;

class Presenter
{
    /**
     * @var \Swiftmade\Blogdown\MetaRepository
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
            ->filter(function ($meta) use ($slug) {
                return $meta->slug !== $slug;
            })
            ->shuffle()
            ->take($take);
    }
}
