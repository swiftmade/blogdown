<?php

namespace Swiftmade\Blogdown\Commands;

use Swiftmade\Blogdown\Parser;
use Illuminate\Console\Command;
use Swiftmade\Blogdown\Repository;
use Illuminate\Support\Facades\File;

class Build extends Command
{
    /**
     * @var Repository
     */
    private $repository;

    protected $signature = 'blog:build';
    protected $description = 'Caches blog articles';

    public function __construct(Repository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    public function handle()
    {
        $blogPath = base_path(config('blogdown.blog_folder'));
        collect(File::files($blogPath))
            ->filter(function ($file) {
                return pathinfo($file, PATHINFO_EXTENSION) === 'md';
            })
            ->each(function ($path) {
                $blog = Parser::parse($path);
                $this->repository->put($blog);
                $this->info('Cached /' . $blog->meta->slug);
            });
    }
}
