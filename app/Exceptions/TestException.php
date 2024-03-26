<?php


namespace App\Exceptions;


class TestException extends CustomerException
{
    public static function one()
    {
        return new self( 'one' ,403);
          }

    public static function two()
    {
        return new self( 'two' , 505);
     }
}
