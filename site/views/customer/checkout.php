<?php include('includes/header.php');?>
<!--navBar content End-->
<!--Product page-->
<div class="container">
  <div class="cart-wrap pdd50">
      
      	<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
				   <li class="breadcrumb-item"><a href="<?php echo $base_url; ?>"><i class="fa fa-home" aria-hidden="true"></i></a></li>
			
					<li class="breadcrumb-item active" aria-current="page">Checkout</li>
				  </ol>
				</nav>
    <div class="row checkout-accordion">
      <div class="col-md-6 col-sm-12 col-md-3 col-md-push-9 mb-30">
        <div class="order-summary">
          <h4><strong>Order Summary</strong></h4>
           <?php     
                $cart_subtotal='0';
                $discountamount=0;
                $shipping_charge =0;
                if($this->cart->total_items() > 0) {  $i = 1;
                    foreach($this->cart->contents() as $items)  
                    { $cart_subtotal +=$items['subtotal']; }  } ?>

                  <?php 
                $discountamount=0;
                            if($this->session->userdata('coupancode') !=''){
                                $coupan_type=$this->session->userdata('coupanvalue'); 
                            if($coupan_type==0){ 
                            if($cartdiscount !=0){
                                $discount=(($discount_subtotal)*$this->session->userdata('discount')/100);
                            }else
                            {
                                $discount=(($discount_subtotal)*$this->session->userdata('discount')/100);
                            }
                                
                                $discountamount = round($discount);
                             }else{
                                $discountamount = round($this->session->userdata('discount'));
                             }   ?>
                                 
                                <?php }  $totalamount=($cart_subtotal-$discountamount); 
                ?>

          <table class="table">
            <tbody>
              <tr>

                <td>Bag Total</td>
                <td class="text-right" id="sub_total"> <i class="fa fa-inr" aria-hidden="true"></i> <?php echo round($cart_subtotal); ?></td>
              </tr>
             <!-- <tr class="border-bottom-dashed">
                <td>Shipping Charges</td>
                <td class="text-right" id="shipping_charges"><i class="fa fa-inr" aria-hidden="true"></i> 0</td>
              </tr>
              <tr class="border-bottom-dashed">
                <td>Discount Amount</td>
                <td class="text-right" id="shipping_charges"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo round($discountamount); ?></td>
              </tr>-->	                
              <tr class="border-bottom-dashed">
                <td>Redeem Amount</td>
                <td class="text-right" id="shipping_charges"><i class="fa fa-inr" aria-hidden="true"></i> 0</td>
              </tr>
              <tr>
                <td><strong>Grand Total</strong></td>
                <td class="text-right"><strong><i class="fa fa-inr" aria-hidden="true"></i> <?php echo round($totalamount); ?></strong></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      
      <div class="col-sm-12 col-md-9 col-md-pull-3">
        <ul class="nav nav-pills nav-stacked">
          <div class="panel-group" id="accordion">
          <!-- Email Login Content -->
          <div class="panel panel-default" <?php if(@$_SESSION['userid'] != '' ) { ?> style="pointer-events: none;" <?php } ?> >
            <div class="panel-heading">
              <p class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"> Login </a> </p>
            </div>
            <div id="collapse1" class="panel-collapse collapse <?php if(@$_SESSION['userid'] == '' ) { ?> in <?php } ?>">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="login-wrap" style="background:none; padding:0; width: 100%;">
                      <h3>Login </h3>
                      <p>If you have an account, sign in with your email address.</p>
                      <div class="mb-30">
                        <form  action="<?php echo $base_url;?>home/login_customer" method="post" id="login_form_header" >
                         <input type="hidden" name="redirect_url" value="<?php echo @$_SERVER['HTTP_REFERER']; ?>"/> 
                        <input type="hidden" name="action" value="login"/> 
                        <div id="login_error" class="alert-message valierror form-group" style="display:none;">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>

                        <div class="form-group">
                            <label for="email">Email address :</label>
                            <input type="email" class="form-control" name="login_email" id="login_email">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password :</label>
                            <input type="password" class="form-control" name="login_password" id="login_password">
                        </div>
                        <div class="checkbox clearfix">
                            <label class="pull-left">
                            <input type="checkbox">
                            Remember me</label>
                            <label class="pull-right"> <a class="forgot-password" href="#forgot-password">Forgot your password?</a> </label>
                          </div>
                          <p>
                            <button type="button" onClick="javascript:header_logins(); return false;" class="btn btn-default-red">Login <i class="fa fa-sign-in" aria-hidden="true"></i></button>
                          </p>
                          <p>No Account Yet? <a class="register" href="#register-form">Register</a> </p>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="vertical-line visible-lg visible-md">
                      <div class="circle-or">OR</div>
                    </div>
                    <div class="checkout-page-or">
                      <div class="login-wrap visible-xs visible-sm">
                        <div class="loginOr mb-15"><span>OR</span></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="checkout-page-login">
                      <div class="login-social-media"> 
					     <a href="#" class="facebook">Facebook &nbsp;&nbsp;<i class="fa fa-facebook" aria-hidden="true"></i></a>
                                <a href="#" class="google">Google &nbsp;&nbsp;<i class="fa fa-google" aria-hidden="true"></i></a>
					  
					  </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" >
            <form action="<?php echo $base_url; ?>billship/checkoutCustomer/1" id="checkout" method="POST"> 
              <p class="panel-title"> <a <?php if(@$_SESSION['userid'] == '' ) { ?> style="pointer-events: none;" <?php } ?> data-toggle="collapse" data-parent="#accordion" href="#collapse2"> Shipping Address</a> </p>
            </div>
            <div id="collapse2" class="panel-collapse collapse <?php if(@$_SESSION['userid'] != '' ) { ?> in <?php } ?>">
              <div class="panel-body">
                <div class="row">
                    <input type="hidden" value="0" id="add_new_address" name="add_new_address" />   
                        <input type="hidden" value="" name="selectedaddress" id="selectedaddress"  />
                <?php  $displayaddress ='block';
               $addchecked   = 'checked'; 
                if($user_address !="" && count($user_address) > 0){
                    $i=1; 
                    foreach($user_address as $address){ 
                      //echo "<pre>";print_r($address);echo "</pre>";
                      ?>

                  <div class="col-md-4 col-xs-12 mb-30">
                    <div class="border-solid padding-15">
                      <div class="border-dotted-bottom mb-15">
                        <label class="control control--radio">
                        Select Delivery Address
                        <input name="address" type="radio" <?php if($address->default_address == 1) {echo "checked";} ?> onclick="javascript:selectadd('<?php echo $address->id; ?>','<?php echo $address->post_code; ?>');" >
                        <div class="control__indicator"></div>
                        </label>
                        
                      </div>
                      <div>
                        <p><?php echo $address->first_name; ?></p>
                        <p><?php echo $address->address2.' '.$address->address1; ?></p>
                        <p><?php echo $address->city.'-'.$address->post_code; ?></p>
                        <p><?php echo $address->state; ?></p>
                       <!-- <p><?php //echo $address->country; ?></p> -->
                        <!-- <p class="add-trash-icon clearfix">
                            <span><button type="submit" class="btn grey-btn-samll margin-left-0"><i class="fa fa-map-marker" aria-hidden="true"></i> Delivery Here </button></span>
                            <span class="pull-right"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>
                        </p> -->
                      </div>
                    </div>
                  </div>
                  <?php $i++; }  ?>
                   <?php $displayaddress ='none'; $addchecked='';} ?>
                </div>
                <script>function selectadd(id,pincode){
                    $("#selectedaddress").val(id);
                     $("#add_new_address").val(0);
                    
                    //setajaxpincode(pincode);
                    //cartupdatetotal();
                }</script>
                <div class="row">
                  <div class="col-sm-12 mb-30"> <a class="add-address-btn" data-toggle="collapse" onclick="newaddress();" href="javascript:void(0);" data-target="#newShippingAddress"><i class="fa fa-plus" aria-hidden="true"></i> Add New Address</a> </div>
                </div>
               
                <div class="row">
	                <div class="collapse" id="newShippingAddress">
               
                    <input type="radio" id="newaddradio" name="radioaddress" value="0" style="display:none;" <?php echo $addchecked; ?> />

                     <div class="col-md-12">
                     	<div class="row">
							<div class="col-md-12 mb-5">
								<h4>Shipping Address</h4>
							</div>
						</div>
                        
                        <div class="form-group">
                          <label class="control-label col-sm-3">Address Title</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" ame="address_title" id="address_title">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="first_name" id="first_name"  value="<?php echo $this->session->userdata('name'); ?>">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Pincode</label>
                          <div class="col-sm-9">
                            <input type="text" readonly class="form-control" name="post_code" id="post_code" value="<?php echo $this->session->userdata('check_pincode'); ?>">
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
                        <!-- <div class="form-group">
                          <label class="control-label col-sm-3">Country</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="country" id="country">
                          </div>
                        </div> -->
                        <div class="form-group">
                          <label class="control-label col-sm-3" for="pwd">Phone</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="phone_number" id="phone_number"  value="<?php echo $this->session->userdata('mobile'); ?>">
                          </div>
                        </div>
                    </div>
                    
                    	<div class="col-md-12">
                        <div class="row">
                       
                        <div class="col-md-12">
                            <div class="clearfix mb-5">
                                <span class="pull-left" style="margin-right: 10px;"><h4>Billing Address </h4></span>
                                <span class="pull-left" style="margin-top: 8px;">
                                    <input class="checkdata" type="checkbox" checked name="samebill" id="buttoncheck" value="1" > 
                                </span>
                                </div>
                        </div>
                    </div>
                      <div class="form-horizontal" id="billadd" style="display:none;">
                        
                        <div class="form-group">
                          <label class="control-label col-sm-3">Address Title</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="bill_address_title" name="bill_address_title">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="bill_first_name" name="bill_first_name">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Pincode</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="bill_post_code" name="bill_post_code">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Address</label>
                          <div class="col-sm-9">
                            <textarea class="form-control" rows="3" id="bill_address1" name="bill_address1"></textarea>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3">Landmark</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="(Optional)" id="bill_address2" name="bill_address2">
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
                            <!-- <input type="text" class="form-control" name="bill_state" id="bill_state"> -->
                          </div>
                        </div>
                        <!-- <div class="form-group">
                          <label class="control-label col-sm-3">Country</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="bill_country" id="bill_country">
                          </div>
                        </div> -->
                        <div class="form-group">
                          <label class="control-label col-sm-3" for="pwd">Phone</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="bill_phone_number" id="bill_phone_number" value="<?php echo $this->session->userdata('mobile'); ?>">
                          </div>
                        </div>
                        
                      </div>
                    </div>

                    <div class="form-group">
                          <label class="control-label col-sm-3">&nbsp;</label>
                          <div class="col-sm-9">
                            <button type="button" class="btn btn-default-red" data-toggle="collapse" data-parent="#accordion" href="#collapse3" >Save and Continue <i class="fa fa-bookmark-o" aria-hidden="true"></i></button>
                          </div>
                    </div>
                    </form>
                  </div>
				</div>
              </div>
            </div>
          </div>
            <!-- Order Review Content -->
            <div class="panel panel-default">
              <div class="panel-heading">
                <p class="panel-title"> <a  <?php if(@$_SESSION['userid'] == '' ) { ?> style="pointer-events: none;" <?php } ?> data-toggle="collapse" data-parent="#accordion" href="#collapse3"> Order Review</a> </p>
              </div>
              <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                	<div class="cart-wrap">
    	
        <div class="cart-header-bg hidden-xs">
            <div class="row">
                <div class="col-md-6 col-sm-6 cart-tb-header-item">Product</div>
                <div class="col-md-1 col-sm-2 text-center cart-tb-header-item">Qty</div>
                <div class="col-md-3 col-sm-2 text-center cart-tb-header-item">Price</div>
                <div class="col-md-2 col-sm-2 text-center cart-tb-header-item">Subtotal</div>
            </div>
        </div>
		
        <div class="product-cart-details">

            <?php   
                $cart_subtotal='0';
                if($this->cart->total_items() > 0) {  $i = 1;
                    foreach($this->cart->contents() as $items)  
                    {  
            ?>

            	<div class="product-cart-bdr-t">
                <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 mb-15 text-xs-center">
                    <div class="product-cart-img"><img src="<?php echo $http_host;?>upload/product/<?php echo $items['options']['base_image']; ?>" alt="" /></div>
                    <div class="cart-image-descr">
                        <p><a href="#" class="cart-image-title"><?php echo $items['name']; ?></a></p>
                        <p><?php echo $items['options']['material_type']; ?></p>
                    </div>
                </div>
                <div class="col-md-1 col-sm-2 col-xs-12 mb-15 text-center">
                	<?php echo $items['qty']; ?>
                </div>
                <div class="col-md-3 col-sm-2 col-xs-12 mb-15 text-xs-center text-center">
                    <p><strong><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $items['price']; ?>/-</strong></p>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12 mb-15 text-xs-center text-center"> <strong><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $items['price'] * $items['qty']; ?></strong> </div>
                </div>
        		</div>
        <?php $cart_subtotal +=$items['subtotal']; }  }else{ echo 'Your Cart is Empty'; } ?>
            <div class="row">
            	<div class="col-md-5 mb-30">
                	<form id="coupon_form" novalidate="novalidate">
                            <div id="coupon_error" class="alert-message valierror form-control" style="display:none; margin-bottom: 5px; width: 100%;"></div>
                            <div id="coupon_success" class="alert-message success form-control" style="display:none; margin-bottom: 5px; width: 100%; color:green;"></div>
                        <div class="input-group">

                            <span class="input-group-addon"><i class="fa fa-gift fa-lg" aria-hidden="true"></i></span>
                            <input id="input-coupon" placeholder="Have A Coupon Code?" class="form-control" style="border-radius:0" type="text">
                            <span class="input-group-btn">
                                <button id="serviceability" class="btn btn-custom" type="button" onClick="coupancheck();" style="border-radius:0">
                                    <span>Apply</span>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>

            	<div class="col-md-5 col-md-offset-2 order-details">
                    <table class="table">
                      <h4><b>Order details</b></h4>
                      <tbody>
                        <tr>
                          <td>Bag Total</td>
                          <td class="text-right" id="sub_total"> <i class="fa fa-inr" aria-hidden="true"></i> <?php echo round($this->cart->total()); ?></td>
                        </tr>
                       <!-- <tr class="border-bottom-dashed">
                          <td>Shipping Charges</td>
                          <td class="text-right" id="shipping_charges"><i class="fa fa-inr" aria-hidden="true"></i> 0</td>
                        </tr>
                        <?php if($discountamount != 0){ ?>
                        <tr class="border-bottom-dashed">
                          <td>Discount Amount</td>
                          <td class="text-right" id="shipping_charges"><i class="fa fa-inr" aria-hidden="true"></i> <?= $discountamount; ?><a  title="Delete Coupon" onclick="removecoupon();" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        </tr>
                    <?php } ?>-->
                        <tr class="border-bottom-dashed">
                          <td>Redeem Amount</td>
                          <td class="text-right" id="shipping_charges"><i class="fa fa-inr" aria-hidden="true"></i> 0</td>
                        </tr>
                        <tr>
                          <td><strong>Order Total</strong></td>
                          <td class="text-right"><strong><i class="fa fa-inr" aria-hidden="true"></i> <?php echo round($totalamount); ?></strong></td>
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div>
             <?php     
                $cart_subtotal='0';
                //$discountamount=0;
                $is_col_product = 0;
                $shipping_charge =0;
                //echo "<pre>";print_r($this->cart->contents());echo "</pre>";
                if($this->cart->total_items() > 0) {  $i = 1;
                    foreach($this->cart->contents() as $items)  
                    { 
                      $cart_subtotal +=$items['subtotal']; 
                      $is_col_product = $items['options']['is_col_product'];
                    }  } 
                    //echo $is_col_product;
                    ?>
            <div class="row">
            	  <div class="col-md-12 text-right check-out-btn-wrap" style="margin-bottom:10px;">
                <?php if($is_col_product == 1) {?>
                  <input type="radio" name="paymenttype" value="1" checked> Cash On Delivery
                  <?php } else { ?>
                    <input type="radio" name="paymenttype" value="1" checked> Cash On Delivery &nbsp;
                  <!-- <input type="radio" name="paymenttype" value="2" checked> Pay Online -->
                  <?php }?>
                </div>
            </div>
            <div class="row">
            	<div class="col-md-12 text-right check-out-btn-wrap">
                	<ul>
                        <div id="error_checkout" class="error alert-message valierror form-control" style="display:none;color:#fff;"></div> 
                    	<li><button class="btn btn-default-red" onclick="checkout();">Make Payment  <i class="fa fa-money" aria-hidden="true"></i></button></li>
                    </ul>
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
        </ul>
      </div>
    </div>
  </div>
