<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by Srilekha 25th April 2017 04:14 PM

class Rollback_designation extends Base_controller { 

	public function __construct() 
    {
        parent::__construct();
        $this->load->model("Rollback_designation_m");
    }

    public function reportee_designation()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Reporting Manager";
		$data['nestedView']['pageTitle'] = 'Reporting Manager';
        $data['nestedView']['cur_page'] = 'Reporting Manager';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Reporting Manager', 'class' => 'active', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_designation', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'reportee_id' 		 => $this->input->post('reportee_id', TRUE),
                'reporting_id'       => $this->input->post('reporting_id', TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'reportee_id'    => $this->session->userdata('reportee_id'),
                    'reporting_id'   => $this->session->userdata('reporting_id'),
                    
                                  );
            }
            else {
                $search_params=array(
                      'reportee_id'     => '',
                      'reporting_id'    => '',
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'reportee_designation/';
        # Total Records
        $config['total_rows'] = $this->Rollback_designation_m->reportee_designation_total_num_rows($search_params);

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
        $data['reporting_manager_results'] = $this->Rollback_designation_m->reportee_designation_results($current_offset, $config['per_page'], $search_params);
       	$data['designation']=$this->Rollback_designation_m->get_designations();
        # Additional data
        $data['display_results'] = 1;

        $this->load->view('rollback_designation/rollback_designation_view',$data);

    }
    
    public function add_reportee_designation()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add Reporting Manager";
        $data['nestedView']['pageTitle'] = 'Add Reporting Manager';
        $data['nestedView']['cur_page'] = 'Reporting Manager';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Reporting Manager', 'class' => '', 'url' => SITE_URL.'reportee_designation');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add reporting Manager', 'class' => 'active', 'url' => '');

        # Data
        
        # Additional data
        $data['designation']=$this->Rollback_designation_m->get_designations();
        $data['flag'] = 1;
        $data['form_action'] = SITE_URL.'insert_reportee_designation';
        $data['display_results'] = 0;
        $this->load->view('rollback_designation/rollback_designation_view',$data);
    }

    public function insert_reportee_designation()
    {
       
        $new_reportee_id = $this->input->post('reportee_designation',TRUE);
        $new_reporting_id = $this->input->post('reporting_designation',TRUE);
        $this->db->trans_begin();
        $this->Rollback_designation_m->insert_update($new_reportee_id,$new_reporting_id);
        if($this->db->trans_status()===FALSE)
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
                                                    <strong>Success!</strong> Reporting Manager has been added successfully! </div>');
        }
        

        redirect(SITE_URL.'reportee_designation');  
    }

    public function edit_reportee_designation()
    {
        $reportee_id=@cmm_decode($this->uri->segment(2));
        $reporting_id=@cmm_decode($this->uri->segment(3));
        if($reportee_id=='' && $reporting_id==''){
            redirect(SITE_URL.'reportee_designation');
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Reporting Manager";
        $data['nestedView']['pageTitle'] = 'Edit Reporting Manager';
        $data['nestedView']['cur_page'] = 'Reporting Manager';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Reporting Manager', 'class' => '', 'url' => SITE_URL.'reportee_designation');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Reporting Manager', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flag'] = 2;
        $data['form_action'] = SITE_URL.'update_reportee_designation';
        $data['display_results'] = 0;

        # Data
        $row = $this->Common_model->get_data('designation_reporting',array('reportee_id'=>$reportee_id,'reporting_id'=>$reporting_id));
        $data['designation_row']=$row[0];
        $data['designation']=$this->Rollback_designation_m->get_designations();
        $data['reportee_id']=$reportee_id;
        $data['reporting_id']=$reporting_id;

        $this->load->view('rollback_designation/rollback_designation_view',$data);
    }

    public function update_reportee_designation()
    {
        $reportee_id=@cmm_decode($this->input->post('reportee_id',TRUE));
        $reporting_id=@cmm_decode($this->input->post('reporting_id',TRUE));
        if($reportee_id=='' && $reporting_id==''){
            redirect(SITE_URL);
            exit;
        }

        $update_des_data = array('status' => 2);
        $update_des_where = array('reportee_id'  =>  $reportee_id,
                                  'reporting_id' =>  $reporting_id);
        $this->db->trans_begin();
        $this->Common_model->update_data('designation_reporting',$update_des_data,$update_des_where);

        $new_reportee_id = $this->input->post('reportee_designation',TRUE);
        $new_reporting_id = $this->input->post('reporting_designation',TRUE);
        $this->Rollback_designation_m->insert_update($new_reportee_id,$new_reporting_id);

                    
        if($this->db->trans_status()===FALSE)
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
                                                    <strong>Success!</strong> Reporting Designation has been updated successfully! </div>');
        }
        redirect(SITE_URL.'reportee_designation');  
    }

     public function download_reportee_designation()
    {
        if($this->input->post('download_designation')!='') {
            
            $search_params=array(
                'reportee_id' 		=> $this->input->post('reportee_id', TRUE),
                'reporting_id'       => $this->input->post('reporting_id', TRUE)
            
                              );
            $designations = $this->Rollback_designation_m->reportee_designation_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Reportee Designation','Reporting Designation');
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
            if(count($designations)>0)
            {
                
                foreach($designations as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['reportee_name'].'</td>';                   
                    $data.='<td align="center">'.$row['reporting_name'].'</td>';
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
            $xlFile='Reportee_designation'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }

}