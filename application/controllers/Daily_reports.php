<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 21th Feb 2017 09:00 AM

class Daily_reports extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Production_m");
        $this->load->model("Oil_stock_balance_m");
        $this->load->model('Daily_reports_m');
        $this->load->model('Distributor_ob_m');
	}
    public function oil_report_search()
    { 

        /*$data['loose_oils']   = $this->Common_model->get_dropdown('loose_oil', 'loose_oil_id', 'name', array('status' => 1) ,'rank ASC');
        //echo $this->db->last_query();exit;
        print_r($data['loose_oils'] );exit;*/
        //$this->Daily_reports_m->get();
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Daily Oil Report";
        $data['nestedView']['pageTitle'] = 'Daily Oil Report';
        $data['nestedView']['cur_page'] = 'oil_report_search';
        $data['nestedView']['parent_page'] = 'oil_report_search';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] =array();
        $data['nestedView']['css_includes'] = array();
        $data['plants'] = get_ops_dropdown();
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Daily Oil Report', 'class' => 'active', 'url' =>'');
        
        $this->load->view('daily_reports/oil_report_search',$data);
    }
	public function daily_oil_report()
	{
        $report_date = date('Y-m-d',strtotime($this->input->post('report_date')));
        $data['report_date'] =date('d-m-Y',strtotime($this->input->post('report_date')));
        // $data['prev_date'] = date('d-m-Y', strtotime($this->input->post('report_date') .' -1 day'));
        // echo date('Y-m-d');
        $plant_id = @$this->input->post('plant_id',TRUE);
        $plant_id = (get_ses_block_id() ==1)?$plant_id:get_plant_id();
        if( $report_date > date('Y-m-d') )
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Sorry!</strong> You can not take the report beyond current date </div>');       
            redirect(SITE_URL.'oil_report_search');
        }  
       

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

        $type1_leakage_arr = $this->Daily_reports_m->get_type1_leakage($report_date,$plant_id);
        $data['type1_leakage_arr'] = $type1_leakage_arr;
        $type2_leakage_arr = $this->Daily_reports_m->get_type2_leakage($report_date,$plant_id);
        $data['type2_leakage_arr'] = $type2_leakage_arr;
        $processing_loss_arr = $this->Daily_reports_m->get_processing_loss($report_date,$plant_id);
        $data['processing_loss_arr'] = $processing_loss_arr;
        //print_r($data['type1_leakage_arr']); exit;
        foreach ($data['loose_oils'] as $loose_oil_id => $value)
        {
            $loose_stock_arr = $this->Daily_reports_m->get_loose_stock($plant_id,$loose_oil_id,$report_date);

            $loose_stock = $loose_stock_arr[0];
            $report_taken_as_on = $loose_stock_arr[1];
            $packed_stock = $this->Daily_reports_m->get_packed_stock($plant_id,$loose_oil_id,$report_date);
            $packed_stock['receipts'] = $loose_stock['sales'];  
            /*echo '<pre>'; print_r($loose_stock);              
            echo '<pre>'; print_r($packed_stock);*///exit;
            // Opening and closing 
            $packed_stock['closing_balance']=($packed_stock['opening'] + $packed_stock['receipts'] - $packed_stock['sales']- $packed_stock['stock_transfer'] );
             $daily_report[$loose_oil_id][0] = $loose_stock;
             $daily_report[$loose_oil_id][1] = $packed_stock;

             // invoice data 
             /*$inv_data = $this->Daily_reports_m->get_invoice_data($loose_oil_id);
             $invoice_report[$loose_oil_id] = $inv_data;*/

             // Pending MRR data
                $plant_id = (get_ses_block_id() ==1)?$plant_id:get_plant_id();
             $mrr_data = get_pending_mrrs($plant_id,$loose_oil_id,$report_date);
             $all_types[$loose_oil_id] = $mrr_data;

             // Pending OB's
            $pending_ob_qty = $this->Daily_reports_m->get_pending_obs_qty_in_mts($plant_id,$loose_oil_id,$report_date);
            
            $ob_qty_arr = array('ob_qty' =>$pending_ob_qty);
            //print_r($ob_qty_arr) ;exit;
            //$obs = $this->Daily_reports_m->get_pending_obs_data($loose_oil_id);
            $p_obs[$loose_oil_id] = $ob_qty_arr ;

             // Pending DO's            
            $pending_do_qty = $this->Daily_reports_m->get_pending_dos_qty_in_mts($plant_id,$loose_oil_id,$report_date);
            
            $do_qty_arr = array('do_qty' =>$pending_do_qty);
            
            
             //$dos = $this->Daily_reports_m->get_pending_dos_data($loose_oil_id);
             $p_dos[$loose_oil_id] = $do_qty_arr;

             $dispatches[$loose_oil_id][0] = get_on_date_invoice($plant_id,$report_date,$loose_oil_id,3); // 3 for both plant and distributor 
             $cumulative = 1; // for cumulative
             //exit;
             $dispatches[$loose_oil_id][1] = get_searched_date_to_today_invoice($plant_id,$report_date,$loose_oil_id,$cumulative);


        }
        $data['daily_report'] = $daily_report ;
        //$data['invoice_report'] = $invoice_report ;
        $data['all_types'] = $all_types;
        $data['obs'] =$p_obs;
        $data['dos'] =$p_dos;
        $data['dispatches'] = $dispatches;
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
        $data['plant_id'] = $plant_id;
        $data['report_taken_as_on'] = $report_taken_as_on;
        $data['display_results'] = 1;
        $data['dispatch_date'] = $report_date;
        $this->load->view('daily_reports/print_oil_report',$data);
    }    
    public function daily_stock_report_search()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Daily Stock Report Search";
        $data['nestedView']['pageTitle'] = 'Daily Stock Report Search';
        $data['nestedView']['cur_page'] = 'daily_stock_report_search';
        $data['nestedView']['parent_page'] = 'daily_stock_report_search';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] =array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Daily Stock Report Search', 'class' => 'active', 'url' =>'');
        
        $this->load->view('daily_reports/stock_report_search',$data);
    }
    public function daily_stock_report()
    {
        $report_date = date('Y-m-d',strtotime($this->input->post('report_date')));
        $data['report_date'] =date('d-m-Y',strtotime($this->input->post('report_date')));
        $data['prev_date'] = date('d-m-Y', strtotime($this->input->post('report_date') .' -1 day'));
        //date('d.m.Y',strtotime("-1 days"));

        //echo $report_date;exit;
        //echo date('Y-m-d');
        if( $report_date > date('Y-m-d') )
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Sorry!</strong> You can not take the report beyond current date </div>');       
            redirect(SITE_URL.'daily_stock_report_search');
        }  
        # Data Array to carry the require fields to View and Model
        /*$data['nestedView']['heading']="Daily Stock Report ";
        $data['nestedView']['pageTitle'] = 'Daily Stock Report ';
        $data['nestedView']['cur_page'] = 'daily_stock_report';
        $data['nestedView']['parent_page'] = 'daily_stock_report';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] =array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Daily Stock Report ', 'class' => 'active', 'url' =>'');*/
        
       
       

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
                      $daily_report[$loose_oil_id][$res['product_id']] = $this->Daily_reports_m->get_opening_stock($loose_oil_id,$res['product_id'],$report_date);
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
        $this->load->view('daily_reports/print_stock_report',$data);
    }
    
    public function daily_pm_stock_report_search()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Daily PM Report Search";
        $data['nestedView']['pageTitle'] = 'Daily PM Report Search';
        $data['nestedView']['cur_page'] = 'daily_pm_stock_search';
        $data['nestedView']['parent_page'] = 'daily_pm_stock_search';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] =array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Daily PM Stock Search', 'class' => 'active', 'url' =>'');
        
        $this->load->view('daily_reports/pm_stock_search',$data);
    }  
    public function daily_pm_stock_report()
    {
        $report_date = date('Y-m-d',strtotime($this->input->post('report_date')));
        $data['report_date'] =date('d-m-Y',strtotime($this->input->post('report_date')));
        $data['prev_date'] = date('d-m-Y', strtotime($this->input->post('report_date') .' -1 day'));
        //date('d.m.Y',strtotime("-1 days"));

        //echo $report_date;exit;
        //echo date('Y-m-d');
        if( $report_date > date('Y-m-d') )
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Sorry!</strong> You can not take the report beyond current date </div>');       
            redirect(SITE_URL.'daily_pm_stock_report_search');
        }  
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Daily Stock Report ";
        $data['nestedView']['pageTitle'] = 'Daily Stock Report ';
        $data['nestedView']['cur_page'] = 'daily_stock_report';
        $data['nestedView']['parent_page'] = 'daily_stock_report';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] =array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Daily Stock Report ', 'class' => 'active', 'url' =>'');
        
       
       

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
                    $pm_results = $this->Daily_reports_m->get_pm_opening_stock($pm_group_id,$pm_id,$report_date);
                    $daily_report[$pm_group_id][$pm_id] = $pm_results;
                } 
            }          

        }
        
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
        $this->load->view('daily_reports/print_pm_stock_report',$data);
    }
    
}