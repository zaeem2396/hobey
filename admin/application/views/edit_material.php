<?php include('include/header.php');?>

<!-- Start: Main -->
<div id="main"> 
  
 <?php include('include/sidebar_left.php');?>
 
  <!-- Start: Content -->
  <section id="content_wrapper">
   <div id="topbar">
      <div class="topbar-left">
         <ol class="breadcrumb">
            <li class="crumb-icon"><a href="<?php echo $base_url; ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="crumb-link"><a href="<?php echo $base_url; ?>material/lists">material</a></li>
            <li class="crumb-active"><a href="javascript:void(0);"> Edit material </a></li>
         </ol>
      </div>
   </div>
   <div id="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel">
               <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Edit material</span> </div>
               <div class="panel-body">
                  <?php if($this->session->flashdata('L_strErrorMessage')) 
                     { ?>
                  <div class="alert alert-success alert-dismissable">
                     <i class="fa fa-check"></i>
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     <b>Success!</b> <?php echo $this->session->flashdata('L_strErrorMessage'); ?>
                  </div>
                  <?php } 
                     ?>
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
                     <form role="form" id="form" method="post" action="<?php echo $base_url;?>material/edit/<?php echo $id; ?>" enctype="multipart/form-data" >
                        <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
                        <INPUT TYPE="hidden" NAME="action" VALUE="edit_category">
                        <INPUT TYPE="hidden" NAME="hiddenaction" VALUE="<?php echo $id;?>">
                        
                           <div class="form-group">
                              <label for="name">Material </label>
                              <input id="name" name="name" type="text" class="form-control" placeholder="Enter material" value="<?php echo $name; ?>"/>
                              <span id="catnameerror" class="valierror"></span>     
                           </div>
                        
                        
                        <div class="col-md-12">
                            <div class="form-group">
                               <input class="submit btn bg-purple pull-right" type="submit" value="Update" onclick="javascript:validate();return false;"/>
                               <a href="<?php echo $base_url;?>material/lists" class="submit btn btn-danger pull-right" style="margin-right: 10px;" />Cancel</a>
                            </div>
                        </div>
                    </form>
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
<script type="text/javascript">
jQuery(document).ready(function () {
    "use strict";
    CKEDITOR.replace('categorydescription',{});
    CKEDITOR.disableAutoInline = false;
});
</script> 
<script>
	function validate(){
	
		 var name = $("#name").val();
     if(name == ''){
   		$("#catnameerror").html("Please Enter material");
   		jQuery('#catnameerror').show().delay(0).fadeIn('show');
   		jQuery('#catnameerror').show().delay(2000).fadeOut('show');
   		document.getElementById("catnameerror").scrollIntoView(true); 
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


<script>
	$(function() {
		$("#cname").keyup(function(){	
		var Text = $(this).val();	
		Text = Text.toLowerCase();	
		Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');	
		$("#page_url").val(Text);    
		});		
		});
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
        $(wrapper).append('<div class="col-sm-4 my_flex" ><div class="col-sm-11" style="padding:0"><div class="form-group"><input id="input_name" name="input_name[]" type="text" class="form-control" placeholder="Enter Input Name" /></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 0px; margin-top: 0px;">Remove</a></div>');
        }
        });
        $(wrapper).on("click",".remove_field1", function(e){
        e.preventDefault();
        $(this).parent('div').remove();
        b--;
        });
        
        	var max_fields1      = 100; 	
        	var wrapper1         = $(".input_fields_name1");
        	var add_button1      = $("#add_field_button1"); 
        	var b = 0;    
        	$(add_button1).click(function(e){   
        	e.preventDefault();     
        	if(b < max_fields){ b++;
        			$(wrapper1).append('<div class="col-md-12" style="padding: 0"><input type="hidden" name="keyindex[]" value="'+b+'"><div class="col-md-12"><div class="form-group"><input id="keyname" name="keyname[]" type="text" class="form-control" placeholder="Enter Keywords Name" /></div></div><div class="col-md-11"></div><div class="input_fields_store'+b+'"></div><div class="col-md-11"><div class="form-group"><div class="col-sm-12"><input type="hidden" id="max_fields_store'+b+'" value="50"><input type="hidden" id="c'+b+'" value="1"></div></div></div><div class="col-sm-12"><a href="#" class="btn btn-danger remove_field1" style="margin-bottom: 10px;margin-top: -40px;">Remove Keywords</a></div></div>');
        		}  							
        	}); 
        	$(wrapper1).on("click",".remove_field1", function(e){  
        		e.preventDefault(); 
        		$(this).parent('div').parent('div').remove();
        		b--; 
        	});	
        	
        	
        	
    var max_fields2      = 100;  
	var wrapper2         = $(".input_fields_name2");
	var add_button2      = $("#add_field_button2"); 
	var b = 0;    
	$(add_button2).click(function(e){   
	e.preventDefault();     
	if(b < max_fields2){ 
			b++;
			$(wrapper2).append('<div class="col-sm-12"><input type="hidden" name="index[]" value="'+b+'"><div class="col-md-6"><div class="form-group"><label for="categoryname"> Name</label><input id="name" name="name[]" type="text" class="form-control" placeholder="Enter Name" /></div></div><div class="col-md-6"><div class="col-md-10 m-padding"><div class="form-group"><label for="categoryname"> Value</label><input id="name" name="value'+b+'[]" type="text" class="form-control" placeholder="Enter Value" /></div></div></div><div class="input_fields_store'+b+'"></div><div class="col-md-12"><div class="form-group"><div class="col-sm-12"><input type="hidden" id="max_fields_store'+b+'" value="50"><input type="hidden" id="c'+b+'" value="1"><a href="javascript:void(0);" onclick="add_value('+b+');" style="border: medium none; margin-right: -11px; line-height: 23px; margin-top: -49px;" class="submit btn bg-purple pull-right" type="button">Add Value</a></div></div></div><div class="col-sm-12"><a href="#" class="btn btn-danger remove_field1" style="margin-bottom: 10px;">Remove Name</a></div></div>');
		}  							
	}); 
	
	$(wrapper).on("click",".remove_field2", function(e){  
	e.preventDefault(); 
	$(this).parent('div').parent('div').remove();
	b--; 
	});
        	   
            });
