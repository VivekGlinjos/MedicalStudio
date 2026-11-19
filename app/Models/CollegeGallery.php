<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollegeGallery extends Model
{
    protected $fillable = [
        'college_id',
        'image_path',
        'caption',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class, 'college_id', 'college_id');
    }
}
