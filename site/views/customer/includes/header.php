<?php
$front_base_url = $this->config->item('front_base_url');
$base_url     = $this->config->item('base_url');
$index_url     = $this->config->item('index_url');
$findex_url     = $this->config->item('findex_url');
$base_url_views = $this->config->item('base_url_views');
$http_host = $this->config->item('http_host');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bharat Petroleum |Oil & Gas Companies in India |Top Petroleum Companies | Petroleum Distribution companies</title>

  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <!-- Bootstrap -->
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
  <link href="<?php echo $base_url_views; ?>customer/css/stylesheet.css" rel="stylesheet">
  <link href="<?php echo $base_url_views; ?>customer/css/responsive.css" rel="stylesheet">
  <link href="<?php echo $base_url_views; ?>customer/css/jquery.scrolling-tabs.css" rel="stylesheet" type="text/css">
  <link href="<?php echo $base_url_views; ?>customer/css/bootstrap.offcanvas.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo $base_url_views; ?>customer/css/owl.carousel.css" rel="stylesheet" type="text/css">
  <link href="<?php echo $base_url_views; ?>customer/css/easy-responsive-tabs.css" rel="stylesheet">
  <link href="<?php echo $base_url_views; ?>customer/css/style.css" rel="stylesheet">
  <link href="<?php echo $base_url_views; ?>customer/css/jquery.fancybox.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="<?php echo $base_url_views; ?>customer/css/magiczoomplus.css" rel="stylesheet" type="text/css">
  <style>
    .inline-block {
      display: table-cell;
    }

    .goog-te-gadget .goog-te-combo {
      margin: 13px 0 !important;
    }

    .sp-icon {
      position: absolute;
      right: 0px;
      top: -8px;
    }

    .goog-logo-link {
      display: none;
    }

    .create-new {
      margin-top: 20px;
    }

    .contc a:hover {
      color: #fff;
      font-size: 22px;
    }

    .fnt12 {
      font-size: 12px;
    }

    .carousel {
      position: relative;
      overflow: hidden;
    }


    @media (max-width: 1169px) {
      .goog-te-gadget {
        right: 238px;
      }

      .sp-icon {
        right: 0;
      }
    }


    @media (max-width: 767px) {
      .inline-block {
        display: inline-block;
      }

      .goog-te-gadget {
        right: 15px;
      }

      .sp-icon {
        right: 25px;
        top: 0px;
      }

      .top-content {
        padding: 18px 0px 38px 0px;
      }

      div#google_translate_element {
        position: relative !important;
        top: 0px;
      }

      .carousel {
        position: relative;
        overflow: hidden;
      }

      .banner_textt {
        position: absolute;
        top: 0;
        left: 0px;
        width: 100%;
        background-color: #0000008c;
        padding: 38px;
        text-align: left;
        color: #fff;
      }

      .banner_textt h1 {
        font-size: 16px;
        font-weight: bold;
      }

      .banner_textt p {
        font-size: 12px;
      }
    }
  </style>
</head>

