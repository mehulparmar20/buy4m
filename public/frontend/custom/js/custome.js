var base_path = $("#url").val();
// fatch country =============================

$(document).ready(function() {
    $(".browsers_country").html("");
    $.ajax({
        type:'get',
        url: base_path+"/admin-fatch_country",
        success:function(res){
            $(".browsers_country").append(res);
        }
    })
})
const tabs = document.querySelectorAll('[data-tab-value]')
const tabInfos = document.querySelectorAll('[data-tab-info]')
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        const target = document
            .querySelector(tab.dataset.tabValue);

        tabInfos.forEach(tabInfo => {
            tabInfo.classList.remove('active')
        })
        target.classList.add('active');
    })
});

// open add trip modal 
$("#AddTripModal").click(function(){
    $("#StoreTripDataMo").modal('show');
});
$(".closeTripModal").click(function(){
    $("#StoreTripDataMo").modal('hide'); 
});
// close verify mobile number 
$(".closeverifyMobileNumberModal").click(function(){
    $("#verifyMobileNumberModal").modal('hide'); 
});
// accept only number -==============================
function allowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 48 || code > 57)) {
        e.preventDefault();
    }
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


//settings page active and close menus (toggle menus)



document.addEventListener('DOMContentLoaded', function() {
    var menuItems = document.getElementsByClassName('menu-list');
    var contents = document.getElementsByClassName('content-container');

    // Set initial active state
    menuItems[0].classList.add('active');
    contents[0].style.display = 'block';

    for (var i = 0; i < menuItems.length; i++) {
      menuItems[i].addEventListener('click', function() {
        var target = this.getAttribute('data-target');

        for (var j = 0; j < contents.length; j++) {
          contents[j].style.display = 'none';
          menuItems[j].classList.remove('active');
        }

        document.getElementById(target).style.display = 'block';
        this.classList.add('active');
      });
    }
  });
  
//   upload button function in settings page starts
  
var uploadButton = document.getElementById("upload-btn");
uploadButton.addEventListener("click", openFileManager);

function openFileManager() {
    // Create an invisible file input element
    var fileInput = document.createElement("input");
    fileInput.type = "file";
    fileInput.style.display = "none";

    // Trigger a click event on the file input element
    fileInput.click();

    // When a file is selected, handle the upload logic
    fileInput.onchange = function(event) {
    var selectedFile = event.target.files[0];

    // Perform the necessary actions with the selected file
    // For example, you can upload it to a server using AJAX or process it in some way

        console.log("Selected file:", selectedFile);
    };
}
  

//   upload button function in settings page ends


// profile page pending hover starts

var statusBtn = document.getElementById('statusBtn');

statusBtn.addEventListener("click", function(){
   console.log("clicked");
});

// profile page pending hover ends

// get city name 
function getState(res,fun)
{
    $.ajax({
        type:'get',
        url: base_path+"/admin-fatch_state",
        data:{id:res},
        success:function(result){
            if(fun=="from_travel")
            {
                $("#travel_from_state").html("");
                $("#travel_from_state").append(result);
            }
            if(fun=="to_travel")
            {
                $("#travel_to_state").html("");
                $("#travel_to_state").append(result);
            }
            if(fun=="devliver_from")
            {
                var abc = $('option:selected',"#delivery_from_ord").data("name");
                document.getElementById("summery_Deliverfrom").innerText =  abc;
                $("#deliveryFromCity").html("");
                $("#deliveryFromCity").append(result);
            }
            if(fun=="deliver_to_ord")
            {
                var abc = $('option:selected',"#deliver_to_ord").data("name");
                document.getElementById("summery_Deliverto").innerText =  abc;
                $("#deliver_to_ordCity").html("");
                $("#deliver_to_ordCity").append(result);
            }
            if(fun=="devliver_fromOrder")
            {
                $("#deliver_fromOrderCity").html("");
                $("#deliver_fromOrderCity").append(result);
            }
            if(fun=="devliver_ToOrder")
            {
                $("#deliver_toOrderCity").html("");
                $("#deliver_toOrderCity").append(result);
            }
            
        }
    })
}

