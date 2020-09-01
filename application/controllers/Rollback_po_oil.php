<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Rollback_po_oil extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Rollback_po_oil_model");
	}

	

    public function po_oil_date()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil Date";
        $data['nestedView']['pageTitle'] = 'Manage PO Oil Date';
        $data['nestedView']['cur_page'] = 'po_oil_date';
        $data['nestedView']['parent_page'] = 'roll_back';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil Date', 'class' => 'active', 'url' => '');   

        
        $data['flag']=1;

        $this->load->view('rollback_po_oil/rollback_po_oil_date',$data);

    }

    public function rollback_po_oil_date()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil Date";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil Date';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil Date', 'class' => 'active', 'url' => SITE_URL.'po_oil_date');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil date', 'class' => 'active', 'url' => '');   

        $po_number=$this->input->post('po_no',TRUE);
        $po_list=$this->Rollback_po_oil_model->get_po_oil_data($po_number);
        if($po_list!='')
        {
            $data['po_list']=$po_list;
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_oil_date');
        }

        $this->load->view('rollback_po_oil/rollback_po_oil_date',$data);
    }
    public function insert_rollback_po_oil_date()
    {
        $po_oil_id = $this->input->post('po_oil_id',TRUE);
        if($po_oil_id == '')
        {
            redirect(SITE_URL.'po_oil_date'); exit();
        }
        $new_po_date = date('Y-m-d',strtotime($this->input->post('new_po_date',TRUE)));
        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
        if($new_po_date == $po_details['po_date'])
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'po_oil_date'); exit();
             
        }
        $remarks = $this->input->post('remarks',TRUE);
        $name="PO Oil Date has changed From :".format_date($po_details['po_date'])." TO :".format_date($new_po_date)." For PO Oil Number : ".$po_details['po_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_oil_date','po_oil');
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
                               'primary_key'       => $po_oil_id,
                               'old_value'         => $po_details['po_date'],
                               'new_value'         => $new_po_date,
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
            update_single_column_rollback($approval_id,$name,$remarks);
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
                            <strong>Success!</strong> PO Oil date Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'po_oil_date'); exit();
    }

    public function po_oil_quantity()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil Quantity";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil Quantity', 'class' => 'active', 'url' => '');   

        
        $data['flag']=1;

        $this->load->view('rollback_po_oil/rollback_po_oil_quantity',$data);

    }

    public function rollback_po_oil_quantity()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil Quantity', 'class' => 'active', 'url' => SITE_URL.'po_oil_quantity');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil', 'class' => 'active', 'url' => '');   

        $po_number=$this->input->post('po_no',TRUE);
        $po_list=$this->Rollback_po_oil_model->get_po_oil_data($po_number);
        if($po_list!='')
        {
            $data['po_list']=$po_list;
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_oil_quantity');
        }

        $this->load->view('rollback_po_oil/rollback_po_oil_quantity',$data);
    }
    public function insert_rollback_po_oil_quantity()
    {
        $po_oil_id = $this->input->post('po_oil_id',TRUE);
        if($po_oil_id == '')
        {
            redirect(SITE_URL.'po_oil_quantity'); exit();
        }
        $new_po_qty = $this->input->post('new_po_quantity',TRUE);
        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
        if($new_po_qty == $po_details['quantity'])
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'po_oil_quantity'); exit();
             
        }
        $remarks = $this->input->post('remarks',TRUE);
        $name="PO Oil Quantity has changed From :".qty_format($po_details['quantity'])." TO :".qty_format($new_po_qty)." For PO Oil Number : ".$po_details['po_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_oil_quantity','po_oil');
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
                               'primary_key'       => $po_oil_id,
                               'old_value'         => $po_details['quantity'],
                               'new_value'         => $new_po_qty,
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
            update_single_column_rollback($approval_id,$name,$remarks);
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
                            <strong>Success!</strong> PO Oil Quantity Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'po_oil_quantity'); exit();

    }

     public function po_oil_price()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil Price";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil Price', 'class' => 'active', 'url' => '');   

        
        $data['flag']=1;

        $this->load->view('rollback_po_oil/rollback_po_oil_price',$data);

    }

    public function rollback_po_oil_price()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil Price', 'class' => 'active', 'url' => SITE_URL.'po_oil_price');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil', 'class' => 'active', 'url' => '');   

        $po_number=$this->input->post('po_no',TRUE);
        $po_list=$this->Rollback_po_oil_model->get_po_oil_data($po_number);
        if($po_list!='')
        {
            $data['po_list']=$po_list;
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_oil_price');
        }

        $this->load->view('rollback_po_oil/rollback_po_oil_price',$data);
    }
    public function insert_rollback_po_oil_price()
    {
        $po_oil_id = $this->input->post('po_oil_id',TRUE);
        if($po_oil_id == '')
        {
            redirect(SITE_URL.'po_oil_price'); exit();
        }
        $new_po_price = $this->input->post('new_po_price',TRUE);
        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
        if($new_po_price == $po_details['unit_price'])
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'po_oil_price'); exit();
             
        }
        $remarks = $this->input->post('remarks',TRUE);
        $name="PO Oil Price has changed From :".price_format($po_details['unit_price'])." TO :".price_format($new_po_price)." For PO Oil Number : ".$po_details['po_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_oil_price','po_oil');
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
                               'primary_key'       => $po_oil_id,
                               'old_value'         => $po_details['unit_price'],
                               'new_value'         => $new_po_price,
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
            update_single_column_rollback($approval_id,$name,$remarks);
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
                            <strong>Success!</strong> PO Oil Unit Price Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'po_oil_price'); exit();
    }

    public function po_oil_product()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil Product";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil Product', 'class' => 'active', 'url' => '');   

        
        $data['flag']=1;

        $this->load->view('rollback_po_oil/rollback_po_oil_product',$data);

    }

    public function rollback_po_oil_product()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil Product', 'class' => 'active', 'url' => SITE_URL.'po_oil_product');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil', 'class' => 'active', 'url' => '');   

        $po_number=$this->input->post('po_no',TRUE);
        $po_list=$this->Rollback_po_oil_model->get_po_oil_data($po_number);
        if($po_list!='')
        {
            $data['po_list']=$po_list;
            $data['loose_oil']=$this->Common_model->get_data('loose_oil',array('status'=>1,'loose_oil_id!='=>8));
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_oil_product');
        }

        $this->load->view('rollback_po_oil/rollback_po_oil_product',$data);
    }
    public function insert_rollback_po_oil_product()
    {
        $po_oil_id = $this->input->post('po_oil_id',TRUE);
        if($po_oil_id == '')
        {
            redirect(SITE_URL.'po_oil_product'); exit();
        }
        $new_po_oil = $this->input->post('loose_oil_id',TRUE);
        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
        if($new_po_oil == $po_details['loose_oil_id'])
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'po_oil_product'); exit();
             
        }
        $old_value = $this->Common_model->get_value('loose_oil',array('loose_oil_id'=>$po_details['loose_oil_id']),'name');
        $new_value = $this->Common_model->get_value('loose_oil',array('loose_oil_id'=>$new_po_oil),'name');
        $remarks = $this->input->post('remarks',TRUE);
        $name="PO Oil Name has changed From :".$old_value." TO :".$new_value." For PO Oil Number : ".$po_details['po_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_oil_name','po_oil');
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
                               'primary_key'       => $po_oil_id,
                               'old_value'         => $po_details['loose_oil_id'],
                               'new_value'         => $new_po_oil,
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
            update_single_column_rollback($approval_id,$name,$remarks);
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
                            <strong>Success!</strong> PO Oil Name Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'po_oil_product'); exit();
    }

    public function po_oil_supplier()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil Supplier";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage DD', 'class' => 'active', 'url' => '');   

        
        $data['flag']=1;

        $this->load->view('rollback_po_oil/rollback_po_oil_supplier',$data);

    }

    public function rollback_po_oil_supplier()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil Supplier', 'class' => 'active', 'url' => SITE_URL.'po_oil_supplier');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil', 'class' => 'active', 'url' => '');   

        $po_number=$this->input->post('po_no',TRUE);
        $po_list=$this->Rollback_po_oil_model->get_po_oil_data($po_number);
        if($po_list!='')
        {
            $data['po_list']=$po_list;
            $data['supplier']=$this->Common_model->get_data('supplier',array('status'=>1));
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_oil_supplier');
        }

        $this->load->view('rollback_po_oil/rollback_po_oil_supplier',$data);
    }
    public function insert_rollback_po_oil_supplier()
    {
        $po_oil_id = $this->input->post('po_oil_id',TRUE);
        if($po_oil_id == '')
        {
            redirect(SITE_URL.'po_oil_supplier'); exit();
        }
        $new_po_supplier = $this->input->post('supplier_id',TRUE);
        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
        if($new_po_supplier == $po_details['supplier_id'])
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'po_oil_supplier'); exit();
             
        }
        $old_value = $this->Common_model->get_value('supplier',array('supplier_id'=>$po_details['supplier_id']),'agency_name');
        $new_value = $this->Common_model->get_value('supplier',array('supplier_id'=>$new_po_supplier),'agency_name');
        $remarks = $this->input->post('remarks',TRUE);
        $name="PO Oil Supplier has changed From :".$old_value." TO :".$new_value." For PO Oil Number : ".$po_details['po_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_oil_supplier','po_oil');
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
                               'primary_key'       => $po_oil_id,
                               'old_value'         => $po_details['supplier_id'],
                               'new_value'         => $new_po_supplier,
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
            update_single_column_rollback($approval_id,$name,$remarks);
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
                            <strong>Success!</strong> PO Oil Supplier Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'po_oil_supplier'); exit();
    }

    public function po_oil_broker()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil Broker";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil Broker', 'class' => 'active', 'url' => '');   

        
        $data['flag']=1;

        $this->load->view('rollback_po_oil/rollback_po_oil_broker',$data);

    }

    public function rollback_po_oil_broker()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil Broker', 'class' => 'active', 'url' => SITE_URL.'po_oil_broker');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil', 'class' => 'active', 'url' => '');   

        $po_number=$this->input->post('po_no',TRUE);
        $po_list=$this->Rollback_po_oil_model->get_po_oil_data($po_number);
        if($po_list!='')
        {
            $data['po_list']=$po_list;
            $data['broker']=$this->Common_model->get_data('broker',array('status'=>1));
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_oil_broker');
        }

        $this->load->view('rollback_po_oil/rollback_po_oil_broker',$data);
    }
    public function insert_rollback_po_oil_broker()
    {
        $po_oil_id = $this->input->post('po_oil_id',TRUE);
        if($po_oil_id == '')
        {
            redirect(SITE_URL.'po_oil_broker'); exit();
        }
        $new_po_broker = $this->input->post('broker_id',TRUE);
        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
        if($new_po_broker == $po_details['broker_id'])
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'po_oil_broker'); exit();
             
        }
        $old_value = $this->Common_model->get_value('broker',array('broker_id'=>$po_details['broker_id']),'agency_name');
        $new_value = $this->Common_model->get_value('broker',array('broker_id'=>$new_po_broker),'agency_name');
        $remarks = $this->input->post('remarks',TRUE);
        $name="PO Oil Broker has changed From :".$old_value." TO :".$new_value." For PO Oil Number : ".$po_details['po_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_oil_broker','po_oil');
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
                               'primary_key'       => $po_oil_id,
                               'old_value'         => $po_details['broker_id'],
                               'new_value'         => $new_po_broker,
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
            update_single_column_rollback($approval_id,$name,$remarks);
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
                            <strong>Success!</strong> PO Oil Broker Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'po_oil_broker'); exit();    
    }

    public function po_oil_block()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil Block";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage DD', 'class' => 'active', 'url' => '');   

        
        $data['flag']=1;

        $this->load->view('rollback_po_oil/rollback_po_oil_block',$data);

    }

    public function rollback_po_oil_block()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil Block', 'class' => 'active', 'url' => SITE_URL.'po_oil_block');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil', 'class' => 'active', 'url' => '');   

        $po_number=$this->input->post('po_no',TRUE);
        $po_list=$this->Rollback_po_oil_model->get_po_oil_data($po_number);
        if($po_list!='')
        {
            $data['po_list']=$po_list;
            $data['block']=$this->Rollback_po_oil_model->get_block();
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_oil_block');
        }

        $this->load->view('rollback_po_oil/rollback_po_oil_block',$data);
    }
    public function insert_rollback_po_oil_block()
    {
        $po_oil_id = $this->input->post('po_oil_id',TRUE);
        if($po_oil_id == '')
        {
            redirect(SITE_URL.'po_oil_block'); exit();
        }
        $new_po_plant = $this->input->post('plant_id',TRUE);
        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
        if($new_po_plant == $po_details['plant_id'])
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'po_oil_block'); exit();
             
        }
        $old_value = $this->Common_model->get_value('plant',array('plant_id'=>$po_details['plant_id']),'name');
        $new_value = $this->Common_model->get_value('plant',array('plant_id'=>$new_po_plant),'name');
        $remarks = $this->input->post('remarks',TRUE);
        $name="PO Oil Plant has changed From :".$old_value." TO :".$new_value." For PO Oil Number : ".$po_details['po_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_oil_plant','po_oil');
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
                               'primary_key'       => $po_oil_id,
                               'old_value'         => $po_details['plant_id'],
                               'new_value'         => $new_po_plant,
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
            update_single_column_rollback($approval_id,$name,$remarks);
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
        redirect(SITE_URL.'po_oil_block');
    }

    public function po_oil_delete()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage PO Oil";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Delete PO Oil', 'class' => 'active', 'url' => '');   

        
        $data['flag']=1;

        $this->load->view('rollback_po_oil/rollback_po_oil_delete',$data);

    }

    public function rollback_po_oil_delete()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Delete PO Oil";
        $data['nestedView']['pageTitle'] = 'PO Oil';
        $data['nestedView']['cur_page'] = 'Rollabck PO Oil';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage PO Oil', 'class' => 'active', 'url' => SITE_URL.'po_oil_delete');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Delete PO Oil', 'class' => 'active', 'url' => '');   

        $po_number=$this->input->post('po_no',TRUE);
        $po_list=$this->Rollback_po_oil_model->get_po_oil_data($po_number);
        if($po_list!='')
        {
            $exist = $this->Common_model->get_value('po_oil_tanker',array('po_oil_id'=>$po_list['po_oil_id']),'tanker_id');
            if($exist != '')
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number : '.$po_number.' has Already been received. Cannot Delete PO. </div>');
            
                redirect(SITE_URL.'po_oil_delete');
            }
            $data['po_list']=$po_list;
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> PO Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'po_oil_delete'); exit();
        }

        $this->load->view('rollback_po_oil/rollback_po_oil_delete',$data);
    }

    public function insert_rollback_po_oil_delete()
    {
        $po_oil_id = $this->input->post('po_oil_id',TRUE);
        if($po_oil_id == '')
        {
            redirect(SITE_URL.'po_oil_delete'); exit();
        }
        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
        $remarks = $this->input->post('remarks',TRUE);
        $name="PO Oil Details  For PO Oil Number : ".$po_details['po_number']." Has been Deleted";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_oil_delete','po_oil');
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
                               'primary_key'       => $po_oil_id,
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
            $this->Common_model->delete_data('po_oil',array('po_oil_id'=>$primary_key));

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
                            <strong>Success!</strong> PO Oil Plant Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'po_oil_delete'); exit();
    }
}