<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 9th Feb 2016 09:00 AM

class Pm_consumption extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Loose_oil_lab_test_m");
        $this->load->model("Pm_consumption_m");
	}


	public function manage_pm_consumption()
	{ 
        /*$a1=array(1,2);
        $a2=array(3,4);echo '<pre>';
        $a3= array_merge($a1,$a2);//exit;
        if(count(array_unique($a3)) < count($a3))*/
        
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Packing Material Consumption";
		$data['nestedView']['pageTitle'] = 'Manage P M Consumption';
        $data['nestedView']['cur_page'] = 'manage_pm_consumption';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PM Consumption', 'class' => 'active', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_pm_consumption', TRUE);
        if($p_search!='') 
        {
            $search_params=array('product_id'     => $this->input->post('product_id', TRUE));
            $this->session->set_userdata($search_params);
        } 
        else 
        {            
            if($this->uri->segment(2)!='')
            {
                $search_params=array('product_id' => $this->session->userdata('product_id'));
            }
            else 
            {
                $search_params=array('product_id'  => '');
                $this->session->set_userdata($search_params);
            }            
        }
        $data['search_data'] = $search_params;

        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'manage_pm_consumption/';
        # Total Records
        $config['total_rows'] = $this->Pm_consumption_m->pm_consumption_total_num_rows($search_params);

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
        $data['pm_consumption_results'] = $this->Pm_consumption_m->pm_consumption_results($current_offset, $config['per_page'], $search_params);
        $data['product'] = $this->Common_model->get_data('product',array('status'=>'1'));

        # Additional data
        $data['display_results'] = 1;
        $this->load->view('pm_consumption/pm_consumption_view',$data);
    }
    
    public function add_pm_consumption()
    {

        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add Pm Consumption";
        $data['nestedView']['pageTitle'] = 'Add Pm Consumption';
        $data['nestedView']['cur_page'] = 'manage_pm_consumption';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/add_pm_consumption.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Pm Consumption', 'class' => '', 'url' => SITE_URL.'manage_pm_consumption');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add Pm Consumption', 'class' => 'active', 'url' => '');
        
        # Additional data
        $data['products'] = $this->Common_model->get_data('product',array('status'=>'1'));
        
        
        $data['form_action'] = SITE_URL.'add_pm_consumption_list';
        $data['display_results'] = 3;
        $this->load->view('pm_consumption/add_pm_consumption_view',$data);
    }    
    public function add_pm_consumption_list()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add Pm Consumption List";
        $data['nestedView']['pageTitle'] = 'Add Pm Consumption List';
        $data['nestedView']['cur_page'] = 'manage_pm_consumption';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/add_pm_consumption_list.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Pm Consumption', 'class' => '', 'url' => SITE_URL.'manage_pm_consumption');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add Pm Consumption ', 'class' => 'active', 'url' => 'add_pm_consumption');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add Pm Consumption List', 'class' => 'active', 'url' => '');

        # Data
        
        # Additional data
        /*$product_id = cmm_decode(@$this->uri->segment(2));
        print_r($product_id);exit;
        echo $product_id;
        echo '123';exit;*/
        
        if(cmm_decode($this->uri->segment(2))!='')
        {
            //echo cmm_decode(@$this->uri->segment(2));exit; 
            $data['product_id'] = cmm_decode(@$this->uri->segment(2));
        }
        else{
            $data['product_id']  = $this->input->post('product_id',TRUE); 
        }
        //echo cmm_decode($this->uri->segment(2));exit;
       //print_r($this->uri->segment(2));exit;

        if($data['product_id']=='')
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> Something Went Wrong Please Check. </div>');       
            redirect(SITE_URL.'add_pm_consumption');
        }
        $data1 = $this->Common_model->get_data('product_packing_material',array('product_id'=>$data['product_id']));
        if(count($data1)){
            //echo $data['product_id'];exit;
             $this->session->set_flashdata('response','<div class="alert alert-warning alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> For this Product You Already Added some packing Materials,so please edit and add here. </div>');           
             redirect(SITE_URL.'edit_pm_consumption/'.cmm_encode($data['product_id'])); 
        }
        $data['primary_type'] = $this->Pm_consumption_m->get_primary_type($data['product_id']);
        
        $data['secondary_type'] = $this->Pm_consumption_m->get_secondary_type($data['product_id']);
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_pm_consumption';
        $data['display_results'] = 0;
        $this->load->view('pm_consumption/add_pm_consumption_view',$data);
    }    
    public function insert_pm_consumption()
    { 
        // echo '<pre>';
        // print_r($_POST);
        // exit;

        if((count(array_unique($_POST['pm_id1'])) == count($_POST['pm_id1'])) && count(array_unique($_POST['pm_id2'])) == count($_POST['pm_id2']) ) 
        {
            $product_id=$this->input->post('product_id',TRUE);
            $capacity_id = get_capacity_id($product_id);

            $this->db->trans_begin();
            foreach ($_POST['pm_id1'] as $key => $value)
            {            
                if($value!='' && $_POST['quantity1'][$key]!='')
                {
                    $this->Pm_consumption_m->insert_update_pm_consumption($product_id,$capacity_id,$value,$_POST['quantity1'][$key]);  
                }
                else
                {                
                     $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                            <strong>Error!</strong> Something went wrong. Please check. </div>');       
                }            
            }
            foreach ($_POST['pm_id2'] as $key => $value)
            {            
                if($value!='' && $_POST['quantity2'][$key]!='')
                {
                    $this->Pm_consumption_m->insert_update_pm_consumption($product_id,$capacity_id,$value,$_POST['quantity2'][$key]);  
                }
                else
                {                
                     $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                            <strong>Error!</strong> Something went wrong. Please check. </div>');       
                }            
            }
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                            <strong>Error!</strong> Something went wrong. Please check. </div>');       
            }
            else
            {
                $this->db->trans_commit();

                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Success!</strong> Tests has been added successfully! </div>');
            }
            redirect(SITE_URL.'add_pm_consumption');
            
        } 
        else
        {
             $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> Please Select Different Packing Material. </div>');       
            redirect(SITE_URL.'add_pm_consumption_list/'.cmm_encode($this->input->post('product_id')));  
        }                     
    }

    public function view_pm_consumption()
    {
        $product_id=@cmm_decode($this->uri->segment(2));
        if($product_id==''){
            redirect(SITE_URL.'manage_pm_consumption');
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="View PM Consumption Details";
        $data['nestedView']['pageTitle'] = 'View PM Consumption Details';
        $data['nestedView']['cur_page'] = 'manage_pm_consumption';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PM Consumption', 'class' => '', 'url' => SITE_URL.'manage_pm_consumption');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'View PM Consumption', 'class' => 'active', 'url' => '');

        # Data
        $data['product_id'] =$product_id;
        $data['results1'] = $this->Pm_consumption_m->get_primary_consumption_data($product_id);
        $data['results2'] = $this->Pm_consumption_m->get_secondary_consumption_data($product_id);
        $data['flg'] = 1;
        $data['display_results'] =0;

        $this->load->view('pm_consumption/pm_consumption_view',$data);
    }
    public function edit_pm_consumption()
    {
        $product_id=@cmm_decode($this->uri->segment(2));       
        if($product_id == '' ){
            redirect(SITE_URL.'manage_pm_consumption');
        }        
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Pm Consumption";
        $data['nestedView']['pageTitle'] = 'Edit Pm Consumption';
        $data['nestedView']['cur_page'] = 'manage_pm_consumption';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/edit_pm_consumption.js"></script>';

        $data['nestedView']['css_includes'] = array();
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Pm Consumption', 'class' => '', 'url' => SITE_URL.'manage_pm_consumption');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Pm Consumption', 'class' => 'active', 'url' => '');
        
        $data['primary_type'] = $this->Pm_consumption_m->get_primary_type($product_id);        
        $data['secondary_type'] = $this->Pm_consumption_m->get_secondary_type($product_id);
        $data['results1'] = $this->Pm_consumption_m->get_primary_consumption_data($product_id);
        $data['results2'] = $this->Pm_consumption_m->get_secondary_consumption_data($product_id);
        /*echo '<pre>';
        print_r($data['results']);exit;*/
        $data['product_id'] = $product_id;
        $data['flg'] =1;
        $data['form_action'] = SITE_URL.'update_pm_consumption';        
        $this->load->view('pm_consumption/edit_pm_consumption_view',$data);
    }
    
    public function update_pm_consumption()
    {  
        /*echo '<pre>';
        print_r($_POST);*/
        //echo count($_POST['pm_id3']);
        $post_pm_id3 =array();
        foreach ($_POST['pm_id3'] as $key => $value) {
            if($value!='')
                $post_pm_id3['pm_id3'][$key] = $value;
        }
        $post_pm_id4 =array();
        foreach ($_POST['pm_id4'] as $key => $value) {
            if($value!='')
                $post_pm_id4['pm_id4'][$key] = $value;
        }
        /*echo count($post_pm_id3);print_r($post_pm_id3);exit;
        exit;
        exit;*/
        $pm_id1 = $_POST['pm_id1'];
        //$pm_id3 = $_POST['pm_id3'];
        if(count($post_pm_id3)>0)
        {
            $pm_1_3 = array_merge($pm_id1,$post_pm_id3);
        }
        else{
                $pm_1_3 = $pm_id1;
        }
        $pm_id2 = $_POST['pm_id2'];
       // $pm_id4 = $_POST['pm_id4'];
        //$pm_2_4 = array_merge($pm_id2,$pm_id4);
        if(count($post_pm_id4)>0)
        {
            $pm_2_4 = array_merge($pm_id2,$post_pm_id4);
        }
        else
        {
                $pm_2_4 = $pm_id2;
        }
       
        if(count(array_unique($pm_1_3)) == count($pm_1_3) && count(array_unique($pm_2_4)) == count($pm_2_4) ) 
        { 
            $product_id=$this->input->post('product_id',TRUE);
            $capacity_id = get_capacity_id($product_id);

            $this->db->trans_begin();
            foreach ($_POST['pm_id1'] as $key => $value)
            {            
                if($value!='' && $_POST['quantity1'][$key]!='')
                {
                    $this->Pm_consumption_m->insert_update_pm_consumption($product_id,$capacity_id,$value,$_POST['quantity1'][$key]);  
                }
                else
                {                
                     $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                            <strong>Error!</strong> Something went wrong. Please check. </div>');       
                }            
            }
            if(count($post_pm_id3)>0)
            {
                foreach ($post_pm_id3['pm_id3'] as $key => $value)
                {            
                    if($value!='' && $_POST['quantity3'][$key]!='')
                    {
                        $this->Pm_consumption_m->insert_update_pm_consumption($product_id,$capacity_id,$value,$_POST['quantity3'][$key]);  
                    }
                    else
                    {                
                         $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                                <strong>Error!</strong> Something went wrong. Please check. </div>');       
                    }            
                }
            }
            foreach ($_POST['pm_id2'] as $key => $value)
            {            
                if($value!='' && $_POST['quantity2'][$key]!='')
                {
                    $this->Pm_consumption_m->insert_update_pm_consumption($product_id,$capacity_id,$value,$_POST['quantity2'][$key]);  
                }
                else
                {                
                     $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                            <strong>Error!</strong> Something went wrong. Please check. </div>');       
                }            
            }
            if(count($post_pm_id4)>0)
            {
                foreach ($post_pm_id4['pm_id4'] as $key => $value)
                {            
                    if($value!='' && $_POST['quantity4'][$key]!='')
                    {
                        $this->Pm_consumption_m->insert_update_pm_consumption($product_id,$capacity_id,$value,$_POST['quantity4'][$key]);  
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
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                            <strong>Error!</strong> Something went wrong. Please check. </div>');       
            }
            else
            {
                $this->db->trans_commit();

                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Success!</strong> Tests has been added successfully! </div>');
            }
            redirect(SITE_URL.'manage_pm_consumption');
            
        } 
        else
        {   
             $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> Please Select Different Packing Material For a Product. </div>');       
            redirect(SITE_URL.'edit_pm_consumption/'.cmm_encode($this->input->post('product_id')));  
        }      
         
    }
}