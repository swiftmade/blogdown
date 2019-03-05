<?php

return [

    /**
     * Set to false to disable /blog and /blog/{slug} routes
     * automatically registered by Blogdown.
     */
    'register_routes' => true,

    /**
     * Path to look for blog posts relative to base_path
     */
    'blog_folder' => 'resources/views/blog',

    /**
     * When parsing the date meta tag, Blogdown will use this format
     */
    'date_format' => 'd.m.Y',

    /**
     * Modifier pipeline to transform .md files into HTML.
     * You can completely customize the pipeline by appending
     * modifiers that implement \Swiftmade\Blogdown\Contracts\ModifierInterface
     */
    'modifiers' => [
        \Swiftmade\Blogdown\Modifiers\MarkdownToHtml::class,
        \Swiftmade\Blogdown\Modifiers\TagModifier\AddAttribute::class,
        // Add your own modifiers..
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
