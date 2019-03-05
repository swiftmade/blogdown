<?php

use Carbon\Carbon;
use Swiftmade\Blogdown\Parser;
use Swiftmade\Blogdown\Facades\AddAttribute;
use Swiftmade\Blogdown\Modifiers\TagModifier\AttributeRule;

class ParserTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function it_parses_post_meta()
    {
        $path = __DIR__ . '/../fixtures/post_meta.md';
        $meta = Parser::meta($path);

        $this->assertEquals('post title', $meta->title);

        $this->assertInstanceOf(Carbon::class, $meta->date);
        $this->assertEquals('01.12.2018', $meta->date->format('d.m.Y'));
    }

    /**
     * @test
     */
    public function it_returns_markdown_as_html()
    {
        $path = __DIR__ . '/../fixtures/post_meta.md';

        $html = Parser::html($path);
        $this->assertEquals("<h1>this is an H1</h1>\n\n<p>some text...</p>\n", $html);
    }

    /**
     * @test
     */
    public function it_adds_attributes_to_html()
    {
        $path = __DIR__ . '/../fixtures/post_meta.md';

        AddAttribute::rules(
            AttributeRule::HTags('mb-2')
        );

        $html = Parser::html($path);
        $this->assertEquals("<h1 class=\"mb-2\">this is an H1</h1>\n\n<p>some text...</p>\n", $html);
    }
}
