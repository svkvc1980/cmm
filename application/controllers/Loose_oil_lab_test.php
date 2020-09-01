<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 9th Feb 2016 09:00 AM

class Loose_oil_lab_test extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Loose_oil_lab_test_m");
	}


	public function loose_oil_lab_test()
	{ 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Loose Oil Lab Test";
		$data['nestedView']['pageTitle'] = 'Loose Loose Oil Lab Test';
        $data['nestedView']['cur_page'] = 'loose_oil_lab_test';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'lab_test';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Loose Oil Lab Test', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_loose_oil', TRUE);
        if($p_search!='') 
        {
            $search_params=array('loose_oil_id'     => $this->input->post('loose_oil_id', TRUE));
            $this->session->set_userdata($search_params);
        } 
        else 
        {            
            if($this->uri->segment(2)!='')
            {
                $search_params=array('loose_oil_id' => $this->session->userdata('loose_oil_id'));
            }
            else 
            {
                $search_params=array('loose_oil_id'  => '');
                $this->session->set_userdata($search_params);
            }            
        }
        $data['search_data'] = $search_params;

        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'loose_oil_lab_test/';
        # Total Records
        $config['total_rows'] = $this->Loose_oil_lab_test_m->loose_oil_total_num_rows($search_params);

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
        $data['loose_oil_results'] = $this->Loose_oil_lab_test_m->loose_oil_results($current_offset, $config['per_page'], $search_params);
        $data['loose_oil_details'] = $this->Common_model->get_data('loose_oil',array('status'=>'1'));

        # Additional data
        $data['display_results'] = 1;
        $this->load->view('loose_oil_lab_test/loose_oil_lab_test_view',$data);
    }
    
    public function add_loose_oil_lab_test()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add Loose Oil Lab Test";
        $data['nestedView']['pageTitle'] = 'Add Loose Oil Lab Test';
        $data['nestedView']['cur_page'] = 'loose_oil_lab_test';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'lab_test';


        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/add_loose_oil_lab_test.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Loose Oil Lab Test', 'class' => '', 'url' => SITE_URL.'loose_oil_lab_test');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add Loose Oil Lab Test', 'class' => '', 'url' => '');
        
        # Additional data
        $data['loose_oil_details'] = $this->Common_model->get_data('loose_oil',array('status'=>'1'));
        $data['test_group_details'] = $this->Common_model->get_data('test_group',array('status'=>'1'));        
        
        $data['form_action'] = SITE_URL.'add_loose_oil_lab_test_list';
        $data['display_results'] = 3;
        $this->load->view('loose_oil_lab_test/add_loose_oil_lab_test_list_view',$data);
    }    
    public function add_loose_oil_lab_test_list()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add Loose Oil Lab Test List";
        $data['nestedView']['pageTitle'] = 'Add Loose Oil Lab Test List';
        $data['nestedView']['cur_page'] = 'loose_oil_lab_test_list';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'lab_test';


        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/add_loose_oil_lab_test.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Loose Oil Lab Test', 'class' => '', 'url' => SITE_URL.'loose_oil_lab_test');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add Loose Oil Test ', 'class' => 'active', 'url' => 'add_loose_oil_lab_test');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add Loose Oil Test List', 'class' => 'active', 'url' => '');

        # Data
        
        # Additional data
        $data['loose_oil_id']  = $this->input->post('loose_oil',TRUE);
        $data['test_group_id'] = $this->input->post('test_group',TRUE);
        $data['loose_oil'] = $this->Common_model->get_value('loose_oil', array('loose_oil_id' => $data['loose_oil_id']),'name');
        $data['test_group'] = $this->Common_model->get_value('test_group', array('test_group_id' => $data['test_group_id']),'name');

        $data['test_unit_details'] = $this->Common_model->get_data('test_unit',array('status'=>'1'));
        $data['range_type_details'] = $this->Common_model->get_data('range_type',array('status'=>'1'));
        
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_loose_oil_lab_test';
        $data['display_results'] = 0;
        $this->load->view('loose_oil_lab_test/add_loose_oil_lab_test_list_view',$data);
    }    
    public function insert_loose_oil_lab_test()
    { 
        /*echo '<pre>';
        print_r($_POST);
        exit;*/
        $test_name=$this->input->post('test_name',TRUE);
        $range_type=$this->input->post('range_type',TRUE);

        $this->db->trans_begin();
        foreach ($test_name as $key => $value)
        {            
            if($value!='' )
            {
                $test_unit_id=$this->input->post('test_unit',TRUE)[$key];
                
                $data = array( 
                    'loose_oil_id'        => cmm_decode($this->input->post('loose_oil_id',TRUE)),
                    'test_group_id'       => cmm_decode($this->input->post('test_group_id',TRUE)),
                    'name'                => $this->input->post('test_name',TRUE)[$key],
                    'range_type_id'       => $this->input->post('range_type',TRUE)[$key],                                      
                    'order'               => get_order('loose_oil_test'),
                    'created_by'          => $this->session->userdata('user_id'),
                    'created_time'        => date('Y-m-d H:i:s')
                );

                if($test_unit_id!='')
                    $data['test_unit_id'] = $test_unit_id;         

                $test_id = $this->Common_model->insert_data('loose_oil_test',$data);
                if(@$test_id!='')
                {
                    $where = array('test_id'=> $test_id);
                    if($range_type[$key]==1)
                    {
                        $data1=array(                    
                            'lower_limit'           => $this->input->post('lower_limit',TRUE)[$key],
                            'upper_limit'           => $this->input->post('upper_limit',TRUE)[$key]
                            
                            );
                        $data1['lower_check']=($this->input->post('lower_check',TRUE)[$key]=='')?0:$this->input->post('lower_check',TRUE)[$key];
                        $data1['upper_check']=($this->input->post('upper_check',TRUE)[$key]=='')?0:$this->input->post('upper_check',TRUE)[$key];

                        $this->Common_model->update_data('loose_oil_test',$data1,$where);                        
                    }
                    else
                    { 
                        if($range_type[$key]==4)
                        {                            
                            $data2=array();
                            $data2['lower_limit']=$this->input->post('exact_value',TRUE)[$key];
                            $data2['lower_check']=1;
                            $res = $this->Common_model->update_data('loose_oil_test',$data2,$where); 
                            /*echo $this->db->last_query();
                            print_r($data2) ;exit;*/
                        }
                        else
                        {
                            $data2=array();
                            $data2['specification']=$this->input->post('specification',TRUE)[$key];
                            $res = $this->Common_model->update_data('loose_oil_test',$data2,$where);
                            $keys=$this->input->post('key');
                            $values=$this->input->post('value');
                            $allowed=$this->input->post('allowed');

                            foreach ($keys[$key] as $k => $v)
                            {
                                $allowed_v=(isset($allowed[$key][$k]))?1:0;
                                $data3=array(
                                    'test_id'               => $test_id,
                                    'key'                   => $v,
                                    'value'                 => $values[$key][$k],
                                    'allowed'         => $allowed_v,
                                    'created_by'            => $this->session->userdata('user_id'),
                                    'created_time'          => date('Y-m-d H:i:s')
                                    );
                                $this->Common_model->insert_data('test_option',$data3);  
                            }
                        }                       
                    }
                }
                else
                {
                    
                     $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                            <strong>Error!</strong> Something went wrong. Please check. </div>');       

                }
            }
        }
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                <strong>Success!</strong> There\'s a problem occured while adding Company! </div>');
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Tests has been added successfully! </div>');
        }
        redirect(SITE_URL.'add_loose_oil_lab_test');  
    }

    public function view_loose_oil_lab_tests()
    {
        $loose_oil_id=@cmm_decode($this->uri->segment(2));
        if($loose_oil_id==''){
            redirect(SITE_URL.'loose_oil_lab_test');
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="View Loose Oil Lab Tests";
        $data['nestedView']['pageTitle'] = 'View Loose Oil Lab Tests';
        $data['nestedView']['cur_page'] = 'loose_oil_lab_test';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'lab_test';


        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Loose Oil Lab Test', 'class' => 'active', 'url' => SITE_URL.'loose_oil_lab_test');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'View Loose Oil Lab Test', 'class' => '', 'url' => '');

        # Data
        $test_groups = $this->Loose_oil_lab_test_m->get_test_groups($loose_oil_id);
        /*echo '<pre>';
        print_r($test_groups);exit;*/
        $loose_oil_tests = array();

        foreach($test_groups as $test_group)
        {
            $results = $this->Loose_oil_lab_test_m->get_tests($loose_oil_id,$test_group['test_group_id']);
            /*echo '<pre>';
            print_r($results);exit;*/
            foreach($results as $test_row)
            {
                // if range type is radio or dropdown 
                if($test_row['range_type_id'] == 2 || $test_row['range_type_id'] == 3)
                {
                    //get test options
                    $test_options = $this->Common_model->get_data('test_option',array('test_id'=>$test_row['test_id'],'status'=>1));
                    //print_r($test_options);exit;
                    $test_row['options'] = $test_options;
                    /*echo '<pre>';
                    print_r($test_row);exit;*/
                }
                //print_r($test_row);exit;
                $loose_oil_tests[$test_group['test_group_id']]['test'][$test_row['test_id']] = $test_row;
               /* echo '<pre>';

                print_r($loose_oil_tests);exit;*/
            } /*echo '<pre>';
                print_r($loose_oil_tests);exit;*/
            $loose_oil_tests[$test_group['test_group_id']]['group_name'] = $test_group['group_name'];
            // print_r($loose_oil_tests);exit;
        }
        $data['loose_oil_tests'] = $loose_oil_tests;
        /*echo '<pre>';
        print_r($data['loose_oil_tests']);exit;*/
        
        $data['flg'] = 1;
        //$data['form_action'] = SITE_URL.'insert_labtest';
        $data['display_results'] = 0;
        $this->load->view('loose_oil_lab_test/loose_oil_lab_test_view',$data);
    }
    public function edit_loose_oil_lab_test()
    {
        $test_id=@cmm_decode($this->uri->segment(2));
        $loose_oil_id=@cmm_decode($this->uri->segment(3));
        
        if($test_id == '' || $loose_oil_id == ''){
            redirect(SITE_URL.'loose_oil_lab_test');
        }        
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Loose Oil Lab Test";
        $data['nestedView']['pageTitle'] = 'Edit Loose Oil Lab Test';
        $data['nestedView']['cur_page'] = 'loose_oil_lab_test';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'lab_test';


        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/edit_loose_oil_lab_test.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Loose Oil Test', 'class' => 'active', 'url' => SITE_URL.'loose_oil_lab_test');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'View Loose Oil Lab Test', 'class' => 'active', 'url' => SITE_URL.'view_loose_oil_lab_tests/'.cmm_encode($loose_oil_id));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Loose Oil Lab Test', 'class' => '', 'url' => '');

        $range_type_id=$this->Common_model->get_value("loose_oil_test" ,array('test_id'=>$test_id),"range_type_id" );
        $data['loose_oil_test'] =$this->Common_model->get_data('loose_oil_test',array('test_id'=>$test_id,'status'=>1));        
          
        //if range type is radio or dropdown
        $test_options=array(); 
        if($range_type_id == 2 || $range_type_id == 3)
        {
            //get test options            
            $options = $this->Loose_oil_lab_test_m->get_range_dropdown_options($test_id);
            $test_options=$options;           
        }
        else
        {
            $data['options']=1;
            $options = $this->Common_model->get_data('loose_oil_test',array('test_id'=>$test_id,'status'=>1));
            $test_options=$options;
        }
        
        
        $data['test_options']=$test_options;
        /*echo '<pre>';
        print_r($data['test_options']);
        
        exit;*/
        $data['range_type_id']=$range_type_id; 

        $data['test_unit_details'] = $this->Common_model->get_data('test_unit',array('status'=>'1'));
        $data['range_type_details'] = $this->Common_model->get_data('range_type',array('status'=>'1'));
             
        $data['form_action'] = SITE_URL.'update_loose_oil_lab_test';
        
        $this->load->view('loose_oil_lab_test/edit_loose_oil_lab_test_view',$data);
    }
    public function update_loose_oil_lab_test()
    {  
        /*echo '<pre>';
        print_r($_POST);
        exit;*/        
        $test_id=@cmm_decode($this->input->post('test_id',TRUE));
        $where = array('test_id'=> $test_id);

        $old_range_type_id = @cmm_decode($this->input->post('edit_range_type_id',TRUE));
        $new_range_type_id = $this->input->post('range_type',TRUE); 
        $test_unit_id      = @$this->input->post('test_unit',TRUE);                         
        
        $upper_limit = @$this->input->post('upper_limit',TRUE);       
        $lower_check = ($this->input->post('lower_check') !='')?1:0;

        if($new_range_type_id == 4 )
        {
            $upper_check = 1;
            $lower_limit = @$this->input->post('exact_value',TRUE); 
        }
        else
        {
            $lower_limit = @$this->input->post('lower_limit',TRUE); 
            $upper_check = ($this->input->post('upper_check') !='')?1:0;  
        }         

        if($old_range_type_id !== $new_range_type_id)
        {
            switch ($old_range_type_id) {
                case 1:
                    if($new_range_type_id == 2 || $new_range_type_id == 3)
                    {
                        $lower_limit = $upper_limit =NULL;
                        $lower_check = $upper_check = 0 ;
                    }
                    else
                    {
                        $lower_check=1;
                        $upper_limit = NULL;
                        $upper_check = 0 ;  
                    }                  
                    break;
                case 2: case 3:
                    if($new_range_type_id == 1)
                    {

                        // same form data
                    }
                    if($new_range_type_id == 4)
                    {
                        $lower_check=1;
                        $upper_limit=NULL;
                        $upper_check = 0 ; 
                    }
                    break;
                case 4:
                    if($new_range_type_id == 1)
                    {
                        // same form data
                    }
                    if($new_range_type_id == 2 || $new_range_type_id ==3)
                    {
                        $lower_limit = $upper_limit =NULL;
                        $lower_check = $upper_check = 0 ;
                    }
                    break;
                default:
                    
                    break;
            }
        }
            $test_unit_id=$this->input->post('test_unit',TRUE);

            // Update Test Row
            $data1=array(
                'lower_limit'    => $lower_limit,
                'lower_check'    => $lower_check,
                'upper_limit'    => $upper_limit,
                'upper_check'    => $upper_check,
                'range_type_id'  => $new_range_type_id,
                'test_unit_id'   => ($test_unit_id!='')?$test_unit_id:NULL,
                'modified_by'    => $this->session->userdata('user_id'),
                'modified_time'  => date('Y-m-d H:i:s') 
                );
            /*if($test_unit_id!='')
                $data1['test_unit_id'] = $test_unit_id;*/         
            /*echo '<pre>';
            print_r($data1);exit;*/
            $this->Common_model->update_data('loose_oil_test',$data1,$where);
            
        //  Updating Test Options

            // deactivate all options of a test
            $deactivate_data=array(
                        'status'         => 2,
                        'modified_by'    => $this->session->userdata('user_id'),
                        'modified_time'  => date('Y-m-d H:i:s') 
                    );
            $this->Common_model->update_data('test_option',$deactivate_data,array('test_id'=>$test_id));

            $this->Common_model->update_data('loose_oil_test',array('specification'=>@$this->input->post('specification',TRUE)),array('test_id'=>$test_id));
            // update existed options
            $option=$this->input->post('edit_option_id',TRUE);
            $new_options=$this->input->post('new_options',TRUE);
            $keys=@$this->input->post('key',TRUE);
            $values=@$this->input->post('value',TRUE);
            $allowed_value=@$this->input->post('allowed',TRUE);
            if(isset($option))
            {                 
                foreach ($option as $option_id)
                {   
                    if($keys[$option_id] !='')
                    {
                        $where4=array('option_id'=>$option_id);
                        $key= $keys[$option_id];
                        $value= $values[$option_id];
                        $allowed = isset($allowed_value[$option_id])?1:0;
                        $data4=array(                                        
                                'key'                   => $key,
                                'value'                 => $value,
                                'allowed'         => @$allowed,
                                'modified_by'           => $this->session->userdata('user_id'),
                                'modified_time'         => date('Y-m-d H:i:s'),
                                'status'                => 1
                                );
                        $this->Common_model->update_data('test_option',$data4,$where4); 
                    }
                }
            }

            // insert new options
            $new_options=$this->input->post('new_options',TRUE);
            if(isset($new_options))
            {                            
                foreach ($new_options as $new_option_id)
                {
                    if($keys[$new_option_id] !='')
                    {
                        $key= $keys[$new_option_id];
                        $value= $values[$new_option_id];
                        $allowed = isset($allowed_value[$new_option_id])?1:0;
                        $data5=array( 
                                'test_id'               => $test_id,                                       
                                'key'                   => $key,
                                'value'                 => $value,
                                'allowed'         		=> @$allowed,
                                'created_by'           => $this->session->userdata('user_id'),
                                'created_time'         => date('Y-m-d H:i:s'),
                                'status'                => 1
                                );
                        $this->Common_model->insert_data('test_option',$data5);
                    }
                }
            }
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                <strong>Success!</strong> There\'s a problem occured while adding Company! </div>');
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> successfully! </div>');
        } 
        $loose_oil_id=$this->Common_model->get_value('loose_oil_test', array('test_id'=>$test_id,'status'=>1), 'loose_oil_id');
        if($loose_oil_id=='')
        {
            redirect(SITE_URL.'loose_oil_lab_test');     
        }        
        redirect(SITE_URL.'view_loose_oil_lab_tests/'.@cmm_encode($loose_oil_id)); 
    }
}