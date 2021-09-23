<?php include('includes/header.php');?>

<section class=" login-reg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
			<div class="login-main">
			<div class="login" id="breadcrumb">

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
                  
                        <h4> Add Product </h4>
						<hr/>
                        <form role="form" id="form" method="post" action="<?php echo $base_url;?>vendor/add_products" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="action" VALUE="add_product">
						<div class="row" >
						     <div class="col-md-6">
				                <div class="form-group">
							
								  <select id="material_type" name="material_type" class="form-control">
									<option value="">Material Type*</option>
                                    <?php 
                                    if($allmaterial !='')
                                    {
                                        foreach($allmaterial as $cate_data)
                                        {
                                    ?>
									<option value="<?php echo $cate_data->id; ?>"><?php echo $cate_data->name; ?></option>
									<?php } } ?>
								  </select>
								  </div>
								   </div>
                                 <div class="col-md-6" >
                                    <div class="form-group">
                                        <input id="material_name" name="material_name" type="text" required="required" class="form-control" value="" placeholder="Material Name*">
                                    </div>
                                </div>

                                <div class="col-md-6" style="display: none;">
                                    <div class="form-group">
                                        <input id="page_url" name="page_url" type="text" required="required" class="form-control" value="" placeholder="Page Url*">
                                    </div>
                                </div>

                                    <div class="col-md-6">
                                    <div class="form-group">
									<label>Upload Product image / Product Brochure</label>
                                        <input id="product_image" name="product_image" type="file" required="required" class="form-control" value="" placeholder="Upload">
                                    </div>
                                </div>
								 <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="material_code" name="material_code" type="text" required="required" class="form-control" value="" placeholder="Material Code">
                                    </div>
                                </div>
                                	 <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="product_description" name="product_description" rows="3" placeholder="Product Description"></textarea>
                                    </div>
                                </div>
						</div>	
						
				<h4>Product Price </h4>	
			  <hr/>

				<div class="row">
                               
								 <div class="col-md-3" style="display:none;">
                                    <div class="form-group">
                                        <input id="margin" name="margin" type="text" required="required" class="form-control" value="" placeholder=" Margin*">
                                    </div>
                                </div>
                                
                                	<div class="col-md-3">
                                    <div class="form-group">
                                        <input id="mrp" name="mrp" type="text" required="required" class="form-control" value="" placeholder="MRP *">
                                    </div>
                                </div>
    
								<div class="col-md-3">
                                    <div class="form-group">
                                        <input id="bpcl_special_price" name="bpcl_special_price" type="text" required="required" class="form-control" value="" placeholder="BPCL Special Price *">
                                    </div>
                                </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <input id="billing_price" name="billing_price" type="text" required="required" class="form-control" value="" placeholder="DBP(Dealer Billing Price) *">
                                    </div>
                                </div>
						</div>		
				<!-- h4>Package Details </h4 >	
			     <hr/ -->

				<div class="row" style="display:none;">
				           
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="package" name="package" type="text" required="required" class="form-control" value="" placeholder="Package*">
                                    </div>
                                </div>
								 <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="base_unit" name="base_unit" type="text" required="required" class="form-control" value="" placeholder=" Base Unit*">
                                    </div>
                                </div>
                                
                                
                                
                                	<div class="col-md-3">
                                    <div class="form-group">
                                        <input id="base_pkg" name="base_pkg" type="text" required="required" class="form-control" value="" placeholder="Base/Pkg*">
                                    </div>
                                </div>
								<div class="col-md-3">
                                    <div class="form-group">
                                        <input id="sale_unit" name="sale_unit" type="text" required="required" class="form-control" value="" placeholder="Sale Unit*">
                                    </div>
                                </div>
									<div class="col-md-3">
                                    <div class="form-group">
                                        <input id="price_unit" name="price_unit" type="text" required="required" class="form-control" value="" placeholder="Price Unit*">
                                    </div>
                                </div>
                                	<div class="col-md-3">
                                    <div class="form-group">
                                        <input id="min_qty" name="min_qty" type="text" required="required" class="form-control" value="" placeholder="Min Qty*">
                                    </div>
                                </div>
								
							
						</div>	
						
						      <h4>Inventory Details </h4>
						<hr/>
						<div class="customer_records">
						<div class="row">
						    
                                 <div class="col-md-4">
                                    <div class="form-group">
							
								  <select id="state_id" name="state_id[]" onchange="get_group(this.value,'0');"  class="form-control">
									<option value="">Select State*</option>
									<?php if($allstate !='')
                                    {
                                        foreach($allstate as $stateshow)
                                        {
                                    ?>
                                    <option value="<?php echo $stateshow->id; ?>"><?php echo $stateshow->name; ?></option>
                                    <?php } } ?>
								  </select>
								  </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <span id="prod10">
                                  <select id="city_id" name="city_id[]" class="form-control">
                                    <option value="">All City*</option>
                                  </select>
                                    </span>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <span id="prod20">
                                  <select id="area_id" name="area_id[]" class="form-control">
                                    <option value="">All Area*</option>
                                  </select>
                                    </span>
                                  </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                    <span id="prod30">
                                  <select id="pincode_id" name="pincode_id[]" class="form-control">
                                    <option value="">All Pincode*</option>
                                  </select>
                                    </span>
                                  </div>
                                </div>
								 <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="inventory" name="inventory[]" type="text" required="required" class="form-control" value="" placeholder="Inventory*">
                                    </div>
                                </div>	
                             </div>    
                         </div>      
                              <!-- <div class="col-md-6"> </div> -->
                                <div class="input_fields_wrap12"></div>
								 <div class="col-md-6">
                                      <a class="extra-fields-customer" href="javascript:void(0)" id="add_field_button12" style="font-weight: bold;">Add More &nbsp;<i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                 </div>	
                                 
                                 <!-- <div class="input_fields_wrap12"></div> -->
                                 
                                 	<div class="col-md-6">
								 <a href="javascript:void(0);" class="sub-btn" onclick="javascript:validate();return false;" type="" value=""> Submit </a>
                                  <a href="<?php echo $base_url; ?>list-product" class="sub-btn" > Cancel </a>
								 </div>
			</div>
				</form>		
			</div>			
			</div>
			</div>
		</div>	
	</div>
