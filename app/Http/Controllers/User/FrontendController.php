<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\BlogVideo;
use App\Models\cart;
use App\Models\UserOrder;
use App\Models\address;
use App\Models\Category;
use App\Models\CheckInSetting;
use App\Models\Notification;
use App\Models\MultiImage;
use App\Models\Customer;
use App\Models\DailyCheckInCoins;
use App\Models\LoyaltyPointTodays;
use App\Models\product;
use App\Models\ProductRedemptionShop;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Wishlist;
use App\Models\VoucherCode;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App;
use App\Models\LoyaltyPoint;
use App\Models\LoyaltyPointshop;
use App\Models\SignInSetting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App as FacadesApp;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as RulesPassword;

use function PHPUnit\Framework\isEmpty;

class FrontendController extends Controller
{
    public function __construct()
    {
        // $products = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id')
        //         ->select('stocks.*','products.id as main_product_id','products.img_path','products.product_category','products.chinese_product_name as product_name_c', 'products.category_id', 'products.min_sale_price','products.discount_percentage','products.discount_price','products.discount_start_date','products.discount_end_date', DB::raw('sum(stocks.quantity) as total_quantity'))
        //         ->where('stocks.quantity', '>=', 0)
        //         ->groupBy('stocks.product_id')
        //         ->get();

        $products = DB::table('products')
                ->select('products.*','products.stock_check','products.id as product_id','products.id as main_product_id','products.img_path','products.product_category','products.chinese_product_name as product_name_c', 'products.category_id', 'products.min_sale_price','products.discount_percentage','products.discount_price','products.discount_start_date','products.discount_end_date', DB::raw('sum(products.discount_end_date) as total_quantity'))
                ->groupBy('products.id')
                ->get();

                // dd($products);

        // $feature_products = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id')
        //         ->select('stocks.*','products.id as main_product_id','products.img_path','products.product_category','products.category_id','products.chinese_product_name as product_name_c', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'),'products.discount_price','products.discount_percentage','products.discount_start_date','products.discount_end_date')
        //         ->where('stocks.quantity', '>=', 0)
        //         ->where('products.featured_product', 1)
        //         ->groupBy('stocks.product_id')
        //         ->get();

        $feature_products = DB::table('products')
                ->select('products.*','products.id as product_id','products.id as main_product_id','products.img_path','products.product_category','products.category_id','products.chinese_product_name as product_name_c', 'products.min_sale_price', DB::raw('sum(products.min_sale_price) as total_quantity'),'products.discount_price','products.discount_percentage','products.discount_start_date','products.discount_end_date','products.stock_check')
                ->where('products.featured_product', 1)
                ->get();
        

        $categories = Category::all();

        // dd($categories);

        $carts = cart::all();
        $banners = Banner::whereIn('type',[0,1,3])->where('status', 'Active')->get();
        // dd($banners);
        $notifications = Notification::all();

        View::share('products', $products);
        View::share('feature_products', $feature_products);
        View::share('categories', $categories);
        View::share('carts', $carts);
        View::share('banners', $banners);
        View::share('notifications', $notifications);
    }

    public function index()
    {
        return view('frontend.index');
    }

    public function searchProducts(Request $request)
    {
        
        return redirect('/search/product/'.$request->search);

        // return view('frontend.search', ['data' => $data]);
    }

