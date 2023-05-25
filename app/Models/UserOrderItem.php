<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrderItem extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id'      ,
        'consolidate_order_no',
        'order_no'     ,
        'product_id'   ,
        'product_name' ,
        'barcode',
        'product_image',
        'quantity'     ,
        'points',
        'product_price',
        'total_price'  ,
        'coupon_code'  ,
        'discount_amount',
        'coupon_amount',
        'coupon_type'  ,
        'after_discount',
        'offer_discount_price',
        'offer_discount_percentage',
        'offer_discount_type',
        'offer_discount_face_value',
        'offer_name',
        'final_price_with_coupon_offer'
    ];
}