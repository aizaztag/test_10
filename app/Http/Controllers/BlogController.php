<?php

namespace App\Http\Controllers;

use App\DTO\BlogDTO;
use App\Enums\BlogSource;
use App\Http\Requests\App\BlogRequest;
use App\Http\Resources\App\BlogResource;
use App\Models\Blog;
use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
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
        $blog = $this->blogService->store(
           BlogDTO::fromAppRequest($request)
        );
        //return redirect()->route('blogs.blog', ['blog' => $blog]);

        return BlogResource::make( $blog );

    }
}
