<?php include('includes/header.php');?>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
<link href="<?php echo $base_url_views; ?>customer/css/stylesheet.css" rel="stylesheet">
<link href="<?php echo $base_url_views; ?>customer/css/easy-responsive-tabs.css" rel="stylesheet">
<style>
footer {
    background: #000;
    text-align: center;
    color: #fff;
    padding-top: 20px;
    padding-bottom: 10px;
    position: fixed;
    width: 100%;
    bottom: 0;
}
.product_list_right_main ul li {    background: #ccc;padding: 50px 10px;}
.product_list_right_main ul a li h2 {color:#000;}
.successmain {

        background-color:#008000;

        border-color: #008000;

    }

</style>

<section class=" login-reg">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
<?php include('includes/sidebar_vendor.php');?>
<div class="content-wrapper">
  <div class="content">
      
      <div class="checkout-area mb-65">
           	<div class="col-md-12">
            <div id="verticalTab">
                   <div class="row">
                        <div class="col-md-12">
                            <h4>Change Password</h4>
                        </div>
                    </div>


                    <div id="error_profile" class="alert-message valierror form-group" style="display:none;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>

                    <span id="register_success" class="alert-message successmain valierror123 form-group" style="display:none;margin-bottom: 5px;"></span>
                    <!-- <div class="topalert successmain alert-message" id="register_success" style="display:none;"><?php echo $this->session->flashdata('register_success'); ?></div> -->
                     <form action="" method="POST" id="form_profile" enctype="multipart/form-data" action="<?php echo $base_url;?>vendor-my-account">
                        <input type="hidden" name="action" value="update_profile">  
                    <div class="row">

                        <div class="col-xs-12 col-md-12">
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
                                <input placeholder="Current Password" value="" name="old_password" id="old_password" class="form-control" type="password">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
                                <input placeholder="New Password" value="" name="pass" id="pass" class="form-control" type="password">
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
                                <input placeholder="Confirm Password" name="cpass"
                                        value="" id="cpass" class="form-control" type="password">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="button" onClick="javascript:profile_form_vali(); return false;" class="btn btn-default-red">Save Changes <i class="fa fa-check" aria-hidden="true"></i></button>
                        </div>
                        
                    </div>
                </form>
            </div>        	
        </div>       	
        </div>
      </div>
         
	</div>
  </div>
</div>
            </div>
      
</section>
<?php include('includes/footer.php');?>
<script>
function profile_form_vali()
{   
    var old_password = jQuery("#old_password").val();
    if (old_password == '') {
        jQuery('#error_profile').html("Please Enter Current Password");
        jQuery('#error_profile').show().delay(0).fadeIn('show');
        jQuery('#error_profile').show().delay(2000).fadeOut('show');
        return false;
    }   

    var old_password_check = '<?php echo $profile->password; ?>';

    if(old_password != old_password_check){
        jQuery('#error_profile').html("Old password entered is invalid. please enter valid password");
        jQuery('#error_profile').show().delay(0).fadeIn('show');
        jQuery('#error_profile').show().delay(2000).fadeOut('show');
        return false;
    }

    var fname = jQuery("#pass").val();
    if (fname == '') {
        jQuery('#error_profile').html("Please Enter New Password");
        jQuery('#error_profile').show().delay(0).fadeIn('show');
        jQuery('#error_profile').show().delay(2000).fadeOut('show');
        return false;
    }
    var lname = jQuery("#cpass").val();
    if (lname == '') {
        jQuery('#error_profile').html("Please Enter Confirm New Password");
        jQuery('#error_profile').show().delay(0).fadeIn('show');
        jQuery('#error_profile').show().delay(2000).fadeOut('show');
        return false;
    }
    
    if(fname != lname){
        jQuery('#error_profile').html("New Password & Confirm Password doesn't Match");
        jQuery('#error_profile').show().delay(0).fadeIn('show');
        jQuery('#error_profile').show().delay(2000).fadeOut('show');
        return false;
    }
  
    jQuery('#form_profile').submit();
}
</script>
<?php if($this->session->flashdata('register_success') !=""){ ?>
<script>    
$(document).ready(function(){
     //$('#messagealert').modal();
     $('#register_success').html("<?php echo $this->session->flashdata('register_success'); ?>");
        $('#register_success').show().delay(0).fadeIn('show');
        $('#register_success').show().delay(6000).fadeOut('show');
    
});
</script>

<?php } ?>