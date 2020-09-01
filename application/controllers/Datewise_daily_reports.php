<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 21th Feb 2017 09:00 AM

class Datewise_daily_reports extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Production_m");
        $this->load->model("Oil_stock_balance_m");
        $this->load->model('Datewise_daily_reports_m');
        $this->load->model('Daily_reports_m');
        $this->load->model('Distributor_ob_m');
	}
    public function dw_oil_report_search()
    { 

        /*$data['loose_oils']   = $this->Common_model->get_dropdown('loose_oil', 'loose_oil_id', 'name', array('status' => 1) ,'rank ASC');
        //echo $this->db->last_query();exit;
        print_r($data['loose_oils'] );exit;*/
        //$this->Daily_reports_m->get();
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Datewise Daily oil Report";
        $data['nestedView']['pageTitle'] = 'Datewise Daily oil Report';
        $data['nestedView']['cur_page'] = 'dw_oil_report_search';
        $data['nestedView']['parent_page'] = 'dw_oil_report_search';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] =array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Datewise Daily oil Report', 'class' => 'active', 'url' =>'');
        $data['plants'] = get_ops_dropdown();
        $this->load->view('datewise_daily_reports/dw_oil_report_search',$data);
    }
	public function dw_daily_oil_report()
	{
        $from_date=(($this->input->post('fromDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('fromDate', TRUE))):''; 
        $to_date=(($this->input->post('toDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('toDate', TRUE))):''; 
        $data['from_date'] = $this->input->post('fromDate', TRUE);
        $data['to_date'] = $this->input->post('toDate', TRUE);
        $plant_id = @$this->input->post('plant_id',TRUE);
        // $data['prev_date'] = date('d-m-Y', strtotime($this->input->post('report_date') .' -1 day'));
        // echo date('Y-m-d');
        /*if( $report_date > date('Y-m-d') )
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Sorry!</strong> You can not take the report beyond current date </div>');       
            redirect(SITE_URL.'dw_oil_report_search');
        }*/  
       

        # Loading the data array to send to View
       // $data['oil_stock_balance_results'] = $this->Daily_reports->daily_oil_report($current_offset, $config['per_page'], $search_params);
        $data['loose_oils']   = $this->Common_model->get_dropdown('loose_oil', 'loose_oil_id', 'name', array('status' => 1) ,'rank ASC');
        //print_r($data['loose_oils'] );exit;
        $daily_report =array();
        $invoice_report = array();
        $all_types =array();
        $p_obs =array();
        $p_dos =array();
        $dispatches = array();
        $plant_id = (get_ses_block_id() ==1)?$plant_id:get_plant_id();
        $type1_leakage_arr = $this->Datewise_daily_reports_m->get_type1_leakage($plant_id,$from_date,$to_date);
        $data['type1_leakage_arr'] = $type1_leakage_arr;
        $type2_leakage_arr = $this->Datewise_daily_reports_m->get_type2_leakage($plant_id,$from_date,$to_date);
        $data['type2_leakage_arr'] = $type2_leakage_arr;
        $processing_loss_arr = $this->Datewise_daily_reports_m->get_processing_loss($plant_id,$from_date,$to_date);
        $data['processing_loss_arr'] = $processing_loss_arr;

        foreach ($data['loose_oils'] as $loose_oil_id => $value)
        {
            $loose_stock_arr = $this->Datewise_daily_reports_m->get_loose_stock($plant_id,$loose_oil_id,$from_date,$to_date);
            $loose_stock = $loose_stock_arr[0];
            $report_taken_as_on = $loose_stock_arr[1];
            $packed_stock = $this->Datewise_daily_reports_m->get_packed_stock($plant_id,$loose_oil_id,$from_date,$to_date);
            $packed_stock['receipts'] = $loose_stock['sales'];  
            /*echo '<pre>'; print_r($loose_stock);              
            echo '<pre>'; print_r($packed_stock);*///exit;
            // Opening and closing 
            $packed_stock['closing_balance']=($packed_stock['opening'] + $packed_stock['receipts'] - $packed_stock['sales'] - $packed_stock['stock_transfer']);
             $daily_report[$loose_oil_id][0] = $loose_stock;
             $daily_report[$loose_oil_id][1] = $packed_stock;

             // invoice data 
             /*$inv_data = $this->Daily_reports_m->get_invoice_data($loose_oil_id);
             $invoice_report[$loose_oil_id] = $inv_data;*/

             


        }
        $data['daily_report'] = $daily_report ;
        $data['plant_id'] = $plant_id;
        
        //echo qty_format($dispatches[1][1]);exit;
        //echo '<pre>'; print_r($dispatches);exit;
        /*foreach ($dispatches as $key => $value) {
                echo get_loose_oil_name($key).$value[0].'<br>';
                echo $value[1].'<br>';
            # code...
        }exit;*/
        /*echo '<pre>'; print_r($daily_report);//exit;
        echo '<pre>'; print_r($all_types);//exit;
        echo '<pre>'; print_r($p_dos);
        echo '<pre>'; print_r($p_obs);*/
       // exit;
        //exit;
        # Additional data
        
        
        $data['display_results'] = 1;
        $this->load->view('datewise_daily_reports/dw_print_oil_report',$data);
    }    
    public function dw_daily_stock_report_search()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Datewise Stock Report Search";
        $data['nestedView']['pageTitle'] = 'Datewise Stock Report Search';
        $data['nestedView']['cur_page'] = 'dw_daily_stock_report_search';
        $data['nestedView']['parent_page'] = 'dw_daily_stock_report_search';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] =array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Datewise Stock Report Search', 'class' => 'active', 'url' =>'');
        
        $this->load->view('datewise_daily_reports/dw_stock_report_search',$data);
    }
    public function dw_daily_stock_report()
    {
        $from_date=(($this->input->post('fromDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('fromDate', TRUE))):''; 
        $to_date=(($this->input->post('toDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('toDate', TRUE))):''; 
        $data['from_date'] = $this->input->post('fromDate', TRUE);
        $data['to_date'] = $this->input->post('toDate', TRUE);
        //date('d.m.Y',strtotime("-1 days"));

        //echo $report_date;exit;
        //echo date('Y-m-d');
        /*if( $report_date > date('Y-m-d') )
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Sorry!</strong> You can not take the report beyond current date </div>');       
            redirect(SITE_URL.'daily_stock_report_search');
        }*/  
        
       

        # Loading the data array to send to View
       // $data['oil_stock_balance_results'] = $this->Daily_reports->daily_oil_report($current_offset, $config['per_page'], $search_params);
        $data['loose_oils']   = $this->Common_model->get_dropdown('loose_oil', 'loose_oil_id', 'name', array('status' => 1),'rank ASC');
        $daily_report =array();  
        $data1=array();      $product_info = array();
        foreach ($data['loose_oils'] as $loose_oil_id => $loose_oil_name)
        {
               $products = get_rankwise_products($loose_oil_id);
               if(count($products)!='')
               {
                  foreach ($products as $product_id => $res)
                  {
                      $daily_report[$loose_oil_id][$res['product_id']] = $this->Datewise_daily_reports_m->get_opening_stock($loose_oil_id,$res['product_id'],$from_date,$to_date);
                      $product_info[$res['product_id']] = $res;
                  } 
                }


        }
        //echo '<pre>'; echo count($product_info);print_r($product_info); exit;
        $data['product_info'] = $product_info;
        $data['daily_report'] = $daily_report ;
        
        /*foreach ($data['loose_oils'] as $key => $value) {
            foreach ($data['daily_report'][$key] as $product_id => $value) {
                    echo get_product_name($product_id).'--'.$value['production'].'<br>';
            }
            # code...
        }*///exit;
        //echo '<pre>'; print_r($daily_report);exit;
        
       // exit;
        //exit;
        # Additional data

        $data['display_results'] = 1;
        $this->load->view('datewise_daily_reports/dw_print_stock_report',$data);
    }
    
    public function dw_daily_pm_stock_report_search()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Datewise Daily PM Report Search";
        $data['nestedView']['pageTitle'] = 'Datewise Daily PM Report Search';
        $data['nestedView']['cur_page'] = 'dw_daily_pm_stock_search';
        $data['nestedView']['parent_page'] = 'dw_daily_pm_stock_search';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] =array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Datewise Daily PM Stock Search', 'class' => 'active', 'url' =>'');
        
        $this->load->view('datewise_daily_reports/dw_pm_stock_search',$data);
    }  
    public function dw_daily_pm_stock_report()
    {
        //echo '123';exit;
        $from_date=(($this->input->post('fromDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('fromDate', TRUE))):''; 
        $to_date=(($this->input->post('toDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('toDate', TRUE))):''; 
        $data['from_date'] = $this->input->post('fromDate', TRUE);
        $data['to_date'] = $this->input->post('toDate', TRUE);

        //echo $report_date;exit;
        //echo date('Y-m-d');
         
        # Loading the data array to send to View
       // $data['oil_stock_balance_results'] = $this->Daily_reports->daily_oil_report($current_offset, $config['per_page'], $search_params);
       $data['pm_grps']   = $this->Common_model->get_dropdown('pm_group', 'pm_group_id', 'name', array('status' => 1));
        $daily_report =array();       
        $i=1;    
        foreach ($data['pm_grps'] as $pm_group_id => $pmgrp_name)
        { 
            $pms = $this->Common_model->get_dropdown('packing_material','pm_id','name',array('status'=>1,'pm_group_id'=>$pm_group_id));
            if(count($pms)!='')
            {
                foreach ($pms as $pm_id => $pm_name)
                {
                    $pm_results = $this->Datewise_daily_reports_m->get_pm_opening_stock($pm_group_id,$pm_id,$from_date,$to_date);
                    $daily_report[$pm_group_id][$pm_id] = $pm_results;
                } 
            }          

        }
       // echo '<pre>'; print_r($daily_reports);exit;
        
        $data['daily_report'] = $daily_report ;
        
        /*foreach ($data['pm_cats'] as $pm_category_id => $pmcat_name)
         { 
            if(count($data['daily_report'][$pm_category_id])!='')
            {
                foreach ($data['daily_report'][$pm_category_id] as $pm_id => $values)
                {
                        echo $values['closing_balance'].'<br>';
                }
            }
            
        }*/
        //echo '<pre>'; print_r($daily_report);exit;
        # Additional data

        $data['display_results'] = 1;
        $this->load->view('datewise_daily_reports/dw_print_pm_stock_report',$data);
    }
    
}