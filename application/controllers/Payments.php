<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

class Payments extends Base_controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->model("Payment_model");
	}
    
/* Adding distributor credit debit notes
    Author:Aswini
    Time:15-02-2017*/
	
    public function credit_debit_notes()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Distributor Credit/Debit";
		$data['nestedView']['pageTitle'] = 'Distributor Credit/Debit';
		$data['nestedView']['cur_page'] = 'distributor_credit_debit_note';
		$data['nestedView']['parent_page'] = 'payment';
        $data['nestedView']['list_page'] = 'distributor_list';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/credit_debit.js" type="text/javascript"></script>';
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>' Distributor Credit/Debit','class'=>'active','url'=>'');

		#data 
		/*$data['distributor']=$this->Common_model->get_dropdown('distributor','distributor_id','concerned_person',array(''));*/
        $data['distributor']    = $this->Payment_model->get_active_distributor();
		$this->load->view('payment_receipts/credit_debit_notes',$data);
	}
    /* getting purpose list
    Author:Aswini
    Time:16-02-2017*/
	public function getpurpose()
    {
    	$type_id = $this->input->post('type_id',TRUE);
    	echo $this->Payment_model->getpurpose($type_id);
    }
   /* Inserting distributor credit debit notes
    Author:Aswini
    Time:16-02-2017*/
	public function insert_credit_debit()
	{       
            $amount       = $this->input->post('amount',TRUE);
            $bad_symbols  = array(",");
            $s_amount     = str_replace($bad_symbols, "", $amount);
			$purpose_id   =  $this->input->post('purpose_id');
            $distributor_id =$this->input->post('distributor_id',TRUE);
            $where_dis = array('distributor_id'=>$distributor_id);
            $note_type = $this->input->post('note_type',TRUE);
			$date = date('Y-m-d',strtotime($this->input->post('on_date',TRUE)));
           
		    // GETTING INPUT TEXT VALUES
			$data = array(
						'distributor_id'	=>	   $distributor_id,
						'amount'			=>	   $s_amount,						
						'on_date'			=>	   $date,
						'note_type'			=>	   $note_type,
						'remarks'           =>     $this->input->post('reason'),
						'created_by'	    =>     $this->session->userdata('user_id')
						);            
		    if($purpose_id!=9999)
		    {
		    	$data['purpose_id']=$purpose_id;
		    }
            $this->db->trans_begin();
			$this->Common_model->insert_data('distributor_credit_debit_note',$data);
            $outstanding_amount = $this->Common_model->get_value('distributor',array('distributor_id'=>$distributor_id),'outstanding_amount');
           if($note_type==1)//credit
            {
                $sum = $outstanding_amount+$s_amount;
                // Modified By Maruthi on 27th April'17 12:10PM
                // inserting in distributor transaction table
                $dist_trans_data = array(
                                'distributor_id'        => $distributor_id,
                                'trans_type_id'         => 1,
                                'trans_amount'          => ($s_amount),
                                'outstanding_amount'    => $sum, 
                                'remarks'               => 'Credit',
                                'trans_date'            => date('Y-m-d'),
                                'created_by'            =>  $this->session->userdata('user_id'),
                                'created_time'          => date('Y-m-d H:m:s')
                    );
                //echo '<pre>';print_r($dist_trans_data);exit;
                $this->Common_model->insert_data('distributor_trans',$dist_trans_data);
            }
            else if($note_type==2)//debit
            {
                $sum = $outstanding_amount-$s_amount;
                // Modified By Maruthi on 27th April'17 12:10PM
                // inserting in distributor transaction table
                $dist_trans_data = array(
                                'distributor_id'        => $distributor_id,
                                'trans_type_id'         => 2,
                                'trans_amount'          => (-$s_amount),
                                'outstanding_amount'    => $sum, 
                                'remarks'               => 'Debit',
                                'trans_date'            => date('Y-m-d'),
                                'created_by'            =>  $this->session->userdata('user_id'),
                                'created_time'          => date('Y-m-d H:m:s')
                    );
                //echo '<pre>';print_r($dist_trans_data);exit;
                $this->Common_model->insert_data('distributor_trans',$dist_trans_data);
            }
            $this->Common_model->update_data('distributor',array('outstanding_amount'=>$sum),$where_dis);
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
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <strong>Success!</strong>credit note has been added Successfully</strong> </div>');
	        }
	        
	        
	      redirect(SITE_URL.'credit_debit_notes');
	}
    /* verification of credit debit list
    Author:Aswini
    Time:17-02-2017*/

     public function cd_verification_dis()
    {
        $note_id=@cmm_decode($this->uri->segment(2));
        if($note_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor Credit/Debit Verification";
        $data['nestedView']['pageTitle'] = 'Distributor C/D Verification';
        $data['nestedView']['cur_page'] = 'distributor_credit_debit_note';
        $data['nestedView']['parent_page'] = 'payment';
        $data['nestedView']['list_page'] = 'distributor_list';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
       
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor C/D List', 'class' => '', 'url' => SITE_URL.'distributor_payments');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor C/D Verification', 'class' => 'active', 'url' => '');
        
        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'cd_approval_dis';
        $data['display_results'] = 0;

        # Data 
        $row = $this->Common_model->get_data('distributor_credit_debit_note',array('note_id'=>$note_id));   
        $data['credit_debit_row'] = $row[0];

        $distributor_id=$row[0]['distributor_id'];
        $row1= $this->Common_model->get_data('distributor',array('distributor_id'=>$distributor_id));       
        $data['distributor_id']=$row1[0];        

        $purpose_id=$row[0]['purpose_id'];
        $row2= $this->Common_model->get_data('credit_debit_purpose',array('purpose_id'=>$purpose_id));
        $data['purpose']=$row2;

        $this->load->view('payment_receipts/credit_debit_notes',$data);
    }
    /* Approval of credit debit notes
    Author:Aswini
    Time:17-02-2017*/
    public function cd_approval_dis()
    {
        
        $note_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($note_id==''){
            redirect(SITE_URL);
            exit;
        }  
        $val = $this->input->post('submit',TRUE);
        $amount= $this->input->post('amount');
        $os_amount=$this->input->post('outstanding_amount');
        $distributor_id = $this->input->post('distributor_id');
        $note_type = $this->Common_model->get_value('distributor_credit_debit_note',array('note_id'=>$note_id),'note_type');

        // GETTING INPUT TEXT VALUES   
        $this->db->trans_begin(); 
        if($val==2)
        {
            $status = 2; 
            if($note_type==1){ $total=$os_amount+$amount; }
            else if($note_type==2){ $total=$os_amount-$amount;}  
            $this->Common_model->update_data('distributor',array('outstanding_amount'=>$total),array('distributor_id'=>$distributor_id));       
        }
        else
        {
            $status = 3;
        }
        
        
        $data = array(
                    'status'            => $status, 
                    'remarks2'           => $this->input->post('remarks2',TRUE),               
                    'verified_by'       => $this->session->userdata('user_id'),
                    'verified_time'     => date('Y-m-d H:i:s')                    
                    );
        
        $where = array('note_id'=>$note_id);
        $this->Common_model->update_data('distributor_credit_debit_note',$data,$where);
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
            <strong>Success!</strong>  CD Verification has been completed succesfully..! </div>');
                 
        }
        redirect(SITE_URL.'distributor_credit_debit_note'); 
    }
    /* Downloading distributor credit debit notes
    Author:Aswini
    Time:17-02-2017*/


   public function download_credit_debit_note()
    {
        if($this->input->post('download_credit_debit_note')!='') 
        {
            $on_date=(($this->input->post('on_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('on_date', TRUE))):''; 
            $search_params=array(
                 'distributor_id'      => $this->input->post('concerned_name', TRUE),
                 'on_date'             => $on_date,
                 'note_type'           => $this->input->post('type', TRUE),
                 'purpose_id'          => $this->input->post('purpose', TRUE)                                
                                );
            $distributor = $this->Payment_model->credit_debit_details($search_params);            
            $header = '';
            $data ='';
            $titles = array('S.NO','Distributor','Amount','on_date','Type','Purpose','Remarks');
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
            if(count($distributor)>0)
            {                
                foreach($distributor as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['concerned_name'].'</td>'; 
                    $data.='<td align="center">'.$row['amount'].'</td>'; 
                    $data.='<td align="center">'.$row['on_date'].'</td>';
                    $data.='<td align="center">'.$row['note_type'].'</td>';
                    $data.='<td align="center">'.$row['purpose_name'].'</td>';                                           
                    $data.='<td align="center">'.$row['remarks'].'</td>';  
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
            $xlFile='distributor_credit_debit_note'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
        }
    }

    /*distributor Payments details
Author:Roopa
Time: 11.26AM 17-02-2017 */ 
     public function distributor_payments()
    {           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor D.D. List";
        $data['nestedView']['pageTitle'] = 'Distributor D.D. List';
        $data['nestedView']['cur_page'] = 'distributor_dd_verify';
        $data['nestedView']['parent_page'] = 'payment';
        $data['nestedView']['list_page'] = 'distributor_list';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor D.D. List', 'class' => 'active', 'url' => '');  
        $data['distributor']    = $this->Payment_model->get_active_distributor();

        # Search Functionality
        $p_search=$this->input->post('search_distributor_payments', TRUE);
        if($p_search!='') 
        {
            $from_date = $this->input->post('from_date',TRUE);
            if($from_date!=''){ $fromdate = date('Y-m-d',strtotime($from_date)); } else { $fromdate = ''; }
            $to_date = $this->input->post('to_date',TRUE);
            if($to_date!=''){ $todate = date('Y-m-d',strtotime($to_date)); } else { $todate = ''; }
            $search_params=array(
                'distributor_id'     => $this->input->post('distributor', TRUE),
                'dd_number'          => $this->input->post('dd_number', TRUE),
                'status'             => $this->input->post('status', TRUE),
                'bank_id'            => $this->input->post('bank', TRUE),
                'pay_mode_id'        => $this->input->post('pay_mode', TRUE),
                'from_date'	     => $fromdate,
                'to_date'	     => $todate,
                'plant_id'	     => $this->input->post('plant_id',TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'distributor_id'    => $this->session->userdata('distributor_id'),
                    'dd_number'         => $this->session->userdata('dd_number'),
                    'status'            => $this->session->userdata('status'),
                    'bank_id'           => $this->session->userdata('bank_id'),
                    'pay_mode_id'       => $this->session->userdata('pay_mode_id'),    
                    'from_date'       => $this->session->userdata('from_date'), 
                    'to_date'       => $this->session->userdata('to_date'),
                    'plant_id'       => $this->session->userdata('plant_id')   
                                  );
            }
            else 
            {
                $search_params=array(
                      'distributor_id'    => '',
                      'dd_number'         => '',
                      'status'            => 1, // Default: Pending items will display
                      'bank_id'           => '',
                      'pay_mode_id'       => '',
                      'from_date'	  => '',
                      'to_date'		  => '',
                      'plant_id'	  => ''      
                                 );
                $this->session->set_userdata($search_params);
            }            
        }
        $data['search_data'] = $search_params;
        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'distributor_payments/';
        # Total Records
        $config['total_rows'] = $this->Payment_model->distributor_payment_total_num_rows($search_params);

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
        $data['bank']            = array(''=>'Select Bank')+$this->Common_model->get_dropdown('bank','bank_id','name');
        $data['pay_mode']            = array(''=>'Select Pay mode')+$this->Common_model->get_dropdown('payment_mode','pay_mode_id','name');
        /*$data['distributor']    = array(''=>'Select Distributor')+$this->Common_model->get_dropdown('distributor','distributor_id','concerned_person');*/
        /* pagination end */
        # Loading the data array to send to View
        $data['distributor_payment_results'] = $this->Payment_model->distributor_payment_results($current_offset, $config['per_page'], $search_params);
        $data['plant_list'] = $this->Payment_model->get_plant_list();
       
        # Additional data
        $data['display_results'] = 1;
        $this->load->view('payment_receipts/dd_verifications',$data);
    }
/*distributor Payments verification
Author:Roopa
Time: 11.26AM 17-02-2017 */   
      public function dd_verification()
    {
        $payment_id=@cmm_decode($this->uri->segment(2));
        if($payment_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor D.D. Verification";
        $data['nestedView']['pageTitle'] = 'Distributor D.D. Verification';
        $data['nestedView']['cur_page'] = 'distributor_dd_verify';
        $data['nestedView']['parent_page'] = 'payment';
        $data['nestedView']['list_page'] = 'distributor_list';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor D.D. List', 'class' => '', 'url' => SITE_URL.'distributor_payments');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor D.D. Verification', 'class' => 'active', 'url' => '');
        
        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'dd_approval';
        $data['display_results'] = 0;
        $data['distributor']    = $this->Payment_model->get_active_distributor();
        //echo "<pre>";
        //print_r($data['distributor']);die();
        $data['bank']            = array(''=>'Select Bank')+$this->Common_model->get_dropdown('bank','bank_id','name');
        $data['pay_mode']            = array(''=>'Select Pay mode')+$this->Common_model->get_dropdown('payment_mode','pay_mode_id','name');

        # Data 
        $row = $this->Common_model->get_data('distributor_payment',array('payment_id'=>$payment_id));       
        $data['distributor_payment_row'] = $row[0];

        $distributor_id=$row[0]['distributor_id'];
        $row1= $this->Common_model->get_data('distributor',array('distributor_id'=>$distributor_id));       
        $data['distributor_id']=$row1[0];


        $pay_mode_id=$row[0]['pay_mode_id'];
        $row2= $this->Common_model->get_data('payment_mode',array('pay_mode_id'=>$pay_mode_id));       
        $data['pay_mode_id']=$row2[0];

        $bank_id=$row[0]['bank_id'];
        $row3= $this->Common_model->get_data('bank',array('bank_id'=>$bank_id));       
        $data['bank_id']=$row3[0];

        $this->load->view('payment_receipts/dd_verifications',$data);
    }
/*Approvakl distributor Payments details
Author:Roopa
Time: 11.26AM 17-02-2017 */
     public function dd_approval()
    {
        $amount       = $this->input->post('amount',TRUE);
        $bad_symbols    = array(",");
        $s_amount      = str_replace($bad_symbols, "", $amount);
        $payment_date   =date('Y-m-d', strtotime($this->input->post('payment_date',TRUE)));
        $distributor_id = $this->input->post('distributor',TRUE);
        $distributor_code = $this->Common_model->get_value('distributor',array('distributor_id'=>$distributor_id),'distributor_code');


        $payment_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($payment_id==''){
            redirect(SITE_URL);
            exit;
        }  
        $val = $this->input->post('submit',TRUE);
        $amount = $this->input->post('amount');
        $os_amount = $this->input->post('outstanding_amount');
        $where1 = array('distributor_id'=> $this->input->post('distributor_id'));
        $this->db->trans_begin();
        // GETTING INPUT TEXT VALUES    
        if($val==1){
            $status = 2;
        }    
        else if($val==2)
        {
            $total = $os_amount-$amount;
            $data1 = array('outstanding_amount' => $total);
            $this->Common_model->update_data('distributor',$data1,$where1);
            // Modified By Maruthi on 27th April'17 12:10PM
            // inserting in distributor transaction table
            $dist_trans_data = array(
                            'distributor_id'        => $distributor_id,
                            'trans_type_id'         => 4,
                            'trans_amount'          => (-$amount),
                            'outstanding_amount'    => $total, 
                            'remarks'               => 'DD Payments Rejected',
                            'trans_date'            => date('Y-m-d'),
                            'created_by'            =>  $this->session->userdata('user_id'),
                            'created_time'          => date('Y-m-d H:m:s')
                );
            //echo '<pre>';print_r($dist_trans_data);exit;
            $this->Common_model->insert_data('distributor_trans',$dist_trans_data);
            $status = 3;            
        }

        $data = array(
                    'dd_number'         =>  $this->input->post('dd_number',TRUE),
                    'pay_mode_id'       =>  $this->input->post('pay_mode',TRUE),
                    'payment_date'      =>  $payment_date,
                    'bank_id'           =>  $this->input->post('bank',TRUE),
                    'status'            =>  $status, 
                    'remarks2'          =>  $this->input->post('remarks2',TRUE),               
                    'verified_by'       =>  $this->session->userdata('user_id'),
                    'verified_time'     =>  date('Y-m-d H:i:s')                    
                    );
        
        $where = array('payment_id'=>$payment_id);
        $this->Common_model->update_data('distributor_payment',$data,$where);
        
        
        if ($this->db->trans_status=== FALSE)
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
            <strong>Success!</strong> DD Verification has been completed successfully! </div>');
        }              
        redirect(SITE_URL.'distributor_payments');  
    }
    
    
    /* 
    Created By      :   Gowripriya 
    Module          :    dd Receipts
    Created Time    :   14th Feb 2017 11:23 AM
    Modified Time   :   
*/
    public function dd_receipts()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Distributor DD Receipts";
        $data['nestedView']['cur_page'] = 'dd_receipts';
        $data['nestedView']['pageTitle'] = 'Distributor DD Receipts';
        $data['nestedView']['parent_page'] = 'payment';
        $data['nestedView']['list_page'] = 'distributor_list';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/dd_receipts.js"></script>';
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Distributor DD Receipts','class'=>'active','url'=>'');

        $data['distributor']    = $this->Payment_model->get_active_distributor();
        $data['bank']           = array(''=>'Select Bank')+$this->Common_model->get_dropdown('bank','bank_id','name',array('status'=>1));
        $data['payment_mode']   = array(''=>'Select payment mode')+$this->Common_model->get_dropdown('payment_mode','pay_mode_id','name',array('status'=>1));
        
        $this->load->view('payment_receipts/dd_receipts',$data);
    }
    // inserting values in database
    public function insert_add_receipts()
    {
        $amount       = $this->input->post('amount',TRUE);
        $bad_symbols    = array(",");
        $s_amount      = str_replace($bad_symbols, "", $amount);
        $payment_date   =date('Y-m-d', strtotime($this->input->post('payment_date',TRUE)));
        $distributor_id = $this->input->post('distributor',TRUE);
        $distributor_code = $this->Common_model->get_value('distributor',array('distributor_id'=>$distributor_id),'distributor_code');
	$dd_number = $this->input->post('dd_number',TRUE);
        $get_result = $this->Payment_model->is_numberExist($dd_number);
        if($get_result==1)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong>Please check. DD number : <strong>'.$dd_number.'</strong> is already Exist  </div>');
            redirect(SITE_URL.'dd_receipts'); exit();
        }

        $data = array( 
                'distributor_id'    =>  $distributor_id,
                'dd_number'         =>  $dd_number,
                'pay_mode_id'       =>  $this->input->post('payment_mode',TRUE),
                'payment_date'      =>  $payment_date,
                'amount'            =>  $s_amount,
                'bank_id'           =>  $this->input->post('bank',TRUE),
                'created_by'        =>  $this->session->userdata('user_id'),
                'created_time'      =>  date('Y-m-d H:m:s')
                    );
       
        //print_r($data);die();
        $this->db->trans_begin();
        $payment_id = $this->Common_model->insert_data('distributor_payment',$data);
        $outstanding_amount = $this->Common_model->get_value('distributor',array('distributor_id'=>$distributor_id),'outstanding_amount');
        if($outstanding_amount=='')
        {
            $outstanding_amount = 0;
        }
        $amount = $outstanding_amount+$s_amount;
        $where_dis = array('distributor_id'=>$distributor_id);
        $this->Common_model->update_data('distributor',array('outstanding_amount'=>$amount),$where_dis);
        
        // Modified By Maruthi on 27th April'17 12:10PM
        // inserting in distributor transaction table
        $dist_trans_data = array(
                        'distributor_id'        => $distributor_id,
                        'trans_type_id'         => 4,
                        'trans_amount'          => ($s_amount),
                        'outstanding_amount'    => $amount, 
                        'remarks'               => 'DD Payments',
                        'trans_date'            => date('Y-m-d'),
                       ' created_by'            =>  $this->session->userdata('user_id'),
                        'created_time'          => date('Y-m-d H:m:s')
            );
        //echo '<pre>'; print_r($dist_trans_data); exit;
        $this->Common_model->insert_data('distributor_trans',$dist_trans_data);
     

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
            <strong>Success!</strong>DD has been Submitted Successfully for Distributor Code : <strong>'.$distributor_code.' </strong> </div>');
        }

         
         redirect(SITE_URL.'dd_receipts');  
    }
     public  function is_numberExist()
    {
        $dd_number = $this->input->post('dd_number');
        echo $this->Payment_model->is_numberExist($dd_number);
    }
}
