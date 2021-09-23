<?php include('includes/header.php');?>
<style>
.product_list_right_main ul li {width: 30%;}
.soort ul li { width: auto;}
.soort ul li:hover {box-shadow: 0 5px 20px rgb(0 0 0 / 0%);}
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
    <i class="fa fa-home" aria-hidden="true"></i>&nbsp; <!-- <i class="fa fa-angle-right"></i> &nbsp;Agri Gold Palmolein Oil -->


    </div>
</div>
<!--breadcrumbs-->
    <div class="soort">
         <form action="<?php echo $url_to_paging; ?>" id="search_form" name="search_form" method="GET">
    <div class="product_list_sort">
    	<ul>
        <li>Sort By : 
            <select name="sort_by" onchange="allfilter();">
            <option value="">Default</option>
            <option value="atoz" <?php if($sort_by == 'atoz'){ ?> selected='selected' <?php } ?>> Alphabetical </option>
            <option value="lowtohigh" <?php if($sort_by == 'lowtohigh'){ ?> selected='selected' <?php } ?>>Price: High to Low</option>
            <option value="hightolow" <?php if($sort_by == 'hightolow'){ ?> selected='selected' <?php } ?>>Price: Low to High</option>
        </select>
    </li>
        </ul>
    </div>
     </div>
</form>
    
    <div class="product_list_right_main">
    	<ul>
        <?php
        if($allproduct !='')
        {
            foreach ($allproduct as $key => $value) {
        ?>
        <li>
        <div class="lprodut_img">
          <a href="<?php echo $base_url; ?>distribute-product-detail/<?php echo $value->page_url; ?>"><img src="<?php echo $http_host;?>upload/product/<?php echo $value->product_image; ?>"></a>
        </div>
        <p class="late_pro_title"><a href="<?php echo $base_url; ?>distribute-product-detail/<?php echo $value->page_url; ?>"><?php echo $value->material_name; ?> </a></p>
        <p class="late_pro_price"><!-- <span><i class="fa fa-rupee"></i> 1400</span> --> 
            
            <div> MRP: <i class="fa fa-rupee"></i> <?php  echo $value->mrp; ?></div>
            <div> BPCL Special Price : <i class="fa fa-rupee"></i> <?php echo $value->bpcl_special_price; ?></div> </p>
            <div> DBP : <i class="fa fa-rupee"></i> <?php echo $value->billing_price; ?></div> </p>
        <p><div class="number">
        	<span class="minus">-</span>
        	<input type="number" id="select_qty" name="select_qty" value="1"  />
        	<span class="plus">+</span>
            </div>
        </p>
        <div class="late_pro_btn">
         <a href="javascript:void(0);" onClick="addtowishlist('<?php echo $value->id;?>');" > <i class="fa fa-heart"></i> </a> <a href="<?php echo $base_url; ?>distribute-product-detail/<?php echo $value->page_url; ?>" >add to cart</a>
        </div>
        </li>
        <?php } } ?>
        </ul>
    </div>
    </div>
		
			</div>
		</div>	
	</div>
</section>	
<?php include('includes/footer.php');?>
<script>
    $('.plus').click(function () {
       //alert($(this).prev().val());
        if ($(this).prev().val() < 3) {
        $(this).prev().val(+$(this).prev().val() + 1);
        }
});
$('.minus').click(function () {
        if ($(this).next().val() > 1) {
        if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
        }
});

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
        function allfilter(){
    document.search_form.submit();
}
</script>