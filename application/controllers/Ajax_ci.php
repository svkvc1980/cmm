<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Created by Maruthi on 4th Feb 2017
class Ajax_ci extends CI_Controller{

    public function __construct() 
    {
        parent::__construct(); 
        $this->load->model("Pm_consumption_m");
       
        
    }    
    
    public function ajax_get_regions_by_state_id()
    {
        $state_id = $this->input->post('state_id',TRUE);
        echo ajax_get_regions_by_state_id($state_id);
    }

    public function ajax_get_districts_by_region_id()
    {
        $region_id = $this->input->post('region_id',TRUE);
        echo ajax_get_districts_by_region_id($region_id);
    }

    public function ajax_get_areas_by_district_id()
    {
        $district_id = $this->input->post('district_id',TRUE);
        echo ajax_get_areas_by_district_id($district_id);
    }
    // created by mounika on 23rd may
    public function ajax_get_mandals_by_district_id()
    {
        $district_id = $this->input->post('district_id',TRUE);
        echo ajax_get_mandals_by_district_id($district_id);
    }

    public function ajax_get_areas_by_mandal_id()
    {
        $mandal_id = $this->input->post('mandal_id',TRUE);
        echo ajax_get_areas_by_mandal_id($mandal_id);
    }
    public function delete_table_details()
    {
        $where=array($this->input->post('table_col')=>$this->input->post('table_val'));
        $table_name=$this->input->post('table_name');  
                          
        $res=$this->Common_model->delete_data($table_name,$where);
        if($res)
            echo 1;
        else 
            echo 0;
    }
    public function get_packing_material_and_micron()
    {
         $product_id=$this->input->post('product_id',TRUE);
         $final_data=array();
        
        $pm_id_arr = get_packing_material_id($product_id);
        if($pm_id_arr)
        {
            $exist = check_pm_has_film_cat($pm_id_arr);
            if($exist == 1)
            {
                $final_data['film_pm_data'] = get_film_pms();
                $final_data['micron_data'] = get_micron_drop_down();
               
            }
            else
            {
                $final_data['film_pm_data'] = 0;
                $final_data['micron_data'] = 0;
            }
        }
        else
        {
            $final_data['film_pm_data'] = 0;
            $final_data['micron_data'] = 0;
        }
        
        
        /*echo '<pre>';
        print_r($final_data);exit;*/
        $final_data= json_encode($final_data);
       // echo '<pre>';
        echo  $final_data;  exit;
    }

    public function get_product_stock()
    {
        $product_id=$this->input->post('product_id',TRUE);
        $final_data=array();
        $stock_data = get_product_stock($product_id);
        
        $exist = get_packing_material_ids($product_id);
        //echo '<pre>';print_r($pm_id_arr);//exit;

        if($exist == 1)
        {
            $final_data['film_pm_data'] = get_film_pms($product_id);
            $final_data['micron_data'] = get_micron_drop_down();
           
        }
        else
        {
            $final_data['film_pm_data'] = 0;
            $final_data['micron_data'] = 0;
        }
        
            
       
        
        
        $final_data['stock_data'] = $stock_data;
        
        $final_data= json_encode($final_data);
        /*echo '<pre>';
        echo  $final_data;
        exit;  */
        echo $final_data;
       
        
    }
    public function ajax_get_products_by_loose_oil()
    {
        $loose_oil_id = $this->input->post('loose_oil_id',TRUE);
        echo ajax_get_products_by_loose_oil($loose_oil_id);
    }
    public function ajax_get_pms_by_product()
    {
        $product_id = $this->input->post('product_id',TRUE);
        echo ajax_get_pms_by_product($product_id);
    }
}
?>