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
$route['default_controller'] = 'patient'; 
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


// Patient API routes
$route['api/v1/patients'] = 'api/v1/patientApi/getAll'; 
$route['api/v1/patients/add'] = 'api/v1/patientApi/add'; 
$route['api/v1/patients/(:num)'] = 'api/v1/patientApi/getPatientById/$1';  
$route['api/v1/patients/edit/(:any)'] = 'api/v1/patientApi/editPatient/$1';
$route['api/v1/patients/update/(:num)'] = 'api/v1/patientApi/update/$1';  
$route['api/v1/patients/delete/(:num)'] = 'api/v1/patientApi/delete/$1'; 
$route['api/v1/patients/restore/(:num)'] = 'api/v1/patientApi/restore/$1';  


// User API routes
$route['api/v1/users'] = 'api/v1/userApi/getAll';
$route['api/v1/users/add'] = 'api/v1/userApi/create';
$route['api/v1/users/(:num)'] = 'api/v1/userApi/get/$1';
$route['api/v1/users/update/(:num)'] = 'api/v1/userApi/update/$1';
$route['api/v1/users/delete/(:num)'] = 'api/v1/userApi/delete/$1';
$route['api/v1/users/restore/(:num)'] = 'api/v1/userApi/restore/$1'; 


 

//Auth
$route['user/login'] = 'user/login';
$route['user/register']['POST'] = 'user/register';


// Routes for patients
$route['patient']['GET'] = 'patient/index';   
$route['patient/table']['GET'] = 'patient/table';   
$route['patient/add']['POST'] = 'Patient/add';          
$route['api/v1/patient/(:any)'] = 'Patient/edit/$1';      
$route['patient/update'] = 'Patient/update';            
$route['patient/delete/(:any)'] = 'Patient/delete/$1';   
$route['patient/show_deleted_pat']['GET'] = 'Patient/show_deleted_pat'; 
$route['patient/destroy/(:any)']['GET'] = 'Patient/delete/$1'; 
$route['patient/view_profile/(:any)'] = 'Patient/get_patient_by/$1';



