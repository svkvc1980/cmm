<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Product_pm_weight extends Base_controller {

	public function __construct() 
    {
        parent::__construct();
        //$this->load->model("Product_model");
    }

/*Product Details details
Author:Srilekha
Time: 11.20AM 14-03-2017 */
	public function product_pm_weight()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Product Pm Weight";
        $data['nestedView']['pageTitle'] = 'Product Pm Weight';
        $data['nestedView']['cur_page'] = 'product_pm_weight';
        $data['nestedView']['parent_page'] = 'inventory';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Product Pm Weight', 'class' => 'active', 'url' => '');

        # Data
        
        # Additional data
        $product= $this->Common_model->get_data('product',array('status'=>1));
        $data['product']=$product;
        @$pm_weight=$this->Common_model->get_data('product_pm_weight',array('status'=>1));
        foreach(@$pm_weight as $key=>$value)
            {
                @$result[$value['product_id']]=$value['weight'];
             
            }
        if(count(@$result)>0)
        {
             $data['results']=$result;
        }
       
        $data['flag'] = 1;
        //$data['form_action'] = SITE_URL.'insert_product_pm_weight';
        $data['display_results'] = 0;
        $this->load->view('product/product_pm_weight_view',$data);
	}

	public function insert_product_pm_weight()
	{
		$product_id=$this->input->post('product_id',TRUE);
        $pm_weight=$this->input->post('pm_weight');
        $user_id=$this->session->userdata('user_id');
        $time=date('Y-m-d H:i:s');
        $this->db->trans_begin();
        foreach($pm_weight as $key=>$value)
        {
        	if($value !='')
        	{
        		$query = 'select weight from product_pm_weight where product_id="'.$key.'" ';
                $count = $this->Common_model->get_no_of_rows($query);
                
                if($count !='')
                {
                    $query = 'select weight from product_pm_weight where product_id="'.$key.'" ';
                    $res=$this->db->query($query);
	                $result=$res->row_array();
			 		$db_value=$result['weight'];
	                if($db_value!=$value)
	                {
	                	$qry=$this->Common_model->update_data('product_pm_weight',array('weight'=>$value,'modified_by'=>$user_id,'modified_time'=>$time),array('product_id'=>$key));
	                    /*$qry='UPDATE product_pm_weight set weight='.$value.', modified_by='.$user_id.', modified_time='.$time.' where product_id='.$key;
	                    $this->db->query($qry);*/
	                }
                    
                }
                else
                {
                	$products[] = array( 
                    'weight'   =>  $value,                
                    'product_id' =>  $key,
                    'status'		=>	1,
                    'created_by'	=>	$user_id,
                    'created_time'=>$time
                    );
                }
        		
        	}
        	
        }
        foreach($products as $row)
        {
        	$product_id = $this->Common_model->insert_data('product_pm_weight',$row); 
        }
        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <strong>Error!</strong> Something went wrong. Please check. </div>');

        }
        else
        {
            $this->db->trans_commit(); 
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <strong>Success!</strong>Product pm Weight has been added successfully! </div>');
        } 
         redirect(SITE_URL.'product_pm_weight');
		
	}

}