<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
// created by maruthi 15th Nov 2016 09:00 AM

class Leakage extends Base_controller {
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Leakage_model");
       
    }
    //Mounika
    public function leakage_entry()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Leakage Entry";
        $data['nestedView']['pageTitle'] = 'Leakage Entry';
        $data['nestedView']['cur_page'] = 'leakage_entry';
        $data['nestedView']['parent_page'] = 'Leakage';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] ='<script type="text/javascript" src="'.assets_url().'pages/scripts/leakage.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Leakage Entry', 'class' => 'active', 'url' =>'');
        
        $data['plant_name']=$this->session->userdata('plant_name');
        $plant_id=$this->session->userdata('ses_plant_id');
        //Retreving Max leakage number from ops_leakage
        $data['leakage_number']=$this->Leakage_model->get_max_leakage_number($plant_id);
        $data['product']=$this->Leakage_model->get_product();
        $data['flag']=1;
        
        $this->load->view('leakage/leakage_entry',$data);
    }
 public function insert_leakage_entry()
    {
        if($this->input->post('submit',TRUE))
        {
            $on_date = date('Y-m-d',strtotime($this->input->post('on_date')));
            $plant_id = $this->session->userdata('ses_plant_id');
            $product_id = $this->input->post('product_id');
            $no_of_cartons = $this->input->post('no_of_cartons');
            $no_of_pouches = $this->input->post('no_of_pouches');
            $recovered_oil = $this->input->post('recovered_oil');
            $items_per_carton=$this->input->post('items_per_carton');
            $cartons=$this->input->post('cartons');
            $pouches=$this->input->post('pouches');
            $type=$this->input->post('type');
            //Retreving Max leakage number from ops_leakage
           $leakage_number=$this->Leakage_model->get_max_leakage_number($plant_id);
               if($type==1)
                {
                    $recovered_quantity = $no_of_cartons;
                }
                else
                {
                    $recovered_quantity = $this->input->post('cartons');
                }

                 $dat=array(
                            'on_date'         =>   $on_date,
                            'plant_id'        =>   $plant_id,
                            'product_id'      =>   $product_id,
                            'leakage_number'  =>   $leakage_number,
                            'leakage_quantity'   =>   $no_of_cartons,
                            'recovered_quantity' =>  $recovered_quantity,
                            'leaked_pouches'   =>   $no_of_pouches,
                            'oil_recovered'   =>   $recovered_oil,
                            'remarks'         =>  $this->input->post('remarks'),
                            'recover_type'   =>    $type,
                            'created_by'      =>   $this->session->userdata('user_id'),
                            'created_time'    =>   date('Y-m-d H:i:s')
                             );
                // Begin Transaction
                $this->db->trans_begin();
                $ops_leakage_id = $this->Common_model->insert_data('ops_leakage',$dat);
                $res=$this->Common_model->get_data_row('product',array('product_id'=>$product_id),array('oil_weight','loose_oil_id'));
                if($type==1)
                {
                    $recovered=$recovered_oil/1000;
                    $production_weight=($no_of_pouches*$res['oil_weight'])/1000;
                    $qry ='UPDATE oil_stock_balance SET production = production +'.$production_weight.',recovered = recovered +'.$recovered.'
                                             WHERE plant_id = '.get_plant_id().'  AND loose_oil_id='.$res['loose_oil_id'].' AND closing_balance IS NULL';
                    $this->db->query($qry);
                }
                else
                {
                    $recovered = $recovered_oil/1000;
                    $production_weight= ($pouches*$res['oil_weight'])/1000;
                    $total= $recovered + $production_weight;
                    $qry ='UPDATE oil_stock_balance SET recovered = recovered +'.$total.'
                            WHERE plant_id = '.get_plant_id().'  AND loose_oil_id='.$res['loose_oil_id'].' AND closing_balance IS NULL';
                    $this->db->query($qry);
                    $diff_cartons= $no_of_cartons-$cartons;
                    $this->Leakage_model->update_carton_diff($product_id,$diff_cartons);
                }
                // Secondary Consumption Calculation
                $secondary_consumption = $this->Leakage_model->get_secondary_consumption_data($dat['product_id']);

               //echo $this->db->last_query();exit;
                foreach ($secondary_consumption as  $row1)
                { //echo '123';exit;
                    $pm_val = $this->Common_model->get_value('plant_pm',array('plant_id'=>get_plant_id(),'pm_id'=>$row1['pm_id']),'quantity');
                        if($type==1)
                        {
                            $rem_quant=$dat['leakage_quantity'];
                        }
                        else
                        {
                            $rem_quant=$dat['recovered_quantity'];
                        }
                        // updating in plant_pm
                        $total_quantity = $rem_quant*$row1['quantity'];
                        $update = $this->Leakage_model->update_plant_pm_quantity($total_quantity,$plant_id,$row1['pm_id']);

                        // insert in ops_leakage_pm
                        $ops_leakage_pm_data = array(
                                        'ops_leakage_id'        => @$ops_leakage_id,
                                        'pm_id'                 => $row1['pm_id'],
                                        'quantity'              => ($total_quantity)                                        
                                        );                            
                        $this->Common_model->insert_data('leakage_pm',$ops_leakage_pm_data);
                        //echo $this->db->last_query().'<br>';
                        // checking pm stock balance entry for that category
                        $pm_stock_records = $this->Leakage_model->get_latest_pm_stock_balance_record($row1['pm_id']);
                        if(@$pm_stock_records)
                        {
                            // updating in pm_stock_balace
                            $qry ='UPDATE pm_stock_balance SET production = production +'.$rem_quant*$row1['quantity'].'
                                 WHERE plant_id = '.get_plant_id().' AND pm_id ='.$row1['pm_id'].' AND closing_balance IS NULL';
                            $this->db->query($qry);
                        }  
                 }
                if($type ==1)
                { //echo 're';exit;
                    // Primary Consumption Calculation
                    $pms2 = $this->Leakage_model->get_primary_consumption_data($product_id);
                    //echo '<pre>';print_r($pms2);exit;
                    foreach ($pms2 as $key => $row2)
                        {
                                $pm_val = $this->Common_model->get_value('plant_pm',array('plant_id'=>get_plant_id(),'pm_id'=>$row2['pm_id']),'quantity');
                                if($row2['pm_cat_id']==1)
                                {   
                                    $production_micron_id = $this->Leakage_model->get_micron_and_pm_id($product_id);
                                    $micron_id = ($production_micron_id!='')?$production_micron_id:2;

                                    $packets_per_kg_data = $this->Leakage_model->get_packets_per_kg1($product_id,$row2['pm_id'],$micron_id);
                                     //echo 're';exit;
                                    //echo '<pre>';print_r($packets_per_kg_data);exit;
                                    if($packets_per_kg_data)
                                    {// echo 're';exit; 
                                        $film_quantity = $packets_per_kg_data['present_quantity'];
                                        $expected_pouches =$packets_per_kg_data['value'];
                                        //$film_pouches = round($expected_pouches*$film_quantity);
                                           
                                        $film_consumption = ($no_of_pouches/$expected_pouches);
                                        // Reducing Film Stock Consumption Quantity in Plant Film Stock
                                       
                                        $a =$this->Leakage_model->update_plant_film_stock($packets_per_kg_data['pfs_id'],$film_consumption);
                                
                                        // updating packing material film consumption in plant_pm
                                        $qry ='UPDATE plant_pm SET quantity = quantity-'.$film_consumption.'
                                                 WHERE plant_id = '.get_plant_id().' AND pm_id ='.$row2['pm_id'].'';
                                        $this->db->query($qry);

                                        $leakage_pm_micron_data = array(
                                                'ops_leakage_id'        => $ops_leakage_id,
                                                'pm_id'                 => $row2['pm_id'],
                                                'quantity'              => $film_consumption,
                                                'micron_id'             => $micron_id,                                               
                                                );   
                                    
                                       $this->Common_model->insert_data('leakage_pm_micron',$leakage_pm_micron_data); 
                                        //echo $this->db->last_query();//exit;

                                        $qry ='UPDATE pm_stock_balance SET production = production +'.$film_consumption.'
                                             WHERE plant_id = '.get_plant_id().' AND pm_id ='.$row2['pm_id'].' AND closing_balance IS NULL';
                                        $this->db->query($qry);

                                    }
                                   
                                }
                                // Other Than Film Category
                                else
                                {
                                   // updating in plant_pm
                                    $qry ='UPDATE plant_pm SET quantity = quantity-'.$no_of_pouches*$row2['quantity'].'
                                            WHERE plant_id = '.get_plant_id().' AND pm_id ='.$row2['pm_id'].'';
                                    $this->db->query($qry);
                                    // insert in leakage_pm
                                    $ops_leakage_pm_data = array(
                                        'ops_leakage_id'        => $ops_leakage_id,
                                        'pm_id'                 => $row2['pm_id'],
                                        'quantity'              => ($no_of_pouches*$row2['quantity'])                                        
                                        );                            
                                    $this->Common_model->insert_data('leakage_pm',$ops_leakage_pm_data);
                                    //echo $this->db->last_query();

                                    // checking pm stock balance entry for that caegory
                                    $pm_stock_records = $this->Leakage_model->get_latest_pm_stock_balance_record($row2['pm_id']);
                                    if(@$pm_stock_records)
                                    {
                                        // updating in pm_stock_balace
                                        $qry ='UPDATE pm_stock_balance SET production = production +'.$no_of_pouches*$row2['quantity'].'
                                                 WHERE plant_id = '.get_plant_id().' AND pm_id ='.$row2['pm_id'].' AND closing_balance IS NULL';
                                         $this->db->query($qry);
                                    }
                                   
                                }                
                            }   
                    }//exit;
                if ($this->db->trans_status() === FALSE)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
                }
                else
                {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Leakage Information has been added successfully! </div>');
                }
                redirect(SITE_URL.'leakage_entry');
            }
            
    }
    
    public function get_carton_per_product()
    {
        $product_id=$this->input->post('product_id');
        echo $this->Common_model->get_value('product',array('product_id'=>$product_id),'items_per_carton');
    }
    public function confirm_leakage_entry()
    {   
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Confirm Leakage Entry";
        $data['nestedView']['pageTitle'] = 'ConfirmLeakage Entry';
        $data['nestedView']['cur_page'] = 'leakage_entry';
        $data['nestedView']['parent_page'] = 'Leakage';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
       /* $data['nestedView']['js_includes'][] ='<script type="text/javascript" src="'.assets_url().'pages/scripts/leakage.js"></script>';*/
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Leakage Entry', 'class' => 'active', 'url' =>'');
        if($this->input->post('submit'))
        {  
            $product_id=$this->input->post('product_id');
            $plant_name=$this->session->userdata('plant_name');
            $carton_quantity=$this->input->post('no_of_cartons');
            $product=$this->Common_model->get_value('product',array('product_id'=>$product_id),'name');
            $plant_id = $this->session->userdata('ses_plant_id');
             //checking quantity for product in plant product
            $count=$this->Leakage_model->get_product_quantity_count($product_id,$plant_id,$carton_quantity);
            if($count >0)
            {
                $dat=array(
                    'product_id'       =>   $product_id,
                    'product_name'     =>   $product,
                    'plant_name'         =>   $plant_name,
                    'type'             =>   $this->input->post('type'),
                    'items_per_carton' =>   $this->input->post('items_per_carton'),
                    'no_of_cartons'    =>   $this->input->post('no_of_cartons'),
                    'no_of_pouches'    =>   $this->input->post('no_of_pouches'),
                    'recovered_oil'    =>   $this->input->post('recovered_oil'),
                    'leakage_number'   =>   $this->input->post('leakage_number'),
                    'cartons'          =>   $this->input->post('cartons'),
                    'remarks'          =>   $this->input->post('remarks'),
                    'pouches'         =>    $this->input->post('pouches')
                    );
               
               $data['dat']=$dat;
               $res=$this->Common_model->get_data_row('product',array('product_id'=>$dat['product_id']),array('oil_weight','loose_oil_id'));
              // $entered_items=($dat['no_of_cartons']*$dat['items_per_carton']);
               $entered_weight=$dat['no_of_pouches'] * $res['oil_weight'];
               //$captured_items=($dat['cartons']*$dat['items_per_carton'])-$dat['pouches'];
               $captured_weight=$dat['recovered_oil'];
               if($captured_weight<=$entered_weight)
                {
                    $data['flag']=2;
                   $this->load->view('leakage/leakage_entry',$data);
               }
               else
               {
                  $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <strong>Sorry!</strong>recovered weight('.$captured_weight.' KG"s) is greater than leakage quantity('.$entered_weight.' KG"s)!
                                 </div>');

                    redirect(SITE_URL.'leakage_entry');exit;
               }
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <strong>Sorry!</strong>No stock Available for '.$product.'!
                                  </div>');
                redirect(SITE_URL.'leakage_entry');exit;
            }
        }
    }
}