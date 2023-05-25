<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRoutes extends Model
{
    use HasFactory;
    protected $fillable = [
        'driver_id',
        'placement_id',
        'delivery_date',
        'address',
        'lat',
        'lng',
        'consolidate_order_no'
    ];
}
