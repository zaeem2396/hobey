c<?php include('includes/header.php');?>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
<link href="http://fiveonlineclient.in/bpcl/html/css/stylesheet.css" rel="stylesheet">

<link href="<?php echo $base_url_views; ?>customer/css/stylesheet.css" rel="stylesheet">
<style>
.content {padding:30px 0px;    display: flex;}
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
</style>
<section class=" login-reg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
<?php include('includes/sidebar_distributor.php');?>
<div class="content-wrapper">
  <div class="content">
      
      
      <div class="checkout-area mb-65" style="width: 100%;">
        <form method="post" action="<?php echo $base_url."billship/checkout" ?>" id="checkaddress">            
                 <div class="col-md-7 col-sm-12 mb-30">
                     <div class="col-md-12">
                        <div class="form-horizontal" >
                        <input style="display:none;" type="radio" name="payment_method" value="1"> 

                        <div class="row">
                       
                        <div class="col-md-12">
                            <div class="clearfix mb-5">
                                <span class="pull-left" style="margin-right: 10px;"><h4>Shipping Address </h4></span>
                                <span class="pull-left" style="margin-top: 8px;">
                                <label>
                                Same as billing address 
                                <input type="checkbox" checked name="samebill" id="buttoncheck" value="1"  >
                                <!-- <div class="control__indicator"></div> -->
                                </label> </span>
                            </div>
                        </div>
                    </div>                        
                        <div class="form-group">
                          <label class="control-label col-sm-3">Address Title</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="address_title" id="address_title">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="first_name" id="first_name">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Address</label>
                          <div class="col-sm-9">
                            <textarea class="form-control" rows="3" name="address1" id="address1"></textarea>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Landmark</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="(Optional)" name="address2" id="address2">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">City</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="city" id="city">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">State</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="state" id="state">
                                <option value="">Select State</option>
                                <?php 
                                if($all_state !='')
                                {
                                    foreach($all_state as $get_state)
                                    {
                                ?>
                                    <option value="<?php echo $get_state->name; ?>"><?php echo $get_state->name; ?></option>
                            <?php } } ?>
                            </select>
                            <!-- <input type="text" class="form-control" name="state" id="state"> -->
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Country</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="country" id="country">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Pincode</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="post_code" id="post_code">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3" for="pwd">Phone</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="phone_number" id="phone_number" >
                          </div>
                        </div>
                        <!--<div class="form-group">
                          <label class="control-label col-sm-3">&nbsp;</label>
                          <div class="col-sm-9">
                            <button type="submit" class="btn btn-default-red">Save and Continue <i class="fa fa-bookmark-o" aria-hidden="true"></i></button>
                          </div>
                        </div> -->
                      </div>
                    </div>
                    <div class="col-md-12" style="display:none;" id="billadd">
                      
                      <div  class="form-horizontal">
                        <div class="col-md-12">
                            <div class="clearfix mb-5">
                                <span class="pull-left" style="margin-right: 10px;"><h4>Billing Address </h4></span>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-sm-3">Address Title</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="bill_address_title" id="bill_address_title">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="bill_first_name" id="bill_first_name">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Address</label>
                          <div class="col-sm-9">
                            <textarea class="form-control" rows="3" name="bill_address1" id="bill_address1"></textarea>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Landmark</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="(Optional)" name="bill_address2" id="bill_address2">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">City</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="bill_city" id="bill_city">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">State</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="bill_state" id="bill_state">
                                <option value="">Select State</option>
                                <?php 
                                if($all_state !='')
                                {
                                    foreach($all_state as $get_state)
                                    {
                                ?>
                                    <option value="<?php echo $get_state->name; ?>"><?php echo $get_state->name; ?></option>
                            <?php } } ?>
                            </select>
                           <!--  <input type="text" class="form-control" name="bill_state" id="bill_state"> -->
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Country</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="bill_country" id="bill_country" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Pincode</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="bill_post_code" id="bill_post_code">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3" for="pwd">Phone</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="bill_phone_number" id="bill_phone_number">
                          </div>
                        </div>
                        
                      </div>
                    </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">&nbsp;</label>
                          <div class="col-sm-9">
                            <button type="button" class="btn btn-default-red" onclick="all_validation_new();" >Save and Order <i class="fa fa-bookmark-o" aria-hidden="true"></i></button>

                            <br />
                            <button type="button" class="btn btn-default-red" onclick="all_validation();" > Cash on delivery Order <i class="fa fa-bookmark-o" aria-hidden="true"></i></button>

                            <div id="per_validat_error" class="error alert-message valierror " style="display:none;"></div> 
                            
                          </div>
                        </div>
                    </div> 
                </form>
                 <div class="col-sm-12 col-md-4">
            <div class="order-summary">
          <h4><strong>Order Summary</strong></h4>
          <?php     
                $cart_subtotal='0';
                $discountamount=0;
                $shipping_charge =0;
                if($this->cart->total_items() > 0) {  $i = 1;
                    foreach($this->cart->contents() as $items)  
                    { $cart_subtotal +=$items['subtotal']; }  } ?>

          <table class="table">
            <tbody>
              <tr>
                <td>Bag Total</td>
                <td class="text-right" id="sub_total"> <i class="fa fa-inr" aria-hidden="true"></i> <?php echo round($cart_subtotal); ?> </td>
              </tr>
              <tr class="border-bottom-dashed">
                <td>Shipping Charges</td>
                <td class="text-right" id="shipping_charges"><i class="fa fa-inr" aria-hidden="true"></i> 0</td>
              </tr>
              <tr class="border-bottom-dashed">
                <td>Discount Amount</td>
                <td class="text-right" id="shipping_charges"><i class="fa fa-inr" aria-hidden="true"></i> 0</td>
              </tr>			                
              <tr class="border-bottom-dashed">
                <td>Redeem Amount</td>
                <td class="text-right" id="shipping_charges"><i class="fa fa-inr" aria-hidden="true"></i> 0</td>
              </tr>
              <tr>
                <td><strong>Grand Total</strong></td>
                <td class="text-right"><strong><i class="fa fa-inr" aria-hidden="true"></i> <?php echo round($cart_subtotal); ?></strong></td>
              </tr>
            </tbody>
          </table>
        </div>
                    </div> 
             <?php $total = ($cart_subtotal - $discountamount + $shipping_charge);
                        $this->session->set_userdata("discount_amount",$discountamount);
                        $this->session->set_userdata("shipping_cost",$shipping_charge);
                        $this->session->set_userdata("total_amount",$total);  ?>
                  </div>   
      </div>
         
	</div>
  </div>
