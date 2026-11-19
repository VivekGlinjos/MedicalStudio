<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'service_package_id',
        'amount',
        'status',
        'transaction_id',
        'razorpay_order_id',
        'payment_method',
        'response_payload',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(ServicePackage::class, 'service_package_id');
    }
}
