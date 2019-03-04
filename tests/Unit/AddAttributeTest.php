<?php

use Swiftmade\Blogdown\Modifiers\TagModifier\AddAttribute;
use Swiftmade\Blogdown\Modifiers\TagModifier\AttributeRule;

class AddAttributeTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_modify_all_h_tags()
    {
        $modifier = new AddAttribute();
        $modifier->rule(AttributeRule::HTags('custom_css_class'));

        $input = join('', [
            '<h1>first tag</h1>',
            '<h2>second tag</h2>',
            '<h3>third tag</h3>',
            '<h4>fourth tag</h4>',
            '<hover>skipped</hover>',
        ]);

        $expected = join('', [
            '<h1 class="custom_css_class">first tag</h1>',
            '<h2 class="custom_css_class">second tag</h2>',
            '<h3 class="custom_css_class">third tag</h3>',
            '<h4 class="custom_css_class">fourth tag</h4>',
            '<hover>skipped</hover>',
        ]);

        $output = $modifier->apply($input);

        $this->assertEquals(
            $expected,
            $output
        );
    }

    /**
     * @test
     */
    public function it_modifies_paragraphs()
    {
        $modifier = new AddAttribute();
        $modifier->rule(AttributeRule::P('mb-4'));

        $input = '<p>test</p><div>unaffected</div>';
        $expected = '<p class="mb-4">test</p><div>unaffected</div>';

        $output = $modifier->apply($input);

        $this->assertEquals(
            $expected,
            $output
        );
    }

    /**
     * @test
     */
    public function it_modifies_links()
    {
        $modifier = new AddAttribute();
        $modifier->rule(AttributeRule::A('btn btn-link'));
        $modifier->rule(AttributeRule::A('_blank', 'target'));

        $input = '<p>test</p> <a href="http://test">test link</a>';
        $expected = '<p>test</p> <a target="_blank" class="btn btn-link" href="http://test">test link</a>';

        $output = $modifier->apply($input);

        $this->assertEquals(
            $expected,
            $output
        );
    }
}
