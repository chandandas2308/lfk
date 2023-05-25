<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Vendors;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistered;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 
        return view('superadmin.userManagement');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserDetails()
    {
        
        try{
            $data = DB::table('users')->where('is_admin', "1")->orderBy('id', 'DESC')->get();

            $i = 0;
            $action = '';
            $new_data = [];

            foreach($data as $item){
                $action .= '<div class="dropdown">';
                $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
                $action .= '</a>';
                $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                $action .= '<a name="viewUser" data-toggle="modal" data-target="#viewUser" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
                $action .= '<a name="editUser" data-toggle="modal" data-target="#editUser" onclick="myvalidation()" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
                $action .= '<a name="delUser"  data-toggle="modal" data-target="#removeModal" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
                $action .= '</div>';
                $action .= '</div>';

                $new_data[] = array(
                    ++$i,
                    $item->name,
                    $item->email,
                    $item->mobile_number,
                    $action
                );
                $action = '';
            }
            
            $output = array(
                "draw" 				=> request()->draw,
                "recordsTotal" 		=> $data->count(),
                "recordsFiltered" 	=> $data->count(),
                "data" 				=> $new_data
            );
            echo json_encode($output);

        }catch(Exception $e){
            return response()->json(["success"=>"Database Query Error ..."]);
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
        $validator = Validator::make($request->all(),[
            // "username" => "required",
            // // "phonenumber" => "required|min:7",
            // "mobilenumber" => "required|min:7",
            // "emailid" => "required",
            // "password" => "required",
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }else{

            if(User::all()->where('email', $request->emailid)->count() > 0){

                return response()->json(['barerror'=>'Email is Alrealy Registered.']);

            }else{

                User::insert([
                    "name" => $request->username,
                    "is_admin" => "1",
                    "phone_number"=>$request->phonenumber,
                    "mobile_number"=>$request->mobilenumber,
                    "email"=>$request->emailid,
                    "password"=>Hash::make($request->password),
                    "assigned_modules"=>$request->userRightsAre,
                    "created_at" => now()
                ]);

                Mail::send(new UserRegistered($request->emailid, $request->password));

                return response()->json(['success'=>'User Added Succesfully']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $id = $_GET['id'];
        return response()->json(User::all()->where('id', $id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
        $id = $_GET['id'];
        return response()->json(User::all()->where('id', $id));
    }
    public function userfffFilter()
    {
        return response()->json(DB::table('users')->where('is_admin', "1")->where('name', 'LIKE', '%'.$_GET['user'].'%')->paginate(10));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            "username" => "required",
            "mobilenumber" => "required|min:7",
            "emailid" => "required",
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }else{

            // $modules = [];
            // array_push($modules, $request->inventory, $request->sales, $request->purchase, $request->reports, $request->customerManagement);

            // $count = User::all()
            //                 ->where('name', $request->username)
            //                 ->where('phone_number', $request->phonenumber)
            //                 ->where('mobile_number', $request->mobilenumber)
            //                 ->where('email', $request->emailid)
            //                 ->where('assigned_modules', implode(",",array_filter($modules)))
            //                 ->count();

            // if($count > 0){

            //     return response()->json(['barerror'=>'Data already updated.']);

            // }else{

                User::where('email', $request->emailid)
                ->update([
                    "name" => $request->username,
                    "phone_number"=>$request->phonenumber,
                    "mobile_number"=>$request->mobilenumber,
                    "assigned_modules"=>$request->userRightsAre,
                    "updated_at" => now()
                ]);

                return response()->json(['success'=>'User Updated Succesfully']);
            // }
        }
            

        return ['success'=>'User updated succesfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
        try{
            $id = $_GET['id'];
            User::where('id', $id)->delete();
            return response()->json(['success'=>'User Details Removed Successfully']);
        }catch(Exception $e){
            return response()->json(['success'=>'Database query error..']);
        }

    }

    public function supplier(){
        $supplier = Vendors::all();
        return response()->json($supplier);
    }
}