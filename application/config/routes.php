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

$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
// User
$route['login'] = 'Login/login';
$route['logout'] = 'Login/logout';
$route['forgotPassword'] = 'Login/forgotPassword';
$route['resetPassword'] = 'Login/resetPassword';
$route['resetPasswordAction'] = 'Login/resetPasswordAction';
$route['is_usernameExist'] = 'Login/is_usernameExist';
$route['registerUser'] = 'Login/registerUser';
$route['changePassword'] = 'Home/changePassword';
$route['coming_soon'] = 'Home/comingSoon';

//Page - mahesh
$route['page'] = '/Page/pageList';
$route['page/(:any)'] = '/Page/pageList/$1';
$route['addPage'] = '/Page/addPage';
$route['pageAdd'] = '/Page/pageAdd';
$route['downloadPage'] = '/Page/downloadPage';
$route['editPage/(:any)'] = '/Page/editPage/$1';
$route['deletePage/(:any)'] = '/Page/deletePage/$1';
$route['activatePage/(:any)'] = '/Page/activatePage/$1';
$route['rolePageMapping'] = '/Page/role_page_mapping';
$route['rolePageMapping/(:any)'] = '/Page/role_page_mapping/$1';
$route['submit_rolePageMapping'] = '/Page/submit_rolePageMapping';
$route['is_pageAlreadyExist'] = '/Page/is_pageAlreadyExist';
$route['unauthorized_request'] = '/Login/unauthorized_request';

//User-master data-Koushik
$route['user'] = 'User/user';
$route['user/(:any)'] = 'User/user/$1';
$route['usertab'] = 'User/usertab';
$route['add_user/(:any)'] = 'User/add_user/$1';
$route['insert_user'] = 'User/insert_user';
$route['edit_user/(:any)'] = 'User/edit_user/$1';
$route['update_user'] = 'User/update_user';
$route['change_password'] = 'User/change_password';
$route['change_password/(:any)'] = 'User/change_password/$1';
$route['insert_new_password'] = 'User/insert_new_password';
$route['insert_new_password/(:any)'] = 'Users/insert_new_password/$1';
$route['deactivate_user/(:any)'] = 'User/deactivate_user/$1';
$route['activate_user/(:any)'] = 'User/activate_user/$1';
$route['download_user'] = 'User/download_user';
$route['getplantList'] = 'User/getplantList';
$route['getdisignationList'] = 'User/getdisignationList';
$route['is_userExist'] = 'User/is_userExist';

/* Srilekha On 21st Jan 1:00 PM
   Distributor Routes */
$route['distributor']='Distributor/distributor';
$route['distributor/(:any)']='Distributor/distributor/$1';
$route['distributor_selection'] = 'Distributor/distributor_selection';
$route['add_distributor/(:any)']='Distributor/add_distributor/$1';
$route['insert_distributor']='Distributor/insert_distributor';
$route['edit_distributor/(:any)'] = 'Distributor/edit_distributor/$1';
$route['update_distributor'] = 'Distributor/update_distributor';
$route['deactivate_distributor/(:any)'] = 'Distributor/deactivate_distributor/$1';
$route['activate_distributor/(:any)'] = 'Distributor/activate_distributor/$1';
$route['download_distributor'] = 'Distributor/download_distributor';
$route['getregionList'] = 'Distributor/getregionList';
$route['getdistrictList'] = 'Distributor/getdistrictList';
$route['getareaList'] = 'Distributor/getareaList';
$route['view_distributor_details/(:any)']='Distributor_r/view_distributor_details/$1';

//roopa - oil tank master
$route['oil_tanker']='Oil_tanker/oil_tanker';
$route['oil_tanker/(:any)']='Oil_tanker/oil_tanker/$1';
$route['add_oil_tank']='Oil_tanker/add_oil_tank';
$route['insert_oil_tank']='Oil_tanker/insert_oil_tank';
$route['edit_oil_tank/(:any)'] = 'Oil_tanker/edit_oil_tank/$1';
$route['update_oil_tank'] = 'Oil_tanker/update_oil_tank';
$route['deactivate_oil_tank/(:any)'] = 'Oil_tanker/deactivate_oil_tank/$1';
$route['activate_oil_tank/(:any)'] = 'Oil_tanker/activate_oil_tank/$1';
$route['download_oil_tank'] = 'Oil_tanker/download_oil_tank';

// Priyanka
 # Insert Update Capacity Micron Details
$route['capacity_micron']='Capacity_micron/capacity_micron';

# Tanker Registration Details
$route['tanker_registration']='Tanker_register/tanker_registration';
$route['registration_details']='Tanker_register/registration_details';
$route['insert_tanker_registration_details']='Tanker_register/insert_tanker_registration_details';
$route['insert_freegift_tanker_details']='Tanker_register/insert_freegift_tanker_details';
$route['insert_pm_registration_details']='Tanker_register/insert_pm_registration_details';
$route['insert_empty_truck_registration_details'] = 'Tanker_register/insert_empty_truck_registration_details';
$route['insert_packed_product_registration_details'] = 'Tanker_register/insert_packed_product_registration_details';

//tanker out-priyanka
$route['tanker_out']='Tanker_out/tanker_out';
$route['tanker_out_details']='Tanker_out/tanker_out_details';
$route['insert_tanker_out_details']='Tanker_out/insert_tanker_out_details';

//gowri insert micron master
$route['micron']='Micron/micron';
$route['micron/(:any)']='Micron/micron/$1';
$route['add_micron']='Micron/add_micron';
$route['insert_micron']='Micron/insert_micron';
$route['edit_micron/(:any)'] = 'Micron/edit_micron/$1';
$route['update_micron'] = 'Micron/update_micron';
$route['deactivate_micron/(:any)'] = 'Micron/deactivate_micron/$1';
$route['activate_micron/(:any)'] = 'Micron/activate_micron/$1';
$route['is_micronExist']= 'Micron/is_micronExist';

//loose-oil-roopa
$route['loose_oil']='Loose_oil/loose_oil';
$route['loose_oil/(:any)']='Loose_oil/loose_oil/$1';
$route['add_loose_oil']='Loose_oil/add_loose_oil';
$route['insert_loose_oil']='Loose_oil/insert_loose_oil';
$route['edit_loose_oil/(:any)'] = 'Loose_oil/edit_loose_oil/$1';
$route['update_loose_oil'] = 'Loose_oil/update_loose_oil';
$route['deactivate_loose_oil/(:any)'] = '/Loose_oil/deactivate_loose_oil/$1';
$route['activate_loose_oil/(:any)'] = '/Loose_oil/activate_loose_oil/$1';
$route['download_loose_oil'] = 'Loose_oil/download_loose_oil';
$route['is_looseoilExist'] = 'Loose_oil/is_looseoilExist';

/* Srilekha On 02nd Feb 12:19 PM
   Designation Routes */
$route['designation']='Designation/designation';
$route['designation/(:any)']='Designation/designation/$1';
$route['add_designation']='Designation/add_designation';
$route['insert_designation']='Designation/insert_designation';
$route['edit_designation/(:any)'] = 'Designation/edit_designation/$1';
$route['update_designation'] = 'Designation/update_designation';
$route['deactivate_designation/(:any)'] = 'Designation/deactivate_designation/$1';
$route['activate_designation/(:any)'] = 'Designation/activate_designation/$1';
$route['download_designation'] = 'Designation/download_designation';
$route['is_designationExist'] = 'Designation/is_designationExist';

//packing material product crud mastan
$route['packing_material'] = 'Packing_material/packing_material';
$route['packing_material/(:any)']='Packing_material/packing_material/$1';
$route['add_packing_material']='Packing_material/add_packing_material';
$route['insert_packing_material']='Packing_material/insert_packing_material';
$route['edit_packing_material/(:any)'] = 'Packing_material/edit_packing_material/$1';
$route['update_packing_material'] = 'Packing_material/update_packing_material';
$route['deactivate_packing_material/(:any)'] = 'Packing_material/deactivate_packing_material/$1';
$route['activate_packing_material/(:any)'] = 'Packing_material/activate_packing_material/$1';
$route['download_packing_material'] = 'Packing_material/download_packing_material';
$route['is_pm_name_Exist'] = 'Packing_material/is_pm_name_Exist';

/* Srilekha On 02nd Feb 12:19 PM
   Plant Routes */
$route['plant']='Plant/plant';
$route['plant/(:any)']='Plant/plant/$1';
$route['add_unit']='Plant/add_unit';
$route['add_unit/(:any)']='Plant/add_unit/$1';
$route['add_plant']='Plant/add_plant';
$route['add_plant/(:any)']='Plant/add_plant/$1';
$route['plant_view']='Plant/plant_view';
$route['plant_view/(:any)']='Plant/plant_view/$1';
$route['add_cf/(:any)']='Plant/add_cf/$1';
$route['insert_plant']='Plant/insert_plant';
$route['insert_plant/(:any)']='Plant/insert_plant/$1';
$route['insert_cf/(:any)']='Plant/insert_cf/$1';
$route['edit_cf/(:any)'] = 'Plant/edit_cf/$1';
$route['update_cf'] = 'Plant/update_cf';
$route['edit_plant/(:any)'] = 'Plant/edit_plant/$1';
$route['update_plant'] = 'Plant/update_plant';
$route['deactivate_plant/(:any)'] = 'Plant/deactivate_plant/$1';
$route['activate_plant/(:any)'] = 'Plant/activate_plant/$1';
$route['download_plant'] = 'Plant/download_plant';
$route['getregionList'] = 'Plant/getregionList';
$route['getregionListcf'] = 'Plant/getregionListcf';
$route['getdistrictList'] = 'Plant/getdistrictList';
$route['getdistrictListcf'] = 'Plant/getdistrictListcf';
//$route['getareaList'] = 'Plant/getareaList';
//Plant
$route['getmandalList'] = 'Plant/getmandalList';


// Roopa supplier...
$route['supplier']='Supplier/supplier';
$route['supplier/(:any)']='Supplier/supplier/$1';
$route['add_supplier']='Supplier/add_supplier';
$route['insert_supplier']='Supplier/insert_supplier';
$route['edit_supplier/(:any)'] = 'Supplier/edit_supplier/$1';
$route['update_supplier'] = 'Supplier/update_supplier';
$route['deactivate_supplier/(:any)'] = 'Supplier/deactivate_supplier/$1';
$route['activate_supplier/(:any)'] = 'Supplier/activate_supplier/$1';
$route['download_supplier'] = 'Supplier/download_supplier';


// Ajax_ci
 // Created by Maruthi on 4th Feb 2017
 $route['ajax_get_regions_by_state_id']='Ajax_ci/ajax_get_regions_by_state_id';
 $route['ajax_get_districts_by_region_id']='Ajax_ci/ajax_get_districts_by_region_id';
 $route['ajax_get_areas_by_district_id']='Ajax_ci/ajax_get_areas_by_district_id';
 $route['delete_table_details']='Ajax_ci/delete_table_details';
 $route['ajax_get_mandals_by_district_id']='Ajax_ci/ajax_get_mandals_by_district_id';
$route['ajax_get_areas_by_mandal_id']='Ajax_ci/ajax_get_areas_by_mandal_id';



//aswini - unit_measure master

$route['unit_measure'] = 'Unit_measure/unit_measure';

$route['unit_measure/(:any)'] = 'Unit_measure/unit_measure/$1';

$route['add_unit_measure'] = 'Unit_measure/add_unit_measure';

$route['insert_unit_measure'] = 'Unit_measure/insert_unit_measure';

$route['edit_unit_measure/(:any)'] = 'Unit_measure/edit_unit_measure/$1';

$route['update_unit_measure'] = 'Unit_measure/update_unit_measure';

$route['deactivate_unit_measure/(:any)'] = 'Unit_measure/deactivate_unit_measure/$1';

$route['activate_unit_measure/(:any)'] = 'Unit_measure/activate_unit_measure/$1';

$route['download_unit_measure'] = 'Unit_measure/download_unit_measure';

$route['is_unit_measureExist']  = 'Unit_measure/is_unit_measureExist';



//head office product-master (Mounika on 06 Feb 2017)

$route['product'] = 'Product/product';

