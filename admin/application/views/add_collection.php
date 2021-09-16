<?php include('include/header.php');?>
<style>
#allowed_discount_div{
	display:none;
}
.ms-selectall {
    font-size: 15px !important;
    font-weight: bold;
    text-decoration: underline !important;
    color: #428bca;
    text-transform: capitalize !important;
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
            <li class="crumb-link"><a href="<?php echo $base_url; ?>collection/lists">Collection</a></li>
            <li class="crumb-active"><a href="javascript:void(0);">Add Collection</a></li>
         </ol>
      </div>
   </div>
   <div id="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel">
               <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Add Collection </span> </div>
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
                     <form role="form" id="form" method="post" action="<?php echo $base_url;?>collection/add" enctype="multipart/form-data">
                        <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">
                        <INPUT TYPE="hidden" NAME="action" VALUE="add_collection">
                        <div class="col-md-4">
                            <div class="form-group">
                               <label for="name">Collection Name</label>
                               <input id="name" name="name" type="text" class="form-control" placeholder="Enter Collection Name"  />
							   <span id="catnameerror" class="valierror"></span>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                               <label for="startdate">Start date:</label>
                               <input id="startdate" name="startdate" type="text" class="form-control" placeholder="Enter Startdate" autocomplete="off" />
							   <span id="startdateerror" class="valierror"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                               <label for="enddate">End date:</label>
                               <input id="enddate" name="enddate" type="text" class="form-control" placeholder="Enter Enddate" autocomplete="off"  />
							   <span id="enddateerror" class="valierror"></span>
                            </div>
                        </div>

						<div class="col-md-4">
                                <div class="form-group">
								<label for="state_id">Select State</label>
                                  <select id="state_id" name="state_id" class="form-control" onchange="get_group(this.value);">
                                    <option value="">Select State</option>
                                    <?php if($allstate !='')
                                    {
                                        foreach($allstate as $stateshow)
                                        { ?>
                                    		<option value="<?php echo $stateshow->id; ?>"><?php echo $stateshow->name; ?></option>
                                    <?php } } ?>
                                  </select>
                             </div>
                         </div>

						 <div class="col-md-4">
                                <div class="form-group">
								<span id="prod11">
								<label for="city_id">Select District</label>
                                  <select id="city_id" name="city_id" class="form-control" onchange="get_city_pro(this.value);">
                                    <option value="">Select District</option>
                                    <?php if($allcity !='')
                                    {
                                        foreach($allcity as $cityshow)
                                        { ?>
                                    		<option value="<?php echo $cityshow->id; ?>"><?php echo $cityshow->name; ?></option>
                                    <?php } } ?>
                                  </select>
								</span>
                             </div>
                         </div>

						 <!-- <div class="col-md-6">
                                <div class="form-group">
								<label for="pincode_id">Select Pincode</label>
                                  <select id="pincode_id" name="pincode_id" class="form-control">
                                    <option value="">Select Pincode</option>
                                    <?php if($allPincode !='')
                                    {
                                        foreach($allPincode as $pincodeshow)
                                        { ?>
                                    		<option value="<?php echo $pincodeshow->id; ?>"><?php echo $pincodeshow->name; ?></option>
                                    <?php } } ?>
                                  </select>
                             </div>
                         </div> -->

						 <div class="col-md-4">
                                        <div class="form-group">
                                            
                                            <span id="prod1">
                                            <label for="product_id">Collection Products </label>
                                                <select id="product_id" name="product_id[]" multiple class="form-control">

                                                    <?php  if($allcproducts !='' && count($allcproducts) > 0){
                                            foreach($allcproducts as $cproducts){ ?>
                                                    <option value="<?php echo $cproducts->id; ?>">
                                                        <?php echo $cproducts->material_name; ?></option>
                                                    <?php } }  ?>
                                                </select>
                                                <span id="caterror" class="valierror"></span>
                                            </span>
                                        </div>
                                    </div>
                       
                          <div class="col-md-12">
                            <div class="form-group">
                               <input class="submit btn bg-purple pull-right" type="submit" value="Submit" onclick="javascript:validate();return false;"/>
                               <a href="<?php echo $base_url;?>collection/lists" class="submit btn btn-danger pull-right" style="margin-right: 10px;" />Cancel</a>
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


		var title = $("#name").val();
		if(title == ''){
			$("#catnameerror").html("Please Enter Collection Name");
			jQuery('#catnameerror').show().delay(0).fadeIn('show');
			jQuery('#catnameerror').show().delay(2000).fadeOut('show');
			document.getElementById("content_wrapper").scrollIntoView(true); 
			return false;
		}
		var startdate = $("#startdate").val();
		if(startdate == ''){
			$("#startdateerror").html("Please Enter Start Date");
			jQuery('#startdateerror').show().delay(0).fadeIn('show');
			jQuery('#startdateerror').show().delay(2000).fadeOut('show');
			document.getElementById("content_wrapper").scrollIntoView(true); 
			return false;
		}

		var enddate = $("#enddate").val();
		if(enddate == ''){
			$("#enddateerror").html("Please Enter End Date");
			jQuery('#enddateerror').show().delay(0).fadeIn('show');
			jQuery('#enddateerror').show().delay(2000).fadeOut('show');
			document.getElementById("content_wrapper").scrollIntoView(true); 
			return false;
		}

      fdate = new Date(startdate),
      tdate = new Date(enddate);

         if (fdate.valueOf() > tdate.valueOf()) {
            $("#enddateerror").html("The end date can not be less than the start date");
            jQuery('#enddateerror').show().delay(0).fadeIn('show');
            jQuery('#enddateerror').show().delay(2000).fadeOut('show');
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

    <?php include('include/footer.php');?>



<script type="text/javascript" src="<?php echo $base_url_views; ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo $base_url_views; ?>js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="<?php echo $base_url_views; ?>js/jquery.timepicker.min.js"></script>

<script type="text/javascript">
jQuery(document).ready(function () {
	"use strict";

	$('#startdate').datepicker();
	$('#enddate').datepicker();

   // var nowTemp = new Date();
   // var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
 
   // var checkin = $('#startdate').datepicker({
   // onRender: function(date) {
   //   // return date.valueOf() < now.valueOf() ? 'disabled' : '';
   // }
   // }).on('changeDate', function(ev) {
   // if (ev.date.valueOf() > checkout.date.valueOf()) {
   //    var newDate = new Date(ev.date)
   //    newDate.setDate(newDate.getDate() + 1);
   //    checkout.setValue(newDate);
   // }

   // checkin.hide();

   // $('#enddate')[0].focus();
   // }).data('datepicker');
   // var checkout = $('#enddate').datepicker({
   // onRender: function(date) {
   //    //return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
   // }
   // }).on('changeDate', function(ev) {
   // checkout.hide();
   // }).data('datepicker');


});

function get_group(cid)
{
        var url = '<?php echo $base_url ?>/collection/show_city/';
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
<script>			
// $('#product_id').multiselect({
//     columns  : 1,
//     search   : true,
//     selectAll: true,
//     texts    : {
//         placeholder: 'Select Collection Product',
//         search     : 'Search Collection Product',
//         selectAll: 'Select All',
//     }
// });

$('#product_id').multiselect({
    columns  : 1,
    selectAll: true,
    texts    : {
        placeholder: 'Select Collection Product',
        selectAll: 'Select All',
    }
});
function get_city_pro(cid)
{
        var url = '<?php echo $base_url ?>/collection/show_city_pro/';
        $.ajax({
        url:url,
        type:'post',
        data:'cid='+cid+'&sid=',
        success:function(msg)
        {
            document.getElementById('prod1').innerHTML = msg ;
            $('#product_id').multiselect({
            columns  : 1,
            selectAll: true,
            texts    : {
               placeholder: 'Select Collection Product',
               selectAll: 'Select All',
            }
         });
        }
        });
}
</script>