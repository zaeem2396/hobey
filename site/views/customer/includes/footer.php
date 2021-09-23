<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div style="display:none;">

                <div id="forgot-password" class="login-wrap">
                    <h3>Forgot Password</h3>
                    <p>Enter your registered email id below</p>
                    <form action="<?php echo $base_url; ?>home/reset_password" method="post" id="reset_form">


                        <div id="error_reset" class="alert-message valierror " style="display:none;width: 100%;">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>

                        <div id="sucess_reset" class="alert-message " style="display:none;width: 100%;background-color:green;">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        </div>

                        <div class="form-group">
                            <label for="email">Email address:</label>
                            <input type="email" placeholder="abc@gmail.com" class="form-control" id="reset_email" name="reset_email">
                        </div>

                        <div class="clearfix">
                            <div class="pull-left"><button type="button" onClick="javascript:reset_password(); return false;" class="btn btn-default-red">Submit <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button></div>
                            <div class="pull-right forgot-login-text">
                                <a class="login" href="#login-form">Login to your Account</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div style="display:none">
                <div id="login-form">
                    <div class="login-wrap">
                        <h3>Log in</h3>
                        <p>If you have an account, sign in with your email address.</p>
                        <div class="mb-30">
                            <form action="<?php echo $base_url; ?>home/login_customer" method="post" id="login_form_header">
                                <input type="hidden" name="redirect_url" value="<?php echo @$_SERVER['HTTP_REFERER']; ?>" />
                                <input type="hidden" name="action" value="login" />
                                <div id="login_error" class="alert-message valierror form-group" style="display:none;">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>
                                <div class="form-group">
                                    <label for="email">Email address :</label>
                                    <input type="email" class="form-control" name="login_email" id="login_email">
                                </div>
                                <div class="form-group">
                                    <label for="pwd">Password :</label>
                                    <input type="password" class="form-control" name="login_password" id="login_password">
                                </div>
                                <div class="checkbox clearfix">
                                    <label class="pull-left">
                                        <!-- <input type="checkbox">Remember me --></label>
                                    <label class="pull-right">
                                        <a class="forgot-password" href="#forgot-password">Forgot your password?</a>
                                    </label>
                                </div>
                                <button type="button" onClick="javascript:header_logins(); return false;" class="btn btn-default-red">Login <i class="fa fa-sign-in" aria-hidden="true"></i></button>
                                <div class="create-new">
                                    <p><a class="register" href="#register-form">If you don’t have an account, register now!</a></p>
                                </div>
                            </form>

                        </div>
                        <!-- <div class="loginOr mb-15"><span>OR</span></div>
                            
                            <div class="login-social-media">
                                <a href="#" class="facebook">Facebook</a>
                                <a href="#" class="google">Google</a>
                            </div> -->

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div style="display:none">
                <div id="register-form">
                    <div class="login-wrap">
                        <h3>Register New Account</h3>
                        <form id="register-forms" name="registerfor" action="<?php echo $base_url; ?>home/register" enctype="multipart/form-data" method="post">
                            <div id="error_msg1" class="alert-message valierror form-group" style="display:none;">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>
                            <input type="hidden" name="action" value="registration" />
                            <div class="form-group">
                                <label for="email">Name :</label>
                                <input type="text" id="register_name" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Email Id :</label>
                                <input type="text" class="form-control" id="register_email" name="register_email">
                            </div>
                            <div class="form-group">
                                <label for="email">Pincode :</label>
                                <input type="text" class="form-control" id="register_pincode" name="register_pincode">
                            </div>

                            <div class="form-group">
                                <label for="email">Mobile No :</label>
                                <input type="text" class="form-control" id="register_mobile" name="register_mobile">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password :</label>
                                <input type="password" class="form-control" id="register_password" name="register_password">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Repeat Password :</label>
                                <input type="password" class="form-control" id="conf_password" name="conf_password">
                            </div>

                            <button type="button" onclick="register();return false;" class="btn btn-default-red">Register <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--footer links -->
<div class="footer-links">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="contc">
                    <a href="<?php echo $base_url; ?>complaint">Complaint / Feedback</a> &nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $base_url; ?>customer-support">Customer Support</a>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="social-media-icon">
                    <a href="https://www.facebook.com/BharatPetroleumcorporation" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="https://twitter.com/bpclimited" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    <a href="https://www.youtube.com/user/bpclbrand" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                    <a href="https://www.instagram.com/bpclimited/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    <a href="https://www.linkedin.com/company/bpcl?trk=tyah" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>


                </div>

            </div>
        </div>
    </div>
</div>
</div>
<!--footer copy right-->
<div class="footer-copy">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">2021 Copyright Bharat Petroleum Corporation Limited All Rights Reserved.</div>
        </div>
    </div>
</div>
<a id="back-to-top" href="#" class="back-to-top btn-primary" role="button" data-toggle="tooltip" data-placement="left">
    <i class="fa fa-angle-up" aria-hidden="true"></i></a>
