<?php
$front_base_url = $this->config->item('front_base_url');
$base_url     = $this->config->item('base_url');
$index_url    = $this->config->item('index_url');
$findex_url     = $this->config->item('findex_url');
$base_url_views = $this->config->item('base_url_views');
$http_host = $this->config->item('http_host');
?>
<style>
    .common {
    width: 100%;
    max-width: 200px;
    padding-top:10px;
}
    .overlay_search .closebtn {
     position: absolute;
    top: 5px;
    right: 10px;
    font-size: 40px;
    cursor: pointer;
    color: #c26573;
}
.overlay_search input[type=text] {
    padding: 0 10px;
    font-size: 15px;
    border: none;
    width: 100%;
    background: #cedde0;
    height: 41px;
}
    .overlay-content {
    width: 1170px;
    margin: 0 auto;
    position: relative;
}
.overlay_search {
    width: 100%;
    position: absolute;
    display: none;
    z-index: 99999999999999;
    top: 80px;
    left: 0;
    background-color: #cedde0;
}
    .successmain {
        background-color:#008000;
        border-color: #008000;
    }
    .valierror{
        background-color:#ee2e34;
        border-color: #ee2e34;
        color: #fff;
    }
    .topalert{ z-index:9999; text-align:center; padding:10px; font-size:18px; color:#fff;  position: fixed; top:0px;}
    .alert-message{
        background-size: 40px 40px;
        background-image: linear-gradient(135deg, rgba(255, 255, 255, .05) 25%, transparent 25%,
                            transparent 50%, rgba(255, 255, 255, .05) 50%, rgba(255, 255, 255, .05) 75%,
                            transparent 75%, transparent);                                      
       /*  box-shadow: inset 0 -1px 0 rgba(255,255,255,.4);*/
         width: 100%;
         border: 0px solid;
         color: #fff;
         padding: 10px;
         /*position: fixed;*/
        /* _position: absolute;
         text-shadow: 0 1px 0 rgba(0,0,0,.5);*/
         animation: animate-bg 5s linear infinite;
         display:block;
         margin-bottom:10px;
         z-index:999999999999;
    }
    .top-nav-collapse
    {
        height:0;
    }
    </style>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <title>Bharat Petroleum |Oil & Gas Companies in India |Top Petroleum Companies | Petroleum Distribution companies</title>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $base_url_views; ?>assets/css/login.css">
</head>
<body>
  <main>
    <div class="container-fluid">
      <div class="row">
	   <div class="col-sm-6 px-0 d-none d-sm-block">
          <img src="<?php echo $base_url_views; ?>assets/images/login.png" alt="login image" class="login-img">
        </div>
        <div class="col-sm-6 login-section-wrapper">
          <div class="brand-wrapper">
            <img src="<?php echo $base_url_views; ?>assets/images/logo-new.png" alt="logo" class="logo">
          </div>
          <div class="login-wrapper my-auto">
            <h1 class="login-title">Log in</h1>
            <form method="post" action="<?php echo $base_url;?>home/login1" id="login_form_header" >
            <input type="hidden" name="action" value="login"/>  
            <input type="hidden" name="page_redirect" value="<?php echo @$_SERVER['HTTP_REFERER']; ?>"/> 
            <span id="login_succsess" class="alert-message valierror123 form-control" style="display:none;"></span>
                            
            <div id="login_error" class="alert-message valierror form-group" style="display:none;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>
              <div class="form-group">
         
                <input type="email" name="login_email" id="login_email" class="form-control" placeholder="Email ID">
              </div>
              <div class="form-group mb-4">
            
                <input type="password" name="login_password" id="login_password" class="form-control" placeholder="Password">
              </div>
              <input name="login" id="login" class="btn btn-block login-btn" onClick="javascript:header_logins(); return false;" type="button" value="Login">
            </form>
            <a href="#!" class="forgot-password-link" data-toggle="modal" data-target="#myModal">Forgot password?</a>
          </div>
        </div>
       
      </div>
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content ">
	  
        <div class="modal-header">
          
          <h4 class="modal-title">Forgot password?</h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
         <form action="<?php echo $base_url;?>home/reset_password" method="post" id="reset_form">
            <div id="error_reset" class="alert-message valierror " style="display:none;width: 100%;">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>
            
            <div id="sucess_reset" class="alert-message " style="display:none;width: 100%;background-color:green;">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            </div>
          <div class="modal-body">
		<div class="login-wrapper my-auto">
         <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="reset_email" name="reset_email" class="form-control" placeholder="email@example.com">
              </div>
			    <input name="login" id="login" class="btn btn-block login-btn" onClick="javascript:reset_password(); return false;" type="button" value="Submit">
			
			  </div>
        </div>
		</form>
      </div>
      
    </div>
  </div>
  <script>
    jQuery(document).ready(function(){
        $("#login_email").on('keyup', function (e) {
            if (e.keyCode === 13) {
                 $("#loginevent").trigger('click');   
            }
        });
        $("#login_password").on('keyup', function (e) {
            if (e.keyCode === 13) {
                 $("#loginevent").trigger('click');   
            }
        });
    });
    
function header_logins(){ 
    var email =jQuery("#login_email").val();
    if(email == ''){
        
        jQuery('#login_error').html("Please enter Email Id");       
        jQuery('#login_error').show().delay(0).fadeIn('show');
        jQuery('#login_error').show().delay(2000).fadeOut('show');
        return false;
    }
    
    
        var em = jQuery('#login_email').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(em)) {
                
        jQuery('#login_error').html("Enter Valid Email Address.");
        jQuery('#login_error').show().delay(0).fadeIn('show');
        jQuery('#login_error').show().delay(2000).fadeOut('show');
            //em.focus;
            return false;
        }
    
        var password = jQuery("#login_password").val();
        
    if(password == ''){
        jQuery('#login_error').html("Please enter Password");
        jQuery('#login_error').show().delay(0).fadeIn('show');
        jQuery('#login_error').show().delay(2000).fadeOut('show');
        
        return false;
    } 
    
    var url ='<?php echo $base_url; ?>home/checlogin';
    jQuery.ajax({
    url:url,
    type:'post',
    data:'email='+email+'&password='+password,
    success:function(msg)
    {
        //console.log(msg);
        //return false;
        if(msg =="0"){  
            jQuery('#login_error').html("Please enter Correct Email & Password");
            jQuery('#login_error').show().delay(0).fadeIn('show');
            jQuery('#login_error').show().delay(2000).fadeOut('show');
            return false;   
        }
        else if(msg =="1")
        {
            jQuery('#login_error').html("Your account is not activated. Please contact admin to activate your account.");
            jQuery('#login_error').show().delay(0).fadeIn('show');
            jQuery('#login_error').show().delay(2000).fadeOut('show');
            return false;   
        }
        else{
            jQuery('#login_form_header').submit();  
        }
            
    }
  });
    
}   



