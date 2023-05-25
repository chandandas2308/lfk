<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverCommissionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
       'user_table_id',
       'driver_table_id',
        'consolidate_order_no',
        'delivery_date',
        'commission',
    ];
}
