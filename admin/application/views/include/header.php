<?php
$front_base_url = $this->config->item('front_base_url');
$base_url       = $this->config->item('base_url');
$http_host       = $this->config->item('http_host');
$base_url_views = $this->config->item('base_url_views');
$base_upload = $this->config->item('upload');
?>
<!DOCTYPE html>
<html>

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>BPCL: Admin Panel</title>
   <link rel="icon" href="<?php echo $base_url_views; ?>images/favicon.png" type="image/png" sizes="20x20">
   <!-- Font CSS (Via CDN) -->
   <!--
<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800'>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css"rel="stylesheet">
<-- Bootstrap CSS -->
   <link rel="stylesheet" type="text/css" href="<?php echo $base_url_views; ?>css/bootstrap.min.css">

   <!-- Required Plugin CSS 
<link rel="stylesheet" type="text/css" href="vendor/plugins/morris/morris.css">
<link rel="stylesheet" type="text/css" href="vendor/plugins/datatables/css/datatables.min.css">
-->
   <!-- Theme CSS -->
   <link rel="stylesheet" type="text/css" href="<?php echo $base_url_views; ?>css/vendor.css">
   <link rel="stylesheet" type="text/css" href="<?php echo $base_url_views; ?>css/theme.css">
   <link rel="stylesheet" type="text/css" href="<?php echo $base_url_views; ?>css/utility.css">
   <link rel="stylesheet" type="text/css" href="<?php echo $base_url_views; ?>css/custom.css">
   <link rel="stylesheet" type="text/css" href="<?php echo $base_url_views; ?>css/font-awesome.min.css">
   <link rel="stylesheet" type="text/css" href="<?php echo $base_url_views; ?>css/jquery.multiselect.css">
   <link rel="stylesheet" type="text/css" href="<?php echo $base_url_views; ?>css/my-style.css">
   <link rel="stylesheet" type="text/css" href="<?php echo $base_url_views; ?>css/new-css.css">
   <!-- Favicon -->

   <link rel="shortcut icon" href="<?php echo $front_base_url; ?>site/views/images/favicon.png">
   <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&display=swap" rel="stylesheet">
   <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
</head>

