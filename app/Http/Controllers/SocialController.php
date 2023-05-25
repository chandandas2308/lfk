<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Customer;
use App\Models\LoyaltyPointshop;
use App\Models\SignInSetting;
use Validator;
use Exception;
use Illuminate\Support\Facades\Redirect;

class SocialController extends Controller
{
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function loginWithFacebook()
    {
        try {
            $user = Socialite::driver('facebook')->stateless()->user();
            $existingUser = User::where('fb_id', $user->id)->first();

            if ($existingUser) {
                $status = Auth::login($existingUser);
                return redirect()->intended('/');
                
                // return Redirect::to('/');
            } else {

                $createUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'fb_id' => $user->id,
                    'is_admin' => '0',
                ]);

                Customer::create([
                    'customer_id' => $createUser->id,
                    'customer_name' => $user->name,
                    'email_id' => $user->email,
                    'fb_id' => $user->id,
                    'customer_type' => 'retail',
                ]);
                
                $points = SignInSetting::first();

                if(!empty($points)){
                    $earn_points = $points->points;
                }else{
                    $earn_points = 0;
                }

                LoyaltyPointshop::create([
                    'user_id' => $createUser->id,
                    'loyalty_points' => $earn_points,
                    'last_transaction_id' => 1
                ]);

                $status = Auth::login($createUser);
                
                
                return Redirect::to('/');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function index_redirect(){
        return Redirect::to('/');
    }
}
