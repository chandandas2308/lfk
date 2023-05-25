<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    use HasFactory;
    protected $fillable=[
       'user_id',
       'order_no',
       'consolidate_order_no',
        'total_product_price',
        'ship_charge',
        'coupon_code',
        'voucher_code',
        'discount_amount',
        'coupon_amount',
        'coupon_type',
        'final_price',
        'points',
        'name',
        'email',
        'mobile_no',
        'address',
        'city',
        'postcode',
        'country',
        'state',
        'status',
        'end_date',
        'payment_id',
        'payment_reference_id',
        'address_id',
        'unit'
    ];
}