<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['publicreports'] = "kpi_generate_controller/publicreports";
$route['report/(:any)/changevisibleto'] = "kpi_generate_controller/changevisibleto/$1";
$route['report/(:any)'] = "kpi_generate_controller/report/$1";
$route['reports'] = "kpi_generate_controller/reports";
$route['publish/(:any)'] = "kpi_generate_controller/publish/$1";
$route['generated/txt/(:any)'] = "kpi_generate_controller/previewtxt/$1";
$route['generated/excel/(:any)'] = "kpi_generate_controller/previewexcel/$1";
$route['generated/pdf/(:any)'] = "kpi_generate_controller/previewpdf/$1";
$route['generated/printablepage/(:any)'] = "kpi_generate_controller/printablepage/$1";
$route['generated'] = "kpi_generate_controller/generated";
$route['generate/(:any)'] = "kpi_generate_controller/generate/$1";
$route['generate'] = "kpi_generate_controller/generate/null";

//$route['user_rate.html'] = "";
$route['shit'] = "user/shit";
$route['auditor'] = "user/view/auditor_home";
$route['user'] = "user/view/user_home";
$route['rate'] = "user/viewmetric";
$route['index'] = "user/index";
$route['submit'] = "user/submit";
$route['deactivate'] = "user/deactivate_value";
$route['edit'] = "user/edit_values";
$route['editvalue'] = "user/edit_a_value";
$route['changevalue'] = "user/changevalue";
$route['auth'] = "user/auth";
$route['login'] = "user/login";
$route['signup'] = "user/signup";
$route['delete_account'] = "user/delete_account";
$route['add_account'] = "user/add_account";
$route['verify'] = "user/viewaccountid";
$route['select'] = "user/select";
$route['auditor_verify'] = "user/auditor_verify_page";
$route['user_rated'] = "user/user_rated";
$route['default_controller'] = "welcome";
$route['404_override'] = '';
$route['(:any)'] = 'user/view/$1';


// for superuser kpi
$route['addKPI'] = 'user/addKPI';
$route['addSubKPI'] = 'user/addSubKPI';
$route['addMetric'] = 'user/addMetric';
$route['addMetric1'] = 'user/addMetric1';
$route['addBreakdown'] = 'user/addBreakdown';




/* End of file routes.php */
/* Location: ./application/config/routes.php */