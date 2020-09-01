<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 /* 
 	Created By 		:	Priyanka 
 	Module 			:	Tanker Registration - Tanker In, Tanker Out
 	Created Time 	:	10th Feb 2017 11:23 AM
 	Modified Time 	:	
*/
class Tanker_register extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Tanker_register_m");
	}

	# Function to get tanker type page
	public function tanker_registration()
	{ 
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Vehicle In";
		$data['nestedView']['pageTitle'] = 'Vehicle In';
        $data['nestedView']['cur_page'] = 'tanker_in';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Vehicle In', 'class' => '', 'url' => '');
        $block_id = $this->session->userdata('block_id');

        # Get Tanker Type
        if($block_id == 2)
        {
            $data['tanker_type'] = $this->Common_model->get_data('tanker_type',array('status'=>1,'tanker_type_id!='=>6));
        }
        else
        {
            $data['tanker_type'] = $this->Tanker_register_m->get_tanker_type_plant(); 
        }
        

        $data['flag']=0;
        $this->load->view('tanker_registration/tanker_register',$data);
	}

	public function registration_details()
	{
        $tanker_type_id=$this->input->post('tanker_type_id');
        if($tanker_type_id=='')
        {
            redirect(SITE_URL.'tanker_registration'); exit();
        }

		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Vehicle In Details";
		$data['nestedView']['pageTitle'] = 'Vehicle In Details';
        $data['nestedView']['cur_page'] = 'tanker_in';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/tanker_in_details.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Vehicle In', 'class' => '', 'url' =>SITE_URL.'tanker_registration');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Vehicle In Details', 'class' => 'active', 'url' =>'');

        $data['tanker_type_id']=$this->input->post('tanker_type_id');
        
        $data['tanker_type_name'] = $this->Common_model->get_value('tanker_type',array('tanker_type_id'=>$tanker_type_id),'name');

        $plant_id = $this->session->userdata('ses_plant_id');
        $data['tanker_in_number'] = get_current_serial_number_tanker(array('value'=>'tanker_in_number','table'=>'tanker_register','where'=>'in_time','plant_id'=>$plant_id));

        

        # tanker type = for looseoil (1,4)
		if($tanker_type_id == 1)
		{
			$data['flag']=1;
			$data['oillist'] = $this->Common_model->get_dropdown('loose_oil', 'loose_oil_id', 'name', array('status'=>1));
        	
		}
		else if($tanker_type_id == 2)
		{
            $data['flag']=2;
            $data['packingmaterial'] = $this->Common_model->get_data('packing_material',array('status'=>1));
		}
        else if($tanker_type_id == 3)
        {
            $data['flag']=3;
            
        }
        else if($tanker_type_id == 4)
        {
            redirect(SITE_URL.'tanker_registration');
            
        }

        else if($tanker_type_id == 5)
        {
            $data['flag']=5;
            $data['freegiftlist'] = $this->Common_model->get_dropdown('free_gift', 'free_gift_id', 'name', array('status'=>1));
            
        }
        else if($tanker_type_id == 6)
        {
            $data['flag'] = 6;
            
        }
	
		$this->load->view('tanker_registration/tanker_register',$data);
		
    }

    public function insert_tanker_registration_details()
    {
        $plant_id = $this->session->userdata('ses_plant_id');
        $tanker_in_number = get_current_serial_number_tanker(array('value'=>'tanker_in_number','table'=>'tanker_register','where'=>'in_time','plant_id'=>$plant_id));
        $dc_no = $this->input->post('dc_no');
        if($dc_no == '')
        { $dc_no = NULL; }
        
    	$tanker_registraion_details = array(
                	        'tanker_type_id'  	=>  $this->input->post('tanker_type_id', TRUE),
				'tanker_in_number'  =>  $tanker_in_number,
				'vehicle_number'  	=>  $this->input->post('vehicle_no', TRUE),
				'invoice_number'  	=>  $this->input->post('invoice_no', TRUE),
				'dc_number'  		=>  $dc_no,
				'in_time'  			=>  date('Y-m-d H:i:s'),
				'created_by' 		=>  $this->session->userdata('user_id'),
				'status'  			=>  1,
                'party_name'        =>  $this->input->post('party_name',TRUE),
                'broker_name'       =>  $this->input->post('broker_name',TRUE),
                'plant_id'          =>  $plant_id);
        $this->db->trans_begin();
    	$tanker_id = $this->Common_model->insert_data('tanker_register',$tanker_registraion_details);

        
        $tanker_oil_data = array('tanker_id'   => $tanker_id,
                                 'loose_oil_id'=> $this->input->post('loose_oil_id',TRUE),
                                 'invoice_qty' => $this->input->post('invoice_qty',TRUE),
                                 'invoice_gross'  => $this->input->post('gross',TRUE),
                                 'invoice_tier'   => $this->input->post('tier',TRUE));
        $this->Common_model->insert_data('tanker_oil',$tanker_oil_data);

    	if($this->db->trans_status()===FALSE)
	    {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong> Vehicle In has not Inserted. Please check. </div>');  
	    }
	    else
	    {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Success!</strong> Vehicle In Details for Oil has been added successfully! <strong>Vehicle In Number : '.$tanker_in_number.' </strong> </div>');
	   }
       redirect(SITE_URL.'tanker_register');
    }

    public function insert_pm_registration_details()
    {
        $plant_id = $this->session->userdata('ses_plant_id');
        $tanker_in_number = get_current_serial_number_tanker(array('value'=>'tanker_in_number','table'=>'tanker_register','where'=>'in_time','plant_id'=>$plant_id));
        $pm_id = $this->input->post('pm_id');
        $pm_category_id = $this->Common_model->get_value('packing_material',array('pm_id'=>$pm_id),'pm_category_id');
        $dc_no = $this->input->post('dc_no');
         if($dc_no == '')
        { $dc_no = NULL; }
        $tanker_registraion_details = array(
                'tanker_type_id'    =>  $this->input->post('tanker_type_id', TRUE),
                'tanker_in_number'  =>  $tanker_in_number,
                'vehicle_number'    =>  $this->input->post('vehicle_no', TRUE),
                'invoice_number'    =>  $this->input->post('invoice_no', TRUE),
                'dc_number'         =>  $dc_no,
                'in_time'           =>  date('Y-m-d H:i:s'),
                'created_by'        =>  $this->session->userdata('user_id'),
                'status'            =>  1,
                'party_name'        =>  $this->input->post('party_name',TRUE),
                'plant_id'          =>  $plant_id);
        $this->db->trans_begin();
        $tanker_id = $this->Common_model->insert_data('tanker_register',$tanker_registraion_details);

        
        $tanker_pm_data = array('tanker_id'         => $tanker_id,
                                 'pm_id'            => $this->input->post('pm_id',TRUE),
                                 'invoice_quantity' => $this->input->post('invoice_qty',TRUE),
                                 'invoice_gross'    => $this->input->post('gross',TRUE),
                                 'invoice_tier'     => $this->input->post('tier',TRUE));
        $this->Common_model->insert_data('tanker_pm',$tanker_pm_data);

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>Vehicle In has not Inserted. Please check. </div>');  
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong>Vehicle In Details for Packing Material has been added successfully! <strong>Vehicle In Number : '.$tanker_in_number.' </strong> </div>');
       }
       redirect(SITE_URL.'tanker_register');
    }

