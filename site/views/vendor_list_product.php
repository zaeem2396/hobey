<?php include('includes/header.php');?>
<style>
footer {
    background: #000;
    text-align: center;
    color: #fff;
    padding-top: 20px;
    padding-bottom: 10px;
    position: fixed;
    width: 100%;
    bottom: 0;
}
.product_list_right_main ul li {    background: #ccc;padding: 50px 10px;}
.product_list_right_main ul a li h2 {color:#000;}
</style>
<section class=" login-reg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
<?php include('includes/sidebar_vendor.php');?>
<div class="content-wrapper">
  <div class="content">
         	
<div class="product_list_right_main">
    
    		<div class="col-md-12">
			
			<a href="<?php echo $base_url;?>add-product" class="sub-btn pull-right"> Add </a>
			<a href="javascript:void(0);" onclick="deleteproduct();" class="sub-btn pull-right">Delete</a>

			
		</div>
		<div class="clearfix">&nbsp;</div>
		<span id="product_succsess" class="alert-message successmain valierror123 form-group" style="display:none;margin-bottom: 5px;"></span>
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
					  <th>Product Status</th>
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

					<td style="text-align:left"><?php if($getallproduct[$i]->status == '1') { echo "Deactive"; } else { echo "Active"; } ?></td>

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
<?php if($this->session->flashdata('product_succsess') !=""){ ?>
<script>    
$(document).ready(function(){
     //$('#messagealert').modal();
     $('#product_succsess').html("<?php echo $this->session->flashdata('product_succsess'); ?>");
        $('#product_succsess').show().delay(0).fadeIn('show');
        $('#product_succsess').show().delay(6000).fadeOut('show');
    
});
</script>

<?php } ?>