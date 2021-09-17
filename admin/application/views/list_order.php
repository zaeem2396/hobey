<?php include('include/header.php'); ?>
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
               <li class="crumb-active"><a href="#">Order Management</a></li>
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
            <?php }
            ?>
            <?php if ($this->session->flashdata('flashError') != '') { ?>
               <div class="alert alert-danger alert-dismissable">
                  <i class="fa fa-warning"></i>
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <b>Error!</b> <?php echo $this->session->flashdata('flashError', 5); ?>
               </div>
            <?php }  ?>
            <div class="col-md-12">
               <form action="<?php echo $base_url . "orders/download_distiorder"; ?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" value="<?php echo $startdate; ?>" id="startdate1" name="startdate">
                  <input type="hidden" value="<?php echo $enddate; ?>" id="enddate1" name="enddate">
                  <input type="hidden" value="<?php echo $distributor_id; ?>" id="distributor_id1" name="distributor_id">
                  <input class="submit btn btn-alert pull-right " type="submit" value="Download Report">
               </form>
            </div>
            <!-- <div class="col-md-12">
            <a href="<?php echo $base_url; ?>orders/lists/SUCCESS" class="btn btn-alert pull-right" style="margin-left:10px"> Payment Success</a>
            <a href="<?php echo $base_url; ?>orders/lists/FAILED" class="btn btn-alert pull-right" style="margin-left:10px"> Payment Failed</a>
            
            <a href="<?php echo $base_url; ?>orders/lists/C" class="btn btn-alert pull-right" style="margin-left:10px"> Canceled</a>
            
            <a href="<?php echo $base_url; ?>orders/lists/D" class="btn btn-alert pull-right" style="margin-left:10px"> Delivered</a>
            
            <a href="<?php echo $base_url; ?>orders/lists/S" class="btn btn-alert pull-right" style="margin-left:10px"> Shipped</a>
            
            <a href="<?php echo $base_url; ?>orders/lists/P" class="btn btn-alert pull-right" style="margin-left:10px"> Pending</a>
            
            <a href="<?php echo $base_url; ?>orders/lists/" class="btn btn-alert pull-right" > All</a>
            
            </div> -->
            <div class="clearfix">&nbsp;</div>
            <!--
            <div class="col-md-12">
            	<a href="javascript:void('0');" onclick="deletecountry();" class="btn btn-danger pull-right"  style="margin-left:10px"><i class="fa fa-trash-o"></i> Delete</a>
            </div>
            -->
            <div class="clearfix">&nbsp;</div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <div class="panel">
                  <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-search"></span>Search Order </span> </div>
                  <div class="panel-body">
                     <form action="<?php echo $base_url . "orders/lists"; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group col-md-2 rpm sd">
                           <label for="categoryname">Start Date</label>
                           <input id="startdate" name="startdate" class="form-control" autocomplete="off" value="<?php echo $startdate; ?>" type="text" placeholder="Select Date" />
                           <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                        <div class="form-group col-md-2 rpm ed">
                           <label for="categoryname">End Date</label>
                           <input id="enddate" name="enddate" class="form-control" autocomplete="off" value="<?php echo $enddate; ?>" type="text" placeholder="Select Date" />
                           <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                        <div class="form-group col-md-2">
                           <label for="distributor_id">Distributor</label>
                           <select id="distributor_id" name="distributor_id" class="form-control">
                              <option selected value="">Select Distributor</option>
                              <?php if ($alldistributors != '') {
                                 foreach ($alldistributors as $distributorshow) { ?>
                                    <option value="<?php echo $distributorshow->id; ?>" <?php if ($distributor_id == $distributorshow->id) {
                                                                                                   echo "selected";
                                                                                                } ?>><?php echo $distributorshow->name; ?></option>
                              <?php }
                              } ?>
                           </select>
                        </div>

                        <div class="form-group col-md-1">
                           <label for="inputEmail" style="visibility:hidden">&nbsp;</label><br>
                           <input class="submit btn bg-purple2 " type="submit" value="Search" style="width:100%">
                        </div>
                        <div class="form-group col-md-1">
                           <label for="inputEmail" style="visibility:hidden">&nbsp;</label><br>
                           <a href="<?php echo $base_url; ?>orders/lists" class="submit btn bg-purple2" style="width:100%">Reset</a>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <div class="panel">
                  <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Order List</span> </div>
                  <div class="panel-body">
                     <form action="<?php echo $base_url . "orders/deleteOrders"; ?>" method="post" enctype="multipart/form-data" id="form">
                        <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                        <div class="table-responsive">
                           <table id="example1" class="table table-bordered table-striped">
                              <thead>
                                 <tr>
                                    <!-- <th>Select</th> -->
                                    <th>Order ID</th>
                                    <th>Order Date</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Amount</th>
                                    <!--<th>Payment Mode</th> -->
                                    <th>Payment Status</th>
                                    <th>Payment Transaction Id</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 if (isset($orders_list) and count($orders_list)) {
                                    foreach ($orders_list as $key => $orders) {
                                       ?>
                                       <tr>
                                          <!-- <td><input name="selected[]" id="selected[]" value="<?php echo $orders['order_id']; ?>" type="checkbox"  class="minimal-red"></td> -->
                                          <td><?php echo $orders['order_id']; ?></td>
                                          <td style="text-align:left"><?php
                                                                              $order_date = strtotime($orders['cdate']);
                                                                              echo $mysqldate = date('F d, Y', $order_date); ?></td>
                                          <td style="text-align:left"><?php echo $orders['user_name']; ?></td>
                                          <td style="text-align:left"><?php echo $orders['user_email']; ?></td>
                                          <td><?php echo $orders['phone_number']; ?></td>
                                          <td style="text-align:right">Rs. <?php echo number_format($orders['order_total'], false, '', ''); ?></td>
                                          <!-- <td> 
                                    <?php
                                          if ($orders['paymentmode'] == '1') {
                                             echo 'Cash On Delivery';
                                          } elseif ($orders['paymentmode'] == '2') {
                                             echo 'Online Payment';
                                          } ?>
                                    </td> -->
                                          <td>
                                             <?php /* if($orders['payment_status'] == '1'){ ?> 
										<span style="color:green;">Paid</span> 
									<?php } else { ?> <span style="color:red;">Failed</span> <?php } */ ?>
                                             <?php echo $orders['payment_status']; ?>
                                          </td>
                                          <td><?php echo $orders['transactionid']; ?></td>

                                          <!-- <td> <?php if ($orders['order_status'] == 'P') {
                                                               echo 'Pending';
                                                            } else if ($orders['order_status'] == 'R') {
                                                               echo 'Processing';
                                                            } else if ($orders['order_status'] == 'S') {
                                                               echo 'Shipped';
                                                            } else if ($orders['order_status'] == 'D') {
                                                               echo 'Delivered';
                                                            } else {
                                                               echo 'Canceled';
                                                            }
                                                            ?> 
                                    </td>  -->
                                          <td class="text-center">
                                             <a class="btn bg-purple2" href="<?php echo $base_url . 'orders/detail/' . $orders['order_id'] ?>" title="Detail">
                                                <i class="fa fa-eye">Details</i>
                                             </a>
                                          </td>
                                       </tr>
                                 <?php
                                    }
                                 } else {
                                    //echo 'No Orders Available.';
                                 }



                                 ?>
                              </tbody>
                           </table>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="clearfix"></div>
         </div>
      </div>
   </section>
   <?php include('include/sidebar_right.php'); ?>