// profile active class add 
$("body").on('click','.account_details_active',function(){
    // alert("Fdfdsfsd");
    $('ul.list-group li.profile').removeClass('active');
    $('ul.list-group li.account').addClass('active');
});


function chnagePriceTraveller(res,buy4meFee,paymentPro,travel_tax)
{
    var buy4meFee = buy4meFee.replace('$','')
    var paymentPro = paymentPro.replace('$','')
    var travel=document.getElementById("change_travel_fee").value;
    if(travel =="")
    {
        var travel = travel_tax.replace('$','')
    }
    var change_product_price_fee = document.getElementById("change_product_price_fee").value;
    if(change_product_price_fee =="")
    {
        var change_product_price_fee =  document.getElementById("pro_ch_price").value;
    }
    var r = buy4meFee.replace('$', " " ,'rs','.');
    var qty = document.getElementById("qty_ch_price").value;
    buy4meFee= Number(change_product_price_fee)*5/100;
    paymentPro=Number(change_product_price_fee)*5/100;
    // travel=Number(change_product_price_fee)*10/100;
    var total= Number(change_product_price_fee)+Number(buy4meFee)+Number(paymentPro)+Number(travel)*Number(qty);
    // alert(r);
    // alert(total);
    $("#changed_traveller_re_tr").text('$'+travel);
    $("#changed_pro_price_tr").text('$'+change_product_price_fee);
    $("#changed_totalPrice_tr").text('$'+total);
    $("#pro_total_price_changed").val('$'+total);
    $("#pro_traveller_price_changed").val('$'+travel);
    $("#pro_p_price_changed").val('$'+change_product_price_fee);
    
}

// change currency 
function updateCurrency(buy4meFee,paymentPro,travel_tax)
{
    var inrValue=$("#change_currency").val();
    if(inrValue=='1')
    {
        $("#changed_currency_status").val('1');
        let INRDollar = new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
        });
        var exchangeRate = 82.61;
        var e=$("#order_product_price").val();
        var res = e.replace('$', "");
        var price=parseFloat(res);
        var qty=parseFloat($("#order_product_qty").val());
        if(qty<=0)
        {
            qty=1;
        }
        var usdValue = (price * exchangeRate).toFixed(2);
        $("#order_product_price").val("₹"+usdValue);
        var travller_re=usdValue*qty*Number(travel_tax)/Number(100);
        if(travller_re<10)
        {
            travller_re=Number(10);
        }
        
        var price_to=usdValue*qty;
        var buy4mefee=price_to*Number(buy4meFee)/Number(100);
        var paymentproccessing=price_to*Number(paymentPro)/Number(100);
        var total= price_to+travller_re+buy4mefee+paymentproccessing;      
        $("#summery_pro_price").val(INRDollar.format(price_to)); 
        document.getElementById("summery_estimated_total").value =INRDollar.format(total);
        document.getElementById("summery_traveler_reward").value =INRDollar.format(travller_re);
        document.getElementById("summery_buy4me_fee").value =INRDollar.format(buy4mefee);
        // document.getElementById("summery_salesTax").value ="₹"+salseTax;
        document.getElementById("summery_payment_processing").value =INRDollar.format(paymentproccessing);
    }
    else
    {
        $("#changed_currency_status").val("2");
        let USDollar = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        });
        var exchangeRate = 0.012;
        var qty=parseFloat($("#order_product_qty").val());
        if(qty<=0)
        {
            qty=1;
        }
        var e=$("#order_product_price").val();
        var res = e.replace('₹', "");
        var price=parseFloat(res);
        var usdValue = (price * exchangeRate).toFixed(2);
        $("#order_product_price").val(USDollar.format(usdValue));
        var price_to=usdValue*qty;
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
}

