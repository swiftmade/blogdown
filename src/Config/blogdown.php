<?php

return [

    /**
     * In minutes, how frequently should Blogdown scan blog posts for changes?
     */
    'index_ttl' => 10,

    /**
     * Set to false to disable /blog and /blog/{slug} routes
     * automatically registered by Blogdown.
     */
    'register_routes' => true,

    /**
     * Path to look for blog posts relative to your views folder
     */
    'blog_folder' => 'blog',

    /**
     * When parsing the date meta tag, Blogdown will use this format
     */
    'date_format' => 'd.m.Y',

    /**
     * Laravel 6+ uses CommonMark out of the box.
     * We also utilize the same framework for parsing markdown.
     * This array is passed to the GithubFlavoredMarkdownConverter object.
     *
     * https://github.com/thephpleague/commonmark
     *
     */
    'commonmark_options' => [
        'html_input' => 'strip',
        'allow_unsafe_links' => false,
    ],

    // Register any CommonMark extensions here
    'commonmark_extensions' => [
        \League\CommonMark\Extension\GithubFlavoredMarkdownExtension::class,
    ],

    'authors' => [
        /*
        'taylor' => [
            'name' => 'Taylor Otwell',
            'title' => 'Laravel\'s Creator',
            'thumbnail' => 'url_to_thumbnail.jpg',
        ],
        */
    ],
];
