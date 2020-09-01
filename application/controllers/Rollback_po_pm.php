<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Rollback_po_pm extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Rollback_po_pm_model");
    }

    //Mounika
    //PO PM Date Change
    public function po_pm_date_change()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO PM Date";
        $data['nestedView']['pageTitle'] = 'PO PM Date';
        $data['nestedView']['cur_page'] = 'po_pm_date_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Date', 'class' => 'active', 'url' => '');   
        
        $data['flag']=1;
        $this->load->view('rollback_po_pm/po_pm_date_change',$data);
    }

    public function po_pm_date_details_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO PM Date Details";
        $data['nestedView']['pageTitle'] = 'PO PM Date Details';
        $data['nestedView']['cur_page'] = 'po_pm_date_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Date', 'class' => 'active', 'url' => SITE_URL.'po_pm_date_change');   
         $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Date Details', 'class' => 'active', 'url' => '');

        $po_number=$this->input->post('po_no',TRUE);
        $data['po_list']=$this->Rollback_po_pm_model->get_po_pm_data($po_number);
        if($data['po_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_pm_date_change');
        }

        $this->load->view('rollback_po_pm/po_pm_date_change',$data);
    }
    
    public function insert_po_pm_date_change()
    {
           $po_date=date('Y-m-d', strtotime($this->input->post('new_po_date',TRUE)));
           $existing_po_date=date('Y-m-d', strtotime($this->input->post('existing_po_date',TRUE)));
          // echo 'hi';exit;
          $po_number=$this->input->post('existing_po_number',TRUE);
          $remarks=$this->input->post('remarks');
        if($po_date == $existing_po_date)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'po_pm_date_change'); exit();
             
        }

        //$this->db->trans_begin();
        if($po_date!='' && $existing_po_date!=$po_date)
        {
            $po_pm_id=$this->input->post('po_pm_id',TRUE);
            /*$qry='UPDATE po_oil SET po_date='.$po_date.' WHERE po_oil_id= '.$po_oil_id;
            $this->db->query($qry);*/
            $name="PO PM DATE Has Changed From ".$existing_po_date." TO ".$po_date." FOR PO Number ".$po_number."";
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_pm_date','po_pm');
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
                               'primary_key'       => $po_pm_id,
                               'old_value'         => $existing_po_date,
                               'new_value'         => $po_date,
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
            //exit;
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Success!</strong> PO PM Date Has Changed successfully for PO Number '.$po_number.' </div>');
        }
        redirect(SITE_URL.'po_pm_date_change');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Already Existing Date is Same as New Date. Please check. </div>');

            redirect(SITE_URL.'po_pm_date_change');
        }
    }

    //PO PM Quantity Change
    public function po_pm_quantity_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO PM Quantity";
        $data['nestedView']['pageTitle'] = 'PO PM Quantity';
        $data['nestedView']['cur_page'] = 'po_pm_quantity_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Quantity', 'class' => 'active', 'url' => '');   
        
        $data['flag']=1;
        $this->load->view('rollback_po_pm/po_pm_quantity_change',$data);
    }

    public function po_pm_quantity_details_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO PM Quantity Details";
        $data['nestedView']['pageTitle'] = 'PO PM Quantity Details';
        $data['nestedView']['cur_page'] = 'po_pm_quantity_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Quantity', 'class' => 'active', 'url' => SITE_URL. 'po_pm_quantity_change');   
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Quantity Details', 'class' => 'active', 'url' => '');

        $po_number=$this->input->post('po_no',TRUE);
        $data['po_list']=$this->Rollback_po_pm_model->get_po_pm_data($po_number);
        if($data['po_list']!='')
        {
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_pm_quantity_change');
        }

        $this->load->view('rollback_po_pm/po_pm_quantity_change',$data);
    }
    public function insert_po_pm_quantity_change()
    {
        $quantity=$this->input->post('new_po_quantity',TRUE);
        $existing_quantity=$this->input->post('existing_quantity',TRUE);
        $po_number=$this->input->post('existing_po_number',TRUE);
        $remarks=$this->input->post('remarks');
       // $this->db->trans_begin();
        if($quantity!='' &&$existing_quantity!=$quantity)
        {
            $po_pm_id=$this->input->post('po_pm_id',TRUE);
            /*$qry='UPDATE po_oil SET po_date='.$po_date.' WHERE po_oil_id= '.$po_oil_id;
            $this->db->query($qry);*/
            $name="PO PM Quantity Has Changed From ".$existing_quantity." TO ".$quantity." FOR PO Number ".$po_number."";
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_pm_quantity','po_pm');
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
                               'primary_key'       => $po_pm_id,
                               'old_value'         => $existing_quantity,
                               'new_value'         => $quantity,
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
            //exit;
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Success!</strong> PO PM Quantity Has Changed successfully for PO Number '.$po_number.' </div>');
        }
        redirect(SITE_URL.'po_pm_date_change');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Already Existing Quantity is Same as New Quantity. Please check. </div>');

            redirect(SITE_URL.'po_pm_quantity_change');
        }
    }

    //PO PM Product Change
    public function po_pm_product_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO PM Product";
        $data['nestedView']['pageTitle'] = 'PO PM Product';
        $data['nestedView']['cur_page'] = 'po_pm_product_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Product', 'class' => 'active', 'url' => '');   

        $data['flag']=1;
        $this->load->view('rollback_po_pm/po_pm_product_change',$data);
    }

    public function po_pm_product_details_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO PM Product Details";
        $data['nestedView']['pageTitle'] = 'PO PM Product Details';
        $data['nestedView']['cur_page'] = 'po_pm_product_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Product', 'class' => 'active', 'url' => SITE_URL. 'po_pm_product_change');   
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Product Details', 'class' => 'active', 'url' => '');

        $po_number=$this->input->post('po_no',TRUE);
        $data['po_list']=$this->Rollback_po_pm_model->get_po_pm_data($po_number);
        $data['product_list']=$this->Common_model->get_data('packing_material',array('pm_id!='=>0));
        if($data['po_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_pm_product_change');
        }

        $this->load->view('rollback_po_pm/po_pm_product_change',$data);
    }

    public function insert_po_pm_product_change()
    {
        $pm_id=$this->input->post('packing_name',TRUE);
        $existing_product_id=$this->input->post('existing_product_id',TRUE);
        $res=$this->Common_model->get_data_row('packing_material',array('pm_id'=>$pm_id));
        $pm_name=$res['name'];
        $existing_product=$this->input->post('existing_product',TRUE);
        $po_number=$this->input->post('existing_po_number',TRUE);
        $remarks=$this->input->post('remarks');
      //  $this->db->trans_begin();
        if($pm_id!='' && $existing_product_id!=$pm_id)
        {
             $po_pm_id=$this->input->post('po_pm_id',TRUE);
            /*$qry='UPDATE po_oil SET po_date='.$po_date.' WHERE po_oil_id= '.$po_oil_id;
            $this->db->query($qry);*/
            $name="PO PM Product Has Changed From ".$existing_product." TO ".$pm_name." FOR PO Number ".$po_number."";
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_pm_product','po_pm');
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
                               'primary_key'       => $po_pm_id,
                               'old_value'         => $existing_product_id,
                               'new_value'         => $pm_id,
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
                                <strong>Success!</strong> PO PM Product Has Changed successfully for PO Number '.$po_number.' </div>');
            }
            redirect(SITE_URL.'po_pm_product_change');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');

            redirect(SITE_URL.'po_pm_product_change');
        }
    }

    //PO PM Rate Change
    public function po_pm_rate_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO PM Rate";
        $data['nestedView']['pageTitle'] = 'PO PM Rate';
        $data['nestedView']['cur_page'] = 'po_pm_rate_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Rate', 'class' => 'active', 'url' => '');   

        $data['flag']=1;
        $this->load->view('rollback_po_pm/po_pm_rate_change',$data);
    }

    public function po_pm_rate_details_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO PM Rate Details";
        $data['nestedView']['pageTitle'] = 'PO PM Rate Details';
        $data['nestedView']['cur_page'] = 'po_pm_rate_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Rate', 'class' => 'active', 'url' => SITE_URL. 'po_pm_rate_change');   
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Rate Details', 'class' => 'active', 'url' => '');

        $po_number=$this->input->post('po_no',TRUE);
        $data['po_list']=$this->Rollback_po_pm_model->get_po_pm_data($po_number);
        if($data['po_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_pm_rate_change');
        }

        $this->load->view('rollback_po_pm/po_pm_rate_change',$data);
    }

    public function insert_po_pm_rate_change()
    {
        $rate=$this->input->post('new_rate',TRUE);
        $existing_rate=$this->input->post('existing_rate',TRUE);
        $po_number=$this->input->post('existing_po_number',TRUE);
        $remarks=$this->input->post('remarks');
      //  $this->db->trans_begin();
        if($rate!='' && $existing_rate!=$rate)
        {
             $po_pm_id=$this->input->post('po_pm_id',TRUE);
            /*$qry='UPDATE po_oil SET po_date='.$po_date.' WHERE po_oil_id= '.$po_oil_id;
            $this->db->query($qry);*/
            $name="PO PM Unit Price Has Changed From ".$existing_rate." TO ".$rate." FOR PO Number ".$po_number."";
            $approval_number = get_approval_number();
            $issued_by = $this->session->userdata('block_designation_id');
            $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
            $pref = get_reporting_preference('po_pm_price','po_pm');
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
                                   'primary_key'       => $po_pm_id,
                                   'old_value'         => $existing_rate,
                                   'new_value'         => $rate,
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
                                <strong>Success!</strong> PO PM Rate Has Changed successfully for PO Number '.$po_number.' </div>');
            }
            redirect(SITE_URL.'po_pm_rate_change');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Already Existing Rate is Same as New Rate. Please check. </div>');

            redirect(SITE_URL.'po_pm_rate_change');
        }
    }

    //PO PM OPS Change
    public function po_pm_ops_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO PM OPS";
        $data['nestedView']['pageTitle'] = 'PO PM OPS';
        $data['nestedView']['cur_page'] = 'po_pm_ops_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM OPS', 'class' => 'active', 'url' => '');   

        $data['flag']=1;
        $this->load->view('rollback_po_pm/po_pm_ops_change',$data);
    }

    public function po_pm_ops_details_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO PM OPS Details";
        $data['nestedView']['pageTitle'] = 'PO PM OPS Details';
        $data['nestedView']['cur_page'] = 'po_pm_ops_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM OPS', 'class' => 'active', 'url' => SITE_URL. 'po_pm_ops_change');   
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM OPS Details', 'class' => 'active', 'url' => '');

        $po_number=$this->input->post('po_no',TRUE);
        $data['po_list']=$this->Rollback_po_pm_model->get_po_pm_data($po_number);
        $data['ops_list']=$this->Rollback_po_pm_model->get_ops();
        if($data['po_list']!='')
        {
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_pm_ops_change');
        }

        $this->load->view('rollback_po_pm/po_pm_ops_change',$data);
    }

    public function insert_po_pm_ops_change()
    {
        $plant_id=$this->input->post('plant_name',TRUE);
        $existing_ops=$this->input->post('existing_ops',TRUE);
        $existing_ops_id=$this->input->post('existing_ops_id',TRUE);
        $po_number=$this->input->post('existing_po_number',TRUE);
        $res=$this->Common_model->get_data_row('plant_id',array('plant_id'=>$plant_id));
        $plant_name=$res['name'];
        $remarks=$this->input->post('remarks');
       // $this->db->trans_begin();
        if($plant_id!='' && $existing_ops_id !=$plant_id)
        {    
             $po_pm_id=$this->input->post('po_pm_id',TRUE);
            /*$qry='UPDATE po_oil SET po_date='.$po_date.' WHERE po_oil_id= '.$po_oil_id;
            $this->db->query($qry);*/
            $name="PO PM Unit Has been Changed From ".$existing_ops." TO ".$plant_name." FOR PO Number ".$po_number."";
            $approval_number = get_approval_number();
            $issued_by = $this->session->userdata('block_designation_id');
            $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
            $pref = get_reporting_preference('po_pm_unit','po_pm');
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
                                   'primary_key'       => $po_pm_id,
                                   'old_value'         => $existing_ops_id,
                                   'new_value'         => $plant_id,
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
                                <strong>Success!</strong> PO PM Plant Has Changed successfully for PO Number '.$po_number.' </div>');
            }
            redirect(SITE_URL.'po_pm_ops_change');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Already Existing OPS is Same as New OPS. Please check. </div>');

            redirect(SITE_URL.'po_pm_ops_change');
        }
    }

    //PO PM Supplier Change
    public function po_pm_supplier_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO PM Supplier";
        $data['nestedView']['pageTitle'] = 'PO PM Supplier';
        $data['nestedView']['cur_page'] = 'po_pm_supplier_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Supplier', 'class' => 'active', 'url' => '');   

        $data['flag']=1;
        $this->load->view('rollback_po_pm/po_pm_supplier_change',$data);
    }

    public function po_pm_supplier_details_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO PM Supplier Details";
        $data['nestedView']['pageTitle'] = 'PO PM Supplier Details';
        $data['nestedView']['cur_page'] = 'po_pm_supplier_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Supplier', 'class' => 'active', 'url' => SITE_URL. 'po_pm_supplier_change');   
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO PM Supplier Details', 'class' => 'active', 'url' => '');

        $po_number=$this->input->post('po_no',TRUE);
        $data['po_list']=$this->Rollback_po_pm_model->get_po_pm_data($po_number);
        $data['supplier_list']=$this->Common_model->get_data('supplier',array('supplier_id!='=>0));
        if($data['po_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_pm_supplier_change');
        }

        $this->load->view('rollback_po_pm/po_pm_supplier_change',$data);
    }
    
    public function insert_po_pm_supplier_change()
    {
        $supplier_id=$this->input->post('supplier_name',TRUE);
        $existing_supplier=$this->input->post('existing_supplier',TRUE);
        $existing_supplier_id=$this->input->post('existing_supplier_id',TRUE);
        $po_number=$this->input->post('existing_po_number',TRUE);
        $res=$this->Common_model->get_data_row('supplier',array('supplier_id'=>$supplier_id));
        $supplier_name=$res['agency_name'];
        $remarks=$this->input->post('remarks');
        //$this->db->trans_begin();
        if($supplier_id!='' && $existing_supplier_id!=$supplier_id)
        {
             $po_pm_id=$this->input->post('po_pm_id',TRUE);
            /*$qry='UPDATE po_oil SET po_date='.$po_date.' WHERE po_oil_id= '.$po_oil_id;
            $this->db->query($qry);*/
            $name="PO PM Supplier Has been Changed From ".$existing_supplier." TO ".$supplier_name." FOR PO Number ".$po_number."";
            $approval_number = get_approval_number();
            $issued_by = $this->session->userdata('block_designation_id');
            $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
            $pref = get_reporting_preference('po_pm_supplier','po_pm');
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
                                   'primary_key'       => $po_pm_id,
                                   'old_value'         => $existing_supplier_id,
                                   'new_value'         => $supplier_id,
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
                                <strong>Success!</strong> PO PM Supplier Has Changed successfully for PO Number '.$po_number.' </div>');
            }
            redirect(SITE_URL.'po_pm_supplier_change');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Already Existing Supplier is Same as New Supplier. Please check. </div>');

            redirect(SITE_URL.'po_pm_supplier_change');
        }
    }

    //PO Delete PM 
    public function po_delete_pm()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO Delete";
        $data['nestedView']['pageTitle'] = 'PO Delete';
        $data['nestedView']['cur_page'] = 'po_delete_pm';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO Delete', 'class' => 'active', 'url' => '');   

        $data['flag']=1;
        $this->load->view('rollback_po_pm/po_pm_delete',$data);
    }

    public function po_delete_pm_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO Delete Details";
        $data['nestedView']['pageTitle'] = 'PO Delete Details';
        $data['nestedView']['cur_page'] = 'po_delete_pm';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO Delete', 'class' => 'active', 'url' => SITE_URL. 'po_delete_pm');   
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO Delete Details', 'class' => 'active', 'url' => '');

        $po_number=$this->input->post('po_no',TRUE);
        $data['po_list']=$this->Rollback_po_pm_model->get_po_pm_data($po_number);
        if($data['po_list']=='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_delete_pm');
        }

        $this->load->view('rollback_po_pm/po_pm_delete',$data);
    }

    public function update_po_pm_delete()
    {
        $po_pm_id = $this->input->post('po_pm_id',TRUE);
        if($po_pm_id == '')
        {
            redirect(SITE_URL.'po_delete_pm'); exit();
        }
        $po_details = $this->Common_model->get_data_row('po_pm',array('po_pm_id'=>$po_pm_id));
        $remarks = $this->input->post('remarks',TRUE);
        $name="PO PM Details  For PO PM Number : ".$po_details['po_number']." Has been Deleted";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_pm_delete','po_pm');
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
                               'primary_key'       => $po_pm_id,
                               'old_value'         => json_encode($po_details),
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
            $this->Common_model->delete_data('po_pm',array('po_pm_id'=>$primary_key));

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
                            <strong>Success!</strong> PO Packing Material Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'po_delete_pm'); exit();
    }


}