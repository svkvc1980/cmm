<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

/*
stock transfer
auther: nagarjuna
created on: 14th mar 2017 4:45pm
*/

class Plant_stock_r extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Plant_stock_r_m");
	}

	 public function plant_stock_reports()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Available Stock Report";
        $data['nestedView']['pageTitle'] = 'Available Stock Report';
        $data['nestedView']['cur_page'] = 'available_stock_r';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Available Stock Report', 'class' => '', 'url' => '');
         
        $plant_id = $this->session->userdata('ses_plant_id');
        $product_price_type=get_product_price_type();
         $product_id=$this->Common_model->get_data('plant_product',array('plant_id'=>$plant_id));
        
        
        if(count($product_id)>0)
        {
            $product_id_arr = array_column($product_id,'product_id');
            $loose_oil_data_arr=$this->Plant_stock_r_m->get_loose_oil($product_id_arr);
            $loose_oil_id_arr = array_column($loose_oil_data_arr,'loose_oil_id');
            if(count($loose_oil_id_arr)>0)
            {

                foreach($loose_oil_id_arr as $key=>$loose_oil_id)
                {
                  $product_results[$loose_oil_id]['loose_oil_id']   = $loose_oil_id; 
                  $product_results[$loose_oil_id]['loose_oil_name'] = $this->Common_model->get_value('loose_oil',array('loose_oil_id'=>$loose_oil_id),'name');
                  $product_results[$loose_oil_id]['sub_products'] = $this->Plant_stock_r_m->get_product_results($loose_oil_id,$plant_id); 
                  
                } 
            }
        $data['product_results']=$product_results; 
        }
         
        
        
        $product_latest_p_data=$this->Plant_stock_r_m->get_product_latest_price($product_price_type);
        if(count($product_latest_p_data)>0)
        {
            foreach($product_latest_p_data as $key=>$value)
            {
                $product_latest_price[$value['product_id']] = $value['value'];
            }
            $data['product_latest_price']=$product_latest_price;
            
        }
        

        $data['portlet_title']='Available Stock';
        $data['flag']=1;
        $this->load->view('plant_reports/plant_stock_report_view',$data);
    }
}