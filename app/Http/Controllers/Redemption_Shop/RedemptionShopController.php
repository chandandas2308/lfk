<?php

namespace App\Http\Controllers\Redemption_Shop;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\VoucherCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedemptionShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $data = Voucher::orderBy('id', 'desc')->get();

            $i = 0;
            $action = '';
            $new_data = [];
    
            foreach($data as $item){
                $action .= '<div class="dropdown">';
                $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
                $action .= '</a>';
                $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                $action .= '<a class="dropdown-item" href="javascript:void(0)" onclick="viewVoucher('.$item->id.')">View</a>';
                $action .= '<a class="dropdown-item" href="javascript:void(0)" onclick="updateVoucher('.$item->id.')">Edit</a>';
                $action .= '<a class="dropdown-item" href="javascript:void(0)" onclick="removeVoucher('.$item->id.')">Delete</a>';
                $action .= '</div>';
                $action .= '</div>';
    
                $new_data[] = array(
                    ++$i,
                    $item->points,
                    ($item->discount_type != 'discount_by_value_btn' ? $item->discount.'%' : '$'.$item->discount),
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
            return view('superadmin.redemption-shop.voucher.add');
        }else if(request()->status == 2){
            $voucher = DB::table('voucher_codes')->join('users', 'users.id','=','voucher_codes.user_id')->where('voucher_codes.voucher_id', request()->id)->get(['voucher_codes.*','users.name']);
            return view('superadmin.redemption-shop.voucher.view',["data"=>Voucher::find(request()->id), "voucher"=>$voucher]);
        }else if(request()->status == 4){
            Voucher::find(request()->id)->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Voucher deleted successfully'
            ]);
        }else{
            return view('superadmin.redemption-shop.voucher.update',["data"=>Voucher::find(request()->id)]);
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

        // discount_type

        $request->validate(
            [
                'discount_type' => 'required',
                'discount_percentage' => $request->discount_type != "discount_by_precentage_btn"?'':'required',
                'discount_amount' => $request->discount_type != "discount_by_value_btn"?'':'required',
            ],
        );

        //
        $url = env("APP_URL", "http://lfk.sg/");
        
        if (!file_exists('voucher')) {
            mkdir('voucher', 666, true);
        }

        $image_resize = \Image::make($request->image->getRealPath());

        $name = date('d_m_y_h').time();

        $image_resize->save(public_path('voucher/' . $name . "." .  $request->image->extension(), 100));
        $path = 'voucher/' . $name . "." .  $request->image->extension();
        $url = env("APP_URL", "http://lfk.sg/");
        
        Voucher::create([
            'name' => $request->name,
            'expiry_date' => $request->expiry_date,
            'points' => $request->points,
            'discount_type' => $request->discount_type,
            'discount' => $request->discount_type != 'discount_by_precentage_btn'?$request->discount_amount:$request->discount_percentage,
            'image' => $url.$path
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Voucher added successfully'
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
        // dd($request->points);
        $url = env("APP_URL", "http://lfk.sg/");
        
        if (!file_exists('voucher')) {
            mkdir('voucher', 666, true);
        }
        if($request->image != null){

            $image_resize = \Image::make($request->image->getRealPath());

            $name = date('d_m_y_h').time();

            $image_resize->save(public_path('voucher/' . $name . "." .  $request->image->extension(), 100));
            $path = 'voucher/' . $name . "." .  $request->image->extension();
            $url = env("APP_URL", "http://lfk.sg/");

            Voucher::where('id', $id)->update([
                'name' => $request->name,
                'points' => $request->points,
                'expiry_date' => $request->expiry_date,
                'discount' => $request->discount_amount,
                'image' => $url.$path,
            ]);

        }else{

            Voucher::where('id', $id)->update([
                'points' => $request->points,   
                'discount' => $request->discount_amount
            ]);

        }

        return response()->json([
            'status' => 'success',
            'message' => 'Voucher updated successfully'
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
