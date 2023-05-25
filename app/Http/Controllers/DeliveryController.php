<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Delivery;
use App\Models\Quotation;
use Illuminate\Support\Facades\Hash;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistered;
use App\Models\DriverDate;
use App\Models\Notification;
use App\Models\OrderRoutes;
use App\Models\User;
// use SebastianBergmann\CodeCoverage\Driver\Driver;
use Exception;

class DeliveryController extends Controller
{

    // ***************************************************************************************************//
    //                                           Delivery SECTION                                          //
    //****************************************************************************************************//

    // =================================================================================
    // fetch order no & details for delivery management
    // =================================================================================
    public function fetchOrderDetails()
    {
        $data = DB::select('SELECT quotations.*, deliveries.ord_no from quotations left JOIN deliveries on quotations.quotation_id=deliveries.ord_no where deliveries.ord_no is null and quotations.status="Confirmed" and quotations.orderID is not null');
        return response()->json($data);
        // return response()->json(Quotation::all()->where('status', 'Confirmed')->where("orderID", "!=", null));
    }

    // =================================================================================
    // Add delivery
    // =================================================================================    
    public function addDelivery(Request $request)
    {
        $uniqueTime = str_replace(' ', '', hexdec(date('Y-m-d H:i:s')));

        $validator = Validator::make($request->all(), [
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {
            Delivery::insert([
                "owner_id" => Auth::user()->id,
                "customer_name" => $request->customer_name,
                "customer_id" => $request->customer_id,
                "order_no" => $request->order_no,
                "ord_no" => $request->deliver_order,
                "mobile_no" => $request->mobile_no,
                "date" => $request->date,
                "delivery_man_user_id" => $request->deliveryman,
                "delivery_man" => $request->delivery_man_name,
                "delivery_man_id" => $request->delivery_man_user_id,
                "delivery_status" => $request->delivery_status,
                "delivery_address" => $request->delivery_address,
                "description" => $request->description,
                "pickup_address" => $request->pickupname,
                "product_details" => $request->allProductDetails,
                "payment_status" => $request->payment_status,
                "created_at" => now()
            ]);


            return response()->json(['success' => 'Delivery Details Added Succesfully']);
        }
    }

    // =================================================================================
    // Edit delivery
    // =================================================================================    
    public function editDelivery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // "customer_name" => "required",
            // "product_name" => "required",
            // "description" => "required",
            // "order_no" => "required",
            // "deliveryman" => "required",
            // "deliveryman_id" => "required",
            // "pickup_address" => "required",
            // "delivery_address" => "required",
            // "date" => "required",
            // "delivery_status" => "required",
            // "payment_status" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {
            Delivery::where("id", $request->id)
                ->update([
                    "delivery_man_user_id" => $request->delivery_man_user_id,

                    "delivery_man" => $request->delivery_man_name,

                    "delivery_man_id" => $request->deliveryman,

                    "delivery_status" => $request->delivery_status,

                    "description" => $request->description,

                    "pickup_address" => $request->editpickupname,


                    "payment_status" => $request->payment_status,

                    "updated_at" => now()
                ]);

            return response()->json(['success' => 'Delivery Details Updated Succesfully']);
        }
    }

    // =================================================================================
    // Delete delivery
    // =================================================================================        
    public function removeDelivery()
    {
        $id = $_GET["id"];
        Delivery::where("id", $id)->delete();
        return response()->json(["success" => "Delivery Deleted Successfully."]);
    }

    // =================================================================================
    // view delivery
    // =================================================================================
    public function viewDelivery()
    {
        $id = $_GET["id"];
        $data = Delivery::all()->where("id", $id);
        return response()->json($data);
    }


