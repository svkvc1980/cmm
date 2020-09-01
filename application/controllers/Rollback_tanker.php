<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Rollback_tanker extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Rollback_tanker_model");
	}

	public function delete_tanker()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Tanker";
        $data['nestedView']['pageTitle'] = 'Rolback Tanker';
        $data['nestedView']['cur_page'] = 'Rollabck Tanker';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Tanker', 'class' => 'active', 'url' => '');   

        
        $data['flag']=1;

        $this->load->view('rollback_tanker/rollback_delete_tanker',$data);

    }

    public function rollback_tanker_register()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Tanker Details";
        $data['nestedView']['pageTitle'] = 'Tanker Details';
        $data['nestedView']['cur_page'] = 'Rollabck Tanker Details';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Tanker', 'class' => 'active', 'url' => SITE_URL.'delete_tanker');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Tanker Details', 'class' => 'active', 'url' => '');   

        $tanker_number=$this->input->post('tanker_no',TRUE);
        $tanker_id=$this->Common_model->get_value('tanker_register',array('tanker_in_number'=>$tanker_number),'tanker_id');
        $tanker_list=$this->Rollback_tanker_model->get_tanker_data($tanker_id);
        if($tanker_list!='')
        {
            $data['tanker_list']=$tanker_list;
            $data['flag']=2;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Tanker Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'delete_tanker');
        }

        $this->load->view('rollback_tanker/rollback_delete_tanker',$data);
    }
    public function insert_rollback_tanker_register()
    {
        $tanker_id=$this->input->post('tanker_id',TRUE);
        $this->db->trans_begin();
        if($tanker_id!='')
        {
            
            
        	$tanker_number=$this->input->post('tanker_number',TRUE);
            $where=array('tanker_id'=>$tanker_id);
            $data=array('status'=>15);
            $this->Common_model->update_data('tanker_register',$data,$where);
            /*$qry='UPDATE po_oil SET po_date='.$po_date.' WHERE po_oil_id= '.$po_oil_id;
            $this->db->query($qry);*/
            $activity="Tanker Number ".$tanker_number." Is Deleted From Tanker Register Entry ";
            $data=  array(
                        'activity'      =>  $activity,
                        'created_by'    =>  $this->session->userdata('user_id'),
                        'created_time'  =>  date('Y-m-d H:i:s')
                        );
            $this->Common_model->insert_data('daily_corrections',$data);

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
                                <strong>Success!</strong> Tanker Register Entry Has Deleted successfully for Tanker Number '.$tanker_number.' </div>');
            }
        redirect(SITE_URL.'delete_tanker');

        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Tanker Number Is Not Exist </div>');

            redirect(SITE_URL.'delete_tanker');
        }
        
    }
}