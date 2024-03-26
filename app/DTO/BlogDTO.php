<?php


namespace App\DTO;


use App\Enums\BlogSource;
use App\Http\Requests\App\BlogRequest;
use App\Http\Requests\App\BlogRequest as ApiBlogRequest;

class BlogDTO
{

    public $title;
    public $body;
    public $source;

    public function __construct(
       $title , $body, $source
   )
   {
       $this->title = $title;
       $this->body = $body;
       $this->source = $source;
   }

    public static function fromAppRequest(BlogRequest $request)
    {
       return new self(
            $request->validated('title'),
            $request->validated('body'),
            BlogSource::App
        );
    }

    public static function fromApiRequest(ApiBlogRequest $request)
    {
       return new self(
            $request->validated('payload.body.title'),
            $request->validated('payload.body.body'),
            BlogSource::App
        );
    }
}
