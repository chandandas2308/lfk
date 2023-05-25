<?php

namespace App\Http\Controllers\SMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\OnewaySms;
use Svg\Tag\Rect;

class OneWaySMSController extends Controller
{
    //
    public function sendSMS(Request $request)
    {
        $mobile = "9350625981";
        $message = "Hello Rakesh";
        $debug = true;

        $result = OnewaySms::send($mobile, $message, $debug);

        // $result = SMS::to("0123456789")->message("Hello there!")->send();

        dd($result);
        // return $result;
    }

}
