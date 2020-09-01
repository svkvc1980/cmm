<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

class Stock_point extends Base_controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->model("Stock_point_model");
		$this->load->model("Common_model");
	}

	public function loose_oil_recovery()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Loose Oil Recovery";
		$data['nestedView']['cur_page'] = 'loose_oil_recovery';
		$data['nestedView']['parent_page'] = 'loose_oil_recovery';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Loose Oil Recovery';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Loose Oil Recovery','class'=>'active','url'=>'');

		$data['product'] 		= array(''=>'Select Product')+$this->Common_model->get_dropdown('loose_oil_product','loose_oil_product_id','loose_oil_product_name');
		$data['unit'] 			= array(''=>'Select Unit')+$this->Common_model->get_dropdown('unit','unit_id','unit_name');

		$this->load->view('stock_point/loose_oil_recovery',$data);
	}

	public function stock_returns()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Generation Of Stock Returns";
		$data['nestedView']['cur_page'] = 'stock_returns';
		$data['nestedView']['parent_page'] = 'stock_returns';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Generation Of Stock Returns';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Generation Of Stock Returns','class'=>'active','url'=>'');

		$data['unit'] = array(''=>'Select Unit')+$this->Common_model->get_dropdown('unit','unit_id','unit_name');
		$data['distributor'] 	= array(''=>'Select Distributor')+$this->Common_model->get_dropdown('distributor','distributor_id','distributor_name');

		$this->load->view('stock_point/stock_returns',$data);
	}

	public function add_free_sample()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Free samples";  
        $data['nestedView']['pageTitle'] = 'Free sample';
        $data['nestedView']['cur_page'] = 'add_free_sample';
        $data['nestedView']['parent_page'] = 'Free sample';
     

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/free-sample.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Free samples', 'class' => '', 'url' => SITE_URL.'add_counter_leakage');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New Free sample', 'class' => 'active', 'url' => '');
        
        # Data
        $data['product'] = array(''=>'Select Product')+$this->Common_model->get_dropdown('loose_oil_product','loose_oil_product_id','loose_oil_product_name'); 
 
        # Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_Free_sample';
        $data['display_results'] = 0;
        $this->load->view('stock_point/free_sample_view',$data);
    }

    public function free_compliments()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Free Compliments";
        $data['nestedView']['pageTitle'] = 'FREE COMPLIMENTS';
        $data['nestedView']['cur_page'] = 'free_compliments';
        $data['nestedView']['parent_page'] = 'Free Compliments';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'free compliments', 'class' => 'active', 'url' => 'free compliments');
        
        $data['unit'] = array(''=>'Select Unit Code')+$this->Common_model->get_dropdown('unit','unit_id','unit_name');
        
        $this->load->view('stock_point/free_compliments',$data);
    }

    public function godown_leakage()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Godown leakages";
        $data['nestedView']['pageTitle'] = 'leakages';
        $data['nestedView']['cur_page'] = 'leakages';
        $data['nestedView']['parent_page'] = 'leakages';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/leakages.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Godown leakages', 'class' => '', 'url' => ''); 
        $data['product'] = array(''=>'Select Product')+$this->Common_model->get_dropdown('loose_oil_product','loose_oil_product_id','loose_oil_product_name'); 

        $this->load->view('stock_point/leakages_view',$data);

    }

    public function add_counter_leakage()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add counter leakage";  
        $data['nestedView']['pageTitle'] = 'counter leakage';
        $data['nestedView']['cur_page'] = 'counter_leakage';
        $data['nestedView']['parent_page'] = 'counter leakage';
     

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/counter_leakage.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage counter leakage', 'class' => '', 'url' => SITE_URL.'add_counter_leakage');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New counter leakage', 'class' => 'active', 'url' => '');
        $data['product'] = array('' =>'Select Product')+$this->Common_model->get_dropdown('product','product_id','product_name');
        
        # Data
        
        # Additional data
        $data['flg'] = 1;
        $data['#'] = SITE_URL.'#';
        $data['display_results'] = 0;
        $this->load->view('stock_point/counter_leakage_view',$data);
    }

    public function carry_bag_receipts()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Carry bag receipts";
        $data['nestedView']['pageTitle'] = 'Carry bag receipts';
        $data['nestedView']['cur_page'] = 'carry_bag_receipts';
        $data['nestedView']['parent_page'] = 'carrybag_recepits';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Carry bag receipts', 'class' => '', 'url' => SITE_URL);
      
        # Additional data
        $data['portlet_title'] = 'Purchase Order for Oils';
        $data['form_action'] = SITE_URL.'';
        $data['displayResults'] = 0;
        $this->load->view('stock_point/carry_bag_receipts',$data);
    }

    public function stock_transfer()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Stock Transfer";  
        $data['nestedView']['pageTitle'] = 'Stock Transfer';
        $data['nestedView']['cur_page'] = 'stock_transfer';
        $data['nestedView']['parent_page'] = 'Stock Transfer';
     

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Stock transfer', 'class' => '', 'url' => SITE_URL.'');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Stock Transfer', 'class' => 'active', 'url' => '');
      
        $this->load->view('stock_point/stock_transfer',$data);
    }

    public function stock_dispatch_report()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor Stock Dispatches";  
        $data['nestedView']['pageTitle'] = 'Distributor Stock Dispatches';
        $data['nestedView']['cur_page'] = 'stock_dispatch';
        $data['nestedView']['parent_page'] = 'Stock Dispatch';
     
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home')); 
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor Stock Dispatches', 'class' => 'active', 'url' => '');
	$data['distributor_list'] = $this->Stock_point_model->get_active_distributor();
        $data['plant'] = $this->Stock_point_model->get_plant();
        $this->load->view('stock_point/stock_dispatch_r',$data);
    }

    public function stock_dispatch_detail()
    {
        

        if($this->input->post('submit', TRUE))
        {
            $from_date = date('Y-m-d', strtotime($this->input->post('from_date')));
            $to_date = date('Y-m-d', strtotime($this->input->post('to_date')));
            $plant_id = $this->input->post('plant_id');

            $data['from_date'] = $from_date; $data['to_date'] = $to_date;
            $data['plant_name'] = $this->Common_model->get_data('plant', array('plant_id' => $plant_id),'name');
            $distributor_id = $this->input->post('distributor_id');

            $dispatches = $this->Stock_point_model->get_dispatches_report($from_date, $to_date, $plant_id,$distributor_id);

            $dispatches_report = array();
            foreach($dispatches as $row) 
            {
                $dispatches_report[$row['invoice_id']]['tot_qty'] = $row['quantity'];
                $dispatches_report[$row['invoice_id']]['do_no'] = $row['do_no'];
                $dispatches_report[$row['invoice_id']]['tot_val'] = $row['total'];
            }
            $data['dispatches_report'] = $dispatches_report;

            $data['distributor'] = $this->Stock_point_model->get_invoice_distributor($from_date, $to_date, $plant_id,$distributor_id);
            
            $this->load->view('stock_point/stock_dispatch_detail',$data);
        }
        else
        {
        redirect(SITE_URL.'stock_dispatch_r'); exit;
        }
    }

}