</section>	

<?php include('includes/footer.php');?>

<script>
    function validate(){

    var material_type = $("#material_type").val();
    if(material_type == ''){          
        $("#error_msg1").html("Please Select Material Type.");
        $("#validator").css("display","block");
        document.getElementById("breadcrumb").scrollIntoView(true); 
        return false;
    } 

    var material_name = $("#material_name").val();
    if(material_name == ''){          
        $("#error_msg1").html("Please Enter Material name");
        $("#validator").css("display","block");
        document.getElementById("breadcrumb").scrollIntoView(true); 
        return false;
    } 

    var billing_price = $("#billing_price").val();
    if(billing_price == ''){          
        $("#error_msg1").html("Please Enter Billing price");
        $("#validator").css("display","block");
        document.getElementById("breadcrumb").scrollIntoView(true); 
        return false;
    } 

    

    var mrp = $("#mrp").val();
    if(mrp == ''){          
        $("#error_msg1").html("Please Enter MRP");
        $("#validator").css("display","block");
        document.getElementById("breadcrumb").scrollIntoView(true); 
        return false;
    }
   
    var bpcl_special_price = $("#bpcl_special_price").val();
    if(bpcl_special_price == ''){          
        $("#error_msg1").html("Please Enter BPCL Special Price");
        $("#validator").css("display","block");
        document.getElementById("breadcrumb").scrollIntoView(true); 
        return false;
    }

     
   /* var sale_unit = $("#sale_unit").val();
    if(sale_unit == ''){          
        $("#error_msg1").html("Please Enter Sale Unit");
        $("#validator").css("display","block");
        document.getElementById("breadcrumb").scrollIntoView(true); 
        return false;
    }
     var price_unit = $("#price_unit").val();
    if(price_unit == ''){          
        $("#error_msg1").html("Please Enter Price Unit");
        $("#validator").css("display","block");
        document.getElementById("breadcrumb").scrollIntoView(true); 
        return false;
    }

     var min_qty = $("#min_qty").val();
    if(min_qty == ''){          
        $("#error_msg1").html("Please Enter Min Qty");
        $("#validator").css("display","block");
        document.getElementById("breadcrumb").scrollIntoView(true); 
        return false;
    }*/
        $('#form').submit();
    }

</script>
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
    var max_fields      = 50;
    var wrapper         = $(".input_fields_wrap12");
    var add_button      = $("#add_field_button12");


    var b = 0;
    $(add_button).click(function(e){
    e.preventDefault();
    if(b < max_fields){
    b++;
      $(wrapper).append('<div class="customer_records"><div class="row"><div class="col-md-4"><div class="form-group"><select id="state_id'+b+'" name="state_id[]" onchange="get_group(this.value,'+b+');"  class="form-control"><option value="">Select State*</option><?php if($allstate !='') { foreach($allstate as $stateshow)   {   ?> <option value="<?php echo $stateshow->id; ?>"><?php echo $stateshow->name; ?></option>   <?php } } ?>     </select>  </div></div> <div class="col-md-4"> <div class="form-group"><span id="prod1'+b+'"><select id="city_id" name="city_id[]" class="form-control"> <option value="">Select City*</option></select> </span></div>  </div> <div class="col-md-4"><div class="form-group"><span id="prod2'+b+'"><select id="area_id" name="area_id[]" class="form-control"><option value="">Select Area*</option></select></span></div></div><div class="col-md-4"><div class="form-group"><span id="prod3'+b+'"><select id="pincode_id" name="pincode_id[]" class="form-control"><option value="">Select Pincode*</option></select></span></div> </div> <div class="col-md-6"><div class="form-group"><input id="inventory" name="inventory[]" type="text" required="required" class="form-control" value="" placeholder="Inventory*"> </div></div>  <a href="#" class="remove-field btn-remove-customer remove_field1" style="margin-right: 0px; margin-top: 24px;">Remove</a></div></div>');
    }
    });
    $(wrapper).on("click",".remove_field1", function(e){
    e.preventDefault();
    $(this).parent('div').remove();
    b--;
    })
    });

    </script>

<script>
function get_group(cid,show_id)
{
        var url = '<?php echo $base_url ?>/home/show_city/';
        $.ajax({
        url:url,
        type:'post',
        data:'cid='+cid+'&show_id='+show_id+'&sid=',
        success:function(msg)
        {
            
            document.getElementById('prod1'+show_id).innerHTML = msg ;
        }
        });
}

function get_area(cid,show_id)
{
        var url = '<?php echo $base_url ?>/home/show_area/';
        $.ajax({
        url:url,
        type:'post',
        data:'cid='+cid+'&show_id='+show_id+'&sid=',
        success:function(msg)
        {            
            document.getElementById('prod2'+show_id).innerHTML = msg ;
        }
        });
}

function get_pincode1(cid,show_id)
{
        var url = '<?php echo $base_url ?>/home/show_pincode/';
        $.ajax({
        url:url,
        type:'post',
       data:'cid='+cid+'&show_id='+show_id+'&sid=',
        success:function(msg)
        {
            
            document.getElementById('prod3'+show_id).innerHTML = msg ;
        }
        });
}

$(function() {
        $("#material_name").keyup(function(){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
        $("#page_url").val(Text);
        });

        });

</script> 