<body>
  <!--top content-->
  <div class="top-content">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-sm-3 col-xs-3 text-xs-left">
          <div class="inline-block mob-bdr-right mob-padd-right-7 mob-mrg-right-5"></div>
          <div class="inline-block sell-icon-mob"><a href="#" class="visible-xs"><i class="fa fa-map-marker" aria-hidden="true" style="font-size: 24px;"></i> </a></div>
          <span class="hidden-xs" style="display: inherit;"><i class="fa fa-map-marker" aria-hidden="true" style="font-size: 24px;"></i> <span>Deliver to </span> <?php echo $this->session->userdata('check_pincode'); ?> &nbsp;<a href="javascript:void(0);" id="OpenPincodeModal"><i class="fa fa-edit"></i> </a></span>
        </div>

        <div class="col-md-8 col-sm-8 col-xs-9 text-lg-right text-xs-right">


          <div class="sp-icon">
            <div class="inline-block">
              <?php if ($this->session->userdata('userid') != '') { ?>
                <span class="register-icon"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;<a class="register" href="<?php echo $base_url; ?>customer-my-account"><?php if ($this->session->userdata('userid') != '') { ?> Hi <?php echo $this->session->userdata('name'); ?>&nbsp;&nbsp; <?php } ?></a></span>
                <span class="register-icon"><i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp;<a class="register" href="<?php echo $base_url; ?>logout">Logout</a></span>
              <?php } else { ?>
                <span class="login-icon"><a class="login" href="#login-form">Login/Register</a></span>
                <!-- <span class="register-icon"><a class="register" href="#register-form">Register</a></span> -->

              <?php } ?>
            </div>

            <div class="inline-block">

              <a href="<?php echo $base_url; ?>customer-cart">
                <div class="shopping_cart" title="Viewcart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> </div>
              </a>
            </div>
            <div class="inline-block">

              <a href="#">
                <div class="shopping_cart" title="Wishlist"> <i class="fa fa-heart" aria-hidden="true"></i></div>
              </a>
            </div>


            <div class="inline-block">
              <div id="google_translate_element"></div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!--top content End-->
  <div class="container-fluid bdb">
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $base_url; ?>"><img src="<?php echo $base_url_views; ?>customer/images/logo-new.png" alt="">
          </a>
        </div>
        <div id="navbar1" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo $base_url; ?>">Home</a></li>


            <li><a href="<?php echo $base_url; ?>product-listing">Our Products</a></li>
            <!-- <li class="dropdown show-on-hover">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Our Products<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                            <ul class="border-dotted-bottom">
                                                  <li><a href="#">Agri Gold Palmolein Oil</a></li>
                                                  <li><a href="#">Agri Gold Palmolein Oil</a></li>
                                                  <li><a href="#">Agri Gold Palmolein Oil</a></li>
                                                  <li><a href="<?php echo $base_url; ?>product-listing">See All</a></li>
                                                </ul>
                            </ul>      
                    </li> -->





            <!-- <li><a href="<?php echo $base_url; ?>special-products">Monthly Supplies</a></li> -->
            <li><a href="<?php echo $base_url; ?>about-bpcl">About Us</a></li>
            <li><a href="<?php echo $base_url; ?>book-form" style="font-size:22px;" title="Pre Book Energy Efficient Hotplates"><i class="fa fa-cart-plus" aria-hidden="true"></i></a></li>



            <!-- <li><a href="<?php echo $base_url; ?>complaint">Complaint / Feedback</a></li>
          
          <li><a href="<?php echo $base_url; ?>customer-support">Customer Support</a></li>-->



          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"></a></li>
          </ul>
        </div>
        <!--/.nav-collapse -->
      </div>
      <!--/.container-fluid -->
    </nav>
  </div>

  <!--navBar content End-->
  <style>
    form {
      padding: 0px 0;
    }

    .successmain {
      background-color: #008000;
      border-color: #008000;
    }

    .valierror {
      background-color: #ee2e34;
      border-color: #ee2e34;
      color: #fff;
    }

    .topalert {
      z-index: 9999;
      text-align: center;
      padding: 10px;
      font-size: 18px;
      color: #fff;
      position: fixed;
      top: 0px;
    }

    .alert-message {
      background-size: 40px 40px;
      background-image: linear-gradient(135deg, rgba(255, 255, 255, .05) 25%, transparent 25%,
          transparent 50%, rgba(255, 255, 255, .05) 50%, rgba(255, 255, 255, .05) 75%,
          transparent 75%, transparent);
      /*  box-shadow: inset 0 -1px 0 rgba(255,255,255,.4);*/
      width: 100%;
      border: 0px solid;
      color: #fff;
      padding: 10px;
      /*position: fixed;*/
      /* _position: absolute;
     text-shadow: 0 1px 0 rgba(0,0,0,.5);*/
      animation: animate-bg 5s linear infinite;
      display: block;
    }

    .valierror123 {
      background-color: #008000;
      border-color: #008000;
      color: #fff;
    }

    .line-through {
      text-decoration: line-through;
    }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


  <div class="container">
    <!-- Trigger the modal with a button -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content login-wrap">
          <form action="<?php echo $base_url; ?>home/set_pincode" method="post" id="set_pincode" name="set_pincode">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Enter Your PIN Code</h4>
            </div>
            <div class="modal-body">
              <div id="error_pincode" class="alert-message valierror " style="display:none;width: 100%;">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>
              <div class="form-group">
                <label for="email">PIN Code :</label>
                <input type="text" maxlength="6" id="check_pincode" name="check_pincode" class="form-control" value="<?php echo $this->session->userdata('check_pincode'); ?>">
              </div>

              <button type="button" onclick="set_pincode_check();" class="btn btn-default-red">Submit </button>
          </form>
        </div>

      </div>

    </div>
  </div>

  </div>
  <?php if ($this->session->userdata('check_pincode') == '') { ?>
    <script type="text/javascript">
      $(window).load(function() {
        $('#myModal').modal('show');
      });
    </script>
  <?php } ?>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#OpenPincodeModal").click(function() {
        $('#myModal').modal('show');
      });
    });
  </script>
  <script>
    function set_pincode_check() {
      var check_pincode = $("#check_pincode").val();
      if (check_pincode == '') {
        $('#error_pincode').html("Please enter Pincode");
        $('#error_pincode').show().delay(0).fadeIn('show');
        $('#error_pincode').show().delay(2000).fadeOut('show');
        return false;
      }
      $('#set_pincode').submit();
    }
  </script>

  <script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'hi,mr',
      }, 'google_translate_element');
    }
  </script>

  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>