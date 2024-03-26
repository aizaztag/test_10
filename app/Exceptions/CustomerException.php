<?php


namespace App\Exceptions;


use Exception;

class CustomerException extends Exception
{

    public static function internal()
    {
        return new static('internal' , 500);
      }
}
