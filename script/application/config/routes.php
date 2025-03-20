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
// $route['default_controller'] = 'authentication/index';
$route['default_controller'] = 'ECommerce_frontend/homePage';


$route['customer-panel'] = 'Authentication/customer_panel';
$route['internet-check'] = 'Authentication/internetCheck';
$route['customer-panel'] = 'authentication/customer_panel';
$route['customer-panel-data'] = 'Authentication/customer_panel_data';
$route['customer-panel-data'] = 'authentication/customer_panel_data';
$route['put-customer-panel-data'] = 'Authentication/put_customer_panel_data';
$route['put-customer-panel-data'] = 'authentication/put_customer_panel_data';
$route['forgot-password-step-one'] = 'authentication/forgotPasswordStepOne';
$route['forgot-password-step-two'] = 'authentication/forgotPasswordStepTwo';
$route['forgot-password-step-final'] = 'authentication/forgotPasswordStepDone';
$route['get_prom_details'] = 'authentication/get_prom_details';
$route['active-now/(:any)'] = 'authentication/activeCompany/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['api/addItem'] = 'api/ApiItemController/addItem';
$route['api/editItem/(:any)'] = 'api/ApiItemController/editItem/$1';
$route['api/updateItem/(:any)'] = 'api/ApiItemController/updateItem/$1';
$route['api/itemList'] = 'api/ApiItemController/itemList';
$route['api/deleteItem/(:any)'] = 'api/ApiItemController/deleteItem/$1';


$route['api/saleList'] = 'api/ApiSaleController/saleList';
$route['api/addSale'] = 'api/ApiSaleController/addSale';
$route['api/editSale/(:any)'] = 'api/ApiSaleController/editSale/$1';
$route['api/updateSale/(:any)'] = 'api/ApiSaleController/updateSale/$1';
$route['api/deleteSale/(:any)'] = 'api/ApiSaleController/deleteSale/$1';

$route['payment-now/(:any)'] = 'Authentication/payment/$1';



// ECommerce Frontend URL
$route['e-home'] = 'ECommerce_frontend/homePage';
$route['e-faq'] = 'ECommerce_frontend/faq';
$route['e-contact'] = 'ECommerce_frontend/contactUs';
$route['e-contact-store'] = 'ECommerce_frontend/contactUsStore';
$route['e-brand/(:any)'] = 'ECommerce_frontend/getByBrand/$1';
$route['e-category/(:any)'] = 'ECommerce_frontend/getByCategory/$1';
$route['e-track-order'] = 'ECommerce_frontend/trackOrder/$1';
$route['e-login'] = 'ECommerce_frontend/login';
$route['e-logout'] = 'ECommerce_frontend/logout';
$route['e-forgot-password'] = 'ECommerce_frontend/forgotPassword';
$route['e-forgot-password-submit'] = 'ECommerce_frontend/forgotPasswordSubmit';
$route['e-change-password'] = 'ECommerce_frontend/changePassword';
$route['e-manage-address'] = 'ECommerce_frontend/manageAddress';
$route['e-register'] = 'ECommerce_frontend/register';
$route['e-account'] = 'ECommerce_frontend/account';
$route['e-account-order-details/(:any)'] = 'ECommerce_frontend/orderDetails/$1';
$route['e-account-info'] = 'ECommerce_frontend/accountInfo';
$route['e-account-order-history'] = 'ECommerce_frontend/accountOrderHistory';
$route['e-wish-list'] = 'ECommerce_frontend/wishList';
$route['e-shopping-cart'] = 'ECommerce_frontend/shoppingCart';
$route['e-checkout'] = 'ECommerce_frontend/checkout';
$route['e-product-details/(:any)'] = 'ECommerce_frontend/productDetails/$1';
$route['e-ratting-submit'] = 'ECommerce_frontend/submitRating';
$route['e-product-type/(:any)'] = 'ECommerce_frontend/getProductByType/$1';


