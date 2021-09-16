<?php include('includes/header.php');?>
<div class="topalert successmain alert-message" id="order_succsess" style="display:none;"></div> 
<div class="topalert valierror alert-message" id="order_succsess1" style="display:none;"></div> 

<style>
* {
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	box-sizing:border-box;
}

*:before, *:after {
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
}
a {
	color: tomato;
	text-decoration: none;
}

a:hover {
	color: #2196f3;
}

pre {
display: block;
padding: 9.5px;
margin: 0 0 10px;
font-size: 13px;
line-height: 1.42857143;
color: #333;
word-break: break-all;
word-wrap: break-word;
background-color: #F5F5F5;
border: 1px solid #CCC;
border-radius: 4px;
}

/* Rating Star Widgets Style */
.rating-stars ul {
	list-style-type:none;
	padding:0;
	
	-moz-user-select:none;
	-webkit-user-select:none;
}
.rating-stars ul > li.star {
	display:inline-block;
	
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
	font-size:2.5em; /* Change the size of the stars */
	color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
	color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
	color:#FF912C;
}
.outOfStock {
    text-align: left;
    width: 100%;
    display: inline-block;
    font-size: 20px;
    color: red;
    font-weight: bold;
    cursor: auto;
}
</style>
<div class="topalert successmain alert-message" id="order_succsess" style="display:none;"></div>
<!--navBar content End-->
<!--Product detail-->
<?php //echo "<pre>";print_r($product_details);echo "</pre>"; ?>
<div class="container">
	
		<div class="row mb-100 pdd50">
				
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
					 <li class="breadcrumb-item"><a href="<?php echo $base_url; ?>"><i class="fa fa-home" aria-hidden="true"></i></a></li>
					<li class="breadcrumb-item"><?php echo $product_details->material_name; ?></li>
					<li class="breadcrumb-item active" aria-current="page">Details</li>
					</ol>
				</nav>
			<div class="col-sm-6">
		<?php $get_product_image = $this->home_model->get_product_image($product_details->id); ?>
			<div class="app-figure" id="zoom-fig">
				<a id="Zoom-1" class="MagicZoom"  data-options="zoomPosition: inner" href="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>"> <img src="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>" alt=""/> </a>

						<div class="selectors text-center">
					<!--  <a data-zoom-id="Zoom-1"href="images/product1.jpg" data-image="<?php echo $base_url_views; ?>customer/images/product1.jpg">
								<img srcset="<?php echo $base_url_views; ?>customer/images/product-small.jpg" src="images/product1.jpg"/>
						</a> -->
					
					<?php  
						if($get_product_image !='')
						{
								foreach($get_product_image as $product_image)
								{
						?>
					 <a data-zoom-id="Zoom-1" href="<?php echo $http_host;?>upload/product/medium/<?php echo $product_image->image; ?>" data-image="<?php echo $http_host;?>upload/product/medium/<?php echo $product_image->image; ?>">
								<img srcset="<?php echo $http_host;?>upload/product/small/<?php echo $product_image->image; ?>" src="<?php echo $http_host;?>upload/product/small/<?php echo $product_image->image; ?>"/>
						</a>          
				<?php } } ?>

				<a data-zoom-id="Zoom-1"href="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>" data-image="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>"><img srcset="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>" src="<?php echo $http_host;?>upload/product/<?php echo $product_details->product_image; ?>" style="width: 70px;"  /> </a>
		
			</div>
			
			
		</div>
				</div>
			<div class="col-sm-6">
					<div class="product-description">
			
							<p class="product-title"><?php echo $product_details->material_name; ?></p>
								<p><span> SKU: <?php echo $product_details->material_code; ?>  </span></p>
								<?php $average_rating =  $this->home_model->avgrating($product_details->id); ?>
								<div class="rating">
									<p>
										<?php for($i=1;$i<=5;$i++) { ?>
												<i class="fa fa-star <?php if($i <= round($average_rating)) { ?> rated <?php } ?>"></i>
										<?php } ?>
										<!-- <i class="fa fa-star rated"></i> 
										<i class="fa fa-star rated"></i> 
										<i class="fa fa-star"></i> 
										<i class="fa fa-star "></i> --> 

										<a href="#review"><span class="count-review">(  <span>Reviews</span> )</span></a>
										</p>
								</div>
							 
								<p><span class="product-price">
										<?php if($product_details->mrp !='') { ?><span><strike><i class="fa fa-rupee"></i> <?php echo $product_details->mrp; ?></span> <?php } ?> </strike> &nbsp;<i class="fa fa-rupee"></i> <?php echo $product_details->bpcl_special_price; ?></span></p>
								 <p> <?php echo $product_details->product_description; ?></p>
					
								
								<div class="product-size-section">
									<div class="clearfix">
					 
																<div class="product-details-accordion mb-15">
									<div class="left-filter">
											<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
													<div class="panel panel-default">
														<div class="panel-heading" role="tab" id="headingOne">
															<h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> <i class="more-less fa fa-plus"></i> Product Details </a> </h4>
														</div>
														<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
															<div class="panel-body">
																	<table class="table">
																		<tbody>
																			<!-- tr>
																				<td>Weight</td>
																				<td>1 Kg</td>
																			</tr -->
																			<tr>
																				<td>Material Type </td>
																				<td>  <?php $cate_detaisl = $this->home_model->get_category($product_details->material_type);  echo $cate_detaisl->name;
																				?> </td>
																			</tr>
																 
																		</tbody>
																	</table>
															</div>
														</div>
													</div>
												</div>
									</div>
								</div>
			</div>
						 
							 
								<div class="save-add-btn clearfix mb-30">
		<div class="mb-30 quantity">
									Quantity: 
									<select name="select_qty" id="select_qty">
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>
								</div>
								<?php 
								$sold_qty = $this->cart_model->productDistributorQty($product_details->id,$distributor_id);	
								$sold_qty_new = $this->cart_model->productCustomreDistributorQty($product_details->id,$distributor_id);	
								if($sold_qty == $sold_qty_new) {
									echo '<span class="outOfStock">Out of stock</span>';
								}	
								?>
								<?php if($this->session->userdata('userid') != '') { ?>
									<p class="pull-left save-btn"><a href="javascript:void(0);" onClick="addtowishlist('<?php echo $product_details->id;?>');">
									     <i class="fa fa-heart" aria-hidden="true"></i> Wishlist </a></p>
								<?php } else { ?>
										<p class="pull-left save-btn"><a class="login" href="#login-form"> <i class="fa fa-heart" aria-hidden="true"></i> Wishlist </a></p>
								<?php } ?>
									<p class="pull-left addToBag"><a href="javascript:void(0);" onclick="add_to_cart();">Add To Cart <i class="fa fa-shopping-cart" aria-hidden="true"></i> </a></p>
									
								
								</div>
								<div class="detail-social-links">
									<a href="#/" class="facebook social"><i class="fa fa-facebook" aria-hidden="true"></i></a>
										<a href="#/" class="twitter social"><i class="fa fa-twitter" aria-hidden="true"></i></a>
										<a href="#/" class="instagram social"><i class="fa fa-instagram" aria-hidden="true"></i></a>
								</div>
						</div>
				</div>
		</div>
		
 </div>
				<?php
				if($relatedproduct_cat !='')
				{ ?>
		<div class="row mb-50">
			<div class="col-md-12">
					<div class="similar-products-title"><span>Similar Products</span></div>
				</div>
		</div>
				<div class="product-images mb-30">    
						<div class="owl-carousel owl-theme">
									 <?php
				if($relatedproduct_cat !='')
				{
						foreach ($relatedproduct_cat as $key => $value) {
				?>

						<div class="item">
								<div class="mb-15 text-xs-left position-relative">
										<a href="#" class="wishlist-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
										<a href="<?php echo $base_url; ?>distribute-product-detail/<?php echo $value->page_url; ?>" class="listing-block">
												<div class="bg-color"><img src="<?php echo $http_host;?>upload/product/<?php echo $value->product_image; ?>" alt="" /></div>
												<div class="clearfix">
														<div class="rating-wrap">
																<a href="#"><i class="fa fa-star" aria-hidden="true"></i></a>
																<a href="#"><i class="fa fa-star" aria-hidden="true"></i></a>
																<a href="#"><i class="fa fa-star" aria-hidden="true"></i></a>
																<a href="#"><i class="fa fa-star-half-o" aria-hidden="true"></i></a>
																<a href="#"><i class="fa fa-star-o" aria-hidden="true"></i></a>
														</div>
														<div class="newTag-wrap">New</div>
												</div>                    
												<p><?php echo $value->material_name; ?></p>
												<p class="price"> <?php if($value->mrp !='') { ?><span> <strike> <i class="fa fa-rupee"></i> <?php echo $value->mrp; ?> </strike> </span> <?php } ?> &nbsp; <i class="fa fa-rupee"></i>  <?php echo $value->bpcl_special_price; ?> </p>                 
										</a>
								</div>
						</div>
						<?php } } ?>
				</div>      
			 </div>
	 <?php } ?>
