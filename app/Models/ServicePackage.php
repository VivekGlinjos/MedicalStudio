<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'actual_amount',
        'payment_button_link',
        'description',
        'tier',
        'is_active',
        'image',
    ];
}
