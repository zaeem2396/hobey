<?php include('include/header.php');?>
<div id="main">
 <?php include('include/sidebar_left.php');?>
  <section id="content_wrapper">
   <div id="topbar">
      <div class="topbar-left">
         <ol class="breadcrumb">
            
            <li class="crumb-icon"><a href="<?php echo $base_url; ?>"><span class="glyphicon glyphicon-home"></span></a></li>
           <li class="crumb-active"><a href="#">Amount Reconcilation Report</a></li>
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
            <form action="<?php echo $base_url."reports_management/download_reconcilation";?>" method="post" enctype="multipart/form-data">
               <input type="hidden" value="<?php echo $sstartdate; ?>" id="startdate1" name="sstartdate">	
               <input type="hidden" value="<?php echo $senddate; ?>" id="enddate1" name="senddate">	
               <input class="submit btn btn-alert pull-right " type="submit" value="Download Report">
            </form>
         </div>
         <div class="clearfix">&nbsp;</div>
      </div>
      <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading"> <span class="panel-title"> <span
                                        class="glyphicon glyphicon-search"></span>Search Report </span> </div>
                            <div class="panel-body">
                                <form action="<?php echo $base_url."reports_management/amount_reconcilation_report";?>" method="post"
                                    enctype="multipart/form-data" id="searchForm">
                                    <div class="form-group col-md-2 rpm sd">
                                        <label for="categoryname">Start Date</label>
                                        <input id="startdate" name="sstartdate" class="form-control" autocomplete="off"
                                            value="<?php echo $sstartdate; ?>" type="text" placeholder="Select Date" />
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                    <div class="form-group col-md-2 rpm ed">
                                        <label for="categoryname">End Date</label>
                                        <input id="enddate" name="senddate" class="form-control" autocomplete="off"
                                            value="<?php echo $senddate; ?>" type="text" placeholder="Select Date" />
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail" style="visibility:hidden">&nbsp;</label><br>
                                        <input class="submit btn bg-purple2 " type="submit" value="Search" onclick="javascript:validate();return false;"
                                            style="width:100%">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="inputEmail" style="visibility:hidden">&nbsp;</label><br>
                                        <a href="<?php echo $base_url;?>reports_management/amount_reconcilation_report" class="submit btn bg-purple2"
                                            style="width:100%">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
      <div class="row">
         <div class="col-md-12">
            <div class="panel">
               <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Amount Reconcilation Report</span> </div>
               <div class="panel-body">
                  <form action="<?php echo $base_url."orders/deleteOrders";?>" method="post" enctype="multipart/form-data" id="form">
                     <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
                     <div class="table-responsive vendorsales-scroll">
                        <table id="" class="table table-bordered table-striped">
                           <thead>
                              <tr>
                                 <th style="text-align:left">Sr. No</th>
								         <th style="text-align:left">Date</th>
                                 <th style="text-align:left">Txn Type</th>
                                 <th style="text-align:left">Payer</th>
                                 <th style="text-align:left">Payee</th>
                                 <th style="text-align:left">Order ID</th>
                                 <th style="text-align:left">Txn No</th>
                                 <th style="text-align:left">Amount (+/-)</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                             //echo "<pre>";print_r($orders_list);echo "</pre>";


                             if($sstartdate != '' and $senddate != ''){
                             $startdate = date('Y-m-d', strtotime($senddate));
                              $enddate = date('Y-m-d', strtotime($sstartdate));
                             }else{
                              $startdate = date('Y-m-d');
                              $enddate = date('Y-m-d', strtotime('-7 days'));
                             }
                                 
                                 $counter=1; 
                                while ($enddate <= $startdate){
                                 $data['startdate'] = $enddate;
                                 $data['enddate'] = $enddate;
                                 $orders_list = $this->reports_management_model->getOrdersreport($id='',$data);
                                 $allblclpayments = $this->reports_management_model->allblclpayments($data);
                                 //echo "<pre>";print_r($allblclpayments);echo "</pre>";

                                     
                                      if (isset($orders_list['order_list']) and count($orders_list['order_list'])) {
                                         foreach ($orders_list['order_list'] as $key => $orders) {
                                            $txnType = '';
                                            $payer = '';
                                            $payee = '';
     
                                            if($orders['is_customer'] == 0){
                                               $txnType = 'Distributor to Vendor';
                                               $payer = $orders['user_name'];
                                               $payee = $this->reports_management_model->get_vendor_name($orders['vendor_id']);
                                            }
                                            if($orders['is_customer'] == 1){
                                               $txnType = 'Customer to Distributor';
                                               $payer = $orders['user_mobile'];
                                               $payee = $this->reports_management_model->get_vendor_name($orders['distributor_id']);
                                            }
                                           
                                            ?>
                                   <tr>
                                   <td style="text-align:left"><?php echo $counter; ?></td>
                                   <td style="text-align:left"><?php $order_date = strtotime( $orders['cdate'] ); echo $mysqldate = date( 'F d, Y', $order_date );?></td>
                                   <td style="text-align:left"><?php echo $txnType; ?></td>
                                   <td style="text-align:left"><?php echo $payer; ?></td>
                                   <td style="text-align:left"><?php echo 'BPCL, '.$payee; ?></td>
                                   <td style="text-align:left"><?php echo $orders['order_id']; ?></td>
                                   <td style="text-align:left"><?php echo $orders['transactionid']; ?></td>
                                   <td style="text-align:left"><?php echo '+ '.$orders['sub_total']; ?></td>
                                         </tr> 
                                       
                                   <?php 
                                   $totalPlus += $orders['sub_total'];
                                   $counter++; } }  

                                    if (isset($allblclpayments) and count($allblclpayments)) {
                                    foreach ($allblclpayments as $key => $payment) {
                                    $txnType = '';
                                    $payer = 'BPCL';
                                    $payee = $this->reports_management_model->get_vendor_name($payment->user_id);
                                    if($payment->user_vendor == 1){
                                       $txnType = 'BPCL to Vendor';
                                    }
                                    if($payment->user_vendor == 2){
                                       $txnType = 'BPCL to Distributor';
                                    }
                                    if($payment->user_vendor == 3){
                                       $txnType = 'BPCL to Delivery man';
                                    }
                                    ?>
                                       <tr>
                                    <td style="text-align:left"><?php echo $counter; ?></td>
                                    <td style="text-align:left"><?php $order_date = strtotime( $payment->pdate ); echo $mysqldate = date( 'F d, Y', $order_date );?></td>
                                    <td style="text-align:left"><?php echo $txnType; ?></td>
                                    <td style="text-align:left"><?php echo $payer; ?></td>
                                    <td style="text-align:left"><?php echo $payee; ?></td>
                                    <td style="text-align:left"></td>
                                    <td style="text-align:left"></td>
                                    <td style="text-align:left"><?php echo '- '.$payment->amount; ?></td>
                                    </tr> 
                                    <?php 
                                    $totalMinus += $payment->amount;
                                    $counter++; } }

                                  $enddate = date('Y-m-d', strtotime($enddate. '+1 days')); 
                                  }
                                 ?>
                               
                               <tr>
                                   <td style="text-align:left;font-weight:bold;">Total</td>
                                   <td style="text-align:left"></td>
                                   <td style="text-align:left"></td>
                                   <td style="text-align:left"></td>
                                   <td style="text-align:left"></td>
                                   <td style="text-align:left"></td>
                                   <td style="text-align:left"></td>
                                   <td style="text-align:left;font-weight:bold;"><?php echo $totalPlus-$totalMinus;?></td>
                                         </tr> 

                                
                              
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

function validate(){

var startdate = $("#startdate").val();

if(startdate == ''){
   alert('Please Enter Start Date');
   return false;
}
var enddate = $("#enddate").val();

if(enddate == ''){
   alert('Please Enter End Date');
   return false;
}

$('#searchForm').submit();

}
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

