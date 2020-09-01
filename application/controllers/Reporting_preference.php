<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Reporting_preference extends Base_controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Reporting_preference_m");              
    }
        public function reporting_preference()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Reporting Settings";
        $data['nestedView']['pageTitle'] = 'Reporting Settings';
        $data['nestedView']['cur_page'] = 'reporting_preference';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Reporting Settings', 'class' => 'active', 'url' =>'');

        # Search Functionality
        $psearch=$this->input->post('searchreporting_preference', TRUE);
        if($psearch!='') 
        {
            $searchParams=array(
                               'label' => $this->input->post('label', TRUE)
                               );
            $this->session->set_userdata($searchParams);
        } 
        else 
        {

        if($this->uri->segment(2)!='')
            {
            $searchParams=array(
                              'label'=>$this->session->userdata('label')
                              );
            }
            else {
                $searchParams=array(
                                    'label'=>''
                                   );
                $this->session->set_userdata($searchParams);
            }
            
        }
        $data['search_data'] = $searchParams;


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'reporting_preference/';
        # Total Records
        $config['total_rows'] = $this->Reporting_preference_m->reporting_total_num_rows($searchParams);
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
        $data['reportingResults'] = $this->Reporting_preference_m->reporting_results($current_offset, $config['per_page'], $searchParams);
        
        # Additional data
        $data['label_list'] = $this->Common_model->get_data('reporting_preference',array('status'=>1));
        $data['displayResults'] = 1;
        $this->load->view('reporting_preference',$data);
    }

public function add_reporting_preference()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add Reporting Preference";
        $data['nestedView']['pageTitle'] = 'Add Reporting Preference';
        $data['nestedView']['cur_page'] = 'reporting_preference';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/reporting_preference.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add Reporting Preference', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 1;
        $data['designation_list'] = $this->Reporting_preference_m->get_designation_list();
        $database_name = $this->db->database;
        $data['table_list'] = $this->db->query("SELECT t.TABLE_NAME AS table_name FROM INFORMATION_SCHEMA.TABLES AS t WHERE t.TABLE_SCHEMA = '$database_name' ")->result_array();
        $data['form_action'] = SITE_URL.'insert_reporting_preference';
        $data['displayResults'] = 0;
        $this->load->view('reporting_preference',$data);
    }

//Nagarjuna 21th Jan 2017 03:00 pm
public function insert_reporting_preference()
    {
        $data = array(
                      'name'               =>      $this->input->post('name',TRUE),
                      'section'            =>      $this->input->post('section',TRUE),
                      'label'              =>      $this->input->post('label',TRUE),
                      'issue_raised_by'    =>      $this->input->post('issue_raised_by',TRUE),
                      'issue_closed_by'    =>      $this->input->post('issue_closed_by',TRUE),
                      'table_name'         =>      $this->input->post('table_name',TRUE),
                      'table_column'       =>      $this->input->post('table_column',TRUE),
                      'table_primary_column'       =>      $this->input->post('table_primary_column',TRUE),
                      'created_by'         =>      $this->session->userdata('user_id'),
                      'created_time'       =>      date('Y-m-d H:i:s')
                    );
        $reporting_preference_id = $this->Common_model->insert_data('reporting_preference',$data);
        if($reporting_preference_id>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                      <strong>Success!</strong> Reporting preference has been added successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                      <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'reporting_preference');  
    }

