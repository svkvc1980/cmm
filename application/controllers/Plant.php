<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Plant extends CI_Controller{

	public function __construct() 
    {
        parent::__construct();
        $this->load->model("Common_model");
        $this->load->model("Plant_m");

    }
/*Search Plant details
Author:Srilekha
Time: 12.01PM 06-02-2017 */
	public function plant()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Plant Unit List";
		$data['nestedView']['pageTitle'] = 'Plant Unit List';
        $data['nestedView']['cur_page'] = 'plant';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Plant Unit List', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_plant', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                 'name'             => $this->input->post('plant_name', TRUE),
                 'location'         => $this->input->post('location',TRUE),
                 'block'            => $this->input->post('block',TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                   'name'             => $this->session->userdata('name'),
                   'location'         => $this->session->userdata('location'),
                   'block'            => $this->session->userdata('block')
                                    );
            }
            else {
                $search_params=array(
                     'name'          => '',
                     'location'      => '',
                     'block'         => ''
                                    );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        
        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'plant/';
        # Total Records
        $config['total_rows'] = $this->Plant_m->plant_total_num_rows($search_params);

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
        $data['plant_results'] = $this->Plant_m->plant_results($current_offset, $config['per_page'], $search_params);
        $data['block'] = $this->Common_model->get_data('block',array('status'=>1,'block_id!='=>6));
        $data['location']=$this->Common_model->get_data('location',array('status'=>1));

        
        # Additional data
        $data['display_results'] = 1;
        
        $this->load->view('plant/plant_view',$data);

    }


/*Adding Plant details
Author:Srilekha
Time: 12.10PM 06-02-2017 */
	public function add_unit()
	{
		
		# Data Array to carry the require fields to View and Model
	    $data['nestedView']['heading']="Plant Unit Selection";
	    $data['nestedView']['cur_page'] = 'plant';
	    $data['nestedView']['pageTitle'] = 'Plant Unit Selection';
	    $data['nestedView']['parent_page'] = 'master';


	    # Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/plant.js" type="text/javascript"></script>';
		$data['nestedView']['css_includes'] = array();

		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Add Plant';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Plant Unit List','class'=>'','url'=>SITE_URL.'plant');
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Plant Unit Selection','class'=>'active','url'=>'');



		# Additional data
        $data['flg'] = 1;

        $data['form_action'] = SITE_URL.'add_plant/';


        $data['display_results'] = 0;
        $data['block_data'] = $this->Plant_m->get_block_data();
    	
        $this->load->view('plant/units_list_view',$data);
	}

/*Adding Plant details
Author:Srilekha
Time: 12.10PM 06-02-2017 */
	public function add_plant()
	{
        $plant_id = $this->input->post('submit',TRUE);
		
		if($plant_id=='')
        {
            redirect(SITE_URL.'add_unit'); exit();
        }

        
        if($plant_id == 2 || $plant_id == 3)
        {
        	
        	redirect(SITE_URL.'plant_view/'.$plant_id);
        }
        else
        {
        	
        	redirect(SITE_URL.'add_cf/'.$plant_id);
        }
    }
/*Adding Plant details
Author:Srilekha
Time: 12.10PM 06-02-2017 */
    public function plant_view()
    {
		$unit_id=@$this->uri->segment(2);

        if($unit_id==''){
            redirect(SITE_URL);
            exit;
        }
        $name = $this->Common_model->get_value('block',array('block_id'=>$unit_id),'name');

		# Data Array to carry the require fields to View and Model
	    $data['nestedView']['heading']= "Add $name" ;
	    $data['nestedView']['cur_page'] = 'plant';
	    $data['nestedView']['pageTitle'] = "Add $name";
	    $data['nestedView']['parent_page'] = 'master';

        

	    # Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/plant.js" type="text/javascript"></script>';
		$data['nestedView']['css_includes'] = array();

		# Breadcrumbs
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Plant Unit List','class'=>'','url'=>SITE_URL.'plant');
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Plant Unit Selection','class'=>'','url'=>SITE_URL.'add_unit');
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>"Add $name",'class'=>'active','url'=>'');



		# Additional data
		$data['state']= $this->Common_model->get_data('location',array('level_id'=>2,'status'=>1));
        $data['flg'] = 1;

        $data['form_action'] = SITE_URL.'insert_plant/'.$unit_id;
        $data['unit_id']=$unit_id;


        $data['display_results'] = 0;
        
        $this->load->view('plant/plant_view',$data);
	}
