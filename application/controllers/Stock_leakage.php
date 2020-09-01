<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
// created by maruthi 15th Nov 2016 09:00 AM

class Stock_leakage extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Stock_leakage_model");
       
    }

    //Mounika
    public function godown_leakage_entry()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']=" Godown Leakage Entry";
        $data['nestedView']['pageTitle'] = 'Godown Leakage Entry';
        $data['nestedView']['cur_page'] = 'godown_leakage_entry';
        $data['nestedView']['parent_page'] = 'Leakage';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] ='<script type="text/javascript" src="'.assets_url().'pages/scripts/stock_leakage.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Leakage Entry', 'class' => 'active', 'url' =>'');
        
        $data['plant_name']=$this->session->userdata('plant_name');
        $plant_id=$this->session->userdata('ses_plant_id');
        //Retreving Max leakage number from leakage_entry
        $data['leakage_number']=$this->Stock_leakage_model->get_max_leakage_number($plant_id);
        $data['product']=$this->Stock_leakage_model->get_product();
        $data['flag']=1;
        $data['type']=1;
        $this->load->view('stock_leakage/stock_leakage_entry',$data);
    }
     public function counter_leakage_entry()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Counter Leakage Entry";
        $data['nestedView']['pageTitle'] = 'Counter Leakage Entry';
        $data['nestedView']['cur_page'] = 'counter_leakage_entry';
        $data['nestedView']['parent_page'] = 'Leakage';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] ='<script type="text/javascript" src="'.assets_url().'pages/scripts/stock_leakage.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Leakage Entry', 'class' => 'active', 'url' =>'');
        
        $data['plant_name']=$this->session->userdata('plant_name');
        $plant_id=$this->session->userdata('ses_plant_id');
        //Retreving Max leakage number from leakage_entry
        $data['leakage_number']=$this->Stock_leakage_model->get_max_leakage_number($plant_id);
        $data['product']=$this->Stock_leakage_model->get_product();
        $data['flag']=1;
        $data['type']=2;
        $this->load->view('stock_leakage/stock_leakage_entry',$data);
    }
     public function confirm_stock_leakage_entry()
    {   
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Confirm Leakage Entry";
        $data['nestedView']['pageTitle'] = 'ConfirmLeakage Entry';
        $data['nestedView']['cur_page'] = 'godown_leakage_entry';
        $data['nestedView']['parent_page'] = 'Leakage';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
       /* $data['nestedView']['js_includes'][] ='<script type="text/javascript" src="'.assets_url().'pages/scripts/leakage.js"></script>';*/
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Leakage Entry', 'class' => 'active', 'url' =>'');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Confirm Leakage Entry', 'class' => 'active', 'url' =>'');
        if($this->input->post('submit'))
        {  
            $product_id=$this->input->post('product_id');
            $plant_name=$this->session->userdata('plant_name');
            $plant_id=$this->session->userdata('ses_plant_id');
            $carton_quantity= $this->input->post('no_of_cartons');
            $type=$this->input->post('type');
            if($type ==1)
            {
                $count=$this->Stock_leakage_model->get_product_quantity_count($product_id,$plant_id,$carton_quantity);
            }
            else
            {
                $count=$this->Stock_leakage_model->get_counter_quantity_count($product_id,$plant_id,$carton_quantity);
            }
            //checking quantity for product in plant product
            
            $product=$this->Common_model->get_value('product',array('product_id'=>$product_id),'name');
            if($count > 0)
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
                    'pouches'         =>    $this->input->post('pouches'),
                    'remarks'         =>   $this->input->post('remarks')
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
                   $this->load->view('stock_leakage/stock_leakage_entry',$data);
               }
               else
               {
                  $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <strong>Sorry!</strong>recovered weight('.$captured_weight.' KG"s) is greater than leakage quantity('.$entered_weight.' KG"s)!
                                  </div>');
                    if($dat['type']==1)
                    {
                        redirect(SITE_URL.'godown_leakage_entry');exit;
                    }
                    else
                    {
                         redirect(SITE_URL.'counter_leakage_entry');exit;
                    }
               }
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <strong>Sorry!</strong>No stock Available for '.$product.'!
                                  </div>');
                    if($type==1)
                    {   
                        
                        redirect(SITE_URL.'godown_leakage_entry');exit;
                    }
                    else
                    {
                         redirect(SITE_URL.'counter_leakage_entry');exit;
                    }
            }
        }
    }
    public function insert_stock_leakage_entry()
    {
        if($this->input->post('submit',TRUE))
        {
            $on_date = $this->input->post('on_date');
            $plant_id = $this->session->userdata('ses_plant_id');
            $product_id = $this->input->post('product_id');
            $no_of_cartons = $this->input->post('no_of_cartons');
            $no_of_pouches = $this->input->post('no_of_pouches');
            $recovered_oil = $this->input->post('recovered_oil');
            $items_per_carton=$this->input->post('items_per_carton');
            $cartons=$this->input->post('cartons');
            $pouches=$this->input->post('pouches');
            $type=$this->input->post('type');
            
            $res=$this->Common_model->get_data_row('product',array('product_id'=>$product_id),array('oil_weight','loose_oil_id'));
            //Retreving Max leakage number from leakage_entry
            $leakage_number=$this->Stock_leakage_model->get_max_leakage_number($plant_id);
            $dat=array(
               'leakage_number' =>  $leakage_number,           
               'on_date'        =>  $on_date,
               'remarks'        =>  $this->input->post('remarks'),
               'type'          =>   $type,
               'plant_id'      =>$plant_id,
               'created_by'     =>  $this->session->userdata('user_id')
                );
          
            $this->db->trans_begin();
            $leakage_id=$this->Common_model->insert_data('leakage_entry',$dat);
            $dat1=array(
                'product_id'   =>  $product_id,
                'quantity'     =>  $no_of_cartons,
                'leaked_pouches'=> $no_of_pouches,
                'items_per_carton' =>$items_per_carton,
                'leakage_id'   =>  $leakage_id,
                'created_by'  =>  $this->session->userdata('user_id')
                ); 

            //inserting product data into leakage products
               $this->Common_model->insert_data('leakage_product',$dat1);
            //inserting data in leakage recovery
            $lr=array(
                            'leakage_id'     =>   $leakage_id,
                            'on_date'        =>   $on_date,
                            'created_by'     =>   $this->session->userdata('user_id'),
                            'created_time'   =>   date('Y-m-d H:i:s') 
                            );
           $recovery_id=$this->Common_model->insert_data('leakage_recovery',$lr);

           //inserting data in leakage recovery products
            $dat2=array(
                            'quantity'          =>  $cartons,
                            'items_per_carton'  =>  $items_per_carton,
                            'recovered_pouches' =>  $pouches,
                            'recovery_id'       =>  $recovery_id,
                            'product_id'        =>  $product_id
                           );
        
            $this->Common_model->insert_data('leakage_recovered_products',$dat2);
             $lro=array(
                            'recovery_id'    =>   $recovery_id,
                            'loose_oil_id'   =>   $res['loose_oil_id'],
                            'oil_weight'     =>   $recovered_oil,
                            'created_by'     =>   $this->session->userdata('user_id'),
                            'created_time'   =>   date('Y-m-d H:i:s') 
                         );
            $this->Common_model->insert_data('leakage_recovered_oil',$lro); 
            $this->Stock_leakage_model->update_recovery_oil($res['loose_oil_id'],$recovered_oil,$plant_id);
            $leaked_pouches=$no_of_pouches/$items_per_carton;
            $this->Stock_leakage_model->update_plant_product_stock($product_id,$leaked_pouches,$plant_id);

             // Secondary Consumption Calculation
            $secondary_consumption = $this->Stock_leakage_model->get_secondary_consumption_data($product_id);
            foreach ($secondary_consumption as  $row1)
            {
                $pm_val = $this->Common_model->get_value('plant_pm',array('plant_id'=>get_plant_id(),'pm_id'=>$row1['pm_id']),'quantity');
                    
                    // updating in plant_pm
                    $total_quantity= $cartons*$row1['quantity'];
                    $update=$this->Stock_leakage_model->update_plant_pm_quantity($total_quantity,$plant_id,$row1['pm_id']);
                     // checking pm stock balance entry for that category
                    $pm_stock_records = $this->Stock_leakage_model->get_latest_pm_stock_balance_record($row1['pm_id']);
                   if(@$pm_stock_records)
                    {
                        // updating in pm_stock_balace
                        $qry ='UPDATE pm_stock_balance SET production = production +'.$cartons*$row1['quantity'].'
                             WHERE plant_id = '.get_plant_id().' AND pm_id ='.$row1['pm_id'].' AND closing_balance IS NULL';
                        $this->db->query($qry);
                    }  

             }
             if($type==2)
             {
                $counter_id=get_plant_counter_sale_id();
                $this->Stock_leakage_model->update_plant_counter_quantity($counter_id,$product_id,$leaked_pouches);
             }
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
            if($type==2)
            {
              redirect(SITE_URL.'counter_leakage_entry');
            }
            else
            {
                  redirect(SITE_URL.'godown_leakage_entry');
            }
        }
    }
}