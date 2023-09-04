// store trip data ===========================================
var base_path = $("#url").val();
$(".store_trip_data").submit(function(e){
    e.preventDefault();
    var user_mobile = $(".user_mobile").val();
    var from_location = $(".from_location").val();
    var to_location = $(".to_location").val();
    var travel_date = $(".travel_date").val();
    var _token = $("input[name=_token]").val();
    if(user_mobile != "")
    {
        $.ajax({
            url: base_path+"/create_trip",
            type:"POST" ,  
            data: {
                user_mobile:user_mobile,
                from_location:from_location,
                to_location:to_location,
                travel_date:travel_date,
                _token:_token
            },
            success:function(response)
            {
                alert("success  Data stored");
                $("#StoreTripDataMo").modal('hide'); 
                window.reload();
            }
        })
    }
    else
    {
        $("#verifyMobileNumberModal").modal('show');
    }
   
});
// end store trip ==================================================
// store order details ============================================
$("#product_with_box").change(function(){
    if($(this).is(':checked'))
    {
        $("#product_with_box").val(1);  // checked
        var lblValue = document.getElementById("summery_Packaging");
        lblValue.innerText =  "With Box";
    }
    else
    {
        $("#product_with_box").val(0);
        var lblValue = document.getElementById("summery_Packaging");
        lblValue.innerText =  "Without Box";
    }
})
$("#update_product_box").change(function(){
    if($(this).is(':checked'))
    {
        $("#update_product_box").val(1); 
    }
    else
    {
        $("#update_product_box").val(0);
    }
})
$(".during_time").change(function(){
    var during_time=$(this).val();
    var lblValue = document.getElementById("summery_Deliverbefore");
    lblValue.innerText =  during_time;    
});
// preview img sing =================================
var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
    
  };


// multipal img preview ====================================
$(function() 
{
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {
        if (input.files) 
        {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) 
            {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };
    $('#product_images_pro').on('change', function() {
        imagesPreview(this, 'div.gallery');
    });
});
function deliver_state_change()
{
    var abc = $('option:selected',"#deliver_to_ordCity").data("name");
    document.getElementById("summery_Deliverto_city").innerText =  abc;
}
function summery_vali(res,buy4meFee,paymentPro,travel_tax)
{
    if(res=='product_name')
    {
        var edValue = document.getElementById("order_productName");
        var s = edValue.value;
        var lblValue = document.getElementById("summ_productName");
        lblValue.innerText =  s;
    }
    if($("#changed_currency_status").val()=='1')
    {
        let INRDollar = new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
        });
        var e=$("#order_product_price").val();
        var res = e.replace('$', "");
        var price=parseFloat(res);
        var qty=parseFloat($("#order_product_qty").val());
        if(qty<=0)
        {
            qty=1;
        }
        var price_to=price*qty;
        var travller_re=price_to*Number(travel_tax)/Number(100);
        if(travller_re<10)
        {
            travller_re=Number(10);
        }
        
        
        var buy4mefee=price_to*Number(buy4meFee)/Number(100);
        var paymentproccessing=price_to*Number(paymentPro)/Number(100);
        var total= price_to+travller_re+buy4mefee+paymentproccessing;      
        $("#summery_pro_price").val(INRDollar.format(price_to)); 
        document.getElementById("summery_estimated_total").value =INRDollar.format(total);
        document.getElementById("summery_traveler_reward").value =INRDollar.format(travller_re);
        document.getElementById("summery_buy4me_fee").value =INRDollar.format(buy4mefee);
        document.getElementById("summery_payment_processing").value =INRDollar.format(paymentproccessing);;
    }
    else
    {
        let USDollar = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        });
        // var exchangeRate = 0.012;
        var qty=parseFloat($("#order_product_qty").val());
        if(qty<=0)
        {
            qty=1;
        }
        var e=$("#order_product_price").val();
        var res = e.replace('₹', "");
        var price=parseFloat(res);
        // var usdValue = (price * exchangeRate).toFixed(2);
        var price_to=price*qty;
        var travller_re=price_to*Number(qty)*Number(travel_tax)/Number(100);
        if(travller_re<10)
        {
            travller_re=Number(10);
        }
        var buy4mefee=price_to*Number(buy4meFee)/Number(100);
        var paymentproccessing=price_to*Number(paymentPro)/Number(100);
        var total= price_to+travller_re+buy4mefee+paymentproccessing;
        $("#summery_pro_price").val(USDollar.format(price_to)); 
        document.getElementById("summery_estimated_total").value =USDollar.format(total);
        document.getElementById("summery_traveler_reward").value =USDollar.format(travller_re);
        document.getElementById("summery_buy4me_fee").value =USDollar.format(buy4mefee);
        // document.getElementById("summery_salesTax").value =salseTax;
        document.getElementById("summery_payment_processing").value =USDollar.format(paymentproccessing);
    }
    if(res=='product_qty')
    {
        var edValue = document.getElementById("order_product_qty");
        var s = edValue.value;
        if(s <=0)
        {
            s=1;
        }
        var lblValue = document.getElementById("summery_Quantity");
        lblValue.innerText =  s;
    }
    if(res=='product_details')
    {
        var edValue = document.getElementById("order_product_details");
        var s = edValue.value;
        var lblValue = document.getElementById("sum_pro_description");
        lblValue.innerText =  s;
    }
}

