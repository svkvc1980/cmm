<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Tanker_registration extends Base_controller {
	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Tanker_registration_m");
        $this->load->library('Pdf');
	}
/*Tanker Registration details
Author:Srilekha
Time: 11.46AM 16-02-2017 */
	public function tanker_registration()
	{
        //echo $this->session->userdata('ses_plant_id'); exit();
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Vehicle Register List";
		$data['nestedView']['pageTitle'] = 'Vehicle Register List';
        $data['nestedView']['cur_page'] = 'tanker_register_r';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Vehicle Register List', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_tanker', TRUE);
        
        
        if($p_search!='') 
        {
            $start_date = $this->input->post('start_date',TRUE);
            if($start_date!=''){ $startdate = date('Y-m-d',strtotime($start_date)); } else { $startdate = ''; }
            $end_date = $this->input->post('end_date',TRUE);
            if($end_date!=''){ $enddate = date('Y-m-d',strtotime($end_date)); } else { $enddate = ''; }
            
            $search_params=array(
                 'vehicle_num'         => $this->input->post('vehicle_num', TRUE),
                 'tanker_type'         => $this->input->post('tanker_type',TRUE),
                 'start_date'             => $startdate,
                 'end_date' =>$enddate
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                   'vehicle_num'         => $this->session->userdata('vehicle_num'),
                   'tanker_type'         => $this->session->userdata('tanker_type'),
                   'start_date'             => $this->session->userdata('start_date'),
                   'end_date'=>$this->session->userdata('end_date')
                                    );
            }
            else {
                $search_params=array(
                     'vehicle_num'     => '',
                     'tanker_type'     => '',
                     'start_date'         => '',
                     'end_date' =>''
                                    );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        
        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'tanker_register/';
        # Total Records
        $config['total_rows'] = $this->Tanker_registration_m->tanker_total_num_rows($search_params);

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
        $data['tanker_results'] = $this->Tanker_registration_m->tanker_results($current_offset, $config['per_page'], $search_params);
        $block_id = $this->session->userdata('block_id');

        # Get Tanker Type
        if($block_id == 2)
        {
            $data['tanker'] = $this->Common_model->get_data('tanker_type',array('status'=>1,'tanker_type_id!='=>6));
        }
        else
        {
            $data['tanker'] = $this->Tanker_registration_m->get_tanker_type_plant(); 
        }

        # Additional data
        $data['display_results'] = 1;
        
        $this->load->view('tanker_registration/tanker_registration_view',$data);
	}
/*Download Tanker details
Author:Srilekha
Time: 12.35PM 16-02-2017 */
	public function download_tanker_details()
    {
        if($this->input->post('download_tanker')!='') {
        	$start_date = $this->input->post('start_date',TRUE);
            if($start_date!=''){ $startdate = date('Y-m-d',strtotime($start_date)); } else { $startdate = ''; }
            $end_date = $this->input->post('end_date',TRUE);
            if($end_date!=''){ $enddate = date('Y-m-d',strtotime($end_date)); } else { $enddate = ''; }
            
           $search_params=array(
                 'vehicle_num'         => $this->input->post('vehicle_num', TRUE),
                 'tanker_type'         => $this->input->post('tanker_type',TRUE),
                 'start_date'             => $startdate,
                 'end_date' =>$enddate
            
                              );   
            $tanker = $this->Tanker_registration_m->tanker_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Tanker In Number','Tanker Type','Vehicle Number','In Time');
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
            if(count($tanker)>0)
            {
                
                foreach($tanker as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['tanker_in_number'].'</td>';
                    $data.='<td align="center">'.$row['tanker_name'].'</td>';
                    $data.='<td align="center">'.$row['vehicle_number'].'</td>';
                    $data.='<td align="center">'.$row['in_time'].'</td>';                   
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
            $xlFile='Tanker_details'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }

    public function print_tanker_details()
    {
        $tanker_id=@cmm_decode($this->uri->segment(2));
        if($tanker_id=='')
        {
            redirect(SITE_URL.'tanker_registration');
            exit;
        }
        $data['tanker_details'] = $this->Tanker_registration_m->get_tanker_in_details($tanker_id);
        $this->load->view('tanker_registration/print_tanker_in',$data);
    }

    public function print_vehicle_details()
    {
        if($this->input->post('print_vehicle_details')!='') 
        {
           $start_date = $this->input->post('start_date',TRUE);
            if($start_date!=''){ $startdate = date('Y-m-d',strtotime($start_date)); } else { $startdate = ''; }
            $end_date = $this->input->post('end_date',TRUE);
            if($end_date!=''){ $enddate = date('Y-m-d',strtotime($end_date)); } else { $enddate = ''; }
            
            $search_params=array(
                        'vehicle_num'         => $this->input->post('vehicle_num', TRUE),
                        'tanker_type'         => $this->input->post('tanker_type',TRUE),
                        'start_date'          => $startdate,
                        'end_date'            => $enddate
                           );
            $print_vehicle_details = $this->Tanker_registration_m->print_vehicle_details(@$search_params);
            $data['print_vehicle_details']=$print_vehicle_details;
            $data['search_params']=$search_params;
            //print_r($data['print_vehicle_details']);exit;
        }
        $this->load->view('tanker_registration/print_vehicle_details',$data);
    }
}