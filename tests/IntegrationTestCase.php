<?php

use Illuminate\Foundation\Testing\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        $app->register(\Swiftmade\Blogdown\BlogdownProvider::class);
        return $app;
    }
}
