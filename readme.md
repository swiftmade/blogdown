Laravel Blogdown
=====================

Build a blog in your Laravel 5.* site using only Markdown files.

### v2 Checklist

- [ ] Out of the box Controller and route registration
- [ ] Fix Build command
- [ ] Write tests for Presenter
- [ ] Document AddAttribute facade
- [ ] Code syntax higlighting support (via highlight.js)

### Awesome Features

* 📝 Just markdown files, no migrations, no admin panels.
* 🔗 Easily build permalinks by adding slugs to your posts.
* 🧭 Store your SEO data in the meta section of the same file.
* 💉 Extend the markdown parser as you like via custom modifiers.

### Add to Your Project

Require this package through composer:

```
composer require swiftmade/blogdown
```

If you're using Laravel < 5.5, then you'll need to register the service provider in your config/app.php

```php
Swiftmade\Blogdown\Providers\BlogdownProvider::class
```
	
If you want to change the default blog folder (*defaults to resources/views/blog*), use `php artisan vendor:publish` to publish the config file.

## Documentation

### 1. Creating Blog Posts, Formatting

It's as simple as creating a new file under `resources/views/blog` File extension must be .md 

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

* Each blog post must start with a meta section declared in between `/*` and `*/`
* Most fields are up to you but some fields are special:
	* **Slug:** Slug must be a unique URL-friendly string to access your article.
	* **Date:** The date property is a special one in that it is transformed into a Carbon object. `d.m.Y` format is followed. If you wish to change it, you can publish the config file of the package and modify it.


### 2. Displaying Blog Posts

After updating your blog posts (or after pulling updates into production), run this command once:

```
php artisan blog:build
```

Why? Because this command will scan all of the articles and read their meta data. It will be stored in the cache and then you'll be able to conveniently do stuff like:

```php
<?php

use Swiftmade\Blogdown\Facades\Blogdown;
	
// Retrieves 15 of the most recent articles
$posts = Blogdown::recent(15);
	
// Pass the slug (unique identifier) of any article to directly retrieve it.
$post = Blogdown::find($slug);
	
// Pass a slug to retrieve random articles except for the slug you passed in.
// Useful to build a feature like "other articles you might want to read"
$posts = Blogdown::other($slug, 5);
```	

### 3. The Post Object

When you retrieve an article, what's returned is the following object:


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

### 4. Extending the Markdown Parser

Sometimes you might like to modify the output of the HTML using your own custom tags. For example you might like to replace any instance of the string [AD] with the HTML for an advert unit. You can do this by adding a customer modifier.

```php
namespace App\BlogModifiers;

use Swiftmade\Blogdown\Contracts\ModifierInterface;

class AdvertModifier implements ModifierInterface
{

    public function apply($html)
    {
        $advertCode = '<p>Buy stuff from Company X</p>';
        return str_replace('[AD]', $advertCode, $html);
    }

}
```

Make sure you have published the config for blogdown (`php artisan vendor:publish`). Add your modifier to the list of modifiers.

```php
'modifiers' => [
	\Swiftmade\Blogdown\Modifiers\TableModifier::class,
	\App\BlogModifiers\AdvertModifier::class,
],
```
	
## Pull Requests Are Welcome

If you want to see more features or report bugs feel free to open issues and send pull requests.

**Contributors:**

* [@aozisik](https://github.com/aozisik)
* [@BenSampo](https://github.com/BenSampo)
