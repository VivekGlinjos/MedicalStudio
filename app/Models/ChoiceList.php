<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChoiceList extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class)->orderBy('preference_order');
    }
}
