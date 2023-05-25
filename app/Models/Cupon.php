<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'owner_id',
        'coupon',
        'coupon_type',
        'face_value',
        'no_of_coupon',
        'limit',
        'start_date',
        'end_date',
        'coupon_desc',
        'merchendise_btn',
        'merchendise'
    ];
}