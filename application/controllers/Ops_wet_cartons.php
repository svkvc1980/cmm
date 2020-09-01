<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 15th Nov 2016 09:00 AM

class Ops_wet_cartons extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Ops_wet_cartons_model");
        $this->load->model("Pm_consumption_m");
        $this->load->model("Production_m");
    }

    //Mounika
    public function wet_cartons_entry()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Wet Cartons";
        $data['nestedView']['pageTitle'] = 'Wet Cartons';
        $data['nestedView']['cur_page'] = 'wet_cartons_entry';
        $data['nestedView']['parent_page'] = 'Leakage';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] ='<script type="text/javascript" src="'.assets_url().'pages/scripts/wet_cartons.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Wet Cartons', 'class' => 'active', 'url' =>'');
        
        $data['plant_name']=$this->session->userdata('plant_name');
        $data['product']=$this->Common_model->get_data('product',array('status'=>1));
        //$data['flag']=1;
        
        $this->load->view('ops_wet_cartons/wet_cartons_entry',$data);
    }

    public function insert_wet_carton()
    {
        if($this->input->post('submit',TRUE))
        {
            $product_id = $this->input->post('product_id');
            $plant_id=$this->session->userdata('ses_plant_id');
            $on_date = date('Y-m-d', strtotime($this->input->post('on_date',TRUE)));
            $old_quantity = $this->Common_model->get_value('plant_product',array('plant_id'=>$plant_id,'product_id'=>$product_id),'quantity');
            if($old_quantity=='')
            {
                $old_quantity = 0;
            }
            $new_quantity = $this->input->post('quantity');
           
            if($old_quantity > $new_quantity)
            {
                $dat=array(
                        'on_date'         =>   $this->input->post('on_date'),
                        'plant_id'        =>   $plant_id,
                        'product_id'      =>   $product_id,
                        'quantity'        =>   $new_quantity,
                        'created_by'      =>   $this->session->userdata('user_id'),
                        'created_time'    =>   date('Y-m-d H:i:s')
                         );
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                <strong>Error!</strong>Cartons are not available. Please check</div>');
                redirect(SITE_URL.'wet_cartons_entry'); exit();
            }
            
            // Begin Transaction
            $this->db->trans_begin();
            $this->Common_model->insert_data('wet_carton_entry',$dat);
            // Secondary Consumption Calculation
            $secondary_consumption = $this->Ops_wet_cartons_model->get_secondary_consumption_data($dat['product_id']);
            //print_r( $secondary_consumption);exit;
            foreach ($secondary_consumption as  $row1)
            {
                $pm_val = $this->Common_model->get_value('plant_pm',array('plant_id'=>get_plant_id(),'pm_id'=>$row1['pm_id']),'quantity');
               
                    // updating in plant_pm
                    $total_quantity=$dat['quantity']*$row1['quantity'];
                    $update=$this->Ops_wet_cartons_model->update_plant_pm_quantity($total_quantity,$plant_id,$row1['pm_id']);
                    // checking pm stock balance entry for that caegory
                    $pm_stock_records = $this->Production_m->get_latest_pm_stock_balance_record($row1['pm_id']);
                    if(@$pm_stock_records)
                    {
                        // updating in pm_stock_balace
                        $qry ='UPDATE pm_stock_balance SET production = production +'.$dat['quantity']*$row1['quantity'].'
                             WHERE plant_id = '.get_plant_id().' AND pm_id ='.$row1['pm_id'].' AND closing_balance IS NULL';
                        $this->db->query($qry);
                    }
                    
                
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
                                                <strong>Success!</strong> Wet Carton Information has been added successfully! </div>');
            }
        }
        redirect(SITE_URL.'wet_cartons_entry'); 
    }
}