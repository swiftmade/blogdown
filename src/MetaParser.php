<?php

namespace Swiftmade\Blogdown;

use Exception;

class MetaParser
{
    private $handle;
    private $meta = [];

    const MetaOpen = '/\{\{\-\-\r?\n/';
    const MetaClose = '/\-\-\}\}/';

    public static function parse($path)
    {
        return (new self)($path);
    }

    public function __invoke($path)
    {
        $this->open($path);

        $this->meta = [
            'view_name' => str_replace(
                PostScanner::Extensions,
                '',
                pathinfo($path, PATHINFO_BASENAME)
            ),
        ];

        $line = fgets($this->handle, 1024);
        $length = strlen($line);

        if (! (preg_match(self::MetaOpen, $line))) {
            throw new Exception('Missing meta section in ' . $path);
        }

        // Until the meta section is closed, keep reading
        while ($line = fgets($this->handle, 1024)) {
            $length += strlen($line);

            if (preg_match(self::MetaClose, $line)) {
                break;
            }

            $this->parseLine($line);
        }

        $this->meta['metaLength'] = $length;
        $this->meta['last_modified'] = filemtime($path);

        $post = resolve('blogdown.postModel')($this->meta);
        $this->meta['slug'] = $post->slug();
        $this->meta['is_draft'] = $post->isDraft();

        $this->close();

        return $this->meta;
    }

    protected function open($path)
    {
        if (! is_readable($path)) {
            throw new Exception('Post at "' . $path . '" cannot be read.');
        }

        $this->handle = fopen($path, 'r');
    }

    protected function close()
    {
        fclose($this->handle);
    }

    protected function parseLine($line)
    {
        list($key, $value) = $this->breakMetaLine($line);
        $this->meta[$key] = $value;
    }

    private function breakMetaLine($line)
    {
        $firstColon = strpos($line, ':');

        return array_map('trim', [
            substr($line, 0, $firstColon),
            substr($line, $firstColon + 1, strlen($line) - $firstColon),
        ]);
    }
}
