<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 /* 
 	Created By 		:	Priyanka 
 	Module 			:	Capacity Micron - Insert Update
 	Created Time 	:	8th Feb 2017 11:23 AM
 	Modified Time 	:	
*/
class Capacity_micron extends Base_controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Capacity_micron_model");
        $this->load->model("Common_model");               
    }

    public function capacity_micron()
    {
    	# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Film Distribution";
		$data['nestedView']['pageTitle'] = 'Film Distribution Details';
        $data['nestedView']['cur_page'] = 'capacity_micron';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Film Distribution Details', 'class' => '', 'url' => '');	

        # Get Micron Data
        $data['micron']= $this->Common_model->get_data('micron',array('status'=>1));
        $query = 'SELECT * FROM capacity_micron';
        $data['capacity_micron_num_count']= $this->Common_model->get_no_of_rows($query);

        # Get Capacity Micron Results
        $capacity_micron_results= $this->Capacity_micron_model->get_capacity_micron_results();
        foreach($capacity_micron_results as $key =>$value)
        {
        	$results[$value['capacity_id']][$value['micron_id']]=$value['value'];
        }
       $data['results']=@$results;


        $qry = 'SELECT name FROM micron WHERE status = 1';
		$data['micron_count'] = $this->Common_model->get_no_of_rows($qry);

		# Get Capacity Data
		$data['capacity'] = $this->Capacity_micron_model->get_capacity_unit_data();
		//echo "<pre>"; print_r($data['capacity']);exit;

		# Insert Update Data
		 if($this->input->post('capacity_micron'))
		 {
		 	$dat = $this->input->post('capacity_microne_value', TRUE);
		 	//echo "<pre>"; print_r($dat);exit;
		 	foreach ($dat as $key => $value) 
		 	{
		 		foreach ($value as $key1 => $value1) 
		 		{
		 			if($value1 !='')
		 			{
		 				$qry = 'SELECT value FROM capacity_micron WHERE capacity_id = "'.$key.'" AND micron_id = "'.$key1.'" ';
		 				$capacity_micron_count = $this->Common_model->get_no_of_rows($qry);
		 				//print_r($capacity_micron_count);exit;
		 				$capacity_micron_data = array('capacity_id' => $key,'micron_id' => $key1,'value' => $value1);
		 				if($capacity_micron_count != '')
		 				{
		 					$qry = 'SELECT value FROM capacity_micron WHERE capacity_id = "'.$key.'" AND micron_id = "'.$key1.'" ';
		 					$res=$this->db->query($qry);
		 					$result=$res->row_array();
		 					$db_value=$result['value'];
		 					if($db_value!=$value1)
		 					{
		 						# Update Capacity Micron Values		 					
			 					$where = array('capacity_id'=>$key,'micron_id' => $key1);
			 					$capacity_micron_history_data = array('end_time' => date('Y-m-d'));
			 					$this->Common_model->update_data('capacity_micron_history',$capacity_micron_history_data,$where);

			 					$capacity_micron_history = array('capacity_id' => $key,'micron_id' => $key1,'value' => $value1,'start_time' => date('Y-m-d'));
	        					$this->Common_model->update_data('capacity_micron',$capacity_micron_data,$where);
	        					$capacity_micron_history_update =  $this->Common_model->insert_data('capacity_micron_history',$capacity_micron_history);
		 					}
		 					
		 				}
		 				else
		 				{
		 					# Insert Capacity Micron Values		 					
		 					$capacity_micron_history_data = array('capacity_id' => $key,'micron_id' => $key1,'value' => $value1,'start_time' => date('Y-m-d'));
		 					$this->Common_model->insert_data('capacity_micron',$capacity_micron_data);
		 					$capacity_micron_history_id = $this->Common_model->insert_data('capacity_micron_history',$capacity_micron_history_data);
		 				}
		 				
		 			}
		 			else
		 			{
		 				$capacity_micron_history_data = array('capacity_id' => $key,'micron_id' => $key1,'value' => $value1,'start_time' => date('Y-m-d'));
		 					$this->Common_model->insert_data('capacity_micron',$capacity_micron_data);
		 			}
		        }
		 		
		 	}

		 	if(@$capacity_micron_history_id != '')
		 	{
		 		$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Capacity Micron Values has been added successfully! </div>');
		 		redirect(SITE_URL.'capacity_micron');
		 	}
		 	else if(@$capacity_micron_history_update != '')
		 	{
		 		$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Capacity Micron Values has been Updated successfully! </div>');
		 		redirect(SITE_URL.'capacity_micron');
		 	}
		 	else
		 	{
		 		$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Please check.</strong> No Changes Occured.  </div>');  
		 	}
		 	
		 }		


        # Additional data
		$data['form_action']     = SITE_URL.'capacity_micron';
        $this->load->view('capacity_micron/capacity_micron',$data);
    }
}