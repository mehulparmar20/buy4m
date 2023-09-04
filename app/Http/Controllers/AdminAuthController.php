<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Admin;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests;
class AdminAuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('guest', ['except' => 'logout']);
    // }
    public function getLogin(Request $request)
    {
        // dd(Auth::guard('admin')->user());
        return view('admin.Auth.login');
    }
   public function postLogin(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $email = $request->email;
        $password = $request->password;
        $user = Admin::where('email',$email)->first();
        // dd($user);
        if($user !=null)
        {
            $pas_check= Hash::check($password, $user->password);
            if($pas_check==true)
            {
                if ($user) 
                {
                    $userModel = new Admin();
                    $userModel->id = $user->id;
                    $userModel->email = $user->email;
                    $userModel->password = $user->password;
                    $user = auth()->guard('admin')->login($userModel);
                }
                return redirect('/admin')->withSuccess("you are logged in successfully !");
            }
            else
            {
                return back()->withError('Something went wrong');
            }
        }
        else
        {
            return back()->withError('Something went wrong');
        }
       
    }
     /**
     * Show the application logout.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminLogout(Request $request)
    {
        auth()->guard('admin')->logout();
        Session::flush();
        Session::put('success', 'You are logout sucessfully');
        return redirect(route('adminLogin'));
    }
}
