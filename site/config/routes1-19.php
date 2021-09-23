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

$route['user-register']  = "home/user_register";
$route['select_category']  = "home/select_categorys";
$route['select-category-subcategory']  = "home/select_category_subcategory";
$route['order-sold']  = "home/order_sold";
$route['updatecategory_sub']  = "home/updatecategory_sub";
$route['update_bank_detail']  = "home/updatebank_dels";
$route['update_personal_detail']  = "home/update_personal_detail";
$route['update_store_detail']  = "home/update_store_detail";
$route['payment-overview']  = "home/payment_overview";
$route['previous-payments']  = "home/previous_payments";
$route['return-order']  = "home/return_order";
$route['cancellation-orders']  = "home/cancellation_orders";
$route['track-approval-request']  = "home/track_approval_request";
$route['store-detail']  = "home/store_detail";
$route['personal-detail']  = "home/personal_detail";
$route['bank-detail']  = "home/bank_detail";

$route['my-account']  = "account";

$route['vendor-register']  = "home/registration";
$route['vendor-register-thanks']  = "home/registration_thanks";


$route['pickup']  = "home/pickup";

$route['vendor-my-account']  = "home/vendor_my_account";

$route['all-products']  = "home/all_products";

$route['add-product']  = "home/add_products";

$route['vendor-orders']  = "home/orders";
$route['vendor-orders-details/(:any)']  = "home/order_details/$1";

$route['vendor-report']  = "home/report";

$route['forgot-password']  = "home/forgot_password";

$route['reset-password/(:any)']  = "home/reset_password/$1";

$route['edit-product/(:any)']  = "home/edit_product/$1";

$route['edit-product-image/(:any)']  = "home/editimage/$1";

$route['login']  = "home/login";

$route['category/(:any)'] 		 = 'home/listing/$1';
$route['category/(:any)/(:any)'] = 'home/listing/$1/$2';

$route['product/(:any)'] = 'home/single_product/$1';

/*$route['workshops/(:any)'] = 'home/workshop/$1';
$route['workshop/(:any)'] = 'home/details/$1';*/

$route['workshops'] = 'home/workshop';
$route['workshops/(:any)'] = 'home/workshop/$1';
$route['workshops-detail/(:any)'] = 'home/details/$1';

$route['blogs'] = 'home/blogs_listing/';
$route['blogs/(:any)'] = 'home/blogs_listing/$1';
$route['blog/(:any)'] = 'home/spiritual_detail/$1';

$route['gift-hampers/(:any)'] = 'home/gift_hamper_listing/$1';
$route['gift-hamper/(:any)'] = 'home/gift_hamper_detail/$1';

$route['blog-tags'] = 'home/journal_tags';
$route['workshop-checkout'] = 'home/register_from';
$route['cart'] = 'cart/viewcart';
$route['checkout'] = 'cart/checkout';

$route['services/(:any)'] = 'home/services/$1';
$route['services-detail/(:any)'] = 'home/services_detail/$1';

$route['wellness/products/(:any)'] = 'home/listing/$2';
$route['wellness/services/(:any)'] = 'home/services/$1';
$route['wellness/articles/(:any)'] = 'home/services/$1';

/*
$route['services-detail'] = 'home/services_detail';
$route['services-detail2'] = 'home/services_detail2';
$route['services-detail3'] = 'home/services_detail3';
*/ 

$route['404_override'] = '';
$route['scaffolding_trigger'] = "";