<!-- 
<a id="back-to-top" href="#" class="back-to-top btn-primary" role="button" data-toggle="tooltip" data-placement="left">
<i class="fa fa-angle-up" aria-hidden="true"></i></a>
<a id="back-to-top" href="#" class="back-to-top btn-primary" role="button" data-toggle="tooltip" data-placement="left">
<i class="fa fa-angle-up" aria-hidden="true"></i></a> -->
<!--footer copy right End-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> -->
<script src="<?php echo $base_url_views; ?>customer/js/jquery.min.js"></script>
<script src="<?php echo $base_url_views; ?>customer/js/bootstrap.min.js"></script>

<!-- <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script> -->
<script src="<?php echo $base_url_views; ?>customer/js/jquery.scrolling-tabs.js"></script>
<script src="<?php echo $base_url_views; ?>customer/js/bootstrap.offcanvas.min.js"></script>
<script src="<?php echo $base_url_views; ?>customer/js/easy-responsive-tabs.js"></script>
<script src="<?php echo $base_url_views; ?>customer/js/jquery.fancybox.js"></script>
<script src="<?php echo $base_url_views; ?>customer/js/owl.carousel.min.js"></script>

<script>
    (function($) {
        'use strict';
        $(document).on('show.bs.tab', '.nav-tabs-responsive [data-toggle="tab"]', function(e) {
            var $target = $(e.target);
            var $tabs = $target.closest('.nav-tabs-responsive');
            var $current = $target.closest('li');
            var $parent = $current.closest('li.dropdown');
            $current = $parent.length > 0 ? $parent : $current;
            var $next = $current.next();
            var $prev = $current.prev();
            var updateDropdownMenu = function($el, position) {
                $el
                    .find('.dropdown-menu')
                    .removeClass('pull-xs-left pull-xs-center pull-xs-right')
                    .addClass('pull-xs-' + position);
            };
            $tabs.find('>li').removeClass('next prev');
            $prev.addClass('prev');
            $next.addClass('next');

            updateDropdownMenu($prev, 'left');
            updateDropdownMenu($current, 'center');
            updateDropdownMenu($next, 'right');
        });
    })(jQuery);
    jQuery(".fa-icon-menu").click(function() {
        $(".dor-verticalmenu").slideToggle("fast", function() {
            var isVisible = $(".dor-verticalmenu").is(":visible");
        });
    });
    jQuery(".login").fancybox({
        'hideOnContentClick': true,
    });
    $(".register").fancybox({
        'hideOnContentClick': true,
    });
    $(".forgot-password").fancybox({
        'hideOnContentClick': true,
    });
    $(window).scroll(function() {
        if ($(this).scrollTop() > 1400) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    // scroll body to 0px on click
    $('#back-to-top').click(function() {
        $('#back-to-top').tooltip('hide');
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    $('#back-to-top').tooltip('show');
    $('#myCarousel').carousel();
    var winWidth = $(window).innerWidth();
    $(window).resize(function() {
        if ($(window).innerWidth() < winWidth) {
            $('.carousel-inner>.item>img').css({
                'min-width': winWidth,
                'width': winWidth
            });
        } else {
            winWidth = $(window).innerWidth();
            $('.carousel-inner>.item>img').css({
                'min-width': '',
                'width': ''
            });
        }
    });
    /*$(".cart-items").hover(function(){
        $('.shopping-cart-show').removeClass('hidden');
    },function(){
        $('.shopping-cart-show').addClass('hidden');
    });
    */
    $(".cart-items").click(function() {
        if ($(".shopping-cart-show").is(":hidden")) {
            $(".shopping-cart-show").slideDown("slow");
        } else {
            $(".shopping-cart-show").hide();
        }
    });
    $(".shopping-cart-show").mouseleave(function() {
        $(this).hide();
    });

    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        dots: false,
        navText: ["<i class='fa fa-angle-left' aria-hidden='true'></i>", "<i class='fa fa-angle-right' aria-hidden='true'></i>"],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 4
            },
            1000: {
                items: 4
            }
        }
    })

    function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass('fa fa-plus fa fa-minus');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);
</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.js'></script>
<!--<script>
$(document).ready(function(){
    $('.carousel').carousel({
      interval: 2000
    })
});
</script>-->
</body>

</html>

<script>
    function header_logins() {
        var email = $("#login_email").val();
        if (email == '') {

            $('#login_error').html("Please enter Email Id");
            $('#login_error').show().delay(0).fadeIn('show');
            $('#login_error').show().delay(2000).fadeOut('show');
            return false;
        }


        var em = $('#login_email').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(em)) {

            $('#login_error').html("Enter Valid Email Address.");
            $('#login_error').show().delay(0).fadeIn('show');
            $('#login_error').show().delay(2000).fadeOut('show');
            //em.focus;
            return false;
        }

        var password = $("#login_password").val();

        if (password == '') {
            $('#login_error').html("Please enter Password");
            $('#login_error').show().delay(0).fadeIn('show');
            $('#login_error').show().delay(2000).fadeOut('show');

            return false;
        }

        var url = '<?php echo $base_url; ?>home/checlogin_customer';
        $.ajax({
            url: url,
            type: 'post',
            data: 'email=' + email + '&password=' + password,
            success: function(msg) {

                if (msg == "0") {
                    $('#login_error').html("Please enter Correct Email & Password");
                    $('#login_error').show().delay(0).fadeIn('show');
                    $('#login_error').show().delay(2000).fadeOut('show');
                    return false;
                } else {
                    $('#login_form_header').submit();
                }

            }
        });

    }
