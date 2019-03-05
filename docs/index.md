---
title: Home
description: "Ultra simple Laravel blogging with Markdown"
nav_order: 1
---

# Create Laravel blogs using just markdown!
{: .fs-9 }

Add a blog to your Laravel app in minutes using Blogdown. No database tables, no complicated setups. Use markdown files and profit 💸
{: .fs-6 .fw-300 }

[Get started now](#getting-started){: .btn .btn-primary .fs-5 .mb-4 .mb-md-0 .mr-2 } [View it on GitHub](https://github.com/swiftmade/blogdown){: .btn .fs-5 .mb-4 .mb-md-0 }

[See Blogdown in action!](https://swiftmade.co/blog)

---

## Features

- 📝 No migrations. Everything lives in .md files and cache.
- 🏷 Supports post slugs, author profile, publish date and tags.
- 🧭  SEO-enabled via customizable meta data and permalink support.
- 🛳 Ships with views, controllers and routes. Keep it or customize it.
- 💉 Customizable render engine. Easily add CSS classes to rendered tags.
- 💻 Compatible with [highlight.js](https://highlightjs.org/) out of the box for syntax highlighted code.

## Getting Started

Require this package through composer:

```bash
composer require swiftmade/blogdown
```

If you're using Laravel < 5.5, then you'll need to manually register the service provider in `config/app.php`

```php
Swiftmade\Blogdown\Providers\BlogdownProvider::class
```

### That's all!

You now have a blog. Here are the next steps:

- [Learn the basics.](basics.html)
- [Customize your blog.](customize.html)
