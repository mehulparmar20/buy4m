var base_path = $("#url").val();
// accept only number -==============================
function allowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 48 || code > 57)) {
        e.preventDefault();
    }
}
// data table ===========================================================
$(document).ready(function() {
    $('#country_table').DataTable();
  } );
// form validation ========================================================
(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
      .forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }

          form.classList.add('was-validated')
        }, false)
      })
  })()

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
});
// update tax % ==========================
function UpdateTax()
{
  $("#viewTaxData").html("");
  $.ajax({
    type:'get',
    url: base_path+"/admin-indexTax",
    success:function(res){
      $("#viewTaxData").append(res);
    }
  })
  $("#ListTaxModal").modal("show");
}
$('body').on('click','#tax_update',function(){
  var id=$(this).attr("data-value");
  $.ajax({
    type:'get',
    url: base_path+"/admin-editTax",
    data:{id:id},
    success:function(res){
        $("#tax_id").val(res.id);
        $("#buy4me_fee").val(res.buy4meFee);
        $("#payment_proccessing_tax").val(res.payment_proccessing_tax);
        $("#travel_tax").val(res.travel_tax);
    }
  })
  $("#update_tax").modal("show");
});
$("#update_taxData").click(function(){
  var _token=$("#token").val();
  var id=$("#tax_id").val();
  var buy4me_fee=$("#buy4me_fee").val();
  var payment_proccessing_tax=$("#payment_proccessing_tax").val();
  var travel_tax=$("#travel_tax").val();
  if(buy4me_fee =="" || buy4me_fee== null)
  {
    alert("buy4me fee required (%)")
    return false;
  }
  if(payment_proccessing_tax =="" || payment_proccessing_tax== null)
  {
    alert("Payment Proccessing tax required (%)")
    return false;
  }
  if(travel_tax =="" || travel_tax== null)
  {
    alert("Travel tax required (%)")
    return false;
  }
  var formData=new FormData();
  formData.append('_token',_token);
  formData.append('id',id);
  formData.append('buy4me_fee',buy4me_fee);
  formData.append('payment_proccessing_tax',payment_proccessing_tax);
  formData.append('travel_tax',travel_tax);

  $.ajax({
    type:'POST',
    processData: false,
    contentType: false,
    cache: false,
    async: false,
    data:formData,
    url:base_path+"/admin-updateTax",
    success:function(){
      alert("success");
      $("#update_tax").modal("hide");
      UpdateTax();
    }
  })
});