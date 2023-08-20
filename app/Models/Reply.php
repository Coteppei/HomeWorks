<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table = 'reply';
    protected $fillable =
    [
        'foreign_id',
        'content',
        'image_path',
    ];
}
