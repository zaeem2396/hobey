<?php include('include/header.php'); ?>
<div id="main">
   <?php include('include/sidebar_left.php'); ?>
   <section id="content_wrapper">
      <div id="topbar">
         <div class="topbar-left">
            <ol class="breadcrumb">

               <li class="crumb-icon"><a href="<?php echo $base_url; ?>"><span class="glyphicon glyphicon-home"></span></a></li>
               <li class="crumb-active"><a href="#">Delivery Man Paybale Report</a></li>
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
               <form action="<?php echo $base_url . "reports_management/download_delpaybale"; ?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" value="<?php echo $startdate; ?>" id="startdate1" name="startdate">
                  <input type="hidden" value="<?php echo $enddate; ?>" id="enddate1" name="enddate">
                  <input class="submit btn btn-alert pull-right " type="submit" value="Download Report">
               </form>
            </div>
            <div class="clearfix">&nbsp;</div>
         </div>

         <div class="row">
            <div class="col-md-12">
               <div class="panel">
                  <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Delivery Man Paybale Report</span> </div>
                  <div class="panel-body">
                     <form action="<?php echo $base_url . "orders/deleteOrders"; ?>" method="post" enctype="multipart/form-data" id="form">
                        <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                        <div class="table-responsive vendorsales-scroll">
                           <table id="example1" class="table table-bordered table-striped">
                              <thead>
                                 <tr>
                                    <th>Delivery Man Name</th>
                                    <th>Amount Payabale to Delivery Man (Rs)</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 $i = 1;
                                 $total[$i] = '0';
                                 if ($alldeliveryman != '' && count($alldeliveryman) > 0) {
                                    foreach ($alldeliveryman as  $deliveryman) {
                                       $allorders = $this->reports_management_model->get_deliveryman_orders($deliveryman->id);
                                       foreach ($allorders as $order) {
                                          $total[$i] = $total[$i] + ($order->deliverypay * $order->product_quantity);
                                       }
                                       ?>
                                       <tr>
                                          <td style="text-align:left"><?php echo $deliveryman->name; ?></td>
                                          <td style="text-align:left"><?php echo number_format($total[$i], false, '', ''); ?></td>

                                    <?php $i++;
                                       }
                                    } ?>

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

   <div class="modal fade" id="create_label_modal" role="dialog">
      <div class="modal-dialog">

         <!-- Modal content-->
         <div class="modal-content" id="create_label_html">

         </div>

      </div>
   </div>

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

<!-- page script -->
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
      $("table").removeClass("dataTable");

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
<script type="text/javascript" src="<?php echo $base_url_views; ?>js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
   jQuery(document).ready(function() {
      "use strict";
      Core.init();
      Ajax.init();
      $('#startdate').datepicker()
      $('#enddate').datepicker()
   });

   function create_label(bookingid) {
      var itemid = bookingid;
      var url = '<?php echo $front_base_url; ?>home/delivered';
      jQuery.ajax({
         url: url,
         type: 'post',
         data: 'bookingid=' + bookingid,
         success: function(msg) {
            $('#create_label_html').html(msg);
            $('#create_label_modal').modal('show');
         }
      });

   }
</script>