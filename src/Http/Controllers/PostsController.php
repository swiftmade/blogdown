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
            ->paginate(15);

        return view('vendor.blogdown.posts')->with(
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

        return view('vendor.blogdown.post')->with(
            compact('post', 'others')
        );
    }
}
