<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Distributor extends CI_Controller{

	public function __construct() 
    {
        parent::__construct();
        $this->load->model("Common_model");
        $this->load->model("Distributor_m");

    }

/*Search Distributor details
Author:Srilekha
Time: 3.22PM 21-01-2017 */
public function distributor()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor List";
		    $data['nestedView']['pageTitle'] = 'Distributor List';
        $data['nestedView']['cur_page'] = 'distributor_list';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor List', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_distributor', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'distributor_code' => $this->input->post('distributor_code', TRUE),
                'agency_name'      => $this->input->post('agency_name', TRUE),
                'type_id'          => $this->input->post('type_id', TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'distributor_code'   => $this->session->userdata('distributor_code'),
                    'agency_name'        => $this->session->userdata('agency_name'),
                    'type_id'            => $this->session->userdata('type_id')
                    
                                  );
            }
            else {
                $search_params=array(
                      'distributor_code'    => '',
                      'agency_name'         => '',
                      'type_id'             => ''
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'distributor/';
        # Total Records
        $config['total_rows'] = $this->Distributor_m->distributor_total_num_rows($search_params);

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
        $data['distributor_results'] = $this->Distributor_m->distributor_results($current_offset, $config['per_page'], $search_params);

        # Additional data
        $data['display_results'] = 1;
        $data['typelist'] = $this->Common_model->get_data('distributor_type',array('status'=>1));
        
        $this->load->view('distributor/distributor_view',$data);

    }
    public function distributor_selection()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor Selection";
        $data['nestedView']['pageTitle'] = 'Distributor Selection';
        $data['nestedView']['cur_page'] = 'distributor';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/form-validation.min.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor List', 'class' => '', 'url' =>SITE_URL.'distributor');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor Selection', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 3;
        $data['form_action'] = SITE_URL.'add_distributor';
        $data['displayResults'] = 0;

        $this->load->view('distributor/distributor_view',$data);

    }


/*Adding Distributor details
Author:Srilekha
Time: 4.50PM 19-01-2017 */
	public function add_distributor()
	{
        $type_id=@cmm_decode($this->uri->segment(2));
        if($type_id=='')
        {
            redirect(SITE_URL.'distributor_selection');
        }
        $dis_name = $this->Common_model->get_value('distributor_type',array('type_id'=>$type_id),'name');
		# Data Array to carry the require fields to View and Model
	    $data['nestedView']['heading']="Add $dis_name";
        $data['nestedView']['pageTitle'] = "Add $dis_name";
	    $data['nestedView']['cur_page'] = 'distributor';
	    $data['nestedView']['parent_page'] = 'master';


	    # Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/distributor.js" type="text/javascript"></script>';
		$data['nestedView']['css_includes'] = array();

		# Breadcrumbs
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Distributor List','class'=>'','url'=>SITE_URL.'distributor');
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Distributor Selection','class'=>'','url'=>SITE_URL.'distributor_selection');
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>"Add $dis_name",'class'=>'active','url'=>'');



		# Additional data
		$data['state']= $this->Common_model->get_data('location',array('level_id'=>2,'status'=>1));
        $data['type_id'] = $type_id;
        $data['type_name'] = $dis_name;
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_distributor';
        $data['display_results'] = 0;
        $data['distributor_type'] = $this->Common_model->get_data('sub_type',array('status'=>1));
    	$data['bank'] = $this->Common_model->get_data('bank',array('status'=>1));
    	$data['executive_list'] = $this->Common_model->get_data('executive',array());
    	
        if($type_id==2)
        {
            $agent_id = 5;
            $data['agentlist'] = $this->Distributor_m->get_agent_list($agent_id);
        }
        else if($type_id == 4)
        {
            $agent_id = 6;
            $data['agentlist'] = $this->Distributor_m->get_agent_list($agent_id);
        }
    	
        $this->load->view('distributor/distributor_view',$data);
	}

