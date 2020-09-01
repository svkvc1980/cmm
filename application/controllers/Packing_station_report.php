<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

/*
stock transfer
auther: Srilekha
created on: 25th mar 2017 01:08pm
*/

class Packing_station_report extends Base_controller { 


	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Packing_station_m");
	}

	public function packing_station_tanker_view()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Daily Tanker report";
        $data['nestedView']['pageTitle'] = 'Daily Tanker report';
        $data['nestedView']['cur_page'] = 'Daily Tanker report';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Daily Tanker report', 'class' => '', 'url' => '');

        $this->load->view('packing_station/packing_station_tanker_view',$data);

	}


	public function packing_station_tanker_report_print()
	{

		/*# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Daily Tanker report";
        $data['nestedView']['pageTitle'] = 'Daily Tanker report';
        $data['nestedView']['cur_page'] = 'Daily Tanker report';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Daily Tanker report', 'class' => '', 'url' => '');
*/		
        $loose_oil=$this->Common_model->get_data('loose_oil',array('status'=>1));
        $loose_oil_id=array_column($loose_oil,'loose_oil_id');
        $packing_material=$this->Common_model->get_data('packing_material',array('status'=>1));
        $packing_material_id=array_column($packing_material,'pm_id');
        $free_gift=$this->Common_model->get_data('free_gift',array('status'=>1));
        $free_gift_id=array_column($free_gift,'free_gift_id');
        $plant_id=$this->session->userdata('ses_plant_id');
        $submit=$this->input->post('search_sales', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        $to_date=date('Y-m-d', strtotime($this->input->post('end_date',TRUE)));
        if($submit!='')
        {	$oil_results = array();
        	$pm_results = array();
        	$fg_results = array();
        	foreach($loose_oil_id as $key=>$value)
	        {
	        	$oil_results[$value]['loose_oil_name'] = $this->Common_model->get_value('loose_oil',array('loose_oil_id'=>$value),'name');
	        	$oil_results[$value]['sub_products']=$this->Packing_station_m->oil_reports($value,$from_date,$to_date);
	        }
            //echo "<pre>";
            //print_r($oil_results); exit();
	        foreach($packing_material_id as $key=>$value)
	        {
	        	$pm_results[$value]['pm_name'] = $this->Common_model->get_value('packing_material',array('pm_id'=>$value),'name');
	        	$pm_results[$value]['sub_products']=$this->Packing_station_m->pm_reports($value,$from_date,$to_date);
	        }
	        foreach($free_gift_id as $key=>$value)
	        {
	        	$fg_results[$value]['fg_name'] = $this->Common_model->get_value('free_gift',array('free_gift_id'=>$value),'name');
	        	$fg_results[$value]['sub_products']=$this->Packing_station_m->fg_reports($value,$from_date,$to_date);
	        }
            $empty_truck_results=$this->Packing_station_m->get_empty_truck_reports($from_date,$to_date);
            $invoice_details = array();
            foreach($empty_truck_results as $key => $value)
            {
              $tanker_id[$key]['tanker_id']=$value['tanker_id'];
                $weight_result[$key]=array();
                foreach($tanker_id as $key1=>$value1)
                {
                    
                    $invoice_details[$key1]=$this->Packing_station_m->get_empty_truck_invoice_details($value1);
                    $invoice_id_arr = $invoice_details[$key1][0]['invoice_ids'];
                    if($invoice_id_arr!='')
                    {
                        $single_invoice_id = $invoice_details[$key1][0]['single'];
                        $result = $this->Packing_station_m->get_party_name($single_invoice_id);
                        $invoice =explode(',', $invoice_id_arr);
                        $total_weight = 0;
                        foreach ($invoice as $key2 => $value2) 
                        {
                            $inv_products = $this->Packing_station_m->get_invoice_products($value2);
                            $sum_of_qty = 0;
                            $t_pm_weight = 0;
                            $t_gross = 0;
                            foreach($inv_products as $keys3 =>$values3)
                            { 
                                $sum_of_qty = $sum_of_qty + $values3['qty_in_kg'];
                                $t_pm_weight = $t_pm_weight + $values3['pm_weight'];
                                $t_gross = $sum_of_qty + $t_pm_weight ; 
                            }
                            $total_weight+=$t_gross; 

                        }
                    }
                    else
                    {
                        $total_weight = '';
                    }
                    
                    
                    $invoice_details[$key1][0]['weight'] = $total_weight;
                    $invoice_details[$key1][0]['agency_name']=$result;
                }
                
                
            }
           /*echo "<pre>";
            print_r($invoice_details); exit();*/
        $data['invoice_details']=$invoice_details;
	    $data['oil_results']=$oil_results;
	    $data['pm_results']=$pm_results;
	    $data['fg_results']=$fg_results;
	    $data['from_date']=$from_date;
	    $data['to_date']=$to_date;
        }
        
        $data['packing_station_name']=$this->Common_model->get_value('plant',array('plant_id'=>$plant_id),'name');
        //$oil_tanker=$this->Packing_station_m->oil_reports($loose_oil_id);
        //echo "<pre>"; print_r($product_results); exit;
         $this->load->view('packing_station/packing_station_tanker_report_print',$data);
	}


	public function packing_station_tanker_abstract_view()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Daily Tanker Abstract report";
        $data['nestedView']['pageTitle'] = 'Daily Tanker Abstract report';
        $data['nestedView']['cur_page'] = 'Daily Tanker Abstract report';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Daily Tanker Abstract report', 'class' => '', 'url' => '');

        $this->load->view('packing_station/packing_station_tanker_abstract_view',$data);

	}


	public function packing_station_tanker_report_abstract_print()
	{

		/*# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Daily Tanker report";
        $data['nestedView']['pageTitle'] = 'Daily Tanker report';
        $data['nestedView']['cur_page'] = 'Daily Tanker report';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Daily Tanker report', 'class' => '', 'url' => '');
*/		
        $loose_oil=$this->Common_model->get_data('loose_oil',array('status'=>1));
        $loose_oil_id=array_column($loose_oil,'loose_oil_id');
        $packing_material=$this->Common_model->get_data('packing_material',array('status'=>1));
        $packing_material_id=array_column($packing_material,'pm_id');
        $free_gift=$this->Common_model->get_data('free_gift',array('status'=>1));
        $free_gift_id=array_column($free_gift,'free_gift_id');
        $plant_id=$this->session->userdata('ses_plant_id');
        $submit=$this->input->post('search_sales', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        $to_date=date('Y-m-d', strtotime($this->input->post('end_date',TRUE)));
        if($submit!='')
        {
        	$oil_results = array();
        	$pm_results = array();
        	$fg_results = array();
        	foreach($loose_oil_id as $key=>$value)
	        {
	        	$oil_results[$value]['loose_oil_name'] = $this->Common_model->get_value('loose_oil',array('loose_oil_id'=>$value),'name');
	        	$oil_results[$value]['sub_products']=$this->Packing_station_m->oil_reports($value,$from_date,$to_date);
	        }
	        foreach($packing_material_id as $key=>$value)
	        {
	        	$pm_results[$value]['pm_name'] = $this->Common_model->get_value('packing_material',array('pm_id'=>$value),'name');
	        	$pm_results[$value]['sub_products']=$this->Packing_station_m->pm_reports($value,$from_date,$to_date);
	        }
	        foreach($free_gift_id as $key=>$value)
	        {
	        	$fg_results[$value]['fg_name'] = $this->Common_model->get_value('free_gift',array('free_gift_id'=>$value),'name');
	        	$fg_results[$value]['sub_products']=$this->Packing_station_m->fg_reports($value,$from_date,$to_date);
	        }
            // For emplty Truck Entry Results

            $empty_truck_results=$this->Packing_station_m->get_empty_truck_reports($from_date,$to_date);
            $invoice_details = array();
            foreach($empty_truck_results as $key => $value)
            {
              $tanker_id[$key]['tanker_id']=$value['tanker_id'];
                $weight_result[$key]=array();
                foreach($tanker_id as $key1=>$value1)
                {
                    
                    $invoice_details[$key1]=$this->Packing_station_m->get_empty_truck_invoice_details($value1);
                    $invoice_id_arr = $invoice_details[$key1][0]['invoice_ids'];
                    if($invoice_id_arr!='')
                    {
                        $single_invoice_id = $invoice_details[$key1][0]['single'];
                        $result = $this->Packing_station_m->get_party_name($single_invoice_id);
                        $invoice =explode(',', $invoice_id_arr);
                        $total_weight = 0;
                        foreach ($invoice as $key2 => $value2) 
                        {
                            $inv_products = $this->Packing_station_m->get_invoice_products($value2);
                            $sum_of_qty = 0;
                            $t_pm_weight = 0;
                            $t_gross = 0;
                            foreach($inv_products as $keys3 =>$values3)
                            { 
                                $sum_of_qty = $sum_of_qty + $values3['qty_in_kg'];
                                $t_pm_weight = $t_pm_weight + $values3['pm_weight'];
                                $t_gross = $sum_of_qty + $t_pm_weight ; 
                            }
                            $total_weight+=$t_gross; 

                        }
                    }
                    else
                    {
                        $total_weight = '';
                    }
                    
                    
                    $invoice_details[$key1][0]['weight'] = $total_weight;
                    $invoice_details[$key1][0]['agency_name']=$result;
                }
                
                
            }
           /*echo "<pre>";
            print_r($invoice_details); exit();*/
        $data['invoice_details']=$invoice_details;
	    $data['oil_results']=$oil_results;
	    $data['pm_results']=$pm_results;
	    $data['fg_results']=$fg_results;
	    $data['from_date']=$from_date;
	    $data['to_date']=$to_date;
        }
        
        $data['packing_station_name']=$this->Common_model->get_value('plant',array('plant_id'=>$plant_id),'name');
        //$oil_tanker=$this->Packing_station_m->oil_reports($loose_oil_id);
        //echo "<pre>"; print_r($product_results); exit;
         $this->load->view('packing_station/packing_station_tanker_report_abstract_print',$data);
	}

}