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
|	https://codeigniter.com/userguide3/general/routing.html
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

$route['translate_uri_dashes']              = FALSE;

$route['default_controller']                = 'static_pages';

$route['404_override']                      = 'static_pages/not_found';
$route['404']                               = 'static_pages/not_found';

$route['login']                             = 'login';

$route['logout']                            = 'logout';

$route['forgot-my-password']                = 'lost_password';
$route['reset-password']                    = 'lost_password/refresh';

$route['dashboard']                         = 'dashboard';

$route['me']                                = 'user';
$route['get-sales-representatives']         = 'user/salesrepresentatives';

$route['roles']                             = 'roles';
$route['roles/(:num)']                      = 'roles';
$route['role/(:any)']                       = 'roles/edit';
$route['role']                              = 'roles/create';

$route['employees']                         = 'employees';
$route['employees/(:num)']                  = 'employees';
$route['employee/(:any)']                   = 'employees/edit';
$route['employee']                          = 'employees/create';
$route['employees/create-password/(:any)']  = 'employees/create_password/$1';


