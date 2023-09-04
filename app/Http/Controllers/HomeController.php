<?php

namespace App\Http\Controllers;
use App\Models\Trip;
use App\Models\OrderDetail;
use App\Models\MatchedTripOrder;
use App\Models\Country;
use App\Models\State;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   //  public function __construct()
   //  {
   //      $this->middleware('auth');
   //  }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function home(Request $request)
   {
      $latestProduct=OrderDetail::orderBy('id','Desc')->take(8)->where('status','1')->get();
      $lestesTrip=Trip::take(4)->orderBy('trips.id','DESC')
               ->where('trips.status','1')
               ->join('users','users.id','trips.user_id')
               ->leftJoin('countries as from_countries','from_countries.id','trips.from_location_country')
               ->leftJoin('countries as to_countries','to_countries.id','trips.to_location_country')
               ->leftJoin('states','states.id','trips.to_location_state')
               ->select('trips.*','users.first_name','users.last_name','users.email','users.mobile','users.profile','from_countries.name as from_countryname','to_countries.name as toCountryName','states.city_name as TOstate_name')
               ->get();
               // dd($latestProduct);
      $popurlDe=OrderDetail::
         join('countries','countries.id','order_details.deliver_to_country')
         ->groupBy('order_details.deliver_to_country')
         ->select(DB::raw('SUM(order_details.product_price) as product_price'),'countries.id as counrty_id','countries.name as country_name','countries.flag',\DB::raw('COUNT(order_details.deliver_to_country) as total_order'))
         ->take(4)->get();
      return view('frontend.home',compact('latestProduct','lestesTrip','popurlDe'));
   }
   public function nav(Request $request)
   {
      return view("frontend.includes.nav");
   }
   
}
