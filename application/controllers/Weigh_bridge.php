<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 /* 
    Created By      :   Nagarjuna 
    Module          :   Weighbridge
    Created Time    :   17th Feb 2017 11:08 AM
    Modified Time   :   
*/
class Weigh_bridge extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Weigh_bridge_m");
        $this->load->library('Pdf');
	}

    // Nagarjuna Weigh Bridge work
    public function weighbridge()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Weigh Bridge";
        $data['nestedView']['pageTitle'] = 'Weigh Bridge';
        $data['nestedView']['cur_page'] = 'weigh_bridge';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Weigh Bridge', 'class' => 'active', 'url' => '');
        
        $loose_oil_id=@cmm_decode($this->input->post('tanker_id',TRUE));
        $data['flag']=1;

        $data['form_action']=SITE_URL.'tanker_weight';
        $this->load->view('weigh_bridge/weighbridge_loose_oil',$data);
    }
    public function tanker_weight()
    {
      
        $tanker_in_number = $this->input->post('tanker_id');
        if($tanker_in_number=='')
        {
            redirect(SITE_URL.'weighbridge'); exit();
        }

        $plant_id = $this->session->userdata('ses_plant_id');
        $available = get_latest_tanker_registration($tanker_in_number,$plant_id);
        if($available==0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong> Tanker Number is Not Existed. Please Enter <strong>Valid Number !.</strong> </div>');
            redirect(SITE_URL.'weighbridge'); exit();

        }

        $tanker_type_id = get_latest_tanker_type($tanker_in_number,$plant_id);
        # Data Array to carry the require fields to View and Model
        if($tanker_type_id==3)
        {
            $data['nestedView']['heading']="Tare Weight";
            $data['nestedView']['pageTitle'] = 'Tare Weight';
            $bgvalue = 'Tare Weight';
        }
        else
        {
            $data['nestedView']['heading']="Gross Weight";
            $data['nestedView']['pageTitle'] = 'Gross Weight';
            $bgvalue = 'Gross Weight';
        }
        
        $data['nestedView']['cur_page'] = 'weigh_bridge';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Weigh Bridge', 'class' => '', 'url' =>SITE_URL.'weighbridge');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => "$bgvalue", 'class' => 'active', 'url' => '');
       
        $tanker_id = get_latest_tanker_id($tanker_in_number,$plant_id);
        if($tanker_type_id == 1)
        {
            $row = $this->Weigh_bridge_m->get_tanker_oil_details($tanker_id);
            $data['tanker_row']=$row[0];
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/weigh_bridge.js"></script>';

            $oil_tank_id=@cmm_encode($tanker_id);

            if($row[0]['status']==1)
            {
              $data['flag']=2;
              $data['form_action']=SITE_URL.'update_gross/'.$oil_tank_id;
            }

            else if($row[0]['status']==2)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                Please go for <strong>Lab Test</strong>.</div>');
                redirect(SITE_URL.'weighbridge'); exit;
            }

            else if($row[0]['status']==3)
            {
              $data['flag']=3;
              redirect(SITE_URL.'weigh_bridge_details/'.$oil_tank_id);
            }
            else if($row[0]['status']==4)
            {
              $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                Tanker Went to <strong>Exit Point !</strong>.</div>');
                redirect(SITE_URL.'weighbridge'); exit;
            }
             else if($row[0]['status']==6)
            {
              $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                Tanker is already Out!</strong>.</div>');
                redirect(SITE_URL.'weighbridge'); exit;
            }

            

            else if($row[0]['status']==10)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong> Lab Test Failed, Go to <strong>Tanker Out</strong>. </div>');
                redirect(SITE_URL.'weighbridge'); exit;
            }

            $this->load->view('weigh_bridge/weighbridge_loose_oil',$data); 
        }
        else if($tanker_type_id==2)
        {
            $row = $this->Weigh_bridge_m->get_tanker_pm_details($tanker_id);
            $data['tanker_row']=$row[0];
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/weigh_bridge.js"></script>';

            $oil_tank_id=@cmm_encode($tanker_id);

            if($row[0]['status']==1)
            {
              $data['flag']=2;
              $data['form_action']=SITE_URL.'update_pm_gross/'.$oil_tank_id;
            }

            else if($row[0]['status']==2)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                Please go for <strong>Packing Material Lab Test</strong>.</div>');
                redirect(SITE_URL.'weighbridge'); exit;
            }

            else if($row[0]['status']==3)
            {
              $data['flag']=3;
              redirect(SITE_URL.'pm_weigh_bridge_details/'.$oil_tank_id);
            }
            else if($row[0]['status']==4)
            {
              $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                Tanker Went to <strong>M.R.R. !</strong>.</div>');
                redirect(SITE_URL.'weighbridge'); exit;
            }
            else if($row[0]['status']==5)
            {
              $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                Tanker Went to <strong>Exit Point !</strong>.</div>');
                redirect(SITE_URL.'weighbridge'); exit;
            }
             else if($row[0]['status']==6)
            {
              $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                Tanker is already Out!</strong>.</div>');
                redirect(SITE_URL.'weighbridge'); exit;
            }

            

            else if($row[0]['status']==10)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong> Lab Test Failed, Go to <strong>Tanker Out</strong>. </div>');
                redirect(SITE_URL.'weighbridge'); exit;
            }

            $this->load->view('weigh_bridge/pm_tanker_weight_view',$data); 
        }
        else if($tanker_type_id==3)
        {
            $row = $this->Weigh_bridge_m->get_empty_truck_details($tanker_id);
            $data['tanker_row']=$row[0];

            //$empty_tank_id=@cmm_encode($tanker_id);

            if($row[0]['status']==1)
            {
              $data['flag']=2;
              $data['form_action']=SITE_URL.'update_empty_truck_tare';
            }

            else if($row[0]['status']==2)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Are You Sure? Tanker Loading is not Processed.!</strong></div>');
                redirect(SITE_URL.'empty_truck_weigh_bridge_details/'.$tanker_id.'');
            }

            else if($row[0]['status']==3)
            {
              redirect(SITE_URL.'empty_truck_weigh_bridge_details/'.$tanker_id.'');
            }
            else if($row[0]['status']==4)
            {
              $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                Move To Tanker Out</strong>.</div>');
                redirect(SITE_URL.'weighbridge'); exit;
            }
            else if($row[0]['status']==5)
            {
              $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                Tanker Out From Unit!</strong>.</div>');
                redirect(SITE_URL.'weighbridge'); exit;
            }
            else if($row[0]['status']==6)
            {
              $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                Tanker Out From Unit!</strong>.</div>');
                redirect(SITE_URL.'weighbridge'); exit;
            }
            else if($row[0]['status']==10)
            {
              $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                Tanker Out From Unit!</strong>.</div>');
                redirect(SITE_URL.'weighbridge'); exit;
            }

            $this->load->view('weigh_bridge/empty_truck_tanker_weight_view',$data); 
        }
        else if($tanker_type_id==4)
        {
           echo '4'; exit(); 
        }
        else if($tanker_type_id==5)
        {
            $row = $this->Weigh_bridge_m->get_freegift_tanker_details($tanker_id);
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/freegift_tanker.js"></script>';
            $data['tanker_row']=$row[0];

            $freegift_tank_id=@cmm_encode($tanker_id);

            if($row[0]['status']==1)
            {
              $data['flag']=2;
              $data['form_action']=SITE_URL.'update_freegift_gross/'.$freegift_tank_id;
            }

            else if($row[0]['status']==2)
            {
                $data['flag']=3;
              $data['form_action']=SITE_URL.'update_freegift_tier/'.$freegift_tank_id;
            }
            else if($row[0]['status']==3)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Success!</strong>Tanker Went To MRR. </div>');
                redirect(SITE_URL.'weighbridge'); exit;

            }
            else if($row[0]['status']==4)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Success!</strong>Tanker went to Exit Point</strong>. </div>');
                redirect(SITE_URL.'weighbridge'); exit;

            }
            else if($row[0]['status']==5)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Success!</strong>Tanker Out</strong>. </div>');
                redirect(SITE_URL.'weighbridge'); exit;

            }
             else if($row[0]['status']==6)
            {
              $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                Tanker Out!</strong>.</div>');
                redirect(SITE_URL.'weighbridge'); exit;
            }
            else 
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong>Check Tanker register Number</strong>. </div>');
                redirect(SITE_URL.'weighbridge'); exit;

            }
            $this->load->view('weigh_bridge/freegift_tanker_weight_view',$data);
        }
        
        
    }

    public function weigh_bridge_details()
    {
        $tanker_id=@cmm_decode($this->uri->segment(2));
        if($tanker_id=='')
        {
            redirect(SITE_URL.'weighbridge'); exit();
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Tare Weight";
        $data['nestedView']['pageTitle'] = 'Tare Weight';
        $data['nestedView']['cur_page'] = 'weigh_bridge';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/weigh_bridge.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Weigh Bridge', 'class' => '', 'url' =>SITE_URL.'weighbridge');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Tare Weight', 'class' => 'active', 'url' =>'');
       
        $data['flag']=3;
        $data['loose_oil'] = $this->Common_model->get_data('loose_oil',array('status'=>1));
        
        
        $row = $this->Weigh_bridge_m->get_tanker_oil_details($tanker_id);
        
        $data['tanker_row']=$row[0];

        $oil_tank_id=@cmm_encode($tanker_id);
        
        $data['form_action']=SITE_URL.'update_tier/'.$oil_tank_id;
        $this->load->view('weigh_bridge/weighbridge_loose_oil',$data);
    }

    public function update_gross()
    {
        $tanker_id=@cmm_decode($this->uri->segment(2));
        if($tanker_id=='')
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>'); 
            redirect(SITE_URL.'weighbridge'); exit();
        }
        
        $where= array('tanker_id'=>$tanker_id);
        $data=array('gross' =>  $this->input->post('gross'),
        	    'gross_time' => date('Y-m-d H:i:s'));
        $this->db->trans_begin();
        $tanker_oil= $this->Common_model->update_data('tanker_oil',$data,$where);

        $data=array('status' => 2);
        $tanker_register= $this->Common_model->update_data('tanker_register',$data,$where);

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>');

        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong> Gross Details has recorded successfully! Move to Lab Test.</div>');
        }
        redirect(SITE_URL.'weighbridge');
    }

    public function update_tier()
    {
        $tanker_id=@cmm_decode($this->uri->segment(2));
        if($tanker_id=='')
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>'); 
            redirect(SITE_URL.'weighbridge'); exit();
        }
        
        $where= array('tanker_id'=>$tanker_id);
        $data=array('tier' =>  $this->input->post('tier'),
        'tare_time' => date('Y-m-d H:i:s') );

        $this->db->trans_begin();
        $tanker_oil= $this->Common_model->update_data('tanker_oil',$data,$where);

        $data=array('status' => 4);
        $tanker_register= $this->Common_model->update_data('tanker_register',$data,$where);

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>');

        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong> Tare Details has recorded successfully! Move to Tanker Out.</div>');
        }
        redirect(SITE_URL.'weighbridge');
    }

    /*Free gift  weigh Bridge details
Author:Srilekha
Time: 04.55PM 17-02-2017 */
    public function freegift_weigh_bridge_details()
    {
        $tanker_id=@cmm_decode($this->uri->segment(2));
        if($tanker_id=='')
        {
            redirect(SITE_URL.'weighbridge'); exit();
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Tier Weight";
        $data['nestedView']['pageTitle'] = 'Tier Weight';
        $data['nestedView']['cur_page'] = 'weigh_bridge';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/freegift_tanker.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Weigh Bridge', 'class' => '', 'url' =>SITE_URL.'weighbridge');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Tier Weight', 'class' => 'active', 'url' =>'');
       
        $data['flag']=3;
        $data['loose_oil'] = $this->Common_model->get_data('loose_oil',array('status'=>1));
        
        
        $row = $this->Weigh_bridge_m->get_freegift_tanker_details($tanker_id);
        
        $data['tanker_row']=$row[0];

        $oil_tank_id=@cmm_encode($tanker_id);
        
        $data['form_action']=SITE_URL.'update_freegift_tier/'.$oil_tank_id;
        $this->load->view('tanker_registration/weighbridge_view',$data);
    }