public function edit_reporting_preference()
    {
        $rep_preference_id = @cmm_decode($this->uri->segment(2));
        if($rep_preference_id =='')
        {
            redirect(SITE_URL.'reporting_preference');
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Reporting preference";
        $data['nestedView']['pageTitle'] = 'Edit Reporting preference';
        $data['nestedView']['cur_page'] = 'reporting_preference';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/bank.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Reporting preference', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_reporting_preference';
        $data['displayResults'] = 0;

        # Data
        $row = $this->Common_model->get_data('reporting_preference',array('rep_preference_id'=>$rep_preference_id));
        $table_name = $row[0]['table_name'];
        if($table_name != '')
        {
        	$data['table_column'] = $this->db->query("desc $table_name")->result_array();
        }
        $data['lrow'] = $row[0];
        $data['designation_list'] = $this->Reporting_preference_m->get_designation_list();
        $data['table_list'] = $this->db->query("SELECT t.TABLE_NAME AS table_name FROM INFORMATION_SCHEMA.TABLES AS t WHERE t.TABLE_SCHEMA = 'oil_fed_25' ")->result_array();
        $this->load->view('reporting_preference',$data);
    }

    //Nagarjuna 21th Jan 2017 03:00 pm
    public function update_reporting_preference()
    {
        $rep_preference_id = @cmm_decode($this->input->post('encoded_id',TRUE));
        if($rep_preference_id==''){
            redirect(SITE_URL.'reporting_preference');
            exit;
        }
        $data = array(
                      'name'               =>      $this->input->post('name',TRUE),
                      'section'            =>      $this->input->post('section',TRUE),
                      'label'              =>      $this->input->post('label',TRUE),
                      'issue_raised_by'    =>      $this->input->post('issue_raised_by',TRUE),
                      'issue_closed_by'    =>      $this->input->post('issue_closed_by',TRUE),
                      'table_name'         =>      $this->input->post('table_name',TRUE),
                      'table_column'       =>      $this->input->post('table_column',TRUE),
                      'table_primary_column'       =>      $this->input->post('table_primary_column',TRUE),
                      'modified_by'        =>      $this->session->userdata('user_id'),
                      'modified_time'      =>      date('Y-m-d H:i:s')
                    );
        $where = array('rep_preference_id'=>$rep_preference_id);
        $res = $this->Common_model->update_data('reporting_preference',$data,$where);

        if ($res>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Reporting preference has been updated successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'reporting_preference');  
    }

    public function get_table_column()
    {
        $table_name = $this->input->post('table_name',TRUE);
        echo $this->Reporting_preference_m->get_table_column($table_name);
    }

    public function get_table_primary_column()
    {
        $table_name = $this->input->post('table_name',TRUE);
        echo $this->Reporting_preference_m->get_table_primary_column($table_name);
    }

     public function rollback_settings()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Manage Rollback Settings";
        $data['nestedView']['pageTitle'] = 'Manage Rollback Settings';
        $data['nestedView']['cur_page'] = 'rollback_settings';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'settings';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'General Rollback Settings','class'=>'active','url'=>'');      
        #data 
        $data['preference_list'] = $this->Common_model->get_data('reporting_preference',array('status'=>1));
        $data['designation_list'] = $this->Reporting_preference_m->get_designation_list();
        $data['form_action'] = SITE_URL.'update_rollback_settings';
        $this->load->view('settings/rollback_settings_view',$data);
    }
    public function update_rollback_settings()
    {
        $setting = $this->input->post('submit',TRUE);
        if($setting == 1)
        {
            $old_issue_raised_by = $this->input->post('old_issue_raised_by',TRUE);
            $old_issue_closed_by = $this->input->post('old_issue_closed_by',TRUE);
            $new_issue_raised_by = $this->input->post('new_issue_raised_by',TRUE);
            $new_issue_closed_by = $this->input->post('new_issue_closed_by',TRUE);

            $count1 = count($old_issue_raised_by);
            $count = 0;
            foreach ($old_issue_raised_by as $key => $value) 
            { 
                $new_issue_raised = $new_issue_raised_by[$key];
                $old_issue_closed = $old_issue_closed_by[$key];
                $new_issue_closed = $new_issue_closed_by[$key];
                if($value != $new_issue_raised || $old_issue_closed != $new_issue_closed)
                {
                    $update_data = array(
                          'issue_raised_by' => $new_issue_raised,
                          'issue_closed_by' => $new_issue_closed,
                          'modified_by'     => $this->session->userdata('user_id'),
                          'modified_time'   => date('Y-m-d H:i:s')
                                       );
                    $where = array('rep_preference_id' => $key);
                    $this->db->trans_begin();
                    $this->Common_model->update_data('reporting_preference',$update_data,$where);
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
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Success!</strong>Rollback Settings has been Updated successfully! </div>');
                    }
                }
                else
                {
                    $count++;
                }
            }
            if($count1 == $count)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>No Changes has been Occured !.</div>');
            }
        }
        redirect(SITE_URL.'rollback_settings');
    }
}