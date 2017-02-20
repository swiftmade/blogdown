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

    public function meta()
    {
        if (!preg_match('/\/\*(.+?)\*\//ms', $this->content, $matches)) {
            throw new \Exception("Invalid blogdown syntax. Missing meta section");
        }
        $raw = $matches[1];
        $lines = explode("\n", $raw);
        $meta = new \stdClass();
        $meta->path = $this->path;
        $meta->hash = md5_file($this->path);
        $meta->html = $this->html();

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }
            $firstColon = strpos($line, ':');
            $key = trim(substr($line, 0, $firstColon));
            $value = substr($line, $firstColon + 1, strlen($line) - $firstColon);
            if ($key === 'slug') {
                $value = str_slug($value);
            }
            $meta->$key = trim($value);
        }

        return $meta;
    }

    public function html()
    {
        $markdown = preg_replace('/\/\*(.+?)\*\//ms', '', $this->content);
        $html = MarkdownExtra::defaultTransform($markdown);
        $html = str_replace('<table>', '<table class="table table-bordered">', $html);

        return $html;
    }
}