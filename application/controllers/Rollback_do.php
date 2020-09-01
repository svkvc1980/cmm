<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Rollback_do extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Rollback_do_model");
    }
    


    //Mounika
    // modified by maruthi 
    //DO Unit Change 
    public function do_unit_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'DO Unit';
        $data['nestedView']['heading'] = "DO Unit";
        $data['nestedView']['cur_page'] = 'DO Unit';
        $data['nestedView']['parent_page'] = 'do_unit_change';
        $data['nestedView']['list_page'] = 'do_unit_change';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'DO Unit','class'=>'active','url'=>'');
       
        $data['flag']=1;
        $this->load->view('rollback_do/do_unit_change',$data);
    }

    public function do_unit_details_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'DO Unit Details';
        $data['nestedView']['heading'] = "DO Unit Details";
        $data['nestedView']['cur_page'] = 'DO Unit Details';
        $data['nestedView']['parent_page'] = 'do_unit_change';
        $data['nestedView']['list_page'] = 'do_unit_change';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'DO Unit','class'=>'active','url'=>SITE_URL.'do_unit_change'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'DO Unit Details','class'=>'active','url'=>'');

        $do_number=$this->input->post('do_no',TRUE);
        //echo $do_number;exit;
        $results=$this->Rollback_do_model->get_do_data($do_number);
        //print_r($data['do_list']);exit;
        foreach ($results as $key => $value) 
        {
            $inv_data = $this->Common_model->get_data('invoice_do',array('do_id'=>$value['do_id']));
            //echo count($inv_data);exit;
            if(count($inv_data)>0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Sorry!</strong> For this DO invoice already raised. So please delete invoice First. Then Delete DO. </div>');
                redirect(SITE_URL.'do_delete');
            }
            $result= $this->Rollback_do_model->get_doProducts($value['do_id']);
            /*$results[$value['do_id']]['sub_products']=$result;*/
        }
        //$data['do_product']=$this->Rollback_do_model->get_doProducts($do_id);
        $data['do_list']=$results;
        $data['results']=$result;
        $data['ops_list']=$this->Rollback_do_model->get_ops();
        if($data['results']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');
            
            redirect(SITE_URL.'do_unit_change');
        }

        $this->load->view('rollback_do/do_unit_change',$data);
    }

    public function insert_do_unit_change()
    {
        $new_lifting_point      =   $this->input->post('new_lifting_point',TRUE);
        $existing_lifting_point =   $this->input->post('lifting_point',TRUE);
        
        
        $this->db->trans_begin();
        if($new_lifting_point!='' && $existing_lifting_point!=$new_lifting_point)
        {
            $order_product = $this->input->post('order_product');
            $do_number = $this->input->post('do_number',TRUE);
            $do_date = $this->input->post('do_date',TRUE);
            $distributor_id = @$this->input->post('distributor_id',TRUE);
            $do_id = $this->input->post('do_id',TRUE);        
            $lifting_point = $this->input->post('lifting_point',TRUE);
            $receiving_plant_id = @$this->input->post('receiving_plant_id');
            $distributor_code = @$this->input->post('distributor_code',TRUE);
            $ob_type = $this->input->post('ob_type',TRUE);
            $order_product_id = $this->input->post('order_product_id',TRUE);
            $do_ob_product_id = $this->input->post('do_ob_product_id',TRUE);
            $do_qty = $this->input->post('do_qty',TRUE);
            $pending_quantity = $this->input->post('pending_qty',TRUE);
            $total_amount = @$this->input->post('total_amount',TRUE);
            $items_per_carton = @$this->input->post('items_per_carton',TRUE);
            $remarks = $this->input->post('remarks',TRUE);
            
            $approval_number = get_approval_number();
            $issued_by = $this->session->userdata('block_designation_id');
            //echo $issued_by;exit;
            $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
            $pref = get_reporting_preference('change_do_unit','delivery_order');
            // echo $this->db->last_query();exit;
            //echo '<pre>';print_r($pref);exit;
            if($issue_at=='')
            {
                $issue_at = $pref['issue_raised_by'];
            }
            if($ob_type == 1)
            {
                $dist_data = $this->Common_model->get_data_row('distributor',array('distributor_code'=>$distributor_code));
                $name ="DO UNIT Has Changed From ".get_plant_name_not_in_session($existing_lifting_point)." TO ".get_plant_name_not_in_session($new_lifting_point)." For DO NUMBER ".$do_number." Of ".$dist_data['agency_name']. " [ ".$dist_data['distributor_code']. " ] , " .$dist_data['distributor_place']."";
            }
            else
            {
                
                $name ="Change of DO Unit From ".get_plant_name_not_in_session($existing_lifting_point)." TO ".get_plant_name_not_in_session($new_lifting_point)." For DO NUMBER ".$do_number." Of ".get_plant_name_not_in_session($receiving_plant_id)."";
            }
            //echo $name;exit;
            
            
            //echo $name;exit;
            $issue_closed_by = $pref['issue_closed_by'];
            if($issue_closed_by == $issued_by)
            {
                $status = 2;
                $issue_at = $issued_by;
                $single_level = 1;
            }
            else
            {
                $status = 1;
               $single_level =0;
            }
            $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                                   'approval_number'   => $approval_number,
                                   'primary_key'       => $do_id,
                                   'old_value'         => $existing_lifting_point,
                                   'new_value'         => $new_lifting_point,
                                   'issue_at'          => $issue_at,
                                   'name'              => $name,
                                   'status'            => $status,
                                   'created_by'        => $this->session->userdata('user_id'),
                                   'created_time'      => date('Y-m-d H:i:s'));
            
            $approval_id = $this->Common_model->insert_data('approval_list',$approval_data);
            //echo $this->db->last_query();//exit;

            $approval_history_data = array('approval_id'       =>     $approval_id,
                                           'issued_by'         =>     $issued_by,
                                           'remarks'           =>     $remarks,
                                           'created_by'        =>     $this->session->userdata('user_id'),
                                           'created_time'      =>     date('Y-m-d H:i:s'));
            $this->Common_model->insert_data('approval_list_history',$approval_history_data);
            //echo $this->db->last_query();//exit;
            if($issue_closed_by == $issued_by)
            {
                //echo 'hello';exit;
                $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
                $pref_data = $this->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

                $old_val = $approval_data['old_value'];
                $new_value = $approval_data['new_value'];
                $do_id = $approval_data['primary_key'];                

                $updata_new_data = array('lifting_point' => $new_value,'modified_by'=>$this->session->userdata('user_id'),'modified_time'=>date('Y-m-d H:i:s'),'remarks'=>$name);
                $update_new_where = array('do_id' => $do_id);
                $this->Common_model->update_data('do',$updata_new_data,$update_new_where);
                //echo $this->db->last_query().'<br>';exit;
                update_rb($approval_id,$name,$remarks,$single_level); //exit;   
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
                                    <strong>Success!</strong> DO Unit Changed  successful With Request Number :'.$approval_number.' </div>');
                }
                redirect(SITE_URL.'do_unit_change');
            }
            //echo 'jnj';exit;
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
                                <strong>Success!</strong> DO Unit Change Request successfully Raised With Request Number :'.$approval_number.' </div>');
            } 
            redirect(SITE_URL.'do_unit_change');          
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Already Existing Lifting Point is Same as New Lifting Point. Please check. </div>');

            redirect(SITE_URL.'do_unit_change');
        }
    }

        //DO Delete 
    public function do_delete()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'DO Delete';
        $data['nestedView']['heading'] = "DO Delete";
        $data['nestedView']['cur_page'] = 'DO Delete';
        $data['nestedView']['parent_page'] = 'do_delete';
        $data['nestedView']['list_page'] = 'do_delete';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'DO Delete','class'=>'active','url'=>'');
       
        $data['flag']=1;
        $this->load->view('rollback_do/do_delete',$data);
    }

    public function do_delete_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Delete DO Details';
        $data['nestedView']['heading'] = "Delete DO Details";
        $data['nestedView']['cur_page'] = 'Delete DO Details';
        $data['nestedView']['parent_page'] = 'do_delete';
        $data['nestedView']['list_page'] = 'do_delete';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'DO Delete','class'=>'active','url'=>SITE_URL.'do_delete'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Delete DO Details','class'=>'active','url'=>'');

        $do_number=$this->input->post('do_no',TRUE);
        //echo $do_number;exit;
        $results=$this->Rollback_do_model->get_do_data($do_number);
        //print_r($data['do_list']);exit;
        foreach ($results as $key => $value) 
        {
            // check do has in invoice list 
            $inv_data = $this->Common_model->get_data('invoice_do',array('do_id'=>$value['do_id']));
            //echo count($inv_data);exit;
            if(count($inv_data)>0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Sorry!</strong> For this DO invoice already raised. So please delete invoice First. Then Delete DO. </div>');
                redirect(SITE_URL.'do_delete');
            }
            $result= $this->Rollback_do_model->get_doProducts($value['do_id']);
            //echo '<pre>'; print_r($result);exit;
            /*$results[$value['do_id']]['sub_products']=$result;*/
        }
        //$data['do_product']=$this->Rollback_do_model->get_doProducts($do_id);
        $data['do_list']=$results;
        $data['results']=$result;
       // print_r($result);exit;
        if($data['results']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');
            
            redirect(SITE_URL.'do_delete');
        }
        $this->load->view('rollback_do/do_delete',$data);
    }
    public function delete_rb_do()
    {
        //echo '<pre>'; print_r($_POST);exit;
        // Assuming That issue raised and closed are same
        $order_product = $this->input->post('order_product');
        $do_number = $this->input->post('do_number',TRUE);
        $do_date = $this->input->post('do_date',TRUE);
        $distributor_id = @$this->input->post('distributor_id',TRUE);
        $do_id = $this->input->post('do_id',TRUE);        
        $lifting_point = $this->input->post('lifting_point',TRUE);
        $receiving_plant_id = @$this->input->post('receiving_plant_id');
        $distributor_code = @$this->input->post('distributor_code',TRUE);
        $ob_type = $this->input->post('ob_type',TRUE);
        $order_product_id = $this->input->post('order_product_id',TRUE);
        $do_ob_product_id = $this->input->post('do_ob_product_id',TRUE);
        $do_qty = $this->input->post('do_qty',TRUE);
        $pending_quantity = $this->input->post('pending_qty',TRUE);
        $total_amount = @$this->input->post('total_amount',TRUE);
        $items_per_carton = @$this->input->post('items_per_carton',TRUE);
        //$db_production_date=date('Y-m-d', strtotime($this->input->post('production_date',TRUE)));
        //echo '<pre>'; print_r($pdp_id_arr);exit;

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        //echo $issued_by;exit;
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('delete_do','delivery_order');
        // echo $this->db->last_query();exit;
        //echo '<pre>';print_r($pref);exit;
        if($issue_at=='')
        {
            $issue_at = $pref['issue_raised_by'];
        }
        if($ob_type == 1)
        {
            $dist_data = $this->Common_model->get_data_row('distributor',array('distributor_code'=>$distributor_code));
            $name ='Deleting DO number '.$do_number.' Of '.$dist_data['agency_name']. ' [ '.$dist_data['distributor_code']. ' ] , ' .$dist_data['distributor_place']. ' and Total Amount of: ' .$total_amount. ' <br>';
        }
        else
        {
            
            $name ='Deleting DO number '.$do_number.' Of '.get_plant_name_not_in_session($receiving_plant_id). ' and Total Amount of: ' .$total_amount. ' <br>';
        }
        //echo $name;exit;
        
        
        //echo $name;exit;
        $issue_closed_by = $pref['issue_closed_by'];
        if($issue_closed_by == $issued_by)
        {
            $status = 2;
            $issue_at = $issued_by;
            $single_level = 1;
        }
        else
        {
            $status = 1;
            $single_level =0;
        }

        $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                               'approval_number'   => $approval_number,                               
                               'issue_at'          => $issue_at,
                               'name'              => $name,
                            'old_value'        => $do_id,
                               'status'            => $status,
                               'created_by'        => $this->session->userdata('user_id'),
                               'created_time'      => date('Y-m-d H:i:s'));
        $this->db->trans_begin();
        $approval_id = $this->Common_model->insert_data('approval_list',$approval_data);
        //echo $this->db->last_query().'<br>';

        $approval_history_data = array('approval_id'       =>     $approval_id,
                                       'issued_by'         =>     $issued_by,
                                       'remarks'           =>     $this->input->post('remarks'),
                                       'created_by'        =>     $this->session->userdata('user_id'),
                                       'created_time'      =>     date('Y-m-d H:i:s'));
        $this->Common_model->insert_data('approval_list_history',$approval_history_data);
        //echo $this->db->last_query().'<br>';
        // inserting data into rb_production with approval_id 
        
        if($issue_closed_by == $issued_by)
        {
           //echo '123';exit;
            $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
            // When Last Person Approved
            // based on approval id get records in rb_production
            $inv_data = $this->Common_model->get_data('invoice_do',array('do_id'=>$approval_data['old_value']));
            //echo count($inv_data);exit;
            if(count($inv_data)>0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Sorry!</strong> For this DO invoice already raised. So please delete invoice First. Then Delete DO. </div>');
                redirect(SITE_URL.'do_delete');
            }
            $do_id = $approval_data['old_value'];
            $do_ob_product_id_arr = array();
            foreach ($order_product as  $op_ids)
            {
                $op_arr = explode('_',$op_ids);
                $order_id = $op_arr[0];
                $product_id = $op_arr[1];
                $do_ob_product_id_arr[] = $do_ob_product_id[$order_id][$product_id];
                // update order product data
                    $qry = 'UPDATE order_product SET pending_qty = pending_qty +"'.$do_qty[$order_id][$product_id].'", status = 2
                            ,modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"    
                            WHERE order_id ="'.$order_id.'" AND product_id="'.$product_id.'" ';
                    $this->db->query($qry);
                    //echo $this->db->last_query().'<br>';

                // update order data
                    $qry = 'UPDATE `order` SET status = 2,modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"   
                            WHERE order_id ="'.$order_id.'" ';
                    $this->db->query($qry);
                    //echo $this->db->last_query().'<br>';
                $do_data = $this->Common_model->get_data_row('do',array('do_id'=>$do_id));
                // inserting in rb_do
                    $rb_do_data = array(
                                'do_id'              =>$do_id,
                                'do_date'            =>$do_date,
                                'do_number'          =>$do_number,
                                'lifting_point'      =>$lifting_point,
                                'do_against_id'      =>$do_data['do_against_id'],
                                'do_created_by'      =>$do_data['created_by'],
                                'do_created_time'    =>$do_data['created_time'],
                                'order_id'           =>$order_id,                                
                                'product_id'         =>$product_id,
                                'quantity'           =>$do_qty[$order_id][$product_id],                                
                                'pending_quantity'   =>$pending_quantity[$order_id][$product_id],
                                'items_per_carton'   =>$items_per_carton[$order_id][$product_id],
                                'created_by'         =>$this->session->userdata('user_id'),
                                'created_time'       =>date('Y-m-d H:i:s')
                                
                                    );
                    
                $this->Common_model->insert_data('rb_do',$rb_do_data);
                
                    //echo $this->db->last_query().'<br>';       
            }
                //echo '<pre>'; print_r($do_ob_product_id_arr);//exit;
            // delete data from do_order_product 
                $do_ob_product_id_string = implode(",",$do_ob_product_id_arr);
                //echo $do_ob_product_id_string;exit;
                //echo $do_id;exit;
                $qry = 'DELETE FROM do_order_product WHERE do_ob_product_id IN ('.$do_ob_product_id_string.')  ';
                $this->db->query($qry);
                //echo $this->db->last_query().'<br>';//exit;

                //echo $this->db->affected_rows();exit;

                //echo $this->db->last_query().'<br>';       
            // deleting from do_order 
                $qry = 'DELETE FROM do_order WHERE do_id ="'.$do_id.'" ';
                $this->db->query($qry);
                //echo $this->db->last_query().'<br>';       
                //exit;
            // deleting from do
                $qry = 'DELETE FROM do WHERE do_id ="'.$do_id.'" ';
                $this->db->query($qry);
                //echo $this->db->last_query().'<br>';exit;
            // updating amount
            if($ob_type == 1)
            {
                // updating distributor outstanding amount 
                $qry ='UPDATE distributor SET outstanding_amount = outstanding_amount + "'.$total_amount.'"                           
                            WHERE distributor_id = "'.$distributor_id.'" ';
                $this->db->query($qry);
                //echo $this->db->last_query().'<br>';exit;
                // inserting into dist transaction amount
                $distributor_data = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$distributor_id));
                $dist_trans_data = array(

                        'distributor_id'        => $distributor_id,
                        'trans_type_id'         => 5,
                        'trans_amount'          => $total_amount,
                        'outstanding_amount'    => ($distributor_data['outstanding_amount']),
                        'remarks'               => 'DO Rollback',
                        'trans_date'            => date('Y-m-d'),
                        'created_by'            => $this->session->userdata('user_id'),
                        'created_time'          => date('Y-m-d H:i:s')

                    );
                $this->Common_model->insert_data('distributor_trans',$dist_trans_data);
                //echo $this->db->last_query().'<br>';exit;
            }
            $remarks = $this->input->post('remarks');
            update_rb($approval_id,$name,$remarks,$single_level); //exit;   
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
                                <strong>Success!</strong> Delivery Order Delete  successful With Request Number :'.$approval_number.' </div>');
            }
                    
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
                            <strong>Success!</strong> Delivery Order Delete  Request Raised With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'do_delete');
    }

    //DO Delete Items
    public function do_delete_items()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'DO Delete Items';
        $data['nestedView']['heading'] = "DO Delete Items";
        $data['nestedView']['cur_page'] = 'DO Delete Items';
        $data['nestedView']['parent_page'] = 'do_delete_items';
        $data['nestedView']['list_page'] = 'do_delete_items';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'DO Delete Items','class'=>'active','url'=>'');
       
        $data['flag']=1;
        $this->load->view('rollback_do/do_delete_items',$data);
    }

    public function do_delete_items_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'DO Delete Items Details';
        $data['nestedView']['heading'] = "DO Delete Items Details";
        $data['nestedView']['cur_page'] = 'DO Delete Items Details';
        $data['nestedView']['parent_page'] = 'do_delete_items';
        $data['nestedView']['list_page'] = 'do_delete_items';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'DO Delete Items','class'=>'active','url'=>SITE_URL.'do_delete_items'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'DO Delete Items Details','class'=>'active','url'=>'');

        $do_number=$this->input->post('do_no',TRUE);
        $results=$this->Rollback_do_model->get_do_data($do_number);
       
        foreach ($results as $key => $value) 
        {
            /*$inv_data = $this->Common_model->get_data('invoice_do',array('do_id'=>$value['do_id']));
            //echo count($inv_data);exit;
            if(count($inv_data)>0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Sorry!</strong> For this DO invoice already raised. So please delete invoice First. Then Delete DO. </div>');
                redirect(SITE_URL.'do_delete_items');
            }*/
            $result=$this->Rollback_do_model->get_doProducts($value['do_id']);
        }
        //$data['do_product']=$this->Rollback_do_model->get_doProducts($do_id);
        $data['do_list']=$results;
        $data['results']=$result;
        //print_r($results);exit;
        if($data['results']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');
            
            redirect(SITE_URL.'do_delete_items');
        }
        $this->load->view('rollback_do/do_delete_items',$data);
    }
    public function delete_rb_do_items()
    {
        //echo '<pre>';
        //print_r($this->input->post('order_product'));exit; 
        $check = $this->input->post('order_product');
        if(!isset($check))
        {
           $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Sorry!</strong> Please Check atleast one product to delete. </div>');
                redirect(SITE_URL.'do_delete_item'); 
        }//exit;
        //echo '<pre>';print_r($_POST);exit;
        // Assuming That issue raised and closed are same
        $order_product = $this->input->post('order_product');

        $product_price = $this->input->post('product_price');
        $do_number = $this->input->post('do_number',TRUE);
        $do_ob_id = $this->input->post('do_ob_id',TRUE);
        $do_date = $this->input->post('do_date',TRUE);
        $distributor_id = @$this->input->post('distributor_id',TRUE);
        $do_id = $this->input->post('do_id',TRUE);        
        $lifting_point = $this->input->post('lifting_point',TRUE);
        $receiving_plant_id = @$this->input->post('receiving_plant_id');
        $distributor_code = @$this->input->post('distributor_code',TRUE);
        $ob_type = $this->input->post('ob_type',TRUE);
        $order_product_id = $this->input->post('order_product_id',TRUE);
        $do_ob_product_id_post = $this->input->post('do_ob_product_id',TRUE);
        $do_qty = $this->input->post('do_qty',TRUE);
        $pending_quantity = $this->input->post('pending_qty',TRUE);
        // $total_amount = @$this->input->post('total_amount',TRUE);
        $items_per_carton = @$this->input->post('items_per_carton',TRUE);
        //$db_production_date=date('Y-m-d', strtotime($this->input->post('production_date',TRUE)));
        //echo '<pre>'; print_r($pdp_id_arr);exit;

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        //echo $issued_by;exit;
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('delete_do_item','delivery_order');
        // echo $this->db->last_query();exit;
        //echo '<pre>';print_r($pref);exit;
        // to caluculate 
        $total_amount = 0;
        foreach ($order_product as  $op_ids)
            {
                $op_arr = explode('_',$op_ids);
                $order_id = $op_arr[0];
                $product_id = $op_arr[1];
                $do_ob_product_id = $do_ob_product_id_post[$order_id][$product_id];
                // Check invoice raised against the do item
                $data = $this->Common_model->get_data('invoice_do_product',array('do_ob_product_id'=>$do_ob_product_id));
                /*echo $this->db->last_query();
                print_r($data);
                 exit;*/
                if(count($data)>0)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                        <strong>Sorry!</strong> For this DO Product invoice already raised. So please delete invoice First. Then Delete DO. </div>');
                        redirect(SITE_URL.'do_delete_items'); exit;
                }
                
                //echo $order_id.'--'.$product_id;exit;
                //echo $do_qty[$order_id][$product_id];exit;
                $deleting_qty = $do_qty[$order_id][$product_id];
                $amount = $do_qty[$order_id][$product_id] * $product_price[$order_id][$product_id] * $items_per_carton[$order_id][$product_id];                
                
                $total_amount += $amount;
                    //echo $this->db->last_query().'<br>';       
            }

        if($issue_at=='')
        {
            $issue_at = $pref['issue_raised_by'];
        }
        if($ob_type == 1)
        {
            $dist_data = $this->Common_model->get_data_row('distributor',array('distributor_code'=>$distributor_code));
            $name ='Deleting DO Product '.get_product_name($product_id).' having quantity '.$deleting_qty.'from do number '.$do_number.' Of '.$dist_data['agency_name']. ' [ '.$dist_data['distributor_code']. ' ] , ' .$dist_data['distributor_place']. ' and Total Amount of: ' .$total_amount. ' <br>';
        }
        else
        {
            
            $name ='Deleting DO Product '.get_product_name($product_id).' having quantity '.$deleting_qty.'from do number '.$do_number.' Of '.get_plant_name_not_in_session($receiving_plant_id). ' and Total Amount of: ' .$total_amount. ' <br>';
        }
        //echo $name;exit;
        
        
        //echo $name;exit;
        $issue_closed_by = $pref['issue_closed_by'];
        if($issue_closed_by == $issued_by)
        {
            $status = 2;
            $issue_at = $issued_by;
            $single_level = 1;
        }
        else
        {
            $status = 1;
            $single_level =0;
        }

        $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                               'approval_number'   => $approval_number,                               
                               'issue_at'          => $issue_at,
                               'name'              => $name,
                            'old_value'        => $do_ob_product_id,
                               'status'            => $status,
                               'created_by'        => $this->session->userdata('user_id'),
                               'created_time'      => date('Y-m-d H:i:s'));
        $this->db->trans_begin();
        $approval_id = $this->Common_model->insert_data('approval_list',$approval_data);
        //echo $this->db->last_query().'<br>';

        $approval_history_data = array('approval_id'       =>     $approval_id,
                                       'issued_by'         =>     $issued_by,
                                       'remarks'           =>     $this->input->post('remarks'),
                                       'created_by'        =>     $this->session->userdata('user_id'),
                                       'created_time'      =>     date('Y-m-d H:i:s'));
        $this->Common_model->insert_data('approval_list_history',$approval_history_data);
        //echo $this->db->last_query().'<br>';
        // inserting data into rb_production with approval_id 
        
        if($issue_closed_by == $issued_by)
        {
           //echo '123';exit;
            $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
            // When Last Person Approved
            // based on approval id get records in rb_production
            $inv_data = $this->Common_model->get_data('invoice_do_product',array('do_ob_product_id'=>$approval_data['old_value']));
            //echo count($inv_data);exit;
            if(count($inv_data)>0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Sorry!</strong> For this DO invoice already raised. So please delete invoice First. Then Delete DO. </div>');
                redirect(SITE_URL.'do_delete_item');
            }
            $do_id = $approval_data['old_value'];
            $do_ob_product_id_arr = array();
            $do_ob_id_arr =array();
            $total_amount = 0;
            //print_r($do_ob_product_id);exit;
            foreach ($order_product as  $op_ids)
            {
                //$amount = $op_ids['do_qty']*$op_ids['product_price']*$op_ids['items_per_carton'];
                $op_arr = explode('_',$op_ids);
                $order_id = $op_arr[0];
                $product_id = $op_arr[1];
               $do_ob_product_id_arr[] = $do_ob_product_id_post[$order_id][$product_id];
                $do_ob_id_arr[] = $do_ob_id[$order_id][$product_id];
                // update order product data
                    $qry = 'UPDATE order_product SET pending_qty = pending_qty +"'.$do_qty[$order_id][$product_id].'", status = 2
                            ,modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"    
                            WHERE order_id ="'.$order_id.'" AND product_id="'.$product_id.'" ';
                    $this->db->query($qry);
                    //echo $this->db->last_query().'<br>';

                // update order data
                    $qry = 'UPDATE `order` SET status = 2,modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"   
                            WHERE order_id ="'.$order_id.'" ';
                    $this->db->query($qry);
                    //echo $this->db->last_query().'<br>';
                $do_data = $this->Common_model->get_data_row('do',array('do_id'=>$do_id));
                // inserting in rb_do
                    $rb_do_data = array(
                                'do_id'              =>$do_id,
                                'do_date'            =>$do_date,
                                'do_number'          =>$do_number,
                                'lifting_point'      =>$lifting_point,
                                'do_against_id'      =>$do_data['do_against_id'],
                                'do_created_by'      =>$do_data['created_by'],
                                'do_created_time'    =>$do_data['created_time'],
                                'order_id'           =>$order_id,                                
                                'product_id'         =>$product_id,
                                'quantity'           =>$do_qty[$order_id][$product_id],                                
                                'pending_quantity'   =>$pending_quantity[$order_id][$product_id],
                                'items_per_carton'   =>$items_per_carton[$order_id][$product_id],
                                'created_by'         =>$this->session->userdata('user_id'),
                                'created_time'       =>date('Y-m-d H:i:s')
                                
                                    );
                    
                $this->Common_model->insert_data('rb_do',$rb_do_data);
                $total_amount += $amount;
                    //echo $this->db->last_query().'<br>';       
            }
                //echo '<pre>'; print_r($do_ob_product_id_arr);//exit;
            // delete data from do_order_product 
                $do_ob_product_id_string = implode(",",$do_ob_product_id_arr);
                $do_ob_id_string = implode(",",$do_ob_id_arr);
                //echo $do_ob_product_id_string;exit;
                //echo $do_id;exit;
                $qry = 'DELETE FROM do_order_product WHERE do_ob_product_id IN ('.$do_ob_product_id_string.')  ';
                $this->db->query($qry);
               // echo $this->db->last_query().'<br>';exit;

                //echo $this->db->affected_rows();exit;

                //echo $this->db->last_query().'<br>';       
            // deleting from do_order 
                //checking  condition and deleting do order
                 $qry = 'SELECT * FROM do_order_product WHERE do_ob_id IN ('.$do_ob_id_string.')' ;
                 $res = $this->db->query($qry);
                 if($res->num_rows() == 0)
                 {
                    $qry = 'DELETE FROM do_order WHERE do_ob_id IN ('.$do_ob_id_string.') ';
                    $this->db->query($qry);
                }
                
            // deleting from do
                //checking  condition and deleting do 
                 $do_order_data = $this->Common_model->get_data('do_order',array('do_id'=>$do_id));
                 if(count($do_order_data) == 0)
                 {
                    $qry = 'DELETE FROM do WHERE do_id ="'.$do_id.'" ';
                    $this->db->query($qry);
                }
                //echo $this->db->last_query().'<br>';exit;
            // updating amount
            if($ob_type == 1)
            {
                // updating distributor outstanding amount 
                $qry ='UPDATE distributor SET outstanding_amount = outstanding_amount + "'.$total_amount.'"                           
                            WHERE distributor_id = "'.$distributor_id.'" ';
                $this->db->query($qry);
                //echo $this->db->last_query().'<br>';exit;
                // inserting into dist transaction amount
                $distributor_data = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$distributor_id));
                $dist_trans_data = array(

                        'distributor_id'        => $distributor_id,
                        'trans_type_id'         => 5,
                        'trans_amount'          => $total_amount,
                        'outstanding_amount'    => ($distributor_data['outstanding_amount']),
                        'remarks'               => 'DO Rollback',
                        'trans_date'            => date('Y-m-d'),
                        'created_by'            => $this->session->userdata('user_id'),
                        'created_time'          => date('Y-m-d H:i:s')

                    );
                $this->Common_model->insert_data('distributor_trans',$dist_trans_data);
                //echo $this->db->last_query().'<br>';exit;
            }
            $remarks = $this->input->post('remarks');
            update_rb($approval_id,$name,$remarks,$single_level); //exit;   
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
                                <strong>Success!</strong> Delivery Order Delete  successful With Request Number :'.$approval_number.' </div>');
            }
            redirect(SITE_URL.'do_delete_items');
                    
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
                            <strong>Success!</strong> Delivery Order Delete  Request Raised With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'do_delete_items');
    }
    //DO Reduce Stock