$route['product/(:any)'] = 'Product/product/$1';

$route['add_product']='Product/add_product';

$route['insert_product']='Product/insert_product';

$route['edit_product/(:any)'] = 'Product/edit_product/$1';

$route['update_product'] = 'Product/update_product';

$route['deactivate_product/(:any)'] = 'Product/deactivate_product/$1';

$route['activate_product/(:any)'] = 'Product/activate_product/$1';

$route['download_product'] = 'Product/download_product';
$route['is_product_name_Exist']  = 'Product/is_product_name_Exist';



// Location CRUD

// created by maruthi on 23rd Jan 2016 11:00 AM

// Location Add

$route['location_add']='Location/location_add';



// State

$route['state'] = 'Location/state';

$route['state/(:any)'] = 'Location/state/$1';

$route['add_state'] = 'Location/add_state';

$route['edit_state/(:any)'] = 'Location/edit_state/$1';



// Region

$route['region'] = 'Location/region';

$route['region/(:any)'] = 'Location/region/$1';

$route['add_region'] = 'Location/add_region';

$route['edit_region/(:any)'] = 'Location/edit_region/$1';



// District

$route['district'] = 'Location/district';

$route['district/(:any)'] = 'Location/district/$1';

$route['add_district'] = 'Location/add_district';

$route['edit_district/(:any)'] = 'Location/edit_district/$1';

// Mandal
// Mounika
$route['mandal'] = 'Location/mandal';
$route['mandal/(:any)'] = 'Location/mandal/$1';
$route['add_mandal'] = 'Location/add_mandal';
$route['edit_mandal/(:any)'] = 'Location/edit_mandal/$1';

//City

$route['area'] = 'Location/area';

$route['area/(:any)'] = 'Location/area/$1';

$route['add_area'] = 'Location/add_area';

$route['edit_area/(:any)'] = 'Location/edit_area/$1';



// Maruthi on 20th Jan 5:00 PM
$route['broker']='Broker/broker';
$route['broker/(:any)']='Broker/broker/$1';
$route['add_broker']='Broker/add_broker';
$route['insert_broker']='Broker/insert_broker';
$route['edit_broker/(:any)'] = 'Broker/edit_broker/$1';
$route['update_broker'] = 'Broker/update_broker';
$route['deactivate_broker/(:any)'] = 'Broker/deactivate_broker/$1';
$route['activate_broker/(:any)'] = 'Broker/activate_broker/$1';
$route['download_broker'] = 'Broker/download_broker';



//updation of product prices by prasad on 6 th feb

$route['product_price']='Product/product_price';

$route['view_product_price']='Product/view_product_price';

$route['update_product_price']='Product/update_product_price';

$route['insert_latest_price']='Product/insert_latest_price';



//Mounika

//Mounika

//Material Tender Process

$route['tender_process_details']='Tender_process/tender_process_details';

$route['tender_process_details/(:any)']='Tender_process/tender_process_details/$1';

$route['download_tender']='Tender_process/download_tender';

$route['tender_process']='Tender_process/tender_process';

$route['insert_tender_process']='Tender_process/insert_tender_process';

$route['tender_details']='Tender_process/tender_details';

$route['tender_details/(:any)']='Tender_process/tender_details/$1';

$route['insert_add_tender']='Tender_process/insert_add_tender';

$route['edit_tender/(:any)'] = 'Tender_process/edit_tender/$1';

$route['update_tender'] = 'Tender_process/update_tender';

$route['deactivate_tender/(:any)/(:any)'] = 'Tender_process/deactivate_tender/$1/$2';

$route['activate_tender/(:any)/(:any)'] = 'Tender_process/activate_tender/$1/$2';



//purchase order for Oil
$route['oil']='Tender_process/oil';
$route['oil/(:any)']='Tender_process/oil/$1';
$route['insert_po']='Tender_process/insert_po';
$route['reject']='Tender_process/reject';
$route['reject/(:any)']='Tender_process/reject/$1';
$route['insert_remarks']='Tender_process/insert_remarks';
$route['get_repeat_order_details_oil']='Tender_process/get_repeat_order_details_oil';





// Nagarjuna 28-11-2016 11.25 A.M creating Free Gifts Page

$route['freegift'] = 'Freegift/freegift';

$route['freegift/(:any)'] = 'Freegift/freegift/$1';

$route['add_freegift'] = 'Freegift/add_freegift';

$route['insert_freegift'] = 'Freegift/insert_freegift';

$route['edit_freegift/(:any)'] = 'Freegift/edit_freegift/$1';

$route['update_freegift'] = 'Freegift/update_freegift';

$route['deactivate_freegift/(:any)'] = 'Freegift/deactivate_freegift/$1';

$route['activate_freegift/(:any)'] = 'Freegift/activate_freegift/$1';

$route['download_freegift'] = 'Freegift/download_freegift';

//Uniqueness of Free Gifts name 

$route['is_freegiftExist'] = 'Freegift/is_freegiftExist';



//nagarjuna 17-02-2017

 $route['weighbridge']='Weigh_bridge/weighbridge';

 $route['weigh_bridge']='Weigh_bridge/weigh_bridge';

 $route['tanker_weight']='Weigh_bridge/tanker_weight';

 $route['update_gross/(:any)']='Weigh_bridge/update_gross/$1';

 $route['weigh_bridge_details']='Weigh_bridge/weigh_bridge_details';

 $route['update_tier/(:any)']='Weigh_bridge/update_tier/$1';

 $route['weigh_bridge_details/(:any)']='Weigh_bridge/weigh_bridge_details/$1';

 $route['update_freegift_gross/(:any)']='Weigh_bridge/update_freegift_gross/$1';

 $route['freegift_weigh_bridge_details']='Weigh_bridge/freegift_weigh_bridge_details';

 $route['update_freegift_tier/(:any)']='Weigh_bridge/update_freegift_tier/$1';

 $route['freegift_weigh_bridge_details/(:any)']='Weigh_bridge/freegift_weigh_bridge_details/$1'; 

 $route['update_pm_gross/(:any)']='Weigh_bridge/update_pm_gross/$1';

 $route['weigh_bridge_pm_details']='Weigh_bridge/weigh_bridge_pm_details';

 $route['update_pm_tier/(:any)']='Weigh_bridge/update_pm_tier/$1';

 $route['pm_weigh_bridge_details/(:any)']='Weigh_bridge/pm_weigh_bridge_details/$1'; 

 $route['update_empty_truck_tare'] = 'Weigh_bridge/update_empty_truck_tare';

 $route['empty_truck_weigh_bridge_details/(:any)'] = 'Weigh_bridge/empty_truck_weigh_bridge_details/$1';

 $route['update_empty_truck_gross'] = 'Weigh_bridge/update_empty_truck_gross';





//maruti labtest for loose oil and packing material

// Loose Oil Lab Tests

// Created by Maruthi on 6th Feb  1:10PM

$route['loose_oil_lab_test']='Loose_oil_lab_test/loose_oil_lab_test';

$route['loose_oil_lab_test/(:any)']='Loose_oil_lab_test/loose_oil_lab_test/$1';

$route['view_loose_oil_lab_tests/(:any)']='Loose_oil_lab_test/view_loose_oil_lab_tests/$1';



$route['add_loose_oil_lab_test']='Loose_oil_lab_test/add_loose_oil_lab_test';

$route['add_loose_oil_lab_test_list']='Loose_oil_lab_test/add_loose_oil_lab_test_list';

$route['insert_loose_oil_lab_test']='Loose_oil_lab_test/insert_loose_oil_lab_test';



$route['edit_loose_oil_lab_test/(:any)/(:any)']='Loose_oil_lab_test/edit_loose_oil_lab_test/$1/$1';

$route['update_loose_oil_lab_test']='Loose_oil_lab_test/update_loose_oil_lab_test';



// Paking Material  Lab Tests

// Created by Maruthi on 6th Feb 17 1:10PM

$route['packing_material_lab_test']='Packing_material_lab_test/packing_material_lab_test';

$route['packing_material_lab_test/(:any)']='Packing_material_lab_test/packing_material_lab_test/$1';

$route['view_packing_material_lab_tests/(:any)']='Packing_material_lab_test/view_packing_material_lab_tests/$1';

$route['add_packing_material_lab_test_list/(:any)']='Packing_material_lab_test/add_packing_material_lab_test_list/$1';

$route['insert_packing_material_lab_test']='Packing_material_lab_test/insert_packing_material_lab_test';

$route['edit_packing_material_lab_test/(:any)/(:any)']='Packing_material_lab_test/edit_packing_material_lab_test/$1/$1';

$route['update_packing_material_lab_test']='Packing_material_lab_test/update_packing_material_lab_test';

//prasad MRR loose Oil
//mrr for loose oil by prasad on 12 th feb
$route['loose_oil_mrr']='Loose_oil_mrr/loose_oil_mrr';
$route['mrr_loose_oil_details']='Loose_oil_mrr/mrr_loose_oil_details';
$route['insert_mrr_details']='Loose_oil_mrr/insert_mrr_details';
$route['download_loose_oil_mrr']='Loose_oil_mrr/download_loose_oil_mrr';

//MRR list for loose oil
$route['mrr_loose_oil_list']='Loose_oil_mrr/mrr_loose_oil_list';
$route['print_mrr_list/(:any)']='Mrr_pdf/print_mrr_list/$1';

//MRR Report for packing material
$route['pm_mrr']='Pm_mrr/pm_mrr';
$route['pm_mrr_details']='Pm_mrr/pm_mrr_details';
$route['insert_pm_mrr_details']='Pm_mrr/insert_pm_mrr_details';
$route['download_pm_mrr']='Pm_mrr/download_pm_mrr';

//MRR list for PM
$route['mrr_pm_list']='Pm_mrr/mrr_pm_list';
$route['mrr_pm_list/(:any)']='Pm_mrr/mrr_pm_list/$1';
$route['print_mrr_pm_list/(:any)']='Mrr_pdf/print_mrr_pm_list/$1';

//priyanka freegift mrr
#Free Gift MRR Reports
$route['freegift_mrr']='Free_gift_mrr/freegift_mrr';
$route['freegift_insert_po_fg']='Free_gift_mrr/freegift_insert_po_fg';
$route['insert_free_gift_mrr_details']='Free_gift_mrr/insert_free_gift_mrr_details';

//lab test for loose oil
$route['lab_test_report']='Oil_lab_test/lab_test_report';
$route['lab_test_report_detail']='Oil_lab_test/lab_test_report_detail';
$route['confirm_lab_test_report'] = 'Oil_lab_test/confirm_lab_test_report';
$route['insert_lab_test_report'] = 'Oil_lab_test/insert_lab_test_report';
$route['oil_test_results/(:any)'] = 'Oil_lab_test/oil_test_results/$1';
$route['print_oil_test_results/(:any)'] = 'Oil_lab_test/print_oil_test_results/$1';

/*Freegift
Author:Srilekha
Time:01:09PM 15-02-2017*/
$route['freegift_po_list']='Freegift_po/freegift_po_list';
$route['freegift_po_list/(:any)']='Freegift_po/freegift_po_list/$1';
$route['freegift_po']='Freegift_po/freegift_po';
$route['insert_po_freegift']='Freegift_po/insert_po_freegift';
$route['download_po_freegift'] = 'Freegift_po/download_po_freegift';



/*author:aswini

distributor credit debit routes*/


$route['credit_debit_notes'] = 'Payments/credit_debit_notes';

$route['getpurpose']='Payments/getpurpose';

$route['insert_credit_debit'] = 'Payments/insert_credit_debit';






//destributor payment receipts-roopa on feb 5:00PM

$route['distributor_payments'] = 'Payments/distributor_payments';

$route['distributor_payments/(:any)']='Payments/distributor_payments/$1';

$route['dd_verification/(:any)'] = 'Payments/dd_verification/$1';

$route['dd_approval'] = 'Payments/dd_approval';



//gowri dd insertion

$route['dd_receipts'] = 'Payments/dd_receipts';

$route['insert_add_receipts'] = 'Payments/insert_add_receipts';

$route['is_ddnumberExist']= 'Payments/is_numberExist';



