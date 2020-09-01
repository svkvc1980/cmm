<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Consumption extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Consumption_m");
	}


	
    
    public function production_consumption()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Production Consumption';
        $data['nestedView']['heading'] = "Production Consumption ";
        $data['nestedView']['cur_page'] = 'production_consumption';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'production_consumption';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Production Consumption','class'=>'active','url'=>'');
        
        
        # Search Functionality
        $psearch=$this->input->post('search_production_consumption', TRUE);
        if($psearch!='') {
            $start_date=$this->input->post('start_date');
            if($start_date=='') {
                $start_date='';
            }
            else
            {
                $start_date= date('Y-m-d',strtotime($this->input->post('start_date')));
            }
            //echo $start_date;exit;
            $end_date=$this->input->post('end_date');
            if($end_date=='')
            {
                $end_date='';
            }
            else
            {
                $end_date= date('Y-m-d',strtotime($this->input->post('end_date')));
            }
            $search_params=array(
                        'product_id'     =>   $this->input->post('product_id',TRUE),
                        'pm_id'          =>   $this->input->post('pm_id',TRUE),
                        'start_date'     =>   $start_date,
                        'end_date'       =>   $end_date
                           );
        $this->session->set_userdata($search_params);
        } else {

            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                        'product_id'    =>   $this->session->userdata('product_id'),
                        'pm_id'         =>   $this->session->userdata('pm_id'),
                        'start_date'    =>   $this->session->userdata('start_date'),
                        'end_date'      =>   $this->session->userdata('end_date')
                            );
            }
            else 
            {
                $search_params=array(
                        'product_id'    =>  '',
                        'pm_id'         =>  '',
                        'start_date'    =>  '',
                        'end_date'      =>  ''
                               );
                $this->session->set_userdata($search_params);
            }
        }
        $data['search_params'] = $search_params;
        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'production_consumption/';
        # Total Records
        $config['total_rows'] = $this->Consumption_m->production_consumption_total_num_rows($search_params);
        $config['per_page'] = 1000;
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
        if($search_params['product_id']!='')
        {
            $data['pms']  = $this->Consumption_m->get_product_pm_data($search_params['product_id']);
        }
        else
        {
            $data['pms']  = $this->Consumption_m->get_product_pm_data();
        }
        # Loading the data array to send to View        
        $data['products']         = get_rankwise_products();
        $data['production_consumption'] = $this->Consumption_m->production_consumption_results($search_params,$config['per_page'],$current_offset);
        //print_r($data['production_consumption']);exit;

        $con_arr= array();
        foreach ($data['production_consumption'] as $key => $value)
        {
            $con_arr[$value['production_product_id']][] = $value; 
        }
        $data['con_arr'] = $con_arr;
       
        $this->load->view('consumption/production_consumption_view',$data);
    }
    public function print_production_consumption()
    {
        
        
        
        # Search Functionality
        $psearch=$this->input->post('print_production_consumption', TRUE);
        if($psearch!='') {
            $start_date=$this->input->post('start_date');
            if($start_date=='') {
                $start_date='';
            }
            else
            {
                $start_date= date('Y-m-d',strtotime($this->input->post('start_date')));
            }
            //echo $start_date;exit;
            $end_date=$this->input->post('end_date');
            if($end_date=='')
            {
                $end_date='';
            }
            else
            {
                $end_date= date('Y-m-d',strtotime($this->input->post('end_date')));
            }
            $search_params=array(
                        'product_id'     =>   $this->input->post('product_id',TRUE),
                        'pm_id'          =>   $this->input->post('pm_id',TRUE),
                        'start_date'     =>   $start_date,
                        'end_date'       =>   $end_date
                           );
        $this->session->set_userdata($search_params);
        } else {

            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                        'product_id'    =>   $this->session->userdata('product_id'),
                        'pm_id'         =>   $this->session->userdata('pm_id'),
                        'start_date'    =>   $this->session->userdata('start_date'),
                        'end_date'      =>   $this->session->userdata('end_date')
                            );
            }
            else 
            {
                $search_params=array(
                        'product_id'    =>  '',
                        'pm_id'         =>  '',
                        'start_date'    =>  '',
                        'end_date'      =>  ''
                               );
                $this->session->set_userdata($search_params);
            }
        }
        $data['search_params'] = $search_params;
        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'production_consumption/';
        # Total Records
        $config['total_rows'] = $this->Consumption_m->production_consumption_total_num_rows($search_params);
        $config['per_page'] = 1000;
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
        if($search_params['product_id']!='')
        {
            $data['pms']  = $this->Consumption_m->get_product_pm_data($search_params['product_id']);
        }
        else
        {
            $data['pms']  = $this->Consumption_m->get_product_pm_data();
        }
        # Loading the data array to send to View        
        $data['products']         = get_rankwise_products();
        $data['production_consumption'] = $this->Consumption_m->production_consumption_results($search_params,$config['per_page'],$current_offset);
        //print_r($data['production_consumption']);exit;

        $con_arr= array();
        foreach ($data['production_consumption'] as $key => $value)
        {
            $con_arr[$value['production_product_id']][] = $value; 
        }
        $data['con_arr'] = $con_arr;
       
        $this->load->view('consumption/print_production_consumption',$data);
    }
    public function leakage_consumption()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Leakage Consumption';
        $data['nestedView']['heading'] = "Leakage Consumption ";
        $data['nestedView']['cur_page'] = 'leakage_consumption';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'leakage_consumption';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Leakage Consumption','class'=>'active','url'=>'');
        
        
        # Search Functionality
        $psearch=$this->input->post('search_leakage_consumption', TRUE);
        if($psearch!='') {
            $start_date=$this->input->post('start_date');
            if($start_date=='') {
                $start_date='';
            }
            else
            {
                $start_date= date('Y-m-d',strtotime($this->input->post('start_date')));
            }
            //echo $start_date;exit;
            $end_date=$this->input->post('end_date');
            if($end_date=='')
            {
                $end_date='';
            }
            else
            {
                $end_date= date('Y-m-d',strtotime($this->input->post('end_date')));
            }
            $search_params=array(
                        'product_id'     =>   $this->input->post('product_id',TRUE),
                        'pm_id'          =>   $this->input->post('pm_id',TRUE),
                        'start_date'     =>   $start_date,
                        'end_date'       =>   $end_date
                           );
        $this->session->set_userdata($search_params);
        } else {

            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                        'product_id'    =>   $this->session->userdata('product_id'),
                        'pm_id'         =>   $this->session->userdata('pm_id'),
                        'start_date'    =>   $this->session->userdata('start_date'),
                        'end_date'      =>   $this->session->userdata('end_date')
                            );
            }
            else 
            {
                $search_params=array(
                        'product_id'    =>  '',
                        'pm_id'         =>  '',
                        'start_date'    =>  '',
                        'end_date'      =>  ''
                               );
                $this->session->set_userdata($search_params);
            }
        }
        $data['search_params'] = $search_params;
        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'leakage_consumption/';
        # Total Records
        $config['total_rows'] = $this->Consumption_m->leakage_consumption_total_num_rows($search_params);
        $config['per_page'] = 10000;
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
        if($search_params['product_id']!='')
        {
            $data['pms']  = $this->Consumption_m->get_product_pm_data($search_params['product_id']);
        }
        else
        {
            $data['pms']  = $this->Consumption_m->get_product_pm_data();
        }
        # Loading the data array to send to View        
        $data['products']         = get_rankwise_products();
        $data['leakage_consumption'] = $this->Consumption_m->leakage_consumption_results($search_params,$config['per_page'],$current_offset);
        //echo '<pre>';print_r($data['leakage_consumption']);exit;

        $con_arr= array();
        foreach ($data['leakage_consumption'] as $key => $value)
        {
            $con_arr[$value['ops_leakage_id']][] = $value; 
        }
        $data['con_arr'] = $con_arr;
       
        $this->load->view('consumption/leakage_consumption_view',$data);
    }
    public function print_leakage_consumption()
    {
        
        
        # Search Functionality
        $psearch=$this->input->post('print_leakage_consumption', TRUE);
        //echo $psearch;exit;
        if($psearch!='') {
            $start_date=$this->input->post('start_date');
            if($start_date=='') {
                $start_date='';
            }
            else
            {
                $start_date= date('Y-m-d',strtotime($this->input->post('start_date')));
            }
            //echo $start_date;exit;
            $end_date=$this->input->post('end_date');
            if($end_date=='')
            {
                $end_date='';
            }
            else
            {
                $end_date= date('Y-m-d',strtotime($this->input->post('end_date')));
            }
            $search_params=array(
                        'product_id'     =>   $this->input->post('product_id',TRUE),
                        'pm_id'          =>   $this->input->post('pm_id',TRUE),
                        'start_date'     =>   $start_date,
                        'end_date'       =>   $end_date
                           );
        $this->session->set_userdata($search_params);
        } else {

            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                        'product_id'    =>   $this->session->userdata('product_id'),
                        'pm_id'         =>   $this->session->userdata('pm_id'),
                        'start_date'    =>   $this->session->userdata('start_date'),
                        'end_date'      =>   $this->session->userdata('end_date')
                            );
            }
            else 
            {
                $search_params=array(
                        'product_id'    =>  '',
                        'pm_id'         =>  '',
                        'start_date'    =>  '',
                        'end_date'      =>  ''
                               );
                $this->session->set_userdata($search_params);
            }
        }
        $data['search_params'] = $search_params;
        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'leakage_consumption/';
        # Total Records
        $config['total_rows'] = $this->Consumption_m->leakage_consumption_total_num_rows($search_params);
        $config['per_page'] = 10000;
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
        if($search_params['product_id']!='')
        {
            $data['pms']  = $this->Consumption_m->get_product_pm_data($search_params['product_id']);
        }
        else
        {
            $data['pms']  = $this->Consumption_m->get_product_pm_data();
        }
        # Loading the data array to send to View        
        $data['products']         = get_rankwise_products();
        $data['leakage_consumption'] = $this->Consumption_m->leakage_consumption_results($search_params,$config['per_page'],$current_offset);
        //echo '<pre>';print_r($data['leakage_consumption']);exit;

        $con_arr= array();
        foreach ($data['leakage_consumption'] as $key => $value)
        {
            $con_arr[$value['ops_leakage_id']][] = $value; 
        }
        $data['con_arr'] = $con_arr;
       
        $this->load->view('consumption/print_leakage_consumption',$data);
    }

    

    

   
}