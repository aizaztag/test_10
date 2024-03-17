<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    //
    public function orders()
    {
        return $this->hasOneThrough(
            Order::class,
            Product::class,
            'supplier_id', // Foreign key on products table...
            'product_id', // Foreign key on orders table...
            'id', // Local key on suppliers table...
            'id' // Local key on products table...
        );
    }
}
