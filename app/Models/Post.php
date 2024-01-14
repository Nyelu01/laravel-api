<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //If you want to override/specify the custom name of table to be used
    // public $table = 'table_name';

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'user_id'
    ];
}
