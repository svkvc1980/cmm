<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Broker_r extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Broker_r_m");
	}
     
    //Mounika
    public function broker_report_search()
    {    
       # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Broker Reports";
        $data['nestedView']['pageTitle'] = 'Broker Reports';
        $data['nestedView']['cur_page'] = 'broker_r';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Broker Reports', 'class' => 'active', 'url' => '');

        # Search Functionality
        $psearch=$this->input->post('search_broker_r', TRUE);
        if($psearch!='')
        {
            $search_params=array(
                'broker_code'       => $this->input->post('broker_code', TRUE),
                'concerned_person'  => $this->input->post('concerned_person', TRUE),
                'agency_name'       => $this->input->post('agency_name', TRUE),
                'status'            => $this->input->post('status',TRUE)
            
                              );
        $this->session->set_userdata($search_params);
        } else {

            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                        'broker_code'       =>   $this->session->userdata('broker_code'),
                        'concerned_person'  =>   $this->session->userdata('concerned_person'),
                        'agency_name'       =>   $this->session->userdata('agency_name'),
                        'status'            =>   $this->session->userdata('status')
                       
                            );
            }
            else 
            {
                $search_params=array(
                        'broker_code'       =>  '',
                        'concerned_person'  =>  '',
                        'agency_name'       =>  '',
                        'status'            =>  ''
                                 );
                $this->session->set_userdata($search_params);
            }
        }
        $data['search_params'] = $search_params;
        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'broker_report_search/';
        # Total Records
        $config['total_rows'] = $this->Broker_r_m->broker_total_num_rows($search_params);
        $config['per_page'] = getDefaultPerPageRecords_ops();
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

        $data['broker'] = $this->Broker_r_m->broker_results($search_params,$config['per_page'], $current_offset);
       
       $this->load->view('reports/broker_report_search',$data);
    }



	public function broker_report_details()
	{
        $p_search=$this->input->post('broker_report_details', TRUE);
        if($p_search!='') 
        { 
            $search_params=array(
                'broker_code' 		=> $this->input->post('broker_code', TRUE),
                'concerned_person' 	=> $this->input->post('concerned_person', TRUE),
                'agency_name' 		=> $this->input->post('agency_name', TRUE),
                'status'            => $this->input->post('status',TRUE)
            
                              );
             $data['broker_reports'] = $this->Broker_r_m->($search_params);
             $this->load->view('reports/broker_report_details',$data);
        } 
      
    }
}