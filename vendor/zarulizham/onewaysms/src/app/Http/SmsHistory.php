<?php

namespace OneWaySMS;

use Illuminate\Database\Eloquent\Model;

class SmsHistory extends Model
{
    protected $fillable = [
        'mobile_number',
        'message',
        'mtid',
        'response_code',
    ];
}