// mastan on 17th FEB 2017 --Packing Material Lab Test
$route['packing_material_test'] = 'Pm_lab_test/packing_material_test';
$route['pm_lab_test_detail'] = 'Pm_lab_test/packing_material_test_detail';
$route['confirm_pm_lab_test'] = 'Pm_lab_test/confirm_packing_material_test';
$route['insert_pm_lab_test'] = 'Pm_lab_test/insert_packing_material_test';
$route['pm_test_results/(:any)'] = 'Pm_lab_test/pm_test_results/$1';
$route['print_pm_test_results/(:any)'] = 'Pm_lab_test/print_pm_test_results/$1';



//Purchase order for Packing Material
$route['po_packing_material']='Mtp_packingmaterial/po_packing_material';
$route['po_packing_material/(:any)']='Mtp_packingmaterial/po_packing_material/$1';
$route['po_packing_material_insert']='Mtp_packingmaterial/po_packing_material_insert';
$route['reject_packingmaterial']='Mtp_packingmaterial/reject_packingmaterial';
$route['reject_packingmaterial/(:any)']='Mtp_packingmaterial/reject_packingmaterial/$1';
$route['reject_packingmaterial_remarks']='Mtp_packingmaterial/reject_packingmaterial_remarks';
//ajax for getting repeat order details
$route['get_repeat_order_details']='Mtp_packingmaterial/get_repeat_order_details';



/*Free Samples
Author:Srilekha
Time:11:26AM 21-02-2017*/
$route['free_sample_list']='Free_samples/free_sample_list';
$route['free_sample_list/(:any)']='Free_samples/free_sample_list/$1';
$route['add_free_samples']='Free_samples/add_free_samples';
$route['insert_freesamples']='Free_samples/insert_freesamples';
$route['download_freesamples']='Free_samples/download_freesamples';
$route['getitemsList']='Free_samples/getitemsList';
$route['getquantityList']='Free_samples/getquantityList';



// Mounika 

//po for packing mtrl - mounika

//Packing Material Tender Process

$route['mtp_packingmaterial']='Mtp_packingmaterial/mtp_packingmaterial';

$route['mtp_packingmaterial/(:any)']='Mtp_packingmaterial/mtp_packingmaterial/$1';

$route['mtp_packingmaterial_add']='Mtp_packingmaterial/mtp_packingmaterial_add';

$route['mtp_packingmaterial_insert']='Mtp_packingmaterial/mtp_packingmaterial_insert';

$route['add_tender_details']='Mtp_packingmaterial/add_tender_details';

$route['add_tender_details/(:any)']='Mtp_packingmaterial/add_tender_details/$1';

$route['insert_tender']='Mtp_packingmaterial/insert_tender';

$route['edit_tender_details/(:any)'] ='Mtp_packingmaterial/edit_tender_details/$1';

$route['update_tender_details'] = 'Mtp_packingmaterial/update_tender_details';

$route['deactivate_tender_details/(:any)/(:any)'] = 'Mtp_packingmaterial/deactivate_tender_details/$1/$2';

$route['activate_tender_details/(:any)/(:any)'] = 'Mtp_packingmaterial/activate_tender_details/$1/$2';

$route['download_packing_material']='Mtp_packingmaterial/download_packing_material';



/*Tanker Registration List View

Author:Srilekha

Time:11:23AM 16-02-2017*/

$route['tanker_register']='Tanker_registration/tanker_registration';

$route['tanker_register/(:any)']='Tanker_registration/tanker_registration/$1';

$route['download_tanker_details'] = 'Tanker_registration/download_tanker_details';

$route['print_tanker_details/(:any)'] = 'Tanker_registration/print_tanker_details/$1';



/*User Profile

Author:Srilekha

Time:03.51PM 22-02-2017*/

$route['profile']='Profile/profile';



// C & F ( DD-Receipts) - gowri

$route['c_and_f'] = 'c_and_f_payments/c_and_f';

$route['insert_c_and_f'] = 'c_and_f_payments/insert_c_and_f';

$route['is_numberExist']= 'c_and_f_payments/is_numberExist';



//c&f payment receipts-roopa on feb 21-02-2017 at 5:00PM

$route['c_and_f_payments'] = 'C_and_f_payments/c_and_f_payments';

$route['c_and_f_payments/(:any)']='C_and_f_payments/c_and_f_payments/$1';

$route['dd_verifications/(:any)'] = 'C_and_f_payments/dd_verifications/$1';

$route['dd_approvals'] = 'C_and_f_payments/dd_approvals';

$route['download_c_and_f_payments'] = 'C_and_f_payments/download_c_and_f_payments';



// Nagarjuna 28-11-2016 11.25 A.M creating Bank Page

$route['bank'] = 'Bank_con/bank';

$route['bank/(:any)'] = 'Bank_con/Bank/$1';

$route['add_bank'] = 'Bank_con/add_bank';

$route['insert_bank'] = 'Bank_con/insert_bank';

$route['edit_bank/(:any)'] = 'Bank_con/edit_bank/$1';

$route['update_bank'] = 'Bank_con/update_bank';

$route['deactivate_bank/(:any)'] = 'Bank_con/deactivate_bank/$1';

$route['activate_bank/(:any)'] = 'Bank_con/activate_bank/$1';

$route['download_bank'] = 'Bank_con/download_bank';

//Uniqueness of Bank name 

$route['is_bankExist'] = 'Bank_con/is_bankExist';



//C AND F routes


$route['c_and_f_credit_debit_notes'] = 'C_and_f_payments/c_and_f_credit_debit_notes';

$route['getpurpose']='C_and_f_payments/getpurpose';

$route['insert_c_and_f_credit_debit'] = 'C_and_f_payments/insert_c_and_f_credit_debit';



//capacity -roopa  on feb 24-02-2017 at 12:00PM

$route['capacity']='Capacity/capacity';

$route['capacity/(:any)']='Capacity/capacity/$1';

$route['add_capacity']='Capacity/add_capacity';

$route['insert_capacity']='Capacity/insert_capacity';

$route['edit_capacity/(:any)'] = 'Capacity/edit_capacity/$1';

$route['update_capacity'] = 'Capacity/update_capacity';

$route['deactivate_capacity/(:any)'] = '/Capacity/deactivate_capacity/$1';

$route['activate_capacity/(:any)'] = '/Capacity/activate_capacity/$1';

$route['download_capacity'] = 'Capacity/download_capacity';

$route['is_capacityExist'] = 'Capacity/is_capacityExist';



// Nagarjuna 28-11-2016 11.25 A.M Test_unit Page

$route['test_unit'] = 'Test_unit/test_unit';

$route['test_unit/(:any)'] = 'Test_unit/test_unit/$1';

$route['add_test_unit'] = 'Test_unit/add_test_unit';

$route['insert_test_unit'] = 'Test_unit/insert_test_unit';

$route['edit_test_unit/(:any)'] = 'Test_unit/edit_test_unit/$1';

$route['update_test_unit'] = 'Test_unit/update_test_unit';

$route['deactivate_test_unit/(:any)'] = 'Test_unit/deactivate_test_unit/$1';

$route['activate_test_unit/(:any)'] = 'Test_unit/activate_test_unit/$1';

$route['download_test_unit'] = 'Test_unit/download_test_unit';

//Uniqueness of Bank name 

$route['is_test_unitExist'] = 'Test_unit/is_test_unitExist';



/*Packing Material Category

Author:Srilekha

Time:11.04AM 24-02-2017*/

$route['packing_material_category']='Packing_material_category/packing_material_category';

$route['packing_material_category/(:any)']='Packing_material_category/packing_material_category/$1';

$route['add_category']='Packing_material_category/add_category';

$route['insert_category']='Packing_material_category/insert_category';

$route['edit_category/(:any)'] = 'Packing_material_category/edit_category/$1';

$route['update_category'] = 'Packing_material_category/update_category';

$route['deactivate_category/(:any)'] = 'Packing_material_category/deactivate_category/$1';

$route['activate_category/(:any)'] = 'Packing_material_category/activate_category/$1';

$route['download_category'] = 'Packing_material_category/download_category';

$route['is_categoryExist'] = 'Packing_material_category/is_categoryExist';



//mastan on 23th FEB 2017 --sales-stock point

$route['counter_sale_view'] ='Sales/counter_sale_view';

$route['counter_sale_view/(:any)'] ='Sales/counter_sale_view/$1';

$route['view_sales_list/(:any)'] = 'Sales/view_sales_list/$1';

$route['counter_sales'] = 'Sales/counter_sales';

$route['insert_counter_sales'] = 'Sales/insert_counter_sales';

$route['print_counter_sales/(:any)'] = 'Sales_pdf/print_counter_sales/$1';

$route['delete_counter_sales/(:any)'] = 'Sales/delete_counter_sales/$1';

$route['activate_counter_sales/(:any)'] = 'Sales/activate_counter_sales/$1';

$route['get_raithu_bazar_price'] = 'Sales/get_raithu_bazar_price';

$route['get_counter_stock_in_counter_sale'] = 'Sales/get_counter_stock_in_counter_sale';







# Priyanka on 24th Feb 2017 12:52 PM

# Delivery Order Pages

$route['delivery_order']='Delivery_order/delivery_order';

$route['delivery_order_details']='Delivery_order/delivery_order_details';

$route['confirm_delivery_order']='Delivery_order/confirm_delivery_order';

$route['submit_delivery_order']='Delivery_order/submit_delivery_order';



//aswini

$route['ob_booking_for_single_product'] = 'OB_cntr_for_single_product/ob_booking_for_single_product';

$route['ob_booking_for_all_products'] = 'OB_cntr_all_products/ob_booking_for_all_products';



// Production

// Created by Maruthi on 21st Feb 17

$route['manage_production']='Production/manage_production';

$route['manage_production/(:any)']='Production/manage_production/$1';

$route['production_entry']='Production/production_entry';

$route['confirm_production_entry']='Production/confirm_production_entry';

$route['insert_production_entry']='Production/insert_production_entry';

$route['download_production'] = 'Production/download_production';



// Oil Stock Balance 

// Created By Maruthi on 23rd Feb 17

$route['manage_oil_stock_balance']='Oil_stock_balance/manage_oil_stock_balance';

$route['manage_oil_stock_balance/(:any)']='Oil_stock_balance/manage_oil_stock_balance/$1';

$route['oil_stock_balance_entry']='Oil_stock_balance/oil_stock_balance_entry';

$route['insert_oil_stock_balance_entry']='Oil_stock_balance/insert_oil_stock_balance_entry';

$route['confirm_oil_stock_balance_entry']='Oil_stock_balance/confirm_oil_stock_balance_entry';

$route['download_oil_stock_balance']='Oil_stock_balance/download_oil_stock_balance';



//price updation report

$route['product_price_report']='Reports/product_price_report';

$route['view_product_price_report']='Reports/view_product_price_report';

$route['download_product_price_report']='Reports/download_product_price_report';


// Distributor Invoice
// Created By Maruthi on 26th Feb 2017
$route['manage_dist_invoice'] = 'Distributor_invoice/manage_dist_invoice';
$route['manage_dist_invoice/(:any)'] = 'Distributor_invoice/manage_dist_invoice/$1';
$route['dist_invoice_entry']='Distributor_invoice/dist_invoice_entry';
$route['dist_invoice_generation']='Distributor_invoice/dist_invoice_generation';
$route['confirm_dist_invoice_generation']='Distributor_invoice/confirm_dist_invoice_generation';
$route['insert_dist_invoice_generation']='Distributor_invoice/insert_dist_invoice_generation';
$route['download_dist_invoice']='Distributor_invoice/download_dist_invoice';
$route['view_dist_invoice_details/(:any)'] = 'Distributor_invoice/view_dist_invoice_details/$1';
$route['print_dist_invoice_details'] = 'Distributor_invoice_pdf/print_dist_invoice_details';	

//Gate pass
$route['gate_pass']='Gate_pass/gate_pass';
$route['add_gate_pass']='Gate_pass/add_gate_pass';
$route['is_invoice_numberExist']='Gate_pass/is_invoice_numberExist';
$route['generate_gate_pass']='Gate_pass/generate_gate_pass';

