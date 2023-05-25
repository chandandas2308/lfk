<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'day1',
        'day2',
        'day3',
        'day4',
        'day5',
        'day6',
        'day7',
        'status'
    ];
}