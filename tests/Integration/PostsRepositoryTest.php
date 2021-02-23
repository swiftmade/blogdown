<?php

use Swiftmade\Blogdown\PostsRepository;

class PostsRepositoryTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_scans_posts()
    {
        $repository = new PostsRepository();
        $repository->forget();

        $repository->all();
        $this->assertEquals(3, $repository->all()->count());

        $this->assertEquals(
            [
                'draft',
                'post-meta',
                'published2',
            ],
            $repository->all()
                ->pluck('slug')
                ->values()
                ->toArray()
        );
    }

    /**
     * @test
     */
    public function it_filters_by_tag()
    {
        $repository = new PostsRepository();

        $this->assertEquals(
            1,
            $repository->all()
                ->whereContains('tags', 'blog')
                ->count()
        );

        $this->assertEquals(
            1,
            $repository->all()
                ->whereContains('tags', ['blog'])
                ->count()
        );
    }

    /**
     * @test
     */
    public function it_hides_drafts_in_production()
    {
        $repository = new PostsRepository();
        $repository->forget();

        config(['blogdown.index_ttl' => 1]);

        $repository->all();
        $this->assertEquals(3, $repository->all()->count());
        $this->assertNotEmpty($repository->find('draft'));

        app()['env'] = 'production';

        $repository->all();
        $this->assertEquals(2, $repository->all()->count());
        $this->assertEmpty($repository->find('draft'));
    }
}