</div>
<!-- End #Main -->
<?php include('include/footer.php') ?>


<!-- DATA TABES SCRIPT -->
<link href="<?php echo $base_url_views; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $base_url_views; ?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo $base_url_views; ?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<link href="<?php echo $base_url_views; ?>plugins/iCheck/minimal/_all.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $base_url_views; ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<!-- <script src="https://cdn.datatables.net/plug-ins/1.10.25/pagination/input.js" type="text/javascript"></script> -->

<!-- page script -->
<script type="text/javascript" src="<?php echo $base_url_views; ?>js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
   $(function() {
      $('#example1').dataTable({
         "bPaginate": true,
         "bLengthChange": true,
         "bFilter": true,
         "bSort": true,
         "bInfo": true,
         "bAutoWidth": false,
         "bStateSave": true,
         //   "pagingType": "input",
         "fnStateSave": function(oSettings, oData) {
            localStorage.setItem('offersDataTables', JSON.stringify(oData));
         },
         "fnStateLoad": function(oSettings) {
            return JSON.parse(localStorage.getItem('offersDataTables'));
         }
      });

      $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
         checkboxClass: 'icheckbox_minimal-red',
         radioClass: 'iradio_minimal-red'
      });
      //$("table").removeClass("dataTable");
      $('#startdate').datepicker();
      $('#enddate').datepicker();
   });
</script>


<script>
   function deletecountry() {
      var checked = $("#form input:checked").length > 0;
      if (!checked) {
         alert("Please select at least one record to delete");
         return false;
      } else {
         var conf = confirm("Do you want to delete?");
         if (conf == true) {
            $('#form').submit();
            return true;
         } else {
            return false;
         }

      }

   }

   function statust(order_id, status) {
      var conf = confirm("Are you sure want to change Status ?");
      if (conf == true) {
         var base_url = '<?php echo $base_url . 'orders/changeStatusmail'; ?>';
         window.location = base_url + "/" + order_id + "/" + status;
         return true;
      } else {
         return false;
      }

   }
</script>