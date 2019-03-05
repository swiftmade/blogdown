<?php
namespace Swiftmade\Blogdown\Providers;

use Swiftmade\Blogdown\Presenter;
use Illuminate\Support\Facades\Config;
use Swiftmade\Blogdown\Commands\Build;
use Swiftmade\Blogdown\Facades\Blogdown as BlogdownFacade;
use Swiftmade\Blogdown\Modifiers\TagModifier\AddAttribute;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Swiftmade\Blogdown\Facades\AddAttribute as AddAttributeFacade;

class BlogdownProvider extends LaravelServiceProvider
{
    public function register()
    {
        $this->app->singleton('swiftmade.blogdown', Presenter::class);

        $this->app->singleton(AddAttribute::class, function () {
            return new AddAttribute();
        });

        $this->app->alias('Blogdown', BlogdownFacade::class);
        $this->app->alias('AddAttribute', AddAttributeFacade::class);

        $this->publishes([
            __DIR__ . '/../Config/blogdown.php' => config_path('blogdown.php'),
            __DIR__ . '/../App/Views' => resource_path('views/vendor/blogdown'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/blogdown.php',
            'blogdown'
        );

        if (Config::get('blogdown.register_routes')) {
            $this->loadRoutesFrom(__DIR__ . '/../App/routes.php');
        }

        $this->commands([
            Build::class
        ]);
    }
}
