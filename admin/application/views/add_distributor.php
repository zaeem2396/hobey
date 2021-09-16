<?php include('include/header.php');?>

<!-- Start: Main -->
<div id="main"> 
  
 <?php include('include/sidebar_left.php');?>
 
  <!-- Start: Content -->
<section id="content_wrapper">
   <div id="topbar">
      <div class="topbar-left">
         <ol class="breadcrumb">
            
            <li class="crumb-icon"><a href="<?php echo $base_url; ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="crumb-link"><a href="<?php echo $base_url; ?>distributor/lists">Distributor</a></li>
            <li class="crumb-active"><a href="javascript:void(0);"> Add Distributor </a></li>
         </ol>
      </div>
   </div>
   <div id="content">
      <div class="row" id="subform">
         <div class="col-md-12">
            <div class="panel">
               <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Add Distributor</span> </div>
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
                  <div id="validator1"  class="alert alert-success alert-dismissable" style="display:none;">
                     <i class="fa fa-check"></i>
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     <b>Success!</b> <span id="success_msg1"></span>
                  </div>
                  <div class="col-md-12">
                     <form role="form" id="form" method="post" action="<?php echo $base_url;?>distributor/add" enctype="multipart/form-data" >

                        <!-- <select id="multiselect" class="mySelect" multiple="multiple">
                          <option value="http://ipv4.download.thinkbroadband.com/5MB.zip">Option 1</option>
                          <option value="http://ipv4.download.thinkbroadband.com/10MB.zip">Option 2</option>
                          <option value="http://ipv4.download.thinkbroadband.com/20MB.zip">Option 3</option>
                          <option value="http://ipv4.download.thinkbroadband.com/50MB.zip">Option 4</option>
                        </select> -->


                        <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
                        <INPUT TYPE="hidden" NAME="action" VALUE="add_vendor">
                        <INPUT TYPE="hidden" NAME="hiddenaction" VALUE="<?php echo $id;?>">


                        <div class="col-md-6">    
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">Name <span style="color:red">*<span></label>
                               <input name="name" id="name" type="text" class="form-control" placeholder="Enter Name" value="<?php echo $name; ?>"/>
                                <span id="vendornameerror" class="valierror"></span>
                            </div>
                        </div>

                        <div class="col-md-6">    
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">Mobile Number <span style="color:red">*<span></label>
                                    <input name="mobile" id="mobile" type="text" class="form-control" placeholder="Enter Mobile Number" value="<?php echo $mobile; ?>"/>
                                    <span id="vendormobileerror" class="valierror"></span>
                            </div>
                        </div>

                        <div class="col-md-6">    
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">Email ID <span style="color:red">*<span></label>
                               <input name="email" id="email" type="text" class="form-control" placeholder="Enter Email ID" value="<?php echo $email; ?>"/>
                               <span id="vendoremailerror" class="valierror"></span>
                            </div>
                        </div>

                        <div class="col-md-6">    
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">Password <span style="color:red">*<span></label>
                                    <input name="password" id="password" type="text" class="form-control" placeholder="Enter Password" value="<?php echo $password; ?>"/>
                                    <span id="vendorpassworderror" class="valierror"></span>
                            </div>
                        </div>

                        <div class="col-md-12">    
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">Address 1 <span style="color:red">*<span></label>
                               <textarea name="address_1" id="address_1" type="text" class="form-control" placeholder="Enter Address 1 " value="" style="height:55px"><?php echo $address_1; ?></textarea>
                               <span id="vendoraddress1error" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-12">    
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">Address 2</label>
                               <textarea name="address_2" id="address_2" type="text" class="form-control" placeholder="Enter Address 2" value="" style="height:55px"><?php echo $address_2; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="state_id">
                                  State <span style="color:red">*<span>
                               </label>
                               <select id="state_id" name="state_id" onchange="get_group(this.value);" class="form-control jobtext">
                                  <option value="" selected>-- Select State --</option>
                                  <?php for($i=0;$i<count($allstate);$i++)
                                     {
                                     ?>
                                  <option value='<?php echo $allstate[$i]->id; ?>'>
                                     <?php echo $allstate[$i]->name; ?>
                                  </option>
                                  <?php
                                     }
                                     ?>
                               </select>
                               <span id="stateiderror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="city_id">
                                  District <span style="color:red">*<span>
                               </label>
                               <span id="prod1">
                                <select id="city_id" name="city_id"  class="form-control jobtext" onchange="get_pincode(this.value);">
                                    <option value="" selected>-- Select District --</option>
                                </select>
                            </span>
                               <span id="citynameerror" class="valierror"></span>
                            </div>
                        </div>

                        <div class="col-md-6">  
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="city_id_new">City</label>
                               <input name="city_id_new" id="city_id_new" type="text" class="form-control" placeholder="Enter City" value="<?php echo $city_id_new; ?>" >
                                <span id="pincodenameerror" class="valierror"></span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="pincode">
                               Pincode <span style="color:red">*<span>
                               </label>
                               <span id="prod11">
                                <select id="pincode" name="pincode[]" multiple="multiple" class="form-control jobtext mySelect">
                                </select>
                            </span>
                               <span id="pincodenameerror" class="valierror"></span>
                            </div>
                        </div>

                        <div class="col-md-6">  
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name"> Telephone</label>
                               <input name="telephone" id="telephone" type="text" class="form-control" placeholder="Enter Telephone" value="<?php echo $telephone; ?>" >
                            </div>
                        </div>
                        <!-- <div class="col-md-12">  
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">Payment Gateway Code</label>
                               <input name="payment_code" id="payment_code" type="text" class="form-control" placeholder="Enter Payment Gateway Code" value="<?php echo $payment_code; ?>" >
                                <span id="pincodenameerror" class="valierror"></span>
                            </div>
                        </div> -->

                        <div class="col-md-6">  
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">Bank name</label>
                               <input name="bank_name" id="bank_name" type="text" class="form-control" placeholder="Enter Bank name" value="<?php echo $bank_name; ?>" >
                                <span id="pincodenameerror" class="valierror"></span>
                            </div>
                        </div>

                         <div class="col-md-6">  
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">Account no</label>
                               <input name="account_no" id="account_no" type="text" class="form-control" placeholder="Enter Account no" value="<?php echo $account_no; ?>" >
                                <span id="pincodenameerror" class="valierror"></span>
                            </div>
                        </div>

                        <div class="col-md-6">  
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">IFSC code</label>
                               <input name="ifsc_code" id="ifsc_code" type="text" class="form-control" placeholder="Enter IFSC code" value="<?php echo $ifsc_code; ?>" >
                                <span id="pincodenameerror" class="valierror"></span>
                            </div>
                        </div>

                        <h3>Contact Person </h3>
                        <hr style="margin:0;"/>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="contact_title">Title <span style="color:red">*<span>
                               </label>
                                <select id="contact_title" name="contact_title"  class="form-control jobtext">
                                    <option value="" >-- Select Title --</option>
                                    <option value="Mr." >Mr.</option>
                                    <option value="Miss" >Miss</option>
                                    <option value="Mrs" >Mrs</option>
                                </select>
                               <span id="titleerror" class="valierror"></span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">  
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="contact_name">Name <span style="color:red">*<span></label>
                               <input name="contact_name" id="contact_name" type="text" class="form-control" placeholder="Enter Name" value="<?php echo $contact_name; ?>" >
                               <span id="contact_nameerror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-4">  
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">Email Id <span style="color:red">*<span></label>
                               <input name="contact_email" id="contact_email" type="text" class="form-control" placeholder="Enter Email Id" value="<?php echo $contact_email; ?>" >
                                <span id="contact_emailerror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-4">  
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">Mobile No. <span style="color:red">*<span></label>
                               <input name="contact_phone" id="contact_phone" type="text" class="form-control" placeholder="Enter Mobile No." value="<?php echo $contact_phone; ?>" >
                               <span id="contact_phoneerror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-4">  
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">Telephone</label>
                               <input name="contact_telephone" id="contact_telephone" type="text" class="form-control" placeholder="Enter Telephone" value="<?php echo $contact_telephone; ?>" >
                            </div>
                        </div>

                        <h3>&nbsp;</h3>
                        <hr style="margin:0;"/>

                        <div class="col-md-6">
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">GST Number <span style="color:red">*<span></label>
                               <input name="gst_no" id="gst_no" type="text" maxlength="15" class="form-control" placeholder="Enter GST Number" value="<?php echo $gst_no; ?>" >
                            </div>
                        </div>
                        <div class="col-md-6">  
                            <div class="form-group">
                               <label style="width:100%; margin:15px 0 5px;" for="name">CC Code <span style="color:red">*<span></label>
                               <input name="cc_code" id="cc_code" type="text" class="form-control" placeholder="Enter CC Code" value="<?php echo $cc_code; ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                           <input class="submit btn bg-purple pull-right" type="submit" value="Submit" onclick="javascript:validate();return false;"/>
                           <a href="<?php echo $base_url;?>distributor/lists" class="submit btn btn-danger pull-right" style="margin-right: 10px;" />Cancel</a>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- End: Content -->
  
   
 <?php include('include/sidebar_right.php');?>
 </div>
