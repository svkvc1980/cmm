<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Rollback_po_fg extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Rollback_po_fg_model");
    }

    //Mounika
    //PO FG Date Change
    public function po_fg_date_change()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO FG Date";
        $data['nestedView']['pageTitle'] = 'PO FG Date';
        $data['nestedView']['cur_page'] = 'po_fg_date_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Date', 'class' => 'active', 'url' => '');   
        
        $data['flag']=1;
        $this->load->view('rollback_po_fg/po_fg_date_change',$data);
    }

    public function po_fg_date_details_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO FG Date Details";
        $data['nestedView']['pageTitle'] = 'PO FG Date Details';
        $data['nestedView']['cur_page'] = 'po_fg_date_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Date', 'class' => 'active', 'url' => SITE_URL.'po_fg_date_change');   
         $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Date Details', 'class' => 'active', 'url' => '');

        $po_number=$this->input->post('po_no',TRUE);
        $data['po_list']=$this->Rollback_po_fg_model->get_po_fg_data($po_number);
        //print_r($data['po_list']);exit;
        if($data['po_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_fg_date_change');
        }

        $this->load->view('rollback_po_fg/po_fg_date_change',$data);
    }
    
    public function insert_po_fg_date_change()
    {
        $po_date=date('Y-m-d', strtotime($this->input->post('new_po_date',TRUE)));
        $existing_po_date=date('Y-m-d', strtotime($this->input->post('existing_po_date',TRUE)));
        $po_number=$this->input->post('po_number',TRUE);
        $remarks=$this->input->post('remarks');
       if($po_date == $existing_po_date)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'po_fg_date_change'); exit();
             
        }

        //$this->db->trans_begin();
        if($po_date!='' && $existing_po_date!=$po_date)
        {
            $po_fg_id=$this->input->post('po_fg_id',TRUE);
            /*$qry='UPDATE po_oil SET po_date='.$po_date.' WHERE po_oil_id= '.$po_oil_id;
            $this->db->query($qry);*/
            $name="PO Free gift Date Has Changed From ".$existing_po_date." TO ".$po_date." FOR PO Number ".$po_number."";
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_fg_date','po_fg');
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
                               'primary_key'       => $po_fg_id,
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
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Success!</strong> PO FG Date Has Changed successfully for PO Number '.$po_number.' </div>');
            }
            redirect(SITE_URL.'po_fg_date_change');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Already Existing Date is Same as New Date. Please check. </div>');

            redirect(SITE_URL.'po_fg_date_change');
        }
    }

    //PO FG Quantity Change
    public function po_fg_quantity_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO FG Quantity";
        $data['nestedView']['pageTitle'] = 'PO FG Quantity';
        $data['nestedView']['cur_page'] = 'po_fg_quantity_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Quantity', 'class' => 'active', 'url' => '');   
        
        $data['flag']=1;
        $this->load->view('rollback_po_fg/po_fg_quantity_change',$data);
    }

    public function po_fg_quantity_details_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO FG Quantity Details";
        $data['nestedView']['pageTitle'] = 'PO FG Quantity Details';
        $data['nestedView']['cur_page'] = 'po_fg_quantity_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Quantity', 'class' => 'active', 'url' => SITE_URL. 'po_fg_quantity_change');   
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Quantity Details', 'class' => 'active', 'url' => '');

        $po_number=$this->input->post('po_no',TRUE);
        $data['po_list']=$this->Rollback_po_fg_model->get_po_fg_data($po_number);
        if($data['po_list']!='')
        {
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_fg_quantity_change');
        }

        $this->load->view('rollback_po_fg/po_fg_quantity_change',$data);
    }
    public function insert_po_fg_quantity_change()
    {
        $quantity=$this->input->post('new_po_quantity',TRUE);
        $existing_quantity=$this->input->post('existing_quantity',TRUE);
         $po_number=$this->input->post('po_number',TRUE);
         $remarks=$this->input->post('remarks',TRUE);
      //  $this->db->trans_begin();
        if($quantity!='' &&$existing_quantity!=$quantity)
        {
           
            $po_fg_id=$this->input->post('po_fg_id',TRUE);
            /*$qry='UPDATE po_oil SET po_date='.$po_date.' WHERE po_oil_id= '.$po_oil_id;
            $this->db->query($qry);*/
            $name="PO Free Gift Quantity Has Changed From ".$existing_quantity." TO ".$quantity." FOR PO Number ".$po_number."";
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_fg_quantity','po_fg');
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
                               'primary_key'       => $po_fg_id,
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
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Success!</strong> PO FG Quantity Has Changed successfully for PO Number '.$po_number.' </div>');
            }
            redirect(SITE_URL.'po_fg_quantity_change');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Already Existing Quantity is Same as New Quantity. Please check. </div>');

            redirect(SITE_URL.'po_fg_quantity_change');
        }
    }

    //PO FG Product Change
    public function po_fg_product_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO FG Product";
        $data['nestedView']['pageTitle'] = 'PO FG Product';
        $data['nestedView']['cur_page'] = 'po_fg_product_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Product', 'class' => 'active', 'url' => '');   

        $data['flag']=1;
        $this->load->view('rollback_po_fg/po_fg_product_change',$data);
    }

    public function po_fg_product_details_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO FG Product Details";
        $data['nestedView']['pageTitle'] = 'PO FG Product Details';
        $data['nestedView']['cur_page'] = 'po_fg_product_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Product', 'class' => 'active', 'url' => SITE_URL. 'po_fg_product_change');   
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Product Details', 'class' => 'active', 'url' => '');

        $po_number=$this->input->post('po_no',TRUE);
        $data['po_list']=$this->Rollback_po_fg_model->get_po_fg_data($po_number);
        $data['product_list']=$this->Rollback_po_fg_model->get_free_gifts();
        if($data['po_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_fg_product_change');
        }

        $this->load->view('rollback_po_fg/po_fg_product_change',$data);
    }

    public function insert_po_fg_product_change()
    {
        $free_gift_id=$this->input->post('fg_name',TRUE);
        $existing_product=$this->input->post('existing_product',TRUE);
        $existing_product_id=$this->input->post('existing_product_id',TRUE);
        
        $res=$this->Common_model->get_data_row('free_gift',array('free_gift_id'=>$free_gift_id));
        $free_gift_name=$res['name'];
        $remarks=$this->input->post('remarks');
        $po_number=$this->input->post('po_number');
       // $this->db->trans_begin();
        if($free_gift_id!='' && $existing_product_id!=$free_gift_id)
        {
             $po_fg_id=$this->input->post('po_fg_id',TRUE);
            /*$qry='UPDATE po_oil SET po_date='.$po_date.' WHERE po_oil_id= '.$po_oil_id;
            $this->db->query($qry);*/
            $name="PO Free Gift Product Has Changed From ".$existing_product." TO ".$free_gift_name." FOR PO Number ".$po_number."";
            $approval_number = get_approval_number();
            $issued_by = $this->session->userdata('block_designation_id');
            $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
            $pref = get_reporting_preference('po_fg_product','po_fg');
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
                                   'primary_key'       => $po_fg_id,
                                   'old_value'         => $existing_product_id,
                                   'new_value'         => $free_gift_id,
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
                                <strong>Success!</strong> PO FG Product Has Changed successfully for PO Number '.$po_number.' </div>');
            }
            redirect(SITE_URL.'po_fg_product_change');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');

            redirect(SITE_URL.'po_fg_product_change');
        }
    }

    //PO FG Rate Change
    public function po_fg_rate_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO FG Rate";
        $data['nestedView']['pageTitle'] = 'PO FG Rate';
        $data['nestedView']['cur_page'] = 'po_fg_rate_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Rate', 'class' => 'active', 'url' => '');   

        $data['flag']=1;
        $this->load->view('rollback_po_fg/po_fg_rate_change',$data);
    }

    public function po_fg_rate_details_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO FG Rate Details";
        $data['nestedView']['pageTitle'] = 'PO FG Rate Details';
        $data['nestedView']['cur_page'] = 'po_fg_rate_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Rate', 'class' => 'active', 'url' => SITE_URL. 'po_fg_rate_change');   
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Rate Details', 'class' => 'active', 'url' => '');

        $po_number=$this->input->post('po_no',TRUE);
        $data['po_list']=$this->Rollback_po_fg_model->get_po_fg_data($po_number);
        if($data['po_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_fg_rate_change');
        }

        $this->load->view('rollback_po_fg/po_fg_rate_change',$data);
    }

    public function insert_po_fg_rate_change()
    {
        $rate=$this->input->post('new_rate',TRUE);
        $existing_rate=$this->input->post('existing_rate',TRUE);
        $po_number=$this->input->post('po_number',TRUE);
        $remarks=$this->input->post('remarks',TRUE);
        //$this->db->trans_begin();
        if($rate!='' && $existing_rate!=$rate)
        {
           $po_fg_id=$this->input->post('po_fg_id',TRUE);
            /*$qry='UPDATE po_oil SET po_date='.$po_date.' WHERE po_oil_id= '.$po_oil_id;
            $this->db->query($qry);*/
            $name="PO Free Gift Unit Price Has Changed From ".$existing_rate." TO ".$rate." FOR PO Number ".$po_number."";
            $approval_number = get_approval_number();
            $issued_by = $this->session->userdata('block_designation_id');
            $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
            $pref = get_reporting_preference('po_fg_rate','po_fg');
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
                                   'primary_key'       => $po_fg_id,
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
                                <strong>Success!</strong> PO FG Rate Has Changed successfully for PO Number '.$po_number.' </div>');
            }
            redirect(SITE_URL.'po_fg_rate_change');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Already Existing Rate is Same as New Rate. Please check. </div>');

            redirect(SITE_URL.'po_fg_rate_change');
        }
    }

     //PO FG Supplier Change
    public function po_fg_supplier_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO FG Supplier";
        $data['nestedView']['pageTitle'] = 'PO FG Supplier';
        $data['nestedView']['cur_page'] = 'po_fg_supplier_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Supplier', 'class' => 'active', 'url' => '');   

        $data['flag']=1;
        $this->load->view('rollback_po_fg/po_fg_supplier_change',$data);
    }

    public function po_fg_supplier_details_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO FG Supplier Details";
        $data['nestedView']['pageTitle'] = 'PO FG Supplier Details';
        $data['nestedView']['cur_page'] = 'po_fg_supplier_change';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Supplier', 'class' => 'active', 'url' => SITE_URL. 'po_fg_supplier_change');   
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO FG Supplier Details', 'class' => 'active', 'url' => '');

        $po_number=$this->input->post('po_no',TRUE);
        $data['po_list']=$this->Rollback_po_fg_model->get_po_fg_data($po_number);
        $data['supplier_list']=$this->Common_model->get_data('supplier',array('type_id'=>3));
        if($data['po_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_fg_supplier_change');
        }

        $this->load->view('rollback_po_fg/po_fg_supplier_change',$data);
    }
    
    public function insert_po_fg_supplier_change()
    {
        $supplier_id=$this->input->post('supplier_name',TRUE);
        $existing_supplier=$this->input->post('existing_supplier',TRUE);
        $existing_supplier_id=$this->input->post('existing_supplier_id',TRUE);
        $po_number=$this->input->post('po_number',TRUE);
        $remarks=$this->input->post('remarks');
        $res=$this->Common_model->get_data_row('supplier',array('supplier_id'=>$supplier_id));
        $supplier_name=$res['agency_name'];
        //$this->db->trans_begin();
        if($supplier_id!='' && $existing_supplier_id != $supplier_id)
        {
           $po_fg_id=$this->input->post('po_fg_id',TRUE);
            /*$qry='UPDATE po_oil SET po_date='.$po_date.' WHERE po_oil_id= '.$po_oil_id;
            $this->db->query($qry);*/
            $name="PO PM Supplier Has been Changed From ".$existing_supplier." TO ".$supplier_name." FOR PO Number ".$po_number."";
            $approval_number = get_approval_number();
            $issued_by = $this->session->userdata('block_designation_id');
            $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
            $pref = get_reporting_preference('po_fg_supplier','po_fg');
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
                                   'primary_key'       => $po_fg_id,
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
                                <strong>Success!</strong> PO FG Supplier Has Changed successfully for PO Number '.$po_number.' </div>');
            }
            redirect(SITE_URL.'po_fg_supplier_change');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Already Existing Supplier is Same as New Supplier. Please check. </div>');

            redirect(SITE_URL.'po_fg_supplier_change');
        }
    }

    //PO Delete FG 
    public function po_delete_fg()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO Delete";
        $data['nestedView']['pageTitle'] = 'PO Delete';
        $data['nestedView']['cur_page'] = 'po_delete_fg';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO Delete', 'class' => 'active', 'url' => '');   

        $data['flag']=1;
        $this->load->view('rollback_po_fg/po_delete_fg',$data);
    }

    public function po_delete_fg_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO Delete Details";
        $data['nestedView']['pageTitle'] = 'PO Delete Details';
        $data['nestedView']['cur_page'] = 'po_delete_fg';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO Delete', 'class' => 'active', 'url' => SITE_URL. 'po_delete_fg');   
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO Delete Details', 'class' => 'active', 'url' => '');

        $po_number=$this->input->post('po_no',TRUE);
        $data['po_list']=$this->Rollback_po_fg_model->get_po_fg_data($po_number);
        if($data['po_list']!='')
        {
           $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_delete_fg');
        }

        $this->load->view('rollback_po_fg/po_delete_fg',$data);
    }

     public function update_po_pm_delete_fg()
    {   
        $po_fg_id = $this->input->post('po_fg_id',TRUE);

        if($po_fg_id == '')
        {
            redirect(SITE_URL.'po_delete_fg'); exit();
        }
        $po_details = $this->Common_model->get_data_row('po_free_gift',array('po_fg_id'=>$po_fg_id));
        $remarks = $this->input->post('remarks',TRUE);
        $name="PO Freegift Details  For PO Number : ".$po_details['po_number']." Has been Requested To Delete";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('delete_po_fg','po_fg');
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
                               'primary_key'       => $po_fg_id,
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
            $this->Common_model->delete_data('po_free_gift',array('po_fg_id'=>$primary_key));

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
                            <strong>Success!</strong> PO  Freegift Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'po_delete_fg'); exit();
    }
}