---
layout: default
title: Basics
nav_order: 2
---

# Basics
{: .no_toc }

Basics of Blogdown
{: .fs-6 .fw-300 }

## Table of contents
{: .no_toc .text-delta }

1. TOC
{:toc}

---

## Your First Post

By default, Blogdown will find your posts at `resource/views/blog`. Blog posts must have a `.md` extension. Now, let's create a hello world post to get going!

To make a new post, simply create a new markdown file at `resource/views/blog/hello-world.md`. Open it and add the following content:

```markdown
/*
title: Hello World!
date: 05.03.2019
*/

# Hello World
This is my first blog post using Blogdown!
```

### Build your posts

After adding/removing a post or modifying meta of existing posts, you must run the command below. 
Build command is not necessary when you only modify the contents of a post.

```bash
php artisan blog:build
```

### See your post at /blog/hello-world

Your first post should now be available at `/blog/hello-world` relative to your app's base URL. This permalink is determined by the file name of your post. To change the /blog/ prefix, see the section on [customization.](customize.html)

## Presenter

`Swiftmade\Blogdown\Presenter` is a class that you can use to access your articles. It's  if you are implementing your custom controller.

The class exposes 4 public methods:

* **static filter($callable)** Pass a filter callback. It will receive `Meta` instances. Returning false will filter that post.
* **find($slug)** Given a post slug, returns the Post or null if not found.
* **findOrFail($slug)** Given a post slug, returns the Post or throws 404 if not found.
* **latest($paginate = 10)** Returns a paginated collection of post meta, ordered latest date first.
* **others($slug, $take = 5)** Returns `$take` many post meta, excluding the article at `$slug`.

### Fetching and Displaying Posts

Blogdown implements the Presenter class in it's default Controller like so:

```php
class PostsController
{
    public function index()
    {
        $posts = $this->presenter->latest(15);

        return view('vendor.blogdown.posts')->with(
            compact('posts')
        );
    }

    public function show($slug)
    {
        $post = $this->presenter->findOrFail($slug);
        $others = $this->presenter->others($slug, 5);

        return view('vendor.blogdown.post')->with(
            compact('post', 'others')
        );
    }
}
```

### Implementing Search

A very simplistic search can be implemented using the presenter's filter method.

```php
$this->presenter->filter(function(Meta $postMeta) {
        return strpos($postMeta->title, 'search keyword') !== false;
    })
    ->latest(15);
}
```

In this example, any method calls to presenter after the filter call, will only display posts that has `search keyword` in their title.

## Post

Post is the object returned by Presenter's find method. It contains the following properties:

* **$html** (string) Rendered html for the post.
* **$meta** (Meta) Meta data for the post.

## Meta

Each post must start with a meta section, starting with `/*` and ending with `*/`. You are free to add as many meta fields as you like. In the end, all keys are turned into public properties in the Meta object.

However some meta keys are special and they are treated differently.

### Meta Key: draft

This is an optional key. It lets you hide posts from production. If a post is work in progress, add `draft: true` to its meta. The build command will ignore such posts only when the APP_ENV is set to `production`. Otherwise, the post will be treated the same.

### Meta Key: date

The **date** key is special in that it's transformed into a Carbon object by the parser. To change the date format, see the section on [customization.](customize.html)

### Meta Key: authorId

The **authorId** key is an optional key that can be used to assign an author to the post. You can use the package config to add as many authors as you like. Author data is arbitrary and completely up to you. The key in the authors array inside config file must match with the value you pass to the author meta key.

To add an author, go to `config/blogdown.php`

```php
<?php

return [
    // ... other configuration ...
    'authors' => [
        
        'ahmet' => [
            'name' => 'Ahmet Özışık',
            'title' => 'Founder, Software Consultant',
            'thumbnail' => '/images/blog/ahmet.jpg',
        ],

    ],
];
```

After adding a new author entry, you can now use the array key of the entry as author's id. In this case, add `authorId: ahmet` to your meta as a new line.

While accessing the author's data, you can call `author()` on the meta object in question.


