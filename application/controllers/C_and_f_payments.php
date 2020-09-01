<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

class c_and_f_payments extends Base_controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->model("C_and_f_m");
	}
    /* 
     	Created By 		:	Gowripriya 
     	Module 			:	 C_and_f payments
     	Created Time 	:	20th Feb 2017 6:30 pm
     	Modified Time 	:	
    */
	public function c_and_f()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "C&F DD Receipt";
        $data['nestedView']['pageTitle'] = 'C&F DD Receipt';
        $data['nestedView']['cur_page'] = 'c_and_f_dd';
        $data['nestedView']['parent_page'] = 'payment';
        $data['nestedView']['list_page'] = 'c_and_f_list';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/c_and_f.js"></script>';
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'C&F DD Receipt','class'=>'active','url'=>'');

        $data['plantlist'] =$this->C_and_f_m->get_plant_details();
        $data['bank']           = array(''=>'Select Bank')+$this->Common_model->get_dropdown('bank','bank_id','name');
        $data['payment_mode']   = array(''=>'Select payment mode')+$this->Common_model->get_dropdown('payment_mode','pay_mode_id','name');
                
        $this->load->view('c_and_f_payments/c_and_f_view',$data);
    }
    
    // inserting values in database
    public function insert_c_and_f()
    {           
        $amount       = $this->input->post('amount',TRUE);
        $bad_symbols  = array(",");
        $s_amount     = str_replace($bad_symbols, "", $amount);
        $payment_date = date('Y-m-d', strtotime($this->input->post('payment_date',TRUE)));
       
        $data = array( 
                'plant_id'          =>  $this->input->post('plant',TRUE),
                'dd_number'         =>  $this->input->post('dd_number',TRUE),
                'pay_mode_id'       =>  $this->input->post('payment_mode',TRUE),
                'payment_date'      =>  $payment_date,
                'amount'            =>  $s_amount,
                'bank_id'           =>  $this->input->post('bank',TRUE),
                'created_by'        =>  1/*$this->session->userdata('user_id')*/,
                'created_time'      =>  date('Y-m-d H:m:s')
                    );
                   
        $payment_id = $this->Common_model->insert_data('c_and_f_payment',$data);
         $this->db->trans_begin();
        $c_and_f_payments=$this->Common_model->get_data('c_and_f_payment',array('payment_id'=>$payment_id));
        $plant_id=$c_and_f_payments[0]['plant_id'];
        $outstanding_amount = $this->Common_model->get_value('c_and_f',array('plant_id'=>$plant_id),'outstanding_amount');
        if($outstanding_amount=='')
        {
            $outstanding_amount = 0;
        }
        $amount = $outstanding_amount+$s_amount;
        $this->Common_model->update_data('c_and_f',array('outstanding_amount'=>$amount),array('plant_id'=>$plant_id));
        

        if($this->db->trans_status() === FALSE)
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
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <strong>Success!</strong>DD has been Submitted Successfully </div>');
        }

         redirect(SITE_URL.'c_and_f');  
    }
    //validation for dd number
     public  function is_numberExist()
    {
        $dd_number = $this->input->post('dd_number');
       	echo $this->C_and_f_m->is_numberExist($dd_number);
    }

    /*c and f Payments details
    Author:Roopa
    Time: 11.26AM 21-02-2017 */	
    public function c_and_f_payments()
    {           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="C&F DD Payments List";
        $data['nestedView']['pageTitle'] = 'C&F DD Payments List';
        $data['nestedView']['cur_page'] = 'c_and_f_dd_view';
		$data['nestedView']['parent_page'] = 'payment';
		$data['nestedView']['list_page'] = 'c_and_f_list';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'C&F DD Payments List', 'class' => 'active', 'url' => '');   

        # Search Functionality
        $p_search=$this->input->post('search_c_and_f_payments', TRUE);
        if($p_search!='') 
        {
            $from_date = $this->input->post('from_date',TRUE);
            if($from_date!=''){ $fromdate = date('Y-m-d',strtotime($from_date)); } else { $fromdate = ''; }

            $to_date = $this->input->post('to_date',TRUE);
            if($to_date!=''){ $todate = date('Y-m-d',strtotime($to_date)); } else { $todate = ''; }

            $search_params=array(
                    'plant_id'           => $this->input->post('plant', TRUE),
                    'dd_number'          => $this->input->post('dd_number', TRUE),
                    'status'             => $this->input->post('status', TRUE),
                    'bank_id'            => $this->input->post('bank', TRUE),
                    'pay_mode_id'        => $this->input->post('pay_mode', TRUE),
                    'from_date'          => $fromdate,
                    'to_date'            => $todate,          
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'plant_id'          => $this->session->userdata('plant_id'),
                    'dd_number'         => $this->session->userdata('dd_number'),
                    'status'            => $this->session->userdata('status'),
                    'bank_id'           => $this->session->userdata('bank_id'),
                    'pay_mode_id'       => $this->session->userdata('pay_mode_id'),
                    'from_date'         => $this->session->userdata('from_date'), 
                    'to_date'           => $this->session->userdata('to_date'),   
                                  );
            }
            else 
            {
                $search_params=array(
                      'plant_id'          => '',
                      'dd_number'         => '',
                      'status'            => '',
                      'bank_id'           => '',
                      'pay_mode_id'       => '',
                      'from_date'         => '',
                      'to_date'           => ''       
                                 );
                $this->session->set_userdata($search_params);
            }            
        }
        $data['search_data'] = $search_params;
        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'c_and_f_payments/';
        # Total Records
        $config['total_rows'] = $this->C_and_f_m->c_and_f_payment_total_num_rows($search_params);
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
        //$data['status'] = array('' =>'Select status')+$this->Common_model->get_dropdown('distributor_payment','payment_id','status');
        $data['bank'] = array(''=>'Select Bank')+$this->Common_model->get_dropdown('bank','bank_id','name');
        $data['pay_mode'] = array(''=>'Select Pay mode')+$this->Common_model->get_dropdown('payment_mode','pay_mode_id','name');
        $data['plant'] = $this->C_and_f_m->get_plant_details();
        /* pagination end */
        # Loading the data array to send to View
        $data['c_and_f_payment_results'] = $this->C_and_f_m->c_and_f_payment_results($current_offset, $config['per_page'], $search_params);        
     
        # Additional data
        $data['display_results'] = 1;
        $this->load->view('c_and_f_payments/dd_verification',$data);
    }
    /*c and f Payments verification
    Author:Roopa
    Time: 11.26AM 21-02-2017 */   
     public function dd_verifications()
    {
        $payment_id=@cmm_decode($this->uri->segment(2));
        if($payment_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="C&F DD Verification";
        $data['nestedView']['pageTitle'] = 'C&F DD Verification';
        $data['nestedView']['cur_page'] = 'c_and_f_dd_view';
		$data['nestedView']['parent_page'] = 'payment';
		$data['nestedView']['list_page'] = 'c_and_f_list';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'C&F DD Payments List', 'class' => '', 'url' => SITE_URL.'c_and_f_payments');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'C&F DD Verification', 'class' => 'active', 'url' => '');
        
        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'dd_approvals';
        $data['display_results'] = 0;
        $data['bank'] = array(''=>'Select Bank')+$this->Common_model->get_dropdown('bank','bank_id','name');
        $data['pay_mode'] = array(''=>'Select Pay mode')+$this->Common_model->get_dropdown('payment_mode','pay_mode_id','name');
        $data['plant'] = $this->C_and_f_m->get_plant_details();

        # Data 
        $row = $this->Common_model->get_data('c_and_f_payment',array('payment_id'=>$payment_id));    
        $data['c_and_f_payment_row'] = $row[0];

        $plant_id=$row[0]['plant_id'];
        $row1= $this->Common_model->get_data('plant',array('plant_id'=>$plant_id));       
        $data['plant_id']=$row1[0];

        $pay_mode_id=$row[0]['pay_mode_id'];
        $row2= $this->Common_model->get_data('payment_mode',array('pay_mode_id'=>$pay_mode_id));       
        $data['pay_mode_id']=$row2[0];

        $bank_id=$row[0]['bank_id'];
        $row3= $this->Common_model->get_data('bank',array('bank_id'=>$bank_id));       
        $data['bank_id']=$row3[0];

       $plant_id = $this->Common_model->get_value('c_and_f_payment',array('payment_id'=>$payment_id),'plant_id'); 

       $data['outstanding_amount'] = $this->Common_model->get_value('c_and_f',array('plant_id'=>$plant_id),'outstanding_amount');

        $this->load->view('c_and_f_payments/dd_verification',$data);
    }
    /*c and f Payment approval details
    Author:Roopa
    Time: 11.26AM 21-02-2017 */
    public function dd_approvals()
    {

        $payment_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($payment_id==''){
            redirect(SITE_URL);
            exit;
        }  

        $val = $this->input->post('submit',TRUE);
        $candf_data = $this->Common_model->get_data('c_and_f_payment',array('payment_id'=>$payment_id));  
        $plant_id = $candf_data[0]['plant_id'];
        $amount = $candf_data[0]['amount'];  
        $outstanding_amount = $this->Common_model->get_value('c_and_f',array('plant_id'=>$plant_id),'outstanding_amount');
              
        $this->db->trans_begin();
        if($val==1)
        {
            $status = 2;
        }    
        else if($val==2)
        {
            $sum = $outstanding_amount-$amount;
            $this->Common_model->update_data('c_and_f',array('outstanding_amount'=>$sum),array('plant_id'=>$plant_id));
            $status = 3;            
        }
        $date = date('Y-m-d',strtotime($this->input->post('payment_date',TRUE)));
        
        $insert_data = array(
                 'pay_mode_id'  => $this->input->post('pay_mode',TRUE),
                 'plant_id'     => $this->input->post('plant_id',TRUE),
                 'bank_id'      => $this->input->post('bank',TRUE),
                 'dd_number'    => $this->input->post('dd_number',TRUE),
                 'payment_date' => $date,
                 'status'       => $status,
                 'verified_by'  => $this->session->userdata('user_id'),
                 'verified_time'=> date('Y-m-d H:i:s'),
                 'remarks2'     => $this->input->post('remarks2'));
        $this->Common_model->update_data('c_and_f_payment',$insert_data,array('payment_id'=>$payment_id));

       
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
            <strong>Success!</strong>  DD Verification has been completed succesfully..! </div>');
        }
        redirect(SITE_URL.'c_and_f_payments');  
    }
    /*download c and f Payments details
    Author:Roopa
    Time: 11.26AM 21-02-2017 */
    public function download_c_and_f_payments()
    {
        if($this->input->post('download_c_and_f_payments')!='') 
        {
            $search_params=array(
                    'plant_id'          => $this->session->userdata('plant_id'),
                    'dd_number'         => $this->session->userdata('dd_number'),
                    'status'            => $this->session->userdata('status'),
                    'bank_id'           => $this->session->userdata('bank_id'),
                    'pay_mode_id'       => $this->session->userdata('pay_mode_id'),
                    'from_date'         => $this->session->userdata('from_date'), 
                    'to_date'           => $this->session->userdata('to_date'),   
                                  );
           // print_r($search_params);exit;
            $c_and_f_payment = $this->C_and_f_m->c_and_f_payment_details($search_params);            
            $header = '';
            $data ='';
            $titles = array('S.NO','dd number/Date','c and f','unit','bank','amount');
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
            if(count($c_and_f_payment)>0)
            {                
                foreach($c_and_f_payment as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['dd_number'].'/'.date('d-m-Y',strtotime($row['payment_date'])).'</td>';  
                    $data.='<td align="center">'.$row['plant_name'].'</td>'; 
                    $data.='<td align="center">'.$row['unit_name'].'</td>'; 
                    $data.='<td align="center">'.$row['bank_name'].'</td>';  
                    $data.='<td align="right">'.price_format($row['amount']).'</td>';
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
            $xlFile='c_and_f_payment'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
        }
    }
    /* Adding C and F credit debit notes
    Author:Aswini
    Time:21-02-2017*/
    
    public function c_and_f_credit_debit_notes()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Add C&F Credit/Debit";
        $data['nestedView']['pageTitle'] = 'Add C&F Credit/Debit';
        $data['nestedView']['cur_page'] = 'c_and_f_credit_debit_note';
        $data['nestedView']['parent_page'] = 'payment';
        $data['nestedView']['list_page'] = 'c_and_f_list';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/c_and_f_credit_debit.js" type="text/javascript"></script>';
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'C&F Credit/Debit List', 'class' => '', 'url' =>SITE_URL.'c_and_f_credit_debit_note'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Add C&F Credit/Debit','class'=>'active','url'=>'');

        #data 
        $data['plantdetails'] = $this->C_and_f_m->get_plant_details();
        $this->load->view('c_and_f_payments/c_and_f_credit_debit_notes',$data);
    }
    /* getting purpose list
    Author:Aswini
    Time:21-02-2017*/
    public function getpurpose()
    {
        $type_id = $this->input->post('type_id',TRUE);
        echo $this->C_and_f_m->getpurpose($type_id);
    }
   /* Inserting C and F credit debit notes
    Author:Aswini
    Time:21-02-2017*/
    public function insert_c_and_f_credit_debit()
    {       
            $amount       = $this->input->post('amount',TRUE);
            $bad_symbols  = array(",");
            $s_amount     = str_replace($bad_symbols, "", $amount);
            $note_type = $this->input->post('note_type');
            
            $purpose_id=$this->input->post('purpose_id');
            /*$a=($purpose_id==9999)?NULL:$purpose_id;
            echo $a; exit();*/

            $date = date('Y-m-d',strtotime($this->input->post('on_date',TRUE)));
            // GETTING INPUT TEXT VALUES
            $data=array(
                        'plant_id'          =>     $this->input->post('plant_id'),
                        'amount'            =>     $s_amount,                       
                        'on_date'           =>     $date,
                        'note_type'         =>     $this->input->post('note_type'),
                        'remarks'           =>     $this->input->post('reason'),
                        'created_by'        =>     $this->session->userdata('user_id')
                        
                        );
            if($purpose_id!=9999)
            {
                $data['purpose_id']=$purpose_id;
            }
            $this->db->trans_begin();
            $note_id = $this->Common_model->insert_data('c_and_f_credit_debit_note',$data);
            $c_and_f_credit_debit_note=$this->Common_model->get_data('c_and_f_credit_debit_note',array('note_id'=>$note_id));
            $plant_id=$c_and_f_credit_debit_note[0]['plant_id'];
            
            $outstanding_amount = $this->Common_model->get_value('c_and_f',array('plant_id'=>$plant_id),'outstanding_amount');
            if($note_type==1)//credit
            {
                $sum = $outstanding_amount+$s_amount;
            }
            else if($note_type==2)//debit
            {
                $sum = $outstanding_amount-$s_amount;
            }
            $this->Common_model->update_data('c_and_f',array('outstanding_amount'=>$sum),array('plant_id'=>$plant_id));
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
                <strong>Success!</strong> credit/debit has been added successfully! </div>');
            }
        
            
          redirect(SITE_URL.'c_and_f_credit_debit_notes');
    }
}