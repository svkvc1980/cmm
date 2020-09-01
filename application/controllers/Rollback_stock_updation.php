<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Rollback_stock_updation extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Rollback_stock_updation_model");
    }
    
    //Mounika
    //Adding of Stock 
    public function stock_add()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Adding Stock';
        $data['nestedView']['heading'] = "Adding Stock";
        $data['nestedView']['cur_page'] = 'Adding Stock';
        $data['nestedView']['parent_page'] = 'stock_add';
        $data['nestedView']['list_page'] = 'stock_add';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/stock_updation.js"></script>';
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Adding Stock','class'=>'active','url'=>'');
       
        $data['product']=$this->Rollback_stock_updation_model->get_products();
        $data['ops']=$this->Rollback_stock_updation_model->get_ops();

        $this->load->view('rollback_stock_updation/stock_add',$data);
    }

    public function get_product_stock_details()
    {
        $product_id = $this->input->post('product_id',TRUE);
        $plant_id = $this->input->post('plant_id',TRUE);
        echo $this->Rollback_stock_updation_model->get_product_stock_details($product_id,$plant_id);
    }

    public function add_stock_updation()
    {
        $plant_id = $this->input->post('plant_id',TRUE);
        $product_id = $this->input->post('product_id',TRUE);
        if($plant_id=='' || $product_id=='')
        {
            redirect(SITE_URL.'stock_add'); exit();
        }
        $new_quantity = $this->input->post('new_quantity',TRUE);
        $plant_name = $this->Common_model->get_value('plant',array('plant_id'=>$plant_id),'name');
        $product_name = $this->Common_model->get_value('product',array('product_id'=>$product_id),'name');
        $remarks = $this->input->post('remarks',TRUE);
        $name="Stock Has Increased for Unit:".$plant_name." and product :".$product_name." With Sachets: ".$new_quantity."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('add_stock_updation','stock_updation');
        if($issue_at=='')
        {
            $issue_at = $pref['issue_raised_by'];
        }

        $issue_closed_by = $pref['issue_closed_by'];
        if($issue_closed_by == $issued_by)
        {
            $status = 2;
            $issue_at = $issued_by;
        }
        else
        {
            $status = 1;
        }

        $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                               'approval_number'   => $approval_number,
                               'primary_key'       => $product_id,
                               'old_value'         => $plant_id,
                               'new_value'         => $new_quantity,
                               'issue_at'          => $issue_at,
                               'name'              => $name,
                               'status'            => $status,
                               'created_by'        => $this->session->userdata('user_id'),
                               'created_time'      => date('Y-m-d H:i:s'));
        $this->db->trans_begin();
        $approval_id = $this->Common_model->insert_data('approval_list',$approval_data);

        $approval_history_data = array('approval_id'       =>     $approval_id,
                                       'issued_by'         =>     $issued_by,
                                       'remarks'           =>     $remarks,
                                       'created_by'        =>     $this->session->userdata('user_id'),
                                       'created_time'      =>     date('Y-m-d H:i:s'));
        $this->Common_model->insert_data('approval_list_history',$approval_history_data);

        if($issue_closed_by == $issued_by)
        {
            $items_per_carton = $this->Common_model->get_value('product',array('product_id'=>$product_id),'items_per_carton');
            $new_qty = $new_quantity/$items_per_carton;
            $insert_stock = array('plant_id'   =>   $plant_id,
                                  'product_id' =>   $product_id,
                                  'quantity'   =>   $new_qty,
                                  'type'       =>   1/*for increase*/,
                                  'status'     =>   1,
                                  'created_by' =>   $this->session->userdata('user_id'),
                                  'created_time'=>  date('Y-m-d H:i:s'));
            $this->Common_model->insert_data('stock_updation',$insert_stock);

            $qry = "INSERT INTO plant_product(plant_id, product_id, quantity) 
                    VALUES (".$plant_id.",".$product_id.",".$new_qty.")  
                    ON DUPLICATE KEY UPDATE quantity=quantity+VALUES(quantity);";
            $this->db->query($qry);

            $update_approval_data = array('status'        => 2,
                                          'modified_by'   => $this->session->userdata('user_id'),
                                          'modified_time' => date('Y-m-d H:i:s'));
            $updata_approval_where = array('approval_id'  => $approval_id);
            $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

            $daily_data=  array('activity'      =>  $name,
                                'created_by'    =>  $this->session->userdata('user_id'),
                                'created_time'  =>  date('Y-m-d H:i:s')
                        );
            $this->Common_model->insert_data('daily_corrections',$daily_data);
        }
        if ($this->db->trans_status()===FALSE)
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
                            <strong>Success!</strong> Stocks Has successfully Increased for unit '.$plant_name.' With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'stock_add'); exit();
    }

    //Reducing of Stock 
    public function stock_reduce()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Reducing Stock';
        $data['nestedView']['heading'] = "Reducing Stock";
        $data['nestedView']['cur_page'] = 'Reducing Stock';
        $data['nestedView']['parent_page'] = 'stock_reduce';
        $data['nestedView']['list_page'] = 'stock_reduce';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/stock_updation.js"></script>';
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Reducing Stock','class'=>'active','url'=>'');
       
        $data['product'] = $this->Rollback_stock_updation_model->get_products();
        $data['ops']=$this->Rollback_stock_updation_model->get_ops();

        $this->load->view('rollback_stock_updation/stock_reduce',$data);
    }
    public function reduce_stock_updation()
    {
        $plant_id = $this->input->post('plant_id',TRUE);
        $product_id = $this->input->post('product_id',TRUE);
        if($plant_id=='' || $product_id=='')
        {
            redirect(SITE_URL.'stock_reduce'); exit();
        }

        $new_quantity = $this->input->post('new_quantity',TRUE);
        $plant_name = $this->Common_model->get_value('plant',array('plant_id'=>$plant_id),'name');
        $product_name = $this->Common_model->get_value('product',array('product_id'=>$product_id),'name');

        $available_stock = $this->Common_model->get_value('plant_product',array('product_id'=>$product_id,'plant_id'=>$plant_id),'quantity');
        if($available_stock<=0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Error!</strong> Available Stock for product : '.$product_name.' is 0. Cannot Reduce Stock! </div>'); 
            redirect(SITE_URL.'stock_reduce'); exit();  
        }

        $remarks = $this->input->post('remarks',TRUE);
        $name="Stock Has Decreased for Unit:".$plant_name." and product :".$product_name." With Sachets: ".$new_quantity."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('reduce_stock_updation','stock_updation');
        if($issue_at=='')
        {
            $issue_at = $pref['issue_raised_by'];
        }

        $issue_closed_by = $pref['issue_closed_by'];
        if($issue_closed_by == $issued_by)
        {
            $status = 2;
            $issue_at = $issued_by;
        }
        else
        {
            $status = 1;
        }

        $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                               'approval_number'   => $approval_number,
                               'primary_key'       => $product_id,
                               'old_value'         => $plant_id,
                               'new_value'         => $new_quantity,
                               'issue_at'          => $issue_at,
                               'name'              => $name,
                               'status'            => $status,
                               'created_by'        => $this->session->userdata('user_id'),
                               'created_time'      => date('Y-m-d H:i:s'));
        $this->db->trans_begin();
        $approval_id = $this->Common_model->insert_data('approval_list',$approval_data);

        $approval_history_data = array('approval_id'       =>     $approval_id,
                                       'issued_by'         =>     $issued_by,
                                       'remarks'           =>     $remarks,
                                       'created_by'        =>     $this->session->userdata('user_id'),
                                       'created_time'      =>     date('Y-m-d H:i:s'));
        $this->Common_model->insert_data('approval_list_history',$approval_history_data);

        if($issue_closed_by == $issued_by)
        {
            $items_per_carton = $this->Common_model->get_value('product',array('product_id'=>$product_id),'items_per_carton');
            $new_qty = $new_quantity/$items_per_carton;
            $insert_stock = array('plant_id'   =>   $plant_id,
                                  'product_id' =>   $product_id,
                                  'quantity'   =>   $new_qty,
                                  'type'       =>   2/*for Decrease*/,
                                  'status'     =>   1,
                                  'created_by' =>   $this->session->userdata('user_id'),
                                  'created_time'=>  date('Y-m-d H:i:s'));
            $this->Common_model->insert_data('stock_updation',$insert_stock);

            $qry = "INSERT INTO plant_product(plant_id, product_id, quantity) 
                    VALUES (".$plant_id.",".$product_id.",".$new_qty.")  
                    ON DUPLICATE KEY UPDATE quantity=quantity-VALUES(quantity);";
            $this->db->query($qry);

            $update_approval_data = array('status'        => 2,
                                          'modified_by'   => $this->session->userdata('user_id'),
                                          'modified_time' => date('Y-m-d H:i:s'));
            $updata_approval_where = array('approval_id'  => $approval_id);
            $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

            $daily_data=  array('activity'      =>  $name,
                                'created_by'    =>  $this->session->userdata('user_id'),
                                'created_time'  =>  date('Y-m-d H:i:s')
                        );
            $this->Common_model->insert_data('daily_corrections',$daily_data);
        }
        if ($this->db->trans_status()===FALSE)
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
                            <strong>Success!</strong> Stocks Has successfully Reduced for unit '.$plant_name.' With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'stock_reduce'); exit();
    }
}