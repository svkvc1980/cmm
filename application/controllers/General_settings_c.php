<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';
class General_settings_c extends Base_controller {	
	public function __construct() 
	{
    	parent::__construct();
	}
    public function edit_general_settings()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Manage General Settings";
		$data['nestedView']['pageTitle'] = 'Manage General Settings';
		$data['nestedView']['cur_page'] = 'general_settings';
		$data['nestedView']['parent_page'] = 'system_management';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'General Settings','class'=>'active','url'=>'');      
		#data 
		$data['preference_list'] = $this->Common_model->get_data('preference',array('type'=>1));
        $data['form_action'] = SITE_URL.'update_general_settings';
		$this->load->view('settings/general_settings_view',$data);
	}
	public function update_general_settings()
	{
		$setting = $this->input->post('submit',TRUE);
		if($setting == 1)
		{
			$preference = $this->input->post('preference',TRUE);
			$count1 = count($preference);
			$old = $this->input->post('old',TRUE);
			$count = 0;
			foreach ($preference as $key => $value) 
			{ 
				//print_r($value); exit();
				$old_value = $old[$key];
				if($value != $old_value)
				{
					$update_data = array(
						  'value'         => $value,
						  'modified_by'   => $this->session->userdata('user_id'),
						  'modified_time' => date('Y-m-d H:i:s')
						               );
					$where = array('preference_id' => $key);
					$this->db->trans_begin();
					$this->Common_model->update_data('preference',$update_data,$where);
					$insert_data = array(
						'preference_id'  => $key,
						 'value'         => $value,
						 'created_by'	 => $this->session->userdata('user_id'),
						 'created_time'  => date('Y-m-d H:i:s'));
					$this->Common_model->insert_data('preference_history',$insert_data);
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
                            <strong>Success!</strong>General Settings has been Updated successfully! </div>');
					}
				}
				else
				{
					$count++;
				}
			}
			if($count1 == $count)
			{
				$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>No Changes has been Occured !.</div>');
			}
		}
		redirect(SITE_URL.'edit_general_settings');
	}
  
}
?>