<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\LiveDateConfig;
use Illuminate\Http\Request;

class LiveDateConfigController extends Controller
{
    //

    public function store(Request $request)
    {
        // LiveDateConfig::create([
        //     "date" => $request->date,
        //     "message" => $request->message
        // ]);

        $item = LiveDateConfig::updateOrCreate(
            ['date' => $request->prevDate,'message' => $request->prevMessage],
            ['date' => $request->date,'message' => $request->message]
        );

        return response()->json(['success' => 'Live Date & Time Configured']);
    }

        // fetch consolidate date   
        public function fetch()
        {
            return response()->json(LiveDateConfig::all());
        }
}
