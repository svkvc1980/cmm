<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class ob_history_oil_R extends CI_Controller{

	public function __construct() 
    {
        parent::__construct();
        $this->load->model("ob_history_oil_R_m");

    }

    /* Ob History Oil Records List
    Author:aswini
       Time: 3pm 10-03-2017 */
public function ob_history_oil_R()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="OB Control (Oils) Report";
		$data['nestedView']['pageTitle'] = 'OB Control (Oils) Report';
        $data['nestedView']['cur_page'] = 'ob_control_oil_r';
        $data['nestedView']['parent_page'] = 'reports';
        $data['nestedView']['list_page'] = 'ob_control_r';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'OB Control (Oils) Report', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_ob_history_oil_R', TRUE);
        if($p_search!='') 
        {
             $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 

           $search_params=array(
                'loose_oil_id'       => $this->input->post('loose_oil',TRUE),
                'from_date'          => $from_date,
                'to_date'            => $to_date
               
                               );
            $this->session->set_userdata($search_params);
        } 
        else 
        { 
            
           if($this->uri->segment(2)!='')
            {

            $search_params=array(
                'loose_oil_id'       =>     $this->input->post('loose_oil'),
                'from_date'          =>     $this->session->userdata('from_date'),
                'to_date'            =>     $this->session->userdata('to_date')
                    );
               
            }
            else {
                $search_params=array( 
                'loose_oil_id'            =>    '',
                'from_date'               =>    '',
                'to_date'                 =>    ''
                      
                                     );
                
                $this->session->set_userdata($search_params);
                 }
        }
        $data['search_data'] = $search_params;
        
         # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        
        # Total Records
        $config['base_url'] = SITE_URL . 'ob_history_oil_R';
        $config['total_rows'] = $this->ob_history_oil_R_m->ob_history_oil_R_total_num_rows($search_params);

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
        $data['ob_history_oil_R_row'] = $this->ob_history_oil_R_m->ob_history_oil_R_results($current_offset, $config['per_page'], $search_params);

        $data['loose_oil'] = array('' =>'Select Loose Oil')+$this->Common_model->get_dropdown('loose_oil','loose_oil_id','name');
        
        $data['display_results'] = 1;
        $this->load->view('ob_history_oil_R',$data);

   }

/*download Ob History Oil Records List
    Author:aswini
       Time: 3pm 10-03-2017 */
public function download_ob_history_oil_R()
    {
        if($this->input->post('download_ob_history_oil_R')!='') 
        {
            $search_params=array(
                                'loose_oil_id'   => $this->input->post('loose_oil',TRUE),
                              'from_date'        => $this->input->post('from_date', TRUE),
                              'to_date'         => $this->input->post('to_date', TRUE)   
                                );
            $ob_history_oil_R_row1 = $this->ob_history_oil_R_m->ob_history_oil_R_details($search_params);            
            $header = '';
            $data ='';
            $titles = array('S.NO','Loose Oil','Status','Date');
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
            if(count($ob_history_oil_R_row1)>0)
            {
                
                foreach($ob_history_oil_R_row1 as $row)
                {
                    if($row['status']==1)
                    {
                        $status = 'ON';
                    }
                    else
                    {
                        $status = 'OFF';
                    }
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                      $data.='<td align="center">'.$row['loose_oil_name'].'</td>'; 
                    $data.='<td align="center">'.$status.'</td>'; 
                    $data.='<td align="center">'.$row['created_time'].'</td>'; 
                                                          
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
            $xlFile='OB control oil Record'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
        }

    }
}