//gatepass list
$route['gate_pass_list']='Gate_pass/gate_pass_list';
$route['gate_pass_list/(:any)']='Gate_pass/gate_pass_list/$1';
$route['print_gate_pass_list/(:any)']='Gate_pass/print_gate_pass_list/$1';

# Created By Priyanka on 21st Feb 2017 11:48 AM
# Distributor Order Booking 
$route['distributor_ob']='Distributor_ob/distributor_ob';
$route['getDistributors']='Distributor_ob/getDistributors';
$route['getStockLiftingUnit']='Distributor_ob/getStockLiftingUnit';
$route['distributor_ob_products']='Distributor_ob/distributor_ob_products';
$route['view_distributor_ob_products']='Distributor_ob/view_distributor_ob_products';
$route['print_distributor_ob_products/(:any)/(:any)']='Distributor_ob/print_distributor_ob_products/$1/$2';
$route['insert_distributor_ob_products']='Distributor_ob/insert_distributor_ob_products';

# Distributor Orders List
$route['distributor_ob_list']='Distributor_ob/distributor_ob_list';
$route['distributor_ob_list/(:any)']='Distributor_ob/distributor_ob_list/$1';
$route['view_distributor_ob/(:any)']='Distributor_ob/view_distributor_ob/$1';
$route['view_distributor_ob/(:any)/(:any)']='Distributor_ob/view_distributor_ob/$1/$2';
$route['download_ob_list']='Distributor_ob/download_ob_list';

# Delivery Orders List
$route['distributor_do_list']='Delivery_order/distributor_do_list';
$route['distributor_do_list/(:any)']='Delivery_order/distributor_do_list/$1';
$route['view_distributor_do/(:any)']='Delivery_order/view_distributor_do/$1';
$route['view_distributor_do/(:any)/(:any)']='Delivery_order/view_distributor_do/$1/$2';
$route['download_do_list']='Delivery_order/download_do_list';

# Print DO Products
$route['print_distributor_do_products']='Delivery_order/print_distributor_do_products';
$route['print_distributor_do_products/(:any)']='Delivery_order/print_distributor_do_products/$1';

/*Executive
Author:Srilekha
Time:10.31AM 01-03-2017*/
$route['executive']='Executive/executive';
$route['executive/(:any)']='Executive/executive/$1';
$route['add_executive']='Executive/add_executive';
$route['insert_executive']='Executive/insert_executive';
$route['edit_executive/(:any)'] = 'Executive/edit_executive/$1';

$route['update_executive'] = 'Executive/update_executive';

$route['deactivate_executive/(:any)'] = 'Executive/deactivate_executive/$1';

$route['activate_executive/(:any)'] = 'Executive/activate_executive/$1';

$route['download_executive'] = 'Executive/download_executive';

$route['is_executiveExist'] = 'Executive/is_executiveExist';


//Freegift_scheme - Koushik

$route['freegift_scheme'] = 'Freegift_scheme/freegift_scheme';

$route['freegift_scheme/(:any)'] = 'Freegift_scheme/freegift_scheme/$1';

$route['add_freegift_scheme'] = 'Freegift_scheme/add_freegift_scheme';

$route['view_freegift_scheme/(:any)'] = 'Freegift_scheme/view_freegift_scheme/$1';

$route['insert_freegift_scheme'] = 'Freegift_scheme/insert_freegift_scheme';



//general settings-roopa  on feb 28-02-2017 at 12:00PM

$route['settings_list']='Settings/settings_list';

$route['settings_list/(:any)']='Settings/settings_list/$1';

$route['add_general_settings']='Settings/add_general_settings';

$route['insert_general_settings']='Settings/insert_general_settings';

$route['edit_settings/(:any)'] = 'Settings/edit_settings/$1';

$route['update_settings'] = 'Settings/update_settings';

$route['is_nameExist'] = 'Settings/is_nameExist';



//general settings-roopa  on march 03-03-2017 at 04:00PM

$route['edit_general_settings'] = 'General_settings_c/edit_general_settings';

$route['update_general_settings'] = 'General_settings_c/update_general_settings';



//plant freegift list-roopa on march 02-03-2017 at 6:00PM

$route['plant_freegift_list']='Plant_free_gift_list/plant_freegift_list';

$route['plant_freegift_list/(:any)']='Plant_free_gift_list/plant_freegift_list/$1';

$route['download_plant_freegift_list']='Plant_free_gift_list/download_plant_freegift_list';



/*Stock transfer

Author:Nagarjuna

Time:1:10pM 27-02-2017*/

$route['godown_to_countersale']='Stock_transfer/godown_to_countersale';

$route['submit_godown_to_countersale']='Stock_transfer/submit_godown_to_countersale';

$route['insert_godown_to_countersale'] = 'Stock_transfer/insert_godown_to_countersale';

$route['get_godown_stock'] = 'Stock_transfer/get_godown_stock';



$route['countersale_to_godown']='Stock_transfer/countersale_to_godown';

$route['submit_countersale_to_godown']='Stock_transfer/submit_countersale_to_godown';

$route['insert_countersale_to_godown'] = 'Stock_transfer/insert_countersale_to_godown';

$route['get_counter_stock'] = 'Stock_transfer/get_counter_stock';



/*Oil Recovering

Author:Srilekha

Time:10.19PM 02-03-2017*/

$route['oil_product']='Convert_oil_product/loose_oil';
$route['loose_oil_recover']='Convert_oil_product/loose_oil_recover';
$route['oil_confirm']='Convert_oil_product/oil_confirm';
$route['insert_oil_product']='Convert_oil_product/insert_oil_product';



//welfare scheme
//Created By Aswini on 1st march 2017
$route['welfare_scheme']='Welfare_scheme/welfare_scheme';
$route['welfare_scheme/(:any)']='Welfare_scheme/welfare_scheme/$1';
$route['add_welfare_scheme']='Welfare_scheme/add_welfare_scheme';
$route['insert_welfare_scheme']='Welfare_scheme/insert_welfare_scheme';
$route['edit_welfare_scheme/(:any)'] = 'Welfare_scheme/edit_welfare_scheme/$1';
$route['update_welfare_scheme'] = 'Welfare_scheme/update_welfare_scheme';
$route['deactivate_welfare_scheme/(:any)'] = 'Welfare_scheme/deactivate_welfare_scheme/$1';
$route['activate_welfare_scheme/(:any)'] = 'Welfare_scheme/activate_welfare_scheme/$1';
$route['download_welfare_scheme'] = 'Welfare_scheme/download_welfare_scheme';

//Leakage work flow
$route['leakage_entry']='Leakage/leakage_entry';
$route['get_carton_per_product']='Leakage/get_carton_per_product';
$route['confirm_leakage_entry']='Leakage/confirm_leakage_entry';
$route['insert_leakage_entry']='Leakage/insert_leakage_entry';

/*Opening stock entry
Author:Gowri*/
$route['product_quantity']='Opening_stock_entry/product_quantity';
$route['view_product_quantity']='Opening_stock_entry/view_product_quantity';
$route['insert_latest_quantity']='Opening_stock_entry/insert_latest_quantity';


/*Opening stock entry for packing material
Author:srilekha
Time:12:41PM 05-03-2017*/
$route['view_pm_quantity']='Pm_stock_balance/view_pm_quantity';
$route['insert_latest_pmqty']='Pm_stock_balance/insert_latest_pmqty';



# Stock Receiving For C & F and Stock point
# Priyanka on 1st March 2017, 11:15 AM
$route['stock_receiving']='Stock_receiving/stock_receiving';
$route['stock_rec_invoice_products']='Stock_receiving/stock_rec_invoice_products';
$route['insert_products_free_gifts']='Stock_receiving/insert_products_free_gifts';
$route['confirm_products_free_gifts']='Stock_receiving/confirm_products_free_gifts';

# Priyanka on 3rd March 2017, 4:27 PM
$route['stock_receiving_list']='Stock_receiving/stock_receiving_list';
$route['view_srn_invoice_details/(:any)']='Stock_receiving/view_srn_invoice_details/$1';
$route['print_srn_invoice_details/(:any)']='Stock_receiving/print_srn_invoice_details/$1';
$route['download_srn_list']='Stock_receiving/download_srn_list';

// Packing Material Consumption
// Created By Maruthi on 2nd Mar 2017
$route['manage_pm_consumption'] ='Pm_consumption/manage_pm_consumption';
$route['manage_pm_consumption/(:any)'] ='Pm_consumption/manage_pm_consumption/$1';
$route['add_pm_consumption'] = 'Pm_consumption/add_pm_consumption';
$route['add_pm_consumption_list'] = 'Pm_consumption/add_pm_consumption_list';
$route['add_pm_consumption_list/(:any)'] = 'Pm_consumption/add_pm_consumption_list/$1';
$route['insert_pm_consumption'] = 'Pm_consumption/insert_pm_consumption';
$route['edit_pm_consumption/(:any)'] = 'Pm_consumption/edit_pm_consumption/$1';
$route['update_pm_consumption'] ='Pm_consumption/update_pm_consumption';
$route['view_pm_consumption/(:any)'] ='Pm_consumption/view_pm_consumption/$1';

// PM Stock Balance 
// Created By Maruthi on 25th Feb 17
$route['manage_pm_stock_balance']='Pm_stock_balance/manage_pm_stock_balance';
$route['manage_pm_stock_balance/(:any)']='Pm_stock_balance/manage_pm_stock_balance/$1';
$route['pm_oil_stock_balance/(:any)']='Pm_stock_balance/pm_oil_stock_balance/$1';
$route['pm_stock_balance_entry']='Pm_stock_balance/pm_stock_balance_entry';
$route['insert_pm_stock_balance_entry']='Pm_stock_balance/insert_pm_stock_balance_entry';
$route['confirm_pm_stock_balance_entry']='Pm_stock_balance/confirm_pm_stock_balance_entry';
$route['download_pm_stock_balance']='Pm_stock_balance/download_pm_stock_balance';

# Order Booking for Plants
# Priyanka on 4th March 2017, 4:12 PM
$route['plant_ob']='Plant_ob/plant_ob';
$route['plant_ob_products']='Plant_ob/plant_ob_products';
$route['confirm_plant_ob_products']='Plant_ob/confirm_plant_ob_products';
$route['insert_plant_ob_products']='Plant_ob/insert_plant_ob_products';


# Order Booking List
# priyanka on 5th March 2017, 11:55 PM

$route['plant_ob_list']='Plant_ob/plant_ob_list';
$route['plant_ob_list/(:any)']='Plant_ob/plant_ob_list/$1';
$route['view_plant_ob_products/(:any)/(:any)']='Plant_ob/view_plant_ob_products/$1/$2';

$route['print_plant_ob_products/(:any)/(:any)']='Plant_ob/print_plant_ob_products/$1/$2';

$route['download_plant_ob']='Plant_ob/download_plant_ob';


# DO for Plants

# Priyanka on 5th March 2017, 3:15 PM

$route['plant_do']='Plant_do/plant_do';

$route['plant_do_products']='Plant_do/plant_do_products';

$route['confirm_plant_do']='Plant_do/confirm_plant_do';

$route['submit_plant_do']='Plant_do/submit_plant_do';



# DO List

# priyanka on 5th March 2017, 11:55 PM

$route['plant_do_list']='Plant_do/plant_do_list';
$route['plant_do_list/(:any)']='Plant_do/plant_do_list/$1';
$route['view_plant_do_products/(:any)/(:any)']='Plant_do/view_plant_do_products/$1/$2';
$route['print_plant_do_products/(:any)/(:any)']='Plant_do/print_plant_do_products/$1/$2';
$route['download_plant_do']='Plant_do/download_plant_do';


//Gate pass for plant

$route['plant_gate_pass']='Plant_gate_pass/plant_gate_pass';
$route['add_plant_gate_pass']='Plant_gate_pass/add_plant_gate_pass';

//$route['is_invoice_numberExist']='Plant_gate_pass/is_invoice_numberExist';
$route['generate_plant_gate_pass']='Plant_gate_pass/generate_plant_gate_pass';



//gatepass list for plant

