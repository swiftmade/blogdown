<?php
namespace Swiftmade\Blogdown\Support;

use Illuminate\Support\Collection;
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
        $page = LengthAwarePaginator::resolveCurrentPage($pageName);

        return new LengthAwarePaginator(
            $this->forPage($page, $perPage),
            $this->count(),
            $perPage,
            $page,
            [
                'path' => request()->getUri()
            ]
        );
    }
}
