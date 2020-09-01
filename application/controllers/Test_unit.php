<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Test_unit extends Base_controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Test_unit_m");
        $this->load->model("Common_model");             
    }
        public function test_unit()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Test Unit List";
        $data['nestedView']['pageTitle'] = 'Test unit List';
        $data['nestedView']['cur_page'] = 'test_unit';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'lab_test';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Test Unit List', 'class' => 'active', 'url' => '');

        # Search Functionality
        $psearch=$this->input->post('searchunit', TRUE);
        if($psearch!='') 
        {
            $searchParams=array(
                               'name' => $this->input->post('name', TRUE)
                               );
            $this->session->set_userdata($searchParams);
        } 
        else 
        {

        if($this->uri->segment(2)!='')
            {
            $searchParams=array(
                              'name'=>$this->session->userdata('name')
                              );
            }
            else {
                $searchParams=array(
                                    'name'=>''
                                   );
                $this->session->set_userdata($searchParams);
            }
            
        }
        $data['search_data'] = $searchParams;


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'test_unit/';
        # Total Records
        $config['total_rows'] = $this->Test_unit_m->unit_total_num_rows($searchParams);

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
        $data['unitResults'] = $this->Test_unit_m->unit_results($current_offset, $config['per_page'], $searchParams);
        
        # Additional data
        $data['portlet_title'] = '';
        $data['displayResults'] = 1;

        $this->load->view('test_unit',$data);

    }

public function add_test_unit()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add New Test Unit";
        $data['nestedView']['pageTitle'] = 'Add New Test Unit';
        $data['nestedView']['cur_page'] = 'test_unit';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'lab_test';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/test_unit.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New Test Unit', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_test_unit';
        $data['displayResults'] = 0;
        $this->load->view('test_unit',$data);
    }

    //Nagarjuna 21th Jan 2017 03:00 pm
    public function insert_test_unit()
    {
        $data = array(
                      'name'       =>      $this->input->post('test_unit',TRUE),
                      'created_by' =>      1 
                    );
        
        $test_unit_id = $this->Common_model->insert_data('test_unit',$data);
        if($test_unit_id>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                      <strong>Success!</strong> Test Unit has been added successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                      <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'test_unit');  
    }

public function edit_test_unit()
    {
        $test_unit_id=@cmm_decode($this->uri->segment(2));
        if($test_unit_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="EDIT TEST UNIT";
        $data['nestedView']['pageTitle'] = 'Edit Test Unit';
        $data['nestedView']['cur_page'] = 'test_unit';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'lab_test';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/test_unit.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Test Unit', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_test_unit';
        $data['displayResults'] = 0;

        # Data
        $row = $this->Common_model->get_data('test_unit',array('test_unit_id'=>$test_unit_id));
        $data['lrow'] = $row[0];
        $this->load->view('test_unit',$data);
    }

//Nagarjuna 21th Jan 2017 03:00 pm
public function update_test_unit()
    {
        $test_unit_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($test_unit_id==''){
            redirect(SITE_URL);
            exit;
        }
        // GETTING INPUT TEXT VALUES
        /*$user_id=1;*/
        $data = array( 
                    'name'               =>      $this->input->post('test_unit',TRUE),
                    'modified_by'        =>      $this->session->userdata('user_id'),
                    'modified_time'      =>      date('Y-m-d H:i:s')
                    );
        $where = array('test_unit_id'=>$test_unit_id);
        $res = $this->Common_model->update_data('test_unit',$data,$where);

        if ($res)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Test Unit has been updated successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'test_unit');  
    }

public function deactivate_test_unit($encoded_id)
    {
    
        $test_unit_id=@cmm_decode($encoded_id);
        if($test_unit_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('test_unit_id' => $test_unit_id);
        //deactivating user
        $data_arr = array('status' => 2,
                          'modified_by'   => $this->session->userdata('user_id'),
                          'modified_time' => date('Y-m-d H:i:s'));
        $this->Common_model->update_data('test_unit',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Test Unit has been De-Activated successfully!</div>');
        redirect(SITE_URL.'test_unit');

    }
public function activate_test_unit($encoded_id)
    {
        $test_unit_id=@cmm_decode($encoded_id);
        if($test_unit_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('test_unit_id' => $test_unit_id);
        //deactivating user
        $data_arr = array('status' => 1,
                          'modified_by'   => $this->session->userdata('user_id'),
                          'modified_time' => date('Y-m-d H:i:s'));
        $this->Common_model->update_data('test_unit',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Test Unit has been Activated successfully!</div>');
            redirect(SITE_URL.'test_unit');

    }
public function download_test_unit()
    {
        if($this->input->post('download_test_unit')!='') {
            
            $searchParams=array(
                               'name' => $this->input->post('name', TRUE)
                               );
            $test_unit = @$this->Test_unit_m->test_unit_details($searchParams);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Name');
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
            if(count(@$test_unit)>0)
              {
                foreach(@$test_unit as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['name'].'</td>';
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
            $xlFile='test_unit_'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }

//Function to check the uniqueness of Test Units
    public function is_test_unitExist()
    {
        $name = $this->input->post('name');
        $test_unit_id = $this->input->post('test_unit_id');
        echo $this->Test_unit_m->is_test_unitExist($name,$test_unit_id);
    }
//ending of Uniqueness of Test units - nagarjune//
}

