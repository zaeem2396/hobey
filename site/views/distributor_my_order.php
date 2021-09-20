<?php

$front_base_url = $this->config->item('front_base_url');

$base_url         = $this->config->item('base_url');

$index_url         = $this->config->item('index_url');

$findex_url         = $this->config->item('findex_url');

$base_url_views = $this->config->item('base_url_views');

$http_host = $this->config->item('http_host');

?>

<!doctype html>

<style>
    .common {

        width: 100%;

        max-width: 200px;

        padding-top: 10px;

    }

    .overlay_search .closebtn {

        position: absolute;

        top: 5px;

        right: 10px;

        font-size: 40px;

        cursor: pointer;

        color: #c26573;

    }

    .overlay_search input[type=text] {

        padding: 0 10px;

        font-size: 15px;

        border: none;

        width: 100%;

        background: #cedde0;

        height: 41px;

    }

    .overlay-content {

        width: 1170px;

        margin: 0 auto;

        position: relative;

    }

    .overlay_search {

        width: 100%;

        position: absolute;

        display: none;

        z-index: 99999999999999;

        top: 80px;

        left: 0;

        background-color: #cedde0;

    }

    .successmain {

        background-color: #008000;

        border-color: #008000;

    }

    .valierror {

        background-color: #ee2e34;

        border-color: #ee2e34;

        color: #fff;

    }

    .topalert {
        z-index: 9999;
        text-align: center;
        padding: 10px;
        font-size: 18px;
        color: #fff;
        position: fixed;
        top: 0px;
    }

    .alert-message {

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

        display: block;

        margin-bottom: 10px;

        z-index: 999999999999;

    }

    .top-nav-collapse {

        height: 0;

    }
</style>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Bharat Petroleum |Oil & Gas Companies in India |Top Petroleum Companies | Petroleum Distribution companies</title>

    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">

    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo $base_url_views; ?>assets/css/login.css">

    <link rel="stylesheet" href="<?php echo $base_url_views; ?>assets/css/style.css">



    <style>
        .collapse:not(.show) {

            display: block;

        }
    </style>

</head>

