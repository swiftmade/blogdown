<?php
namespace Swiftmade\Blogdown\Providers;

use Swiftmade\Blogdown\Presenter;
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
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/blogdown.php',
            'blogdown'
        );

        $this->commands([
            Build::class
        ]);
    }
}
