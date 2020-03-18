<?php
namespace Swiftmade\Blogdown\Parsers;

use League\CommonMark\Environment;
use Illuminate\Support\Facades\Config;
use League\CommonMark\CommonMarkConverter;

class CommonMark
{
    private $parser;

    public function __construct()
    {
        $environment = Environment::createCommonMarkEnvironment();

        foreach (Config::get('blogdown.commonmark_extensions', []) as $extension) {
            $environment->addExtension(new $extension);
        }

        $this->parser = new CommonMarkConverter(
            Config::get('blogdown.commonmark_options'),
            $environment
        );
    }

    public function toHtml($markdown)
    {
        return $this->parser->convertToHtml($markdown);
    }
}
