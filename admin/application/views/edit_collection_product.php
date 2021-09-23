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
            <li class="crumb-link"><a href="<?php echo $base_url; ?>collection_product/lists">Product</a></li>
            <li class="crumb-active"><a href="javascript:void(0);"> Edit Product </a></li>
         </ol>
      </div>
   </div>
   <div id="content">
      <div class="row">
        <form role="form" id="form" method="post" action="<?php echo $base_url;?>collection_product/edit/<?php echo $id; ?>" enctype="multipart/form-data" >
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
                        <INPUT TYPE="hidden" NAME="action" VALUE="edit_collection_product">
                        <INPUT TYPE="hidden" NAME="hiddenaction" VALUE="<?php echo $id;?>">
                        <INPUT TYPE="hidden" NAME="is_col_product" VALUE="1">
                                       
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="name">Product Name <span color="red">*</span></label>
                               <input id="name" name="material_name" type="text" class="form-control" placeholder="Enter Product Name" value="<?php echo $material_name; ?>" />
                               <span id="productnameerror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="name">Vendor Name <span color="red">*</span></label>
                               <input id="vendorname" name="vendorname" type="text" class="form-control" placeholder="Enter Vendor Name" value="<?php echo $vendorname; ?>" />
                               <span id="vendornameerror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="weight">Weight<span color="red">*</span></label>
                               <input id="weight" name="weight" type="text" class="form-control" placeholder="Enter Weight " value="<?php echo $weight; ?>"/>
                               <span id="weighterror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="quantity">Quantity<span color="red">*</span></label>
                               <input id="quantity" name="quantity" type="text" class="form-control" placeholder="Enter Quantity" value="<?php echo $quantity; ?>"/>
                               <span id="quantityerror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="price">MRP<span color="red">*</span></label>
                               <input id="mrp" name="mrp" type="text" class="form-control" placeholder="Enter MRP " value="<?php echo $mrp; ?>"/>
                               <span id="mrperror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="price">Price<span color="red">*</span></label>
                               <input id="price" name="price" type="text" class="form-control" placeholder="Enter Price " value="<?php echo $price; ?>"/>
                               <span id="priceerror" class="valierror"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                                <div class="form-group">
								<label for="city_id">Select District</label>
                                  <select id="city_id" name="city_id" class="form-control">
                                    <option value="">Select District</option>
                                    <?php if($allcity !='')
                                    {
                                        foreach($allcity as $cityshow)
                                        { ?>
                                    		<option value="<?php echo $cityshow->id; ?>" <?php if($city_id == $cityshow->id ) { echo "selected"; } ?>><?php echo $cityshow->name; ?></option>
                                    <?php } } ?>
                                  </select>
                             </div>
                         </div>

                         <div class="col-md-6">
                            <div class="form-group">
                               <label for="d_buy_price">Distributor buying price<span color="red">*</span></label>
                               <input id="d_buy_price" name="d_buy_price" type="text" class="form-control" placeholder="Enter Distributor buying price " value="<?php echo $d_buy_price; ?>"/>
                               <span id="d_buy_priceerror" class="valierror"></span>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                               <input class="submit btn bg-purple pull-right" type="submit" value="Submit" onclick="javascript:validate();return false;"/>
                               <a href="<?php echo $base_url;?>collection_product/lists" class="submit btn btn-danger pull-right" style="margin-right: 10px;" />Cancel</a>
                            </div>
                        </div>  
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
      $(wrapper).append('<div class="customer_records"><div class="row"><div class="col-md-4"><div class="form-group"><select id="state_id'+b+'" name="state_id1[]" onchange="get_group1(this.value,'+b+');"  class="form-control"><option value="">Select State*</option><?php if($allstate !='') { foreach($allstate as $stateshow)   {   ?> <option value="<?php echo $stateshow->id; ?>"><?php echo $stateshow->name; ?></option>   <?php } } ?>     </select>  </div></div> <div class="col-md-4"> <div class="form-group"><span id="prod1'+b+'"><select id="city_id" name="city_id1[]" class="form-control"> <option value="">Select City*</option></select> </span></div>  </div> <div class="col-md-4"><div class="form-group"><span id="prod2'+b+'"><select id="area_id" name="area_id1[]" class="form-control"><option value="">Select Area*</option></select></span></div></div><div class="col-md-4"><div class="form-group"><span id="prod3'+b+'"><select id="pincode_id" name="pincode_id1[]" class="form-control"><option value="">Select Pincode*</option></select></span></div> </div> <div class="col-md-6"><div class="form-group"><input id="inventory" name="inventory1[]" type="text" required="required" class="form-control" value="" placeholder="Inventory*"> </div></div>  <a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 0px; margin-top: 24px;">Remove</a></div></div>');
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
    
    var title = $("#name").val();
   
   if(title == ''){
       $("#productnameerror").html("Please Enter Product Name.");
       jQuery('#productnameerror').show().delay(0).fadeIn('show');
       jQuery('#productnameerror').show().delay(2000).fadeOut('show');
       document.getElementById("breadcrumb").scrollIntoView(true); 
       return false;
   }
  var weight = $("#weight").val();

if(weight == ''){
  $("#weighterror").html("Please Enter Weight.");
  jQuery('#weighterror').show().delay(0).fadeIn('show');
  jQuery('#weighterror').show().delay(2000).fadeOut('show');
  document.getElementById("breadcrumb").scrollIntoView(true); 
  return false;
}

var price = $("#price").val();

if(price == ''){
  $("#priceerror").html("Please Enter Price.");
  jQuery('#priceerror').show().delay(0).fadeIn('show');
  jQuery('#priceerror').show().delay(2000).fadeOut('show');
  document.getElementById("breadcrumb").scrollIntoView(true); 
  return false;
}

var quantity = $("#quantity").val();

if(quantity == ''){
  $("#quantityerror").html("Please Enter Quantity.");
  jQuery('#quantityerror').show().delay(0).fadeIn('show');
  jQuery('#quantityerror').show().delay(2000).fadeOut('show');
  document.getElementById("breadcrumb").scrollIntoView(true); 
  return false;
}
var d_buy_price = $("#d_buy_price").val();
   
   if(d_buy_price == ''){
      $("#d_buy_priceerror").html("Please Enter Distributor buying price.");
      jQuery('#d_buy_priceerror').show().delay(0).fadeIn('show');
      jQuery('#d_buy_priceerror').show().delay(2000).fadeOut('show');
      document.getElementById("breadcrumb").scrollIntoView(true); 
      return false;
   }
    		
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
});jQuery(document).ready(function () {	"use strict";	Core.init();	Ajax.init();	CKEDITOR.replace('specification',	{	});    CKEDITOR.disableAutoInline = false;});
jQuery(document).ready(function () {
	"use strict";
	CKEDITOR.replace('howtouse',
	{
	});
    CKEDITOR.disableAutoInline = false;
});
jQuery(document).ready(function () {
	"use strict";
	CKEDITOR.replace('ingredients',
	{
	});
    CKEDITOR.disableAutoInline = false;
});
jQuery(document).ready(function () {
	"use strict";
	CKEDITOR.replace('funfacts',
	{
	});
    CKEDITOR.disableAutoInline = false;
});

</script>


	<script>

	 function singledelete(url)
	 {
		 window.location.href=url;
	 }
	</script>


