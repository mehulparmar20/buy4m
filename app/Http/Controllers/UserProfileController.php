<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Trip;
use App\Models\OrderDetail;
use App\Models\MatchedTripOrder;
use App\Models\Country;
use App\Models\State;
use App\Models\Tax;
use App\Models\Shop;
use Illuminate\Support\Facades\Hash;
use Auth;
use Session;
use DB;
class UserProfileController extends Controller
{
    public function profile(Request $request)
    {
        $user_id=Auth::user()->id;
        $data=User::findOrFail($user_id);
        // $request->session()->flash('status', 'Task was successful!');
        return view('frontend.user.profile',compact('data'));
    }
  
    public function edit_profile_data(Request $request)
    {
        // dd($request->mobile);
        $id=Auth::user()->id;
        $files=$request->file('profile');
        if($files !="" || $files !=null)
        {
            $name =  time().rand(1,100).'.'.$files->getClientOriginalName();
            $filePath=$files->move(public_path() . '/upload/profile_img/', $name);
        }
       
        $profile_data=User::findOrFail($id);
        $profile_data->first_name=$request->first_name;
        $profile_data->last_name=$request->last_name;
        $profile_data->mobile=$request->mobile;
        $profile_data->email=$request->email;
        $profile_data->description=$request->description;
        if($files != "" || $files != null)
        {
            $profile_data->profile=$name;
        }
        $profile_data->save();
        $response=array("status"=>200,"msg"=>"Profile updated successfully");
       return $response;
    }
    public function help_desk(Request $request)
    {
        return view('frontend.user.help_center'); 
    }
    public function setting(Request $request)
    {
        $user_id=Auth::user()->id;
        $user_data=User::findOrFail($user_id);
        return view('frontend.user.settings',compact('user_data'));
    }
  
    
}