</div>
<!--Product detail End-->
<div class="container mb-100">
	<div class="row">
			<div class="col-md-6" id="review">
					<h4>Customer Reviews </h4>
						<?php  $totalreviews = $this->home_model->totalreviews($product_details->id);
						if($totalreviews !='') {
								foreach($totalreviews as $reviews)
								{
						 ?>
						<div class="mb-10 cus-review">
							<div class="row">
										<div class="col-md-12">
												<p class="customer-name"><?php echo $reviews->name; ?> </p>
										</div>
		
										<div class="col-md-12">
												<p>
														<span class="rating">
																<?php for($i=1;$i<=5;$i++){ ?>
																<i class="fa fa-star <?php if($i <= $reviews->rating) { ?> rated <?php } ?> "></i> 
														<?php } ?>
															 <!--  <i class="fa fa-star rated"></i> 
																<i class="fa fa-star rated"></i> 
																<i class="fa fa-star"></i> 
																<i class="fa fa-star "></i> -->
														</span> &nbsp;
														<span class="font-size-12">  <?php echo date('d M Y',strtotime($reviews->added_date)); ?> </span>
												</p>
										</div>
										<div class="col-xs-12">
												<?php echo $reviews->description; ?>
										</div>
								</div>
						</div>
						<?php }   ?>
					 
					
				<?php } else { echo "no reivew found"; } ?>
				</div>
			<div class="col-md-6">
			   <h4 class="" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Write a Product Review </h4>

			<div class="collapse multi-collapse" id="multiCollapseExample1">
		<div class="row personal-details">
				<form action="<?php echo $base_url; ?>home/add_review" id="review_form1" name="review_form1" method="post">
				<span id="contact_error" class="error alert-message valierror " style="display:none;"></span>
			<div class="col-md-12">
				<div class="form-group input-group"> <span class="input-group-addon"><i class="fa fa-user"></i></span>
					<input placeholder="Full Name" id="review_name" name="review_name" class="form-control" value="<?php echo $this->session->userdata('name'); ?>" type="text">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group input-group"> <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
					<input placeholder="Email ID" class="form-control" id="review_email" name="review_email" type="text" value="<?php echo $this->session->userdata('email'); ?>">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group input-group"> <span class="input-group-addon"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span>
					<input placeholder="Review Title" class="form-control" type="text" id="review_title" name="review_title" value="">
				</div>
			</div>
		
			<div class="col-md-12">
				<div class="form-group input-group"> <span class="input-group-addon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
					<textarea rows="4" type="text" name="review_description" class="form-control" id="review_description"  placeholder="Write Review"></textarea>
				</div>
			</div>
		
			<div class="col-md-12">
		
		<div class="rating">
			<p>
				<span class="count-review"> <span>Your Rating :</span></span>

				 <input type="hidden" name="product_id" id="product_id" class="rating-value" value="<?php echo $product_details->id; ?>">
				 <input type="hidden" name="user_info_id" id="user_info_id" class="rating-value" value="<?php echo $product_details->user_info_id; ?>">
				 <input type="hidden" name="product_url" id="product_url" class="rating-value" value="<?php echo $product_details->page_url; ?>">

