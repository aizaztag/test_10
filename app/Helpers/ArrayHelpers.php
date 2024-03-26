<?php

namespace App\Helpers;

class ArrayHelpers{

    public static function chunkFile(
         $path,
         $generator,
         $size
    )
    {
         $file  = fopen($path , 'r');
         $data = [];

        // Read and discard the header row
        fgetcsv($file);

        for($ii = 1; ($row = fgetcsv($file, null, ',')) !== false; $ii++){

             $data[]   =  $generator($row);
             if( $ii % $size ==0){
                 yield $data;
                 $data = [];
             }
         }

         if( !empty($data) ){
             yield $data;
         }

         fclose($file);
    }

}
