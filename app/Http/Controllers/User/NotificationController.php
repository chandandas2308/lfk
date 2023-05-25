<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class NotificationController extends Controller
{
    //
    public function fetchAllNotification()
    {
        $data = Notification::where('user_id', Auth::user()->id)->get();
        
        
        $new_data = array();
        $i = 0;
        foreach ($data as $item) {
            $new_data[] = array(
                ++$i,
                $item->order_no,
                Carbon::parse($item->created_at)->format('d-m-y'),
                Carbon::parse($item->end_date)->format('d-m-y'),
                // Carbon::parse($item->delivery_date)->format('d-m-y'),
                $item->delivery_date,

                // '<a href="javascript:void(0)" onclick="removeFromWishlist(' . $item->user_id . ', ' . $item->id . ')"><button type="button" class="btn btn-default"><i class="tf-ion-close" aria-hidden="true"></i></button></a>'

            );
        }

        $output = array(
            "draw"                 => request()->draw,
            "recordsTotal"         => $data->count(),
            "recordsFiltered"     => $data->count(),
            "data"                 => $new_data
        );

        echo json_encode($output);
    }
    // user notification
    public function userAlert()
    {
        
        $id = Auth::user()->id;
        // $alert = Notification::all()->where('user_id',$id);
        
        // return response()->json($alert);

        $current_date = Carbon::createFromFormat('Y-m-d H:i:s', carbon::now());

        $alert = Notification::where('user_id',$id)->where('delivery_date', null)->where('end_date', '<', $current_date)->get();
        return response()->json($alert);

    }
}
