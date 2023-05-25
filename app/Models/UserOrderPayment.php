<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrderPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'consolidate_order_no',
        'user_id',
        'payment_id',
        'payment_request_id',
        'phone',
        'buyer_name',
        'buyer_phone',
        'buyer_email',
        'points',
        'amount',
        'currency',
        'status',
        'fees',
        'payment_type',
        'reference_number',
        'hmac',
        'time',
        'all_data'
    ];
}