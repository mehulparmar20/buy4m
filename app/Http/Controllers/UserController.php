<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Session;
class UserController extends Controller
{
    public function index(Request $request)
    {
        $userData=User::all();
        return view('admin.users.index',compact('userData'));
    }
    public function Create(Request $request)
    {
         return view('admin.users.store');
    }
    public function Store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$request->email,
        ]);
        // dd($request->first_name);
       $user=new User();
       $user->first_name=$request->first_name;
       $user->last_name=$request->last_name;
       $user->email=$request->email;
       $user->password=Hash::make($request->password);
       $user->mobile=$request->mobile;
       $user->save();
       if($user)
       {
            return redirect()->route('admin.user_index')->withSuccess('User Created Successfully');
       }
       return back()->withError('Something went wrong');
       
    }
    public function edit(Request $request)
    {
        $id=$request->id;
        // $request->session()->flash('status', 'Task was successful!');
        $user_data=User::findOrFail($id);
         
        return view('admin.users.edit',compact('user_data'))->with('success','Item created successfully!');
    }
    public function update(Request $request)
    {
       $id=$request->id;
       $user=User::findOrFail($id);
       $user->first_name=$request->first_name;
       $user->last_name=$request->last_name;
       $user->email=$request->email;
       $user->mobile=$request->mobile;
       $user->save();
        return redirect()->route('admin.user_index')->withSuccess('User Updated Successfully');
    }
    public function delete(Request $request)
    {
        $id=$request->id;
        $user=User::find($id)->delete();
        return back()->withSuccess('User Deleted Successfully');
    }
}
