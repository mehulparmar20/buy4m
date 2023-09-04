<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\OrderDetail;
use App\Models\TravellerOffer;
use Auth;
use App\Models\MatchedTripOrder;

class TravellerOfferController extends Controller
{
   public function create_offer(Request $request)
   {	
        $for_trip=OrderDetail::findOrFail($request->id);
        $trip=new Trip();
        $trip->user_id=Auth::user()->id;
        $trip->from_location_country=$for_trip->deliver_from_country;
        $trip->to_location_country=$for_trip->deliver_to_country;
        $trip->to_location_state=$for_trip->deliver_to_state;
        $trip->travel_date=$for_trip->during_time;
        $trip->save();
        $t_id=Trip::latest()->first();
        if($trip==true)
        {
            $change_travel_fee=$request->change_travel_fee;
            $change_product_price_fee=$request->change_product_price_fee;
            if($change_travel_fee==null || $change_travel_fee=="")
            {
                $change_travel_fee=str_replace(array( '\'', '"',
                ',' , ';', '<', '>','₹','$'), ' ', $request->traveller_re_ch_price);
            }
            if($change_product_price_fee==null || $change_product_price_fee=="")
            {
                $change_product_price_fee=str_replace(array( '\'', '"',
                ',' , ';', '<', '>','₹','$'), ' ', $request->pro_ch_price);
            }
            $data=new TravellerOffer();
            $data->order_id=$request->id;
            $data->product_price=$change_product_price_fee;
            $data->travel_reward=$change_travel_fee;
            $data->trip_id=$t_id->id;
            $data->save();

            $MatchedTripOrder=new MatchedTripOrder();
            $MatchedTripOrder->trip_id=$t_id->id;
            $MatchedTripOrder->order_id=$request->id;
            $MatchedTripOrder->trip_user=Auth::user()->id;
            $MatchedTripOrder->order_user=$for_trip->user_id;
            $MatchedTripOrder->trip_status='1';
            $MatchedTripOrder->save();
        }
        return redirect()->route('user.matched_trip',['id'=>$t_id->id])->withSuccess("Offer sended to Shopper Successfully !");
   }
}
