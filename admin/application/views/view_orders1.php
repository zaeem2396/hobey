<?php include('include/header.php'); ?>
<style>
   #create_label_html .modal-header {
      height: auto;
      padding: 15px;
      border-bottom: 1px solid #e5e5e5;
      background: white;
      color: #000;
   }

   .invoice-title h2,
   .invoice-title h3 {
      display: inline-block;
   }

   .table>tbody>tr>.no-line {
      border-top: none;
   }

   .table>thead>tr>.no-line {
      border-bottom: none;
   }

   .table>tbody>tr>.thick-line {
      border-top: 2px solid;
   }

   .table>thead>tr>.thick-line-bottom {
      border-bottom: 2px solid;
   }

   .btn-default-red {
      background-color: #fdbb28;
      border: 1px solid #fdbb28;
      transition: all 0.3s ease 0s;
      color: #fff;
      padding: 6px 50px;
      text-transform: uppercase;
   }
</style>

<!-- Start: Main -->
<div id="main">
   <?php include('include/sidebar_left.php'); ?>
   <!-- Start: Content -->
   <!-- Start: Content -->
   <section id="content_wrapper">
      <div id="topbar">
         <div class="topbar-left">
            <ol class="breadcrumb">

               <li class="crumb-icon"><a href="<?php echo $base_url; ?>"><span class="glyphicon glyphicon-home"></span></a></li>
               <li class="crumb-icon"><a href="<?php echo $base_url; ?>orders/lists_specialcustomer">Order Management</a></li>
               <li class="crumb-active"><a href="#">Order Detail</a></li>
            </ol>
         </div>
      </div>
      <div id="content">
         <div class="row">
            <?php if ($this->session->flashdata('L_strErrorMessage')) { ?>
               <div class="alert alert-success alert-dismissable">
                  <i class="fa fa-check"></i>
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <b>Success!</b> <?php echo $this->session->flashdata('L_strErrorMessage', 5); ?>
               </div>
            <?php } ?>
            <?php if ($this->session->flashdata('flashError') != '') { ?>
               <div class="alert alert-danger alert-dismissable">
                  <i class="fa fa-warning"></i>
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <b>Error!</b> <?php echo $this->session->flashdata('flashError', 5); ?>
               </div>
            <?php }  ?>
            <!-- <div class="col-md-12">
            <button class="btn btn-success pull-right"  style="margin-left:10px" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalHorizontal"><i class="fa fa-plus-circle"></i> Add Tracking Information</button>
            </div>-->
            <!--	<div class="col-md-12">
            <a href="javascript:void(0);" onclick="printDiv('printArea');" class="btn btn-alert pull-right"><i class="fa fa-plus"></i> Print Invoice</a>
            <a href="javascript:void(0);" onclick="printDiv('printslip');" class="btn btn-alert pull-right" style="margin-right:10px;"><i class="fa fa-plus"></i> Print Packing Slip</a>
            </div> -->
            <div class="clearfix">&nbsp;</div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <div class="panel">
                  <div class="panel-body">
                     <div class="container-fluid">
                        <div class="row">
                           <div class="col-xs-12">
                              <div class="invoice-title">
                                 <div class="row">
                                    <div class="col-xs-3">
                                       <?php //echo "<pre>";print_r($order);echo "</pre>"; 
                                       ?>
                                       <!-- <form action="<?php echo $base_url . "orders/changeStatusmail/" . $order['order_id']; ?>" method="post" enctype="multipart/form-data" id="statusupdate">
                                       <label >Order Status</label>
                                        <select class="order_status form-control" name="status">
                                                           <option <?php if ($order['order_status'] == "P") echo 'selected' ?> value="P">Pending</option>
                                         <option <?php if ($order['order_status'] == "S") echo 'selected' ?> value="S">Shipped</option>
                                                           <option <?php if ($order['order_status'] == "D") echo 'selected' ?> value="D">Delivered</option>
                                                           <option <?php if ($order['order_status'] == "C") echo 'selected' ?> value="C">Canceled</option>
                                         </select>
                                         <label >Tracking Detail</label>
                                         
                                         <textarea name="tracking" placeholder="Enter Tracking Detail" class="form-control"><?php echo $order['trackadd']; ?></textarea>
                                         
                                         <button class="btn btn-alert" class="btn btn-primary btn-lg" style="margin-top:05px" onclick="javascript:statust(); return false;" >Update</button>
                                         </form> -->
                                    </div>
                                    <div class="col-xs-9">
                                       <h3 class="pull-right">Order # <?php echo $order['order_id'] ?></h3>
                                    </div>
                                 </div>
                              </div>
                              <script>
                                 function statust() {
                                    var conf = confirm("Are you sure want to change Status ?");
                                    if (conf == true) {
                                       $("#statusupdate").submit();
                                       /*var base_url = '<?php echo $base_url . 'orders/changeStatusmail'; ?>';
                                       window.location = base_url+"/"+order_id+"/"+status;*/
                                       return true;
                                    } else {
                                       return false;
                                    }
                                 }
                              </script>
                              <hr style="margin: 0 0 18px 0;">
                              <div class="row">
                                 <div class="col-xs-6">
                                    <address>
                                       <strong>Shipping To:</strong><br>
                                       <?php echo $order['address1'] . ",<br>"; ?>
                                       <?php echo $order['post_code'] . ",<br>"; ?>
                                       <?php echo "Mo - " . $order['phone_number'] . "<br>"; ?>
                                    </address>
                                 </div>
                                 <div class="col-xs-6 text-right">
                                    <address>
                                       <strong>Order Date:</strong><br>
                                       <?php $order_date = strtotime($order['cdate']);
                                       echo $mysqldate = date('l, F d, Y', $order_date); ?>
                                    </address>
                                    <button type="button" onclick="createinvoice(<?php echo $order['order_id'] ?>);" data-toggle="modal" data-target="#invoce_modal" class="btn btn-default-red" style="float:right;padding: 6px 20px;">Invoice</button>
                                 </div>
                              </div>
                              <div class="row">
                                 <!--div class="col-xs-6">
                                 <address>
                                     <strong>Payment Method:</strong><br>
                                     <br>
                                 </address>
                                 </div>
                                 <div class="col-xs-6 text-right">
                                 <address>
                                     <strong>Order Date:</strong><br>
                                   <?php $order_date = strtotime($order['created_on']);
                                    echo $mysqldate = date('l, F d, Y', $order_date); ?><br><br>
                                 </address>
                                 </div-->
                              </div>
                           </div>
                        </div>
                        <?php //echo "<pre>"; print_r($order); 
                        $titleName = '';
                        if ($order['is_customer'] == 0) {
                           $titleName = 'Distributor Detail';
                        } else {
                           $titleName = 'Customer Detail';
                        }
                        ?>

                        <div class="row">
                           <div class="col-md-12">
                              <div class="panel panel-default">
                                 <div class="panel-heading">
                                    <h3 class="panel-title"><strong><?php echo $titleName; ?> </strong></h3>
                                 </div>
                                 <div class="panel-body">
                                    <div class="table-responsive">
                                       <table class="table table-condensed">
                                          <thead>
                                             <tr>
                                                <td><strong>First Name</strong></td>

                                                <td class="text-center"><strong>Mobile</strong></td>
                                                <!--<td class="text-center"><strong>Address</strong></td>
                                                <td class="text-center"><strong>City</strong></td>-->
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <tr>
                                                <td><?php echo $order['first_name']; ?></td>

                                                <td class="text-center"> <?php echo $order['phone_number']; ?></td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                              <?php $canceldisplay = false;
                              if (count($order['items']) > 1 && $order['order_status'] == "P") {
                                 $canceldisplay = true;
                              }  ?>
                              <div class="panel panel-default">
                                 <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Order summary</strong></h3>
                                 </div>
                                 <div class="panel-body">
                                    <div class="table-responsive">
                                       <table class="table table-condensed">
                                          <thead>
                                             <tr>

                                                <td class="thick-line-bottom"><strong>Product Name</strong></td>
                                                <td class="thick-line-bottom"><strong>&nbsp;&nbsp;</strong></td>
                                                <?php if ($order['is_customer'] == 1) { ?>
                                                   <td class="thick-line-bottom"><strong>Distributor Name</strong></td>
                                                <?php } ?>
                                                <td class="thick-line-bottom"><strong>MRP</strong></td>
                                                <td class="thick-line-bottom"><strong>Savings</strong></td>
                                                <td class="text-center thick-line-bottom"><strong>Unit price</strong></td>
                                                <td class="text-center thick-line-bottom"><strong>Quantity</strong></td>
                                                <td class="text-right thick-line-bottom"><strong>Totals</strong></td>
                                                <!-- <td class="text-right thick-line-bottom"><strong>Order Status</strong></td> -->
                                                <?php /* if($canceldisplay==true){ ?>
                                             <td class="text-right thick-line-bottom"><strong>Cancel</strong></td>
                                             <?php } */ ?>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php
                                             //echo "<pre>";print_r($order['items']);echo "</pre>";
                                             foreach ($order['items'] as $item) { ?>
                                                <tr>

                                                   <td class="text-left"><?php echo $item['order_item_name']; ?></td>
                                                   <td class="text-left"><?php //echo $this->orders_model->getUsername($item['vendor_id']); 
                                                                              ?></td>
                                                   <?php if ($order['is_customer'] == 1) { ?>
                                                      <td class="text-left"><?php echo $this->orders_model->getUsername($item['distributor_id']); ?></td>
                                                   <?php } ?>
                                                   <td class="text-left">Rs. <?php echo $item['realprice']; ?></td>
                                                   <td class="text-left">Rs. <?php echo $item['realprice'] - number_format($item['product_item_price']); ?></td>
                                                   <td class="text-center">Rs. <?php echo number_format($item['product_item_price']); ?></td>
                                                   <td class="text-center"><?php echo $item['product_quantity']; ?></td>
                                                   <td class="text-right">Rs. <?php echo $item['product_item_price'] * $item['product_quantity'] ?> </td>
                                                   <!-- <td class="text-center" width="9%">
                                                <?php
                                                   $status = "Pending";
                                                   if ($item['is_cancel'] == '1') {
                                                      $status = "Cancelled";
                                                   }
                                                   if ($item['packstatus'] == '1') {
                                                      $status = "Packed";
                                                   } else if ($item['packstatus'] == '2') {
                                                      $status = "Dispatched";
                                                   } else if ($item['packstatus'] == '3') {
                                                      $status = "Delivered";
                                                   }
                                                   echo $status;
                                                   ?>
                                             </td> -->
                                                   <?php /* if($canceldisplay==true){ if($item['is_cancel']==1){ ?>
                                             <td class="text-right">Canceled</td>
                                             <?php }else{ ?>
                                             <td><button class="btn btn-alert" class="btn btn-primary btn-lg"  onclick="javascript:cancel_product(<?php echo $item['order_item_id']; ?>,<?php echo $item['order_id']; ?>); return false;" >Cancel</button></td>
                                             <?php }  ?>
                                             <?php } */ ?>
                                                </tr>
                                             <?php } ?>
                                             <tr>

                                                <td class="thick-line"></td>
                                                <td class="thick-line"></td>
                                                <td class="thick-line"></td>
                                                <td class="thick-line text-left"><strong>Subtotal</strong></td>
                                                <td class="thick-line text-right">Rs. <?php echo number_format($order['sub_total']); ?></td>
                                                <td class="thick-line"></td>
                                             </tr>
                                             <!--<tr>
                                             <td class="no-line"></td>
                                             <td class="no-line"></td>
                                             <td class="no-line"></td>
                                             <td class="no-line"></td>
                                             <td class="no-line text-center"><strong>Additional Cost</strong></td>
                                             <td class="no-line text-right">Rs.<?php echo $order['ordercost'] ?></td>
                                             </tr>
                                             -->
                                             <?php if ($order['coupondiscount'] != '') { ?>
                                                <tr>

                                                   <td class="no-line"></td>
                                                   <td class="no-line"></td>
                                                   <td class="no-line"></td>
                                                   <td class="no-line text-left"><strong>Coupon Discount</strong></td>
                                                   <td class="no-line text-right">Rs. <?php echo "-" . number_format($order['coupondiscount']); ?></td>
                                                   <td class="no-line"></td>
                                                </tr>
                                             <?php } ?>
                                             <?php if ($order['shippingcost'] != '' && $order['shippingcost'] != '0') { ?>
                                                <tr>

                                                   <td class="no-line"></td>
                                                   <td class="no-line"></td>
                                                   <td class="no-line"></td>
                                                   <td class="no-line text-left"><strong>Shipping</strong></td>
                                                   <td class="no-line text-right">Rs.<?php echo number_format($order['shippingcost']); ?></td>
                                                   <td class="no-line"></td>
                                                </tr>
                                             <?php } ?>
                                             <!-- 
                                             <tr>
                                                 <td class="no-line"></td>
                                                 <td class="no-line"></td>
                                                 <td class="no-line"></td>
                                                 <td class="no-line"></td>
                                                 <td class="no-line text-center"><strong>Shipping</strong></td>
                                                 <td class="no-line text-right">Rs. 0</td>
                                             </tr>-->
                                             <tr>

                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line text-left"><strong>Total</strong></td>
                                                <td class="no-line text-right">Rs. <?php echo number_format($order['order_total']); ?></td>
                                                <td class="no-line"></td>
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
                  <script>
                     function cancel_product(order_item_id, orderid) {
                        var conf = confirm("Are you sure want to Cancel Product ?");
                        if (conf == true) {
                           var base_url = '<?php echo $base_url . 'orders/cancel_product'; ?>';
                           window.location = base_url + "/" + order_item_id + "/" + orderid;
                           return true;
                        } else {
                           return false;
                        }
                     }
                  </script>
               </div>
               <!------Start Print Div -->
               <style>
                  .panel {
                     margin-bottom: 0px !important;
                  }

                  .padding-zero {
                     padding-left: 0px !important;
                     padding-right: 0px !important;
                  }

                  .padding-right-zero {
                     padding-right: 0px !important;
                  }

                  .padding-top-zero {
                     padding-top: 0px !important;
                  }

                  .padding-bottom-zero {
                     padding-bottom: 0px !important;
                  }

                  .border-1px {
                     border: 1px solid #d5d5d5;
                  }

                  .border-bottom-1px {
                     border-bottom: 1px solid #d5d5d5;
                  }

                  .border-left-1px {
                     border-left: 1px solid #d5d5d5;
                  }

                  .border-right-1px {
                     border-right: 1px solid #d5d5d5;
                  }

                  .invoice-title h2,
                  .invoice-title h3 {
                     display: inline-block;
                  }

                  .table>tbody>tr>.no-line {
                     border-top: none;
                  }

                  .table>thead>tr>.no-line {
                     border-bottom: none;
                  }

                  .table>tbody>tr>.thick-line {
                     border-top: 2px solid;
                  }

                  .table>thead>tr>.thick-line-bottom {
                     border-bottom: 2px solid;
                  }

                  @media (max-width:768px) {

                     .col-xs-1,
                     .col-sm-1,
                     .col-md-1,
                     .col-lg-1,
                     .col-xs-2,
                     .col-sm-2,
                     .col-md-2,
                     .col-lg-2,
                     .col-xs-3,
                     .col-sm-3,
                     .col-md-3,
                     .col-lg-3,
                     .col-xs-4,
                     .col-sm-4,
                     .col-md-4,
                     .col-lg-4,
                     .col-xs-5,
                     .col-sm-5,
                     .col-md-5,
                     .col-lg-5,
                     .col-xs-6,
                     .col-sm-6,
                     .col-md-6,
                     .col-lg-6,
                     .col-xs-7,
                     .col-sm-7,
                     .col-md-7,
                     .col-lg-7,
                     .col-xs-8,
                     .col-sm-8,
                     .col-md-8,
                     .col-lg-8,
                     .col-xs-9,
                     .col-sm-9,
                     .col-md-9,
                     .col-lg-9,
                     .col-xs-10,
                     .col-sm-10,
                     .col-md-10,
                     .col-lg-10,
                     .col-xs-11,
                     .col-sm-11,
                     .col-md-11,
                     .col-lg-11,
                     .col-xs-12,
                     .col-sm-12,
                     .col-md-12,
                     .col-lg-12 {
                        padding-left: 1px !important;
                        padding-right: 1px !important;
                     }
                  }
               </style>
               <div class="panel" style="display:none;" id="printArea">
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-xs-12 col-md-6 col-lg-12">
                           <div class="col-xs-12 col-md-6 col-lg-4" style="width: 33.3333%;">
                              <img width="210" style=" float:left" src="http://justintime.in/beta/upload/logo/logo.png" alt="Just In Time">
                           </div>
                           <div class="col-xs-12 col-md-6 col-lg-4 text-center" style="width: 33.3333%;">
                              <h3 style=" margin-top:20px;"><span><strong>Invoice</strong></span></h3>
                           </div>
                           <div class="col-xs-12 col-md-6 col-lg-4" style="height: 80px;width: 33.3333%;"> &nbsp;</div>
                           <div class="col-xs-12 col-md-6 col-lg-4 padding-right-zero padding-bottom-zero" style="padding-right:0px !important;padding-bottom:0px !important;width: 33.3333%; height:170px;">
                              <div class="panel panel-default height" style="margin-bottom:0px !important;
                              background-color: #fff;
                              border-top: 1px solid #d5d5d5 !important;
                              border-right: 1px solid #d5d5d5 !important;border-left: 1px solid #d5d5d5 !important;
                              border-bottom: 1px solid #fff !important;
                              border-radius: 4px;
                              box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
                              ">
                                 <div class="panel-body">
                                    Sender<br />
                                    <strong>Just in Time Trading Pvt Ltd,</strong><br />
                                    V N Sphere, Plot No.199,<br />
                                    Vithalbhai Patel Road,<br />
                                    TPS-III,<br />
                                    Bandra(W)<br />
                                    Mumbai - 400050<br />
                                    Ph No: 65285700<br />
                                    E-Mail: customercare@justintime.in
                                 </div>
                              </div>
                           </div>
                           <div class="col-xs-12 col-md-6 col-lg-4 padding-zero padding-bottom-zero" style="padding-bottom:0px !important;padding-left:0px !important; padding-right:0px !important;width: 33.3333% !important;">
                              <div class="panel panel-default height" style="height: 205px ! important;margin-bottom:0px !important;  background-color: #fff;
                              border: 1px solid #d5d5d5 !important;
                              border-radius: 4px;
                              box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
                              margin-bottom: 20px;">
                                 <div class="panel-body border-bottom-1px" style=" border-bottom:1px solid #d5d5d5;">
                                    Invoice No.<br />
                                    <strong style="font-size:18px">RJLPL00317</strong><br />
                                 </div>
                                 <div class="panel-body">
                                    Order No.<br />
                                    <strong style="font-size:18px">OD506796207040523000</strong><br />
                                 </div>
                              </div>
                           </div>
                           <div class="col-xs-12 col-md-6 col-lg-4 padding-zero padding-bottom-zero" style="width: 33.3333% !important;">
                              <div class="panel panel-default height" style="height: 205px ! important;margin-bottom:0px !important;  background-color: #fff;
                              border: 1px solid #d5d5d5 !important;
                              border-radius: 4px;
                              box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
                              margin-bottom: 20px;
                              margin-left:-10px;">
                                 <div class="panel-body border-bottom-1px" style="border-bottom:1px solid #d5d5d5;">
                                    Dated<br />
                                    <strong style="font-size:18px">16-Aug-2016</strong><br />
                                 </div>
                                 <div class="panel-body">
                                    Dated<br />
                                    <strong style="font-size:18px">16-Aug-2016</strong><br />
                                 </div>
                              </div>
                           </div>
                           <div class="col-xs-12 col-md-6 col-lg-4 padding-right-zero padding-top-zero" style="padding-right:0px !important; padding-top:0px !important;width: 33.3333%;">
                              <div class="panel panel-default height" style="height: 150px !important;margin-bottom:0px !important;  background-color: #fff;
                              border: 1px solid #d5d5d5 !important;
                              border-radius: 4px;
                              box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
                              ">
                                 <div class="panel-body">
                                    Buyer<br />
                                    <strong>Dr.<?php echo $order['user_name']; ?></strong><br />
                                    <?php echo $order['address'] . ",<br>"; ?>
                                    <?php echo $order['city'] . ",<br>"; ?>
                                    <?php echo $order['state'] . "-" . $order['zipcode'] . ",<br>"; ?>
                                    <?php echo $order['country'] . ".<br>"; ?>
                                    <?php echo "Mo - " . $order['mobno'] . "<br>"; ?>
                                 </div>
                                 </address>
                              </div>
                           </div>
                           <div class="col-xs-12 col-md-6 col-lg-4 padding-zero padding-top-zero" style=" padding-left:0px !important; padding-right:0px !important; padding-top:0px !important;width: 33.3333%;">
                              <div class="panel panel-default height" style="height: 150px !important;margin-bottom:0px !important;  background-color: #fff;
                              border: 1px solid #d5d5d5 !important;
                              border-radius: 4px;
                              box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
                              margin-bottom: 20px;">
                                 <div class="panel-body">
                                    Portal<br />
                                    <strong style="font-size:18px">JUST IN TIME</strong><br />
                                 </div>
                                 <!--<div class="panel-body">
                                 Dispatch Through<br />
                                 <strong style="font-size:18px">E-Kart Logistics</strong><br />    
                                    
                                    
                                 </div>-->
                              </div>
                           </div>
                           <div class="col-xs-12 col-md-6 col-lg-4 padding-zero padding-top-zero" style=" padding-left:0px !important; padding-right:0px !important; padding-top:0px !important;width: 33.3333%;">
                              <div class="panel panel-default height" style="height: 150px !important;margin-bottom:0px !important;  background-color: #fff;
                              border: 1px solid #d5d5d5 !important;
                              border-radius: 4px;
                              box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
                              margin-bottom: 20px;">
                                 <div class="panel-body">
                                    Payment Mode<br />
                                    <strong style="font-size:18px">Prepaid</strong><br />
                                 </div>
                                 <!--<div class="panel-body">
                                 AWB No<br />
                                 <strong style="font-size:18px">FMPC0146442531</strong><br />     
                                    
                                    
                                 </div>-->
                              </div>
                           </div>
                           <div class="col-xs-12 col-md-6 col-lg-12 padding-zero padding-top-zero" style=" padding-left:0px !important; padding-right:0px !important; padding-top:0px !important;">
                              <div class="panel panel-default" style="margin-left: 10px;margin-bottom:0px !important;  background-color: #fff;
                              border-bottom: 0px solid #fff !important;
                              border-radius: 4px;
                              box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
                              margin-bottom: 20px;
                              border-right:1px solid #d5d5d5 !important;
                              border-left:1px solid #d5d5d5 !important;">
                                 <table class="table table-bordered">
                                    <thead>
                                       <tr>
                                          <th style="border:1px solid #ddd !important;">
                                             <h4>Sr No.</h4>
                                          </th>
                                          <th style="border:1px solid #ddd !important;">
                                             <h4>Description of Goods</h4>
                                          </th>
                                          <th style="border:1px solid #ddd !important;">
                                             <h4>Model No.</h4>
                                          </th>
                                          <th style="border:1px solid #ddd !important;">
                                             <h4>Quantity</h4>
                                          </th>
                                          <th style="border:1px solid #ddd !important;">
                                             <h4>Rate</h4>
                                          </th>
                                          <th style="border:1px solid #ddd !important;">
                                             <h4>Amount</h4>
                                          </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $i = '1';
                                       $totalquty = '0';
                                       foreach ($order['items'] as $item) { ?>
                                          <tr>
                                             <td><?php echo $i; ?></td>
                                             <td><?php echo $item['order_item_name']; ?></td>
                                             <td class="text-right"><?php echo $item['order_item_code']; ?> </td>
                                             <td class="text-right"><?php echo $item['product_quantity']; ?></td>
                                             <td class="text-right"><i class="fa fa-inr"></i> <?php echo number_format($item['product_item_price']); ?>
                                             </td>
                                             <td class="text-right"><i class="fa fa-inr"></i> <?php echo $item['product_item_price'] * $item['product_quantity'] ?>
                                             </td>
                                          </tr>
                                       <?php $totalquty = ($totalquty + $item['product_quantity']);
                                          $i++;
                                       } ?>
                                       <thead>
                                          <tr>
                                             <th class="text-right" colspan="2" style="border:1px solid #ddd !important;">
                                                <h4>TOTAL</h4>
                                             </th>
                                             <th style="border:1px solid #ddd !important;">
                                                <h4></h4>
                                             </th>
                                             <th class="text-right" style="border:1px solid #ddd !important;">
                                                <h4><?php echo $totalquty; ?></h4>
                                             </th>
                                             <th style="border:1px solid #ddd !important;">
                                                <h4></h4>
                                             </th>
                                             <th class="text-right" style="border:1px solid #ddd !important;">
                                                <h4><i class="fa fa-inr"></i> <?php echo number_format($order['sub_total']); ?></h4>
                                             </th>
                                          </tr>
                                          <?php if ($order['coupondiscount'] != '0') { ?>
                                             <tr>
                                                <th class="text-right" colspan="5" style="border:1px solid #ddd !important;">
                                                   <h4>Coupon Discount</h4>
                                                </th>
                                                <th class="text-right" style="border:1px solid #ddd !important;">
                                                   <h4><i class="fa fa-inr"></i> <?php echo number_format($order['coupondiscount']); ?></h4>
                                                </th>
                                             </tr>
                                          <?php  } ?>
                                          <tr>
                                             <th class="text-right" colspan="5" style="border:1px solid #ddd !important;">
                                                <h4>Grand Total</h4>
                                             </th>
                                             <th class="text-right" style="border:1px solid #ddd !important;">
                                                <h4><i class="fa fa-inr"></i> <?php echo number_format($order['order_total']); ?></h4>
                                             </th>
                                          </tr>
                                       </thead>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="col-xs-12 col-md-12 col-lg-12 border-1px" style="margin-left: 10px; width: 99%;border:1px solid #d5d5d5;">
                              <div class="col-xs-12 col-md-6 col-lg-6" style="width: 50%;">
                                 Amount Chargeable (in words)
                              </div>
                              <div class="col-xs-12 col-md-6 col-lg-6 text-right" style="width: 50%;">
                                 E. & O.E
                              </div>
                              <div class="col-xs-12 col-md-12 col-lg-12">
                                 <h3 style="margin-top:10px;"> <strong>INR <?php echo $totol_words; ?></strong></h3>
                              </div>
                              <div class="col-xs-12 col-md-12 col-lg-12">
                                 Company's VAT TIN : 27670783970V w.e.f 27/07/2010
                              </div>
                              <div class="col-xs-12 col-md-12 col-lg-12">
                                 Company's CST TIN : 27670783970C w.e.f 27/07/2010
                              </div>
                              <!--<div class="col-xs-12 col-md-12 col-lg-12"> 
                              Company's PAN :
                              
                                             </div>-->
                              <div class="col-xs-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">
                                 <span style=" text-decoration:underline">Declaration</span><br />
                                 We declare that this invoice shows the actual price of the
                                 goods described and that all particulars are true and correct.
                              </div>
                              <!--<div style="margin-top:30px;" class="col-xs-12 col-md-6 col-lg-6 text-center border-1px"> 
                              <span>  <strong>For just lifestyle Pvt Ltd</strong></span><br><br><br>
                                <span>Authorised Signatory</span>
                                 </div>-->
                           </div>
                           <div class="col-xs-12 col-md-12 col-lg-12 text-center" style="margin-top:10px;">
                              This is a Computer Generated Invoice
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!------End Print Div -->
            </div>
            <div class="clearfix"></div>
         </div>
      </div>
   </section>

   <?php include('include/sidebar_right.php'); ?>
