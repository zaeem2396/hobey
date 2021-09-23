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

					<li class="crumb-link"><a href="<?php echo $base_url; ?>banner/lists">Banner </a></li>

					<li class="crumb-active"><a href="javascript:void(0);"> Add Banner </a></li>

				</ol>

			</div>

		</div>

		<div id="content">

			<div class="row">

				<div class="col-md-12">

					<div class="panel">

						<div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Add Banner </span> </div>

						<div class="panel-body">

							<?php if ($this->session->flashdata('L_strErrorMessage')) { ?>
								<div class="alert alert-success alert-dismissable">

									<i class="fa fa-check"></i>

									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

									<b>Success!</b> <?php echo $this->session->flashdata('L_strErrorMessage'); ?>
								</div>
							<?php } ?>

							<?php if ($this->session->flashdata('flashError2') != '') { ?>

								<div class="alert alert-danger alert-dismissable">

									<i class="fa fa-warning"></i>

									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

									<b>Error!</b> <?php echo $this->session->flashdata('flashError2'); ?>

								</div>

							<?php }  ?>

							<div id="validator" class="alert alert-danger alert-dismissable" style="display:none;">

								<i class="fa fa-warning"></i>

								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

								<b>Error &nbsp; </b><span id="error_msg1"></span>

							</div>

							<div class="col-md-12">
								<form role="form" id="form" method="post" action="<?php echo $base_url; ?>banner/add" enctype="multipart/form-data">

									<INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">

									<INPUT TYPE="hidden" NAME="action" VALUE="add_banner">

									<div class="form-group">

										<label style="width:100%; margin:15px 0 5px;" for="categoryname">Title </label>

										<input id="title" name="title" type="text" class="form-control" placeholder="Enter Title " value="<?php echo $title; ?>" />
										<span id="catnameerror" class="valierror"></span>
									</div>


									<div class="form-group">

										<label style="width:100%; margin:15px 0 5px;" for="title_2">Title 2</label>

										<input id="title_2" name="title_2" type="text" class="form-control" placeholder="Enter Title 2" value="<?php echo $title_2; ?>" />
									</div>

									<div class="form-group">
										<label style="width:100%; margin:15px 0 5px;" for="categoryname">URL </label> <input id="url" name="url" type="text" class="form-control" placeholder="Enter URL " />
									</div>

									<div class="form-group">

										<label style="width:100%; margin:15px 0 5px;" for="categoryname">Image (Image size 1920px x 1000px at 72 dpi, JPG, JPEG accepted)</label>

										<input id="image" name="image" type="file" class="form-control" placeholder="Enter Image" value="<?php echo $image; ?>" style="height: auto; width: 250px; object-fit: contain" />
										<span id="catnameerror1" class="valierror"></span>
									</div>

									<!-- <div class="form-group">

				<label style="width:100%; margin:15px 0 5px;" for="categoryname">Page </label>

				<select name="activepage" id="activepage" class="form-control">
				   <?php if ($allactivepages != '' && count($allactivepages)) {
						foreach ($allactivepages as $activepage) {
							?>
				        <option value="<?php echo $activepage->id; ?>"><?php echo $activepage->pagename; ?></option>
				    <?php }
					} ?>
				</select>
                </div> -->

									<div class="form-group">

										<input class="submit btn bg-purple pull-right" type="submit" value="Submit" onclick="javascript:validate();return false;" />

										<a href="<?php echo $base_url; ?>banner/lists" class="submit btn btn-danger pull-right" style="margin-right: 10px;" />Cancel</a>

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

		var title = $("#title").val();

		if (title == '') {
			$("#catnameerror").html("Please Enter Title");
			jQuery('#catnameerror').show().delay(0).fadeIn('show');
			jQuery('#catnameerror').show().delay(2000).fadeOut('show');
			document.getElementById("catnameerror").scrollIntoView(true);
			return false;
		}
		var image = $("#image").val();

		if (image == '') {
			$("#catnameerror1").html("Please Select Banner Image");
			jQuery('#catnameerror1').show().delay(0).fadeIn('show');
			jQuery('#catnameerror1').show().delay(2000).fadeOut('show');
			document.getElementById("catnameerror1").scrollIntoView(true);
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