/*Insert Distributor details
Author:Srilekha
Time: 3.40PM 21-01-2017 */
	public function insert_distributor()
	{
        $type_id = $this->input->post('type_id',TRUE);
        if($type_id=='')
        {
            redirect(SITE_URL.'distributor_selection');
            exit();
        }
 	    $location_id = $this->input->post('location_id',TRUE);
      $mandal_id = $this->input->post('mandal',TRUE);
      if($mandal_id=='')
        { 
          $location_id = NULL;
        }
        else
        {
            if($location_id =='')
            {
              $location_id = $mandal_id;
            }
            else
            {
              $location_id = $location_id;
            }
        }
      
              
        //$level_id6 = $this->Common_model->get_value('location',array('location_id'=>$location_id),'level_id');
        //$level_id5 = $this->Common_model->get_value('location',array('location_id'=>$mandal_id),'level_id');
        //echo $location_id;exit;
        $address = $this->input->post('address',TRUE);
              if($address==''){ $address = NULL;}

        $sdamount       = $this->input->post('sd_amount',TRUE);
        $bad_symbols    = array(",");
        $sd_amount      = str_replace($bad_symbols, "", $sdamount);

        $mktg_exe_code = $this->input->post('mktg_exe_code',TRUE);
                if($mktg_exe_code==''){ $mktg_exe_code = NULL;}

        $pincode = $this->input->post('pincode',TRUE);
                if($pincode==''){ $pincode = NULL;}

        $alternate_mobile = $this->input->post('alternate_mobile',TRUE);
                if($alternate_mobile==''){ $alternate_mobile = NULL;}

        $marriage_date = $this->input->post('marriage_date',TRUE);
                if($marriage_date==''){ $marriage_date = NULL;}
                else{$marriage_date = date('Y-m-d', strtotime($this->input->post('marriage_date',TRUE)));}

        $date_of_birth = $this->input->post('date_of_birth',TRUE);
                if($date_of_birth==''){ $date_of_birth = NULL;}
                else{ $date_of_birth = date('Y-m-d', strtotime($this->input->post('date_of_birth',TRUE)));}

        $agreement_start_date = $this->input->post('agreement_start_date',TRUE);
                if($agreement_start_date==''){ $agreement_start_date = '0000-00-00';}
                else{$agreement_start_date = date('Y-m-d', strtotime($this->input->post('agreement_start_date',TRUE)));}

        $agreement_end_date = $this->input->post('agreement_end_date',TRUE);
                if($agreement_end_date==''){ $agreement_end_date = '0000-00-00';}
                else{$agreement_end_date = date('Y-m-d', strtotime($this->input->post('agreement_end_date',TRUE)));}
            //echo $agreement_start_date.'-->'.$agreement_end_date; exit;
        if($type_id==2 || $type_id==4)
        {
            $user_id = 0;
            $username = $this->input->post('user_name','TRUE');
            $get_user_unique = $this->Distributor_m->check_user_availability($username,$user_id);
            if($get_user_unique==0)
            {
                $user_data = array('username'       =>  $username,
                                   'password'       =>  md5('abc'),
                                   'plant_id'       =>  1,
                                   'block_id'       =>  5,
                                   'designation_id' =>  11,
                                   'name'           =>  $this->input->post('concerned_person',TRUE),
                                   'mobile'         =>  $this->input->post('mobile',TRUE),
                                   'email'          =>  $this->input->post('email',TRUE),
                                   'address'        =>  $address,
                                   'status'         =>  1,
                                   'created_by'     =>  $this->session->userdata('user_id'),
                                   'created_time'   =>  date('Y-m-d H:i:s')
                                   );
                $this->db->trans_begin();
                $user_id = $this->Common_model->insert_data('user',$user_data);

                $distributor_data = array('user_id'          =>   $user_id,
                                          'type_id'          =>   $type_id,
                                          'distributor_code' =>   $this->input->post('distributor_code',TRUE),
                                          'agency_name'      =>   $this->input->post('agency_name',TRUE),
                                          'concerned_person' =>   $this->input->post('concerned_person',TRUE),
                                          'address'          =>   $address,
                                          'location_id'      =>   $location_id,
                                          'pincode'          =>   $pincode,
                                          'mobile'           =>   $this->input->post('mobile',TRUE),
                                          'landline'         =>   $this->input->post('landline',TRUE),
                                          'alternate_mobile' =>   $alternate_mobile,
                                          'agent_id'         =>   $this->input->post('agent_id',TRUE),
                                          'distributor_place'=>   $this->input->post('distributor_place')
                                         );
                $distributor_id = $this->Common_model->insert_data('distributor',$distributor_data);

                if($this->db->trans_status() === FALSE)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Error!</strong> Something went wrong. Please check. </div>');

                }
                else
                {
                    $this->db->trans_commit(); 
                    $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Success!</strong>Distributor has been added successfully! </div>');
                }
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Error!</strong> UserName Already Exist. Please check. </div>'); 
                redirect(SITE_URL.'distributor_selection'); exit();
            }
        }
        else
        {

            $username = $this->input->post('user_name','TRUE');
            $get_user_unique = $this->Distributor_m->check_user_availability($username,$user_id);
            if($get_user_unique==0)
            {
                $user_data = array('username'       =>  $username,
                                   'password'       =>  md5('abc'),
                                   'plant_id'       =>  1,
                                   'block_id'       =>  5,
                                   'designation_id' =>  11,
                                   'name'           =>  $this->input->post('concerned_person',TRUE),
                                   'mobile'         =>  $this->input->post('mobile',TRUE),
                                   'email'          =>  $this->input->post('email',TRUE),
                                   'address'        =>  $address,
                                   'status'         =>  1,
                                   'created_by'     =>  $this->session->userdata('user_id'),
                                   'created_time'   =>  date('Y-m-d H:i:s')
                                   );
                $this->db->trans_begin();
                $user_id = $this->Common_model->insert_data('user',$user_data);

                $distributor_data = array('user_id'          =>   $user_id,
                                          'type_id'          =>   $type_id,
                                          'distributor_code' =>   $this->input->post('distributor_code',TRUE),
                                          'agency_name'      =>   $this->input->post('agency_name',TRUE),
                                          'concerned_person' =>   $this->input->post('concerned_person',TRUE),
                                          'address'          =>   $address,
                                          'location_id'      =>   $location_id,
                                          'pincode'          =>   $pincode,
                                          'mobile'           =>   $this->input->post('mobile',TRUE),
                                          'landline'         =>   $this->input->post('landline',TRUE),
                                          'alternate_mobile' =>   $alternate_mobile,
                                          'vat_no'           =>   $this->input->post('vat_no',TRUE),
                                          'aadhar_no'        =>   $this->input->post('aadhar_no',TRUE),
                                          'pan_no'           =>   $this->input->post('pan_no',TRUE),
                                          'tan_no'           =>   $this->input->post('tan_no',TRUE),
                                          'date_of_birth'    =>   $date_of_birth,
                                          'marriage_date'    =>   $marriage_date,
                                          'executive_id'    =>    $this->input->post('executive_id'),
                                          'sd_amount'        =>   $sd_amount,
                                          'agreement_start_date' => $agreement_start_date,
                                          'agreement_end_date'   => $agreement_end_date,
                                          'outstanding_amount'   => $this->input->post('outstanding_amount'),
                                          'distributor_place'=>   $this->input->post('distributor_place')
                                         );
                $distributor_id = $this->Common_model->insert_data('distributor',$distributor_data);

                if($sd_amount>0)
                {
                  // Insert SD Amount history
                  $sd_amount_history_data = array('distributor_id' => $distributor_id,
                                                  'sd_amount'      => $sd_amount,
                                                  'start_date'     => date('Y-m-d'),
                                                  'end_date'       => NULL,
                                                  'created_by'     => $this->session->userdata('user_id'),
                                                  'created_time'   => date('Y-m-d H:i:s')
                                                 );
                  $this->Common_model->insert_data('dist_sd_amount_history',$sd_amount_history_data);
                }
                // Insert agreement history
                $agreement_history_data = array('distributor_id' => $distributor_id,
                                                'start_date'     => $agreement_start_date,
                                                'end_date'       => $agreement_end_date,
                                                'created_by'     => $this->session->userdata('user_id'),
                                                'created_time'   => date('Y-m-d H:i:s')
                                               );
                $this->Common_model->insert_data('distributor_agreement_history',$agreement_history_data);
                print_r($this->input->post('bank_id',TRUE));
                for($i = 0; $i < count($this->input->post('bank_id',TRUE)); $i++)
                {
                  if($this->input->post('bank_id',TRUE)[$i]!='')
                  {
                    $symbols        = array(",");
                    $bgamount = $this->input->post('bg_amount',TRUE)[$i];
                    $bg_amount      = str_replace($symbols, "", $bgamount);
                    $bank_data=array(
                            'bank_id'               =>     $this->input->post('bank_id',TRUE)[$i],
                            'distributor_id'        =>     $distributor_id,
                            'ifsc_code'             =>     $this->input->post('ifsc_code',TRUE)[$i],
                            'account_no'            =>     $this->input->post('account_no',TRUE)[$i],
                            'bg_amount'             =>     $bg_amount,
                            'start_date'            =>     date('Y-m-d', strtotime($this->input->post('start_date',TRUE)[$i])),
                            'end_date'              =>     date('Y-m-d', strtotime($this->input->post('end_date',TRUE)[$i])),
                            'status'                =>     1
                            );


                    $this->Common_model->insert_data('bank_guarantee',$bank_data);
                  }
                }


                if($this->db->trans_status() === FALSE)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Error!</strong> Something went wrong. Please check. </div>');

                }
                else
                {
                    $this->db->trans_commit(); 
                    $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Success!</strong>Distributor has been added successfully! </div>');
                }

            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Error!</strong> UserName Already Exist. Please check. </div>'); 
                redirect(SITE_URL.'distributor_selection'); exit();
            }
            
        }
        redirect(SITE_URL.'distributor'); 
    }
	// created by srilekhs
    // modified by maruthi 
  public function edit_distributor()
    {
        $distributor_id=@cmm_decode($this->uri->segment(2));
        if($distributor_id==''){
            redirect(SITE_URL.'distributor');
            exit;
        }
        $type_id = $this->Common_model->get_value('distributor',array('distributor_id'=>$distributor_id),'type_id');
        $type_name = $this->Common_model->get_value('distributor_type',array('type_id'=>$type_id),'name');
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit $type_name";
        $data['nestedView']['pageTitle'] = "Edit $type_name";
        $data['nestedView']['cur_page'] = 'distributor';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/distributor.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor List', 'class' => '', 'url' => SITE_URL.'distributor');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' =>"Edit $type_name", 'class' => 'active', 'url' => '');

       

        # Data
        $user_id = $this->Common_model->get_value('distributor',array('distributor_id'=>$distributor_id),'user_id');
        $user_details = $this->Common_model->get_data('user',array('user_id'=>$user_id));
        $data['user'] = $user_details[0];
        $row = $this->Common_model->get_data('distributor',array('distributor_id'=>$distributor_id));

        /*koushik*/
        //  Modified By Maruthi
        $city_id = $row[0]['location_id'];
        //$level_id = $this->Common_model->get_value('location',array('location_id'=>$row[0]))
        if($city_id!='')
        {
          $level_id = $this->Common_model->get_value('location',array('location_id'=>$city_id),'level_id');
          if($level_id == 6)
          {
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
          }
          else
          {
            $mandal_id = $city_id;
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
          }
         
        }
        
         $data['state']= $this->Common_model->get_data('location',array('level_id'=>2,'status'=>1));
        /*koushik*/

        $data['distributor_row'] = $row[0];
        $data['bank'] = $this->Common_model->get_data('bank',array('status'=>1));
        $data['executive_list'] = $this->Common_model->get_data('executive',array());
        $data['bank_g'] = $this->Common_model->get_data('bank_guarantee',array('distributor_id'=>$distributor_id));

         # Additional data
        $data['type_name'] = $type_name;
        $data['type_id'] = $type_id;
        $data['flg'] = 1;
        $data['flag'] = 2;
        $data['form_action'] = SITE_URL.'update_distributor';
        $data['display_results'] = 0;
        
        if($type_id==2)
        {
            $agent_id = 5;
            $data['agentlist'] = $this->Distributor_m->get_agent_list($agent_id);
        }
        else if($type_id == 4)
        {
            $agent_id = 6;
            $data['agentlist'] = $this->Distributor_m->get_agent_list($agent_id);
        }
        $this->load->view('distributor/distributor_view',$data);
    }