$("#store_orderwith_details").click(function(){
    var _token = $("input[name=_token]").val();
    var product_link = $("input[name=product_link]").val();
    var product_name = $("input[name=product_name]").val();
    var product_price = $("input[name=product_price]").val();
    var product_qty = $("input[name=product_qty]").val();
    var box = $("input[name=box]").val();
    var product_details = $(".product_details").val();
    var devliver_from_country = $("#delivery_from_ord").val();
    var devliver_to_country = $("#deliver_to_ord").val();
    var devliver_from_city = $("#deliveryFromCity").val();
    var devliver_to_city = $("#deliver_to_ordCity").val();
    // var product_img = $("#product_images").prop('files')[0];   
    var during_time = $(".during_time").val();
    var summery_traveler_reward = $("#summery_traveler_reward").val();
    var summery_buy4me_fee = $("#summery_buy4me_fee").val();
    // var summery_salesTax = $("#summery_salesTax").val();
    var summery_payment_processing = $("#summery_payment_processing").val();
    var summery_estimated_total = $("#summery_estimated_total").val();
    // if(product_link =="")
    // {
    //     Swal.fire('Please Enter Product Link');
    //     return false
    // }
    if(product_name =="")
    {
        Swal.fire('Please Enter Product Name');
        return false
    }
    if(product_price =="")
    {
        Swal.fire('Please Enter Product price');
        return false
    }
    if(product_qty =="")
    {
        Swal.fire('Please Enter Product qty');
        return false
    }
    if(devliver_from_country =="" || devliver_from_country==null)
    {
        Swal.fire('Please select from country');
        return false
    }
    if(devliver_to_country =="" || devliver_to_country==null)
    {
        Swal.fire('Please select to country');
        return false
    }
    if(devliver_to_city =="" || devliver_to_city==null)
    {
        Swal.fire('Please select to City');
        return false
    }
    if($("#product_images_pro").val()=="" || $("#product_images_pro").val()==null)
    {
        Swal.fire('Please select some images');
        return false
    }
    let formData = new FormData();
    $.each($("#product_images_pro")[0].files, function(i, file) {            
        formData.append('file[]', file);
    });
    formData.append("product_link", product_link);
    formData.append("product_name", product_name);
    formData.append("product_price", product_price);
    formData.append("product_qty", product_qty);
    formData.append("box", box);
    formData.append("product_details", product_details);
    formData.append("devliver_from_country", devliver_from_country);
    formData.append("devliver_to_country", devliver_to_country);
    formData.append("devliver_from_city", devliver_from_city);
    formData.append("devliver_to_city", devliver_to_city);
    formData.append("during_time", during_time);
    formData.append("summery_traveler_reward", summery_traveler_reward);
    formData.append("summery_buy4me_fee", summery_buy4me_fee);
    formData.append("summery_payment_processing", summery_payment_processing);
    formData.append("summery_estimated_total", summery_estimated_total);
    formData.append("_token", _token);
    $.ajax({
        enctype: 'multipart/form-data',
        url: base_path+"/order_product",
        type:"POST" , 
        contentType: false,
        processData: false, 
        data:formData,
        success:function(response)
        {
            Swal.fire(
                'Good job!',
                'Verifyed Your Order',
                'success'
            )
            location.href=base_path+"/order_details/"+response.id;
        }
        // ,
        // error:function(res){
        //     location.href=base_path+"/login";
        // }
    })
});
if($("#update_product_box").val() == 1)
{
    $("#update_product_box").attr("checked", "checked");
}

