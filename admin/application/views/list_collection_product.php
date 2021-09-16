<?php include('include/header.php');?>
<!-- Start: Main -->
<div id="main"> 
 <?php include('include/sidebar_left.php');?>
 <style>
.table-responsive .switch {
    position: relative;
    display: inline-block;
    width: 46px;
    height: 25px;
}
.table-responsive .slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: -4px;
    bottom: 3px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}
.table-responsive input:checked + .slider {
    background-color: #055b57;
}
 </style>
  <!-- Start: Content -->
  <!-- Start: Content -->
  <section id="content_wrapper">
    <div id="topbar">
      <div class="topbar-left">
        <ol class="breadcrumb">
         
          <li class="crumb-icon"><a href="<?php echo $base_url; ?>"><span class="glyphicon glyphicon-home"></span></a></li>         
          <li class="crumb-trail">Collection Product</li>
		   <li class="crumb-active"><a href="javascript:void(0);">Collection Product</a></li>
        </ol>
      </div>
    </div>
    <div id="content">
      
      <div class="row">
                
<?php if($this->session->flashdata('L_strErrorMessage')){ ?>
		  <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Success!</b> <?php echo $this->session->flashdata('L_strErrorMessage',5); ?>
			</div>         
  <?php } ?>


<?php if($this->session->flashdata('flashError')!=''){ ?>
<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-warning"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Error!</b> <?php echo $this->session->flashdata('flashError',5); ?>
                                    </div>
<?php }  ?>


		<div class="col-md-12">
		<a href="javascript:void('0');" onclick="deletecountry();" class="btn btn-danger pull-right"  style="margin-left:10px"><i class="fa fa-trash-o"></i> Delete</a>
		
		<a href="<?php echo $base_url;?>collection_product/add/" class="btn btn-alert pull-right"><i class="fa fa-plus"></i> Add Collection Product</a>
    <a style="margin:0px 14px 0 0;" class="btn bg-purple2 pull-right"
                        href="<?php echo $base_url; ?>collection_product/xlsuploadcproducts/">
                        <i class="fa fa-plus"></i> Upload Collection Products
                    </a>
		
		</div>
		<div class="clearfix">&nbsp;</div>

		    
      <div class="row">
        <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Collection Product Listing </span> </div>
            <div class="panel-body">
			  <form action="<?php echo $base_url."collection_product/deletes";?>" method="post" enctype="multipart/form-data" id="form">
			  <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
   
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                    <th><input name="checkAll" id="checkAll" type="checkbox"  class="minimal-red" ></th>
                      <th>Product Name</th>
                      <th>Vendor Name</th>
                      <th>Unit</th>
                      <th>MRP</th>
                      <th>Special Price</th>
                      <th>Distributor buying price</th>
                      <th>Quantity</th>
                      <th class="sorting" role="columnheader" aria-controls="table-2" style="width: auto;">Action</th>
                    </tr>
                  </thead>
     
				  
                  <tbody>
                <?php if($result){ for($i=0;$i<count($result);$i++){ ?>
         <tr>
         <td><input name="selected[]" id="selected[]" value="<?php echo $result[$i]['id']; ?>" type="checkbox"  class="minimal-red checkDelete" <?php if($result[$i]['is_deleted']==1) { ?> disabled <?php }?>></td>
					     <td style="text-align:left"><?php echo $result[$i]['material_name']; ?></td>
					     <td style="text-align:left"><?php echo $result[$i]['vendorname']; ?></td>
               <td style="text-align:left"><?php echo $result[$i]['weight']; ?></td>
               <td style="text-align:left"><?php echo $result[$i]['mrp']; ?></td>
               <td style="text-align:left"><?php echo $result[$i]['price']; ?></td>
               <td style="text-align:left"><?php echo $result[$i]['d_buy_price']; ?></td>
               <td style="text-align:left"><?php echo $result[$i]['quantity']; ?></td>
						 
						 
						 <!-- <td>
							<select title="Approve" onchange="javascript:approve('<?php echo $base_url."collection_product/updatestatus/"; ?><?php echo $result[$i]['id']; ?>',this.value);" >
								<option value="0" <?php if($result[$i]['status']==0) { echo "selected"; } ?>>Active</option>
								<option value="1" <?php if($result[$i]['status']==1) { echo "selected"; } ?>>Deactive</option>
							</select>
						</td> -->
					    
          <td>  
                        <?php if($result[$i]['is_deleted']==1) { ?><span style="color:red;">Deleted</span><?php } else { ?> <a class="btn bg-purple2" title="Edit" href="<?php echo $base_url."collection_product/edit/"; ?><?php echo $result[$i]['id'];?>"><i class="fa fa-pencil"></i></a> <?php } ?>
                       </td>
					
        </tr>
				<?php }   } else { //echo 'No Product Found'; 
				} ?>           
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
	<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $base_url_views; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $base_url_views; ?>plugins/iCheck/minimal/_all.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css">
	
    <script src="<?php echo $base_url_views; ?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo $base_url_views; ?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
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
		  "pageLength": 50,
        });
		
	   $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
		
      });
    </script>
      

<script>
function approve(url,is_active){
		if(is_active=='0'){
		var t = confirm('Are you sure you want to Active Product ?');	
			}
		else
		{
		var t = confirm('Are you sure you want to Deactive Product  ?');
				}
			
			if(t){
			window.location.href = url+"/"+is_active;
				} 
			else {
				return false; 
				}
}
function blocked(url,is_active){
		if(is_active=='0'){
		var t = confirm('Are you sure you want to unblocked Product ?');	
			}
		else
		{
		var t = confirm('Are you sure you want to blocked Product ?');
				}
			
			if(t){
			window.location.href = url+"/"+is_active;
				} 
			else {
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
				
				var base_url = '<?php echo $base_url. 'collection_product/featured_product';?>';
				window.location = base_url+"/"+id+"/1";				
			}
			else
			{
				
				var base_url = '<?php echo $base_url. 'collection_product/featured_product';?>';
				window.location = base_url+"/"+id+"/0";
			}
		
	 }
	 
	 </script>