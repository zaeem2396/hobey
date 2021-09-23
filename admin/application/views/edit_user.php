<?php include('include/header.php');?>

<!-- Start: Main -->
<div id="main"> 
  
 <?php include('include/sidebar_left.php');?>
 
  <!-- Start: Content -->
  <!-- Start: Content -->
<section id="content_wrapper">
   <div id="topbar">
      <div class="topbar-left">
         <ol class="breadcrumb">
            <li class="crumb-icon"><a href="<?php echo $base_url; ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="crumb-link"><a href="<?php echo $base_url; ?>user/lists">User</a></li>
            <li class="crumb-active"><a href="javascript:void(0);"> Edit Users</a></li>
         </ol>
      </div>
   </div>
   <div id="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel">
               <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Edit User</span> </div>
               <div class="panel-body">
                  <?php if($this->session->flashdata('L_strErrorMessage')) 
                     { ?>
                  <div class="alert alert-success alert-dismissable">
                     <i class="fa fa-check"></i>
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     <b>Success!</b> <?php echo $this->session->flashdata('L_strErrorMessage'); ?>
                  </div>
                  <?php } 
                     ?>
                  <?php if($this->session->flashdata('flashError')!='') { ?>
                  <div class="alert alert-danger alert-dismissable">
                     <i class="fa fa-warning"></i>
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     <b>Error!</b> <?php echo $this->session->flashdata('flashError'); ?>
                  </div>
                  <?php }  ?>
                  <div id="validator"  class="alert alert-danger alert-dismissable" style="display:none;">
                     <i class="fa fa-warning"></i>
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     <b>Error &nbsp; </b><span id="error_msg1"></span>
                  </div>
                  <div class="col-md-12">
                     <form role="form" id="form" method="post" action="<?php echo $base_url;?>user/edit/<?php echo $id; ?>" enctype="multipart/form-data" >
                        <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
                        <INPUT TYPE="hidden" NAME="action" VALUE="edit_user">
                        <INPUT TYPE="hidden" NAME="hiddenaction" VALUE="<?php echo $id;?>">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label style="width:100%; margin:15px 0 5px;" for="name">First Name <span style="color:red">*<span></label>
                              <input name="name" id="register_fname" type="text" class="form-control" placeholder="Enter First Name" value="<?php echo $name; ?>"/>
                           </div>
                        </div>
                       <!--  <div class="col-md-6">
                           <div class="form-group">
                              <label style="width:100%; margin:15px 0 5px;" for="name">Last Name</label>
                              <input name="lname" id="register_lname" type="text" class="form-control" placeholder="Enter Last Name" value="<?php echo $lname; ?>"/>
                           </div>
                        </div> -->
                        <div class="col-md-6">
                           <div class="form-group">
                              <label style="width:100%; margin:15px 0 5px;" for="name">Email <span style="color:red">*<span></label>
                              <input name="email" id="register_email" readonly type="text" class="form-control" placeholder="Enter Email" value="<?php echo $email; ?>"/>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label style="width:100%; margin:15px 0 5px;" for="name">Mobile <span style="color:red">*<span></label>
                              <input name="mobile" id="register_mobile" type="text" class="form-control" placeholder="Enter Mobile" value="<?php echo $mobile; ?>"/>
                           </div>
                        </div>
                        <!-- <div class="col-md-6">
                           <div class="form-group">
                              <label style="width:100%; margin:15px 0 5px;" for="name">Address</label>
                              <textarea name="address" id="register_address" type="text" class="form-control" placeholder="Enter Address" value="<?php echo $lname; ?>" style="height: 34px;"><?php echo $address; ?></textarea>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label style="width:100%; margin:15px 0 5px;" for="name">Country</label>
                              <select class="form-control" id="address_country" name="country" >
                                 <option value="">select Country</option>
                                 <option value="India" <?php if($country == 'India'){ echo "selected"; }  ?>>India</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label style="width:100%; margin:15px 0 5px;" for="name">State</label>
                              <select class="form-control" id="address_state" name="state">
                                 <option value="" >State</option>
                                 <option value="Andaman and Nicobar Islands" <?php if($state == 'Andaman and Nicobar Islands'){ echo "selected"; }  ?>>Andaman and Nicobar Islands</option>
                                 <option value="Andhra Pradesh" <?php if($state == 'Andhra Pradesh'){ echo "selected"; }  ?>>Andhra Pradesh</option>
                                 <option value="Arunachal Pradesh" <?php if($state == 'Arunachal Pradesh'){ echo "selected"; }  ?>>Arunachal Pradesh</option>
                                 <option value="Assam" <?php if($state == 'Assam'){ echo "selected"; }  ?>>Assam</option>
                                 <option value="Bihar" <?php if($state == 'Bihar'){ echo "selected"; }  ?>>Bihar</option>
                                 <option value="Chandigarh" <?php if($state == 'Chandigarh'){ echo "selected"; }  ?>>Chandigarh</option>
                                 <option value="Chhattisgarh" <?php if($state == 'Chhattisgarh'){ echo "selected"; }  ?>>Chhattisgarh</option>
                                 <option value="Dadra and Nagar Haveli" <?php if($state == 'Dadra and Nagar Haveli'){ echo "selected"; }  ?>>Dadra and Nagar Haveli</option>
                                 <option value="Daman and Diu" <?php if($state == 'Daman and Diu'){ echo "selected"; }  ?>>Daman and Diu</option>
                                 <option value="Delhi" <?php if($state == 'Delhi'){ echo "selected"; }  ?>>Delhi</option>
                                 <option value="Goa" <?php if($state == 'Goa'){ echo "selected"; }  ?>>Goa</option>
                                 <option value="Gujarat" <?php if($state == 'Gujarat'){ echo "selected"; }  ?>>Gujarat</option>
                                 <option value="Haryana" <?php if($state == 'Haryana'){ echo "selected"; }  ?>>Haryana</option>
                                 <option value="Himachal Pradesh" <?php if($state == 'Himachal Pradesh'){ echo "selected"; }  ?>>Himachal Pradesh</option>
                                 <option value="Jammu and Kashmir" <?php if($state == 'Jammu and Kashmir'){ echo "selected"; }  ?>>Jammu and Kashmir</option>
                                 <option value="Jharkhand" <?php if($state == 'Jharkhand'){ echo "selected"; }  ?>>Jharkhand</option>
                                 <option value="Karnataka" <?php if($state == 'Karnataka'){ echo "selected"; }  ?>>Karnataka</option>
                                 <option value="Kashmir" <?php if($state == 'Kashmir'){ echo "selected"; }  ?>>Kashmir</option>
                                 <option value="Kerala" <?php if($state == 'Kerala'){ echo "selected"; }  ?>>Kerala</option>
                                 <option value="Laccadives" <?php if($state == 'Laccadives'){ echo "selected"; }  ?>>Laccadives</option>
                                 <option value="Lakshadweep" <?php if($state == 'Lakshadweep'){ echo "selected"; }  ?>>Lakshadweep</option>
                                 <option value="Madhya Pradesh" <?php if($state == 'Madhya Pradesh'){ echo "selected"; }  ?>>Madhya Pradesh</option>
                                 <option value="Maharashtra" <?php if($state == 'Maharashtra'){ echo "selected"; }  ?> >Maharashtra</option>
                                 <option value="Manipur" <?php if($state == 'Manipur'){ echo "selected"; }  ?>>Manipur</option>
                                 <option value="Meghalaya" <?php if($state == 'Meghalaya'){ echo "selected"; }  ?>>Meghalaya</option>
                                 <option value="Mizoram" <?php if($state == 'Mizoram'){ echo "selected"; }  ?>>Mizoram</option>
                                 <option value="Nagaland" <?php if($state == 'Nagaland'){ echo "selected"; }  ?>>Nagaland</option>
                                 <option value="Odisha" <?php if($state == 'Odisha'){ echo "selected"; }  ?>>Odisha</option>
                                 <option value="Pondicherry" <?php if($state == 'Pondicherry'){ echo "selected"; }  ?>>Pondicherry</option>
                                 <option value="Punjab" <?php if($state == 'Punjab'){ echo "selected"; }  ?>>Punjab</option>
                                 <option value="Rajasthan" <?php if($state == 'Rajasthan'){ echo "selected"; }  ?>>Rajasthan</option>
                                 <option value="Sikkim" <?php if($state == 'Sikkim'){ echo "selected"; }  ?>>Sikkim</option>
                                 <option value="Tamil Nadu" <?php if($state == 'Tamil Nadu'){ echo "selected"; }  ?>>Tamil Nadu</option>
                                 <option value="Telangana" <?php if($state == 'Telangana'){ echo "selected"; }  ?>>Telangana</option>
                                 <option value="Tripura" <?php if($state == 'Tripura'){ echo "selected"; }  ?>>Tripura</option>
                                 <option value="Uttarakhand" <?php if($state == 'Uttarakhand'){ echo "selected"; }  ?>>Uttarakhand</option>
                                 <option value="Uttar Pradesh" <?php if($state == 'Uttar Pradesh'){ echo "selected"; }  ?>>Uttar Pradesh</option>
                                 <option value="West Bengal" <?php if($state == 'West Bengal'){ echo "selected"; }  ?>>West Bengal</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label style="width:100%; margin:15px 0 5px;" for="city">City</label>
                              <input id="register_city" name="city" type="text" class="form-control" placeholder="Enter City" value="<?php echo $city; ?>"/>
                           </div>
                        </div> -->
                        <div class="col-md-6">
                           <div class="form-group">
                              <label style="width:100%; margin:15px 0 5px;" for="city">Zipcode <span style="color:red">*<span></label>
                              <input onkeypress="return numbersonly(event)" maxlength="6" id="register_pincode" name="pincode" type="text" class="form-control" placeholder="Enter Zipcode" value="<?php echo $pincode; ?>"/>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <input class="submit btn bg-purple pull-right" type="submit" value="Update" onclick="javascript:validate();return false;"/>
                              <a href="<?php echo $base_url;?>user/lists" class="submit btn btn-danger pull-right" style="margin-right: 10px;" />Cancel</a>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
  
   
 <?php include('include/sidebar_right.php');?>
 </div>