</div>
            </div>
         
		
	</div>
</section>
<?php include('includes/footer.php');?>
<!-- <script src="http://fiveonlineclient.in/bpcl/html/js/jquery.min.js"></script>
<script src="http://fiveonlineclient.in/bpcl/html/js/bootstrap.min.js"></script> -->

<script>
    $(function(){
    $("#buttoncheck").click(function(){
       
        if($(this).is(":checked")){
             //alert('hide');
          $('#billadd').hide();
        }else{           
            //alert('show');
            $('#billadd').show();
         }
        })
    });
</script>

<script type="text/javascript" src="https://services.billdesk.com/checkout-widget/src/app.bundle.js"></script>
<?php 
$str = 'BDSKUATY|UATTXN0001|NA|<?php echo $total; ?>|NA|NA|NA|INR|NA|R|bdskuaty|NA|NA|F|Andheri|Mumbai|02240920005|himansuprajapati9@gmail.com|NA|NA|NA|NA';
$checksum = hash_hmac('sha256',$str,'ABCDEF1234567890', false); 
$checksumfinal = strtoupper($checksum);

/*
$str = 'BDSKUATY|UATTXN0001|NA|2|NA|NA|NA|INR|NA|R|NA|NA|NA|F|Andheri|Mumbai|02240920005|support@billdesk.com|NA|NA|NA|NA';

$checksum = hash_hmac('sha256',$str,'ABCDEF1234567890', false); 
$checksum = strtoupper($checksum);
echo $checksum;*/
?>

