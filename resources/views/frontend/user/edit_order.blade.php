@include('frontend.includes.header')
<body>
    @include('frontend.includes.nav')
    <!-- header end -->
    <div class="best-product-area pb-15">
        <div class="pl-100 pr-100">
            <div class="container-fluid">
                <div class="section-title-3 text-center mb-40">
                    <h2>Edit Order</h2>
                </div>
                <form action="{{route('user.update_order')}}" method="post" enctype="multipart/form-data">
                    @csrf 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-input-style mb-30">
                                <label>Product Name</label>
                                <input type="hidden" name="id" value="{{$data->id}}">
                                <input name="product_name" required="" type="text" placeholder="Enter Product Name" value="{{$data->product_name}}">
                            </div>
                            <div class="contact-input-style mb-30">
                                <label>Product Img</label>
                                <input name="product_img[]"  type="file" multiple>
                                <?php
                                    $img=$data->product_imgs;
                                    $img=explode(' , ', $img);
                                ?>
                                <div>
                                    @foreach($img as $i)
                                        <?php 
                                            $i=str_replace([']','[']," " ,$i);
                                            $i=trim($i);
                                        ?>
                                        <img src="{{URL::to('/')}}/public/upload/product_img/{{$i}}" width="50px" height="50px;">
                                    @endforeach
                                </div>
                            </div>
                            <div class="contact-input-style mb-30">
                                <label>Product price</label>
                                <input name="product_price" required="" type="text" placeholder="Enter Product price" value="{{$data->product_price}}">
                            </div>
                            <div class="contact-input-style mb-30">
                                <label>Product qty</label>
                                <input name="product_qty" required="" type="number" placeholder="Enter Product qty" value="{{$data->product_qty}}">
                            </div>
                            <div class="contact-input-style mb-30">
                                <label>Product details</label>
                                <textarea name="product_details" required="">{{$data->product_details}}</textarea>
                            </div>
                            <div class="contact-input-style mb-30">
                                <label>With Box</label>
                                <input name="box" type="checkbox" id="update_product_box" value="{{$data->box}}" >
                            </div>
                            <div class="contact-input-style mb-30">
                                <label>Delivery route</label>
                                <select class="form-select single-select-field " data-placeholder="Choose one thing" name="deliver_from" onchange="getState(this.value,'devliver_fromOrder')">
                                    @foreach($country as $r)
                                        <option <?php if($data->deliver_from_country==$r->id){ echo "selected"; } ?> value="{{$r->id}}">{{$r->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- <div class="contact-input-style mb-30">
                                <label>Delivery From City</label>
                                <select class="form-select single-select-field " data-placeholder="Choose one thing" name="deliver_fromOrderCity" id="deliver_fromOrderCity">
                                    @foreach($state as $r)
                                        <option </?php if($data->deliver_from_state==$r->id){ echo "selected"; } ?> value="{{$r->id}}">{{$r->city_name}}</option>
                                    @endforeach
                                </select>
                            </div> -->
                            <div class="contact-input-style mb-30">
                                <label>Delivery to</label>
                                <select class="form-select single-select-field " data-placeholder="Choose one thing" name="deliver_to" onchange="getState(this.value,'devliver_ToOrder')">
                                    @foreach($country as $r)
                                        <option <?php if($data->deliver_to_country==$r->id){ echo "selected"; } ?> value="{{$r->id}}">{{$r->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="contact-input-style mb-30">
                                <label>Delivery To City</label>
                                <select class="form-select single-select-field " data-placeholder="Choose one thing" name="deliver_toOrderCity" id="deliver_toOrderCity">
                                    @foreach($state_to as $r)
                                        <option <?php if($data->deliver_to_state==$r->id){ echo "selected"; } ?> value="{{$r->id}}">{{$r->city_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="contact-input-style mb-30">
                                <label>How long are you willing to wait?</label>
                                <input name="during_date"  type="date"  min="<?php echo date('Y-m-d'); ?>"  value="<?php echo date('Y-m-d',strtotime($data["during_time"])) ?>" >
                               
                                <button type="submit">Update order</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  <!-- menu area end -->
  @include('frontend.includes.footer')
  <!-- all js here -->
  @include('frontend.includes.footer_script')
</body>
</html>
</body>
</html>
