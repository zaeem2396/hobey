<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = "home";

$route['login']  = "home/login";

$route['logout']  = "home/logout";

$route['distributor-profile']  = "home/distributor_profile";
$route['distributor-product-listing']  = "home/distributor_product_listing";
$route['distribute-product-detail/(:any)']  = "home/product_details/$1";
$route['distributor-cart']  = "home/distributor_cart";
$route['distributor-checkout']  = "home/distributor_checkout";
$route['distributor-my-account']  = "home/distributor_my_account";
$route['distributor-change-password']  = "home/distributor_change_password";
$route['distributor-my-order']  = "home/distributor_my_order";
$route['distributor-customer-my-order']  = "home/distributor_customer_my_order";
$route['distributor-wishlist']  = "home/distributor_wishlist";
$route['distributor-my-inventory']  = "home/distributor_my_inventory";
$route['distributor-monthly-order']  = "home/distributor_monthly_order";

$route['vendor-my-inventory']  = "home/vendor_my_inventory";

$route['vendor-dashboard']  = "vendor/dashboard";
$route['list-product']  = "vendor/list_product";
$route['add-product']  = "vendor/add_products";
$route['edit-product/(:any)']  = "vendor/edit_product/$1";
$route['vendor-my-account']  = "vendor/vendor_my_account";
$route['vendor-my-order']  = "vendor/vendor_my_order";
$route['vendor-change-password']  = "vendor/vendor_change_password";

$route['deliveryboy-customer-my-order']  = "home/deliveryboy_customer_my_order";

$route['special-products']  = "home/special_products";
$route['product-listing']  = "home/product_listing";
$route['product-detail/(:any)']  = "home/product_detail_customer/$1";
$route['customer-cart']  = "home/customer_cart";
$route['customer-checkout']  = "home/customer_checkout";
$route['customer-my-account']  = "account/customer_myaccount";
$route['thank-you/(:any)']  = "billship/customerthanks/$1";

$route['about-bpcl']  = "home/about_bpcl";
$route['contact-us']  = "home/contact_us";
$route['complaint']  = "home/complaint";
$route['customer-support']  = "home/customer_support";

$route['book-form']  = "home/book_form";

$route['404_override'] = '';
$route['scaffolding_trigger'] = "";