$route['plant_gate_pass_list']='Plant_gate_pass/plant_gate_pass_list';
$route['plant_gate_pass_list/(:any)']='Plant_gate_pass/plant_gate_pass_list/$1';
$route['print_plant_gate_pass_list/(:any)']='Gate_pass_pdf/print_plant_gate_pass_list/$1';

// Plant Invoice
// Created By Maruthi on 6th Mar 2017
$route['manage_plant_invoice'] = 'Plant_invoice/manage_plant_invoice';
$route['manage_plant_invoice/(:any)'] = 'Plant_invoice/manage_plant_invoice/$1';
$route['plant_invoice_entry']='Plant_invoice/plant_invoice_entry';
$route['plant_invoice_generation']='Plant_invoice/plant_invoice_generation';
$route['confirm_plant_invoice_generation']='Plant_invoice/confirm_plant_invoice_generation';
$route['insert_plant_invoice_generation']='Plant_invoice/insert_plant_invoice_generation';
$route['download_plant_invoice']='Plant_invoice/download_plant_invoice';
$route['view_plant_invoice_details/(:any)'] = 'Plant_invoice/view_plant_invoice_details/$1';
$route['print_plant_invoice_details'] = 'Distributor_invoice_pdf/print_plant_invoice_details';
$route['print_plant_invoice_details/(:any)'] = 'Distributor_invoice_pdf/print_plant_invoice_details/$1'; 

/*Distributor Reports
Author:Srilekha
Time: 12.35PM 10-03-2017 */
$route['distributor_r']='Distributor_r/distributor_r';
$route['distributor_r/(:any)']='Distributor_r/distributor_r/$1';
$route['download_distributor_r']='Distributor_r/download_distributor_r';

//reports --- broker & supplier
$route['broker_report_search'] = 'Broker_r/broker_report_search';
$route['broker_report_details']= 'Broker_r/broker_report_details';
$route['print_supplier'] = 'Supplier_r/print_supplier';
$route['supplier_view_r'] = 'Supplier_r/supplier_view_r';

//lab test reports (oils & packing materials)
$route['oil_test_r'] = 'Lab_test_r/oil_test_reports';
$route['oil_test_r/(:any)'] = 'Lab_test_r/oil_test_reports/$1';
$route['download_oil_test_r/(:any)'] = 'Lab_test_r/download_oil_test_r/$1';

$route['pm_test_r'] = 'Lab_test_r/pm_test_reports';
$route['pm_test_r/(:any)'] = 'Lab_test_r/pm_test_reports/$1';
$route['download_pm_test_r/(:any)'] = 'Lab_test_r/download_pm_test_r/$1';

/* Ob History Oil Records List
Author:aswini
Time: 3pm 10-03-2017 */
$route['ob_history_oil_R'] ='Ob_history_oil_R/ob_history_oil_R';
$route['ob_history_oil_R/(:any)'] ='Ob_history_oil_R/ob_history_oil_R/$1';
$route['download_ob_history_oil_R'] = 'Ob_history_oil_R/download_ob_history_oil_R';

/* Ob History  Records List
Author:aswini
Time: 12pm 10-03-2017 */
$route['ob_history_R'] ='Ob_history_R/ob_history_R';
$route['ob_history_R/(:any)'] ='Ob_history_R/ob_history_R/$1';
$route['download_ob_history_R'] = 'Ob_history_R/download_ob_history_R';

// Purchase order Reports
//Mounika
$route['loose_oil_report']='Po_reports/loose_oil_report';
$route['loose_oil_report/(:any)']='Po_reports/loose_oil_report/$1';
$route['print_loose_oil/(:any)']='Po_reports/print_loose_oil/$1';

//Product Reports
#Nagarjuna on 10th March 2017, 12:25 PM
$route['product_r']='Product_r/product_r';
$route['print_product_report'] = 'Product_r/print_product_report';

// Purchase order Reports
//Mounika
//Packing Material
$route['pm_report']='Po_reports/pm_report';
$route['pm_report/(:any)']='Po_reports/pm_report/$1';
$route['print_pm/(:any)']='Po_reports/print_pm/$1';

//weigh bridge list & print
$route['weigh_bridge_list'] = 'Weigh_bridge/weigh_bridge_list';
$route['weigh_bridge_list/(:any)'] = 'Weigh_bridge/weigh_bridge_list/$1';
$route['view_weigh_bridge_list/(:any)'] = 'Weigh_bridge/view_weigh_bridge_list/$1';
$route['download_weigh_bridge_list/(:any)'] = 'Weigh_bridge/download_weigh_bridge_list/$1';

//available stock per plant - srilekha
$route['plant_stock_reports']='Plant_stock_r/plant_stock_reports';

/*MRR List
Author:Srilekha
Time: 02.33PM 11-03-2017 */
$route['mrr_fg_list']='Free_gift_mrr/mrr_fg_list';
$route['mrr_fg_list/(:any)']='Free_gift_mrr/mrr_fg_list/$1';
$route['download_mrr_fg']='Free_gift_mrr/download_mrr_fg';

/*Product Packing MAterial Weight
Author:srilekha
Time:11:21AM 14-03-2017*/
$route['product_pm_weight']='Product_pm_weight/product_pm_weight';
$route['insert_product_pm_weight']='Product_pm_weight/insert_product_pm_weight';

/* routes for waste oil
Author:gowripriya
Time: 11am 15-03-2017 */
$route['waste_oil']='Waste_oil/waste_oil';
$route['waste_oil/(:any)']='Waste_oil/waste_oil/$1';
$route['view_waste_oil']='Waste_oil/view_waste_oil';
$route['insert_waste_oil']='Waste_oil/insert_waste_oil';

//roopa on 13th march 2017 --Waste oil sale
$route['waste_oil_sale'] ='Waste_oil_sale/waste_oil_sale';
$route['waste_oil_sale/(:any)'] ='Waste_oil_sale/waste_oil_sale/$1';
$route['add_waste_oil_sale']='Waste_oil_sale/add_waste_oil_sale';
$route['insert_waste_oil_sale']='Waste_oil_sale/insert_waste_oil_sale';
//ajax for loose oil based on quantity
$route['get_loose_oil_details']='Waste_oil_sale/get_loose_oil_details';

// Recovered oil scrap
// Created By Aswini on 8th march 2017
$route['oil_scrap']='Recovered_oil_scrap/oil_scrap';
$route['oil_scrap/(:any)']='Recovered_oil_scrap/oil_scrap/$1';
$route['add_recovered_oil_scrap']='Recovered_oil_scrap/add_recovered_oil_scrap';
$route['insert_recovered_oil_scrap']='Recovered_oil_scrap/insert_recovered_oil_scrap';
$route['get_oil_weight'] = 'Recovered_oil_scrap/get_oil_weight';


/*Product Micron
Author:Srilekha
Time: 01.23PM 16-03-2017 */
//$route['product_micron']='Product_micron/product_micron';
$route['product_micron']='Pm_stock_balance/film_pm_stock_balance_entry';

//Ops Wet Cartons
//Mounika
$route['wet_cartons_entry']='Ops_wet_cartons/wet_cartons_entry';
$route['insert_wet_carton']='Ops_wet_cartons/insert_wet_carton';


/*Loose Oil Stock entry
Author:Srilekha
Time: 01.01PM 17-03-2017 */
$route['waste_oil_quantity']='Waste_oil/waste_oil_quantity';

//Nagarjuna 17-03-2017 2:30PM
$route['freegift_quantity']='Freegift/freegift_quantity';


$route['godown_leakage_entry']='Stock_leakage/godown_leakage_entry';
$route['counter_leakage_entry']='Stock_leakage/counter_leakage_entry';
$route['confirm_stock_leakage_entry']='Stock_leakage/confirm_stock_leakage_entry';
$route['insert_stock_leakage_entry']='Stock_leakage/insert_stock_leakage_entry';

$route['is_pm_name_Exist'] ='packing_material/is_pm_name_Exist';

//ops leakage reports - mastan(16-03-17)
$route['ops_leakage_r'] = 'Ops_leakage_r/ops_leakage_r';
$route['ops_leakage_r/(:any)'] = 'Ops_leakage_r/ops_leakage_r/$1';
$route['download_ops_leakage_r'] = 'Ops_leakage_r/download_ops_leakage_report';
$route['print_ops_leakage_r'] = 'Ops_leakage_r/print_ops_leakage_r';

//Executive Limit - mastan(17-03-17)
$route['executive_limit'] = 'Executive_limit/executive_limit';
$route['submit_executive_limit'] = 'Executive_limit/submit_executive_limit';

# Distributor Pending OBs & DOs
$route['get_dist_pending_obs']='Distributor_ob/get_distributor_orders';
$route['get_dist_pending_dos']='Delivery_order/get_dist_pending_dos';

# Plants Pending OBs & DOs 
$route['get_plant_pending_obs']='Plant_ob/get_plant_pending_obs';
$route['get_plant_pending_dos']='Plant_do/get_plant_pending_dos';

//Production Report
//Mounika
$route['production_report']='Production_report/production_report';
$route['print_production_report']='Production_report/print_production_report';

$route['product_price_report_units']='Reports/product_price_report_units';
$route['view_product_price_report_units']='Reports/view_product_price_report_units';

// OPS Daily Reports 
// Created by Maruthi on 18th Mar'17
$route['oil_report_search'] = 'Daily_reports/oil_report_search';
$route['daily_oil_report'] = 'Daily_reports/daily_oil_report';
$route['daily_stock_report_search'] = 'Daily_reports/daily_stock_report_search';
$route['daily_stock_report'] = 'Daily_reports/daily_stock_report';
$route['daily_pm_stock_report_search'] = 'Daily_reports/daily_pm_stock_report_search';
$route['daily_pm_stock_report'] ='Daily_reports/daily_pm_stock_report';

//Stock point product stock balance
$route['stock_point_product_balance']='Stock_point_product_report/stock_point_product_balance';
$route['stock_point_product_report']='Stock_point_product_report/stock_point_product_report';



//stock dispaches report(stock point)-----mastan
$route['stock_dispatch_r'] = 'Stock_point/stock_dispatch_report';
$route['stock_dispatch_detail'] = 'Stock_point/stock_dispatch_detail';

//stockpoint leakage reports - mastan(18-03-17)
$route['sp_leakage_r'] = 'Ops_leakage_r/sp_leakage_r';
$route['sp_leakage_r/(:any)'] = 'Ops_leakage_r/sp_leakage_r/$1';
$route['download_sp_leakage_r'] = 'Ops_leakage_r/download_sp_leakage_report';

/*Daily sales Report 
Author:Srilekha
Time:23-03-2017 12.42PM*/
//districtwise
$route['district_sales_report']='Sales/district_sales_report';
$route['district_sales_report_print']='Sales/district_sales_report_print';

//daily sales report unit wise
$route['daily_sales_report']='Sales/daily_sales_report';
$route['daily_sales_report_print']='Sales/daily_sales_report_print';

//monthly sales report unit wise
$route['monthly_sales_report']='Sales/monthly_sales_report';
$route['monthly_sales_report_print']='Sales/monthly_sales_report_print';

//daily unit wise product  dispatch report
$route['daily_product_sale_report']='Sales/daily_product_sale_report';
$route['daily_product_sales_report_print']='Sales/daily_product_sales_report_print';

//monthly unit wise product  dispatch report
$route['monthly_product_sale_report']='Sales/monthly_product_sale_report';
$route['monthly_product_sales_report_print']='Sales/monthly_product_sales_report_print';

//Daily Executive wise product dispatch report
$route['daily_exec_product_sale_report']='Sales/daily_exec_product_sale_report';
$route['daily_exec_product_sales_report_print']='Sales/daily_exec_product_sales_report_print';

//monthly Executive wise product dispatch report
$route['monthly_exec_product_sale_report']='Sales/monthly_exec_product_sale_report';
$route['monthly_exec_product_sales_report_print']='Sales/monthly_exec_product_sales_report_print';

//Daily Executive sales report
$route['executive_daily_sales_report']='Sales/executive_daily_sales_report';
$route['executive_daily_sales_report_print']='Sales/executive_daily_sales_report_print';

//Monthly executive sales report
$route['executive_monthly_sales_report']='Sales/executive_monthly_sales_report';
$route['executive_monthly_sales_report_print']='Sales/executive_monthly_sales_report_print';


