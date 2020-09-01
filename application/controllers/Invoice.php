<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Invoice extends CI_Controller{

	public function __construct() 
    {
        parent::__construct();
        $this->load->model("Common_model");
        

    }

/*Adding General Invoice details
Author:Srilekha
Time: 11.26AM 30-01-2017 */
	public function invoice()
	{
		# Data Array to carry the require fields to View and Model
	    $data['nestedView']['heading']="General Invoice";
	    $data['nestedView']['cur_page'] = 'invoiceGeneration';
	    $data['nestedView']['pageTitle'] = 'General Invoice';
	    $data['nestedView']['parent_page'] = 'invoice_generation';


	    # Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();

		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'General Invoice';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'General Invoice','class'=>'active','url'=>'');



		# Additional data
		$data['state']= $this->Common_model->get_data('location',array('territory_level_id'=>2,'status'=>1));
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'general_invoice';
        $data['display_results'] = 0;
        $data['distributor_type'] = $this->Common_model->get_data('sub_type',array('status'=>1));
    	$data['bank_type'] = $this->Common_model->get_data('bank',array('status'=>1));
    	
        $this->load->view('invoice/invoice_view',$data);
	}
	public function invoice_generation()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Invoice Generation";
		$data['nestedView']['cur_page'] = 'invoiceGeneration';
		$data['nestedView']['parent_page'] = 'invoice_generation';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		//$data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/bootstrap-tabdrop.js" type="text/javascript"></script>';
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Invoice Generation';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Invoice Generation','class'=>'active','url'=>'');

		$this->load->view('invoice/invoice_generation',$data);
	}
/*Adding General Invoice details
Author:Srilekha
Time: 11.26AM 30-01-2017 */
	public function general_invoice()
	{
	# Data Array to carry the require fields to View and Model
	$data['nestedView']['heading']="General Invoice";
	$data['nestedView']['cur_page'] = 'General Invoice';
	$data['nestedView']['pageTitle'] = 'General Invoice';
	$data['nestedView']['parent_page'] = 'master';
	
	# Load JS and CSS Files
	$data['nestedView']['js_includes'] = array();
	$data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/invoice.js" type="text/javascript"></script>';
	$data['nestedView']['css_includes'] = array();
	
	# Breadcrumbs
	$data['nestedView']['pageTitle'] = 'General Invoice';
	$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
	$data['nestedView']['breadCrumbOptions'][] = array('label'=>'General Invoice','class'=>'active','url'=>'');
	
	# Additional data
	$data['state']= $this->Common_model->get_data('location',array('territory_level_id'=>2,'status'=>1));
	$data['flg'] = 1;
	$data['form_action'] = SITE_URL.'general_invoice';
	$data['display_results'] = 0;
	$data['distributor_type'] = $this->Common_model->get_data('sub_type',array('status'=>1));
	$data['bank_type'] = $this->Common_model->get_data('bank',array('status'=>1));
	
	$this->load->view('invoice/general_invoice_view',$data);
	}
}