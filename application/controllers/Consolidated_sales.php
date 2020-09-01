<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Consolidated_sales extends Base_controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Consolidated_sales_m");               
    }
    public function consolidated_sales_view()
    {
         # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Consolidated Unit Sales Report";
        $data['nestedView']['pageTitle'] = 'Consolidated Unit Sales Report';
        $data['nestedView']['cur_page'] = 'consolidated_sales_report';
        $data['nestedView']['parent_page'] = 'reports';
        $data['nestedView']['list_page'] = 'consolidated_reports';
        

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Consolidated Unit Sales Report', 'class' => '', 'url' => ''); 
        
        $this->load->view('sales/consolidated_sales_view',$data); 
    }

    public function print_consolidated_sales()
    {  
        if($this->input->post('submit')!='')
        { 
            $from_date = date('Y-m-d',strtotime($this->input->post('from_date',TRUE)));
            $to_date = date('Y-m-d',strtotime($this->input->post('to_date',TRUE))); 

            $units=$this->Consolidated_sales_m->get_plant();
            

            $arr_unit=array();
            foreach($units as $key =>$value)
            {
                $latest_details=$this->Consolidated_sales_m->get_all_product_sales_list($value['plant_id'],$from_date,$to_date);
                $arr_unit[$value['plant_id']]['plant_id']=$value['plant_id'];
                $arr_unit[$value['plant_id']]['sales_results']=$latest_details;
            }
            
            $sales_details=array();
            foreach($arr_unit as $key =>$value )
            {  
                foreach ($value['sales_results'] as $keys => $values) 
                {
                    $sales_details[$key][$values['product_id']]['qty']=$values['qty'];
                    $sales_details[$key][$values['product_id']]['pouch']=$values['pouches'];
                    $sales_details[$key][$values['product_id']]['weight']=$values['qty_in_kg'];
                    $sales_details[$key][$values['product_id']]['amount']=$values['amount'];
                }
            }
            
           //get products
            $products=$this->Consolidated_sales_m->get_products();
            foreach($products as $key =>$value)
            {   $product_results[$value['loose_oil_id']]['loose_oil_name']=$value['loose_oil_id'];
                $product_results[$value['loose_oil_id']]['product_name']=$value['name'];
                $results=$this->Consolidated_sales_m->get_sub_products_by_products($value['loose_oil_id']);
                $product_results[$value['loose_oil_id']]['sub_products']=$results;
            }

            $data['product_results']=$product_results;
            $data['sales_details']=$sales_details;
            $data['from_date'] = date('d-m-Y',strtotime($from_date));
            $data['to_date'] = date('d-m-Y',strtotime($to_date));
            $data['units']=$units;

            $this->load->view('sales/print_consolidated_sales',$data); 
        }
        else
        {
            redirect(SITE_URL.'consolidated_sales_view'); exit();
        }
    }

    public function print_consolidated_closing_stock()
    {  
        $units=$this->Consolidated_sales_m->get_plant()+array('100'=>array('plant_id'=>100,'plant_name'=>'In Transit'));
        
        $arr_unit=array();
        foreach($units as $key =>$value)
        {
            if($key == 100)
            {
                $latest_details=$this->Consolidated_sales_m->get_stock_in_transit_list();
            }
            else
            {
                $latest_details=$this->Consolidated_sales_m->get_all_closing_stock_list($value['plant_id']);
            }
            
            $arr_unit[$value['plant_id']]['plant_id']=$value['plant_id'];
            $arr_unit[$value['plant_id']]['closing_stock_details']=$latest_details;
        }

        $closing_stock_details=array();
        foreach($arr_unit as $key =>$value )
        {  
            foreach ($value['closing_stock_details'] as $keys => $values) 
            {
                $closing_stock_details[$key][$values['product_id']]['pouch']=$values['pouches'];
                $closing_stock_details[$key][$values['product_id']]['weight']=$values['qty_in_kg'];
            }
        }
        
       //get products
        $products=$this->Consolidated_sales_m->get_products();
        foreach($products as $key =>$value)
        {   $product_results[$value['loose_oil_id']]['loose_oil_name']=$value['loose_oil_id'];
            $product_results[$value['loose_oil_id']]['product_name']=$value['name'];
            $results=$this->Consolidated_sales_m->get_sub_products_by_products($value['loose_oil_id']);
            $product_results[$value['loose_oil_id']]['sub_products']=$results;
        }

        $data['product_results']=$product_results;
        $data['closing_stock_details']=$closing_stock_details;
        $data['units']=$units;

        $this->load->view('reports/print_consolidated_closing_stock',$data); 
    }

    public function consolidated_executive_sales_view()
    {
         # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Consolidated Executive Sales Report (Products)";
        $data['nestedView']['pageTitle'] = 'Consolidated Executive Sales Report (Products)';
        $data['nestedView']['cur_page'] = 'consolidated_executive_sales_view';
        $data['nestedView']['parent_page'] = 'reports';
        $data['nestedView']['list_page'] = 'consolidated_reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Consolidated Executive Sales Report (Products)', 'class' => '', 'url' => ''); 
        
        $this->load->view('sales/consolidated_executive_sales_view',$data); 
    }

    public function print_consolidated_executive_sales()
    {  
        if($this->input->post('submit')!='')
        { 
            $from_date = date('Y-m-d',strtotime($this->input->post('from_date',TRUE)));
            $to_date = date('Y-m-d',strtotime($this->input->post('to_date',TRUE))); 

            $units=$this->Consolidated_sales_m->get_executive_list();
            

            $arr_unit=array();
            foreach($units as $key =>$value)
            {
                $latest_details=$this->Consolidated_sales_m->get_all_product_executive_sales_list($value['executive_id'],$from_date,$to_date);
                $arr_unit[$value['executive_id']]['executive_id']=$value['executive_id'];
                $arr_unit[$value['executive_id']]['sales_results']=$latest_details;
            }
            
            $sales_details=array();
            foreach($arr_unit as $key =>$value )
            {  
                foreach ($value['sales_results'] as $keys => $values) 
                {
                    $sales_details[$key][$values['product_id']]['qty']=$values['qty'];
                    $sales_details[$key][$values['product_id']]['pouch']=$values['pouches'];
                    $sales_details[$key][$values['product_id']]['weight']=$values['qty_in_kg'];
                    $sales_details[$key][$values['product_id']]['amount']=$values['amount'];
                }
            }
            
           //get products
            $products=$this->Consolidated_sales_m->get_products();
            foreach($products as $key =>$value)
            {   $product_results[$value['loose_oil_id']]['loose_oil_name']=$value['loose_oil_id'];
                $product_results[$value['loose_oil_id']]['product_name']=$value['name'];
                $results=$this->Consolidated_sales_m->get_sub_products_by_products($value['loose_oil_id']);
                $product_results[$value['loose_oil_id']]['sub_products']=$results;
            }

            $data['product_results']=$product_results;
            $data['sales_details']=$sales_details;
            $data['from_date'] = date('d-m-Y',strtotime($from_date));
            $data['to_date'] = date('d-m-Y',strtotime($to_date));
            $data['units']=$units;

            $this->load->view('sales/print_consolidated_executive_sales',$data); 
        }
        else
        {
            redirect(SITE_URL.'consolidated_executive_sales_view'); exit();
        }
    }
}