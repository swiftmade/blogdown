<?php

use Illuminate\Support\Facades\File;

class NewPostTest extends IntegrationTestCase
{
    protected function tearDown(): void
    {
        // Delete the blog folder
        File::deleteDirectory(resource_path('views/' . config('blogdown.blog_folder')));

        // Tear down the app
        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_creates_new_post()
    {
        $folder = resource_path('views/' . config('blogdown.blog_folder'));

        $this->artisan('blog:new')
            ->expectsQuestion('Title of your new post', 'Blogdown is Cool!')
            ->expectsQuestion('Author', 'ahmet')
            ->assertExitCode(0);

        // Assert that the file is created
        $this->assertFileIsReadable(
            $folder . '/blogdown-is-cool.md.blade.php'
        );

        $contents = file_get_contents($folder . '/blogdown-is-cool.md.blade.php');

        $this->assertStringContainsString(
            'Blogdown is Cool!',
            $contents
        );

        $this->assertStringContainsString(
            'ahmet',
            $contents
        );
    }
}
