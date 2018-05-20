Laravel Blogdown
===

This package enables you to write content in Markdown and display it in your **Laravel 5.*** application. You can also use this package to build a simple blog.

### Main Features
* No database / migrations needed
* Pre-renders the content for speed
* Automatically detects changes in markdown files
* Works out of the box
* Simple to use

### Install

Require this package through composer:

```
composer require swiftmade/blogdown
```

If you're using Laravel < 5.5, then you'll need to register the service provider in your config/app.php

```php
Swiftmade\Blogdown\Providers\BlogdownProvider::class
```
	
If you want to change the default blog folder (*defaults to resources/views/blog*), use `php artisan vendor:publish` to publish the config file.

### Use

#### a. Format

Here is a sample blog article:

```markdown
/*
slug: this-is-your-slug
title: Title of My Article
keywords: any keywords, you want to add, here
description: you can add any tag you want
date: 19.02.2017
custom: hey! I can access this like $blog->meta->custom
*/

# Title of My Article

** Bold Text **

Hey, this is my first blogdown article. Here is a list:

* It's awesome
* It just works!
```

#### b. Building

You need to put your markdown files (with .md extension) inside the blog folder (see install notes for configuration). Afterwards, you need to run the following artisan command:

```
php artisan blog:build
```

This command is necessary when you add a new article or when you want to flush the entire cache and rebuild it. Blogdown automatically detects a modification to an existing article, so no need to run this when you modify your articles.

#### c. Retrieving Articles

The only meta tag required by Blogdown is *slug*. The package uses this tag as a unique identifier across all your markdown files. While retrieving your blog article, you pass in this slug like this:

```php
use Swiftmade\Blogdown\Facades\Blogdown;


Blogdown::find('this-is-your-slug');
```

And in return you get this object:

```php
stdClass Object
(
	[meta] => stdClass Object
		(
			[path] => /path/to/your/file.md
			[slug] => this-is-your-slug
			[title] => Title of My Article
			[keywords] => any keywords, you want to add, here
			[description] => you can add any tag you want
			[date] => 19.02.2017
		)

	[html] => Your HTML code
)
```

In your view file just display your rendered HTML unescaped:

```php
{!! $blog->html !!}
```
	
### Contributions Are Welcome

If you want to see more features or report bugs feel free to open issues and send pull requests.