<!-- End #Main --> 
<?php include('include/footer.php')?>
 
<script>
	function validate(){
	
	var register_fname = $("#register_fname").val();
		if(register_fname == ''){
			$("#error_msg1").html("Please Enter First Name.");
			$("#validator").css("display","block");
			return false;
		}
		
		var register_lname = $("#register_lname").val();
		if(register_lname == ''){
			$("#error_msg1").html("Please Enter Last Name.");
			$("#validator").css("display","block");
			return false;
		}
		
		var register_email = $("#register_email").val();
		if(register_email == ''){
			$("#error_msg1").html("Please Enter Last Name.");
			$("#validator").css("display","block");
			return false;
		}
		
		var em = jQuery("#register_email").val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(em)) {	
			jQuery("#error_msg1").html("Enter Valid Email Address.");
			$("#validator").css("display","block");
            return false;
        }
		
		var register_mobile = $("#register_mobile").val();
		if(register_mobile == ''){
			$("#error_msg1").html("Please Enter Mobile Number.");
			$("#validator").css("display","block");
			return false;
		}
		
		var em = jQuery("#register_mobile").val();
		var filter = /^([0-9]{10})+$/;
		if (!filter.test(em)){	
			jQuery("#error_msg1").html("Mobile number must be 10 digit .");
			$("#validator").css("display","block");
			return false;
		}
		
		
		var register_address = $("#register_address").val();
		if(register_address == ''){
			$("#error_msg1").html("Please Enter Address.");
			$("#validator").css("display","block");
			return false;
		}
		
		var address_country = $("#address_country").val();
		if(address_country == ''){
			$("#error_msg1").html("Please Select Country.");
			$("#validator").css("display","block");
			return false;
		}
		
		var address_state = jQuery("#address_state").val();
		if(address_state == ''){
			jQuery("#error_msg1").html("Please Select State.");
			$("#validator").css("display","block");
			return false;
		}
		
		var register_city = jQuery("#register_city").val();
		if(register_city == ''){
			jQuery("#error_msg1").html("Please Enter City.");
			$("#validator").css("display","block");
			return false;
		}
		
		var register_pincode = jQuery("#register_pincode").val();
		if(register_pincode == ''){
			jQuery("#error_msg1").html("Please Enter Zipcode.");
			$("#validator").css("display","block");
			return false;
		}
				
		$('#form').submit();
	}
	function numbersonly(e){
		var unicode=e.charCode? e.charCode : e.keyCode
		if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
			 if (unicode < 45 || unicode > 57) //if not a number
				return false //disable key press
		}
	}
	
</script>