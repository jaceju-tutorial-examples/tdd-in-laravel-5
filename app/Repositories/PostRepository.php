<?php

namespace App\Repositories;

use App\Post;

class PostRepository
{
    public function latest10()
    {
        return Post::query()->orderBy('id', 'desc')->limit(10)->get();
    }

    public function create(array $attributes)
    {
        return Post::create($attributes);
    }
}
