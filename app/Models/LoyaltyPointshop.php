<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPointshop extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'last_transaction_id', 'loyalty_points'];
}
