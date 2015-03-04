<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
</head>
<body>

{!! Form::open(['route' => 'posts.index']) !!}
<p>
    Title: {!! Form::text('title') !!}
</p>
<p>
    Body: {!! Form::textarea('body') !!}
</p>
<p>
    {!! Form::submit('Create Post') !!}
</p>
{!! Form::close() !!}
</body>
</html>
