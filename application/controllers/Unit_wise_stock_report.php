<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';
class Unit_wise_stock_report extends Base_controller
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Unit_wise_stock_report_m");
        $this->load->library('Pdf');
    }
    public function unit_wise_stock()
    {   
        $plant_id= $this->session->userdata('ses_plant_id');
        $data['plant_name']=$this->session->userdata('plant_name');
        //for product list
        $products=$this->Unit_wise_stock_report_m->get_products();
         if(count($products) > 0)
        {
            $product_results=array();
            foreach($products as $key =>$value)
            {   
                if(array_key_exists(@$keys, $product_results))
                {   
                    $product_results[$value['loose_oil_id']] ['products'][$value['product_id']] =array(
                        'product_id'     =>  $value['product_id'],
                        'product_name'   =>  $value['short_name'],
                        'items_per_carton'=> $value['items_per_carton'],
                        'oil_weight'     =>  $value['oil_weight']
                         );    
                }    
                else
                {   $product_results[$value['loose_oil_id']]['loose_oil']=$value['loose_oil_name'];
                    $product_results[$value['loose_oil_id']] ['products'][$value['product_id']] =array(
                        'product_id'     =>  $value['product_id'],
                        'product_name'   =>  $value['short_name'],
                        'items_per_carton' => $value['items_per_carton'],
                        'oil_weight'      =>   $value['oil_weight']
                        );
                } 
            }
        }
        //$row=$this->Common_model->get_data_row('distributor_price_type',array('name'=>'MRP'),array('price_type_id'));
        $price_type=get_regular_price_id();
        $latest_details=$this->Unit_wise_stock_report_m->get_all_products_latest_price_plant($price_type,$plant_id);
        $latest_price_details=array();
        foreach($latest_details as $key =>$value)
        {
            $latest_price_details[$value['product_id']]['latest_price']=$value['value'];
        }
        $stock=$this->Common_model->get_data('plant_product',array('plant_id'=>$plant_id));
        $stock_arr=array();
        foreach ($stock as $keys => $values) 
        {
            $stock_arr[$values['product_id']]['quantity']=$values['quantity'];
        }
        $data['product_results']=$product_results;
        $data['latest_price_details']=$latest_price_details;
       // print_r($latest_price_details);exit;
        $data['stock_arr']=$stock_arr;
        $this->load->view('stock_list/unit_wise_stock',$data);
    }
}   