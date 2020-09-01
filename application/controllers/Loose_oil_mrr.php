<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'Base_controller.php';

class Loose_oil_mrr extends Base_controller

{



    public function __construct() 

    {

        parent::__construct();

        $this->load->model("Loose_oil_mrr_m");

    }

    /*

      * Function   : MRR details for loose oil

      * Developer  :  Prasad created on: 12th Feb 9 PM updated on:      

     */

    public function loose_oil_mrr()

    {       

        # Data Array to carry the require fields to View and Model

        $data['nestedView']['heading']="M.R.R. For Loose Oil";  

        $data['nestedView']['pageTitle'] = 'M.R.R. for Loose Oil';

        $data['nestedView']['cur_page'] = 'loose_oil_mrr';

        $data['nestedView']['parent_page'] = 'mrr_report';



        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/mrr_loose_oil_details.js"></script>';

        $data['nestedView']['css_includes'] = array();



        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'M.R.R. for Loose Oil', 'class' => '', 'url' => '');



        $data['flag']=1;

        $this->load->view('mrr/loose_oil_mrr',$data);

    }



     /*

      * Function   :   Retreving details for loose oil based on tanker id annd purchase order

      * Developer  :  Prasad created on: 12th Feb 9 PM updated on:      

     */

    public function mrr_loose_oil_details()

    { 

        # Data Array to carry the require fields to View and Model

        $data['nestedView']['heading']="M.R.R. For Loose Oil Details";

        $data['nestedView']['pageTitle'] = 'M.R.R. For Loose Oil Details';

        $data['nestedView']['cur_page'] = 'loose_oil_mrr';

        $data['nestedView']['parent_page'] = 'mrr_report';



        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/mrr_loose_oil_details.js"></script>';

        $data['nestedView']['css_includes'] = array();



        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'M.R.R. for Loose Oil', 'class' => '', 'url' => SITE_URL . 'loose_oil_mrr');

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'M.R.R. for Loose Oil Details', 'class' => '', 'url' => '');

        

        if($this->input->post('submit'))

        {

            $tanker_number=$this->input->post('tanker_number');

            $tanker_details=$this->Loose_oil_mrr_m->get_tanker_details($tanker_number);
           

            $tanker_count=$tanker_details[0];

            $tanker_results=$tanker_details[1];

            if($tanker_count > 0)

            {  //echo 'hi';  exit;

               //checking tanker register status to generate MRR

               if($tanker_results['status']==1)

               {

                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">

                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                                <strong>Sorry!</strong>Please complete weighbride gross weight process to generate MRR!

                             </div>');



                redirect(SITE_URL.'loose_oil_mrr');exit;

               }



               elseif($tanker_results['status']==2)

               {

                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">

                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                                <strong>Sorry!</strong>Please complete lab Test process To generate MRR!

                             </div>');



                redirect(SITE_URL.'loose_oil_mrr');exit;

               }



              elseif($tanker_results['status']==3)

               {

                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">

                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                                <strong>Sorry!</strong>Please complete weighbride tier weight process to generate MRR!

                             </div>');



                redirect(SITE_URL.'loose_oil_mrr');exit;

               }



               elseif($tanker_results['status']==5)

               {

                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">

                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                                <strong>Sorry!</strong>MRR is already generated.!

                             </div>');



                redirect(SITE_URL.'loose_oil_mrr');exit;

               }



               elseif($tanker_results['status']==6)

               {

                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">

                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                                <strong>Sorry!</strong>MRR is already generated.tanker is registered out!

                             </div>');



                redirect(SITE_URL.'loose_oil_mrr');exit;

               }



                elseif($tanker_results['status']==10)

               {

                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">

                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                                <strong>Sorry!</strong>Lab test is failed.MRR will not be generated!

                             </div>');



                redirect(SITE_URL.'loose_oil_mrr');exit;

               }



               else

               {

                    $mrr_results=$this->Loose_oil_mrr_m->get_mrr_loose_oil_details($tanker_results['tanker_id']);
                    $data['received_qty']=$this->Loose_oil_mrr_m->get_received_qty($mrr_results['po_oil_id']);
                    $data['flag']=2;

                    

                    $plant_id=$mrr_results['plant_id'];

                    $where=array('plant_id'=>$mrr_results['plant_id'],'loose_oil_id'=>$mrr_results['loose_oil_id']);

                    $data['mrr_results']=$mrr_results;



                    //Retreving Max mrr number from mrr_oil

                    $data['mrr_number']=get_current_serial_number(array('value'=>'mrr_number','table'=>'mrr_oil','where'=>'created_time'));



                    //retreiving oil tanks based on plant id

                    $data['tank_details'] = array(''=>'Select Oil Tank')+$this->Common_model->get_dropdown('oil_tank', 'oil_tank_id', 'name',$where);



                    $this->load->view('mrr/loose_oil_mrr',$data);

                    

                }



            }



            else

            {

               $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">

                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                                <strong>Sorry!</strong> Invalid Tanker Registration Number! OR P.O. status is Completed

                             </div>');



               redirect(SITE_URL.'loose_oil_mrr'); exit;

            }

        }

                  

    }



    /*

      * Function   :   Insertion of MRR details for loose oil

      * Developer  :  Prasad created on: 12th Feb 9 PM updated on:      

    */



    public function insert_mrr_details()

    {

        # Data Array to carry the require fields to View and Model

        $data['nestedView']['heading']="M.R.R. for Oils Details";

        $data['nestedView']['pageTitle'] = 'M.R.R. For Oils Details';

        $data['nestedView']['cur_page'] = 'insert_mrr_details';

        $data['nestedView']['parent_page'] = 'mrr_report';



        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

       /* $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/price_updation.js"></script>';*/

        $data['nestedView']['css_includes'] = array();



        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'M.R.R. for Loose Oil', 'class' => '', 'url' => SITE_URL . 'loose_oil_mrr');

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'M.R.R. for Loose Oil Details', 'class' => '', 'url' => '');

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'M.R.R. Details', 'class' => '', 'url' => '');



        if($this->input->post('submit'))

        {   

            $tanker_id =  $this->input->post('tanker_id');

            $po_status= $this->input->post('po_status');

            $po_oil_id = $this->input->post('po_oil_id');
		
	    //retreving mrr loose oil details
            $mrr_results=$this->Loose_oil_mrr_m->get_mrr_loose_oil_details($tanker_id);


            //Retreving Max mrr number from mrr_oil

            $mrr_number=get_current_serial_number(array('value'=>'mrr_number','table'=>'mrr_oil','where'=>'created_time'));
            $data['received_qty']=$this->Loose_oil_mrr_m->get_received_qty($mrr_results['po_oil_id']);

            $dat=array(

              'mrr_number'       =>  $mrr_number,

              'tanker_oil_id'    =>  $this->input->post('tanker_oil_id'),

              'folio_number'     =>  $this->input->post('folio_number'),

              'ledger_number'    =>  $this->input->post('ledger_number'),

              'oil_tank_id'      =>  $this->input->post('tank_name'),

              'remarks'          =>  $this->input->post('remarks'),

              'mrr_date'         =>  date('Y-m-d'),

              'created_by'       =>  1

              );

            
            $data['received_qty']=$this->Loose_oil_mrr_m->get_received_qty($mrr_results['po_oil_id']);
            $net_weight=$mrr_results['net_weight'];



            if($mrr_results['loose_oil_id']==gn_loose_oil_id())

            {

                $test_id= get_ffa_test_id();
                $ffa_value=$this->Loose_oil_mrr_m->get_ffa_value($test_id,$mrr_results['tanker_id']);
                $results=$this->Loose_oil_mrr_m->get_ffa_range($ffa_value);
                $total_rebate=0;



                foreach($results as $row)

                {

                    if($row['upper_limit'] <= $ffa_value)

                    {

                        $total_rebate+=($row['upper_limit']-$row['lower_limit'])*$row['multiplier'];

                    }

                    else

                    {

                        $total_rebate+=($row['upper_limit']-$ffa_value)*$row['multiplier'];

                        break;

                    }

                }

                $data['total_rebate']=$total_rebate;

                $data['ffa_value']=$ffa_value;

            }



            //Retreving receipts weight in stock list based on plantid,date,loose oil id

            $results=$this->Loose_oil_mrr_m->get_receipt_weight_stock_list($mrr_results);

            $receipts=$results['receipts'];

            $receipts+=$net_weight;



            $this->db->trans_begin();

            $mrr_oil_id = $this->Loose_oil_mrr_m->insert_mrr_loose_oil_details($dat);

            //echo $this->db->last_query();exit;
            // Created By Maruthi On 16th april 8:10 PM 
            // Updating mrr data in Po Oil table
              $closed_po_data = array(
                    'modified_by'    => $this->session->userdata('user_id'),
                    'modified_time'  => date('Y-m-d H:i:s'),
                    'closed_by'      => $this->session->userdata('user_id'),
                    'closed_time'    => date('Y-m-d H:i:s'),
                    'status'         => $po_status
                );
              $pending_po_data = array(
                    'modified_by'   => $this->session->userdata('user_id'),
                    'modified_time'  => date('Y-m-d H:i:s'),
                    'status'         =>$po_status
                );
              if($po_status == 3)
                  $this->Common_model->update_data('po_oil',$closed_po_data,array('po_oil_id'=>$po_oil_id));
              else
                  $this->Common_model->update_data('po_oil',$pending_po_data,array('po_oil_id'=>$po_oil_id));
            // End Updated 

            $this->Common_model->update_data('tanker_register',array('status' =>5),array('tanker_id'=>$tanker_id));

            //$this->Common_model->update_data('po_oil',array('status' =>$po_status),array('po_oil_id'=>$po_oil_id));



            //updating data in stock list

            $this->Common_model->update_data('oil_stock_balance',array('receipts' =>$receipts),array('oil_stock_balance_id'=>$results['oil_stock_balance_id']));



            if($this->db->trans_status()===FALSE)

            {

              $this->db->trans_rollback();

            }

            else

            {

              $this->db->trans_commit();

              $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                <strong>Success!</strong>Oil M.R.R. are inserted successfully! </div>');



            }

           

            $data['mrr_results']=$mrr_results;

            //retreving mrr ledger details

            $data['mrr_details']=$this->Loose_oil_mrr_m->get_details_mrr($mrr_oil_id);



           

            $data['flag']=3;



            $this->load->view('mrr/loose_oil_mrr',$data);

        }

    }

     /*

      * Function   :  Downloading details for loose oil based on tanker id and purchase order

      * Developer  :  Prasad created on: 12th Feb 11 PM updated on:      

     */

     public function download_loose_oil_mrr()

     {

        if($this->input->post('download')!='')

        {

            $tanker_id   = $this->input->post('tanker_id');

            $mrr_oil_id  = $this->input->post('mrr_oil_id');



            //retreving mrr loose oil details

            $mrr_results=$this->Loose_oil_mrr_m->get_mrr_loose_oil_details($tanker_id);
            //$received_qty=$this->Loose_oil_mrr_m->get_received_qty($mrr_results['po_oil_id']);
           

            //retreving mrr ledger details

            $mrr_details=$this->Loose_oil_mrr_m->get_details_mrr($mrr_oil_id);

            

            if($mrr_results['loose_oil_id']==gn_loose_oil_id())

            {

                $test_id= get_ffa_test_id();

                $ffa_value=$this->Loose_oil_mrr_m->get_ffa_value($test_id,$mrr_results['tanker_id']);

                

                $results=$this->Common_model->get_data('ffa_rebate',array('lower_limit <'=>$ffa_value));

               

                $total_rebate=0;



                foreach($results as $row)

                {

                    if($row['upper_limit'] <= $ffa_value)

                    {

                        $total_rebate+=($row['upper_limit']-$row['lower_limit'])*$row['multiplier'];

                    }

                    else

                    {

                        $total_rebate+=($row['upper_limit']-$ffa_value)*$row['multiplier'];

                        break;

                    }

                }

               

            }



            $header = '';

            $data ='';

           

           

            $data = '<table border="1">';

            $data.= '<thead>';

            $data.='<h3 align="center"> Material Receipt Report(MRR)</h3>';

            $data.='</thead>';

            $data.='<tbody>';

            $data.='<tr>';

            $data.='<td><b>MRR Reference Number : </b>'.$mrr_details['mrr_number'].'</td>';

            $data.='<td><b>Tanker Register Number : </b>'. $mrr_results['tanker_number'].'</td>';  

            $data.='<td><b>PO Number : </b>'.$mrr_results['po_number'].'</td>'; 

            $data.='<td><b>Date : </b>'.date('d-m-Y').'</td>';                           

            $data.='</tr>';



            $data.='<tr>';

            $data.='<td><b>Invoice Number : </b>'.$mrr_results['invoice_number'].'</td>';

            $data.='<td><b>Loose Oil : </b>'. $mrr_results['loose_oil_name'].'</td>';  

            $data.='<td><b>Broker : </b>'.' '.$mrr_results['broker_name'].'</td>'; 

            $data.='<td><b>Supplier: </b>'.$mrr_results['supplier_name'].'</td>';                           

            $data.='</tr>';



            $data.='<tr>';

            $data.='<td colspan="2"><b>Unit Name : </b>'.$mrr_results['plant_name'].'</td>';

            $data.='<td><b>Oil Tank Name : </b>'.$mrr_details['name'].'</td>'; 

            $data.='<td><b>PO Date : </b>'.$mrr_results['po_date'].'</td>'; 

                                       

            $data.='</tr>';



            $data.='<tr>';

            $data.='<td><b>Unit Price : </b>'. $mrr_results['unit_price'].'</td>';

            $data.='<td><b>Gross Weight : </b>'.$mrr_results['gross_weight'].'</td>'; 

            $data.='<td><b>Tier Weight : </b>'.$mrr_results['tier_weight'].'</td>';   

            $data.='<td><b>Net Quantity : </b>'. $mrr_results['net_weight'].'</td>'; 

            $data.='</tr>';



            $data.='<tr>';

            $data.='<td><b>Ledger Number : </b>'.$mrr_details['ledger_number'].'</td>';

            $data.='<td><b>Folio Number : </b>'. $mrr_details['folio_number'].'</td>';

            $data.='<td><b>DC Number : </b>'.$mrr_results['dc_number'].'</td>';

            $data.='<td><b>Vehicle Number: </b>'.$mrr_results['vehicle_number'].'</td>'; 

            $data.='</tr>';



            if($mrr_details['remarks'] !='')

            {

               $data.='<tr>';

               $data.='<td colspan="2"><b>Ledger Number : </b>'.$mrr_details['remarks'].'</td>';

               $data.='<td colspan="2"><b>Purchase Mode : </b>'.$mrr_results['purchase_type'].'</td>';  

               $data.='</tr>';

            }

           /* $data.='</tbody>';

            $data.='</table>';



            $data.='<table>';

            $data.='<tbody>';

            $data.='</body>';*/

            if($mrr_results['loose_oil_id']==gn_loose_oil_id())

            {  

                $data.='<tr>';

                $rebate=($total_rebate*$mrr_results['unit_price']* $mrr_results['net_weight'])/100;

                $payable_amount=($mrr_results['unit_price']* $mrr_results['net_weight'])-$rebate; 

                $data.='<td><b>Total Amount :</b> '. $mrr_results['unit_price']* $mrr_results['net_weight'].'</td>';

                $data.='<td><b>FFA :</b>'. $ffa_value.'</td>';

                $data.='<td><b>Rebate :</b>'.$rebate.'</td>';

                $data.='<td><b>Payabale Amount :</b>'. $payable_amount.'</td>';

                $data.='</tr>';

            }

            else

            {

                $data.='<tr>'; 

                $rebate=0;

                $payable_amount=($mrr_results['unit_price']* $mrr_results['net_weight'])-$rebate; 

                $data.='<td><b>Total Amount :</b>'. $mrr_results['unit_price']* $mrr_results['net_weight'].'</td>';

                $data.='<td><b>Rebate (if any):</b>'.'0'.'</td>';

                $data.='<td colspan="2"><b>Payabale Amount :</b> '. $payable_amount.'</td>';   

                $data.='</tr>'; 
            }
            $data.='</div>';
            $data.='</div>';
            $time = date("Ymdhis");
            $xlFile='Loose_oil_MRR_'.$time.'.xls'; 
            header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
        }
     }
    /*
      * Function   : List of MRR's
      * Developer  :  Prasad created on: 24th Feb 11 PM updated on:      
    */
    public function mrr_loose_oil_list()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="M.R.R. Loose Oil List";
        $data['nestedView']['pageTitle'] = 'M.R.R. Loose Oil List';
        $data['nestedView']['cur_page'] = 'loose_oil_mrr';
        $data['nestedView']['parent_page'] = 'mrr_report';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'M.R.R. Loose Oil List', 'class' => '', 'url' => '');
        # Search Functionality
        $psearch=$this->input->post('search_oil', TRUE);
        if($psearch!='') {
        $search_params=array(
                        'po_number'            =>   $this->input->post('po_no', TRUE),
                        'mrr_number'           =>   $this->input->post('mrr_number',TRUE),
                        'start_date'           =>   $this->input->post('start_date', TRUE),
                        'end_date'             =>   $this->input->post('end_date',TRUE),
                        'tanker_in_number'     =>   $this->input->post('tanker_in_number')
                              );
         $this->session->set_userdata($search_params);
        } else {
            if($this->uri->segment(2)!='')
            {
            $search_params=array(
                        'po_number'         =>    $this->session->userdata('po_number'),
                        'mrr_number'         =>   $this->session->userdata('mrr_number'),
                        'start_date'         =>    $this->session->userdata('start_date'),
                        'end_date'         =>   $this->session->userdata('end_date'),
                        'tanker_in_number'   =>   $this->session->userdata('tanker_in_number')
                              );
            }
            else {
                $search_params=array(
                        'po_number'         =>  '',
                        'mrr_number'        =>  '',
                        'start_date'        =>  '',
                        'end_date'          =>  '',
                        'tanker_in_number'  =>  ''
                                  );
                 $this->session->set_userdata($search_params);
            }
        }
        $data['search_params'] = $search_params;
         # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'mrr_loose_oil_list/';
        # Total Records
        $config['total_rows'] = $this->Loose_oil_mrr_m->get_mrr_list_total_num_rows($search_params);
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
        $data['view_mrr_list_results'] = $this->Loose_oil_mrr_m->view_mrr_list_results($search_params, $config['per_page'] ,$current_offset);
        //print_r( $data['view_mrr_list_results']);exit;
        # Additional data
        $data['flag']=1;
        $this->load->view('mrr/mrr_loose_oil_list',$data);        
    }

    public function print_mrr_oil_list()
    {
        
        $psearch=$this->input->post('print_mrr_list', TRUE);
        if($psearch!='') {
        $search_params=array(
                        'po_number'            =>   $this->input->post('po_no', TRUE),
                        'mrr_number'           =>   $this->input->post('mrr_number',TRUE),
                        'start_date'           =>   $this->input->post('start_date', TRUE),
                        'end_date'             =>   $this->input->post('end_date',TRUE),
                        'tanker_in_number'     =>   $this->input->post('tanker_in_number')
                              );
         $this->session->set_userdata($search_params);
        } 
        $data['search_params'] = $search_params;
        $data['mrr_oil_results'] = $this->Loose_oil_mrr_m->print_mrr_oil_results($search_params);
        $this->load->view('mrr/print_mrr_oil_list',$data);        
    }     

 

}