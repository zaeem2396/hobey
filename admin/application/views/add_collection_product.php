<?php include('include/header.php');?>
<link href="<?php echo $base_url_views; ?>css/fSelect.css" rel="stylesheet">
<link href="<?php echo $base_url_views; ?>css/mediaBoxes.css" rel="stylesheet">
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
  <section id="content_wrapper">
   <div id="topbar">
      <div class="topbar-left">
         <ol class="breadcrumb" id="breadcrumb">
            
            <li class="crumb-icon"><a href="<?php echo $base_url; ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="crumb-link"><a href="<?php echo $base_url; ?>collection_product/lists">Product</a></li>
            <li class="crumb-active"><a href="javascript:void(0);">Add Collection Product</a></li>
         </ol>
      </div>
   </div>
   <div id="content">
      <div class="row">
          <form role="form" id="form" method="post" action="<?php echo $base_url;?>collection_product/add" enctype="multipart/form-data">
		 <div class="col-md-12">
            <div class="panel">
               <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Add Collection Product </span> </div>
               <div class="panel-body">
                  <?php if($this->session->flashdata('L_strErrorMessage'))
                     { ?>
                  <div class="alert alert-success alert-dismissable">
                     <i class="fa fa-check"></i>
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     <b>Success!</b> <?php echo $this->session->flashdata('L_strErrorMessage'); ?>
                  </div>
                  <?php }  ?>
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
                        <INPUT TYPE="hidden" NAME="action" VALUE="add_collection_product">
                        <INPUT TYPE="hidden" NAME="is_col_product" VALUE="1">
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="name">Product Name <span color="red">*</span></label>
                               <input id="name" name="material_name" type="text" class="form-control" placeholder="Enter Product Name"  />
                               <span id="productnameerror" class="valierror"></span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="name">Vendor Name <span color="red">*</span></label>
                               <input id="vendorname" name="vendorname" type="text" class="form-control" placeholder="Enter Vendor Name"  />
                               <span id="vendornameerror" class="valierror"></span>
                            </div>
                        </div>
                       
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="weight">Weight<span color="red">*</span></label>
                               <input id="weight" name="weight" type="text" class="form-control" placeholder="Enter Weight " value=""/>
                               <span id="weighterror" class="valierror"></span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="quantity">Quantity<span color="red">*</span></label>
                               <input id="quantity" name="quantity" type="text" class="form-control" placeholder="Enter Quantity" value=""/>
                               <span id="quantityerror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="price">MRP<span color="red">*</span></label>
                               <input id="mrp" name="mrp" type="text" class="form-control" placeholder="Enter MRP " value=""/>
                               <span id="priceerror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="price">Special Price<span color="red">*</span></label>
                               <input id="price" name="price" type="text" class="form-control" placeholder="Enter Special Price " value=""/>
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
                                    		<option value="<?php echo $cityshow->id; ?>"><?php echo $cityshow->name; ?></option>
                                    <?php } } ?>
                                  </select>
                             </div>
                         </div>

                         <div class="col-md-6">
                            <div class="form-group">
                               <label for="d_buy_price">Distributor buying price<span color="red">*</span></label>
                               <input id="d_buy_price" name="d_buy_price" type="text" class="form-control" placeholder="Enter Distributor buying price " value=""/>
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
   </div>
</section>    
  <!-- End: Content -->


 <?php include('include/sidebar_right.php');?>
 </div>
<!-- End #Main -->
<?php include('include/footer.php')?>

<script type="text/javascript" src="<?php echo $base_url_views; ?>ckeditor/ckeditor.js"></script>

<script>
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
function subcategory(cid)
{
	var multipleValues = $( "#category_id" ).val() || [];
	var sid="";
	var url = '<?php echo $base_url ?>product/show_subcategory';
	$.ajax({
	url:url,
	type:'post',
	data:'cid='+multipleValues+'&sid='+sid,
	success:function(msg)
	{
		document.getElementById('prod2').innerHTML = msg ;
	}
	});
	
	
	var url = '<?php echo $base_url ?>collection_product/show_input';
	$.ajax({
		url:url,
		type:'post',
		data:'cid='+multipleValues+'&pro_id=',
		success:function(msg)
		{
			$('#subcatefory_id').multiselect({
				columns: 1,
				selectedOptions: 'PHP',
				placeholder: 'Select Subcategory'
			});
			document.getElementById('prod_input').innerHTML = msg;
			/* $('.jquery_ckeditor').ckeditor(); */
			/* CKEDITOR.replaceClass('input_value');*/
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

</script>


<script type="text/javascript">
// jQuery(document).ready(function () {
//     "use strict";
//     CKEDITOR.replace('desc',{});
//     CKEDITOR.disableAutoInline = false;
// });
</script>
</body>
</html>



<script>
    $(function() {
        $("#name").keyup(function(){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
        $("#page_url").val(Text);
        });

        });
</script>