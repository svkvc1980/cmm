<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Designation extends CI_Controller{

	public function __construct() 
    {
        parent::__construct();
        $this->load->model("Common_model");
        $this->load->model("Designation_m");

    }
/*Search Designation details
Author:Srilekha
Time: 02.40PM 06-02-2017 */
	public function designation()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Designation";
		$data['nestedView']['pageTitle'] = 'Designation';
        $data['nestedView']['cur_page'] = 'designation';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Designation', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_designation', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                 'name'       => $this->input->post('desig_name', TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                   'name'         => $this->session->userdata('desig_name'),
                    
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
        $config['base_url'] = SITE_URL . 'designation/';
        # Total Records
        $config['total_rows'] = $this->Designation_m->designation_total_num_rows($search_params);

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
        $data['designation_results'] = $this->Designation_m->designation_results($current_offset, $config['per_page'], $search_params);
         
        
        # Additional data
        $data['display_results'] = 1;
        
        $this->load->view('designation/designation_view',$data);

    }


/*Adding Designation details
Author:Srilekha
Time: 02.44PM 06-02-2017 */
	public function add_designation()
	{
		# Data Array to carry the require fields to View and Model
	    $data['nestedView']['heading']="Add Designation";
	    $data['nestedView']['cur_page'] = 'designation';
	    $data['nestedView']['pageTitle'] = 'Add Designation';
	    $data['nestedView']['parent_page'] = 'master';


	    # Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/designation.js" type="text/javascript"></script>';
		$data['nestedView']['css_includes'] = array();

		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Add Plant';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Add Designation','class'=>'active','url'=>'');



		# Additional data
		$data['state']= $this->Common_model->get_data('location',array('level_id'=>2,'status'=>1));
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_designation';
        $data['display_results'] = 0;
        $data['block'] = $this->Common_model->get_dropdown('block', 'block_id', 'name', array('status'=>1));
        $data['manager'] = $this->Common_model->get_dropdown('designation', 'designation_id', 'name', array('status'=>1));
        $data['blockselected'] = array();
    	
        $this->load->view('designation/designation_view',$data);
	}


/*Insert Plant details
Author:Srilekha
Time: 12.15PM 06-02-2017 */
	public function insert_designation()
	{
        $desig_name = $this->input->post('designation_name');
        $desig_id = 0;
        $unique = $this->Designation_m->is_designationExist($desig_name,$desig_id);
        if($unique==0)
        {
            $data=array(
                        'name'                  =>     $desig_name,
                        'description'           =>     $this->input->post('description'),
                        'status'                =>     1,
                        'created_by'            =>     $this->session->userdata('user_id'),
                        'created_time'          =>     date('Y-m-d H:i:s')
                        );
            //echo "<pre>"; print_r($data); exit;
            $this->db->trans_begin();
            $designation = $this->Common_model->insert_data('designation',$data);
            for($i = 0; $i < count(@$this->input->post('block_type',TRUE)); $i++)
            {
                $data=array(
                        'block_id'                    =>     $this->input->post('block_type')[$i],
                        'designation_id'              =>     $designation
                        );

                $block_designation = $this->Common_model->insert_data('block_designation',$data);

            }
            if ($this->db->trans_status()===FALSE)
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
                                                        <strong>Success!</strong> Designation has been added successfully! </div>');
                      
            }
        }
        else
        {
             $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> UserName already exist! Try Again. </div>');

        }
            
	        	
	       redirect(SITE_URL.'designation');
	}

