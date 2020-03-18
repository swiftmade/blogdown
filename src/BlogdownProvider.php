<?php
namespace Swiftmade\Blogdown;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Swiftmade\Blogdown\Commands\IndexPosts;

class BlogdownProvider extends LaravelServiceProvider
{
    public function register()
    {
        $this->publishes([
            __DIR__ . '/config/blogdown.php' => config_path('blogdown.php'),
            __DIR__ . '/resources/views' => resource_path('views/vendor/blogdown'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/config/blogdown.php',
            'blogdown'
        );

        if (Config::get('blogdown.register_routes')) {
            $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        }

        $this->commands([
            IndexPosts::class
        ]);
    }
}