<!-- End #Main --> 
<?php include('include/footer.php')?>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script> 
<script>
$(document).ready(function() {
    $(".mySelect").select2({
        //data: data,
        //placeholder: placeholder,
        allowClear: false,
        minimumResultsForSearch: 5
    });
});

	function validate(){
	
	var name = jQuery("#name").val();
		
		if(name == ''){
			jQuery("#error_msg1").html("Please Enter Name.");
			$("#validator").css("display","block");
            document.getElementById("subform").scrollIntoView(true); 
			return false;
		}
		
		var tel_no = jQuery("#mobile").val();
        if(tel_no == ''){
            jQuery("#error_msg1").html("Please Enter Mobile Number.");
            $("#validator").css("display","block");
            document.getElementById("subform").scrollIntoView(true); 
            return false;
        }
        var em = jQuery("#mobile").val();
        var filter = /^([0-9]{10})+$/;
        if (!filter.test(em)){  
            jQuery("#error_msg1").html("Mobile number must be 10 digit .");
            $("#validator").css("display","block");
            document.getElementById("subform").scrollIntoView(true); 
            return false;
        }

        var email = jQuery("#email").val();
        if(email == ''){
            jQuery("#error_msg1").html("Please Enter Email Id.");
            $("#validator").css("display","block");
            document.getElementById("subform").scrollIntoView(true); 
            return false;
        }

        var filter = /(?!.*\.{2})^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

    if (!filter.test(email)) {
        jQuery("#error_msg1").html("Enter Valid Email Address.");
        $("#validator").css("display", "block");
        document.getElementById("subform").scrollIntoView(true);
        return false;
    }

        var url = '<?php echo $base_url;?>vendor/checkemail';
        $.ajax({
            url:url,
            type:'post',
            data:'email='+email,
            success:function(msg)
            {

                if(msg != 0)
                {
                    jQuery("#error_msg1").html("Email Id Already Exists.");
                    $("#validator").css("display","block");
                    document.getElementById("subform").scrollIntoView(true); 
                    return false;
                }
                else
                {
                var password = jQuery("#password").val();
                if(password == ''){
                    jQuery("#error_msg1").html("Please Enter Password");
                    $("#validator").css("display","block");
                    document.getElementById("subform").scrollIntoView(true); 
                    return false;
                }

        		
        		var address = jQuery("#address_1").val();
        		if(address == ''){
        			
        			jQuery("#error_msg1").html("Please Enter Address.");
        			$("#validator").css("display","block");
                    document.getElementById("subform").scrollIntoView(true); 
        			return false;
        		}

                var state_id = jQuery("#state_id").val();
                if(state_id == ''){
                    
                    jQuery("#error_msg1").html("Please Select State.");
                    $("#validator").css("display","block");
                    document.getElementById("subform").scrollIntoView(true); 
                    return false;
                }
        		
        		var city_id = jQuery("#city_id").val();
        		if(city_id == ''){
        			
        			jQuery("#error_msg1").html("Please Select District");
        			$("#validator").css("display","block");
                    document.getElementById("subform").scrollIntoView(true); 
        			return false;
        		}
        		
            	var pincode = jQuery("#pincode").val();
        		if(pincode == ''){
        			jQuery("#error_msg1").html("Please Enter Pincode");
        			$("#validator").css("display","block");
                    document.getElementById("subform").scrollIntoView(true); 
        			return false;
        		}
        		
                var contact_title = jQuery("#contact_title").val();
                if(contact_title == ''){
                    jQuery("#error_msg1").html("Please Select Contact Person Title");
                    $("#validator").css("display","block");
                    document.getElementById("subform").scrollIntoView(true); 
                    return false;
                }

                var contact_name = jQuery("#contact_name").val();
                if(contact_name == ''){
                    jQuery("#error_msg1").html("Please Enter Contact Person Name");
                    $("#validator").css("display","block");
                    document.getElementById("subform").scrollIntoView(true); 
                    return false;
                }

                var contact_email = jQuery("#contact_email").val();
                if(contact_email == ''){
                    jQuery("#error_msg1").html("Please Enter Contact Person Email Id");
                    $("#validator").css("display","block");
                    document.getElementById("subform").scrollIntoView(true); 
                    return false;
                }

                var filter = /(?!.*\.{2})^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

if (!filter.test(contact_email)) {
    jQuery("#error_msg1").html("Enter Valid Contact Person Email Id.");
    $("#validator").css("display", "block");
    document.getElementById("subform").scrollIntoView(true);
    return false;
}

                var contact_phone = jQuery("#contact_phone").val();
                if(contact_phone == ''){
                    jQuery("#error_msg1").html("Please Enter Contact Person Mobile Number.");
                    $("#validator").css("display","block");
                    document.getElementById("subform").scrollIntoView(true); 
                    return false;
                }
                var em = jQuery("#contact_phone").val();
                var filter = /^([0-9]{10})+$/;
                if (!filter.test(em)){  
                    jQuery("#error_msg1").html("Contact Person Mobile number must be 10 digit .");
                    $("#validator").css("display","block");
                    document.getElementById("subform").scrollIntoView(true); 
                    return false;
                }

                var gst_no = jQuery("#gst_no").val();
                if(gst_no == ''){
                    jQuery("#error_msg1").html("Please Enter GST Number.");
                    $("#validator").css("display","block");
                    document.getElementById("subform").scrollIntoView(true); 
                    return false;
                }

                if(gst_no.length != 15){
                    jQuery("#error_msg1").html("Please Enter Valid GST Number.");
                    $("#validator").css("display","block");
                    document.getElementById("subform").scrollIntoView(true); 
                    return false;
                }

                var cc_code = jQuery("#cc_code").val();
                if(cc_code == ''){
                    jQuery("#error_msg1").html("Please Enter CC Code.");
                    $("#validator").css("display","block");
                    document.getElementById("subform").scrollIntoView(true); 
                    return false;
                }

        		$('#form').submit();

            }
            }
        });
	}
	function numbersonly(e){
		var unicode=e.charCode? e.charCode : e.keyCode
		if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
			 if (unicode < 45 || unicode > 57) //if not a number
				return false //disable key press
		}
	}
	
