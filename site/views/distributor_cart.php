<?php include('includes/header.php');?>
<style>
.content {    display: block;}
.btn-default-red {
    background-color: #fdbb28;
    border: 1px solid #fdbb28;
    transition: all 0.3s ease 0s;
    color: #fff;
    padding: 6px 22px;
    text-transform: uppercase;
        border-radius: 30px;
        margin-bottom:10px;
}
.pull-right { padding-bottom: 30px;}
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
.grey-btn { margin-bottom:10px; padding: 6px 22px;}
</style>
<section class=" login-reg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
<?php include('includes/sidebar_distributor.php');?>

<div class="content-wrapper">
  <div class="content">
         
   <div class="row">
            	<div class="login-main">
		        	<div class="login">

					<a href="<?php echo $base_url; ?>distributor-product-listing" class="sub-btn" > List Product </a>
					
	<div class="cart-wrap pdd50">
	    <div class="row mb-15">
    		<div class="col-md-4"><h4>My Shopping Bag ( <?php echo count($this->cart->contents()); ?> Items)</h4></div>
            	<div class="col-md-8 text-right check-out-btn-wrap">
                	<ul>
                    	<!-- <li><button class="btn grey-btn"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;Continue shopping</button></li> -->
                    	<li><button class="btn btn-default-red" onclick="location.href='<?php echo $base_url; ?>distributor-checkout';" >Proceed to checkout <i class="fa fa-shopping-cart" aria-hidden="true"></i></button></li>
                    </ul>
                </div>
            </div>
        <div class="cart-header-bg hidden-xs">
            <div class="row">
                <div class="col-md-6 col-sm-6 cart-tb-header-item">Product</div>
                <div class="col-md-1 col-sm-2 cart-tb-header-item">Qty</div>
                <div class="col-md-3 col-sm-2 cart-tb-header-item">Price</div>
                <div class="col-md-2 col-sm-2 cart-tb-header-item">Subtotal</div>
            </div>
        </div>

        <div class="product-cart-details mb-100">

            <?php
                $cart_subtotal='0';
                if($this->cart->total_items() > 0) {    
                $i = 1;
                foreach($this->cart->contents() as $items)  
                { 
                
                ?>

        	<div class="product-cart-bdr-t">
            <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 mb-15 text-xs-center">
                <div class="product-cart-img" ><img src="<?php echo $http_host;?>upload/product/<?php echo $items['options']['base_image']; ?>" alt="" style="width: 100px;"></div>
                <div class="cart-image-descr">
                    <p><a href="#" class="cart-image-title"><?php echo $items['name']; ?></a></p>
                    <p><?php echo $items['options']['material_type']; ?></p>

                    <div class="clearfix">
                        <div class="pull-right ">
                            <!-- <a href="#" class="wishlist"><i class="fa fa-heart" aria-hidden="true"></i></a> -->
                            <a href="javacript:void(0);" class="remove"  onclick="removeproduct('<?php echo $items['rowid']; ?>')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-1 col-sm-2 col-xs-12 mb-15">
                <select class="form-control cart-qty-input oldqtycheck_<?php echo $items['rowid']; ?>" id="sel1" onchange="changeqty('<?php echo $items['rowid']; ?>',this.value,<?php echo $items['min_qty']; ?>,<?php echo $items['qty']; ?>);">
                    <option value="1" <?php if($items['qty'] == '1') { echo "selected";  } ?> >1</option>
                    <option value="2" <?php if($items['qty'] == '2') { echo "selected";  } ?>>2</option>
                    <option value="3" <?php if($items['qty'] == '3') { echo "selected";  } ?>>3</option>
                    <option value="4" <?php if($items['qty'] == '4') { echo "selected";  } ?>>4</option>
                    <option value="5" <?php if($items['qty'] == '5') { echo "selected";  } ?>>5</option>
                </select>
            </div>
            <div class="col-md-3 col-sm-2 col-xs-12 mb-15 text-xs-center">
                <p><strong><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $items['price']; ?>/-</strong></p>
                <!-- <p>Discount 40%</p> -->
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 mb-15 text-xs-center"> <strong><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $items['price'] * $items['qty']; ?></strong> </div>
        </div>
		</div>
    <?php } } ?>
            <div class="row">
            	<div class="col-md-6 order-details">
                    <h4><b>Order details</b></h4><table class="table">
                      <tbody>
                        <tr>
                          <td>Bag Total</td>
                          <td class="text-right" id="sub_total"> <i class="fa fa-inr" aria-hidden="true"></i> <?php echo round($this->cart->total()); ?></td>
                        </tr>
                        <!--<tr class="border-bottom-dashed">
                          <td>Shipping Charges</td>
                          <td class="text-right" id="shipping_charges"><i class="fa fa-inr" aria-hidden="true"></i> 0</td>
                        </tr>
                        <tr class="border-bottom-dashed">
                          <td>Discount</td>
                          <td class="text-right" id="shipping_charges"><i class="fa fa-inr" aria-hidden="true"></i> 0</td>
                        </tr>-->
                       <tr>
                          <td><strong>Order Total</strong></td>
                          <td class="text-right"><strong><i class="fa fa-inr" aria-hidden="true"></i> <?php echo round($this->cart->total()); ?></strong></td>
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
            	<div class="col-md-12 check-out-btn-wrap">
                	<ul>
                    	<!-- <li><button class="btn grey-btn"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;Continue shopping</button></li> -->
                    	<li><button class="btn btn-default-red" onclick="location.href='<?php echo $base_url; ?>distributor-checkout';" >Proceed to checkout <i class="fa fa-shopping-cart" aria-hidden="true"></i></button></li>
                    </ul>
                </div>
            </div>
        </div>
  	</div>
  <div class="container">
		<div class="row">
        	<div class="col-md-12">
            	<div style="display:none;">
                    <div id="forgot-password" class="login-wrap">
                        <h3>Forgot Password</h3>
                        <p>Enter your registered email id below</p>
                        <form>
                        <div class="form-group">
                          <label for="email">Email address:</label>
                          <input type="email" placeholder="abc@gmail.com" class="form-control" id="email">
                        </div>
                        <div class="clearfix">
                            <div class="pull-left"><button type="submit" class="btn btn-default-red">Submit <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button></div>
                            <div class="pull-right forgot-login-text">
                            	<a class="login" href="#login-form">Login to your Account</a>
                            </div>
                        </div>
                        </form>                        

                    </div>

                </div>

            </div>

        </div>

			

        <div class="row">

            <div class="col-md-12">

                <div style="display:none">

                    <div id="login-form">

                        <div class="login-wrap">

                            <h3>Log in</h3>

                            <p>If you have an account, sign in with your email address.</p>

                            <div class="mb-30">

                                <form>

                                <div class="form-group">

                                    <label for="email">Email address :</label>

                                    <input type="email" class="form-control" id="email">

                                </div>

                                <div class="form-group">

                                    <label for="pwd">Password :</label>

                                    <input type="password" class="form-control" id="pwd">

                                </div>

                                <div class="checkbox clearfix">

                    <label class="pull-left"><input type="checkbox">Remember me</label>

                    <label class="pull-right">

                    	<a class="forgot-password" href="#forgot-password">Forgot your password?</a>

                    </label>

                  </div>

                                <button type="submit" class="btn btn-default-red">Login <i class="fa fa-sign-in" aria-hidden="true"></i></button>

                            </form>

                            

                            

                            

                            </div>

                            <div class="loginOr mb-15"><span>OR</span></div>

                            

                            <div class="login-social-media">

                                <a href="#" class="facebook">Facebook</a>

                                <a href="#" class="google">Google+</a>

                            </div>

                            

                        </div>

                    </div>

                </div>

            </div>

        </div>

        

        <div class="row">

            <div class="col-md-12">

                <div style="display:none">

                    <div id="register-form">

                        <div class="login-wrap">

                            <h3>Register New Account</h3>

                            <form>

                                <div class="form-group">

                                    <label for="email">Username :</label>

                                    <input type="text" class="form-control" id="email">

                                </div>

                                <div class="form-group">

                                    <label for="pwd">Email Id :</label>

                                    <input type="text" class="form-control" id="pwd">

                                </div>

                                

                                <div class="form-group">

                                    <label for="pwd">Password :</label>

                                    <input type="password" class="form-control" id="pwd">

                                </div>



                                <div class="form-group">

                                    <label for="pwd">Repeat Password :</label>

                                    <input type="password" class="form-control" id="pwd">

                                </div>

                                

                                <button type="submit" class="btn btn-default-red">Register <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>


			</div>
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
function removeproduct(id){
        var p = confirm('Are you sure u want to remove product');
        if(p){
            $.ajax(
             {
                 type: 'POST',
                 url: '<?php echo $base_url; ?>cart/removeproduct/'+id,
                  data:'',
                 success: function(result)
                    {
                        location.reload();
                        //cartupdatetotal();    
                    }
            });
        } else {
            return false;
        }
}

function changeqty(id,qty,min_qty,oldQty)
{
    if(qty < min_qty)
		{
			alert("You need to buy minimum "+min_qty+" quantity");
            $(".oldqtycheck_"+id).val(oldQty);
			return false;
		}
    if(qty != '0')
    {
        var url='<?php echo $base_url."cart/changeqty/"; ?>'+id+'/'+qty;        
        window.location = url;
        return true;
    }
}
</script>