// update user profile setting ==========================================
$(".update_pro_setting").click(function(){
    var _token = $("input[name=_token]").val();
    var id=$("input[name=id]").val();
    var first_name=$("input[name=first_name]").val();
    var last_name=$("input[name=last_name]").val();
    var email=$("input[name=email]").val();
    var email=$("input[name=email]").val();
    var mobile=$("input[name=mobile]").val();
    var description=$("#biotextarea").val();
    var profile = $("#profile_img_up").prop('files')[0]; 
    let formData = new FormData();
    formData.append("id", id);
    formData.append("first_name", first_name);
    formData.append("last_name", last_name);
    formData.append("email", email);
    formData.append("mobile", mobile);
    formData.append("description", description);
    formData.append("profile", profile);
    formData.append("_token", _token); 
    // alert("DFDdg");
    $.ajax({
        enctype: 'multipart/form-data',
        url: base_path+"/edit_profile_data",
        type:"POST" , 
        contentType: false,
        processData: false, 
        data:formData,
        success:function(response)
        {
            Swal.fire(
                'Good job!',
                'Verifyed Your Order',
                'success'
            )
        }
    })
})
// profile updated end ===============================================

// create_order===================================================
// header("Access-Control-Allow-Origin: *");
$("#create_order").click(function(){
 
    // alert("bnbm");
    var url=$("#fromduct_from_url").val();
    if(url=="")
    {
        alert("enter any product link");
        return false;
    }
    location.href=base_path+"/fetch-amazon-data/"+url;
    // $.get(url).then(function(responseData) {
    //     $('#display').append(responseData);
    //   });
    // $("#display").load(url);
    // $.ajax({
    //     url:base_path+"/fetch-amazon-data",
    //     type:"get" , 
    //     success:function(response)
    //     {
    //         // console.log(response);
    //         // alert(response)
    //         // // location.href=base_path+"/product_details";
    //         // // $("#order_product_price").val();
    //     }
    // });
});


// make delivery offer =======================
$("body").on('click',"#make_delivery_offer",function(){
    var _token = $("#token").val();
    var pro_total_price_changed=$("#pro_total_price_changed").val();
    var travel=$("#pro_traveller_price_changed").val();
    var change_product_price_fee=$("#pro_p_price_changed").val();
    var or_id=$("#or_id").val();
    let formData = new FormData();
    formData.append("_token", _token);
    formData.append("pro_total_price_changed", pro_total_price_changed);
    formData.append("travel", travel);
    formData.append("change_product_price_fee", change_product_price_fee);
    formData.append("or_id", or_id);
    $.ajax({
        url: base_path+"/travel-make_deliveryOffer",
        type:"POST" , 
        contentType: false,
        processData: false, 
        data:formData,
        success:function(response)
        {
            Swal.fire(
                'Good job!',
                'Verifyed Your Order',
                'success'
            )
            location.href=base_path+"/trip";
        }
    })
});