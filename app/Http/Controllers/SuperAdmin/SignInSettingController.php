<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SignInSetting;
use Illuminate\Http\Request;

class SignInSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = SignInSetting::orderBy('id', 'desc')->get();

        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a class="dropdown-item" href="javascript:void(0)" onclick="viewSignIn('.$item->id.')">View</a>';
            $action .= '<a class="dropdown-item" href="javascript:void(0)" onclick="updateSignIn('.$item->id.')">Edit</a>';
            $action .= '<a class="dropdown-item" href="javascript:void(0)" onclick="removeSignIn('.$item->id.')">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->points,
                $item->status==true?"Yes":"No",
                $action
            );
            $action = '';
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
            return response()->json(SignInSetting::orderBy('id','desc')->first());
        }else{
            return view('superadmin.LoyaltyPoint.sign_in.update',["data"=>SignInSetting::find(request()->id)]);
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
        SignInSetting::updateOrCreate(
            ['points' => $request->prevPoints],
            ['points' => $request->bonusPoints, 'status'=>true]
        );
        return response()->json(['success' => 'Welcome Bonus Point Added']);
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
        if((boolean)$request->status == true){
            SignInSetting::where('status', true)->update(['status'=>(boolean)false]);
        }

        SignInSetting::where('id', $id)->update([
            'points' => $request->points,
            'status' => (boolean)$request->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Details updated successfully'
        ]);
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
