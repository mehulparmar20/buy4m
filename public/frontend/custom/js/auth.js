var base_path = $("#url").val();
//login ================================================================
function openLogin()
{
    $("#email_login").val("");
    $("#password_login").val("");
    $("#login_form_modal").show();
    $("#registrion_form_modal").hide();
    $("#openLoginModal").modal("show");
}
function go_registrion_modal()
{
   
    $("#login_form_modal").hide();
    $("#registrion_form_modal").show();
}
function go_login(){
    $("#login_form_modal").show();
    $("#registrion_form_modal").hide();
}

function closeLoginModal()
{
    $("#openLoginModal").modal("hide");
}
$("body").on('click',"#login_auth",function(){
    var _token = $("#token").val();
    var email=$("#email_login").val();
    var password=$("#password_login").val();
    var previous_url=$("#get_url_re").val();
    if(email=="" || email==null)
    {
        Swal.fire('Please enter email address');
        return false;
    }
    if(password=="" || password==null)
    {
        Swal.fire('Please enter password');
        return false;
    }
    let formData = new FormData();
    formData.append("_token", _token);
    formData.append("email", email);
    formData.append("password", password);
    formData.append("sub", 'modal');
    formData.append("previous_url", previous_url);
    $.ajax({
        url: base_path+"/user_login",
        type:"POST" , 
        contentType: false,
        processData: false, 
        data:formData,
        success:function(response)
        {
            if(response.status=='200')
            {
                Swal.fire(
                    'Good job!',
                    'Successfully Logged in ...',
                    'success'
                )
                if(response.email_status=='1')
                {
                    $.ajax({url: base_path+"/nav", success: function(result){
                            $('#header_navbar').html(result);
                        }
                    });
                    $("#reload_div_auth").html('<button  class="btn btn-primary px-4" onclick="stepper1.next()">Next<i class="bx bx-right-arrow-alt ms-2"></i></button>');
                    $("#trip_check_verify").html(' <button type="submit" class="menu-btn1 btn-hover">Add Trip</button>');
                }
                else
                {
                    $.ajax({url: base_path+"/nav", success: function(result){
                            $('#header_navbar').html(result);
                        }   
                    });
                    // $("#emailverifyPopup").modal("show");
                    location.href=base_path+"/verify/check_mail";
                }
            }
            else
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please enter right info....' 
                })
            }
            
            closeLoginModal();
        },error:function(){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Please enter right info....' 
              })
        }
    })
});
// login end =======================================================

// registion ======================================================
$("body").on('click',"#registrion_auth",function(){
    var _token = $("#token").val();
    var email=$("#email_registrion").val();
    var password=$("#password_registrion").val();
    // var previous_url=$("#get_url_re").val();
    var first_name=$("#first_name_registrion").val();
    var last_name=$("#last_name_registrion").val();
    if(first_name=="" || first_name==null)
    {
        Swal.fire('Please enter first name ');
        return false;
    }
    if(last_name=="" || last_name==null)
    {
        Swal.fire('Please enter last name');
        return false;
    }
    if(email=="" || email==null)
    {
        Swal.fire('Please enter email address');
        return false;
    }
    if(password=="" || password==null)
    {
        Swal.fire('Please enter password');
        return false;
    }
    let formData = new FormData();
    formData.append("_token", _token);
    formData.append("email", email);
    formData.append("password", password);
    formData.append("sub", 'modal');
    formData.append("first_name", first_name);
    formData.append("last_name", last_name);
    $.ajax({
        url: base_path+"/user-registration",
        type:"POST" , 
        contentType: false,
        processData: false, 
        data:formData,
        success:function(response)
        {
            if(response.status=='200')
            {
                Swal.fire(
                    'Good job!',
                    'Successfully registered ...',
                    'success'
                )
                if(response.email_status=='1')
                {
                    $.ajax({url: base_path+"/nav", success: function(result){
                            $('#header_navbar').html(result);
                        }
                    });
                    $("#reload_div_auth").html('<button  class="btn btn-primary px-4" onclick="stepper1.next()">Next<i class="bx bx-right-arrow-alt ms-2"></i></button>');
                    $("#trip_check_verify").html(' <button type="submit" class="menu-btn1 btn-hover">Add Trip</button>');
                }
                else
                {
                    $.ajax({url: base_path+"/nav", success: function(result){
                            $('#header_navbar').html(result);
                        }   
                    });
                    // $("#emailverifyPopup").modal("show");
                    location.href=base_path+"/verify/check_mail";
                }
                   
            }
            else
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Email already exits  Please try again !.... ' 
                })
            }
            
            closeLoginModal();
        },error:function(){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Please enter right info....' 
              })
        }
    })
});
// end registrion =================================================