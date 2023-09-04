<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\OrderDetail;
use App\Models\Country;
use Auth;
use DB;
use App\Models\MatchedTripOrder;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $TripData=Trip::join('users','users.id','trips.user_id')
        ->leftJoin('countries as coun1','coun1.id','trips.from_location_country')
        ->leftJoin('countries as coun2','coun2.id','trips.to_location_country')
        ->select('trips.*','coun1.name as fromCountry','coun2.name as toCountry')
        ->get();
        // dd($TripData);
        return view('admin.trips.index',compact('TripData'));
    }
    public function make_offer_html(Request $request)
    {
        $id=$request->id;
        $data=OrderDetail::leftJoin('countries as coun1','coun1.id','order_details.deliver_from_country')
        ->leftJoin('countries as coun2','coun2.id','order_details.deliver_to_country')
        ->leftJoin('states as states1','states1.id','order_details.deliver_from_state')
        ->leftJoin('states as states2','states2.id','order_details.deliver_to_state')
        ->orderBy('order_details.id','desc')
        ->where('order_details.deliver_to_country',$id)
        ->select('order_details.*','coun1.name as fromCountry','coun2.name as toCountry','states1.city_name as fromCity','states2.city_name as toCIty')->get();
        // dd($data);
        return view('frontend.travels.make_offer_html',compact('data'));
    }
    public function create_offer(Request $request)
    {
        $id=$request->id;
        $data=OrderDetail::where('order_details.id',$id)
        ->leftJoin('countries as coun1','coun1.id','order_details.deliver_from_country')
        ->leftJoin('countries as coun2','coun2.id','order_details.deliver_to_country')
        ->leftJoin('states as states1','states1.id','order_details.deliver_from_state')
        ->leftJoin('states as states2','states2.id','order_details.deliver_to_state')
        ->select('order_details.*','coun1.name as fromCountry','coun2.name as toCountry','states1.city_name as fromCity','states2.city_name as toCIty')
        ->first(); 
        $from="from_order";
        return view('frontend.travels.create_offer',compact('data'));
    }
    public function make_deliveryOffer(Request $request)
    {
        // dd($request);
        $orderId=$request->or_id;
        $for_trip=OrderDetail::findOrFail($orderId);
        $for_trip->product_price=$request->change_product_price_fee;
        $for_trip->traveller_reward=$request->travel;
        $for_trip->estimated_total=$request->pro_total_price_changed;
        $for_trip->save();
            $user=Auth::User();
            $user_id=$user->id;
            $trip=new Trip();
            $trip->user_id=$user_id;
            $trip->from_location_country=$for_trip->deliver_from_country;
            $trip->to_location_country=$for_trip->deliver_to_country;
            // $trip->from_location_state=$for_trip->deliver_from_state;
            $trip->to_location_state=$for_trip->deliver_to_state;
            $trip->travel_date=$for_trip->during_time;
            $trip->save();
            $t_id=Trip::latest()->first();
            $tid=$t_id->id;
            $t_user=$t_id->user_id;
            // $OrderDetail=OrderDetail::where('deliver_from_country',$for_trip->from_location)->where('deliver_to_country',$for_trip->to_location)->where('deliver_to_state',$for_trip->to_city)->where('during_time' ,'>=',$for_trip->travel_date)->where('order_status','1')->get();
            // dd($OrderDetail);
            // foreach($OrderDetail as $r)
            // {
                // if($t_user != $r->user_id)
                // {
                    $MatchedTripOrder=new MatchedTripOrder();
                    $MatchedTripOrder->trip_id=$tid;
                    $MatchedTripOrder->order_id=$orderId;
                    $MatchedTripOrder->trip_user=$t_user;
                    $MatchedTripOrder->order_user=$for_trip->user_id;
                    $MatchedTripOrder->trip_status='1';
                    $MatchedTripOrder->save();
            //     }
            
            // }
            return redirect()->route('user.trip')->withSuccess('Trip Created Successfully');
       
    }
    public function matched_trip(Request $request)
    {
        $id=$request->id;
        $data=MatchedTripOrder::where('matched_trip_orders.trip_id',$id)
        ->where('matched_trip_orders.trip_user',Auth::user()->id)->leftJoin('trips','trips.id','matched_trip_orders.trip_id')->leftJoin('order_details','order_details.id','matched_trip_orders.order_id')
        ->leftJoin('countries as coun1','coun1.id','order_details.deliver_from_country')
        ->leftJoin('countries as coun2','coun2.id','order_details.deliver_to_country')
        ->leftJoin('states as states1','states1.id','order_details.deliver_from_state')
        ->leftJoin('states as states2','states2.id','order_details.deliver_to_state')
        ->select('matched_trip_orders.id as ma_id','matched_trip_orders.trip_status','matched_trip_orders.order_status as orStatus','matched_trip_orders.order_id as o_id','order_details.*','coun1.name as fromCountry','coun2.name as toCountry','states1.city_name as fromcity','states2.city_name as toCity')->get();
        // dd($data);
        // dd($data);
        $from="from_trip";
        return view('frontend.user.matched_orders',compact('data','from')); 
    }
    public function send_tripRequest(Request $request)
    {
        $id=$request->id;
        $status=$request->status;
        $data=MatchedTripOrder::findOrFail($id);
        $orId=$data->order_id;
        $trId=$data->trip_id;
        if($request->from=='from_order')
        {
            if($status=='requested')
            {
                $data->order_status='1';
            }
            if($status=='pick_up')
            {
                $data->order_status='3';
            }
            if($status=='delivered')
            {
                $data->order_status='4';
            }
            $data->save();
            return redirect()->route('user.orders')->withSuccess("Your request sended ");
        }
        else
        {
            $orde=OrderDetail::findOrFail($orId);
            if($status=='requested')
            {
                $data->trip_status='1';
                $orde->trip_id=$data->trip_id;
            }
            if($status=='pick_up')
            {
                $data->trip_status='3';
                $data->order_status='3';
                $orde->order_status='2';
            }
            if($status=='delivered')
            {
                $data->trip_status='4';
                $data->order_status='4';
                $orde->order_status='3';
            }
            if($status=='accept_orderRe')
            {
                $data->trip_status='2';
                $data->order_status='2';
            }
            if($status=='cancle_orderRe')
            {
                $data->trip_status='0';
                $data->order_status='0';
            }
            $data->save();
            $orde->save();
            return redirect($request->url);
        }
       
    }
    public function check_trOffer(Request $request)
    {
        $ord_id=$request->id;
        $data=MatchedTripOrder::where('order_id',$ord_id)
                ->leftJoin('order_details','order_details.id','matched_trip_orders.order_id')
                ->leftJoin('users','users.id','matched_trip_orders.trip_user')
                ->leftJoin('countries as coun1','coun1.id','order_details.deliver_from_country')
                ->leftJoin('countries as coun2','coun2.id','order_details.deliver_to_country')
                ->leftJoin('states as states1','states1.id','order_details.deliver_from_state')
                ->leftJoin('states as states2','states2.id','order_details.deliver_to_state')
                ->select('matched_trip_orders.id as m_id','users.*','order_details.*','coun1.name as fromCountry','coun2.name as toCountry','states1.city_name as fromcity','states2.city_name as toCity')
                ->where('trip_status', '!=' ,'0')
                ->first();
        if($data != null)
        {
            return view('frontend.user.order_travel_offer',compact('data')); 
        }
        else
        {
            return redirect()->route('user.trip');
        }
    }
    public function travel_offer_reChange(Request $request)
    {
        $id=$request->id;
        $status=$request->status;
        $data=MatchedTripOrder::findOrFail($id);
        if($status=='accept')
        {
            $data->trip_status='2';
        }
        elseif($status=='cancle')
        {
            $data->trip_status='0';
        }
        $data->save();
        return redirect()->route('user.orders')->withSuccess('Your request Changed');
    }
    public function create_trip(Request $request)
    {
        // dd($request);
        // if($request->from_city != $request->to_city)
        // {
            $user=Auth::User();
            $user_id=$user->id;
            $trip=new Trip();
            $trip->user_id=$user_id;
            $trip->from_location_country=$request->from_location;
            $trip->to_location_country=$request->to_location;
            // $trip->from_location_state=$request->from_city;
            $trip->to_location_state=$request->to_city;
            $trip->travel_date=$request->travel_date;
            $trip->save();
            $t_id=Trip::latest()->first();
            $tid=$t_id->id;
            $t_user=$t_id->user_id;
            $OrderDetail=OrderDetail::where('deliver_from_country',$request->from_location)->where('deliver_to_country',$request->to_location)->where('deliver_to_state',$request->to_city)->where('during_time' ,'>=',$request->travel_date)->where('order_status','1')->get();
            foreach($OrderDetail as $r)
            {
                if($t_user != $r->user_id)
                {
                    $MatchedTripOrder=new MatchedTripOrder();
                    $MatchedTripOrder->trip_id=$tid;
                    $MatchedTripOrder->order_id=$r->id;
                    $MatchedTripOrder->trip_user=$t_user;
                    $MatchedTripOrder->order_user=$r->user_id;
                    $MatchedTripOrder->save();
                }
            
            }
            return redirect()->route('user.trip')->withSuccess('Trip Created Successfully');
        // }
        // else
        // {
        //     return back()->withError('Something went Wrong');
        // }
        
    }
    public function treveller_store(Request $request)
    {
        $data= Country::all();
        $today=date('y-m-d');
        $popurlDe=OrderDetail::
        join('countries','countries.id','order_details.deliver_to_country')
        // ->where('order_details.during_time', ">",$today)
        ->groupBy('order_details.deliver_to_country')
        ->select(DB::raw('SUM(order_details.product_price) as product_price'),'countries.id as counrty_id','countries.name as country_name','countries.flag',\DB::raw('COUNT(order_details.deliver_to_country) as total_order'))
        ->take(4)->get();
        return view('frontend.user.create_trip',compact('data','popurlDe'));
    }
    public function trip(Request $request)
    {
        $user_id=Auth::User()->id;
        $today=date('y-m-d');
        // dd($today);
        $data=Trip::where('travel_date' ,'=', $today)
            ->where('user_id',$user_id)
            ->leftJoin('countries as coun1','coun1.id','trips.from_location_country')
            ->leftJoin('countries as coun2','coun2.id','trips.to_location_country')
            ->leftJoin('states as states1','states1.id','trips.from_location_state')
            ->leftJoin('states as states2','states2.id','trips.to_location_state')
            ->select('trips.*','coun1.name as fromCountry','coun2.name as toCountry','states1.city_name as fromCity','states2.city_name as toCIty')
            ->orderBy('trips.id')
            ->get();
        $current=Trip::where('travel_date' ,'=', $today)
                ->where('user_id',$user_id)
                ->leftJoin('countries as coun1','coun1.id','trips.from_location_country')
                ->leftJoin('countries as coun2','coun2.id','trips.to_location_country')
                ->leftJoin('states as states1','states1.id','trips.from_location_state')
                ->leftJoin('states as states2','states2.id','trips.to_location_state')
                ->select('trips.*','coun1.name as fromCountry','coun2.name as toCountry','states1.city_name as fromCity','states2.city_name as toCIty')
                ->get();
        // dd($current);
        $cur=$current->count();
        $upcoming=Trip::where('travel_date' ,'>', $today)
            ->where('user_id',$user_id)
            ->orderBy('trips.id','DESC')
            ->leftJoin('countries as coun1','coun1.id','trips.from_location_country')
            ->leftJoin('countries as coun2','coun2.id','trips.to_location_country')
            ->leftJoin('states as states1','states1.id','trips.from_location_state')
            ->leftJoin('states as states2','states2.id','trips.to_location_state')
            ->select('trips.*','coun1.name as fromCountry','coun2.name as toCountry','states1.city_name as fromCity','states2.city_name as toCIty')
            ->get();
            // dd($upcoming);
        $upc=$upcoming->count();
        $past=Trip::where('travel_date' ,'<', $today)->where('user_id',$user_id)->get();
        $pastCount=$past->count();
        // dd($upcoming);
        return view('frontend.user.trips',compact('upcoming','current','past','cur','upc','pastCount'));
    }
}