    // =================================================================================
    // fetch all delivery
    // =================================================================================
    public function getDeliveries()
    {
        
        $data = DB::table('deliveries')
                 ->where('owner_id', Auth::user()->id)
                 ->orderBy('id','desc')
                ->get();

        $userOrders = DB::table('deliveries')->get();
        $action = '';
        $new_data = [];
        $i = 0;
        foreach($data as $item){
        
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewdeliverys" href="javascript:void(0)" class="dropdown-item"  data-toggle="modal" data-id="' .$item->id.'"  data-target=".viewDelivery">View</a>';
            $action .= '<a name="editdeliverys"  href="javascript:void(0)" class="dropdown-item"  data-toggle="modal" data-id="'.$item->id.'" data-target="#edit_Delivery">Edit</a>';
            $action .= '<a name="deleteDelivery"  href="javascript:void(0)" class="dropdown-item"  data-id="'.$item->id.'" >Delete</a>';
            $action .= '</div>';
            $action .= '</div>';
            
            $new_data[] = array(
                ++$i,
                $item->ord_no,
                $item->customer_name,
                $item->mobile_no,
                $item->delivery_man,
                $item->delivery_address,
                $item->date,
                $item->delivery_status,
                $item->payment_status,
                $action,
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
    }


    // =================================================================================
    // fetch a single delivery
    // =================================================================================
    public function getDelivery()
    {
        $id = $_GET["id"];
        $data = Delivery::all()->where("id", $id);
        return response()->json($data);
    }

    // =================================================================================
    // fetch a delivery man name
    // =================================================================================
    public function viewDeliverymanName()
    {
        return response()->json(Driver::all());
    }

    // 
    // END
    // 

    public function index()
    {
        $drivers1 = Driver::leftJoin('deliveries', 'deliveries.delivery_man_user_id', '=','drivers.id')
                    ->leftJoin('notifications', 'notifications.consolidate_order_no','=','deliveries.order_no')
                    ->orderBy('drivers.id','desc')
                    ->groupBy('notifications.consolidate_order_no')
                    ->get(['drivers.*', 'deliveries.date', 'deliveries.delivery_address', 'notifications.delivery_date']);

                    // dd($drivers1);

        $drivers = Driver::orderBy('id','desc')->get();
                    
        $deliveries = Delivery::orderBy('id','desc')->where('delivery_status', 'Packing')->orWhere('delivery_status', 'Pending')->get();

        return view('superadmin.delivery',compact('drivers','deliveries','drivers1'));
    }

    // fetch list of drivers
    public function driversList(){
        // $drivers1 = Driver::leftJoin('deliveries', 'deliveries.delivery_man_user_id', '=','drivers.id')
        //             ->leftJoin('notifications', 'notifications.consolidate_order_no','=','deliveries.order_no')
        //             ->where('delivery_date', request()->delivery_date)
        //             ->orderBy('drivers.id','desc')
        //             ->groupBy('notifications.consolidate_order_no')
        //             ->get(['drivers.*', 'deliveries.date', 'deliveries.delivery_address', 'notifications.delivery_date']);

        // $drivers = Driver::orderBy('id','desc')->get();

        // return response()->json(["drivers"=>$drivers1, "driver_list"=>$drivers]);

        $date = date('Y-m-d', strtotime(str_replace('/', '-', request()->delivery_date)));
        $data = DB::table('drivers')
        ->join('deliveries','deliveries.delivery_man_user_id','=','drivers.id')
        ->select('drivers.*','deliveries.date')
        ->whereIn('deliveries.delivery_status',['Packing','Pending','yet_to_deliver'])
        ->where('deliveries.date',$date)
        ->groupBy('deliveries.delivery_man_user_id')
        ->get();
        $new_data = array(); 
        foreach($data as $item){
            $new_data[]=[
                'driver_id'     => $item->driver_id,
                'driver_name'   => $item->driver_name,
                'total_order'   => DB::table('deliveries')->where('date',$date)->where('delivery_man_id',$item->driver_id)->where('delivery_status','!=','delivered')->count('*')
            ];
        }
        
        return response()->json(["drivers"=>$new_data]);

    }

    // count orders
    public function countOrders(){
        // $count = DB::table('deliveries')->where('delivery_man_user_id', request()->delivery_man_user_id)->where('delivery_status', 'Packing')->orWhere('delivery_status', 'Pending')->count();
        $change_date_format = str_replace('/', '-', request()->date);
        $date = date("Y-m-d", strtotime($change_date_format));
        $count = DB::table('deliveries')->where('delivery_man_user_id', request()->delivery_man_user_id)->whereBetween('delivery_status',['Packing','Pending'])->where('date',$date)->count();
        return response()->json(["count"=>$count]);
    }

    // list of deliveries
    public function driverDeliveries(){
        // $deliveries = Delivery::orderBy('id','desc')->where('delivery_man_id',request()->driver_id)->where('delivery_status', 'Packing')->orWhere('delivery_status', 'Pending')->get();
        $change_date_format = str_replace('/', '-', request()->date);
        $date = date("Y-m-d", strtotime($change_date_format));
        $deliveries = Delivery::join('notifications','deliveries.order_no','=','notifications.consolidate_order_no')
        ->select('deliveries.*','notifications.postcode')
        ->where('deliveries.delivery_man_id',request()->driver_id)
        ->whereIn('deliveries.delivery_status',['Packing','Pending','yet_to_deliver'])
        ->where('date',$date)
        ->orderBy('deliveries.id','desc')
        ->groupBy('notifications.consolidate_order_no')
        ->get();
        return response()->json(["deliveries"=>$deliveries]);
    }


    public function CancleOrder()
    {
        return view('superadmin.Delivery');
    }

    // fetch all Order
    public function GetOrder()
    {
        $data = DB::table('deliveries')->where('delivery_status', '!=', 'Cancel')->orderBy('id', 'desc')->get();
        
        $i = 0;
        $action = '';
        $new_data = []; 

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewcnclorder" title="View Order" data-toggle="modal" data-target="#viewcnclorder" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="cancelQuotation" title="Asign Driver" data-toggle="modal" data-target="#cancelModalorderdelivery" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="deleteQuotation" data-toggle="modal" data-target="#removeModalorderdelivery" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';
            
            $new_data[] = array(
                ++$i,
                $item->order_no,
                $item->customer_name,
                (($item->mobile_no != null) ? $item->mobile_no : "--"),
                $item->pickup_address,
                $item->delivery_man,
                $item->delivery_status,
                $item->payment_status,
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

    public function GetOrdercancel()
    {
        $data = DB::table('deliveries')->where('delivery_status', '=', 'Cancel')->orderBy('id', 'desc')->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewcnclorder" title="View Order" data-toggle="modal" data-target="#viewcnclorder" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="cancelQuotation" title="Asign Driver" data-toggle="modal" data-target="#cancelModalorderdelivery" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="deleteQuotation" data-toggle="modal" data-target="#removeModalorderdelivery" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';
            
            $new_data[] = array(
                ++$i,
                $item->order_no,
                $item->customer_name,
                (($item->mobile_no != null) ? $item->mobile_no : "--"),
                $item->pickup_address,
                $item->delivery_status,
                $item->payment_status,
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

    public function removeOrder()
    {
        $id = $_GET['id'];
        Delivery::where('id', $id)->delete();
        return response()->json(['success' => "Order Removed Successfully."]);
    }
    public function cancelOrder()
    {
        $id = $_GET['id'];
        Delivery::where("id", $id)
            ->update([
                "delivery_status" => "Cancel"
            ]);
        return response()->json(['success' => "Order Cancel Successfully."]);
    }
    // fetch a single order
    public function getOrderview()
    {
        $id = $_GET['id'];
        return response()->json(Delivery::all()->where("id", $id));
    }
    // order filter
    public function OrderFilter()
    {
        return response()->json(DB::table('deliveries')->where('customer_name', 'LIKE', '%' . $_GET['user'] . '%')->paginate(10));
    }

    public function GetdriverList()
    {
        $data = DB::table('drivers')->orderBy('id', 'desc')->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewdriver" data-toggle="modal" data-target="#viewdriver2" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="editdriver" data-toggle="modal" data-target="#editdriver" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="deletedriver" data-toggle="modal" data-target="#removeModalSalesdriver" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';
            
            $new_data[] = array(
                ++$i,
                $item->driver_man_id,
                $item->driver_name,
                $item->driver_mobile_no,
                $item->driver_email,
                // $item->driver_address,
                // $item->region,
                // $item->order_delivered,
                // $item->status,
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

    public function AddDriver(Request $request){

        $validator = $request->validate([
            "driver_name"       => "required",
            "driver_mobile_no"  => "required",
            "driver_email"      => "required|unique:users,email",
            "password"          => "required",
        ]);

        $now = new \DateTime('now');
        $month = $now->format('m');
        $year = $now->format('Y');

        $product_id = Driver::orderBy('id', 'DESC')->pluck('driver_man_id')->first();


        if ($product_id == null or $product_id == "") {
            $product_id = 'LFKDI'.$year.$month.'000001' ;
        } else {
            $number = (int)str_replace('LFKDI', '', $product_id);

            $product_id = "LFKDI" . sprintf("%04d", $number + 1);

        }
        $user = User::create([
            "is_admin"      => "5",
            "name"          => $request->driver_name,
            "mobile_number" => $request->driver_mobile_no,
            "email"         => $request->driver_email,
            "password"      => Hash::make($request->password),
            "created_at"    => now()
        ]);
        Driver::insert([
            "driver_id"         => $user->id,
            "driver_man_id"     => $product_id,
            "driver_name"       => $request->driver_name,
            "driver_mobile_no"  => $request->driver_mobile_no,
            "driver_email"      => $request->driver_email,
            "password"          => Hash::make($request->password),
            'show_password'     => $request->password,
            "commission"        => $request->commission,
            "created_at"        => now()
        ]);

        // Mail::send(new UserRegistered($request->driver_email, $request->password));

        return response()->json(["success" => "Driver is Added Successfully"]);

    }

    public function RemoveDriver()
    {
        $id = $_GET['id'];

        $data = Driver::where('id', $id)->first();

        User::where('id',$data->driver_id)->delete();
        Driver::where('id', $id)->delete();
        return response()->json(['success' => "Driver Removed Successfully."]);
    }
    public function EditDriver(Request $request)
    {

        $validator = $request->validate([
            "driver_name"       => "required",
            "driver_mobile_no"  => "required",
            "driver_email"      => "required|unique:users,email,". $request->edit_id,
            'edit_password'     => 'required'
        ]);

        User::where("id", $request->edit_id)
            ->update([
                "name"          => $request->driver_name,
                "mobile_number" => $request->driver_mobile_no,
                "email"         => $request->driver_email,
                "password"      => Hash::make($request->edit_password),
                "created_at"    => now()
        ]);
        Driver::where("driver_id", $request->edit_id)
            ->update([
                "driver_name"       => $request->driver_name,
                "driver_mobile_no"  => $request->driver_mobile_no,
                "driver_email"      => $request->driver_email,
                "commission"        => $request->editCommission,
                'password'          => Hash::make($request->edit_password),
                'show_password'     => $request->edit_password,
                "updated_at"        => now()
            ]);

        return response()->json(["success" => "Driver Details Updated Successfully"]);
    }
    public function FetchDriver()
    {
        try {

            $value = $_GET['id'];
            $data = Driver::where('id', $value)->first();
            $orders = Delivery::where('delivery_man_user_id', $_GET['id'])->get();

            if(request()->status == 1){
                return response()->json(["data"=>Driver::where('id', $value)->get()]);
            }else{
                $id = $_GET['id'];
                return view('superadmin.Delivery.driver-modal.viewdriver',compact('data','id'));
            }

        } catch (Exception $e) {
            return response()->json(['success' => $e->getMessage()]);
        }
    }


    // Store Delivery Route
    public function storeDeliveryRoute(Request $request){
        // return json_encode($request->all());

        $count = OrderRoutes::where('driver_id', $request->driver_id)->where('delivery_date', $request->delivery_date)->count();

        if($count > 0){
            OrderRoutes::where('driver_id', $request->driver_id)->where('delivery_date', $request->delivery_date)->delete();
        }
        foreach($request->addresses as $key => $address){
            OrderRoutes::create([
                'consolidate_order_no'  => $request->consolidate_order_no[$key],
                'driver_id'         => $request->driver_id,
                'placement_id'      => $key,
                'delivery_date'     => $request->delivery_date,
                'address'           => $address,
                'lat'               => $request->waypoints[$key]['lat'],
                'lng'               => $request->waypoints[$key]['lng'],
            ]);
        }

    return response()->json(["status" => "success", "message"=>"Route Saved Successfully"]);




        // $request->validate([
        //     "addresses" => "required",
        //     "driver_id" => "required",
        //     "delivery_date" => "required",
        // ],[
        //     "driver_id" => "Driver field required."
        // ]);

        // $j = 0;
        // $k = 0;
        // $l = 0;

        // $count = OrderRoutes::where('driver_id', $request->driver_id)->where('delivery_date', $request->delivery_date)->count();

        // if($count > 0){
        //     OrderRoutes::where('driver_id', $request->driver_id)->where('delivery_date', $request->delivery_date)->delete();
        // }

        //     for($i = 0; $i<sizeof($request->addresses1); $i++){

        //         // dd($request->addresses1[$i]);
        //         // dd($request->addresses[$i]['place_id']);

        //         OrderRoutes::create([
        //             'driver_id' => $request->driver_id,
        //             'location' => ++$k,
        //             'delivery_date' => $request->delivery_date,
        //             'address' => $request->addresses1[$i],
        //             'placeID' => $request->addresses[$i]['place_id'],
        //         ]);
        //     }

        // return response()->json(["status" => "success", "message"=>"Route Saved Successfully"]);

    }


    // =================================================================================
    // Store delivery Date
    // =================================================================================    
    public function storeDeliverydate(Request $request)
    {
        $uniqueTime = str_replace(' ', '', hexdec(date('Y-m-d H:i:s')));

        $validator = Validator::make($request->all(), [
            // "customer_name" => "required",
            // "product_name" => "required",
            // "description" => "required",

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {
            $date = DriverDate::where('owner_id', Auth::user()->id)->where('date_time', $request->date_time)->count();

            if ($date > 0) {

                DriverDate::where('owner_id', Auth::user()->id)->where('date_time', $request->date_time)->update([
                    "limit" => $request->limit,
                    "updated_at" => now()
                ]);

                return response()->json(['success' => 'Delivery Limit Updated Succesfully']);
            } else {


                DriverDate::create([
                    "owner_id" => Auth::user()->id,
                    "date_time" => $request->date_time,
                    "limit" => $request->limit,
                    "created_at" => now()
                ]);
                return response()->json(['success' => 'Delivery Limit Created Succesfully']);
            }
        }
    }

    // =================================================================================
    // Get delivery Date
    // =================================================================================    
    public function getDeliverydate()
    {
        $deliveryDates = Notification::all();

        // $new_data = DB::table('notifications')->distinct('delivery_date')->where('delivery_date', '!=', null)->get();
        // $new_data = Notification::where('delivery_date','!=', null)->where('delivery_date','=','delivery_date')->distinct('delivery_date')->count();
        $new_data = DB::select('SELECT delivery_date, count(*) as count FROM notifications GROUP BY delivery_date');
        $data = DriverDate::all();
        return response()->json(['data'=>$data,'new_data'=>$new_data]);
        // return response()->json($data);
    }

    // =================================================================================
    // Delite delivery Date
    // =================================================================================    
  
    // public function destroyDate()
    // {
    //     $id = $_GET['id'];
    //         dd($id);
    //     try{
    //         $id = $_GET['id'];
    //         dd($id);
    //         DriverDate::where('date_time', $id)->delete();
    //         return response()->json(['success'=>'Limit Removed Successfully']);
    //     }catch(Exception $e){
    //         return response()->json(['success'=>'Database query error..']);
    //     }

    // }
    public function destroyDate($id)
    {
        DriverDate::where('id', $id)->delete();
        return response()->json(['success'=>'Limit Removed Successfully']);
    }

  
}
