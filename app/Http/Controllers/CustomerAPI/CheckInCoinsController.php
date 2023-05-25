<?php

namespace App\Http\Controllers\CustomerAPI;

use App\Http\Controllers\Controller;
use App\Models\CheckInSetting;
use App\Models\DailyCheckInCoins;
use App\Models\LoyaltyPoint;
use App\Models\LoyaltyPointshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckInCoinsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            "user_id" => "required|exists:users,id",
            "day" => "required",
            "points" => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json([
                "status" => false,
                "message" => "Invalid Inputs",
                "error" => $validator->getMessageBag()->toArray()
            ], 422);

        }else{

            DailyCheckInCoins::create([
                "user_id" => $request->user_id,
                "day" => $request->day,
                "points" => $request->points
            ]);

            $walletPoint = LoyaltyPointshop::where('user_id', $request->user_id)->first();

            if($walletPoint != null){
                $havingPoints = $walletPoint->loyalty_points;
            }else{
                $havingPoints = 0;
            }

            LoyaltyPoint::create([
                'user_id' => $request->user_id,
                'gained_points' => $request->points,
                'spend_points' => 0,
                'remains_points' => (int)$request->points+(int)$havingPoints,
                'transaction_id' => 1,
                'transaction_amount' => 0,
                'transaction_date' => now(),
            ]);

            LoyaltyPointshop::updateOrCreate(
                ['user_id' => $request->user_id],
                [
                    'user_id' => $request->user_id,
                    'loyalty_points' => (int)$request->points+(int)$havingPoints,
                    'last_transaction_id' => 1
                ]
            );

            return response()->json([
                "status" => "success",
                "message" => "You have earned ".$request->points." Points"
            ], 200);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
