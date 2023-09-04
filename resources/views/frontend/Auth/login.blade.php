@include('frontend.includes.header')
    <body>
        @include('frontend.includes.nav')
        <!-- header end -->
		
        <!-- login-area start -->
        <div class="register-area " style="margin:50px">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-12 col-lg-6 col-xl-6 ms-auto me-auto">
                        <div class="login">
                            <div class="login-form-container">
                                <div class="login-form">
                                    <form action="{{route('login.user')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="previous_url" value="{{url()->previous()}}">
                                        <input type="email" name="email" placeholder="Email">
                                        <input type="password" name="password" placeholder="Password">
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <input type="checkbox">
                                                <label>Remember me</label>
                                                <!--<a href="#">Forgot Password?</a>-->
                                            </div>
                                            <button type="submit" class="default-btn floatright">Login</button>
                                            <a href="{{route('registrion')}}"><button type="button" class="default-btn floatright">Registration</button></a>
                                            <!-- <button type="button" class="default-btn floatright"><a href="{{route('registrion')}}">Registration</a></button> -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- login-area end -->
	    @include('frontend.includes.footer')
		
		<!-- all js here -->
     @include('frontend.includes.footer_script')
    </body>
</html>