</div>
<!-- End #Main -->
<?php include('include/footer.php') ?>
<div class="modal fade" id="invoce_modal" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content" id="create_label_html">
      </div>
   </div>
</div>
<script>
   function createinvoice(id) {
      var itemid = id;
      var url = '<?php echo $front_base_url; ?>index.php/home/createinvoice_vendor_sp';
      jQuery.ajax({
         url: url,
         type: 'post',
         data: 'itemid=' + itemid,
         success: function(msg) {
            $('#create_label_html').html(msg);
            $('#invoce_modal').modal('show');
         }
      });
   }
</script>
<!---- Start Delivered Slip ---->
<?php  /* ?>
<style>
  .panel{ margin-bottom:0px !important;  
  border-left: 3px dashed black !important;
  border-right: 3px dashed black !important;}

  .panel-heading{ line-height:30px !important; padding:10px !important;}
  .invoice-title h2, .invoice-title h3 {
      display: inline-block;
  }

  .table > tbody > tr > .no-line {
      border-top: none;
  }

  .table > thead > tr > .no-line {
      border-bottom: none;
  }

  .table > tbody > tr > .thick-line {
      border-top: 2px solid;
  }
  .table > thead > tr > .thick-line-bottom{
      border-bottom: 2px solid;
  }


  } 
</style>  */ ?>
<div class="panel" style="border:none !important; display:none;" id="printslip">
   <div class="panel-body">
      <div class="row">
         <div class="col-xs-12 col-md-6 col-lg-6 col-lg-offset-3">
            <div class="panel panel-default height" style=" border-top: 3px dashed black !important;border-left: 3px dashed black !important;
