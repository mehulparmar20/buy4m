<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class AdminController extends Controller
{
   public function index(Request $request)
   {
    if(Auth::guard('admin')->user() !=null)
    {
        return view('admin.index');
    }
    else
    {
        return redirect(route('adminLogin'));
    }
     
   }
}