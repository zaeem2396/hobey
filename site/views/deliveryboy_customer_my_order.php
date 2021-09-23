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
<?php include('includes/sidebar_deliveryboy.php');?>
<div class="content-wrapper">
  <div class="content">
      
      <div class="checkout-area mb-65">
            <div class="col-md-12">
            <div id="verticalTab">
                    <?php  
                    if(count($orders_list) >0 )
                    {
                        foreach($orders_list as $order)
                        {
                    ?>
                    <div class="row mb-15">
                            <div class="col-md-12 clearfix">
                                <div class="accordion-heading font-size-14">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne">Order Number #<?php echo $order['order_id']?></a>
                                </div>
                                <div id="collapseOne" class="accordion-body collapse">
                                    <div class="padding-15">
                                      <div class="accordion-toggle">
                                          <div class="col-xs-12 col-md-6 col-md-push-6 text-xs-center text-sm-center text-right mb-15 padding-none">
                                            <!-- <p>                                             
                                              <button type="submit" class="btn grey-btn-samll">Cancel Order <i class="fa fa-times" aria-hidden="true"></i></button>
                                            </p> -->
                                          </div>
                                          <div class="col-xs-12 col-md-6 col-md-pull-6 text-xs-center text-sm-center mb-15 padding-none">
                                            <section class="font-size-18">Order Number #<?php echo $order['order_id']?></section>
                                            <section class="font-size-13">Placed on <?php $order_date = strtotime( $order['cdate'] );
                                       echo $mysqldate = date( 'l, F d, Y', $order_date );?></section>
                                          </div>

                                           <?php foreach ($order['items'] as $item) { ?>
                                          <div class="col-xs-12 text-xs-center padding-none">
                                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 mb-15 text-xs-center padding-none"> 
                                                <?php
                                                   $product_detail = $this->vendor_model->get_product($item['product_id']);
                                                    //print_r($product_detail);
                                                if($item['base_image'] !=''){ ?>
                                                <img src="<?php echo $http_host; ?>upload/product/<?php echo $item['base_image']; ?>">
                                                <?php } else { ?>
                                                <img src="<?php echo $base_url_views; ?>images/noimage.jpg"  >
                                                <?php }  ?>
                                                <!-- <img src="http://fiveonlineclient.in/bpcl/html/images/1_270x.jpg" alt=""> -->
                                                 </div>
                                            <div class="col-lg-6 col-md-6 col-sm-9 col-xs-12">
                                              <section class="font-size-18"><?php echo $item['order_item_name']; ?></section>
                                              <section class=""><?php echo $item['material'];?></section>
                                              <section class="">Quantity - <?php echo $item['product_quantity'];?></section>
                                              <section class="font-size-18"><i class="fa fa-inr"></i> <?php echo number_format($item['product_item_price']);?></section>
                                            </div>
                                            <div class="col-sm-3 visible-sm"></div>
                                            <div class="col-lg-4 col-md-4 col-sm-9 col-xs-12 " style="display: block;">
                                            <section class="font-size-18 "> <b>Payment Mode : </b>
                                                    <?php 
                                                    if($order['paymentmode'] == '1' )
                                                    {
                                                        echo "Cash";
                                                    }
                                                    else if($order['paymentmode'] == '2' )
                                                    {
                                                         echo "Online";
                                                    }
                                                    ?>
                                                </section>
                                                <section class="font-size-18 "> <b>Order Status : </b>
                                                    <?php 
                                                    if($item['order_status'] == 'P' )
                                                    {
                                                        echo "pending";
                                                    }
                                                    else if($item['order_status'] == 'S' )
                                                    {
                                                         echo "Shipped";
                                                    }
                                                    else if($item['order_status'] == 'D' )
                                                    {
                                                         echo "Delivered";
                                                    }
                                                    ?>
                                                    
                                                </section>
                                                <?php if($item['order_status'] != 'D') { ?>
                                                <section class="font-size-18 ">order Status</section>
                                                <select name="status" id="change_status_<?php echo $item['order_id']; ?>" onchange="change_order_status(this.value,<?php echo $item['order_item_id']; ?>,<?php echo $item['order_id']; ?>,'<?php echo $item['order_status']; ?>');">
                                                    <option value="P" <?php if($item['order_status'] == 'P') { echo "Selected";  } ?>>Pending</option>
                                                    <option value="S" <?php if($item['order_status'] == 'S') { echo "Selected";  } ?>>Shipped</option>
                                                    <option value="D" <?php if($item['order_status'] == 'D') { echo "Selected";  } ?>>Delivered</option>
                                                </select>
                                                <?php } ?>

                                              <section class="font-size-18 ">Delivered To</section>
                                              <section class=""><?php echo $order['first_name'];?> <?php echo $order['last_name'];?></section>
                                              <section> <?php echo $order['address1'];?> , <?php echo $order['address2'];?> , <?php echo $order['city'];?> , <?php echo $order['state'];?> , <?php echo $order['post_code'];?> </section>
                                            </div>
                                          </div>

                                      <?php } ?>

                                          <div class="col-xs-12 padding-10 text-center bg-red font-size-20 mb-30"> <i class="fa fa-minus" aria-hidden="true"></i> Total <i class="fa fa-inr"></i> <?php echo number_format($order['order_total']);?> <i class="fa fa-minus" aria-hidden="true"></i> </div>
                                      </div>
                                    </div>
                                </div>                          
                            </div>
                        </div>
                    <?php } } else { echo "Order Not found"; } ?>
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
    function change_order_status(status,order_item_id,orderid,oldVlaue)
    {
        var box = document.getElementById('change_status_'+orderid);
        var conf = confirm("Are you sure want to change Status ?");
        if(conf==true){
        var base_url = '<?php echo $base_url.'home/changeStatusmail'; ?>';
                window.location = base_url+"/"+status+"/"+order_item_id+"/"+orderid;
        return true;
        }else{
            box.value = oldVlaue;
            return false;
        }
    }

</script>