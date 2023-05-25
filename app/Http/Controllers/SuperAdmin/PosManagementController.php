<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\User;
use App\Models\address;
use App\Models\PosStocks;
use App\Models\product;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\FacadesoutletManagement\Validator;

class PosManagementController extends Controller
{
    //
    public function index()
    {
        return view('superadmin.pos');
    }

    // store outlet
    public function store(Request $request)
    {
        try {

            $data = $request->validate([
                'email' => 'required|unique:users',
                'mobile_number' => 'required|unique:users',
            ],
            [
                "email" => 'Email Already Registered',
                "mobile_number" => 'Mobile Number Already Registered'
            ]
        );

            $data = ModelsUser::create([
                'is_admin' => '4',
                'name' => $request->name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'password' => Hash::make($request->password)
            ]);

            address::create([
                'user_id' => $data->id,
                'company' => '--',
                'name' => $request->name,
                'postcode' => $request->postcode,
                'unit' => $request->unitCode,
                'housee_flat_office_no' => $request->unitCode,
                'address' => $request->address,
                'mobile_number' => $request->mobile_number,
                'country' => 'Singapore'
            ]);

            return response()->json(["success" => "Outlet Details Added Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()]);
        }
    }

    // fetch all outlet's
    public function fetchAllOutLet()
    {
        $data = DB::table('users')->join('addresses', 'addresses.user_id', '=', 'users.id')->where('users.is_admin', 4)->select(['users.*', 'addresses.*'])->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewOutLetDetails" data-target="#viewOutlet" data-toggle="modal" class="dropdown-item" href="#" data-id="'.$item->user_id.'">View</a>';
            $action .= '<a name="updateOutletDetails" data-target="#updateOutlet" data-toggle="modal" class="dropdown-item" href="#" data-id="'.$item->user_id.'">Edit</a>';
            $action .= '<a name="deleteOrders" data-toggle="modal" data-target="#removeModalOutletDetails" class="dropdown-item" href="#" data-id="'.$item->user_id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->name,
                $item->email,
                $item->mobile_number,
                $item->postcode,
                '<a class="btn btn-sm btn-primary" href="/admin/pos/outlet-management/'.$item->user_id.'"  id="stockUserStockManagementModel" >Manage Stock</a>',
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

    // fetch single outlet details
    public function fetchSingleOutletDetails()
    {
        $data = ModelsUser::join('addresses', 'addresses.user_id', '=', 'users.id')->where('addresses.user_id', $_GET['id'])->get(['users.*', 'addresses.*']);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        try {

            $data = ModelsUser::where('id', (int)$request->id)
            ->update([
                'is_admin' => '4',
                'name' => $request->name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number
            ]);

            address::where('user_id', (int)$request->id)
            ->update([
                'name' => $request->name,
                'postcode' => $request->postcode,
                'unit' => $request->unitCode,
                'address' => $request->address,
            ]);

            return response()->json(["success" => "Outlet Details Updated Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()]);
        }
    }

    // remove single outlet details
    public function remove()
    {
        try {

            // PosStocks::where('id', $_GET['id'])->delete();
            $status = DB::table('users')->leftJoin('addresses', 'addresses.user_id', '=', 'users.id')->where('users.id', $_GET['id'])->delete();
            DB::table('addresses')->where('user_id', $_GET['id'])->delete();
            return response()->json(["success" => "Outlet Details Removed Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => $th->getMessage()]);
        }
    }


    // Store Stock for OUTLET in POS
    public function outletStoreStock(Request $request)
    {

        $barcode = product::where('product_name', $request->product_name)->where('product_varient', $request->product_variant)->value('barcode');
        $product_id = product::where('product_name', $request->product_name)->where('product_varient', $request->product_variant)->value('id');
        PosStocks::create([
            "owner_id" => $request->id,
            "product_id" => $product_id,
            "product_name" => $request->product_name,
            "product_variant" => $request->product_variant,
            "unit_price" => $request->unit_price,
            "barcode" => $barcode,
            "quantity" => $request->quantity,
        ]);
        return response()->json(["success" => "Stock Added Successfully"]);
    }

    public function fetchAllProductsList()
    {
        $data = DB::table('products')->select('product_name')->get();
        $data = json_decode($data);
        return response()->json(array_unique($data, SORT_REGULAR ));
    }

    // fetch products details via product name
    public function fetchAllVariantList()
    {
        $data = DB::table('products')->where('product_name', $_GET['proName'])->select('product_varient')->get();
        $data = json_decode($data);
        return response()->json(array_unique($data, SORT_REGULAR ));
    }

    // all details
    public function fetchAllProductsDetailsStock()
    {
        $data = product::where('product_name', $_GET['proName'])->where('product_varient', $_GET['proVariant'])->get();
        return response()->json($data);
    }

    // fetch all OutletStock Details for table
    public function fetchAllOutletStockDetails()
    {
        // return response()->json(PosStocks::where('owner_id', $_GET['id'])->get());
        $data = PosStocks::where('owner_id', $_GET['id'])->orderBy('id','desc')->get();
        $new_data = array();

        $action = '';

        $i = 0;
        foreach($data as $item){

            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="updateOutletStockInfo" href="javascript:void(0)" class="dropdown-item" data-toggle="modal" data-target="#updateStock" data-id="'.$item->id.'" >Edit</a>';
            $action .= '<a name="removeOutletStockInfo" href="javascript:void(0)" class="dropdown-item" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->product_name,
                $item->product_variant,
                $item->unit_price,
                $item->quantity,
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
    }

    // fetch single outlet stock details
    public function fetchSingleOutletStockDetails()
    {
        return response()->json(PosStocks::where('id', $_GET['id'])->get());
    }

    // update single outlet stock details
    public function outletUpdateStock(Request $request)
    {
        $data = $request->validate([
            "quantity" => "required",
        ]);

        PosStocks::where('id', $request->id)
        ->update([
            "quantity" => $request->quantity,
        ]);
        return response()->json(["success" => "Stock Updated Successfully"]);
    }

    // remove single outlet stock details
    public function outletRemoveStock()
    {
        try {
            PosStocks::where('id', $_GET['id'])->delete();
            return response()->json(["success" => "Stock Removed Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()]);
        }
    }

    // outlet management
    public function outletManagement($id)
    {
        $data = PosStocks::all();
        return view('superadmin.pos.outletManagement', ["id" => $id]);
    }

}
