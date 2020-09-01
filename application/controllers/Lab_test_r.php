<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Lab_test_r extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Lab_test_rm");
        $this->load->model("Oil_lab_test_m");
        $this->load->model("Packing_material_test_m");
        $this->load->library('Pdf');
	}

	public function oil_test_reports()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Oil Lab Test Reports";
        $data['nestedView']['pageTitle'] = 'Oil Lab Test Reports';
        $data['nestedView']['cur_page'] = 'oil_test_r';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Oil Lab Test Reports', 'class' => 'active', 'url' => '');

        # Search Functionality
        $p_search=$this->input->post('serach_test', TRUE);
        if($p_search!='') 
        { 
            $start_date = $this->input->post('start_date',TRUE);
            if($start_date!=''){ $startdate = date('Y-m-d',strtotime($start_date)); } else { $startdate = ''; }
            $end_date = $this->input->post('end_date',TRUE);
            if($end_date!=''){ $enddate = date('Y-m-d',strtotime($end_date)); } else { $enddate = ''; }
            
            $search_params=array(
                'loose_oil' 	=> $this->input->post('loose_oil', TRUE),
                'test_number' 	=> $this->input->post('test_number', TRUE),
                'start_date' 	=> $startdate,
               	'end_date' 	=> $enddate
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'loose_oil'   	=> $this->session->userdata('loose_oil'),
                    'test_number'	=> $this->session->userdata('test_number'),
                    'start_date'   	=> $this->session->userdata('start_date'),
                    'end_date'   	=> $this->session->userdata('end_date')
                    
                    
                                  );
            }
            else {
                $search_params=array(
                      'loose_oil'   => '',
                      'test_number'	=> '',
                      'start_date'   => '',
                      'end_date'=>''
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;

        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'oil_test_r/';
        # Total Records
        $config['total_rows'] = $this->Lab_test_rm->get_oil_test_total_rows($search_params);

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
        $data['loose_oil'] = array(''=>'Select Loose Oil')+$this->Common_model->get_dropdown('loose_oil','loose_oil_id','name',array('status' => 1));
        $data['oil_test_reports'] = $this->Lab_test_rm->get_oil_test_reports($current_offset, $config['per_page'], $search_params);
        //print_r($data['oil_test_reports']); die;
        # Additional data
        $data['display_results'] = 1;
        $this->load->view('reports/oil_test_reports', $data);
	}

	public function download_oil_test_r()
	{
        $lab_test_id=@cmm_decode($this->uri->segment(2));
        if($lab_test_id == '')
        {
            redirect(SITE_URL);
        }
        else
        {   
            $tanker_id = $this->Common_model->get_value('po_oil_lab_test',array('lab_test_id'=>$lab_test_id),'tanker_id');
            $data['plant_idd'] = $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id),'plant_id');
            
            $data['test_number'] = $this->Common_model->get_value('po_oil_lab_test',array('lab_test_id'=>$lab_test_id),'test_number');
            $data['test_date'] = $this->Common_model->get_value('po_oil_lab_test',array('lab_test_id'=>$lab_test_id),'test_date');
            $po_oil_id = $this->Common_model->get_value('po_oil_tanker',array('tanker_id'=>$tanker_id),'po_oil_id');
            $po_no = $this->Common_model->get_value('po_oil',array('po_oil_id'=>$po_oil_id),'po_number');
            $reg_no = $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id),'tanker_in_number');

            $data['test_reports'] = $this->Oil_lab_test_m->test_report_details($po_no,$tanker_id);

            $test_results=array();
            $result = $this->Oil_lab_test_m->get_test_results($lab_test_id);
            
            foreach($result as $results)
            {   
                if($results['range_type_id'] == 2 || $results['range_type_id'] == 3)
                {
                    //get test options
                    $test_options = $this->Common_model->get_data('test_option',array('test_id'=>$results['test_id'],'status'=>1));
                    $results['options'] = $test_options;
                    if(array_key_exists(@$keys, $test_results)) 
                    {
                        $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                    } 
                    else
                    {
                        $test_results[$results['test_group_id']]['test_group']=$results['test_group'];
                        $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                    }
                }
                else
                {
                    if(array_key_exists(@$keys, $test_results)) 
                    {
                        $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                    } 
                    else
                    {
                        $test_results[$results['test_group_id']]['test_group']=$results['test_group'];
                        $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                    }   
                }
            }
            # print_r($test_results);exit;
            $data['test_results']=$test_results;

           $this->load->view('lab_test/print_oil_test_results',$data);

        }
    }

	public function pm_test_reports()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Packing Material Lab Test Reports";
        $data['nestedView']['pageTitle'] = 'Packing Material Lab Test Reports';
        $data['nestedView']['cur_page'] = 'pm_test_r';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Packing Material Lab Test Reports', 'class' => 'active', 'url' => '');

        # Search Functionality
        $p_search=$this->input->post('serach_test', TRUE);
        if($p_search!='') 
        { 
            $start_date = $this->input->post('start_date',TRUE);
            if($start_date!=''){ $startdate = date('Y-m-d',strtotime($start_date)); } else { $startdate = ''; }
            $end_date = $this->input->post('end_date',TRUE);
            if($end_date!=''){ $enddate = date('Y-m-d',strtotime($end_date)); } else { $enddate = ''; }
            
            $search_params=array(
                'packing_material' 	=> $this->input->post('packing_material', TRUE),
                'test_number' 		=> $this->input->post('test_number', TRUE),
                'start_date' 		=> $startdate,
                'end_date' => $enddate
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'packing_material'  => $this->session->userdata('packing_material'),
                    'test_number'		=> $this->session->userdata('test_number'),
                    'start_date'   		=> $this->session->userdata('start_date'),
                    'end_date'   		=> $this->session->userdata('end_date')
                    
                                  );
            }
            else {
                $search_params=array(
                      'packing_material'    => '',
                      'test_number'			=> '',
                      'start_date'   		=> '',
                      'end_date'=>''
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;

        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'pm_test_r/';
        # Total Records
        $config['total_rows'] = $this->Lab_test_rm->get_pm_test_total_rows($search_params);

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
        $data['packing_material'] = array(''=>'Select Packing Material')+$this->Common_model->get_dropdown('packing_material','pm_id','name',array('status' => 1));
        $data['pm_test_reports'] = $this->Lab_test_rm->get_pm_test_reports($current_offset, $config['per_page'], $search_params);
        # Additional data
        $data['display_results'] = 1;
        $this->load->view('reports/pm_test_reports', $data);
	}

	public function download_pm_test_r()
	{
        $lab_test_id=@cmm_decode($this->uri->segment(2));
        if($lab_test_id == '')
        {
            redirect(SITE_URL);
        }
        else
        {   
            $tanker_id = $this->Common_model->get_value('po_pm_lab_test',array('lab_test_id'=>$lab_test_id),'tanker_id');
            $data['plant_idd'] = $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id),'plant_id');
            $data['test_date'] = $this->Common_model->get_value('po_pm_lab_test',array('lab_test_id'=>$lab_test_id),'test_date');
            $data['test_number'] = $this->Common_model->get_value('po_pm_lab_test',array('lab_test_id'=>$lab_test_id),'test_number');
            $po_pm_id = $this->Common_model->get_value('po_pm_tanker',array('tanker_id'=>$tanker_id),'po_pm_id');
            $po_no = $this->Common_model->get_value('po_pm',array('po_pm_id'=>$po_pm_id),'po_number');
            $reg_no = $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id),'tanker_in_number');

            $data['test_reports'] = $this->Packing_material_test_m->pm_test_details($po_no,$tanker_id);
            $data['results_list'] = $this->Packing_material_test_m->get_list_of_test_results($tanker_id);


            $test_results=array();
            $result = $this->Packing_material_test_m->get_pm_test_results($lab_test_id);
            
            foreach($result as $results)
            {   
                if($results['range_type_id'] == 2 || $results['range_type_id'] == 3)
                {
                    //get test options
                    $test_options = $this->Common_model->get_data('pm_test_option',array('pm_test_id'=>$results['pm_test_id'],'status'=>1));
                    $results['options'] = $test_options;
                    if(array_key_exists(@$keys, $test_results)) 
                    {
                        $test_results[$results['test_id']] = $results;
                    } 
                    else
                    {
                        $test_results[$results['test_id']] = $results;
                    }
                }
                else
                {
                    if(array_key_exists(@$keys, $test_results)) 
                    {
                        $test_results[$results['test_id']] = $results;
                    } 
                    else
                    {
                        $test_results[$results['test_id']] = $results;
                    }
                }
            }
            # print_r($test_results);exit;
            $data['test_results']=$test_results;

            $this->load->view('lab_test/print_pm_test_results',$data);
    	}
    }

    public function print_lab_test_oil()
    {
        if($this->input->post('print_lab_test_oil')!='') 
        {
            $start_date=$this->input->post('start_date');
            if($start_date=='')
            {
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
                        'loose_oil'     => $this->input->post('loose_oil', TRUE),
                        'test_number'   => $this->input->post('test_number', TRUE),
                        'start_date'    => $start_date,
                        'end_date'      => $end_date
                           );
            $lab_test_oil_report = $this->Lab_test_rm->get_lab_test_oil_reports(@$search_params);
            $data['lab_test_oil_report']=$lab_test_oil_report;
            $data['search_params']=$search_params;
            //print_r($data['lab_test_oil_report']);exit;
        }
        $this->load->view('reports/print_lab_test_oil',$data);
    }

    public function print_lab_test_pm()
    {
        if($this->input->post('print_lab_test_pm')!='') 
        {
            $start_date=$this->input->post('start_date');
            if($start_date=='')
            {
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
                        'packing_material'     => $this->input->post('packing_material', TRUE),
                        'test_number'       => $this->input->post('test_number', TRUE),
                        'start_date'    => $start_date,
                        'end_date'      => $end_date
                           );
            $lab_test_pm_report = $this->Lab_test_rm->get_lab_test_pm_reports(@$search_params);
            $data['lab_test_pm_report']=$lab_test_pm_report;
            $data['search_params']=$search_params;
            //print_r($data['lab_test_oil_report']);exit;
        }
        $this->load->view('reports/print_lab_test_pm',$data);
    }
}