<?php

namespace Swiftmade\Blogdown\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class NewPost extends Command
{
    protected $signature = 'blog:new';
    protected $description = 'Creates a new post';

    public function handle()
    {
        $title = $this->ask('Title of your new post:');

        $author = $this->askWithCompletion('Author:', array_keys(
            config('blogdown.authors')
        ));

        $meta = [
            'title' => $title,
            'author' => $author,
            'date' => date(config('blogdown.date_format')),
            'summary' => 'Summary of your post...',
            'tags' => 'tag1, tag2',
        ];

        $folder = resource_path('views/' . config('blogdown.blog_folder'));
        $file = Str::slug($title) . '.md.blade.php';

        file_put_contents(
            $folder . '/' . $file,
            $this->getMetaAsText($meta)
        );

        Artisan::call('blog:index');
    }

    private function getMetaAsText(array $data)
    {
        $meta = '{{--' . PHP_EOL;

        foreach ($data as $key => $value) {
            $meta .= $key . ': ' . $value . PHP_EOL;
        }

        $meta .= '--}}' . PHP_EOL;
        return $meta;
    }
}
