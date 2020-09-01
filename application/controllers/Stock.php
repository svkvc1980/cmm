<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Stock extends Base_controller {
	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Stock_m");
        $this->load->model("Consolidated_sales_m");
	}

    /*Stock Details for scrolling 
Author:Srilekha
Time: 05.01PM 18-03-2017 */
    public function stock_scroll()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']=" Product Stock List";
        $data['nestedView']['pageTitle'] = 'Product Stock List';
        $data['nestedView']['cur_page'] = 'product_stock';
        $data['nestedView']['parent_page'] = 'inventory';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        $data['stock_scroll']=$this->Stock_m->get_stock_details();

        $this->load->view('commons/dashboard/admin-headoffice',$data);

        
    }

/*Stock Details for scrolling 
Author:Srilekha
Time: 05.46PM 18-03-2017 */
    public function stock_print_scroll()
    {
        
        $data['stock_scroll']=$this->Stock_m->get_stock_details();
        $col=array_column($data['stock_scroll'],'tot_oil_weight');
        $data['stock_sum']=array_sum($col);

        $this->load->view('stock_list/stock_list_print_view',$data);
    }
    
    public function print_available_product_stock()
    {  
        $units=$this->Consolidated_sales_m->get_plant();
        
        $arr_unit=array();
        foreach($units as $key =>$value)
        {
            $latest_details=$this->Consolidated_sales_m->get_all_closing_stock_list($value['plant_id']);
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

        $this->load->view('stock_list/print_consolidated_product_stock',$data); 
    }
}