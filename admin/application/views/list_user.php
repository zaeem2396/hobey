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
          <li class="crumb-trail">User</li>
		  <li class="crumb-active"><a href="javascript:void(0);">User</a></li>
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
		<!--	<a href="<?php echo $base_url;?>user/add/" class="btn btn-alert pull-right"><i class="fa fa-plus"></i> Add User</a> -->
		
		</div>
		<div class="clearfix">&nbsp;</div>
			  
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>User Listing </span> </div>
            <div class="panel-body">
			  <form action="<?php echo $base_url."user/deletes";?>" method="post" enctype="multipart/form-data" id="form">
			  <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
   
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th><input name="checkAll" id="checkAll" type="checkbox"  class="minimal-red" ></th>
                    
                      <th>Name</th>
					 
					 
					  <th>Email Id</th>
            <th>Password</th>
					  <th>Mobile </th>
					  
					  <th>Status</th>
					  
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
					       
                          <td style="text-align:left"><?php echo $result[$i]['name'] ?></td>	
						 
						  <td style="text-align:left"><?php echo $result[$i]['email']; ?></td>	
              <td style="text-align:left"><?php echo $result[$i]['password']; ?></td>
						  <td><?php echo $result[$i]['mobile']; ?></td>
						 
						 <td>

					<select title="Approve" id="change_status_<?php echo $result[$i]['id']; ?>" onchange="javascript:approve('<?php echo $base_url."user/updatestatus/"; ?><?php echo $result[$i]['id']; ?>',this.value,<?php echo $result[$i]['status']; ?>,<?php echo $result[$i]['id']; ?>);" >

						

						<option value="0" <?php if($result[$i]['status']==0) { echo "selected"; } ?>>Active</option>

						<option value="1" <?php if($result[$i]['status']==1) { echo "selected"; } ?>>Deactive</option>	

						</select>

						</td>
						
                     <td><a class="btn bg-purple2" title="Edit" href="<?php echo $base_url."user/edit/"; ?><?php echo $result[$i]['id'];?>">
					<i class="fa fa-pencil"></i></a></td> 
					
        </tr>
				<?php
                  } 
                  } else {
					  echo 'No User Found';
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
		var t = confirm('Are you sure you want to Active User ?');	
			}
		else
		{
		var t = confirm('Are you sure you want to Deactive User ?');
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
 
     