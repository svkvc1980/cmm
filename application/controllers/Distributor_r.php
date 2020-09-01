<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Distributor_r extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Distributor_rm");
        $this->load->library('Pdf');
	}
/*Distributor Reports List details
Author:Srilekha
Time: 12.35PM 10-03-2017 */
	public function distributor_r()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor Reports";
		$data['nestedView']['pageTitle'] = 'Distributor reports';
        $data['nestedView']['cur_page'] = 'distributor_r';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor Reports', 'class' => 'active', 'url' => '');	

        # Search Functionality
        //echo '<pre>'; print_r($_POST); exit;
        $p_search=$this->input->post('search_dist', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
               	 'dist_code' 		  => 	$this->input->post('dist_code', TRUE),
                 'dist_name'          =>    $this->input->post('dist_name', TRUE),
               	 'dist_type'          => 	$this->input->post('d_type', TRUE),
               	 'executive'		  => 	$this->input->post('executive',TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'dist_code'   	=>    $this->session->userdata('dist_code'),
                    'dist_name'     =>    $this->session->userdata('dist_name'),
                    'dist_type'   	=>    $this->session->userdata('dist_type'),
                    'executive'		=>	  $this->session->userdata('executive')
                    
                                  );
            }
            else {
                $search_params=array(
                      'dist_code'     => '',
                      'dist_name'     => '',
                      'dist_type'     => '',
                      'executive'	  => ''
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        //print_r($search_params); exit;


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'distributor_r/';
        # Total Records
        $config['total_rows'] = $this->Distributor_rm->distreport_total_num_rows($search_params);

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
        $distributor_results = $this->Distributor_rm->distreport_results($current_offset, $config['per_page'], $search_params);
        
        /*foreach($distributor_results as $details)
        {
           $distributor_bank_details=$this->Distributor_rm->distributor_bank_details($details['distributor_id']);
            
            if(count(@$distributor_bank_details)>0) 
            {
                
                $bg_amount=0;
                foreach($distributor_bank_details as $date)
                {
                   $end_date=$date['end_date']; 
                   $cur_date=date('Y-m-d');
                   if($cur_date <= $end_date)
                   {
                      
                        $bg_amount+=$date['bg_amount'];
                   }
                   else
                   {
                    $bg_amount = 0;
                   }
                }
                $data['amount'][$details['distributor_id']]=$bg_amount;
            }
            else
            {
                $data['amount'][$details['distributor_id']] = 0;
            }
        }*/
        $data['location']=$this->Common_model->get_data('location',array('status'=>1,'level_id'=>5));
        $data['distributor_type']=$this->Common_model->get_data('distributor_type',array('status'=>1));
        $data['executive']=$this->Common_model->get_data('executive');
        $data['distributor_results']=$distributor_results;
       
        # Additional data
        $data['display_results'] = 1;

        $this->load->view('distributor/distributor_r_view',$data);

    }

    public function download_distributor_r()
    {
        $p_search=$this->input->post('print_distributor_list', TRUE);
        //echo $p_search; exit;
        if($p_search!='')
        {
            $search_params=array(
                     'dist_code'          =>    $this->input->post('dist_code', TRUE),
                     'dist_name'          =>    $this->input->post('dist_name', TRUE),
                     'dist_type'          =>    $this->input->post('d_type', TRUE),
                     'executive'          =>    $this->input->post('executive',TRUE)
                
                                  );
            $dist_type = $this->input->post('d_type', TRUE);
            $executive_id = $this->input->post('executive', TRUE);
            $data['distributor_type'] = '';
            $data['executive_name'] = '';
            if($dist_type!='')
            {
                $distributor_type = $this->Common_model->get_value('distributor_type',array('type_id'=>$dist_type),'name');
                $data['distributor_type'] = $distributor_type;
            }

            if($executive_id!='')
            {
                $executive_name = $this->Common_model->get_value('executive',array('executive_id'=>$executive_id),'name');
                $data['executive_name'] = $executive_name;
            }

        	$data['distributor_results'] = $this->Distributor_rm->distreport_details($search_params);
            $this->load->view('distributor/print_distributor_r',$data);
        }
        //echo '<pre>';print_r($_POST); exit;
        
    }
/*View Distributor Reports List details
Author:Srilekha
Time: 01.15PM 20-03-2017 */
    public function view_distributor_details()
    {
        $distributor_id = @cmm_decode($this->uri->segment(2));
        if($distributor_id==''){
            redirect(SITE_URL);
            exit;
        }
        $distributor_details=$this->Distributor_rm->view_distributor_details($distributor_id);
        $data['type_id']=$distributor_details[0]['type_id'];
        $distributor_bank_details=$this->Distributor_rm->distributor_bank_details($distributor_id);
        $bg_amount=0;
        foreach($distributor_bank_details as $date)
        {
           $end_date=$date['end_date']; 
           $cur_date=date('Y-m-d');
           if($cur_date <= $end_date)
           {
              
                $bg_amount+=$date['bg_amount'];
           }
        }
        $data['available_amount']=$distributor_details[0]['outstanding_amount']+$bg_amount;
        $data['distributor_details']=$distributor_details;
        $data['distributor_bank_details']=$distributor_bank_details;

        $this->load->view('distributor/distributor_details_view',$data);
        
    }

    # Distributor Ledger
    public function distributor_ledger()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Distributor Ledger";
        $data['nestedView']['pageTitle'] = 'Distributor Ledger';
        $data['nestedView']['cur_page'] = 'distributor_ledger';
        $data['nestedView']['parent_page'] = 'distributor_reports';
        $data['nestedView']['list_page'] = 'distributor_reports';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Distributor Ledger','class'=>'active','url'=>'');
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

        $data['distributors'] = $this->Distributor_rm->get_distributors();
       
        $this->load->view('distributor/distributor_ledger',$data);
    }

    # Print Distributor ledger report
    public function print_distributor_ledger()
    {
        if($this->input->post('print_dist_ledger')!='') {
            
            $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 
            $distributor_id = $this->input->post('distributor_id');
            $search_params = array(
                                'from_date' =>  $from_date,
                                'to_date'   =>  $to_date,
                                'distributor_id'  =>  $distributor_id
                                );
            // Getting Distributor info
            $distributor = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$distributor_id));
            // Getting Distributor Bank Guarantees
            $bank_guarantees = $this->Common_model->get_data('bank_guarantee',array('distributor_id'=>$distributor_id,'end_date>='=>date('Y-m-d')));
            $data['bank_guarantees'] = $bank_guarantees;
            $tot_bg_amount = 0;
            foreach ($bank_guarantees as $bg_row) {
              $tot_bg_amount += $bg_row['bg_amount'];
            }
            $data['tot_bg_amount'] = $tot_bg_amount;
            $data['distributor'] = $distributor;
            //echo '<pre>';print_r($distributor); exit;
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            // Get distributor ledger dates : DD payments, do, credit/Debit Note, Penality
            $transaction_results = $this->Distributor_rm->get_ledger_dates($search_params);
            // Get DD receipts entries
            $dd_receipts_results = $this->Distributor_rm->get_dd_receipts($search_params);
            $dd_receipts = array();
            foreach($dd_receipts_results as $ddr_row)
            {
              $dd_receipts[$ddr_row['payment_date']][] = $ddr_row; 
            }
            $data['dd_receipts'] = $dd_receipts;
            // Get DO entries
            $do_results = $this->Distributor_rm->get_do_results($search_params);
            $do_list = array();
            foreach($do_results as $drow)
            {
              $do_list[$drow['do_date']][] = $drow; 
            }
            $data['do_list'] = $do_list;
            // Get Credit/Debit Note entries
            $cd_note_results = $this->Distributor_rm->get_credit_debit_notes($search_params);
            $credit_note = array(); $debit_note = array();
            foreach($cd_note_results as $cd_row)
            {
              if($cd_row['note_type']==1) // Credit
                $credit_note[$cd_row['on_date']][] = $cd_row;
              else // Debit
                $debit_note[$cd_row['on_date']][] = $cd_row;
            }
            $data['credit_note'] = $credit_note;
            $data['debit_note'] = $debit_note;
            
            // Get penalities
            $penality_results = $this->Distributor_rm->get_penalities($search_params);
            $penality_list = array();
            foreach($penality_results as $prow)
            {
              $penality_list[$prow['penality_date']][] = $prow; 
            }
            $data['penality_list'] = $penality_list;
            // Get Invoice entries
            $invoice_results = $this->Distributor_rm->get_invoices($search_params);
            $invoice_list = array();
            foreach($invoice_results as $irow)
            {
              $invoice_list[$irow['invoice_date']][] = $irow; 
            }
            /*echo $this->Distributor_rm->invoice_sum($search_params);
            echo $this->db->last_query();
            echo '<pre>'; print_r($invoice_list); exit;*/
            $data['invoice_list'] = $invoice_list;

            $data['transaction_results'] = $transaction_results;
            // Getting Outstanding amount as O/B as on from date
            $opening_outstanding_amount = $distributor['outstanding_amount']; # Current outstanding amount
            $opening_outstanding_amount -= $this->Distributor_rm->dd_receipts_sum($search_params); # Deducting DD Receits
            $opening_outstanding_amount += $this->Distributor_rm->do_sum($search_params); # Adding DO amount
            $opening_outstanding_amount -= $this->Distributor_rm->credit_note_sum($search_params); # Deducting Credit Note sum
            $opening_outstanding_amount += $this->Distributor_rm->debit_note_sum($search_params); # Adding Debit Note amount
            $opening_outstanding_amount += $this->Distributor_rm->penalities_sum($search_params); # Adding Penality amount
            //echo $opening_outstanding_amount.'-->';
            //$opening_outstanding_amount -= 2856; //test
            $opening_outstanding_amount += $this->Distributor_rm->pending_do_amount_on_date($search_params); # Adding Pending Do Amount
            $data['opening_outstanding_amount'] = $opening_outstanding_amount;
            //echo '<pre>';print_r($do_list); exit;
            $data['current_pending_do_amount'] = $this->Distributor_rm->current_pending_do_amount($search_params['distributor_id']);
            $this->load->view('distributor/print_distributor_ledger',$data);
            
        }
    }

}