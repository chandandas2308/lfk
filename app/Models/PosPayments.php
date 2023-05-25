<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosPayments extends Model
{
    use HasFactory;
    protected $fillable = ['order_no', 'payment_type', 'amount'];
}
