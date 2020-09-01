<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';
class Settings extends Base_controller {	
	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Settings_m");
	}

	public function settings_list()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage General Settings";
		$data['nestedView']['pageTitle'] = 'General Settings';
        $data['nestedView']['cur_page'] = 'settings';
        $data['nestedView']['parent_page'] = 'Settings';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Denomination', 'class' => '', 'url' => '');	
        
        $p_search=$this->input->post('search_settings_list', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'name' => $this->input->post('name', TRUE)              
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'name'   => $this->session->userdata('name')
                                  );
            }
            else {
                $search_params=array(
                      'name'    => ''
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'settings_list/';
        # Total Records
        $config['total_rows'] = $this->Settings_m->settings_total_num_rows($search_params);

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
        $data['settings_results'] = $this->Settings_m->settings_results($current_offset, $config['per_page'], $search_params);
       
        # Additional data
        $data['display_results'] = 1;
        $this->load->view('settings/setting_view',$data);

    }
    public function add_general_settings()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage General Settings";
        $data['nestedView']['pageTitle'] = 'Add General Settings';
        $data['nestedView']['cur_page'] = 'add_general_settings';
        $data['nestedView']['parent_page'] = 'Settings';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/settings.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Denomination', 'class' => '', 'url' => SITE_URL.'capacity');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New Denomination', 'class' => 'active', 'url' => '');
        
        # Search Functionality
        # Data
       /* $row = $this->Common_model->get_data('preference',array('preference_id'=>$preference_id));
        $data['preference_row'] = $row[0];*/
        # Additional data
        $data['preference_list'] = $this->Common_model->get_data('preference',array('type'=>1));
		$data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_general_settings';
        $data['display_results'] = 0;
		$this->load->view('settings/setting_view',$data);
    }
    public function insert_general_settings()
    {
        $this->session->set_userdata('user_id','1');
        // GETTING INPUT TEXT VALUES
        $data = array( 
        			'section'         =>$this->input->post('section',TRUE),
                    'name'            =>$this->input->post('name',TRUE),
                    'value'           =>$this->input->post('value',TRUE),
                    'lable'           =>$this->input->post('lable',TRUE), 
                    'type'            =>$this->input->post('type',TRUE),  
                    'created_by'      =>$this->session->userdata('user_id'),
                    'created_time'    =>date('Y-m-d H:i:s')                   
                    );
        $this->db->trans_begin();
        $preference_id = $this->Common_model->insert_data('preference',$data);
        $data1 =array(
        			'preference_id' =>$preference_id,
        			'value'         =>$this->input->post('value',TRUE)
        	);
        $this->Common_model->insert_data('preference_history',$data1);
        if($this->db->trans_status() === FALSE)
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
                <strong>Success!</strong>General Settings has been inserted successfully! </div>');
        }

        redirect(SITE_URL.'settings_list');  
    }
     public function edit_settings()
    {
        $preference_id=@cmm_decode($this->uri->segment(2));
        if($preference_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Settings";
        $data['nestedView']['pageTitle'] = 'Edit Settings';
        $data['nestedView']['cur_page'] = 'edit_settings';
        $data['nestedView']['parent_page'] = 'Settings';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/settings.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Settings', 'class' => '', 'url' => SITE_URL.'settings_list');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Settings', 'class' => 'active', 'url' => '');
        $data['preference_list'] = $this->Common_model->get_data('preference',array('type'=>1));
        # Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'update_settings';
        $data['display_results'] = 0;

        # Data
        $row = $this->Common_model->get_data('preference',array('preference_id'=>$preference_id));
        $data['preference_row'] = $row[0];
        $this->load->view('settings/setting_view',$data);
    }
 
    public function update_settings()
    {
        $preference_id=@$this->input->post('preference_id',TRUE);
        if($preference_id==''){
            redirect(SITE_URL.'settings_list');
            exit;
        }
        // GETTING INPUT TEXT VALUES
        $data = array( 
                    'section'        =>$this->input->post('section',TRUE),
                    'name'           =>$this->input->post('name',TRUE),
                    'value'          =>$this->input->post('value',TRUE),
                    'lable'          =>$this->input->post('lable',TRUE), 
                    'type'           =>$this->input->post('type',TRUE),  
                    'modified_by'    => $this->session->userdata('user_id'),
                    'modified_time'  => date('Y-m-d H:i:s')                   
                    );
        $this->db->trans_begin();
        $where = array('preference_id'=>$preference_id);
        $this->Common_model->update_data('preference',$data,$where);
        $old_value = $this->Common_model->get_value('preference',array('preference_id'=>$preference_id),'value');
        $value = $this->input->post('value',TRUE);
        if($value != $old_value){
             $data1 =array(
                    'preference_id' =>$preference_id,
                    'value'         =>$value,
                    'created_by'    => $this->session->userdata('user_id'),
                    'created_time'  => date('Y-m-d H:i:s')
            );
        $this->Common_model->insert_data('preference_history',$data1);

        }
       
        if($this->db->trans_status() === FALSE)
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
                <strong>Success!</strong>Settings has been Updated successfully! </div>');
        }
        redirect(SITE_URL.'settings_list');  
    }
    
    //name unique..
    public  function is_nameExist()
     {
        $name = $this->input->post('preference_name');
        $preference_id = $this->input->post('identity');
        $section =$this->input->post('preference_section');
        echo $this->Settings_m->is_nameExist($name,$preference_id,$section);
    }
}
?>