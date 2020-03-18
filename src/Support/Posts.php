<?php
namespace Swiftmade\Blogdown\Support;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Posts extends Collection
{
    public function latest($dateField = 'date')
    {
        return $this->sortByDesc($dateField);
    }

    public function whereContains($attribute, $search)
    {
        if (!is_array($search)) {
            $search = [$search];
        }

        return $this->filter(function ($post) use ($attribute, $search) {
            return count(array_intersect(
                $post->$attribute,
                $search
            ));
        });
    }

    public function paginate($perPage, $pageName = 'page')
    {
        $page = Paginator::resolveCurrentPage($pageName);

        return new LengthAwarePaginator(
            $this->items->forPage($page, $perPage),
            $this->items->count(),
            $perPage,
            $page
        );
    }
}
