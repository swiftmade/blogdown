<?php

class NewPostTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_creates_new_post()
    {
        $folder = resource_path('views/' . config('blogdown.blog_folder'));

        // This will create the blog folder, so that we can write to it
        @mkdir(
            $folder,
            0777,
            true
        );

        $this->artisan('blog:new')
            ->expectsQuestion('Title of your new post:', 'Blogdown is Cool!')
            ->expectsQuestion('Author:', 'ahmet')
            ->assertExitCode(0);

        // Assert that the file is created
        $this->assertFileIsReadable(
            $folder . '/blogdown-is-cool.md.blade.php'
        );

        $contents = file_get_contents($folder . '/blogdown-is-cool.md.blade.php');

        $this->assertContains(
            'Blogdown is Cool!',
            $contents
        );

        $this->assertContains(
            'ahmet',
            $contents
        );
    }
}
