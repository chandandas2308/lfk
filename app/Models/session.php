<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class session extends Model
{
    use HasFactory;
    protected $fillable = [
        'sub_total',
        'id',
        'shipping_charge',
        'final_price',
        'total_offer_discount',
        'user_id',
        'delivery_date',
        'remark'
    ];
}
