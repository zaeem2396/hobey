<?php include('includes/header.php');?>
<style>
form {
    padding: 0px 0;
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
}

.valierror123{
    background-color:#008000;
    border-color: #008000;
    color: #fff;
}
.line-through {
    text-decoration: line-through;
}
</style>
<div class="container">
	<div class="cart-wrap pdd50">
	    
	        	<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
				   <li class="breadcrumb-item"><a href="<?php echo $base_url; ?>"><i class="fa fa-home" aria-hidden="true"></i></a></li>			
					<li class="breadcrumb-item active" aria-current="page">View Cart</li>
				  </ol>
				</nav>

                <?php if($this->session->flashdata('msg_success')){ ?>
                <div  class="alert-message successmain form-group" style="display:block;"><i class="fa fa-check" aria-hidden="true"></i> <?php echo $this->session->flashdata('msg_success'); ?></div>

            <?php } ?>

    	   <div class="row mb-15">
        		<div class="col-md-4"><h4>My Shopping Bag ( <?php echo count($this->cart->contents()); ?> Items)</h4></div>
            	<div class="col-md-8 text-right check-out-btn-wrap">
                	<ul>
                    	<!-- <li><a href="<?php echo $base_url; ?>product-listing"><button class="btn grey-btn"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;Continue shopping</button></a></li> -->
                    	<li><a href="<?php echo $base_url; ?>customer-checkout"><button class="btn btn-default-red">Proceed to checkout <i class="fa fa-shopping-cart" aria-hidden="true"></i></button></a></li>
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
                    
                    $product_detail = $this->cart_model->get_product($items['id']);
                    //echo "<pre>";print_r($product_detail);echo "</pre>";
            ?>
            <div class="product-cart-bdr-t">
            <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 mb-15 text-xs-center">
                <div class="product-cart-img"><img src="<?php echo $http_host;?>upload/product/<?php echo $items['options']['base_image']; ?>" alt="" /></div>
                <div class="cart-image-descr">
                    <p><a href="<?php echo $base_url; ?>product-detail/<?php echo $product_detail->page_url; ?>-<?php echo $product_detail->user_info_id; ?>" class="cart-image-title"><?php echo $items['name']; ?></a></p>
                    <p><?php echo $items['options']['material_type']; ?></p>
              
                    <div class="clearfix">
                        <!--<div class="pull-left cart-gift-wrap"><label><input class=""  type="checkbox"> Gift wrap this</label></div>-->
                        <div class="pull-right ">
                           <!--  <a href="#" class="wishlist"><i class="fa fa-heart" aria-hidden="true"></i></a> -->
                            <a href="javacript:void(0);" class="remove" onclick="removeproduct('<?php echo $items['rowid']; ?>')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1 col-sm-2 col-xs-12 mb-15">
                <select class="form-control cart-qty-input qty_<?php echo $items['rowid']; ?>" id="sel1" onchange="changeqty('<?php echo $items['rowid']; ?>',this.value,<?php echo $items['id']; ?>,<?php echo $items['options']['distributor_id']; ?>,<?php echo $items['qty']; ?>);">
                    <option value="1" <?php if($items['qty'] == '1') { echo "selected";  } ?>>1</option>
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
            	<div class="col-md-4 col-md-offset-8 order-details">
                    <table class="table">
                      <h4><b>Order details</b></h4>
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
            	<div class="col-md-12 text-right check-out-btn-wrap">
                	<ul>
                    	<!-- <li><a href="<?php echo $base_url; ?>product-listing"> <button class="btn grey-btn"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;Continue shopping</button></a></li> -->
                    	<li><a href="<?php echo $base_url; ?>customer-checkout"><button class="btn btn-default-red">Proceed to checkout <i class="fa fa-shopping-cart" aria-hidden="true"></i></button></a></li>
                    </ul>
                </div>
            </div>
            
        </div>
        
  	</div>
    

</div>
<?php include('includes/footer.php');?>
<script>
function removeproduct(id){
        var p = confirm('Are you sure u want to remove product');
        if(p){
            $.ajax(
             {
                 type: 'POST',
                 url: '<?php echo $base_url; ?>cart/removeproduct_customer/'+id,
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

function changeqty(id,qty,pid,distributor_id,oldQty)
{

    var url = "<?php echo $base_url; ?>cart/checkCartstock";
				$.ajax({
						url:url,
						type:'post',
						data:'product_id='+pid+'&qty='+qty+'&distributor_id='+distributor_id,
						success:function(msg)
                        {
									if(msg == 'nostock')
									{
										alert('Out Of Stock');
                                        jQuery(".qty_"+id).val(oldQty);
										return false;	
									}
                                    if(msg == 'instock'){
                                        if(qty != '0')
                                        {
                                            var url='<?php echo $base_url."cart/changeqty_customer/"; ?>'+id+'/'+qty;        
                                            window.location = url;
                                            return true;
                                        }
									}
												
						}	
				});

   
}
</script>