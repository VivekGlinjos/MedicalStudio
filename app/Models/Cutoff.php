<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cutoff extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'college_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