border-right: 3px dashed black !important;
margin-bottom: 0 !important;border-bottom:1px solid #d5d5d5 !important;">
               <div class="panel-heading" style="background-color: #f5f5f5;
border-color: #ddd;
color: #333;">Packing Slip</div>

               <div class="panel-body">
                  <strong>DELIVERY ADDRESS:</strong><br>
                  <?php echo $order['user_name']; ?>,<br>
                  <?php echo $order['address'] . ",<br>"; ?>
                  <?php echo $order['city'] . ",<br>"; ?>
                  <?php echo $order['state'] . "-" . $order['zipcode'] . ",<br>"; ?>
                  <?php echo $order['country'] . ".<br>"; ?>
                  <?php echo "Mo - " . $order['mobno'] . "<br>"; ?>

               </div>
            </div>
            <div class="panel panel-default height" style="border-left: 3px dashed black !important;
border-right: 3px dashed black !important;
margin-bottom: 0 !important;border-bottom:1px solid #d5d5d5 !important;">
               <div class="panel-heading" style="background-color: #f5f5f5;
border-color: #ddd;
color: #333;">Courier Name: E-Kart Logistics<br />
                  Courier AWB No: FMPC0146442531
               </div>
               <div class="panel-body">
                  <strong>Sold By:</strong>
                  <strong>Just in Time Trading Pvt Ltd,</strong><br />
                  V N Sphere, Plot No.199,<br />
                  Vithalbhai Patel Road,<br />
                  TPS-III,<br />
                  Bandra(W)<br />
                  Mumbai - 400050<br />
                  Ph No: 65285700<br />
                  E-Mail: customercare@justintime.in<br />

               </div>
            </div>

            <div class="panel panel-default height" style="border-left: 3px dashed black !important;
