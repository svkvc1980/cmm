<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 15th Nov 2016 09:00 AM

class Mmtc extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Mmtc_m");
        $this->load->model("Common_model");
	}


	public function mmtc_bulkreceipt()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="MMTC Bulk Receipt";
		$data['nestedView']['pageTitle'] = 'MMTC Bulk Receipt';
        $data['nestedView']['cur_page'] = 'mmtcc';
        $data['nestedView']['parent_page'] = 'mmtc';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/mmtc_bulkreceipt.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MMTC Bulk Receipt', 'class' => '', 'url' => '');	
    
        $this->load->view('mmtc/mmtc_bulkreceipt_view',$data);

    }
    public function add_rec_oil()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Received Oil From BulkStorage";  
        $data['nestedView']['pageTitle'] = 'Received Oil From BulkStorage';
        $data['nestedView']['cur_page'] = 'add_rec_oil';
        $data['nestedView']['parent_page'] = 'mmtc';
     

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/rec_oil_from_bulkmarket.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Received Oil', 'class' => '', 'url' => SITE_URL.'add_rec_oil');  
       $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New Received Oil', 'class' => 'active', 'url' => '');
        $data['loose_oil_product'] = array('' =>'Select product')+$this->Common_model->get_dropdown('loose_oil_product','loose_oil_product_id','loose_oil_product_name');
        
        # Data
        
        # Additional data
        $data['flg'] = 1;
        $data['#'] = SITE_URL.'#';
        //$data['display_results'] = 0;
        $this->load->view('mmtc/received_oil_view',$data);
    }
    public function mmtc_do()
    {
        # Data Array to carry the require fields tosample View and Model
        $data['nestedView']['heading']="DELIVERY ORDER FROM MMTC ";  
        $data['nestedView']['pageTitle'] = 'DELIVERY ORDER FROM MMTC ';
        $data['nestedView']['cur_page'] = 'mmtc_do';
        $data['nestedView']['parent_page'] = 'mmtc';
     

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/mmtc.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'DELIVERY ORDER FROM MMTC', 'class' => '', 'url' => SITE_URL.'mmtc_do');  
       $data['nestedView']['breadCrumbOptions'][] = array('label' => 'DELIVERY ORDER FROM MMTC', 'class' => 'active', 'url' => '');
        
        # Data
        //$data['product']=$this->free_sample_m->get_product();  

        
        # Additional data
        $data['flg'] = 1;
        $data['#'] = SITE_URL.'insert_mmtc_do';
        $data['display_results'] = 0;
        $this->load->view('mmtc/mmtc_do_view',$data);


    }

        /*Adding Civil Suppliers Invoice details
    Author:Srilekha
    Time: 11.33AM 02-02-2017 */
    public function civil_supplies_invoice()
    {
	# Data Array to carry the require fields to View and Model
	$data['nestedView']['heading']="Civil Suppliers Invoice";
	$data['nestedView']['cur_page'] = 'civil_suppliers_invoice';
	$data['nestedView']['pageTitle'] = 'Civil Suppliers Invoice';
	$data['nestedView']['parent_page'] = 'mmtc';
	
	# Load JS and CSS Files
	$data['nestedView']['js_includes'] = array();
	$data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/mmtc.js" type="text/javascript"></script>';
	$data['nestedView']['css_includes'] = array();
	
	# Breadcrumbs
	$data['nestedView']['pageTitle'] = 'Civil Suppliers Invoice';
	$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
	$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Civil Suppliers Invoice','class'=>'active','url'=>'');
	
	# Additional data
	$data['state']= $this->Common_model->get_data('location',array('territory_level_id'=>2,'status'=>1));
	$data['flg'] = 1;
	$data['form_action'] = SITE_URL.'civil_suppliers_invoice';
	$data['display_results'] = 0;
	$data['distributor_type'] = $this->Common_model->get_data('sub_type',array('status'=>1));
	$data['bank_type'] = $this->Common_model->get_data('bank',array('status'=>1));
	
	$this->load->view('mmtc/civil_suppliers_invoice_view',$data);
    }
    /*Adding Civil Suppliers Invoice details
    Author:Srilekha
    Time: 11.33AM 02-02-2017 */
    public function daily_production()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Daily Production";
        $data['nestedView']['cur_page'] = 'daily_production';
        $data['nestedView']['pageTitle'] = 'Daily Production';
        $data['nestedView']['parent_page'] = 'mmtc';


        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/distributor.js" type="text/javascript"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['pageTitle'] = 'Daily Production';
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Daily Production','class'=>'active','url'=>'');



        # Additional data
        $data['state']= $this->Common_model->get_data('location',array('territory_level_id'=>2,'status'=>1));
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'civil_suppliers_invoice';
        $data['display_results'] = 0;
        $data['distributor_type'] = $this->Common_model->get_data('sub_type',array('status'=>1));
        $data['bank_type'] = $this->Common_model->get_data('bank',array('status'=>1));
        
        $this->load->view('mmtc/daily_production_view',$data);
    }

    public function orderbooking()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Order Booking";
        $data['nestedView']['pageTitle'] = 'orderbooking';
        $data['nestedView']['cur_page'] = 'orderbooking';
        $data['nestedView']['parent_page'] = 'mmtc';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
         $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/orderbooking.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Order Booking', 'class' => '', 'url' => ''); 
        // $data['product']=$this->Mmtc_m->get_product();

        $this->load->view('mmtc/orderbooking_view',$data);

    }
    public function mmtc_module()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="MMTC";
        $data['nestedView']['pageTitle'] = 'MMTC';
        $data['nestedView']['cur_page'] = 'mmtc_module';
        $data['nestedView']['parent_page'] = 'mmtc';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Mmtc', 'class' => 'active', 'url' => 'mmtc_module');
        
        //$data['Agency Name'] = array(''=>'Select Agency Name')+$this->Common_model->get_dropdown('agency','agency_id','agency_name');
        //$data['Stock Lifting Unit'] = array(''=>'Select Unit Code')+$this->Common_model->get_dropdown('unit','unit_id','unit_name');
        

        $this->load->view('mmtc/mmtc_module',$data);
    }
    


}