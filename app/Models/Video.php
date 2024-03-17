<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function comment()
    {
        return $this->morphOne(Comment::class, 'commentable');
    }
}