<!-- Start: Header -->
<header class="">
   <div class="navbar-branding">
      <!--<span id="toggle_sidemenu_l" class="glyphicons glyphicons-show_lines"></span> -->
      <a class="navbar-brand" href="<?php echo $base_url; ?>"><img alt="BPCL" src="<?php echo $base_url_views; ?>images/logo-new.png" style="width: 180px;"></a>
   </div>
   <div class="navbar-right">
      <!--sing out-->
      <div class="user-info" style="border:none">
         <div class="media">
            <div class="mobile-link"> <span class="glyphicons glyphicons-show_big_thumbnails"></span> </div>
            <div class="media-body pull-right">
               <!--<h5 class="media-heading mt5 mbn fw700 cursor"><?php //echo strtoupper($this->session->userdata('uname'));
                                                                  ?><--span class="caret ml5"></span</h5>-->
               <div class="media-links fs11">
                  <!--a href="javascript:void(0);">Menu</a--><i class="fa fa-sign-out" style="font-size:18px; color:#2d8484"></i> <a href="<?php echo $base_url; ?>welcome/logout" style="font-size:16px; color:#2d8484">Sign Out</a>
               </div>
            </div>
         </div>
      </div>
      <!--div class="navbar-search">
         <input type="text" id="HeaderSearch" placeholder="Search..." value="Search...">
         </div-->
   </div>
   <div class="navbar navbar-inverse" data-spy="affix" data-offset-top="50">
      <div class="container-fluid">
         <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
            </button>
         </div>
         <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">

               <?php
               $uid = $this->session->userdata('adminId');
               $getuser['data'] = $this->footer->getuser($uid);
               $category = $getuser['data'][0]->role_id;
               $usercategory = $this->footer->usercategory($category);
               $permission1 = $usercategory[0]->permission;
               $permission1 = explode(',', $permission1);

               $edit_permi = $usercategory[0]->editperm;
               $edit_permission = explode(',', $edit_permi);


               $activetab = $this->uri->segment('1'); ?>

               <?php if (in_array('1', $permission1) || in_array('2', $permission1) || in_array('3', $permission1) || in_array('4', $permission1) || in_array('5', $permission1) || in_array('6', $permission1) || in_array('7', $permission1) || in_array('8', $permission1)) { ?>

                  <li class="dropdown <?php if ($activetab == 'category' || $activetab == 'subcategory' || $activetab == 'wellness_category' || $activetab == 'size' || $activetab == 'colour' || $activetab == 'pincode' || $activetab == 'cms' || $activetab == 'banner') { ?>active<?php } ?>">
                     <a class="dropdown-toggle " data-toggle="dropdown" href="#">Master<span class="caret"></span></a>
                     <ul class="dropdown-menu">
                        <?php if (in_array('1', $permission1)) { ?>
                           <li><a class="ajax-disable" href="<?php echo $base_url; ?>banner/lists" title="State">Banner</a></li>
                        <?php } ?>
                        <?php if (in_array('1', $permission1)) { ?>
                           <li><a class="ajax-disable" href="<?php echo $base_url; ?>state/lists" title="State">State</a></li>
                        <?php } ?>
                        <?php if (in_array('2', $permission1)) { ?>
                           <li><a class="ajax-disable" href="<?php echo $base_url; ?>city/lists" title="District">District</a></li>
                        <?php } ?>
                        <?php /* if(in_array('4',$permission1)){ ?>
                     <li><a class="ajax-disable" href="<?php echo $base_url;?>area/lists" title="Area">Area</a></li>
                     <?php } */ ?>

                        <?php if (in_array('4', $permission1)) { ?>
                           <li><a class="ajax-disable" href="<?php echo $base_url; ?>pincode/lists" title="Pincode">Pincode</a></li>
                        <?php } ?>

                        <?php if (in_array('4', $permission1)) { ?>
                           <li><a class="ajax-disable" href="<?php echo $base_url; ?>material/lists" title="Pincode">Material</a></li>
                        <?php } ?>

                     </ul>
                  </li>
               <?php } ?>

               <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="User Management">User Management<span class="caret"></span></a>
                  <ul class="dropdown-menu ">
                     <li><a class="ajax-disable" href="<?php echo $base_url; ?>vendor/lists" title="Vendor">Vendor</a></li>
                     <li><a class="ajax-disable" href="<?php echo $base_url; ?>distributor/lists" title="Distributor">Distributor</a></li>
                     <li><a class="ajax-disable" href="<?php echo $base_url; ?>user/lists" title="Distributor">Customer</a></li>
                     <li><a class="ajax-disable" href="<?php echo $base_url; ?>delivery/lists" title="Distributor">Delivery Boy</a></li>
                  </ul>

               </li>

               <?php if (in_array('23', $permission1)) { ?>
                  <li class="dropdown <?php if ($activetab == 'orders') { ?>active<?php } ?>">
                     <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Order Management">Order Management<span class="caret"></span></a>
                     <ul class="dropdown-menu">
                        <li><a class="ajax-disable" href="<?php echo $base_url; ?>orders/lists" title="Order">Distributor Orders</a></li>
                        <li><a class="ajax-disable" href="<?php echo $base_url; ?>orders/lists_customer" title="Order">Customer Orders</a></li>
                        <li><a class="ajax-disable" href="<?php echo $base_url; ?>orders/lists_specialcustomer" title="Order">Special Orders</a></li>
                        <!--<li><a class="ajax-disable" href="<?php echo $base_url; ?>reports_management/vendororder" title="Vendor Sales Reports">Vendor Orders</a></li>
                    <li><a class="ajax-disable" href="<?php echo $base_url; ?>reports_management/cancelorder" title="Cancelled Orders">Cancelled orders</a></li>
                    <li><a class="ajax-disable" href="<?php echo $base_url; ?>reports_management/cancelrequest" title="Customer Cancel Request">Customer Cancel Request</a></li>
                    <li><a class="ajax-disable" href="<?php echo $base_url; ?>orders/lists_experiance" title="Workshop Order">Workshop Order </a></li> -->
                     </ul>
                  </li>
               <?php } ?>

               <?php if (in_array('23', $permission1)) { ?>
                  <li class="dropdown <?php if ($activetab == 'product') { ?>active<?php } ?>">
                     <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Order Management">Products Management<span class="caret"></span></a>
                     <ul class="dropdown-menu">
                        <li><a class="ajax-disable" href="<?php echo $base_url; ?>product/lists" title="Order">Products</a></li>
                     </ul>
                  </li>
               <?php } ?>
               <?php if (in_array('12', $permission1)) { ?>
                  <li class="dropdown <?php if ($activetab == 'offers') { ?>active<?php } ?>">
                     <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Offers">Offers<span class="caret"></span></a>
                     <ul class="dropdown-menu">
                        <li class="<?php if ($activetab == 'coupan') { ?>active<?php } ?>"><a class="ajax-disable" href="<?php echo $base_url; ?>coupan/lists" title="Coupon">Coupon</a></li>
                     </ul>
                  </li>
               <?php } ?>

               <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="User Management">Reviews Management<span class="caret"></span></a>
                  <ul class="dropdown-menu ">
                     <li><a class="ajax-disable" href="<?php echo $base_url; ?>reviews/lists"><span class="glyphicons glyphicons-book"></span>Reviews</a></li>

                  </ul>

               </li>

               <?php if (in_array('23', $permission1)) { ?>
                  <li class="dropdown <?php if ($activetab == 'collection_product') { ?>active<?php } ?>">
                     <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Order Management">Collection Management<span class="caret"></span></a>
                     <ul class="dropdown-menu">
                        <li><a class="ajax-disable" href="<?php echo $base_url; ?>collection/lists" title="Order">Collection</a></li>
                        <li><a class="ajax-disable" href="<?php echo $base_url; ?>collection_product/lists" title="Order">Collection Products</a></li>
                        <li><a class="ajax-disable" href="<?php echo $base_url; ?>reports_management/vendor_special_report" title="Order">Collection Vendor wise Report</a></li>
                        <li><a class="ajax-disable" href="<?php echo $base_url; ?>reports_management/distributor_special_report" title="Order">Collection Distributor wise Report</a></li>
                     </ul>
                  </li>
               <?php } ?>

               <?php if (in_array('23', $permission1)) { ?>
                  <li class="dropdown <?php if ($activetab == 'reports_management') { ?>active<?php } ?>">
                     <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Report Management">Report Management<span class="caret"></span></a>
                     <ul class="dropdown-menu">
                        <li><a class="ajax-disable" href="<?php echo $base_url; ?>reports_management/amount_reconcilation_report" title="Amount Reconcilation Report">Amount Reconcilation Report</a></li>
                        <li><a class="ajax-disable" href="<?php echo $base_url; ?>reports_management/vendor_paybale_report" title="Vendor Paybale Report">Vendor Paybale Report</a></li>
                        <li><a class="ajax-disable" href="<?php echo $base_url; ?>reports_management/distributor_paybale_report" title="Distributor Paybale Report">Distributor Paybale Report</a></li>
                        <li><a class="ajax-disable" href="<?php echo $base_url; ?>reports_management/delivery_man_paybale_report" title="Delivery Man Paybale Report">Delivery Man Paybale Report</a></li>
                        <!-- <li><a class="ajax-disable" href="<?php echo $base_url; ?>reports_management/vendororder" title="Vendor Sales Reports">Vendor Orders</a></li> -->
                        <!--<li><a class="ajax-disable" href="<?php echo $base_url; ?>reports_management/cancelorder" title="Cancelled Orders">Cancelled orders</a></li>
                    <li><a class="ajax-disable" href="<?php echo $base_url; ?>reports_management/cancelrequest" title="Customer Cancel Request">Customer Cancel Request</a></li>
                    <li><a class="ajax-disable" href="<?php echo $base_url; ?>orders/lists_experiance" title="Workshop Order">Workshop Order </a></li> -->
                     </ul>
                  </li>
               <?php } ?>

               <?php if (in_array('23', $permission1)) { ?>
                  <li class="dropdown <?php if ($activetab == 'bpcl_payment') { ?>active<?php } ?>">
                     <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Bpcl Payment">Bpcl Payment<span class="caret"></span></a>
                     <ul class="dropdown-menu">
                        <li><a class="ajax-disable" href="<?php echo $base_url; ?>bpcl_payment/lists" title="Bpcl Payment">Bpcl Payment</a></li>
                     </ul>
                  </li>
               <?php } ?>

            </ul>
         </div>
      </div>
   </div>
