<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gained_points',
        'spend_points',
        'remains_points',
        'transaction_id',
        'transaction_amount',
        'wallet_id',
        'transaction_date',
        'log'
    ];

}
