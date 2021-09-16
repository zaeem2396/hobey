<?php include('include/header.php');?>
<div id="main">
 <?php include('include/sidebar_left.php');?>
  <section id="content_wrapper">
   <div id="topbar">
      <div class="topbar-left">
         <ol class="breadcrumb">
            
            <li class="crumb-icon"><a href="<?php echo $base_url; ?>"><span class="glyphicon glyphicon-home"></span></a></li>
           <li class="crumb-active"><a href="#">Vendor Sales</a></li>
         </ol>
      </div>
   </div>
   <div id="content">
      <div class="row">
         <?php if($this->session->flashdata('L_strErrorMessage'))
            { ?>
         <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <b>Success!</b> <?php echo $this->session->flashdata('L_strErrorMessage',5); ?>
         </div>
         <?php }
            ?>
         <?php if($this->session->flashdata('flashError')!='') { ?>
         <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-warning"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <b>Error!</b> <?php echo $this->session->flashdata('flashError',5); ?>
         </div>
         <?php }  ?>
         <div class="col-md-12">
            <form action="<?php echo $base_url."reports_management/download_report";?>" method="post" enctype="multipart/form-data">
               <input type="hidden" value="<?php echo $startdate; ?>" id="startdate1" name="startdate">	
               <input type="hidden" value="<?php echo $enddate; ?>" id="enddate1" name="enddate">	
               <input type="hidden" value="<?php echo $status; ?>" id="status" name="status">	
               <input type="hidden" value="<?php echo $product; ?>" id="product" name="product">
               <input type="hidden" value="<?php echo $vendor; ?>" id="vendor" name="vendor">
               <input class="submit btn btn-alert pull-right " type="submit" value="Download Report">	
               <!--<a href="#" onclick="download_report();" class="btn btn-alert pull-right"><i class="fa fa-plus"></i> Download Report</a> -->
            </form>
         </div>
         <div class="clearfix">&nbsp;</div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="panel">
               <div class="panel-heading"> <span class="panel-title" > <span class="glyphicon glyphicon-search"></span>Search Vendor Sales  </span> </div>
               <div class="panel-body">
                  <form action="<?php echo $base_url."reports_management/vendororder";?>" method="post" enctype="multipart/form-data">
                     <div class="form-group col-md-2 rpm sd">
                        <label for="categoryname">Start Date</label>
                        <input id="startdate" name="startdate" class="form-control" autocomplete="off" value="<?php echo $startdate; ?>" type="text" placeholder="Select Date" />
						<i class="fa fa-calendar" aria-hidden="true"></i>
                     </div>
                     <div class="form-group col-md-2 rpm ed">
                        <label for="categoryname">End Date</label>
                        <input id="enddate" name="enddate" class="form-control" autocomplete="off" value="<?php echo $enddate; ?>" type="text" placeholder="Select Date"/>
						<i class="fa fa-calendar" aria-hidden="true"></i>
                     </div>
                     <div class="form-group col-md-2">
                        <label for="inputEmail">Order Status</label>
                        <select  id="status" name="status" class="form-control" >
                           <option selected value="">Select Status</option>
                           <option value="0" <?php if($status == '0'){ ?> selected='selected' <?php } ?>>Pending</option>
                           <option value="1" <?php if($status == '1'){ ?> selected='selected' <?php } ?>>Package Created</option>
                           <option value="2" <?php if($status == '2'){ ?> selected='selected' <?php } ?>>Dispatched</option>
						   <option value="3" <?php if($status == '3'){ ?> selected='selected' <?php } ?>>Delivered</option>
                        </select>
                     </div>
                     <div class="form-group col-md-2">
                        <label for="inputEmail">All Products</label>
                        <select name="product" class="form-control">
                           <option selected value="">Select Products</option>
                           <?php if($allvendorproducts != '' && count($allvendorproducts) > 0) {
                              foreach($allvendorproducts as $productss){ ?>
                           <option value="<?php echo $productss->id; ?>" <?php if($product == $productss->id){ ?> selected='selected' <?php } ?>><?php echo $productss->name; ?></option>
                           <?php }
                              } ?>
                        </select>
                     </div>
                     <div class="form-group col-md-2">
                        <label for="inputEmail">All Vendors</label>
                        <select name="vendor" class="form-control">
                           <option selected value="">Select Vendor</option>
                           <?php if($allvendor != '' && count($allvendor) > 0) {
                              foreach($allvendor as $product){ ?>
                           <option value="<?php echo $product->id; ?>" <?php if($vendor == $product->id){ ?> selected='selected' <?php } ?>><?php echo $product->company_name; ?></option>
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
                        <a href="<?php echo $base_url;?>reports_management/vendororder" class="submit btn bg-purple2" style="width:100%"/>Reset</a>
                     </div>
                     <!-- <div class="form-group col-md-3">
                        <label for="categoryname">Total Orders :</label> <?php echo $totalorder; ?>
                        </div>
                        
                        <div class="form-group col-md-3">
                        <label for="categoryname">Total Amount : Rs.</label> <?php echo $ordertotal; ?>
                        </div> -->
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="panel">
               <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Vendor Sales List</span> </div>
               <div class="panel-body">
                  <form action="<?php echo $base_url."orders/deleteOrders";?>" method="post" enctype="multipart/form-data" id="form">
                     <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
                     <div class="table-responsive vendorsales-scroll">
                        <table id="example1" class="table table-bordered table-striped">
                           <thead>
                              <tr>
							  	 <th>Order Id</th>
                                 <th>Vendor Item Id</th>
                                 <th>Product Name</th>
                                 <th>Vendor Name</th>
								 <th>Customer Name</th>
								 <th>Customer Email</th>
								 <th>Customer Mobile</th>
                                 <th>Order Date</th>
                                 <th>Product Variant</th>
                                 <th>Vendor Status</th>
                                 <th>Delivery Status</th>
                                 <th>Delivery Booking Id</th>
								 <th>Cancel Order</th>
								 <th>Quantity</th>
                                 <th>Price</th>
                                 
                                 <!--<th>Action</th>-->
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 $total = '0'; 
                                  if($salesreports!='' && count($salesreports) > 0) {
                                 foreach($salesreports as  $prd)
                                 {	
                                  $get_vendor_name= $this->reports_management_model->get_vendor_name($prd->vendor_id);
                                 ?>
                              <tr>
							  	 <td><?php echo $prd->order_id; ?></td>
                                 <td><?php echo $prd->order_item_id; ?></td>
                                 <td style="text-align:left"><?php echo $prd->order_item_name; ?></td>
                                 <td style="text-align:left"><?php echo $get_vendor_name; ?></td>
                                 <td style="text-align:left"><?php echo $prd->first_name." ".$prd->last_name; ?></td>
                                 <td style="text-align:left"><?php echo $prd->email; ?></td>
                                 <td><?php echo $prd->phone_number; ?></td>
                                 <td><?php echo date('d/m/Y',strtotime($prd->cdate)); ?></td>
                                 
                                 <td style="text-align:left"><?php echo $prd->size_name; ?></td>
                                 <td style="text-align:left"><?php if($prd->vendor_accept == '0')
                                    { echo 'Pending'; }
                                    else if($prd->vendor_accept == '1')
                                    { echo 'Vendor Accepted'; }
                                    else if($prd->vendor_accept == '2')
                                    {	
										if($prd->admin_cancel == '1')	
										{	
											echo 'Admin Cancelled';
											
											} else {
											echo 'Vendor Rejected';
										}
										
									}    
                                    ?></td>
								 <td style="text-align:left"><?php if($prd->packstatus == '1')
                                    { echo 'Package Created'; }
                                    else if($prd->packstatus == '2')
                                    { echo 'Dispatched'; }
									else if($prd->packstatus == '3')
                                    { echo 'Delivered'; }
                                    else if($prd->packstatus == '0')
                                    { echo 'Pending'; }    
                                    ?>
								 </td>
								
								 <td><!-- a onclick="create_label('<?php echo $prd->api_booking_id; ?>');" href="javascript:void(0);" data-toggle="modal"><?php echo $prd->api_booking_id; ?></a-->
								 <?php if(!empty($prd->api_booking_id)) { ?>
								 <a href="<?php echo $base_url; ?>orders/vendordetail/<?php echo $prd->order_item_id; ?>/<?php echo $prd->api_booking_id; ?>" class="btn btn-default"><?php echo $prd->api_booking_id; ?></a>
								 <?php } else {?>
								  <a href="<?php echo $base_url; ?>orders/vendordetail/<?php echo $prd->order_item_id; ?>/<?php echo $prd->api_booking_id; ?>" ><?php echo $prd->api_booking_id; ?></a>
								 <?php } ?>
								 </td>
								  <td><a href="<?php echo $base_url; ?>reports_management/rejectorder/<?php echo $prd->order_item_id; ?>/<?php echo $prd->vendor_id; ?>" class="btn btn-default" onclick="return confirm('Are you sure you want to cancel order?')">Cancel Order</a>
								 </td>
								 <td><?php echo $prd->product_quantity; ?></td>
                                 <td style="text-align:right"><?php echo round($prd->product_item_price*$prd->product_quantity); ?></td>
                                
                              </tr>
                              <?php $total = $total + ($prd->product_item_price*$prd->product_quantity); 
                                 } ?> 
                              <!-- tr>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>Total Amount: </td>
                                 <td><?php echo round($total); ?></td>
                                 </tr-->
                              <?php } else { ?>
                              <tr>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td style="width:150px;float: left;">No Records Found</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                              </tr>
                              <?php } ?>
                           </tbody>
                           <?php if($salesreports!='' && count($salesreports) > 0) { ?>
                           <tfoot>
                              <tr>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>&nbsp;</td>
                                 <td>Total Amount: </td>
                                 <td>&#8377; <?php echo round($total); ?></td>
                                 <td>&nbsp;</td>
								 <td>&nbsp;</td>
								 <td>&nbsp;</td>
								 <td>&nbsp;</td>
								 <td>&nbsp;</td>
                              </tr>
                              </tbody>
                              <?php } ?>
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

  <?php include('include/sidebar_right.php');?>
 </div>
<!-- End #Main -->
<?php include('include/footer.php')?>


<!-- DATA TABES SCRIPT -->
	<link href="<?php echo $base_url_views; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $base_url_views; ?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo $base_url_views; ?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
	<link href="<?php echo $base_url_views; ?>plugins/iCheck/minimal/_all.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $base_url_views; ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>

 <!-- page script -->
    <script type="text/javascript">
      $(function () {
       $('#example1').dataTable({
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false,
          "rowReorder": true,
          "bStateSave"  : true,
		  "stateSave"  : true,	
          "aaSorting": [],
		  "pageLength": 50
        });

	   $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });

      });
    </script>


