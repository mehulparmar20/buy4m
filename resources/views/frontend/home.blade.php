@include('frontend.includes.header')
<!-- <body> -->
    @include('frontend.includes.nav')

    <!-- slider-area strat -->
    <div class="slider-area">
        <div class=" containerimage mydeivtest" style=" background-image: url(
        'public/frontend/custom/img/Banner Final - 1.jpg' );">
            <div class="bottom-left text-block btn-1"><a href="{{route('user.create_order')}}">Shopper</a></div>
            <!-- <div class="text-left">Turn your <br>Journey into Money</div> -->
            <div class="bottom-right text-block btn-1"><a href="{{route('user.treveller')}}">Traveller</a></div>
            <!-- <div class="text-right">Receive Items from all <br> around the world</div> -->
        </div>
    </div>
    <!-- slider-area end-->
    <!-- <div class="slider-active owl-carousel">
        <div class="food-slider bg-img slider-height-5" style="background-image: url(public/frontend/custom/img/Banner-1.jpg)">
            <div class="container">
                <div class="food-slider-content text-center fadeinup-animated-1">
                     <img class="animated" src="assets/img/slider/6.png" alt="">
                    <p class="animated">Earn $200+ USD every time you travel abroad</p>
                    <a class="food-slider-btn food-slider-btn-2 animated" href="#">How Buyforme works</a> -->
    <!-- Recent Transactions area start -->
    <div class="popular-product-area wrapper-padding-3 pt-115 pb-115">
        <div class="container-fluid">
            <div class="section-title-6 text-center mb-50">
                <h2>Recent Transactions</h2>
                <p>Bridging Nations, One Transaction at a Time.</p>
            </div>
            <div class="product-style">
                <div class="popular-product-active owl-carousel">
                    @foreach($latestProduct as $row)
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
                            <div class="product-img-1">
                                <a href="#">
                                    <img src="https://b4m.veravalonline.com/b4m/public/upload/product_img/{{$i}}" alt="">
                                </a>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="#" class="max-width-50">{{$row->product_name}}</a></h4>
                                <span>${{$row->product_price}}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Recent Transactions area end -->
    <!-- whybuyforme area start -->
    <div class="food-menu-area bg-img pt-110" style="background-image: url(assets/img/bg/13.jpg)">
        <div class="services-area wrapper-padding-4 gray-bg pt-120 pb-80">
            <div class="container-fluid">
                <div class="section-title-6 text-center mb-50">
                    <h2>Why Buy4Me </h2>
                    <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p> -->
                </div>
                <div class="services-wrapper">
                    <div class="single-services mb-40">
                        <div class="services-img">
                            <img src="{{URL::to('/')}}/public/frontend/custom/img/icon-img/Faster, Cost-Effective Shipping.png" alt="">
                        </div>
                        <div class="services-content">
                            <h4>Faster, Cost-Effective Shipping</h4>
                            <p>Say goodbye to lengthy shipping times and high costs. Our innovative approach leverages travelers' existing trips to deliver items swiftly and economically, meeting urgent and specialized shipping requirements.</p>
                        </div>
                    </div>
                    <div class="single-services mb-40">
                        <div class="services-img">
                            <img src="{{URL::to('/')}}/public/frontend/custom/img/icon-img/Dedicated Customer Support.png" alt="">
                        </div>
                        <div class="services-content">
                            <h4>Dedicated Customer Support</h4>
                            <p>Have a question or need assistance? Our dedicated customer support team is here to help. We're committed to providing you with a seamless and hassle-free experience.</p>
                        </div>
                    </div>
                    <div class="single-services mb-40">
                        <div class="services-img">
                            <img src="{{URL::to('/')}}/public/frontend/custom/img/icon-img/Secure and Transparent Transactions.png" alt="">
                        </div>
                        <div class="services-content">
                            <h4>Secure and Transparent Transactions</h4>
                            <p>We prioritize the security of your transactions and personal information. Our platform employs cutting-edge security measures, and our transparent tracking system keeps you informed at every step of the journey. </p>
                        </div>
                    </div>
                </div>
                <div class="services-wrapper">
                    <div class="single-services mb-40">
                        <div class="services-img">
                            <img src="{{URL::to('/')}}/public/frontend/custom/img/icon-img/Earning Opportunities for Travelers.png" alt="">
                        </div>
                        <div class="services-content">
                            <h4>Earning Opportunities for Travelers</h4>
                            <p>Traveling becomes more rewarding than ever. Travelers can earn extra income by carrying items requested by shoppers during their trips. It's a win-win situation that turns your travel plans into profitable ventures.</p>
                        </div>
                    </div>
                    <div class="single-services mb-40">
                        <div class="services-img">
                            <img src="{{URL::to('/')}}/public/frontend/custom/img/icon-img/Reliable Travelers, Trusted Deliveries.png" alt="">
                        </div>
                        <div class="services-content">
                            <h4>Reliable Travelers, Trusted Deliveries</h4>
                            <p>We take trust seriously. Our rigorous verification process ensures that travelers and shoppers on our platform are reliable and trustworthy. Rest assured that your items are in safe hands from pick-up to delivery.</p>
                        </div>
                    </div>
                    <div class="single-services mb-40">
                        <div class="services-img">
                            <img src="{{URL::to('/')}}/public/frontend/custom/img/icon-img/Seamless Global Connectivity.png" alt="">
                        </div>
                        <div class="services-content">
                            <h4>Seamless Global Connectivity</h4>
                            <p>Our platform bridges the gap between travelers and shoppers worldwide. With a vast network of users spanning across countries, we offer an unmatched global reach for your shipping and needs. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- whybuyforme area end -->
    <!-- testimonials area start -->
    <div class="testimonials-area  pt-50 pb-50 wishlist bg-img" style="background-image: url(public/frontend/custom/img/47.jpg)">
    
        <div class="container">
        <h2 style="text-align: center;">Our Testimonials </h2>
        <p style="text-align: center;">Real Stories from Our Community</p>
            <div class="testimonials-active owl-carousel">
                <div class="fruits-single-testimonial text-center">
                    <img alt="" src="assets/img/team/1.png">
                    
                    <p>I was skeptical about the concept initially, but Buy4Me exceeded my expectations. The website is well-designed, and the entire process is so straightforward. I've recommended it to friends already! </p>
                    <div class="client-name">
                        <span class="client-name-bright">Rachel B/</span>
                        <span>UIUX DEsigner</span>
                    </div>
                    <div class="fruits-ratting">
                        <i class="icofont icofont-star yellow"></i>
                        <i class="icofont icofont-star yellow"></i>
                        <i class="icofont icofont-star yellow"></i>
                        <i class="icofont icofont-star yellow"></i>
                        <i class="icofont icofont-star yellow"></i>
                    </div>
                </div>
                <div class="fruits-single-testimonial text-center">
                    <img alt="" src="assets/img/team/1.png">
                    <!-- <h3>Real Stories from Our Community Our Testimonials</h3> -->
                    <p>As a fashion enthusiast, I often find unique pieces online that aren't available in my country. Buy4Me made it simple to get those pieces delivered right to my door. I'm thrilled with the service! </p>
                    <div class="client-name">
                        <span class="client-name-bright">Mia L /</span>
                        <span>UIUX DEsigner</span>
                    </div>
                    <div class="fruits-ratting">
                        <i class="icofont icofont-star yellow"></i>
                        <i class="icofont icofont-star yellow"></i>
                        <i class="icofont icofont-star yellow"></i>
                        <i class="icofont icofont-star yellow"></i>
                        <i class="icofont icofont-star yellow"></i>
                    </div>
                </div>
                <div class="fruits-single-testimonial text-center">
                    <img alt="" src="assets/img/team/1.png">
                    <!-- <h3>Real Stories from Our Community Our Testimonials</h3> -->
                    <p>Buy4Me is a game-changer in the shipping industry. It's the future of cross-border shopping and travel. The platform's transparency and user-friendliness are remarkable. </p>
                    <div class="client-name">
                        <span class="client-name-bright">David W /</span>
                        <span>UIUX DEsigner</span>
                    </div>
                    <div class="fruits-ratting">
                        <i class="icofont icofont-star yellow"></i>
                        <i class="icofont icofont-star yellow"></i>
                        <i class="icofont icofont-star yellow"></i>
                        <i class="icofont icofont-star yellow"></i>
                        <i class="icofont icofont-star yellow"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- testimonials area end -->
    </div>
    @include('frontend.includes.footer') @include('frontend.includes.footer_script')
</body>

</html>