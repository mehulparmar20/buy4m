<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\Country;
use App\Models\Trip;
use App\Models\State;
use App\Models\MatchedTripOrder;
use App\Models\Shop;
use App\Models\Tax;
use Auth;
use Goutte\Client;
use App\Models\TravellerOffer;
use Illuminate\Support\Str;
class OrderController extends Controller
{
    public function index(Request $request)
    {
        $data=OrderDetail::all();
        return view('admin.orders.index',compact('data'));
    }
    public function order_details(Request $request)
    {
        $id= $request->id;
        $data=OrderDetail::where('order_details.id',$id)
                ->leftJoin('countries as coun1','coun1.id','order_details.deliver_from_country')
                ->leftJoin('countries as coun2','coun2.id','order_details.deliver_to_country')
                ->leftJoin('states as states1','states1.id','order_details.deliver_from_state')
                ->leftJoin('states as states2','states2.id','order_details.deliver_to_state')
                ->select('order_details.*','coun1.name as fromCountry','coun2.name as toCountry','states1.city_name as fromCity','states2.city_name as toCIty')
                ->first(); 
        $from="from_order";
        $TravellerOffer=TravellerOffer::where('traveller_offers.order_id',$id)
                        ->join('trips','trips.id','traveller_offers.trip_id')
                        ->leftJoin('users','users.id','trips.user_id')
                        ->select('trips.id as trip_id','traveller_offers.*','users.first_name','users.last_name','users.id as user_id')->get();
                        // dd($TravellerOffer);
        return view('frontend.user.order_details',compact('data','from','TravellerOffer'));  
    }
    public function order_product(Request $request)
    {	
        $user=Auth::User();
        $user_id=$user->id;
        $data="";
        if($request->from=="request")
        {
            $getOrder=OrderDetail::findOrFail($request->id);
            // dd($getOrder);
            $data=new OrderDetail();
            $data->user_id=Auth::user()->id;
            $data->product_name=$getOrder->product_name;
            $data->product_url=$getOrder->product_url;
            $data->product_price=$getOrder->product_price;
            $data->product_imgs=$getOrder->product_imgs;
            $data->img_path=$getOrder->img_path;
            $data->product_qty=$request->product_qty;
            $data->product_details=$getOrder->product_details;
            $data->box=$getOrder->box;
            $data->information=$getOrder->information;
            $data->us_sale_tax=$getOrder->us_sale_tax;
            $data->traveller_reward=$getOrder->traveller_reward;
            $data->buy4me_fee=$getOrder->buy4me_fee;
            $data->payment=$getOrder->payment;
            $data->payment_id=$getOrder->payment_id;
            $data->order_status=$getOrder->order_status;
            $data->deliver_from_country=$getOrder->deliver_from_country;
            $data->deliver_to_country=$getOrder->deliver_to_country;
            $data->deliver_from_state=$getOrder->deliver_from_state;
            $data->deliver_to_state=$getOrder->deliver_to_state;
            $data->during_time=$getOrder->during_time;
            $data->estimated_total=$getOrder->estimated_total;
            $data->upc=$getOrder->upc;
            $data->save();
            $or_id=OrderDetail::latest()->first();
            $oid=$or_id->id;
            return  redirect("order_details/".$oid)->withSuccess("Data updated successfully");
           
        }
        $curDate=strtotime(date('y-m-d'));
        $during_d=$request->during_time;
        if($during_d=='up_one_month')
        {
            $d= date("Y-m-d", strtotime("+1 month", $curDate));
        }
        elseif($during_d=='up_3_week')
        {
            $d= date("Y-m-d", strtotime("+3 week", $curDate));
        }
        elseif($during_d=='up_2_week')
        {
            $d= date("Y-m-d", strtotime("+2 week", $curDate));
        }
        elseif($during_d=='up_2_months')
        {
            $d= date("Y-m-d", strtotime("+2 month", $curDate));
        }
        else
        {
            $d=date('y-m-d');
        }
        $files=$request->file('file');
        $data=array();
        foreach($files as $file)
        {
            $name =  time().rand(1,100).'.'.$file->getClientOriginalName();
            $filePath=$file->move(public_path() . '/upload/product_img/', $name);
            $data[] = $name;
        }
        $filePathar=$filePath;
        $data=json_encode($data);
        $data=str_ireplace(['"',' ;']," ",$data);
       
        $OrdersDetail= new OrderDetail();
        $OrdersDetail->user_id=$user_id;
        $OrdersDetail->product_name=$request->product_name;
        $OrdersDetail->product_url=$request->product_link;
        $OrdersDetail->product_price=$request->product_price;
        $OrdersDetail->product_imgs=$data;
        $OrdersDetail->img_path=$filePathar;
        if($request->product_qty<=0)
        {
            $OrdersDetail->product_qty=1;
        }
        else
        {
            $OrdersDetail->product_qty=$request->product_qty;
        }
        $OrdersDetail->product_details=$request->product_details;
        $OrdersDetail->box=$request->box;
        $OrdersDetail->traveller_reward=$request->summery_traveler_reward;
        $OrdersDetail->buy4me_fee=$request->summery_buy4me_fee;
        $OrdersDetail->payment=$request->summery_payment_processing;
        $OrdersDetail->estimated_total=$request->summery_estimated_total;
        $OrdersDetail->order_status=1;
        $OrdersDetail->deliver_from_country=$request->devliver_from_country;
        $OrdersDetail->deliver_to_country=$request->devliver_to_country;
        $OrdersDetail->deliver_to_state=$request->devliver_to_city;
        $OrdersDetail->during_time=$d;
        $OrdersDetail->save();
        $or_id=OrderDetail::latest()->first();
        $oid=$or_id->id;
        $or_user=Auth::user()->id;
        $trip_de=Trip::where('from_location_country',$request->devliver_from_country)->where('to_location_country',$request->devliver_to_country)->where('to_location_state',$request->devliver_to_city)->where('travel_date' ,'<',$d)->get();
        foreach($trip_de as $r)
        {
            if($or_user != $r->user_id)
            {
                $MatchedTripOrder=new MatchedTripOrder();
                $MatchedTripOrder->trip_id=$r->id;
                $MatchedTripOrder->order_id=$oid;
                $MatchedTripOrder->trip_user=$r->user_id;
                $MatchedTripOrder->order_user=$or_user;
                $MatchedTripOrder->save();
            }
           
        }
        $response=array("status"=>200,"msg"=>"Order created succesfully",'id'=>$oid);
        return $response;
    }
    public function order_cancle(Request $request)
    {
        $status=$request->status;
        $id=$request->id;
        $curDate=strtotime(date('y-m-d'));
        $d= date("Y-m-d", strtotime("+1 month", $curDate));
        if($status=='delete')
        {
            $data=OrderDetail::where('id',$id)->delete();            
        }
        else
        {
            $data=OrderDetail::findOrFail($id);
            if($status=='publish')
            {
                $data->order_status=1;
                $data->during_time=$d;
            }
            elseif($status=='cancle')
            {
                $data->order_status=4;
            }
            $data->save();
        }
       
        return redirect()->route('user.orders')->withSuccess("Product status changed successfully");
    }
    public function edit_order(Request $request)
    {
        $id=$request->id;
        $data=OrderDetail::findOrFail($id);
        $country=Country::all();
        $state=State::where('country_id',$data->deliver_from_country)->get();
        $state_to=State::where('country_id',$data->deliver_to_country)->get();
        return view('frontend.user.edit_order',compact('data','country','state','state_to')); 
    }
    public function update_order(Request $request)
    {
        $id=$request->id;
        $files=$request->file('product_img');
        $data=array();
        if($request->box==null)
        {
            $request->box='0';
        }
        $estimated_total=$request->product_price+30;
        if($files == !null)
        {
            foreach($files as $file)
            {
                $name =  time().rand(1,100).'.'.$file->getClientOriginalName();
                $filePath=$file->move(public_path() . '/upload/product_img/', $name);
                $data[] = $name;
            }
            $filePathar=$filePath;
            $data=json_encode($data);
            $data=str_ireplace(['"',' ;']," ",$data);
        }
        $d=date("Y-m-d", strtotime($request->during_date));
        $OrderDetail=OrderDetail::findOrFail($id);
        $OrderDetail->product_name=$request->product_name;
        $OrderDetail->product_price=$request->product_price;
        if($files != null)
        {
            $OrderDetail->product_imgs=$data;
            $OrderDetail->img_path=$filePathar;
        }
        $OrderDetail->product_qty=$request->product_qty;
        $OrderDetail->product_details=$request->product_details;
        $OrderDetail->box=$request->box;
        $OrderDetail->order_status=1;
        $OrderDetail->deliver_from_country=$request->deliver_from;
        $OrderDetail->deliver_to_country=$request->deliver_to;
        // $OrderDetail->deliver_from_state=$request->deliver_fromOrderCity;
        $OrderDetail->deliver_to_state=$request->deliver_toOrderCity;
        $OrderDetail->during_time=$d;
        $OrderDetail->save();
        $or_user=$OrderDetail->user_id;
        $trip_de=Trip::where('from_location_country',$request->devliver_from_country)->where('to_location_country',$request->devliver_to_country)->where('to_location_state',$request->devliver_to_city)->where('travel_date' ,'<',$d)->get();
        foreach($trip_de as $r)
        {
            if($or_user != $r->user_id)
            {
                $MatchedTripOrder=new MatchedTripOrder();
                $MatchedTripOrder->trip_id=$r->id;
                $MatchedTripOrder->order_id=$oid;
                $MatchedTripOrder->trip_user=$r->user_id;
                $MatchedTripOrder->order_user=$or_user;
                $MatchedTripOrder->save();
            }
           
        }
        return redirect("order_details/".$id)->withSuccess("Data updated successfully");
    }
    public function create_order(Request $request)
    {
        $latestProduct=OrderDetail::orderBy('id','Desc')->take(8)->where('status','1')->get();
        $topShop=Shop::take(8)->where('status','1')->get();
        return view('frontend.user.create_order',compact('latestProduct','topShop'));  
    }
    public function product_details(Request $request)
    {
        $url=$request->url;
        $price="";
        $title=""; 
        $discription="";
        // $client = new Client();
        // $crawler = $client->request('GET', $url);
        // $title = $crawler->filter('body')->text();
        // //  dd($title);
        // $price = $crawler->filter('.a-price-whole')->text();
        // $discription=$crawler->filter('#feature-bullets')->text();
        // // return [
        // //     'title' => $title,
        // //     'price' => $price,
        // // ];
        $all_tax=Tax::first();
        return view('frontend.user.create_product',compact('all_tax','price','title','discription','url'));  
    }
    public function orders(Request $request)
    {
        $user_id=Auth::User()->id;
        $curDate=date('Y-m-d');
        $data=OrderDetail::where('order_details.user_id',"=",$user_id)
        ->leftJoin('countries as coun1','coun1.id','order_details.deliver_from_country')
                    ->leftJoin('countries as coun2','coun2.id','order_details.deliver_to_country')
                    ->leftJoin('states as states1','states1.id','order_details.deliver_from_state')
                    ->leftJoin('states as states2','states2.id','order_details.deliver_to_state')
                    ->orderBy('order_details.id','desc')
                    ->select('order_details.*','coun1.name as fromCountry','coun2.name as toCountry','states1.city_name as fromCity','states2.city_name as toCIty');
        $orderData=$data;
        $orderData=$orderData->get();
        $intrailcoun=$orderData;
        $receviedc=$orderData;
        $in=$orderData;
        // dd($curDate);s
        $inaCount= $data->Where('order_details.during_time','<',"$curDate")->count();
        
        $in=$in->where('order_status',4)->count();
        $inaCount=$inaCount+$in;
        $reCount= $orderData->where('order_status',1)->where('during_time','>',$curDate)->count();
        $intrailcoun= $intrailcoun->where('order_status',2)->where('during_time','>',$curDate)->count();
        $receviedc= $receviedc->where('order_status',3)->where('during_time','>',$curDate)->count();
        $data=$orderData;
        return view('frontend.user.orders',compact('data','inaCount','reCount','intrailcoun','receviedc'));  
    }
    public function matched_order(Request $request)
    {
        $id=$request->id;
        $data=MatchedTripOrder::where('matched_trip_orders.order_id',$id)->leftJoin('trips','trips.id','matched_trip_orders.trip_id')
        ->leftJoin('users','users.id','matched_trip_orders.trip_user')->leftJoin('order_details','order_details.id','matched_trip_orders.order_id')
        ->leftJoin('countries as coun1','coun1.id','order_details.deliver_from_country')
        ->leftJoin('countries as coun2','coun2.id','order_details.deliver_to_country')
        ->leftJoin('states as states1','states1.id','order_details.deliver_from_state')
        ->leftJoin('states as states2','states2.id','order_details.deliver_to_state')
        ->select('matched_trip_orders.id as ma_id','matched_trip_orders.trip_status','matched_trip_orders.order_status as orStatus','matched_trip_orders.order_id as o_id','order_details.*','users.first_name','users.last_name','users.email','users.mobile','coun1.name as fromCountry','coun2.name as toCountry','states1.city_name as fromcity','states2.city_name as toCity')->get();
        // dd($data);
        $from="from_order";
        return view('frontend.user.matched_trips',compact('data','from')); 
    }
    public function create_order2(Request $request)
    {
        $id=$request->id;
        $data=OrderDetail::findOrFail($id);
        $country=Country::all();
        $state=State::where('country_id',$data->deliver_from_country)->get();
        $state_to=State::where('country_id',$data->deliver_to_country)->get();
        return view('frontend.user.create_order2',compact('data','country','state','state_to')); 
    }
}
