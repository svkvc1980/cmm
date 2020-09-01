<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 15th Nov 2016 09:00 AM

class Oil_lab_test extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Oil_lab_test_m");
        $this->load->library('Pdf');
    }

    public function lab_test_report()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Oil Lab Test Reports";
        $data['nestedView']['pageTitle'] = 'Oil Lab Test Reports';
        $data['nestedView']['cur_page'] = 'oil_lab_test';
        $data['nestedView']['parent_page'] = 'Logistics';
        $data['nestedView']['list_page'] = 'quality_check';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/test_reports.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Oil Lab Test Reports', 'class' => 'active', 'url' => '');
        
        unset($_SESSION['lab_tests']);
        # Additional data
        $data['form_action'] = SITE_URL.'';
        $data['flag'] =1;
        $this->load->view('lab_test/lab_test_report',$data);
    }

    public function lab_test_report_detail()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Oil Lab Test Report Details";
        $data['nestedView']['pageTitle'] = 'Oil Lab Test Report Details';
        $data['nestedView']['cur_page'] = 'oil_lab_test';
        $data['nestedView']['parent_page'] = 'Logistics';
        $data['nestedView']['list_page'] = 'quality_check';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/test_reports.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Oil Lab Test Report Details', 'class' => 'active', 'url' => '');   
       
        @$lab_tests=$_SESSION['lab_tests'];
        if($this->input->post('submit')|| isset($lab_tests))
        {   
            $po_no  =   ($this->input->post('po_no') !='')?$this->input->post('po_no'):$lab_tests['po_no'];
            $reg_no =   ($this->input->post('tank_reg_no') !='')?$this->input->post('tank_reg_no'):$lab_tests['tank_reg_no'];
            if($po_no=='' || $reg_no=='')
            {
                redirect(SITE_URL.'lab_test_report'); exit();
            }
            $plant_id = $this->session->userdata('ses_plant_id');
           
            $available = get_latest_tanker_registration($reg_no,$plant_id);
            if($available==0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong> Tanker Number is Not Existed. Please Enter <strong>Valid Number !.</strong> </div>');
                redirect(SITE_URL.'lab_test_report'); exit();

            }
            $tanker_status = $available['status'];
            if($tanker_status != 2)
            {
            	$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong> Please Enter <strong>Valid Tanker Number !.</strong> </div>');
                redirect(SITE_URL.'packing_material_test'); exit();
            
            }

            $po_oil_id = $this->Common_model->get_value('po_oil',array('po_number'=>$po_no,'status<'=>3),'po_oil_id');
            $tankertypeid = 1;
            $tanker_id = get_latest_tanker_type_id($reg_no,$plant_id,$tankertypeid);
            if($tanker_id=='')
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong> Tanker Number is Not Belong To Loose Oil Lab Test. Please Check!</strong> </div>');
                redirect(SITE_URL.'lab_test_report'); exit();

            }

            if($po_oil_id=='')
            {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <span> Invalid PO Number</span></div>');
                redirect(SITE_URL.'lab_test_report'); exit();

            }

            if($tanker_id!='' && $po_oil_id != '')
            {
                $qry = "SELECT * FROM po_oil_tanker where po_oil_id='".$po_oil_id."' AND tanker_id ='".$tanker_id."' AND status = 1";
                $count = $this->Common_model->get_no_of_rows($qry);
                
                if($count==0)
                {
                	 $qry = "SELECT * FROM po_oil_tanker where tanker_id ='".$tanker_id."' AND status = 1";
                         $count = $this->Common_model->get_no_of_rows($qry);
                         if($count==1)
                         {
                         	$data_update = array('po_oil_id' => $po_oil_id);
                         	$where_po_oil = array('tanker_id' => $tanker_id);
                         	$this->Common_model->update_data('po_oil_tanker',$data_update,$where_po_oil);
                         }
                         else
                         {
                         	$this->Common_model->insert_data('po_oil_tanker',array('po_oil_id'=>$po_oil_id,'tanker_id'=>$tanker_id,'status'=>1,'created_by'=>$this->session->userdata('user_id'),'created_time'=>date('Y-m-d H:i:s')));
                         }
                         
                         
                	
                    
                }

            }
            else
            {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <span> Invalid PO Number/Tanker Number ! Please Check.</span></div>');
                redirect(SITE_URL.'lab_test_report'); exit();
            }

            $data['lab_tests']=$lab_tests;

            $data['test_reports'] = $this->Oil_lab_test_m->test_report_details($po_no,$tanker_id);
            $status = $data['test_reports'][0]['tanker_status'];
            if($status==1)
            {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">
                                                                <button class="close" data-close="alert"></button>
                                                                <span> Please go for Weigh Bridge gross weight. </span>
                                                            </div>');
                redirect(SITE_URL.'lab_test_report'); 
            }
            elseif($status==3)
            {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">
                                                                <button class="close" data-close="alert"></button>
                                                                <span> Already Test Performed, Please go for Weigh Bridge Tare weight </span>
                                                            </div>');
                redirect(SITE_URL.'lab_test_report'); 
            }
            elseif($status==4)
            {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">
                                                                <button class="close" data-close="alert"></button>
                                                                <span> Already Test Performed, Please take MRR  </span>
                                                            </div>');
                redirect(SITE_URL.'lab_test_report'); 
            }
            elseif($status==5)
            {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">
                                                                <button class="close" data-close="alert"></button>
                                                                <span> Already Test Performed, MRR is also generated  </span>
                                                            </div>');
                redirect(SITE_URL.'lab_test_report');
            }
            elseif($status==10)
            {
                $this->session->set_flashdata('response', '<div class="alert alert-danger">
                                                                <button class="close" data-close="alert"></button>
                                                                <span> Test Failed  </span>
                                                            </div>');
                redirect(SITE_URL.'lab_test_report');
            }
            else
            {
                $tanker_id = $data['test_reports'][0]['tanker_id'];
                $data['tanker_id'] = $tanker_id;
                $loose_oil_id = $data['test_reports'][0]['loose_oil_id'];
                $test_groups = $this->Oil_lab_test_m->get_test_groups($loose_oil_id);
                $loose_oil_tests = array();

                foreach($test_groups as $test_group)
                {  
                    $results = $this->Oil_lab_test_m->get_tests($loose_oil_id,$test_group['test_group_id']);
                    foreach($results as $test_row)
                    {
                        //if range type is radio or dropdown 
                        if($test_row['range_type_id'] == 2 || $test_row['range_type_id'] == 3)
                        {
                            //get test options
                            $test_options = $this->Common_model->get_data('test_option',array('test_id'=>$test_row['test_id'],'status'=>1));
                            $test_row['options'] = $test_options;
                        }
                        $loose_oil_tests[$test_group['test_group_id']]['test'][$test_row['test_id']] = $test_row;
                    }
                    $loose_oil_tests[$test_group['test_group_id']]['group_name'] = $test_group['group_name'];
                }
                $data['loose_oil_tests'] = $loose_oil_tests;
                //$data['test_id'] = $data['loose_oil_tests'][1]['test'][1]['test_id'];
                
                $data['flag']=2;
                $data['form_action'] = SITE_URL.'confirm_lab_test_report';
                $data['reg_no']=$reg_no;
                $data['po_no'] =$po_no;
                $this->load->view('lab_test/lab_test_report',$data);    
                
            }
        }
    }

    public function confirm_lab_test_report()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Oil Lab Test Report Details";
        $data['nestedView']['pageTitle'] = 'Oil Lab Test Report Details';
        $data['nestedView']['cur_page'] = 'oil_lab_test';
        $data['nestedView']['parent_page'] = 'Logistics';
        $data['nestedView']['list_page'] = 'quality_check';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/test_reports.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Oil Lab Test Report Details', 'class' => 'active', 'url' => '');

        
        if($this->input->post('submit')==TRUE)
        {
            $po_no  =   $this->input->post('po_no');
            $reg_no =   $this->input->post('tank_reg_no');
            $plant_idd = $this->session->userdata('ses_plant_id');
            $tanker_idd = get_latest_tanker_id($reg_no,$plant_idd);
            $data['test_reports'] = $this->Oil_lab_test_m->test_report_details($po_no,$tanker_idd);
            $tanker_id = $data['test_reports'][0]['tanker_id'];
            $data['tanker_id'] = $tanker_id;
            $loose_oil_id = $data['test_reports'][0]['loose_oil_id'];
            $test_groups = $this->Oil_lab_test_m->get_test_groups($loose_oil_id);
            $loose_oil_tests = array();

            foreach($test_groups as $test_group)
            {  
                $results = $this->Oil_lab_test_m->get_tests($loose_oil_id,$test_group['test_group_id']);
                foreach($results as $test_row)
                {
                    //if range type is radio or dropdown 
                    if($test_row['range_type_id'] == 2 || $test_row['range_type_id'] == 3)
                    {
                        //get test options
                        $test_options = $this->Common_model->get_data('test_option',array('test_id'=>$test_row['test_id'],'status'=>1));
                        $test_row['options'] = $test_options;
                    }
                    $loose_oil_tests[$test_group['test_group_id']]['test'][$test_row['test_id']] = $test_row;
                }
                $loose_oil_tests[$test_group['test_group_id']]['group_name'] = $test_group['group_name'];
            }

            $data['loose_oil_tests'] = $loose_oil_tests;

            $tanker_id = $tanker_idd;
            $tanker_reg_no = $this->Common_model->get_data('tanker_register',array('tanker_id' => $tanker_id),'tanker_in_number');
            $test_result = $this->input->post('test_result');
            $data['test_result'] = $test_result;

            $overall_test_status = 1; $passed_tests_counter = 0; $oil_test_results = array();
            //looping test results
            foreach ($test_result as $test_id => $result) 
            {
                // get test details by test id
                $test_details = $this->Common_model->get_data_row('loose_oil_test',array('test_id' => $test_id));
                switch ($test_details['range_type_id']) 
                {
                    case 2: case 3: // Radio Or Dropdown
                         // check weather test passed or not
                        if($this->Oil_lab_test_m->check_oil_test_option($result,$test_id))
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
                        if($test_details['lower_limit'] != NULL && $test_details['upper_limit'] != NULL )
                        { 

                            if($test_details['lower_check'] == 1)
                            {
                                if($test_details['upper_check'] == 1)
                                {

                                    if($result >= $test_details['lower_limit'] && $result <= $test_details['upper_limit'])
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
                                    if($result >= $test_details['lower_limit'] && $result < $test_details['upper_limit'])
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
                                if($test_details['lower_limit'] == NULL)
                                { 
                                    if($test_details['upper_check'] == 1)
                                    {
                                        if($test_details['lower_limit'] == $result)
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
                                        if($test_details['lower_limit'] == $result)
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
                                    if($test_details['lower_check'] == 1)
                                    { 
                                        if($test_details['lower_limit'] == $result)
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
                                        
                                        if($test_details['lower_check'] == NULL && $test_details['upper_check'] ==NULL)
                                        {
                                            if($result > $test_details['lower_limit'] && $result < $test_details['upper_limit'])//solved
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
                                            if($result > $test_details['lower_limit'] && $result <= $test_details['upper_limit'])//solved
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
                            }
                        }
                        else if($test_details['lower_limit'] == NULL || $test_details['upper_limit'] == NULL)
                        {
                            
                            if($test_details['lower_limit'] == NULL)
                            {

                                if($test_details['upper_check'] == 1)
                                {
                                    if($result <= $test_details['upper_limit']) //solved
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
                                    if($test_details['lower_limit'] != NULL)
                                    {
                                        if($result < $test_details['lower_limit']) //solved
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
                                        if($test_details['upper_limit'] != NULL)
                                        {
                                           
                                            if($result < $test_details['upper_limit']) //solved
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
                            }
                            else if($test_details['lower_limit'] != NULL)
                            {
                                 
                                if($test_details['lower_check'] == 1)
                                {
                                    

                                    if($result >= $test_details['lower_limit']) //solved
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
                                    if($test_details['lower_limit'] < $result)
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

                $oil_test_results[$test_id]['result'] = $result;
                $oil_test_results[$test_id]['test_status'] = $test_status;
            }

            $_SESSION['lab_tests']=$_POST;
           // print_r($_SESSION['lab_tests']);exit;
            $data['oil_test_results'] = $oil_test_results;
            $data['overall_test_status'] = $overall_test_status;
        }
            $this->load->view('lab_test/confirm_lab_test_report',$data);
    }

    public function insert_lab_test_report()
    {
        #echo '<pre>'; print_r($_POST); die;
        
        if($this->input->post('submit')==TRUE)
        {
            $tanker_id = $this->input->post('tanker_id', TRUE);
            $tanker_reg_no = $this->Common_model->get_data('tanker_register',array('tanker_id' => $tanker_id),'tanker_in_number');
            $test_result = $this->input->post('test_result');

            // Inserting oil lab test
            $data = array(  'tanker_id'     =>  $tanker_id,
                            'test_number'   =>  get_test_number(),
                            'test_date'     =>  date('Y-m-d'),
                            'status'        =>  1,
                            'created_by'    =>  $this->session->userdata('user_id')
                        );
            $lab_test_id = $this->Common_model->insert_data('po_oil_lab_test',$data);

            $overall_test_status = 1; $passed_tests_counter = 0;
            //looping test results
            foreach ($test_result as $test_id => $result) 
            {
                // get test details by test id
                $test_details = $this->Common_model->get_data_row('loose_oil_test',array('test_id' => $test_id));
                switch ($test_details['range_type_id']) 
                {
                    case 2: case 3: // Radio Or Dropdown
                         // check weather test passed or not
                        if($this->Oil_lab_test_m->check_oil_test_option($result,$test_id))
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
                                    if($test_details['upper_limit']>=$result) // mahesh replaced lower_limit with upper_limit 29mar17
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
                                    if($test_details['upper_limit']>$result) // mahesh replaced lower_limit with upper_limit 29mar17
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
                                'test_id'       =>  $test_id,
                                'value'         =>  $result,
                                'status'        =>  $test_status
                            );
                $this->Common_model->insert_data('po_oil_lab_test_results',$data1);

            }
            
            // Update overall lab test status
            $data2 = array('status'=>$overall_test_status);
            $where2 = array('lab_test_id'=>$lab_test_id);
            $this->Common_model->update_data('po_oil_lab_test',$data2,$where2);

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
                                                        <strong>Success!</strong> Lab Test has been completed. Test Result is Passed! </div>');
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> Lab Test has been completed. Test Result is Failed. </div>');       
            }

            redirect(SITE_URL.'oil_test_results'.'/'.cmm_encode($lab_test_id)); 
        }
    }

    public function oil_test_results()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Oil Lab Test Results";
        $data['nestedView']['pageTitle'] = 'Oil Lab Test Results';
        $data['nestedView']['cur_page'] = 'oil_lab_test';
        $data['nestedView']['parent_page'] = 'Logistics';
        $data['nestedView']['list_page'] = 'quality_check';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/test_reports.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Oil Lab Test Results', 'class' => 'active', 'url' => '');

        $lab_test_id=@cmm_decode($this->uri->segment(2));
        if($lab_test_id == '')
        {
            redirect(SITE_URL);
        }
        else
        {   
            $tanker_id = $this->Common_model->get_value('po_oil_lab_test',array('lab_test_id'=>$lab_test_id),'tanker_id');
             $data['plant_idd'] = $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id),'plant_id');
            $data['test_number'] = $this->Common_model->get_value('po_oil_lab_test',array('lab_test_id'=>$lab_test_id),'test_number');
            $data['test_date'] = $this->Common_model->get_value('po_oil_lab_test',array('lab_test_id'=>$lab_test_id),'test_date');
            $po_oil_id = $this->Common_model->get_value('po_oil_tanker',array('tanker_id'=>$tanker_id),'po_oil_id');
            $po_no = $this->Common_model->get_value('po_oil',array('po_oil_id'=>$po_oil_id),'po_number');
            $reg_no = $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id),'tanker_in_number');

            $data['test_reports'] = $this->Oil_lab_test_m->test_report_details($po_no,$tanker_id);
            $data['results_list'] = $this->Oil_lab_test_m->get_list_of_test_results($tanker_id);

            $test_results=array();
            $result = $this->Oil_lab_test_m->get_test_results($lab_test_id);
            
            foreach($result as $results)
            {   
                if($results['range_type_id'] == 2 || $results['range_type_id'] == 3)
                {
                    //get test options
                    $test_options = $this->Common_model->get_data('test_option',array('test_id'=>$results['test_id'],'status'=>1));
                    $results['options'] = $test_options;
                    if(array_key_exists(@$keys, $test_results)) 
                    {
                        $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                    } 
                    else
                    {
                        $test_results[$results['test_group_id']]['test_group']=$results['test_group'];
                        $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                    }
                }
                else
                {
                    if(array_key_exists(@$keys, $test_results)) 
                    {
                        $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                    } 
                    else
                    {
                        $test_results[$results['test_group_id']]['test_group']=$results['test_group'];
                        $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                    }   
                }
            }
            # print_r($test_results);exit;
            $data['test_results']=$test_results;
            $this->load->view('lab_test/oil_test_results',$data);
        }  
    }

    public function print_oil_test_results()
    {
        $lab_test_id=@cmm_decode($this->uri->segment(2));
        if($lab_test_id == '')
        {
            redirect(SITE_URL);
        }
        else
        {   
            $tanker_id = $this->Common_model->get_value('po_oil_lab_test',array('lab_test_id'=>$lab_test_id),'tanker_id');
            $po_oil_id = $this->Common_model->get_value('po_oil_tanker',array('tanker_id'=>$tanker_id),'po_oil_id');
             $data['plant_idd'] = $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id),'plant_id');
            $data['test_number'] = $this->Common_model->get_value('po_oil_lab_test',array('lab_test_id'=>$lab_test_id),'test_number');
            $data['test_date'] = $this->Common_model->get_value('po_oil_lab_test',array('lab_test_id'=>$lab_test_id),'test_date');
            $po_no = $this->Common_model->get_value('po_oil',array('po_oil_id'=>$po_oil_id),'po_number');
            $reg_no = $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id),'tanker_in_number');

            $data['test_reports'] = $this->Oil_lab_test_m->test_report_details($po_no,$tanker_id);

            $test_results=array();
            $result = $this->Oil_lab_test_m->get_test_results($lab_test_id);
            
            foreach($result as $results)
            {   
                if($results['range_type_id'] == 2 || $results['range_type_id'] == 3)
                {
                    //get test options
                    $test_options = $this->Common_model->get_data('test_option',array('test_id'=>$results['test_id'],'status'=>1));
                    $results['options'] = $test_options;
                    if(array_key_exists(@$keys, $test_results)) 
                    {
                        $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                    } 
                    else
                    {
                        $test_results[$results['test_group_id']]['test_group']=$results['test_group'];
                        $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                    }
                }
                else
                {
                    if(array_key_exists(@$keys, $test_results)) 
                    {
                        $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                    } 
                    else
                    {
                        $test_results[$results['test_group_id']]['test_group']=$results['test_group'];
                        $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                    }   
                }
            }
            # print_r($test_results);exit;
            $data['test_results']=$test_results;

            $this->load->view('lab_test/print_oil_test_results',$data);
        }
    }
}