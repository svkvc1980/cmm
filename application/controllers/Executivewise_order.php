<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Executivewise_order extends Base_controller 
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Executivewise_order_m");
        $this->load->model("Plant_do_m");
    }
    public function all_executive_pending_ob()
    {
    	# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="ExecutiveWise Pending OBs";
        $data['nestedView']['pageTitle'] = 'ExecutiveWise Pending OBs';
        $data['nestedView']['cur_page'] = 'executivewise_order_booking';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'ExecutiveWise Pending OBs', 'class' => '', 'url' => ''); 
        //$data['executive_list'] = $this->Executivewise_order_m->get_executives_list();
       	$this->load->view('distributor_ob/all_executive_pending_ob_search',$data);

    }
    public function all_executive_pending_ob_print()
    {
    	if($this->input->post('submit')!='')
        {
        	$from_date = date('Y-m-d',strtotime($this->input->post('from_date',TRUE)));
        	$to_date = date('Y-m-d',strtotime($this->input->post('to_date',TRUE)));
        	$executive_list = $this->Executivewise_order_m->get_executives_list();
        	$loose_oil_list = $this->Common_model->get_data('loose_oil',array('status'=>1));

        	$arr_exe = array();
        	foreach ($executive_list as $key => $value) 
        	{
        		foreach ($loose_oil_list as $keys => $values) 
        		{
    			$latest_details=$this->Executivewise_order_m->get_executivewise_pending_ob_list($from_date,$to_date,$value['executive_id'],$values['loose_oil_id']);
    			//print_r($latest_details); 
                $arr_exe[$value['executive_id']][$values['loose_oil_id']]=$latest_details;
            	}
        	}
        	$data['from_date'] = date('d-m-Y',strtotime($from_date));
        	$data['to_date'] = date('d-m-Y',strtotime($to_date));
        	$data['executive_list'] = $executive_list;
        	$data['loose_oil_list'] = $loose_oil_list;
        	$data['pending_qty_list'] = $arr_exe;
        	$this->load->view('distributor_ob/all_executive_pending_ob_print',$data);
        }
        else
        {
        	redirect(SITE_URL.'all_executive_pending_ob'); exit();
        }

    }
    public function all_executive_pending_do()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="ExecutiveWise Pending DOs";
        $data['nestedView']['pageTitle'] = 'ExecutiveWise Pending DOs';
        $data['nestedView']['cur_page'] = 'executivewise_delivery_booking';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'ExecutiveWise Pending DOs', 'class' => '', 'url' => ''); 
        //$data['executive_list'] = $this->Executivewise_order_m->get_executives_list();
        $this->load->view('delivery_orders/all_executive_pending_do_search',$data);

    }
    public function all_executive_pending_do_print()
    {
        if($this->input->post('submit')!='')
        {
            $from_date = date('Y-m-d',strtotime($this->input->post('from_date',TRUE)));
            $to_date = date('Y-m-d',strtotime($this->input->post('to_date',TRUE)));
            $executive_list = $this->Executivewise_order_m->get_executives_list();
            $loose_oil_list = $this->Common_model->get_data('loose_oil',array('status'=>1));

            $arr_exe = array();
            foreach ($executive_list as $key => $value) 
            {
                foreach ($loose_oil_list as $keys => $values) 
                {
                $latest_details=$this->Executivewise_order_m->get_executivewise_pending_do_list($from_date,$to_date,$value['executive_id'],$values['loose_oil_id']);
                //print_r($latest_details); 
                $arr_exe[$value['executive_id']][$values['loose_oil_id']]=$latest_details;
                }
            }
            $data['from_date'] = date('d-m-Y',strtotime($from_date));
            $data['to_date'] = date('d-m-Y',strtotime($to_date));
            $data['executive_list'] = $executive_list;
            $data['loose_oil_list'] = $loose_oil_list;
            $data['pending_qty_list'] = $arr_exe;
            $this->load->view('delivery_orders/all_executive_pending_do_print',$data);
        }
        else
        {
            redirect(SITE_URL.'all_executive_pending_do'); exit();
        }

    }
    
     public function product_wise_pending_ob()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Product Wise Pending O.B. Report";
        $data['nestedView']['pageTitle'] = 'Product Wise Pending O.B. Report';
        $data['nestedView']['cur_page'] = 'product_wise_pending_ob';
        $data['nestedView']['parent_page'] = 'reports';
        $data['nestedView']['list_page'] = 'ob_reports';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Product Wise Pending OB Report','class'=>'active','url'=>'');
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';
        # Get Blocks(C & F and Stock Point) 
        $blocks = $this->Plant_do_m->get_blocks();
        $ops_cf_stock_blocks = $this->Plant_do_m->ops_cf_stock_blocks();
        
        # Get Product_id array
        $block_ids = array_column($blocks,'block_id');

        foreach($ops_cf_stock_blocks as $block_id=>$value)
        {
            $ops_cf_stock_ids[] = $value['block_id'];
        }
        # Order For
        foreach($block_ids as $key=>$block_id)
        {
            $block_name  = $this->Common_model->get_value('block',array('block_id'=>$block_id),'name');
            $plants                            = $this->Plant_do_m->get_plants($block_id); 
            $plant_block[$block_id]['block_name'] = $block_name;
            $plant_block[$block_id]['plants']     = $plants;
        }

        # Data array for Lifting Point
        foreach($ops_cf_stock_ids as $key=>$block_id)
        {
            $block_name  = $this->Common_model->get_value('block',array('block_id'=>$block_id),'name');
            $plants      = $this->Plant_do_m->get_plants($block_id); 
            $lifting_points[$block_id]['block_name'] = $block_name;
            $lifting_points[$block_id]['plants']     = $plants;
        }
        $data['plant_block'] =$plant_block;
        $data['lifting_points'] =$lifting_points;



        $this->load->view('distributor_ob/report_product_wise_pending_ob',$data);
    }

 # Print Product wise pending OB List
    public function print_product_wise_pending_ob()
    {
        if($this->input->post('print_product_wise_pending_ob')!='') {
           $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 

            $search_params=array(
                                    'lifting_point_id'    => $this->input->post('lifting_point_id', TRUE),
                                    'fromDate'            => $from_date,
                                    'toDate'              => $to_date            
                                );
            //echo '<pre>';print_r($search_params); exit;
            $data['search_params'] =    $search_params;
            $data['plant_name'] =   $this->Common_model->get_value('plant', array('plant_id'=>$this->input->post('lifting_point_id', TRUE)),'name');
            $data['loose_oils'] = $this->Common_model->get_data('loose_oil',array('status'=>1));

            //echo $this->db->last_query(); exit;
            $dop_results = $this->Executivewise_order_m->product_wise_pending_ob($search_params);
            // looping do products
            $oil_wise_records = array();
            if(count($dop_results)>0)
            {
                foreach($dop_results as $dop_row)
                {
                    if(array_key_exists(@$dop_row['loose_oil_id'], $oil_wise_records))
                    {
                        $oil_wise_records[@$dop_row['loose_oil_id']][@$dop_row['product_id']]= $dop_row;
                    }
                    else{
                        $oil_wise_records[@$dop_row['loose_oil_id']][@$dop_row['product_id']] = $dop_row;
                    }
                }
            }
            $data['do_results'] = $oil_wise_records;
            //echo '<pre>'; print_r($data['do_results']); exit;
            $this->load->view('distributor_ob/print_product_wise_pending_ob',$data);
            
        }
    }
    public function all_executive_sales_view()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="All Executive Sales Report (Oils)";
        $data['nestedView']['pageTitle'] = 'All Executive Sales Report (Oils)';
        $data['nestedView']['cur_page'] = 'all_executive_sales_view';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'All Executive Sales Report (Oils)', 'class' => '', 'url' => ''); 
        //$data['executive_list'] = $this->Executivewise_order_m->get_executives_list();
        $this->load->view('sales/all_executive_sales_view',$data);

    }
    public function all_executive_sales_print()
    {
        if($this->input->post('submit')!='')
        {
            $from_date = date('Y-m-d',strtotime($this->input->post('from_date',TRUE)));
            $to_date = date('Y-m-d',strtotime($this->input->post('to_date',TRUE)));
            $executive_list = $this->Executivewise_order_m->get_executives_list();
            $loose_oil_list = $this->Common_model->get_data('loose_oil',array('status'=>1));

            $arr_exe = array();
            foreach ($executive_list as $key => $value) 
            {
                foreach ($loose_oil_list as $keys => $values) 
                {
                $latest_details=$this->Executivewise_order_m->get_executivewise_sales_list($from_date,$to_date,$value['executive_id'],$values['loose_oil_id']);
                $arr_exe[$value['executive_id']][$values['loose_oil_id']]=$latest_details;
                }
            }
           // echo "<pre>"; print_r($executive_list); exit();
            $data['from_date'] = date('d-m-Y',strtotime($from_date));
            $data['to_date'] = date('d-m-Y',strtotime($to_date));
            $data['executive_list'] = $executive_list;
            $data['loose_oil_list'] = $loose_oil_list;
            $data['pending_qty_list'] = $arr_exe;
            $this->load->view('sales/all_executive_sales_print',$data);
        }
        else
        {
            redirect(SITE_URL.'all_executive_sales_view'); exit();
        }

    }
    
    public function all_executive_sales_download()
    {
         if($this->input->post('download_executive')!='')
        {
            $from_date = date('Y-m-d',strtotime($this->input->post('from_date',TRUE)));
            $to_date = date('Y-m-d',strtotime($this->input->post('to_date',TRUE)));
            $executive_list = $this->Executivewise_order_m->get_executives_list();
            $loose_oil_list = $this->Common_model->get_data('loose_oil',array('status'=>1));
            $arr_exe = array();
            foreach ($executive_list as $key => $value) 
            {
                foreach ($loose_oil_list as $keys => $values) 
                {
                $latest_details=$this->Executivewise_order_m->get_executivewise_sales_list($from_date,$to_date,$value['executive_id'],$values['loose_oil_id']);
                $arr_exe[$value['executive_id']][$values['loose_oil_id']]=$latest_details;
                }
            }
           // echo "<pre>"; print_r($executive_list); exit();
            $from_date = date('d-m-Y',strtotime($from_date));
            $to_date = date('d-m-Y',strtotime($to_date));
            $executive_list = $executive_list;
            $loose_oil_list = $loose_oil_list;
            $pending_qty_list = $arr_exe;
             $header = '';
            $data ='';

           
            $data = '<table border="1">';
           
            $data.='<tr>';
            $data.='<th>'."Executive Name".'</th>';
            foreach($executive_list as $key)
            {
                $data.='<th align="center">'.$key['short_name'].'</th>';
            }
            $data.='<th>'."Total (Kgs)".'</th>';
            $data.='<th>'." Value".'</th>';
            $data.='</tr>';
            $data.='<tr style="background-color:#cccfff">';
            $i = 1; 
            foreach($executive_list as $key) {
                if($i==1) {
                    $data.='<th align="center" width="170" >'."Product".'</th>';
                }
           $i++;
           } $col_count=count($executive_list)+2;
            $data.='<th colspan="'.$col_count.'">'.'</th>';
            
            $data.='</tr>';
           $grand_total_kg = 0; 
           $grand_total_amt = 0;

            foreach($loose_oil_list as $keys => $values)
            
            { $total_kg = 0;
             $total_amt = 0; 
                $data.='<tr>';
                $data.='<td width="170">'.$values['name'].'</td>';
                
                foreach ($executive_list as $key => $value)
                { 
                    $total_kg += $pending_qty_list[$value['executive_id']][$values['loose_oil_id']]['invoice_kgs']; 
                    $total_amt += $pending_qty_list[$value['executive_id']][$values['loose_oil_id']]['invoice_amount']; 
                     
                    $data.='<td align="right">'.qty_format($pending_qty_list[$value['executive_id']][$values['loose_oil_id']]['invoice_kgs']);'</td>';
                  } 
                $grand_total_kg+=$total_kg;
                $grand_total_amt += $total_amt; 
                $data.='<td align="right">'.qty_format($total_kg);'</td>';
                $data.='<td align="right">'.price_format($total_amt);'</td>';
                    
                $data.='</tr>';

        

        } 
        $data.='<tr>';
        $data.='<td align="right"><b>'."Total Qty".'</b></td>';
            foreach ($executive_list as $key => $value) 
            { $column_count = 0;
                foreach($loose_oil_list as $keys => $values)
                {
                    $column_count+=$pending_qty_list[$value['executive_id']][$values['loose_oil_id']]['invoice_kgs'];

                } 
                $data.='<td align="right"><b>'.qty_format($column_count).'</b></td>';

            } 

            $data.='<td align="right"><b>'.qty_format($grand_total_kg).'</b></td>';
            $data.='<td align="right"><b>'.price_format($grand_total_amt).'</b></td>';

        $data.='</tr>';
           
            $data.='</table>';
            $time = date("Ymdhis");
            $xlFile='All_Executives_Sales_'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    
    }
}