<?php include('include/header.php');?>
<style>
#allowed_discount_div{
	display:none;
}
</style>
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
            <li class="crumb-link"><a href="<?php echo $base_url; ?>bpcl_payment/lists">BPCL Payment</a></li>
            <li class="crumb-active"><a href="javascript:void(0);">Add BPCL Payment</a></li>
         </ol>
      </div>
   </div>
   <div id="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel">
               <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Add BPCL Payment </span> </div>
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
                     <form role="form" id="form" method="post" action="<?php echo $base_url;?>bpcl_payment/add" enctype="multipart/form-data">
                        <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
                        <INPUT TYPE="hidden" NAME="action" VALUE="add_bpcl_payment">
                        <div class="col-md-3">
                                <div class="form-group">
								            <label for="user_vendor">Select User Type</label>
                                    <select id="user_vendor" name="user_vendor" class="form-control" onchange="get_group(this.value);">
                                       <option value="">Select User Type</option>
                                       <option value="1">Vendor</option>
                                       <option value="2">Distributor</option>
                                       <option value="3">Deliveryman</option>
                                    </select>
                                    <span id="caterror" class="valierror"></span>
                             </div>
                         </div>

						      <div class="col-md-3">
                                <div class="form-group">
                                 <span id="prod11">
                                 <label for="user_id">Select User</label>
                                          <select id="user_id" name="user_id" class="form-control">
                                             <option value="">Select User</option>
                                          </select>
                                          <span id="usererror" class="valierror"></span>
                                 </span>
                             </div>
                         </div>

                         <div class="col-md-3">
                            <div class="form-group">
                               <label for="amount">Amount</label>
                               <input id="amount" name="amount" type="text" class="form-control" placeholder="Enter Amount"  />
							          <span id="amounterror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                               <label for="pdate">Date</label>
                               <input id="pdate" name="pdate" type="text" class="form-control" placeholder="Enter Date" autocomplete="off" />
							   <span id="startdateerror" class="valierror"></span>
                            </div>
                        </div>
                       
                          <div class="col-md-12">
                            <div class="form-group">
                               <input class="submit btn bg-purple pull-right" type="submit" value="Submit" onclick="javascript:validate();return false;"/>
                               <a href="<?php echo $base_url;?>bpcl_payment/lists" class="submit btn btn-danger pull-right" style="margin-right: 10px;" />Cancel</a>
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
	function validate(){

		var user_vendor = $("#user_vendor").val();
		if(user_vendor == ''){
			$("#caterror").html("Please Select User Type");
			jQuery('#caterror').show().delay(0).fadeIn('show');
			jQuery('#caterror').show().delay(2000).fadeOut('show');
			//document.getElementById("content_wrapper").scrollIntoView(true); 
			return false;
		}
      var user_id = $("#user_id").val();
		if(user_id == ''){
			$("#usererror").html("Please Select User");
			jQuery('#usererror').show().delay(0).fadeIn('show');
			jQuery('#usererror').show().delay(2000).fadeOut('show');
			//document.getElementById("content_wrapper").scrollIntoView(true); 
			return false;
		}
		var amount = $("#amount").val();
		if(amount == ''){
			$("#amounterror").html("Please Enter Amout");
			jQuery('#amounterror').show().delay(0).fadeIn('show');
			jQuery('#amounterror').show().delay(2000).fadeOut('show');
			//document.getElementById("content_wrapper").scrollIntoView(true); 
			return false;
		}
      var pdate = $("#pdate").val();
		if(pdate == ''){
			$("#startdateerror").html("Please Enter Date");
			jQuery('#startdateerror').show().delay(0).fadeIn('show');
			jQuery('#startdateerror').show().delay(2000).fadeOut('show');
			//document.getElementById("content_wrapper").scrollIntoView(true); 
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

    <?php include('include/footer.php');?>



<script type="text/javascript" src="<?php echo $base_url_views; ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo $base_url_views; ?>js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="<?php echo $base_url_views; ?>js/jquery.timepicker.min.js"></script>

<script type="text/javascript">
jQuery(document).ready(function () {
	"use strict";

	$('#pdate').datepicker();
	//$('#enddate').datepicker();
});
function get_group(cid)
{

        var url = '<?php echo $base_url ?>/bpcl_payment/show_user/';
        $.ajax({
        url:url,
        type:'post',
        data:'cid='+cid+'&sid=',
        success:function(msg)
        {
            document.getElementById('prod11').innerHTML = msg ;
        }
        });
}
</script>


<link rel="stylesheet" type="text/css" href="<?php echo $base_url_views;?>css/jquery.timepicker.min.css">


<script type="text/javascript">
// jQuery(document).ready(function () {
// 	 $('#start_time').timepicker();
//      });
</script>


<script type="text/javascript">
// jQuery(document).ready(function () {
// 	 $('#end_time').timepicker();
//      });
</script>



<script type="text/javascript" src="<?php echo $base_url_views; ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript">
// jQuery(document).ready(function () {
// 	"use strict";
// 	CKEDITOR.replace('desc',{});
//     CKEDITOR.disableAutoInline = false;
// });

</script>
</body>
</html>

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
		</script>