</div>
<!--Product page End-->


<?php include('includes/footer.php');
/*
echo "<pre>";
print_r($this->session->userdata()); die;*/
$str = 'BDSKUATY|BPCL-456|NA|'.$total.'|NA|NA|NA|INR|NA|R|bdskuaty|NA|NA|F|NA|NA|NA|'.$this->session->userdata('email').'|NA|NA|NA|NA';
$checksum = hash_hmac('sha256',$str,'G3eAmyVkAzKp8jFq0fqPEqxF4agynvtJ', false); 
$checksum = strtoupper($checksum);
//echo $checksum;
?>
<script type="text/javascript" src="https://services.billdesk.com/checkout-widget/src/app.bundle.js"></script>
<script>
function newaddress()
    {
        $('#newadd').show();
        $("#newaddradio").prop("checked", true);
        
        if ($('#add_new_address').val() == "0") {
            $("#add_new_address").val(1);
        }
        else {
           $("#add_new_address").val(0);
        }
    }

    $(function(){
    $("#buttoncheck").click(function(){
        if($(this).is(":checked")){
          $('#billadd').hide();
        }else{           
            $('#billadd').show();
         }
        })
    });

function checkout(){
        var pincodevalid = $("#checkoutproceeed").val();
        var add_new_address = $("#add_new_address").val();
        var seladd = $('#selectedaddress').val();

        /*var terms = $('input:checkbox[name=refundexchangepolicy]').is(':checked');
        if(terms == false){
            $("#error_checkout").html("Please accept return & exchange policy");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }*/
        
        if(add_new_address == '0' || seladd != '') {
        
        if(seladd == ''){
            $("#error_checkout").html("Please Select Address OR Add New Address.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#error_checkout').offset().top - 200
            }, 1000);
            return false;
        } 
        /*if(pincodevalid != '1'){
            $("#error_checkout").html("Please add address with valid pincode.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#error_checkout').offset().top - 200
            }, 1000);

            return false;
        }*/

        //$('#checkout').submit();   

        if ($('input[name=paymenttype]').is(':checked')) {
            var value = $("input[name=paymenttype]:checked").val();
            $('#checkout').attr('action', '<?php echo $base_url; ?>billship/checkoutCustomer/' + value);
            $('#checkout').submit(); 
          } else {
              $("#error_checkout").html("Please Select Payment Mode.");
              $('#error_checkout').show().delay(0).fadeIn('show');
              $('#error_checkout').show().delay(2000).fadeOut('show');
              return false;
          }
        
         
            
        // var formValues= $('#checkout').serialize();
        // var url = '<?php echo $base_url ?>billship/checkoutCustomer';
        // $.post(url, formValues, function(data){
        // console.log(data);
        //     bdPayment.initialize({
        //         msg :'BDSKUATY|BPCL-456|NA|<?= $total; ?>|NA|NA|NA|INR|NA|R|bdskuaty|NA|NA|F|NA|NA|NA|<?= $this->session->userdata('email'); ?>|NA|NA|NA|NA|<?php echo $checksum; ?>',
        //                 callbackUrl: '<?php echo $base_url."billship/successCustomer/" ?>'+data,
        //     options : {
        //                     enableChildWindowPosting : true,
        //                     enablePaymentRetry : true,
        //                     retry_attempt_count: 2
        //                 }   
        //          });
        // });

        } else { 
        
        var checkout_first_name = $("#first_name").val();
        if(checkout_first_name == ''){
            $("#error_checkout").html("Please Enter First Name.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#checkout_first_name').offset().top - 200
            }, 1000);
            return false;
        }
        var checkout_last_name = $("#checkout_last_name").val();
        if(checkout_last_name == ''){
            $("#error_checkout").html("Please Enter Last Name.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#error_checkout').offset().top - 200
            }, 1000);
            return false;
        }
        
        var checkout_phone_number = $("#phone_number").val();
        if(checkout_phone_number == ''){
            $("#error_checkout").html("Please Enter Phone Number.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#error_checkout').offset().top - 200
            }, 1000);
            return false;
        }
        var emn = $("#phone_number").val();
         var filter_number=/^[0-9]{10}$/;
        if (!filter_number.test(emn)) { 
        $("#error_checkout").html("Enter Phone Number should be 10 digits");
        $('#error_checkout').show().delay(0).fadeIn('show');
        $('#error_checkout').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#error_checkout').offset().top - 200
            }, 1000);
            return false;
        }
        
        var checkout_address = $("#address1").val();
        if(checkout_address == ''){
            $("#error_checkout").html("Please Enter Address.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#error_checkout').offset().top - 200
            }, 1000);
            return false;
        }
        
        //     var checkout_country = $("#country").val();
        // if(checkout_country == ''){
        //     $("#error_checkout").html("Please Select Country.");
        //     $('#error_checkout').show().delay(0).fadeIn('show');
        //     $('#error_checkout').show().delay(2000).fadeOut('show');
        //     $('html, body').animate({
        //         scrollTop: $('#error_checkout').offset().top - 200
        //     }, 1000);
        //     return false;
        // }
        var checkout_state = $("#state").val();
        if(checkout_state == ''){
            $("#error_checkout").html("Please Select State.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#error_checkout').offset().top - 200
            }, 1000);
            return false;
        }
        var checkout_city = $("#city").val();
        if(checkout_city == ''){
            $("#error_checkout").html("Please Enter City.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#error_checkout').offset().top - 200
            }, 1000);
            return false;
        } 
        
        var checkout_zip_code = $("#post_code").val();
        if(checkout_zip_code == ''){
            $("#error_checkout").html("Please Enter Zip / Postal Code.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#error_checkout').offset().top - 200
            }, 1000);
            return false;
        }
        
        var em = $("#post_code").val();
         var filter=/^[0-9]{6}$/;
        if (!filter.test(em)) { 
        $("#error_checkout").html("Enter Zip Code should be 6 digits");
        $('#error_checkout').show().delay(0).fadeIn('show');
        $('#error_checkout').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#error_checkout').offset().top - 200
            }, 1000);
            return false;
        }
        
        /*var url = '<?php echo $base_url ?>cart/checkpincode';
        $.ajax({
            url:url,
            type:'post',
            data:'pincode='+checkout_zip_code,
            success:function(msg)
            {
                if(msg ==1)
                { */
                    
                    /*if(pincodevalid != '1'){
                        $("#error_checkout").html("Please add address with valid pincode.");
                        $('#error_checkout').show().delay(0).fadeIn('show');
                        $('#error_checkout').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#error_checkout').offset().top - 200
                        }, 1000);
                        return false;
                    }*/
                    
                    if($("#ckbShippingAddr").prop("checked") == true){  
                    var bill_checkout_first_name = $("#bill_first_name").val();
                    if(bill_checkout_first_name == ''){
                        $("#error_checkout").html("Please Enter Bill First Name.");
                        $('#error_checkout').show().delay(0).fadeIn('show');
                        $('#error_checkout').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#error_checkout').offset().top - 200
                        }, 1000);
                        return false;
                    }
                    var bill_checkout_last_name = $("#bill_checkout_last_name").val();
                    if(bill_checkout_last_name == ''){
                        $("#error_checkout").html("Please Enter Bill Last Name.");
                        $('#error_checkout').show().delay(0).fadeIn('show');
                        $('#error_checkout').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#error_checkout').offset().top - 200
                        }, 1000);
                        return false;
                    }
                    
                    var bill_checkout_phone_number = $("#bill_phone_number").val();
                    if(bill_checkout_phone_number == ''){
                        $("#error_checkout").html("Please Enter Bill Phone Number.");
                        $('#error_checkout').show().delay(0).fadeIn('show');
                        $('#error_checkout').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#error_checkout').offset().top - 200
                        }, 1000);
                        return false;
                    }
                    var emn = $("#bill_phone_number").val();
                     var filter_number=/^[0-9]{10}$/;
                    if (!filter_number.test(emn)) { 
                    $("#error_checkout").html("Enter Bill Phone Number should be 10 digits");
                    $('#error_checkout').show().delay(0).fadeIn('show');
                    $('#error_checkout').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                                scrollTop: $('#error_checkout').offset().top - 200
                        }, 1000);
                        return false;
                    }
                    
                    var bill_checkout_address = $("#bill_address1").val();
                    if(bill_checkout_address == ''){
                        $("#error_checkout").html("Please Enter Bill Address.");
                        $('#error_checkout').show().delay(0).fadeIn('show');
                        $('#error_checkout').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                                scrollTop: $('#error_checkout').offset().top - 200
                        }, 1000);
                        return false;
                    }
                    
                    // var bill_checkout_country = $("#bill_country").val();
                    // if(bill_checkout_country == ''){
                    //     $("#error_checkout").html("Please Select Bill Country.");
                    //     $('#error_checkout').show().delay(0).fadeIn('show');
                    //     $('#error_checkout').show().delay(2000).fadeOut('show');
                    //     $('html, body').animate({
                    //             scrollTop: $('#error_checkout').offset().top - 200
                    //     }, 1000);
                    //     return false;
                    // }
                    var bill_checkout_state = $("#bill_state").val();
                    if(bill_checkout_state == ''){
                        $("#error_checkout").html("Please Select Bill State.");
                        $('#error_checkout').show().delay(0).fadeIn('show');
                        $('#error_checkout').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                                scrollTop: $('#error_checkout').offset().top - 200
                        }, 1000);
                        return false;
                    }
                    var bill_checkout_city = $("#bill_city").val();
                    if(bill_checkout_city == ''){
                        $("#error_checkout").html("Please Enter Bill City.");
                        $('#error_checkout').show().delay(0).fadeIn('show');
                        $('#error_checkout').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                                scrollTop: $('#error_checkout').offset().top - 200
                        }, 1000);
                        return false;
                    }
                    
                    var bill_checkout_zip_code = $("#bill_post_code").val();
                    if(bill_checkout_zip_code == ''){
                        $("#error_checkout").html("Please Enter Bill Zip / Postal Code.");
                        $('#error_checkout').show().delay(0).fadeIn('show');
                        $('#error_checkout').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                                scrollTop: $('#error_checkout').offset().top - 200
                        }, 1000);
                        return false;
                    }
                    
                    var em = $("#bill_post_code").val();
                    var filter=/^[0-9]{6}$/;
                    if (!filter.test(em)) { 
                    $("#error_checkout").html("Enter Bill Zip Code should be 6 digits");
                    $('#error_checkout').show().delay(0).fadeIn('show');
                    $('#error_checkout').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                                scrollTop: $('#error_checkout').offset().top - 200
                        }, 1000);
                        return false;
                    }
                        $('#checkout').submit();

                        // var formValues= $('#checkout').serialize();
                        // var url = '<?php echo $base_url ?>billship/checkoutCustomer';
                        // $.post(url, formValues, function(data){
                        // console.log(data);
                        //     bdPayment.initialize({
                        //         msg :'BDSKUATY|BPCL-456|NA|<?= $total; ?>|NA|NA|NA|INR|NA|R|bdskuaty|NA|NA|F|NA|NA|NA|<?= $this->session->userdata('email'); ?>|NA|NA|NA|NA|<?php echo $checksum; ?>',
                        //                 callbackUrl: '<?php echo $base_url."billship/successCustomer/" ?>'+data,
                        //     options : {
                        //                     enableChildWindowPosting : true,
                        //                     enablePaymentRetry : true,
                        //                     retry_attempt_count: 2
                        //                 }   
                        //          });
                        // });
                    
                    }else
                    {
                        $('#checkout').submit();
                        // var formValues= $('#checkout').serialize();
                        // var url = '<?php echo $base_url ?>billship/checkoutCustomer';
                        // $.post(url, formValues, function(data){
                        // console.log(data);
                        //     bdPayment.initialize({
                        //         msg :'BDSKUATY|BPCL-456|NA|<?= $total; ?>|NA|NA|NA|INR|NA|R|bdskuaty|NA|NA|F|NA|NA|NA|<?= $this->session->userdata('email'); ?>|NA|NA|NA|NA|<?php echo $checksum; ?>',
                        //                 callbackUrl: '<?php echo $base_url."billship/successCustomer/" ?>'+data,
                        //     options : {
                        //                     enableChildWindowPosting : true,
                        //                     enablePaymentRetry : true,
                        //                     retry_attempt_count: 2
                        //                 }   
                        //          });
                        // });
                    }                   
               /* }else
                {
                    //$("#error_checkout").html("The Service is not available in your pincode");
                    $("#error_checkout").html("This product is not available for delivery");
                    $('#error_checkout').show().delay(0).fadeIn('show');
                    $('#error_checkout').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                                scrollTop: $('#error_checkout').offset().top - 200
                        }, 1000);
                        return false;
                }*/
          /*  } 
        }); */
        }
    }
