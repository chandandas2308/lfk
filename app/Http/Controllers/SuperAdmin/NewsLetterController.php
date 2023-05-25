<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsLetter;
use DB;

class NewsLetterController extends Controller
{
    //

    public function index()
    {
        return view('superadmin.newsletter');
    }

    public function store(Request $request)
    {

        $status = NewsLetter::where('email', $request->email)->count();

        if($status > 0){
            return redirect()->back()->with(['error'=>'Already Subscribed Our NewsLetter!']);
        }else{

            NewsLetter::create([
                "email" => $request->email
            ]);
            return redirect()->back()->with(['success'=>'Sucessfully Subscribed Our NewsLetter!']);
        }
    }

    public function destroy()
    {
        NewsLetter::where("id", $_GET['id'])->delete();
        return response()->json(["success"=>"Info Deleted Successfully !"]);
    }

    public function allView()
    {
        return response()->json(DB::table('news_letters')->paginate(10));
    }

}
