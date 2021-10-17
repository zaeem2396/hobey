<?php

$front_base_url = $this->config->item('front_base_url');

$base_url         = $this->config->item('base_url');

$index_url         = $this->config->item('index_url');

$findex_url         = $this->config->item('findex_url');

$base_url_views = $this->config->item('base_url_views');

$http_host = $this->config->item('http_host');
// complete address = <?= $order['address1']; $order['address2']; $order['city']; $order['state']; $order['post_code'];

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

    /* edit modal style starts */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    /* edit modal style ends */
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
        .bg-red {
            background: #fdbb28;
            color: #fff;
        }

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
                        <div class="">
                            <div class="checkout-area mb-65">
                                <div class="col-md-12">
                                    <?php foreach ($orders_list as $order) : ?>
                                        <div id="orderSectionReload">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h5 class="float-right">
                                                        Order ID: <b><?= $order['order_id'] ?></b>, Name: <span class="text-capitalize"><?= $order['first_name']; ?> <?= $order['last_name']; ?></span>, Address: <?= $order['address1']; ?>,<?= $order['post_code']; ?>, Expected Delivery Date: <?= ($order['exp_delivery_date'] != "") ? date("d-m-Y", strtotime($order['exp_delivery_date'])) : ""; ?></h5>
                                                    <h5> Payment: <?= ($order['paymentmode'] == '1') ? "Cash" : "Online"; ?> , Status: <select name="status" id="change_status_<?php echo $order['order_id']; ?>" onchange="change_order_status(this.value,0,<?php echo $order['order_id']; ?>,'<?php echo $order['order_status']; ?>');">
                                                            <option value="P" <?php if ($order['order_status'] == 'P') {
                                                                                        echo "Selected";
                                                                                    } ?>>Pending</option>
                                                            <option value="D" <?php if ($order['order_status'] == 'D') {
                                                                                        echo "Selected";
                                                                                    } ?>>Delivered</option>
                                                        </select> , Assign deliveryboy: <select name="deliveryBoyId" id="assignDeliveryBoy" onchange="assign_delivery_boy(this.value,<?php echo $order['order_id']; ?>);">
                                                            <option value="" selected disabled>Select Delivery Boy</option>
                                                            <?php
                                                                foreach ($allDeliveryBoys as $deliveryBoy) { ?>
                                                                <option value="<?php echo $deliveryBoy->id; ?>" <?php if ($order['deliveryBoyId'] == $deliveryBoy->id) {
                                                                                                                            echo "Selected";
                                                                                                                        } ?>><?php echo $deliveryBoy->name; ?></option>
                                                            <?php }  ?>
                                                        </select>
                                                    </h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <?php if ($order['order_status'] != 'D') : ?>
                                                        <button onclick="deleteCompleteOrder(this)" data-orderId="<?= $order['order_id'] ?>" class="btn btn-xl btn-danger">Delete Entire Order <i class="fa fa-trash"></i></button> | <a class="btn btn-xl btn-primary" href="edit-order/<?= $order['order_id'] ?>">Edit Order</a>
                                                    <?php else : ?>
                                                        <button class="btn btn-xl btn-danger" disabled>Delete Entire Order <i class="fa fa-trash"></i></button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <table class="table table-bordered" id="orderList">
                                                <tr style="background-color: #c5c5c5;">
                                                    <!-- <th>#</th> -->
                                                    <th>Items</th>
                                                    <th style="width: 7%;">Quantity</th>
                                                    <th style="width: 7%;">Price</th>
                                                    <th style="width: 6%;">Total</th>
                                                    <th style="width: 8%;">Delete Item</th>
                                                    <th>Invoice</th>
                                                </tr>
                                                <tr>
                                                    <!-- <td><?= $i++; ?></td> -->
                                                    <td>
                                                        <?php for ($i = 0; $i < count($order['items']); $i++) {
                                                                $item = $order['items'][$i];
                                                                $qty = $item['product_quantity'];
                                                                $singleProdPrice = number_format($item['product_item_price'] / ($qty < 1 ? 1 : $qty)); ?>
                                                            <p><?= $item['order_item_name']; ?></p>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php foreach ($order['items'] as $qty) : ?>
                                                            <p><?= $qty['product_quantity'] ?></p>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td>
                                                        <?php foreach ($order['items'] as $price) : ?>
                                                            <p><i class="fa fa-inr"></i><?= number_format($price['product_item_price']); ?></p>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td>
                                                        <i class="fa fa-inr"></i><?= number_format($order['order_total']); ?>
                                                    </td>
                                                    <td>
                                                        <?php foreach ($order['items'] as $item) :  if ($order['order_status'] != 'D') : ?>
                                                                <p>
                                                                    <button onclick="deleteOrder(this)" data-price="<?= $item['product_item_price'] ?>" data-orderItemId="<?= $item['order_item_id'] ?>" data-orderId="<?= $item['order_id'] ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="<?= $item['order_item_name']; ?>"><i class="fa fa-trash"></i></button>
                                                                </p>
                                                            <?php else : ?>
                                                                <p>
                                                                    <button class="btn btn-xs btn-danger" disabled><i class="fa fa-trash"></i></button>
                                                                </p>
                                                        <?php endif;
                                                            endforeach;  ?>
                                                    </td>
                                                    <td style="width: 5%;">
                                                        <?php
                                                            if ($order['is_customer'] == 2) { ?>
                                                            <button type="button" onclick="createinvoice1(<?php echo $order['order_id'] ?>);" data-toggle="modal" data-target="#invoce_modal" class="btn btn-xs btn-default-red" style="float:right;padding: 6px 20px;"><i class="fa fa-file-pdf-o" style="font-size: large;" aria-hidden="true"></i></button>
                                                        <?php } else { ?>
                                                            <button type="button" onclick="createinvoice(<?php echo $order['order_id'] ?>);" data-toggle="modal" data-target="#invoce_modal" class="btn btn-lg btn-default-red" style="float:right;padding: 6px 20px;font-size: large;">Invoice</button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- edit modal -->

        <!-- edit modal ends -->
    </section>

    <?php include('includes/footer.php'); ?>

    <script>
        // edit modal script start

        // edit modal script ends
        const deleteOrder = (e) => {
            let order_item_id = e.getAttribute("data-orderItemId")
            let order_id = e.getAttribute("data-orderId")
            let product_item_price = e.getAttribute("data-price")
            let url = '<?php echo $base_url; ?>'
            if (confirm("Are you sure ?")) {
                $.ajax({
                    url: `${url}/home/deleteOrder`,
                    type: 'POST',
                    data: {
                        order_item_id: order_item_id,
                        order_id: order_id, //for updating total
                        product_item_price: product_item_price //for price update
                    },
                    success: function(response) {
                        // return console.log(response);
                        let data = JSON.parse(response)
                        if (data.status === 200) {
                            // $(`#order-item-id-${order_item_id}`).remove()
                            $("#orderSectionReload").load(location.href + " #orderSectionReload");
                        }
                    }
                })
            }
        }

        // edit single order
        const editSingleOrder = (e) => {
            let singleOrderId = e.getAttribute("data-editOrderId");
            let i = e.getAttribute('data-i')
            // return console.log(document.getElementById(`displayButton-${singleOrderId}`));
            document.getElementById(`quantityVal-${singleOrderId}-${i}`).readOnly = false;
            // document.getElementById(`displayButton-${singleOrderId}`).style.display = "block";
            document.getElementById(`changeButtonContent-${singleOrderId}-${i}`).innerHTML = `<button data-editOrderId="${singleOrderId}-${i}" class="btn btn-sm btn-danger" onclick="cancelEditOrder(this)"><i class="fa fa-times"></i></button>`
        }

        // cancel single order edit
        const cancelEditOrder = (e) => {
            let singleOrderId = e.getAttribute("data-editOrderId");
            document.getElementById(`quantityVal-${singleOrderId}`).readOnly = true;
            // return console.log(document.getElementById(`displayButton-${singleOrderId}`));
            // document.getElementById(`displayButton-${singleOrderId}`).style.display = "none";
            document.getElementById(`changeButtonContent-${singleOrderId}-${i}`).innerHTML = `<button data-editOrderId="${singleOrderId}-${i}" class="btn btn-sm btn-primary" onclick="editSingleOrder(this)"><i class="fa fa-pencil"></i></button>`
        }

        // submit edit order
        const submitOrder = (e) => {
            let orderId = e.getAttribute("data-orderId")
            let orderList = document.getElementsByClassName(`allOrderList-${orderId}`)
            let orderItemId = e.getAttribute("data-editOrderId")
            let url = '<?= $base_url ?>'

            let data = []
            for (let i = 0; i < orderList.length; i++) {
                const e = orderList[i];
                const qty = e.getAttribute("data-qty");
                const q = parseInt(document.getElementById(`quantityVal-${orderId}-${i}`).value);
                if (!q || q < 1) {
                    alert('Quantity should be greater than 0');
                    return;
                }
                data.push({
                    prodPrice: parseFloat(e.getAttribute("data-price")) / parseFloat(qty),
                    prodQty: qty,
                    orderItemId: e.getAttribute("data-editOrderId"),
                    orderId: e.getAttribute("data-orderId"),
                    qtyValue: q
                })
            }

            if (confirm("Are you sure you want to change the quantity ?")) {
                // return console.log(data);
                $.ajax({
                    url: `${url}/home/editOrder`,
                    type: 'POST',
                    data: {
                        data: JSON.stringify(data)
                    },
                    success: function(response) {
                        // console.log(response);
                        $("#orderSectionReload").load(location.href + " #orderSectionReload");
                    }
                })
            }
        }

        // delete complete order
        const deleteCompleteOrder = (e) => {
            let orderId = e.getAttribute("data-orderId")
            let url = '<?= $base_url ?>'
            if (confirm("This will delete the entire order, are you sure you want to proceed ?")) {
                $.ajax({
                    url: `${url}/home/deleteCompleteOrder`,
                    type: 'POST',
                    data: {
                        orderId: orderId
                    },
                    success: function(response) {
                        // return console.log(response);
                        let data = JSON.parse(response)
                        if (data.status === 200) {
                            $("#orderSectionReload").load(location.href + " #orderSectionReload");
                        }
                    }
                })
            }
        }

        function change_order_status(status, order_item_id, orderid, oldVlaue) {
            // return console.log("in order status");
            var box = document.getElementById('change_status_' + orderid);
            var conf = confirm("Are you sure want to change Status ?");
            if (conf == true) {
                var base_url = '<?php echo $base_url . 'home/changeStatusmail'; ?>';
                window.location = base_url + "/" + status + "/" + order_item_id + "/" + orderid;
                return true;
            } else {
                box.value = oldVlaue;
                return false;
            }
        }

        function assign_delivery_boy(deliveryBoyId, orderid) {
            var conf = confirm("Are you sure want to assign this delivery boy?");
            if (conf == true) {
                var base_url = '<?php echo $base_url . 'home/assignDeliveryBoyOrder'; ?>';
                window.location = base_url + "/" + deliveryBoyId + "/" + orderid;
                return true;
            } else {
                return false;
            }
        }
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.js'></script>
    <!-- invoice modal starts -->
    <div class="modal fade" id="create_label_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" id="create_label_html">

            </div>
        </div>
    </div>
    <!-- invoice modal ends -->

    <!-- edit quantity modal starts -->
    <div class="modal fade" id="edit_quantity_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" id="create_label_html">
                <h1>Modal content</h1>
            </div>
        </div>
    </div>
    <!-- edit quantity modal ends -->
    <script>
        const edit_quantity = () => {
            $('#edit_quantity_modal').modal('show');
        }

        function createinvoice(id) {
            var itemid = id;
            var url = '<?php echo $base_url; ?>account/createinvoice_vendor';
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

        function createinvoice1(id) {
            var itemid = id;
            var url = '<?php echo $base_url; ?>account/createinvoice_vendor_sp';
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