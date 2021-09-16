<?php include('include/header.php');?>


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
          <li class="crumb-trail">Coupon</li>
		  <li class="crumb-active"><a href="javascript:void(0);">Coupon</a></li>
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
		<a href="javascript:void('0');" onclick="deletecountry();" class="btn btn-danger pull-right"  style="margin-left:10px"><i class="fa fa-trash-o"></i> Delete</a>
			<a href="<?php echo $base_url;?>coupan/add/" class="btn btn-alert pull-right"><i class="fa fa-plus"></i> Add Coupon</a>
		</div>
		<div class="clearfix">&nbsp;</div>
			  
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Coupon Listing </span> </div>
            <div class="panel-body">
			  <form action="<?php echo $base_url."coupan/deletes";?>" method="post" enctype="multipart/form-data" id="form">
			  <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
   
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
						 <th><input name="checkAll" id="checkAll" type="checkbox"  class="minimal-red" ></th>
                         <th>Coupon Name</th>
					     <th>Coupon Code</th>
                         <th>Discount</th>
                         <th>Coupon Value</th>
						 <th>Type</th>
						 <th>Start Date</th>
						 <th>End  Date</th> 
						 <th>Status</th>
						 <!--<th>Display In Front</th>-->
                      <th class="sorting" role="columnheader" aria-controls="table-2" style="width: auto;">Action</th>
                    </tr>
                  </thead>
     
				  
                  <tbody>
                <?php
                  if($result){
                    
					for($i=0;$i<count($result);$i++){
				?>
         <tr>
					<td><input name="selected[]" id="selected[]" value="<?php echo $result[$i]['id']; ?>" type="checkbox"  class="minimal-red"></td>
					       
                          <td style="text-align:left"><?php echo $result[$i]['name']; ?></td>	
						   <td style="text-align:left"><?php echo $result[$i]['code']; ?></td>	
                          <td><?php echo $result[$i]['discount']; ?></td>	
                          <td style="text-align:left"><?php if($result[$i]['value']  == '0' ) { echo "Percentage" ; } else { echo "Price" ;} ?></td>	
                          <td><?php if($result[$i]['type']=='1'){ echo "Shop" ; }else if($result[$i]['type'] == '2'){ echo "Workshop" ;}else{ echo 'Both'; } ?></td>	
						  <td><?php $strtotime =strtotime( $result[$i]['start_date'] );
							echo date('Y-m-d',$strtotime); ?></td>	
                          <td><?php $strtotimeed =strtotime( $result[$i]['end_date'] );
							echo date('Y-m-d',$strtotimeed); ?></td>
							
							
							<td>
					<select title="Approve" id="change_status_<?php echo $result[$i]['id']; ?>" onchange="javascript:approve('<?php echo $base_url."coupan/updatestatus/"; ?><?php echo $result[$i]['id']; ?>',this.value,<?php echo $result[$i]['enabled']; ?>,<?php echo $result[$i]['id']; ?>);" >
						
						<option value="1" <?php if($result[$i]['enabled']==1) { echo "selected"; } ?>>Active</option>
						<option value="0" <?php if($result[$i]['enabled']==0) { echo "selected"; } ?>>Deactive</option>	
						</select>
						</td>
						
							
						<!--	<td><?php if($result[$i]['enabled']=='1')
										{ 
										?>
												<a class="btn bg-purple2" title="Active" onclick="approve('<?php echo $base_url."coupan/updatestatus/"; ?><?php echo $result[$i]['id'];  ?>','0');" href="javascript:void(0);">
											<i>Active</i>
										</a>
										<?php
										}
										else
										{ 
										?><a class="btn bg-purple2" title="Deactive" onclick="approve('<?php echo $base_url."coupan/updatestatus/".$result[$i]['id'];  ?>','1');" href="javascript:void(0)">
											<i>Deactive</i>
										</a>
										<?php
										} ?>
									</td>	-->

									<!--	<td> 
							<input type="checkbox" id="set_home" name="set_home"  value="1" onclick="featured_product('<?php echo $result[$i]['id']; ?>',this);" <?php if($result[$i]['display_front'] == '1') { echo "checked"; } ?> >
						 </td>-->
						 
						
					
                        <td><a class="btn bg-purple2" title="Edit" href="<?php echo $base_url."coupan/edit/"; ?><?php echo $result[$i]['id'];?>">
					<i class="fa fa-pencil"></i></a></td>
					
        </tr>
				<?php
                  } 
                  } else {
					  echo 'No Coupon Found';
				  }
                ?>
				                 
                  </body>
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
function approve(url,is_active,oldVlaue,orderid){
  var box = document.getElementById('change_status_'+orderid);
		if(is_active=='0'){
		var t = confirm('Are you sure you want to Active Coupan ?');	
			}
		else
		{
		var t = confirm('Are you sure you want to Deactive Coupan ?');
				}
			
			if(t){
			window.location.href = url+"/"+is_active;
				} 
			else {
        box.value = oldVlaue;
				return false; 
				}
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
</script>
 
     
	  
<script>
 function featured_product(id,value)
 
 {
	 
		if(value.checked)
		{	
			var base_url = '<?php echo $base_url. 'coupan/featured_product';?>';
			window.location = base_url+"/"+id+"/1";				
		}
		else
		{
			
			var base_url = '<?php echo $base_url. 'coupan/featured_product';?>';
			window.location = base_url+"/"+id+"/0";
		}
	
 }
 </script>  
 
	 
	  <script>
 function updateorder(val,id){
			var t = confirm('Are you sure you want to Set order of Category');
			if(t){
				window.location.href='<?php echo $base_url;?>coupan/updateorder/'+id+'/'+val;
			}else {
				return false;
			}
		}
 </script>
 