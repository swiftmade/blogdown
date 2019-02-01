<?php

namespace Swiftmade\Blogdown;

use Carbon\Carbon;
use Michelf\MarkdownExtra;
use Swiftmade\Blogdown\Contracts\ModifierInterface;

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

        if(property_exists($meta, 'date')) {
            $meta->date = Carbon::createFromFormat(config('blogdown.date_format'), $meta->date);
        }

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
        // Remove the meta from the content, before parsing it as Markdown
        $markdown = preg_replace('/\/\*(.+?)\*\//ms', '', $this->content, 1);

        $html = MarkdownExtra::defaultTransform($markdown);
        $html = $this->applyModifiers($html);

        return $html;
    }

    public function applyModifiers($html)
    {
        $modifiers = config('blogdown.modifiers');

        foreach ($modifiers as $modifier) {

            $modifier = resolve($modifier);

            if (! $modifier instanceof ModifierInterface) {
                throw new \Exception("Modifiers must implement the ModifierInterface.");
            }

            $html = $modifier->apply($html);
        }

        return $html;
    }
}