@include('frontend.includes.header')
    <body>
        @include('frontend.includes.nav')
        <!-- header end -->
	    <!-- <div class="breadcrumb-area pt-205 pb-210" style="background-image: url({{URL::to('/')}}/public/frontend/assets/img/bg/breadcrumb.jpg)">
            <div class="container">
                <div class="breadcrumb-content text-center">
                    <h2>Profile details</h2>
                    <ul>
                        <li><a href="#">home</a></li>
                        <li> Profile </li>
                    </ul>
                </div>
            </div>
        </div> -->
        <div class="product-description-review-area pb-90 profile-page">
            <div class="container">
                <div class="product-description-review">
                    <div class="description-review-title nav" role=tablist>
                        <a href="#" >
                           {{$data->first_name}} {{$data->last_name}}
                        </a>
                        @if($data->profile !="")
                            <img src="{{URL::to('/')}}/public/upload/profile_img/{{$data->profile}}" width="100px;">
                        @else
                            <img src="{{URL::to('/')}}/public/frontend/assets/img/profile/3135715.png" width="100px" alt="" >
                        @endif
                        <div>
                    </div>
                   </div>
                    <div class="stars-container-main">
                        <div class="stars-container first">
                            <p>Joined {{ date("M d , Y", strtotime($data->created_at))}}</p>
                            <span>Shopper</span>
                            <div class="stars">
                                <i class="fa-regular fa-star" ></i>
                                <i class="fa-regular fa-star" ></i>
                                <i class="fa-regular fa-star" ></i>
                                <i class="fa-regular fa-star" ></i>
                                <i class="fa-regular fa-star" ></i>
                            </div>
                            <span>(0)</span>
                        </div>
                        <div class="stars-container second">
                            <span>Traveller</span>
                            <div class="stars">
                                <i class="fa-regular fa-star" ></i>
                                <i class="fa-regular fa-star" ></i>
                                <i class="fa-regular fa-star" ></i>
                                <i class="fa-regular fa-star" ></i>
                                <i class="fa-regular fa-star" ></i>
                            </div>
                            <span>(0)</span>
                        </div>
                    </div>
                    <p class="cancelation-line">Mobile Number :- <span >{{$data->mobile}}</span></p>
                    <p class="cancelation-line">Email :-<span>{{$data->email}}</span></p>
                    <p class="cancelation-line">Cancelations rating <button class="status-btn" id="statusBtn">PENDING</button></p>
                    
                    <div class="pending-hover">
                        <p class="pending-hover-text">The traveler has no recent deliveries. <br> 
                        Cancellations rating is based on the ratio between the number of cancellations and deliveries of the traveler compared to the whole Buy4Me community.
                        </p>
                    </div>
                    
                    <p class="verified-phone-line"><span class="verified-info">VERIFIED INFO </span>@if($data->otp != "") <span class="check-icon-main" style="color:green;"><span class="check-icon"><i class="fa-regular fa-circle-check"></i></span>phone</span>@else <a href="{{route('user.setting')}}" class="account_details_active"><span class="check-icon-main" style="color:blue;" >Verify phone number</span></a>@endif @if($data->email_veryfied != '0')<span class="check-icon-main" style="color:green"><span class="check-icon"><i class="fa-regular fa-circle-check"></i></span>Email</span> @else <a href="{{route('user.setting')}}" class="account_details_active"><span class="check-icon-main" style="color:blue">Verify email</span></a> @endif</p>
                    <div class="description-review-text tab-content">
                        <div class="tab-pane active show fade" id="pro-dec" role="tabpanel">
                           <button class="edit-profile-btn"><a href="{{route('user.setting')}}">Edit Profile</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- profile area end -->
        <!-- menu area end -->
	    @include('frontend.includes.footer')
		<!-- all js here -->
     @include('frontend.includes.footer_script')
    </body>
</html>
