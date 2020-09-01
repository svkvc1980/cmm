<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

/* 	ops leakage reports
	auther:mastan
	created on: 16 mar 2017
*/

class Ops_leakage_r extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Ops_leakage_r_m");
        $this->load->library('Pdf');
	}

	public function ops_leakage_r()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Ops Leakage Reports";
		$data['nestedView']['pageTitle'] = 'Ops Leakage Reports';
        $data['nestedView']['cur_page'] = 'ops_leakage_r';
        $data['nestedView']['parent_page'] = 'leakage';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Ops Leakage Reports', 'class' => 'active', 'url' => '');
        $plant_id=$this->session->userdata('ses_plant_id');
        # Search Functionality
        $p_search=$this->input->post('serach_leakage', TRUE);
        if($p_search!='') 
        {   
            $from_date=$this->input->post('from_date');
            if($from_date=='')
            {
                $from_date='';
            }
            else
            {
                $from_date= date('Y-m-d',strtotime($this->input->post('from_date')));
            }
            //echo $start_date;exit;
            $to_date=$this->input->post('to_date');
            if($to_date=='')
            {
                $to_date='';
            }
            else
            {
                $to_date= date('Y-m-d',strtotime($this->input->post('to_date')));
            }
            $search_params=array(
                'product_id'	=> $this->input->post('product', TRUE),
                'loose_oil_id'   => $this->input->post('loose_oil', TRUE),
                'from_date' 	=> $from_date,
                'to_date' 		=> $to_date
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'product_id'	=> $this->session->userdata('product_id'),
                    'loose_oil_id'  => $this->session->userdata('loose_oil_id'),
                    'from_date'		=> $this->session->userdata('from_date'),
                    'to_date'   	=> $this->session->userdata('to_date')
                    
                                  );
            }
            else {
                $search_params=array(
                      'product_id' 		=> '',
                      'loose_oil_id'      => '',
                      'from_date'		=> '',
                      'to_date'   		=> ''
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        
        # Default Records Per Page - always 10
        # pagination start 
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'ops_leakage_r/';
        # Total Records
        $config['total_rows'] = $this->Ops_leakage_r_m->ops_leakage_report_total_rows($search_params,$plant_id);

        $config['per_page'] = getDefaultPerPageRecords();
        $data['total_rows'] = $config['total_rows'];
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        $current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        if ($data['pagination_links'] != '') {
            $data['last'] = $this->pagination->cur_page * $config['per_page'];
            if ($data['last'] > $data['total_rows']) {
                $data['last'] = $data['total_rows'];
            }
            $data['pagermessage'] = 'Showing ' . ((($this->pagination->cur_page - 1) * $config['per_page']) + 1) . ' to ' . ($data['last']) . ' of ' . $data['total_rows'];
        }
        $data['sn'] = $current_offset + 1;
        /* pagination end */

        # Loading the data array to send to View
        $data['product'] = $this->Ops_leakage_r_m->get_leakage_products();
        $data['loose_oil']=$this->Ops_leakage_r_m->get_loose_oils();
        $data['ops_leakage_reports'] = $this->Ops_leakage_r_m->ops_leakage_report_results($search_params,$current_offset, $config['per_page'],$plant_id);
       // echo $this->db->last_query(); exit;
        # Additional data
        $data['display_results'] = 1;
        //retreving prices of regular price type
        $price_type=1;
        $latest_details=$this->Ops_leakage_r_m->get_all_products_latest_price_plant($price_type,$plant_id);
         $latest_price_details=array();
        foreach($latest_details as $key =>$value )
        {
            $latest_price_details[$value['product_id']]['old_price']=$value['value'];
        }
        $data['latest_price_details']=$latest_price_details;
       $this->load->view('leakage/ops_leakage_r_view',$data);
	}

	public function download_ops_leakage_report()
	{
		if($this->input->post('download_leakage')!='') {
            $plant_id=$this->session->userdata('ses_plant_id');
            $from_date=$this->input->post('from_date');
            if($from_date=='')
            {
                $from_date='';
            }
            else
            {
                $from_date= date('Y-m-d',strtotime($this->input->post('from_date')));
            }
            //echo $start_date;exit;
            $to_date=$this->input->post('to_date');
            if($to_date=='')
            {
                $to_date='';
            }
            else
            {
                $to_date= date('Y-m-d',strtotime($this->input->post('to_date')));
            }
            $search_params=array(
                'product_id'	=> $this->input->post('product', TRUE),
                'loose_oil_id'   => $this->input->post('loose_oil', TRUE),
                'from_date' 	=> $from_date,
                'to_date' 		=> $to_date
                              );
            $report = $this->Ops_leakage_r_m->download_ops_leakage_report($search_params,$plant_id);
            //retreving prices of regular price type
            $price_type=1;
            $latest_details=$this->Ops_leakage_r_m->get_all_products_latest_price_plant($price_type,$plant_id);
             $latest_price_details=array();
            foreach($latest_details as $key =>$value )
            {
                $latest_price_details[$value['product_id']]['old_price']=$value['value'];
            }
            $header = '';
            $data ='';
            echo '<p><b>Leakage Report At :'.$this->session->userdata('plant_name').'</p>';
            echo '<p>Note : Loss Amount is calculated on current regular price</p>';
            $titles = array('S.NO','Product','Date','Leakage Cartons','Leaked Pouches','Oil Recovered(Kgs)','Recovered Cartons','Oil Loss(Kgs)','Loss Amount');
            $data = '<table border="1">';
            $data.='<thead>';
            $data.='<tr>';
            foreach ( $titles as $title)
            {
                $data.= '<th align="center">'.$title.'</th>';
            }
            $data.='</tr>';
            $data.='</thead>';
            $data.='<tbody>';
             $j=1;
             $total_loss_amount=0;
             $total_oil_loss=0;
            if(count($report)>0)
            {
                
                foreach($report as $row)
                {   $oil_loss=(($row['leaked_pouches']*$row['oil_weight'])-$row['oil_recovered']);
                    $loss_amount=($oil_loss*(($latest_price_details[$row['product_id']]['old_price'])/$row['oil_weight']));
                    $total_oil_loss+=$oil_loss;
                    $total_loss_amount+=$loss_amount;
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['product'].'</td>';
                     $data.='<td align="center">'.date('d-m-Y',strtotime($row['on_date'])).'</td>';                   
                    $data.='<td align="right">'.$row['leakage_quantity'].'</td>';
                    $data.='<td align="right">'.$row['leaked_pouches'].'</td>';
                    $data.='<td align="right">'.qty_format($row['oil_recovered']).'</td>';
                    $data.='<td align="right">'.$row['recovered_quantity'].'</td>';
                    $data.='<td align="right">'.qty_format($oil_loss).'</td>';
                    $data.='<td align="right">'.price_format($loss_amount).'</td>';
                    $data.='</tr>';
                    $j++;
                }
                $data.='<tr>';
                $data.='<td colspan="7" align="right">'."Grand Total :".'</td>';
                $data.='<td align="right">'.qty_format($total_oil_loss).'</td>';
                $data.='<td align="right">'.price_format($total_loss_amount).'</td>';
                $data.='</tr>';
            }
            else
            {
                $data.='<tr><td colspan="'.(count($titles)+1).'" align="center">No Results Found</td></tr>';
            }
            $data.='</tbody>';
            $data.='</table>';
            $time = date("Ymdhis");
            $xlFile='OPS_Leakage_Report'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
            }
        }

    public function print_ops_leakage_r()
    {
        if($this->input->post('print_leakage')!='') {
            $plant_id=$this->session->userdata('ses_plant_id');
            $from_date=$this->input->post('from_date');
            if($from_date=='')
            {
                $from_date='';
            }
            else
            {
                $from_date= date('Y-m-d',strtotime($this->input->post('from_date')));
            }
            //echo $start_date;exit;
            $to_date=$this->input->post('to_date');
            if($to_date=='')
            {
                $to_date='';
            }
            else
            {
                $to_date= date('Y-m-d',strtotime($this->input->post('to_date')));
            }
            $search_params=array(
                'product_id'    => $this->input->post('product', TRUE),
                'loose_oil_id'   => $this->input->post('loose_oil', TRUE),
                'from_date'     => $from_date,
                'to_date'       => $to_date
                              );
            $data['report'] = $this->Ops_leakage_r_m->download_ops_leakage_report($search_params,$plant_id);
            //retreving prices of regular price type
            $price_type=1;
            $latest_details=$this->Ops_leakage_r_m->get_all_products_latest_price_plant($price_type,$plant_id);
             $latest_price_details=array();
            foreach($latest_details as $key =>$value )
            {
                $latest_price_details[$value['product_id']]['old_price']=$value['value'];
            }
            $data['search_params']=$search_params;
            $data['latest_price_details']=$latest_price_details;
            $this->load->view('leakage/ops_leakage_report',$data);
        }
    }
    public function sp_leakage_r()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Stock Point Leakage Reports";
        $data['nestedView']['pageTitle'] = 'Stock Point Leakage Reports';
        $data['nestedView']['cur_page'] = 'sp_leakage_r';
        $data['nestedView']['parent_page'] = 'leakage';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Stock Point Leakage Reports', 'class' => 'active', 'url' => '');
        $plant_id=$this->session->userdata('ses_plant_id');
        # Search Functionality
        $p_search=$this->input->post('serach_leakage', TRUE);
        if($p_search!='') 
        { 
        	    $from_date=$this->input->post('from_date');
            if($from_date=='')
            {
                $from_date='';
            }
            else
            {
                $from_date= date('Y-m-d',strtotime($this->input->post('from_date')));
            }
            //echo $start_date;exit;
            $to_date=$this->input->post('to_date');
            if($to_date=='')
            {
                $to_date='';
            }
            else
            {
                $to_date= date('Y-m-d',strtotime($this->input->post('to_date')));
            }
            
            $search_params=array(
                'product_id'    => $this->input->post('product', TRUE),
                'loose_oil_id'    => $this->input->post('loose_oil', TRUE),
                'from_date'     => $from_date,
                'to_date'       => $to_date
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'product_id'    => $this->session->userdata('product_id'),
                    'loose_oil_id'    => $this->session->userdata('loose_oil_id'),
                    'from_date'     => $this->session->userdata('from_date'),
                    'to_date'       => $this->session->userdata('to_date')
                    
                                  );
            }
            else {
                $search_params=array(
                      'product_id'      => '',
                      'loose_oil_id'      => '',
                      'from_date'       => '',
                      'to_date'         => ''
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;

        # Default Records Per Page - always 10
        # pagination start 
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'sp_leakage_r/';
        # Total Records
        $config['total_rows'] = $this->Ops_leakage_r_m->sp_leakage_report_total_rows($search_params);

        $config['per_page'] = getDefaultPerPageRecords();
        $data['total_rows'] = $config['total_rows'];
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        $current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        if ($data['pagination_links'] != '') {
            $data['last'] = $this->pagination->cur_page * $config['per_page'];
            if ($data['last'] > $data['total_rows']) {
                $data['last'] = $data['total_rows'];
            }
            $data['pagermessage'] = 'Showing ' . ((($this->pagination->cur_page - 1) * $config['per_page']) + 1) . ' to ' . ($data['last']) . ' of ' . $data['total_rows'];
        }
        $data['sn'] = $current_offset + 1;
        /* pagination end */

        # Loading the data array to send to View
        $data['product'] = $this->Ops_leakage_r_m->get_leakage_products();
        $data['loose_oil']=$this->Ops_leakage_r_m->get_loose_oils();
        $data['sp_leakage_reports'] = $this->Ops_leakage_r_m->sp_leakage_report_results($search_params,$current_offset, $config['per_page']);
        // echo $this->db->last_query(); exit;
        # Additional data
        $data['display_results'] = 1;

        //retreving prices of regular price type
        $price_type=1;
        $latest_details=$this->Ops_leakage_r_m->get_all_products_latest_price_plant($price_type,$plant_id);
         $latest_price_details=array();
        foreach($latest_details as $key =>$value )
        {
            $latest_price_details[$value['product_id']]['old_price']=$value['value'];
        }
        $data['latest_price_details']=$latest_price_details;

        $this->load->view('leakage/sp_leakage_r_view',$data);
    }

    public function print_ops_leakage()
    {
        if($this->input->post('print_ops_leakage')!='') 
        {  
            $plant_id=$this->session->userdata('ses_plant_id');
            $from_date=$this->input->post('from_date');
            if($from_date=='')
            {
                $from_date='';
            }
            else
            {
                $from_date= date('Y-m-d',strtotime($this->input->post('from_date')));
            }
            //echo $start_date;exit;
            $to_date=$this->input->post('to_date');
            if($to_date=='')
            {
                $to_date='';
            }
            else
            {
                $to_date= date('Y-m-d',strtotime($this->input->post('to_date')));
            }
            $search_params=array(
                        'product_id'    => $this->input->post('product', TRUE),
                        'loose_oil_id'    => $this->input->post('loose_oil', TRUE),
                        'from_date'     => $from_date,
                        'to_date'       => $to_date
                           );
            $print_ops_leakage= $this->Ops_leakage_r_m->get_ops_leakage_reports(@$search_params);
            $data['print_ops_leakage']=$print_ops_leakage;
            $data['search_params']=$search_params;
            //retreving prices of regular price type
            $price_type=1;
            $latest_details=$this->Ops_leakage_r_m->get_all_products_latest_price_plant($price_type,$plant_id);
             $latest_price_details=array();
            foreach($latest_details as $key =>$value )
            {
                $latest_price_details[$value['product_id']]['old_price']=$value['value'];
            }
            $data['latest_price_details']=$latest_price_details;
                //print_r($data['print_ops_leakage']);exit;
            }
        $this->load->view('leakage/print_ops_leakage',$data);
    }

     // Prasad Consolidated Leakage Report Start
     public function consolidated_leakage_report()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Leakage Report";
        $data['nestedView']['pageTitle'] = 'Leakage Report';
        $data['nestedView']['cur_page'] = 'reports';
        $data['nestedView']['parent_page'] = 'leakage report';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Leakage Report', 'class' => '', 'url' => '');  
        $data['units']=$this->Ops_leakage_r_m->get_units();
        $this->load->view('leakage/consolidated_leakage_report', $data);
    }

    public function print_consolidated_leakage_report()
    {
        if($this->input->post('submit'))
        {   
            if($this->input->post('from_date') !='')
            {
                $from_date=date('Y-m-d',strtotime($this->input->post('from_date')));
            }
            else
            {
                $from_date='';
            }
            if($this->input->post('to_date') !='')
            {
                $to_date=date('Y-m-d',strtotime($this->input->post('to_date')));
            }
            else
            {
                $to_date='';
            }
            $plant_id=$this->input->post('plant_id');
            $data['from_date']=$from_date;
            $data['to_date']=$to_date;
            $leakage_report=array();
            $data['units']=$this->Ops_leakage_r_m->get_units();
            $sp_leakage=$this->Ops_leakage_r_m->all_units_sp_leakage_report_results($from_date,$to_date,$plant_id);
            foreach($sp_leakage as $key => $value)
            {
                if(array_key_exists(@$keys, $leakage_report))
                {   
                    
                    $leakage_report[$value['plant_id']] ['products'][] =array(
                        'product_id'=> $value['product_id'],
                        'product'=> $value['product'],
                        'plant_id'  =>  $value['plant_id'],
                        'leaked_pouches' =>  $value['leaked_pouches'],
                        'leakage_quantity' =>  $value['leakage_quantity'],
                        'recovered_quantity'=> $value['recovered_quantity'],
                        'on_date'=> $value['on_date'],
                        'oil_recovered'=> $value['oil_recovered'],
                        'oil_weight'=> $value['oil_weight'],
                         );    
                }    
                else
                {
                    $leakage_report[$value['plant_id']] ['plant_id']=$value['plant_id'];
                    $leakage_report[$value['plant_id']] ['products'][] =array(
                        'product_id'=> $value['product_id'],
                        'product'=> $value['product'],
                        'plant_id'  =>  $value['plant_id'],
                        'leaked_pouches' =>  $value['leaked_pouches'],
                        'leakage_quantity' =>  $value['leakage_quantity'],
                        'recovered_quantity'=> $value['recovered_quantity'],
                        'on_date'=> $value['on_date'],
                        'oil_recovered'=> $value['oil_recovered'],
                        'oil_weight'=> $value['oil_weight'],
                         );
                } 
            }
            $ops_leakage=$this->Ops_leakage_r_m->all_units_ops_leakage_report_results($from_date,$to_date,$plant_id);
            foreach($ops_leakage as $key => $value)
            {
                if(array_key_exists(@$keys, $leakage_report))
                {   
                    
                    $leakage_report[$value['plant_id']] ['products'][] =array(
                        'product_id'=> $value['product_id'],
                        'product'=> $value['product'],
                        'plant_id'  =>  $value['plant_id'],
                        'leaked_pouches' =>  $value['leaked_pouches'],
                        'leakage_quantity' =>  $value['leakage_quantity'],
                        'recovered_quantity'=> $value['recovered_quantity'],
                        'on_date'=> $value['on_date'],
                        'oil_recovered'=> $value['oil_recovered'],
                        'oil_weight'=> $value['oil_weight'],
                         );    
                }    
                else
                {
                    $leakage_report[$value['plant_id']] ['plant_id']=$value['plant_id'];
                    $leakage_report[$value['plant_id']] ['products'][] =array(
                        'product_id'=> $value['product_id'],
                        'product'=> $value['product'],
                        'plant_id'  =>  $value['plant_id'],
                        'leaked_pouches' =>  $value['leaked_pouches'],
                        'leakage_quantity' =>  $value['leakage_quantity'],
                        'recovered_quantity'=> $value['recovered_quantity'],
                        'on_date'=> $value['on_date'],
                        'oil_recovered'=> $value['oil_recovered'],
                        'oil_weight'=> $value['oil_weight'],
                         );
                } 
            }
            //retreving regular price type
            $price_type=1;
            $latest_details=$this->Ops_leakage_r_m->get_all_products_latest_price($price_type);
            foreach($latest_details as $key =>$value )
            {
                $latest_price_details[$value['plant_id']][$value['product_id']]['old_price']=$value['value'];
            }
           // print_r($latest_price_details);exit;
           $data['latest_price_details']=$latest_price_details;
            $data['leakage_report']=$leakage_report;
            $this->load->view('leakage/print_consolidated_leakage_report',$data);
        }
    }

    // Prasad Consolidated Leakage Report End

}