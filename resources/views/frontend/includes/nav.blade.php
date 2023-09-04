
<header class="headerclass" id="header_navbar">
    <div class="header-top-furniture wrapper-padding-2 res-header-sm">
        <div class="container-fluid">
            <div class="header-bottom-wrapper">
                <div class="logo-2 furniture-logo">
                    <a href="{{URL::to('/')}}">
                    <input type="hidden" id="token" value="{{csrf_token()}}">
                        <input type="hidden" id="url" value="{{URL::to('/')}}">
                        <img src="{{URL::to('/')}}/public/frontend/assets/img/buy4me-02.png" width="160px" alt="" >
                    </a>
                </div>
                <div class="menu-style-2 furniture-menu menu-hover">
                    <nav>
                        <ul>
                            <li><a href="{{route('home')}}">home</a></li>
                            <li><a href="{{route('user.create_order')}}">Shopper</a></li>
                            <li><a href="{{route('user.treveller')}}">Traveller</a></li>
                            <li><a href="#">Cost Calculator</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="header-cart">
                    
                    @if(!empty(Auth::User()))
                        <a class="icon-cart-furniture" href="#" style="text-align: center;">
                        <i class="ti-user"></i><br>
                          Welcome {{Auth::User()->first_name}}
                        </a>
                    @else
                         <a class="icon-cart-furniture" href="#">
                          <i class="ti-user"></i>
                        </a>
                    @endif 
                    
                    <ul class="cart-dropdown">
                        @if(!empty(Auth::User()))
                            @if(Auth::User()->email_veryfied=='1')
                                <li class="single-product-cart">
                                    <a href="{{route('user.profile')}}">Profile</a>
                                </li>
                                <li class="single-product-cart">
                                    <a href="{{route('user.orders')}}">Orders</a>
                                </li>
                                <li class="single-product-cart">
                                    <a href="{{route('user.trip')}}">Trips</a>
                                </li>
                                <li class="single-product-cart">
                                    <a href="{{route('user.setting')}}">Wallets</a>
                                </li>
                                <li class="single-product-cart">
                                    <a href="{{route('user.setting')}}">Coupons</a>
                                </li>
                                <li class="single-product-cart">
                                    <a href="{{route('user.setting')}}">Settings</a>
                                </li>
                                <li class="single-product-cart">
                                    <a href="{{route('user.help_desk')}}">Help Desk</a>
                                </li>
                            @else
                                <li class="single-product-cart">
                                    <a href="{{route('email_verify.auth',['email'=>Auth::user()->email])}}">Email Verify</a>
                                </li>
                            @endif
                            
                        @endif
                        @if(empty(Auth::User()))
                            <li class="single-product-cart">
                                <a href="{{route('registrion')}}">Sign up</a>
                            </li>
                            <li class="single-product-cart">
                                <a href="{{route('login')}}">Login</a>
                            </li>
                        @else
                            <li class="single-product-cart">
                                <a href="{{route('logout')}}">Logout</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div> 
        </div>
    </div>
</header>
@include("frontend.Auth.login_modal")