//DO Reduce Stock
    public function do_reduce_stock()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'DO Reduce Stock';
        $data['nestedView']['heading'] = "DO Reduce Stock";
        $data['nestedView']['cur_page'] = 'DO Reduce Stock';
        $data['nestedView']['parent_page'] = 'do_reduce_stock';
        $data['nestedView']['list_page'] = 'do_reduce_stock';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'DO Reduce Stock','class'=>'active','url'=>'');
       
        $data['flag']=1;
        $this->load->view('rollback_do/do_reduce_stock',$data);
    }

    public function do_reduce_stock_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'DO Reduce Stock Details';
        $data['nestedView']['heading'] = "DO Reduce Stock Details";
        $data['nestedView']['cur_page'] = 'DO Reduce Stock Details';
        $data['nestedView']['parent_page'] = 'do_reduce_stock';
        $data['nestedView']['list_page'] = 'do_reduce_stock';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'DO Reduce Stock','class'=>'active','url'=>SITE_URL.'do_delete_items'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'DO Reduce Stock Details','class'=>'active','url'=>'');

        $do_number=$this->input->post('do_no',TRUE);
        $results=$this->Rollback_do_model->get_do_data($do_number);
       
        foreach ($results as $key => $value) 
        {
            $inv_data = $this->Common_model->get_data('invoice_do',array('do_id'=>$value['do_id']));
            //echo count($inv_data);exit;
            /*if(count($inv_data)>0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Sorry!</strong> For this DO invoice already raised. So please delete invoice First. Then Delete DO. </div>');
                redirect(SITE_URL.'do_reduce_stock');
            }*/
            $result=$this->Rollback_do_model->get_doProducts($value['do_id']);
           
        }
        //$data['do_product']=$this->Rollback_do_model->get_doProducts($do_id);
        $data['do_list']=$results;
        $data['results']=$result;
        //print_r($results);exit;
        if($data['results']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');
            
            redirect(SITE_URL.'do_reduce_stock');
        }
        $this->load->view('rollback_do/do_reduce_stock',$data);
    }
    public function reduce_rb_do_stock()
    {
        /* echo '<pre>';
        print_r($this->input->post('order_product'));exit; */
        $check = $this->input->post('order_product');
        if(!isset($check))
        {
           $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Sorry!</strong> Please Check atleast one product to delete. </div>');
                redirect(SITE_URL.'do_reduce_stock'); 
        }//exit;
        //echo '<pre>';print_r($_POST);exit;
        // Assuming That issue raised and closed are same
        $order_product = $this->input->post('order_product');

        $product_price = $this->input->post('product_price');
        $do_number = $this->input->post('do_number',TRUE);
        $do_ob_id = $this->input->post('do_ob_id',TRUE);
        $do_date = $this->input->post('do_date',TRUE);
        $distributor_id = @$this->input->post('distributor_id',TRUE);
        $do_id = $this->input->post('do_id',TRUE);        
        $lifting_point = $this->input->post('lifting_point',TRUE);
        $receiving_plant_id = @$this->input->post('receiving_plant_id');
        $distributor_code = @$this->input->post('distributor_code',TRUE);
        $ob_type = $this->input->post('ob_type',TRUE);
        $order_product_id = $this->input->post('order_product_id',TRUE);
        $do_ob_product_id_post = $this->input->post('do_ob_product_id',TRUE);
        $do_qty = $this->input->post('do_qty',TRUE);
        $new_do_qty = $this->input->post('new_do_qty',TRUE);
        $pending_quantity = $this->input->post('pending_qty',TRUE);
        // $total_amount = @$this->input->post('total_amount',TRUE);
        $items_per_carton = @$this->input->post('items_per_carton',TRUE);
        //$db_production_date=date('Y-m-d', strtotime($this->input->post('production_date',TRUE)));
        //echo '<pre>'; print_r($pdp_id_arr);exit;

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        //echo $issued_by;exit;
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('reduce_do_stock','delivery_order');
        // echo $this->db->last_query();exit;
        //echo '<pre>';print_r($pref);exit;
        // to caluculate 
        $total_amount = 0;
        foreach ($order_product as  $op_ids)
            {
                $op_arr = explode('_',$op_ids);
                $order_id = $op_arr[0];
                $product_id = $op_arr[1];
                $do_ob_product_id = $do_ob_product_id_post[$order_id][$product_id];
                //echo $order_id.'--'.$product_id;exit;
                //echo $do_qty[$order_id][$product_id];exit;
                $new_qty = $new_do_qty[$order_id][$product_id];
                $old_qty = $do_qty[$order_id][$product_id];
                $final_amount_credit_qty = $old_qty - $new_qty;
                $amount = $final_amount_credit_qty * $product_price[$order_id][$product_id] * $items_per_carton[$order_id][$product_id];                
                
                $total_amount += $amount;
                    //echo $this->db->last_query().'<br>';       
            }

        if($issue_at=='')
        {
            $issue_at = $pref['issue_raised_by'];
        }
        if($ob_type == 1)
        {
            $dist_data = $this->Common_model->get_data_row('distributor',array('distributor_code'=>$distributor_code));
            $name ='Changing DO Product '.get_product_name($product_id).' quantity From '.$old_qty.' TO '.$new_qty.' of do number '.$do_number.' Of '.$dist_data['agency_name']. ' [ '.$dist_data['distributor_code']. ' ] , ' .$dist_data['distributor_place']. ' and Total Amount of: ' .$total_amount. ' <br>';
        }
        else
        {
            
            $name ='Deleting DO Product '.get_product_name($product_id).' quantity From '.$old_qty.' TO '.$new_qty.' of do number '.$do_number.' Of '.get_plant_name_not_in_session($receiving_plant_id). ' and Total Amount of: ' .$total_amount. ' <br>';
        }
        //echo $name;exit;
        
        
        //echo $name;exit;
        $issue_closed_by = $pref['issue_closed_by'];
        if($issue_closed_by == $issued_by)
        {
            $status = 2;
            $issue_at = $issued_by;
            $single_level = 1;
        }
        else
        {
            $status = 1;
            $single_level =0;
        }

        $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                               'approval_number'   => $approval_number,                               
                               'issue_at'          => $issue_at,
                               'name'              => $name,
                            'old_value'        => $old_qty,
                            'new_value'        => $new_qty,
                            'primary_key'      => $do_ob_product_id,
                               'status'            => $status,
                               'created_by'        => $this->session->userdata('user_id'),
                               'created_time'      => date('Y-m-d H:i:s'));
        $this->db->trans_begin();
        $approval_id = $this->Common_model->insert_data('approval_list',$approval_data);
        //echo $this->db->last_query().'<br>';

        $approval_history_data = array('approval_id'       =>     $approval_id,
                                       'issued_by'         =>     $issued_by,
                                       'remarks'           =>     $this->input->post('remarks'),
                                       'created_by'        =>     $this->session->userdata('user_id'),
                                       'created_time'      =>     date('Y-m-d H:i:s'));
        $this->Common_model->insert_data('approval_list_history',$approval_history_data);
        //echo $this->db->last_query().'<br>';
        // inserting data into rb_production with approval_id 
        
        if($issue_closed_by == $issued_by)
        {
           //echo '123';exit;
            $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
            // When Last Person Approved
            // based on approval id get records in rb_production
            $inv_data = $this->Common_model->get_data('invoice_do_product',array('do_ob_product_id'=>$approval_data['primary_key']));
            //echo count($inv_data);exit;
            if(count($inv_data)>0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Sorry!</strong> For this DO invoice already raised. So please delete invoice First. Then Delete DO. </div>');
                redirect(SITE_URL.'do_delete_item');
            }
            $old_qty= $approval_data['old_value'];
            $new_qty = $approval_data['new_value'];
            $do_ob_product_id = $approval_data['primary_key'];
            $do_ob_product_id_arr = array();
            $do_ob_id_arr =array();
            $total_amount = 0;
            //print_r($do_ob_product_id);exit;
            foreach ($order_product as  $op_ids)
            {
                //$amount = $op_ids['do_qty']*$op_ids['product_price']*$op_ids['items_per_carton'];
                $op_arr = explode('_',$op_ids);
                $order_id = $op_arr[0];
                $product_id = $op_arr[1];
               $do_ob_product_id_arr[] = $do_ob_product_id_post[$order_id][$product_id];
                $do_ob_id_arr[] = $do_ob_id[$order_id][$product_id];
                // update order product data
                    $qry = 'UPDATE order_product SET pending_qty = pending_qty +"'.$new_do_qty[$order_id][$product_id].'", status = 2
                            ,modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"    
                            WHERE order_id ="'.$order_id.'" AND product_id="'.$product_id.'" ';
                    $this->db->query($qry);
                // Update Do_order_product
                    $qry = 'UPDATE do_order_product SET quantity = "'.$new_do_qty[$order_id][$product_id].'",
                                        pending_qty = pending_qty -"'.$new_do_qty[$order_id][$product_id].'",status = 1
                            ,modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"    
                            WHERE do_ob_product_id ="'.$do_ob_product_id.'" AND product_id="'.$product_id.'" ';
                    $this->db->query($qry);
                    //echo $this->db->last_query().'<br>';

                // update order data
                    $qry = 'UPDATE `order` SET status = 2,modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"   
                            WHERE order_id ="'.$order_id.'" ';
                    $this->db->query($qry);
                    //echo $this->db->last_query().'<br>';
                $do_data = $this->Common_model->get_data_row('do',array('do_id'=>$do_id));
                // inserting in rb_do
                    $rb_do_data = array(
                                'do_id'              =>$do_id,
                                'do_date'            =>$do_date,
                                'do_number'          =>$do_number,
                                'lifting_point'      =>$lifting_point,
                                'do_against_id'      =>$do_data['do_against_id'],
                                'do_created_by'      =>$do_data['created_by'],
                                'do_created_time'    =>$do_data['created_time'],
                                'order_id'           =>$order_id,                                
                                'product_id'         =>$product_id,
                                'quantity'           =>$new_do_qty[$order_id][$product_id],                                
                                'pending_quantity'   =>($pending_quantity[$order_id][$product_id] - $new_do_qty[$order_id][$product_id]),
                                'items_per_carton'   =>$items_per_carton[$order_id][$product_id],
                                'product_price'      =>$product_price[$order_id][$product_id],
                                'created_by'         =>$this->session->userdata('user_id'),
                                'created_time'       =>date('Y-m-d H:i:s')                                
                                    );
                    
                $this->Common_model->insert_data('rb_do',$rb_do_data);
                $total_amount += $amount;
                    //echo $this->db->last_query().'<br>';       
            }
                
            // updating amount
            if($ob_type == 1)
            {
                // updating distributor outstanding amount 
                $qry ='UPDATE distributor SET outstanding_amount = outstanding_amount + "'.$total_amount.'"                           
                            WHERE distributor_id = "'.$distributor_id.'" ';
                $this->db->query($qry);
                //echo $this->db->last_query().'<br>';exit;
                // inserting into dist transaction amount
                $distributor_data = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$distributor_id));
                $dist_trans_data = array(

                        'distributor_id'        => $distributor_id,
                        'trans_type_id'         => 5,
                        'trans_amount'          => $total_amount,
                        'outstanding_amount'    => ($distributor_data['outstanding_amount']),
                        'remarks'               => 'DO Rollback Reduce Stock',
                        'trans_date'            => date('Y-m-d'),
                        'created_by'            => $this->session->userdata('user_id'),
                        'created_time'          => date('Y-m-d H:i:s')

                    );
                $this->Common_model->insert_data('distributor_trans',$dist_trans_data);
                //echo $this->db->last_query().'<br>';exit;
            }
            $remarks = $this->input->post('remarks');
            update_rb($approval_id,$name,$remarks,$single_level); //exit;   
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
                                <strong>Success!</strong> Delivery Order Delete  successful With Request Number :'.$approval_number.' </div>');
            }
            redirect(SITE_URL.'do_delete_items');
                    
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
                            <strong>Success!</strong> Delivery Order Delete  Request Raised With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'do_delete_items');
    }
}