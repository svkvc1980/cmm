<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
/*Created By Srilekha
Rollback DD Changes*/

class Rollback_dd extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Rollback_dd_model");
	}

	public function distributor_dd()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Change Distributor Name";
		$data['nestedView']['pageTitle'] = 'Change Distributor Name';
        $data['nestedView']['cur_page'] = 'Rollabck DD';
        $data['nestedView']['parent_page'] = 'roll_back';
         $data['nestedView']['list_page'] = 'demand_draft';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Change Distributor Name', 'class' => 'active', 'url' => '');	

        $data['distributor_list']=$this->Rollback_dd_model->get_active_distributor();
        $data['flag']=1;

        $this->load->view('rollback_dd/distributor_dd',$data);

    }

    public function rollback_dd_list()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor Details";
        $data['nestedView']['pageTitle'] = 'Distributor Details';
        $data['nestedView']['cur_page'] = 'Rollabck DD List';
        $data['nestedView']['parent_page'] = 'roll_back';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Change Distributor Name', 'class' => '', 'url' => SITE_URL.'distributor_dd');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor Details', 'class' => 'active', 'url' => '');   

        $distributor_id=$this->input->post('distributor_name',TRUE);
        $dd_number=$this->input->post('dd_number',TRUE);
        $dd_amount=$this->input->post('dd_amount',TRUE);
        $dd_list=$this->Rollback_dd_model->get_dd_data($distributor_id,$dd_number,$dd_amount);
        if($dd_list['status'] == 3)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> DD Payment Is Already Rejected..Cannot Rollback. </div>');
            
            redirect(SITE_URL.'distributor_dd');
        }
        if($dd_list!='')
        {
            $data['dd_list']=$dd_list;
            $data['distributor_list'] = $this->Rollback_dd_model->get_active_distributor();
            $data['flag']=2;
        }

        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> No Data Found For This Details.. Please check. </div>');
            
            redirect(SITE_URL.'distributor_dd');
        }


        $this->load->view('rollback_dd/distributor_dd',$data);
    }
    public function insert_rollback_dd_list()
    {
        $distributor_id = $this->input->post('distributor_id',TRUE);
        $old_distributor_id = $this->input->post('old_distributor_id',TRUE);
        if($distributor_id == $old_distributor_id)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'distributor_dd'); exit();
             
        }
        $old_dd_number = $this->input->post('old_dd_number',TRUE);
        $old_dist = $this->Common_model->get_data('distributor',array('distributor_id'=>$old_distributor_id));
        $new_dist = $this->Common_model->get_data('distributor',array('distributor_id'=>$distributor_id));
        $old_dist_name = $old_dist[0]['distributor_code'].' - ('.$old_dist[0]['agency_name'].')';
        $new_dist_name = $new_dist[0]['distributor_code'].' - ('.$new_dist[0]['agency_name'].')';
        $payment_id = $this->input->post('payment_id',TRUE);
        $remarks = $this->input->post('remarks',TRUE);

        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('distributor_dd_name','distributor_dd');
        if($issue_at=='')
        {
            $issue_at = $pref['issue_raised_by'];
        }


        $name="Distributor Name Has Changed From :".$old_dist_name." TO :".$new_dist_name." For DD Number : ".$old_dd_number."";


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
                               'primary_key'       => $payment_id,
                               'old_value'         => $old_distributor_id,
                               'new_value'         => $distributor_id,
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

            $old_dist = $approval_data['old_value'];
            $new_dist = $approval_data['new_value'];
            $old_dist_data = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$old_dist));
            $new_dist_data = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$new_dist));

            $payment_data = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$approval_data['primary_key']));

            $amount = $payment_data['amount'];
            $old_dist_amount = $old_dist_data['outstanding_amount'];
            $new_dist_amount = $new_dist_data['outstanding_amount'];

            if($old_dist_amount=='')
            { $reduce = 0 - $amount; }
            else
            { $reduce = $old_dist_amount - $amount; }

            if($new_dist_amount=='')
            { $increase = 0 + $amount; }
            else
            { $increase = $new_dist_amount + $amount; }

            $updata_old_data = array('outstanding_amount' => $reduce);
            $update_old_where = array('distributor_id' => $old_dist);
            $this->Common_model->update_data('distributor',$updata_old_data,$update_old_where);

            $updata_new_data = array('outstanding_amount' => $increase);
            $update_new_where = array('distributor_id' => $new_dist);
            $this->Common_model->update_data('distributor',$updata_new_data,$update_new_where);
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
                                <strong>Success!</strong> DD Distributor Has Changed successfully With Request Number :'.$approval_number.' </div>');
            }
        redirect(SITE_URL.'distributor_dd');
    }
    public function dd_amount()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Change Distributor DD Amount";
        $data['nestedView']['pageTitle'] = 'Change Distributor DD Amount';
        $data['nestedView']['cur_page'] = 'Rollabck DD Amount';
        $data['nestedView']['parent_page'] = 'roll_back';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Change Distributor DD Amount', 'class' => 'active', 'url' => '');   

        $data['distributor_list']=$this->Rollback_dd_model->get_active_distributor();
        $data['flag']=1;

        $this->load->view('rollback_dd/rollback_dd_amount',$data);

    }

    public function rollback_dd_amount()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor DD Details";
        $data['nestedView']['pageTitle'] = 'Distributor DD Details';
        $data['nestedView']['cur_page'] = 'Rollabck DD List';
        $data['nestedView']['parent_page'] = 'roll_back';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Change Distributor DD Amount', 'class' => '', 'url' => SITE_URL.'dd_amount');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor DD Details', 'class' => 'active', 'url' => '');  

        $distributor_id=$this->input->post('distributor_name',TRUE);
        $dd_number=$this->input->post('dd_number',TRUE);
        $dd_amount=$this->input->post('dd_amount',TRUE);
        $dd_list=$this->Rollback_dd_model->get_dd_data($distributor_id,$dd_number,$dd_amount);
        if($dd_list['status'] == 3)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> DD Payment Is Already Rejected..No Need For Rollback. </div>');
            
            redirect(SITE_URL.'dd_amount');
        }
        if($dd_list !='')
        {
            
            $data['dd_list']=$dd_list;
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');
            
            redirect(SITE_URL.'dd_amount');
        }

        $this->load->view('rollback_dd/rollback_dd_amount',$data);
    }
    public function insert_rollback_dd_amount()
    {
        $payment_id = $this->input->post('payment_id',TRUE);
        if($payment_id=='')
        {
            redirect(SITE_URL.'dd_amount'); exit();
        }
        $new_dd_amount = $this->input->post('dd_amount',TRUE);
        $dd_details = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$payment_id));
        if($new_dd_amount == $dd_details['amount'])
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'dd_amount'); exit();
             
        }

        
        $remarks = $this->input->post('remarks',TRUE);
        $name="Distributor DD Date changed from :".$dd_details['amount']." TO :".price_format($new_dd_amount)." For DD Number : ".$dd_details['dd_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('distributor_dd_amount','distributor_dd');
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
                               'primary_key'       => $payment_id,
                               'old_value'         => $dd_details['amount'],
                               'new_value'         => $new_dd_amount,
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

            $payment_id = $approval_data['primary_key'];
            $dd_details = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$payment_id));
            $dist_details = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$dd_details['distributor_id']));

            $old_value = $approval_data['old_value'];
            $new_value = $approval_data['new_value'];
            if($old_value >= $new_value)
            {
                $reduce = $old_value-$new_value;
                $outstanding_amount = $dist_details['outstanding_amount']-$reduce;
            }
            else
            {
                $increase = $new_value-$old_value;
                $outstanding_amount = $dist_details['outstanding_amount']+$increase;
            }
            $update_dist_data = array('outstanding_amount'=> $outstanding_amount);
            $update_dist_where = array('distributor_id' => $dist_details['distributor_id']);
            $this->Common_model->update_data('distributor',$update_dist_data,$update_dist_where);
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
                            <strong>Success!</strong> DD Amount Has Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'dd_amount'); exit();
    }
    public function dd_type()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Change Distributor DD Type";
        $data['nestedView']['pageTitle'] = 'Change Distributor DD Type';
        $data['nestedView']['cur_page'] = 'Rollabck DD Type';
        $data['nestedView']['parent_page'] = 'roll_back';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Change Distributor DD Type', 'class' => 'active', 'url' => '');   

        $data['distributor_list'] = $this->Rollback_dd_model->get_active_distributor();
        $data['flag']=1;

        $this->load->view('rollback_dd/rollback_dd_type',$data);

    }

    public function rollback_dd_type()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor DD Details";
        $data['nestedView']['pageTitle'] = 'Distributor DD Details';
        $data['nestedView']['cur_page'] = 'Rollabck DD List';
        $data['nestedView']['parent_page'] = 'roll_back';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Change Distributor DD Type', 'class' => 'active', 'url' => SITE_URL.'dd_type');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor DD Details', 'class' => 'active', 'url' => '');   

        $distributor_id=$this->input->post('distributor_name',TRUE);
        $dd_number=$this->input->post('dd_number',TRUE);
        $dd_amount=$this->input->post('dd_amount',TRUE);

        $dd_list=$this->Rollback_dd_model->get_dd_data($distributor_id,$dd_number,$dd_amount);
        if($dd_list['status'] == 3)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> DD Payment Is Already Rejected..No Need For Rollback. </div>');
            
            redirect(SITE_URL.'dd_type');
        }
        if($dd_list !='')
        {
            
            $data['dd_list']=$dd_list;
            $data['payment_mode']=$this->Common_model->get_data('payment_mode',array('status'=>1));
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>');
            
            redirect(SITE_URL.'dd_type');
        }

        $this->load->view('rollback_dd/rollback_dd_type',$data);
    }
    public function insert_rollback_dd_type()
    {
        $payment_id = $this->input->post('payment_id',TRUE);
        if($payment_id=='')
        {
            redirect(SITE_URL.'dd_type'); exit();
        }
        $new_payment_mode_id = $this->input->post('payment_mode_id',TRUE);
        $dd_details = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$payment_id));
        if($new_payment_mode_id == $dd_details['pay_mode_id'])
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'dd_type'); exit();
             
        }

        $old_name = $this->Common_model->get_value('payment_mode',array('pay_mode_id'=>$dd_details['pay_mode_id']),'name');
        $new_name = $this->Common_model->get_value('payment_mode',array('pay_mode_id'=>$new_payment_mode_id),'name');
        $remarks = $this->input->post('remarks',TRUE);
        $name="Distributor DD Type changed from :".$old_name." TO :".$new_name." For DD Number : ".$dd_details['dd_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('distributor_dd_payment_type','distributor_dd');
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
                               'primary_key'       => $payment_id,
                               'old_value'         => $dd_details['pay_mode_id'],
                               'new_value'         => $new_payment_mode_id,
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
                            <strong>Success!</strong> DD Payment Type Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'dd_type'); exit();
    }

    //Mounika
    //DD Date Change 
    public function dd_date_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Change Distributor DD Date';
        $data['nestedView']['heading'] = "Change Distributor DD Date";
        $data['nestedView']['cur_page'] = 'dd_date_change';
        $data['nestedView']['parent_page'] = 'roll_back';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Change Distributor DD Date','class'=>'active','url'=>'');
       
        $data['distributor']= $this->Rollback_dd_model->get_active_distributor();

        $data['flag']=1;
        $this->load->view('rollback_dd/dd_date_change',$data);
    }

    public function dd_date_change_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Distributor DD Details';
        $data['nestedView']['heading'] = "Distributor DD Details";
        $data['nestedView']['cur_page'] = 'dd_date_change';
        $data['nestedView']['parent_page'] = 'roll_back';
        $data['nestedView']['list_page'] = 'demand_draft';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Change Distributor DD Date','class'=>'','url'=>SITE_URL.'dd_date_change'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Distributor DD Details','class'=>'active','url'=>'');

        $distributor_id=$this->input->post('distributor_name',TRUE);
        //echo $distributor_id;exit;
        $dd_number=$this->input->post('dd_number',TRUE);
        $dd_amount=$this->input->post('dd_amount',TRUE);
        $dd_list=$this->Rollback_dd_model->get_dd_data($distributor_id,$dd_number,$dd_amount);
        if($dd_list['status'] == 3)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> DD Payment Is Already Rejected..No Need For Rollback. </div>');
            
            redirect(SITE_URL.'dd_date_change');
        }
        if($dd_list !='')
        {
            
            $data['dd_date']=$dd_list;
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <strong>Error!</strong> Something went wrong. Please Check... </div>');       
            
            redirect(SITE_URL.'dd_date_change');
        }
        $this->load->view('rollback_dd/dd_date_change',$data);
    }

    public function insert_rollback_dd_date()
    {
        $payment_id = $this->input->post('payment_id',TRUE);
        if($payment_id=='')
        {
            redirect(SITE_URL.'dd_date_change'); exit();
        }
        $new_payment_date = date('Y-m-d',strtotime($this->input->post('payment_date',TRUE)));
        $dd_details = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$payment_id));
        if($new_payment_date == $dd_details['payment_date'])
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'dd_date_change'); exit();
             
        }
        $remarks = $this->input->post('remarks',TRUE);
        $name="Distributor DD Date changed from :".format_date($dd_details['payment_date'])." TO :".format_date($new_payment_date)." For DD Number : ".$dd_details['dd_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('distributor_dd_date','distributor_dd');
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
                               'primary_key'       => $payment_id,
                               'old_value'         => $dd_details['payment_date'],
                               'new_value'         => $new_payment_date,
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
                            <strong>Success!</strong> DD Payment Date Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'dd_date_change'); exit();
    }
    
    //DD Number Change
    public function dd_number_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Change Distributor DD Number';
        $data['nestedView']['heading'] = "Change Distributor DD Number";
        $data['nestedView']['cur_page'] = 'dd_number_change';
        $data['nestedView']['parent_page'] = 'roll_back';
        $data['nestedView']['list_page'] = 'demand_draft';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Change Distributor DD Number','class'=>'active','url'=>'');
       
        $data['distributor']=$this->Rollback_dd_model->get_active_distributor();

        $data['flag']=1;
        $this->load->view('rollback_dd/dd_number_change',$data);
    }

    public function dd_number_change_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'DD Number Details';
        $data['nestedView']['heading'] = "DD Number Details";
        $data['nestedView']['cur_page'] = 'dd_number_change';
        $data['nestedView']['parent_page'] = 'roll_back';
        $data['nestedView']['list_page'] = 'demand_draft';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Change Distributor DD Number','class'=>'','url'=>SITE_URL.'dd_number_change'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'DD Number Details','class'=>'active','url'=>'');

        $distributor_id=$this->input->post('distributor_name',TRUE);
        //echo $distributor_id;exit;
        $dd_number=$this->input->post('dd_number',TRUE);
        $dd_amount=$this->input->post('dd_amount',TRUE);
        $dd_list=$this->Rollback_dd_model->get_dd_data($distributor_id,$dd_number,$dd_amount);
        if($dd_list['status'] == 3)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> DD Payment Is Already Rejected..No Need For Rollback. </div>');
            
            redirect(SITE_URL.'dd_number_change');
        }
        if($dd_list !='')
        {
            
            $data['dd_number']=$dd_list;
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <strong>Error!</strong> Something went wrong. Please Check... </div>');       
            
            redirect(SITE_URL.'dd_number_change');
        }
        $this->load->view('rollback_dd/dd_number_change',$data);
    }

    public function insert_rollback_dd_number()
    {
        $payment_id = $this->input->post('payment_id',TRUE);
        if($payment_id=='')
        {
            redirect(SITE_URL.'dd_number_change'); exit();
        }
        $new_dd_number = $this->input->post('dd_number',TRUE);
        $get_result = $this->Rollback_dd_model->is_numberExist($new_dd_number);
        if($get_result==1)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>Please check. DD number : <strong>'.$new_dd_number.'</strong> is already Exist  </div>');
            redirect(SITE_URL.'dd_number_change'); exit();
        }
        $dd_details = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$payment_id));
        $remarks = $this->input->post('remarks',TRUE);
        $name="Distributor DD Number changed from :".$dd_details['dd_number']." TO :".$new_dd_number." For DD Number : ".$dd_details['dd_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('distributor_dd_number','distributor_dd');
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
                               'primary_key'       => $payment_id,
                               'old_value'         => $dd_details['dd_number'],
                               'new_value'         => $new_dd_number,
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
                            <strong>Success!</strong> DD Payment Number Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'dd_number_change'); exit();
    }

    //DD Bank Change
    public function dd_bank_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Change Distributor DD Bank';
        $data['nestedView']['heading'] = "Change Distributor DD Bank";
        $data['nestedView']['cur_page'] = 'dd_bank_change';
        $data['nestedView']['parent_page'] = 'roll_back';
        $data['nestedView']['list_page'] = 'demand_draft';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Change Distributor DD Bank','class'=>'active','url'=>'');
       
        $data['distributor']= $this->Rollback_dd_model->get_active_distributor();

        $data['flag']=1;
        $this->load->view('rollback_dd/dd_bank_change',$data);
    }

    public function dd_bank_change_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'DD Bank Details';
        $data['nestedView']['heading'] = "DD Bank Details";
        $data['nestedView']['cur_page'] = 'DD Bank Details';
        $data['nestedView']['parent_page'] = 'dd_bank_change';
        $data['nestedView']['list_page'] = 'dd_bank_change';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Change Distributor DD Bank','class'=>'','url'=>SITE_URL.'dd_bank_change'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'DD Bank Details','class'=>'active','url'=>'');

        $distributor_id=$this->input->post('distributor_id',TRUE);
        $dd_number=$this->input->post('dd_number',TRUE);
        $dd_amount=$this->input->post('dd_amount',TRUE);
        $dd_list = $this->Rollback_dd_model->get_dd_data($distributor_id,$dd_number,$dd_amount);
        if($dd_list['status'] == 3)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> DD Payment Is Already Rejected..No Need For Rollback. </div>');
            
            redirect(SITE_URL.'dd_bank_change');
        }
        $data['bank_list']=$this->Common_model->get_data('bank',array('status'=>1));
        if($dd_list !='')
        {
            $data['dd_bank'] = $dd_list;
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <strong>Error!</strong> Something went wrong. Please Check... </div>');       
            
            redirect(SITE_URL.'dd_bank_change');
        }
        $this->load->view('rollback_dd/dd_bank_change',$data);
    }

   
    public function insert_rollback_dd_bank()
    {
        $payment_id = $this->input->post('payment_id',TRUE);
        if($payment_id=='')
        {
            redirect(SITE_URL.'dd_bank_change'); exit();
        }
        $new_bank_id = $this->input->post('bank_id',TRUE);
        $dd_details = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$payment_id));
        if($new_bank_id == $dd_details['bank_id'])
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'dd_bank_change'); exit();
             
        }

        $old_name = $this->Common_model->get_value('bank',array('bank_id'=>$dd_details['bank_id']),'name');
        $new_name = $this->Common_model->get_value('bank',array('bank_id'=>$new_bank_id),'name');
        $remarks = $this->input->post('remarks',TRUE);
        $name="Distributor DD Bank changed from :".$old_name." TO :".$new_name." For DD Number : ".$dd_details['dd_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('distributor_dd_bank','distributor_dd');
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
                               'primary_key'       => $payment_id,
                               'old_value'         => $dd_details['bank_id'],
                               'new_value'         => $new_bank_id,
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
                            <strong>Success!</strong> DD Payment Type Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'dd_bank_change'); exit();
    }
    
    public function distributor_delete_dd()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Delete Distributor DD";
        $data['nestedView']['pageTitle'] = 'Delete Distributor DD';
        $data['nestedView']['cur_page'] = 'distributor_delete_dd';
        $data['nestedView']['parent_page'] = 'roll_back';
         $data['nestedView']['list_page'] = 'demand_draft';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Delete Distributor DD', 'class' => 'active', 'url' => ''); 

        $data['distributor_list']=$this->Rollback_dd_model->get_active_distributor();
        $data['flag']=1;

        $this->load->view('rollback_dd/distributor_delete_dd',$data);

    }

    public function rollback_dd_delete_list()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor Details";
        $data['nestedView']['pageTitle'] = 'Distributor Details';
        $data['nestedView']['cur_page'] = 'distributor_delete_dd';
        $data['nestedView']['parent_page'] = 'roll_back';
        $data['nestedView']['list_page'] = 'demand_draft';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Delete Distributor DD', 'class' => '', 'url' => SITE_URL.'distributor_delete_dd');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor Details', 'class' => 'active', 'url' => '');   

        $distributor_id=$this->input->post('distributor_name',TRUE);
        $dd_number=$this->input->post('dd_number',TRUE);
        $dd_amount=$this->input->post('dd_amount',TRUE);
        $dd_list=$this->Rollback_dd_model->get_dd_data($distributor_id,$dd_number,$dd_amount);
        if($dd_list['status'] == 3)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> DD Payment Is Already Rejected..Cannot Rollback. </div>');
            
            redirect(SITE_URL.'distributor_delete_dd');
        }
        if($dd_list!='')
        {
            $data['dd_list']=$dd_list;
            $data['flag']=2;
        }

        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> No Data Found For This Details.. Please check. </div>');
            
            redirect(SITE_URL.'distributor_delete_dd');
        }
        $this->load->view('rollback_dd/distributor_delete_dd',$data);
    }

    public function insert_rollback_dd_delete()
    {
        $payment_id = $this->input->post('payment_id',TRUE);
        if($payment_id == '')
        {
            redirect(SITE_URL.'distributor_delete_dd'); exit();
        }
        $dd_details = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$payment_id));
        $remarks = $this->input->post('remarks',TRUE);
        $name="DD Details  For DD Number : ".$dd_details['dd_number']." Has been Deleted";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('distributor_dd_delete','distributor_dd');
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
                               'primary_key'       => $payment_id,
                               'old_value'         => json_encode($dd_details),
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
            $this->Common_model->delete_data('distributor_payment',array('payment_id'=>$primary_key));

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
                            <strong>Success!</strong> Distributor DD Details Deleted successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'distributor_delete_dd'); exit();
    }
}