/*Sales Details for scrolling 
Author:Srilekha
Time: 04.36PM 21-03-2017 */
$route['sales_scroll']='Sales/sales_scroll';
$route['sales_print_scroll']='Sales/sales_print_scroll';

/*Stock Details for scrolling 
Author:Srilekha
Time: 05.01PM 18-03-2017 */
$route['stock_scroll']='Stock/stock_scroll';
$route['stock_print_scroll']='Stock/stock_print_scroll';

/*Daily Tanker Reports
Author:Srilekha
Time: 01.10PM 25-03-2017 */
$route['packing_station_tanker_view']='Packing_station_report/packing_station_tanker_view';
$route['packing_station_tanker_report_print']='Packing_station_report/packing_station_tanker_report_print';
$route['packing_station_tanker_abstract_view']='Packing_station_report/packing_station_tanker_abstract_view';
$route['packing_station_tanker_report_abstract_print']='Packing_station_report/packing_station_tanker_report_abstract_print';

/*dist_dd_r routes
Author:gowri
Time: 3-21-17*/ 
$route['dist_dd_r'] = 'Dist_dd_r/dist_dd_r';
$route['print_dist_datewise_dd_report'] = 'Dist_dd_r/print_dist_datewise_dd_report';
$route['download_distributor_dd_payment'] = 'Dist_dd_r/download_distributor_dd_payment';

/* C and F payments  Reports 
Author:aswini
Time: 4pm 20-03-2017 */
$route['c_and_f_payments_R'] = 'C_and_f_payments_R/c_and_f_payments_R';
$route['print_c_and_f_dd_payment_list'] = 'C_and_f_payments_R/print_c_and_f_dd_payment_list';
$route['download_c_and_f_payments_R'] = 'C_and_f_payments_R/download_c_and_f_payments_R';

//c&f credit debit reports-roopa
$route['cd_candf_r'] = 'Cd_candf_r/cd_candf_r';
$route['print_c_and_f_cd_report'] = 'Cd_candf_r/print_c_and_f_cd_report';
$route['download_c_and_f_cd_report'] = 'Cd_candf_r/download_c_and_f_cd_report';

//distributor credit debit reports...roopa
$route['c_d_distributor_r'] = 'Cd_distributor_r/c_d_distributor_r';
$route['print_dist_cd_report'] = 'Cd_distributor_r/print_dist_cd_report';
$route['download_dist_cd_report'] = 'Cd_distributor_r/download_dist_cd_report';

//free gift report
//mounika
$route['print_free_gift/(:any)']='Freegift_po/print_free_gift/$1';
$route['print_loose_oil/(:any)']='Po_reports/print_loose_oil/$1';
$route['print_pm/(:any)']='Po_reports/print_pm/$1';


$route['single_do_ob_list'] = 'Ob_list/single_do_ob_list';
$route['print_distributor_ob_products']='Distributor_ob/print_distributor_ob_products';

$route['single_plant_ob_list'] = 'Ob_list/single_plant_ob_list';

$route['print_plant_ob_products']='Plant_ob/print_plant_ob_products';

$route['print_dist_invoice_details/(:any)'] = 'Distributor_invoice_pdf/print_dist_invoice_details/$1';

//unit stock wise report 
$route['unit_wise_stock']='Unit_wise_stock_report/unit_wise_stock';

//exe wise distributor payment list
$route['exec_wise_dist_list']='Exec_wise_dist_list_r/exec_wise_dist_list';
$route['view_exec_dist_list']='Exec_wise_dist_list_r/view_exec_dist_list';

// Mahesh
$route['print_plant_do'] = 'Plant_do/print_plant_do';
$route['print_distributor_do'] = 'Delivery_order/print_distributor_do';
$route['product_wise_pending_do'] = 'Delivery_order/product_wise_pending_do';
$route['print_product_wise_pending_do'] = 'Delivery_order/print_product_wise_pending_do';
$route['print_distributor_ob_list'] = 'Distributor_ob/print_distributor_ob_list';
$route['print_unit_ob_list'] = 'Plant_ob/print_unit_ob_list';
$route['distributor_ledger'] = 'Distributor_r/distributor_ledger';
$route['print_distributor_ledger'] = 'Distributor_r/print_distributor_ledger';

//distributor wise daily sales report
$route['distributor_daily_sales_report']='Sales/distributor_daily_sales_report';
$route['distributor_daily_sales_report_print']='Sales/distributor_daily_sales_report_print';

//distributor wise daily sales report
$route['distributor_monthly_sales_report']='Sales/distributor_monthly_sales_report';
$route['distributor_monthly_sales_report_print']='Sales/distributor_monthly_sales_report_print';


// OPS Date Wise Daily Reports 
// Created by Maruthi on 11th Mar'17
$route['dw_oil_report_search'] = 'Datewise_daily_reports/dw_oil_report_search';
$route['dw_daily_oil_report'] = 'Datewise_daily_reports/dw_daily_oil_report';
$route['dw_daily_stock_report_search'] = 'Datewise_daily_reports/dw_daily_stock_report_search';
$route['dw_daily_stock_report'] = 'Datewise_daily_reports/dw_daily_stock_report';
$route['dw_daily_pm_stock_report_search'] = 'Datewise_daily_reports/dw_daily_pm_stock_report_search';
$route['dw_daily_pm_stock_report'] ='Datewise_daily_reports/dw_daily_pm_stock_report';

//executivewise_ob_report
$route['all_executive_pending_ob'] = 'Executivewise_order/all_executive_pending_ob';
$route['all_executive_pending_ob_print'] = 'Executivewise_order/all_executive_pending_ob_print';

//Distributors Bg Reports
//Nagarjuna 20-03-2017 12:45PM
$route['dist_bg_r']='Dist_bg_r/dist_bg_r';
$route['print_dist_bg']='Dist_bg_r/print_dist_bg';

//individual delivery order report (distibutor and unit)---- mastan ----
$route['individual_dist_do'] = 'Individual_do_list/individual_distributor_do';
$route['individual_dist_do_detail'] = 'Individual_do_list/individual_distributor_do_detail';

$route['individual_unit_do'] = 'Individual_do_list/individual_unit_do';
$route['individual_unit_do_detail'] = 'Individual_do_list/individual_unit_do_detail';

//insurance entry & reports ---- mastan
$route['insurance_product'] = 'Insurance_product/insurance_product';
$route['submit_insurance_product'] = 'Insurance_product/submit_insurance_product';
$route['insert_insurance_product'] = 'Insurance_product/insert_insurance_product';
$route['get_oil_weight'] = 'Insurance_product/get_oil_weight';
$route['get_product_price'] = 'Insurance_product/get_product_price';
$route['insurance_report'] = 'Insurance_product/insurance_report';
$route['insurance_report_detail'] = 'Insurance_product/insurance_report_detail';

//stock in transit
$route['stock_in_transit'] = 'Stock_in_transit/stock_in_transit';
$route['stock_in_transit_detail'] = 'Stock_in_transit/stock_in_transit_detail';

//Purchase order all details report
//Mounika
$route['print_loose_oil_report']='Po_reports/print_loose_oil_report';
$route['print_pm_report']='Po_reports/print_pm_report';
$route['print_free_gift_report']='Freegift_po/print_free_gift_report';

$route['product_wise_daily_dispatches'] = 'Dispatches_report/stock_dispatch_report';
$route['product_wise_daily_dispatches_detail'] = 'Dispatches_report/stock_dispatch_detail';

// maruthi on 8th april 
$route['dist_penalty'] = 'Cron/dist_penalty';
// Penalty Report 
$route['penalty_report'] = 'Penalty_reports/penalty_report';
$route['consolidated_penalty_report'] = 'Penalty_reports/consolidated_penalty_report';

//lose in transit report
$route['lit_report'] = 'Lit_report/lit_report';
$route['lit_perticulars'] = 'Lit_report/lit_perticulars';

//consolidated sales
$route['consolidated_sales_view'] = 'Consolidated_sales/consolidated_sales_view';
$route['print_consolidated_sales'] = 'Consolidated_sales/print_consolidated_sales';

//consolidated closing stock
$route['print_consolidated_closing_stock'] = 'Consolidated_sales/print_consolidated_closing_stock';

//executivewise_ob_report
$route['all_executive_pending_do'] = 'Executivewise_order/all_executive_pending_do';
$route['all_executive_pending_do_print'] = 'Executivewise_order/all_executive_pending_do_print';

$route['print_available_product_stock'] = 'Stock/print_available_product_stock';
// stock point monthly report
$route['monthly_godown_stock_report'] = 'Stock_point_product_report/monthly_godown_stock_report';
$route['print_monthly_stock_report'] = 'Stock_point_product_report/print_monthly_stock_report';

//consolidated sales
$route['consolidated_executive_sales_view'] = 'Consolidated_sales/consolidated_executive_sales_view';
$route['print_consolidated_executive_sales'] = 'Consolidated_sales/print_consolidated_executive_sales';

//for purpose of md daily sales report
$route['daily_sales_report_md']='Sales/daily_sales_report_md';
$route['daily_sales_report_md_print']='Sales/daily_sales_report_md_print';

//unit wise yearly product wise sale report
$route['yearly_unit_product_report']='Sales/yearly_unit_product_report';
$route['yearly_unit_product_report_print']='Sales/yearly_unit_product_report_print';

$route['product_wise_pending_ob']='Executivewise_order/product_wise_pending_ob';
$route['print_product_wise_pending_ob']='Executivewise_order/print_product_wise_pending_ob';

//Lab test report for OIl
//Mounika
$route['print_lab_test_oil']='Lab_test_r/print_lab_test_oil';
//Lab test report for Packing Material
//Mounika
$route['print_lab_test_pm']='Lab_test_r/print_lab_test_pm';

//Stock Point Leakage Reports
//Mounika
$route['print_ops_leakage']='Ops_leakage_r/print_ops_leakage';

//Print Vehicle Details
//Mounika
$route['print_vehicle_details']='Tanker_registration/print_vehicle_details';

//stock_transfer
$route['stock_transfer_view'] = 'Dispatches_report/stock_transfer_view';
$route['stock_transfer_print'] = 'Dispatches_report/stock_transfer_print';

//all_executive_sales_report
$route['all_executive_sales_view'] = 'Executivewise_order/all_executive_sales_view';
$route['all_executive_sales_print'] = 'Executivewise_order/all_executive_sales_print';

// OPS Consumption Reports
// Created By Maruthi on 22nd April 5PM
$route['production_consumption'] = 'Consumption/production_consumption';
$route['print_production_consumption'] = 'Consumption/print_production_consumption';
$route['leakage_consumption'] = 'Consumption/leakage_consumption';
$route['print_leakage_consumption'] = 'Consumption/print_leakage_consumption';

//mahesh 24 apr 2017
$route['print_dist_invoice_list'] = 'Distributor_invoice/print_dist_invoice_list';
$route['print_plant_invoice_list'] = 'Plant_invoice/print_plant_invoice_list';
$route['print_mrr_oil_list'] = 'Loose_oil_mrr/print_mrr_oil_list';
$route['print_mrr_pm_list'] = 'pm_mrr/print_mrr_pm_list';
$route['print_mrr_fg_list'] = 'Free_gift_mrr/print_mrr_fg_list';
$route['dealerwise_penalty_report'] = 'Penalty_reports/dealerwise_penalty_report';

//download executives sales report
$route['all_executive_sales_download'] = 'Executivewise_order/all_executive_sales_download';

//Unit insurance report
$route['plant_insurance_product'] = 'Insurance_product/plant_insurance_product';
$route['submit_insurance_product_plant'] = 'Insurance_product/submit_insurance_product_plant';


//individual insurance invoice report for distributor
$route['individual_insurance_invoice']='Insurance_product/individual_insurance_invoice';
$route['individual_insurance_invoice_report']='Insurance_product/individual_insurance_invoice_report';

//individual insurance invoice report for plant
$route['individual_insurance_invoice_plant']='Insurance_product/individual_insurance_invoice_plant';
$route['plant_individual_insurance_invoice_report']='Insurance_product/plant_individual_insurance_invoice_report';