</header>



<style>
   #main {
      margin-top: 60px;
   }

   #error_msg {
      color: red;
      text-align: center;
   }

   header .dropdown-submenu {
      position: relative;
   }

   header .dropdown-submenu>.dropdown-menu {
      top: 0;
      left: 100%;
      margin-top: -6px;
      margin-left: -1px;
      -webkit-border-radius: 0 6px 6px 6px;
      -moz-border-radius: 0 6px 6px;
      border-radius: 0 6px 6px 6px;
   }

   header .dropdown-submenu:hover>.dropdown-menu,
   header .navbar-nav>li:hover>.dropdown-menu {
      display: block;
   }

   header .dropdown-submenu>a:after {
      display: block;
      content: " ";
      float: right;
      width: 0;
      height: 0;
      border-color: transparent;
      border-style: solid;
      border-width: 5px 0 5px 5px;
      border-left-color: #ccc;
      margin-top: 5px;
      margin-right: -10px;
   }

   header .dropdown-submenu:hover>a:after {
      border-left-color: #fff;
   }

   header .dropdown-submenu.pull-left {
      float: none;
   }

   header .dropdown-submenu.pull-left>.dropdown-menu {
      left: -100%;
      margin-left: 10px;
      -webkit-border-radius: 6px 0 6px 6px;
      -moz-border-radius: 6px 0 6px 6px;
      border-radius: 6px 0 6px 6px;
   }

   header .nav .open>a,
   header .nav .open>a:hover,
   header .nav .open>a:focus {
      color: #428bca;
      border-color: #cfcfcf00;
   }

   header .dropdown-submenu {
      padding: 0;
      border-bottom: none;
   }

   header .dropdown-menu>li>a:hover,
   header .dropdown-menu>li>a:focus {
      text-decoration: none;
      color: #262626;
      background-color: #fff;
   }

   header .dropdown-menu,
   header .dropdown-submenu>.dropdown-menu {
      border-radius: 0;
   }

   header .dropdown-menu>.active>a,
   header .dropdown-menu>.active>a:hover,
   header .dropdown-menu>.active>a:focus {
      background-color: #055b57;
   }
</style>