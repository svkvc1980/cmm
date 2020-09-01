<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Regionwise_distributor_r extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Regionwise_distributor_rm");
        $this->load->library('Pdf');
	}

	public function region_wise_distributor_r()
	{  
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Region Wise Distributor Report";
		$data['nestedView']['pageTitle'] = 'Region Wise Distributor Report';
        $data['nestedView']['cur_page'] = 'region_wise_distributor_r';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Region Wise Distributor Report', 'class' => 'active', 'url' => '');	
       
        # Search Functionality
        #echo '<pre>'; print_r($_POST); exit;
        $p_search=$this->input->post('search_dist', TRUE);
        //echo $this->input->post('districts');exit;
        if($p_search!='') 
        {
            $search_params=array(
               	 'dist_code' 		  => 	$this->input->post('dist_code', TRUE),
                 'dist_name'          =>    $this->input->post('dist_name', TRUE),
               	 'dist_type'          => 	$this->input->post('d_type', TRUE),
               	 'executive'		  => 	$this->input->post('executive',TRUE),
               	 'region'		  	  => 	$this->input->post('region',TRUE),
               	 'district'		      => 	$this->input->post('district',TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'dist_code'   	=>    $this->session->userdata('dist_code'),
                    'dist_name'     =>    $this->session->userdata('dist_name'),
                    'dist_type'   	=>    $this->session->userdata('dist_type'),
                    'executive'		=>	  $this->session->userdata('executive'),
                    'region'   	    =>    $this->session->userdata('region'),
                    'district'		=>	  $this->session->userdata('district')
                    
                                  );
            }
            else {
                $search_params=array(
                      'dist_code'     => '',
                      'dist_name'     => '',
                      'dist_type'     => '',
                      'executive'	  => '',
                      'region'		  => '',
                      'district'	  => ''
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        //print_r($search_params); exit;


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'region_wise_distributor_r/';
        # Total Records
        $config['total_rows'] = $this->Regionwise_distributor_rm->region_wise_dist_report_total_rows($search_params);

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
        $data['distributor_results'] = $this->Regionwise_distributor_rm->region_wise_dist_report_results($current_offset, $config['per_page'], $search_params);
        #print_r($data['distributor_results']); die;
        $data['location']=$this->Common_model->get_data('location',array('status'=>1,'level_id'=>5));
        $data['distributor_type']=$this->Common_model->get_data('distributor_type',array('status'=>1));
        $data['executive']=$this->Common_model->get_data('executive');
        $data['region'] = $this->Common_model->get_data('location', array('level_id'=>3), array('location_id','name'));
        $data['dist']=$this->Common_model->get_data('location',array('parent_id'=>$search_params['region'],'status'=>1),array('location_id','name'));
        

        # Additional data
        $data['display_results'] = 1;

        $this->load->view('distributor/region_wise_distributor_view',$data);
    }

    public function get_district_based_region()
    {
    	$region_id = $this->input->post('region_id');
    	echo $this->Regionwise_distributor_rm->get_district_based_region($region_id);
    }

    public function download_region_wise_distributor_r()
    {
    	$p_search=$this->input->post('print_distributor_list', TRUE);
        //echo $p_search; exit;
        if($p_search!='')
        {
            $search_params=array(
                     'dist_code'          =>    $this->input->post('dist_code', TRUE),
                     'dist_name'          =>    $this->input->post('dist_name', TRUE),
                     'dist_type'          =>    $this->input->post('d_type', TRUE),
                     'executive'          =>    $this->input->post('executive',TRUE),
                     'region'		  	  => 	$this->input->post('region',TRUE),
               	     'district'		      => 	$this->input->post('district',TRUE)
                
                                  );
            $dist_type = $this->input->post('d_type', TRUE);
            $executive_id = $this->input->post('executive', TRUE);
            $data['distributor_type'] = '';
            $data['executive_name'] = '';
            if($dist_type!='')
            {
                $distributor_type = $this->Common_model->get_value('distributor_type',array('type_id'=>$dist_type),'name');
                $data['distributor_type'] = $distributor_type;
            }

            if($executive_id!='')
            {
                $executive_name = $this->Common_model->get_value('executive',array('executive_id'=>$executive_id),'name');
                $data['executive_name'] = $executive_name;
            }
            $data['region'] = $this->Common_model->get_data_row('location', array('location_id'=>$search_params['region']));
            $data['district'] = $this->Common_model->get_data_row('location', array('location_id'=>$search_params['district']));
        	$data['distributor_results'] = $this->Regionwise_distributor_rm->regionwise_dist_details($search_params);

            $this->load->view('distributor/print_regionwise_dist_r',$data);
        }
    }
}