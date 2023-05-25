<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pos_Orders extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','order_no','product_id','quantity','unit_price','discount','total','customer_name','customer_id','status'];
}
