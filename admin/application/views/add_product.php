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
            <li class="crumb-link"><a href="<?php echo $base_url; ?>product/lists">Product</a></li>
            <li class="crumb-active"><a href="javascript:void(0);">Add Product</a></li>
         </ol>
      </div>
   </div>
   <div id="content">
      <div class="row">
          <form role="form" id="form" method="post" action="<?php echo $base_url;?>product/add" enctype="multipart/form-data">
		 <div class="col-md-12">
            <div class="panel">
               <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Add Product </span> </div>
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
                        <INPUT TYPE="hidden" NAME="action" VALUE="add_product">
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="vendor_id">Vendor <span color="red">*</span></label>			                    
                               <select id="vendor_id" name="vendor_id" class="form-control">
                                  <option value="">Select Vendor</option>
                                  <?php  if($allvendor !='' && count($allvendor) > 0){ 						  foreach($allvendor as $vend){ ?>					
                                  <option value="<?php echo $vend->id; ?>"><?php echo $vend->company_name; ?></option>
                                  <?php } }  ?>			  				  
                               </select>
                               <span id="vendorerror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="name">Product Name <span color="red">*</span></label>
                               <input id="name" name="name" type="text" class="form-control" placeholder="Enter Product Name"  />
                               <span id="productnameerror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="page_url">Page Url <span color="red">*</span></label>
                               <input id="page_url" name="page_url" type="text" class="form-control" placeholder="Enter Page Url " value=""/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="sku_code">GST <span color="red">*</span></label>
                               <select id="gst" name="gst" class="form-control">
                                <option value="">Select GST</option>
                                <option value="0">0&#37;</option>
                                <option value="5">5&#37;</option>
                                <option value="12">12&#37;</option>
                                <option value="18">18&#37;</option>
                                <option value="28">28&#37;</option>
                                </select>
                                <span id="gsterror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-4" style="display: none">
                            <div class="form-group">
                               <label for="wllness_category_id">Wellness Category</label>
                               <select id="wllness_category_id" name="wllness_category_id[]" multiple class="form-control">
                                  <option value="">Select Wellness Category</option>
                                  <?php  if($allwellness_category !='' && count($allwellness_category) > 0){
                                     foreach($allwellness_category as $wellness_category){ ?>
                                  <option value="<?php echo $wellness_category->id; ?>"><?php echo $wellness_category->name; ?></option>
                                  <?php } }  ?>
                               </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                               <label for="category_id">Category <span color="red">*</span></label>
                               <span id="prod1">
                                   <select id="category_id" name="category_id[]"  onchange="subcategory(this.value);" multiple class="form-control">
                                        
                                         <?php  if($allcategory !='' && count($allcategory) > 0){
                                            foreach($allcategory as $category){ ?>
                                         <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                         <?php } }  ?>
                                    </select>

                                  <!-- select id="category_id" name="category_id[]"  onchange="subcategory(this.value);" multiple class="form-control" style="display: none">
                                     <option value="">Select Category</option>
                                     <?php  if($allcategory !='' && count($allcategory) > 0){
                                        foreach($allcategory as $category){ ?>
                                     <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                     <?php } }  ?>
                                  </select -->
                                  <span id="caterror" class="valierror"></span>
                               </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                               <label for="subcatefory_id">Subcategory</label>
                               <span id="prod2">
                                  <select id="subcatefory_id" name="subcatefory_id[]" multiple class="form-control">
                                     <!--<option value="">Select Subcategory</option>-->
                                     <?php  if($allsubcategory !='' && count($allsubcategory) > 0){
                                        foreach($allsubcategory as $subcategory){ ?>
                                     <option value="<?php echo $subcategory->id; ?>"><?php echo $subcategory->name; ?></option>
                                     <?php } }  ?>
                                  </select>
                               </span>
                            </div>
                        </div>
						<input id="is_perishable" name="is_perishable" type="hidden"  placeholder="" value="0"  />
                        <!--div class="col-md-4">
                         <div class="form-group" style="margin-top: 25px">
                             <p><input id="is_perishable" name="is_perishable" type="checkbox"  placeholder="" value="1" <?php if($is_perishable == '1'){ ?> checked='checked' <?php } ?> /> <label for="hsn_code" style="font-size: 20px;color: #055b57;font-weight: 700;"> Perishable Product</label></p>
                          
                          
                          </div>
                        </div -->
                        <!--<div class="form-group rfa_multiple_select">                  <label for="sampleMutdsd" >Select Pincode</label>                  <select id="sampleMut" name="pincode[]" multiple="multiple" type="text" class="form-control multiple-select col-sm-12">				  <option value=""> Select Pincode </option>				<?php if($allpincode!='')				{					foreach($allpincode as $ser)					{				  ?>				   <option value="<?php echo $ser->id; ?>"><?php echo $ser->pincode; ?></option>				   <?php } } ?>				  </select>                </div> 				</br> </br> -->												
                        
                        <div class="col-md-12">
                            <h4>Add Price</h4>
                           <div class="col-md-1">
                              <div class="form-group">
                                 <label for="categoryname">Type </label><br>
                                 <input type="radio" value="1" onclick="get_hide_show(this.value);" checked name="gram_size[]" id="gram_size" > Size &nbsp;<br>
                                 <input type="radio" value="2" onclick="get_hide_show(this.value);" name="gram_size[]" id="gram_size" >  GM &nbsp;<br>
                                 <input type="radio" value="3" onclick="get_hide_show(this.value);" name="gram_size[]" id="gram_size" >  ML<br>
                                 <input type="radio" value="4" onclick="get_hide_show(this.value);" name="gram_size[]" id="gram_size" >  Ltr &nbsp;<br>
                                 <input type="radio" value="5" onclick="get_hide_show(this.value);" name="gram_size[]" id="gram_size" >  Units &nbsp;<br>
                                 <input type="radio" value="6" onclick="get_hide_show(this.value);" name="gram_size[]" id="gram_size" >  CM<br>
                                 <input type="radio" value="7" onclick="get_hide_show(this.value);" name="gram_size[]" id="gram_size" >  KG<br>
                              </div>
                           </div>
                           <div id="hide_size">
                              <div class="col-md-1" >
                                 <div class="form-group">
                                    <label for="categoryname">Size </label>
                                    <select id="size" name="size[]"  class="form-control jobtext" >
                                       <option value="" selected>Select Size</option>
                                       <?php if($allsize != ''){
                                          for($k=0;$k<count($allsize);$k++)								{								?>
                                       <option value='<?php echo $allsize[$k]->id; ?>'><?php echo $allsize[$k]->name; ?>
                                       </option>
                                       <?php } } ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div id="hide_gram" style="display:none;">
                              <div class="col-md-1" >
                                 <div class="form-group">
                                    <label for="gram">Gram </label>
                                    <input type="text" class="form-control jobtext" id="gram" placeholder="Gram" name="gram[]" >								
                                 </div>
                              </div>
                           </div>
                           <div id="hide_ml" style="display:none;">
                              <div class="col-md-1" >
                                 <div class="form-group">
                                    <label for="gram">ML </label>
                                    <input type="text" class="form-control jobtext" id="ml" placeholder="ML" name="ml[]" >
                                 </div>
                              </div>
                           </div>
                           <div id="hide_ltr" style="display:none;">
                              <div class="col-md-1" >
                                 <div class="form-group">
                                    <label for="ltr">Ltr </label>
                                    <input type="text" class="form-control jobtext" id="ltr" placeholder="Ltr" name="ltr[]" >
                                 </div>
                              </div>
                           </div>
                           <div id="hide_units" style="display:none;">
                              <div class="col-md-1" >
                                 <div class="form-group">
                                    <label for="units">Units</label>
                                    <input type="text" class="form-control jobtext" id="units" placeholder="Units" name="units[]" >
                                 </div>
                              </div>
                           </div>
                           <div id="hide_cm" style="display:none;">
                              <div class="col-md-1" >
                                 <div class="form-group">
                                    <label for="cm">CM</label>
                                    <input type="text" class="form-control jobtext" id="cm" placeholder="CM" name="cm[]" >
                                 </div>
                              </div>
                           </div>
                           <div id="hide_kg" style="display:none;">
                              <div class="col-md-1" >
                                 <div class="form-group">
                                    <label for="kg">KG</label>
                                    <input type="text" class="form-control jobtext" id="kg" placeholder="KG" name="kg[]" >
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="form-group">
                                 <label for="categoryname">Colour </label>							 
                                 <select id="colour" name="colour[]" class="form-control jobtext" >
                                    <option value="" selected>Select Colour</option>
                                    <?php if($allcolour != ''){for($k=0;$k<count($allcolour);$k++){?>									
                                    <option value='<?php echo $allcolour[$k]->id; ?>'><?php echo $allcolour[$k]->colour; ?>										</option>
                                    <?php } } ?>								
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="form-group">
                                 <label for="categoryname"> Price</label>   							
                                 <input id="price" name="price[]" type="text" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" class="form-control" placeholder="Enter Price" />
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="form-group">
                                 <label for="qty">Qty</label>
                                 <input id="qty" name="qty[]" type="text" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" class="form-control" placeholder="Enter Qty" />
                              </div>
                           </div>
                           <div class="col-md-2">
                            <div class="form-group">
                               <label for="sku_code">Sku Code.</label>    
                               <input id="sku_code" name="sku_code[]" type="text" class="form-control" placeholder="Enter Sku Code" value="" />
                            </div>
                         </div>
                           <div class="col-md-2">
                              <div class="form-group">
                                 <label for="discount">Discount (%)</label>
                                 <input id="discount0" name="discount[]" onkeyup="blockvalue_p(0);" type="text" class="form-control" maxlength="2" placeholder="Enter Discount" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" />
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="form-group">
                                 <label for="discount_price">Discount Price</label>
                                 <input id="discount_price0" name="discount_price[]" onkeyup="blockvalue_d(0);" type="text" class="form-control" placeholder="Enter Discount Price" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" />
                              </div>
                           </div>
					    
						   <div class="col-md-2">
                              <div class="form-group">
                                 <label for="length">Packing Length (CM)</label>
                                 <input id="length0" name="length[]" type="text" class="form-control" placeholder="Enter Length" onchange="calvolweight(0);" />
                              </div>
                           </div>
						   <div class="col-md-2">
                              <div class="form-group">
                                 <label for="height">Packing Height (CM)</label>
                                 <input id="height0" name="height[]" type="text" class="form-control" placeholder="Enter Height" onchange="calvolweight(0);" />
                              </div>
                           </div>
						   <div class="col-md-2">
                              <div class="form-group">
                                 <label for="width">Packing Width (CM)</label>
                                 <input id="width0" name="width[]" type="text" class="form-control" placeholder="Enter Width" onchange="calvolweight(0);" />
                              </div>
                           </div>
						   <div class="col-md-2">
                              <div class="form-group">
                                 <label for="volweight">Volumertic Weight(kg)</label>
                                 <input id="volweight0" name="volweight[]" type="text" class="form-control" placeholder="Enter Volumertic Weight" />
                              </div>
                           </div>
						   <div class="col-md-2">
                              <div class="form-group">
                                 <label for="weight">Packing Weight (kg)</label>
                                 <input id="weight0" name="weight[]" type="text" class="form-control" placeholder="Enter Weight" />
                              </div>
                           </div>

                        </div>
                        <div class="input_fields_wrap12">
                        </div>
                        <div class="form-group">
                           <div class="col-sm-12">
                              <button style="border: medium none; margin-right: 0px; line-height: 23px; margin-top: -30px;" class="submit btn bg-purple pull-right" type="button" id="add_field_button12">Add Price </button>								
                           </div>
                        </div>
                        <script>										function get_hide_show(id)
                           {
                                 if(id == 1){
                                   $("#hide_size").css("display", "block");
                                   $("#hide_gram").css("display", "none");
                                   $("#hide_ml").css("display", "none");
                                   $("#hide_ltr").css("display", "none");
                                   $("#hide_units").css("display", "none");
                                   $("#hide_cm").css("display", "none");
                                   $("#hide_kg").css("display", "none");
                           
                           
                                 }else if(id == 2)
                                 {
                                   $("#hide_size").css("display", "none");
                                   $("#hide_gram").css("display", "block");
                                   $("#hide_ml").css("display", "none");
                                   $("#hide_ltr").css("display", "none");
                                   $("#hide_units").css("display", "none");
                                   $("#hide_cm").css("display", "none");
                                   $("#hide_kg").css("display", "none");
                           
                                 }
                                 else if(id == 3)
                                 {
                                   $("#hide_size").css("display", "none");
                                   $("#hide_gram").css("display", "none");
                                   $("#hide_ml").css("display", "block");
                                   $("#hide_ltr").css("display", "none");
                                   $("#hide_units").css("display", "none");
                                   $("#hide_cm").css("display", "none");
                                   $("#hide_kg").css("display", "none");
                                 }
                                 else if(id == 4)
                                 {
                                   $("#hide_size").css("display", "none");
                                   $("#hide_gram").css("display", "none");
                                   $("#hide_ml").css("display", "none");
                                   $("#hide_ltr").css("display", "block");
                                   $("#hide_units").css("display", "none");
                                   $("#hide_cm").css("display", "none");
                                   $("#hide_kg").css("display", "none");
                           
                                 }else if(id == 5)
                                 {
                                   $("#hide_size").css("display", "none");
                                   $("#hide_gram").css("display", "none");
                                   $("#hide_ml").css("display", "none");
                                   $("#hide_ltr").css("display", "none");
                                   $("#hide_units").css("display", "block");
                                   $("#hide_cm").css("display", "none");
                                   $("#hide_kg").css("display", "none");
                                 }else if(id == 6)
                                 {
                                       $("#hide_size").css("display", "none");
                                       $("#hide_gram").css("display", "none");
                                       $("#hide_ml").css("display", "none");
                                       $("#hide_ltr").css("display", "none");
                                       $("#hide_units").css("display", "none");
                                       $("#hide_cm").css("display", "block");
                                       $("#hide_kg").css("display", "none");
                                 }
                                 else
                                 {
                                       $("#hide_size").css("display", "none");
                                       $("#hide_gram").css("display", "none");
                                       $("#hide_ml").css("display", "none");
                                       $("#hide_ltr").css("display", "none");
                                       $("#hide_units").css("display", "none");
                                       $("#hide_cm").css("display", "none");
                                       $("#hide_kg").css("display", "block");
                                 }
                           }
                        </script>
                        <?php /* <div class="form-group">
                           <label for="discount"> Discount</label>
                           <input id="discount" name="discount" type="text" class="form-control" placeholder="Enter Discount" />
                           </div>	*/ ?>
                        <!-- div class="col-md-4">
                            <div class="form-group">
                               <label for="gst">GST</label>
                               <select id="gst" name="gst" class="form-control">
                                  <option value="">Select GST</option>
                                  <option value="0" <?php if($gst == '0'){?> selected='selected' <?php } ?>>0%</option>
                                  <option value="5" <?php if($gst == '5'){?> selected='selected' <?php } ?>>5%</option>
                                  <option value="12" <?php if($gst == '12'){?> selected='selected' <?php } ?>>12%</option>
                                  <option value="18" <?php if($gst == '18'){?> selected='selected' <?php } ?>>18%</option>
                                  <option value="28" <?php if($gst == '28'){?> selected='selected' <?php } ?>>28%</option>
                               </select>
                               <span id="gsterror" class="valierror"></span>
                            </div>
                        </div -->
                        
						<!-- div class="col-md-3">
                            <div class="form-group">
                               <label for="length">Packing Length (CM)</label>
                               <input id="length" name="length" type="text" class="form-control" placeholder="Enter Packing Length" />
                            </div>
                        </div>
						<div class="col-md-3">
                            <div class="form-group">
                               <label for="height">Packing Height (CM)</label>
                               <input id="height" name="height" type="text" class="form-control" placeholder="Enter Packing Height" />
                            </div>
                        </div>
						<div class="col-md-3">
                            <div class="form-group">
                               <label for="breadth">Packing Width (CM)</label>
                               <input id="breadth" name="breadth" type="text" class="form-control" placeholder="Enter Packing Width" />
                            </div>
                        </div>
						
						<div class="col-md-3">
                            <div class="form-group">
                               <label for="weight">Packing Weight (Grams)</label>
                               <input id="weight" name="weight" type="text" class="form-control" placeholder="Enter Packing Weight" />
                            </div>
                        </div -->

                         <div class="col-md-6">
                            <div class="form-group">
                               <label for="hsn_code">HSN Code</label>
                               <input id="hsn_code" name="hsn_code" type="text" class="form-control" placeholder="Enter HSN Code" />
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                               <label for="vendor_percentage">Vendor Percentage</label>
                               <input id="vendor_percentage" name="vendor_percentage" type="text" class="form-control" placeholder="Enter Vendor Percentage" value="25" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="video_url">Video Url</label>
                               <input id="video_url" name="video_url" type="text" class="form-control" placeholder="Enter Video Url"/>
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="form-group">
                               <label for="countryorigin">Country of Origin</label>
                               <input id="countryorigin" name="countryorigin" type="text" class="form-control" placeholder="Enter Country of Origin"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                               <label for="short_desc">Short Description</label>
                               <textarea id="short_desc" name="short_desc" class="form-control" placeholder="Enter Short Description" style="height: 34px;"></textarea>                
                            </div>
                        </div>

						



                        <div class="col-md-12">
                            <div class="form-group">
                               <span id="prod_input"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="funfacts" style="margin:15px 0 5px 0px; width:100%;">FAQs</label>
                               <textarea id="funfacts" name="funfacts" class="form-control" placeholder="Enter Fun Facts"></textarea>
                            </div>
                        </div>
                         
                         <div class="col-md-6">
                            <div class="form-group">
                               <label for="desc" style="margin:15px 0 5px 0px; width:100%;"> Description</label>
                               <textarea id="desc" name="description" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                               <label for="specification" style="margin:15px 0 5px 0px; width:100%;">Specification </label>
                               <textarea id="specification" name="specification" class="form-control" placeholder="Enter Specification"></textarea>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                               <label for="howtouse" style="margin:15px 0 5px 0px; width:100%;">How To Use</label>
                               <textarea id="wash_and_care" name="howtouse" class="form-control" placeholder="Enter How To Use"></textarea>                
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                               <label for="specification" style="margin:15px 0 5px 0px; width:100%;">Ingredients </label>
                               <textarea id="ingredients" name="ingredients" class="form-control" placeholder="Enter ingredients"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
							<div class="form-group" id="filter_group_section">
							   <label >Filters</label>
							   <?php
								  foreach($allfilter as $filter_group){
								  ?>
							   <div id="filter-group-div-<?php echo $filter_group['id']?>"  class="filter-group filter-group-subcat-<?php echo $filter_group['subcat_id']?> filter-milan" style="display:none;">
								  <label ><?php echo $filter_group['name'] ?></label>
								  <?php
									 foreach($filter_group['filters_value'] as $filter){
									 ?>
								  <br>
								  <input name="product_filter[]" type="checkbox" value="<?php echo $filter['id']?>"> <?php echo $filter['name']?>
								  <?php
									 }
									 ?>
							   </div>
							   <?php
								  }
								  ?>
							</div>
                        </div>
                        <div class="col-md-12">
                            <label>Keywords</label>
                            <br>
                            <div class="form-group" id="filter_group_section">
                               
                               <?php
                                  $keywords_array = explode(',',$keywords_filter);
                                  foreach($getkeywordsname as $filter_group){
                                      $checked = "";
                                  if(in_array($filter_group['id'], $keywords_array)){
                                  $checked = "checked";
                                  }
                                  ?>
                               <div id="filter-group-div1-<?php echo $filter_group['id']?>"  class="filter-group1 filter-group-subcat1-<?php echo $filter_group['service_id'];?> filter-milan" style="display:none;">
                                  <label ><input name="keywords_filter[]" <?php echo $checked ?> type="checkbox" value="<?php echo $filter_group['id']?>"> <?php echo $filter_group['keywords'] ?></label>
                               </div>
                               <?php
                                  }
                                  ?>
                            </div>
                        </div>

				<div class="col-md-12">
				    <h4>Badges</h4>
					 <div class="form-group badges-div">
						<?php if($allbadges != '' && count($allbadges) > 0){ ?> 
							<?php 
							$badgesfilarray = explode(',',$badgesfil);
							foreach($allbadges as $badges){ ?> 
								<input name="badgesfil[]" <?php if(in_array($badges->id, $badgesfilarray)){ ?> checked='checked' <?php } ?> type="checkbox" value="<?php echo $badges->id; ?>" style=" margin-right: 6px;"> <img src="<?php echo $front_base_url."upload/badges/".$badges->image; ?>" style="    max-width: 60px;"/>
							<?php } ?>
						<?php }?>
					 </div>
				 </div>

                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="short_desc">Tags</label>
                               <textarea id="tags" name="tags" class="form-control" placeholder="Tags"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="short_desc">Meta Title</label>
                               <textarea id="metatitle" name="metatitle" class="form-control" placeholder="Meta Title"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="short_desc">Meta Keywords</label>
                               <textarea id="metakeywords" name="metakeywords" class="form-control" placeholder="Meta Keywords"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="short_desc">Meta Description</label>
                               <textarea id="metadescription" name="metadescription" class="form-control" placeholder="Meta Description"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                               <input class="submit btn bg-purple pull-right" type="submit" value="Submit" onclick="javascript:validate();return false;"/>
                               <a href="<?php echo $base_url;?>product/lists" class="submit btn btn-danger pull-right" style="margin-right: 10px;" />Cancel</a>
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
	
	
	var url = '<?php echo $base_url ?>product/show_input';
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
     var vendor_id = $("#vendor_id").val();
     if(vendor_id == ''){
   		$("#vendorerror").html("Please Select Vendor Name.");
   		jQuery('#vendorerror').show().delay(0).fadeIn('show');
   		jQuery('#vendorerror').show().delay(2000).fadeOut('show');
   		document.getElementById("breadcrumb").scrollIntoView(true); 
   		return false;
   	 }    
        
    var title = $("#name").val();
   
   	if(title == ''){
   		$("#productnameerror").html("Please Enter Product Name.");
   		jQuery('#productnameerror').show().delay(0).fadeIn('show');
   		jQuery('#productnameerror').show().delay(2000).fadeOut('show');
   		document.getElementById("breadcrumb").scrollIntoView(true); 
   		return false;
   	}
   	  
   	var category_id = $("#category_id").val();
   	if(category_id == ''){
   		$("#caterror").html("Please Select Category.");
   		jQuery('#caterror').show().delay(0).fadeIn('show');
   		jQuery('#caterror').show().delay(2000).fadeOut('show');
   		document.getElementById("breadcrumb").scrollIntoView(true); 
   		return false;
   	}
   	
    var gst = $("#gst").val();
   	if(gst == ''){
   		$("#gsterror").html("Please Select GST.");
   		jQuery('#gsterror').show().delay(0).fadeIn('show');
   		jQuery('#gsterror').show().delay(2000).fadeOut('show');
   		document.getElementById("breadcrumb").scrollIntoView(true); 
   		return false;
   	}
   	
        /*var vendor_id = $("#vendor_id").val();
        if(vendor_id == ''){
            $("#error_msg1").html("Please Select Vendor.");
            $("#validator").css("display","block");
            return false;
        }
        var title = $("#name").val();
        if(title == ''){
        $("#error_msg1").html("Please Enter Product Name.");
        $("#validator").css("display","block");
        return false;
        }

        var category_id = $("#category_id").val();
        if(category_id == ''){
            $("#error_msg1").html("Please Select Category.");
            $("#validator").css("display","block");
            return false;
            }

        var subcatefory_id = $("#subcatefory_id").val();
        if(subcatefory_id == ''){
        $("#error_msg1").html("Please Select Sub Category.");
        $("#validator").css("display","block");
        return false;
        }*/
        
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
jQuery(document).ready(function () {
    "use strict";
    CKEDITOR.replace('desc',{});
    CKEDITOR.disableAutoInline = false;
});
jQuery(document).ready(function () {
    "use strict";
    CKEDITOR.replace('wash_and_care',{});
    CKEDITOR.disableAutoInline = false;
});