/*Update Distributor details
Author:Srilekha
Time: 3.46PM 21-01-2017 */
     public function update_distributor()
    {
      /*echo '<pre>';
      print_r($_POST);exit;*/
      $distributor_id=@cmm_decode($this->input->post('encoded_id',TRUE));
      if($distributor_id=='')
      {
        redirect(SITE_URL.'distributor'); exit;
      }
      $type_id = $this->Common_model->get_value('distributor',array('distributor_id'=>$distributor_id),'type_id');

      $address = $this->input->post('address',TRUE);
              if($address==''){ $address = NULL;}
      $location_id = $this->input->post('location_id',TRUE);
      $mandal_id = $this->input->post('mandal',TRUE);
      if($mandal_id=='')
        { 
          $location_id = NULL;
        }
        else
        {
            if($location_id =='')
            {
              $location_id = $mandal_id;
            }
            else
            {
              $location_id = $location_id;
            }
        }
      //echo $location_id;exit;        

      $sdamount       = $this->input->post('sd_amount',TRUE);
      $bad_symbols    = array(",");
      $sd_amount      = str_replace($bad_symbols, "", $sdamount);
      $mktg_exe_code = $this->input->post('mktg_exe_code',TRUE);
              if($mktg_exe_code==''){ $mktg_exe_code = NULL;}

      $pincode = $this->input->post('pincode',TRUE);
              if($pincode==''){ $pincode = NULL;}

      $alternate_mobile = $this->input->post('alternate_mobile',TRUE);
              if($alternate_mobile==''){ $alternate_mobile = NULL;}

      $marriage_date = $this->input->post('marriage_date',TRUE);
              if($marriage_date==''){ $marriage_date = NULL;}
              else{$marriage_date = date('Y-m-d', strtotime($this->input->post('marriage_date',TRUE)));}

      $date_of_birth = $this->input->post('date_of_birth',TRUE);
              if($date_of_birth==''){ $date_of_birth = NULL;}
              else{ $date_of_birth = date('Y-m-d', strtotime($this->input->post('date_of_birth',TRUE)));}

      $agreement_start_date = $this->input->post('agreement_start_date',TRUE);
              if($agreement_start_date==''){ $agreement_start_date = NULL;}
              else{$agreement_start_date = date('Y-m-d', strtotime($this->input->post('agreement_start_date',TRUE)));}

      $agreement_end_date = date('Y-m-d', strtotime($this->input->post('agreement_end_date',TRUE)));
              if($agreement_end_date==''){ $agreement_end_date = NULL;}
              else{$agreement_end_date = date('Y-m-d', strtotime($this->input->post('agreement_end_date',TRUE)));}

      if($type_id==2 || $type_id==4)
      {
          $user_id = $this->input->post('user_id',TRUE);
          $username = $this->input->post('user_name','TRUE');
          $get_user_unique = $this->Distributor_m->check_user_availability($username,$user_id);
          if($get_user_unique==0)
          {
              $user_data = array('username'       =>  $username,
                                 'plant_id'       =>  1,
                                 'block_id'       =>  5,
                                 'designation_id' =>  11,
                                 'name'           =>  $this->input->post('concerned_person',TRUE),
                                 'mobile'         =>  $this->input->post('mobile',TRUE),
                                 'email'          =>  $this->input->post('email',TRUE),
                                 'address'        =>  $address,
                                 'status'         =>  1,
                                 'modified_by'    =>  $this->session->userdata('user_id'),
                                 'modified_time'  =>  date('Y-m-d H:i:s')
                                 );
              $where = array('user_id'=>$user_id);
              $this->db->trans_begin();
              $this->Common_model->update_data('user',$user_data,$where);

              $distributor_data = array('user_id'          =>   $user_id,
                                        'type_id'          =>   $type_id,
                                        'distributor_code' =>   $this->input->post('distributor_code',TRUE),
                                        'agency_name'      =>   $this->input->post('agency_name',TRUE),
                                        'concerned_person' =>   $this->input->post('concerned_person',TRUE),
                                        'address'          =>   $address,
                                        'pincode'          =>   $pincode,
                                        'mobile'           =>   $this->input->post('mobile',TRUE),
                                        'landline'         =>   $this->input->post('landline',TRUE),
                                        'alternate_mobile' =>   $alternate_mobile,
                                        'agent_id'         =>   $this->input->post('agent_id',TRUE),
                                        'distributor_place'=>   $this->input->post('distributor_place'),
                                        'location_id'      =>$location_id
                                       );
                                       //if($location_id!=''){ $distributor_data['location_id']=$location_id;}
              $where1 = array('distributor_id' => $distributor_id);

              $distributor_id = $this->Common_model->update_data('distributor',$distributor_data,$where1);

              //echo $this->db->last_query();exit;

              if($this->db->trans_status() === FALSE)
              {
                  $this->db->trans_rollback();
                  $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                      <strong>Error!</strong> Something went wrong. Please check. </div>');

              }
              else
              {//exit;
                  $this->db->trans_commit(); 
                  $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                      <strong>Success!</strong>Distributor has been Updated successfully! </div>');
              }
          }
          else
          {
              $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                          <strong>Error!</strong> UserName Already Exist. Please check. </div>'); 
              redirect(SITE_URL.'distributor'); exit();
          }
      }
      else
      {

          $user_id = $user_id = $this->input->post('user_id',TRUE);
          $username = $this->input->post('user_name',TRUE);
          $get_user_unique = $this->Distributor_m->check_user_availability($username,$user_id);
          if($get_user_unique==0)
          {
            $current_sd_amount = $this->Common_model->get_value('distributor',array('distributor_id'=> $distributor_id),'sd_amount');
              $user_data = array('username'       =>  $username,
                                 'plant_id'       =>  1,
                                 'block_id'       =>  5,
                                 'designation_id' =>  11,
                                 'name'           =>  $this->input->post('concerned_person',TRUE),
                                 'mobile'         =>  $this->input->post('mobile',TRUE),
                                 'email'          =>  $this->input->post('email',TRUE),
                                 'address'        =>  $address,
                                 'status'         =>  1,
                                 'modified_by'    =>  $this->session->userdata('user_id'),
                                 'modified_time'  =>  date('Y-m-d H:i:s')
                                 );
              $where = array('user_id'=>$user_id);
              $this->db->trans_begin();
              $this->Common_model->update_data('user',$user_data,$where);

              $distributor_data = array('user_id'          =>   $user_id,
                                        'type_id'          =>   $type_id,
                                        'distributor_code' =>   $this->input->post('distributor_code',TRUE),
                                        'agency_name'      =>   $this->input->post('agency_name',TRUE),
                                        'concerned_person' =>   $this->input->post('concerned_person',TRUE),
                                        'address'          =>   $address,
                                        'pincode'          =>   $pincode,
                                        'mobile'           =>   $this->input->post('mobile',TRUE),
                                        'landline'         =>   $this->input->post('landline',TRUE),
                                        'alternate_mobile' =>   $alternate_mobile,
                                        'vat_no'           =>   $this->input->post('vat_no',TRUE),
                                        'aadhar_no'        =>   $this->input->post('aadhar_no',TRUE),
                                        'pan_no'           =>   $this->input->post('pan_no',TRUE),
                                        'tan_no'           =>   $this->input->post('tan_no',TRUE),
                                        'date_of_birth'    =>   $date_of_birth,
                                        'marriage_date'    =>   $marriage_date,
                                        'executive_id'    =>    $this->input->post('executive_id'),
                                        'sd_amount'        =>   $sd_amount,
                                        'agreement_start_date' => $agreement_start_date,
                                        'agreement_end_date'   => $agreement_end_date,
                                        'outstanding_amount'   => $this->input->post('outstanding_amount'),
                                          'distributor_place'=>   $this->input->post('distributor_place'),
                                          'location_id'      =>$location_id
                                       );
                                        //if($location_id!=''){ $distributor_data['location_id']=$location_id;}
              $where1 = array('distributor_id' => $distributor_id);
              $this->Common_model->update_data('distributor',$distributor_data,$where1);
              //echo $this->db->last_query();exit;
              $get_agreement = $this->Distributor_m->get_latest_agreement($distributor_id);

              if($get_agreement['start_date']!=$agreement_start_date || $get_agreement['end_date']!=$agreement_end_date)
              {
                $agreement_history_data = array('distributor_id' => $distributor_id,
                                              'start_date'     => $agreement_start_date,
                                              'end_date'       => $agreement_end_date,
                                              'created_by'     => $this->session->userdata('user_id'),
                                              'created_time'   => date('Y-m-d H:i:s')
                                             );
                $this->Common_model->insert_data('distributor_agreement_history',$agreement_history_data);
              }

              // Update sd amount history
              
              //echo $sd_amount.'--'.$current_sd_amount;
              if($sd_amount!=$current_sd_amount)
              {
                  // Update previous entry end date
                  $sdh_data = array('end_date'=> date('Y-m-d'),
                                    'modified_by'=> $this->session->userdata('user_id'),
                                    'modified_time' => date('Y-m-d H:i:s'));
                  $sdh_where = array('distributor_id' => $distributor_id,
                                     'end_date IS NULL' => NULL);
                  $this->Common_model->update_data('dist_sd_amount_history',$sdh_data,$sdh_where);
                  //echo $this->db->last_query().'<br>';
                  // Insert new entry
                  $sdh_data2 = array('distributor_id' => $distributor_id,
                                     'sd_amount'    => $sd_amount,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => NULL,
                                     'created_by' => $this->session->userdata('user_id'),
                                     'created_time' => date('Y-m-d H:i:s'));
                  $this->Common_model->insert_data('dist_sd_amount_history',$sdh_data2);
                  //echo $this->db->last_query().'<br>';
              }

              $this->Common_model->delete_data('bank_guarantee',array('distributor_id'=>$distributor_id));
              
              for($i = 0; $i < count($this->input->post('bank_id',TRUE)); $i++)
                {
                	if($this->input->post('bank_id',TRUE)[$i] != '')
                	
                	{
                  $symbols        = array(",");
                  $bgamount = $this->input->post('bg_amount',TRUE)[$i];
                  $bg_amount      = str_replace($symbols, "", $bgamount);
                  $bank_data=array(
                          'bank_id'               =>     $this->input->post('bank_id',TRUE)[$i],
                          'distributor_id'        =>     $distributor_id,
                          'ifsc_code'             =>     $this->input->post('ifsc_code',TRUE)[$i],
                          'account_no'            =>     $this->input->post('account_no',TRUE)[$i],
                          'bg_amount'             =>     $bg_amount,
                          'start_date'            =>     date('Y-m-d', strtotime($this->input->post('start_date',TRUE)[$i])),
                          'end_date'              =>     date('Y-m-d', strtotime($this->input->post('end_date',TRUE)[$i])),
                          'status'                =>     1
                          );
				$this->Common_model->insert_data('bank_guarantee',$bank_data);
			}
                  
                }
              if($this->db->trans_status() === FALSE)
              {
                  $this->db->trans_rollback();
                  $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                      <strong>Error!</strong> Something went wrong. Please check. </div>');

              }
              else
              {

                  $this->db->trans_commit(); 
                  //exit;
                  $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                      <strong>Success!</strong>Distributor has been Updated successfully! </div>');
              }

          }
          else
          {
              $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                          <strong>Error!</strong> UserName Already Exist. Please check. </div>'); 
              redirect(SITE_URL.'distributor_selection'); exit();
          }
          
      }
      redirect(SITE_URL.'distributor');  
    }