/*Free gift  Gross details updating
Author:Srilekha
Time: 05.10PM 17-02-2017 */
    public function update_freegift_gross()
    {
        $tanker_id=@cmm_decode($this->uri->segment(2));
        if($tanker_id=='')
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>'); 
            redirect(SITE_URL.'freegift_weighbridge'); exit();
        }
        
        $where= array('tanker_id'=>$tanker_id);
        $data=array('gross' =>  $this->input->post('freegift_gross'),
        'gross_time' => date('Y-m-d H:i:s') );
        $this->db->trans_begin();
        $freegift_tanker= $this->Common_model->update_data('tanker_fg',$data,$where);

        $data=array('status' => 2);
        $tanker_register= $this->Common_model->update_data('tanker_register',$data,$where);

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>');

        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong> Gross Details has recorded successfully! Move to Free Gift Unload.</div>');
        }
        redirect(SITE_URL.'weighbridge');
    }
/*Free gift  Tier details updating
Author:Srilekha
Time: 05.15PM 17-02-2017 */
    public function update_freegift_tier()
    {
        $tanker_id=@cmm_decode($this->uri->segment(2));
        if($tanker_id=='')
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>'); 
            redirect(SITE_URL.'weighbridge'); exit();
        }
        
        $where= array('tanker_id'=>$tanker_id);
        $data=array('tier' =>  $this->input->post('freegift_tier'),
        'tare_time' => date('Y-m-d H:i:s') );

        $this->db->trans_begin();
        $freegift_tanker= $this->Common_model->update_data('tanker_fg',$data,$where);

        $data=array('status' => 3);
        $tanker_register= $this->Common_model->update_data('tanker_register',$data,$where);

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>');

        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong> Tare Details has recorded successfully! Move to MRR Generation.</div>');
        }
        redirect(SITE_URL.'weighbridge');
    }

    //pm - koushik
    public function pm_weigh_bridge_details()
    {
        $tanker_id=@cmm_decode($this->uri->segment(2));
        if($tanker_id=='')
        {
            redirect(SITE_URL.'weighbridge'); exit();
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Tier Weight";
        $data['nestedView']['pageTitle'] = 'Tier Weight';
        $data['nestedView']['cur_page'] = 'weigh_bridge';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/weigh_bridge.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Weigh Bridge', 'class' => '', 'url' =>SITE_URL.'weighbridge');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Tier Weight', 'class' => 'active', 'url' =>'');
       
        $data['flag']=3;
        //$data['loose_oil'] = $this->Common_model->get_data('loose_oil',array('status'=>1));
        
        
        $row = $this->Weigh_bridge_m->get_tanker_pm_details($tanker_id);
        
        $data['tanker_row']=$row[0];

        $oil_tank_id=@cmm_encode($tanker_id);
        
        $data['form_action']=SITE_URL.'update_pm_tier/'.$oil_tank_id;
        $this->load->view('weigh_bridge/pm_tanker_weight_view',$data);
    }

    public function update_pm_gross()
    {
        $tanker_id=@cmm_decode($this->uri->segment(2));
        if($tanker_id=='')
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>'); 
            redirect(SITE_URL.'weighbridge'); exit();
        }
        $pm_id = $this->Common_model->get_value('tanker_pm',array('tanker_id'=>$tanker_id),'pm_id');
        $pm_category_id = $this->Common_model->get_value('packing_material',array('pm_id'=>$pm_id),'pm_category_id');
        
        if($pm_category_id == 8)
        {
            $status = 3;
        }
        else
        {
            $status = 2;
        }
        
        $where= array('tanker_id'=>$tanker_id);
        $data=array('gross' =>  $this->input->post('gross'),
        'gross_time' => date('Y-m-d H:i:s') );
        $this->db->trans_begin();
        $tanker_oil= $this->Common_model->update_data('tanker_pm',$data,$where);

        $data=array('status' => $status);
        $tanker_register= $this->Common_model->update_data('tanker_register',$data,$where);

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>');

        }
        else
        {
            $this->db->trans_commit();
            if($status == 2)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Success!</strong> Gross Details has recorded successfully! Move to Lab Test.</div>');
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Success!</strong> Go for Packing Material Unloading and come back for <strong>Tare weight</strong></div>');

            }
        }
        redirect(SITE_URL.'weighbridge');
    }

    public function update_pm_tier()
    {
        $tanker_id=@cmm_decode($this->uri->segment(2));

        if($tanker_id=='')
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>'); 
            redirect(SITE_URL.'weighbridge'); exit();
        }
        
        $where= array('tanker_id'=>$tanker_id);
        $data=array('tier' =>  $this->input->post('tier'),
        'tare_time' => date('Y-m-d H:i:s') );
        
        $this->db->trans_begin();
        $tanker_oil= $this->Common_model->update_data('tanker_pm',$data,$where);

        $data=array('status' => 4);
        $tanker_register= $this->Common_model->update_data('tanker_register',$data,$where);

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>');

        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong> Tare Details has recorded successfully! Move for MRR.</div>');
        }
        redirect(SITE_URL.'weighbridge');
    }

    public function update_empty_truck_tare()
    {
        $tanker_pp_delivery_id = $this->input->post('tanker_id',TRUE);
        if($tanker_pp_delivery_id=='')
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>'); 
            redirect(SITE_URL.'weighbridge'); exit();
        }

        $tanker_id = $this->Common_model->get_value('tanker_pp_delivery',array('tanker_pp_delivery_id'=>$tanker_pp_delivery_id),'tanker_id');
        $remarks = $this->input->post('remarks',TRUE);
        if($remarks=='') { $remarks = NULL; }

        $where= array('tanker_pp_delivery_id'=>$tanker_pp_delivery_id);
        $data=array('tier' =>  $this->input->post('tare'),
        	    'tare_time' => date('Y-m-d H:i:s'),
                    'remarks'  => $remarks,
                    'modified_by' => $this->session->userdata('user_id'),
                    'modified_time' => date('Y-m-d H:i:s') );
        $this->db->trans_begin();
        $this->Common_model->update_data('tanker_pp_delivery',$data,$where);


        $where1 = array('tanker_id'=>$tanker_id);
        $data1 = array('status' => 2);
        $tanker_register= $this->Common_model->update_data('tanker_register',$data1,$where1);

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>');

        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong> Tare Details has recorded successfully! Move to Truck Loading!.</div>');
        }
        redirect(SITE_URL.'weighbridge');
    }
     public function empty_truck_weigh_bridge_details()
    {
        $tanker_id = $this->uri->segment(2);
        if($tanker_id=='')
        {
            redirect(SITE_URL.'weighbridge'); exit();
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Gross Weight";
        $data['nestedView']['pageTitle'] = 'Gross Weight';
        $data['nestedView']['cur_page'] = 'weigh_bridge';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Weigh Bridge', 'class' => '', 'url' =>SITE_URL.'weighbridge');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Gross Weight', 'class' => 'active', 'url' =>'');
       
        $data['flag']=3;
        $row = $this->Weigh_bridge_m->get_empty_truck_details($tanker_id);
        $data['tanker_row']=$row[0];
        $data['form_action']=SITE_URL.'update_empty_truck_gross';
        $this->load->view('weigh_bridge/empty_truck_tanker_weight_view',$data);
    }

    public function update_empty_truck_gross()
    {
        $tanker_pp_delivery_id = $this->input->post('tanker_id',TRUE);
        if($tanker_pp_delivery_id=='')
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>'); 
            redirect(SITE_URL.'weighbridge'); exit();
        }

        $tanker_id = $this->Common_model->get_value('tanker_pp_delivery',array('tanker_pp_delivery_id'=>$tanker_pp_delivery_id),'tanker_id');
        $remarks = $this->input->post('remarks1',TRUE);
        if($remarks=='') { $remarks = NULL; }

        $where= array('tanker_pp_delivery_id'=>$tanker_pp_delivery_id);
        $data=array('gross' =>  $this->input->post('gross'),
        	    'gross_time' => date('Y-m-d H:i:s'),
                    'remarks'  => $remarks,
                    'modified_by' => $this->session->userdata('user_id'),
                    'modified_time' => date('Y-m-d H:i:s') );
        $this->db->trans_begin();
        $this->Common_model->update_data('tanker_pp_delivery',$data,$where);


        $where1 = array('tanker_id'=>$tanker_id);
        $data1 = array('status' => 4);
        $tanker_register= $this->Common_model->update_data('tanker_register',$data1,$where1);

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>SomeThing Went Wrong. Please Check! </div>');

        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong> Gross Details has recorded successfully! Move to Tanker Out !.</div>');
        }
        redirect(SITE_URL.'weighbridge');
    }

    public function weigh_bridge_list()
    {
        $data['nestedView']['heading']="Weigh Bridge List";
        $data['nestedView']['pageTitle'] = 'Weigh Bridge List';
        $data['nestedView']['cur_page'] = 'weigh_bridge_r';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Weigh Bridge', 'class' => '', 'url' =>SITE_URL.'weighbridge');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Weigh Bridge List', 'class' => 'active', 'url' =>'');

        # Search Functionality
        $p_search=$this->input->post('serach_wb_list', TRUE);
        	
        if($p_search!='') 
        { 
        	$from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
        	$to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 
            $search_params=array(
                    'tanker_type'   => $this->input->post('tanker_type', TRUE),
                    'from_date'     => $from_date,
                    'to_date'       => $to_date,
                    'tanker_no'     => $this->input->post('tanker_no', TRUE),
                    'loose_oil'     => $this->input->post('loose_oil', TRUE),
                    'vehicle_no'    => $this->input->post('vehicle_no', TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'tanker_type'   => $this->session->userdata('tanker_type'),
                    'from_date'     => $this->session->userdata('from_date'),
                    'to_date'       => $this->session->userdata('to_date'),
                    'tanker_no'     => $this->session->userdata('tanker_no'),
                    'loose_oil'     => $this->session->userdata('loose_oil'),
                    'vehicle_no'    => $this->session->userdata('vehicle_no')
                    
                                  );
            }
            else {
                $search_params=array(
                    'tanker_type'    => '',
                    'from_date'      => '',
                    'to_date'        => '',
                    'tanker_no'      => '',
                    'loose_oil'      => '',
                    'vehicle_no'     => ''
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;

        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'weigh_bridge_list/';
        # Total Records
        $config['total_rows'] = $this->Weigh_bridge_m->weigh_bridge_list_num_rows($search_params);

        $config['per_page'] = getDefaultPerPageRecords();
        $data['total_rows'] = $config['total_rows'];
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        $current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        if ($data['pagination_links'] != '') {
            $data['last'] = $this->pagination->cur_page * $config['per_page'];
            if ($data['last'] > $data['total_rows']) {
                $data['last'] = $data['total_rows'];
            }
            $data['pagermessage'] = 'Showing ' . ((($this->pagination->cur_page - 1) * $config['per_page']) + 1) . ' to ' . ($data['last']) . ' of ' . $data['total_rows'];
        }
        $data['sn'] = $current_offset + 1;
        /* pagination end */

        # Loading the data array to send to View
        $data['weigh_bridge_list'] = $this->Weigh_bridge_m->get_weigh_bridge_list($current_offset, $config['per_page'], $search_params);
        $data['tanker_type'] = array(''=>'Select Tanker Type')+$this->Common_model->get_dropdown('tanker_type','tanker_type_id','name',array('status' => 1));
        $data['loose_oil'] = array(''=>'Select Loose Oil')+$this->Common_model->get_dropdown('loose_oil','loose_oil_id','name',array('status' => 1));
        # Additional data
        $data['display_results'] = 1;

        $this->load->view('weigh_bridge/weigh_bridge_list', $data);
    }

    public function view_weigh_bridge_list()
    {
        $tanker_id = @cmm_decode($this->uri->segment(2));
        if($tanker_id=='')
        {
            redirect(SITE_URL.'weigh_bridge_list'); exit();
        }
        $data['nestedView']['heading']="Weigh Bridge Report";
        $data['nestedView']['pageTitle'] = 'Weigh Bridge Report';
        $data['nestedView']['cur_page'] = 'weigh_bridge_r';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Weigh Bridge Report', 'class' => 'active', 'url' =>'');

        $data['view_list'] = $this->Weigh_bridge_m->get_weigh_bridge_list_by_tanker_id($tanker_id);
        $this->load->view('weigh_bridge/view_weigh_bridge_list', $data);
    }

    public function download_weigh_bridge_list()
    {
        $tanker_id = @cmm_decode($this->uri->segment(2));
        if($tanker_id=='')
        {
            redirect(SITE_URL.'weigh_bridge_list'); exit();
        }
        $data['plant_name'] = $this->session->userdata('plant_name');
        $tanker_type = $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id),'tanker_type_id');
        if($tanker_type == 1)
        {
            $data['view_list'] = $this->Weigh_bridge_m->get_weigh_bridge_loose_oil($tanker_id);
            $this->load->view('weigh_bridge/download_weigh_bridge_list',$data);
        }
        if($tanker_type == 2)
        {
            $data['view_list'] = $this->Weigh_bridge_m->get_weigh_bridge_packing_material($tanker_id); 
            $this->load->view('weigh_bridge/download_weigh_bridge_pm_list',$data);
        }
        if($tanker_type == 3)
        {
            $data['view_list'] = $this->Weigh_bridge_m->get_weigh_bridge_empty_truck($tanker_id);
            $invoice_id_arr = $data['view_list'][0]['invoice_ids'];
            if($invoice_id_arr!='')
            {
            	$single_invoice_id = $data['view_list'][0]['single'];
                $data['party_name'] = $this->Weigh_bridge_m->get_party_name($single_invoice_id);
                $invoice =explode(',', $invoice_id_arr);
                $total_weight = 0;
                foreach ($invoice as $key => $value) 
                {
                    $inv_products = $this->Weigh_bridge_m->get_invoice_products($value);
                    $sum_of_qty = 0;
                    $t_pm_weight = 0;
                    $t_gross = 0;
                    foreach($inv_products as $keys =>$values)
                    { 
                        $sum_of_qty = $sum_of_qty + $values['qty_in_kg'];
                        $t_pm_weight = $t_pm_weight + $values['pm_weight'];
                        $t_gross = $sum_of_qty + $t_pm_weight ; 
                    }
                    $total_weight+=$t_gross; 
                }
            }
            else
            {
                $total_weight = '';
            }
            $data['total_weight'] = $total_weight;
            $this->load->view('weigh_bridge/download_weigh_bridge_empty_truck_list',$data);
        }
        if($tanker_type == 5)
        {
            $data['view_list'] = $this->Weigh_bridge_m->get_weigh_bridge_free_gifts($tanker_id);
            $this->load->view('weigh_bridge/download_weigh_bridge_fg_list',$data);
        }
        
    }


}