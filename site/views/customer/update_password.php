<?php include('includes/header.php');?>
<div class="topalert successmain alert-message" id="order_succsess" style="display:none;"></div>    
<!--navBar content End-->
<!--Product page-->
<div class="container">
        <div class="row mb-50 pdd50">
            <!--Right product section -->    
            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="brand-name-wrap">
                            <span class="brand-name-title"> <a href="<?php echo $base_url; ?>"><i class="fa fa-home" aria-hidden="true"></i></a></span>
                            <span class="product-total">Update Password</span>
                        </div>
                    </div>
                </div>
                
                <div class="product-images">                
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                        <form action="<?php echo $base_url; ?>home/update_password/<?php echo $id; ?>" method="post" id="forgot_submit">
                             <input type="hidden" id="action" name="action" value="reset_password" >
                              <input type="hidden" id="user_id" name="user_id" value="<?php echo $id; ?>" >
                            <div id="error_reset" class="alert-message valierror " style="display:none;width: 100%;">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>
                            
                            <div id="sucess_reset" class="alert-message " style="display:none;width: 100%;background-color:green;">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            </div>
                           
                        <div class="form-group">
                          <label for="password">Enter New Password:</label>
                          <input type="password" placeholder="Enter Enter New Password" class="form-control" name="new_password" id="new_password">
                        </div>
                        
                        <div class="clearfix">
                            <div class="pull-left"><button type="button" onClick="javascript:forgotsubmit(); return false;" class="btn btn-default-red">Reset Password  <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button></div>
                            <div class="pull-right forgot-login-text">
                                <a class="login" href="#login-form">Login to your Account</a>
                            </div>
                        </div>
                        </form>
                    </div>
                        <div class="col-md-3"></div>
                    </div>
                    </div>
                </div>
                
            </div>
            <!--Right product section End-->        
        </div>    
</div>
<!--Product page End-->

<?php include('includes/footer.php');?>

<script>
function forgotsubmit(){

     var new_password = jQuery('#new_password').val();
        if(new_password == ''){
            
        jQuery("#error_reset").html("Please Enter New Password.");
        jQuery('#error_reset').show().delay(0).fadeIn('show');
        jQuery('#error_reset').show().delay(2000).fadeOut('show');
        return false;
        }

        jQuery('#forgot_submit').submit();  

}



</script>


    <?php if ($this->session->flashdata('success_password')) { ?>
            <script>    
        jQuery(document).ready(function(){
                jQuery('#forgot_succsess').html("<?php echo $this->session->flashdata('success_password'); ?>");
                jQuery('#forgot_succsess').show().delay(0).fadeIn('show');
                jQuery('#forgot_succsess').show().delay(6000).fadeOut('show');
        });

        </script>
        <?php } ?>


        <?php if ($this->session->flashdata('error_password')) { ?>
            <script> 
        jQuery(document).ready(function(){
                jQuery('#errorloginoneforhot').html("<?php echo $this->session->flashdata('error_password'); ?>");
                jQuery('#errorloginoneforhot').show().delay(0).fadeIn('show');
                jQuery('#errorloginoneforhot').show().delay(6000).fadeOut('show');
        });

        </script>
        <?php } ?>