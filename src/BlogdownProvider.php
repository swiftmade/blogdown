<?php

namespace Swiftmade\Blogdown;

use Illuminate\Support\Facades\Config;
use Swiftmade\Blogdown\Commands\NewPost;
use Swiftmade\Blogdown\Commands\IndexPosts;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class BlogdownProvider extends LaravelServiceProvider
{
    public function register()
    {
        $this->publishes([
            __DIR__ . '/config/blogdown.php' => config_path('blogdown.php'),
            __DIR__ . '/resources/views' => resource_path('views/vendor/blogdown'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'blogdown');

        $this->mergeConfigFrom(
            __DIR__ . '/config/blogdown.php',
            'blogdown'
        );

        if (Config::get('blogdown.register_routes')) {
            $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        }

        $this->commands([
            IndexPosts::class,
            NewPost::class,
        ]);

        $this->app->singleton('blogdown.postModel', function () {
            return function ($data) {
                $class = Config::get('blogdown.post_model');

                return new $class($data);
            };
        });
    }
}
