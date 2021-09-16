<?php include('includes/header.php');?>
<style>
.content {display:block;}
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
.product_list_right_main ul li {
    background: #ccc;
    padding: 50px 10px;
    height: 180px;
    display: inline-grid;
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
    <h4> Dashboard  </h4>
						<hr>
<div class="product_list_right_main">
    	<ul>
    	<a href="<?php echo $base_url; ?>distributor-product-listing"> <li>
    	  <h2>  <i class="fa fa-product-hunt" aria-hidden="true"></i></h2>

         <p style="color:#000;"> <strong>Show Product</strong></p>
        </li></a>

        <!-- <a href="<?php echo $base_url; ?>list-product"> <li>
         <h2>Total product</h2>
        </li></a> -->
        
        <a href="<?php echo $base_url; ?>distributor-my-order">  <li>
             <h2>  <i class="fa fa-cart-plus"></i></h2>
        <p style="color:#000;"> <strong>Total Order <br/> <span style="font-size:20px;"><?php echo count($orderCount); ?></span></strong></p>
        </li></a>
        
   
        <a href="<?php echo $base_url; ?>distributor-my-order/?status=p">
          <li>
               <h2>  <i class="fa fa-cart-arrow-down"></i></h2>
           <p style="color:#000;"> <strong>Pending Order <br/>  <span style="font-size:20px;"><?php echo count($getOrdersCount); ?></span></strong></p>
        </li></a>
        
        <a href="<?php echo $base_url; ?>distributor-customer-my-order/?status=p">
          <li>
               <h2> <i class="fa fa-users" aria-hidden="true"></i></h2>
         <p style="color:#000;"> <strong>Pending customer order</strong></p>
        </li></a>
        
       
        </ul>
    </div>   
			</div>
  </div>
</div>
            </div>
         
		
	</div>
</section>
<?php include('includes/footer.php');?>