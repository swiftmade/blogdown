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

	composer require swiftmade/blogdown

Then register the service provider in your config/app.php

	Swiftmade\Blogdown\Providers\BlogdownProvider::class,
	
If you want to change the default blog folder (*defaults to resources/views/blog*), use `php artisan vendor:publish` to publish the config file.

### Use

The package parses your markdown in two steps:

1. It parses the meta tags at the beginning
2. It renders the markdown into html

Here is a sample blog article:


	/*
	slug: this-is-your-slug
	title: Title of My Article
	keywords: any keywords, you want to add, here
	description: you can add any tag you want
	date: 19.02.2017
	*/
	
	# Title of My Article
	
	** Bold Text **
	
	Hey, this is my first blogdown article. Here is a list:
	
	* It's awesome
	* It just works!
	

The only meta tag required by Blogdown is *slug*. The package uses this tag as a unique identifier across all your markdown files. While retrieving your blog article, you pass in this slug like this:


	use Swiftmade\Blogdown\Facades\Blogdown;
	..
	..
	Blogdown::find('this-is-your-slug');

And in return you get this object:

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

In your view file just display your rendered HTML unesacped:

	{!! $blog->html !}}
	
### Contributions Are Welcome

If you want to see more features or report bugs feel free to open issues and send pull requests.