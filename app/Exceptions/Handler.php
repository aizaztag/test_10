<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register()
    {
//        $this->reportable(function (Throwable $e) {
//            //
//        });

        $this->reportable(function (CustomerException $e) {
            return response()->json(
                [
                     'msg' => $e->getMessage()
                ],$e->getCode());
        });
    }
}
