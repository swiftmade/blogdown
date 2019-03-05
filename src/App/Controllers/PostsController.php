<?php
namespace Swiftmade\Blogdown\App\Controllers;

use Swiftmade\Blogdown\Presenter;

class PostsController
{
    private $presenter;

    public function __construct(Presenter $presenter)
    {
        $this->presenter = $presenter;
    }

    public function index()
    {
        $posts = $this->presenter->latest(2);

        return view('vendor.blogdown.posts')->with(
            compact('posts')
        );
    }

    public function show($slug)
    {
        $post = $this->presenter->findOrFail($slug);
        $others = $this->presenter->others($slug, 5);

        return view('vendor.blogdown.post')->with(
            compact('post', 'others')
        );
    }
}