/*Roll Back DD 
Author:Srilekha
Time: 02.16PM 03-04-2017 
DD Distributor Change */
$route['distributor_dd']='Rollback_dd/distributor_dd';
$route['rollback_dd_list']='Rollback_dd/rollback_dd_list';
$route['insert_rollback_dd_list']='Rollback_dd/insert_rollback_dd_list';
//DD Amount change
$route['dd_amount']='Rollback_dd/dd_amount';
$route['rollback_dd_amount']='Rollback_dd/rollback_dd_amount';
$route['insert_rollback_dd_amount']='Rollback_dd/insert_rollback_dd_amount';
//DD Type Change
$route['dd_type']='Rollback_dd/dd_type';
$route['rollback_dd_type']='Rollback_dd/rollback_dd_type';
$route['insert_rollback_dd_type']='Rollback_dd/insert_rollback_dd_type';
//Roll back Management
//Mounika
//DD payment date change
$route['dd_date_change']='Rollback_dd/dd_date_change';
$route['dd_date_change_details']='Rollback_dd/dd_date_change_details';
$route['insert_rollback_dd_date']='Rollback_dd/insert_rollback_dd_date';
//DD number change
$route['dd_number_change']='Rollback_dd/dd_number_change';
$route['dd_number_change_details']='Rollback_dd/dd_number_change_details';
$route['insert_rollback_dd_number']='Rollback_dd/insert_rollback_dd_number';
//DD bank change
$route['dd_bank_change']='Rollback_dd/dd_bank_change';
$route['dd_bank_change_details']='Rollback_dd/dd_bank_change_details';
$route['insert_rollback_dd_bank']='Rollback_dd/insert_rollback_dd_bank';
//DD Distributor Delete
$route['distributor_delete_dd']='Rollback_dd/distributor_delete_dd';
$route['rollback_dd_delete_list']='Rollback_dd/rollback_dd_delete_list';
$route['insert_rollback_dd_delete']='Rollback_dd/insert_rollback_dd_delete';



//Do Unit Change
$route['do_unit_change']='Rollback_do/do_unit_change';
$route['do_unit_details_change']='Rollback_do/do_unit_details_change';
$route['insert_do_unit_change']='Rollback_do/insert_do_unit_change';
//DO Delete
// Modified by Maruthi on 3rd May'17 4:30 PM
$route['do_delete']='Rollback_do/do_delete';
$route['do_delete_details']='Rollback_do/do_delete_details';
$route['delete_rb_do'] = 'Rollback_do/delete_rb_do';
//DO Delete Items
$route['do_delete_items']='Rollback_do/do_delete_items';
$route['do_delete_items_details']='Rollback_do/do_delete_items_details';
$route['delete_rb_do_items'] = 'Rollback_do/delete_rb_do_items';
//DO Reduce Stock
$route['do_reduce_stock']='Rollback_do/do_reduce_stock';
$route['do_reduce_stock_details']='Rollback_do/do_reduce_stock_details';
$route['reduce_rb_do_stock']='Rollback_do/reduce_rb_do_stock';



/*gowri
invoice date change*/
$route['date_change']='Rollback_invoice/date_change';
$route['date_change_details']='Rollback_invoice/date_change_details';
$route['insert_rollback_date']='Rollback_invoice/insert_rollback_date';
// Delete Invoice
//Srilekha
$route['delete_invoice']='Rollback_invoice/delete_invoice';
$route['rollback_invoice_delete']='Rollback_invoice/rollback_invoice_delete';
$route['delete_invoice_details'] = 'Rollback_invoice/delete_invoice_details';
//Delete Invoice Products
//Srilekha
$route['invoice_product_delete']='Rollback_invoice/invoice_product_delete';
$route['rollback_invoice_product_delete']='Rollback_invoice/rollback_invoice_product_delete';
$route['delete_invoice_product'] = 'Rollback_invoice/delete_invoice_product';



//rollback lab tests ------- mastan --------
$route['rollback_oil_test'] = 'Rollback_lab_test/rollback_oil_test';
$route['get_oil_test_result'] = 'Rollback_lab_test/get_oil_test_result';
$route['update_oil_test_status'] = 'Rollback_lab_test/update_oil_test_status';

$route['rollback_pm_test'] = 'Rollback_lab_test/rollback_pm_test';
$route['get_pm_test_result'] = 'Rollback_lab_test/get_pm_test_result';
$route['update_pm_test_status'] = 'Rollback_lab_test/update_pm_test_status';


//MRR Free Gift Date Change
$route['mrr_fg_date_change']='Rollback_mrr/mrr_fg_date_change';
$route['mrr_fg_date_details']='Rollback_mrr/mrr_fg_date_details';
$route['insert_mrr_fg_date']='Rollback_mrr/insert_mrr_fg_date';
//MRR FG Delete Entry
$route['mrr_fg_delete_entry']='Rollback_mrr/mrr_fg_delete_entry';
$route['mrr_fg_delete_entry_details']='Rollback_mrr/mrr_fg_delete_entry_details';



/*Rollback OB
Author:Srilekha
Distributor Change*/
$route['ob_distributor']='Rollback_ob/ob_distributor';
$route['rollback_ob_distributor']='Rollback_ob/rollback_ob_distributor';
$route['insert_rollback_ob_distributor']='Rollback_ob/insert_rollback_ob_distributor';
//Rollback OB Stocks Change
// Modified By maruthi on 12th may 6:PM
$route['ob_stocks']='Rollback_ob/ob_stocks';
$route['rollback_ob_stocks']='Rollback_ob/rollback_ob_stocks';
$route['insert_rollback_ob_stocks'] = 'Rollback_ob/insert_rollback_ob_stocks';
//Activate OB
$route['ob_activate']='Rollback_ob/ob_activate';
$route['rollback_ob_activate']='Rollback_ob/rollback_ob_activate';
$route['insert_rollback_ob_activate']='Rollback_ob/insert_rollback_ob_activate';
//Activate Product In OB
$route['ob_product_activate']='Rollback_ob/ob_product_activate';
$route['rollback_ob_product_activate']='Rollback_ob/rollback_ob_product_activate';
$route['insert_rollback_product_ob_activate']='Rollback_ob/insert_rollback_product_ob_activate';
//Delete Product In OB
$route['ob_product_delete']='Rollback_ob/ob_product_delete';
$route['rollback_ob_product_delete']='Rollback_ob/rollback_ob_product_delete';
$route['change_rollback_ob_product_delete']='Rollback_ob/change_rollback_ob_product_delete';


//Purchase order for Free Gifts
//PO FG Date change
$route['po_fg_date_change']='Rollback_po_fg/po_fg_date_change';
$route['po_fg_date_details_change']='Rollback_po_fg/po_fg_date_details_change';
$route['insert_po_fg_date_change']='Rollback_po_fg/insert_po_fg_date_change';
//PO FG Quantity Change
$route['po_fg_quantity_change']='Rollback_po_fg/po_fg_quantity_change';
$route['po_fg_quantity_details_change']='Rollback_po_fg/po_fg_quantity_details_change';
$route['insert_po_fg_quantity_change']='Rollback_po_fg/insert_po_fg_quantity_change';
//PO FG Product Change
$route['po_fg_product_change']='Rollback_po_fg/po_fg_product_change';
$route['po_fg_product_details_change']='Rollback_po_fg/po_fg_product_details_change';
$route['insert_po_fg_product_change']='Rollback_po_fg/insert_po_fg_product_change';
//PO FG Rate Change
$route['po_fg_rate_change']='Rollback_po_fg/po_fg_rate_change';
$route['po_fg_rate_details_change']='Rollback_po_fg/po_fg_rate_details_change';
$route['insert_po_fg_rate_change']='Rollback_po_fg/insert_po_fg_rate_change';
//PO FG Supplier Change
$route['po_fg_supplier_change']='Rollback_po_fg/po_fg_supplier_change';
$route['po_fg_supplier_details_change']='Rollback_po_fg/po_fg_supplier_details_change';
$route['insert_po_fg_supplier_change']='Rollback_po_fg/insert_po_fg_supplier_change';
//PO FG Delete
$route['po_delete_fg']='Rollback_po_fg/po_delete_fg';
$route['po_delete_fg_details']='Rollback_po_fg/po_delete_fg_details';
$route['update_po_pm_delete_fg']='Rollback_po_fg/update_po_pm_delete_fg';


/*Rollback For PO Oils
Author:Srilekha
PO OIL Date Change*/
$route['po_oil_date']='Rollback_po_oil/po_oil_date';
$route['rollback_po_oil_date']='Rollback_po_oil/rollback_po_oil_date';
$route['insert_rollback_po_oil_date']='Rollback_po_oil/insert_rollback_po_oil_date';
//PO Oil Quantity Change
$route['po_oil_quantity']='Rollback_po_oil/po_oil_quantity';
$route['rollback_po_oil_quantity']='Rollback_po_oil/rollback_po_oil_quantity';
$route['insert_rollback_po_oil_quantity']='Rollback_po_oil/insert_rollback_po_oil_quantity';
//PO Oil Price change
$route['po_oil_price']='Rollback_po_oil/po_oil_price';
$route['rollback_po_oil_price']='Rollback_po_oil/rollback_po_oil_price';
$route['insert_rollback_po_oil_price']='Rollback_po_oil/insert_rollback_po_oil_price';
//Po Oil Product Change
$route['po_oil_product']='Rollback_po_oil/po_oil_product';
$route['rollback_po_oil_product']='Rollback_po_oil/rollback_po_oil_product';
$route['insert_rollback_po_oil_product']='Rollback_po_oil/insert_rollback_po_oil_product';
//PO Oil Supplier Change
$route['po_oil_supplier']='Rollback_po_oil/po_oil_supplier';
$route['rollback_po_oil_supplier']='Rollback_po_oil/rollback_po_oil_supplier';
$route['insert_rollback_po_oil_supplier']='Rollback_po_oil/insert_rollback_po_oil_supplier';
//PO Oil Broker Change
$route['po_oil_broker']='Rollback_po_oil/po_oil_broker';
$route['rollback_po_oil_broker']='Rollback_po_oil/rollback_po_oil_broker';
$route['insert_rollback_po_oil_broker']='Rollback_po_oil/insert_rollback_po_oil_broker';
//PO OIL Block Change
$route['po_oil_block']='Rollback_po_oil/po_oil_block';
$route['rollback_po_oil_block']='Rollback_po_oil/rollback_po_oil_block';
$route['insert_rollback_po_oil_block']='Rollback_po_oil/insert_rollback_po_oil_block';
//PO OIL Delete
$route['po_oil_delete']='Rollback_po_oil/po_oil_delete';
$route['rollback_po_oil_delete']='Rollback_po_oil/rollback_po_oil_delete';
$route['insert_rollback_po_oil_delete']='Rollback_po_oil/insert_rollback_po_oil_delete';


//Purchase order for Packing Material
//PO PM Date change
$route['po_pm_date_change']='Rollback_po_pm/po_pm_date_change';
$route['po_pm_date_details_change']='Rollback_po_pm/po_pm_date_details_change';
$route['insert_po_pm_date_change']='Rollback_po_pm/insert_po_pm_date_change';
//PO PM Quantity Change
$route['po_pm_quantity_change']='Rollback_po_pm/po_pm_quantity_change';
$route['po_pm_quantity_details_change']='Rollback_po_pm/po_pm_quantity_details_change';
$route['insert_po_pm_quantity_change']='Rollback_po_pm/insert_po_pm_quantity_change';
//PO PM Product Change
$route['po_pm_product_change']='Rollback_po_pm/po_pm_product_change';
$route['po_pm_product_details_change']='Rollback_po_pm/po_pm_product_details_change';
$route['insert_po_pm_product_change']='Rollback_po_pm/insert_po_pm_product_change';
//PO PM Rate Change
$route['po_pm_rate_change']='Rollback_po_pm/po_pm_rate_change';
$route['po_pm_rate_details_change']='Rollback_po_pm/po_pm_rate_details_change';
$route['insert_po_pm_rate_change']='Rollback_po_pm/insert_po_pm_rate_change';
//PO PM OPS Change
$route['po_pm_ops_change']='Rollback_po_pm/po_pm_ops_change';
$route['po_pm_ops_details_change']='Rollback_po_pm/po_pm_ops_details_change';
$route['insert_po_pm_ops_change']='Rollback_po_pm/insert_po_pm_ops_change';
//PO PM Supplier Change
$route['po_pm_supplier_change']='Rollback_po_pm/po_pm_supplier_change';
$route['po_pm_supplier_details_change']='Rollback_po_pm/po_pm_supplier_details_change';
$route['insert_po_pm_supplier_change']='Rollback_po_pm/insert_po_pm_supplier_change';
//PO PM Delete
$route['po_delete_pm']='Rollback_po_pm/po_delete_pm';
$route['po_delete_pm_details']='Rollback_po_pm/po_delete_pm_details';
$route['update_po_pm_delete']='Rollback_po_pm/update_po_pm_delete';

