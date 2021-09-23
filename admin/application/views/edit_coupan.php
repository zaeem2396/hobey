<?php include('include/header.php');?>

<link href="<?php echo $base_url_views; ?>css/fSelect.css" rel="stylesheet">

<link href="<?php echo $base_url_views; ?>css/mediaBoxes.css" rel="stylesheet">

<!-- Start: Main -->
<div id="main">

 <?php include('include/sidebar_left.php');?>

  <!-- Start: Content -->
  <section id="content_wrapper">
   <div id="topbar">
      <div class="topbar-left">
         <ol class="breadcrumb">
            <li class="crumb-icon"><a href="<?php echo $base_url; ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="crumb-link"><a href="<?php echo $base_url; ?>coupan/lists">Coupon</a></li>
            <li class="crumb-active"><a href="javascript:void(0);"> Edit Coupon <?php echo $coupanname;?></a></li>
         </ol>
      </div>
   </div>
   <div id="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel">
               <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Edit Coupon <?php echo $coupanname;?> </span> </div>
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
                  <div id="validator"  class="alert alert-success alert-dismissable" style="display:none;">
                     <i class="fa fa-warning"></i>
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     <b>Success!</b> <span id="error_msg1"></span>
                  </div>
                  <div class="col-md-12">
                     <form role="form" id="form" method="post" action="<?php echo $base_url;?>coupan/edit/<?php echo $id; ?>" enctype="multipart/form-data" >
                        <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
                        <INPUT TYPE="hidden" NAME="action" VALUE="edit_coupan">
                        <INPUT TYPE="hidden" NAME="hiddenaction" VALUE="<?php echo $id;?>">
                        <div class="col-md-4">
                            <div class="form-group">
                               <label for="coupanname">Coupon Name</label>
                               <input id="coupanname" name="coupanname" type="text"  value="<?php echo $coupanname;?>"class="form-control" placeholder="Enter Coupon Name"  />
							   <span id="catnameerror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                               <label for="coupanname">Coupon Code</label>
                               <input id="coupancode" name="coupancode" value="<?php echo $coupancode;?>" type="text" class="form-control" placeholder="Enter Coupon Code"  />
							   <span id="codenameerror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                               <label for="discount">Discount</label>
                               <input id="discount" name="discount" type="text"  value="<?php echo $discount;?>" class="form-control" placeholder="Enter Discount" onkeypress="return numbersonly(event)" />
							   <span id="discounterror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                               <label for="no_of_coupan">Coupon Value:</label><br>
                               <input type="radio" value="1" name="coupanvalue"  id="coupanvalue" class="" <?php if($coupanvalue =='1'){ echo "Checked"; } ?> >&nbsp; Price &nbsp;&nbsp;
                               <input type="radio"  value="0" name="coupanvalue" id="coupanvalue" class="" <?php if($coupanvalue =='0'){ echo "Checked"; }?>>&nbsp; Percentage &nbsp;&nbsp;
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                               <label for="startdate">Start date:</label>
                               <input id="startdate" name="startdate" type="text" value="<?php echo date("m/d/Y",strtotime($startdate));?>" class="form-control" placeholder="Enter Startdate" />
							   <span id="startdateerror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                               <label for="enddate">End date:</label>
                               <input id="enddate" name="enddate" type="text" value="<?php echo date("m/d/Y",strtotime($enddate));?>" class="form-control" placeholder="Enter Enddate"  />
							   <span id="enddateerror" class="valierror"></span>
                            </div>
                        </div>
                        
                        <div class="col-md-12">    
                            <div class="form-group">
                               <label for="short_desc" style="margin:15px 0 5px 0px; width:100%;"> Description</label>
                               <textarea id="desc" name="description" class="form-control" placeholder="Enter Short Description"><?php echo $description;?> </textarea>
                            </div>
                        </div>
                        <div class="col-md-12">  
                            <div class="form-group">
                               <input class="submit btn bg-purple pull-right" type="submit" value="Submit" onclick="javascript:validate();return false;"/>
                               <a href="<?php echo $base_url;?>coupan/lists" class="submit btn btn-danger pull-right" style="margin-right: 10px;" />Cancel</a>
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
  <script>
function subcategory(cid)
{
	//alert(cid);
		//country id
		var sid = $("#sid").val();
		var url = '<?php echo $base_url ?>coupan/show_subcategory/';
		//window.location = url;
		$.ajax({
		url:url,
		type:'post',
		data:'cid='+cid+'&sid='+sid,
		success:function(msg)
		{
			//alert(msg);
			document.getElementById('prod1').innerHTML = msg ;
		}
		});
}
 </script>
