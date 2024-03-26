<?php

namespace App\Http\Controllers\Api;

use App\Enums\BlogSource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BlogRequest;
use App\Http\Resources\Api\BlogResource;
use App\Models\Blog;
use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogApiController extends Controller
{
    /**
     * @var BlogService
     */
    private $blogService;

    public function __construct(
        BlogService $blogService
    )
    {
        $this->blogService = $blogService;
    }


    public function store(BlogRequest $request)
    {

        $blog =   $this->blogService->store(
            $request->validated('payload.blog.title'),
            $request->validated('payload.blog.body'),
            BlogSource::App
        );

        return BlogResource::make( $blog );

    }
}