</script>

<script>
function coupancheck()  
{
        if ($("#input-coupon").val() == '')
                {
                    $("#coupon_error").html("Please Enter Coupon Code.");
                    $('#coupon_error').show().delay(0).fadeIn('show');
                    $('#coupon_error').show().delay(2000).fadeOut('show');
                        return false;
                }
                else
                {   
                    var minimum ='<?php echo $cart_subtotal; ?>';
                     $.ajax(
                     {
                         type: 'POST',
                         url: '<?php echo $base_url; ?>cart/couponcheck',
                         data: "coupon="+$("#input-coupon").val()+"&minimum="+minimum,
                         success: function(result)
                            {
                               if(result == 'invalid')
                                 {
                                    $("#coupon_error").html("Invalid Coupon Code.");
                                    $('#coupon_error').show().delay(0).fadeIn('show');
                                    $('#coupon_error').show().delay(2000).fadeOut('show');
                                    $("#coupon_success").html("");
                                     return false;
                                 }else if (result == 'Already') {
                                     $("#coupon_error").html("Coupan Code is Already Applied");
                                     $('#coupon_error').show().delay(0).fadeIn('show');
                                     $('#coupon_error').show().delay(2000).fadeOut('show');
                                     $("#coupon_success").html("");
                                    return false;
                                 }else if(result == 'success'){
                                    location.reload();
                                                //cartupdatetotal();
                                                $("#coupon_error").html("");
                                                $("#coupon_success").html("Coupon Code Applied Succsessfully");
                                                $('#coupon_success').show().delay(0).fadeIn('show');
                                                $('#coupon_success').show().delay(2000).fadeOut('show');
                                                $("#input-coupon").val("");
                                 }else{
                                     $("#coupon_error").html("Minimum order amount should be RS. "+result);
                                     $('#coupon_error').show().delay(0).fadeIn('show');
                                     $('#coupon_error').show().delay(2000).fadeOut('show');
                                     $("#coupon_success").html("");
                                    return false; 
                                    }
                            }
                    });
                }
}
function removecoupon()
{
    $.ajax(
    {
     type: 'POST',
     url: '<?php echo $base_url; ?>cart/removecoupon',
     data:'',
     success: function(msg)
        {
            cartupdatetotal();
        }
    });
}   
</script>