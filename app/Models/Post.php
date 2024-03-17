<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content'];

    public function comment()
    {
        return $this->morphOne(Comment::class, 'commentable');
    }

    protected function getTitleAttribute($value)
    {
        return ucfirst($value);
    }

    public function setTitleAttribute($value)
    {
        // Here, you can modify the "title" attribute before it's saved to the database
        $this->attributes['title'] = ucfirst($value); // This will capitalize the first letter before saving
    }

}