<div class='rating-stars text-center' style="font-size: 10px;margin-top: -35px;">
		<ul id='stars'>
			<li class='star' title='Poor' data-value='1'>
				<i class='fa fa-star fa-fw'></i>
			</li>
			<li class='star' title='Fair' data-value='2'>
				<i class='fa fa-star fa-fw'></i>
			</li>
			<li class='star' title='Good' data-value='3'>
				<i class='fa fa-star fa-fw'></i>
			</li>
			<li class='star' title='Excellent' data-value='4'>
				<i class='fa fa-star fa-fw'></i>
			</li>
			<li class='star' title='WOW!!!' data-value='5'>
				<i class='fa fa-star fa-fw'></i>
			</li>
		</ul>
	</div>
 <input type="hidden" name="rating_value" id="rating_value" class="rating-value" value="1">
</p>
		</div>
		<div class="col-md-12" style="margin-top:30px;">
				<button type="button" onclick="javascript:review_validation();" class="btn btn-default-red">Submit Review <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
			</div>
	</form>
			
		</div>

				</div>
				</div>

		</div>
	
		</div></div></div>
</div>

<?php include('includes/footer.php');?>
<script src="<?php echo $base_url_views; ?>customer/js/magiczoomplus.js"></script>
<script>
function toggleIcon(e) {
		$(e.target)
				.prev('.panel-heading')
				.find(".more-less")
				.toggleClass('fa fa-plus fa fa-minus');
}
$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);
$('.owl-carousel').owlCarousel({
		loop:true,
		margin:15,
		nav:true,
		dots:false,
		navText: ["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"],
		responsive:{
				0:{
						items:1
				},
				600:{
						items:4
				},
				1000:{
						items:4
				}
		}
})
		
