<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

/*
Order Booking List
auther: nagarjuna
created on: 30th mar 2017 1:45pm
*/

class Ob_list extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
    }

	public function single_do_ob_list()
	{
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor Order Booking List";
		$data['nestedView']['pageTitle'] = 'Order Booking List';
        $data['nestedView']['cur_page'] = 'ob_list_view';
        $data['nestedView']['parent_page'] = 'Order Booking List';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Order Booking List', 'class' => '', 'url' => '');	
       $this->load->view('order_booking/ob_list_view',$data);
    }
   
     public function single_plant_ob_list()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Plant Order Booking List";
        $data['nestedView']['pageTitle'] = 'Order Booking List';
        $data['nestedView']['cur_page'] = 'ob_list_view';
        $data['nestedView']['parent_page'] = 'Order Booking List';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Order Booking List', 'class' => '', 'url' => '');    
       $this->load->view('order_booking/plant_ob_list_view',$data);
    }
}