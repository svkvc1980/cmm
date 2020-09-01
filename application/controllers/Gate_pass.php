<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 15th Nov 2016 09:00 AM

class Gate_pass extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Gate_pass_model");
    }

      public function gate_pass()
      { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Gate Pass";
        $data['nestedView']['pageTitle'] = 'Gate Pass';
        $data['nestedView']['cur_page'] = 'gate_pass';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Gate Pass', 'class' => 'active', 'url' =>'');
        

        $data['flag']=1;
         $this->session->unset_userdata('gate_pass1');
        $this->load->view('gate_pass/gate_pass',$data);
    }

    public function add_gate_pass()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add Gate Pass";
        $data['nestedView']['pageTitle'] = 'Add Gate Pass';
        $data['nestedView']['cur_page'] = 'gate_pass';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/gate_pass.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Gate Pass', 'class' => '', 'url' => SITE_URL . 'gate_pass');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add Gate Pass', 'class' => '', 'url' =>'');
        @$gate_pass1 = $_SESSION['gate_pass1'];
        if($this->input->post('submit') || isset($gate_pass1))
        {
            $tanker_in_no= ($this->input->post('tanker_in_no')!='')?$this->input->post('tanker_in_no'):$gate_pass1['tanker_in_no'];
            $tanker_type_id=get_empty_truck_id();
            $res=$this->Gate_pass_model->get_tanker_no_details($tanker_in_no,$tanker_type_id);
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

    public function generate_gate_pass()
    {
        if($this->input->post('submit'))
        {
            //Retreving Max Gate pass  number from gatepass
            $gatepass_number=get_current_serial_number(array('value'=>'gatepass_number','table'=>'gatepass','where'=>'created_time'));
            $invoice_no=$this->input->post('invoice_number');
            $number=array();
            foreach($invoice_no as $key =>$value)
            {
                 $invoice=$this->Common_model->get_data_row('invoice',array('invoice_number'=>$value),array('invoice_id')); 
                 $count=$this->Gate_pass_model->get_invoice_count($invoice['invoice_id']);
                 if($invoice['invoice_id']<=0  || $count >0) 
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
                $gatepass_id=$this->Gate_pass_model->insert_gate_pass_data($tanker_id,$dat);
                $waybill_number=$this->input->post('waybill_number');
                foreach($invoice_no as $key =>$value)
                {
                     $invoice=$this->Gate_pass_model->get_latest_invoice_id($value); 
                     if($invoice['invoice_id']>0) 
                     {
                        $dat1=array(
                            'gatepass_id' => $gatepass_id,
                            'invoice_id'  => $invoice['invoice_id'],
                            'waybill_number'=>$waybill_number[$key]

                            );
                        $this->Gate_pass_model->insert_gate_pass_invoice($dat1,$invoice['invoice_id']);
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
      * Function   : List of Gatepass Generated
      * Developer  :  Prasad created on: 26th Feb 9 PM updated on:      
    */
    public function gate_pass_list()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Gate Pass List";
        $data['nestedView']['pageTitle'] = 'Gate Pass List';
        $data['nestedView']['cur_page'] = 'gate_pass';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Gate Pass List', 'class' => '', 'url' => '');
        
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
        //print_r($data['search_params']); exit();
        
         # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'gate_pass_list/';
        # Total Records
        $config['total_rows'] = $this->Gate_pass_model->get_gate_pass_list_total_num_rows($search_params);

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
        $data['view_gate_pass_list_results'] = $this->Gate_pass_model->view_gate_pass_results($search_params, $config['per_page'] ,$current_offset);
        # Additional data
        
        $data['flag']=1;
        $this->load->view('gate_pass/gatepass_list',$data);        
    }
     public function print_gate_pass_list()
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
            $details=$this->Gate_pass_model->get_gate_pass_details($gatepass_id);
            $data['details']=$details;
            $gate_pass=$this->Gate_pass_model->get_gate_invoice_details($gatepass_id);
            foreach($gate_pass as $key=> $row )
            {
                $gatepass_results[$row['invoice_id']]['invoice']=$row['invoice_number'];
                $gatepass_results[$row['invoice_id']]['waybill_number']=$row['waybill_number'];
                $products=$this->Gate_pass_model->get_do_products_details($row['invoice_id']);
                $gatepass_results[$row['invoice_id']]['products']=$products;
            }
            //print_r($gatepass_results);exit;
            $data['gatepass_results']=$gatepass_results;
            $this->load->view('gate_pass/print_gatepass_list',$data);  
        }
    }

       /** MOUNIKA 30 APR 2017 GATE PASS DELETE   START **/
     public function gate_pass_delete()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Delete Gate Pass";
        $data['nestedView']['pageTitle'] = 'Delete Gate Pass';
        $data['nestedView']['cur_page'] = 'gate_pass_delete';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Delete Gate Pass', 'class' => 'active', 'url' =>'');
        

        $data['flag']=1;
        //$this->session->unset_userdata('gate_pass1');
        $this->load->view('gate_pass/gate_pass_delete',$data);
    }

     public function gate_pass_delete_details()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Gate Pass Details";
        $data['nestedView']['pageTitle'] = 'Gate Pass Details';
        $data['nestedView']['cur_page'] = 'gate_pass_delete';
        $data['nestedView']['parent_page'] = 'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Gate Pass', 'class' => 'active', 'url' =>SITE_URL . 'gate_pass_delete');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Gate Pass Details', 'class' => 'active', 'url' =>'');

        $gatepass_number=$this->input->post('gate_pass_number');
        
        $row=$this->Gate_pass_model->get_gatepass_details($gatepass_number);
        //echo $this->db->last_query();print_r($row);//exit;
        if($row)
        {  
            $data['gate_pass']=$row;
            $gate_pass_id=$row['gatepass_id'];

           // $data['gate_pass']=$gate_pass;
            $data['gate_pass_invoice']=$this->Gate_pass_model->get_invoice_gatepass_details($gate_pass_id);
           // print_r($data['gate_pass_invoice']); exit;
            $data['flag']=2;
            $this->load->view('gate_pass/gate_pass_delete',$data);
            //print_r($data['edit_tanker']);exit;
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                      <strong>Error!</strong> Gate Pass Number not exist! Please check </div>');  
             redirect(SITE_URL.'gate_pass_delete');      
        }
    }
    public function delete_gp_delete()
    {
        if($this->input->post('submit'))
        {
            $gate_pass_id=$this->input->post('gatepass_id');
            $invoice_no=$this->input->post('invoice_no');
            $waybill_no=$this->input->post('waybill_no');
            $tanker_id=$this->input->post('tanker_id');
            foreach($invoice_no as $key =>$value)
            {
                $d[]=array('invoice_no' => $value,
                           'waybill_number'=>$waybill_no[$key]
                    );
            }
            $invoice_details=json_encode($d);
            $this->db->trans_begin();
            $insert_array=array(
                'on_date'         =>  $this->input->post('on_date'),
                'tanker_id'       =>  $this->input->post('tanker_id'),
                'created_time'    =>  date('Y-m-d h:i:s'),
                'created_by'      =>  $this->session->userdata('user_id'),
                'gatepass_id'     =>  $gate_pass_id,
                'remarks'         =>  $this->input->post('remarks'),
                'gatepass_number' =>  $this->input->post('gatepass_number'),
                'invoice_details' =>  $invoice_details 
                );
              $this->Common_model->delete_data('gatepass_invoice',array('gatepass_id'=>$gate_pass_id));
            $this->Common_model->delete_data('gatepass',array('gatepass_id'=>$gate_pass_id));
          
            $this->Common_model->insert_data('gatepass_history',$insert_array);
            // updating tanker in status to 2
            $this->Common_model->update_data('tanker_register',array('status'=>2),array('tanker_id'=>$tanker_id));

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
                                                            <strong>Success!</strong> Gatepass('.$insert_array['gatepass_number'].') is deleted successfully! </div>');      
            }
            redirect(SITE_URL.'gate_pass_delete'); 

        }
    }
    /** MOUNIKA 30 APR 2017 GATE PASS DELETE   END **/
   
}