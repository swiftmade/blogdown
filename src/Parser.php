<?php
namespace Swiftmade\Blogdown;

use Exception;
use Michelf\MarkdownExtra;
use Swiftmade\Blogdown\Support\Meta;
use Illuminate\Support\Facades\Config;
use Swiftmade\Blogdown\Contracts\ModifierInterface;

class Parser
{
    private $path;
    private $handle;

    private function __construct($path)
    {
        $this->path = $path;
    }

    public static function meta($path)
    {
        return (new self($path))->getMeta();
    }

    public static function html($path)
    {
        return (new self($path))->getContent();
    }

    private function getMeta()
    {
        $this->open($this->path);

        $meta = new Meta(
            $this->path
        );

        $line = fgets($this->handle, 1024);

        if ($line !== '/*' . PHP_EOL) {
            throw new Exception('All blog posts must start with meta section.');
        }

        // Until the meta section is closed, keep reading
        while (strpos($line, '*/') === false) {
            $line = fgets($this->handle, 1024);
            $meta->parseLine($line);
        }

        $this->close();
        return $meta;
    }

    private function open($path)
    {
        if (!is_readable($path)) {
            throw new Exception('Post at "' . $path . '" cannot be read.');
        }

        $this->handle = fopen($path, 'r');
    }

    private function close()
    {
        fclose($this->handle);
    }

    private function getContent()
    {
        $content = file_get_contents($this->path);
        $content = preg_replace('/\/\*(.+?)\*\//ms', '', $content, 1);

        return $this->applyModifiers(
            MarkdownExtra::defaultTransform($content)
        );
    }

    private function applyModifiers($content)
    {
        $modifiers = Config::get('blogdown.modifiers');

        foreach ($modifiers as $modifier) {
            $modifier = resolve($modifier);

            if (!$modifier instanceof ModifierInterface) {
                throw new \Exception('Modifiers must implement the ModifierInterface.');
            }

            $content = $modifier->apply($content);
        }

        return $content;
    }
}
