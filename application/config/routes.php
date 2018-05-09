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
$route['default_controller'] = 'welcome';

// Visitor Links
$route['home'] = 'welcome';
$route['aboutUs'] = 'welcome/aboutUs';
$route['courtBooking'] = 'welcome/courtBooking';
$route['gallery'] = 'welcome/gallery';
$route['contactUs'] = 'welcome/contactUs';
$route['signup'] = 'welcome/signup';
$route['login'] = 'welcome/login';
$route['logout'] = 'welcome/logout';
$route['courtCheckOut'] = 'welcome/courtCheckOut';
$route['saveSession'] = 'welcome/saveSession';
$route['make-payment'] = 'welcome/makeCustomerPayment';
$route['payment-response'] = 'welcome/PaymentResponse';
$route['referFirend'] = 'welcome/referFriend';
$route['newsletter'] = 'welcome/newsletter';




$route['checkBookings'] = 'admin/courts/checkBookingsForDate';

//print_r("adkjfhaks");exit;
// Admin Links
$route['courts/create'] = 'admin/courts/CreateCourt';
$route['submit/courts'] = 'admin/courts/CreateCourt';
$route['slots'] = 'admin/slots/CreateSlot';
$route['slots/edit'] = 'admin/slots/EditSlot';
$route['admin/delete-slot'] = 'admin/slots/delete';
$route['slots/getSlots'] = 'admin/slots/getSlots/$1';
$route['admin/login'] = 'welcome/adminLogin';
$route['admin/court/edit/(:any)'] = 'admin/courts/EditCourt/$1';
$route['admin/bookings'] = 'admin/bookings/ViewBookings';
$route['admin/checkBookings'] = 'admin/bookings/CheckBookings';
$route['admin/bookslots'] = 'admin/bookings/BookSlotForCustomer';
$route['admin/current-bookings'] = 'admin/bookings/GetAllBookings';
$route['admin/booking-release/(:any)'] = 'admin/bookings/BookingReleaseByAdmin/$1';
$route['admin/payForBookings'] = 'admin/bookings/PayForBookings';
$route['admin/court/delete/(:any)'] = 'admin/courts/Delete/$1';
$route['admin/search-bookings'] = 'admin/bookings/DateSearch';


$route['admin/customer/create'] = 'admin/customer/CreateCustomer';
$route['admin/customer/saveVehicle'] = 'admin/customer/SaveVehicle';
$route['admin/loan/createLoan'] = 'admin/loan/CreateLoan';
$route['admin/loan/collectionList'] = 'admin/loan/collectionList';
$route['admin/loan/view/(:any)'] = 'admin/loan/viewLoan/$1';
$route['admin/loan/initiate/(:any)'] = 'admin/loan/initiateInstallment/$1';
$route['admin/loan/payInstallment'] = 'admin/loan/payInsallmentSubmit';









// @TODO remove this line after the testing.
//$route['saveBookingSlots'] = 'welcome/saveBookingSlots';






$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
