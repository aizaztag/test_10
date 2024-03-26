<?php


namespace App\Services;


use App\DTO\BlogDTO;
use App\Enums\BlogSource;
use App\Models\Blog;

class BlogService
{

    public function store( BlogDTO $blogDTO )
    {
        return Blog::create([
                       'title' => $blogDTO->title,
                       'body' => $blogDTO->body,
                       'source' => $blogDTO->source
                   ]);
    }
}
