<?php include('include/header.php'); ?>

<!-- Start: Main -->
<div id="main">

   <?php include('include/sidebar_left.php'); ?>

   <!-- Start: Content -->
   <section id="content_wrapper">
      <div id="topbar">
         <div class="topbar-left">
            <ol class="breadcrumb">
               <li class="crumb-icon"><a href="<?php echo $base_url; ?>"><span class="glyphicon glyphicon-home"></span></a></li>
               <li class="crumb-link"><a href="<?php echo $base_url; ?>city/lists">District</a></li>
               <li class="crumb-active"><a href="javascript:void(0);"> Edit District </a></li>
            </ol>
         </div>
      </div>
      <div id="content">
         <div class="row" id="subform">
            <div class="col-md-12">
               <div class="panel">
                  <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Edit District</span> </div>
                  <div class="panel-body">
                     <?php if ($this->session->flashdata('L_strErrorMessage')) { ?>
                        <div class="alert alert-success alert-dismissable">
                           <i class="fa fa-check"></i>
                           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                           <b>Success!</b> <?php echo $this->session->flashdata('L_strErrorMessage'); ?>
                        </div>
                     <?php }
                     ?>
                     <?php if ($this->session->flashdata('flashError') != '') { ?>
                        <div class="alert alert-danger alert-dismissable">
                           <i class="fa fa-warning"></i>
                           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                           <b>Error!</b> <?php echo $this->session->flashdata('flashError'); ?>
                        </div>
                     <?php }  ?>
                     <div id="validator" class="alert alert-danger alert-dismissable" style="display:none;">
                        <i class="fa fa-warning"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <b>Error &nbsp; </b><span id="error_msg1"></span>
                     </div>
                     <div class="col-md-12">
                        <form role="form" id="form" method="post" action="<?php echo $base_url; ?>city/edit/<?php echo $id; ?>" enctype="multipart/form-data">
                           <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                           <INPUT TYPE="hidden" NAME="action" VALUE="edit_category">
                           <INPUT TYPE="hidden" NAME="hiddenaction" VALUE="<?php echo $id; ?>">

                           <div class="form-group">
                              <label style="width:100%; margin:15px 0 5px;" for="name">State <span color="red">*</span></label>
                              <select id="state_id" name="state_id" class="form-control jobtext">
                                 <option value="" selected disabled>-- Select State --</option>
                                 <?php for ($i = 0; $i < count($allstate); $i++) { ?>
                                    <option value='<?php echo $allstate[$i]->id; ?>' <?php if ($state_id == $allstate[$i]->id) {
                                                                                             echo "selected";
                                                                                          } ?>>
                                       <?php echo $allstate[$i]->name; ?>
                                    </option>
                                 <?php } ?>
                              </select>
                              <span id="catnameerror" class="valierror"></span>
                           </div>


                           <div class="form-group">
                              <label style="width:100%; margin:15px 0 5px;" for="name">District Name <span color="red">*</span></label>
                              <input id="name" name="name" type="text" class="form-control" placeholder="Enter District Name" value="<?php echo $name; ?>" />
                              <span id="subcatnameerror" class="valierror"></span>
                           </div>

                           <div class="form-group">
                              <label style="width:100%; margin:15px 0 5px;" for="name">Sales Office Name <span color="red">*</span></label>
                              <input id="sales_office_name" name="sales_office_name" type="text" class="form-control" placeholder="Enter Sales Office Name" value="<?= $sales_office_name ?>" required />
                              <span id="salesofficeerr" class="valierror"></span>
                           </div>

                           <div class="form-group">
                              <label style="width:100%; margin:15px 0 5px;" for="name">Sales Office Number <span color="red">*</span></label>
                              <input id="sales_office_no" name="sales_office_no" type="text" class="form-control" placeholder="Enter Sales Office Number" value="<?= $sales_office_no ?>" onkeypress="return isNumber(event)" maxlength="4" required />
                              <span id="salesofficeno" class="valierror"></span>
                           </div>

                           <div class="col-md-12">
                              <div class="form-group">
                                 <input class="submit btn bg-purple pull-right" type="submit" value="Update" onclick="javascript:validate();return false;" />
                                 <a href="<?php echo $base_url; ?>city/lists" class="submit btn btn-danger pull-right" style="margin-right: 10px;" />Cancel</a>
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
      var category_id = $("#state_id").val();
      if (category_id == '') {
         $("#catnameerror").html("Please select State");
         jQuery('#catnameerror').show().delay(0).fadeIn('show');
         jQuery('#catnameerror').show().delay(2000).fadeOut('show');
         document.getElementById("catnameerror").scrollIntoView(true);
         return false;
      }

      var name = $("#name").val();
      if (name == '') {
         $("#subcatnameerror").html("Please Enter District");
         jQuery('#subcatnameerror').show().delay(0).fadeIn('show');
         jQuery('#subcatnameerror').show().delay(2000).fadeOut('show');
         document.getElementById("subcatnameerror").scrollIntoView(true);
         return false;
      }

      var salesofficeerr = $("#sales_office_name").val();
      if (salesofficeerr == '') {
         $("#salesofficeerr").html("Please Enter Sales office name");
         jQuery('#salesofficeerr').show().delay(0).fadeIn('show');
         jQuery('#salesofficeerr').show().delay(2000).fadeOut('show');
         document.getElementById("salesofficeerr").scrollIntoView(true);
         return false;
      }

      var salesofficeno = $("#sales_office_no").val();
      if (salesofficeno == '') {
         $("#salesofficeno").html("Please Enter Sales office number");
         jQuery('#salesofficeno').show().delay(0).fadeIn('show');
         jQuery('#salesofficeno').show().delay(2000).fadeOut('show');
         document.getElementById("salesofficeno").scrollIntoView(true);
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

   const isNumber = evt => {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
         return false;
      }
      return true;
   }
</script>
<script>
   function get_group(cid) {
      var sid = '<?php echo $category_id; ?>';
      var url = '<?php echo $base_url ?>/city/show_city/';
      $.ajax({
         url: url,
         type: 'post',
         data: 'cid=' + cid + '&sid=' + sid,
         success: function(msg) {

            document.getElementById('prod1').innerHTML = msg;
         }
      });
   }
</script>


<script>
   $(function() {
      $("#name").keyup(function() {
         var Text = $(this).val();
         Text = Text.toLowerCase();
         Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
         $("#page_url").val(Text);
      });
   });
</script>