/*Insert Plant details
Author:Srilekha
Time: 12.15PM 06-02-2017 */
	public function insert_plant()
	{
			$unit_id=$this->uri->segment(2);
			
		    // GETTING INPUT TEXT VALUES
			$data=array(
						'name'					=>	   $this->input->post('plant_name'),
						'description'			=>	   $this->input->post('description'),
						'address'				=>	   $this->input->post('address'),
						'location_id'			=>	   $this->input->post('city'),
						'created_by'			=>	   $this->session->userdata('user_id'),
						'created_time'     		=> 	   date('Y-m-d H:i:s'),
                        'short_name'            =>     $this->input->post('short_name',TRUE)
						);
		    
            $this->db->trans_begin();
			$plant = $this->Common_model->insert_data('plant',$data);

            //if stock point insert entry for counter sale in plant counter
            if($unit_id == 3)
            {
                $data_stock_point = array('plant_id' => $plant,
                                          'name'     => $this->input->post('plant_name',TRUE),
                                          'status'   => 1);
                $this->Common_model->insert_data('plant_counter',$data_stock_point);

            }
			
	        	
	        	$data=array(
						'block_id'				=>	   $unit_id,
						'plant_id'				=>	   $plant
						);
			
			$plant_block = $this->Common_model->insert_data('plant_block',$data);
			

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
                                                        <strong>Success!</strong> Unit has been added successfully! </div>');
		        }
	        
	        
	      redirect(SITE_URL.'plant');
	}

/*Edit Plant details
Author:Srilekha
Time: 01.10PM 06-02-2017 */
	public function edit_plant()
    {
        $plant_id=@cmm_decode($this->uri->segment(2));
        if($plant_id==''){
            redirect(SITE_URL);
            exit;
        }
        $block_id = $this->Common_model->get_value('plant_block',array('plant_id'=>$plant_id),'block_id');
        $name = $this->Common_model->get_value('block',array('block_id'=>$block_id),'name');
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit $name";
        $data['nestedView']['pageTitle'] = "Edit $name";
        $data['nestedView']['cur_page'] = 'plant';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/plant.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Unit List', 'class' => '', 'url' => SITE_URL.'plant');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => "Edit $name", 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_plant';
        $data['display_results'] = 0;

        # Data
        $row = $this->Common_model->get_data('plant',array('plant_id'=>$plant_id));
        $row1= $this->Common_model->get_data('plant_block',array('plant_id'=>$plant_id));
        
        $city_id = $row[0]['location_id'];

        $mandal_id = $this->Common_model->get_value('location',array('location_id'=>$city_id),'parent_id');
        $data['city_id'] = $city_id;
        //echo $city_id;exit;
        $data['city'] = $this->Common_model->get_data('location',array('parent_id'=>$mandal_id));

        $district_id = $this->Common_model->get_value('location',array('location_id'=>$mandal_id),'parent_id');
        $data['mandal_id'] = $mandal_id;
        $data['mandal'] = $this->Common_model->get_data('location',array('parent_id'=>$district_id));

        $region_id = $this->Common_model->get_value('location',array('location_id'=>$district_id),'parent_id');
        $data['district_id'] = $district_id;
        $data['district'] = $this->Common_model->get_data('location',array('parent_id'=>$region_id));

        $state_id = $this->Common_model->get_value('location',array('location_id'=>$region_id),'parent_id');
        $data['region_id'] = $region_id;
        $data['region'] = $this->Common_model->get_data('location',array('parent_id'=>$state_id));
        $data['state_id'] = $state_id;
        //echo $region_parent_id;exit;
       /* $state_parent_id = $this->Common_model->get_value('location',array('location_id'=>$region_parent_id),'parent_id');
        $data['insi'] = $region_parent_id;*/
        $data['state'] = $this->Common_model->get_data('location',array('level_id'=>2));

        /*koushik*/

        $data['plant_row'] = $row[0];
        $data['block_row'] = $row1[0];

        $data['block_data'] = $this->Common_model->get_data('block',array('status'=>1));
        
        $this->load->view('plant/plant_view',$data);
    }