border-right: 3px dashed black !important;
margin-bottom: 0 !important;border-bottom:1px solid #d5d5d5 !important;">

               <div class="panel-body">
                  <strong>VAT TIN No: 27670783970V w.e.f 27/07/2010</strong><br /> <span><strong>CST TIN No: 27670783970C w.e.f 27/07/2010</strong></span>


               </div>


            </div>
            <div class="panel panel-default" style="border-left: 3px dashed black !important;
border-right: 3px dashed black !important;
margin-bottom: 0 !important;border-bottom:1px solid #d5d5d5 !important;">
               <div class="panel-body">
                  <div class="table-responsive">
                     <table class="table table-condensed">
                        <thead>
                           <tr>
                              <td><strong>Product</strong></td>
                              <td class="highrow"></td>
                              <td class="highrow"></td>
                              <td class="text-center"><strong>Quantity</strong></td>

                           </tr>
                        </thead>
                        <tbody>
                           <?php $totalquty = '0';
                           foreach ($order['items'] as $item) { ?>

                              <tr>
                                 <td><?php echo $item['order_item_name']; ?> | <?php echo $item['order_item_code']; ?></td>
                                 <td class="highrow"></td>
                                 <td class="highrow"></td>
                                 <td class="text-center"><?php echo $item['product_quantity']; ?></td>

                              </tr>
                           <?php $totalquty = ($totalquty + $item['product_quantity']);
                           } ?>



                           <tr>
                              <td class="highrow"></td>
                              <td class="highrow"></td>
                              <td class="highrow text-right"><strong>Total</strong></td>
                              <td class="highrow text-center"><?php echo $totalquty; ?></td>

                           </tr>


                        </tbody>
                     </table>
                     <!--<div class="panel-heading">
                    <h4 class="text-right">
                    <strong>(N) DEL/DSG</strong></h4>
                </div>-->
                  </div>
               </div>

            </div>


            <div class="panel panel-default height" style="border-left: 3px dashed black !important;
