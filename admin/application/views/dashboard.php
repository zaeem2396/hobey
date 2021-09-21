<body class="dashboard-page">
   <script>
      var boxtest = localStorage.getItem('boxed');
      if (boxtest === 'true') {
         document.body.className += ' boxed-layout';
      }
   </script>
   <!DOCTYPE html>
   <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" > <![endif]-->
   <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" > <![endif]-->
   <!--[if IE 8]>         <html class="no-js lt-ie9" > <![endif]-->
   <!--[if gt IE 8]><!-->
   <html class="no-js">
   <!--<![endif]-->
   <?php include('include/header.php'); ?>
   <!-- Start: Main -->
   <div id="main">
      <?php include('include/sidebar_left.php'); ?>
      <!-- Start: Content -->
      <section id="content_wrapper">

         <div class="admin_dash_sec">
            <div class="container-fluid">
               <div class="row">

                  <?php if ($this->session->flashdata('L_strErrorMessage')) { ?>
                     <div class="alert alert-success alert-dismissable">
                        <i class="fa fa-check"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <b>Success!</b> <?php echo $this->session->flashdata('L_strErrorMessage', 5); ?>
                     </div>
                  <?php } ?>


                  <div class="col-xs-12 col-sm-12 col-md-9">
                     <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                           <h2 class="wlcm_text">Welcome to BPCL Dashboard</h2>
                           <div class="panel panel-default grid-margin">
                              <div class="panel-heading">Total Sale <a href="<?php echo $base_url; ?>reports_management/order" class="mya">View All</a></div>
                              <div class="panel-body">
                                 <div class="row">
                                    <div class="col-xs">
                                       <a href="#">
                                          <div class="box-row">
                                             <div class="dash_block">
                                                <h4>Today's Sale</h4>
                                                <h2><?php echo $orderstatus['todaysorder']; ?></h2>
                                             </div>
                                          </div>
                                       </a>
                                    </div>
                                    <div class="col-xs">
                                       <a href="#">
                                          <div class="box-row">
                                             <div class="dash_block">
                                                <h4>Weekly Sale</h4>
                                                <h2><?php echo $orderstatus['weeksale']; ?></h2>
                                             </div>
                                          </div>
                                       </a>
                                    </div>
                                    <div class="col-xs">
                                       <a href="#">
                                          <div class="box-row">
                                             <div class="dash_block">
                                                <h4>Monthly Sale</h4>
                                                <h2><?php echo $orderstatus['monthsale']; ?></h2>
                                             </div>
                                          </div>
                                       </a>
                                    </div>
                                    <div class="col-xs">
                                       <a href="#">
                                          <div class="box-row">
                                             <div class="dash_block">
                                                <h4>Total Profit</h4>
                                                <h2><?php echo $orderstatus['totalprofit']; ?></h2>
                                             </div>
                                          </div>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                           <div class="panel panel-default">
                              <div class="panel-heading">Top Products <a href="<?php echo $base_url; ?>home/topproducts" class="mya">View All</a></div>
                              <div class="panel-body">
                                 <div class="table-responsive">
                                    <table class="table table-striped table-borderless">
                                       <thead>
                                          <tr>
                                             <th>Image</th>
                                             <th>Product</th>
                                             <th>Qty</th>
                                             <th>Price</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php if ($topproducts != '' && count($topproducts)) {
                                             foreach ($topproducts as $product) {
                                                $productimage = $this->admin->productimage($product->product_id);

                                                ?>
                                                <tr>
                                                   <td class="text-center"><?php if ($productimage != '') { ?>
                                                         <img src="<?php echo $front_base_url; ?>upload/products/small/<?php echo $productimage; ?>">
                                                      <?php } else { ?>
                                                         <img src="<?php echo $front_base_url; ?>upload/products/medium/noimage.jpg">
                                                      <?php } ?>
                                                   </td>
                                                   <td><?php echo $product->name; ?></td>
                                                   <td><?php echo $product->qty; ?></td>
                                                   <td style="width: 20%;"><i class="fa fa-inr"></i> <?php echo round($product->price); ?></td>
                                                </tr>
                                          <?php }
                                          } ?>

                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 grid-margin stretch-card">
                           <div class="panel panel-default">
                              <div class="panel-heading">Top Vendors <a href="<?php echo $base_url; ?>home/topvendors" class="mya">View All</a></div>
                              <div class="panel-body">
                                 <div class="table-responsive">
                                    <table class="table table-striped table-borderless">
                                       <thead>
                                          <tr>
                                             <th>Vendor Name</th>
                                             <th>Qty</th>
                                             <th>Sale</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php if ($topvendors != '' && count($topvendors)) {
                                             foreach ($topvendors as $vendor) { ?>
                                                <tr>
                                                   <td><?php echo $vendor->company_name; ?></td>
                                                   <td><?php echo $vendor->qty; ?></td>
                                                   <td style="width: 20%;"><i class="fa fa-inr"></i> <?php echo round($vendor->price); ?></td>
                                                </tr>
                                          <?php }
                                          } ?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-3 notifications_div">
                     <div class="panel panel-default" style="box-shadow:none">
                        <div class="panel-heading">
                           Notifications
                           <span><a style="float: right;color: #055b57;padding-right: 28px;" href="<?php echo $base_url; ?>home/notifications" class="mya">View All</a></span>
                           <div class="noti_a">
                              <i class="fa fa-bell" aria-hidden="true"></i>
                              <div><?php if ($notifications != '') {
                                       echo count($notifications);
                                    } else {
                                       echo "0";
                                    }  ?></div>
                           </div>
                        </div>
                     </div>
                     <?php if ($notifications != '' && count($notifications)) {
                        foreach ($notifications as $notify) { ?>
                           <div class="noti_div">
                              <!--div class="close" id="hide2"><i class="fa fa-times-circle" aria-hidden="true"></i></div -->
                              <h4><img src="https://www.happysoul.in/site/views/dashboard/images/inventory_icon.png"> <?php echo $notify->tagname; ?>:</h4>
                              <p><?php echo $notify->message; ?></p>
                           </div>
                     <?php }
                     } ?>


                     <!-- div class="noti_div">
               <div class="close" id="hide1"><i class="fa fa-times-circle" aria-hidden="true"></i></div>
               <h4><i class="fa fa-shopping-cart" aria-hidden="true"></i> Order Canceled:</h4>
               <p>Your Order No. XXX is canceled by the buyer.</p>
            </div>
            <div class="noti_div">
               <div class="close" id="hide2"><i class="fa fa-times-circle" aria-hidden="true"></i></div>
               <h4><img src="https://happysoul.in/beta/site/views/dashboard/images/inventory_icon.png">  Out of Stock:</h4>
               <p>Your XXX product is out of stock. Please, refill the inventory.</p>
            </div>
            <div class="noti_div">
               <div class="close" id="hide2"><i class="fa fa-times-circle" aria-hidden="true"></i></div>
               <h4><img src="https://happysoul.in/beta/site/views/dashboard/images/inventory_icon.png"> Low on Stock:</h4>
               <p>Your XXX product is low on stock. Please, refill the inventory.</p>
            </div>
            <div class="noti_div">
               <div class="close" id="hide2"><i class="fa fa-times-circle" aria-hidden="true"></i></div>
               <h4><img src="https://happysoul.in/beta/site/views/dashboard/images/inventory_icon.png"> Product Approval:</h4>
               <p>Your XXX product is approved and live now.</p>
            </div>
            <div class="noti_div">
               <div class="close" id="hide2"><i class="fa fa-times-circle" aria-hidden="true"></i></div>
               <h4><img src="https://happysoul.in/beta/site/views/dashboard/images/inventory_icon.png"> Product Blocked:</h4>
               <p>Your XXX product is blocked.</p>
            </div>
            <div class="noti_div">
               <div class="close" id="hide2"><i class="fa fa-times-circle" aria-hidden="true"></i></div>
               <h4><i class="fa fa-credit-card" aria-hidden="true"></i> Payment is Credited:</h4>
               <p>We have credited Rs. XXX against your last due amount.
                  The transaction reference no is XXXXXX.
               </p>
            </div -->
                  </div>
               </div>
            </div>
         </div>
      </section>

      <!-- product message Modal -->
      <div class="modal fade" id="msgModal" role="dialog">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Message For Changes</h4>
               </div>
               <div class="modal-body">
                  <form class="form-horizontal" name="changemsg" id="changemsg" action="<?php echo $base_url; ?>home/productchange/" method="post">
                     <input type="hidden" value="" id="productid" name="productid" />
                     <div class="form-group" style="margin:0">
                        <textarea class="form-control" rows="5" id="comment" name="comment" placeholder="Type here your message"></textarea>
                     </div>
                     <br>
                     <div class="form-group" style="margin:0">
                        <button type="button" class="btn bg-purple" onclick="sendmessage(); ">Send</button>
                     </div>
                  </form>
               </div>

            </div>
         </div>
      </div>


      <!--change in product message Modal -->
      <!-- div class="modal fade" id="msgChangeModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change in Product Message</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" action="#">
              <div class="form-group" style="margin:0">
                 <textarea class="form-control" rows="5" id="comment" placeholder="Type here your message"></textarea>
              </div>
              <br>
              <div class="form-group"  style="margin:0">
                <button type="submit" class="btn bg-purple">Send</button>
              </div>
            </form>
        </div>
        
      </div>
    </div>
  </div-->
      <style>
         #main {
            height: auto;
         }
      </style>
      <script>
         function sendmessage() {
            var productid = $("#productid").val();
            var comment = $("#comment").val();

            if (productid == '') {
               alert('Some thing wrong with Product');
               return false;
            }

            if (comment == '') {
               alert('Please enter comment to be sent to Vendor');
               return false;
            }

            $('#changemsg').submit();

         }

         function approve(url, is_active) {
            if (is_active == '0') {
               var t = confirm('Are you sure you want to Active Product ?');
            } else {
               var t = confirm('Are you sure you want to Deactive Product  ?');
            }

            if (t) {
               window.location.href = url + "/" + is_active;
            } else {
               return false;
            }
         }

         function blockproduct(url, is_active) {
            if (is_active == '0') {
               var t = confirm('Are you sure you want to Block Product ?');
            } else {
               var t = confirm('Are you sure you want to Deactive Product  ?');
            }

            if (t) {
               window.location.href = url + "/" + is_active;
            } else {
               return false;
            }
         }
      </script>
      <?php include('include/sidebar_right.php'); ?>
   </div><!-- End #Main -->
   <?php include('include/footer.php') ?>
</body>

</html>