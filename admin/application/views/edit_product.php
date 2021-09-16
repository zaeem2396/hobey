<?php include('include/header.php');?>
<link href="<?php echo $base_url_views; ?>css/fSelect.css" rel="stylesheet">
<link href="<?php echo $base_url_views; ?>css/mediaBoxes.css" rel="stylesheet">
<!-- Start: Main -->
<div id="main">
 <?php include('include/sidebar_left.php');?>
 <style>
     .badges-div img
     {
         max-width: 60px;
        height: 70px;
        object-fit: contain;
        margin-right: 10px;

     }
 </style>
  <!-- Start: Content -->
  <section id="content_wrapper">
   <div id="topbar">
      <div class="topbar-left">
         <ol class="breadcrumb" id="breadcrumb">
            <li class="crumb-icon"><a href="<?php echo $base_url; ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="crumb-link"><a href="<?php echo $base_url; ?>product/lists">Product</a></li>
            <li class="crumb-active"><a href="javascript:void(0);"> Edit Product </a></li>
         </ol>
      </div>
   </div>
   <div id="content">
      <div class="row">
        <form role="form" id="form" method="post" action="<?php echo $base_url;?>product/edit/<?php echo $id; ?>" enctype="multipart/form-data" >
		 <div class="col-md-12">
            <div class="panel">
               <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Edit Product </span> </div>
               <div class="panel-body">
                  <?php if($this->session->flashdata('L_strErrorMessage'))
                     { ?>
                  <div class="alert alert-success alert-dismissable">
                     <i class="fa fa-check"></i>
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     <b>Success!</b> <?php echo $this->session->flashdata('L_strErrorMessage'); ?>
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
                    
                        <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
                        <INPUT TYPE="hidden" NAME="action" VALUE="edit_product">
                        <INPUT TYPE="hidden" NAME="hiddenaction" VALUE="<?php echo $id;?>">
                            <div class="col-md-4">
                                <div class="form-group">
                                   <label for="vendor_id">Material Type</label>			                    
                                   <select id="material_type" name="material_type" class="form-control">
                                    <option value="">Material Type*</option>
                                    <?php 
                                    if($allmaterial !='')
                                    {
                                        foreach($allmaterial as $cate_data)
                                        {
                                    ?>
                                    <option value="<?php echo $cate_data->id; ?>" <?php if($cate_data->id == $material_type) { echo "selected"; } ?>><?php echo $cate_data->name; ?></option>
                                    <?php } } ?>
                                  </select>
                                   <span id="vendorerror" class="valierror"></span>
                                </div>
                            </div>
                            <div class="col-md-4">  
                                <div class="form-group">
                                   <label for="name">Product Name <span color="red">*</span></label>
                                   <input id="material_name" name="material_name" type="text" required="required" class="form-control" value="<?php echo $material_name; ?>" placeholder="Material Name*">
                                   <span id="nameerror" class="valierror"></span>
                                </div>
                            </div>
                            <div class="col-md-4">  
                                <div class="form-group">
                                   <label for="page_url">Page Url <span color="red">*</span></label>
                                    <input id="page_url" name="page_url" type="text" required="required" class="form-control" value="<?php echo $page_url; ?>" placeholder="Page Url*">
                                   <span id="pageurlerror" class="valierror"></span>
                                </div>
                            </div>
                       
                        <div class="col-md-4">
                            <div class="form-group">
                               <label for="category_id">Upload Product image / Product Brochure <span color="red">*</span></label>
                               <input id="product_image" name="product_image" type="file" class="form-control" value="" placeholder="Upload">
                                <img style="width: 100px;" src="<?php echo $this->config->item('front_base_url')."upload/product/".$product_image; ?>" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                               <label for="subcatefory_id">Material Code</label>
                                <input id="material_code" name="material_code" type="text"class="form-control" value="<?php echo $material_code; ?>" placeholder="Material Code">
                            </div>
                        </div>
						
                  <div class="col-md-12">
                      <div class="form-group">
                      <label for="hsn_code">Product Description</label>
                     <div class="form-group">
                          <textarea id="desc" name="product_description" class="form-control" placeholder="Enter Short Description"><?php  echo $product_description; ?></textarea>                
                    </div>
                      </div>
                  </div>
                  
                   <div class="col-md-12">
                 <h4>Product Price </h4>    
                 <hr/>
                </div>
               
                <div class="col-md-3">
                <div class="form-group">
                     <label for="hsn_code">MRP</label>
                    <input id="mrp" name="mrp" type="text" required="required" class="form-control" value="<?php echo $mrp; ?>" placeholder="MRP*">
                </div>
            </div>
            
                <div class="col-md-3">
                <div class="form-group">
                     <label for="hsn_code">BPCL Special Price</label>
                    <input id="bpcl_special_price" name="bpcl_special_price" type="text" required="required" class="form-control" value="<?php echo $bpcl_special_price; ?>" placeholder="BPCL Special Price*">
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                     <label for="hsn_code">Billing Price</label>
                    <input id="billing_price" name="billing_price" type="text" required="required" class="form-control" value="<?php echo $billing_price; ?>" placeholder="DBP(Dealer Billing Price)*">
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                     <label for="hsn_code">Distributor Payment</label>
                    <input id="distributorpay" name="distributorpay" type="text" required="required" class="form-control" value="<?php echo $distributorpay; ?>" placeholder="Distributor Payment*">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                     <label for="hsn_code">Delivery Man Payment</label>
                    <input id="deliverypay" name="deliverypay" type="text" required="required" class="form-control" value="<?php echo $deliverypay; ?>" placeholder="Delivery Payment">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                     <label for="hsn_code">BPCL Payment</label>
                    <input id="bpclpay" name="bpclpay" type="text" required="required" class="form-control" value="<?php echo $bpclpay; ?>" placeholder="BPCL Payment">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                     <label for="package">Packsize</label>
                    <input id="package" name="package" type="text" class="form-control" value="<?php echo $package; ?>" placeholder="Packsize">
                    <span id="packerror" class="valierror"></span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                     <label for="min_qty">Min Qty</label>
                    <input id="min_qty" name="min_qty" type="text" class="form-control" value="<?php echo $min_qty; ?>" placeholder="Min Qty">
                    <span id="qtyerror" class="valierror"></span>
                </div>
            </div>
                                
            
            <div class="col-md-12">
                 <h4>Inventory Details </h4>
                 <hr/>
                </div>
                        
                        <?php
                           if($addition_item !=''){
                             for($i=0;$i<count($addition_item);$i++)
                           {
                            ?>
                            <input type="hidden" name="updateid1xxx[]" id="updateid1xxx<?php echo $i+1; ?>" value="<?php echo $addition_item[$i]->id; ?>">
                        <div class="customer_records">
                        <div class="row">
                            
                                 <div class="col-md-4">
                                    <div class="form-group">
                            
                                  <select id="state_id<?php echo $i+1; ?>" name="state_id[]" onchange="get_group(this.value,'<?php echo $i; ?>');"  class="form-control">
                                    <option value="">Select State*</option>
                                    <?php if($allstate !='')
                                    {
                                        foreach($allstate as $stateshow)
                                        {
                                    ?>
                                    <option value="<?php echo $stateshow->id; ?>" <?php if($addition_item[$i]->state_id == $stateshow->id ) { echo "selected"; } ?>><?php echo $stateshow->name; ?></option>
                                    <?php } } ?>
                                  </select>
                                  </div>
                                </div>
                                <?php $allcity = $this->product_model->show_subcategory($addition_item[$i]->state_id); ?>
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <span id="prod1<?php echo $i; ?>">
                                  <select id="city_id<?php echo $i+1; ?>" name="city_id[]" class="form-control" onchange="get_area(this.value,'<?php echo $i; ?>');">
                                    <option value="">All City*</option>
                                    <?php if($allcity !='')
                                    {
                                        foreach($allcity as $cityhow)
                                        {
                                    ?>
                                    <option value="<?php echo $cityhow->id; ?>" <?php if($addition_item[$i]->city_id == $cityhow->id ) { echo "selected"; } ?>><?php echo $cityhow->name; ?></option>
                                    <?php } } ?>
                                  </select>
                                    </span>
                                  </div>
                                </div>
                                <?php $allarea = $this->product_model->show_area($addition_item[$i]->city_id); ?>
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <span id="prod2<?php echo $i; ?>">
                                  <select id="area_id<?php echo $i+1; ?>" name="area_id[]" class="form-control" onchange="get_pincode(this.value,'<?php echo $i; ?>');">
                                    <option value="">All Area*</option>
                                    <?php if($allarea !='')
                                    {
                                        foreach($allarea as $areahow)
                                        {
                                    ?>
                                    <option value="<?php echo $areahow->id; ?>" <?php if($addition_item[$i]->area_id == $areahow->id ) { echo "selected"; } ?>><?php echo $areahow->name; ?></option>
                                    <?php } } ?>
                                  </select>
                                    </span>
                                  </div>
                                </div>
                                <?php //$allpincode = $this->product_model->show_pincode($addition_item[$i]->area_id); ?>
                                <!-- <div class="col-md-4">
                                    <div class="form-group">
                                    <span id="prod3<?php //echo $i; ?>">
                                  <select id="pincode_id<?php echo $i+1; ?>" name="pincode_id[]" class="form-control">
                                    <option value="">All Pincode*</option>
                                    <?php //if($allpincode !='')
                                    // {
                                    //     foreach($allpincode as $pincodehow)
                                    //     {
                                    ?>
                                    <option value="<?php //echo $pincodehow->id; ?>" <?php //if($addition_item[$i]->pincode_id == $pincodehow->id ) { echo "selected"; } ?>><?php //echo $pincodehow->name; ?></option>
                                    <?php //} } ?>
                                  </select>
                                    </span>
                                  </div>
                                </div> -->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <input id="inventory" name="inventory[]" type="text" required="required" class="form-control" value="<?php echo $addition_item[$i]->inventory; ?>" placeholder="Inventory*">
                                    </div>
                                </div>
                                <a href="javascript:void(0);" onclick="singledelete('<?php echo $base_url."product/removeprice/"; ?><?php echo $addition_item[$i]->pro_id;?>/<?php echo $addition_item[$i]->id; ?>');" class="btn btn-danger pull-right">Remove</a>    
                             </div>
                         </div> 
                         <?php } } ?>     
                              <!-- <div class="col-md-6"> </div> -->
                                <div class="input_fields_wrap12"></div>

                                 <div class="col-md-12">
                                      <a  href="javascript:void(0)" id="add_field_button12" style="border: medium none; margin-right: 0px; line-height: 23px;" class="submit btn bg-purple pull-right" >Add More &nbsp;<i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                 </div> 


                  <div class="form-group">                  <input class="submit btn btn-danger pull-right" type="submit" value="Submit" onclick="javascript:validate();return false;"/>				   <a href="<?php echo $base_url;?>product/lists" class="submit btn bg-purple pull-right" style="margin-right: 10px;" />Cancel</a>                </div>
                  
               </div>
            </div>
         </div>
         </div>
      </div>
	  </form>
   </div>
   </div>
</section>
  <!-- End: Content -->


 <?php include('include/sidebar_right.php');?>
 </div>
<!-- End #Main -->
<?php include('include/footer.php')?>
<script>
    $(document).ready(function() {
     
    var max_fields      = 50;
    var wrapper         = $(".input_fields_wrap12");
    var add_button      = $("#add_field_button12");
    var b = <?php echo (count($addition_item)); ?>;
    
    $(add_button).click(function(e){
    e.preventDefault();
    if(b < max_fields){
    b++;
      $(wrapper).append('<div class="customer_records"><div class="row"><div class="col-md-4"><div class="form-group"><select id="state_id'+b+'" name="state_id1[]" onchange="get_group1(this.value,'+b+');"  class="form-control"><option value="">Select State*</option><?php if($allstate !='') { foreach($allstate as $stateshow)   {   ?> <option value="<?php echo $stateshow->id; ?>"><?php echo $stateshow->name; ?></option>   <?php } } ?>     </select>  </div></div> <div class="col-md-4"> <div class="form-group"><span id="prod1'+b+'"><select id="city_id" name="city_id1[]" class="form-control"> <option value="">Select City*</option></select> </span></div>  </div> <div class="col-md-4"><div class="form-group"><span id="prod2'+b+'"><select id="area_id" name="area_id1[]" class="form-control"><option value="">Select Area*</option></select></span></div></div><div class="col-md-4"><div class="form-group"><input id="inventory" name="inventory1[]" type="text" required="required" class="form-control" value="" placeholder="Inventory*"> </div></div>  <a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 0px; margin-top: 24px;">Remove</a></div></div>');
    }
    });
    $(wrapper).on("click",".remove_field1", function(e){
    e.preventDefault();
    $(this).parent('div').remove();
    b--;
    })
    });

    function get_group(cid,show_id)
{
        var url = '<?php echo $base_url ?>/product/show_city/';
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
        var url = '<?php echo $base_url ?>/product/show_area/';
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
function get_pincode(cid,show_id)
{
        var url = '<?php echo $base_url ?>/product/show_pincode/';
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
function get_group1(cid,show_id)
{
        var url = '<?php echo $base_url ?>/product/show_city1/';
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
function get_area1(cid,show_id)
{
        var url = '<?php echo $base_url ?>/product/show_area1/';
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
        var url = '<?php echo $base_url ?>/product/show_pincode1/';
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
</script>
<script>
function validate(){
    	var material_type = $("#material_type").val();
    	if(material_type == ''){
        	$("#vendorerror").html("Please Select Material Type.");
       		jQuery('#vendorerror').show().delay(0).fadeIn('show');
       		jQuery('#vendorerror').show().delay(2000).fadeOut('show');
       		document.getElementById("breadcrumb").scrollIntoView(true); 
    	    return false;
    	}

		var title = $("#material_name").val();

		if(title == ''){
			$("#nameerror").html("Please Enter Material name");
       		jQuery('#nameerror').show().delay(0).fadeIn('show');
       		jQuery('#nameerror').show().delay(2000).fadeOut('show');
       		document.getElementById("breadcrumb").scrollIntoView(true); 
		    return false;
		}
       
        var bpcl_special_price = $("#bpcl_special_price").val();
       
        var billing_price = $("#billing_price").val();
        
        var distributorpay = $("#distributorpay").val();
        
        var deliverypay = $("#deliverypay").val();
        
        var bpclpay = $("#bpclpay").val();
       

        var margin = bpcl_special_price-billing_price;
        
        //var ddbtotal = parseFloat(distributorpay)+parseFloat(deliverypay)+parseFloat(bpclpay);
        var ddbtotal = (parseFloat(distributorpay) + parseFloat(deliverypay)).toFixed(1);
        ddbtotal = (parseFloat(ddbtotal) + parseFloat(bpclpay)).toFixed(1);
        
        if(margin != ddbtotal){
            alert('Margin is not equal');
            return false;
        }

        var package = $("#package").val();
        if(package == ''){
			$("#packerror").html("Please Enter Packsize");
       		jQuery('#packerror').show().delay(0).fadeIn('show');
       		jQuery('#packerror').show().delay(2000).fadeOut('show');
       		//document.getElementById("breadcrumb").scrollIntoView(true); 
		    return false;
		}

        var min_qty = $("#min_qty").val();
        if(min_qty == ''){
			$("#qtyerror").html("Please Enter Min Qty");
       		jQuery('#qtyerror').show().delay(0).fadeIn('show');
       		jQuery('#qtyerror').show().delay(2000).fadeOut('show');
       		//document.getElementById("breadcrumb").scrollIntoView(true); 
		    return false;
		}

        
        /*
		var category_id = $("#category_id").val();
		//alert(category_id);
		if(category_id == '' || category_id == null){
        	$("#caterror").html("Please select Category");
       		jQuery('#caterror').show().delay(0).fadeIn('show');
       		jQuery('#caterror').show().delay(2000).fadeOut('show');
       		document.getElementById("breadcrumb").scrollIntoView(true); 
		    return false;
		}
		
		var gst = $("#gst").val();
		if(gst == ''){
        	$("#gsterror").html("Please Select GST");
       		jQuery('#gsterror').show().delay(0).fadeIn('show');
       		jQuery('#gsterror').show().delay(2000).fadeOut('show');
       		document.getElementById("breadcrumb").scrollIntoView(true); 
		    return false;
		}*/

		/*var subcatefory_id = $("#subcatefory_id").val();
		if(subcatefory_id == ''){
    		$("#error_msg1").html("Please Select Sub Category.");
    		$("#validator").css("display","block");
    		return false;
    		}
    	*/	
    		
    	$('#form').submit();
    	}
	 	
	 	function numbersonly(e){
    		var unicode=e.charCode? e.charCode : e.keyCode
    		if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
    			 if (unicode < 45 || unicode > 57) //if not a number
    				return false //disable key press
    		}
    	}
	
    	function blockvalue_p(idvale){
            if($("#discount"+idvale).val() !== ""){
              $("#discount_price"+idvale).prop("readonly", true);
            }else{
              $("#discount_price"+idvale).removeAttr("readonly");
            }
        }

        function blockvalue_d(idvale){
            if($("#discount_price"+idvale).val() !== ""){
              $("#discount"+idvale).prop("readonly", true);
            }else{
              $("#discount"+idvale).removeAttr("readonly");
            }
        }
</script>

<script type="text/javascript" src="<?php echo $base_url_views; ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript">
jQuery(document).ready(function () {
	"use strict";
	CKEDITOR.replace('desc',
	{

	});
    CKEDITOR.disableAutoInline = false;
});
// jQuery(document).ready(function () {	"use strict";	Core.init();	Ajax.init();	CKEDITOR.replace('specification',	{	});    CKEDITOR.disableAutoInline = false;});
// jQuery(document).ready(function () {
// 	"use strict";
// 	CKEDITOR.replace('howtouse',
// 	{
// 	});
//     CKEDITOR.disableAutoInline = false;
// });
// jQuery(document).ready(function () {
// 	"use strict";
// 	CKEDITOR.replace('ingredients',
// 	{
// 	});
//     CKEDITOR.disableAutoInline = false;
// });
// jQuery(document).ready(function () {
// 	"use strict";
// 	CKEDITOR.replace('funfacts',
// 	{
// 	});
//     CKEDITOR.disableAutoInline = false;
// });

</script>


	<script>

	 function singledelete(url)
	 {
		 window.location.href=url;
	 }
	</script>


 Man