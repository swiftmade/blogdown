<?php
namespace Swiftmade\Blogdown;

use Swiftmade\Blogdown\Post\Post;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Swiftmade\Blogdown\Repositories\MetaRepository;
use Swiftmade\Blogdown\Support\Meta;

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

    public static function filter(callable $filter)
    {
        $repository = resolve(MetaRepository::class);
        $repository->addFilter($filter);
        return new self($repository);
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

        $html = Parser::html($meta->path);
        return Post::fromHtml($html, $meta);
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
        $posts = $this->repository->selected()->sortByDesc('date');
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
        return $this->repository->selected()
            ->filter(function ($meta) use ($slug) {
                return $meta->slug !== $slug;
            })
            ->shuffle()
            ->take($take);
    }
}
