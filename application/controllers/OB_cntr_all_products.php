<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class OB_cntr_all_products extends Base_controller {

    /* Dispalying  C and F credit debit list
    Author:Aswini
    Time:21-02-2017*/
	
	
    public function ob_booking_for_all_products()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = 'Start/Stop All Product Bookings';
		$data['nestedView']['pageTitle'] = 'Start/Stop All Product Bookings';
		$data['nestedView']['cur_page'] = 'ob_booking_for_all_products';
		$data['nestedView']['parent_page'] = 'ob_control';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Start/Stop All Product Bookings','class'=>'active','url'=>'');
		#data 
		
		$data['ob_status']=get_preference('all_products_ob_status','ob_control');

		if($this->input->post('submit')==1)
		{
			$value=$this->input->post('status');
			$old_value = get_preference('all_products_ob_status','ob_control');
			if($value!=$old_value)
			{
				$data['ob_start'] =set_preference('all_products_ob_status',$value,'ob_control');
				$history=array(
						'status'		=>  $value,
						'created_by'	=>	$this->session->userdata('user_id'),
						'created_time'	=>	date('Y-m-d H:i:s')
					   );
				$ob_history=$this->Common_model->insert_data('ob_status_history',$history);
				if($value==1)
				{
					$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Success!</strong>Bookings for All products are Started ! </div>');

				}
				else if($value==2)
				{
					$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Success!</strong>Bookings for All products are Stopped ! </div>');

				}
				redirect(SITE_URL.'ob_booking_for_all_products');
			}
		}

		//
        $data['form_action'] = SITE_URL.'ob_booking_for_all_products';
		$this->load->view('order_booking/ob_start_stop_all_products',$data);
	}
}
?>