<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Security extends Base_controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Bank_model");
        $this->load->model("Common_model");               
    }
    public function inward()
    {
    	# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Inward Details";
		$data['nestedView']['pageTitle'] = 'Inward Details';
        $data['nestedView']['cur_page'] = 'inward';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Inward Details', 'class' => '', 'url' => '');
        
        $data['flag']=1;
        $this->load->view('security/inward_details',$data);
    }

    public function inward_details()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Inward Details";
		$data['nestedView']['pageTitle'] = 'Inward Details';
        $data['nestedView']['cur_page'] = 'inward';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Inward Details', 'class' => '', 'url' => '');
       if($this->input->post('submit'))
		{
			$po_number=$this->input->post('po_no');
			$data['po_num'] = $po_number;
			$data['type']=$this->input->post('type');
			$invoice_no = array(1 => 'Priyanka', 2 => 'Tulasi', 3 => 'Prasad');
			foreach ($invoice_no as $key => $value)
			{
				if($po_number == $key)
				{
					$name = $value;
				}
			}
			$data['name'] = $name;
			$data['flag']=2;
			if($po_number >= 3 )
			{
				$data['flag']=1;
				$this->session->set_flashdata('response', '<div class="alert alert-danger">
	            												<button class="close" data-close="alert"></button>
	            												<span> Incorrect Invoice / Purchase Order Number. </span>
	        												</div>');
			redirect(SITE_URL.'inward');
			}

		}


        $this->load->view('security/inward_details',$data);
    }

    public function outward()
    {
    	# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Outward Details";
		$data['nestedView']['pageTitle'] = 'Outward Details';
        $data['nestedView']['cur_page'] = 'outward';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Outward Details', 'class' => '', 'url' => '');
        
        $data['flag']=1;
        $this->load->view('security/outward_details',$data);
    }

    public function outward_details()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Outward Details";
		$data['nestedView']['pageTitle'] = 'Outward Details';
        $data['nestedView']['cur_page'] = 'outward';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Outward Details', 'class' => '', 'url' => '');
       if($this->input->post('submit'))
		{
			$serial_num=$this->input->post('serial_num');
			$data['serial_num'] = $serial_num;
			$data['type']=$this->input->post('type');
			$dataa = array(1 => array(
											'date' =>  date("d-m-Y"),
											'Type' => 'Loose Oil Receive', 
											'InvoiceNo' => 2,
											'TicketNo'   => 3243,
											'VehicleNo'   => 7889,
											'Party'       => 'Kakinada',
											'Product'     =>  'Sun Flower',
											'Quantity'    =>  100,
											'Intime'      =>  '11:40:40',
											'DriverName'  =>  'Sardar',
											'Phone'       =>   '8096636672',	
											'outtime' =>  date("d-m-Y"),											
										  ),
								2 => array(
											'date' =>  date("d-m-Y"),
											'Type' => 'Receive Goods', 
											'InvoiceNo' => 3,
											'TicketNo'   => 2643,
											'VehicleNo'   => 6689,
											'Party'       => 'Hyderabad',
											'Product'     =>  'Ground Nut Oil',
											'Quantity'    =>  1100,
											'Intime'      =>  '10:50:40',
											'DriverName'  =>  'Paparao',
											'Phone'       =>   '8522818577',
											'outtime' =>  date("d-m-Y"),											
										  ),
								);
			foreach ($dataa as $key => $value)
			{
				if($serial_num == $key)
				{
				   $data['details'] = $value;
				}
			}
			
			
			$data['flag']=2;
			if($serial_num >= 3 )
			{
				$data['flag']=1;
				$this->session->set_flashdata('response', '<div class="alert alert-danger">
	            												<button class="close" data-close="alert"></button>
	            												<span> Incorrect Invoice / Purchase Order Number. </span>
	        												</div>');
			redirect(SITE_URL.'outward');
			}

		}


        $this->load->view('security/outward_details',$data);
    }

    public function gatepass_details()
    {
    	# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Gatepass Details";
		$data['nestedView']['pageTitle'] = 'Gatepass Details';
        $data['nestedView']['cur_page'] = 'gatepass_details';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Gatepass Details', 'class' => '', 'url' => '');
        
        $data['flag']=1;
        $this->load->view('security/gatepass_details',$data);
    }


}