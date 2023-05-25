<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    use HasFactory;
    protected $fillable = [
        'deliveries_id',
        'order_no',
        'driver_id',
        'remark',
        'image',
    ];
    
}
