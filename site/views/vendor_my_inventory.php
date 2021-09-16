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
			
		</div>
		<div class="clearfix">&nbsp;</div>
			  <form action="<?php echo $base_url."vendor/delete_product";?>" method="post" enctype="multipart/form-data" id="form">
			  <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
   
              <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th>Material Name</th>
					  <th>Total Qty (Pack)</th>
					  <th>Sold Order</th>
					  <th>Current Stock</th>
					</tr>
                  </thead>
				  
                  <tbody>
                <?php
				//echo "<pre>";print_r($getVendorOrdersCustomerStock);echo "</pre>";
                  if($getVendorOrdersCustomerStock){
					for($i=0;$i<count($getVendorOrdersCustomerStock);$i++){
				?>
				<tr>
					<td style="text-align:left"><?php echo $getVendorOrdersCustomerStock[$i]->material_name; ?></td>
					<?php $vendor_tqty =  $this->home_model->get_vendor_tqty($getVendorOrdersCustomerStock[$i]->id); ?>
					<td style="text-align:left"><?php echo $vendor_tqty; ?></td>
					<?php $vendor_qty =  $this->home_model->get_vendor_qty($getVendorOrdersCustomerStock[$i]->id); ?>
					<td style="text-align:left"><?php echo $vendor_qty; ?></td>

					<td style="text-align:left"><?php echo ($vendor_tqty - $vendor_qty); ?></td>

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