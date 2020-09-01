<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 15th Nov 2016 09:00 AM

class Micron extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Micron_m");
    }


    public function micron()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Film Specification";
        $data['nestedView']['pageTitle'] = 'Manage Film Specification';
        $data['nestedView']['cur_page'] = 'micron';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Film Specification', 'class' => 'active', 'url' => ''); 

        # Search Functionality
        $p_search=$this->input->post('search_micron', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'name'       => $this->input->post('name', TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'name'         => $this->session->userdata('name')
                    
                                  );
            }
            else {
                $search_params=array(
                     'name'          => '',
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'micron/';
        # Total Records
        $config['total_rows'] = $this->Micron_m->micron_total_num_rows($search_params);

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
        $data['micron_results'] = $this->Micron_m->micron_results($current_offset, $config['per_page'], $search_params);
       
        # Additional data
        $data['display_results'] = 1;

        $this->load->view('micron_view',$data);

    } public function add_micron()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add Film Specification";
        $data['nestedView']['pageTitle'] = 'Add Film Specification';
        $data['nestedView']['cur_page'] = 'add_micron';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/micron.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Film Specification', 'class' => '', 'url' => SITE_URL.'icds');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add Film Specification', 'class' => 'active', 'url' => '');

        # Data
        
        # Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_micron';
        $data['display_results'] = 0;
        $this->load->view('micron_view',$data);
    }
   

    public function insert_micron()
    { 
        // GETTING INPUT TEXT VALUES
        $name = $this->input->post('name',TRUE);
        $micron_id = 0;
        $unique = $this->Micron_m->is_nameExist($name,$micron_id);
        if($unique==0)
        {
            $data = array( 
                   'name'       =>$name,
                    'created_by'=>$this->session->userdata('user_id'),
                    'created_time'=>date('Y-m-d H:m:s')
                    );
        
            $micron_id = $this->Common_model->insert_data('micron',$data);

            if ($micron_id>0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Success!</strong>Film Specification has been added successfully! </div>');
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
                <strong>Error!</strong>Film Specification already Existed ! Try again</div>');       
        }

        redirect(SITE_URL.'micron');  
    }

    public function edit_micron()
    {
        $micron_id=@cmm_decode($this->uri->segment(2));
        if($micron_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Film Specification";
        $data['nestedView']['pageTitle'] = 'Edit Film Specification';
        $data['nestedView']['cur_page'] = 'edit_micron';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/micron.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Film Specification', 'class' => '', 'url' => SITE_URL.'broker');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Film Specification', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_micron';
        $data['display_results'] = 0;

        # Data
        $row = $this->Common_model->get_data('micron',array('micron_id'=>$micron_id));
        $data['micron_row'] = $row[0];

        
        $this->load->view('micron_view',$data);
    }

    public function update_micron()
    {
        $micron_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($micron_id==''){
            redirect(SITE_URL.'micron');
            exit;
        }
        $name = $this->input->post('name',TRUE);
        $unique = $this->Micron_m->is_nameExist($name,$micron_id);
        if($unique==0)
        {
            $data = array( 
                   'name'    => $this->input->post('name',TRUE),
                   'modified_by'=>$this->session->userdata('user_id'),
                   'modified_time'=>date('Y-m-d H:m:s'),
                    'status'       => 1
                    ); 

            $where = array('micron_id'=>$micron_id);
            $res = $this->Common_model->update_data('micron',$data,$where);

            if ($res)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Success!</strong>Film Specification has been updated successfully! </div>');
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
            <strong>Error!</strong>Film Specification already existed! Try again</div>');       
        }
        redirect(SITE_URL.'micron');  
    }

    public function deactivate_micron($encoded_id)
    {
    
        $micron_id=@cmm_decode($encoded_id);
        if($micron_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('micron_id' => $micron_id);
        //deactivating user
        $data_arr = array('status' => 2);
        $this->Common_model->update_data('micron',$data_arr, $where);
        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Success!</strong> Film Specification  has been De-Activated successfully!</div>');
        redirect(SITE_URL.'micron');           
        

    }
    
    public function activate_micron($encoded_id)
    {
        $micron_id=@cmm_decode($encoded_id);
        if($micron_id==''){
            redirect(SITE_URL.'micron');
            exit;
        }
        $where = array('micron_id' => $micron_id);
        //deactivating user
        $data_arr = array('status' => 1);
        $this->Common_model->update_data('micron',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Success!</strong> Film Specification has been Activated successfully!</div>');
        redirect(SITE_URL.'micron');

    }
    public  function is_micronExist()
    {
        $name = $this->input->post('name');
        $micron_id = $this->input->post('identity');
        echo $this->Micron_m->is_nameExist($name,$micron_id);
    }
}