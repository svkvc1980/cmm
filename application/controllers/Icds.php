<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 15th Nov 2016 09:00 AM

class icds extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Icds_m");
    }


    public function icds()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage icds";
        $data['nestedView']['pageTitle'] = 'icds';
        $data['nestedView']['cur_page'] = 'icds';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage icds', 'class' => '', 'url' => ''); 

        # Search Functionality
        $p_search=$this->input->post('search_icds', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'icds_code' => $this->input->post('icds_code', TRUE),
                'icds_name'       => $this->input->post('icds_name', TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'icds_code'   => $this->session->userdata('icds_code'),
                    'icds_name'         => $this->session->userdata('icds_name'),
                    
                                  );
            }
            else {
                $search_params=array(
                      'icds_code'    => '',
                      'icds_name'          => '',
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'icds/';
        # Total Records
        $config['total_rows'] = $this->Icds_m->icds_total_num_rows($search_params);

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
        $data['icds_results'] = $this->Icds_m->icds_results($current_offset, $config['per_page'], $search_params);
       
        # Additional data
        $data['display_results'] = 1;

        $this->load->view('icds_view',$data);

    }
    public function add_icds()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add icds";
        $data['nestedView']['pageTitle'] = 'Add icds';
        $data['nestedView']['cur_page'] = 'icds';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/icds.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage icds', 'class' => '', 'url' => SITE_URL.'icds');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New icds', 'class' => 'active', 'url' => '');

        # Data
        
        # Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_icds';
        $data['display_results'] = 0;
        $this->load->view('icds_view',$data);
    }

    public function insert_icds()
    {
       
        // GETTING INPUT TEXT VALUES
        $data = array( 
                    'icds_code'       =>$this->input->post('icds_code',TRUE),
                    'icds_name'       =>$this->input->post('icds_name',TRUE),
                    'mrkexe_code'       =>$this->input->post('mrkexe_code',TRUE),
                    'ph_num'       =>$this->input->post('ph_num',TRUE)
                    );
        
        $icds_id = $this->Common_model->insert_data('icds',$data);

        if ($icds_id>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> icds has been added successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'icds');  
    }

    public function edit_icds()
    {
        $icds_id=@cmm_decode($this->uri->segment(2));
        //echo $icds_id; exit();
        if($icds_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit icds";
        $data['nestedView']['pageTitle'] = 'Edit icds';
        $data['nestedView']['cur_page'] = 'icds';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/icds.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage icds', 'class' => '', 'url' => SITE_URL.'icds');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit icds', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_icds';
        $data['display_results'] = 0;

        # Data
        $row = $this->Common_model->get_data('icds',array('icds_id'=>$icds_id));
        $data['icds_row'] = $row[0];

        
        $this->load->view('icds_view',$data);
    }

    public function update_icds()
    {
        $icds_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($icds_id==''){
            redirect(SITE_URL.'icds');
            exit;
        }
        // GETTING INPUT TEXT VALUES
        $data = array( 
                    'icds_code'       =>$this->input->post('icds_code',TRUE),
                    'icds_name'       =>$this->input->post('icds_name',TRUE),
                    'mrkexe_code'       =>$this->input->post('mrkexe_code',TRUE),
                    'ph_num'       =>$this->input->post('ph_num',TRUE)
                    );

        $where = array('icds_id'=>$icds_id);
        $res = $this->Common_model->update_data('icds',$data,$where);

        if ($res)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong>icds Type has been updated successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'icds');  
    }

    public function deactivate_icds($encoded_id)
    {
    
        $icds_id=@cmm_decode($encoded_id);
        if($icds_id==''){
            redirect(SITE_URL);
            exit;
        }/*
        $qry='SELECT * FROM icds WHERE icds_id="'.$icds_id.'" AND status="1" ';
        $count=$this->Common_model->get_no_of_rows($qry);
        if($count>0)
        {
          $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong> Sorry !</strong> Some Records Found With this Broker.So This Broker 
                                                    can not Be deactivated </div>');        
            redirect(SITE_URL.'icds');  
        }
        else*/
        
            $where = array('icds_id' => $icds_id);
            //deactivating user
            $data_arr = array('status' => 2);
            $this->Common_model->update_data('icds',$data_arr, $where);
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> icds  has been De-Activated successfully!</div>');
            redirect(SITE_URL.'icds');           
        

    }
    
    public function activate_icds($encoded_id)
    {
        $icds_id=@cmm_decode($encoded_id);
        if($icds_id==''){
            redirect(SITE_URL.'icds');
            exit;
        }
        $where = array('icds_id' => $icds_id);
        //deactivating user
        $data_arr = array('status' => 1);
        $this->Common_model->update_data('icds',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> icds has been Activated successfully!</div>');
        redirect(SITE_URL.'icds');

    }
    
    public function download_icds()
    {
        if($this->input->post('download_icds')!='') {
            
            $search_params=array(
               'icds_code'       =>$this->input->post('icds_code',TRUE),
                    'icds_name'       =>$this->input->post('icds_name',TRUE),
                    'mrkexe_code'       =>$this->input->post('mrkexe_code',TRUE),
                    'ph_num'       =>$this->input->post('ph_num',TRUE)
                              );
            $icdss = $this->Icds_m->icds_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','icds_code','icds_name','mrkexe_code','ph_num');
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
            if(count($icdss)>0)
            {
                
                foreach($icdss as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['icds_code'].'</td>';  
                    $data.='<td align="center">'.$row['icds_name'].'</td>';  
                    $data.='<td align="center">'.$row['mrkexe_code'].'</td>';  
                    $data.='<td align="center">'.$row['ph_num'].'</td>';                   
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
            $xlFile='icds'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
}