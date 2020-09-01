<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Distributor_login_reports extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Price_updation_model");
         $this->load->model("Distributor_login_m");
    }
     public function view_product_price_report_distributor()
    {  
           
        	$price_type=@cmm_decode($this->uri->segment(2));
            $data['price_type']=$price_type;
            $row=$this->Common_model->get_data_row('distributor_price_type',array('price_type_id'=>$data['price_type']),array('name'));
            $data['distributor_price_type']=$row['name'];
            $start_date=date('Y-m-d');
            $data['start_date']=$start_date;
            $search_date = format_date($start_date,'Y-m-d');
            $data['effective_from'] = $this->Price_updation_model->get_price_last_updated_date($search_date,$data['price_type']);
            //getting plant except the headoffice and distributor
            $units=$this->Price_updation_model->get_plant();
            $data['units']=$units;
            if($data['price_type']!=get_raithu_bazar_id())
            {
                $arr_unit=array();
                foreach($units as $key =>$value)
                {
                    $latest_details=$this->Price_updation_model->get_all_products_latest_price_report_plant($data['price_type'],$value['plant_id'],date('Y-m-d',strtotime($start_date)));
                    $arr_unit[$value['plant_id']]['plant_id']=$value['plant_id'];
                    $arr_unit[$value['plant_id']]['plant_results']=$latest_details;
                }
                

                $latest_price_details=array();
                foreach($arr_unit as $key =>$value )
                {  
                    foreach ($value['plant_results'] as $keys => $values) 
                    {
                        $latest_price_details[$key][$values['product_id']]['old_price']=$values['value'];
                        $latest_price_details[$key][$values['product_id']]['product_price_id']=$values['product_price_id'];
                    }
                }
            }
            else
            {
                $latest_details=$this->Price_updation_model->get_all_products_latest_price_report($data['price_type'],date('Y-m-d',strtotime($start_date)));  
                 $latest_price_details=array();
                foreach($latest_details as $key =>$value )
                {
                    $latest_price_details[$value['product_id']]['old_price']=$value['value'];
                    $latest_price_details[$value['product_id']]['product_price_id']=$value['product_price_id'];
                } 
            }
           //get products
            $products=$this->Price_updation_model->get_products();
            foreach($products as $key =>$value)
            {   $product_results[$value['loose_oil_id']]['loose_oil_name']=$value['loose_oil_id'];
                $product_results[$value['loose_oil_id']]['product_name']=$value['name'];
                $results=$this->Price_updation_model->get_sub_products_by_products($value['loose_oil_id']);
                $product_results[$value['loose_oil_id']]['sub_products']=$results;
            }
            $data['product_results']=$product_results;
            $data['latest_price_details']=$latest_price_details;
            $this->load->view('distributor/print_dist_unit_price_report',$data); 
        
    }

    public function login_distributor_ob_list()
    {
    	# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor Pending OB";
		$data['nestedView']['pageTitle'] = 'Distributor Pending OB';
        $data['nestedView']['cur_page'] = 'reports';
        $data['nestedView']['parent_page'] = '';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Pending OBS', 'class' => '', 'url' => '');	
        $this->load->view('distributor/pending_dist_ob', $data);
    }

     # Print Distributor OB List
    public function login_dist_ob_print()
    {
       
        $data['distributor_id'] = $this->session->userdata('distributor_id');
        $data['ob_results'] = $this->Distributor_login_m->download_ob_list($data['distributor_id']);
        $this->load->view('distributor/print_pen_dist_ob_list',$data);
            
       
    }
     public function login_distributor_do_list()
    {
    	# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor Pending DO";
		$data['nestedView']['pageTitle'] = 'Distributor Pending DO';
        $data['nestedView']['cur_page'] = 'reports';
        $data['nestedView']['parent_page'] = '';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Pending DO', 'class' => '', 'url' => '');	
        $this->load->view('distributor/pending_dist_do', $data);
    }
    public function login_dist_do_print()
    {
    	
            $data['distributor_id']=$this->session->userdata('distributor_id');
           
            $data['do_results'] = $this->Distributor_login_m->download_do_list($data['distributor_id']);
            $this->load->view('distributor/print_pen_dist_do_list',$data);
    }
}