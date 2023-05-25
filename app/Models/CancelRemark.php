<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelRemark extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_table_id',
        'driver_user_table_id',
        'consolidate_order_no',
        'remark',
        'cancel_image',
    ];
}
