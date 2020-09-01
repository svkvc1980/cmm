<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 /* 
 	Created By 		:	Srilekha
 	Module 			:	Product Micron - Insert Update
 	Created Time 	:	16th March 2017 01:17 PM
 	Modified Time 	:	
*/
class Product_micron extends Base_controller {

	public function __construct() 
    {
        parent::__construct();      
    }

    public function product_micron()
    {
    	# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Film Distribution";
		$data['nestedView']['pageTitle'] = 'Film Distribution Details';
        $data['nestedView']['cur_page'] = 'opening_stock_entry_for_film_type';
        $data['nestedView']['parent_page'] = 'opening_stock_entry';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Film Distribution Details', 'class' => '', 'url' => '');

        # Get Micron Data
        $data['micron']= $this->Common_model->get_data('micron',array('status'=>1));
        $qry = 'SELECT name FROM micron WHERE status = 1';
		$data['micron_count'] = $this->Common_model->get_no_of_rows($qry);

		# Get Capacity Micron Results
        $product_micron_results= $this->Common_model->get_data('plant_film_stock',array('status'=>1));

        foreach($product_micron_results as $key =>$value)
        {
        	
        	$results[$value['pm_id']][$value['micron_id']]=$value['quantity'];
        } 
       $data['results']=@$results;

		$plant_id=$this->session->userdata('ses_plant_id');
		$user_id=$this->session->userdata('user_id');
        $film_id=get_film_id();
       	$data['capacity'] = get_film_order_by();
        if($this->input->post('product_micron'))
        {
        	$dat = $this->input->post('product_micron_value', TRUE);
        	$this->db->trans_begin();
        	foreach($dat as $key => $value)
        	{
        		if(count($value) !=0)
        		{
        			$qry = 'SELECT quantity FROM plant_pm WHERE plant_id = "'.$plant_id.'" AND pm_id = "'.$key.'" ';
		 			$product_pm_count = $this->Common_model->get_no_of_rows($qry);
					$pm_quantity=array_sum($value);
					if($pm_quantity>0)
					{
			 			if($product_pm_count>0)
			 			{
			 				$where=array('plant_id'=>$plant_id,'pm_id'=>$key);
			 				$quant = array('quantity'=>$pm_quantity);
			 				$this->Common_model->update_data('plant_pm',$quant,$where);
			 			}
			 			else
			 			{
			        		$plant_pm=array('pm_id'=>$key,'plant_id'=>$plant_id,'quantity'=>$pm_quantity,'updated_time'=>date('Y-m-d H:i:s'));
			        		$this->Common_model->insert_data('plant_pm',$plant_pm);
			 			}
					}
		 			foreach ($value as $key1 => $value1) 
	        		{
	        			 
	        			if($value1 !=0)
	        			{
	        				$qry = 'SELECT quantity FROM plant_film_stock WHERE plant_id = "'.$plant_id.'" AND micron_id="'.$key1.'" AND pm_id = "'.$key.'" ';
		 					$product_micron_count = $this->Common_model->get_no_of_rows($qry);
		 					if($product_micron_count>0)
		 					{
		 						$where=array('plant_id'=>$plant_id,'micron_id'=>$key1,'pm_id'=>$key);
		 						$micron_quantity=array('quantity'=>$value1,'modified_by'=>$user_id,'modified_time'=>date('Y-m-d H:i:s'));
		 						$this->Common_model->update_data('plant_film_stock',$micron_quantity,$where);
		 					}
		 					else
		 					{
		 						$product_micron_data = array('pm_id' => $key,'micron_id' => $key1,'quantity' => $value1,'plant_id'=>$plant_id);
	        					$this->Common_model->insert_data('plant_film_stock',$product_micron_data);
		 					}

	        			}
	        			
	        		}
        		}
        		  
        	} 
        	if ($this->db->trans_status()===FALSE)
        	{
        		$this->db->rollback();
        		$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Please check.</strong> No Changes Occured.  </div>'); 
        		redirect(SITE_URL.'product_micron');
        	}
        	else
        	{
        		$this->db->trans_commit();
        		$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Product Micron Values has been added successfully! </div>');
		 		redirect(SITE_URL.'product_micron');
        	} 
        }
        //$data['flag']=1;
        $this->load->view('product/product_micron_view',$data);
    }

}