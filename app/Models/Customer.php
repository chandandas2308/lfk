<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'specialPrice',
        'customer_type',
        'customer_name',
        'address',
        'fb_id',
        'month',
        'day',
        'year',
        'gender',
        'unit_number',
        'image',
        'phone_number',
        'mobile_number',
        'email_id',
        'dob',
        'status',
        'postal_code',
        'unit',
        'is_pos'
    ];

}
