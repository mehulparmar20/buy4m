<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $data= Country::where('status','1')->get();
        return view('admin.country.index',compact('data'));
    }
    public function create(Request $request)
    {
        return view('admin.country.store');
    }
    public function store(Request $request)
    {
        $files=$request->file('flag');
        if($files !="" || $files !=null)
        {
            $name =  time().rand(1,100).'.'.$files->getClientOriginalName();
            $filePath=$files->move(public_path() . '/upload/country_flag/', $name);
        }
        $data= new Country();
        $data->name=$request->name;
        $data->flag=$name;
        $data->save();
        return back()->with("success");
    }
    public function fatch_country(Request $request)
    {
        // $value=$request->value;
        // $data=Country::where('name','LIKE', '%'.$value.'%')->get();
        $data=Country::where('status','1')->orderBy('name','ASC')->get();
        $opt="<option selected disabled>Country</option>";
        foreach($data as $row)
        {
            $opt.="<option data-name='".$row->name."' value=".$row->id." >".$row->name."</option>";
            // echo $opt;
            // dd($opt);
           
        }
        echo $opt;
    }
    public function delete_country(Request $request)
    {
        $id=$request->id;
        $data=Country::findOrFail($id);
        $data->status='0';
        $data->save();
        // $data=Country::where('id',$id)->delete();
        return back()->with("success","deleted");
    }
}
