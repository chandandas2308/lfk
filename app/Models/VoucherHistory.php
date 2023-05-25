<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'voucher_id',
        'discount_amount',
        'voucher_amount',
        'voucher_type',
        'consolidate_order_no',
        'order_no'
    ];
}
