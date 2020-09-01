<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 15th Nov 2016 09:00 AM

class Rec_loose_oil extends Base_controller 
{

	public function __construct() 
	{
    	parent::__construct();
      // $this->load->model("counter_leakage_m");
	}
    public function add_rec_loose_oil()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Received LooseOil From BulkMarket";  
        $data['nestedView']['pageTitle'] = 'Received LooseOil';
        $data['nestedView']['cur_page'] = 'receive_loose_oil';
        $data['nestedView']['parent_page'] = 'loose_oil_exchange';
     

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/rec_loose_oil.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage counter leakage', 'class' => '', 'url' => SITE_URL.'add_counter_leakage');  
       $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New counter leakage', 'class' => 'active', 'url' => '');
        $data['loose_oil_product'] = array('' =>'Select product')+$this->Common_model->get_dropdown('loose_oil_product','loose_oil_product_id','loose_oil_product_name');
        
        # Data
        
        # Additional data
        $data['flg'] = 1;
        $data['#'] = SITE_URL.'#';
        $data['display_results'] = 0;
        $this->load->view('rec_loose_oil_view',$data);
    }   
}