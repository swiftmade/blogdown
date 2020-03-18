<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $post->title }} - My Blog</title>
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/styles/tomorrow.min.css">
</head>
<body>

    <div class="container mt-5">
        <h1>{{ $post->title }}</h1>
        <br>
        <div >
        @include($post->view())
        </div>
        <br>
        <hr class="mt-5">
        <h5>Other posts you might enjoy...</h5>
        @unless($others->count())
            No other posts...
        @else
            <!-- start looping in all posts -->
            @foreach($others as $post)
                <div class="py-2">
                    <div class="text-dark text-muted mb-0">{{ $post->date->format('d M, Y')}}</div>
                    <a href="/blog/{{ $post->slug }}">{{ $post->title }}</a>
                </div>
            @endforeach
            <!-- end looping in all posts -->
        @endif
        <br>
    </div>
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
</body>
</html>