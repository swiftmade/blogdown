<?php
namespace Swiftmade\Blogdown\Http\Controllers;

use Swiftmade\Blogdown\PostsRepository;

class PostsController
{
    private $posts;

    public function __construct(PostsRepository $posts)
    {
        $this->posts = $posts;
    }

    public function index()
    {
        $posts = $this->posts->all()
            ->latest()
            ->paginate(5);

        return view('blogdown::posts')->with(
            compact('posts')
        );
    }

    public function show($slug)
    {
        $post = $this->posts->find($slug);
        abort_unless($post, 404);

        $others = $this->posts->all()
            ->where('slug', '!=', $post->slug)
            ->take(5);

        return view('blogdown::post')->with(
            compact('post', 'others')
        );
    }
}
