<?php

namespace Swiftmade\Blogdown\Commands;

use Illuminate\Console\Command;
use Swiftmade\Blogdown\PostsRepository;

class IndexPosts extends Command
{
    protected $signature = 'blog:index';
    protected $description = 'Rebuild blog index';

    public function handle(PostsRepository $postsRepository)
    {
        $postsRepository->forget();

        $count = $postsRepository->all()->count();

        $this->info('Indexed ' . $count . ' posts.');
    }
}
