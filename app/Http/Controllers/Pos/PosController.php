<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Models\product;
use App\Models\Warehouse;
use App\Models\Stock;
use App\Models\Pos_Orders;
// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\PosStocks;
use App\Models\SalesOrder;

use App\Models\Customer;
use App\Models\PosPayments;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Console\Input\Input;

class PosController extends Controller
{
    //
    public function index2(){
        return view('pos.login');
    }

    // orders dashboard
    public function viewOrdersDashboard()
    {
        return view('pos.sales-order');
    }
    // end here

    // fetch all sales order details
    public function viewOrdersDetails()
    {
        $data = Pos_Orders::where('user_id', Auth::user()->id)->where('status',0)->get();
        $new_arr=[];
        $new_data=[];
        foreach($data as $k => $v) {
            $new_arr[$v['order_no']]=$v;
        }

        $i = 0;
        $action = "";
        foreach($new_arr as $item){       
            $action .= '<a href="/pos/sales-session/'.$item->order_no.'"><i class="fa-solid fa-right-to-bracket"></i></a>';
            $action .= '&nbsp;&nbsp;|&nbsp;&nbsp;';
            $action .= '<a href="javascript:void(0)" id="removeOrder" data-total="'.Pos_Orders::where('order_no', $item->order_no)->sum('total').'" data-orderno="'.$item->order_no.'"><i class="bi bi-trash text-danger mx-auto"></i></a>';
            $new_data[] = array(
                ++$i,
                Carbon::parse($item->created_at)->diffForHumans(),
                $item->order_no,
                $item->customer_name,
                '$'.Pos_Orders::where('order_no', $item->order_no)->sum('total'),
                'Ongoing',
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
    // end here

    // show all sales orders list
    public function viewAllSalesOrdersDetails()
    {
        $data = Pos_Orders::where('user_id', Auth::user()->id)->where('status',1)->get();
        $new_arr=[];
        $new_data=[];
        foreach($data as $k => $v) {
            $new_arr[$v['order_no']]=$v;
        }

        $i = 0;
        $action = "";
        foreach($new_arr as $item){       
            $action .= '<a href="javascript:void(0)" id="viewOrders" data-id="'.$item->order_no.'"><i class="bi bi-eye"></i></a>';
            $new_data[] = array(
                ++$i,
                Carbon::parse($item->created_at)->diffForHumans(),
                $item->order_no,
                $item->customer_name,
                '$'.Pos_Orders::where('order_no', $item->order_no)->sum('total'),
                $item->status!=0?'Completed':'Ongoing',
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
    // end here

    // show single order wise products list
    public function viewSingleSalesOrdersDetails()
    {
                $data = Pos_Orders::join('pos_stocks', 'pos_stocks.product_id', '=', 'pos__orders.product_id')
                        ->where('order_no', request()->order_number)
                            ->get(["pos__orders.*", "pos_stocks.product_name", "pos_stocks.product_variant"]);

        $new_data = [];
        $i = 0;
        foreach($data as $item){       
            $new_data[] = array(
                ++$i,
                $item->product_name,
                $item->product_variant,
                $item->quantity,
                $item->unit_price,
                $item->total,
            );
        }
        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> $data->count(),
            "recordsFiltered" 	=> $data->count(),
            "data" 				=> $new_data
        );

        echo json_encode($output);
    }
    // end here

    // continue sales session
    public function continueSalesSession($order_number)
    {
        if(empty(request()->id))
        {
            $user = False;
            
            $data = Pos_Orders::where('user_id', Auth::user()->id)->where('status', 0)->get();
            $new_arr=[];
            foreach($data as $k => $v) {
                $new_arr[$v['order_no']]=$v;
            }

            $total_orders = sizeof($new_arr);

            return view('pos.sales')->with(['user'=>$user, 'order_number'=>$order_number, 'total_orders'=>$total_orders]);
        }
        else
        {
            $user = Customer::find(request()->id);
            
            $data = Pos_Orders::where('user_id', Auth::user()->id)->where('status', 0)->get();
            $new_arr=[];
            foreach($data as $k => $v) {
                $new_arr[$v['order_no']]=$v;
            }

            $total_orders = sizeof($new_arr);
            Pos_Orders::where('order_no',$order_number)->update(['customer_name'=>$user->customer_name, 'customer_id'=> $user->customer_id]);
            return view('pos.sales')->with(['user'=>$user, 'order_number'=>$order_number, 'total_orders'=>$total_orders]);
        }
    }
    // end here

    public function onlyPosLogin(Request $request){

        $rules = array(
			'email' => 'required|email',
			'password' => 'required'
        );

			$validator = Validator::make([
                "email" => $request->email,
                "password" => $request->password,
            ] , $rules);

			if ($validator->fails())
				{
				return Redirect::back()->withErrors($validator);
				}
			  else
				{

				$userdata = array(
					'email' => $request->email ,
					'password' => $request->password
				);

				// attempt to do the login

				if (Auth::attempt($userdata))
					{
                        if(Auth::user()->is_admin == '4'){
                            return Redirect::route('Pos-Dashbaord');
                        }else{
                            Auth::logout();
 
                            $request->session()->invalidate();
                         
                            $request->session()->regenerateToken();
                            return Redirect::back()->with('error', 'Please enter valid credentials');
                        }

					}
				  else
					{
					    return Redirect::back()->with('error', 'Please enter valid credentials');
					}
				}
    }

    public function onlyPosLogout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
        return Redirect::route('C-login')->with('success', 'Successfully logged out');
    }

    function successlogin()
    {
     return view('pos.pos-dashboard');
    }


    public function index(){

        $total_customer = Customer::where('is_pos', 1)->count();

        $this_month_customer = Customer::where('is_pos', 1)->whereMonth('created_at', Carbon::now()->month)->count();

        $total_products = PosStocks::select('product_name')->distinct()->get();

        $todays = Pos_Orders::whereDate('created_at', Carbon::today())->select('order_no')->distinct()->get();

        $this_month = Pos_Orders::whereMonth('created_at', Carbon::now()->month)->select('order_no')->distinct()->get();

        $last_month = Pos_Orders::whereBetween('created_at',[Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->select('order_no')->distinct()->get();

        return view('pos.index')
                ->with([
                    "todays"=>$todays->count(),
                    "last_month"=>$last_month->count(),
                    "this_month"=>$this_month->count(),
                    "total_products"=>$total_products->count(),
                    "total_customer"=>$total_customer,
                    "this_month_customer"=>$this_month_customer,
                ]);
    }

    public function GetData(){
        $data = Product::select(
            DB::raw("(COUNT(*)) as count"),
            DB::raw("MONTHNAME(created_at) as month_name")
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month_name')
        ->get();
    }


    public function customer()
    {
        return view('pos.customer');
    }
      
    public function addcustomer(Request $request){
        $validator = Validator::make($request->all(),[
            'customer_name'=>'required',
            'mobile_number'=>'required|max:12',
            'email_id' => 'required|email|unique:customers,email_id',
            // unique:users
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()]);
        }
        $customer = new Customer();
        $customer->customer_name = request('customer_name');
        $customer->customer_id = 1;
        $customer->customer_type = 'retails';
        $customer->address = request('address');
        $customer->phone_number = request('phone_number');
        $customer->mobile_number = request('mobile_number');
        $customer->email_id = request('email_id');
        $customer->dob = request('dob');
        $customer->postal_code = request('postcode');
        $customer->unit_number = request('unitCode');
        $customer->is_pos = 1;
        $customer->save();

        return response()->json([
            "success"=>"Customer Data Inserted"
        ]);
        // session()->flash('message','customer data Inserted');
        // return view('pos.customer');
        
    }
 
    public function destroy($id) {
        $delete = customer::destroy('delete from student where id = ?',[$id]);
        return redirect()->back()->with("Record deleted successfully");
     }
     public function deleteCustomer($id){
         $delete = Payment::destroy('delete from student where id = ?',[$id]);
         return redirect()->back()->with("Record deleted successfully");
     }
    
    public function create()
    {
        if(empty(request()->id))
        {
            $order_no = Pos_Orders::orderBy('id', 'DESC')->first();
                if($order_no == null or $order_no == "")
                {
                    $number = 'PO001';
                }
                else
                {
                    $number = str_replace('PO', '', $order_no->order_no);
                    $number =  "PO" . sprintf("%03d", $number + 1);
                }
            $user = False;

            $data = Pos_Orders::where('user_id', Auth::user()->id)->where('status', 0)->get();
            $new_arr=[];
            foreach($data as $k => $v) {
                $new_arr[$v['order_no']]=$v;
            }

            $total_orders = sizeof($new_arr);

            return view('pos.sales')->with(['user'=>$user, 'order_number'=>$number, 'total_orders'=>$total_orders]);
        }
        else
        {
            $user = Customer::find(request()->id);
            $product = product::all();
            return view('pos.sales')->with('user',$user)->with('product',$product);
        }
    }

    public function show(){
        $pay = Payment::all();
        return view("pos.show-sales")->with('pay',$pay);
    }

    // view single pos sales ordered details
    public function orderDetails()
    {
        return view('pos.show-sales-orders')->with('order_number',request()->order_number);
    }
    // end here

    public function getCustomerInfo()
    {
        $user = Customer::where('id',$_GET['id'])->get();
        return response()->json($user);
    }
  
    public function getProduct()
    {
        $data = PosStocks::join('products', 'products.id', '=', 'pos_stocks.product_id')->get();
        
        $data1 = [];

        foreach ($data as $key => $value) {
            $data1[$value['product_id']]=$value;
        }
        return response()->json($data1);
    }
    public function getPerProduct()
    {
        // $user = product::where('id',$_GET['id'])->get();
        $data = PosStocks::join('products', 'products.id', '=', 'pos_stocks.product_id')->where('products.product_category',$_GET['category'])->get();
        
        $data1 = [];

        foreach ($data as $key => $value) {
            $data1[$value['product_id']]=$value;
        }
        return response()->json($data1);
    }

    public function store(Request $request){
        $request->validate([
            'customer_name'=>'required',
            'mobile_number'=>'required|max:12',
        ]);
        $sales = new SalesOrder();
        $sales->customer_name = request('customer_name');
        $sales->mobile_number = request('mobile_number');
        $sales->address = request('address');
        $sales->product_name = request('product_name');
        $sales->product_variant = request('product_variant');
        $sales->unit_price = request('min_sale_price');
        $sales->quantity = request('quantity');
        $sales->amount = request('total');
        
        $sales->save();

        // session()->flash('message','customer data Inserted');
        return view('pos.salespayment');
        // return "them";
    }
    public function viewstock($id){
        $user = PosStocks::where('id',$_GET['id'])->get();
        return response()->json($user);
    }
    
    public function showcustomer(){
        $order_number = "false";
        $new = Customer::where('is_pos', 1)->get();
        return view("pos.show-customer")->with(['new'=>$new, 'order_number'=>$order_number]);
    }

    public function selectCustomer($order_number)
    {
        $data = Customer::all();
        return view("pos.show-customer")->with(['new'=>$data, 'order_number'=>$order_number]);
    }

    public function viewcustomer($id){
        $customer = Customer::find($id);
        return response()->json($customer);
    }

    public function update(Request $request, $id){  
        // $new = Customer::find($id);
        // $input = $request->all();
        // $new->update($input);
        // session()->flash('message','customer data Updated');
        // return redirect()->back(); 
        $updateData = $request->validate([
            'customer_name'=>'required',
            'mobile_number'=>'required|max:12',
        ]);
        $cust = Customer::find($id);
        
        // Customer::whereId($id)->update($updateData);
        // session()->flash('message','customer data Updated');
        // return redirect()->back(); 
        // return redirect()->back()->with('completed', 'Customer has been updated');
    }
    public function salesAllBatchCode()
    {
        $data = Stock::where('product_name', $_GET['proName'])->where('product_variant', $_GET['proVariant']);
        return $data;
    }

    public function fetchProductsDetialsInfo()
    {

        $customer_id = $_GET['id'];
        // $product = $_GET['product'];
        // $varient = $_GET['varient'];
        $all_products = product::all()->toArray();
        // $all_products = product::all()->unique(['product_name'])->toArray();
        // 
        // $all_products = DB::table('products')->select('product_name', 'product_variant')->distinct()->get();

        $customer_pro = Customer::all()->where('id', $customer_id)->value('specialPrice');

        // return $all_products;

        $arr1Id = [];

        $arr2Id = [];

        $unmatch_pro = [];

        // $finalProDetials = [];

        if(empty(json_decode($customer_pro))){

                // $finalProDetials = $all_products;
                foreach($all_products as $k1 => $v1){
                    array_push($unmatch_pro, [
                        "id" => $v1['id'],
                        "product_name" => $v1['product_name'],
                        "sku_code" => $v1['sku_code'],
                        "batch_code" => $v1['batch_code'],
                        "category" => $v1['product_category'],
                        "variant" => $v1['product_variant'],
                        "unit_price" => $v1['min_sale_price'],
                    ]);
                }
        }else{

                foreach($all_products as $k => $v){
                    $obj = (object)[
                        "id" => $v['id'],
                        "product_name" => $v['product_name'],
                        "product_variant" => $v['product_variant'],
                        "unit_price" => $v['min_sale_price'],
                        "category" => $v['product_category'],
                        "sku_code" => $v['sku_code'],
                        'batch_code' => $v['batch_code']
                    ];
                    array_push($arr1Id, $obj);
                }

                // return $arr1Id;

                foreach(json_decode($customer_pro) as $k => $v){
                    array_push($arr2Id, (object)[
                        "id" => $v -> id,
                        "product_name" => $v -> product_name,
                        "product_variant" => $v -> product_variant,
                        "unit_price" => $v -> specialPrice,
                        "sku_code" => $v -> sku_code,
                        "category" => $v -> category,
                        "batch_code" => $v -> batch_code,
                    ]);
                }

                // return $arr2Id;

                foreach($arr1Id as $k => $v){
                    foreach($arr2Id as $key => $value){
                        // return $v -> product_variant;
                        if($v->product_name != $value->product_name || $v -> product_variant != $value -> product_variant){
                            array_push($unmatch_pro, (object)[
                                "id" => $v->id,
                                "product_name" => $v->product_name,
                                "category" => $v->category,
                                "variant" => $v->product_variant,
                                "sku_code" => $v->sku_code,
                                "batch_code" => $v->batch_code,
                                "unit_price" => $v->unit_price
                            ]);
                        }
                    }
                }

                // return $arr2Id;
                
                // $unmatch_pro = array_diff_assoc((array)$arr2Id, (array)$arr1Id);

                // return $unmatch_pro;

                // products which not listed in special price list
                // foreach($unmatch_pro as $k => $v){
                //     foreach($all_products as $k1 => $v1){
                //         if($v === $v1['product_name']){
                //             array_push($finalProDetials, [
                //                 "id" => $v1['id'],
                //                 "product_name" => $v1['product_name'],
                //                 "category" => $v1['product_category'],
                //                 "varient" => $v1['product_variant'],
                //                 "sku_code" => $v1['sku_code'],
                //                 "batch_code" => $v1['batch_code'],
                //                 "sku_code" => $v1['sku_code'],
                //                 "unit_price" => $v1['min_sale_price']
                //             ]);
                //         }
                //     }    
                // }

                // products which listed in special price list
                foreach(json_decode($customer_pro) as $k => $v){
                    array_push($unmatch_pro, (object)[
                        // $k => $v
                        // "id" => (int)$v->id,
                        "product_name" => $v->product_name,
                        "category" => $v->category,
                        "variant" => $v->product_variant,
                        "sku_code" => $v->sku_code,
                        "batch_code" => $v->batch_code,
                        "unit_price" => $v->specialPrice
                    ]);
                }
        }

        return response()->json($unmatch_pro);

        // return response()->json(product::all()->where('product_name', $_GET['product'])->where('product_variant', $_GET['varient'])->pluck('sku_code'));
        // return response()->json(DB::table('products')->where('product_name', $_GET['product'])->where('product_variant', $_GET['varient'])->select('sku_code', 'batch_code', 'product_category')->get());
    }

    public function product(){
        $product = product::all();
        return view("pos.product")->with('product',$product);
    }

    public function getVarient(){
        $name = $_GET['name'];
        $data = product::where('product_name',$name)->select('product_variant')->distinct()->get();
        return response()->json($data);
    }
    public function getAllData(){
        $name = $_GET['name'];
        $varient = $_GET['varient'];
        $data = product::where('product_name',$name)->where('product_variant',$varient)->get();
        return response()->json($data);
    }
    public function getCal(){
        $sale = $_GET['sale'];
        $quantity = $_GET['quantity'];
        $data = product::where('min_sale_price',$sale)->where('quantity',$quantity)->get();
        return response()->json($data);
    }
   public function getCustomerpayment(){
        $user = Customer::where('id',$_GET['id'])->get();
        return response()->json($user);
   }

   public function stock(){
      $new = stock::all();
      $stock = PosStocks::all()->where("owner_id",Auth::user()->id);
      return view("pos.stock",compact('new','stock'));
   }

   public function addstock(){
        $wh = Warehouse::get();
        $product = product::all();
        return view("pos.addstock",compact('wh','product'));
   }

   public function addstock2(Request $request){
    $request->validate([
        'product_name'=>'required',
        'quantity'=>'required'
    ]);
        $barcode = product::where('product_name',$request->product_name)->where('product_variant',$request->product_variant)->value('barcode');
        $stock = new PosStocks();
        $stock->owner_id = Auth::user()->id;
        $stock->product_name = request('product_name');
        $stock->product_variant = request('product_variant');
        $stock->quantity = request('quantity');
        $stock->barcode = $barcode;
        $stock->unit_price = request('min_sale_price');
        $stock->save();
        return redirect()->back()->with("Successfuly Added");
    }    
    // public function showstock(){
    //     $stock = PosStocks::all();
    //     return view("pos.show-stock2",compact('stock'));
    // }

    // public function editstock($id){
    //     $product = Product::all();
    //     $new = PosStocks::find($id);
    //     return view("pos.edit-stock", compact('new','product'));
    // }
    public function destock($id) {
        $delete = PosStocks::destroy('delete from stocks where id = ?',[$id]);
        return redirect()->back()->with("Record deleted successfully");
    }
    
    public function showstock2($id){
        $stock = PosStocks::find($id); 
        return response()->json($stock);
    }

    // public function search(Request $request){
    //     $psearch = $request->product_name;
    //     if($psearch != ""){
    //         $product = product::where("name","LIKE","%",product_name,"%")->first();
    //         if($product){
    //             return redirect();
    //         }
    //     }
    //     else{
    //         return redirect()->back();
    //     }
    // }

    public function storecust(){
        $data = DB::table('users')->join('addresses', 'addresses.user_id', '=', 'users.id')->where('users.is_admin', 4)->select(['users.*', 'addresses.*'])->paginate(5);
        return response()->json($data);
    }
    public function searchproduct(){

        $val = $_GET["product_name"];
        $product = PosStocks::join('products', 'products.id', '=', 'pos_stocks.product_id')
                    ->where('products.product_name', $val)
                    ->orWhere('products.product_name', 'like', '%' . $val . '%')->get();

                    
        $data1 = [];

        foreach ($product as $key => $value) {
            $data1[$value['product_id']]=$value;
        }

        return response()->json($data1);
    }

    // ====================================================================================================
    // ====================================================================================================
    // ADD ITEM TO POS ORDER
    public function addToPosOrder(Request $request){
        try {
            
            $count = Pos_Orders::where('user_id',Auth::user()->id)->where('order_no', request()->order_number)->where('product_id', request()->product_id)->count();

            $price = PosStocks::where('owner_id',Auth::user()->id)->where('product_id', request()->product_id)->value('unit_price');

            if((integer)$count == (integer)0){
                Pos_Orders::create([
                        'order_no' => request()->order_number,
                        'user_id' => Auth::user()->id,
                        'product_id' => request()->product_id,
                        'unit_price' =>  $price,
                        'total' => $price,
                        'quantity' => 1
                ]);        
            }
            else{

                $quantity = Pos_Orders::where('user_id',Auth::user()->id)->where('order_no', request()->order_number)->where('product_id',  request()->product_id)->value('quantity');
                Pos_Orders::where('user_id',Auth::user()->id)
                            ->where('order_no', request()->order_number)
                            ->where('product_id',  request()->product_id)
                            ->update([
                                'quantity' => (integer)$quantity+1,
                                'total' => ((integer)$quantity+1)*(integer)$price,
                            ]);
            }
            return response()->json(["status"=>true, "message"=>"Item Added"]);
        } catch (\Throwable $th) {
            return response()->json(["status"=>false, "message"=>$th->getMessage()]);
        }
    }
    // END HERE
    // ====================================================================================================
    // ====================================================================================================

    // ====================================================================================================
    // ====================================================================================================
    // FETCH ALL CART ORDER DETAILS
    public function fetchOrderDetails(){
        $data = Pos_Orders::join('products', 'products.id','=', 'pos__orders.product_id')->where('pos__orders.user_id',Auth::user()->id)->where('pos__orders.order_no', request()->order_number)->get();
        return response()->json(["status"=> true, "data"=>$data]);
    }
    // END HERE
    // ====================================================================================================
    // ====================================================================================================

    // ====================================================================================================
    // ====================================================================================================
    // Update Quantity
    public function updateQuantity(Request $request)
    {
        try {
            $price = Pos_Orders::where('user_id',Auth::user()->id)->where('order_no', request()->order_number)->where('product_id', request()->product_id)->value('unit_price');

            Pos_Orders::where('user_id',Auth::user()->id)
                        ->where('order_no', request()->order_number)
                        ->where('product_id', request()->product_id)
                        ->update([
                            'quantity' => request()->quantity,
                            'total' => (integer)request()->quantity*(integer)$price
                        ]);
            return response()->json(["status"=>true, "message"=>"Item Updated"]);
        } catch (\Throwable $th) {
            return response()->json(["status"=>false, "message"=>$th->getMessage()]);
        }
    }
    // END HERE
    // ====================================================================================================
    // ====================================================================================================
    
    // ====================================================================================================
    // ====================================================================================================
    // Update Price
    public function updateProductPrice(Request $request)
    {
        try {
            $quantity = Pos_Orders::where('user_id',Auth::user()->id)->where('order_no', request()->order_number)->where('product_id', request()->product_id)->value('quantity');

            Pos_Orders::where('user_id',Auth::user()->id)
                        ->where('order_no', request()->order_number)
                        ->where('product_id', request()->product_id)
                        ->update([
                            'unit_price' => request()->price,
                            'total' => (integer)request()->price*(integer)$quantity
                        ]);
            return response()->json(["status"=>true, "message"=>"Item Updated"]);
        } catch (\Throwable $th) {
            return response()->json(["status"=>false, "message"=>$th->getMessage()]);
        }
    }
    // END HERE
    // ====================================================================================================
    // ====================================================================================================

    // ====================================================================================================
    // ====================================================================================================
    // Update Price
    public function updateProductDiscount(Request $request)
    {
        try {
            $data = Pos_Orders::where('user_id',Auth::user()->id)->where('order_no', request()->order_number)->where('product_id', request()->product_id)->get();

            $discount = request()->discount;
            $quantity = $data[0]["quantity"];
            $price = $data[0]["unit_price"];

            $total_discount = ((float)$price*(float)$discount)/100;

            $product_price = (float)$price-(float)$total_discount;

            $total = (float)$product_price*(float)$quantity;

            Pos_Orders::where('user_id',Auth::user()->id)
                        ->where('order_no', request()->order_number)
                        ->where('product_id', request()->product_id)
                        ->update([
                            'unit_price' => $price,
                            'discount' => request()->discount,
                            'total' => $total
                        ]);
            return response()->json(["status"=>true, "message"=>"Item Updated"]);
        } catch (\Throwable $th) {
            return response()->json(["status"=>false, "message"=>$th->getMessage()]);
        }
    }
    // END HERE
    // ====================================================================================================
    // ====================================================================================================
    
    // ====================================================================================================
    // ====================================================================================================    
    // Payment Section
    public function paymentSection($order_number){

        $data = Pos_Orders::where('user_id', Auth::user()->id)->where('status', 0)->get();
        $new_arr=[];
        foreach($data as $k => $v) {
            $new_arr[$v['order_no']]=$v;
        }

        $total_orders = sizeof($new_arr);
        $sum = Pos_Orders::where('order_no', $order_number)->get();
        $sum = Pos_Orders::where('order_no', $order_number)->sum('total');

        return view("pos.salespayment", ["order_number"=>$order_number, "total_orders"=>$total_orders, "sum"=>$sum]);
    }
    // END HERE
    // ====================================================================================================
    // ====================================================================================================

    // ====================================================================================================
    // ====================================================================================================    
    // Remove single order via order number
    public function removeSingleOrder(){
        try {
            Pos_Orders::where('order_no', request()->order_number)->delete();
            return response()->json(["status"=>true,"message"=>'Order Removed']);
        } catch (\Throwable $th) {
            return response()->json(["status"=>false,"message"=>$th->getMessage()]);
        }
    }
    // END HERE
    // ====================================================================================================
    // ====================================================================================================

    
    // ====================================================================================================
    // ====================================================================================================    
    // Remove single order via order number
    public function getFinalPayments(){
        try {
            $order_number = request()->order_number;
            $payments = request()->payments;

            Pos_Orders::where('order_no', $order_number)->update(['status'=>1]);

            $data = Pos_Orders::where('order_no', $order_number)->get();

            foreach ($data as $value) {
                $inStock = PosStocks::all()->where('product_id', $value["product_id"])->value('quantity');

                $minus = $inStock - $value['quantity'];

                PosStocks::where('product_id', $value["product_id"])
                    ->update([
                        "quantity" => $minus,
                    ]);
            }

            foreach($payments as $key=>$value){
                PosPayments::create([
                    'order_no' => $order_number,
                    'payment_type' => $value["type"],
                    'amount' => $value["value"],
                ]);
            }
            return response()->json(["status"=>true,"message"=>"Payment Succeeded", "route" => "/pos/payment/sales-order/".$order_number]);
        } catch (\Throwable $th) {
            return response()->json(["status"=>false,"message"=>$th->getMessage()]);
        }
    }
    // END HERE
    // ====================================================================================================
    // ====================================================================================================

    
    // ====================================================================================================
    // ====================================================================================================    
    // Remove single order via order number
    public function viewPaymentPage($order_number){
        return view('pos.payment')->with('order_number', $order_number);
    }
    // END HERE
    // ====================================================================================================
    // ====================================================================================================
    

    public function SalesOrder(){
        $all = Pos_Orders::all();
        return view('pos.sales-order', compact('all'));
    }

    public function getname($id){
        $cust = Customer::where('id',$id)->get();
        return response()->json($cust);
    }

    public function EnterData(){
        // $new = Pos_Orders::where('user_id',Auth::user()->id)->get();
        // return response()->json($new);
    }

    public function destroy2($id){
        $delete = Pos_Orders::destroy('delete from order where id = ?',[$id]);
        return redirect()->back()->with("Record deleted successfully");
    }

    public function profile(){
        return view("pos.profile");
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
   }
}