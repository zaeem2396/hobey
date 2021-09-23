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
            <li class="crumb-active"><a href="javascript:void(0);"> Add material</a></li>
         </ol>
      </div>
   </div>
   <div id="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel">
               <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Add material </span> </div>
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
                     <form role="form" id="form" method="post" action="<?php echo $base_url;?>material/add" enctype="multipart/form-data">
                        <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
                        <INPUT TYPE="hidden" NAME="action" VALUE="add_category">
                            
                            
                                <div class="form-group">
                                   <label  for="name">material <span color="red">*</span></label>
                                   <input id="name" name="name" type="text" class="form-control" placeholder="Enter material" value=""/>
                                   <span id="catnameerror" class="valierror"></span>
                                </div>
                           
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <br>
                                    <br>
                                   <input class="submit btn bg-purple pull-right" type="submit" value="Submit" onclick="javascript:validate();return false;"/>
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
   	 
		/*var name = $("#name").val();
		if(name == ''){
			//alert('Please Enter Category ');
			$("#error_msg1").html("Please Enter Category Name.");
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
    $(wrapper).append('<div class="col-md-4 my_flex" style="padding-left:0"><div class="col-md-10"><div class="form-group"><input id="input_name" name="input_name[]" type="text" class="form-control" placeholder="Enter Input Name" /></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-top: 0px;">Remove</a></div>');
    }
    });
    $(wrapper).on("click",".remove_field1", function(e){
    e.preventDefault();
    $(this).parent('div').remove();
    b--;
    })
    });
</script>