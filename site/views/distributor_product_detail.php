<?php include('includes/header.php');?>

  <link href="<?php echo $base_url_views; ?>assets/css/magiczoomplus.css" rel="stylesheet" type="text/css">
  <style>
  .product_list_right_main ul li {width:30%;}
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

.product_list_right_main ul a li h2 {color:#000;}
</style>


<div class="topalert successmain alert-message" id="order_succsess" style="display:none;"></div>
<div class="topalert valierror alert-message" id="order_succsess1" style="display:none;"></div>
<section class=" login-reg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
<?php include('includes/sidebar_distributor.php');?>
<div class="content-wrapper">
  <div class="content">
         	
<div class="product_list_right_main">
    
    		<div class="col-md-12">
			
		</div>	        	    
		        	    <!--breadcrumbs-->
<div class="container-fluid">
	<div class=" page-nm">
    <i class="fa fa-home" aria-hidden="true"></i>&nbsp; <i class="fa fa-angle-right"></i> &nbsp;<?php echo $product_details->material_name; ?>
    </div>
</div>
<!--breadcrumbs-->

<?php
//echo "<pre>";print_r($product_details);echo "</pre>";
$get_product_image = $this->home_model->get_product_image($product_details->id); ?>
<div class="container">
   <!--img section start-->
     	     <div class="col-md-6 dsp">
    <div class="app-figure" id="zoom-fig">
        <a id="Zoom-1" class="MagicZoom"  data-options="zoomPosition: inner" href="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>"> <img src="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>" alt=""/> </a>

           <div class="selectors text-center">
            <?php  
            if($get_product_image !='')
            {
                foreach($get_product_image as $product_image)
                {
            ?>
           <a data-zoom-id="Zoom-1"href="<?php echo $http_host;?>upload/product/<?php echo $product_image->image; ?>" data-image="<?php echo $http_host;?>upload/product/<?php echo $product_image->image; ?>">
                <img srcset="<?php echo $http_host;?>upload/product/small/<?php echo $product_image->image; ?>" src="<?php echo $http_host;?>upload/product/small/<?php echo $product_image->image; ?>"/>
            </a>          
        <?php } } ?>
         <a data-zoom-id="Zoom-1" href="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>"  data-image="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>">
                <img srcset="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>" src="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>" style="width: 70px;" /> 
            </a>
        <!-- <a id="Zoom-1" class="MagicZoom"  data-options="zoomPosition: inner" href="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>"> <img src="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>" alt=""/> </a> -->
		  <!--  <a data-zoom-id="Zoom-1" href="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>"  data-image="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>">
                <img srcset="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>" src="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>"/> -
            </a>
        !--<a data-zoom-id="Zoom-1" href="<?php echo $base_url_views; ?>assets/images/product1.jpg"  data-image="<?php echo $base_url_views; ?>assets/images/product1.jpg">
                <img srcset="<?php echo $base_url_views; ?>assets/images/product-small.jpg" src="<?php echo $base_url_views; ?>assets/images/product1.jpg"/>
            </a> -->
            </div>
		</div>	
	</div>
    <!--img section end-->   
    
    <div class="col-md-6 dsp1">  
	  	<div class="details font-size-18">					
						<h1 class="product-title"><?php echo $product_details->material_name; ?></h1>
							<div class="rating">
						                             <div class="stars">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
								</div>						
								</div>
						
							<p class="pro-code"><span style="font-size:15px" ;=""> <strong>Material Code : </strong> </span> <span style="font-size:12px;"><?php echo $product_details->material_code; ?> <span></span></span></p>
					
						    <h3 class="price">	<p id="price_detail_change">

                                <div> MRP: <i class="fa fa-rupee"></i> <?php  echo $product_details->mrp; ?></div>
                                <div> BPCL Special Price : <i class="fa fa-rupee"></i> <?php  echo $product_details->bpcl_special_price; ?></div>
                                <span> DBP : <i class="fa fa-rupee"></i> <?php echo $product_details->billing_price + $product_details->deliverypay + $product_details->bpclpay; ?> <span> <!-- <span class="strtt"><i class="fa fa-rupee"></i> 1400</span> -->
                            </p>	</h3>

                            <?php $packsize1 = $product_details->package;
                            if($packsize1 == '' or $packsize1 == 0){
                                $packsize1 = 1;
                            }
                            ?>
                            <p class="fabric" style="font-size:15px;"> <span><strong>Pack Size :</strong></span>   
                                <span><?php echo $packsize1; ?></span>
                             </p>

							<p class="fabric" style="font-size:15px;"> <span><strong>Material Type :</strong></span>   
                                <span> <?php $cate_detaisl = $this->home_model->get_category($product_details->material_type);  echo $cate_detaisl->name;
                                ?> </span>
                             </p>
							<p class="contents"><span>
							<strong> Product description : </strong><br/>
							<?php echo $product_details->product_description; ?>
							</p>
                            <?php  
                            //echo "<pre>";print_r($product_details);echo "</pre>";
                            
                            $minQty = $product_details->min_qty;
                            if($minQty == '' or $minQty == 0){
                                $minQty = 1;
                            }
                            ?>
							<p>
							<div class="number">
                            	<span class="minus">-</span>
                            	<input type="text" id="select_qty" name="quantity" value="<?php echo $minQty; ?>">
                            	<span class="plus">+</span>
                                        </div>
                            </p>            
				
						    <div class="action">
						        	<button class="add-to-cart btn btn-default" onclick="add_to_cart();" type="button" ><span class="fa fa-shopping-cart" style="padding-right: 10px;"></span>add to cart</button>

                            <?php /* if($this->session->userdata('userid') != '') { ?>
                            
                            <a title="Add to Wishlist" href="javascript:void(0);" onClick="addtowishlist('<?php echo $product_details->id;?>');" class="text-uppercase text-small vertical-align-middle"><i class="fa fa-heart-o black-text"></i> Add to wishlist</a>
                            
                            <?php } else { ?>
                            
                            <a title="Add to Wishlist" data-toggle="modal" data-target="#login"  href="javascript:void(0);" class="text-uppercase text-small vertical-align-middle"><i class="fa fa-heart-o black-text"></i> Add to wishlist</a>
                            
                            <?php } */?>

							<button class="like btn btn-default" onClick="addtowishlist('<?php echo $product_details->id;?>');" type="button"><span class="fa fa-heart"></span> Add to wishlist</button>	
							</div>
							
					</div>
			</div> 
</div>
	<div style="clear:both;"></div>
	<?php
        if($relatedproduct_cat)
        { ?>
    <div class="product_list_right_main">
    <h3 class="headd">Similar Products</h3>
    	<ul>
            <?php
        if($relatedproduct_cat !='')
        {
            foreach ($relatedproduct_cat as $key => $value) {
        ?>

        <li>
        <div class="lprodut_img">
          <a href="<?php echo $base_url; ?>distribute-product-detail/<?php echo $value->page_url; ?>"><img src="<?php echo $http_host;?>upload/product/<?php echo $value->product_image; ?>"></a>
        </div>
        <p class="late_pro_title"><a href="<?php echo $base_url; ?>distribute-product-detail/<?php echo $value->page_url; ?>"><?php echo $value->material_name; ?> </a></p>
        <p class="late_pro_price"><!-- <span><i class="fa fa-rupee"></i> 1400</span> --> <i class="fa fa-rupee"></i> <?php echo $value->bpcl_special_price; ?></p>
    
        <div class="late_pro_btn">
         <a href="#"><i class="fa fa-heart"></i></a><a href="#">add to cart</a>
        </div>
        </li>
        <?php } } ?>
       
        </ul>
    </div>
<?php } ?>
    </div>
<!--products-->
		
			</div>
			

		</div>	
	</div>
</section>	
<?php include('includes/footer.php');?>
<script src="<?php echo $base_url_views; ?>assets/js/magiczoomplus.js"></script>
<script>
function add_to_cart()
    {
        var product_id = <?php echo $product_details->id; ?>;            
        var qty = $('#select_qty').val();
        var min_qty = <?php echo $product_details->min_qty; ?>; 
        if(qty =='' )
        {
            alert("Please Select Quantity");
            return false;
        }
        if(qty < min_qty)
		{
			alert("You need to buy minimum "+min_qty+" quantity");
			return false;
		}
        
        <?php $packsize = $product_details->package;
        if($packsize == '' or $packsize == 0){
            $packsize = 1;
        }
        ?>
        var packsize = <?php echo $packsize; ?>; 
        var total_price = '<?php echo ($product_details->billing_price + $product_details->deliverypay + $product_details->bpclpay); ?>';

        total_price = total_price*packsize;

        var url = "<?php echo $base_url; ?>cart/addtocart";
        $.ajax({
            url:url,
            type:'post',
            data:'product_id='+product_id+'&qty='+qty+'&total_price='+total_price+'&min_qty='+min_qty,
            success:function(msg)
                {
                  //  alert(msg);
                    //console.log(msg);
                    if(msg == 'nostock')
                    {
                        $("#order_succsess1").css("display","block");
                        $("#order_succsess1").addClass("success");
                        $('#order_succsess1').show().delay(0).fadeIn('slow');
                        $('#order_succsess1').hide().delay(2000).fadeOut('slow');
                        $("#order_succsess1").html("Out Of Stock");
                        
                     }else{
                         
                        //header_cart();  
                        var msgs = 'Quote: '+msg+' item(s)';
                        $("#total_quote").html(msgs);
                            
                        var cart_url = '<?php echo $base_url; ?>distributor-cart';
                        window.location.href = cart_url;

                        $("#order_succsess").css("display","block");
                        $("#order_succsess").addClass("success");
                        $('#order_succsess').show().delay(0).fadeIn('slow');
                        $('#order_succsess').hide().delay(2000).fadeOut('slow');
                        $("#order_succsess").html("Product has been added in Cart");
                        
                        /*$("#textmessage").html('Product has been added in Cart');
                        $('#messagealert').modal();*/
                        
                         //}
                    }
                        
            }
        });
}
        
</script>

<script>
function addtowishlist(fav)
        {
            $.ajax({
            url: '<?php echo $base_url;?>home/addtowishlist',
            type: 'post',
            data: 'id='+fav,
            success:function(d)
            {   
                if(d == '1') {
                    
                    /*$("#textmessage").html("<i class='fa fa-check'></i>Product has been added to your wishlist list.");
                    $('#messagealert').modal();*/

                    $("#order_succsess").css("display","block");
                    $("#order_succsess").addClass("success");
                    $('#order_succsess').show().delay(0).fadeIn('slow');
                    $('#order_succsess').hide().delay(2000).fadeOut('slow');
                    $("#order_succsess").html("Product has been added to your wishlist list.");

                }else{
                    $("#order_succsess").css("display","block");
                    $("#order_succsess").addClass("success");
                    $('#order_succsess').show().delay(0).fadeIn('slow');
                    $('#order_succsess').hide().delay(2000).fadeOut('slow');
                    $("#order_succsess").html("Product already added in whishlist.");

                    /*$("#textmessage").html("<i class='fa fa-check'></i>Product already added in whishlist.");
                    $('#messagealert').modal();*/
                }
            }
            }); 
        }
</script>
</script>
