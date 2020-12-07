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
$route['default_controller']                   = 'authentication';

$route['api/register']                         = 'api/register';

$route['user-login']                           = 'authentication/login';
$route['login']                                = 'authentication/logout';
$route['dashboard']                            = 'authentication/dashboard';
$route['dashboardw2']                          = 'authentication/dashboardw2';
$route['dashboardsole']                        = 'authentication/dashboardsole';
$route['dashboardc2c']                         = 'authentication/dashboardc2c';

$route['consultant-list']                      = 'consultants';
$route['consultant-list-c2c']                  = 'consultantsc2c';
$route['consultant-list/(:any)']               = 'consultants/index/$1';
$route['add-consultant']                       = 'consultants/consult_view';
// $route['add-consultant']                    = 'consultants/add_consultant';
$route['edit-consultant/(:any)']               = 'consultants/display_consultant/$1';
$route['consultant-display']                   = 'consultants/edit_consultant';
$route['view-consultant/(:any)']               = 'consultants/view_consultant/$1';

$route['vendor-list']                          = 'vendors';
// $route['vendor-page']                          = 'vendors/vendor_view';
$route['add-vendor']                           = 'vendors/vendor_view';
$route['edit-vendor/(:any)']                   = 'vendors/display_vendor/$1';
$route['vendor-display']                       = 'vendors/edit_vendor';
$route['consult-list/(:any)']                  = 'vendors/vendor_consult/$1';

$route['user-list']                            = 'user';
$route['user-page']                            = 'user/user_view';
$route['add-user']                             = 'user/add_user';
$route['user-display/(:any)']                  = 'user/display_user/$1';
$route['edit-user']                            = 'user/edit_user';

$route['document-list/(:any)']                 = 'documents/index/$1';
$route['document-list/(:any)/(:any)']          = 'documents/doc_upload_panel/$1/$2';
$route['doc-upload-page/(:any)']               = 'documents/doc_view/$1';
$route['doc-upload-page/(:any)/(:any)']        = 'documents/doc_view/$1/$2';

$route['document-list/(:any)']                 = 'documents/index/$1';
$route['document-list/(:any)/(:any)']          = 'documents/doc_upload_panel/$1/$2';
$route['doc-upload-page/(:any)']               = 'documents/doc_view/$1';
$route['doc-upload-page/(:any)/(:any)']        = 'documents/doc_view/$1/$2';
$route['miscellaneous-uploaded-list/(:any)/(:any)'] = 'documents/misc_upload_panel/$1/$2';
$route['miscdoc-upload-page/(:any)/(:any)']        = 'documents/misc_doc_view/$1/$2';

//vendor
$route['doc-list/(:any)']                      = 'documents/vendor_document_list/$1';
$route['doc-list/(:any)/(:any)']               = 'documents/vendor_document_type_list/$1/$2';
$route['document-upload-page/(:any)']          = 'documents/vendor_document_view/$1/$2';
$route['document-upload-page/(:any)/(:any)']   = 'documents/vendor_document_view/$1/$2';
$route['document-uploaded-list/(:any)/(:any)'] = 'documents/vendor_purchase_list/$1/$2';
$route['document-upload/(:any)/(:any)']        = 'documents/purchase_add_document/$1/$1';

//vendor
$route['add-doc']                              = 'documents/do_upload';
$route['download-file']                        = 'documents/download';


$route['user-type-list']                       = 'usertype';
$route['consultant-type-list']                 = 'consultantstype';
$route['document-type-list']                   = 'documentstype';

$route['user-type-list']                       = 'usertype';
$route['consultant-type-list']                 = 'consultantstype';
$route['document-type-list']                   = 'documentstype';


/* Dashboard*/
$route['pending-documents']                    = 'documents/getPendingDocument';
$route['pending-documents-c2c']                = 'documents/getPendingDocumentc2c';

/* Dashboard*/
/*Route for mapping of vendor and consultant*/
$route['association']                          = 'association';

/*Route for timesheet*/
$route['time-sheet']                           = 'timesheet';
$route['timesheet-w2']                         = 'timesheetw2';
$route['timesheet-sole']                       = 'timesheetsole';
$route['timesheet-c2c']                        = 'timesheetc2c';

$route['time-expense-report']                  = 'timesheet/timesheet_report';
$route['timesheet-report-w2']                  = 'timesheetw2/timesheet_report_w2';
$route['timesheet-report-sole']                = 'timesheetsole/timesheet_report_sole';
$route['timesheet-report-c2c']                 = 'timesheetc2c/timesheet_report_c2c';

$route['pending-timesheet']					   = 'timesheet/getPendingTimesheet';
$route['pending-timesheet-w2']				   = 'timesheetw2/getPendingTimesheet_w2';
$route['pending-timesheet-sole']			   = 'timesheetsole/getPendingTimesheet_sole';
$route['pending-timesheet-c2c']			   	   = 'timesheetc2c/getPendingTimesheet_c2c';

$route['pending-timesheet/(:any)']			   = 'timesheet/pending_timesheet/$1';
$route['pending-timesheet-w2/(:any)']		   = 'timesheetw2/pending_timesheet_w2/$1';
$route['pending-timesheet-sole/(:any)']		   = 'timesheetsole/pending_timesheet_sole/$1';
$route['pending-timesheet-c2c/(:any)']		   = 'timesheetc2c/pending_timesheet_c2c/$1';

$route['pending-timesheet/(:any)/(:any)']	   = 'timesheet/pending_timesheet/$1/$2';
$route['pending-timesheet-w2/(:any)/(:any)']   = 'timesheetw2/pending_timesheet_w2/$1/$2';
$route['pending-timesheet-sole/(:any)/(:any)'] = 'timesheetsole/pending_timesheet_sole/$1/$2';
$route['pending-timesheet-c2c/(:any)/(:any)']  = 'timesheetc2c/pending_timesheet_c2c/$1/$2';

/*Route for Bills*/
$route['bills']                                = 'bills';
$route['bills-sole']                           = 'billssole';
$route['bills-c2c']                            = 'billsc2c';

$route['bills-report']                         = 'bills/bills_report';
$route['bills-sole-report']                    = 'billssole/bills_report';
$route['bills-c2c-report']                     = 'billsc2c/bills_report';

$route['pending-bills']						   = 'bills/getPendingBills';	
$route['pending-sole-bills']				   = 'billssole/getPendingBills';
$route['pending-c2c-bills']				  	   = 'billsc2c/getPendingBills';

$route['pending-bills/(:any)']				   = 'bills/pending_bills/$1';
$route['pending-sole-bills/(:any)']			   = 'billssole/pending_bills/$1';
$route['pending-c2c-bills/(:any)']			   = 'billsc2c/pending_bills/$1';

$route['upload-pending-bills/(:any)/(:any)']   = 'bills/upload_pending_bills/$1/$2';
$route['upload-sole-pending-bills/(:any)/(:any)']   = 'billssole/upload_pending_bills/$1/$2';
$route['upload-c2c-pending-bills/(:any)/(:any)']   = 'billsc2c/upload_pending_bills/$1/$2';	

/*Route for vendor contacts*/
$route['add-contact/(:any)']                   = 'vendors/add_contact/$1';

/*Route for vendor documents pending*/
$route['document-pending']                     = 'vendors/document_pending';

$route['404_override']                         = '';
$route['translate_uri_dashes']                 = FALSE;
