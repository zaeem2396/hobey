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
.content {
    width: 100%;
    min-height: 90%;
    background: #fff;
    border-radius: 10px;
    padding: 30px;
    display: flex;
}
.product_list_right_main ul li {    background: #ccc;padding: 50px 10px;}
.product_list_right_main ul a li h2 {color:#000;}
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
                            <h4>Personal Details</h4>
                        </div>
                    </div>

                   <!--  <span id="error_profile" class="error alert-message valierror form-control" style="display:none;margin-bottom: 5px;"></span> -->
                    <div id="error_profile" class="alert-message valierror form-group" style="display:none;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>

                    <span id="register_success" class="alert-message successmain valierror123 form-group" style="display:none;margin-bottom: 5px;"></span>
                    <!-- <div class="topalert successmain alert-message" id="register_success" style="display:none;"><?php echo $this->session->flashdata('register_success'); ?></div> -->
                     <form action="" method="POST" id="form_profile" enctype="multipart/form-data" action="<?php echo $base_url;?>vendor-my-account">
                        <input type="hidden" name="action" value="update_profile">  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input placeholder="Full Name" class="form-control" name="fname" id="fname_pro" type="text" value="<?php echo $profile->name; ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                <input placeholder="Email ID" class="form-control" readonly type="text" value="<?php echo $profile->email; ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                                <input placeholder="Mobile Number" id="mobile_pro" name="mobile" class="form-control" type="text" value="<?php echo $profile->mobile; ?>">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                                <input placeholder="Bank Name" class="form-control" name="bank_name" id="bank_name" type="text" value="<?php echo $profile->bank_name; ?>">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                                <input placeholder="Account no" class="form-control" name="account_no" id="account_no" type="text" value="<?php echo $profile->account_no; ?>">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                                <input placeholder="IFSC code" class="form-control" name="ifsc_code" id="ifsc_code" type="text" value="<?php echo $profile->ifsc_code; ?>">
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
    var fname = $("#fname_pro").val();
    if(fname == ''){
        
        $('#error_profile').html("Please Enter Full Name");     
        $('#error_profile').show().delay(0).fadeIn('show');
        $('#error_profile').show().delay(6000).fadeOut('show');
        return false;
    }
    
    var mobile = $("#mobile_pro").val();
    if(mobile == ''){
        $('#error_profile').html("Please Enter Mobile Number");     
        $('#error_profile').show().delay(0).fadeIn('show');
        $('#error_profile').show().delay(6000).fadeOut('show');
        return false;
    }
        var em = $('#mobile_pro').val();
        var filter =/^[0-9]{10}$/;
        if (!filter.test(em)) {
        $('#error_profile').html("Enter Mobile Number should be 10 digits.");
        $('#error_profile').show().delay(0).fadeIn('show');
        $('#error_profile').show().delay(2000).fadeOut('show');
            return false;
        } 
        $('#form_profile').submit();
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