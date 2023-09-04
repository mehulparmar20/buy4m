@include('frontend.includes.header')
  <body>
    @include('frontend.includes.nav')
    <!-- header end -->
    <div class="best-product-area pb-15">
      <div class="pl-100 pr-100">
        <div class="container-fluid">
              <div class="section-title-3 text-center mb-40">
                <h2>Matched Trip  </h2>
               
              </div>
              <div class="best-product-style">
                  <div class="product-tab-list2 text-center mb-95 nav product-menu-mrg" role="tablist">
                    <a class="active" href="#matchTrip_order" data-bs-toggle="tab" role="tab">
                      <h4>Matched order </h4>
                    </a>
                    <a href="#matchTrip_requested" data-bs-toggle="tab" role="tab">
                        <h4>Requested</h4>
                    </a>
                    <a href="#matchTrip_accepted" data-bs-toggle="tab" role="tab">
                        <h4>Accepted</h4>
                    </a>
                    <a href="#matchTrip_inTrain" data-bs-toggle="tab" role="tab">
                        <h4>In Train</h4>
                    </a>
                    <a href="#matchTrip_delivered" data-bs-toggle="tab" role="tab">
                        <h4>Delivered</h4>
                    </a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active show fade" id="matchTrip_order" role="tabpanel">
                        <div class="custom-row">
                            <div class="custom-col-5 custom-col-style mb-95">
                                @foreach($data as $row)
                                    @if($row->orStatus==0)
                                        <div class="product-wrapper">
                                            <div class="product-img-2">
                                                <a href="#">
                                                    <img src="{{URL::to('/')}}/public/upload/profile_img/{{$row->profile}}" alt="">
                                                </a>
                                            </div>
                                            <div class="product-content-2 text-center">
                                                <h4><a href="#">{{$row->first_name}}</a></h4><h4><a href="#">{{$row->last_name}}</a></h4>
                                                <span>{{$row->fromCountry}} ,{{$row->fromcity}}:- {{$row->toCountry}},{{$row->toCity}} , by  &nbsp; &nbsp; {{ date("M d , Y", strtotime($row->during_time))}}</span>
                                                <div class="product-rating">
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star"></i>
                                                    <i class="ti-star"></i>
                                                </div>
                                                <div class="details-price">
                                                    <span>Treveler Email</span> :-<span >${{$row->email}}</span>
                                                </div>
                                                <div class="details-price">
                                                    <span>Treveler Mobile</span> :-<span >{{$row->mobile}}</span>
                                                </div>
                                                <!-- @if($row->trip_status=='1') -->
                                                <!-- @endif -->
                                                <!-- <button><a href="{{route('user.send_tripRequest',['id'=>$row->ma_id,'status'=>'requested','from'=>$from])}}">Send request </a></button> -->
                                                @if($row->trip_status=='1')
                                                    <button><a href="{{route('stripeIdentity.index')}}">Accept Offer</a></button>
                                                @else
                                                    <button><a href="{{route('user.send_tripRequest',['id'=>$row->ma_id,'status'=>'requested','from'=>$from])}}">Send request </a></button>
                                                @endif
                                            </div>
                                        </div>
                                    @endif 
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="matchTrip_requested" role="tabpanel">
                        <div class="custom-row">
                            <div class="custom-col-5 custom-col-style mb-95">
                                @foreach($data as $row)
                                    @if($row->orStatus==1)
                                       
                                        <div class="product-wrapper">
                                            <div class="product-img-2">
                                                <a href="#">
                                                    <img src="{{URL::to('/')}}/public/upload/profile_img/{{$row->profile}}" alt="">
                                                </a>
                                            </div>
                                            <div class="product-content-2 text-center">
                                                <h4><a href="#">{{$row->first_name}}</a></h4><h4><a href="#">{{$row->last_name}}</a></h4>
                                                <span>{{$row->fromCountry}} ,{{$row->fromcity}}:- {{$row->toCountry}},{{$row->toCity}} , by  &nbsp; &nbsp; {{ date("M d , Y", strtotime($row->during_time))}}</span>
                                                <div class="product-rating">
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star"></i>
                                                    <i class="ti-star"></i>
                                                </div>
                                                <div class="details-price">
                                                    <span>Treveler Email</span> :-<span >${{$row->email}}</span>
                                                </div>
                                                <div class="details-price">
                                                    <span>Treveler Mobile</span> :-<span >{{$row->mobile}}</span>
                                                </div>
                                                <!-- <button><a href="{{route('user.send_tripRequest',['id'=>$row->ma_id,'status'=>'requested','from'=>$from])}}">Send request </a></button> -->
                                            </div>
                                        </div>
                                    @else
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="matchTrip_accepted" role="tabpanel">
                        <div class="custom-row">
                            <div class="custom-col-5 custom-col-style mb-95">
                                @foreach($data as $row)
                                    @if($row->orStatus==2)
                                       
                                        <div class="product-wrapper">
                                            <div class="product-img-2">
                                                <a href="#">
                                                    <img src="{{URL::to('/')}}/public/upload/profile_img/{{$row->profile}}" alt="">
                                                </a>
                                            </div>
                                            <div class="product-content-2 text-center">
                                                <h4><a href="#">{{$row->first_name}}</a></h4><h4><a href="#">{{$row->last_name}}</a></h4>
                                                <span>{{$row->fromCountry}} ,{{$row->fromcity}}:- {{$row->toCountry}},{{$row->toCity}} , by  &nbsp; &nbsp; {{ date("M d , Y", strtotime($row->during_time))}}</span>
                                                <div class="product-rating">
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star"></i>
                                                    <i class="ti-star"></i>
                                                </div>
                                                <div class="details-price">
                                                    <span>Treveler Email</span> :-<span >${{$row->email}}</span>
                                                </div>
                                                <div class="details-price">
                                                    <span>Treveler Mobile</span> :-<span >{{$row->mobile}}</span>
                                                </div>
                                                <!-- <button><a href="{{route('user.send_tripRequest',['id'=>$row->ma_id,'status'=>'requested','from'=>$from])}}">Send request </a></button> -->
                                            </div>
                                        </div>
                                    @else
                                     <!-- <p>No matched Request</p> -->
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="matchTrip_inTrain" role="tabpanel">
                        <div class="custom-row">
                            <div class="custom-col-5 custom-col-style mb-95">
                            @foreach($data as $row)
                                    @if($row->orStatus==3)
                                       
                                        <div class="product-wrapper">
                                            <div class="product-img-2">
                                                <a href="#">
                                                    <img src="{{URL::to('/')}}/public/upload/profile_img/{{$row->profile}}" alt="">
                                                </a>
                                            </div>
                                            <div class="product-content-2 text-center">
                                                <h4><a href="#">{{$row->first_name}}</a></h4><h4><a href="#">{{$row->last_name}}</a></h4>
                                                <span>{{$row->fromCountry}} ,{{$row->fromcity}}:- {{$row->toCountry}},{{$row->toCity}} , by  &nbsp; &nbsp; {{ date("M d , Y", strtotime($row->during_time))}}</span>
                                                <div class="product-rating">
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star"></i>
                                                    <i class="ti-star"></i>
                                                </div>
                                                <div class="details-price">
                                                    <span>Treveler Email</span> :-<span >${{$row->email}}</span>
                                                </div>
                                                <div class="details-price">
                                                    <span>Treveler Mobile</span> :-<span >{{$row->mobile}}</span>
                                                </div>
                                                <!-- <button><a href="{{route('user.send_tripRequest',['id'=>$row->ma_id,'status'=>'requested','from'=>$from])}}">Send request </a></button> -->
                                            </div>
                                        </div>
                                    @else
                                     <!-- <p>No matched Request</p> -->
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="matchTrip_delivered" role="tabpanel">
                        <div class="custom-row">
                            <div class="custom-col-5 custom-col-style mb-95">
                                @foreach($data as $row)
                                    @if($row->orStatus==4)
                                        <?php
                                            $img=$row->product_imgs;
                                            $img=explode(' , ', $img);
                                            foreach($img as $i)
                                            {
                                                $i=$i;
                                            }
                                            $i=str_replace([']','[']," " ,$i);
                                            $i=trim($i);
                                        ?>
                                        <div class="product-wrapper">
                                            <div class="product-img-2">
                                                <a href="#">
                                                    <img src="https://b4m.veravalonline.com/b4m/public/upload/product_img/{{$i}}" alt="">
                                                </a>
                                            </div>
                                            <div class="product-content-2 text-center">
                                                <h4><a href="#">{{$row->product_name}}</a></h4>
                                                <span>{{$row->fromCountry}} ,{{$row->fromcity}}:- {{$row->toCountry}},{{$row->toCity}} , by &nbsp; &nbsp;  {{ date("M d , Y", strtotime($row->during_time))}}</span>
                                                @if($row->box==0)
                                                    <p> Without Box</p>
                                                @else
                                                    <p> With Box</p>
                                                @endif
                                                <div class="product-rating">
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star black"></i>
                                                    <i class="ti-star"></i>
                                                    <i class="ti-star"></i>
                                                </div>
                                                <div class="details-price">
                                                    <span>Product Price</span> :-<span >${{$row->product_price}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                     <!-- <p>Orders you have received.</p> -->
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
        <!-- menu area end -->
	    @include('frontend.includes.footer')
		<!-- all js here -->
     @include('frontend.includes.footer_script')
    </body>
</html>