//rollback production -roopa-4/4/2017.
$route['change_production_date'] ='Rollback_production/change_production_date';
$route['production_details'] ='Rollback_production/production_details';
$route['update_production_date'] ='Rollback_production/update_production_date';
//rollback Production 
//Srilekha 
//Production Delete
$route['delete_production'] ='Rollback_production/delete_production';
$route['rollback_delete_production'] ='Rollback_production/rollback_delete_production';


//Stock Updation for Stock Adding
$route['stock_add']='Rollback_stock_updation/stock_add';
$route['add_stock_updation'] = 'Rollback_stock_updation/add_stock_updation';
$route['get_product_stock_details'] = 'Rollback_stock_updation/get_product_stock_details';

$route['stock_reduce']='Rollback_stock_updation/stock_reduce';
$route['reduce_stock_updation'] = 'Rollback_stock_updation/reduce_stock_updation';


//Rollback Tanker Register
//Srilekha
$route['delete_tanker']='Rollback_tanker/delete_tanker';
$route['rollback_tanker_register']='Rollback_tanker/rollback_tanker_register';
$route['insert_rollback_tanker_register']='Rollback_tanker/insert_rollback_tanker_register';

//Daily Correction Report
//Aswini
$route['daily_correction_report_search']='Daily_correction_report/daily_correction_report_search';
$route['daily_correction_report']='Daily_correction_report/daily_correction_report';

//Mounika
//MRR OIL Date Change
$route['mrr_date_change']='Rollback_mrr/mrr_date_change';
$route['mrr_date_details']='Rollback_mrr/mrr_date_details';
$route['insert_mrr_date']='Rollback_mrr/insert_mrr_date';
//MRR OIL Delete Entry
$route['mrr_delete_entry']='Rollback_mrr/mrr_delete_entry';
$route['mrr_delete_entry_details']='Rollback_mrr/mrr_delete_entry_details';
$route['update_mrr_oil_delete_details']='Rollback_mrr/update_mrr_oil_delete_details';
//MRR PM Date Change
$route['mrr_pm_date_change']='Rollback_mrr/mrr_pm_date_change';
$route['mrr_pm_date_details']='Rollback_mrr/mrr_pm_date_details';
$route['insert_mrr_pm_date']='Rollback_mrr/insert_mrr_pm_date';
//MRR PM Delete Entry
$route['mrr_pm_delete_entry']='Rollback_mrr/mrr_pm_delete_entry';
$route['mrr_pm_delete_entry_details']='Rollback_mrr/mrr_pm_delete_entry_details';
$route['update_mrr_pm_delete_details']='Rollback_mrr/update_mrr_pm_delete_details';

//MRR Free Gift Date Change
$route['mrr_fg_date_change']='Rollback_mrr/mrr_fg_date_change';
$route['mrr_fg_date_details']='Rollback_mrr/mrr_fg_date_details';
$route['insert_mrr_fg_date']='Rollback_mrr/insert_mrr_fg_date';
//MRR FG Delete Entry
$route['mrr_fg_delete_entry']='Rollback_mrr/mrr_fg_delete_entry';
$route['mrr_fg_delete_entry_details']='Rollback_mrr/mrr_fg_delete_entry_details';
$route['update_mrr_fg_delete_details']='Rollback_mrr/update_mrr_fg_delete_details';

//for Distributor Logins
$route['view_product_price_report_distributor/(:any)']='Distributor_login_reports/view_product_price_report_distributor/$1';

$route['login_distributor_ob_list']='Distributor_login_reports/login_distributor_ob_list';
$route['login_dist_ob_print']='Distributor_login_reports/login_dist_ob_print';

$route['login_distributor_do_list']='Distributor_login_reports/login_distributor_do_list';
$route['login_dist_do_print']='Distributor_login_reports/login_dist_do_print';

//distributor bank guarantee renewal
$route['distributor_bg_renewal']='Distributor/distributor_bg_renewal';
$route['view_distributor_bg_renewal']='Distributor/view_distributor_bg_renewal';
$route['insert_distributor_bg_renewal']='Distributor/insert_distributor_bg_renewal';

// Mounika
//Distributor Dashboard bg,agreement prints
$route['bg_expired_print']='Distributor/bg_expired_print';
$route['agreement_expired_print']='Distributor/agreement_expired_print';
$route['bg_going_expired_print']='Distributor/bg_going_expired_print';
$route['agreement_going_expired_print']='Distributor/agreement_going_expired_print';
$route['executive_print']='Executive/executive_print';

//user manuals..Roopa
$route['user_manuals'] = 'User_manuals/user_manuals';

//srilekha - Rollback Designation
$route['reportee_designation']	='Rollback_designation/reportee_designation';
$route['reportee_designation/(:any)']	='Rollback_designation/reportee_designation/$1';
$route['add_reportee_designation']='Rollback_designation/add_reportee_designation';
$route['insert_reportee_designation']='Rollback_designation/insert_reportee_designation';
$route['edit_reportee_designation/(:any)/(:any)']='Rollback_designation/edit_reportee_designation/$1/$2';
$route['update_reportee_designation']='Rollback_designation/update_reportee_designation';
$route['download_reportee_designation'] = 'Rollback_designation/download_reportee_designation';

// Koushik - reporting_preference
$route['reporting_preference'] = 'Reporting_preference/reporting_preference';
$route['reporting_preference/(:any)'] = 'Reporting_preference/reporting_preference/$1';
$route['add_reporting_preference'] = 'Reporting_preference/add_reporting_preference';
$route['insert_reporting_preference'] = 'Reporting_preference/insert_reporting_preference';
$route['edit_reporting_preference/(:any)'] = 'Reporting_preference/edit_reporting_preference/$1';
$route['update_reporting_preference'] = 'Reporting_preference/update_reporting_preference';
$route['get_table_column'] = 'Reporting_preference/get_table_column';
$route['get_table_primary_column'] = 'Reporting_preference/get_table_primary_column';

//koushik- Rollback Settings
$route['rollback_settings'] = 'Reporting_preference/rollback_settings';
$route['update_rollback_settings'] = 'Reporting_preference/update_rollback_settings';

// Koushik - Approval List
$route['approval_list'] = 'Approval_list/approval_list';
$route['approval_list/(:any)'] = 'Approval_list/approval_list/$1';
$route['view_approval_information/(:any)'] = 'Approval_list/view_approval_information/$1';
$route['update_approval_information'] = 'Approval_list/update_approval_information';

//Edit Tanker Details
//Mounika
$route['edit_tanker_details']='Tanker_register/edit_tanker_details';
$route['edit_tanker_details_view']='Tanker_register/edit_tanker_details_view';
//Update Tanker Details
//Mounika
$route['update_tanker_registration_details']='Tanker_register/update_tanker_registration_details';
$route['update_pm_registration_details']='Tanker_register/update_pm_registration_details';
$route['update_empty_truck_registration_details']='Tanker_register/update_empty_truck_registration_details';
$route['update_freegift_tanker_details']='Tanker_register/update_freegift_tanker_details';
// Prasad 29 Apr 2017 05:33 PM
$route['commission_report']='Po_reports/commission_report';
$route['print_commission_report']='Po_reports/print_commission_report';
$route['pm_commission_report']='Po_reports/pm_commission_report';
$route['print_pm_commission_report']='Po_reports/print_pm_commission_report';
$route['consolidated_leakage_report']='Ops_leakage_r/consolidated_leakage_report';
$route['print_consolidated_leakage_report']='Ops_leakage_r/print_consolidated_leakage_report';
/** MOUNIKA 30 APR 2017 GATE PASS DELETE  **/
$route['gate_pass_delete']='Gate_pass/gate_pass_delete';
$route['gate_pass_delete_details']='Gate_pass/gate_pass_delete_details';
$route['delete_gp_delete']='Gate_pass/delete_gp_delete';

$route['delete_rb_production'] = 'Rollback_production/delete_rb_production';
$route['delete_rb_do'] = 'Rollback_do/delete_rb_do';

$route['consolidated_insurance_sales']='Insurance_product/consolidated_insurance_sales';
$route['print_consolidated_insurance_sales']='Insurance_product/print_consolidated_insurance_sales';

//md monthly sales report
$route['monthly_sales_report_md']='Sales/monthly_sales_report_md';
$route['monthly_sales_report_md_print']='Sales/monthly_sales_report_md_print';

$route['get_institutions'] = 'Delivery_order/get_institutions';

// NEW REQUESTS 19-05-2017
$route['tally_report']='Tally/tally_report';
$route['tally_report_print']='Tally/tally_report_print';
$route['coupon']='Coupon/coupon';
$route['coupon/(:any)']='Coupon/coupon/$1';
$route['add_coupon']='Coupon/add_coupon';
$route['insert_coupon']='Coupon/insert_coupon';
$route['edit_coupon/(:any)'] = 'Coupon/edit_coupon/$1';
$route['update_coupon'] = 'Coupon/update_coupon';
$route['deactivate_coupon/(:any)'] = 'Coupon/deactivate_coupon/$1';
$route['activate_coupon/(:any)'] = 'Coupon/activate_coupon/$1';
$route['download_coupon'] = 'Coupon/download_coupon';

$route['invoice_coupon_report']='Coupon/invoice_coupon_report';
$route['invoice_coupon_report_print']='Coupon/invoice_coupon_report_print';
$route['consolidated_insurance_sales_declaration']='Insurance_product/consolidated_insurance_sales_declaration';
$route['print_consolidated_insurance_sales_declaration']='Insurance_product/print_consolidated_insurance_sales_declaration';

//monthly product wise insurance declaration report
$route['monthly_product_ins_dec']='Insurance_product/monthly_product_ins_dec';
$route['monthly_product_ins_dec_print']='Insurance_product/monthly_product_ins_dec_print';

//Delete OB
$route['ob_delete']='Rollback_ob/ob_delete';
$route['rollback_ob_delete']='Rollback_ob/rollback_ob_delete';
$route['insert_rb_ob_delete']='Rollback_ob/insert_rb_ob_delete';

//Monthly executive sales report
$route['executive_wise_invoice_sales_report']='Sales/executive_wise_invoice_sales_report';
$route['executive_wise_invoice_sales_report_print']='Sales/executive_wise_invoice_sales_report_print';

$route['distributor_sales_report']='Sales/distributor_sales_report';
$route['distributor_sales_report_print']='Sales/distributor_sales_report_print';

//Region wise distributor report(24th may 2017)
$route['region_wise_distributor_r'] = 'Regionwise_distributor_r/region_wise_distributor_r';
$route['region_wise_distributor_r/(:any)'] = 'Regionwise_distributor_r/region_wise_distributor_r/$1';
$route['get_district_based_region'] = 'Regionwise_distributor_r/get_district_based_region';
$route['download_region_wise_distributor_r'] = 'Regionwise_distributor_r/download_region_wise_distributor_r';

//OPS processing loss - Masthan
$route['processing_loss'] = 'Processing_loss/processing_loss';
$route['processing_loss/(:any)'] = 'Processing_loss/processing_loss/$1';
$route['add_processing_loss'] = 'Processing_loss/add_processing_loss';
$route['insert_processing_loss'] = 'Processing_loss/insert_processing_loss';
// report for ops processing loss  --- mastan(31-05-2017)
$route['processing_loss_report'] = 'Processing_loss/processing_loss_report';
$route['print_processing_loss'] = 'Processing_loss/print_processing_loss';