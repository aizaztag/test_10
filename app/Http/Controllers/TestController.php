<?php

namespace App\Http\Controllers;

use App\Exceptions\TestException;
use App\Helpers\ArrayHelpers;
use App\Jobs\CreateGeneralExportFileJob;
use App\Models\Comment;
use App\Models\Country;
use App\Models\GeneralExport;
use App\Models\Post;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\fileExists;
use function Symfony\Component\String\length;

class TestController extends Controller
{
    public function __construct()
    {
    }

    public function oneToOne()
    {
        $user = User::find(3);

        // Access the user's profile
        $profile = $user->profile;

        dd($profile->bio);

        // Access the profile details
        echo $profile->bio;
        echo $profile->avatar;
    }

    public function oneToMany()
    {
        //lazy
        $post = Post::find(1);
        $comments = $post->comments;
        foreach ($comments as $comment) {
            //  echo $comment->body;
        }
        //eager
        $post = Post::with('comments')->find(1);
        //dd($post->comments);

    }

    public function hasOne()
    {
        $pro = Product::find(1);

        return $pro->order;
    }

    public function oneToManyInverse()
    {
        $comment = Comment::find(1);
        //lazy loading
        $post = $comment->post;
        printf("title %s contetn %s.", $post->title, $post->content);
        //eager lading
        $comment = Comment::with('post')->find(1);
        $title = $comment->post->title;
        //dd($post);
        printf("title %s contetn.", $title);
    }

    public function accessors()
    {
        $user = Post::find(1);

        $title = $user->title;

        dd($title);
    }

    public function muttators()
    {
        //dd(strlen('$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6'));
        $post = new Post();

        $post->title = 'new title';
        $post->content = 'new content';

        $post->save();
    }

    public function has_one_through()
    {
        //exp 1 getting country city through state has relationship with city
        $country = Country::find(1);
        //return $country->city; // object

        //exp 2
        $supplier = Supplier::find(1);
        return $supplier->orders;
    }


    public function many_to_many()
    {
        //return  User::find(3)->roles()->latest()->get();

        $user = User::find(3);

        foreach ($user->roles as $role) {
            //  return $role;
        }
        return view('welcome');
    }

    public function one_one_polymorphic_relations()
    {
        // Create a new comment for a post
        $post = Post::find(2);
        $comment = $post->comment()->create(['content' => 'This is a comment on the post.']);

// Create a new comment for a video
        $video = Video::find(1);
        $comment = $video->comment()->create(['content' => 'This is a comment on the video.']);

// Retrieve the comment and its associated parent model
        $comment = Comment::find(1);
        $commentable = $comment->commentable;
        // This will return either the Post or Video model that the comment belongs to
        return $commentable;
    }

    public function download()
    {
        try {
            $export = GeneralExport::find(1);
            // dd($export);
            dispatch(new CreateGeneralExportFileJob($export, 'download.csv', 1));
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function exception()
    {
        $this->oops();



     /*   try {


            return response()->json(
                [
                    'msg' => 'error'
                ]
            );
        } catch (TestException $e) {
            return response()->json(
                [
                    'msg' => $e->getMessage()
                ],
                $e->getCode()
            );
        }*/
    }

    protected function oops()
    {
        throw TestException::one();
    }

    public function bulkUpload()
    {
        $start_time = microtime(true);

        $path =  storage_path('bulk.csv');
        if( file_exists($path) ){

            $generateRow = function($row){
               return [
                    'region' => $row[0],
                    'country' => $row[1],
                    'item' => $row[2],
                ];
            };
            foreach ( ArrayHelpers::chunkFile($path , $generateRow,2 ) as $chunk){
                DB::table('bulk_uploads')->insert($chunk);
            }

            // End time
            $end_time = microtime(true);

// Calculate execution time
            $execution_time = $end_time - $start_time;

// Display execution time
            dd("Script execution time: " . $execution_time . " seconds");

        }
    }
}