/*Update Plant details
Author:Srilekha
Time: 01.37PM 06-02-2017 */
     public function update_plant()
    {
        $plant_id=@cmm_decode($this->input->post('encoded_id',TRUE));

        if($plant_id==''){
            redirect(SITE_URL);
            exit;
        }
        // GETTING INPUT TEXT VALUES
        $data = array( 
                    	'name'					=>	   $this->input->post('plant_name'),
						'description'			=>	   $this->input->post('description'),
						'address'				=>	   $this->input->post('address'),
						'location_id'			=>	   $this->input->post('city'),
						'modified_by'			=>	   $this->session->userdata('user_id'),
						'modified_time'     	=> 	   date('Y-m-d H:i:s'),
                        'short_name'            =>     $this->input->post('short_name',TRUE)
                    );
       
        $where = array('plant_id'=>$plant_id);
        $this->db->trans_begin();
        $res = $this->Common_model->update_data('plant',$data,$where);
        
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
                                                        <strong>Success!</strong> Unit  has been updated successfully! </div>');      
        }
       
        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		                            <strong>Success!</strong> Unit has been updated successfully! </div>');
		        
		        
	        

        redirect(SITE_URL.'plant');  
    }

/*Deactivate Plant details
Author:Srilekha
Time:01.19PM 06-02-2017 */
    public function deactivate_plant($encoded_id)
    {
    
        $plant_id=@cmm_decode($encoded_id);
        if($plant_id==''){
            redirect(SITE_URL);
            exit;
        }
       
            $where = array('plant_id' => $plant_id);
            //deactivating user
            $data_arr = array('status' => 2);
            $this->Common_model->update_data('plant',$data_arr, $where);
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Plant  has been De-Activated successfully!</div>');
            redirect(SITE_URL.'plant');           
        

    }

