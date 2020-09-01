<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 15th Nov 2016 09:00 AM

class Plant_gate_pass extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Plant_gate_pass_model");
    }

      public function plant_gate_pass()
      { 
        # Data Array to carry the require fields to View and Model
        $plant_name = $this->session->userdata('plant_name');
        $data['nestedView']['heading']="$plant_name Gate Pass";
        $data['nestedView']['pageTitle'] = "$plant_name Gate Pass";
        $data['nestedView']['cur_page'] = 'gate_pass';
        $data['nestedView']['parent_page'] = 'gate_pass';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/gate_pass.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => "$plant_name Gate Pass", 'class' => '', 'url' =>'');
        

        $data['flag']=1;
         $this->session->unset_userdata('gate_pass1');
        $this->load->view('plant_gate_pass/plant_gate_pass',$data);
    }

    public function add_plant_gate_pass()
    { 
        # Data Array to carry the require fields to View and Model
        
        $plant_name = $this->session->userdata('plant_name');
        $data['nestedView']['heading']="Add $plant_name Gate Pass";
        $data['nestedView']['pageTitle'] = "Add $plant_name Gate Pass";
        $data['nestedView']['cur_page'] = 'add_gate_pass';
        $data['nestedView']['parent_page'] = 'add_gate_pass';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/gate_pass.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => "$plant_name Gate Pass", 'class' => '', 'url' => SITE_URL . 'plant_gate_pass');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => "Add $plant_name Gate Pass", 'class' => '', 'url' =>'');
        @$gate_pass1 = $_SESSION['gate_pass1'];
        if($this->input->post('submit') || isset($gate_pass1))
        {
            $tanker_in_no= ($this->input->post('tanker_in_no')!='')?$this->input->post('tanker_in_no'):$gate_pass1['tanker_in_no'];
            $tanker_type_id=get_empty_truck_id();
            $plant_id=$this->session->userdata('plant_id');
            $res=$this->Plant_gate_pass_model->get_tanker_no_details($tanker_in_no,$tanker_type_id,$plant_id);
            $count=$res[0];

            if($count > 0)
            {  $results=$res[1];
                if($results['status']==1)
               {    
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong>Please complete weighbride tier weight process to generate gatepass!
                             </div>');

                redirect(SITE_URL.'gate_pass');exit;
               } 
               else if($results['status']==3)
               {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong>Please complete weighbride gross weight process.  gatepass is already generated!
                             </div>');

                redirect(SITE_URL.'gate_pass');exit;
               }
                else if($results['status']==4)
               {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong>Move to tanker out. gatepass is already generated!
                             </div>');

                redirect(SITE_URL.'gate_pass');exit;
               } 
                else if($results['status']==5)
               {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong>Tanker is out. gatepass is already generated!
                             </div>');

                redirect(SITE_URL.'gate_pass');exit;
               }  
                else
                {
                //Retreving Max Gate pass  number from gatepass
                $data['gatepass_number']=get_current_serial_number(array('value'=>'gatepass_number','table'=>'gatepass','where'=>'created_time'));
                $data['results']=$res[1];
                $data['flag']=2;
                $data['gate_pass1']=$gate_pass1;
                $this->load->view('gate_pass/gate_pass',$data);
                }
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong> Invalid Tanker Registration Number!
                             </div>');

               redirect(SITE_URL.'gate_pass'); exit;
            }

        }

      
    }

    public function is_invoice_numberExist()
    {
        $invoice_no = $this->input->post('invoice_no');
        $invoice=$this->Common_model->get_data_row('invoice',array('invoice_number'=>$invoice_no),array('invoice_id'));
        if($invoice['invoice_id'] > 0)
        {
           echo 0;
        }
        else
        {
            echo 1;
        }
    }

    public function generate_plant_gate_pass()
    {
        if($this->input->post('submit'))
        {
            //Retreving Max Gate pass  number from gatepass
            $gatepass_number=get_current_serial_number(array('value'=>'gatepass_number','table'=>'gatepass','where'=>'created_time'));
            $invoice_no=$this->input->post('invoice_no');
            $number=array();
            foreach($invoice_no as $key =>$value)
            {
                 $invoice=$this->Common_model->get_data_row('invoice',array('invoice_number'=>$value),array('invoice_id')); 
                 if($invoice['invoice_id']<=0) 
                 { 
                   $number=implode(',',$invoice_no);
                 }
            }
            if(count($number)>0)
            {
                  
                   $_SESSION['gate_pass1'] = $_POST;
                  // print_r($_POST); exit;
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong> Invalid '.$number.' invoice numbers!
                             </div>');

               redirect(SITE_URL.'add_gate_pass'); exit;


            }
            else
            {
                $tanker_id=$this->input->post('tanker_id');
                $this->db->trans_begin();
                $dat=array(
                        'tanker_id'        =>   $this->input->post('tanker_id'),
                        'remarks'          =>   $this->input->post('remarks'),
                        'on_date'          =>    date('Y-m-d'),
                        'created_by'       =>   $this->session->userdata('user_id'),
                        'gatepass_number'  =>   $gatepass_number
                );
                $gatepass_id=$this->Plant_gate_pass_model->insert_gate_pass_data($tanker_id,$dat);
                foreach($invoice_no as $key =>$value)
                {
                     $invoice=$this->Common_model->get_data_row('invoice',array('invoice_number'=>$value),array('invoice_id')); 
                     if($invoice['invoice_id']>0) 
                     {
                        $dat1=array(
                            'gatepass_id' => $gatepass_id,
                            'invoice_id'  => $invoice['invoice_id'],
                            'created_by'  => $this->session->userdata('user_id')
                            );
                        $this->Plant_gate_pass_model->insert_gate_pass_invoice($dat1,$invoice['invoice_id']);
                     } 


                }
                $block_id = $this->Common_model->get_value('user',array('user_id'=>$this->session->userdata('user_id')),'block_id');
                if($block_id == 2) 
                { 
                    $status = 3; 
                }
                else
                { 
                    $status = 4;
                }

                $this->Common_model->update_data('tanker_register',array('status' =>$status),array('tanker_id'=>$tanker_id));

                 if($this->db->trans_status()===FALSE)
                {
                  $this->db->trans_rollback();
                }
                else
                {
                  $this->db->trans_commit();
                  $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Success!</strong>Gate pass is generated successfully! </div>');

                }

            }
             redirect(SITE_URL.'gate_pass'); exit;
            
        }
    }

     /*
      * Function   : List of Gatepass Generated for plant
      * Developer  :  Prasad created on: 26th Feb 9 PM updated on:      
    */
    public function plant_gate_pass_list()
    {
        # Data Array to carry the require fields to View and Model
         $plant_name = $this->session->userdata('plant_name');
        $data['nestedView']['heading']="$plant_name Gate Pass List";
        $data['nestedView']['pageTitle'] = "$plant_name Gate Pass List";
        $data['nestedView']['cur_page'] = 'gate_pass_list';
        $data['nestedView']['parent_page'] = 'gate_pass_list';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => "$plant_name Gate Pass List", 'class' => '', 'url' => '');
        
        # Search Functionality
        $psearch=$this->input->post('submit', TRUE);
        if($psearch!='') {
            $date = $this->input->post('on_date');
            if($date=='')
            {
                $date = '';
            }
            else
            {
                $date = date('Y-m-d',strtotime($this->input->post('on_date')));
            }
        $search_params=array(
                        'tanker_in_number' => $this->input->post('tanker_in_number', TRUE),
                        'gatepass_number'  => $this->input->post('gatepass_number',TRUE),
                        'on_date'          => $date   
                              );
         $this->session->set_userdata($search_params);
        } else {
            
            if($this->uri->segment(2)!='')
            {
            $search_params=array(
                        'tanker_in_number' => $this->session->userdata('tanker_in_number'),
                        'gatepass_number'  => $this->session->userdata('gatepass_number'),
                        'on_date'          => $this->session->userdata('on_date')
                              );
            }
            else {
                $search_params=array(
                        'tanker_in_number' =>  '',
                        'gatepass_number'  =>  '',
                        'on_date'          =>  ''
                                  );
                 $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_params'] = $search_params;
        $plant_id=$this->session->userdata('plant_id');
        
        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'plant_gate_pass_list/';
        # Total Records
        $config['total_rows'] = $this->Plant_gate_pass_model->get_gate_pass_list_total_num_rows($search_params);

        $config['per_page'] = getDefaultPerPageRecords_ops();
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
        $data['view_gate_pass_list_results'] = $this->Plant_gate_pass_model->view_gate_pass_results($search_params, $config['per_page'] ,$current_offset);
        # Additional data
        
        $data['flag']=1;
        $this->load->view('plant_gate_pass/plant_gatepass_list',$data);        
    }

   /* public function print_gate_pass_list()
    {
         $gatepass_id=@cmm_decode($this->uri->segment(2));
        if($gatepass_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
        else
        {   
            $gatepass_results=array();
            $details=$this->Plant_gate_pass_model->get_gate_pass_details($gatepass_id);
            $data['details']=$details;
            $gate_pass=$this->Plant_gate_pass_model->get_gate_invoice_details($gatepass_id);
            foreach($gate_pass as $key=> $row )
            {
                $gatepass_results[$row['invoice_id']]['invoice']=$row['invoice_number'];
                $products=$this->Plant_gate_pass_model->get_do_products_details($row['invoice_id']);
                $gatepass_results[$row['invoice_id']]['products']=$products;
            }
          
            $data['gatepass_results']=$gatepass_results;
            $this->load->view('gate_pass/print_gatepass_list',$data);    

        }
    }*/
}