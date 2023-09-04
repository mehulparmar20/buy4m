@include('frontend.includes.header')
  <body>
    @include('frontend.includes.nav')
    <!-- header end -->
    <div class="best-product-area pb-15">
      <div class="pl-100 pr-100">
        <div class="container-fluid">
              <div class="section-title-3 text-center mb-40">
                <h4>Orders  &nbsp;&nbsp;&nbsp; 
                    <a href="{{route('user.create_order')}}">Add Order</a>
                </h4>
               
              </div>
              <div class="best-product-style">
                  <div class="product-tab-list2 text-center mb-95 nav product-menu-mrg" role="tablist">
                    <a class="active" href="#order_requested" data-bs-toggle="tab" role="tab">
                      <h4>Requested ({{$reCount}}) </h4>
                    </a>
                    <a href="#order_inTransit" data-bs-toggle="tab" role="tab">
                        <h4>In Transit ({{$intrailcoun}})</h4>
                    </a>
                    <a href="#order_received" data-bs-toggle="tab" role="tab">
                        <h4>Received ({{$receviedc}})</h4>
                    </a>
                    <a href="#order_inactive" data-bs-toggle="tab" role="tab">
                        <h4> Canceled ({{$inaCount}})</h4>
                    </a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active show fade" id="order_requested" role="tabpanel">
                        <div class="custom-row">
                            <div class="custom-col-12 custom-col-style mb-95">
                               
                                @foreach($data as $row)
                                    @if($row->order_status==1 && $row->during_time > date('Y-m-d'))
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
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="product-img-2">
                                                    <a href="#">
                                                        <img src="https://b4m.veravalonline.com/b4m/public/upload/product_img/{{$i}}" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div >
                                                    <h4><a href="#">{{$row->product_name}}</a></h4>
                                                    <span>{{$row->fromCountry}},{{$row->fromCity}} :- {{$row->toCountry}},{{$row->toCIty}} , by  &nbsp; &nbsp; 
                                                        {{ date("M d , Y", strtotime($row->during_time))}}</span>
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
                                                    <!-- <div>
                                                        <span>Where To Buy</span> :-<span >{{$row->product_url}}</span>
                                                    </div> -->
                                                    <div class="details-price">
                                                        <span>Product Price</span> :-<span >${{$row->product_price}}</span>
                                                    </div>
                                                    <a class="btn btn-outline-secondary px-4" href="{{route('user.order_details',['id'=>$row->id])}}">Show Details</a>
                                                    @if($row->trip_id != null || $row->trip_id !="")
                                                        <button><a href="{{route('user.check_trOffer',['id'=>$row->id])}}">Check Offer To trevel</a></button>
                                                    @endif
                                                </div>
                                            </div>

                                            <hr style="border-bottom: 1px solid #000; padding-top:5px">
                                        </div>
                                       
                                    @else
                                     <!-- <p>Orders awaiting delivery offers.</p> -->
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="order_inTransit" role="tabpanel">
                        <div class="custom-row">
                            <div class="custom-col-5 custom-col-style mb-95">
                                @foreach($data as $row)
                                    @if($row->order_status==2 && $row->during_time > date('Y-m-d'))
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
                                            <div class="product-action-2">
                                                <a class="animate-left add-style-2" title="Add To Cart" href="#">Show Details
                                              
                                            </div>
                                            <div class="product-content-2 text-center">
                                                <h4><a href="#">{{$row->product_name}}</a></h4>
                                                <span>{{$row->fromCountry}},{{$row->fromCity}} :- {{$row->toCountry}},{{$row->toCIty}}  , by &nbsp; &nbsp;   {{ date("M d , Y", strtotime($row->during_time))}}</span>
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
                                                <!-- <div>
                                                    <span>Where To Buy</span> :-<span >{{$row->product_url}}</span>
                                                </div> -->
                                                <div class="details-price">
                                                    <span>Product Price</span> :-<span >${{$row->product_price}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                     <!-- <p>Orders paid for, receiving soon.</p> -->
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="order_received" role="tabpanel">
                        <div class="custom-row">
                            <div class="custom-col-5 custom-col-style mb-95">
                                @foreach($data as $row)
                                    @if($row->order_status==3 && $row->during_time > date('Y-m-d'))
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
                                            <div class="product-action-2">
                                                <a class="animate-left add-style-2" title="Add To Cart" href="#">Show Details
                                            </div>
                                            <div class="product-content-2 text-center">
                                                <h4><a href="#">{{$row->product_name}}</a></h4>
                                                <span>{{$row->fromCountry}},{{$row->fromCity}} :- {{$row->toCountry}},{{$row->toCIty}}  , by &nbsp; &nbsp;   {{ date("M d , Y", strtotime($row->during_time))}}</span>
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
                                                <!-- <div>
                                                    <span>Where To Buy</span> :-<span >{{$row->product_url}}</span>
                                                </div> -->
                                                <div class="details-price">
                                                    <span>Product Price</span> :-<span >${{$row->product_price}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                    
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="order_inactive" role="tabpanel">
                        <div class="custom-row">
                            <div class="custom-col-5 custom-col-style mb-95">
                               
                                @foreach($data as $row)
                                <?php
                                    if($row->order_status==4 || $row->during_time < date('Y-m-d'))
                                    {
                                      
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
                                                    <img src="{{URL::to('/')}}/public/upload/product_img/{{$i}}" alt="">
                                                </a>
                                            </div>
                                            <div class="product-content-2 text-center">
                                                <h4><a href="#">{{$row->product_name}}</a></h4>
                                                <span>{{$row->fromCountry}},{{$row->fromCity}} :- {{$row->toCountry}},{{$row->toCIty}}  , by &nbsp; &nbsp;   {{ date("M d , Y", strtotime($row->during_time))}}</span>
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
                                                <!-- <div>
                                                    <span>Where To Buy</span> :-<span >{{$row->product_url}}</span>
                                                </div> -->
                                                <div class="details-price">
                                                    <span>Product Price</span> :-<span >${{$row->product_price}}</span>
                                                </div>
                                                <div class="quickview-btn-cart">
                                                        <a class="btn-hover-black" href="{{route('user.order_cancle',['id'=>$row->id,'status'=>'publish'])}}" onclick="return confirm('Are you sure you want to republish this ?');" >Re-publish</a>
                                                    <a class="btn-hover-black" href="{{route('user.order_cancle',['id'=>$row->id,'status'=>'delete'])}}" onclick="return confirm('Are you sure you want to permanent delete this ?');" >Delete Order</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
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
