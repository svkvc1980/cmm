<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Processing_loss extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Processing_loss_m");
	}

	public function processing_loss()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Processing Loss";
        $data['nestedView']['pageTitle'] = 'Processing Loss';
        $data['nestedView']['cur_page'] = 'processing_loss';
        $data['nestedView']['parent_page'] = 'processing_loss';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Processing Loss Entry', 'class' => 'active', 'url' => '');

        # Search Functionality
        $p_search=$this->input->post('search_pro_loss', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'from_date'     => $this->input->post('from_date', TRUE),
                'to_date'       => $this->input->post('to_date', TRUE),
                'loose_oil'     => $this->input->post('loose_oil', TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'from_date'       => $this->session->userdata('from_date'),
                    'to_date'         => $this->session->userdata('to_date'),
                    'loose_oil'       => $this->session->userdata('loose_oil')                  
                                  );
            }
            else {
                $search_params=array(
                      'from_date'    => '',
                      'to_date'      => '',
                      'loose_oil'    => ''                   
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        # Default Records Per Page - always 10
        /* pagination start */
         $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'processing_loss/';
        # Total Records
        $config['total_rows'] = $this->Processing_loss_m->processing_loss_num_rows($search_params);

        $config['per_page'] = getDefaultPerPageRecords();
        $data['total_rows'] = $config['total_rows'];
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        $current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        if ($data['pagination_links'] != '') {
            $data['last'] = $this->pagination->cur_page * $config['per_page'];
            if ($data['last'] > $data['total_rows']) {
                $data['last'] = $data['total_rows'];
            }
            $data['pagermessage'] = 'Showing ' . ((($this->pagination->cur_page - 1) * $config['per_page']) + 1) . ' to ' . ($data['last']) . ' of ' . $data['total_rows'];
        }
        $data['sn'] = $current_offset + 1;
        /* pagination end */
        # Loading the data array to send to View
        $data['processing_loss'] = $this->Processing_loss_m->processing_loss_results($current_offset, $config['per_page'], $search_params);
        # Additional data
        $data['display_results'] = 1;
        $data['loose_oil'] = $this->Common_model->get_data('loose_oil',array('status'=>1));
        $this->load->view('processing_loss', $data);
	}

    public function add_processing_loss()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']=" New Processing Loss Entry";
        $data['nestedView']['pageTitle'] = ' New Processing Loss Entry';
        $data['nestedView']['cur_page'] = 'processing_loss';
        $data['nestedView']['parent_page'] = 'processing_loss';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'New Processing Loss Entry', 'class' => 'active', 'url' => '');

        $data['form_action'] = SITE_URL.'insert_processing_loss';
        $data['display_results'] = 0;
        $data['flag'] = 1;
        $data['loose_oil'] = $this->Common_model->get_data('loose_oil',array('status'=>1));
        $this->load->view('processing_loss', $data);
    }

	public function insert_processing_loss()
	{
		if($this->input->post("submit") == TRUE)
        {
        	$dat = array(
        			'plant_id'		=> $this->session->userdata('ses_plant_id'),
        			'loose_oil_id' 	=> $this->input->post("loose_oil"),
        			'on_date' 		=> date('Y-m-d',strtotime($this->input->post("date"))),
        			'quantity' 		=> $this->input->post("quantity"),
                    'status'        => 1,
                    'created_by'    => $this->session->userdata('user_id'),
                    'created_time'  => date('Y-m-d H:i:s')
        		);

        	$p_loss = $this->Common_model->insert_data('ops_processing_loss',$dat);

        	if($p_loss>0)
        	{
        		$this->session->set_flashdata('response', '<div class="alert alert-success">
                    <button class="close" data-close="alert"></button>
                    <span> Processing Loss Added Successfully </span>
                </div>');
                redirect(SITE_URL.'processing_loss');
        	}
        }
	}

    // 31 may 2017 12:26 PM
    public function processing_loss_report()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Processing Loss Report";
        $data['nestedView']['pageTitle'] = 'Processing Loss Report';
        $data['nestedView']['cur_page'] = 'processing_loss';
        $data['nestedView']['parent_page'] = 'processing_loss';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Processing Loss Report', 'class' => 'active', 'url' => '');

        $data['form_action'] = SITE_URL.'print_processing_loss';
        $data['loose_oil'] = $this->Common_model->get_data('loose_oil',array('status'=>1));
        $data['block_id'] = get_ses_block_id();
        $data['ops_dropdown'] = get_ops_dropdown();
        $this->load->view('processing_loss_report', $data);
    }

    public function print_processing_loss()
    {
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');
        $loose_oil = $this->input->post('loose_oil');
        $ops = $this->input->post('ops');
        $data['ops'] = $this->Common_model->get_value('plant', array('plant_id' => $ops), 'name');
        $data['from_date'] = $from_date; $data['to_date'] = $to_date;
        $data['loose_oil'] = $this->Common_model->get_value('loose_oil', array('loose_oil_id' => $loose_oil), 'name');
        $data['processing_loss_results'] = $this->Processing_loss_m->print_processing_loss($from_date,$to_date,$loose_oil,$ops);
        $this->load->view('print_processing_loss', $data);
    }
}