    public function searchProductsPage($search)
    {

        // dd($search);
        $data = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id');
        if(app()->getLocale() == 'en')
        {
            $data->select('products.product_name','stocks.id','products.img_path', 'products.min_sale_price', 'stocks.product_id', DB::raw('sum(stocks.quantity) as total_quantity'));
        }
        else
        {
            $data->select('products.chinese_product_name as product_name','stocks.id','products.img_path', 'stocks.product_id', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'));
        }
            $data = $data->where('stocks.quantity', '>', 0)
                    ->where('products.product_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('products.chinese_product_name', 'LIKE', '%' . $search . '%')
                    ->groupBy('stocks.product_id')
                    ->paginate(10);

        return view('frontend.search', ['data' => $data]);
    }

    public function contact()
    {

        return view('frontend.contact');
    }

    public function addWishlist()
    {
        $wishlistItems = Wishlist::join('products', 'products.id', '=', 'wishlists.product_id')->get(["products.product_name", "products.img_path", "products.min_sale_price"]);

        return view('frontend.wishlist',[
            'wishlistItems' => $wishlistItems,

        ]);
    }

    public function about()
    {
        return view('frontend.about');
    }

    
   

    public function privacyPolicy()
    {
        return view('frontend.privacy-policy');
    }

    public function termsConditions()
    {
        return view('frontend.terms-conditions');
    }

    public function returnRefund()
    {
        return view('frontend.return-refund');
    }
    public function faq()
    {
        return view('frontend.faq');
    }

    public function dataProtectionPolicy()
    {
        return view('frontend.data-protection-policy');
    }

    public function blog(Request $request)
    {
        $allBlogs = DB::table('blogs')->orderBy('id','desc')->get();
        
        foreach($allBlogs as $blog){
            $blog->status = 0;
        }
        
        $videoBlogs = DB::table('blog_videos')->orderBy('id','desc')->get();
        
        foreach($videoBlogs as $vblog){
            $vblog->status = 1;
        }

        $merged = $allBlogs->merge($videoBlogs);

        $sorted = array($merged->sortByDesc('created_at'));

        $arr = $sorted[0];

        $data = $this->paginate($arr);
        $data->withPath('blogs-list');

        $recentBlog = Blog::whereDate('created_at', Carbon::today())->orderBy('id','desc')->take(4)->get();

        return View::make('frontend.blog', compact('sorted'))->with('success', 'Account successfully updated')->with('sorted', $data);

        // return view('frontend.blog', [
        //     "blogs" => $allBlogs,
        //     "vBlogs" => $videoBlogs,
        //     "sorted" => $data,
        //     "recentBlogs" => $recentBlog,
        // ]);
    }

    public function single_blog($slug)
    {
        // return view('frontend.single_blog');
        $blog = Blog::where('slug', $slug)->first();
        $recentBlog = Blog::whereDate('created_at', Carbon::today())->get();



        $categories = Category::all()->take(5);

        return view('frontend.single_blog', [
            "blog" => $blog,
            "recentBlog" => $recentBlog,
            "allCategories" => $categories
        ]);
    }
    public function single_blogVideo($slug)
    {
        // return view('frontend.single_blog');

        $blogVideo = BlogVideo::where('slug', $slug)->first();
        $recentBlogVideo = BlogVideo::whereDate('created_at', Carbon::today())->get();


        $categories = Category::all()->take(5);

        return view('frontend.single_videoBlog', [
            "blogVideo" => $blogVideo,
            "recentBlogVideo" => $recentBlogVideo,
            "allCategories" => $categories
        ]);
    }

    public function shop()
    {
        return view('frontend.shop');
    }

    // redirect email and phone login
    public function pelogin()
    {
        return view('frontend.PE_login');
    }
    public function register()
    {
        return view('frontend.register');
    }

    public function login()
    {
        return view('frontend.login');
    }

    public function forgot_password()
    {
        return view('frontend.forgot_password');
    }


    public function registerUs(Request $request)
    {
        try {
            // $data = $request->validate(
            $validator = Validator::make($request->all(),
                [
                    'firstName' => 'required',
                    'lastName'  => 'required',
                    'email'     => 'required|email|unique:users',
                    // 'password'  => 'required|min:8|confirmed',
                    'password' => [
                        'required',
                        'confirmed',
                        RulesPassword::min(6)
                            ->mixedCase()
                            ->letters()
                            ->numbers()
                            ->symbols()
                            // ->uncompromised(),
                    ],
                    'phoneNumber' =>'required',
                    'dob' =>'required|date',
                    // 'month' =>'required',
                    // 'day' =>'required',
                    // 'year' =>'required',
                    'gender' =>'required',
                    'postalCode' =>'required',
                    'address' =>'required',
                    'unitNumberName' =>'required',
                ],
                [
                    'email' => 'Email ID is already registered',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->getMessageBag()->toArray());
            }

        $data = $request->validate(
            [
                'firstName' => 'required',
                'lastName'  => 'required',
                'email'     => 'required|email|unique:users',
                // 'password'  => 'required|min:8|confirmed',
                'password' => [
                    'required',
                    'confirmed',
                    RulesPassword::min(8)
                        ->mixedCase()
                        ->letters()
                        ->numbers()
                        ->symbols()
                        // ->uncompromised(),
                ],
                'phoneNumber' =>'required',
                'dob' =>'required|date',
                // 'month' =>'required',
                // 'day' =>'required',
                // 'year' =>'required',
                'gender' =>'required',
                'postalCode' =>'required',
                'address' =>'required',
                'unitNumberName' =>'required',
            ],
        );

            $user = User::create([
                'is_admin' => '0',
                'name' => $data['firstName'] . ' ' . $data['lastName'],
                'phone_number' => $data['phoneNumber'],
                'month' => explode('-',$request->dob)[1],
                'day' => explode('-',$request->dob)[0],
                'year' => explode('-',$request->dob)[2],
                'gender' => $data['gender'],
                'email' => $data['email'],
                'postal_code' => $data['postalCode'],
                'address' => $data['address'],
                'unit_number' => $data['unitNumberName'],
                'password' => Hash::make($data['password']),
            ]);

            $points = SignInSetting::first();

            if(!empty($points)){
                $earn_points = $points->points;
            }else{
                $earn_points = 0;
            }

            LoyaltyPointshop::create([
                'user_id' => $user->id,
                'loyalty_points' => $earn_points,
                'last_transaction_id' => 1,
            ]);
            
            LoyaltyPoint::create([
                'user_id' => $user->id,
                'gained_points' => $earn_points,
                'spend_points' => 0,
                'remains_points' => $earn_points,
                'transaction_id' => 1,
                'transaction_amount' => 0,
                'transaction_date' => now(),
                'log' => 'Register'
            ]);

            Customer::create([
                'customer_name' => $data['firstName'] . ' ' . $data['lastName'],
                'address' => 'null',
                'customer_type' => 'retail',
                'mobile_number' => 0,
                'phone_number' => $data['phoneNumber'],
                'month' => explode('-',$request->dob)[1],
                'day' => explode('-',$request->dob)[0],
                'year' => explode('-',$request->dob)[2],
                'gender' => $data['gender'],
                'email_id' => $data['email'],
                'postal_code' => $data['postalCode'],
                'address' => $data['address'],
                'unit_number' => $data['unitNumberName'],
                'customer_id' => $user->id,
            ]);

            // return view('frontend.login')->with('success', 'Details Registered Successfully.');
            return redirect()->route('login-with-us1')->with('success', 'Details Registered Successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function allProducts()
    {
        return view('frontend.shop_sidebar');
    }

    public function paginate($items, $perPage = 8, $page = null, $options = [])
    {

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

    }

    public function allBuyNowPageProducts(Request $request)
    {
        // $products = DB::table('stocks')->leftJoin('products', 'products.id', '=', 'stocks.product_id');
        $products = DB::table('products');
        if(app()->getLocale() == 'en')
        {
            $products->select('products.stock_check','products.id as product_id','products.product_name','products.id','products.img_path', 'products.min_sale_price','products.discount_price','products.discount_percentage','products.discount_start_date','products.discount_end_date', DB::raw('sum(products.discount_end_date) as total_quantity'));
        }
        else{
            $products->select('products.stock_check','products.id as product_id','products.chinese_product_name as product_name','products.id','products.img_path', 'products.min_sale_price','products.discount_price','products.discount_percentage','products.discount_start_date','products.discount_end_date', DB::raw('sum(products.discount_end_date) as total_quantity'));
        }
        $products = $products->groupBy('id')->orderBy('id','desc')->paginate(12);
        
        return response()->json($products);
    }

    // single product via id
    public function singleProductViaId($id)
    {
        $category_id = product::where('id', $id)->first();

        if($category_id){
            $category = Category::find($category_id->category_id);

            // show product name
            if(app()->getLocale() == 'en'){
                $product_name  = $category_id->product_name;
            }else{
                $product_name  = $category_id->chinese_product_name;
            }


            if($category != null){
                if(app()->getLocale() == 'en'){
                    $category_name = $category->name;
                    $product_name  = $category_id->product_name;
                }else{
                    $category_name = $category->chinese_name;
                    $product_name  = $category_id->chinese_product_name;
                }
            }else{
                $category_name = '';
            }

            $products = product::where('id',$id)->get();

            return view('frontend.single_product', [
                'category_name' => $category_name, 
                'product_name'  => $product_name,
                'data'          => $products,
            ]);
        }
        return redirect()->back()->with('back_message','Product Not Found'); 

    }

    // category wise products
    public function categoryWiseProduct(Request $request)
    {

        $products = DB::table('products');
        if(app()->getLocale() == 'en')
        {
            $products->select('products.stock_check','products.id as product_id','products.product_name','products.id','products.img_path', 'products.min_sale_price','products.discount_price','products.discount_percentage','products.discount_start_date','products.discount_end_date', DB::raw('sum(products.discount_end_date) as total_quantity'));
        }
        else{
            $products->select('products.stock_check','products.id as product_id','products.chinese_product_name as product_name','products.id','products.img_path', 'products.min_sale_price','products.discount_price','products.discount_percentage','products.discount_start_date','products.discount_end_date', DB::raw('sum(products.discount_end_date) as total_quantity'));
        }
        $products = $products->where('products.product_category', request()->id)->groupBy('id')->orderBy('id','desc')->paginate(12);
        
        return response()->json($products);


        // $products = DB::table('stocks')->leftJoin('products', 'products.id', '=', 'stocks.product_id');
        // if(app()->getLocale() == 'en')
        // {
        //     $products->select('stocks.product_id','products.product_name','products.id','products.img_path', 'products.min_sale_price','products.discount_price','products.discount_percentage','products.discount_start_date','products.discount_end_date', DB::raw('sum(stocks.quantity) as total_quantity'));
        // }
        // else{
        //     $products->select('stocks.product_id','products.chinese_product_name as product_name','products.id','products.img_path', 'products.min_sale_price','products.discount_price','products.discount_percentage','products.discount_start_date','products.discount_end_date', DB::raw('sum(stocks.quantity) as total_quantity'));
        // }
        // $products = $products->where('stocks.quantity', '>=', 0)
        // ->where('products.product_category', request()->id)
        // ->groupBy('stocks.product_id')->paginate(12);
        
        // return response()->json($products);


        // $data = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id');
        // if(app()->getLocale() == 'en'){
        //      $data->select('stocks.product_id','products.product_name','stocks.id','products.img_path', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'));
        // }else{
        //      $data->select('stocks.product_id','products.chinese_product_name as product_name','stocks.id','products.img_path', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'));
        // }
        // $data = $data->where('stocks.quantity', '>=', 0)
        // ->where('products.product_category', $_GET['id'])
        // ->groupBy('stocks.product_id')
        // ->paginate(12);

        // return $data;
    }

    // get products via price range
    public function productsViaPriceRange(Request $request)
    {

        $products = DB::table('products');
        if(app()->getLocale() == 'en')
        {
            $products->select('products.stock_check','products.id as product_id','products.product_name','products.id','products.img_path', 'products.min_sale_price','products.discount_price','products.discount_percentage','products.discount_start_date','products.discount_end_date', DB::raw('sum(products.discount_end_date) as total_quantity'));
        }
        else{
            $products->select('products.stock_check','products.id as product_id','products.chinese_product_name as product_name','products.id','products.img_path', 'products.min_sale_price','products.discount_price','products.discount_percentage','products.discount_start_date','products.discount_end_date', DB::raw('sum(products.discount_end_date) as total_quantity'));
        }
        $products = $products->whereBetween('products.min_sale_price', [(int)$_GET['minValue'], (int)$_GET['maxValue']])->groupBy('id')->orderBy('id','desc')->paginate(12);
        
        return response()->json($products);


        // $data = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id');
        // if(app()->getLocale() == 'en'){
        //     $data->select('stocks.product_id','products.product_name','stocks.id','products.img_path', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'));
        // }
        // else{
        //     $data->select('stocks.product_id','products.chinese_product_name as product_name','stocks.id','products.img_path', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'));
        // }
        // $data = $data->where('stocks.quantity', '>=', 0)
        // ->whereBetween('products.min_sale_price', [(int)$_GET['minValue'], (int)$_GET['maxValue']])
        // ->groupBy('stocks.product_id')
        // ->paginate(12);
        // return response()->json($data);
    }

    // Rewards coins page
    function checkInRewards(){
        $data = CheckInSetting::first();
        $user = LoyaltyPointshop::where('user_id', Auth::user()->id)->first();
        $vouchers = Voucher::get();
        $redemption_products = ProductRedemptionShop::where('quantity','>',0)->get();

        if(Auth::check()){
            $coins = DailyCheckInCoins::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->first();
        }else{
            $coins = [];
        }

        if(!empty($coins)){
            $days = now()->diffInDays($coins->created_at);

            if($days == 0)
            {
                $day = $coins->day;
                $status = false;
            }
            else if($days == 1)
            {
                $day = $coins->day+1;
                $status = true;
            }
            else
            {
                $day = 1;
                $status = true;
            }
        
            // dd($status);

        }else{
            $day = 1;
            $status = true;
        }

        $date = Carbon::now();

        // $voucherDetails = DB::select('SELECT vouchers.*, voucher_codes.voucher_id,voucher_codes.status,voucher_codes.code FROM vouchers LEFT OUTER JOIN voucher_codes ON vouchers.id=voucher_codes.voucher_id WHERE vouchers.expiry_date >= "'.$date->toDateString().'"');

        // dd($voucherDetails);

        // "voucherDetails"=>$voucherDetails,
        return view('frontend.coinrewardpage', [
            "date"=>$date, 
            "data"=>$data, 
            "day"=>$day, 
            "status"=>$status, 
            "vouchers"=>$vouchers, 
            "redemption_products"=>$redemption_products, 
            "user"=>$user]);
    }

    // check-in now
    function checkInNow(){
        $user_id = Auth::user()->id;
        $coins = CheckInSetting::first();
        $data = DailyCheckInCoins::orderBy('id', 'desc')->where('user_id', $user_id)->first();

        // dd(now(),$data->created_at);
        if(!empty($data)){
            $days = now()->diffInDays($data->created_at);
            // dd('difference', $days);
            if($days > 1){
                $day = 1;
            }else if($days == 0){
                return redirect()->back()->with('success','Come back tomorrow to earn points');
            }else{
                if($data->day == 7 || $data->day >= 8){
                    $day = 1;
                }else{
                    $day = $data->day+1;
                }
            }
        }else{
            $day = 1;
        }

        // dd($day+1);

        switch($day){
            case 1 :
                $points = $coins->day1;
                break;
            case 2 :
                $points = $coins->day2;
                break;
            case 3 :
                $points = $coins->day3;
                break;
            case 4 :
                $points = $coins->day4;
                break;
            case 5 :
                $points = $coins->day5;
                break;                
            case 6 :
                $points = $coins->day6;
                break;
            case 7 :
                $points = $coins->day7;
                break;
            default :
                $points = $coins->day1;
        }

        $walletPoint = LoyaltyPointshop::where('user_id',Auth::user()->id)->first();

        if($walletPoint != null){
            $havingPoints = $walletPoint->loyalty_points;
        }else{
            $havingPoints = 0;
        }
        
        LoyaltyPointshop::updateOrCreate(
            ['user_id' => Auth::user()->id],
            [
                'user_id' => Auth::user()->id,
                'loyalty_points' => (int)$points+(int)$havingPoints,
                'last_transaction_id' => 1
            ]
        );

        LoyaltyPoint::create([
            'user_id' => Auth::user()->id,
            'gained_points' => $points,
            'spend_points' => 0,
            'remains_points' => (int)$points+(int)$havingPoints,
            'transaction_id' => 1,
            'transaction_amount' => 0,
            'transaction_date' => now(),
            'log'   => 'Daily Check In'
        ]);

        DailyCheckInCoins::create([
            "user_id" => $user_id,
            "day" => $day,
            "points" => $points
        ]);

        return redirect()->back()->with('success','You have earned '.$points.' Points');

    }

    // language
    public function change(Request $request)
    {
        FacadesApp::setLocale($request->lang);
        session()->put('locale', $request->lang);
        return redirect()->back();
    }


    public function check_all_product_details(){
        product::where('discount_end_date','<=',date('Y-m-d'))->update([
            'discount_price'        => null,
            'discount_name'         => null,
            'discount_type'         => null,
            'discount_face_value'   => null,
            'discount_start_date'   => null,
            'discount_end_date'     => null,
            'discount_percentage'   => null
        ]);
    }


}