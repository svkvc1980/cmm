<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Executive_limit extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
	}

	public function executive_limit()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = 'Executive Limit';
		$data['nestedView']['pageTitle'] = 'Executive Limit';
		$data['nestedView']['cur_page'] = 'executive_limit_ob';
		$data['nestedView']['parent_page'] = 'ob_control';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Executive Limit','class'=>'active','url'=>'');

		$data['exe_limit_status']=get_preference('executive_limit_control_status','executive_limit_control');
		$old_value = get_preference('executive_limit_control_status','executive_limit_control');

		if($this->input->post('submit')==TRUE)
		{
			$value=$this->input->post('status');
			

			if($value!=$old_value)
			{
				
				$history=array(
						'value'			=>  $value,
						'modified_by'	=>	$this->session->userdata('user_id'),
						'modified_time'	=>	date('Y-m-d H:i:s')
					   );
					   $pref_id = $this->Common_model->get_value('preference',array('name'=>'executive_limit_control_status'),'preference_id');
				$executive_limit = $this->Common_model->update_data('preference',$history,array('preference_id'=>$pref_id)); 
				
				if($value==1)
				{
					$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                    			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    			<strong>Success!</strong>Limit for Executives are Started ! </div>');
				}
				else if($value==2)
				{
					$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Success!</strong>Limit for Executives are Stopped ! </div>');
				}
				redirect(SITE_URL.'executive_limit');
			}
		}
		
		# Search Functionality
		$psearch=$this->input->post('action', TRUE);
		if($psearch!='') {
		$searchParams=array(
					  'executive_id'=>$this->input->post('executive', TRUE)
					 		  );
		$this->session->set_userdata($searchParams);
		} else {
			
			if($this->uri->segment(2)!='')
			{
			$searchParams=array(
					  'executive_id'=>$this->session->userdata('executive')
							  );
			}
			else {
				$searchParams=array(
					  'executive_id'=>''
					  			  );
				$this->session->unset_userdata(array_keys($searchParams));
			}
			
		}
		$data['executive_id'] = @$searchParams['executive_id'];
		$executive_limit = array();
		if(@$data['executive_id']>0)
		{
			$results = $this->Common_model->get_data('executive_limit',array('executive_limit_id'=>@$data['executive_limit_id'],'status'=>1));
			foreach ($results as $exc_row) 
			{
				$executive_limit[]=$exc_row['executive_id'];
			}
		}
		$data['executive_limit'] = $executive_limit;


		# Search Results
		$pqry = 'SELECT * FROM loose_oil WHERE status = 1 ORDER BY loose_oil_id';
		$pres = $this->db->query($pqry);
		$data['loose_oil'] = $pres->result_array();

		$qry = 'SELECT * FROM executive';
		$res = $this->db->query($qry);
		$data['executive'] = $res->result_array();

		$exe_limit = $this->Common_model->get_data('executive_limit', array('status' => 1));
		foreach ($exe_limit as $key => $value) 
		{
		 	@$result[$value['loose_oil_id']][$value['executive_id']]=$value['ob_limit'];
		} 
		$data['results']=@$result;
		$data['exe_id']=$this->input->post('executive');
	   	$data['flag'] = 2;
		$data['displayList'] = 1;
		$this->load->view('executive/executive_limit_view',$data);
	}

	public function submit_executive_limit()
	{
		if($this->input->post('save_changes')!='')
		{
			$user_id = $this->session->userdata('user_id');
			$this->db->trans_begin();
			$executive_id = $this->input->post('executive');

			// insert loose oil id and limit value
			$limit = $this->input->post('limit');
			if($limit)
			{   
				$batch_data = array();
				//looping 
				foreach ($limit as $key=> $value) 
				{
					if($value!=0)
					{
						$qry='SELECT ob_limit From executive_limit Where loose_oil_id='.$key.' and executive_id='.$executive_id.' ';
						$count = $this->Common_model->get_no_of_rows($qry);
		                if($count>0)
		                {
		                    $qry = 'UPDATE executive_limit SET ob_limit='.$value.', modified_by='.$user_id.', modified_time = NOW() WHERE loose_oil_id='.$key.' and executive_id='.$executive_id.' ';
		                    $this->db->query($qry); 
		                }
		                else
		                {
		                	$dat = array(
							'loose_oil_id' => $key,
							'executive_id' => $executive_id,
							'ob_limit'     => $value,
							'created_time' => date('Y-m-d H:i:s'),
							'created_by'   => $user_id,
							'status'	   => 1
							);
						
						    $this->Common_model->insert_data('executive_limit', $dat);
						}
					}
					
				} 

				if ($this->db->trans_status() === FALSE)
				{
						$this->db->trans_rollback();
						$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
											<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
											<strong>Error!</strong> There\'s a problem occured while saving Executive Limits!
										 </div>');
				}
				else
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
											<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
											<strong>Success!</strong>Executive Limits have been saved successfully!
										 </div>');
				}
			}
		}
		redirect(SITE_URL.'executive_limit');
	}
}