<script>
    function all_validation_new()
                {
                    
                            
                var pname=$('#first_name').val();
                if(pname=='')
                {
                    $('#per_validat_error').html("Please Enter First Name !");
                    $('#per_validat_error').show().delay(0).fadeIn('show');
                    $('#per_validat_error').show().delay(2000).fadeOut('show');
                    return false;
                }
            
                var last_name=$('#last_name').val();
                if(last_name=='')
                {
                    $('#per_validat_error').html("Please Enter Last Name");
                    $('#per_validat_error').show().delay(0).fadeIn('show');
                    $('#per_validat_error').show().delay(2000).fadeOut('show');
                    return false;
                }
            
                var paddress=$('#address1').val();
                if(paddress=='')
                {
                    $('#per_validat_error').html("Please Enter Address");
                    $('#per_validat_error').show().delay(0).fadeIn('show');
                    $('#per_validat_error').show().delay(2000).fadeOut('show');
                    return false;
                }
                var address2=$('#address2').val();
                if(address2=='')
                {
                    $('#per_validat_error').html("Please Enter Street / Apatment No. / House No.");
                    $('#per_validat_error').show().delay(0).fadeIn('show');
                    $('#per_validat_error').show().delay(2000).fadeOut('show');
                    return false;
                }
            
            
            var city=$('#city').val();
            if(city=='')
            {
                $('#per_validat_error').html("Please Enter City !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            var pstate=$('#state').val();
            if(pstate=='')
            {
                $('#per_validat_error').html("Please Select State !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var pcountry=$('#country').val();
            if(pcountry=='')
            {
                $('#per_validat_error').html("Please Select Country !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var ppincode=$('#post_code').val();
            if(ppincode=='')
            {
                $('#per_validat_error').html("Please Enter Pincode !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            
            var pmobile=$('#phone_number').val();
            if(pmobile=='')
            {
                $('#per_validat_error').html("Please Enter Phone Number!");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var filter = /^[0-9]{10}$/;
            if (!filter.test(pmobile)) {    
                $("#per_validat_error").html("Phone Number Must Be 10 Digit.");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }

            
        if(!$("#buttoncheck").is(":checked")) {                                         
            
            
            var pname=$('#bill_first_name').val();
            if(pname=='')
            {
                $('#per_validat_error').html("Please Enter Billing First Name !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var bill_address1=$('#bill_address1').val();
            if(bill_address1=='')
            {
                $('#per_validat_error').html("Please Enter Billing Address");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var bill_address2=$('#bill_address2').val();
            if(bill_address2=='')
            {
                $('#per_validat_error').html("Please Enter Billing Street / Apatment No. / House No.");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            
            var bill_city=$('#bill_city').val();
            if(bill_city=='')
            {
                $('#per_validat_error').html("Please Enter Billing City !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }

            var bill_state=$('#bill_state').val();
            if(bill_state=='')
            {
                $('#per_validat_error').html("Please Select Billing State !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var bill_country=$('#bill_country').val();
            if(bill_country=='')
            {
                $('#per_validat_error').html("Please Select Billing Country !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var bill_post_code=$('#bill_post_code').val();
            if(bill_post_code=='')
            {
                $('#per_validat_error').html("Please Enter Billing Pincode !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            
            var bill_phone_number=$('#bill_phone_number').val();
            if(bill_phone_number=='')
            {
                $('#per_validat_error').html("Please Enter Billing Phone Number!");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var filter = /^[0-9]{10}$/;
            if (!filter.test(bill_phone_number)) {  
                $("#per_validat_error").html("Billing Phone Number Must Be 10 Digit.");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
        }
        //$('#checkaddress').submit(); 

bdPayment.initialize({
    msg :'BDSKUATY|UATTXN0001|NA|<?php echo $total; ?>|NA|NA|NA|INR|NA|R|bdskuaty|NA|NA|F|Andheri|Mumbai|02240920005|himansuprajapati9@gmail.com|NA|NA|NA|NA|<?php echo $checksumfinal; ?>',
            callbackUrl: '<?php echo $base_url."billship/checkout" ?>',
options : {
                enableChildWindowPosting : true,
                enablePaymentRetry : true,
                retry_attempt_count: 20
            }   
     }); 
                        
    }

/*document.addEventListener('readystatechange', function(event) {
    if (event.target.readyState === "complete") { 
        alert('test');
        //$('#checkaddress').submit(); 

        // var button = document.getElementById('pay'); 
        // button.disabled = false; 
        // button.value="Pay with BillDesk";
        // button.classList.remove("disabled"); 
    }
});*/

function all_validation()
                {
                    
                            
                var pname=$('#first_name').val();
                if(pname=='')
                {
                    $('#per_validat_error').html("Please Enter First Name !");
                    $('#per_validat_error').show().delay(0).fadeIn('show');
                    $('#per_validat_error').show().delay(2000).fadeOut('show');
                    return false;
                }
            
                var last_name=$('#last_name').val();
                if(last_name=='')
                {
                    $('#per_validat_error').html("Please Enter Last Name");
                    $('#per_validat_error').show().delay(0).fadeIn('show');
                    $('#per_validat_error').show().delay(2000).fadeOut('show');
                    return false;
                }
            
                var paddress=$('#address1').val();
                if(paddress=='')
                {
                    $('#per_validat_error').html("Please Enter Address");
                    $('#per_validat_error').show().delay(0).fadeIn('show');
                    $('#per_validat_error').show().delay(2000).fadeOut('show');
                    return false;
                }
                var address2=$('#address2').val();
                if(address2=='')
                {
                    $('#per_validat_error').html("Please Enter Street / Apatment No. / House No.");
                    $('#per_validat_error').show().delay(0).fadeIn('show');
                    $('#per_validat_error').show().delay(2000).fadeOut('show');
                    return false;
                }
            
            
            var city=$('#city').val();
            if(city=='')
            {
                $('#per_validat_error').html("Please Enter City !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            var pstate=$('#state').val();
            if(pstate=='')
            {
                $('#per_validat_error').html("Please Select State !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var pcountry=$('#country').val();
            if(pcountry=='')
            {
                $('#per_validat_error').html("Please Select Country !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var ppincode=$('#post_code').val();
            if(ppincode=='')
            {
                $('#per_validat_error').html("Please Enter Pincode !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            
            var pmobile=$('#phone_number').val();
            if(pmobile=='')
            {
                $('#per_validat_error').html("Please Enter Phone Number!");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var filter = /^[0-9]{10}$/;
            if (!filter.test(pmobile)) {    
                $("#per_validat_error").html("Phone Number Must Be 10 Digit.");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }

            
        if(!$("#buttoncheck").is(":checked")) {                                         
            
            
            var pname=$('#bill_first_name').val();
            if(pname=='')
            {
                $('#per_validat_error').html("Please Enter Billing First Name !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var bill_address1=$('#bill_address1').val();
            if(bill_address1=='')
            {
                $('#per_validat_error').html("Please Enter Billing Address");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var bill_address2=$('#bill_address2').val();
            if(bill_address2=='')
            {
                $('#per_validat_error').html("Please Enter Billing Street / Apatment No. / House No.");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            
            var bill_city=$('#bill_city').val();
            if(bill_city=='')
            {
                $('#per_validat_error').html("Please Enter Billing City !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }

            var bill_state=$('#bill_state').val();
            if(bill_state=='')
            {
                $('#per_validat_error').html("Please Select Billing State !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var bill_country=$('#bill_country').val();
            if(bill_country=='')
            {
                $('#per_validat_error').html("Please Select Billing Country !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var bill_post_code=$('#bill_post_code').val();
            if(bill_post_code=='')
            {
                $('#per_validat_error').html("Please Enter Billing Pincode !");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            
            var bill_phone_number=$('#bill_phone_number').val();
            if(bill_phone_number=='')
            {
                $('#per_validat_error').html("Please Enter Billing Phone Number!");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
            
            var filter = /^[0-9]{10}$/;
            if (!filter.test(bill_phone_number)) {  
                $("#per_validat_error").html("Billing Phone Number Must Be 10 Digit.");
                $('#per_validat_error').show().delay(0).fadeIn('show');
                $('#per_validat_error').show().delay(2000).fadeOut('show');
                return false;
            }
        }
      $('#checkaddress').submit(); 
/*
bdPayment.initialize({
    msg :'BDSKUATY|UATTXN0001|NA|<?php echo $total; ?>|NA|NA|NA|INR|NA|R|bdskuaty|NA|NA|F|Andheri|Mumbai|02240920005|himansuprajapati9@gmail.com|NA|NA|NA|NA|<?php echo $checksumfinal; ?>',
            callbackUrl: '<?php echo $base_url."billship/checkout" ?>',
options : {
                enableChildWindowPosting : true,
                enablePaymentRetry : true,
                retry_attempt_count: 20
            }   
     }); */
                        
    }
</script>