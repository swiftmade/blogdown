<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blogdown - My Blog</title>
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-5">
        <h1>Blog</h1>
        <br>
        
        @unless($posts->count())
            No blog posts...
        @else

            <!-- start looping in all posts -->
            @foreach($posts as $meta)
                <div class="py-2">
                    <div class="text-dark text-muted mb-0">{{ $meta->date->format('d M, Y')}}</div>
                
                    <a href="/blog/{{ $meta->slug }}">   
                        <h2 class="mb-3 antialiased text-blue-dark hover:text-blue">{{ $meta->title }}</h2>
                    </a>
                </div>
                <hr>
            @endforeach
            <!-- end looping in all posts -->

            <br>
            {!! $posts->links() !!}
        @endif
    </div>
    
</body>
</html>