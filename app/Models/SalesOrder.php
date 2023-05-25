<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'customer_name' , 'mobile_number' , 'address' , 'product_name' ,'product_variant', 'unit_price' ,'quantity','amount'
    ];
}
