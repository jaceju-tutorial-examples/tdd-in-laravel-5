<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Article</title>
</head>
<body>

{!! Form::open(['route' => 'repository.index']) !!}
<p>
    Title: {!! Form::text('title') !!}
</p>
<p>
    Body: {!! Form::textarea('body') !!}
</p>
<p>
    {!! Form::submit('Create Article') !!}
</p>
{!! Form::close() !!}

@if ($errors->any())
<ul>
    @foreach ($errors->all() as $error)
    <li>{{ print_r($error) }}</li>
    @endforeach
</ul>
@endif

</body>
</html>
