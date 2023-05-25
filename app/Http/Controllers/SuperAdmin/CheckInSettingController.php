<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\CheckInSetting;
use App\Models\DailyCheckInCoins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckInSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = DB::table('daily_check_in_coins')->join('users', 'users.id','=','daily_check_in_coins.user_id')->orderBy('id', 'desc')->get(['daily_check_in_coins.*','users.email','users.name']);

        $i = 0;
        $new_data = [];

        foreach($data as $item){
            $new_data[] = array(
                ++$i,
                $item->name,
                $item->email,
                $item->day,
                $item->points,
            );
        }

        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> sizeOf($data),
            "recordsFiltered" 	=> sizeOf($data),
            "data" 				=> $new_data
        );
        echo json_encode($output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(request()->status == 1){
            return view('superadmin.LoyaltyPoint.sign_in.add',["data"=>CheckInSetting::orderBy('id','desc')->first()]);
        }else{

        }
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
        $request->validate(
            [
                'day1' => 'required',
                'day2' => 'required',
                'day3' => 'required',
                'day4' => 'required',
                'day5' => 'required',
                'day6' => 'required',
                'day7' => 'required',
            ]
        );

        CheckInSetting::updateOrCreate(
            ['status' => true],
            [
            'day1' => $request->day1,
            'day2' => $request->day2,
            'day3' => $request->day3,
            'day4' => $request->day4,
            'day5' => $request->day5,
            'day6' => $request->day6,
            'day7' => $request->day7,
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Updated Successfully"
        ]);

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
