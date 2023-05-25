<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackStockDeductDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'consolidate_order_no',
        'order_no',
        'warehouse_id',
        'warehouse_name',
        'user_id',
        'product_id',
        'deduct_quantity',
    ];
}