</script>
<!-- xzoom plugin here -->
<script type="text/javascript" src="<?php echo $base_url_views; ?>customer/js/xzoom.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url_views; ?>customer/js/magnific-popup.js"></script>
<script src="<?php echo $base_url_views; ?>customer/js/foundation.min.js"></script>
<script src="<?php echo $base_url_views; ?>customer/js/setup.js"></script> 
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
				// if(qty < min_qty)
				// {
				// 		alert("You need to buy minimum "+min_qty+" quantity");
				// 		return false;
				// }
				
				
				var distributor_id = '<?php echo $distributor_id; ?>';
				var total_price = '<?php echo $product_details->bpcl_special_price; ?>';
				var url = "<?php echo $base_url; ?>cart/customer_addtocart";
				$.ajax({
						url:url,
						type:'post',
						data:'product_id='+product_id+'&qty='+qty+'&total_price='+total_price+'&distributor_id='+distributor_id,
						success:function(msg)
								{
										//console.log(msg);
										//return false;
										//alert(msg);
										if(msg == 'nostock')
										{
												$("#order_succsess1").css("display","block");
												$("#order_succsess1").addClass("success");
												$('#order_succsess1').show().delay(0).fadeIn('slow');
												$('#order_succsess1').hide().delay(2000).fadeOut('slow');
												$("#order_succsess1").html("Out Of Stock");
												
										 }else{
												var msgs = 'Quote: '+msg+' item(s)';
												$("#total_quote").html(msgs);
												var cart_url = '<?php echo $base_url; ?>customer-cart';
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
								}
						}
						}); 
				}

function review_validation(){ 
		
				var review_name = jQuery("#review_name").val();
				if(review_name == ''){
						jQuery('#contact_error').html("Please enter Name");     
						jQuery('#contact_error').show().delay(0).fadeIn('show');
						jQuery('#contact_error').show().delay(2000).fadeOut('show');
						return false;
				}
				
				var con_email = jQuery("#review_email").val();
				if(con_email == ''){
								jQuery('#contact_error').html("Please enter Email Id");     
								jQuery('#contact_error').show().delay(0).fadeIn('show');
								jQuery('#contact_error').show().delay(2000).fadeOut('show');
								return false;
				}
		
				var em = jQuery('#review_email').val();
				var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if (!filter.test(em)) {
						jQuery('#contact_error').html("Enter Valid Email Address.");
						jQuery('#contact_error').show().delay(0).fadeIn('show');
						jQuery('#contact_error').show().delay(2000).fadeOut('show');
						return false;
				}
				
				var con_mobile = jQuery("#review_title").val();
				if(con_mobile == ''){
						jQuery('#contact_error').html("Please enter Review Title");        
						jQuery('#contact_error').show().delay(0).fadeIn('show');
						jQuery('#contact_error').show().delay(2000).fadeOut('show');
						return false;
				}
				
				
				var con_message = jQuery("#review_description").val();
				if(con_message == ''){
						jQuery('#contact_error').html("Please enter Review Description");      
						jQuery('#contact_error').show().delay(0).fadeIn('show');
						jQuery('#contact_error').show().delay(2000).fadeOut('show');
						return false;
				}
				
				jQuery("#review_form1").submit();
}
</script>
<script>
$(document).ready(function(){
	
	/* 1. Visualizing things on Hover - See next part for action on click */
	$('#stars li').on('mouseover', function(){
		var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
	 
		// Now highlight all the stars that's not after the current hovered star
		$(this).parent().children('li.star').each(function(e){
			if (e < onStar) {
				$(this).addClass('hover');
			}
			else {
				$(this).removeClass('hover');
			}
		});
		
	}).on('mouseout', function(){
		$(this).parent().children('li.star').each(function(e){
			$(this).removeClass('hover');
		});
	});
	
	
	/* 2. Action to perform on click */
	$('#stars li').on('click', function(){
		var onStar = parseInt($(this).data('value'), 10); // The star currently selected
		var stars = $(this).parent().children('li.star');
		
		for (i = 0; i < stars.length; i++) {
			$(stars[i]).removeClass('selected');
		}
		
		for (i = 0; i < onStar; i++) {
			$(stars[i]).addClass('selected');
		}
		
		// JUST RESPONSE (Not needed)
		var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
		$('#rating_value').val(ratingValue);
	});
	
	
});

</script>
<?php if ($this->session->flashdata('register_success')) { ?>
						<script>    
				jQuery(document).ready(function(){
								jQuery('#order_succsess').html("<?php echo $this->session->flashdata('register_success'); ?>");
								jQuery('#order_succsess').show().delay(0).fadeIn('show');
								jQuery('#order_succsess').show().delay(6000).fadeOut('show');
				});

				</script>
				<?php } ?>