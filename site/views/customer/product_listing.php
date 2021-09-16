<?php include('includes/header.php');?>
<div class="topalert successmain alert-message" id="order_succsess" style="display:none;"></div>    
<!--navBar content End-->
<!--Product page-->
<div class="container">
        <div class="row mb-50 pdd50">
            <!--Right product section -->    
            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="brand-name-wrap">
                            <span class="brand-name-title"> <a href="<?php echo $base_url; ?>"><i class="fa fa-home" aria-hidden="true"></i></a></span>
                            <span class="product-total">All Products</span>
                        </div>
                    </div>
                </div>
                <form action="<?php echo $url_to_paging; ?>" id="search_form" name="search_form" method="GET">
                <div class="row mb-15">
                    <!--<div class="col-md-6 col-xs-6">
                        <div class="product-grid">Show: <a href="#" class="active">3</a> <a href="#">4</a></div>
                    </div>-->
                    <div class="col-md-12 col-xs-12 text-right">
                        <div class="sortBy">
                             Sort by:
                            <select class="selectpicker" name="sort_by" data-style="btn-info" onchange="allfilter();">
                                <option value="">Default</option>
                                <option value="atoz" <?php if($sort_by == 'atoz'){ ?> selected='selected' <?php } ?>>Alphabetical</option>
                                <option value="lowtohigh" <?php if($sort_by == 'lowtohigh'){ ?> selected='selected' <?php } ?>>Price: Low to High</option>
                                <option value="hightolow" <?php if($sort_by == 'hightolow'){ ?> selected='selected' <?php } ?>>Price: High to Low</option>
                               
                        
                            </select>
                        </div>
                    </div>
                </div>
                </form>
                <div class="product-images">                
                    <div class="row">
                        <?php
                        if(isset($allproduct) && count($allproduct) > 0)
                        {
                            foreach($allproduct as $product)
                            {
                        ?>
                        <div class="col-md-3 col-sm-4 col-xs-12 mb-15 text-xs-left position-relative">
                            <a href="<?php echo $base_url; ?>product-detail/<?php echo $product->page_url; ?>-<?php echo $product->user_info_id; ?>" class="listing-block">
                                <div class="bg-color"><img src="<?php echo $http_host;?>upload/product/<?php echo $product->product_image; ?>" alt="" /></div>
                                 <?php $average_rating =  $this->home_model->avgrating($product->id); ?>
                                <div class="clearfix">
                                    <div class="rating-wrap">
                                        <?php for($i=1;$i<=5;$i++) { ?>
                                            <!-- <i class="fa fa-star <?php if($i <= round($average_rating)) { ?> rated <?php } ?>"></i> -->

                                            <a href="#"><i <?php if($i <= round($average_rating)) { ?> class="fa fa-star" <?php } else { ?> class="fa fa-star-o"<?php  } ?> aria-hidden="true"></i></a>

                                        <?php } ?>
                                        <!-- <a href="#"><i class="fa fa-star" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-star" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-star" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-star-half-o" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-star-o" aria-hidden="true"></i></a> -->
                                    </div>
                                    <div class="newTag-wrap">New</div>
                                </div>
                                <p><?php echo $product->material_name; ?></p>
                                <p class="late_pro_price"><?php if($product->mrp !='') { ?><span><i class="fa fa-rupee"></i> <?php echo $product->mrp; ?></span><?php } ?><i class="fa fa-rupee"></i> <?php echo $product->bpcl_special_price; ?></p>
                                <!-- div class="number">
                                <span class="minus">-</span>
                                <input type="text" value="1">
                                <span class="plus">+</span>
                                        </div -->
                                <div class="late_pro_btn">
                                    <?php if($this->session->userdata('userid') == '') { ?>
                                    <a class="login" href="#login-form" ><i class="fa fa-heart"></i></a>
                                <?php } else { ?>
                                    <a href="javascript:void(0);" onClick="addtowishlist('<?php echo $product->id;?>');" ><i class="fa fa-heart"></i></a>
                                <?php } ?>
                                    <a href="<?php echo $base_url; ?>product-detail/<?php echo $product->page_url; ?>-<?php echo $product->user_info_id; ?>">View Product</a>
                                </div>
                            </a>
                        </div>
                        <?php } } else { echo "No Product Found"; } ?>

                        <?php //echo $this->pagination->create_links(); ?>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-md-12">
                            <nav aria-label="Page navigation example">
                              <ul class="pagination justify-content-center">
                                <?php if($this->pagination->create_links() !=''){ ?>
                                <!-- <li class="page-item">
                                  <a class="page-link" href="#" tabindex="-1"><?php echo $this->pagination->create_links();   ?></a>
                                </li> -->
                                <?php echo $this->pagination->create_links();   ?>
                                <?php } ?>
                                <!-- <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item">
                                  <a class="page-link" href="#">Next</a>
                                </li> -->
                              </ul>
                            </nav>                          
                        </div>
                    </div>
                    
                    
                    
                    
                    
                </div>
                
            </div>
            <!--Right product section End-->        
        </div>    
</div>
<!--Product page End-->

<?php include('includes/footer.php');?>

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
                    $("#order_succsess").html("<i class='fa fa-check'></i>Product has been added to your wishlist list.");
                    
                }else{
                    $("#order_succsess").css("display","block");
                    $("#order_succsess").addClass("success");
                    $('#order_succsess').show().delay(0).fadeIn('slow');
                    $('#order_succsess').hide().delay(2000).fadeOut('slow');
                    $("#order_succsess").html("<i class='fa fa-check'></i>Product already added in whishlist."); 
                }
            }
            }); 
        }
function allfilter(){
    document.search_form.submit();
}

</script>