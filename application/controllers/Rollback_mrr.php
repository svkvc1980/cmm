<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Rollback_mrr extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Rollback_mrr_model");
    }

    //Mounika
    //MRR Date Change
    public function mrr_date_change()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="MRR Date";
        $data['nestedView']['pageTitle'] = 'MRR Date';
        $data['nestedView']['cur_page'] = 'mrr_date_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Date', 'class' => 'active', 'url' => '');   
        
        $data['flag']=1;
        $this->load->view('rollback_mrr/mrr_date_change',$data);
    }

    public function mrr_date_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="MRR Date Details";
        $data['nestedView']['pageTitle'] ='MRR Date Details';
        $data['nestedView']['cur_page'] = 'mrr_date_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Date', 'class' => 'active', 'url' => SITE_URL.'mrr_date_change');   
         $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Date Details', 'class' => 'active', 'url' => '');

        $mrr_number=$this->input->post('mrr_no',TRUE);
        $mrr_list=$this->Rollback_mrr_model->get_mrr_data($mrr_number);
        $data['mrr_list']=$mrr_list;
        $data['received_qty']=$this->Rollback_mrr_model->get_received_qty($mrr_list['po_oil_id']);
        //print_r($data['mrr_list']);exit;
        if( $data['mrr_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');
            
            redirect(SITE_URL.'mrr_date_change');
        }

        $this->load->view('rollback_mrr/mrr_date_change',$data);
    }

    public function insert_mrr_date()
    {
        $mrr_date=date('Y-m-d', strtotime($this->input->post('mrr_date',TRUE)));
        $existing_mrr_date=date('Y-m-d', strtotime($this->input->post('existing_mrr_date',TRUE)));
       // $this->db->trans_begin();
        $mrr_number=$this->input->post('mrr_number',TRUE);
        $mrr_oil_id=$this->input->post('mrr_oil_id',TRUE);
        $remarks=$this->input->post('remarks');
        if($mrr_date!='' && $existing_mrr_date!=$mrr_date)
        {
            $mrr_oil_id=$this->input->post('mrr_oil_id',TRUE);
           
            $name="MRR Oil Date Has Changed From ".$existing_mrr_date." TO ".$mrr_date." FOR MRR Number ".$mrr_number."";
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('mrr_oil_date','mrr_oil');
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
                               'primary_key'       => $mrr_oil_id,
                               'old_value'         => $existing_mrr_date,
                               'new_value'         => $mrr_date,
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
      //  echo $this->db->last_query();exit;
        if($issue_closed_by == $issued_by)
        {
            update_single_column_rollback($approval_id,$name,$remarks);
        }

            if ($this->db->trans_status()===FALSE)
            {
                $this->db->rollback();
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>'); 
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Success!</strong> MRR Date has Changed Successfully </div>');
            }
            redirect(SITE_URL.'mrr_date_change');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Already Existing MRR Date is Same as New MRR Date. Please check. </div>');

            redirect(SITE_URL.'mrr_date_change');
        }
    }

    //MRR Delete Entry
    public function mrr_delete_entry()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="MRR Delete";
        $data['nestedView']['pageTitle'] = 'MRR Delete';
        $data['nestedView']['cur_page'] = 'mrr_delete_entry';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Delete', 'class' => 'active', 'url' => '');   
        
        $data['flag']=1;
        $this->load->view('rollback_mrr/mrr_delete_entry',$data);
    }

    public function mrr_delete_entry_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="MRR Delete Entry Details";
        $data['nestedView']['pageTitle'] ='MRR Delete Entry Details';
        $data['nestedView']['cur_page'] = 'mrr_delete_entry_details';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Delete', 'class' => 'active', 'url' => SITE_URL.'mrr_delete_entry');   
         $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Delete Entry Details', 'class' => 'active', 'url' => '');

        $data['product']=$this->Rollback_mrr_model->get_products();
        $data['plant']=$this->Rollback_mrr_model->get_ops();
        $mrr_number=$this->input->post('mrr_no',TRUE);
        $mrr_list=$this->Rollback_mrr_model->get_mrr_data($mrr_number);
        $data['mrr_list']=$mrr_list;
        $data['received_qty']=$this->Rollback_mrr_model->get_received_qty($mrr_list['po_oil_id']);
        //print_r($data['mrr_list']);exit;
        if( $data['mrr_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');
            redirect(SITE_URL.'mrr_delete_entry');
        }
        $this->load->view('rollback_mrr/mrr_delete_entry',$data);
    }

     public function update_mrr_oil_delete_details()
    {
        $mrr_oil_id = $this->input->post('mrr_oil_id',TRUE);
        if($mrr_oil_id == '')
        {
            redirect(SITE_URL.'mrr_delete_entry'); exit();
        }
        $mrr_details = $this->Common_model->get_data_row('mrr_oil',array('mrr_oil_id'=>$mrr_oil_id));
        $remarks = $this->input->post('remarks',TRUE);
        $name="MRR Oil Details of MRR Number :( ".$mrr_details['mrr_number'].") Has been Deleted";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('mrr_oil_delete','mrr_oil');
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
                               'primary_key'       => $mrr_oil_id,
                               'old_value'         => json_encode($mrr_details),
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
            $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
            $pref_data = $this->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

            $primary_key = $approval_data['primary_key'];
           
            // $this->Common_model->delete_data('po_pm',array('po_pm_id'=>$primary_key));

            //retreving MRR plant details
            $mrr_plant_details=$this->Rollback_mrr_model->get_mrr_oil_details($mrr_oil_id);
            
            //updating tanker register status 
            $this->Common_model->update_data('tanker_register',array('status'=>4),array('tanker_id'=> $mrr_plant_details['tanker_id']));

            //retreving plant oil stock balance details based on recent date
            $oil_stock=$this->Rollback_mrr_model->get_mrr_oil_stock_balance($mrr_plant_details['plant_id'],$mrr_plant_details['loose_oil_id'],$mrr_plant_details['mrr_date']);
          
            $receipt_weight=$oil_stock['receipts']-$mrr_plant_details['net_weight'];

            //reducing receipt weight in oil stock balance
             $this->Common_model->update_data('oil_stock_balance',array('receipts'=>$receipt_weight),array('oil_stock_balance_id'=> $oil_stock['oil_stock_balance_id']));

             //updating mrr oil history table
            $mrr_results=$this->Common_model->get_data_row('mrr_oil',array('mrr_oil_id'=>$mrr_oil_id));
            $mrr_history=array(
                'mrr_oil_id'     => $mrr_results['mrr_oil_id'],
                'tanker_oil_id'  => $mrr_results['tanker_oil_id'],
                'mrr_number'     => $mrr_results['mrr_number'],
                'ledger_number'  => $mrr_results['ledger_number'],
                'folio_number'   => $mrr_results['folio_number'],
                'remarks'        => $mrr_results['remarks'],
                'mrr_date'       => $mrr_results['mrr_date'],
                'created_by'     => $mrr_results['created_by'],
                'created_time'   => $mrr_results['created_time'],
                'oil_tank_id'    => $mrr_results['oil_tank_id']
                );
             $this->Common_model->insert_data('mrr_oil_history',$mrr_history);

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
            $this->Common_model->delete_data('mrr_oil',array('mrr_oil_id'=>$mrr_oil_id));
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
                            <strong>Success!</strong> PO Oil Plant Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'po_delete_pm'); exit();
    }

    //MRR PM Date Change
    public function mrr_pm_date_change()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="MRR Date";
        $data['nestedView']['pageTitle'] = 'MRR Date';
        $data['nestedView']['cur_page'] = 'mrr_date_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Date', 'class' => 'active', 'url' => '');   
        
        $data['flag']=1;
        $this->load->view('rollback_mrr/mrr_pm_date_change',$data);
    }

    public function mrr_pm_date_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="MRR Date Details";
        $data['nestedView']['pageTitle'] ='MRR Date Details';
        $data['nestedView']['cur_page'] = 'mrr_date_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Date', 'class' => 'active', 'url' => SITE_URL.'mrr_pm_date_change');   
         $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Date Details', 'class' => 'active', 'url' => '');

        $mrr_number=$this->input->post('mrr_no',TRUE);
        $mrr_pm_list=$this->Rollback_mrr_model->get_mrr_pm_data($mrr_number);
        $data['mrr_pm_list']=$mrr_pm_list;
        $data['received_qty']=$this->Rollback_mrr_model->get_pm_received_qty($mrr_pm_list['po_pm_id'],$mrr_pm_list['pm_category_id']);
        //print_r($data['mrr_list']);exit;
        if( $data['mrr_pm_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');
            
            redirect(SITE_URL.'mrr_pm_date_change');
        }

        $this->load->view('rollback_mrr/mrr_pm_date_change',$data);
    }

     public function update_mrr_pm_delete_details()
    {
        $mrr_pm_id = $this->input->post('mrr_pm_id',TRUE);
        if($mrr_pm_id == '')
        {
            redirect(SITE_URL.'mrr_pm_delete_entry'); exit();
        }
        $mrr_details = $this->Common_model->get_data_row('mrr_pm',array('mrr_pm_id'=>$mrr_pm_id));
        $remarks = $this->input->post('remarks',TRUE);
        $name="MRR PM Details of MRR Number :( ".$mrr_details['mrr_number'].") Has been Deleted";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('mrr_pm_delete','mrr_pm');
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
                               'primary_key'       => $mrr_pm_id,
                               'old_value'         => json_encode($mrr_details),
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
            $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
            $pref_data = $this->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

            $primary_key = $approval_data['primary_key'];
           
            // $this->Common_model->delete_data('po_pm',array('po_pm_id'=>$primary_key));

            //retreving MRR plant details
            $mrr_plant_details=$this->Rollback_mrr_model->get_mrr_pm_details($mrr_pm_id);
            
            //updating tanker register status 
            $this->Common_model->update_data('tanker_register',array('status'=>4),array('tanker_id'=> $mrr_plant_details['tanker_id']));

            //retreving plant pm stock balance details based on recent date
            $pm_stock=$this->Rollback_mrr_model->get_mrr_pm_stock_balance($mrr_plant_details['plant_id'],$mrr_plant_details['pm_id'],$mrr_plant_details['mrr_date']);
            
            if($mrr_plant_details['pm_category_id']==get_film_cat_id())
            {
                $film_results=$this->Common_model->get_data_row('mrr_pm_film',array('mrr_pm_id'=>$mrr_pm_id));
               // print_r($film_results);exit;
                $receipt_weight=$pm_stock['receipts']-$film_results['received_quantity'];
                $received_weight=$film_results['received_quantity'];
            }
            else
            {
                 $receipt_weight=$pm_stock['receipts']-$mrr_plant_details['received_qty'];
                  $received_weight=$mrr_plant_details['received_qty'];
            }

            //reducing receipt weight in oil stock balance
             $this->Common_model->update_data('pm_stock_balance',array('receipts'=>$receipt_weight),array('pm_stock_balance_id'=> $pm_stock['pm_stock_balance_id']));

             //updating mrr oil history table
            $mrr_results=$this->Common_model->get_data_row('mrr_pm',array('mrr_pm_id'=>$mrr_pm_id));
            
            $mrr_history=array(
                'mrr_pm_id'     => $mrr_results['mrr_pm_id'],
                'tanker_pm_id'  => $mrr_results['tanker_pm_id'],
                'mrr_number'     => $mrr_results['mrr_number'],
                'ledger_number'  => $mrr_results['ledger_number'],
                'folio_number'   => $mrr_results['folio_number'],
                'remarks'        => $mrr_results['remarks'],
                'mrr_date'       => $mrr_results['mrr_date'],
                'created_by'     => $mrr_results['created_by'],
                'created_time'   => $mrr_results['created_time'],
                'received_qty'    => $received_weight
                );
             $this->Common_model->insert_data('mrr_pm_history',$mrr_history);

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
             if($mrr_plant_details['pm_category_id']==get_film_cat_id())
            {
               $this->Common_model->delete_data('mrr_pm_film',array('mrr_pm_id'=>$mrr_pm_id));
            }
            $this->Common_model->delete_data('mrr_pm',array('mrr_pm_id'=>$mrr_pm_id));
           
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
                            <strong>Success!</strong> PO Oil Plant Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'po_delete_pm'); exit();
    }

    public function insert_mrr_pm_date()
    {
        $mrr_date=date('Y-m-d', strtotime($this->input->post('mrr_date',TRUE)));
        $existing_mrr_date=date('Y-m-d', strtotime($this->input->post('existing_mrr_date',TRUE)));
       // $this->db->trans_begin();
        $mrr_number=$this->input->post('mrr_number',TRUE);
        $remarks=$this->input->post('remarks');
        if($mrr_date!='' && $existing_mrr_date!=$mrr_date)
        {
            
        $mrr_pm_id=$this->input->post('mrr_pm_id',TRUE);
           
        $name="MRR PM Date Has Changed From ".$existing_mrr_date." TO ".$mrr_date." FOR MRR Number ".$mrr_number."";
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('mrr_pm_date','mrr_pm');
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
                               'primary_key'       => $mrr_pm_id,
                               'old_value'         => $existing_mrr_date,
                               'new_value'         => $mrr_date,
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
      //  echo $this->db->last_query();exit;
        if($issue_closed_by == $issued_by)
        {
            update_single_column_rollback($approval_id,$name,$remarks);
        }
           
            if ($this->db->trans_status()===FALSE)
            {
                $this->db->rollback();
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>'); 
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Success!</strong> MRR PM Date has Changed Successfully </div>');
            }
            redirect(SITE_URL.'mrr_pm_date_change');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Already Existing MRR Date is Same as New MRR Date. Please check. </div>');

            redirect(SITE_URL.'mrr_pm_date_change');
        }
    }

     //MRR PM Delete Entry
    public function mrr_pm_delete_entry()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="MRR Delete";
        $data['nestedView']['pageTitle'] = 'MRR Delete';
        $data['nestedView']['cur_page'] = 'mrr_delete_entry';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Delete', 'class' => 'active', 'url' => '');   
        
        $data['flag']=1;
        $this->load->view('rollback_mrr/mrr_pm_delete_entry',$data);
    }

    public function mrr_pm_delete_entry_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="MRR Delete Entry Details";
        $data['nestedView']['pageTitle'] ='MRR Delete Entry Details';
        $data['nestedView']['cur_page'] = 'mrr_delete_entry_details';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Delete', 'class' => 'active', 'url' => SITE_URL.'mrr_pm_delete_entry');   
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Delete Entry Details', 'class' => 'active', 'url' => '');

        $data['product']=$this->Rollback_mrr_model->get_products();
        $data['plant']=$this->Rollback_mrr_model->get_ops();
        $mrr_number=$this->input->post('mrr_no',TRUE);
        $mrr_pm_list=$this->Rollback_mrr_model->get_mrr_pm_data($mrr_number);
        $data['mrr_pm_list']=$mrr_pm_list;
        $data['received_qty']=$this->Rollback_mrr_model->get_pm_received_qty($mrr_pm_list['po_pm_id'],$mrr_pm_list['pm_category_id']);
        //print_r($data['mrr_list']);exit;
        if( $data['mrr_pm_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');
            redirect(SITE_URL.'mrr_pm_delete_entry');
        }
        $this->load->view('rollback_mrr/mrr_pm_delete_entry',$data);
    }

    //MRR Free Gift Date Change
    public function mrr_fg_date_change()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="MRR Date";
        $data['nestedView']['pageTitle'] = 'MRR Date';
        $data['nestedView']['cur_page'] = 'mrr_fg_date_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Date', 'class' => 'active', 'url' => '');   
        
        $data['flag']=1;
        $this->load->view('rollback_mrr/mrr_fg_date_change',$data);
    }

    public function mrr_fg_date_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="MRR Date Details";
        $data['nestedView']['pageTitle'] ='MRR Date Details';
        $data['nestedView']['cur_page'] = 'mrr_fg_date_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Date', 'class' => 'active', 'url' => SITE_URL.'mrr_fg_date_change');   
         $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Date Details', 'class' => 'active', 'url' => '');

        $mrr_number=$this->input->post('mrr_no',TRUE);
        $mrr_fg_list=$this->Rollback_mrr_model->get_mrr_fg_data($mrr_number);
        $data['mrr_fg_list']=$mrr_fg_list;
        $data['received_qty']=$this->Rollback_mrr_model->get_fg_received_qty($mrr_fg_list['po_fg_id']);
        //print_r($data['mrr_list']);exit;
        if( $data['mrr_fg_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');
            
            redirect(SITE_URL.'mrr_fg_date_change');
        }

        $this->load->view('rollback_mrr/mrr_fg_date_change',$data);
    }

    public function insert_mrr_fg_date()
    {
        $mrr_date=date('Y-m-d', strtotime($this->input->post('mrr_date',TRUE)));
        $existing_mrr_date=date('Y-m-d', strtotime($this->input->post('existing_mrr_date',TRUE)));
        //$this->db->trans_begin();
        $remarks=$this->input->post('remarks');
        $mrr_number=$this->input->post('mrr_number',TRUE);
        if($mrr_date!='' && $existing_mrr_date!=$mrr_date)
        {
           
            $mrr_fg_id=$this->input->post('mrr_fg_id',TRUE);
           
        $name="MRR Freegift Date Has Changed From ".$existing_mrr_date." TO ".$mrr_date." FOR MRR Number ".$mrr_number."";
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('mrr_fg_date','mrr_fg');
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
                               'primary_key'       => $mrr_fg_id,
                               'old_value'         => $existing_mrr_date,
                               'new_value'         => $mrr_date,
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
      //  echo $this->db->last_query();exit;
        if($issue_closed_by == $issued_by)
        {
            update_single_column_rollback($approval_id,$name,$remarks);
        }

            if ($this->db->trans_status()===FALSE)
            {
                $this->db->rollback();
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>'); 
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Success!</strong> MRR PM Date has Changed Successfully </div>');
            }
            redirect(SITE_URL.'mrr_fg_date_change');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Already Existing MRR Date is Same as New MRR Date. Please check. </div>');

            redirect(SITE_URL.'mrr_fg_date_change');
        }
    }

    //MRR FG Delete Entry
    public function mrr_fg_delete_entry()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="MRR Delete";
        $data['nestedView']['pageTitle'] = 'MRR Delete';
        $data['nestedView']['cur_page'] = 'mrr_fg_delete_entry';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Delete', 'class' => 'active', 'url' => '');   
        
        $data['flag']=1;
        $this->load->view('rollback_mrr/mrr_fg_delete_entry',$data);
    }

    public function mrr_fg_delete_entry_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="MRR Delete Entry Details";
        $data['nestedView']['pageTitle'] ='MRR Delete Entry Details';
        $data['nestedView']['cur_page'] = 'mrr_delete_entry_details';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Delete', 'class' => 'active', 'url' => SITE_URL.'mrr_fg_delete_entry');   
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Delete Entry Details', 'class' => 'active', 'url' => '');

        $data['product']=$this->Rollback_mrr_model->get_products();
        $data['plant']=$this->Rollback_mrr_model->get_ops();
        $mrr_number=$this->input->post('mrr_no',TRUE);
        $mrr_fg_list=$this->Rollback_mrr_model->get_mrr_fg_data($mrr_number);
        $data['mrr_fg_list']=$mrr_fg_list;
        $data['received_qty']=$this->Rollback_mrr_model->get_fg_received_qty($mrr_fg_list['po_fg_id']);
        //print_r($data['mrr_list']);exit;
        if( $data['mrr_fg_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');
            redirect(SITE_URL.'mrr_fg_delete_entry');
        }
        $this->load->view('rollback_mrr/mrr_fg_delete_entry',$data);
    }

     public function update_mrr_fg_delete_details()
    {
        $mrr_fg_id = $this->input->post('mrr_fg_id',TRUE);
        if($mrr_fg_id == '')
        {
            redirect(SITE_URL.'mrr_fg_delete_entry'); exit();
        }
        $mrr_details = $this->Common_model->get_data_row('mrr_fg',array('mrr_fg_id'=>$mrr_fg_id));
        $remarks = $this->input->post('remarks',TRUE);
        $name="MRR Freegift Details of MRR Number :( ".$mrr_details['mrr_number'].") Has been Deleted";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('delete_mrr_fg','mrr_fg');
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
                               'primary_key'       => $mrr_fg_id,
                               'old_value'         => json_encode($mrr_details),
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
            $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
            $pref_data = $this->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

            $primary_key = $approval_data['primary_key'];
           
            // $this->Common_model->delete_data('po_pm',array('po_pm_id'=>$primary_key));

            //retreving MRR plant details
            $mrr_plant_details=$this->Rollback_mrr_model->get_mrr_fg_details($mrr_fg_id);
            
            //updating tanker register status 
            $this->Common_model->update_data('tanker_register',array('status'=>4),array('tanker_id'=> $mrr_plant_details['tanker_id']));

            //retreving plant oil stock balance details based on recent date
            $fg_stock=$this->Rollback_mrr_model->get_mrr_plant_fg_stock_balance($mrr_plant_details['plant_id'],$mrr_plant_details['free_gift_id']);
          
            $receipt_weight=$fg_stock['quantity']-$mrr_plant_details['received_qty'];

            //reducing receipt weight in oil stock balance
             $this->Common_model->update_data('plant_free_gift',array('quantity'=>$receipt_weight),array('plant_id'=> $fg_stock['plant_id'],'free_gift_id'=>$fg_stock['free_gift_id']));

             

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
            $this->Common_model->delete_data('mrr_fg',array('mrr_fg_id'=>$mrr_fg_id));
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
                            <strong>Success!</strong> PO Oil Plant Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'mrr_fg_delete_entry'); exit();
    }

}