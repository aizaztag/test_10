<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralExport extends Model
{
    use HasFactory;

    protected $fillable  = ['status' , 'status_message' , 'file'];
}
