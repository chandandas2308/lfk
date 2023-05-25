<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class ContactController extends Controller
{
    //

    public function index()
    {
        return view('superadmin.contacts');
    }

    public function store(Request $request)
    {
        Contact::create([
            'name'  => $request->name,
            "email" => $request->email,
            "mobile_no" => $request->mobile_no,
            "subject" => $request->subject,
            "message" => $request->message,
            "created_at" => now()
        ]);
        return redirect()->back()->with(['success'=>'Queries Sent Sucessfully!']);
    }

    public function destroy()
    {
        Contact::where("id", $_GET['id'])->delete();
        return response()->json(["success"=>"Contact Deleted Successfully !"]);
    }

    public function allView()
    {
        return response()->json(FacadesDB::table('contacts')->paginate(10));
    }
}
