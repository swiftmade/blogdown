<?php
namespace Swiftmade\Blogdown;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

class PostScanner
{
    const Extensions = [
        '.md',
        '.md.php',
        '.blade.php',
        '.md.blade.php',
    ];

    public function __invoke()
    {
        $index = collect(File::files($this->blogFolder()))
                ->filter(function ($file) {
                    return preg_match($this->extensionMatcher(), $file);
                })
                ->map(function ($path) {
                    return MetaParser::parse($path);
                });

        $this->checkForDuplicates($index);

        return $index->keyBy('slug');
    }

    protected function checkForDuplicates($index)
    {
        $diff = array_diff(
            $index->pluck('slug')->toArray(),
            $index->pluck('slug')
                    ->unique()
                    ->toArray()
        );

        if (!empty($diff)) {
            throw new \Exception('Blogdown duplicate slug: /' . $diff[0]);
        }
    }

    protected function extensionMatcher()
    {
        $extensions = collect(self::Extensions)
            ->map(function ($ext) {
                return preg_quote($ext);
            })
            ->join('|');

        return '/' . $extensions . '$/';
    }

    protected function blogFolder()
    {
        if (app()->runningUnitTests()) {
            return __DIR__ . '/../tests/fixtures';
        }
        return resource_path('views/' . Config::get('blogdown.blog_folder'));
    }
}
