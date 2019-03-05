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

### See your post at /blog/hello-world
{: .no_toc }

Your first post should now be available at `/blog/hello-world` relative to your app's base URL. This permalink is determined by the file name of your post. To change the /blog/ prefix, see the section on [customization.](customize.html)

## Meta Data

Each post must start with a meta section, starting with `/*` and ending with `*/`. You are free to add as many meta fields as you like. However some meta keys are special and they are treated differently.

### Date

The **date** key is special in that it's transformed into a Carbon object by the parser. To change the date format, see the section on [customization.](customize.html)

### Author

The **author** key is an optional key that can be used to assign an author to the post. You can use the package config to add as many authors as you like. Author data is arbitrary and completely up to you. The key in the authors array inside config file must match with the value you pass to the author meta key.