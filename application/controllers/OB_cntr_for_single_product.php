<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';
class OB_cntr_for_single_product extends Base_controller {

    /* Dispalying  Ob control
    Author:Aswini
    Time:21-02-2017*/
	
	
    public function ob_booking_for_single_product()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Start/Stop Bookings for Individual product";
		$data['nestedView']['pageTitle'] = 'Start/Stop Bookings for Individual product';
		$data['nestedView']['cur_page'] = 'ob_booking_for_single_product';
		$data['nestedView']['parent_page'] = 'ob_control';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Start/Stop Bookings for Individual product','class'=>'active','url'=>'');

		#data 
		$data['loose_oil'] = array('' =>'Select Loose Oil')+$this->Common_model->get_dropdown('loose_oil','loose_oil_id','name');
        $status=$this->input->post('value');
        $loose_oil_id=$this->input->post('loose_oil');
        $oil_name=$this->Common_model->get_value('loose_oil',array('loose_oil_id'=>$loose_oil_id),'name');
         if($status==1)
         {
         	$stat='started';
         }
         else if($status==2)
         {
         	$stat='stopped';
         }
         else
         {
         	$stat='Some Thing went wrong';
         }
        $val=array(
					
					'ob_status' =>  $status  
				   );
        
		$where =array('loose_oil_id'=> $loose_oil_id);
		$this->db->trans_begin();
		$ob_history=$this->Common_model->update_data('loose_oil',$val,$where);
		if($this->input->post('loose_oil',TRUE))
		{
			$history=array(
                        'loose_oil_id' => $this->input->post('loose_oil'),
                        'status'       => $status,
                        'created_by'   => $this->session->userdata('user_id'),
                        'created_time' => date('Y-m-d H:i:s')
                                 	);
			$loose_oil_history=$this->Common_model->insert_data('oil_ob_status_history',$history);
			if($this->db->trans_status()=== FALSE)
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
	                                                        <strong>Success!</strong> '.$oil_name.' has been '.$stat.' successfully! </div>');
			}
		}
		
		$data['oil_results']=$this->Common_model->get_data('loose_oil',array('status'=>1));
        $data['form_action'] = SITE_URL.'ob_booking_for_single_product';
		$this->load->view('order_booking/ob_start_stop_single_product',$data);
	}
}
?>