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
          <li class="crumb-trail">Product</li>
		   <li class="crumb-active"><a href="javascript:void(0);">Product</a></li>
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
		<!-- <a href="javascript:void('0');" onclick="deletecountry();" class="btn btn-danger pull-right"  style="margin-left:10px"><i class="fa fa-trash-o"></i> Delete</a> -->
		
		<!-- a href="<?php echo $base_url;?>product/add/" class="btn btn-alert pull-right"><i class="fa fa-plus"></i> Add Product</a -->
		
		</div>
		<div class="clearfix">&nbsp;</div>

		    <div class="row">
       <div class="col-md-12">      
        <div class="panel">
            <div class="panel-heading"> <span class="panel-title" > <span class="glyphicon glyphicon-search"></span>Search Products  </span>
             </div>
             
      <div class="panel-body">
           <form action="<?php echo $base_url."product/lists";?>" method="post" enctype="multipart/form-data"> 

            <div class="form-group col-md-3">
                  <label for="inputEmail">Vendor</label>
                
                <select id="vendors" name="vendors" class="form-control jobtext">
                <option value="" selected> Select Vendor Name </option>
                <?php
        for($i=0;$i<count($vendor);$i++)
                {
                ?>
                <option 
                value="<?php echo $vendor[$i]->id; ?>" <?php if($vendor[$i]->id==$vendors) {echo "selected";} ?> >
        <?php echo $vendor[$i]->name;  ?></option>
                <?php
                }
                ?>
                </select>
          </div>
       
          <div class="form-group col-md-3">
                  <label for="inputEmail">Material</label>
                
                <select id="categorys" name="categorys" class="form-control jobtext">
                <option value="" selected> Select Material Name </option>
                <?php
        for($i=0;$i<count($allcategory);$i++)
                {
                ?>
                <option 
                value="<?php echo $allcategory[$i]->id; ?>" <?php if($allcategory[$i]->id==$categorys) {echo "selected";} ?> >
        <?php echo $allcategory[$i]->name;  ?></option>
                <?php
                }
                ?>
                </select>
          </div>
          
          <!-- div class="form-group col-md-3">
                  <label for="inputEmail">Sub Category</label>
                
                <select id="sub_category" name="sub_category" class="form-control jobtext">
                <option value="" selected> Select Sub Category Name </option>
                <?php
        for($i=0;$i<count($subcategory);$i++)
                {
                ?>
                <option 
                value="<?php echo $subcategory[$i]->id; ?>" <?php if($subcategory[$i]->id==$sub_category) {echo "selected";} ?> >
        <?php echo $subcategory[$i]->name;  ?></option>
                <?php
                }
                ?>
                </select>
          </div -->
          
        
      
      <div class="form-group col-md-1">
      <label for="inputEmail" style="visibility:hidden">&nbsp;</label><br>
      <input class="submit btn bg-purple2 " type="submit" value="Search" style="width:100%">
      </div>
      
      <div class="form-group col-md-1">
      <label for="inputEmail" style="visibility:hidden">&nbsp;</label><br>
       <a href="<?php echo $base_url;?>product/lists" class="submit btn bg-purple2" style="width:100%">Reset</a>
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
			  
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Product Listing </span> </div>
            <div class="panel-body">
			  <form action="<?php echo $base_url."product/deletes";?>" method="post" enctype="multipart/form-data" id="form">
			  <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
   
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      
                      <th><input name="checkAll" id="checkAll" type="checkbox"  class="minimal-red" ></th><th>Vendor Name</th>
                      <th>Product Name</th>
					  <th>Material</th>
					   <!-- th>Sub Category </th>-->
					  <th>Featured Product</th>
					   <th>Status</th>
					   <th>MRP</th>
					    <th>BPCL Special Price</th>
					     <th>DBP</th>
					  <th>Add Image</th>
					 
					  <th>Delete</th>
                      <th class="sorting" role="columnheader" aria-controls="table-2" style="width: auto;">Action</th>
                     
                    </tr>
                  </thead>
     
				  
                  <tbody>
                <?php if($result){ for($i=0;$i<count($result);$i++){ ?>
         <tr>
					<td><input name="selected[]" id="selected[]" value="<?php echo $result[$i]['id']; ?>" type="checkbox"  class="minimal-red checkDelete" <?php if($result[$i]['is_deleted']==1) { ?> disabled <?php }?>></td>
					     <td style="text-align:left"><?php echo $this->product_model->get_vendor_name($result[$i]['user_id']); ?></td>
                          <td style="text-align:left"><?php echo $result[$i]['material_name']; ?></td>
						  <td><?php echo $this->product_model->get_cate_name($result[$i]['material_type']); ?></td>	
						  <!-- <td><?php //echo $this->product_model->get_subcate_name($result[$i]['subcatefory_id']); ?></td>-->	
						 
						 <td> 
						 <input type="checkbox"  id="featured" name="featured"  value="1" onclick="featured_product('<?php echo $result[$i]['id']; ?>',this);" <?php if($result[$i]['featured'] == '1') { echo "checked"; } ?> ></td> 

						 
						 <td>
							<select title="Approve" id="change_status_<?php echo $result[$i]['id']; ?>" onchange="javascript:approve('<?php echo $base_url."product/updatestatus/"; ?><?php echo $result[$i]['id']; ?>',this.value,<?php echo $result[$i]['status']; ?>,<?php echo $result[$i]['id']; ?>);" >
								<option value="0" <?php if($result[$i]['status']==0) { echo "selected"; } ?>>Active</option>
								<option value="1" <?php if($result[$i]['status']==1) { echo "selected"; } ?>>Deactive</option>
							</select>
						</td>
					     <td><?php echo $result[$i]['mrp']; ?></td>	
					      <td><?php echo $result[$i]['bpcl_special_price']; ?></td>	
					       <td><?php echo $result[$i]['billing_price']; ?></td>	
                           <td><a class="btn bg-purple2" title="Edit" href="<?php echo $base_url."product/editimage/"; ?><?php echo $result[$i]['id']; ?>">Add Image</a></td>
                        
                           <td><a class="btn btn-danger" title="Delete" href="javascript:void('0');" onclick="deletesingle(<?php echo $result[$i]['id']; ?>);"><i class="fa fa-trash-o"></i> Delete</a></td>
                           <td>  
                        <?php if($result[$i]['is_deleted']==1) { ?><span style="color:red;">Deleted</span><?php } else { ?> <a class="btn bg-purple2" title="Edit" href="<?php echo $base_url."product/edit/"; ?><?php echo $result[$i]['id'];?>"><i class="fa fa-pencil"></i></a> <?php } ?>
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
function approve(url,is_active,oldVlaue,orderid){
  var box = document.getElementById('change_status_'+orderid);
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
        box.value = oldVlaue;
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

function deletesingle(proid){

  var conf = confirm("Do you want to delete?");
		if(conf == true){
		var base_url = '<?php echo $base_url.'product/deleteSingle'; ?>';
				window.location = base_url+"/"+proid;
		return true;
		}else{
			return false;
		}
}

function deletecountry(){
	var checked = $("#form .checkDelete:checked").length > 0;
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
				
				var base_url = '<?php echo $base_url. 'product/featured_product';?>';
				window.location = base_url+"/"+id+"/1";				
			}
			else
			{
				
				var base_url = '<?php echo $base_url. 'product/featured_product';?>';
				window.location = base_url+"/"+id+"/0";
			}
		
	 }
	 
	 </script>