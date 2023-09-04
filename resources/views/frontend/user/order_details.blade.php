@include('frontend.includes.header')
  <body>
	<?php setlocale(LC_MONETARY, "en_US"); ?>
    @include('frontend.includes.nav')
    <!-- header end -->
    <div class="best-product-area pb-15">
	@include('admin.includes.validation')
      <div class="pl-100 pr-100">
        <div class="container-fluid">
              <div class="section-title-3 text-center mb-40">
                <h2>Orders  Details</h2>
               
              </div>
			 
              <div class="best-product-style">
                  <div class="product-tab-list2 text-center mb-95 nav product-menu-mrg" role="tablist">
                    <a class="active" href="#order_Orderpublished" data-bs-toggle="tab" role="tab">
                      <h4>Order published </h4>
                    </a>
                    <a href="#order_Offerreceived" data-bs-toggle="tab" role="tab">
                        <h4>Offer received </h4>
                    </a>
                    <a href="#order_Offerchosen" data-bs-toggle="tab" role="tab">
                        <h4>Offer chosen</h4>
                    </a>
                    <a href="#order_Deliverystarted" data-bs-toggle="tab" role="tab">
                        <h4> Delivery started</h4>
                    </a>
                </div>
                <?php
                    $img=$data->product_imgs;
                    $img=explode(' , ', $img);
                ?>
                <div class="card">
					<div class="row g-0">
					  <div class="col-md-4 border-end">
                        @foreach($img as $i)
                        <?php 
                            $i=str_replace([']','[']," " ,$i);
                            $i=trim($i); 
                        ?>
                        @endforeach
                        <a href="{{URL::to('/')}}/public/upload/product_img/{{$i}}">
                            <img src="{{URL::to('/')}}/public/upload/product_img/{{$i}}" alt="" class="img-fluid">
                        </a>
						
					  </div>
					  <div class="col-md-8">
						<div class="card-body">
						  <h4 class="card-title" id="summ_productName">{{$data->product_name}}</h4>
						  <div class="d-flex gap-3 py-3">
                            <div class="rating-number">
                                <div class="quick-view-rating">
                                    <i class="pe-7s-star red-star"></i>
                                    <i class="pe-7s-star red-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                                <div class="quick-view-number">
                                    <span>2 Ratting (S)</span>
                                </div>
                            </div>
						  </div>
						  <div class="mb-3"> 
                            
							<span class="price h4">${{$data->product_price}}</span> 
							
						</div>
						  <p class="card-text fs-6">{{$data->product_details}}</p>
						  <dl class="row">
							<dt class="col-sm-3">From</dt>
							<dd class="col-sm-9">{{$data->fromCountry}},{{$data->fromCity}}</dd>
						  
							<dt class="col-sm-3">To</dt>
							<dd class="col-sm-9">{{$data->toCountry}},{{$data->toCIty}}</dd>
						  
							<dt class="col-sm-3">Before</dt>
							<dd class="col-sm-9">{{ date("M d , Y", strtotime($data->during_time))}} </dd>
						  </dl>

                          <dl class="row">
							<dt class="col-sm-3">Reward</dt>
							<dd class="col-sm-9">{{$data->traveller_reward}}</dd>
						  
							<dt class="col-sm-3">Tax</dt>
							<dd class="col-sm-9">{{$data->us_sale_tax}}</dd>
						  
							<dt class="col-sm-3">Buy4Me Fee</dt>
							<dd class="col-sm-9">{{$data->buy4me_fee}} </dd>

                            <dt class="col-sm-3">Payment Processing</dt>
							<dd class="col-sm-9">{{$data->payment}} </dd>
						  </dl>
                          <div class="details-price">
                            <span>Total </span>:-<span id="">{{$data->estimated_total}}</span>
                        </div>
						  <div class="row row-cols-auto row-cols-1 row-cols-md-3 align-items-center">
							<div class="col">
								<label class="form-label">QTY</label>
								<div class="input-group input-spinner">
                                    <span>{{$data->product_qty}}</span>
						
								</div>
							</div> 
							 
							
						</div>
						<div class="d-flex gap-3 mt-3">
						<?php if(url()->previous()==URL::to('/')."/create_order"){  ?>
								<a href="{{route('user.create_order2',['id'=>$data->id])}}" class="btn btn-primary">Request this Item</a>
							<?php }else{ ?>
								<a href="{{route('user.matched_order',['id'=>$data->id,'status'=>$from])}}" class="btn btn-primary">Find Traveller</a>
								<a href="{{route('user.edit_order',['id'=>$data->id])}}" class="btn btn-outline-primary"><span class="text">Edit</span> <i class='bx bxs-cart-alt'></i></a>
								<a href="{{route('user.order_cancle',['id'=>$data->id,'status'=>'cancle'])}}" onclick="return confirm('Are you sure you want to cancle this ?');" class="btn btn-outline-primary"><span class="text">Cancel</span> <i class='bx bxs-cart-alt'></i></a>
							<?php } ?>
						</div>
						</div>
					  </div>
					</div>
                    <hr/>
					<?php if(url()->previous()!=URL::to('/')."/create_order"){  ?>
						<div class="card-body">
							<ul class="nav nav-tabs nav-primary mb-0" role="tablist">
								<li class="nav-item" role="presentation">
									<a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
										<div class="d-flex align-items-center">
											<div class="tab-icon"><i class='bx bx-comment-detail font-18 me-1'></i>
											</div>
											<div class="tab-title"> Product Description </div>
										</div>
									</a>
								</li>
								<li class="nav-item" role="presentation">
									<a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab" aria-selected="false">
										<div class="d-flex align-items-center">
											<div class="tab-icon"><i class='bx bx-bookmark-alt font-18 me-1'></i>
											</div>
											<div class="tab-title">Tags</div>
										</div>
									</a>
								</li>
								<li class="nav-item" role="presentation">
									<a class="nav-link" data-bs-toggle="tab" href="#primarycontact" role="tab" aria-selected="false">
										<div class="d-flex align-items-center">
											<div class="tab-icon"><i class='bx bx-star font-18 me-1'></i>
											</div>
											<div class="tab-title">Reviews</div>
										</div>
									</a>
								</li>
								<li class="nav-item" role="presentation">
									<a class="nav-link" data-bs-toggle="tab" href="#traveller_offer_list" role="tab" aria-selected="false">
										<div class="d-flex align-items-center">
											<div class="tab-icon"><i class='bx bx-star font-18 me-1'></i>
											</div>
											<div class="tab-title">Traveller's offer</div>
										</div>
									</a>
								</li>
							</ul>
							<div class="tab-content pt-3">
								<div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
									<p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi.</p>
									<p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi.</p>
								</div>
								<div class="tab-pane fade" id="primaryprofile" role="tabpanel">
									<p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
								</div>
								<div class="tab-pane fade" id="primarycontact" role="tabpanel">
									<p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
								</div>
								<div class="tab-pane fade" id="traveller_offer_list" role="tabpanel">
									@foreach($TravellerOffer as $row)
										<p>Traveler <b><a href="{{route('user.check_trOffer',['id'=>$row->order_id])}}">{{$row->first_name}} {{$row->last_name}}</a></b> send you Offer for this Product He/She can deliver this product to you for <b>${{number_format($row->product_price, 2, '.', ',') }}</b> and Traveler Rewards for <b>${{number_format($row->travel_reward, 2, '.', ',') }}</b></p>
									@endforeach
								</div>
							</div>
						</div>
					<?php } ?>

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
