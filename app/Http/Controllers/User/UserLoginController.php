<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserLoginController extends Controller
{
    //

    public function login(Request $request)
    {

        $rules = array(
            'email' => 'required',
            'password' => 'required'
        );

        $validator = Validator::make([
            "email" => $request->email,
            "password" => $request->password,
        ], $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {
            $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';
            $userdata = array(
                $fieldType => $request->email,
                'password' => $request->password
            );

            // attempt to do the login

            if (Auth::attempt($userdata)) {
                if (Auth::user()->is_admin == '0') {
                    return Redirect::route('Home');
                } else {
                    Auth::logout();

                    $request->session()->invalidate();

                    $request->session()->regenerateToken();
                    return Redirect::back()->with('error', 'Please enter valid credentials');
                }
            } else {
                return Redirect::back()->with('error', 'Please enter valid credentials');
            }
        }
    }

    public function logout(Request $request)
    {
        session::where('user_id', Auth::user()->id)->delete();

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return Redirect::route('login-with-us1')->with('success', 'Successfully logged out');
    }
}