border-right: 3px dashed black !important;
margin-bottom: 0 !important;border-bottom:1px solid #d5d5d5 !important;">

               <div class="panel-body">
                  <!--                       <span style="background: black none repeat scroll 0% 0%; color: white; padding: 10px;"> <strong>Handover to E-Kart Logistics</strong> </span>   <span class="pull-right"><strong>REG</strong></span><br /><br />-->
                  <strong>Tracking ID:</strong> FMPC0146442531<br />
                  <strong>Order ID:</strong> OD506796207040523000

               </div>


            </div>

            <div class="panel panel-default height" style=" border-bottom: 3px dashed black !important;border-left: 3px dashed black !important;
border-right: 3px dashed black !important;
margin-bottom: 0 !important;
border-top:1px solid #d5d5d5 !important;">

               <div class="panel-body">
                  <span class="pull-right"><strong>Ordered Through</strong></span><br />
                  <img width="110" style="margin-top: 10px; float:right" src="http://justintime.in/beta/upload/logo/logo.png" alt="Just In Time">

               </div>


            </div>
         </div>
      </div>

   </div>
</div>
<!---- Start Delivered Slip ---->


<div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
               <span aria-hidden="true">&times;</span>
               <span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">
               Add Tracking Information
            </h4>
         </div>

         <!-- Modal Body -->
         <div class="modal-body">
            <form method="post" class="form-horizontal" role="form" id="add_tracking_info_form">
               <input type="hidden" class="form-control" name="action" value="add_tracking_info" />
               <input type="hidden" class="form-control" name="id" value="<?php if (isset($tracking_info['id']) and $tracking_info['id'] != null) {
                                                                              echo $tracking_info['id'];
                                                                           } ?>" />
               <div class="form-group">
                  <label class="col-sm-2 control-label" for="tracking_id">Tracking ID</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" value="<?php if (isset($tracking_info['tracking_id']) and $tracking_info['tracking_id'] != null) {
                                                                        echo $tracking_info['tracking_id'];
                                                                     } ?>" id="tracking_id" name="tracking_id" />
                  </div>
               </div>
               <?php if (isset($tracking_info['dispach_date']) and $tracking_info['dispach_date'] != null) { ?>
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="dispach_date">Dispach Date</label>
                     <div class="col-sm-10">
                        <input type="text" readonly class="form-control" value="<?php if (isset($tracking_info['dispach_date']) and $tracking_info['dispach_date'] != null) {
                                                                                       echo $tracking_info['dispach_date'];
                                                                                    } ?>" id="dispach_date" name="dispach_date" />
                     </div>
                  </div>
               <?php } ?>
               <div class="form-group">
                  <label class="col-sm-2 control-label" for="tracking_link">Tracking Link</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="tracking_link" name="tracking_link" value="<?php if (isset($tracking_info['tracking_link']) and $tracking_info['tracking_link'] != null) {
                                                                                                               echo $tracking_info['tracking_link'];
                                                                                                            } ?>" />
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-sm-2 control-label" for="last_guideline">Last Guideline</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="last_guideline" name="last_guideline" value="<?php if (isset($tracking_info['last_guideline']) and $tracking_info['last_guideline'] != null) {
                                                                                                                  echo $tracking_info['last_guideline'];
                                                                                                               } ?>" />
                  </div>
               </div>
            </form>
         </div>

         <!-- Modal Footer -->
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
               Close
            </button>
            <button id="add_tracking_info_submit" type="button" class="btn btn-primary">
               Save changes
            </button>
         </div>
      </div>
   </div>
