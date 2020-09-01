<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Convert_oil_product extends Base_controller {
	public function __construct() 
    {
        parent::__construct();
        $this->load->model("User_model");             
    }
/*loose oil details
Author:Srilekha
Time: 09.10PM 02-03-2017 */
	public function loose_oil()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Loose oil Recovery";
		$data['nestedView']['pageTitle'] = 'Loose Oil Recovery';
        $data['nestedView']['cur_page'] = 'recovery_oil_production';
        $data['nestedView']['parent_page'] = 'Leakage';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/convert_oil_product.js" type="text/javascript"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Loose Oil Recovery', 'class' => 'active', 'url' => '');	

        $data['loose_oil'] = $this->Common_model->get_dropdown('loose_oil', 'loose_oil_id', 'name', array('status'=>1));
        $data['flag']=1;
        $data['form_action'] = SITE_URL.'loose_oil_recover';

        $this->load->view('convert_oil_product/loose_oil_view',$data);

	}
/*loose oil recover details
Author:Srilekha
Time: 09.30PM 02-03-2017 */
	public function loose_oil_recover()
	{
        $val = $this->input->post('loose_oil',TRUE);
        if($val=='')
        {
            redirect(SITE_URL.'oil_product');
        }
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Loose oil Recovery Details";
		$data['nestedView']['pageTitle'] = 'Loose Oil Recovery Details';
        $data['nestedView']['cur_page'] = 'recovery_oil_production';
        $data['nestedView']['parent_page'] = 'Leakage';


        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/convert_oil_product.js" type="text/javascript"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Loose Oil Recovery', 'class' => '', 'url' =>SITE_URL.'oil_product');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Loose Oil Recovery Details', 'class' => 'active', 'url' => '');	

        if($this->input->post('loose_oil',TRUE))
        {
        	$loose_oil_id=$this->input->post('loose_oil');
        	$plant_id=$this->session->userdata('ses_plant_id');
        	$data['loose_oil_id']=$loose_oil_id;
        	$data['flag']=2;
        	$data['loose_oil_name']=$this->Common_model->get_value('loose_oil',array('loose_oil_id'=>$loose_oil_id),'name');
        	$data['quantity']=$this->Common_model->get_value('plant_recovery_oil',array('plant_id'=>$plant_id,'loose_oil_id'=>$loose_oil_id),'oil_weight');
        	$data['product'] = $this->User_model->get_limit_product($loose_oil_id);
        	$data['form_action'] = SITE_URL.'oil_confirm';
        	
        	$this->load->view('convert_oil_product/loose_oil_view',$data);
        }
        
	} 
/*loose oil confirmation details
Author:Srilekha
Time: 10.38AM 03-03-2017 */
	public function oil_confirm()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Loose oil Recovery Confirmation";
		$data['nestedView']['pageTitle'] = 'Loose Oil Recovery Confirmation';
        $data['nestedView']['cur_page'] = 'recovery_oil_production';
        $data['nestedView']['parent_page'] = 'Leakage';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/convert_oil_product.js" type="text/javascript"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Loose Oil Recovery', 'class' => '', 'url' =>SITE_URL.'oil_product');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Loose Oil Recovery Confirmation', 'class' => 'active', 'url' => '');	

        if($this->input->post('product',TRUE))
        {
        	$product_id=$this->input->post('product');
        	$loose_items=$this->input->post('loose_type');
        	
        	$tot_oil_weight=0;
        	foreach($product_id as $key=>$value)
        	{
        		if($value!=null)
        		{
        			$product_name=$this->Common_model->get_value('product',array('product_id'=>$value),'name');
        			$oil_weight=get_oil_weight($value);
        			$oil_qty[]=array(
        								'product_id'	=>	$value,
        								'loose_item'	=>	$loose_items[$key],
        								'oil_weight'	=>	$loose_items[$key]*$oil_weight,
        								'product_name'	=>	$product_name
        				            );
        			 $tot_oil_weight+=	$loose_items[$key]*$oil_weight;
        			 
        			
        		} 
        	} 
        	$data['loose_oil_name']=$this->input->post('loose_oil_name');
        	$data['loose_oil_id']=$this->input->post('loose_oil_id');
        	$oil_quantity=$this->input->post('quantity');
        	$data['oil_quantity']=$oil_quantity;
        	if($oil_quantity>=$tot_oil_weight)
        	{
        		$data['form_action'] = SITE_URL.'insert_oil_product';
        		
        	}
        	else
        	{
        		
        		$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Product Weight Is Exceeded Please check. </div>');
        		redirect(SITE_URL.'oil_product');
        	}
        	$data['total_oil_weight']=$tot_oil_weight;
        	$plant_id=$this->session->userdata('ses_plant_id');
        	$data['product']=$oil_qty;
        	$data['flag']=3;
        	
        	
        	$this->load->view('convert_oil_product/loose_oil_view',$data);
        }
	}
/*loose oil insertion
Author:Srilekha
Time: 11.51AM 03-03-2017 */
	public function insert_oil_product()
	{
		$plant_id=$this->session->userdata('ses_plant_id');
		$loose_oil_id=$this->input->post('loose_oil_id');
		$product_id=$this->input->post('products');
		$loose_type=$this->input->post('loose_items',TRUE);
		$quantity=$this->input->post('total');
		$data=array(
					'on_date'		=>	date('Y-m-d'),
					'loose_oil_id'	=>	$loose_oil_id,
                    'plant_id'      =>  get_plant_id(),
					'status'		=>	1,
					'remarks'		=>	$this->input->post('remarks'),
					'created_by'	=>	$this->session->userdata('user_id'),
					'created_time'	=>	date('Y-m-d H:i:s')
			       );
		$this->db->trans_begin();
		
		$production_id=$this->Common_model->insert_data('recovered_oil_production',$data);
		$qry='UPDATE plant_recovery_oil set oil_weight=oil_weight-'.$quantity.' where plant_id='.$plant_id.' and loose_oil_id='.$loose_oil_id;
		$this->db->query($qry);
		
		foreach($product_id as $key=>$value)
		{
			if($value!='')
			{
				$data=array(
							'ro_production_id'	=>	$production_id,
							'item_qty'			=>	$loose_type[$value],
							'product_id'		=>	$value,
							'status'			=>	1,
					       );

				$rop_product=$this->Common_model->insert_data('rop_product',$data);
				$items_per_carton=$this->Common_model->get_value('product',array('product_id'=>$value),'items_per_carton');
				$carton_qty=$loose_type[$value]/$items_per_carton;

                $query = 'select * from plant_product where product_id="'.$value.'" AND plant_id="'.$plant_id.'"';
                $count = $this->Common_model->get_no_of_rows($query);
                if($count>0)
                {
                    $qry='UPDATE plant_product set quantity=quantity+'.$carton_qty.' where product_id='.$value.' and plant_id='.$plant_id;
                    $this->db->query($qry);
                }
                else
                {
                    $insert_data = array('product_id'  => $value,
                                         'plant_id'=> $plant_id,
                                         'quantity'  => $carton_qty,
                                         'loose_pouches' => 0,
                                         'updated_time' => date('Y-m-d H:i:s'));
                    $this->Common_model->insert_data('plant_product',$insert_data);
                }


			}
			if ($this->db->trans_status()===FALSE)
			{
				$this->db->rollback();
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');
			}
			else
			{
				$this->db->trans_commit();
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Success!</strong> Converted Recover Oil to product successfully </div>');
			}
		}
		redirect(SITE_URL.'oil_product');
	}
}