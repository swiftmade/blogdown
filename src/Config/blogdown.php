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
     * Use this to replace default Post model
     */
    'post_model' => \Swiftmade\Blogdown\Models\Post::class,


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