/*Deactivate Distributor details
Author:Srilekha
Time: 3.51PM 21-01-2017 */
    public function deactivate_distributor($encoded_id)
    {
    
        $distributor_id=@cmm_decode($encoded_id);
        if($distributor_id==''){
            redirect(SITE_URL.'distributor');
            exit;
        }
        $user_id = $this->Common_model->get_value('distributor',array('distributor_id'=>$distributor_id),'user_id');
       
            $where = array('user_id' => $user_id);
            //deactivating user
            $data_arr = array('status' => 2);
            $this->Common_model->update_data('user',$data_arr, $where);
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Distributor  has been Deactivated successfully!</div>');
            redirect(SITE_URL.'distributor');           
        

    }

/*Insert Distributor details
Author:Srilekha
Time: 3.53PM 21-01-2017 */
	public function activate_distributor($encoded_id)
    {
        $distributor_id=@cmm_decode($encoded_id);
        if($distributor_id==''){
            redirect(SITE_URL.'distributor');
            exit;
        }
        $user_id = $this->Common_model->get_value('distributor',array('distributor_id'=>$distributor_id),'user_id');
       
            $where = array('user_id' => $user_id);
            //deactivating user
            $data_arr = array('status' => 1);
            $this->Common_model->update_data('user',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Distributor has been Activated successfully!</div>');
        redirect(SITE_URL.'distributor');

    }
/*Insert Distributor details
Author:Srilekha
Time: 4.09PM 21-01-2017 */
	public function download_distributor()
    {
        if($this->input->post('download_distributor')!='') {
            $search_params=array(
                'distributor_code' => $this->input->post('distributor_code', TRUE),
                'agency_name'      => $this->input->post('agency_name', TRUE),
                'type_id'          => $this->input->post('type_id', TRUE)
            
                              );
            $distributors = $this->Distributor_m->distributor_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Distributor Code','UserName','Agency Name','Concerned Person','Phone Number','Pin Code');
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
            if(count($distributors)>0)
            {
                
                foreach($distributors as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['distributor_code'].'</td>';
                    $data.='<td align="center">'.$row['username'].'</td>';                   
                    $data.='<td align="center">'.$row['agency_name'].'</td>';                   
                    $data.='<td align="center">'.$row['concerned_person'].'</td>';
                    $data.='<td align="center">'.$row['mobile'].'</td>';
                    $data.='<td align="center">'.$row['pincode'].'</td>';
                    
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
            $xlFile='Distributor'.$time.'.xls'; 
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
Time: 2.50PM 25-01-2017 */
    public function getregionList()
    {
    	$state_id = $this->input->post('state_id',TRUE);
    	echo $this->Distributor_m->getregionList($state_id);
    }
/*Getting District Dropdown details
Author:Srilekha
Time: 2.50PM 25-01-2017 */
    public function getdistrictList()
    {
    	$region_id = $this->input->post('region_id',TRUE);
    	echo $this->Distributor_m->getdistrictList($region_id);
    }
/*Getting Area Dropdown details
Author:Srilekha
Time: 2.50PM 25-01-2017 */
    /*public function getareaList()
    {
    	$district_id = $this->input->post('district_id',TRUE);
    	echo $this->Distributor_m->getareaList($district_id);
    }*/
    /*Getting Mandal Dropdown details
Author:Mounika */
    public function getmandalList()
    {
      $district_id = $this->input->post('district_id',TRUE);
      echo $this->Distributor_m->getmandalList($district_id);
    }
/*Getting Area Dropdown details
Author:Mounika */
    public function getareaList()
    {
      $mandal_id = $this->input->post('mandal_id',TRUE);
      echo $this->Distributor_m->getareaList($mandal_id);
    }
    //Bank Guarantee Expired Print for Dashboard
  //Mounika
    public function bg_expired_print()
    {
      $data['bg_expired']=$this->Distributor_m->get_bg_expired_details();
      $this->load->view('distributor_bg_prints/bg_expired_print',$data);
    }
  //Agreement Expired Print for Dashboard
  //Mounika
     public function agreement_expired_print()
    {
      $data['agreement_expired']=$this->Distributor_m->get_agreement_expired_details();
      $this->load->view('distributor_bg_prints/agreement_expired_print',$data);
    }
  //Bank Guarantee Going to Expired Print for Dashboard
  //Mounika
    public function bg_going_expired_print()
    {
      $data['bg_going_expired']=$this->Distributor_m->get_bg_going_expired_details();
      $this->load->view('distributor_bg_prints/bg_going_expired_print',$data);
    }
  //Agreement Going to Expired Print for Dashboard
  //Mounika
    public function agreement_going_expired_print()
    {
      $data['agreement_going_expired']=$this->Distributor_m->get_agreement_going_expired_details();
      $this->load->view('distributor_bg_prints/agreement_going_expired_print',$data);
    }
    
     public function distributor_bg_renewal()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor BG Renewal";
        $data['nestedView']['pageTitle'] = 'Distributor BG Renewal';
        $data['nestedView']['cur_page'] = 'distributor_bg_renewal';
        $data['nestedView']['parent_page'] = 'distributor';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor BG Renewal', 'class' => '', 'url' => '');  
        $data['distributor_list'] = $this->Distributor_m->get_active_distributor_list();
        $this->load->view('distributor/distributor_bg_renewal', $data);
    }

    public function view_distributor_bg_renewal()
    {   
    # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="View BG Renewal";
        $data['nestedView']['pageTitle'] = "View BG Renewal";
        $data['nestedView']['cur_page'] = 'distributor';
        $data['nestedView']['parent_page'] = 'master';


        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/distributor.js" type="text/javascript"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'View BG Renewal','class'=>'','url'=>'');
       
        if($this->input->post('submit'))
        {
            $distributor_id=$this->input->post('distributor_id');
            $data['distributor_id']=$distributor_id;
            $data['results']=$this->Distributor_m->get_dist_bg_expired_details($distributor_id);
            $data['bank'] = $this->Common_model->get_data('bank',array('status'=>1));
            $this->load->view('distributor/view_distributor_bg_renewal',$data);
        }
    }
    public function insert_distributor_bg_renewal()
    {
        if($this->input->post('submit'))
        {
           $bg_id= $this->input->post('bg_id');
           $distributor_id=$this->input->post('distributor_id');
           $this->db->trans_begin();
               foreach($bg_id as $key =>$value)
               {
                   $this->Common_model->update_data('bank_guarantee',array('status'=>2),array('bg_id'=>$value));
               }
                $bank_id=$this->input->post('bank_id',TRUE) ;
                foreach($bank_id as $i => $value)
                    {
                      if($value!='')
                      {
                        $symbols        = array(",");
                        $bgamount = $this->input->post('bg_amount',TRUE)[$i];
                        $bg_amount      = str_replace($symbols, "", $bgamount);
                        $bank_data=array(
                                'bank_id'               =>     $value,
                                'distributor_id'        =>     $distributor_id,
                                'ifsc_code'             =>     $this->input->post('ifsc_code',TRUE)[$i],
                                'account_no'            =>     $this->input->post('account_no',TRUE)[$i],
                                'bg_amount'             =>     $bg_amount,
                                'start_date'            =>     date('Y-m-d', strtotime($this->input->post('start_date',TRUE)[$i])),
                                'end_date'              =>     date('Y-m-d', strtotime($this->input->post('end_date',TRUE)[$i])),
                                'status'                =>     1
                                );


                        $bg_id= $this->Common_model->insert_data('bank_guarantee',$bank_data);
                    }
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
                                                        <strong>Success!</strong> Bank Guarantee has been renewalled successfully! </div>');
                      
            }
           redirect(SITE_URL.'distributor_bg_renewal');
        }
    }

}
?>