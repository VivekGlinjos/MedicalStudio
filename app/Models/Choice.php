<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $guarded = [];

    public function choiceList()
    {
        return $this->belongsTo(ChoiceList::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'college_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
