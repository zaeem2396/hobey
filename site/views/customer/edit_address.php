<?php include('includes/header.php');?>

<!--navBar content End-->
<!--Product page-->
<div class="container">
	<div class="row mb-50 pdd50">
	    
	    
	        	<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
				   <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home" aria-hidden="true"></i></a></li>
			
					<li class="breadcrumb-item active" aria-current="page">Edit Address</li>
				  </ol>
				</nav>
    	<div class="col-md-12">
            <span id="register_success" class="alert-message successmain valierror123 form-group" style="display:none;margin-bottom: 5px;"></span>
            
                <form class="form-horizontal" action="<?php echo $base_url; ?>account/edit_address/<?php echo $editaddress->id; ?>" id="form_address_add" name="form_address_add" method="POST">
                        <input type="hidden" name="action" value="update_profile">
                        <div class="form-group">
                          <label class="control-label col-sm-3">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo $editaddress->first_name; ?>" name="first_name" id="first_name">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Pincode</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo $editaddress->post_code; ?>" name="post_code" id="post_code">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Address</label>
                          <div class="col-sm-9">
                            <textarea class="form-control" rows="5" value="" name="address1" id="address1"><?php echo $editaddress->address1; ?></textarea>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Landmark</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo $editaddress->address2; ?>" placeholder="(Optional)" name="address2" id="address2">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">City</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo $editaddress->city; ?>" name="city" id="city">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">State</label>
                          <div class="col-sm-9">
                            <!-- <input type="text" class="form-control" id=""> -->
                            <select class="form-control" name="state" id="state">
                                <option value="">Select State</option>
                                <?php 
                                if($all_state !='')
                                {
                                    foreach($all_state as $get_state)
                                    {
                                ?>
                                    <option value="<?php echo $get_state->name; ?>" <?php if($get_state->name == $editaddress->state) { echo "selected"; } ?>><?php echo $get_state->name; ?></option>
                            <?php } } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Country</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo $editaddress->country; ?>" name="country" id="country">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3" for="pwd">Phone</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo $editaddress->phone_number; ?>" name="phone_number" id="phone_number">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">&nbsp;</label>
                          <div class="col-sm-9">
                            <div id="error_checkout" class="error alert-message valierror form-control" style="display:none;color:#fff;"></div> 
                            <button type="button" onclick="saveAddress();" class="btn btn-default-red">Update Address <i class="fa fa-bookmark-o" aria-hidden="true"></i></button>
                            <a href="<?php echo $base_url; ?>customer-my-account" class="btn btn-default-red" >Cancel  <i class="fa fa-bookmark-o" aria-hidden="true"></i></a>

                          </div>
                        </div>
                      </form>
                </div>
                
            </div>        	
        </div>
    </div>
    
</div>
<?php include('includes/footer.php');?>
<script>
function saveAddress()
{
        /*var address_title = $("#address_title").val();
        if(address_title == ''){
            $("#error_checkout").html("Please Enter Title.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        } */
        var first_name = $("#first_name").val();
        if(first_name == ''){
            $("#error_checkout").html("Please Enter Name.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }
        
        var post_code = $("#post_code").val();
        if(post_code == ''){
            $("#error_checkout").html("Please Enter Pincode.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }
        
        var checkout_address = $("#address1").val();
        if(checkout_address == ''){
            $("#error_checkout").html("Please Enter Address.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }
        
        var checkout_country = $("#city").val();
        if(checkout_country == ''){
            $("#error_checkout").html("Please Select City.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }
        var checkout_state = $("#state").val();
        if(checkout_state == ''){
            $("#error_checkout").html("Please Select State.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }
        var country = $("#country").val();
        if(country == ''){
            $("#error_checkout").html("Please Enter Country.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        } 
        
        var phone_number = $("#phone_number").val();
        if(phone_number == ''){
            $("#error_checkout").html("Please Enter Phone Number.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }
        
        var emn = $("#phone_number").val();
         var filter_number=/^[0-9]{10}$/;
        if (!filter_number.test(emn)) { 
        $("#error_checkout").html("Enter Phone Number should be 10 digits");
        $('#error_checkout').show().delay(0).fadeIn('show');
        $('#error_checkout').show().delay(2000).fadeOut('show');
        return false;
        }

        $('#form_address_add').submit();
}
</script>