<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'video_name',
        'thumbnail',
        'video_link',
        'is_active',
    ];
}
