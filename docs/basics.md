---
layout: default
title: Basics
nav_order: 2
---

# Configuration
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
slug: hello-world
title: Hello World!
date: 05.03.2019
*/

# Hello World
This is my first blog post using Blogdown!
```

The first portion of the file is the meta section. There are **3 compulsory meta fields: slug, title and date**. After this, you are free to add as many meta fields as you like. We will show how to access these fields in a second.

### View your first blog post!
Your first post should now be available at `/blog/hello-world` relative to your app's base URL.
