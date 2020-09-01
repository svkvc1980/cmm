<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by mastan 17th Feb 2017 11:00 AM

class Pm_lab_test extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Packing_material_test_m");
         $this->load->library('Pdf');
	}

	public function packing_material_test()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Packing Material Lab Test";
		$data['nestedView']['pageTitle'] = 'Packing Material Lab Test';
        $data['nestedView']['cur_page'] = 'packing_material_test';
        $data['nestedView']['parent_page'] = 'Logistics';
        $data['nestedView']['list_page'] = 'quality_check';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/pm_lab_test.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Packing Material Lab Test', 'class' => '', 'url' => '');

        unset($_SESSION['lab_tests']);
        # Additional data
        $data['form_action'] = SITE_URL.'';
        $data['flag'] =1;
        $this->load->view('lab_test/packing_material_lab_test',$data);
	}

    public function packing_material_test_detail()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Packing Material Lab Test Details";
        $data['nestedView']['pageTitle'] = 'Packing Material Lab Test Details';
        $data['nestedView']['cur_page'] = 'packing_material_test';
        $data['nestedView']['parent_page'] = 'Logistics';
        $data['nestedView']['list_page'] = 'quality_check';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/pm_lab_test.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Packing Material Lab Test Details', 'class' => '', 'url' => '');

        @$lab_tests=$_SESSION['lab_tests'];
        if($this->input->post('submit') || isset($lab_tests))
        {
            $po_no  =   ($this->input->post('po_no') !='')?$this->input->post('po_no'):$lab_tests['po_no'];
            $reg_no =   ($this->input->post('tank_reg_no') !='')?$this->input->post('tank_reg_no'):$lab_tests['tank_reg_no'];
            if($po_no=='' || $reg_no=='')
            {
                redirect(SITE_URL.'packing_material_test'); exit();
            }
            $plant_id = $this->session->userdata('ses_plant_id'); 
            $available = get_latest_tanker_registration($reg_no,$plant_id);
            
            if($available==0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong> Tanker Number is Not Existed. Please Enter <strong>Valid Number !.</strong> </div>');
                redirect(SITE_URL.'packing_material_test'); exit();

            }
            $tanker_status = $available['status'];
            if($tanker_status != 2)
            {
            	$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong> Please Enter <strong>Valid Tanker Number !.</strong> </div>');
                redirect(SITE_URL.'packing_material_test'); exit();
            
            }

            
            $po_pm_id = $this->Common_model->get_value('po_pm',array('po_number'=>$po_no,'status <'=>3),'po_pm_id');
            $tankertypeid = 2;
            $tanker_id = get_latest_tanker_type_id($reg_no,$plant_id,$tankertypeid);
            
            if($tanker_id == '')
            {
            	$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong> Tanker Number is Not Belong to Pm lab Test. Please Check.</strong> </div>');
                redirect(SITE_URL.'packing_material_test'); exit();	
            }
            
             if($po_pm_id == '')
            {
            	$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong>Invalid PO Number. Please Check.</strong> </div>');
                redirect(SITE_URL.'packing_material_test'); exit();	
            }

            if($tanker_id!='' && $po_pm_id != '')
            {
                $qry = "SELECT * FROM po_pm_tanker where po_pm_id='".$po_pm_id."' AND tanker_id ='".$tanker_id."' AND status = 1";
                $count = $this->Common_model->get_no_of_rows($qry);
                if($count==0)
                {
               		$qry = "SELECT * FROM po_pm_tanker where tanker_id ='".$tanker_id."' AND status = 1";
                	$countt = $this->Common_model->get_no_of_rows($qry);
                	if($countt==1)
                	{
                		$update_data = array('po_pm_id' => $po_pm_id);
                		$where1 = array('tanker_id' => $tanker_id);
                		$this->Common_model->update_data('po_pm_tanker',$update_data,$where1);
                	}
                	else
                	{
                		$this->Common_model->insert_data('po_pm_tanker',array('po_pm_id'=>$po_pm_id,'tanker_id'=>$tanker_id,'status'=>1,'created_by'=>$this->session->userdata('user_id'),'created_time'=>date('Y-m-d H:i:s')));
                	}
                
                    
                }

            }
            else
            {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                <span> Invalid PO Number/Tanker Number ! Please Check.</span></div>');

                redirect(SITE_URL.'packing_material_test'); exit();
            }

            $data['lab_tests']=$lab_tests;
            $data['test_reports'] = $this->Packing_material_test_m->pm_test_details($po_no,$tanker_id);
            $pm_id = $data['test_reports'][0]['pm_id'];
            $pm_category_id = $this->Common_model->get_value('packing_material',array('pm_id'=>$pm_id,'status'=>1),'pm_category_id');
            $results = $this->Packing_material_test_m->get_pm_tests($pm_category_id);
            if(count($results)==0)
            {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                <span>PM Lab Test Questions are Not Defined. <strong>Contact Headoffice!. </strong></span></div>');

                redirect(SITE_URL.'packing_material_test'); exit();

            }

            $status = $data['test_reports'][0]['tanker_status'];
            if($status==1)
            {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">
                                                                <button class="close" data-close="alert"></button>
                                                                <span> Please go for Weigh Bridge gross weight. </span>
                                                            </div>');
                redirect(SITE_URL.'packing_material_test'); 
            }
            elseif($status==3)
            {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">
                                                                <button class="close" data-close="alert"></button>
                                                                <span> Already Test Performed, Please go for Weigh Bridge net weight </span>
                                                            </div>');
                redirect(SITE_URL.'packing_material_test'); 
            }
            elseif($status==4)
            {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">
                                                                <button class="close" data-close="alert"></button>
                                                                <span> Already Test Performed, Please take MRR  </span>
                                                            </div>');
                redirect(SITE_URL.'packing_material_test'); 
            }
            elseif($status==5)
            {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">
                                                                <button class="close" data-close="alert"></button>
                                                                <span> Already Test Performed, MRR is also generated  </span>
                                                            </div>');
                redirect(SITE_URL.'packing_material_test');
            }
            elseif($status==10)
            {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">
                                                                <button class="close" data-close="alert"></button>
                                                                <span> Test Failed  </span>
                                                            </div>');
                redirect(SITE_URL.'packing_material_test');
            }
            else
            {
                $pm_tests = array();
                    foreach($results as $test_row)
                    {
                        //if range type is radio or dropdown 
                        if($test_row['range_type_id'] == 2 || $test_row['range_type_id'] == 3)
                        {
                            //get test options
                            $test_options = $this->Common_model->get_data('pm_test_option',array('pm_test_id'=>$test_row['test_id'],'status'=>1));
                            $test_row['options'] = $test_options;
                        }
                        $pm_tests[$test_row['test_id']] = $test_row;
                    }
                    $data['pm_tests'] = $pm_tests;

                
                  
                    $data['flag']=2;
                    $data['form_action'] = SITE_URL.'confirm_pm_lab_test';
                    $data['reg_no']=$reg_no;
                    $data['po_no'] =$po_no;    
                
            }
            $this->load->view('lab_test/packing_material_lab_test',$data);
        }
    }

    public function confirm_packing_material_test()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Packing Material Lab Test Details";
        $data['nestedView']['pageTitle'] = 'Packing Material Lab Test Details';
        $data['nestedView']['cur_page'] = 'packing_material_test';
        $data['nestedView']['parent_page'] = 'Logistics';
        $data['nestedView']['list_page'] = 'quality_check';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/pm_lab_test.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Packing Material Lab Test Details', 'class' => 'active', 'url' => '');
        
        if($this->input->post('submit')==TRUE)
        {
            $po_no  =   $this->input->post('po_no');
            $reg_no =   $this->input->post('tank_reg_no');
            $plantidd = $this->session->userdata('ses_plant_id');
            $tankeridd = get_latest_tanker_id($reg_no,$plantidd);
            $pm_id  =   $this->input->post('pm_id');
            $data['test_reports'] = $this->Packing_material_test_m->pm_test_details($po_no,$tankeridd);
            $pm_id = $data['test_reports'][0]['pm_id'];
            $pm_category_id = $this->Common_model->get_value('packing_material',array('pm_id'=>$pm_id),'pm_category_id');
            $tanker_id = $data['test_reports'][0]['tanker_id'];
            $data['tanker_id'] = $tanker_id;
            $results = $this->Packing_material_test_m->get_pm_tests($pm_category_id);
            $pm_tests = array();
                foreach($results as $test_row)
                {
                    //if range type is radio or dropdown 
                    if($test_row['range_type_id'] == 2 || $test_row['range_type_id'] == 3)
                    {
                        //get test options
                        $test_options = $this->Common_model->get_data('pm_test_option',array('pm_test_id'=>$test_row['test_id'],'status'=>1));
                        $test_row['options'] = $test_options;
                    }
                    $pm_tests[$test_row['test_id']] = $test_row;
                }
                $data['pm_tests'] = $pm_tests;

            $tanker_id = $this->input->post('tanker_id', TRUE);
            $tanker_reg_no = $this->Common_model->get_data('tanker_register',array('tanker_id' => $tanker_id),'tanker_in_number');
            $test_result = $this->input->post('test_result');
            $data['test_result'] = $test_result;

            $overall_test_status = 1; $passed_tests_counter = 0; $pm_test_results = array();
            //looping test results
            foreach ($test_result as $test_id => $result) 
            {
                // get test details by test id
                $test_details = $this->Common_model->get_data_row('packing_material_test',array('pm_test_id' => $test_id));
                switch ($test_details['range_type_id']) 
                {
                    case 2: case 3: // Radio Or Dropdown
                         // check weather test passed or not
                        if($this->Packing_material_test_m->check_pm_test_option($result,$test_id))
                        {
                           $test_status = 1;
                           $passed_tests_counter++;
                        }
                        else
                        {
                            $test_status = 2;
                            $overall_test_status = 2;
                        }
                    break;
                    case 4: // Exact Value
                        if($test_details['lower_limit']==$result)
                        {
                            $test_status = 1;
                            $passed_tests_counter++;
                        }
                        else
                        {
                            $test_status = 2;
                            $overall_test_status = 2;
                        }
                    break;
                    case 1: // Textbox
                        if($test_details['lower_limit']!=NULL && $test_details['upper_limit']!=NULL)
                        {
                            if($test_details['lower_check']==1)
                            {
                                if($test_details['upper_check']==1)
                                {
                                    if($test_details['lower_limit']<=$result && $test_details['upper_limit']>=$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                                else
                                {
                                    if($test_details['lower_limit']<$result && $test_details['upper_limit']>$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                            }
                            else
                            {
                                if($test_details['upper_check']==1)
                                {
                                    if($test_details['lower_limit']<$result && $test_details['upper_limit']>=$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                                else
                                {
                                    if($test_details['lower_limit']<$result && $test_details['upper_limit']>$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                            }
                        }
                       
                        else
                        {
                            if($test_details['lower_limit']==NULL)
                            {
                                if($test_details['upper_check']==1)
                                {
                                    if($test_details['lower_limit']>=$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                                else
                                {
                                    if($test_details['lower_limit']>$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                            }
                            else
                            {
                                if($test_details['lower_check']==1)
                                {
                                    if($test_details['lower_limit']<=$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                                else
                                {
                                    if($test_details['lower_limit']<$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                            }
                        }
                    break;
                }

                $pm_test_results[$test_id]['result'] = $result;
                $pm_test_results[$test_id]['test_status'] = $test_status;
            }

            $_SESSION['lab_tests']=$_POST;
            // print_r($_SESSION['lab_tests']);exit;
            $data['pm_test_results'] = $pm_test_results;
            $data['overall_test_status'] = $overall_test_status;
        }
            $this->load->view('lab_test/confirm_pm_lab_test',$data);
    }

    public function insert_packing_material_test()
    {
        #echo '<pre>'; print_r($_POST); die;
        if($this->input->post('submit')==TRUE)
        {
            $tanker_id = $this->input->post('tanker_id', TRUE);
            $plant_id = $this->session->userdata('ses_plant_id');
            $tanker_reg_no = $this->Common_model->get_data('tanker_register',array('tanker_id' => $tanker_id,'plant_id'=>$plant_id),'tanker_in_number');
            $test_result = $this->input->post('test_result');

            // Inserting oil lab test
            $data = array(  'tanker_id'     =>  $tanker_id,
                            'test_number'   =>  get_test_pm_number(),
                            'test_date'     =>  date('Y-m-d'),
                            'pm_id'         =>  1,
                            'status'        =>  1,
                            'created_by'    =>  $this->session->userdata('user_id')
                        );
            $lab_test_id = $this->Common_model->insert_data('po_pm_lab_test',$data);

            $overall_test_status = 1; $passed_tests_counter = 0;
            //looping test results
            foreach ($test_result as $test_id => $result) 
            {
                // get test details by test id
                $test_details = $this->Common_model->get_data_row('packing_material_test',array('pm_test_id' => $test_id));
                switch ($test_details['range_type_id']) 
                {
                    case 2: case 3: // Radio Or Dropdown
                         // check weather test passed or not
                        if($this->Packing_material_test_m->check_pm_test_option($result,$test_id))
                        {
                           $test_status = 1;
                           $passed_tests_counter++;
                        }
                        else
                        {
                            $test_status = 2;
                            $overall_test_status = 2;
                        }
                    break;
                    case 4: // Exact Value
                        if($test_details['lower_limit']==$result)
                        {
                            $test_status = 1;
                            $passed_tests_counter++;
                        }
                        else
                        {
                            $test_status = 2;
                            $overall_test_status = 2;
                        }
                    break;
                    case 1: // Textbox
                        if($test_details['lower_limit']!=NULL && $test_details['upper_limit']!=NULL)
                        {
                            if($test_details['lower_check']==1)
                            {
                                if($test_details['upper_check']==1)
                                {
                                    if($test_details['lower_limit']<=$result && $test_details['upper_limit']>=$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                                else
                                {
                                    if($test_details['lower_limit']<$result && $test_details['upper_limit']>$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                            }
                            else
                            {
                                if($test_details['upper_check']==1)
                                {
                                    if($test_details['lower_limit']<$result && $test_details['upper_limit']>=$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                                else
                                {
                                    if($test_details['lower_limit']<$result && $test_details['upper_limit']>$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                            }
                        }
                       
                        else
                        {
                            if($test_details['lower_limit']==NULL)
                            {
                                if($test_details['upper_check']==1)
                                {
                                    if($test_details['lower_limit']>=$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                                else
                                {
                                    if($test_details['lower_limit']>$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                            }
                            else
                            {
                                if($test_details['lower_check']==1)
                                {
                                    if($test_details['lower_limit']<=$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                                else
                                {
                                    if($test_details['lower_limit']<$result)
                                    {
                                        $test_status = 1;
                                        $passed_tests_counter++;
                                    }
                                    else
                                    {
                                        $test_status = 2;
                                        $overall_test_status = 2;
                                    }
                                }
                            }
                        }
                    break;
                }

                // Inserting lab test results
                $data1 = array( 'lab_test_id'   =>  $lab_test_id,
                                'pm_test_id'    =>  $test_id,
                                'value'         =>  $result,
                                'status'        =>  $test_status
                            );
                $this->Common_model->insert_data('po_pm_lab_test_results',$data1);

            }
            
            // Update overall lab test status
            $data2 = array('status'=>$overall_test_status);
            $where2 = array('lab_test_id'=>$lab_test_id);
            $this->Common_model->update_data('po_pm_lab_test',$data2,$where2);

            $get_pm_id = $this->Common_model->get_value('tanker_pm',array('tanker_id'=>$tanker_id),'pm_id');
            $get_pm_cat_id = $this->Common_model->get_value('packing_material',array('pm_id'=>$get_pm_id),'pm_category_id');
            

            $tanker_status =($overall_test_status==1)?3:10; // 3 - passed , 10 - Failed
            // Update tanker register status
            $data3 = array( 'modified_by'=> $this->session->userdata('user_id'),
                            'modified_time' => date('Y-m-d H:i:s'),
                            'status'    => $tanker_status
                            );

            $where3 = array('tanker_id'=>$tanker_id);
            $this->Common_model->update_data('tanker_register',$data3,$where3);
        
            if($overall_test_status==1)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Success!</strong>Packing Material Lab Test has been completed. Test Result is Passed! </div>');
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong>Packing Material Lab Test has been completed. Test Result is Failed. </div>');       
            }

            redirect(SITE_URL.'pm_test_results'.'/'.cmm_encode($lab_test_id));
        }
    }

     public function pm_test_results()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Packing Material Lab Test Results";
        $data['nestedView']['pageTitle'] = 'Packing Material Lab Test Results';
        $data['nestedView']['cur_page'] = 'pm_lab_test';
        $data['nestedView']['parent_page'] = 'Logistics';
        $data['nestedView']['list_page'] = 'quality_check';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Packing Material Lab Test Results', 'class' => 'active', 'url' => '');

        $lab_test_id=@cmm_decode($this->uri->segment(2));
        if($lab_test_id == '')
        {
            redirect(SITE_URL);
        }
        else
        {   
            $tanker_id = $this->Common_model->get_value('po_pm_lab_test',array('lab_test_id'=>$lab_test_id),'tanker_id');
             $data['plant_idd'] = $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id),'plant_id');
             $data['test_date'] = $this->Common_model->get_value('po_pm_lab_test',array('lab_test_id'=>$lab_test_id),'test_date');
            $data['test_number'] = $this->Common_model->get_value('po_pm_lab_test',array('lab_test_id'=>$lab_test_id),'test_number');
            $po_pm_id = $this->Common_model->get_value('po_pm_tanker',array('tanker_id'=>$tanker_id),'po_pm_id');
            $po_no = $this->Common_model->get_value('po_pm',array('po_pm_id'=>$po_pm_id),'po_number');
            $reg_no = $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id),'tanker_in_number');

            $data['test_reports'] = $this->Packing_material_test_m->pm_test_details($po_no,$tanker_id);
            $data['results_list'] = $this->Packing_material_test_m->get_list_of_test_results($tanker_id);

            $test_results=array();
            $result = $this->Packing_material_test_m->get_pm_test_results($lab_test_id);
            
            foreach($result as $results)
            {   
                if($results['range_type_id'] == 2 || $results['range_type_id'] == 3)
                {
                    //get test options
                    $test_options = $this->Common_model->get_data('pm_test_option',array('pm_test_id'=>$results['pm_test_id'],'status'=>1));
                    $results['options'] = $test_options;
                    if(array_key_exists(@$keys, $test_results)) 
                    {
                        $test_results[$results['test_id']] = $results;
                    } 
                    else
                    {
                        $test_results[$results['test_id']] = $results;
                    }
                }
                else
                {
                    if(array_key_exists(@$keys, $test_results)) 
                    {
                        $test_results[$results['test_id']] = $results;
                    } 
                    else
                    {
                        $test_results[$results['test_id']] = $results;
                    }
                }
            }
            # print_r($test_results);exit;
            $data['test_results']=$test_results;
            $this->load->view('lab_test/pm_test_results',$data);
        }
        
    }

    public function print_pm_test_results()
    {
        $lab_test_id=@cmm_decode($this->uri->segment(2));
        if($lab_test_id == '')
        {
            redirect(SITE_URL);
        }
        else
        {   
            $tanker_id = $this->Common_model->get_value('po_pm_lab_test',array('lab_test_id'=>$lab_test_id),'tanker_id');
             $data['plant_idd'] = $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id),'plant_id');
            $po_pm_id = $this->Common_model->get_value('po_pm_tanker',array('tanker_id'=>$tanker_id),'po_pm_id');
            $data['test_date'] = $this->Common_model->get_value('po_pm_lab_test',array('lab_test_id'=>$lab_test_id),'test_date');
            $data['test_number'] = $this->Common_model->get_value('po_pm_lab_test',array('lab_test_id'=>$lab_test_id),'test_number');
            $po_no = $this->Common_model->get_value('po_pm',array('po_pm_id'=>$po_pm_id),'po_number');
            $reg_no = $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id),'tanker_in_number');

            $data['test_reports'] = $this->Packing_material_test_m->pm_test_details($po_no,$tanker_id);
            $data['results_list'] = $this->Packing_material_test_m->get_list_of_test_results($tanker_id);


            $test_results=array();
            $result = $this->Packing_material_test_m->get_pm_test_results($lab_test_id);
            
            foreach($result as $results)
            {   
                if($results['range_type_id'] == 2 || $results['range_type_id'] == 3)
                {
                    //get test options
                    $test_options = $this->Common_model->get_data('pm_test_option',array('pm_test_id'=>$results['pm_test_id'],'status'=>1));
                    $results['options'] = $test_options;
                    if(array_key_exists(@$keys, $test_results)) 
                    {
                        $test_results[$results['test_id']] = $results;
                    } 
                    else
                    {
                        $test_results[$results['test_id']] = $results;
                    }
                }
                else
                {
                    if(array_key_exists(@$keys, $test_results)) 
                    {
                        $test_results[$results['test_id']] = $results;
                    } 
                    else
                    {
                        $test_results[$results['test_id']] = $results;
                    }
                }
            }
            # print_r($test_results);exit;
            $data['test_results']=$test_results;

            $this->load->view('lab_test/print_pm_test_results',$data);
        }
    }
}