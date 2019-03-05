<?php

return [

    'blog_folder' => 'resources/views/blog',

    'date_format' => 'd.m.Y',

    'modifiers' => [
        \Swiftmade\Blogdown\Modifiers\MarkdownToHtml::class,
        \Swiftmade\Blogdown\Modifiers\TagModifier\AddAttribute::class,
        // Add your own modifiers..
    ],

];
