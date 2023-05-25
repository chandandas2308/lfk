<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PosCustomer extends Controller
{
    //
    public function allCustomers()
    {
        $data = Customer::where('is_pos', 1)->get();

        $new_data=[];

        // dd(request()->status);

        $order_number = request()->status;

        $i = 0;
        $action = "";
        foreach($data as $item){       
            $action .= '<a href="javascript:void(0)" id="viewCustomerDetails" data-url="/pos/viewcustomer/'.$item->id.'">';
            $action .= '<i class="bi bi-eye"></i>';
            $action .= '</a>';
            $action .= '<a href ="javascript:void(0)" id="updateCustomerDetails" data-url="/pos/editcustomer/'.$item->id.'"  class="ms-1 me-1"><i class="bi bi-pencil-fill text-success"></i></a>';
            $action .= '<a href="javascript:void(0)" id="removeCustomer" data-id="'.$item->id.'" ><i class="bi bi-trash text-danger mx-auto"></i></a>';
            if($order_number != "false"){
                $action .= "<a href='".route("Pos-ContinueSalesSession",['id'=>$item->id, 'order_number'=>$order_number])."' disabled><i class='bi bi-plus' style='font-size: 20px; font-weight: bolder;'></i></a>";
            }

            $new_data[] = array(
                ++$i,
                $item->customer_name,
                $item->email_id,
                $item->mobile_number,
                $item->address,
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

    public function editcustomer($id){
        $data = Customer::where('id',$id)->get();
        // dd($data);
        return view('pos.update-customer')->with('data', $data);
    }

    // update customer
    public function update(Request $request)
    {
        Customer::where('id', request()->id)->update([
            'customer_name' => request()->customer_name,
            'address' => request()->address,
            'phone_number' => request()->phone_number,
            'mobile_number' => request()->mobile_number,
            'email_id' => request()->email_id,
            'dob' => request()->dob,
            'postal_code' => request()->postcode,
            'unit_number' => request()->unitCode
        ]);

        return response()->json([
            "success"=>"Details Updated"
        ]);
    }

    public function viewcustomer($id)
    {
        $data = Customer::where('id',$id)->get();
        // dd($data);
        return view('pos.view-customer')->with('data', $data);
    }

    // delete customer
    public function delete($id)
    {
        try {       
            Customer::where('id',$id)->delete();
            return response()->json(["status"=>true,"success"=>"Customer Details Removed"]);
        } catch (\Throwable $th) {
            return response()->json(["status"=>false,"error"=>$th->getMessage()]);
        }
    }

}