</script>
<script>
    function register() {
        var fname = $("#register_name").val();
        // alert(fname);
        if (fname == '') {

            $("#error_msg1").html("Please Enter Name.");
            $('#error_msg1').show().delay(0).fadeIn('show');
            $('#error_msg1').show().delay(2000).fadeOut('show');
            return false;
        }

        var email = $("#register_email").val();
        if (email == '') {

            $("#error_msg1").html("Please Enter Email Id.");
            $('#error_msg1').show().delay(0).fadeIn('show');
            $('#error_msg1').show().delay(2000).fadeOut('show');
            return false;
        }

        var em = $("#register_email").val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(em)) {
            $("#error_msg1").html("Enter Valid Email Address.");
            $('#error_msg1').show().delay(0).fadeIn('show');
            $('#error_msg1').show().delay(2000).fadeOut('show');
            return false;
        }

        var register_mobile = $("#register_mobile").val();
        if (register_mobile == '') {

            $("#error_msg1").html("Please Enter Mobile No.");
            $('#error_msg1').show().delay(0).fadeIn('show');
            $('#error_msg1').show().delay(2000).fadeOut('show');
            return false;
        }


        var register_pincode = $("#register_pincode").val();
        if (register_pincode == '') {
            //alert('Please Enter Country ');
            $("#error_msg1").html("Please Enter Pincode.");
            $('#error_msg1').show().delay(0).fadeIn('show');
            $('#error_msg1').show().delay(2000).fadeOut('show');
            return false;
        }

        var url = '<?php echo $base_url; ?>home/checkemail';
        $.ajax({
            url: url,
            type: 'post',
            data: 'email=' + email,
            success: function(msg) {
                if (msg == "0") {
                    $("#error_msg1").html("Email Address Already Exists.");
                    $('#error_msg1').show().delay(0).fadeIn('show');
                    $('#error_msg1').show().delay(2000).fadeOut('show');
                    $('email').val('');
                    return false;
                }

                var password = $("#register_password").val();
                if (password == '') {
                    //alert('Please Enter Country ');
                    $("#error_msg1").html("Please Enter password.");
                    $('#error_msg1').show().delay(0).fadeIn('show');
                    $('#error_msg1').show().delay(2000).fadeOut('show');
                    return false;
                }

                var cpassword = $("#conf_password").val();
                if (cpassword == '') {
                    $("#error_msg1").html("Please Enter Confirm password.");
                    $('#error_msg1').show().delay(0).fadeIn('show');
                    $('#error_msg1').show().delay(2000).fadeOut('show');
                    return false;
                }

                if (cpassword != password) {
                    $("#error_msg1").html("Password Do Not Match.");
                    $('#error_msg1').show().delay(0).fadeIn('show');
                    $('#error_msg1').show().delay(2000).fadeOut('show');
                    return false;
                }

                $('#register-forms').submit();
            }
        });

    }

    function reset_password() {

        var reset_email = $("#reset_email").val();
        if (reset_email == '') {

            $('#error_reset').html("Please enter Email Id");
            $('#error_reset').show().delay(0).fadeIn('show');
            $('#error_reset').show().delay(2000).fadeOut('show');
            return false;
        }

        var em = $('#reset_email').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(em)) {
            $('#error_reset').html("Enter Valid Email Address.");
            $('#error_reset').show().delay(0).fadeIn('show');
            $('#error_reset').show().delay(2000).fadeOut('show');
            return false;
        }
        var url = '<?php echo $base_url; ?>home/checkemail';
        $.ajax({
            url: url,
            type: 'post',
            data: 'email=' + reset_email,
            success: function(msg) {
                if (msg == "1") {
                    $('#error_reset').html("Email id dose not exist");
                    $('#error_reset').show().delay(0).fadeIn('show');
                    $('#error_reset').show().delay(2000).fadeOut('show');
                    return false;
                } else {
                    var url = '<?php echo $base_url; ?>home/reset_password';
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: 'reset_email=' + reset_email,
                        success: function(msg) {
                            if (msg == "1") {
                                $('#reset_email').val('');
                                $('#sucess_reset').html("Email has been sent successfully");
                                $('#sucess_reset').show().delay(0).fadeIn('show');
                                $('#sucess_reset').show().delay(2000).fadeOut('show');
                                return false;
                            } else {
                                $('#reset_email').val('');
                                $('#sucess_reset').html("The email ID does not exist.");
                                $('#sucess_reset').show().delay(0).fadeIn('show');
                                $('#sucess_reset').show().delay(2000).fadeOut('show');
                                return false;
                            }

                        }
                    });
                    /*  $('#reset_form').submit();  */
                }

            }
        });

    }
</script>