function reset_password(){ 
    
        var reset_email = $("#reset_email").val();
        if(reset_email == ''){
            
            $('#error_reset').html("Please enter Email Id");        
            $('#error_reset').show().delay(0).fadeIn('show');
            $('#error_reset').show().delay(2000).fadeOut('show');
            return false;
        }
        
        var em = $('#reset_email').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(em)) {
        $('#error_reset').html("Enter Valid Email Address.");
        $('#error_reset').show().delay(0).fadeIn('show');
        $('#error_reset').show().delay(2000).fadeOut('show');
            return false;
        }
            var url ='<?php echo $base_url; ?>home/checkemail_vendor';
            $.ajax({
            url:url,
            type:'post',
            data:'email='+reset_email,
            success:function(msg)
            {
                if(msg =="1"){  
                        $('#error_reset').html("Email id dose not exist");
                        $('#error_reset').show().delay(0).fadeIn('show');
                        $('#error_reset').show().delay(2000).fadeOut('show');
                            return false;   
                }
                else{
                    var url ='<?php echo $base_url; ?>home/reset_password_vendor_distri';
                            $.ajax({
                            url:url,
                            type:'post',
                            data:'reset_email='+reset_email,
                            success:function(msg)
                            {
                                if(msg =="1"){  
                                    $('#reset_email').val('');
                                    $('#sucess_reset').html("Email has been sent successfully");
                                    $('#sucess_reset').show().delay(0).fadeIn('show');
                                    $('#sucess_reset').show().delay(2000).fadeOut('show');
                                    return false;   
                                }  else 
                                {
                                    $('#reset_email').val('');
                                    $('#sucess_reset').html("The email ID does not exist.");
                                    $('#sucess_reset').show().delay(0).fadeIn('show');
                                    $('#sucess_reset').show().delay(2000).fadeOut('show');
                                    return false;   
                                }

                            }
                          });
                        /*  $('#reset_form').submit();  */
                }
                    
            }
          });
    
}   
</script>
</body>
</html>
