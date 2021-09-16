<?php include('includes/header.php');?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap.min.css">
<section class=" login-reg">
    <div class="container">
        <div class="row">
            	<div class="login-main">
		        	<div class="login">

		        		<?php if($this->session->flashdata('product_succsess'))
                     { ?>
                  <div class="alert alert-success alert-dismissable">
                     <i class="fa fa-check"></i>
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     <b>Success!</b> <?php echo $this->session->flashdata('product_succsess'); ?>
                  </div>
                  <?php }   ?>
                  <?php if($this->session->flashdata('flashError')!='') { ?>
                  <div class="alert alert-danger alert-dismissable">
                     <i class="fa fa-warning"></i>
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     <b>Error!</b> <?php echo $this->session->flashdata('flashError'); ?>
                  </div>
                  <?php }  ?>
                  <div id="validator"  class="alert alert-danger alert-dismissable" style="display:none;">
                     <i class="fa fa-warning"></i>
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     <b>Error &nbsp; </b><span id="error_msg1"></span>
                  </div>

		        		<div class="col-md-12">
			
			<a href="<?php echo $base_url;?>add-product" class="sub-btn pull-right"> Add </a>

			<a href="javascript:void(0);" onclick="deleteproduct();" class="sub-btn pull-right">Delete</a>

		</div>
		<div class="clearfix">&nbsp;</div>

			       <div class="row">
        <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> Product Listing </span> </div>
            <div class="panel-body">
			  <form action="<?php echo $base_url."vendor/delete_product";?>" method="post" enctype="multipart/form-data" id="form">
			  <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
   
              <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th><!-- <input name="checkAll" id="checkAll" type="checkbox"  class="minimal-red" > --></th>
					 
					  <th>Material Type</th>
					  <th>Material Name</th>
					  <th>Material Code</th>

					  <th class="text-center">Edit</th>                      
                    </tr>
                  </thead>
				  
                  <tbody>
                <?php
                  if($getallproduct){
					for($i=0;$i<count($getallproduct);$i++){
				?>
				<tr>
					<td><input name="selected[]" id="selected[]" value="<?php echo $getallproduct[$i]->id; ?>" type="checkbox"  class="minimal-red"></td>
					 
					<td style="text-align:left"><?php echo $this->vendor_model->get_category_name($getallproduct[$i]->material_type); ?></td>
					<td style="text-align:left"><?php echo $getallproduct[$i]->material_name; ?></td>					
					<td style="text-align:left"><?php echo $getallproduct[$i]->material_code; ?></td>					
					<td class="text-center"><a class="btn bg-purple2" title="Edit" href="<?php echo $base_url."edit-product/"; ?><?php echo $getallproduct[$i]->id; ?>">
					<i class="fa fa-pencil"></i></a></td>	
				</tr>
				<?php
                  } } else {
					  echo 'No Product Found';
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
		</div>	
	</div>
</section>	
<?php include('includes/footer.php');?>

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap.min.js"></script>
	
<script>

function deleteproduct(){	
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