jQuery(document).ready(function () {
    "use strict";
    CKEDITOR.replace('specification',{});
    CKEDITOR.disableAutoInline = false;
});
jQuery(document).ready(function () {
    "use strict";
    CKEDITOR.replace('ingredients',{});
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
</body>
</html>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
    var max_fields      = 50;
    var wrapper         = $(".input_fields_wrap12");
    var add_button      = $("#add_field_button12");

    $(document).on('change', '#subcatefory_id', function() {
        $('.filter-group').hide();
        $('.filter-group1').hide();
        $('#subcatefory_id :selected').each(function(){
            $('.filter-group-subcat-'+ $(this).val()).show();
            $('.filter-group-subcat1-'+ $(this).val()).show();
        });
        
        $('#category_id :selected').each(function(){
            $('.filter-group-cat-'+ $(this).val()).show();
            $('.filter-group-cat1-'+ $(this).val()).show();
        });
    });

    var b = 0;
    $(add_button).click(function(e){
    e.preventDefault();
    if(b < max_fields){
    b++;
      $(wrapper).append('<div class="col-md-12"><div class="col-md-1"><input type="hidden" value="" name="gram_size[]" id="gram_size_hidden'+b+'" ><div class="form-group"><label for="categoryname">Type </label><br><input type="radio" value="1" onclick="get_hide_show1(this.value,'+b+');" checked name="gram_size1'+b+'[]" id="gram_size1'+b+'" > Size &nbsp;<br><input type="radio" value="2" onclick="get_hide_show1(this.value,'+b+');" name="gram_size1'+b+'[]" id="gram_size1'+b+'"> GM &nbsp;<br><input type="radio" value="3" onclick="get_hide_show1(this.value,'+b+');" name="gram_size1'+b+'[]" id="gram_size1'+b+'" > ML &nbsp;<br><input type="radio" value="4" onclick="get_hide_show1(this.value,'+b+');" name="gram_size1'+b+'[]" id="gram_size1'+b+'" > Ltr &nbsp;<br><input type="radio" value="5" onclick="get_hide_show1(this.value,'+b+');" name="gram_size1'+b+'[]" id="gram_size1'+b+'" > Units &nbsp;<br> <input type="radio" value="6" onclick="get_hide_show1(this.value,'+b+');" name="gram_size1'+b+'[]" id="gram_size1'+b+'" > CM &nbsp;<br><input type="radio" value="7" onclick="get_hide_show1(this.value,'+b+');" name="gram_size1'+b+'[]" id="gram_size1'+b+'" > KG &nbsp;<br></div></div><div id="hide_size'+b+'"><div class="col-md-1" ><div class="form-group"><label for="categoryname">Size </label><select id="size" name="size[]"  class="form-control jobtext" ><option value="" selected>Select Size</option><?php	if($allsize != ""){	for($k=0;$k<count($allsize);$k++) { ?>	<option value="<?php echo $allsize[$k]->id; ?>"><?php echo $allsize[$k]->name; ?></option>	<?php } } ?></select></div>	</div></div><div id="hide_gram'+b+'" style="display:none;"><div class="col-md-1" ><div class="form-group"><label for="gram">Gram </label><input type="text" class="form-control jobtext" id="gram" placeholder="Gram" name="gram[]" >	</div>	</div></div><div id="hide_ml'+b+'" style="display:none;"><div class="col-md-2" >	<div class="form-group"><label for="gram">ML </label><input type="text" class="form-control jobtext" id="ml" placeholder="ML" name="ml[]" >	</div>	</div></div><div id="hide_ltr'+b+'" style="display:none;"><div class="col-md-2" ><div class="form-group"><label for="ltr">Ltr </label><input type="text" class="form-control jobtext" id="ltr" placeholder="Ltr" name="ltr[]" ></div></div></div><div id="hide_units'+b+'" style="display:none;"><div class="col-md-2" ><div class="form-group"><label for="units">Units</label><input type="text" class="form-control jobtext" id="units" placeholder="Units" name="units[]" ></div></div></div><div id="hide_cms'+b+'" style="display:none;"><div class="col-md-1" ><div class="form-group"><label for="cm">CM</label><input type="text" class="form-control jobtext" id="cm" placeholder="CM" name="cm[]" ></div></div></div><div id="hide_kgs'+b+'" style="display:none;"><div class="col-md-1" ><div class="form-group"><label for="kg">KG</label><input type="text" class="form-control jobtext" id="kg" placeholder="KG" name="kg[]" ></div></div></div><div class="col-md-2"><div class="form-group"><label for="categoryname">Colour </label><select id="colour" name="colour[]" class="form-control jobtext" ><option value="" selected>Select Colour</option><?php if($allcolour != ''){ for($k=0;$k<count($allcolour);$k++) { ?><option value="<?php echo $allcolour[$k]->id; ?>"><?php echo $allcolour[$k]->colour; ?></option><?php } } ?></select></div></div><div class="col-md-2"><div class="form-group"><label for="categoryname"> Price</label><input id="price" name="price[]" type="text" class="form-control" placeholder="Enter  Price" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"  /></div></div><div class="col-md-2"><div class="form-group"><label for="qty">Qty</label><input id="qty" name="qty[]" type="text" class="form-control" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"  placeholder="Enter Qty"/></div></div><div class="col-md-2"><div class="form-group"><label for="sku_code">Sku Code</label><input id="sku_code" name="sku_code[]" type="text" class="form-control" placeholder="Sku Code"/></div></div><div class="col-md-2"><div class="form-group"><label for="discount">Discount (%)</label><input id="discount'+b+'" maxlength="2" onkeyup="blockvalue_p('+b+');" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"  name="discount[]" type="text" class="form-control" placeholder="Enter Discount" /></div></div><div class="col-md-2"><div class="form-group"><label for="discount_price">Discount Price</label><input id="discount_price'+b+'" onkeyup="blockvalue_d('+b+');" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"  name="discount_price[]" type="text" class="form-control" placeholder="Enter Discount Price" /></div></div><div class="col-md-2"><div class="form-group"><label for="length">Packing Length (CM)</label><input id="length'+b+'" name="length[]" type="text" class="form-control" placeholder="Packing Length" onchange="calvolweight('+b+');"/></div></div><div class="col-md-2"><div class="form-group"><label for="height">Packing height (CM)</label><input id="height'+b+'" name="height[]" type="text" class="form-control" placeholder="Packing height" onchange="calvolweight('+b+');"/></div></div><div class="col-md-2"><div class="form-group"><label for="width">Packing Width (CM)</label><input id="width'+b+'" name="width[]" type="text" class="form-control" placeholder="Packing Width" onchange="calvolweight('+b+');" /></div></div><div class="col-md-2"><div class="form-group"><label for="volweight">Volumertic Weight (kg)</label><input id="volweight'+b+'" name="volweight[]" type="text" class="form-control" placeholder="Volumertic Weight"/></div></div><div class="col-md-2"><div class="form-group"><label for="weight">Packing Weight (kg)</label><input id="weight" name="weight[]" type="text" class="form-control" placeholder="Packing Weight"/></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 0px; margin-top: 24px;">Remove</a></div>');
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
    function get_hide_show1(id,b)
    {
                $("#gram_size_hidden"+b).val(id);
                if(id == '1')
                {
                            $("#hide_size"+b).css("display", "block");
                            $("#hide_gram"+b).css("display", "none");
                            $("#hide_ml"+b).css("display", "none");
                            $("#hide_ltr"+b).css("display", "none");
                            $("#hide_units"+b).css("display", "none");
                            $("#hide_cms"+b).css("display", "none");
                            $("#hide_kgs"+b).css("display", "none");

                }
                else if(id == '2')
                {
                            $("#hide_size"+b).css("display", "none");
                            $("#hide_gram"+b).css("display", "block");
                            $("#hide_ml"+b).css("display", "none");
                            $("#hide_ltr"+b).css("display", "none");
                            $("#hide_units"+b).css("display", "none");
                            $("#hide_cms"+b).css("display", "none");
                            $("#hide_kgs"+b).css("display", "none");
                }else if(id == '3')
                {
                            $("#hide_size"+b).css("display", "none");
                            $("#hide_gram"+b).css("display", "none");
                            $("#hide_ml"+b).css("display", "block");
                            $("#hide_ltr"+b).css("display", "none");
                            $("#hide_units"+b).css("display", "none");
                            $("#hide_cms"+b).css("display", "none");
                            $("#hide_kgs"+b).css("display", "none");
                }else if(id == '4')
                {
                            $("#hide_size"+b).css("display", "none");
                            $("#hide_gram"+b).css("display", "none");
                            $("#hide_ml"+b).css("display", "none");
                            $("#hide_ltr"+b).css("display", "block");
                            $("#hide_units"+b).css("display", "none");
                            $("#hide_cms"+b).css("display", "none");
                            $("#hide_kgs"+b).css("display", "none");
                }else if(id == '5')
                {
                            $("#hide_size"+b).css("display", "none");
                            $("#hide_gram"+b).css("display", "none");
                            $("#hide_ml"+b).css("display", "none");
                            $("#hide_ltr"+b).css("display", "none");
                            $("#hide_units"+b).css("display", "block");
                            $("#hide_cms"+b).css("display", "none");
                            $("#hide_kgs"+b).css("display", "none");
                }else if(id == '6')
                {
                            $("#hide_size"+b).css("display", "none");
                            $("#hide_gram"+b).css("display", "none");
                            $("#hide_ml"+b).css("display", "none");
                            $("#hide_ltr"+b).css("display", "none");
                            $("#hide_units"+b).css("display", "none");
                            $("#hide_cms"+b).css("display", "block");
                            $("#hide_kgs"+b).css("display", "none");
                }else
                {
                            $("#hide_size"+b).css("display", "none");
                            $("#hide_gram"+b).css("display", "none");
                            $("#hide_ml"+b).css("display", "none");
                            $("#hide_ltr"+b).css("display", "none");
                            $("#hide_units"+b).css("display", "none");
                            $("#hide_cms"+b).css("display", "none");
                            $("#hide_kgs"+b).css("display", "block");
                }
    }
                            </script>

<script>
    $(function() {
        $("#name").keyup(function(){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
        $("#page_url").val(Text);
        });

        });
</script><script src="<?php echo $base_url_views; ?>js/fSelect.js"></script><script src="<?php echo $base_url_views; ?>js/jquery.mediaBoxes.dropdown.js"></script>		<script src="<?php echo $base_url_views; ?>js/jquery.mediaBoxes.js"></script>		<script>							$('.multiple-select').fSelect();				$('.rfa_multiple_select .fs-wrap').addClass('col-sm-12');		</script>
<script>
     $('#category_id').multiselect({
            columns: 1,
            selectedOptions: 'PHP',
            placeholder: 'Select Category'
    });
        
    $('#subcatefory_id').multiselect({
        columns: 1,
        selectedOptions: 'PHP',
        placeholder: 'Select Subcategory'
    });


function calvolweight(id){
	var height = $('#height'+id).val();
	var length = $('#length'+id).val();
	var width  = $('#width'+id).val();
	var volwei = (length * height * width)/5000;
	$("#volweight"+id).val(volwei);
}
 </script>