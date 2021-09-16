<?php include('include/header.php');?>
<style>
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<!-- Start: Main -->
<div id="main">

 <?php include('include/sidebar_left.php');?>
  <!-- Start: Content -->
  <!-- Start: Content -->
  <section id="content_wrapper">
    <div id="topbar">
      <div class="topbar-left">
        <ol class="breadcrumb">
          
          <li class="crumb-icon"><a href="<?php echo $base_url; ?>"><span class="glyphicon glyphicon-home"></span></a></li>
          <li class="crumb-trail">Reviews</li>
		  <li class="crumb-active"><a href="#">Reviews Management</a></li>
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


<!-- <div class="col-md-12">
<a href="<?php echo $base_url;?>orders/lists/SUCCESS" class="btn btn-alert pull-right" style="margin-left:10px"> Payment Success</a>
<a href="<?php echo $base_url;?>orders/lists/FAILED" class="btn btn-alert pull-right" style="margin-left:10px"> Payment Failed</a>

<a href="<?php echo $base_url;?>orders/lists/C" class="btn btn-alert pull-right" style="margin-left:10px"> Canceled</a>

<a href="<?php echo $base_url;?>orders/lists/D" class="btn btn-alert pull-right" style="margin-left:10px"> Delivered</a>

<a href="<?php echo $base_url;?>orders/lists/S" class="btn btn-alert pull-right" style="margin-left:10px"> Shipped</a>

<a href="<?php echo $base_url;?>orders/lists/P" class="btn btn-alert pull-right" style="margin-left:10px"> Pending</a>

<a href="<?php echo $base_url;?>orders/lists/" class="btn btn-alert pull-right" > All</a>

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
            <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Reviews List</span> </div>
            <div class="panel-body">
			  <form action="<?php echo $base_url."orders/deleteOrders";?>" method="post" enctype="multipart/form-data" id="form">
			  <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">

              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
						<th>Select</th>
						<th>Product</th>
						<th>Star Rating</th>
						<th>Description</th>
						<th>User Name</th>
						<th>Added Date</th>
						<th>Status</th>
					</tr>
                  </thead>

                  <tbody>
                <?php
                  if (isset($orders_list) and count($orders_list)) {
					//  print_r($orders_list); die;
					foreach ($orders_list as $key => $orders) {
				?>
				<tr>
					<td><input name="selected[]" id="selected[]" value="<?php echo $orders['order_id']; ?>" type="checkbox"  class="minimal-red"></td>
					<td style="text-align:left"><?php echo $orders['material_name']; ?></td>
					<td ><?php echo $orders['rating']; ?></td>
					<td style="text-align:left"><?php echo $orders['description']; ?></td>
					<td style="text-align:left"><?php echo $orders['name']; ?></td>
					<td style="text-align:left"><?php
							$order_date = strtotime( $orders['added_date'] );
									echo $mysqldate = date( 'F d, Y', $order_date );?></td>
 				 
 					
 					<td><label class="switch">
                                  <input type="checkbox" id="status<?php echo $orders['id']; ?>" value="1" onchange="javascript:approve('<?php echo $base_url."reviews/updatestatus/"; ?><?php echo $orders['id']; ?>',<?php echo $orders['id']; ?>);" <?php if($orders['is_approved'] =='1'){ ?> checked <?php }  ?> >
                                  <span class="slider round"></span>
                                </label></td>
 					</td>
 				</tr>
				<?php
                    }
                  } else { ?>
				   <!-- div class="text-center">
					  <h3><?php echo 'No Orders Available'; ?></h3>
					  
					</div -->	  
				  <?php }
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
          "bAutoWidth": false
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
    
     function approve(url,is_active){
        if($('#status'+is_active).is(":checked")){
           var is_active_status = 1;
        }
		else if($('#status'+is_active).is(":not(:checked)")){
          var is_active_status = 0;
        }
		if(is_active_status=='1'){
			var t = confirm('Are you sure you want to approve reviews?'); 
		}
		else
		{
			var t = confirm('Are you sure you want to disapprove reviews?');
		}

		if(t){
				$.ajax({
					url:url+"/"+is_active_status,
					type:'post',
					//data:'cid='+sid,
					success:function(msg)
					{
						/* document.getElementById('prod2').innerHTML = msg ;
						$('.dropdown2').on('change', function () {
							var table = $('.table-responsive1 table').DataTable();
							table.columns(4).search( this.value ).draw();
						}); */
					}
					});
		
				///window.location.href = url+"/"+is_active;
		}else
		{
			if(is_active_status=='0'){
				$('#status'+is_active). prop("checked", false);	
			}else{
				$('#status'+is_active). prop("checked", true);	
			}
			return false;
		}
    }	
</script>

