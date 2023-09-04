@include('frontend.includes.header')
  <body>
    @include('frontend.includes.nav')
    <!-- header end -->
    <div class="product-description-review-area pb-90 pt-40">
      <div class="container">
        <div class="product-description-review text-center">
          <h5> Trips  &nbsp;&nbsp;<a href="{{route('user.treveller')}}">Add Trip</a></h5> 
          <div class="description-review-title nav tabs" role=tablist>
            <span data-tab-value="#recent_tab" style="width:150px;">Recent <?php echo $cur+$upc; ?></span>
            <span  data-tab-value="#past_tab"style="width:150px;">Past {{$pastCount}}</span>
          </div>
          <div class="description-review-text tab-content">
            <div class="tab-pane active show fade tabs__tab active " id="recent_tab"  role="tabpanel" data-tab-info>
              <h3>Current</h3>
              <div>
                @if($cur !=0) 
                  @foreach($current as $row)
                    <div class="single-blog-replay">
                      <div class="replay-info-wrapper">
                        <div class="replay-info">
                          <div class="replay-name-date">
                            <h5><a href="#">Upcoming Trip</a></h5>
                            <span>{{ date("M d , Y", strtotime($row->travel_date))}}</span>
                          </div>
                          <div class="replay-btn">
                            <a href="{{route('user.matched_trip',['id'=>$row->id,'from'=>'trip'])}}">check Offer</a>
                          </div>
                        </div>
                        <p>{{$row->fromCountry}},{{$row->fromCity}} -> {{$row->toCountry}},{{$row->toCIty}}</p>
                        <p>{{ date("M d , Y", strtotime($row->travel_date))}}</p>
                      </div>
                    </div>
                  @endforeach
                @else
                  <p>there are no trip</p>
                @endif    
              </div>
              <div>
                <div class="blog-replay-wrapper pb-40">
                  <h4 class="blog-details-title2">Upcoming</h4>
                    @if($upc !=0)
                      @foreach($upcoming as $row)
                        <div class="single-blog-replay">
                          <div class="replay-info-wrapper">
                            <div class="replay-info">
                              <div class="replay-name-date">
                                <h5><a href="#">Upcoming Trip</a></h5>
                                <span>{{$row->travel_date}}</span>
                              </div>
                              <div class="replay-btn">
                                <a href="{{route('user.matched_trip',['id'=>$row->id,'from'=>'trip'])}}">check Offer</a>
                              </div>
                            </div>
                            <p>{{$row->fromCountry}},{{$row->fromCity}} -> {{$row->toCountry}},{{$row->toCIty}}</p>
                            <p>{{ date("M d , Y", strtotime($row->travel_date))}}</p>
                          </div>
                        </div>
                      @endforeach
                    @else
                      <p>there are no trip</p>
                    @endif
                  </div>
                </div>
              </div>
              <div class="description-review-text tab-content">
                <div class="tab-pane  show fade tabs__tab " id="past_tab"  role="tabpanel" data-tab-info>
                  <h3>Past</h3>
                  <div>
                    @if($pastCount !=0)
                      @foreach($past as $row)
                        <div class="single-blog-replay">
                          <div class="replay-info-wrapper">
                            <div class="replay-info">
                              <div class="replay-name-date">
                                <h5><a href="#">Past Trip</a></h5>
                                <span>{{$row->travel_date}}</span>
                              </div>
                            </div>
                            <p>{{$row->fromCountry}},{{$row->fromCity}} -> {{$row->toCountry}},{{$row->toCIty}}</p>
                            <p>{{ date("M d , Y", strtotime($row->travel_date))}}</p>
                          </div>
                        </div>
                      @endforeach
                    @else
                      <p>there are no trip</p>
                    @endif
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
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
  
<script>
      
  var firebaseConfig = {
    apiKey: "AIzaSyBPdVwUIYOY0qRr9kbIMTnxKpFw_nkneYk",
    authDomain: "itdemo-push-notification.firebaseapp.com",
    databaseURL: "https://itdemo-push-notification.firebaseio.com",
    projectId: "itdemo-push-notification",
    storageBucket: "itdemo-push-notification.appspot.com",
    messagingSenderId: "257055232313",
    appId: "1:257055232313:web:3f09127acdda7298dfd8e8",
    measurementId: "G-VMJ68DFLXL"
  };
    
  firebase.initializeApp(firebaseConfig);
</script>
  
<script type="text/javascript">
  
    window.onload=function () {
      render();
    };
  
    function render() {
        window.recaptchaVerifier=new firebase.auth.RecaptchaVerifier('recaptcha-container');
        recaptchaVerifier.render();
    }
  
    function phoneSendAuth() {
           
        var number = $("#mobile_number").val();
          
        firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {
              
            window.confirmationResult=confirmationResult;
            coderesult=confirmationResult;
            console.log(coderesult);
  
            $("#sentSuccess").text("Message Sent Successfully.");
            $("#sentSuccess").show();
              
        }).catch(function (error) {
            $("#error").text(error.message);
            $("#error").show();
        });
  
    }
  
    function codeverify() {
  
        var code = $("#verificationCode").val();
  
        coderesult.confirm(code).then(function (result) {
            var user=result.user;
            console.log(user);
  
            $("#successRegsiter").text("you are register Successfully.");
            $("#successRegsiter").show();
  
        }).catch(function (error) {
            $("#error").text(error.message);
            $("#error").show();
        });
    }
  
</script>