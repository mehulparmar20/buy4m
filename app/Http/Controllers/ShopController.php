<?php

namespace App\Http\Controllers;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $data=Shop::orderBy('id','desc')->get();
        return view("admin.top_shops.index",compact('data'));
    }
    public function create(Request $request)
    { 	
        return view("admin.top_shops.create");
    }
    public function store(Request $request)
    {
        $brandimg=$request->file('brand_img');
        $logo=$request->file('logo');
        $b_name="";
        $l_name="";
        if($brandimg !="" || $brandimg !=null)
        {
            $b_name =  time().rand(1,100).'.'.$brandimg->getClientOriginalName();
            $filePath=$brandimg->move(public_path() . '/upload/top_shops/brand_img/', $b_name);
        }
        if($logo !="" || $logo !=null)
        {
            $l_name =  time().rand(1,100).'.'.$logo->getClientOriginalName();
            $filePath=$logo->move(public_path() . '/upload/top_shops/logo/', $l_name);
        }	
        $data= new Shop();
        $data->name=$request->name;
        $data->url=$request->url;
        $data->brand_img=$b_name;
        $data->logo=$l_name;
        $data->save();
        return redirect('/admin-index_topShop')->withSuccess("data stored successfully !");
    }
    public function edit(Request $request)
    {
        $id=$request->id;
        $data=Shop::findOrFail($id);
        return view("admin.top_shops.edit",compact('data'));
    }
    public function update(Request $request)
    {
        $id=$request->id;
        $brandimg=$request->file('brand_img');
        $logo=$request->file('logo');
        // $b_name="";
        // $l_name="";
        if($brandimg !="" || $brandimg !=null)
        {
            $b_name =  time().rand(1,100).'.'.$brandimg->getClientOriginalName();
            $filePath=$brandimg->move(public_path() . '/upload/top_shops/brand_img/', $b_name);
        }
        if($logo !="" || $logo !=null)
        {
            $l_name =  time().rand(1,100).'.'.$logo->getClientOriginalName();
            $filePath=$logo->move(public_path() . '/upload/top_shops/logo/', $l_name);
        }	
        $data= Shop::findOrFail($id);
        $data->name=$request->name;
        $data->url=$request->url;
        if($brandimg !="" || $brandimg!=null)
        {
            $data->brand_img=$b_name;
        }
        if($logo !="" || $logo!=null)
        {
            $data->logo=$l_name;
        }
        $data->save();
        return redirect('/admin-index_topShop')->withSuccess("data updated successfully !");
    }
    public function delete(Request $request)
    {
        $id=$request->id;
        $data=Shop::where('id',$id)->delete();
        return back()->withSuccess("data deleted successfully !");
    }
}
