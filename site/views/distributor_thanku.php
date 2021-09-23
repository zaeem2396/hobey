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
       <div class="mb-65">

            	<div class="login-main">
		        	<div class="login">
		        		<div class="cart-wrap pdd50">
			       
		    <?php if($id==0){ ?>
					  Your order has been failed. <br/> please <a href="<?php echo $this->config->item('base_url');?>distributor-checkout" >Click Here</a> to do transaction again.
					<?php }else{
						echo 'Thank you for shopping. Your order number is '.$id.'.';
					} ?> 
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