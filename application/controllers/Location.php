<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 25th Jan 2017 11:00 AM

class Location extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Location_m");
	}

    public function location_add()
    {
        if($this->input->post('submit_location') != "")
        {
            //print_r($_POST);
            $location_id = $this->input->post('location_id');
            $dataArr = array('name' => $this->input->post('name'),
                                'parent_id'=>$this->input->post('parent'));

            //$dataArr = $_POST[];
            if($location_id == "")
            {
                $level_id = $this->input->post('level_id');
                $dataArr['level_id'] = $level_id;
                $dataArr['created_by'] = $this->session->userdata('user_id');
                $dataArr['created_time'] = date('Y-m-d H:i:s');
                /*echo '<pre>';print_r($dataArr);exit;*/
                $territory_level_name = $this->Common_model->get_value('territory_level', array('level_id'=>$level_id), 'name');
                //Insert
                $location_id = $this->Common_model->insert_data('location',$dataArr);
                
                
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> '.$territory_level_name.' has been added successfully! </div>');
            }
            else
            {   
                $edit_dataArr = array('name' => $this->input->post('name'),
                                        'parent_id'=>$this->input->post('edit_parent_id'));
                $level_id = $this->Common_model->get_value('location', array('location_id'=>$location_id), 'level_id');
                $edit_dataArr['modified_by'] = $this->session->userdata('user_id');
                $edit_dataArr['modified_time'] = date('Y-m-d H:i:s');
                $where = array('location_id' => $location_id);
                /*echo '<pre>';print_r($edit_dataArr);exit;*/

                $territory_level_name = $this->Common_model->get_value('territory_level', array('level_id'=>$level_id), 'name');
                //Update
                $this->Common_model->update_data('location',$edit_dataArr, $where);
                
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> '.$territory_level_name.' has been updated successfully! </div>');                
            }
            redirect(SITE_URL.strtolower($territory_level_name));
        }
    }
    public  function is_locationExist()
    {

        $name = $this->input->post('name');
        $parent_id = $this->input->post('parent_id');
        $location_id = $this->input->post('location_id');
       
        echo $this->Location_m->is_locationExist($name,$parent_id,$location_id);
    }
    public  function check_state()
    {
            
        $state_name = $this->input->post('state_name');
        $location_id = $this->input->post('location_id'); 

        echo $this->Location_m->check_state($state_name,$location_id);
    }

    //State
        public function state()
        {
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading']="Manage State";
            $data['nestedView']['pageTitle'] = 'State';
            $data['nestedView']['cur_page'] = 'state';
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';

            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['css_includes'] = array();

            # Breadcrumbs
            $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
            $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage State', 'class' => 'active', 'url' => '');    

            # Search Functionality
            $p_search=$this->input->post('search_state', TRUE);
            if($p_search!='') 
            {
                $search_params=array(
                    'state_name' => $this->input->post('state_name', TRUE),
                                  );
                $this->session->set_userdata($search_params);
            } 
            else 
            {
                
                if($this->uri->segment(2)!='')
                {
                    $search_params=array(
                        'state_name' => $this->session->userdata('state_name'),
                                      );
                }
                else {
                    $search_params=array(
                          'state_name'=>'',
                                     );
                    $this->session->set_userdata($search_params);
                }
                
            }       
            $data['search_data'] = $search_params; 
            # Default Records Per Page - always 10
            /* pagination start */

            $config = get_paginationConfig();
            $config['base_url'] = SITE_URL . 'state/';
            # Total Records
            $config['total_rows'] = $this->Location_m->state_total_num_rows($search_params);

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
            $data['sn'] =$current_offset + 1;
            /* pagination end */
            # Loading the data array to send to View
            $data['state_results'] = $this->Location_m->state_results($current_offset, $config['per_page'], $search_params);
            # Additional data
            $data['display_results'] = 1;

            $this->load->view('location/state_view',$data);
        }    	

        public function add_state()
        {
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading']="Add State";
            $data['nestedView']['pageTitle'] = 'Add State';
            $data['nestedView']['cur_page'] = 'state';
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';

            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/location.js"></script>';
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/additional-methods.js"></script>';

            $data['nestedView']['css_includes'] = array();

            # Breadcrumbs
            $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
            $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage State', 'class' => '', 'url' => SITE_URL.'state');  
            $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New State', 'class' => 'active', 'url' => '');

            $data['level_id'] = $this->Common_model->get_value('territory_level', array('name'=>'State'), 'level_id');
            $data['parent_id'] = $this->Common_model->get_value('territory_level', array('name'=>'India'), 'level_id');
            # Additional data
            $data['flg'] = 1;            
            $data['display_results'] = 0;

            $this->load->view('location/state_view',$data);
        }


        public function edit_state()
        {
            $state_id=@eip_decode($this->uri->segment(2));
            if($state_id==''){
                redirect(SITE_URL);
                exit;
            }
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading']="Edit State";
            $data['nestedView']['pageTitle'] = 'Edit State';
            $data['nestedView']['cur_page'] = 'state';
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';

            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/location.js"></script>';
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'custom/js/additional-methods.js"></script>';

            $data['nestedView']['css_includes'] = array();

            # Breadcrumbs
            $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
            $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage State', 'class' => '', 'url' => SITE_URL.'state');  
            $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit state', 'class' => 'active', 'url' => '');

            # Additional data

            $data['val'] = 1;
            $data['flg'] = 2;
            $data['display_results'] = 0;
            
            $where = array('location_id' => $state_id);
            $data['state_edit'] = $this->Common_model->get_data('location', $where);            
            $data['parent_id'] = $this->Common_model->get_value('territory_level', array('name'=>'India'), 'level_id');
            $this->load->view('location/state_view',$data);
        }       
    //Region
    
        public function region()
        {
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Manage Region";
            $data['nestedView']['pageTitle'] = 'Manage Region';
            $data['nestedView']['cur_page'] = 'region';     
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';
            
            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['css_includes'] = array();
            
            # Breadcrumbs
            $data['nestedView']['breadCrumbTite'] = 'Manage Region';
            $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Region','class'=>'active','url'=>'');
            
            # Search Functionality
            $psearch=$this->input->post('search_region', TRUE);
            if($psearch!='') {
            $searchParams=array(
                          'region_name'=>$this->input->post('region_name', TRUE),
                          'state_id'=>$this->input->post('state', TRUE),
                                  );
            $this->session->set_userdata($searchParams);
            } else {
                
                if($this->uri->segment(2)!='')
                {
                $searchParams=array(
                          'region_name'=>$this->session->userdata('region_name'),
                          'state_id'=>$this->session->userdata('state_id'),
                                  );
                }
                else {
                    $searchParams=array(
                          'region_name'=>'',
                          'state_id'=>'',
                                      );
                    $this->session->unset_userdata(array_keys($searchParams));
                }
                
            }
            $data['searchParams'] = $searchParams;
            
            /* pagination start */
            $config = get_paginationConfig();
            $config['base_url'] = SITE_URL.'region/'; 
            # Total Records
            $config['total_rows'] = $this->Location_m->region_total_rows($searchParams);
            
            $config['per_page'] = getDefaultPerPageRecords();
            $data['total_rows'] = $config['total_rows'];
            $this->pagination->initialize($config);
            $data['pagination_links'] = $this->pagination->create_links(); 
            $current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            if($data['pagination_links']!= '') {
                $data['last']=$this->pagination->cur_page*$config['per_page'];
                if($data['last']>$data['total_rows']){
                    $data['last']=$data['total_rows'];
                }
                $data['pagermessage'] = 'Showing '.((($this->pagination->cur_page-1)*$config['per_page'])+1).' to '.($data['last']).' of '.$data['total_rows'];
             } 
             $data['sn'] = $current_offset + 1;
            /* pagination end */

            # Search Results
            /*echo '<br>';
            print_r($data['region_details']);exit;*/
            $data['region_details'] = $this->Location_m->region_results($searchParams,$config['per_page'], $current_offset);
            /*echo '<br>';
            print_r($data['region_details']);exit;*/
            $data['display_results'] = 1;

            $this->load->view('location/region_view', $data);
        }

        public function add_region()
        {
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Manage Region";
            $data['nestedView']['cur_page'] = 'region';
            $data['nestedView']['pageTitle'] = 'Add Region';
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';
            
            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/location.js"></script>';
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'custom/js/additional-methods.js"></script>';

            $data['nestedView']['css_includes'] = array();
            
            # Breadcrumbs
            $data['nestedView']['breadCrumbTite'] = 'Manage Region';
            $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Region','class'=>'active','url'=>SITE_URL.'region');
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Add Region','class'=>'active','url'=>'');

            $data['region_details'] =$this->Common_model->get_data('location',array('level_id' => 2));

            $data['level_id'] = $this->Common_model->get_value('territory_level', array('name'=>'Region'), 'level_id');
            $data['flg'] = 1;
            $data['val'] = 0;

            # Load page with all shop details
            $this->load->view('location/region_view', $data);
        }

        public function edit_region()
        {
            $value=@eip_decode($this->uri->segment(2));
            if($value==''){
                redirect(SITE_URL);
                exit;
            }
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Manage Region";
            $data['nestedView']['cur_page'] = 'region';
            $data['nestedView']['pageTitle'] = 'Edit Region';
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';
            
            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/location.js"></script>';
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'custom/js/additional-methods.js"></script>';

            $data['nestedView']['css_includes'] = array();
            
            # Breadcrumbs
            $data['nestedView']['breadCrumbTite'] = 'Manage Region';
            $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Region','class'=>'active','url'=>SITE_URL.'region');
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Edit Region','class'=>'active','url'=>'');
            //echo $encoded_id;echo '<br>'.@icrm_decode($encoded_id); exit;
            
                
            $where = array('location_id' => $value);

            $data['region_details'] =$this->Common_model->get_data('location',array('level_id' => 2));

            $data['region_edit'] = $this->Common_model->get_data('location', $where);
            $data['parentInfo'] = getParentLocation($value);
            
            $data['flg'] = 2;
            $data['val'] = 1;

            # Load page with all shop details
            $this->load->view('location/region_view', $data);
        }
    //District
    
        public function district()
        {
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Manage District";
            $data['nestedView']['cur_page'] = 'district';
            $data['nestedView']['pageTitle'] = 'Manage District';
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';
            
            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['css_includes'] = array();
            
            # Breadcrumbs
            $data['nestedView']['breadCrumbTite'] = 'Manage Region';
            $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage District','class'=>'active','url'=>'');
            
            # Search Functionality
            $psearch=$this->input->post('search_district', TRUE);
            if($psearch!='') {
            $searchParams=array(
                          'district_name'=>$this->input->post('district_name', TRUE),
                          'region_id'=>$this->input->post('region', TRUE)
                                  );
            $this->session->set_userdata($searchParams);
            } else {
                
                if($this->uri->segment(2)!='')
                {
                $searchParams=array(
                          'district_name'=>$this->session->userdata('district_name'),
                          'region_id'=>$this->session->userdata('region_id')
                                  );
                }
                else {
                    $searchParams=array(
                          'district_name'=>'',
                          'region_id'=>''
                                      );
                    $this->session->unset_userdata(array_keys($searchParams));
                }
                
            }
            $data['searchParams'] = $searchParams;
            
            /* pagination start */
            $config = get_paginationConfig();
            $config['base_url'] = SITE_URL.'district/'; 
            # Total Records
            $config['total_rows'] = $this->Location_m->district_total_num_rows($searchParams);
            
            $config['per_page'] = getDefaultPerPageRecords();
            $data['total_rows'] = $config['total_rows'];
            $this->pagination->initialize($config);
            $data['pagination_links'] = $this->pagination->create_links(); 
            $current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            if($data['pagination_links']!= '') {
                $data['last']=$this->pagination->cur_page*$config['per_page'];
                if($data['last']>$data['total_rows']){
                    $data['last']=$data['total_rows'];
                }
                $data['pagermessage'] = 'Showing '.((($this->pagination->cur_page-1)*$config['per_page'])+1).' to '.($data['last']).' of '.$data['total_rows'];
             } 
             $data['sn'] = $current_offset + 1;
            /* pagination end */
           
                /*echo '<pre>';print_r($data['region_details']);exit;*/
            # Search Results
            $data['district_results'] = $this->Location_m->district_results($searchParams,$config['per_page'], $current_offset);
            //print_r($data['district_results']);die();
            $data['display_results'] = 1;
            $this->load->view('location/district_view', $data);
        }
        public function add_district()
        {
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Manage District";
            $data['nestedView']['cur_page'] = 'district';
            $data['nestedView']['pageTitle'] = 'Add District';
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';
            
            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/location.js"></script>';

            $data['nestedView']['css_includes'] = array();
            
            # Breadcrumbs
            $data['nestedView']['breadCrumbTite'] = 'Manage Region';
            $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage District','class'=>'active','url'=>SITE_URL.'region');
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Add District','class'=>'active','url'=>'');

            /*$data['region_details'] =$this->Location_m->get_regions();*/

            $data['level_id'] = $this->Common_model->get_value('territory_level', array('name'=>'District'), 'level_id');
            $data['flg'] = 1;
            $data['val'] = 0;

            # Load page with all shop details
            $this->load->view('location/district_view', $data);
        }
        public function edit_district()
        {
            $value=@eip_decode($this->uri->segment(2));
            if($value==''){
                redirect(SITE_URL);
                exit;
            }
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Manage Region";
            $data['nestedView']['cur_page'] = 'region';
            $data['nestedView']['pageTitle'] = 'Edit Region';
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';
            
            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/location.js"></script>';

            $data['nestedView']['css_includes'] = array();
            
            # Breadcrumbs
            $data['nestedView']['breadCrumbTite'] = 'Manage Region';
            $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Region','class'=>'active','url'=>SITE_URL.'region');
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Edit Region','class'=>'active','url'=>'');
            //echo $encoded_id;echo '<br>'.@icrm_decode($encoded_id); exit;
            
                
            $where = array('location_id' => $value);

            $data['region_details'] =$this->Common_model->get_data('location',array('level_id' => 3));

            $data['district_edit'] = $this->Common_model->get_data('location', $where);
            $data['parentInfo'] = getParentLocation($value);

            
            $data['flg'] = 2;
            $data['val'] = 1;

            # Load page with all shop details
            $this->load->view('location/district_view', $data);
        }
    //Mandal
        public function mandal()
        {
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Manage Mandal";
            $data['nestedView']['cur_page'] = 'mandal';
            $data['nestedView']['pageTitle'] = 'Manage Mandal';
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';
            
            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['css_includes'] = array();
            
            # Breadcrumbs
            $data['nestedView']['breadCrumbTite'] = 'Manage Mandal';
            $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Mandal','class'=>'active','url'=>'');
            
            # Search Functionality
            $psearch=$this->input->post('search_mandal', TRUE);
            if($psearch!='') {
            $searchParams=array(
                          'mandal_name'=>$this->input->post('mandal_name', TRUE),
                          'region_id'=>$this->input->post('region', TRUE),
                          'district_id'=>$this->input->post('district', TRUE)
                                  );
            /*print_r($searchParams);exit;*/
            $this->session->set_userdata($searchParams);
            } else {
                
                if($this->uri->segment(2)!='')
                {
                $searchParams=array(
                          'mandal_name'=>$this->session->userdata('mandal_name'),
                          'region_id'=>$this->session->userdata('region_id'),
                          'district_id'=>$this->session->userdata('district_id')
                                  );
                }
                else {
                    $searchParams=array(
                          'mandal_name'=>'',
                          'region_id'=>'',
                          'district_id'=>''
                                      );
                    $this->session->unset_userdata(array_keys($searchParams));
                }
                
            }
           /* print_r($_POST);
            print_r($searchParams);
            exit();*/
            $data['searchParams'] = $searchParams;
            
            /* pagination start */
            $config = get_paginationConfig();
            $config['base_url'] = SITE_URL.'mandal/'; 
            # Total Records
            $config['total_rows'] = $this->Location_m->mandal_total_num_rows($searchParams);
            
            $config['per_page'] = getDefaultPerPageRecords();
            $data['total_rows'] = $config['total_rows'];
            $this->pagination->initialize($config);
            $data['pagination_links'] = $this->pagination->create_links(); 
            $current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            if($data['pagination_links']!= '') {
                $data['last']=$this->pagination->cur_page*$config['per_page'];
                if($data['last']>$data['total_rows']){
                    $data['last']=$data['total_rows'];
                }
                $data['pagermessage'] = 'Showing '.((($this->pagination->cur_page-1)*$config['per_page'])+1).' to '.($data['last']).' of '.$data['total_rows'];
             } 
             $data['sn'] = $current_offset + 1;
            /* pagination end */
            
            /*$data['region_details'] =$this->Common_model->get_data('location',array('level_id' => 3));*/
            /*echo '<pre>';print_r($data['region_details']);die();*/
            if($searchParams['district_id']>0){
                $data['districts'] = $this->Location_m->get_district_details($searchParams['region_id']);
            }
            # Search Results
            $data['mandal_details'] = $this->Location_m->mandal_results($searchParams,$config['per_page'], $current_offset);
            /*echo '<pre>';print_r($data['area_details']);die();*/
            $data['display_results'] = 1;

            /*$data['region_details'] =$this->Location_m->get_regions();*/


            $this->load->view('location/mandal_view', $data);
        }
        
        public function add_mandal()
        {
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Manage Mandal";
            $data['nestedView']['cur_page'] = 'mandal';
            $data['nestedView']['pageTitle'] = 'Add Mandal';
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';
            
            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/location.js"></script>';

            $data['nestedView']['css_includes'] = array();
            
            # Breadcrumbs
            $data['nestedView']['breadCrumbTite'] = 'Manage Mandal';
            $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Mandal','class'=>'active','url'=>SITE_URL.'mandal');
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Add Mandal','class'=>'active','url'=>'');

            $data['district_details'] =$this->Common_model->get_data('location',array('level_id' => 4));

            $data['level_id'] = $this->Common_model->get_value('territory_level', array('name'=>'Mandal'), 'level_id');
            $data['flg'] = 1;
            $data['val'] = 0;

            # Load page with all shop details
            $this->load->view('location/mandal_view', $data);
        }
        public function edit_mandal($encoded_id)
        {
            $value=@eip_decode($this->uri->segment(2));
            if($value==''){
                redirect(SITE_URL);
                exit;
            }
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Manage Mandal";
            $data['nestedView']['cur_page'] = 'mandal';
            $data['nestedView']['pageTitle'] = 'Edit Mandal';
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';
            
            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/location.js"></script>';

            $data['nestedView']['css_includes'] = array();
            
            # Breadcrumbs
            $data['nestedView']['breadCrumbTite'] = 'Manage Mandal';
            $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Mandal','class'=>'active','url'=>SITE_URL.'mandal');
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Edit Mandal','class'=>'active','url'=>'');
            //echo $encoded_id;echo '<br>'.@icrm_decode($encoded_id); exit;
            
                
            $where = array('location_id' => $value);

            $data['district_details'] =$this->Common_model->get_data('location',array('level_id' => 4));

            $data['mandal_edit'] = $this->Common_model->get_data('location', $where);
            $data['parentInfo'] = getParentLocation($value);
            
            $data['flg'] = 2;
            $data['val'] = 1;

            # Load page with all shop details
            $this->load->view('location/mandal_view', $data);
        }

        //Area
        public function area()
        {
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Manage Area";
            $data['nestedView']['cur_page'] = 'area';
            $data['nestedView']['pageTitle'] = 'Manage Area';
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';
            
            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['css_includes'] = array();
            
            # Breadcrumbs
            $data['nestedView']['breadCrumbTite'] = 'Manage Mandal';
            $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Area','class'=>'active','url'=>'');
            
            # Search Functionality
            $psearch=$this->input->post('search_area', TRUE);
            if($psearch!='') {
            $searchParams=array(
                          'area_name'    =>  $this->input->post('area_name', TRUE),
                          'mandal_id'    =>  $this->input->post('mandal', TRUE),
                          'region_id'    =>  $this->input->post('region', TRUE),
                          'district_id'  =>  $this->input->post('district', TRUE)
                                  );
            /*print_r($searchParams);exit;*/
            $this->session->set_userdata($searchParams);
            } else {
                
                if($this->uri->segment(2)!='')
                {
                $searchParams=array(
                          'area_name'   =>  $this->session->userdata('area_name'),
                          'mandal_id'   =>  $this->session->userdata('mandal_id'),
                          'region_id'   =>  $this->session->userdata('region_id'),
                          'district_id' =>  $this->session->userdata('district_id')
                                  );
                }
                else {
                    $searchParams=array(
                          'area_name'   =>  '',
                          'mandal_id'   =>  '',
                          'region_id'   =>  '',
                          'district_id' =>  ''
                                      );
                    $this->session->unset_userdata(array_keys($searchParams));
                }
                
            }
           /* print_r($_POST);
            print_r($searchParams);
            exit();*/
            $data['searchParams'] = $searchParams;
            
            /* pagination start */
            $config = get_paginationConfig();
            $config['base_url'] = SITE_URL.'area/'; 
            # Total Records
            $config['total_rows'] = $this->Location_m->area_total_num_rows($searchParams);
            
            $config['per_page'] = getDefaultPerPageRecords();
            $data['total_rows'] = $config['total_rows'];
            $this->pagination->initialize($config);
            $data['pagination_links'] = $this->pagination->create_links(); 
            $current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            if($data['pagination_links']!= '') {
                $data['last']=$this->pagination->cur_page*$config['per_page'];
                if($data['last']>$data['total_rows']){
                    $data['last']=$data['total_rows'];
                }
                $data['pagermessage'] = 'Showing '.((($this->pagination->cur_page-1)*$config['per_page'])+1).' to '.($data['last']).' of '.$data['total_rows'];
             } 
             $data['sn'] = $current_offset + 1;
            /* pagination end */
            
            /*$data['region_details'] =$this->Common_model->get_data('location',array('level_id' => 3));*/
            /*echo '<pre>';print_r($data['region_details']);die();*/
            if($searchParams['district_id']>0){
                $data['districts'] = $this->Location_m->get_district_details($searchParams['region_id']);
            }
            if($searchParams['mandal_id']>0){
                $data['mandals'] = $this->Location_m->get_mandal_details($searchParams['district_id']);
            }
            # Search Results
            $data['area_details'] = $this->Location_m->area_results($searchParams,$config['per_page'], $current_offset);
            //echo '<pre>';print_r($data['area_details']);die();
            $data['display_results'] = 1;

            /*$data['region_details'] =$this->Location_m->get_regions();*/


            $this->load->view('location/area_view', $data);
        }
        
        public function add_area()
        {
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Manage Area";
            $data['nestedView']['cur_page'] = 'area';
            $data['nestedView']['pageTitle'] = 'Add Area';
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';
            
            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/location.js"></script>';

            $data['nestedView']['css_includes'] = array();
            
            # Breadcrumbs
            $data['nestedView']['breadCrumbTite'] = 'Manage Mandal';
            $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Area','class'=>'active','url'=>SITE_URL.'area');
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Add Area','class'=>'active','url'=>'');

            $data['district_details'] =$this->Common_model->get_data('location',array('level_id' => 4));
            $data['mandal_details'] =$this->Common_model->get_data('location',array('level_id' => 5));

            $data['level_id'] = $this->Common_model->get_value('territory_level', array('name'=>'Area'), 'level_id');
            $data['flg'] = 1;
            $data['val'] = 0;

            # Load page with all shop details
            $this->load->view('location/area_view', $data);
        }
        public function edit_area($encoded_id)
        {
            $value=@eip_decode($this->uri->segment(2));
            if($value==''){
                redirect(SITE_URL);
                exit;
            }
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Manage Area";
            $data['nestedView']['cur_page'] = 'area';
            $data['nestedView']['pageTitle'] = 'Edit Area';
            $data['nestedView']['parent_page'] = 'master';
            $data['nestedView']['list_page'] = 'location';
            
            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/location.js"></script>';

            $data['nestedView']['css_includes'] = array();
            
            # Breadcrumbs
            $data['nestedView']['breadCrumbTite'] = 'Manage Mandal';
            $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Area','class'=>'active','url'=>SITE_URL.'area');
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Edit Area','class'=>'active','url'=>'');
            //echo $encoded_id;echo '<br>'.@icrm_decode($encoded_id); exit;
            
                
            $where = array('location_id' => $value);

            $data['district_details'] =$this->Common_model->get_data('location',array('level_id' => 4));
            $data['mandal_details'] =$this->Common_model->get_data('location',array('level_id' => 5));

            $data['area_edit'] = $this->Common_model->get_data('location', $where);
            //print_r($data['area_edit']);exit;
            $data['parentInfo'] = getParentLocation($value);
            
            $data['flg'] = 2;
            $data['val'] = 1;

            # Load page with all shop details
            $this->load->view('location/area_view', $data);
        }
}