<?php

use Swiftmade\Blogdown\MetaParser;

class ParserTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_parses_post_meta()
    {
        $path = __DIR__ . '/../fixtures/post_meta.blade.php';
        $meta = MetaParser::parse($path);

        $this->assertEquals('post title', $meta['title']);
        $this->assertEquals('post-meta', $meta['slug']);
        $this->assertEquals('1.12.2018', $meta['date']);
        $this->assertEquals('The world is your oyster: Developing GIS systems', $meta['description']);
    }

    /**
     * @test
     */
    public function it_parses_urls()
    {
        $path = __DIR__ . '/../fixtures/meta_same_line.blade.php';
        $meta = MetaParser::parse($path);

        $this->assertEquals('comment tags on the same line', $meta['title']);
        $this->assertEquals('https://example.com', $meta['url']);
    }
}
