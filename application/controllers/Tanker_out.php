<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 /* 
 	Created By 		:	Priyanka 
 	Module 			:	Tanker Registration - Tanker In, Tanker Out
 	Created Time 	:	10th Feb 2017 11:23 AM
 	Modified Time 	:	
*/
class Tanker_out extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Tanker_out_m");
	}
    
    public function tanker_out()
    {
    	# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Vehicle Out";
		$data['nestedView']['pageTitle'] = 'Vehicle Out';
        $data['nestedView']['cur_page'] = 'tanker_out';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Vehicle Out', 'class' => 'active', 'url' => '');
       	
        $data['flag']=1;
        $this->load->view('tanker_registration/tanker_out_details',$data);
    }

    public function tanker_out_details()
    {
        //print_r($_POST); exit();
        $tanker_in = $this->input->post('tanker_in_number',TRUE);

        if($tanker_in=='')
        {
            redirect(SITE_URL.'tanker_out'); exit();
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Tanker Out Details";
        $data['nestedView']['pageTitle'] = 'Tanker Out Details';
        $data['nestedView']['cur_page'] = 'tanker_out';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Tanker Out', 'class' => '', 'url' =>SITE_URL.'tank_out');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Tanker Out', 'class' => 'active', 'url' => '');

        if($tanker_in != '')
        {
            $plant_id = $this->session->userdata('ses_plant_id');
           
            $available = $this->Tanker_out_m->get_tanker_id_rows($tanker_in,$plant_id);
            if($available==0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong> Tanker Number is Not Existed. Please Enter <strong>Valid Number !.</strong> </div>');
                redirect(SITE_URL.'tanker_out'); exit();
            }

           $results=$this->Tanker_out_m->get_tanker_id($tanker_in);
            $tanker_id=$results['tanker_id'];
            $tanker_type_id=$results['tanker_type_id'];

            if($tanker_type_id == 1)
            {
                $row = $this->Tanker_out_m->get_tanker_oil_details($tanker_id);

                $data['tanker_row']=$row[0];


                if($row[0]['status']==1)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Please go to <strong>weigh bridge for Gross</strong>.</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }

                else if($row[0]['status']==2)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Please go for <strong>Lab Test</strong>.</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }

                else if($row[0]['status']==3)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Please go to<strong>weigh bridge for tier weight</strong>.</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }
                else if($row[0]['status']==4)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Tanker Went For <strong>M.R.R. !</strong>.</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }
                else if($row[0]['status']==5)
                {                  
                    $data['flag']=2;
                }
                else if($row[0]['status']==6)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Tanker Out from Plant Unit</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }
                else if($row[0]['status']==10)
                {
                    $data['flag']=2;
                }

                $this->load->view('tanker_registration/tanker_out_details',$data);
            }
            else if($tanker_type_id==2)
            {
                $row = $this->Tanker_out_m->get_tanker_pm_details($tanker_id);

                $data['tanker_row']=$row[0];


                if($row[0]['status']==1)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Please go to <strong>weigh bridge for Gross</strong>.</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }

                else if($row[0]['status']==2)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Please go for <strong>Lab Test</strong>.</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }

                else if($row[0]['status']==3)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Please go to<strong>weigh bridge for tare weight</strong>.</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }
                else if($row[0]['status']==4)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Tanker Went For <strong>M.R.R. !</strong>.</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }
                else if($row[0]['status']==5)
                {                  
                    $data['flag']=2;
                }
                else if($row[0]['status']==6)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Tanker Out from Plant Unit</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }
                else if($row[0]['status']==10)
                {
                    $data['flag']=2;
                }

                $this->load->view('tanker_registration/tanker_out_details',$data);
            }
            else if($tanker_type_id==3)
            {
                $row = $this->Tanker_out_m->get_empty_truck_details($tanker_id);

                $data['tanker_row']=$row[0];


                if($row[0]['status']==1)
                {
                    $data['flag']=2;
                }

                else if($row[0]['status']==2)
                {
                    
                        $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        Please go for <strong>Truck UnLoading !</strong>.</div>');
                        redirect(SITE_URL.'tanker_out'); exit();

                    
                    
                }

                else if($row[0]['status']==3)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Please go to<strong>weigh bridge for Gross weight</strong>.</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }
                else if($row[0]['status']==4)
                {
                    $data['flag']=2;
                   
                }
                else if($row[0]['status']==6)
                {  
                     $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Tanker Out From Unit.</div>');
                    redirect(SITE_URL.'tanker_out'); exit();                
                    
                }
                
                $this->load->view('tanker_registration/tanker_out_details',$data);
            }
            else if($tanker_type_id==4)
            {
                //echo "4";
                redirect(SITE_URL.'tanker_out');
            }
            else if($tanker_type_id==5)
            {

                $row = $this->Tanker_out_m->get_tanker_free_gift_details($tanker_id);

                $data['tanker_row']=$row[0];

                if($row[0]['status']==1)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Please go to <strong>weigh bridge for gross</strong>.</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }

                else if($row[0]['status']==2)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Please go to <strong>weigh bridge for Tier Weight</strong>.</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }

                else if($row[0]['status']==3)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Tanker Went For <strong>M.R.R. !</strong>.</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }
                else if($row[0]['status']==4)
                {
                    $data['flag'] = 2;
                }
                else if($row[0]['status']==6)
                {                 
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Tanker Out from Plant Unit</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }

                $this->load->view('tanker_registration/tanker_out_details',$data);
            }
            else if($tanker_type_id==6)
            {

                $row = $this->Tanker_out_m->get_packed_product_details($tanker_id);

                $data['tanker_row']=$row[0];

                if($row[0]['status']==1)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Please go to <strong>Packed Products Unloading</strong>.</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }

                else if($row[0]['status']==2)
                {
                    $data['flag'] = 2;
                }
                else if($row[0]['status']==6)
                {                 
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    Tanker Out from Plant Unit</div>');
                    redirect(SITE_URL.'tanker_out'); exit();
                }

                $this->load->view('tanker_registration/tanker_out_details',$data);
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                              <strong>Error!</strong> Tanker In Number cannot be empty. Please check. </div>');
                $data['flag']=1;
                redirect(SITE_URL.'tanker_out_details'); 

            }
            
        } 
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                              <strong>Error!</strong> Tanker In Number cannot be empty. Please check. </div>');
            $data['flag']=1;
            redirect(SITE_URL.'tanker_out_details'); 
        }
    }

    public function insert_tanker_out_details()
    {
    	$tanker_in 	=	$this->input->post('tanker_in_no', TRUE);
    	$tanker_registraion_details = array(

    										'out_time'  			=>  date('Y-m-d H:i:s'),
    										'modified_by' 			=>  $this->session->userdata('user_id'),
    										'modified_time' 	 	=>  date('Y-m-d'),
    										'status'  				=>  6
    										);
    	$results =$this->Tanker_out_m->get_tanker_id($tanker_in);
        $tanker_id=$results['tanker_id'];
        $this->Common_model->update_data('tanker_register',$tanker_registraion_details,array('tanker_id'=>$tanker_id));

    	if($tanker_id != '')
	    {
	        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
	                                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	                                              <strong>Success!</strong> Tanker Out Details has been Updated successfully! Tanker Can Check Out </div>');
	        redirect(SITE_URL.'tanker_out');  
	    }
	    else
	    {
	      	$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
	                                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	                                              <strong>Error!</strong> Tanker Out has not Updated. Please check. </div>');        
	    }
        redirect(SITE_URL.'tanker_out'); 
    }

}