</script>

	<script>
	function get_pincode_check(pincode)
	{
		
		var url = '<?php echo $base_url;?>vendor/checkpincode';
		$.ajax({
			url:url,
			type:'post',
			data:'pincode='+pincode,
			success:function(msg)
			{
				
				if(msg == 0)
				{
					alert("service is not available at your pincode.");
					/*jQuery("#error_msg1").html("service is not available at your pincode.");
					$("#validator").css("display","block");
					return false;*/
			
					/*$("#error_msg1").html("service is not available at your pincode.");
					$("#validator").css("display","block");
					return false;*/
				}
				else
				{
					alert("Service is available at your pincode.");
					/*jQuery("#success_msg1").html("Service is available at your pincode.");
					$("#validator1").css("display","block");
					return false;*/
					
				}
				
				
			}
		});
	}
	</script>

<script>


function get_group(cid)
{
        var url = '<?php echo $base_url ?>/distributor/show_city/';
        $.ajax({
        url:url,
        type:'post',
        data:'cid='+cid+'&sid=',
        success:function(msg)
        {
            
            document.getElementById('prod1').innerHTML = msg ;
        }
        });
}
function get_pincode(cid)
{
        var url = '<?php echo $base_url ?>/distributor/show_pincode/';
        $.ajax({
        url:url,
        type:'post',
        data:'cid='+cid+'&sid=',
        success:function(msg)
        {
            document.getElementById('prod11').innerHTML = msg ;
            $(".mySelect").select2({
                allowClear: false,
                minimumResultsForSearch: 5
            });
        }
        });
}
/*
function get_area(cid)
{
        var url = '<?php echo $base_url ?>/distributor/show_city/';
        $.ajax({
        url:url,
        type:'post',
        data:'cid='+cid+'&sid=',
        success:function(msg)
        {
            
            document.getElementById('prod1').innerHTML = msg ;
        }
        });
}*/

</script>