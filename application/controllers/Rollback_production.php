<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Rollback_production extends CI_Controller
{
  /*roopa-4/4/2017*/
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Rollback_production_model"); 
    }

    public function change_production_date()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Change Production Date';
        $data['nestedView']['heading'] = "Change Production Date";
        $data['nestedView']['cur_page'] = 'Change Production Date';
        $data['nestedView']['parent_page'] = 'change_production_date';
        $data['nestedView']['list_page'] = 'change_production_date';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Change Production Date','class'=>'active','url'=>'');
       
        $data['plantlist']=$this->Rollback_production_model->get_plant_details();
        $data['flag']=1;
        $this->load->view('rollback_production/rollback_production_view',$data);
    }

    public function production_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Change Production Date Details';
        $data['nestedView']['heading'] = "Change Production Date Details";
        $data['nestedView']['cur_page'] = 'Change Production Date Details';
        $data['nestedView']['parent_page'] = 'production_details';
        $data['nestedView']['list_page'] = 'change_production_date';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Change Production Date','class'=>'active','url'=>SITE_URL.'change_production_date'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Production Datails','class'=>'active','url'=>'');

        $production_date=date('Y-m-d', strtotime($this->input->post('production_date',TRUE)));
        $plant_id=$this->input->post('plant_id',TRUE);
        $production_details=$this->Rollback_production_model->get_production_product_data($production_date,$plant_id);
        if($production_details!='')
        { 
            $data['production_details']=$production_details;
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <strong>No Records found...</strong>  </div>');       
            
            redirect(SITE_URL.'change_production_date');
        }
       $this->load->view('rollback_production/rollback_production_view',$data);
    }
    public function update_production_date()
    {
       // echo '<pre>'; print_r($_POST);exit;
        $plant_production_id = $this->input->post('plant_production_id');
        $plant_id = $this->input->post('plant_id');
        if(!isset($plant_production_id))
        { //echo 'ret';exit;
           $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Sorry!</strong> Please Check atleast one production date to change date. </div>');
            redirect(SITE_URL.'change_production_date'); 
        }//exit;
        $plant_production_date=date('Y-m-d', strtotime($this->input->post('updated_date',TRUE)));
        $existing_production_date=date('Y-m-d', strtotime($this->input->post('existing_production_date',TRUE)));
        $this->db->trans_begin();
        if($plant_production_date!='' && $plant_production_date!=$existing_production_date)
        {
            $plant_production_id=$this->input->post('plant_production_id',TRUE);
            $approval_number = get_approval_number();
            $issued_by = $this->session->userdata('block_designation_id');
            //echo $issued_by;exit;
            $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
            $pref = get_reporting_preference('change_production_date','production');
            // echo $this->db->last_query();exit;
            //echo '<pre>';print_r($pref);exit;
            if($issue_at=='')
            {
                $issue_at = $pref['issue_raised_by'];
            }
            
            //echo $name;exit;
            $name = 'Changing Production Date From '.date('d-m-Y', strtotime($this->input->post('existing_production_date',TRUE))). ' To '.$this->input->post('updated_date',TRUE).' At '.get_plant_name_not_in_session($plant_id);
            
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
            $remarks = $this->input->post('remarks');
            $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                                   'approval_number'   => $approval_number,
                                   'primary_key'       => $plant_production_id,
                                   'old_value'         => $existing_production_date,
                                   'new_value'         => $plant_production_date,
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

                $existing_production_date = $approval_data['old_value'];
                $plant_production_date = $approval_data['new_value'];
                $plant_production_id = $approval_data['primary_key'];                

                $updata_new_data = array('production_date' => $plant_production_date);
                $update_new_where = array('plant_production_id' => $plant_production_id);
                $this->Common_model->update_data('plant_production',$updata_new_data,$update_new_where);
                
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
                                    <strong>Success!</strong> Production Date Changed  successful With Request Number :'.$approval_number.' </div>');
                }
                redirect(SITE_URL.'change_production_date');
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
                                <strong>Success!</strong> Production Date  Change Request successfully Raised With Request Number :'.$approval_number.' </div>');
            } 
            redirect(SITE_URL.'change_production_date');

        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> New Date should be different than Existing Date.....</div>');

            redirect(SITE_URL.'change_production_date');
        }
        
    }

    public function delete_production()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Delete Production';
        $data['nestedView']['heading'] = "Delete Production";
        $data['nestedView']['cur_page'] = 'Delete Production';
        $data['nestedView']['parent_page'] = 'delete_production';
        $data['nestedView']['list_page'] = 'delete_production';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Delete Production','class'=>'active','url'=>'');
       
        $data['plantlist']=$this->Rollback_production_model->get_plant_details();
        $data['flag']=1;
        $this->load->view('rollback_production/rollback_production_delete_view',$data);
    }

    public function rollback_delete_production()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Delete Production Details';
        $data['nestedView']['heading'] = "Delete Production Details";
        $data['nestedView']['cur_page'] = 'Delete Production Details';
        $data['nestedView']['parent_page'] = 'production_details';
        $data['nestedView']['list_page'] = 'delete_production';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Delete Production','class'=>'active','url'=>SITE_URL.'delete_production'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Delete Production Datails','class'=>'active','url'=>'');

        $production_date=date('Y-m-d', strtotime($this->input->post('production_date',TRUE)));
        $data['production_date'] = $this->input->post('production_date',TRUE);
        
        $plant_id=$this->input->post('plant_id',TRUE);
        $data['plant_id'] = $plant_id;        
        $production_details=$this->Rollback_production_model->get_production_product_data($production_date,$plant_id);
        if($production_details!='')
        { 
            $data['production_details']=$production_details;
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <strong>No Records found...</strong>  </div>');       
            
            redirect(SITE_URL.'change_production_date');
        }
       $this->load->view('rollback_production/rollback_production_delete_view',$data);
    }
    public function delete_rb_production()
    {
        //echo '<pre>'; print_r($_POST);exit;
        // Assuming That issue raised and closed are same
        $pdp_id_arr = $this->input->post('pdp_id_arr',TRUE);
        $plant_id = $this->input->post('plant_id',TRUE);        
        $pd_qty = $this->input->post('pd_qty',TRUE);
        $product_id = $this->input->post('product_id');
        $production_date = $this->input->post('production_date',TRUE);
        $db_production_date=date('Y-m-d', strtotime($this->input->post('production_date',TRUE)));
        //echo '<pre>'; print_r($pdp_id_arr);exit;

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        //echo $issued_by;exit;
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('delete_production','production');
        // echo $this->db->last_query();exit;
        //echo '<pre>';print_r($pref);exit;
        if($issue_at=='')
        {
            $issue_at = $pref['issue_raised_by'];
        }

        $name ='Deleting following Production Entries at '.get_plant_name_not_in_session($plant_id).' On '.$production_date. ' <br>';
        
        foreach ($pdp_id_arr as $key => $pdp_id)
        {
                $name .= get_product_short_name($product_id[$pdp_id]).' '.$pd_qty[$pdp_id].'<br>';
        }
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
        foreach ($pdp_id_arr as $key => $pdp_id)
        {
            if($pdp_id!='')
            {
                // get production PM data other than film
                $consumption =array();
                $pdp_pm_result= $this->Common_model->get_data('production_pm',array('production_product_id'=>$pdp_id));
                if(count($pdp_pm_result)>0)
                {
                    foreach ($pdp_pm_result as $key => $pdp_pm_data)
                    {
                      $consumption [] = array(
                                        'pm_id'     => $pdp_pm_data['pm_id'],
                                        'quantity'  => $pdp_pm_data['quantity']
                                            );
                    }
                }
                // get production film consumption data
                $pdp_pm_micron_result= $this->Common_model->get_data('production_pm_micron',array('production_product_id'=>$pdp_id));
               /*echo count($pdp_pm_micron_result);exit; 
                var_dump($pdp_pm_micron_result);exit;*/
                if(count($pdp_pm_micron_result) > 0)
                {
                    //echo count($pdp_pm_micron_result);exit;
                    foreach ($pdp_pm_micron_result as $key => $pdp_pm__micron_data)
                    {
                        $consumption [] = array(
                                        'pm_id'     => $pdp_pm__micron_data['pm_id'],
                                        'quantity'  => $pdp_pm__micron_data['quantity']
                                            );
                        $micron_id = $pdp_pm__micron_data['micron_id'];
                    }
                }

                // inserting into 
                $json_consumption = json_encode($consumption);
                $rb_production_data = array(
                            'plant_id'          => $plant_id,
                        'production_product_id' => $pdp_id,
                            'approval_id'       => $approval_id,
                            'product_id'        => $product_id[$pdp_id],
                            'quantity'          => $pd_qty[$pdp_id],
                            'production_date'   => $db_production_date,
                            'micron_id'         => @$micron_id,
                            'consumption'       => $json_consumption,
                            'created_by'        => $this->session->userdata('user_id'),
                            'created_time'      => date('Y-m-d H:i:s')

                        );
                $this->Common_model->insert_data('rb_production',$rb_production_data);
                //echo $this->db->last_query().'<br>';
            }
        }
        if($issue_closed_by == $issued_by)
        {
           //echo '123';exit;
            $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
            // When Last Person Approved
            // based on approval id get records in rb_production
            $rb_production_data = $this->Common_model->get_data('rb_production',array('approval_id'=>$approval_id));
            if(count($rb_production_data)>0)
            {
                foreach ($rb_production_data as $key => $rb_data)
                {
                        // get production PM data other than film
                        $consumption =array();
                        $pdp_pm_result= $this->Common_model->get_data('production_pm',array('production_product_id'=>$rb_data['production_product_id']));
                        if(count($pdp_pm_result)>0)
                        {
                            foreach ($pdp_pm_result as $key => $pdp_pm_data)
                            {
                                // Update Data in plant_pm
                                $qry = 'UPDATE plant_pm SET quantity = quantity + "'.$pdp_pm_data['quantity'].'",updated_time ="'.date('Y-m-d H:i:s').'"  
                                        WHERE plant_id ="'.$plant_id.'" AND pm_id = "'.$pdp_pm_data['pm_id'].'"  ';
                                $this->db->query($qry);
                                //echo $this->db->last_query().'<br>';
                                // Updating in pm_stock_balance                        
                                $qry = 'UPDATE pm_stock_balance SET production = production - "'.$pdp_pm_data['quantity'].'",modified_by ="'.$this->session->userdata('user_id').'",
                                        modified_time ="'.date('Y-m-d H:i:s').'"  
                                        WHERE plant_id ="'.$plant_id.'" AND pm_id = "'.$pdp_pm_data['pm_id'].'"  AND closing_balance IS NULL ';
                                $this->db->query($qry);
                                //echo $this->db->last_query().'<br>';

                            }
                            // delete production_pm Data
                            $qry = 'DELETE FROM production_pm WHERE  production_product_id = "'.$rb_data['production_product_id'].'"  ';
                            $this->db->query($qry);
                            //echo $this->db->last_query().'<br>';//exit;
                        }
                        // get production film consumption data
                        $pdp_pm_micron_result= $this->Common_model->get_data('production_pm_micron',array('production_product_id'=>$rb_data['production_product_id']));
                       // echo $this->db->last_query();exit;
                       // echo '<pre>'; print_r($pdp_pm_micron_result);exit;
                        if(count($pdp_pm_micron_result)>0)
                        {
                            foreach ($pdp_pm_micron_result as $key => $pdp_pm__micron_data)
                            {
                                // Update Data in plant_pm
                                $qry = 'UPDATE plant_pm SET quantity = quantity + "'.$pdp_pm__micron_data['quantity'].'",updated_time ="'.date('Y-m-d H:i:s').'"  
                                        WHERE plant_id ="'.$plant_id.'" AND pm_id = "'.$pdp_pm__micron_data['pm_id'].'"  ';
                                $this->db->query($qry);
                                //echo $this->db->last_query().'<br>';//exit;

                                // Updating in pm_stock_balance                        
                                $qry = 'UPDATE pm_stock_balance SET production = production - "'.$pdp_pm__micron_data['quantity'].'",
                                        modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"   
                                        WHERE plant_id ="'.$plant_id.'" AND pm_id = "'.$pdp_pm__micron_data['pm_id'].'"  AND closing_balance IS NULL ';
                                $this->db->query($qry);
                                //echo $this->db->last_query().'<br>';

                                // Updateing in plant_film_stock
                                $qry = 'UPDATE plant_film_stock SET quantity = quantity + "'.$pdp_pm__micron_data['quantity'].'",
                                        modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"   
                                        WHERE plant_id ="'.$plant_id.'" AND pm_id = "'.$pdp_pm__micron_data['pm_id'].'" 
                                        AND micron_id ="'.$pdp_pm__micron_data['micron_id'].'" ';
                                $this->db->query($qry);   
                                //echo $this->db->last_query().'<br>';                     
                            }
                            // delete production_pm_micron Data
                            $qry = 'DELETE FROM production_pm_micron WHERE  production_product_id = "'.$rb_data['production_product_id'].'"  ';
                            $this->db->query($qry);
                           // echo $this->db->last_query().'<br>';
                        }              

                        // delete production_product data
                        $qry = 'DELETE FROM production_product WHERE  production_product_id = "'.$rb_data['production_product_id'].'"  ';
                        $this->db->query($qry);
                        //echo $this->db->last_query().'<br>';

                        // update plant stock                 
                        $qry = 'UPDATE plant_product SET quantity = quantity - "'.$pd_qty[$pdp_id].'" , updated_time ="'.date('Y-m-d H:i:s').'" 
                                WHERE plant_id ="'.$plant_id.'" AND product_id = "'.$product_id[$pdp_id].'"  ';
                        $this->db->query($qry);
                        //echo $this->db->last_query().'<br>';//exit;  

                        // Update Oil Stock Balance                                
                        $oil_wt = get_oil_weight($product_id[$pdp_id]);
                        $items_per_carton = get_items_per_carton($product_id[$pdp_id]);
                        $production_oil = (($pd_qty[$pdp_id]*$oil_wt*$items_per_carton)/1000);
                        $qry ='UPDATE oil_stock_balance SET production = production - "'.$production_oil.'",
                                modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"   
                                WHERE plant_id = "'.$plant_id.'" AND loose_oil_id ='.get_loose_oil_id($product_id[$pdp_id]).' AND closing_balance IS NULL';
                        $this->db->query($qry); 
                        //echo $this->db->last_query().'<br>';
                        // Updating Approval List and history and daily corrections
                        //$remarks = $this->input->post('remarks');
                        //update_rb($approval_id,$name,$remarks);
                        //echo $this->db->last_query().'<br>';exit;               
                }
            }  
            $remarks = $this->input->post('remarks');
            update_rb($approval_id,$name,$remarks,$single_level);   //exit;   
        }
        //exit;
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
                            <strong>Success!</strong> Production Delete  successful With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'delete_production');
    }
  }
?>