/*Freegift Tanker Insertion
Author:Srilekha
Time:04:01PM 16-02-2017*/
    public function insert_freegift_tanker_details()
    {
        $plant_id = $this->session->userdata('ses_plant_id');
        $tanker_in_number = get_current_serial_number_tanker(array('value'=>'tanker_in_number','table'=>'tanker_register','where'=>'in_time','plant_id'=>$plant_id));
        $dc_no = $this->input->post('dc_no');
         if($dc_no == '')
        { $dc_no = NULL; }
        $tanker_registraion_details = array(
            'tanker_type_id'    =>  $this->input->post('tanker_type_id', TRUE),
            'tanker_in_number'  =>  $tanker_in_number,
            'vehicle_number'    =>  $this->input->post('vehicle_no', TRUE),
            'invoice_number'    =>  $this->input->post('invoice_no', TRUE),
            'dc_number'         =>  $dc_no,
            'in_time'           =>  date('Y-m-d H:i:s'),
            'created_by'        =>  $this->session->userdata('user_id'),
            'status'            =>  1,
            'party_name'        =>  $this->input->post('party_name',TRUE),
            'plant_id'          =>  $plant_id
            );
        $this->db->trans_begin();
        $tanker_id = $this->Common_model->insert_data('tanker_register',$tanker_registraion_details);

        
        $tanker_oil_data = array(
                                 'tanker_id'      => $tanker_id,
                                 'free_gift_id'   => $this->input->post('free_gift_id',TRUE),
                                 'invoice_qty'    => $this->input->post('invoice_qty',TRUE),
                                 'invoice_gross'  => $this->input->post('gross',TRUE),
                                 'invoice_tier'   => $this->input->post('tier',TRUE)
                                 );
        $this->Common_model->insert_data('tanker_fg',$tanker_oil_data);

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong> Vehicle In has not Inserted. Please check. </div>');  
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong> Vehicle In Details has been added successfully! <strong>Vehicle In Number : '.$tanker_in_number.' </strong></div>');
       }
       redirect(SITE_URL.'tanker_register');
    }

     public function insert_empty_truck_registration_details()
    {
        $plant_id = $this->session->userdata('ses_plant_id');
        $tanker_in_number = get_current_serial_number_tanker(array('value'=>'tanker_in_number','table'=>'tanker_register','where'=>'in_time','plant_id'=>$plant_id));
        $invoice_number = $this->input->post('invoice_num', TRUE);
        if($invoice_number==''){ $invoice_number = NULL;}
        $remarks1 = $this->input->post('remarks1', TRUE);
        if($remarks1==''){ $remarks1 = NULL;}

        $tanker_registraion_details = array(
                'tanker_type_id'    =>  $this->input->post('tanker_type_id', TRUE),
                'tanker_in_number'  =>  $tanker_in_number,
                'vehicle_number'    =>  $this->input->post('vehicle_no', TRUE),
                'invoice_number'    =>  $invoice_number,
                'in_time'           =>  date('Y-m-d H:i:s'),
                'created_by'        =>  $this->session->userdata('user_id'),
                'status'            =>  1,
                'party_name'        =>  $this->input->post('party_name',TRUE),
                'remarks1'          =>  $remarks1,
                'plant_id'          =>  $plant_id);
        $this->db->trans_begin();
        $tanker_id = $this->Common_model->insert_data('tanker_register',$tanker_registraion_details);

        $pp_data = array('tanker_id'     =>  $tanker_id,
                         'status'        =>  1,
                         'modified_by'   =>  $this->session->userdata('user_id'),
                         'modified_time' =>  date('Y-m-d H:i:s'));
        $this->Common_model->insert_data('tanker_pp_delivery',$pp_data);

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong> Vehicle In has not Inserted. Please check. </div>');  
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong> Vehicle In Details for Empty Truck has been added successfully! <strong>Vehicle In Number : '.$tanker_in_number.' </strong></div>');
       }
       redirect(SITE_URL.'tanker_register');
    }

    public function insert_packed_product_registration_details()
    {
        $plant_id = $this->session->userdata('ses_plant_id');
        $tanker_in_number = get_current_serial_number_tanker(array('value'=>'tanker_in_number','table'=>'tanker_register','where'=>'in_time','plant_id'=>$plant_id));
        $remarks1 = $this->input->post('remarks1', TRUE);
        if($remarks1==''){ $remarks1 = NULL;}

        $tanker_registraion_details = array(
                'tanker_type_id'    =>  $this->input->post('tanker_type_id', TRUE),
                'tanker_in_number'  =>  $tanker_in_number,
                'vehicle_number'    =>  $this->input->post('vehicle_no', TRUE),
                'in_time'           =>  date('Y-m-d H:i:s'),
                'created_by'        =>  $this->session->userdata('user_id'),
                'status'            =>  1,
                'party_name'        =>  $this->input->post('party_name',TRUE),
                'remarks1'          =>  $remarks1,
                'plant_id'          =>  $plant_id);
        $this->db->trans_begin();
        $this->Common_model->insert_data('tanker_register',$tanker_registraion_details);

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>Vehicle In has not Inserted. Please check. </div>');  
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong>Vehicle In Details for Packed Products Unloading has been added successfully!<strong>Vehicle In Number : '.$tanker_in_number.' </strong> </div>');
       }
       redirect(SITE_URL.'tanker_register');
    }

    /** Mounika Edit Tanker Details 29 Apr 2017 06:25 PM Start **/
    //Edit Tanker Details
    //Mounika
    public function edit_tanker_details()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Tanker In No";
        $data['nestedView']['pageTitle'] = 'Tanker In No';
        $data['nestedView']['cur_page'] = 'edit_tanker_details';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Tanker In No', 'class' => '', 'url' => '');
        
        
       
        $data['flag']=0;
        $this->load->view('tanker_registration/edit_tanker_details',$data);
    }

    public function edit_tanker_details_view()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Tanker In Details";
        $data['nestedView']['pageTitle'] = 'Edit Tanker In Details';
        $data['nestedView']['cur_page'] = 'edit_tanker_details';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Tanker In No', 'class' => '', 'url' =>  SITE_URL . 'edit_tanker_details');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Tanker In Details', 'class' => '', 'url' =>  '');

        $tanker_in_number=$this->input->post('tanker_in_number');
        $tanker_oils = $this->Tanker_register_m->get_tanker_in_details($tanker_in_number);
        $tanker_id=$tanker_oils['tanker_id'];
        $tanker_type_id=$tanker_oils['tanker_type_id'];
        if($tanker_id !='')
        {
          # tanker type = for looseoil (1,4)
            if($tanker_type_id == 1)
            {
                $data['flag']=1;
                $data['edit_tanker']=$this->Tanker_register_m->get_tanker_details_oil($tanker_in_number);
                //print_r($data['edit_tanker']);exit;
                $data['oillist'] = $this->Tanker_register_m->getloose_oil();
                //print_r($data['oillist']);exit;
                $this->load->view('tanker_registration/edit_tanker_details',$data);
            }
            else if($tanker_type_id == 2)
            {
                $data['flag']=2;
                $data['edit_tanker']=$this->Tanker_register_m->get_tanker_details_pm($tanker_in_number);
                //print_r($data['edit_tanker']);exit;
                $data['packingmaterial'] = $this->Tanker_register_m->get_packing_material();
                //print_r($data['packingmaterial']);exit;
                $this->load->view('tanker_registration/edit_tanker_details',$data);
            }
            else if($tanker_type_id == 3)
            {
                $data['flag']=3;
                $data['edit_tanker']=$this->Tanker_register_m->get_tanker_details_empty_truck($tanker_in_number);
                //print_r($data['edit_tanker']);exit;
                $this->load->view('tanker_registration/edit_tanker_details',$data);
            }
            /*else if($tanker_type_id == 4)
            {
                redirect(SITE_URL.'tanker_registration');
                $this->load->view('tanker_registration/edit_tanker_details',$data);
            }*/

            else if($tanker_type_id == 5)
            {
                $data['flag']=5;
                $data['edit_tanker']=$this->Tanker_register_m->get_tanker_details_fg($tanker_in_number);
                $data['freegiftlist'] = $this->Tanker_register_m->get_free_gift();
                $this->load->view('tanker_registration/edit_tanker_details',$data);
            }
           /* else if($tanker_type_id == 6)
            {
                $data['flag'] = 6;
                $this->load->view('tanker_registration/edit_tanker_details',$data);
            }*/
        }

       /* $res=$this->Tanker_register_m->get_tanker_details($tanker_in_number);
        $counts=$res[1];
        //echo $counts; exit;
        if($counts > 0)
        {  
            $data['edit_tanker']=$res[0];
            $data['flag']=1;
            $this->load->view('tanker_registration/edit_tanker_details',$data);
            //print_r($data['edit_tanker']);exit;
        }*/
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                      <strong>Error!</strong> Tanker In Number is Wrong! Please check </div>');  
             redirect(SITE_URL.'edit_tanker_details');      
        }
        
    }

    //Update Tanker Details
    //Mounika
    public function update_tanker_registration_details()
    {
        $tanker_in_number= $this->input->post('tanker_in_number');
        $tanker= $this->input->post('tanker_id');
        $dc_no = $this->input->post('dc_no');
        if($dc_no == '')
        { 
            $dc_no = NULL; 
        }
        $tanker_registraion_details = array(

                'vehicle_number'    =>  $this->input->post('vehicle_no', TRUE),
                'invoice_number'    =>  $this->input->post('invoice_no', TRUE),
                'dc_number'         =>  $dc_no,
                'party_name'        =>  $this->input->post('party_name',TRUE),
                'broker_name'       =>  $this->input->post('broker_name',TRUE),
                'modified_by'       =>  $this->session->userdata('user_id'),
                'modified_time'     =>  date('Y-m-d H:i:s')
                );
        $this->db->trans_begin();

        $tanker_id = $this->Common_model->update_data('tanker_register',$tanker_registraion_details,array('tanker_id'=>$tanker));

        //echo $this->db->last_query();exit;
        $tanker_oil_data = array('loose_oil_id'   => $this->input->post('loose_oil_id',TRUE),
                                 'invoice_qty'    => $this->input->post('invoice_qty',TRUE),
                                 'invoice_gross'  => $this->input->post('gross',TRUE),
                                 'invoice_tier'   => $this->input->post('tier',TRUE));
        $this->Common_model->update_data('tanker_oil',$tanker_oil_data,array('tanker_id' =>$tanker));
        //echo $this->db->last_query();exit;
        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong> Vehicle In has not Updated. Please check. </div>');  
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Success!</strong> Vehicle In Details for Oil has been updated successfully! <strong>Vehicle In Number : '.$tanker_in_number.' </strong> </div>');
       }
       redirect(SITE_URL.'edit_tanker_details');
    } 

    public function update_pm_registration_details()
    {
        $tanker_in_number= $this->input->post('tanker_in_number');
        $tanker= $this->input->post('tanker_id');
       // echo $tanker;exit;
        $dc_no = $this->input->post('dc_no');
        if($dc_no == '')
        { 
            $dc_no = NULL;
        }
        $tanker_registraion_details = array(
                'vehicle_number'    =>  $this->input->post('vehicle_no', TRUE),
                'invoice_number'    =>  $this->input->post('invoice_no', TRUE),
                'dc_number'         =>  $dc_no,
                'party_name'        =>  $this->input->post('party_name',TRUE),
                'modified_by'       =>  $this->session->userdata('user_id'),
                'modified_time'     =>  date('Y-m-d H:i:s')
                );
        $this->db->trans_begin();
        $tanker_id = $this->Common_model->update_data('tanker_register',$tanker_registraion_details,array('tanker_id'=>$tanker));
        //echo $this->db->last_query();exit;
        
        $tanker_pm_data = array( 'pm_id'            => $this->input->post('pm_id',TRUE),
                                 'invoice_quantity' => $this->input->post('invoice_qty',TRUE),
                                 'invoice_gross'    => $this->input->post('gross',TRUE),
                                 'invoice_tier'     => $this->input->post('tier',TRUE));
        $this->Common_model->update_data('tanker_pm',$tanker_pm_data,array('tanker_id' =>$tanker));
        //echo $this->db->last_query();exit;
        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>Vehicle In has not Updated. Please check. </div>');  
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong>Vehicle In Details for Packing Material has been updated successfully! <strong>Vehicle In Number : '.$tanker_in_number.' </strong> </div>');
       }
       redirect(SITE_URL.'edit_tanker_details');
    }

    public function update_empty_truck_registration_details()
    {
        $tanker_in_number = $this->input->post('tanker_in_number');
        $tanker = $this->input->post('tanker_id');
        $invoice_number = $this->input->post('invoice_no', TRUE);
        if($invoice_number=='')
        { 
            $invoice_number = NULL;
        }
        $remarks1 = $this->input->post('remarks1', TRUE);
        if($remarks1=='')
        {
            $remarks1 = NULL;
        }

        $tanker_registraion_details = array(
                'vehicle_number'    =>  $this->input->post('vehicle_no', TRUE),
                'invoice_number'    =>  $invoice_number,
                'party_name'        =>  $this->input->post('party_name',TRUE),
                'remarks1'          =>  $remarks1,
                'modified_by'       =>  $this->session->userdata('user_id'),
                'modified_time'     =>  date('Y-m-d H:i:s')
                );
        $this->db->trans_begin();
        $tanker_id = $this->Common_model->update_data('tanker_register',$tanker_registraion_details,array('tanker_id'=>$tanker));

        $pp_data = array(
                         'modified_by'   =>  $this->session->userdata('user_id'),
                         'modified_time' =>  date('Y-m-d H:i:s'));
        $this->Common_model->update_data('tanker_pp_delivery',$pp_data,array('tanker_id' =>$tanker));

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong> Vehicle In has not Updated. Please check. </div>');  
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong> Vehicle In Details for Empty Truck has been updated successfully! <strong>Vehicle In Number : '.$tanker_in_number.' </strong></div>');
       }
       redirect(SITE_URL.'edit_tanker_details');
    }

    public function update_freegift_tanker_details()
    {
        $tanker_in_number = $this->input->post('tanker_in_number');
        $tanker = $this->input->post('tanker_id');
        $dc_no = $this->input->post('dc_no');
        if($dc_no == '')
        {
            $dc_no = NULL;
        }
        $tanker_registraion_details = array(
            'vehicle_number'    =>  $this->input->post('vehicle_no', TRUE),
            'invoice_number'    =>  $this->input->post('invoice_no', TRUE),
            'dc_number'         =>  $dc_no,
            'party_name'        =>  $this->input->post('party_name',TRUE),
            'modified_by'       =>  $this->session->userdata('user_id'),
            'modified_time'     =>  date('Y-m-d H:i:s')
            );
        $this->db->trans_begin();
        $tanker_id = $this->Common_model->update_data('tanker_register',$tanker_registraion_details,array('tanker_id'=>$tanker));

        
        $tanker_oil_data = array(
                                 'free_gift_id'   => $this->input->post('free_gift_id',TRUE),
                                 'invoice_qty'    => $this->input->post('invoice_qty',TRUE),
                                 'invoice_gross'  => $this->input->post('gross',TRUE),
                                 'invoice_tier'   => $this->input->post('tier',TRUE)
                                 );
        $this->Common_model->update_data('tanker_fg',$tanker_oil_data,array('tanker_id' =>$tanker));

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong> Vehicle In has not Updated. Please check. </div>');  
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong> Vehicle In Details has been updated successfully! <strong>Vehicle In Number : '.$tanker_in_number.' </strong></div>');
       }
       redirect(SITE_URL.'edit_tanker_details');
    }

    /** Mounika Edit Tanker Details 29 Apr 2017 06:25 PM End **/
}