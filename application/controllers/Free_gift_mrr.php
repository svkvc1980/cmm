<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 /* 
 	Created By 		:	Priyanka 
 	Module 			:	Tanker Registration - Tanker In, Tanker Out
 	Created Time 	:	10th Feb 2017 11:23 AM
 	Modified Time 	:	
*/
class Free_gift_mrr extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Free_gift_mrr_m");
	}

    # Function for Free Gift MRR
    public function freegift_mrr()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Free Gift MRR";
        $data['nestedView']['pageTitle'] = 'Free Gift MRR';
        $data['nestedView']['cur_page'] = 'freegift_mrr';
        $data['nestedView']['parent_page'] = 'mrr_report';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Free Gift MRR', 'class' => '', 'url' => '');

        $data['flag']=1;
        $this->load->view('mrr/freegift_mrr',$data);
    }

    # Function to Insert PO FG Details into po_fg_tanker AND Redirect to mrr details page
    public function freegift_insert_po_fg()
    {
        $plant_id = $this->session->userdata('ses_plant_id');
        $po_num          =   $this->input->post('po_num', TRUE);
        $tanker_in_num   =   $this->input->post('tanker_in_num', TRUE);

        $po_fg_id        =    $this->Common_model->get_value('po_free_gift',array('po_number'=>$po_num),'po_fg_id');
        $tanker_id       =   $this->Free_gift_mrr_m->get_tanker_id($tanker_in_num);
        echo $tanker_id;exit;
        $tanker_type_id  =    $this->Common_model->get_value('tanker_register',array('tanker_in_number'=>$tanker_in_num,'status' => 3,'plant_id'=>$plant_id),'tanker_type_id');

        $qry = 'SELECT tanker_id FROM po_fg_tanker WHERE po_fg_id = "'.$po_fg_id.'" AND tanker_id = "'.$tanker_id.'" AND status = 1 ';
        $num_rows = $this->Common_model->get_no_of_rows($qry);
        
        #tanker_type_id = 5 (free gift)
        if($tanker_type_id == 5 && $po_fg_id != '' && $tanker_id != '')
        {
             # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading']="Free Gift MRR";
            $data['nestedView']['pageTitle'] = 'Free Gift MRR';
            $data['nestedView']['cur_page'] = 'freegift_mrr';
            $data['nestedView']['parent_page'] = 'mrr_report';

            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['css_includes'] = array();

            # Breadcrumbs
            $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Free Gift MRR', 'class' => '', 'url' => '');
           
            $data['flag']  = 2;
            $data['po_num']  = $po_num;
            $data['tanker_in_num']  = $tanker_in_num;
            $data['po_free_gift_details'] = $this->Common_model->get_data('po_free_gift',array('po_fg_id' => $po_fg_id,'status'=>1));
            $free_gift_id = $data['po_free_gift_details'][0]['free_gift_id'];
            $data['tanker_fg'] = $this->Common_model->get_data('tanker_fg',array('tanker_id' => $tanker_id,'free_gift_id'=>$free_gift_id));
            $data['tanker_register'] = $this->Common_model->get_data('tanker_register',array('tanker_id' => $tanker_id,'status'=>3));
            $free_gift_id= $this->Common_model->get_value('po_free_gift',array('po_fg_id'=>$po_fg_id),'free_gift_id');
            $supplier_id= $this->Common_model->get_value('po_free_gift',array('po_fg_id'=>$po_fg_id),'supplier_id');
            $data['free_gift_name'] = $this->Common_model->get_value('free_gift',array('free_gift_id' => $free_gift_id),'name');
            $data['supplier_name'] = $this->Common_model->get_value('supplier',array('supplier_id' => $supplier_id),'concerned_person');
            $data['mrr_no'] = get_current_serial_number(array('value'=>'mrr_number','table'=>'mrr_fg','where'=>'created_time'));
           // echo "<pre>"; print_r($tanker_register);exit;
            if($num_rows != '')
            {  
                # redirect to mrr reports , no need to insert data.     
                $this->load->view('mrr/freegift_mrr',$data);
            }
            else
            {
                # Insert data in po_fg_tanker and redirect to mrr reports 
                $po_fg_tanker_details = array(

                                                'po_fg_id'       =>  $po_fg_id,
                                                'tanker_id'      =>  $tanker_id,
                                                'created_by'     =>  $this->session->userdata('user_id'),
                                                'created_time'   =>  date('Y-m-d H:i:s'),                                       
                                                'status'         =>  1
                                             );
                $this->Common_model->insert_data('po_fg_tanker',$po_fg_tanker_details);
                
                $this->load->view('mrr/freegift_mrr',$data);                

            }
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                      <strong>ERROR!</strong> Tanker In Number / PO Number is invalid ! </div>');
            redirect(SITE_URL.'freegift_mrr');  
        }
    }

    # Function to Insert MRR Details into mrr_fg
    public function insert_free_gift_mrr_details()
    {
          # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Free Gift MRR Reports";
        $data['nestedView']['pageTitle'] = 'Free Gift MRR Reports';
        $data['nestedView']['cur_page'] = 'freegift_mrr';
        $data['nestedView']['parent_page'] = 'mrr_report';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Free Gift MRR Reports', 'class' => '', 'url' => '');
        $mrr_no = get_current_serial_number(array('value'=>'mrr_number','table'=>'mrr_fg','where'=>'created_time'));
        $mrr_details       =    array(
                                        'tanker_fg_id'  =>  $this->input->post('tanker_fg_id'),
                                        'received_qty'  =>  $this->input->post('received_quantity'),
                                        'ledger_number'  =>  $this->input->post('ledger_number'),
                                        'folio_number'  =>  $this->input->post('folio_number'),
                                        'remarks'  =>  $this->input->post('remarks'),
                                        'mrr_date'  =>  $this->input->post('mrr_date'),
                                        'remarks'  =>  $this->input->post('remarks'),
                                        'mrr_date'  =>  $this->input->post('mrr_date'),
                                        'created_by'  =>  $this->session->userdata('user_id'),
                                        'mrr_number' => $mrr_no,
                                        'created_time'  =>  date('Y-m-d H:i:s')
                                     );
        $free_gift_id = $this->Common_model->get_value('tanker_fg',array('tanker_fg_id'=>$this->input->post('tanker_fg_id')),'free_gift_id');
        $plant_id = $this->session->userdata('ses_plant_id');
        $quantity = $this->input->post('received_quantity');
        $this->db->trans_begin();
        $qry = "INSERT INTO plant_free_gift(plant_id,free_gift_id,quantity,updated_time) 
                    VALUES (".$plant_id.",".$free_gift_id.",".$quantity.",'".date('Y-m-d H:i:s')."')  
                    ON DUPLICATE KEY UPDATE quantity = quantity+VALUES(quantity), updated_time = VALUES(updated_time) ;";
        $this->db->query($qry);


        $tanker_registration_details    =   array(
                                                    'status'    =>  4,
                                                    'modified_by'  =>  $this->session->userdata('user_id'),
                                                    'modified_time'  =>  date('Y-m-d H:i:s')
                                                 );
        $tanker_id  =   $this->input->post('tanker_id');
        $where = array('tanker_id' => $tanker_id);
        $this->Common_model->insert_data('mrr_fg',$mrr_details);
        $this->Common_model->update_data('tanker_register',$tanker_registration_details,$where);

        if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                  <strong>Error!</strong> MRR Details has not Inserted. Please check. </div>');       
            $data['flag']=2;  
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                  <strong>Success!</strong> MRR Details has been added successfully! </div>');
            $data['flag']=1; 
             
        }

         $this->load->view('mrr/freegift_mrr',$data);
        
    }

    /*MRR List details
Author:Srilekha
Time: 02.29PM 11-03-2017 */
    public function mrr_fg_list()
    {

        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Freegift MRR List";
        $data['nestedView']['pageTitle'] = 'Freegift MRR List';
        $data['nestedView']['cur_page'] = 'free_gift_mrr_r';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Freegift MRR List', 'class' => 'active', 'url' => ''); 

        # Search Functionality
        $p_search=$this->input->post('search_mrr', TRUE);
        if($this->input->post('from_date',TRUE)!='')
        {
            $from_date=date('Y-m-d', strtotime($this->input->post('from_date',TRUE)));  
        }
        else
        {
            $from_date = '';
        }
        if($this->input->post('to_date',TRUE)!='')
        {
            $to_date=date('Y-m-d', strtotime($this->input->post('to_date',TRUE)));  
        }
        else
        {
            $to_date = '';
        }
        if($p_search!='') 
        {
            
            $search_params=array(
                 'mrr_number'           =>    $this->input->post('mrr_number', TRUE),
                 'from_date'            => $from_date,
                 'to_date'              => $to_date
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                   'mrr_number'         => $this->session->userdata('mrr_number'),
                   'from_date'          => $this->session->userdata('from_date'),
                   'to_date'            => $this->session->userdata('to_date')
                    
                                  );
            }
            else {
                $search_params=array(
                      'mrr_number'     => '',
                      'from_date'      => '',
                      'to_date'        => ''
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'mrr_fg_list/';
        # Total Records
        $config['total_rows'] = $this->Free_gift_mrr_m->mrr_fg_total_num_rows($search_params);

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
        $data['mrr_fg_results'] = $this->Free_gift_mrr_m->mrr_fg_results($current_offset, $config['per_page'], $search_params);

        # Additional data
        $data['display_results'] = 1;

        $this->load->view('mrr/mrr_fg_list_view',$data);
    }
/*Download MRR Fre Gift details
Author:Srilekha
Time: 03.20PM 11-03-2017 */
    public function download_mrr_fg()
    {
        if($this->input->post('download_mrr')!='') {
            
           $search_params=array(
                'mrr_number'         => $this->input->post('mrr_number', TRUE),
                'from_date'         => $this->input->post('from_date', TRUE),
                'to_date'           => $this->input->post('to_date', TRUE)
            
                                );   
            $mrr_fg = $this->Free_gift_mrr_m->mrr_fg_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','MRR Number','Tanker Number','MRR Date','Free Gift Name','Received Quantity','Ledger Number','Folio Number');
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
            if(count($mrr_fg)>0)
            {
                
                foreach($mrr_fg as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['mrr_number'].'</td>';
                    $data.='<td align="center">'.$row['tanker_in_number'].'</td>';
                    $data.='<td align="center">'.date('d-m-Y',strtotime($row['mrr_date'])).'</td>';
                    $data.='<td align="center">'.$row['freegift_name'].'</td>'; 
                    $data.='<td align="center">'.$row['received_qty'].'</td>';
                    $data.='<td align="center">'.$row['ledger_number'].'</td>'; 
                    $data.='<td align="center">'.$row['folio_number'].'</td>';                    
                    $data.='</tr>';
                    $j++;
                }
            }
            else
            {
                $data.='<tr><td colspan="'.(count($titles)).'" align="center">No Results Found</td></tr>';
            }
            $data.='</tbody>';
            $data.='</table>';
            $time = date("Ymdhis");
            $xlFile='MRR_Free_gift'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }

    }

    // mahesh 23rd apr 2017, 09:43 pm
    public function print_mrr_fg_list()
    {
        if($this->input->post('print_mrr_fg_list')!='') {
            
           $search_params=array(
                'mrr_number'         => $this->input->post('mrr_number', TRUE),
                'from_date'         => $this->input->post('from_date', TRUE),
                'to_date'           => $this->input->post('to_date', TRUE)
            
                                );   
            $data['mrr_fg_results'] = $this->Free_gift_mrr_m->mrr_fg_details($search_params);
            $data['search_params'] = $search_params;
            $this->load->view('mrr/print_mrr_fg_list',$data);
            
        }

    }

}