---
layout: default
title: Customize
nav_order: 2
---

# Configuration
{: .no_toc }

Customize Blogdown
{: .fs-6 .fw-300 }

## Table of contents
{: .no_toc .text-delta }

1. TOC
{:toc}

---

## Customize the Theme

Probably the first customization you will make is to change the blog's look and feel. This is made easy as you can simply edit the view files published at `resources/views/vendor/blogdown` There is no limit here, as you are using blade... Think of these files as templates or sample implementations that give you an idea. You can extend layouts, add scripts or more...

## Code Highlighting Support

Blogdown comes ready for highlight.js integration. You just need to include highlight.js CSS and Javascript code to your page. The fastest way is to use CDN.

```html
<!-- to head -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/styles/railscasts.min.css">

<!-- at the end of body -->
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
```

## Blog Folder

To change where the posts are searched, simply edit the `blog_folder` key in your `config/blogdown.php` file.

## Date Format

The parser will look for `date` meta key and try to cast it to Carbon using the configured the format. To change this, simply edit the `date_format` key in your `config/blogdown.php` file.

## Modifiers

You can completely customize the way Blogdown renders a markdown file. Rendering happens through a pipeline, where each iteration calls the next modifier, which must implement `Swiftmade\Blogdown\Contracts\ModifierInterface`.

The default modifiers are:

```php
<?php
[
    \Swiftmade\Blogdown\Modifiers\MarkdownToHtml::class,
    \Swiftmade\Blogdown\Modifiers\TagModifier\AddAttribute::class,
];
```

MarkdownToHtml is where the main magic happens. This modifier invokes the `michelf/php-markdown` package to generate html from markdown input. 

### Using AddAttribute

AddAttribute is a useful modifier in that it lets you sprinkle attributes to the resultant tags. By default, the value is passed to the `class` attribute of the target tags.

To leverage this modifier, we included a facade found at `Swiftmade\Blogdown\Facades\AddAttribute` You can invoke this facade in your `AppServiceProvider` to add arbitrary attributes such as `class` (default), `target` or `rel` to your html.

```php
<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Swiftmade\Blogdown\Facades\AddAttribute;
use Swiftmade\Blogdown\Modifiers\TagModifier\AttributeRule;

class AppServiceProvider extends ServiceProvider
{
    /* rest of your service provider */
    
    public function boot()
    {
        $this->registerMarkdownModifiers();
    }

    private function registerMarkdownModifiers()
    {
        AddAttribute::rules(
            AttributeRule::P('antialiased leading-loose mt-3 mb-6'), // second parameter is attribute, which is "class" by default
            AttributeRule::A('no-follow', 'rel'),
            AttributeRule::HTags('mb-4'),
            // Or use Tags to pass a tag name manually
            AttributeRule::Tags('pre', 'html', 'language')
        );
    }
}
```

