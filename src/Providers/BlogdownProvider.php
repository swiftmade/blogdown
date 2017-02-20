<?php

namespace Swiftmade\Blogdown\Providers;

use Swiftmade\Blogdown\Presenter;
use Swiftmade\Blogdown\Commands\Build;
use Swiftmade\Blogdown\Facades\Blogdown as Facade;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class BlogdownProvider extends LaravelServiceProvider
{
    public function register()
    {
        $this->app->singleton('swiftmade.blogdown', Presenter::class);
        $this->app->alias('Blogdown', Facade::class);

        $this->publishes([
            __DIR__ . '/../Config/blogdown.php' => config_path('blogdown.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/blogdown.php', 'blogdown'
        );

        $this->commands([
            Build::class
        ]);
    }
}