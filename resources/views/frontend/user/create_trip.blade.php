@include('frontend.includes.header')
  <body>
    @include('frontend.includes.nav')
    <!-- header end -->
    <!-- <div class="slider-active owl-carousel">
      <div class="food-slider bg-img slider-height-5" style="background-image: url({{URL::to('/')}}/public/frontend/custom/img/Web-Banners-1.jpg)">
        <div class="container">
          <div class="food-slider-content text-center fadeinup-animated-1">
             <form action="{{route('user.create_trip')}}" method="post" class="container1">
              @csrf
              <h5></b>Add your trip details to start earning money</b></h5> -->
              <!-- <label>From Country *</label>
              <select class="form-select single-select-field browsers_country" data-placeholder="Choose one thing" name="from_location" onchange="getState(this.value,'from_travel')" required>
              </select>
              
              
              <label>To Country *</label>
              <select class="form-select single-select-field browsers_country" data-placeholder="Choose one thing" name="to_location" onchange="getState(this.value,'to_travel')" required>
              </select>

              <label>To City*</label>
              <select class="form-select single-select-field " data-placeholder="Choose one thing" name="to_city" id="travel_to_state" required>
              </select>
            
              <input type="date" name="travel_date"   class="form-control travel_date" placeholder="travel date" min="</?php echo date('Y-m-d'); ?>" required>

              <button type="submit" class="btn1">Add Trip</button> -->
            <!-- </form> -->
          <!-- </div>
        </div>
      </div>
    </div>    -->
    <div class="row traveller_slider" style="background-image: url({{URL::to('/')}}/public/frontend/custom/img/Web-Banners-1.jpg);height: 500px !important;"> 
      <div class="product-description-review-area pb-90s col-12">
        <div class="container">
            <div class="food-slider-content fadeinup-animated-1">
           <!-- <div class="food-slider-content text-center fadeinup-animated-1"> -->
              <form action="{{route('user.create_trip')}}" method="post" class="container1">
                @csrf
                <h1></b>Travel to Earn</b></h1><p>Embark on Your Next Adventure!</p>
                <label>From*</label>
                <select class="form-select single-select-field browsers_country" data-placeholder="Choose one thing" name="from_location" onchange="getState(this.value,'from_travel')" required>
                </select>
                
                
                <label>To*</label>
                <select class="form-select single-select-field browsers_country" data-placeholder="Choose one thing" name="to_location" onchange="getState(this.value,'to_travel')" required>
                </select>

                <label>Select*</label>
                <select class="form-select single-select-field " data-placeholder="City" name="to_city" id="travel_to_state" required>
                </select>
              
                <input type="date" name="travel_date"   class="form-control travel_date" placeholder="travel date" min="</?php echo date('Y-m-d'); ?>" required>
                <div id="trip_check_verify">
                  @if(Auth::check())
                    @if(Auth::user()->email_veryfied=='1')
                      <button type="submit" class="menu-btn1 btn-hover">Add Trip</button>
                    @else
                      <button type="button" class="menu-btn1 btn-hover"> <a href="{{route('email_verify.auth',['email'=>Auth::user()->email])}}">Add Trip</a></button>
                    @endif
                  @else
                    <button type="button" onclick="openLogin()" class="menu-btn1 btn-hover">Add Trip</button>
                  @endif
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
    <!-- menu area  -->
    <div class="about-story pt-95 pb-100">
      <div class="container">
          <div class="row">
              <div class="col-lg-6">
                  <div class="story-img">
                      <img src="{{URL::to('/')}}/public/frontend/assets/img/banner/11.png" alt="">
                      <div class="about-logo">
                          <h3>Buy4me</h3>
                      </div>
                  </div>
              </div>
              <div class="col-lg-6">
                  <div class="story-details pl-50">
                      <div class="story-details-top">
                          <h2>WELCOME TO <span>Buy4me</span></h2>
                          <p>…wondering if you should try Grabr on your next trip? The answer is YES. Shoppers all came to my hotel lobby within two hours. Quick, easy, and fun. What a cool way to meet new people and earn some cash.</p>
                          <button class="menu-btn1 btn-hover">More Buy4me stories</button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
    <!-- menu area end -->
      <!-- blog area start -->
      <div class="blog-area pt-120 pb-80">
        <div class="container">
            <div class="section-title-3 text-center mb-50">
                <h2>Popular Destinations</h2>
            </div>
            <div class="row">
              @foreach($popurlDe as $row)
                <div class="col-md-3">
                    <div class="blog-wrapper mb-40">
                      <p>{{$row->country_name}}</p>
                      <p>{{$row->total_order}} orders</p>
                        <div class="blog-img blog-hover mb-15">
                            <a href="#"><img src="{{URL::to('/')}}/public/upload/country_flag/{{$row->flag}}" alt=""></a>
                        </div>
                        <div class="blog-info">
                            <h4><a href="{{route('make_offer_html',['id'=>$row->counrty_id])}}">Add trip</a></h4>
                            <span>${{$row->product_price}}</span>
                        </div>
                    </div>
                </div>
              @endforeach               
            </div>
        </div>
    </div>
    <!-- blog area end -->
    @include('frontend.includes.footer')
		<!-- all js here -->
    @include('frontend.includes.footer_script')
  </body>

</html>

