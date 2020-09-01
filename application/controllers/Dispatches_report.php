<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

class Dispatches_report extends Base_controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Dispatches_report_m");
    }

    public function stock_dispatch_report()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="ProductWise Stock Dispatches";  
        $data['nestedView']['pageTitle'] = 'ProductWise Stock Dispatches';
        $data['nestedView']['cur_page'] = 'stock_dispatch';
        $data['nestedView']['parent_page'] = 'Stock Dispatch';
     
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home')); 
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'ProductWise Stock Dispatches', 'class' => 'active', 'url' => '');
    $data['distributor_list'] = $this->Dispatches_report_m->get_active_distributor();
        $data['plant'] = $this->Dispatches_report_m->get_plant();
        $this->load->view('dispatches_reports/stock_dispatch_r',$data);
    }

    public function stock_dispatch_detail()
    {
        if($this->input->post('submit', TRUE))
        {
            $from_date = date('Y-m-d', strtotime($this->input->post('from_date')));
            $to_date = date('Y-m-d', strtotime($this->input->post('to_date')));
            $plant_id = $this->input->post('plant_id');
            $distributor_id = $this->input->post('distributor_id');

            $data['from_date'] = $from_date; $data['to_date'] = $to_date;
            $data['plant_name'] = $this->Common_model->get_data('plant', array('plant_id' => $plant_id),'name');

            $invoices = $this->Dispatches_report_m->get_dispatched_invoices($from_date, $to_date, $plant_id,$distributor_id);
            //echo "<pre>"; print_r($invoices); exit;
            $dispatches_result = array();
            if(count($invoices)>0)
            {
                foreach ($invoices as $key => $value) 
                {
                    $dispatches_result[$value['invoice_id']]['invoice']=$value['invoice_number'];
                    $results=$this->Dispatches_report_m->get_dispatches_report($from_date, $to_date, $plant_id, $value['invoice_id'],$value['distributor_id']);
                    $do_number = $this->Dispatches_report_m->get_do_number_by_invoice($from_date, $to_date, $plant_id,$value['invoice_id']);
                    //echo $do_number; exit();
                    $dispatches_result[$value['invoice_id']]['invoice_results']=$results;
                    $dispatches_result[$value['invoice_id']]['do_number']=$do_number;
                }
            }
            $data['dispatches_result'] = $dispatches_result;
            
            $this->load->view('dispatches_reports/stock_dispatch_detail',$data);
        }
        else
        {
            redirect(SITE_URL.'product_wise_daily_dispatches'); exit;
        }
    }
    
    public function stock_transfer_view()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="DateWise Stock Transfer Report";  
        $data['nestedView']['pageTitle'] = 'DateWise Stock Transfer Report';
        $data['nestedView']['cur_page'] = 'stock_tranfer';
        $data['nestedView']['parent_page'] = 'reports';
     
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home')); 
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'DateWise Stock Transfer Report', 'class' => 'active', 'url' => '');
        $data['plant'] = $this->Dispatches_report_m->get_plant();
        $this->load->view('dispatches_reports/stock_transfer_report',$data);
    }

    public function stock_transfer_print()
    {
        if($this->input->post('submit', TRUE) !='')
        {
            $from_date = date('Y-m-d', strtotime($this->input->post('from_date')));
            $to_date = date('Y-m-d', strtotime($this->input->post('to_date')));
            $plant_id = $this->input->post('plant_id');

            $data['from_date'] = $from_date; 
            $data['to_date'] = $to_date;
            $data['plant_name'] = $this->Common_model->get_data('plant', array('plant_id' => $plant_id),'name');

            $invoices = $this->Dispatches_report_m->get_stock_transfer_invoices($from_date, $to_date, $plant_id);
            //echo "<pre>"; print_r($invoices); exit;
            $stock_receive_result = array();
            if(count($invoices)>0)
            {
                foreach ($invoices as $key => $value) 
                {
                    $stock_receive_result[$value['invoice_id']]['invoice_number']=$value['invoice_number'];
                    $stock_receive_result[$value['invoice_id']]['invoice_date']=format_date($value['invoice_date']);
                    $stock_receive_result[$value['invoice_id']]['plant_name']= $value['plant_name'];
                    $stock_receive_result[$value['invoice_id']]['plant_short_name']= $value['plant_short_name'];
                    $results=$this->Dispatches_report_m->get_stock_receive_products($value['receipt_invoice_id']);
                    $do_number = $this->Dispatches_report_m->get_invoice_do_number($value['invoice_id']);
                    $stock_receive_result[$value['invoice_id']]['invoice_results']=$results;
                    $stock_receive_result[$value['invoice_id']]['do_number']=$do_number;
                }
            }
            //echo "<pre>"; print_r($stock_receive_result); exit; 
            $data['stock_receive_result'] = $stock_receive_result;
            
            $this->load->view('dispatches_reports/stock_transfer_print',$data);
        }
        else
        {
            redirect(SITE_URL.'stock_transfer_view'); exit;
        }
    }
}
