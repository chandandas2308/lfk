<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'date_time',
        'limit',

    ];
}
