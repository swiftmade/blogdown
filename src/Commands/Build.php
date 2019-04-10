<?php

namespace Swiftmade\Blogdown\Commands;

use Swiftmade\Blogdown\Parser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Swiftmade\Blogdown\Support\Meta;
use Swiftmade\Blogdown\Repositories\MetaRepository;

class Build extends Command
{
    /**
     * @var MetaRepository
     */
    private $repository;

    protected $signature = 'blog:build';
    protected $description = 'Caches blog articles';

    public function __construct(MetaRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    public function handle()
    {
        $this->repository->flush();

        $blogPath = base_path(config('blogdown.blog_folder'));
        collect(File::files($blogPath))
            ->filter(function ($file) {
                return pathinfo($file, PATHINFO_EXTENSION) === 'md';
            })
            ->each(function ($path) {
                $meta = Parser::meta((string)$path);

                if ($this->shouldPublish($meta)) {
                    $this->repository->put($meta);
                    $this->info('Cached /' . $meta->slug);
                } else {
                    $this->comment('Draft /' . $meta->slug);
                }
            });
    }

    private function shouldPublish(Meta $meta)
    {
        if (app()->environment() === 'production') {
            return $meta->isPublished();
        }
        // In development or other modes, don't hide draft articles...
        return true;
    }
}
