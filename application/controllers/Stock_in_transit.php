<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Stock_in_transit extends Base_controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Stock_in_transit_m");              
    }

    public function stock_in_transit()
    {
    	# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Stock In Transit";  
        $data['nestedView']['pageTitle'] = 'Stock In Transit';
        $data['nestedView']['cur_page'] = 'stock_in_transit';
        $data['nestedView']['parent_page'] = 'Stock In Transit';
     
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home')); 
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Stock In Transit', 'class' => 'active', 'url' => '');

        $data['flag'] = 1;
        $data['plant_list'] = $this->Stock_in_transit_m->get_plant_list();

        $this->load->view('stock_in_transit/stock_in_transit', $data);
    }

    public function stock_in_transit_detail()
    {
    	$from_date=date('Y-m-d', strtotime($this->input->post('from_date',TRUE)));
    	$to_date=date('Y-m-d', strtotime($this->input->post('to_date',TRUE)));
    	$plant_from = $this->input->post('plant_from');
    	$plant_to = $this->input->post('plant_to');
    	$data['lifting_point'] = $this->Common_model->get_value('plant', array('plant_id' => $plant_from), 'name');
    	$data['order_for'] = $this->Common_model->get_value('plant', array('plant_id' => $plant_to), 'name');
        $data['from_date'] = date('d-m-Y',strtotime($from_date));
        $data['to_date'] = date('d-m-Y',strtotime($to_date));

    	$invoices = $this->Stock_in_transit_m->get_plant_invoices($from_date, $to_date, $plant_from, $plant_to);
    	$stock_result = array();
    	foreach ($invoices as $key => $value) 
    	{
    		$stock_result[$value['invoice_id']]['invoice']=$value['invoice_number'];
            $results=$this->Stock_in_transit_m->get_stock_in_transit_report($from_date, $to_date, $plant_from, $plant_to, $value['invoice_id']);
            $stock_result[$value['invoice_id']]['invoice_results']=$results;
    	}

    	$data['stock_result'] = $stock_result;
    	#print_r($stock_result); die;
    	$this->load->view('stock_in_transit/stock_in_transit_detail', $data);
    }
}