<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';
class Stock_point_product_report extends Base_controller
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Stock_point_report_m");
        $this->load->library('Pdf');
    }
    public function stock_point_product_balance()
    {
    	 # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Product Stock Balance";
        $data['nestedView']['pageTitle'] = 'Product Stock Balance Report';
        $data['nestedView']['cur_page'] = 'product_stock_balance';
        $data['nestedView']['parent_page'] = '';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Product Stock Balance', 'class' => '', 'url' => '');
        $data['flag']=1;
        $data['plant_name']=$this->session->userdata('plant_name');
        $data['block_id']=$this->session->userdata('block_id');
        if($data['block_id'] == get_headoffice_block_id())
        {
        	$data['plants']=$this->Stock_point_report_m->get_units();
        }
        $this->load->view('stock_point_reports/view_stock_balance',$data);
    }
    public function stock_point_product_report()
    {
        
        if($this->input->post('submit')) 
        {   
            $effective_date=date('Y-m-d',strtotime($this->input->post('effective_date')));
            if( $effective_date > date('Y-m-d') )
	        {
	            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
	                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	                                                        <strong>Sorry!</strong> You can not take the report beyond current date </div>');       
	            redirect(SITE_URL.'stock_point_product_balance');
	        }
            $data['start_date']=$effective_date;
            $block_id=$this->session->userdata('block_id');
            if($block_id == get_headoffice_block_id())
            {
                $plant_id= $this->input->post('plant_id');
                $block=$this->Common_model->get_data_row('plant_block',array('plant_id'=>$plant_id),array('block_id'));
                $blocks=$block['block_id'];
                $data['block_id']=$blocks;
                $plant=$this->Common_model->get_data_row('plant',array('plant_id'=>$plant_id),array('name'));
                $data['plant_name']=$plant['name'];
                $data['plant_id']=$plant_id;
            }
            else
            {
                $plant_id=$this->session->userdata('ses_plant_id');
                $data['plant_name']=$this->session->userdata('plant_name');
                $data['plant_id']=$plant_id;
                $blocks=$block_id;
                $data['block_id']=$blocks;
            }

            //for product list
            $products=$this->Stock_point_report_m->get_products();
             if(count($products) > 0)
            {
                $product_results=array();
                foreach($products as $key =>$value)
                {   
                    if(array_key_exists(@$keys, $product_results))
                    {   
                        $product_results[$value['loose_oil_id']] ['products'][$value['product_id']] =array(
                            'product_id'     =>  $value['product_id'],
                            'product_name'   =>  $value['short_name'].' '.'['.$value['oil_weight'].']',
                            'items_per_carton'=> $value['items_per_carton']
                             );    
                    }    
                    else
                    {   $product_results[$value['loose_oil_id']]['loose_oil']=$value['loose_oil_name'];
                        $product_results[$value['loose_oil_id']] ['products'][$value['product_id']] =array(
                            'product_id'     =>  $value['product_id'],
                            'product_name'   =>  $value['short_name'].' '.'['.$value['oil_weight'].']',
                            'items_per_carton' => $value['items_per_carton'],
                            'oil_weight' => $value['oil_weight']
                            );
                    } 
                }  
		//retreving production qty data from search date
		$prod_qty_stock = $this->Stock_point_report_m->get_recovered_oil_production_qty($plant_id,$effective_date);
                //retreving production data from search date
                $production_stock=$this->Stock_point_report_m->get_production_data($plant_id,$effective_date);
                //retreving invoice stock from search date
                $curr_invoice_stock=$this->Stock_point_report_m->get_search_date_invoice_stock($plant_id,$effective_date);
                //echo '<pre>'; print_r($curr_invoice_stock);exit;
                //retreving  quantity from stock to counter  based on search date
                $gst_stock=$this->Stock_point_report_m->get_stock_to_counter_data($plant_id,$effective_date);

                // Get free samples between search date and now
                $search_date_free_stock=$this->Stock_point_report_m->get_search_date_free_sample($plant_id,$effective_date);

                //retreving free samples quantity based on search data
                $free_stock=$this->Stock_point_report_m->get_free_sample_data($plant_id,$effective_date);
                 //retreving leakage quantity based on search data
                $cur_leakage_stock=$this->Stock_point_report_m->get_search_date_leakage_quantity($plant_id,$effective_date);
                //retreving current stock from plant product
                $current_quantity=$this->Stock_point_report_m->get_plant_product_quantity($plant_id);
                //retreving product stock of that product id
                $stock=$this->Stock_point_report_m->get_product_stock($plant_id,$effective_date);
                 //retreving invoice stock
                $invoice_stock=$this->Stock_point_report_m->get_invoice_stock($plant_id,$effective_date);
               
                // Stocks received on search date
                $stock_received = $this->Stock_point_report_m->get_plant_receits($plant_id,$effective_date);
                /*echo $this->db->last_query().'<br>';
                echo '<pre>';print_r($stock_received); exit;*/
                // looping stocks received and preparing array with keys plant_id, product_id
                $received_stock =  array();
                foreach($stock_received as $sr_row)
                {
                    $received_stock[$sr_row['plant_id']][$sr_row['product_id']]['cartons'] = $sr_row['carton_receipt_quantity'];
                    $received_stock[$sr_row['plant_id']][$sr_row['product_id']]['pouches'] = $sr_row['pouch_receipt_quantity'];
                    $received_stock[$sr_row['plant_id']][$sr_row['product_id']]['oil_weight'] = $sr_row['tot_oil_weight'];
                }
                $data['stock_received'] = $received_stock;
                //echo '<pre>'; print_r($received_stock); exit;
                //retreving leakage quantity
                $leakage_stock=$this->Stock_point_report_m->get_leakage_stock($plant_id,$effective_date);
                //retreving recovery quantity
                /*$recovered_stock=$this->Stock_point_report_m->get_recovery_stock($plant_id,$effective_date);*/
                $present_stock=array();
                 foreach ($current_quantity as $key1 => $value1) 
                 {
                    $present_stock[$value1['product_id']]['opening_stock']=$value1['quantity'];
                    $present_stock[$value1['product_id']]['pouch_opening_stock']=$value1['pouch_quantity'];
                 }
                 foreach ($stock as $key4 => $value4) 
                 {
                    $present_stock[$value4['product_id']]['receipt_stock']=$value4['receipt_quantity'];
                    $present_stock[$value4['product_id']]['pouch_receipt_stock']=$value4['pouch_receipt_quantity'];
                 }
                 foreach ($invoice_stock as $key2 => $value2) 
                 {
                    $present_stock[$value2['product_id']]['invoice_stock']=$value2['invoice_quantity'];
                    $present_stock[$value2['product_id']]['pouch_invoice_stock']=$value2['pouch_invoice_quantity'];
                 }
                foreach ($leakage_stock as $key3 => $value3) 
                 {
                    $present_stock[$value3['product_id']]['leakage_stock']=$value3['leakage_quantity'];
                    $present_stock[$value3['product_id']]['pouch_leakage_stock']=$value3['leaked_pouches'];
                 }
                 foreach ($production_stock as $key5 => $value5) 
                 {
                    $present_stock[$value5['product_id']]['production_qty']=$value5['production_qty'];
                    $present_stock[$value5['product_id']]['pouch_production_qty']=$value5['pouch_production_qty'];
                 }
                 
                 foreach ($prod_qty_stock as $key11 => $value11) 
                 {
                    $present_stock[$value11['product_id']]['tot_production_qty']=$value11['tot_production_qty'];
                    $present_stock[$value11['product_id']]['tot_production_weight']=$value11['tot_production_weight'];
                 }

                 foreach ($search_date_free_stock as $key10 => $value10) 
                 {
                    $present_stock[$value10['product_id']]['search_day_free_qty']=$value10['free_quantity'];
                    $present_stock[$value10['product_id']]['pouch_search_day_free_qty']=round($value10['pouch_free_quantity']);
                 }
                 foreach ($curr_invoice_stock as $key6 => $value6) 
                 {
                    $present_stock[$value6['product_id']]['curr_invoice_qty']=$value6['invoice_quantity'];
                    $present_stock[$value6['product_id']]['pouch_curr_invoice_qty']=$value6['pouch_invoice_quantity'];
                 }
                 foreach ($gst_stock as $key7 => $value7) 
                 {
                    $present_stock[$value7['product_id']]['curr_gst_qty']=$value7['gst_quantity'];
                    $present_stock[$value7['product_id']]['pouch_curr_gst_qty']=$value7['pouch_gst_quantity'];
                 }
                 foreach ($free_stock as $key8 => $value8) 
                 {
                    $present_stock[$value8['product_id']]['curr_free_qty']=$value8['free_quantity'];
                    $present_stock[$value8['product_id']]['pouch_curr_free_qty']=round($value8['pouch_free_quantity']);
                 }
                foreach ($cur_leakage_stock as $key9 => $value9) 
                 {
                    $present_stock[$value9['product_id']]['curr_leakage_qty']=$value9['leakage_quantity'];
                    $present_stock[$value9['product_id']]['curr_pouch_leakage_qty']=$value9['leaked_pouches'];
                 }
                 $block_id=get_ops_block_id();
                 $units=$this->Stock_point_report_m->get_ops_units($block_id);
                 $data['units']=$units;
                 $arr_unit=array();
                 foreach($units as $key =>$value)
                 {
                    $receipt_details=$this->Stock_point_report_m->get_stock_receipt_search_date($value['plant_id'],$effective_date);
                    $arr_unit[$value['plant_id']]['plant_id']=$value['plant_id'];
                    $arr_unit[$value['plant_id']]['plant_results']=$receipt_details;
                 }
                $stock_receipt_details=array();
                foreach($arr_unit as $key =>$value )
                {  
                    foreach ($value['plant_results'] as $keys => $values) 
                    {
                        $stock_receipt_details[$key][$values['product_id']]['receipt_quantity']=$values['receipt_quantity'];
                        $stock_receipt_details[$key][$values['product_id']]['pouch_receipt_quantity']=$values['pouch_receipt_quantity'];
                    }
                }

            // for loose oils list in stock point
            $data['loose_oils']=$this->Stock_point_report_m->get_loose_oils();
            //retreving oils from plant recovery oil
            $loose_oil_stock=$this->Common_model->get_data('plant_recovery_oil',array('plant_id'=>$plant_id));
            //retreving loose oil from recovered oil production 
            $production_oil_qty=$this->Stock_point_report_m->get_recovered_oil_production($plant_id,$effective_date);

            //retreving leakage recovered oil
            $recovered_oil_qty=$this->Stock_point_report_m->get_leakage_recovered_stock($plant_id,$effective_date);

            //retreving oils from recovered oil production on search date
            $curr_prod_oil_qty=$this->Stock_point_report_m->get_rop_date($plant_id,$effective_date);
            //echo '<pre>'; print_r($curr_prod_oil_qty); exit;
            //retreving leakage recovered oil based on search date
            $curr_recovered_oil=$this->Stock_point_report_m->get_curr_leakage_recovered_qty($plant_id,$effective_date);
            $present_oil_stock=array();
            foreach ($loose_oil_stock as $key10 => $value10)
            {
                $present_oil_stock[$value10['loose_oil_id']]['net_stock']=$value10['oil_weight'];
            }
             foreach ($production_oil_qty as $key11 => $value11)
            {
                $present_oil_stock[$value11['loose_oil_id']]['production_oil']=$value11['production_oil_qty'];
            }
            foreach ($recovered_oil_qty as $key12 => $value12)
            {
                $present_oil_stock[$value12['loose_oil_id']]['recovered_oil']=$value12['recovered_oil_weight'];
            }
            foreach ($curr_prod_oil_qty as $key13 => $value13)
            {
                $present_oil_stock[$value13['loose_oil_id']]['curr_production_oil']=$value13['production_oil_qty'];
            }
             foreach ($curr_recovered_oil as $key14 => $value14)
            {
                $present_oil_stock[$value14['loose_oil_id']]['curr_recovered_oil']=$value14['recovered_oil_weight'];
            }
            //print_r($present_stock);exit;
            $data['present_oil_stock']=$present_oil_stock;
            $data['present_stock']=$present_stock;
            $data['stock_receipt_details']=$stock_receipt_details;
            $data['product_results'] =$product_results;
            $data['flag']=2;
            $data['effective_date']=$effective_date;
            $this->load->view('stock_point_reports/print_stock_point_report',$data);
           }
           else
           {
             $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong>No Stock is available!
                             </div>');

                redirect(SITE_URL.'stock_point_product_balance');exit;
           }
        }
    }

    public function monthly_godown_stock_report()
    {
         # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Monthly Godown Stock Report";
        $data['nestedView']['pageTitle'] = 'Monthly Godown Stock Report';
        $data['nestedView']['cur_page'] = 'monthly_godown_stock_report';
        $data['nestedView']['parent_page'] = '';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Monthly Godown Stock Report', 'class' => '', 'url' => '');
        $data['flag']=1;
        $data['plant_name']=$this->session->userdata('plant_name');
        $data['block_id']=$this->session->userdata('block_id');
        if($data['block_id'] == get_headoffice_block_id())
        {
            $data['plants']=$this->Stock_point_report_m->get_units();
        }
        $this->load->view('stock_point_reports/monthly_stock_report',$data);
    }

    // Mahesh 13apr17 10:42 pm
    public function print_monthly_stock_report()
    {
        
        if($this->input->post('submit')) 
        {   
            $from_date=date('Y-m-d',strtotime($this->input->post('from_date')));
            $to_date=date('Y-m-d',strtotime($this->input->post('to_date')));
            if( $to_date > date('Y-m-d') )
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                            <strong>Sorry!</strong> You can not take the report beyond current date </div>');       
                redirect(SITE_URL.'monthly_godown_stock_report');
            }
            $data['from_date']=$from_date;
            $data['to_date']=$to_date;
            $block_id=$this->session->userdata('block_id');
            if($block_id == get_headoffice_block_id())
            {
                $plant_id= $this->input->post('plant_id');
                $block=$this->Common_model->get_data_row('plant_block',array('plant_id'=>$plant_id),array('block_id'));
                $blocks=$block['block_id'];
                $data['block_id']=$blocks;
                $plant=$this->Common_model->get_data_row('plant',array('plant_id'=>$plant_id),array('name'));
                $data['plant_name']=$plant['name'];
                $data['plant_id']=$plant_id;
            }
            else
            {
                $plant_id=$this->session->userdata('ses_plant_id');
                $data['plant_name']=$this->session->userdata('plant_name');
                $data['plant_id']=$plant_id;
                $blocks=$block_id;
                $data['block_id']=$blocks;
            }

            //for product list
            $products=$this->Stock_point_report_m->get_products();
             if(count($products) > 0)
            {
                $product_results=array();
                foreach($products as $key =>$value)
                {   
                    if(array_key_exists(@$keys, $product_results))
                    {   
                        $product_results[$value['loose_oil_id']] ['products'][$value['product_id']] =array(
                            'product_id'     =>  $value['product_id'],
                            'product_name'   =>  $value['short_name'].' '.'['.$value['oil_weight'].']',
                            'items_per_carton'=> $value['items_per_carton']
                             );    
                    }    
                    else
                    {   $product_results[$value['loose_oil_id']]['loose_oil']=$value['loose_oil_name'];
                        $product_results[$value['loose_oil_id']] ['products'][$value['product_id']] =array(
                            'product_id'     =>  $value['product_id'],
                            'product_name'   =>  $value['short_name'].' '.'['.$value['oil_weight'].']',
                            'items_per_carton' => $value['items_per_carton'],
                            'oil_weight' => $value['oil_weight']
                            );
                    } 
                }  

                //retreving current stock from plant product
                $current_quantity=$this->Stock_point_report_m->get_plant_product_quantity($plant_id);

                /*** 
                **** Get from date to current date totals
                ***/

                //retreving production qty data from search date
                $prod_qty_stock = $this->Stock_point_report_m->get_recovered_oil_production_qty($plant_id,$from_date);
                // Get free samples between search date and now
                $search_date_free_stock=$this->Stock_point_report_m->get_search_date_free_sample($plant_id,$from_date);
                // Get stock receipts from date to current date totals
                $stock=$this->Stock_point_report_m->get_product_stock($plant_id,$from_date);
                // Get invoice sales from date to current date totals
                $invoice_stock=$this->Stock_point_report_m->get_invoice_stock($plant_id,$from_date);
                // Get leaked stock from_date to current date totals
                $leakage_stock=$this->Stock_point_report_m->get_leakage_stock($plant_id,$from_date);

                /*** 
                **** Get from_date to to_date transaction totals 
                ***/

                //Get Production stock between from_date and to_date e
                $production_stock=$this->Stock_point_report_m->get_monthly_production_data($plant_id,$from_date,$to_date);
                //Get Invoice sales between from_date and to_date 
                $curr_invoice_stock=$this->Stock_point_report_m->get_monthly_invoice_sales($plant_id,$from_date,$to_date);
                //Get Stock transfer to counter between from_date and to_date 
                $gst_stock=$this->Stock_point_report_m->get_monthly_stock_transfer_counter($plant_id,$from_date,$to_date);
                //Get free samples between from_date and to_date 
                $free_stock=$this->Stock_point_report_m->get_monthly_free_samples($plant_id,$from_date,$to_date);
                //Get leaked stock between from_date and to_date 
                $cur_leakage_stock=$this->Stock_point_report_m->get_monthly_leaked_stock($plant_id,$from_date,$to_date);
                //Get stock receipts between from_date and to_date 
                $stock_received = $this->Stock_point_report_m->get_monthly_stock_receipts($plant_id,$from_date,$to_date);


                // looping stocks received and preparing array with keys plant_id, product_id
                $received_stock =  array();
                foreach($stock_received as $sr_row)
                {
                    $received_stock[$sr_row['plant_id']][$sr_row['product_id']]['cartons'] = $sr_row['carton_receipt_quantity'];
                    $received_stock[$sr_row['plant_id']][$sr_row['product_id']]['pouches'] = $sr_row['pouch_receipt_quantity'];
                    $received_stock[$sr_row['plant_id']][$sr_row['product_id']]['oil_weight'] = $sr_row['tot_oil_weight'];
                }
                $data['stock_received'] = $received_stock;
                //echo '<pre>'; print_r($received_stock); exit;
                
                //retreving recovery quantity
                /*$recovered_stock=$this->Stock_point_report_m->get_recovery_stock($plant_id,$from_date);*/
                $present_stock=array();
                 foreach ($current_quantity as $key1 => $value1) 
                 {
                    $present_stock[$value1['product_id']]['opening_stock']=$value1['quantity'];
                    $present_stock[$value1['product_id']]['pouch_opening_stock']=$value1['pouch_quantity'];
                 }
                 foreach ($stock as $key4 => $value4) 
                 {
                    $present_stock[$value4['product_id']]['receipt_stock']=$value4['receipt_quantity'];
                    $present_stock[$value4['product_id']]['pouch_receipt_stock']=$value4['pouch_receipt_quantity'];
                 }
                 foreach ($invoice_stock as $key2 => $value2) 
                 {
                    $present_stock[$value2['product_id']]['invoice_stock']=$value2['invoice_quantity'];
                    $present_stock[$value2['product_id']]['pouch_invoice_stock']=$value2['pouch_invoice_quantity'];
                 }
                foreach ($leakage_stock as $key3 => $value3) 
                 {
                    $present_stock[$value3['product_id']]['leakage_stock']=$value3['leakage_quantity'];
                    $present_stock[$value3['product_id']]['pouch_leakage_stock']=$value3['leaked_pouches'];
                 }
                 foreach ($production_stock as $key5 => $value5) 
                 {
                    $present_stock[$value5['product_id']]['production_qty']=$value5['production_qty'];
                    $present_stock[$value5['product_id']]['pouch_production_qty']=$value5['pouch_production_qty'];
                 }
                 
                 foreach ($prod_qty_stock as $key11 => $value11) 
                 {
                    $present_stock[$value11['product_id']]['tot_production_qty']=$value11['tot_production_qty'];
                    $present_stock[$value11['product_id']]['tot_production_weight']=$value11['tot_production_weight'];
                 }

                 foreach ($search_date_free_stock as $key10 => $value10) 
                 {
                    $present_stock[$value10['product_id']]['search_day_free_qty']=$value10['free_quantity'];
                    $present_stock[$value10['product_id']]['pouch_search_day_free_qty']=round($value10['pouch_free_quantity']);
                 }
                 foreach ($curr_invoice_stock as $key6 => $value6) 
                 {
                    $present_stock[$value6['product_id']]['curr_invoice_qty']=$value6['invoice_quantity'];
                    $present_stock[$value6['product_id']]['pouch_curr_invoice_qty']=$value6['pouch_invoice_quantity'];
                 }
                 foreach ($gst_stock as $key7 => $value7) 
                 {
                    $present_stock[$value7['product_id']]['curr_gst_qty']=$value7['gst_quantity'];
                    $present_stock[$value7['product_id']]['pouch_curr_gst_qty']=$value7['pouch_gst_quantity'];
                 }
                 foreach ($free_stock as $key8 => $value8) 
                 {
                    $present_stock[$value8['product_id']]['curr_free_qty']=$value8['free_quantity'];
                    $present_stock[$value8['product_id']]['pouch_curr_free_qty']=round($value8['pouch_free_quantity']);
                 }
                foreach ($cur_leakage_stock as $key9 => $value9) 
                 {
                    $present_stock[$value9['product_id']]['curr_leakage_qty']=$value9['leakage_quantity'];
                    $present_stock[$value9['product_id']]['curr_pouch_leakage_qty']=$value9['leaked_pouches'];
                 }
                 $block_id=get_ops_block_id();
                 $units=$this->Stock_point_report_m->get_ops_units($block_id);
                 $data['units']=$units;
                 $arr_unit=array();
                 foreach($units as $key =>$value)
                 {
                    $receipt_details=$this->Stock_point_report_m->get_stock_receipt_search_date($value['plant_id'],$from_date);
                    $arr_unit[$value['plant_id']]['plant_id']=$value['plant_id'];
                    $arr_unit[$value['plant_id']]['plant_results']=$receipt_details;
                 }
                $stock_receipt_details=array();
                foreach($arr_unit as $key =>$value )
                {  
                    foreach ($value['plant_results'] as $keys => $values) 
                    {
                        $stock_receipt_details[$key][$values['product_id']]['receipt_quantity']=$values['receipt_quantity'];
                        $stock_receipt_details[$key][$values['product_id']]['pouch_receipt_quantity']=$values['pouch_receipt_quantity'];
                    }
                }

            // for loose oils list in stock point
            $data['loose_oils']=$this->Stock_point_report_m->get_loose_oils();
            //retreving oils from plant recovery oil
            $loose_oil_stock=$this->Common_model->get_data('plant_recovery_oil',array('plant_id'=>$plant_id));

            /***
            **** Get oil transaction between from_date to current date totals
            ***/
            //retreving loose oil from recovered oil production 
            $production_oil_qty=$this->Stock_point_report_m->get_recovered_oil_production($plant_id,$from_date);
            //retreving leakage recovered oil
            $recovered_oil_qty=$this->Stock_point_report_m->get_leakage_recovered_stock($plant_id,$from_date);

            /***
            **** Get oil transaction between from_date to to_date totals
            ***/
            //Get production between from_date to to_date totals
            $curr_prod_oil_qty=$this->Stock_point_report_m->get_monthly_porduction($plant_id,$from_date,$to_date);
            //Get recovered oil between from_date to to_date totals
            $curr_recovered_oil=$this->Stock_point_report_m->get_monthly_recovered_oil($plant_id,$from_date,$to_date);
            $present_oil_stock=array();
            foreach ($loose_oil_stock as $key10 => $value10)
            {
                $present_oil_stock[$value10['loose_oil_id']]['net_stock']=$value10['oil_weight'];
            }
             foreach ($production_oil_qty as $key11 => $value11)
            {
                $present_oil_stock[$value11['loose_oil_id']]['production_oil']=$value11['production_oil_qty'];
            }
            foreach ($recovered_oil_qty as $key12 => $value12)
            {
                $present_oil_stock[$value12['loose_oil_id']]['recovered_oil']=$value12['recovered_oil_weight'];
            }
            foreach ($curr_prod_oil_qty as $key13 => $value13)
            {
                $present_oil_stock[$value13['loose_oil_id']]['curr_production_oil']=$value13['production_oil_qty'];
            }
             foreach ($curr_recovered_oil as $key14 => $value14)
            {
                $present_oil_stock[$value14['loose_oil_id']]['curr_recovered_oil']=$value14['recovered_oil_weight'];
            }
            //print_r($present_stock);exit;
            $data['present_oil_stock']=$present_oil_stock;
            $data['present_stock']=$present_stock;
            $data['stock_receipt_details']=$stock_receipt_details;
            $data['product_results'] =$product_results;
            $data['flag']=2;
            $data['from_date']=$from_date;
            $this->load->view('stock_point_reports/print_monthly_stock_report',$data);
           }
           else
           {
             $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong>No Stock is available!
                             </div>');

                redirect(SITE_URL.'monthly_godown_stock_report');exit;
           }
        }
    }
}