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

            <li class="crumb-link"><a href="<?php echo $base_url; ?>pincode/lists">Pincode</a></li>

            <li class="crumb-active"><a href="javascript:void(0);"> Add Pincode</a></li>

         </ol>

      </div>

   </div>

   <div id="content">

      <div class="row" id="subform">

         <div class="col-md-12">

            <div class="panel">

               <div class="panel-heading"> <span class="panel-title"> <span class="glyphicon glyphicon-lock"></span> Add Pincode </span> </div>

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

                  <div class="col-md-12" >

                     <form role="form" id="form" method="post" action="<?php echo $base_url;?>pincode/add" enctype="multipart/form-data">

                        <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand();?>">

                        <INPUT TYPE="hidden" NAME="action" VALUE="add_category">

                            

                           

                            <div class="form-group">

                               <label style="width:100%; margin:15px 0 5px;" for="state_id">

                                  State <span color="red">*</span><!--<span style="color:red"> *<span>-->

                               </label>

                               <select id="state_id" name="state_id" onchange="get_group(this.value);" class="form-control jobtext">

                                  <option value="" selected>-- Select State --</option>

                                  <?php for($i=0;$i<count($allstate);$i++)

                                     {

                                     ?>

                                  <option value='<?php echo $allstate[$i]->id; ?>'>

                                     <?php echo $allstate[$i]->name; ?>

                                  </option>

                                  <?php

                                     }

                                     ?>

                               </select>

                               <span id="catnameerror" class="valierror"></span>

                            </div>

                       

                        

                            <div class="form-group">

                               <label style="width:100%; margin:15px 0 5px;" for="city_id">

                                  City <span color="red">*</span><!--<span style="color:red"> *<span>-->

                               </label>

                               <span id="prod1">

                                <select id="city_id" name="city_id"  class="form-control jobtext">

                                    <option value="" selected>-- Select City --</option>

                                </select>

                            </span>

                               <span id="citynameerror" class="valierror"></span>

                            </div>

                       

                            <!-- <div class="form-group">

                               <label style="width:100%; margin:15px 0 5px;" for="city_id">Area <span color="red">*</span>

                               </label>

                               <span id="prod2">

                                <select id="area_id" name="area_id"  class="form-control jobtext">

                                    <option value="" selected>-- Select Area --</option>

                                </select>

                            </span>

                               <span id="areanameerror" class="valierror"></span>

                            </div> -->



                            <div class="form-group">

                               <label style="width:100%; margin:15px 0 5px;" for="name">Pincode <span color="red">*</span></label>

                               <input onkeypress="return numbersonly(event)" id="name" name="name" type="text" class="form-control" maxlength="6" placeholder="Enter Pincode Name" value=""/>

                               <span id="subcatnameerror" class="valierror"></span>    

                            </div>

                        

                        <div class="col-md-12">

                            <div class="form-group">

                               <input class="submit btn bg-purple pull-right" type="submit" value="Submit" onclick="javascript:validate();return false;"/>

                               <a href="<?php echo $base_url;?>pincode/lists" class="submit btn btn-danger pull-right" style="margin-right: 10px;" />Cancel</a>

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

		

		var state_id = $("#state_id").val();

		if(state_id == ''){

     		$("#catnameerror").html("Please Select State");

       		jQuery('#catnameerror').show().delay(0).fadeIn('show');

       		jQuery('#catnameerror').show().delay(2000).fadeOut('show');

       		document.getElementById("subform").scrollIntoView(true); 

       		return false;

		}



        var city_id = $("#city_id").val();

        if(city_id == ''){

            $("#citynameerror").html("Please Select City");

            jQuery('#citynameerror').show().delay(0).fadeIn('show');

            jQuery('#citynameerror').show().delay(2000).fadeOut('show');

            document.getElementById("subform").scrollIntoView(true); 

            return false;

        }



        var area_id = $("#area_id").val();

        if(area_id == ''){

            $("#areanameerror").html("Please Select Area");

            jQuery('#areanameerror').show().delay(0).fadeIn('show');

            jQuery('#areanameerror').show().delay(2000).fadeOut('show');

            document.getElementById("subform").scrollIntoView(true); 

            return false;

        }

        

		var sub_name = $("#name").val();

		if(sub_name == ''){

			

			$("#subcatnameerror").html("Please Enter Pincode");

       		jQuery('#subcatnameerror').show().delay(0).fadeIn('show');

       		jQuery('#subcatnameerror').show().delay(2000).fadeOut('show');

       		document.getElementById("subform").scrollIntoView(true); 

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

function get_group(cid)

{

		var url = '<?php echo $base_url ?>/pincode/show_city/';

		$.ajax({

		url:url,

		type:'post',

		data:'cid='+cid+'&sid=',

		success:function(msg)

		{

			

			document.getElementById('prod1').innerHTML = msg ;

		}

		});

}



function get_area(cid)

{

        var url = '<?php echo $base_url ?>/pincode/show_area/';

        $.ajax({

        url:url,

        type:'post',

        data:'cid='+cid+'&sid=',

        success:function(msg)

        {

            

            document.getElementById('prod2').innerHTML = msg ;

        }

        });

}





</script> 