<script>

	function validate(){


		var title = $("#coupanname").val();
		if(title == ''){
			$("#catnameerror").html("Please Enter Coupon Name");
			jQuery('#catnameerror').show().delay(0).fadeIn('show');
			jQuery('#catnameerror').show().delay(2000).fadeOut('show');
			document.getElementById("content_wrapper").scrollIntoView(true); 
			return false;
		}
		var coupancode = $("#coupancode").val();
		if(coupancode == ''){
			$("#codenameerror").html("Please Enter Coupon Code");
			jQuery('#codenameerror').show().delay(0).fadeIn('show');
			jQuery('#codenameerror').show().delay(2000).fadeOut('show');
			document.getElementById("content_wrapper").scrollIntoView(true); 
			return false;
		}
		/*var pa=document.getElementById('coupanname');
		var p = /[a-zA-Z\s-, ]+$/;
		if(!p.test(pa.value))
			{
				//alert("Please Enter Valid coupanname ");
				$("#error_msg1").html("Please Enter Valid Coupon Name.");
				$("#validator").css("display","block");
				return false;
        }*/

        var discount = $("#discount").val();
		if(discount == ''){
			$("#discounterror").html("Please Enter Coupon Code");
			jQuery('#discounterror').show().delay(0).fadeIn('show');
			jQuery('#discounterror').show().delay(2000).fadeOut('show');
			document.getElementById("content_wrapper").scrollIntoView(true); 
			return false;
		}
		var startdate = $("#startdate").val();
		if(startdate == ''){
			$("#startdateerror").html("Please Enter Coupon Code");
			jQuery('#startdateerror').show().delay(0).fadeIn('show');
			jQuery('#startdateerror').show().delay(2000).fadeOut('show');
			document.getElementById("content_wrapper").scrollIntoView(true); 
			return false;
		}

		var enddate = $("#enddate").val();
		if(enddate == ''){
			$("#enddateerror").html("Please Enter Coupon Code");
			jQuery('#enddateerror').show().delay(0).fadeIn('show');
			jQuery('#enddateerror').show().delay(2000).fadeOut('show');
			document.getElementById("content_wrapper").scrollIntoView(true); 
			return false;
		}
		var no_of_coupan = $("#no_of_coupan").val();
		if(no_of_coupan == ''){
			$("#noofcouperror").html("Please Enter Coupon Code");
			jQuery('#noofcouperror').show().delay(0).fadeIn('show');
			jQuery('#noofcouperror').show().delay(2000).fadeOut('show');
			document.getElementById("content_wrapper").scrollIntoView(true); 
			return false;
		}

		var coupan_per_user = $("#coupan_per_user").val();
		if(coupan_per_user == ''){
			$("#couperuserror").html("Please Enter Coupon Code");
			jQuery('#couperuserror').show().delay(0).fadeIn('show');
			jQuery('#couperuserror').show().delay(2000).fadeOut('show');
			document.getElementById("content_wrapper").scrollIntoView(true); 
			return false;
		}

		var mini_amount = $("#mini_amount").val();
		if(mini_amount == ''){
			$("#minamterror").html("Please Enter Coupon Code");
			jQuery('#minamterror').show().delay(0).fadeIn('show');
			jQuery('#minamterror').show().delay(2000).fadeOut('show');
			document.getElementById("content_wrapper").scrollIntoView(true); 
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
  	<script type="text/javascript" src="<?php echo $base_url_views; ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo $base_url_views; ?>js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
jQuery(document).ready(function () {
	"use strict";
	$('#startdate').datepicker({ autoclose: true });
	$('#enddate').datepicker({ autoclose: true });
	$('#is_discounted').click(function(){
		if($(this).is(":checked")){
			$('#allowed_discount_div').show();
		}else {
			$('#allowed_discount_div').hide();
			$('#allowed_discount').val(0);
		}
	});
	$('#category').change(function(){
		var multipleValues = $( this ).val() || [];
		$.ajax({
			url:'<?php echo $base_url ?>coupan/show_subcategory',
			type:'post',
			data:'cid='+multipleValues,
			success:function(msg)
			{
			$('#subcategory').html(msg);
			$('#subcategory').fSelect('reload');
			}
		});
	});
});
</script>
<script type="text/javascript" src="<?php echo $base_url_views; ?>js/jquery.timepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url_views;?>css/jquery.timepicker.min.css">


<script type="text/javascript">
jQuery(document).ready(function () {
	 $('#start_time').timepicker();
     });
</script>


<script type="text/javascript">
jQuery(document).ready(function () {
	 $('#end_time').timepicker();
     });
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


</script>

<script src="<?php echo $base_url_views; ?>js/fSelect.js"></script>
<script src="<?php echo $base_url_views; ?>js/jquery.mediaBoxes.dropdown.js"></script>
		<script src="<?php echo $base_url_views; ?>js/jquery.mediaBoxes.js"></script>
		<script>
			$('#grid').mediaBoxes({
				filterContainer: '#filter',
				search: '#search',
				columns: 3,
				boxesToLoadStart: 9,
				boxesToLoad: 9,
				horizontalSpaceBetweenBoxes: 30,
				verticalSpaceBetweenBoxes: 30,
				minBoxesPerFilter: 20,
				deepLinkingOnFilter: false,
				fancybox: {
					thumbs : { autoStart : true },    // Display thumbnails on opening/closing
				}
			});

			$('#grid2').mediaBoxes({
				filterContainer: '#filter2',
				search: '#search',
				columns: 3,
				boxesToLoadStart: 10,
				boxesToLoad: 9,
				horizontalSpaceBetweenBoxes: 20,
				verticalSpaceBetweenBoxes: 20,
				minBoxesPerFilter: 20,
				deepLinkingOnFilter: false,
			});

				$('.multiple-select').fSelect();
				$('.rfa_multiple_select .fs-wrap').addClass('');
		</script><script>function hideshow(value){	if(value==2 || value==0)	{		$('#events_id').show();		}else{		$('#events_id').hide();	}}</script>