</div>

<!-- DATA TABES SCRIPT -->
<link href="<?php echo $base_url_views; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $base_url_views; ?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo $base_url_views; ?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<link href="<?php echo $base_url_views; ?>plugins/iCheck/minimal/_all.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $base_url_views; ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>

<script>
   $('#add_tracking_info_submit').click(function() {
      $('#add_tracking_info_form').submit();
   });

   $('.order_status').change(function() {
      var order_item_id = $(this).attr('data-order_id');
      var order_item_status = $(this).val();
      $.ajax({
         url: '<?php echo $this->config->item('base_url') . 'orders/changeItemStatus' ?>',
         type: 'get',
         data: 'order_item_id=' + order_item_id + '&order_item_status=' + order_item_status,
         dataType: 'text',
         success: function(response) {
            if (response == 1) {
               var status = '<div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b>Success!</b> Status of Item is changed.</div>';
               $('#content').children(':first-child').prepend(status);
            }
         }
      });
   });

   function printDiv(divName) {
      var printContents = document.getElementById(divName).innerHTML;
      var originalContents = document.body.innerHTML;

      document.body.innerHTML = printContents;

      window.print();

      document.body.innerHTML = originalContents;
   }
   //  $("#product_review_form").validate({
   //    errorElement: 'div',
   //    rules: {
   //      user_name: {
   //        required: true,
   //      },
   //      user_email: {
   //        required: true,
   //        email:true,
   //      },
   //      product_review_title: {
   //        required: true,
   //      },
   //      product_review: {
   //        required: true,
   //      },
   //    },
   //    messages:
   //    {
   //        user_name:
   //        {
   //          required:"Please Enter Your Name",
   //        },
   //        user_email:
   //        {
   //          required:"Please Enter You Email ID",
   //          email:"Please Enter Valid Email ID",
   //        },
   //        product_review_title:
   //        {
   //          required:"Please Enter Review Title",
   //        },
   //        product_review:
   //        {
   //          required:"Please Enter Review",
   //        },
   //    },
   //    errorPlacement: function(error, element)
   //    {
   //          error.insertAfter(element.parent());
   //    }
   //});
</script>