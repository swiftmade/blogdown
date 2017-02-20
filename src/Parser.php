<?php

namespace Swiftmade\Blogdown;

use Michelf\MarkdownExtra;

class Parser
{
    private $path;
    private $content;

    public function __construct($path)
    {
        $this->path = $path;
        $this->content = file_get_contents($path);
    }

    public static function parse($path)
    {
        $parser = (new self($path));
        $blog = new \stdClass();
        $blog->meta = $parser->meta();
        $blog->html = $parser->html();
        $blog->hash = md5_file($path);
        return $blog;
    }

    public function meta()
    {
        if (!preg_match('/\/\*(.+?)\*\//ms', $this->content, $matches)) {
            throw new \Exception("Invalid blogdown syntax. Missing meta section");
        }
        $meta = new \stdClass();
        $meta->path = $this->path;

        collect(explode("\n", $matches[1]))
            ->filter(function ($line) {
                return !empty(trim($line));
            })
            ->each(function ($line) use ($meta) {
                list($key, $value) = $this->breakMetaLine($line);
                $meta->$key = $value;
            });

        return $meta;
    }

    protected function breakMetaLine($line)
    {
        $firstColon = strpos($line, ':');
        return array_map('trim', [
            substr($line, 0, $firstColon),
            substr($line, $firstColon + 1, strlen($line) - $firstColon)
        ]);
    }

    public function html()
    {
        $markdown = preg_replace('/\/\*(.+?)\*\//ms', '', $this->content);
        $html = MarkdownExtra::defaultTransform($markdown);
        // TODO: Move this to a custom modifier.
        $html = str_replace('<table>', '<table class="table table-bordered">', $html);
        return $html;
    }
}