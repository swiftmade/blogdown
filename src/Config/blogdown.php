<?php

return [

    'blog_folder' => 'resources/views/blog',

    'date_format' => 'd.m.Y',

    'modifiers' => [
        \Swiftmade\Blogdown\Modifiers\MarkdownTransformer::class,
        \Swiftmade\Blogdown\Modifiers\TagModifier\AddAttribute::class,
        // Add your own modifiers..
    ],

];