<script>
function deletecountry(){
	var checked = $("#form input:checked").length > 0;
    if (!checked)
	{
        alert("Please select at least one record to delete");
        return false;
    }
	else
	{
		var conf = confirm("Do you want to delete?");
		if(conf == true){
			$('#form').submit();
			return true;
		}else{
			return false;
		}

	}

    }
function statust(order_id,status)
{
		var conf = confirm("Are you sure want to change Status ?");
		if(conf == true){
		var base_url = '<?php echo $base_url.'orders/changeStatusmail'; ?>';
				window.location = base_url+"/"+order_id+"/"+status;
		return true;
		}else{
			return false;
		}
	
}	
</script>
<script type="text/javascript" src="<?php echo $base_url_views; ?>js/bootstrap-datepicker.js"></script> 
<script type="text/javascript">
jQuery(document).ready(function () {
	  "use strict";
     Core.init();     
     Ajax.init();     
	 $('#startdate').datepicker()
	 $('#enddate').datepicker()
     });

function create_label(bookingid)
{
	var itemid = bookingid;
	var url ='<?php echo $front_base_url; ?>home/delivered';
		jQuery.ajax({
		url:url,
		type:'post',
		data:'bookingid='+bookingid,
		success:function(msg)
		{	
			 $('#create_label_html').html(msg);	
			 $('#create_label_modal').modal('show');
		}
	  });
	  
}
</script>

