<?php include('includes/header.php');?>

<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
<link href="<?php echo $base_url_views; ?>customer/css/stylesheet.css" rel="stylesheet">
<link href="<?php echo $base_url_views; ?>customer/css/easy-responsive-tabs.css" rel="stylesheet">
<style>
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
      
      <div class="checkout-area mb-65">
        <span id="register_success" class="alert-message successmain valierror123 form-group" style="display:none;margin-bottom: 5px;"></span>
           	<div class="col-md-12">
            <div id="verticalTab">
                    
                    <div class="row mb-15">
                            <div class="col-md-12 clearfix">
                        <?php 
                        if(isset($allwishlist) && count($allwishlist) > 0 )
                        {
                        foreach ($allwishlist as $item) { ?>
                          <div class="col-xs-12 text-xs-center">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mb-15 text-xs-center padding-none"> 
                                <?php
                                $material_type = $this->home_model->get_category($item->material_type);
                                   
                                if($item->product_image !=''){ ?>
                                <img src="<?php echo $http_host; ?>upload/product/<?php echo $item->product_image; ?>">
                                <?php } else { ?>
                                <img src="<?php echo $base_url_views; ?>images/noimage.jpg"  >
                                <?php }  ?>
                                <!-- <img src="http://fiveonlineclient.in/bpcl/html/images/1_270x.jpg" alt=""> -->
                                 </div>
                              
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                              <section class="font-size-18"><?php echo $item->material_name; ?></section>
                              <section class=""><?php echo $material_type->name;?></section>
                              <section class="">
                                <div> MRP: <i class="fa fa-rupee"></i> <?php  echo $item->mrp; ?></div>
                                <div> DBP : <i class="fa fa-rupee"></i> <?php echo $item->billing_price + $item->deliverypay + $item->bpclpay; ?></div> 
                               </section>
                            </div>
                               <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><a href="<?php echo $base_url; ?>home/delete_wishlist_distributor/<?php echo $item->wish_id; ?>" class="font-size-18"><i class="fa fa-trash" aria-hidden="true"></i>
</a></div>
                          </div>
                        
                        <?php } } else { echo "No Products added to wishlist "; } ?>
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

<?php if($this->session->flashdata('register_success') !=""){ ?>
<script>    
$(document).ready(function(){
     //$('#messagealert').modal();
     $('#register_success').html("<?php echo $this->session->flashdata('register_success'); ?>");
        $('#register_success').show().delay(0).fadeIn('show');
        $('#register_success').show().delay(6000).fadeOut('show');
    
});
</script>

<?php } ?>