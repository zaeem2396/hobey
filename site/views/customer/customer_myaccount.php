<?php include('includes/header.php'); ?>

<!--navBar content End-->
<!--Product page-->
<div class="container">
    <div class="row mb-50 pdd50">


        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home" aria-hidden="true"></i></a></li>

                <li class="breadcrumb-item active" aria-current="page">My account</li>
            </ol>
        </nav>
        <div class="col-md-12">
            <span id="register_success" class="alert-message successmain valierror123 form-group" style="display:none;margin-bottom: 5px;"></span>
            <div id="verticalTab">
                <h4>My Account <i class="fa fa-level-down" aria-hidden="true"></i></h4>
                <ul class="resp-tabs-list">
                    <li><i class="fa fa-user" aria-hidden="true"></i> Personal Information</li>
                    <li><i class="fa fa-user" aria-hidden="true"></i>Change Password</li>
                    <li><i class="fa fa-book" aria-hidden="true"></i> My Orders</li>
                    <li><i class="fa fa-map-marker fa-lg" aria-hidden="true"></i> Addresses</li>
                    <li><i class="fa fa-heart" aria-hidden="true"></i> My Wishlist</li>

                </ul>

                <div class="resp-tabs-container">
                    <div class="personal-details">
                        <form method="POST" id="form_profile" enctype="multipart/form-data" action="<?php echo $base_url; ?>vendor-my-account">
                            <div id="error_profile" class="alert-message valierror form-group" style="display:none;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>

                            <input type="hidden" name="action" value="update_profile">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Personal Details</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input placeholder="Full Name" class="form-control" type="text" name="fname" id="fname_pro" value="<?php echo @$profile->name; ?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                        <input placeholder="Email ID" class="form-control" type="text" readonly value="<?php echo @$profile->email; ?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                                        <input placeholder="Mobile Number" class="form-control" id="mobile_pro" name="mobile" value="<?php echo @$profile->mobile; ?>" type="text">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                        <input placeholder="Location Pincode" class="form-control" type="text" id="pincode" name="pincode" value="<?php echo @$profile->pincode; ?>">
                                    </div>
                                </div>
                                <!-- <div class="col-xs-8 col-md-3">
                        	<div class="form-group">
                                Reset Password?
                            </div>
                        </div>
                        <div class="col-xs-4 col-md-9">
                        	<div class="form-group">
                                <input name="" type="checkbox" value="">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12">
                        	<div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
                                <input placeholder="Current Password" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-12">
                        	<div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
                                <input placeholder="New Password" class="form-control" type="text">
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                        	<div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
                                <input placeholder="Confirm Password" class="form-control" type="text">
                            </div>
                        </div> -->
                                <div class="col-md-12">
                                    <button type="button" onClick="javascript:profile_form_vali(); return false;" class="btn btn-default-red">Save Changes <i class="fa fa-check" aria-hidden="true"></i></button>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="change-password">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Change Password</h4>
                            </div>
                        </div>
                        <form action="" method="POST" id="form_password" enctype="multipart/form-data" action="<?php echo $base_url; ?>vendor-my-account">
                            <div id="error_profile_password" class="alert-message valierror form-group" style="display:none;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            </div>
                            <input type="hidden" name="action" value="update_password">
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
                                        <input placeholder="Current Password" name="old_password" id="old_password" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
                                        <input placeholder="New Password" name="pass" id="pass" class="form-control" type="text">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
                                        <input id="cpass" placeholder="Confirm Password" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-default-red" onClick="javascript:password_form_vali(); return false;">Save Changes <i class="fa fa-check" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="my-order">
                        <div id="accordion">
                            <div class="row mb-15">

                                <?php  //echo "<pre>"; print_r($orders_list); die;
                                if (count($orders_list) > 0) {
                                    $i = 0;
                                    foreach ($orders_list as $order) {
                                        ?>
                                        <div class="col-md-12 clearfix">
                                            <div class="accordion-heading font-size-14">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i; ?>">Order Number
                                                    #<?php echo $order['order_id'] ?></a>
                                            </div>
                                            <div id="collapseOne<?php echo $i; ?>" class="accordion-body collapse <?php if ($i == 0) {
                                                                                                                                echo "in";
                                                                                                                            } ?>">
                                                <div class="padding-15">
                                                    <div class="accordion-toggle">
                                                        <button type="button" onclick="createinvoice(<?php echo $order['order_id'] ?>);" data-toggle="modal" data-target="#invoce_modal" class="btn btn-default-red" style="float:right;padding: 6px 20px;">Invoice</button>
                                                        <div class="col-xs-12 col-md-6 col-md-push-6 text-xs-center text-sm-center text-right mb-15 padding-none">
                                                            <p>
                                                                <!--- <button type="submit" class="btn grey-btn-samll"><i class="fa fa-undo" aria-hidden="true"></i> Return Order</button>-->
                                                                <!-- <button type="submit" class="btn grey-btn-samll">Cancel Order <i class="fa fa-times" aria-hidden="true"></i></button> -->
                                                            </p>
                                                        </div>
                                                        <div class="col-xs-12 col-md-6 col-md-pull-6 text-xs-center text-sm-center mb-15 padding-none">
                                                            <section class="mb-5 font-size-18">Order Number
                                                                #<?php echo $order['order_id'] ?></section>
                                                            <section class="mb-15 font-size-13">Placed on <?php $order_date = strtotime($order['cdate']);
                                                                                                                    echo $mysqldate = date('l, F d, Y', $order_date); ?></section>

                                                        </div>

                                                        <?php
                                                                /*echo "<pre>";
                                           print_R($order['items']);*/
                                                                foreach ($order['items'] as $item) { ?>
                                                            <div class="col-xs-12 text-xs-center padding-none">
                                                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 mb-15 text-xs-center padding-none">
                                                                    <?php
                                                                                if ($item['base_image'] != '') { ?>
                                                                        <img src="<?php echo $http_host; ?>upload/product/<?php echo $item['base_image']; ?>">
                                                                    <?php } else { ?>
                                                                        <img src="<?php echo $base_url_views; ?>images/noimage.jpg">
                                                                    <?php }  ?>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-9 col-xs-12">
                                                                    <section class="font-size-18 mb-5">
                                                                        <?php echo $item['order_item_name']; ?></section>
                                                                    <section class="mb-5"><?php echo $item['material']; ?></section>
                                                                    <section class="mb-5">Quantity -
                                                                        <?php echo $item['product_quantity']; ?></section>

                                                                    <section class="mb-5">Discount - <i class="fa fa-inr"></i><?= $order['coupondiscount']; ?>
                                                                    </section>

                                                                    <section class="font-size-18 mb-15"><i class="fa fa-inr"></i>
                                                                        <?php echo number_format($item['product_item_price']); ?>
                                                                    </section>
                                                                </div>
                                                                <div class="col-sm-3 visible-sm"></div>
                                                                <div class="col-lg-4 col-md-4 col-sm-9 col-xs-12 mb-15" style="display: block;">
                                                                    <section class="font-size-18 "> <b>Order Status : </b>
                                                                        <?php
                                                                                    if ($item['order_status'] == 'P') {
                                                                                        echo "pending";
                                                                                    } else if ($item['order_status'] == 'S') {
                                                                                        echo "Shipped";
                                                                                    } else if ($item['order_status'] == 'D') {
                                                                                        echo "Delivered";
                                                                                    } else {
                                                                                        echo "pending";
                                                                                    }
                                                                                    ?>

                                                                    </section>
                                                                    <section class="font-size-18 mb-10">Delivered address</section>
                                                                    <section class="mb-10"><?php echo $order['first_name']; ?>
                                                                        <?php echo $order['last_name']; ?></section>
                                                                    <section> <?php echo $order['address1']; ?> ,
                                                                        <?php echo $order['address2']; ?> ,
                                                                        <?php echo $order['city']; ?> , <?php echo $order['state']; ?>
                                                                        , <?php echo $order['post_code']; ?> </section>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="col-xs-12 padding-10 text-center bg-red font-size-20 mb-30">
                                                            <i class="fa fa-minus" aria-hidden="true"></i> Total <i class="fa fa-inr"></i>
                                                            <?php echo number_format($order['order_total']); ?> <i class="fa fa-minus" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php $i++;
                                    }
                                } else {
                                    echo "Order Not found";
                                } ?>
                            </div>
                        </div>
                    </div>

                    <div class="address">
                        <div class="row">
                            <?php if ($getadd_all != "" && count($getadd_all) > 0) {
                                foreach ($getadd_all as $get_addres) {
                                    ?>
                                    <div class="col-md-4 col-xs-12 mb-30">
                                        <div class="border-solid padding-15">
                                            <div class="border-dotted-bottom mb-15">
                                                <label class="control control--radio">
                                                    Make Default Address
                                                    <input name="address" <?php if ($get_addres->default_address == '1') {  ?> checked="" <?php } ?> type="radio" onclick="defaultaddress('<?php echo $base_url . "account/defaultaddress/"; ?><?php echo $get_addres->id ?>');return false;">
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </div>
                                            <div>
                                                <p><?php echo $get_addres->first_name; ?> <?php echo $get_addres->last_name; ?>
                                                </p>
                                                <p><?php echo $get_addres->address1; ?>, <?php echo $get_addres->address2; ?>
                                                </p>
                                                <p><?php echo $get_addres->city; ?> , <?php echo $get_addres->post_code; ?></p>
                                                <p><?php echo $get_addres->state; ?></p>
                                                <p><?php echo $get_addres->phone_number; ?></p>
                                                <p class="add-trash-icon clearfix">
                                                    <span class="pull-left"><a href="<?php $base_url; ?>account/edit_address/<?php echo $get_addres->id; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>
                                                    <span class="pull-right"><a href="javascript:void(0);" onclick="deleteaddress('<?php echo $base_url . "account/removeadd/"; ?><?php echo $get_addres->id ?>');return false;"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                            <?php }
                            } ?>

                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-30"> <a class="add-address-btn" data-toggle="collapse" data-target="#newShippingAddress"><i class="fa fa-plus" aria-hidden="true"></i> Add
                                    New Address</a> </div>
                        </div>

                        <div class="row">
                            <div class="collapse" id="newShippingAddress">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-12 mb-5">
                                            <h4>Address</h4>
                                        </div>
                                    </div>
                                    <form class="form-horizontal" action="<?php echo $base_url; ?>customer-my-account" id="form_address_add" name="form_address_add" method="POST">
                                        <input type="hidden" name="action" value="add_profile">
                                        <!-- <div class="form-group">
                          <label class="control-label col-sm-3">Address Title</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="address_title" name="address_title">
                          </div>
                        </div> -->
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="first_name" id="first_name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Pincode</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="post_code" id="post_code">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Address</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" rows="5" name="address1" id="address1"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Landmark</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" placeholder="(Optional)" name="address2" id="address2">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">City</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="city" id="city">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">State</label>
                                            <div class="col-sm-9">
                                                <!-- <input type="text" class="form-control" id=""> -->
                                                <select class="form-control" name="state" id="state">
                                                    <option value="">Select State</option>
                                                    <?php
                                                    if ($all_state != '') {
                                                        foreach ($all_state as $get_state) {
                                                            ?>
                                                            <option value="<?php echo $get_state->name; ?>">
                                                                <?php echo $get_state->name; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Country</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="country" id="country">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="pwd">Phone</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="phone_number" id="phone_number">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">&nbsp;</label>
                                            <div class="col-sm-9">
                                                <div id="error_checkout" class="error alert-message valierror form-control" style="display:none;color:#fff;"></div>
                                                <button type="button" onclick="saveAddress();" class="btn btn-default-red">Save and Continue <i class="fa fa-bookmark-o" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="my-wishlist text-xs-center text-sm-center">
                        <?php
                        if (isset($allwishlist) && count($allwishlist) > 0) {
                            foreach ($allwishlist as $item) { ?>
                                <div class="row border-solid-bottom padding-bottom-15 padding-top-15">
                                    <div class="col-md-2 mrg-bot-15">
                                        <?php
                                                $material_type = $this->home_model->get_category($item->material_type);
                                                if ($item->product_image != '') { ?>
                                            <img src="<?php echo $http_host; ?>upload/product/<?php echo $item->product_image; ?>">
                                        <?php } else { ?>
                                            <img src="<?php echo $base_url_views; ?>images/noimage.jpg">
                                        <?php }  ?>
                                    </div>
                                    <div class="col-md-4">
                                        <p><?php echo $item->material_name; ?>
                                            <p><?php echo $material_type->name; ?></p>

                                    </div>
                                    <div class="col-md-4 mrg-bot-15"><a href="javascript:void(0);" onClick="delete_wishlist('<?php echo $base_url . "account/delete_wishlist/"; ?><?php echo $item->wish_id ?>');return false;">Remove
                                            from wishlist</a></div>
                                    <div class="col-md-2"><i class="fa fa-inr"></i> <?php echo $item->bpcl_special_price; ?>
                                    </div>
                                </div>
                        <?php }
                        } else {
                            echo "No Products added to wishlist ";
                        } ?>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<?php include('includes/footer.php'); ?>
<div class="modal fade" id="create_label_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" id="create_label_html">

        </div>
    </div>
</div>
<script>
    function createinvoice(id) {
        var itemid = id;
        var url = '<?php echo $base_url; ?>account/createinvoice_vendor';
        jQuery.ajax({
            url: url,
            type: 'post',
            data: 'itemid=' + itemid,
            success: function(msg) {
                $('#create_label_html').html(msg);
                $('#create_label_modal').modal('show');
            }
        });
    }
    $('#verticalTab').easyResponsiveTabs({
        type: 'vertical',
        width: 'auto',
        fit: true
    });
    $('#accordion').on('click', function() {
        if ($('.collapse:not(.in)')) {
            $.collapse("toggle");
        }
    });
</script>

<script>
    function profile_form_vali() {
        var fname = $("#fname_pro").val();
        if (fname == '') {

            $('#error_profile').html("Please Enter Full Name");
            $('#error_profile').show().delay(0).fadeIn('show');
            $('#error_profile').show().delay(6000).fadeOut('show');
            return false;
        }

        var mobile = $("#mobile_pro").val();
        if (mobile == '') {
            $('#error_profile').html("Please Enter Mobile Number");
            $('#error_profile').show().delay(0).fadeIn('show');
            $('#error_profile').show().delay(6000).fadeOut('show');
            return false;
        }
        var em = $('#mobile_pro').val();
        var filter = /^[0-9]{10}$/;
        if (!filter.test(em)) {
            $('#error_profile').html("Enter Mobile Number should be 10 digits.");
            $('#error_profile').show().delay(0).fadeIn('show');
            $('#error_profile').show().delay(2000).fadeOut('show');
            return false;
        }

        var pincode = $("#pincode").val();
        if (pincode == '') {
            $('#error_profile').html("Please Enter Pincode");
            $('#error_profile').show().delay(0).fadeIn('show');
            $('#error_profile').show().delay(6000).fadeOut('show');
            return false;
        }


        $('#form_profile').submit();
    }

    function password_form_vali() {
        var old_password = jQuery("#old_password").val();
        if (old_password == '') {
            jQuery('#error_profile_password').html("Please Enter Current Password");
            jQuery('#error_profile_password').show().delay(0).fadeIn('show');
            jQuery('#error_profile_password').show().delay(2000).fadeOut('show');
            return false;
        }

        var old_password_check = '<?php echo $profile->password; ?>';

        if (old_password != old_password_check) {
            jQuery('#error_profile_password').html("Old password entered is invalid. please enter valid password.");
            jQuery('#error_profile_password').show().delay(0).fadeIn('show');
            jQuery('#error_profile_password').show().delay(2000).fadeOut('show');
            return false;
        }

        var fname = jQuery("#pass").val();
        if (fname == '') {
            jQuery('#error_profile_password').html("Please Enter New Password");
            jQuery('#error_profile_password').show().delay(0).fadeIn('show');
            jQuery('#error_profile_password').show().delay(2000).fadeOut('show');
            return false;
        }
        var lname = jQuery("#cpass").val();
        if (lname == '') {
            jQuery('#error_profile_password').html("Please Enter Confirm New Password");
            jQuery('#error_profile_password').show().delay(0).fadeIn('show');
            jQuery('#error_profile_password').show().delay(2000).fadeOut('show');
            return false;
        }

        if (fname != lname) {
            jQuery('#error_profile_password').html("New Password & Confirm Password doesn't Match");
            jQuery('#error_profile_password').show().delay(0).fadeIn('show');
            jQuery('#error_profile_password').show().delay(2000).fadeOut('show');
            return false;
        }

        jQuery('#form_password').submit();
    }


    function delete_wishlist(url) {
        var t = confirm('Are you sure you want to Delete wishlist ?');
        if (t) {
            window.location.href = url;
        } else {
            return false;
        }
    }
</script>

<?php if ($this->session->flashdata('register_success') != "") { ?>
    <script>
        $(document).ready(function() {
            //$('#messagealert').modal();
            $('#register_success').html("<?php echo $this->session->flashdata('register_success'); ?>");
            $('#register_success').show().delay(0).fadeIn('show');
            $('#register_success').show().delay(6000).fadeOut('show');

        });
    </script>

<?php } ?>
<script>
    function saveAddress() {
        /*var address_title = $("#address_title").val();
        if(address_title == ''){
            $("#error_checkout").html("Please Enter Title.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        } */
        var first_name = $("#first_name").val();
        if (first_name == '') {
            $("#error_checkout").html("Please Enter Name.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }

        var post_code = $("#post_code").val();
        if (post_code == '') {
            $("#error_checkout").html("Please Enter Pincode.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }

        var checkout_address = $("#address1").val();
        if (checkout_address == '') {
            $("#error_checkout").html("Please Enter Address.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }

        var checkout_country = $("#city").val();
        if (checkout_country == '') {
            $("#error_checkout").html("Please Select City.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }
        var checkout_state = $("#state").val();
        if (checkout_state == '') {
            $("#error_checkout").html("Please Select State.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }
        var country = $("#country").val();
        if (country == '') {
            $("#error_checkout").html("Please Enter Country.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }

        var phone_number = $("#phone_number").val();
        if (phone_number == '') {
            $("#error_checkout").html("Please Enter Phone Number.");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }

        var emn = $("#phone_number").val();
        var filter_number = /^[0-9]{10}$/;
        if (!filter_number.test(emn)) {
            $("#error_checkout").html("Enter Phone Number should be 10 digits");
            $('#error_checkout').show().delay(0).fadeIn('show');
            $('#error_checkout').show().delay(2000).fadeOut('show');
            return false;
        }

        $('#form_address_add').submit();
    }

    function deleteaddress(url) {
        var t = confirm('Are you sure you want to Delete Address ?');
        if (t) {
            window.location.href = url;
        } else {
            return false;
        }
    }


    function defaultaddress(url) {
        var t = confirm('Are you sure you want to Default Address ?');
        if (t) {
            window.location.href = url;
        } else {
            return false;
        }
    }
</script>