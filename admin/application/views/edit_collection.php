<?php include('include/header.php'); ?>
<style>
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

   <?php include('include/sidebar_left.php'); ?>

   <!-- Start: Content -->
   <section id="content_wrapper">
      <div id="topbar">
         <div class="topbar-left">
            <ol class="breadcrumb">
               <li class="crumb-icon"><a href="<?php echo $base_url; ?>"><span class="glyphicon glyphicon-home"></span></a></li>
               <li class="crumb-link"><a href="<?php echo $base_url; ?>collection/lists">Collection</a></li>
               <li class="crumb-active"><a href="javascript:void(0);"> Edit Collection <?php echo $name; ?></a></li>
            </ol>
         </div>
      </div>
      <div id="content">
         <div class="row">
            <div class="col-md-12">
               <div class="panel">
                  <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Edit Collection <?php echo $name; ?> </span> </div>
                  <div class="panel-body">
                     <?php if ($this->session->flashdata('L_strErrorMessage')) { ?>
                        <div class="alert alert-success alert-dismissable">
                           <i class="fa fa-check"></i>
                           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                           <b>Success!</b> <?php echo $this->session->flashdata('L_strErrorMessage'); ?>
                        </div>
                     <?php }   ?>
                     <?php if ($this->session->flashdata('flashError') != '') { ?>
                        <div class="alert alert-danger alert-dismissable">
                           <i class="fa fa-warning"></i>
                           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                           <b>Error!</b> <?php echo $this->session->flashdata('flashError'); ?>
                        </div>
                     <?php }  ?>
                     <div id="validator" class="alert alert-success alert-dismissable" style="display:none;">
                        <i class="fa fa-warning"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <b>Success!</b> <span id="error_msg1"></span>
                     </div>
                     <div class="col-md-12">
                        <form role="form" id="form" method="post" action="<?php echo $base_url; ?>collection/edit/<?php echo $id; ?>" enctype="multipart/form-data">
                           <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                           <INPUT TYPE="hidden" NAME="action" VALUE="edit_collection">
                           <INPUT TYPE="hidden" NAME="hiddenaction" VALUE="<?php echo $id; ?>">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="name">Collection Name</label>
                                 <input id="name" name="name" type="text" value="<?php echo $name; ?>" class="form-control" placeholder="Enter Collection Name" />
                                 <span id="catnameerror" class="valierror"></span>
                              </div>
                           </div>

                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="startdate">Start date:</label>
                                 <input id="startdate" name="startdate" type="text" value="<?php echo date("m/d/Y", strtotime($startdate)); ?>" class="form-control" placeholder="Enter Startdate" />
                                 <span id="startdateerror" class="valierror"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="enddate">End date:</label>
                                 <input id="enddate" name="enddate" type="text" value="<?php echo date("m/d/Y", strtotime($enddate)); ?>" class="form-control" placeholder="Enter Enddate" />
                                 <span id="enddateerror" class="valierror"></span>
                              </div>
                           </div>

                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="state_id">Select State</label>
                                 <select id="state_id" name="state_id" class="form-control" onchange="get_group(this.value);">
                                    <option value="">Select State</option>
                                    <?php if ($allstate != '') {
                                       foreach ($allstate as $stateshow) { ?>
                                          <option value="<?php echo $stateshow->id; ?>" <?php if ($state_id == $stateshow->id) {
                                                                                                   echo "selected";
                                                                                                } ?>><?php echo $stateshow->name; ?></option>
                                    <?php }
                                    } ?>
                                 </select>
                              </div>
                           </div>

                           <div class="col-md-4">
                              <div class="form-group">
                                 <span id="prod11">
                                    <label for="city_id">Select District</label>
                                    <select id="city_id" name="city_id" class="form-control">
                                       <option value="">Select District</option>
                                       <?php if ($allcity != '') {
                                          foreach ($allcity as $cityshow) { ?>
                                             <option value="<?php echo $cityshow->id; ?>" <?php if ($city_id == $cityshow->id) {
                                                                                                   echo "selected";
                                                                                                } ?>><?php echo $cityshow->name; ?></option>
                                       <?php }
                                       } ?>
                                    </select>
                                 </span>
                              </div>
                           </div>

                           <!-- <div class="col-md-6">
                                <div class="form-group">
								<label for="pincode_id">Select Pincode</label>
                                  <select id="pincode_id" name="pincode_id" class="form-control">
                                    <option value="">Select Pincode</option>
                                    <?php if ($allPincode != '') {
                                       foreach ($allPincode as $pincodeshow) { ?>
                                    		<option value="<?php echo $pincodeshow->id; ?>" <?php if ($pincode_id == $pincodeshow->id) {
                                                                                                   echo "selected";
                                                                                                } ?>><?php echo $pincodeshow->name; ?></option>
                                    <?php }
                                    } ?>
                                  </select>
                             </div>
                         </div> -->

                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="product_id">Collection Products </label>
                                 <span id="prod1">
                                    <select id="product_id" name="product_id[]" multiple class="form-control">

                                       <?php if ($allcproducts != '' && count($allcproducts) > 0) {
                                          $in_product_id = explode(",", $product_id);
                                          foreach ($allcproducts as $cproducts) { ?>
                                             <option value="<?php echo $cproducts->id; ?>" <?php if (in_array($cproducts->id, $in_product_id)) {
                                                                                                      echo "selected";
                                                                                                   } ?>>
                                                <?php echo $cproducts->material_name; ?> <?php echo $cproducts->weight; ?></option>
                                       <?php }
                                       }  ?>
                                    </select>
                                    <span id="caterror" class="valierror"></span>
                                 </span>
                              </div>
                           </div>

                           <div class="col-md-12">
                              <div class="form-group">
                                 <input class="submit btn bg-purple pull-right" type="submit" value="Submit" onclick="javascript:validate();return false;" />
                                 <a href="<?php echo $base_url; ?>collection/lists" class="submit btn btn-danger pull-right" style="margin-right: 10px;" />Cancel</a>
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


   <?php include('include/sidebar_right.php'); ?>
