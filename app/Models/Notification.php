<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'consolidate_order_no',
        'order_no',
        'user_id',
        'remark',
        'address_id',
        'postcode',
        'delivery_date',
        'end_date',
        'payment_mode',
        'status',
        'delivered_date_time',
        'delivered_payment_method'
    ];
}