</script>
<script>
	function add_value(b)
	{
			var max_fields_store      = $("#max_fields_store"+b).val();
			var c      				  = $("#c"+b).val();	
			var wrapper_store         = $(".input_fields_store"+b); 
			if(parseInt(c) < parseInt(max_fields_store)){ c++; 	        
				$("#c"+b).val(c);	
				$(wrapper_store).append('<div class="col-md-4 m-padding my_flex" ><div class="col-md-11" STYLE="PADDING-RIGHT:0"><div class="form-group"><input id="name" name="value'+b+'[]" type="text" class="form-control" placeholder="Enter Value"/></div></div><a href="#" class="btn btn-danger remove_value'+b+'" style="margin-top:0px;">Remove</a></div>');      
			}
			$(wrapper_store).on("click",".remove_value"+b, function(e){  
			e.preventDefault(); 
			$(this).parent('div').remove();
			});
	}
</script>
<script>
	function add_update_value(b)
	{
			var max_fields_store      = $("#update_max_fields_store"+b).val();
			var c      				  = $("#update_c"+b).val();	
			var wrapper_store         = $(".update_input_fields_store"+b); 
			if(parseInt(c) < parseInt(max_fields_store)){ c++; 	        
				$("#update_c"+b).val(c);	
				$(wrapper_store).append('<div class="col-md-4  my_flex"><input type="hidden" name="update_value_id'+b+'[]" value=""><div class="col-md-11 m-padding"><div class="form-group"><input id="name" name="update_value'+b+'[]" type="text" class="form-control" placeholder="Enter Value"/></div></div><a href="#" class="btn btn-danger update_remove_value'+b+'" style="margin-top:0px;    margin-left: 20px;">Remove</a></div>');      
			}
			$(wrapper_store).on("click",".update_remove_value"+b, function(e){  
			e.preventDefault(); 
			$(this).parent('div').remove();
			});
	}
</script>