</div>
<!-- End #Main -->
<?php include('include/footer.php') ?>

<script>
   function validate() {


      var title = $("#name").val();
      if (title == '') {
         $("#catnameerror").html("Please Enter Collection Name");
         jQuery('#catnameerror').show().delay(0).fadeIn('show');
         jQuery('#catnameerror').show().delay(2000).fadeOut('show');
         document.getElementById("content_wrapper").scrollIntoView(true);
         return false;
      }

      var startdate = $("#startdate").val();
      if (startdate == '') {
         $("#startdateerror").html("Please Enter Start Date");
         jQuery('#startdateerror').show().delay(0).fadeIn('show');
         jQuery('#startdateerror').show().delay(2000).fadeOut('show');
         document.getElementById("content_wrapper").scrollIntoView(true);
         return false;
      }

      var enddate = $("#enddate").val();
      if (enddate == '') {
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

   function numbersonly(e) {
      var unicode = e.charCode ? e.charCode : e.keyCode
      if (unicode != 8) { //if the key isn't the backspace key (which we should allow)
         if (unicode < 45 || unicode > 57) //if not a number
            return false //disable key press
      }
   }
</script>
<script type="text/javascript" src="<?php echo $base_url_views; ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo $base_url_views; ?>js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
   jQuery(document).ready(function() {
      "use strict";
      $('#startdate').datepicker({
         autoclose: true
      });
      $('#enddate').datepicker({
         autoclose: true
      });


   });

   function get_group(cid) {
      var url = '<?php echo $base_url ?>/collection/show_city/';
      $.ajax({
         url: url,
         type: 'post',
         data: 'cid=' + cid + '&sid=',
         success: function(msg) {
            document.getElementById('prod11').innerHTML = msg;
         }
      });
   }
</script>
<script type="text/javascript" src="<?php echo $base_url_views; ?>js/jquery.timepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url_views; ?>css/jquery.timepicker.min.css">


<script type="text/javascript">
   jQuery(document).ready(function() {
      $('#start_time').timepicker();
   });
</script>


<script type="text/javascript">
   jQuery(document).ready(function() {
      $('#end_time').timepicker();
   });
</script>

<script type="text/javascript" src="<?php echo $base_url_views; ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript">
   // jQuery(document).ready(function () {
   // 	"use strict";
   // 	CKEDITOR.replace('desc',
   // 	{

   // 	});
   //     CKEDITOR.disableAutoInline = false;
   // });
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
         thumbs: {
            autoStart: true
         }, // Display thumbnails on opening/closing
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
      columns: 1,
      selectAll: true,
      texts: {
         placeholder: 'Select Collection Product',
         selectAll: 'Select All',
      }
   });
</script>