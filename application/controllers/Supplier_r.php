<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Supplier_r extends CI_Controller {
/*
 * created by roopa on 12th april 2017
*/
	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Supplier_r_m");
	}
  
    //Mounika
    public function supplier_view_r()
    {    
       # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Supplier Reports";
        $data['nestedView']['pageTitle'] = 'Supplier Reports';
        $data['nestedView']['cur_page'] = 'supplier_r';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Supplier Reports', 'class' => 'active', 'url' => '');

        $data['supplier_type'] = array(''=>'Select Type')+$this->Common_model->get_dropdown('supplier_type','type_id','name',array('status' => 1));

        # Search Functionality
        $psearch=$this->input->post('search_supplier_r', TRUE);
        if($psearch!='')
        {
            $search_params=array(
                'supplier_code'     => $this->input->post('supplier_code', TRUE),
                'type_id'           => $this->input->post('supplier_type', TRUE),
                'concerned_person'  => $this->input->post('concerned_person', TRUE),
                'agency_name'       => $this->input->post('agency_name', TRUE),
                'status'            => $this->input->post('status', TRUE)
                  );
        $this->session->set_userdata($search_params);
        } else {

            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                        'supplier_code'     =>   $this->session->userdata('supplier_code'),
                        'type_id'           =>   $this->session->userdata('supplier_type', TRUE),
                        'concerned_person'  =>   $this->session->userdata('concerned_person'),
                        'agency_name'       =>   $this->session->userdata('agency_name'),
                        'status'            =>   $this->session->userdata('status')
                       
                            );
            }
            else 
            {
                $search_params=array(
                        'supplier_code'     =>  '',
                        'type_id'           =>  '',
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
        $config['base_url'] = SITE_URL . 'supplier_view_r/';
        # Total Records
        $config['total_rows'] = $this->Supplier_r_m->supplier_total_num_rows($search_params);
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

        $data['supplier'] = $this->Supplier_r_m->supplier_results($search_params,$config['per_page'], $current_offset);
       
       $this->load->view('reports/supplier_view_r',$data);
    }

	public function print_supplier()
	{
        $p_search=$this->input->post('print_supplier', TRUE);
        if($p_search!='') 
        { 
            $search_params=array(
                'supplier_code' 	=> $this->input->post('supplier_code', TRUE),
                'type_id'           => $this->input->post('supplier_type', TRUE),
                'concerned_person' 	=> $this->input->post('concerned_person', TRUE),
                'agency_name' 		=> $this->input->post('agency_name', TRUE),
                'status'            => $this->input->post('status', TRUE)
                  );
            $data = array();
            $data['supplier_type'] = '';
            if($search_params['type_id']!='')
            {
                $data['supplier_type'] = $this->Common_model->get_value('supplier_type',array('type_id'=>$search_params['type_id']),'name');
            }
                            
            $data['supplier_reports'] = $this->Supplier_r_m->supplier_report_results($search_params);
            $this->load->view('reports/print_supplier',$data);
        } 
   }

}