/*Edit Designation details
Author:Srilekha
Time: 04.00PM 06-02-2017 */
	public function edit_designation()
    {
        $designation_id=@cmm_decode($this->uri->segment(2));
        if($designation_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Designation";
        $data['nestedView']['pageTitle'] = 'Edit Designation';
        $data['nestedView']['cur_page'] = 'designation';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/designation.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Designation', 'class' => '', 'url' => SITE_URL.'designation');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Designation', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_designation';
        $data['display_results'] = 0;

        $data['block'] = $this->Common_model->get_dropdown('block', 'block_id', 'name', array('status'=>1));
        $data['blockselected'] = array_column($this->Common_model->get_data('block_designation', array('status'=>1,'designation_id'=>$designation_id),array('block_id'), '1'), 'block_id');
        $data['designation_selected']=$this->Common_model->get_value('designation',array('designation_id'=>$designation_id),'parent_id');
        

        # Data
        $row = $this->Common_model->get_data('designation',array('designation_id'=>$designation_id));
        $row1= $this->Common_model->get_data('block_designation',array('designation_id'=>$designation_id,'status'=>1));
        
        $data['designation_row'] = $row[0];
        $data['block_row'] = $row1[0];

        $data['block_data'] = $this->Common_model->get_data('block',array('status'=>1));
        
        $data['manager'] = $this->Common_model->get_dropdown('designation', 'designation_id', 'name', array('status'=>1));
        $this->load->view('designation/designation_view',$data);
    }

/*Update Designation details
Author:Srilekha
Time: 04.01PM 06-02-2017 */
     public function update_designation()
    {
        $designation_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($designation_id=='')
        {
            redirect(SITE_URL.'designation');
            exit;
        }

        $desig_name = $this->input->post('designation_name');
        $unique = $this->Designation_m->is_designationExist($desig_name,$designation_id);
        if($unique==0)
        {
            // GETTING INPUT TEXT VALUES
            $data = array( 
                        'name'                  =>     $this->input->post('designation_name'),
                        'description'           =>     $this->input->post('description'),
                        'status'                =>     1,
                        'modified_by'           =>     $this->session->userdata('user_id'),
                        'modified_time'         =>     date('Y-m-d H:i:s')
                    );

            $where = array('designation_id'=>$designation_id);

            $this->db->trans_begin();
            $this->Common_model->update_data('designation',$data,$where);
            @$block=$this->input->post('block_type');

            //Deactivating all the Blocks with that designation
            $where = array('designation_id'=>$designation_id);
            $data = array('status'=>2);
            $this->Common_model->update_data('block_designation',$data, $where);

            if(@count($block)>0)
            {
                //looping through departments and inserting and updating
                foreach ($block as $block_id)
                {
                //UPDATE EXIST DEPARTMENTS AND INSERTING NEW DEPARTMENTS
                $this->Designation_m->insert_update($block_id,$designation_id);
                //echo $this->db->last_query().'<br>';
                }
            }
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
                                                        <strong>Success!</strong> Designation  has been updated successfully! </div>');
            }
        
                
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> UserName already exist! Try Again. </div>');
        }
       
        redirect(SITE_URL.'designation');  
    }

/*Deactivate Designation details
Author:Srilekha
Time:04.05PM 06-02-2017 */
    public function deactivate_designation($encoded_id)
    {
    
        $designation_id=@cmm_decode($encoded_id);
        if($designation_id==''){
            redirect(SITE_URL);
            exit;
        }
       
            $where = array('designation_id' => $designation_id);
            //deactivating user
            $data_arr = array('status' => 2);
            $this->Common_model->update_data('designation',$data_arr, $where);
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Designation  has been De-Activated successfully!</div>');
            redirect(SITE_URL.'designation');           
        

    }

/*Activate Designation details
Author:Srilekha
Time: 01.20PM 06-02-2017 */
	public function activate_designation($encoded_id)
    {
        $designation_id=@cmm_decode($encoded_id);
        if($designation_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('designation_id' => $designation_id);
        //deactivating user
        $data_arr = array('status' => 1);
        $this->Common_model->update_data('designation',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Designation has been Activated successfully!</div>');
        redirect(SITE_URL.'designation');

    }

/*Download Designation details
Author:Srilekha
Time: 4.09PM 06-02-2017 */
	public function download_designation()
    {
        if($this->input->post('download_designation')!='') {
            
            $search_params=array(
                'name' 		   => $this->input->post('desig_name', TRUE),                
                              );
            $designation = $this->Designation_m->designation_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Designation','Block name','Reporting To');
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
            if(count($designation)>0)
            {
                
                foreach($designation as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['name'].'</td>';                   
                    $data.='<td align="center">'.$row['block_name'].'</td>'; 
                    $data.='<td align="center">'.@reporting_manager($row['parent_id']).'</td>';                 
                    
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
            $xlFile='Designation'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
//Function to check the uniqueness of Designation
    public  function is_designationExist()
    {
        $designation_name = $this->input->post('designation_name');
        $designation_id = $this->input->post('designation_id');
        
        echo $this->Designation_m->is_designationExist($designation_name,$designation_id);
    }


}