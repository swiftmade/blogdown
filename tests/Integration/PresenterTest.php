<?php

use Swiftmade\Blogdown\Parser;
use Swiftmade\Blogdown\Presenter;
use Swiftmade\Blogdown\Support\Meta;
use Swiftmade\Blogdown\Repositories\MetaRepository;

class PresenterTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_filters_posts()
    {
        $repository = new MetaRepository();

        $repository->flush();
        $repository->put(Parser::meta(__DIR__ . '/../fixtures/post_meta.md'));
        $repository->put(Parser::meta(__DIR__ . '/../fixtures/published2.md'));

        $this->assertEquals(2, $repository->all()->count());

        $posts = resolve(Presenter::class)->filter(function (Meta $postMeta) {
            return strpos($postMeta->keywords, 'keyword') !== false;
        })->latest();

        $this->assertCount(1, $posts);
        $this->assertEquals('another published article', $posts->first()->title);

        $posts = resolve(Presenter::class)->latest();
        // Return both only published posts
        $this->assertCount(2, $posts);
        $this->assertEquals('another published article', $posts->first()->title);
        $this->assertEquals('post title', $posts->last()->title);
    }
}