<body>


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

        .bg-red {
            background: #fdbb28;
            color: #fff;
        }

        .product_list_right_main ul li {
            background: #ccc;
            padding: 50px 10px;
        }

        .product_list_right_main ul a li h2 {
            color: #000;
        }
    </style>
    <section class=" login-reg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php include('includes/sidebar_distributor.php'); ?>
                    <div class="content-wrapper">
                        <form action="<?php echo $base_url . "home/download_distiorder"; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $this->session->userdata('userid'); ?>" id="distributor_id1" name="distributor_id">
                            <input class="btn btn-alert pull-right " type="submit" value="Download Report">
                        </form>
                        <div class="content">

                            <div class="checkout-area mb-65">
                                <div class="col-md-12">
                                    <div id="verticalTab">
                                        <?php
                                        //echo "<pre>";print_r($orders_list);echo "</pre>";
                                        if (count($orders_list) > 0) {
                                            foreach ($orders_list as $order) {
                                                ?>
                                                <div class="row mb-15">
                                                    <div class="col-md-12 clearfix">
                                                        <div class="accordion-heading font-size-14">
                                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne">Order Number #<?php echo $order['order_id'] ?></a>
                                                        </div>
                                                        <div id="collapseOne" class="accordion-body collapse">
                                                            <div class="padding-15">
                                                                <div class="accordion-toggle">
                                                                    <button type="button" onclick="createinvoice(<?php echo $order['order_id'] ?>);" data-toggle="modal" data-target="#invoce_modal" class="btn btn-default-red" style="float:right;padding: 6px 20px;">Invoice</button>
                                                                    <div class="col-xs-12 col-md-6 col-md-push-6 text-xs-center text-sm-center text-right mb-15 padding-none">
                                                                        <!-- <p>                                             
                                              <button type="submit" class="btn grey-btn-samll">Cancel Order <i class="fa fa-times" aria-hidden="true"></i></button>
                                            </p> -->
                                                                    </div>
                                                                    <div class="col-xs-12 col-md-6 col-md-pull-6 text-xs-center text-sm-center mb-15 padding-none">
                                                                        <section class="font-size-18">Order Number #<?php echo $order['order_id'] ?></section>
                                                                        <section class="font-size-13">Placed on <?php $order_date = strtotime($order['cdate']);
                                                                                                                        echo $mysqldate = date('l, F d, Y', $order_date); ?></section>
                                                                    </div>

                                                                    <?php foreach ($order['items'] as $item) { ?>
                                                                        <div class="col-xs-12 text-xs-center padding-none">
                                                                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 mb-15 text-xs-center padding-none">
                                                                                <?php
                                                                                            $product_detail = $this->vendor_model->get_product($item['product_id']);
                                                                                            $package_size = $this->vendor_model->getPackageSize($item['product_id']);
                                                                                            //print_r($product_detail);
                                                                                            if ($item['base_image'] != '') { ?>
                                                                                    <img src="<?php echo $http_host; ?>upload/product/<?php echo $item['base_image']; ?>">
                                                                                <?php } else { ?>
                                                                                    <img src="<?php echo $base_url_views; ?>images/noimage.jpg">
                                                                                <?php }  ?>
                                                                                <!-- <img src="http://fiveonlineclient.in/bpcl/html/images/1_270x.jpg" alt=""> -->
                                                                            </div>
                                                                            <div class="col-lg-6 col-md-6 col-sm-9 col-xs-12">
                                                                                <section class="font-size-18"><?php echo $item['order_item_name']; ?></section>
                                                                                <section class=""><?php echo $item['material']; ?></section>
                                                                                <section class="">Quantity - <?php echo $item['product_quantity']; ?></section>
                                                                                <?php $packsize1 = $package_size;
                                                                                            if ($packsize1 == '' or $packsize1 == 0) {
                                                                                                $packsize1 = 1;
                                                                                            }
                                                                                            ?>
                                                                                <section class="">Pack Size - <?php echo $packsize1; ?></section>
                                                                                <section class="">Item Price - <?php echo $item['product_item_price'] / $packsize1; ?></section>
                                                                                <?php $totalOrder = $item['product_item_price'] * $item['product_quantity']; ?>
                                                                                <section class="font-size-18">Total - <i class="fa fa-inr"></i> <?php echo number_format($totalOrder); ?></section>
                                                                            </div>
                                                                            <div class="col-sm-3 visible-sm"></div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-9 col-xs-12 " style="display: block;">
                                                                                <section class="font-size-18 "> <b>Payment Mode : </b>
                                                                                    <?php
                                                                                                if ($order['paymentmode'] == '1') {
                                                                                                    echo "Cash";
                                                                                                } else if ($order['paymentmode'] == '2') {
                                                                                                    echo "Online";
                                                                                                }
                                                                                                ?>
                                                                                </section>
                                                                                <section class="font-size-18 "> <b>Order Status : </b>
                                                                                    <?php
                                                                                                if ($order['order_status'] == 'P') {
                                                                                                    echo "pending";
                                                                                                } else if ($order['order_status'] == 'S') {
                                                                                                    echo "Shipped";
                                                                                                } else if ($order['order_status'] == 'D') {
                                                                                                    echo "Delivered";
                                                                                                } else if ($order['order_status'] == 'R') {
                                                                                                    echo "Received";
                                                                                                }
                                                                                                ?>

                                                                                </section>
                                                                                <?php if ($item['order_status'] == 'D') { ?>

                                                                                    <button type="button" onclick="change_order_status('R',<?php echo $item['order_item_id']; ?>,<?php echo $item['order_id']; ?>);" class="btn btn-default" style="padding: 0 10px 3px;color: white;background: #0067AC;">Mark as Received</button>

                                                                                <?php } ?>
                                                                                <section class="font-size-18 ">Delivered To</section>
                                                                                <section class=""><?php echo $order['first_name']; ?> <?php echo $order['last_name']; ?></section>
                                                                                <section> <?php echo $order['address1']; ?> , <?php echo $order['address2']; ?> , <?php echo $order['city']; ?> , <?php echo $order['state']; ?> , <?php echo $order['post_code']; ?> </section>
                                                                            </div>
                                                                        </div>

                                                                    <?php } ?>

                                                                    <div class="col-xs-12 padding-10 text-center bg-red font-size-20 mb-30"> <i class="fa fa-minus" aria-hidden="true"></i> Total <i class="fa fa-inr"></i> <?php echo number_format($order['order_total']); ?> <i class="fa fa-minus" aria-hidden="true"></i> </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php }
                                        } else {
                                            echo "Order Not found";
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

    <?php include('includes/footer.php'); ?>
    <script>
        function change_order_status(status, order_item_id, orderid) {
            var conf = confirm("Are you sure want to mark as receivede ?");
            if (conf == true) {
                var base_url = '<?php echo $base_url . 'home/changereceived'; ?>';
                window.location = base_url + "/" + status + "/" + order_item_id + "/" + orderid;
            } else {
                return false;
            }
        }
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.js'></script>
    <div class="modal fade" id="create_label_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" id="create_label_html">

            </div>
        </div>
    </div>
    <script>
        function createinvoice(id) {
            var itemid = id;
            var url = '<?php echo $base_url; ?>account/createinvoice';
            jQuery.ajax({
                url: url,
                type: 'post',
                data: 'itemid=' + itemid,
                success: function(msg) {
                    $('#create_label_html').html(msg);
                    $('#create_label_modal').modal('show');
                }
            });
        }
    </script>