/*Insert Plant details
Author:Srilekha
Time: 01.20PM 06-02-2017 */
	public function activate_plant($encoded_id)
    {
        $plant_id=@cmm_decode($encoded_id);
        if($plant_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('plant_id' => $plant_id);
        //deactivating user
        $data_arr = array('status' => 1);
        $this->Common_model->update_data('plant',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Plant has been Activated successfully!</div>');
        redirect(SITE_URL.'plant');

    }	

/*Add C&F details
Author:Srilekha
Time: 10.21PM 07-02-2017 */
	public function add_cf()
	{
		$unit_id=$this->uri->segment(2);
		# Data Array to carry the require fields to View and Model
	    $data['nestedView']['heading']=  'Add C&F' ;
	    $data['nestedView']['cur_page'] = 'plant';
	    $data['nestedView']['pageTitle'] = 'Add C&F';
	    $data['nestedView']['parent_page'] = 'master';


	    # Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/plant.js" type="text/javascript"></script>';
		$data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/cf_form_wizard.js" type="text/javascript"></script>';
		$data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>';
		$data['nestedView']['css_includes'] = array();
		

		# Breadcrumbs
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Plant Unit List', 'class' => '', 'url' => SITE_URL.'plant'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Plant Unit Selection', 'class' => '', 'url' => SITE_URL.'add_unit');  
	    $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Add C&F','class'=>'active','url'=>'');



		# Additional data
		$data['state']= $this->Common_model->get_data('location',array('level_id'=>2,'status'=>1));
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_cf/'.$unit_id;
        $data['unit_id']=$unit_id;

        $data['bank_type'] = $this->Common_model->get_data('bank',array('status'=>1));

        $data['display_results'] = 0;
        
        $this->load->view('plant/cf_view',$data);
	}

/*Insert C&F details
Author:Srilekha
Time: 12.15PM 06-02-2017 */
	public function insert_cf()
	{
			$unit_id=@$this->uri->segment(2);
	        if($unit_id==''){
	            redirect(SITE_URL);
	            exit;
	        }
			
		    // GETTING INPUT TEXT VALUES
            // Adding plant details
			$data=array(
						'name'					=>	   $this->input->post('cf_name'),
						'description'			=>	   $this->input->post('description'),
						'address'				=>	   $this->input->post('address'),
						'location_id'			=>	   $this->input->post('city'),
						'created_by'			=>	   $this->session->userdata('user_id'),
						'created_time'     		=> 	   date('Y-m-d H:i:s'),
                        'short_name'            =>     $this->input->post('short_name',TRUE)
						);
		    $this->db->trans_begin();
			$plant = $this->Common_model->insert_data('plant',$data);

            $data_stock_point = array('plant_id' => $plant,
                                      'name'     => $this->input->post('cf_name',TRUE),
                                      'status'   => 1);

            $this->Common_model->insert_data('plant_counter',$data_stock_point);
            //Adding Plant Block details

            $data=array(
						'block_id'				=>	   $unit_id,
						'plant_id'				=>	   $plant
						);
			$plant_block = $this->Common_model->insert_data('plant_block',$data);
            // Adding C&F details
			
        	$start_date =  date('Y-m-d', strtotime($this->input->post('agr_start_date',TRUE))).' '.date('H:i:s');
        	$end_date   =  date('Y-m-d', strtotime($this->input->post('agr_exp_date',TRUE))).' '.date('H:i:s');
        	$sdamount		= $this->input->post('sd_amount',TRUE);
			$bad_symbols    = array(",");
			$sd_amount      = str_replace($bad_symbols, "", $sdamount);

        	$data=array(
					'concerned_person'		=>	   $this->input->post('concerned_person'),
					'plant_id'				=>	   $plant,
					'mobile'				=>	   $this->input->post('mobile_number'),
					'alternate_mobile'		=>	   $this->input->post('alternate_mobile_no'),
					'pincode'				=>	   $this->input->post('pin_code'),
					'vat_no'				=>	   $this->input->post('vat_no'),
					'aadhar_no'				=>	   $this->input->post('adhar_no'),
					'pan_no'				=>	   $this->input->post('pan_no'),
					'tan_no'				=>	   $this->input->post('tan_no'),
					'sd_amount'				=>	   $sd_amount,
					'agreement_start_date'	=>	   $start_date,
					'agreement_end_date'	=>	   $end_date
					);
			
			$c_and_f = $this->Common_model->insert_data('c_and_f',$data);
            // Adding C&F Agreement History
				$data=array(
								'start_date'	=>		$start_date,
								'end_date'		=>		$end_date,
								'c_and_f_id'	=>		$c_and_f
						   );
			$c_and_f_history = $this->Common_model->insert_data('c_and_f_agreement_history',$data);
			
            // Adding LOcations
			if($this->input->post('district_cf'))
			{
				for($i = 0; $i < count(@$this->input->post('district_cf',TRUE)); $i++)
				{
					$data=array(
							'location_id'	=>		$this->input->post('district_cf')[$i],
							'plant_id'		=>		$plant
						       );
					
					$plant_location = $this->Common_model->insert_data('plant_location',$data);
				}
			}
			else if($this->input->post('region_cf'))
			{
				$data=array(
							'location_id'	=>		$this->input->post('region_cf'),
							'plant_id'		=>		$plant
						       );
					$plant_location = $this->Common_model->insert_data('plant_location',$data);
			}
			else
			{
				$data=array(
							'location_id'	=>		$this->input->post('state_cf'),
							'plant_id'		=>		$plant
						       );
					$plant_location = $this->Common_model->insert_data('plant_location',$data);
			}
				
            // Adding Bank Details
				for($i = 0; $i < count(@$this->input->post('bank_type',TRUE)); $i++)
				{
					$amount			= $this->input->post('bg_amount',TRUE);
		        	$start_date  	=  date('Y-m-d', strtotime($this->input->post('start_date',TRUE)[$i])).' '.date('H:i:s');
		        	$end_date  		=  date('Y-m-d', strtotime($this->input->post('end_date',TRUE)[$i])).' '.date('H:i:s');
		        	$symbols        = array(",");
		        	$bg_amount      = str_replace($symbols, "", $amount);
		        	$data=array(
							
	                        'bank_id'				=>	   $this->input->post('bank_type')[$i],
							'c_and_f_id'			=>	   $c_and_f,
							'ifsc_code'				=>	   $this->input->post('ifsc_code')[$i],
							'account_no'			=>	   $this->input->post('account_no')[$i],
							'bg_amount'				=>	   $bg_amount[$i],
							'start_date'			=>	   $start_date,
							'end_date'				=>	   $end_date
							
							
							);
					
					$bank_details = $this->Common_model->insert_data('c_and_f_bank_gurantee',$data);
					
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
                    <strong>Success!</strong> C&F has been added successfully! </div>');
		        }
	        
	        
	      redirect(SITE_URL.'plant');
	}

/*Edit C&F details
Author:Srilekha
Time: 11.20PM 08-02-2017 */
	   public function edit_cf()
    {
        $plant_id=@cmm_decode($this->uri->segment(2));
        if($plant_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit C&F";
        $data['nestedView']['pageTitle'] = 'Edit C&F';
        $data['nestedView']['cur_page'] = 'plant';
        $data['nestedView']['parent_page'] = 'master';

        $data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/plant.js" type="text/javascript"></script>';
        $data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/cf_form_wizard.js" type="text/javascript"></script>';
        $data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Plant Unit List', 'class' => '', 'url' => SITE_URL.'plant');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit C&F', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_cf';
        $data['display_results'] = 0;

        # Data
        $row = $this->Common_model->get_data('plant',array('plant_id'=>$plant_id));
        $row1= $this->Common_model->get_data('c_and_f',array('plant_id'=>$plant_id));



        $get_location_plant = $this->Common_model->get_value('plant_location',array('plant_id'=>$plant_id,'status'=>1),'location_id');

        $get_level_id = $this->Common_model->get_value('location',array('location_id'=>$get_location_plant,'status'=>1),'level_id');
       
        if($get_level_id == 2)/*state level*/
        {
            $selected_state = $this->Common_model->get_value('plant_location',array('plant_id'=>$plant_id,'status'=>1),'location_id');
            $data['selected_state'] = $selected_state;
            $data['regionn'] = $this->Common_model->get_data('location',array('parent_id'=>$selected_state,'status'=>1));
            $data['flggg'] = 4;

        }
        else if($get_level_id == 3)/*region level*/
        {
            $selected_region = $this->Common_model->get_value('plant_location',array('plant_id'=>$plant_id,'status'=>1),'location_id');
            $data['selected_region'] = $selected_region;
            $data['districtt'] = $this->Common_model->get_data('location',array('parent_id'=>$selected_region,'status'=>1));
            $data['selected_district'] = array('0');

            $region_parent_id = $this->Common_model->get_value('location',array('location_id'=>$selected_region,'status'=>1),'parent_id');
            $data['regionn'] = $this->Common_model->get_data('location',array('parent_id'=>$region_parent_id,'status'=>1));
            $data['selected_state'] = $region_parent_id;
            $data['flgg'] = 3;


        }
        else if($get_level_id == 4)/*district level*/
        {
            $data['selected_district'] = $this->Common_model->get_data('plant_location',array('plant_id'=>$plant_id,'status'=>1));
            $get_location_plant = $this->Common_model->get_value('plant_location',array('plant_id'=>$plant_id,'status'=>1),'location_id');
            $get_district_parent_id = $this->Common_model->get_value('location',array('location_id'=>$get_location_plant,'status'=>1),'parent_id');
            $data['districtt'] = $this->Common_model->get_data('location',array('parent_id'=>$get_district_parent_id,'status'=>1));

            $data['selected_region'] = $get_district_parent_id;
            $region_parent_id = $this->Common_model->get_value('location',array('location_id'=>$get_district_parent_id,'status'=>1),'parent_id');
            $data['regionn'] = $this->Common_model->get_data('location',array('parent_id'=>$region_parent_id,'status'=>1));

            $data['selected_state'] = $region_parent_id;
            $data['flgg'] = 3;
        }
        
        $city_id = $row[0]['location_id'];

        $city_parent_id = $this->Common_model->get_value('location',array('location_id'=>$city_id),'parent_id');
        $data['city_parent_id'] = $city_id;
        $data['city'] = $this->Common_model->get_data('location',array('parent_id'=>$city_parent_id));

        $mandal_parent_id = $this->Common_model->get_value('location',array('location_id'=>$city_parent_id),'parent_id');
        $data['mandal_parent_id'] = $city_parent_id;
        $data['mandal'] = $this->Common_model->get_data('location',array('parent_id'=>$mandal_parent_id));

        $district_parent_id = $this->Common_model->get_value('location',array('location_id'=>$mandal_parent_id),'parent_id');
        $data['district_parent_id'] = $mandal_parent_id;
        $data['district'] = $this->Common_model->get_data('location',array('parent_id'=>$district_parent_id));

        $region_parent_id = $this->Common_model->get_value('location',array('location_id'=>$district_parent_id),'parent_id');
        $data['region_parent_id'] = $district_parent_id;
        $data['region'] = $this->Common_model->get_data('location',array('parent_id'=>$region_parent_id));

        $data['state_parent_id'] = $region_parent_id;
        $data['state']= $this->Common_model->get_data('location',array('level_id'=>2,'status'=>1));
        

        $data['plant_row'] = $row[0];
        $data['c_f_row'] = $row1[0];

        
        $c_f_id=$this->Common_model->get_value('c_and_f',array('plant_id'=>$plant_id),'c_and_f_id');
       
        $data['bank_details'] = $this->Common_model->get_data('c_and_f_bank_gurantee',array('c_and_f_id'=>$c_f_id));
        $data['bank_type'] = $this->Common_model->get_data('bank',array('status'=>1));
        
        
        $this->load->view('plant/cf_view',$data);
    }

/*Update C&F details
Author:Srilekha
Time: 11.17PM 08-02-2017 */
     public function update_cf()
    {
        $plant_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        //echo $plant_id; exit;
        if($plant_id==''){
            redirect(SITE_URL);
            exit;
        }

        //Updating Plant data
        // GETTING INPUT TEXT VALUES
        $data = array( 
                    	'name'					=>	   $this->input->post('cf_name'),
						'description'			=>	   $this->input->post('description'),
						'address'				=>	   $this->input->post('address'),
						'location_id'			=>	   $this->input->post('city'),
						'modified_by'			=>	   $this->session->userdata('user_id'),
						'modified_time'     	=> 	   date('Y-m-d H:i:s'),
                        'short_name'            =>     $this->input->post('short_name',TRUE)
                    );
       
        $where = array('plant_id'=>$plant_id);
        $this->db->trans_begin();
        $res = $this->Common_model->update_data('plant',$data,$where);
       // Retrieving c_and_f_id with that plant_id
        $c_f_id=$this->Common_model->get_value('c_and_f',array('plant_id'=>$plant_id),'c_and_f_id');
        // Updating c_and_f data 
        $where = array('c_and_f_id'=>$c_f_id);
        $start_date =  date('Y-m-d', strtotime($this->input->post('agr_start_date',TRUE)));
    	$end_date   =  date('Y-m-d', strtotime($this->input->post('agr_exp_date',TRUE)));
    	$sdamount		= $this->input->post('sd_amount',TRUE);
		$bad_symbols    = array(",");
		$sd_amount      = str_replace($bad_symbols, "", $sdamount);
		$data=array(
						'concerned_person'		=>	   $this->input->post('concerned_person'),
						'plant_id'				=>	   $plant_id,
						'mobile'				=>	   $this->input->post('mobile_number'),
						'alternate_mobile'		=>	   $this->input->post('alternate_mobile_no'),
						'pincode'				=>	   $this->input->post('pin_code'),
						'vat_no'				=>	   $this->input->post('vat_no'),
						'aadhar_no'				=>	   $this->input->post('adhar_no'),
						'pan_no'				=>	   $this->input->post('pan_no'),
						'tan_no'				=>	   $this->input->post('tan_no'),
						'sd_amount'				=>	   $sd_amount,
						'agreement_start_date'	=>	   $start_date,
						'agreement_end_date'	=>	   $end_date
						);
		$c_and_f = $this->Common_model->update_data('c_and_f',$data,$where);

        

        // Inserting Agreement History data
		$data=array(
								'start_date'	=>		$start_date,
								'end_date'		=>		$end_date,
								'c_and_f_id'	=>		$c_f_id,
                                'created_by'    =>      $this->session->userdata('user_id'),
                                'created_time'  =>      date('Y-m-d H:i:s')
						   );
         

		$c_and_f_history = $this->Common_model->insert_data('c_and_f_agreement_history',$data);
        
        
        @$plant_district=$this->input->post('district_cf');
        @$plant_region=$this->input->post('region_cf');
        @$plant_state=$this->input->post('state_cf');

        //Deactivating all the Locations with that plant_id
        $where = array('plant_id'=>$plant_id);
        $data = array('status'=>2);
        $this->Common_model->update_data('plant_location',$data, $where);

        // inserting updated locations
        if(@count($plant_district)>0)
            {
                //looping through departments and inserting and updating
                foreach ($plant_district as $district)
                {
                //UPDATE EXIST DEPARTMENTS AND INSERTING NEW DEPARTMENTS
                $this->Plant_m->insert_update($district,$plant_id);
                
                }
            }

			else if($plant_region)
			{
				
					$this->Plant_m->insert_update_region($plant_region,$plant_id);
			}
			else
			{
				
					$this->Plant_m->insert_update_state($plant_state,$plant_id);
			}
        // Updating bank_gurantee data
		$this->Common_model->delete_data('c_and_f_bank_gurantee',array('c_and_f_id'=>$c_f_id));
        for($i = 0; $i < count(@$this->input->post('bank_type',TRUE)); $i++)
	        {
	        	$amount			= $this->input->post('bg_amount',TRUE);
	        	$start_date  	=  date('Y-m-d', strtotime($this->input->post('start_date',TRUE)[$i])).' '.date('H:i:s');
	        	$end_date  		=  date('Y-m-d', strtotime($this->input->post('end_date',TRUE)[$i])).' '.date('H:i:s');
	        	$symbols        = array(",");
	        	$bg_amount      = str_replace($symbols, "", $amount);
	        	$data=array(
							'bank_id'				=>	   $this->input->post('bank_type')[$i],
							'c_and_f_id'			=>	   $c_f_id,
							'ifsc_code'				=>	   $this->input->post('ifsc_code')[$i],
							'account_no'			=>	   $this->input->post('account_no')[$i],
							'bg_amount'				=>	   $bg_amount[$i],
							'start_date'			=>	   $start_date,
							'end_date'				=>	   $end_date
						
						
						);
			   
				$bank_details = $this->Common_model->insert_data('c_and_f_bank_gurantee',$data);
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
                                                        <strong>Success!</strong> C&F has been updated successfully! </div>');
        }
        
        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
		                            <strong>Success!</strong> unit has been updated successfully! </div>');
		        
		        
	        

        redirect(SITE_URL.'plant');  
    }


/*Download Plant details
Author:Srilekha
Time: 4.09PM 21-01-2017 */
	public function download_plant()
    {
        if($this->input->post('download_plant')!='') {
            
           $search_params=array(
                 'name'             => $this->input->post('plant_name', TRUE),
                 'location'         => $this->input->post('location',TRUE),
                 'block'            => $this->input->post('block',TRUE)
            
                              );    
            $plant = $this->Plant_m->plant_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Plant Name','Block name','location','address');
            $data = '<table border="1">';
            $data.='<thead>';
            $data.='<tr>';
            foreach ( $titles as $title)
            {
                $data.= '<th align="center">'.$title.'</th>';
            }
            $data.='</tr>';
            $data.='</thead>';
            $data.='<tbody>';
             $j=1;
            if(count($plant)>0)
            {
                
                foreach($plant as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['name'].'</td>';                   
                    $data.='<td align="center">'.$row['block_name'].'</td>';
                    $data.='<td align="center">'.$row['location_name'].'</td>';
                    $data.='<td align="center">'.$row['address'].'</td>';                   
                    
                    $data.='</tr>';
                    $j++;
                }
            }
            else
            {
                $data.='<tr><td colspan="'.(count($titles)+1).'" align="center">No Results Found</td></tr>';
            }
            $data.='</tbody>';
            $data.='</table>';
            $time = date("Ymdhis");
            $xlFile='Plant'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }


/*Getting Region Dropdown details
Author:Srilekha
Time: 12.40PM 06-02-2017 */
    public function getregionList()
    {
        $state_id = $this->input->post('state_id',TRUE);
        echo $this->Plant_m->getregionList($state_id);
    }
/*Getting District Dropdown details
Author:Srilekha
Time: 12.41PM 06-02-2017 */
    public function getdistrictList()
    {
        $region_id = $this->input->post('region_id',TRUE);
        echo $this->Plant_m->getdistrictList($region_id);
    }
/*Getting Mandal Dropdown details
Author:Mounika
Time: 12.41PM 06-02-2017 */
    public function getmandalList()
    {
        $district_id = $this->input->post('district_id',TRUE);
        echo $this->Plant_m->getmandalList($district_id);
    }


/*Getting Area Dropdown details
Author:Srilekha
Time: 12.40PM 06-02-2017 */
    public function getareaList()
    {
        $mandal_id = $this->input->post('mandal_id',TRUE);
        echo $this->Plant_m->getareaList($mandal_id);
    }

    /*Getting Regioncf Dropdown details
Author:Srilekha
Time: 04.52PM 06-02-2017 */
    public function getregionListcf()
    {
        $state_id = $this->input->post('state_id',TRUE);
        echo $this->Plant_m->getregionList($state_id);
    }
/*Getting District Dropdown details
Author:Srilekha
Time: 03.08PM 08-02-2017 */
    public function getdistrictListcf()
    {
        $region_id = $this->input->post('region_id',TRUE);
        echo $this->Plant_m->getdistrictListcf($region_id);
    }
/*Getting Mandal Dropdown details
Author:Mounika */
    public function getmandalListcf()
    {
        $district_id = $this->input->post('district_id',TRUE);
        echo $this->Plant_m->getmandalListcf($district_id);
    }
/*Getting Area Dropdown details
Author:Mounika */
    public function getareaListcf()
    {
        $mandal_id = $this->input->post('mandal_id',TRUE);
        echo $this->Plant_m->getareaListcf($mandal_id);
    }

}