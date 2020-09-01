<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Unit_measure extends CI_Controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Unit_measure_m');
    }
    public function unit_measure()
    {

        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage unit Measures";
        $data['nestedView']['pageTitle'] = 'Manage Unit Measures';
        $data['nestedView']['cur_page'] = 'unit_measure';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage unit Measure', 'class' => 'active', 'url' => '');   

        # Search Functionality
        $p_search=$this->input->post('search_unit', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'name' => $this->input->post('name', TRUE)
                
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'name'   => $this->session->userdata('name')
                   
                    
                                  );
            }
            else {
                $search_params=array(
                      'name'    => '',
                    
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'unit_measure/';
        # Total Records
        $config['total_rows'] = $this->Unit_measure_m->unit_total_num_rows($search_params);

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
        $data['unit_results'] = $this->Unit_measure_m->unit_results($current_offset, $config['per_page'], $search_params);
       
        # Additional data
        $data['display_results'] = 1;

        $this->load->view('unit_measure_view',$data);

    }
    public function add_unit_measure()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add unit Measure";
        $data['nestedView']['pageTitle'] = 'Add unit Measure';
        $data['nestedView']['cur_page'] = 'unit_measure';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/unit_measure.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage unit Measure', 'class' => '', 'url' => SITE_URL.'unit_measure');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add Unit Measure', 'class' => 'active', 'url' => '');

       
        # Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_unit_measure';
        $this->load->view('unit_measure_view',$data);
    }
  
    public function insert_unit_measure()
    {
        // GETTING INPUT TEXT VALUES
        $name = $this->input->post('name',TRUE);
        $unit_id = 0;
        $unique = $this->Unit_measure_m->is_unitExist($name,$unit_id);
        if($unique==0)
        {
            $data = array( 
                    'name'       =>$this->input->post('name',TRUE)           
                    );
        
            $unit_id = $this->Common_model->insert_data('unit',$data);

            if ($unit_id>0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Success!</strong> unit has been added successfully! </div>');
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
            }
        }
        else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Error!</strong>Unit Measure name already exist. Please check. </div>');       
            }

        
        redirect(SITE_URL.'unit_measure');  
    }

    public function edit_unit_measure()
    {
        $unit_id=@cmm_decode($this->uri->segment(2));
        if($unit_id==''){
            redirect(SITE_URL.'unit_measure');
            exit;
        }

        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit unit Measure";
        $data['nestedView']['pageTitle'] = 'Edit unit Measure';
        $data['nestedView']['cur_page'] = 'unit_measure';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/unit_measure.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage unit Measure', 'class' => '', 'url' => SITE_URL.'unit_measure');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit unit Measure', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_unit_measure';
        $data['display_results'] = 0;
        
        # Data
        $row = $this->Common_model->get_data('unit',array('unit_id'=>$unit_id));
        $data['unit_row'] = $row[0];

        
        $this->load->view('unit_measure_view',$data);
    }

    public function update_unit_measure()
    {
        $unit_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($unit_id==''){
            redirect(SITE_URL.'unit_measure');
            exit;
        }
        $name = $this->input->post('name',TRUE);
        $unique = $this->Unit_measure_m->is_unitExist($name,$unit_id);
        if($unique==0)
        {
            // GETTING INPUT TEXT VALUES
            $data = array('name' => $this->input->post('name',TRUE));
            $where = array('unit_id'=>$unit_id);
            $this->Common_model->update_data('unit',$data,$where);

            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Success!</strong> unit Measure Name has been updated successfully! </div>');
            
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <strong>Error!</strong>Unit Measure Name already Exist. Please check. </div>');       
        }
        redirect(SITE_URL.'unit_measure');  
    }

    public function deactivate_unit_measure($encoded_id)
    {
    
        $unit_id=@cmm_decode($encoded_id);
        if($unit_id==''){
            redirect(SITE_URL.'unit_measure');
            exit;
        }
       
        
            $where = array('unit_id' => $unit_id);
            //deactivating user
            $data_arr = array('status' => 2);
            $this->Common_model->update_data('unit',$data_arr, $where);
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Success!</strong> unit  has been De-Activated successfully!</div>');
            redirect(SITE_URL.'unit_measure');           
        

    }
    
    public function activate_unit_measure($encoded_id)
    {
        $unit_id=@cmm_decode($encoded_id);
        if($unit_id==''){
            redirect(SITE_URL.'unit_measure');
            exit;
        }
        $where = array('unit_id' => $unit_id);
        //deactivating user
        $data_arr = array('status' => 1);
        $this->Common_model->update_data('unit',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> unit has been Activated successfully!</div>');
        redirect(SITE_URL.'unit_measure');

    }
    
    public function download_unit_measure()
    {
        if($this->input->post('download_unit')!='') {
            
            $search_params=array(
                
                'name' => $this->input->post('name', TRUE)
                
                              );
            $units= $this->Unit_measure_m->unit_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Unit Measure name');
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
            if(count($units)>0)
            {
                
                foreach($units as $row)
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
                $data.='<tr><td colspan="'.(count($titles)).'" align="center">No Results Found</td></tr>';
            }
            $data.='</tbody>';
            $data.='</table>';
            $time = date("Ymdhis");
            $xlFile='Unit_measure'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }    
  public  function is_unit_measureExist()
    {
        $name = $this->input->post('unit_name');
        $unit_id = $this->input->post('identity');
        echo $this->Unit_measure_m->is_unitExist($name,$unit_id);
    }

}