<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Packing_material_category extends CI_Controller{

	public function __construct() 
    {
        parent::__construct();
        $this->load->model("Packing_material_category_m");

    }
/*Search Packing Material Category details
Author:Srilekha
Time: 11.08AM 24-02-2017 */
	public function packing_material_category()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Packing Material Category";
		$data['nestedView']['pageTitle'] = 'Packing Material Category';
        $data['nestedView']['cur_page'] = 'packing_material_category';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Packing Material Category', 'class' => 'active', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_category', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                 'name'       => $this->input->post('material_name', TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                   'name'         => $this->session->userdata('name'),
                    
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
        $config['base_url'] = SITE_URL . 'packing_material_category/';
        # Total Records
        $config['total_rows'] = $this->Packing_material_category_m->category_total_num_rows($search_params);

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
        $data['category_results'] = $this->Packing_material_category_m->category_results($current_offset, $config['per_page'], $search_params);
        
        # Additional data
        $data['display_results'] = 1;
        
        $this->load->view('packing_material_category/packing_material_category_view',$data);

    }


/*Adding Packing Material Category details
Author:Srilekha
Time: 11.14AM 24-02-2017 */
	public function add_category()
	{
		# Data Array to carry the require fields to View and Model
	    $data['nestedView']['heading']="Add Packing Material Category";
	    $data['nestedView']['pageTitle'] = 'Add Packing Material Category';
        $data['nestedView']['cur_page'] = 'packing_material_category';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';


	    # Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/pm_category.js" type="text/javascript"></script>';
		$data['nestedView']['css_includes'] = array();

		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Add Packing Material Category';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Packing Material Category', 'class' => '', 'url' => SITE_URL.'packing_material_category');
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Add Packing Material Category','class'=>'active','url'=>'');



		
        $data['flg'] = 1;
        $data['packing_type']=$this->Common_model->get_dropdown('packing_type', 'packing_type_id', 'name', array('status'=>1));
        $data['packing_unit']=$this->Common_model->get_dropdown('pm_unit', 'pm_unit', 'name', array('status'=>1));
        $data['form_action'] = SITE_URL.'insert_category';
        $data['display_results'] = 0;
    	
        $this->load->view('packing_material_category/packing_material_category_view',$data);
	}


/*Insert Packing Material Category details
Author:Srilekha
Time: 11.17AM 24-02-2017 */
	public function insert_category()
	{
        $category_name = $this->input->post('material_name');
        $category_id = 0;
        $unique = $this->Packing_material_category_m->is_categoryExist($category_name,$category_id);
        if($unique==0)
        {
            $data=array(
                        'name'                  =>     $category_name,
                        'packing_type_id'       =>     $this->input->post('type'),
                        'pm_unit'               =>     $this->input->post('unit'),
                        'created_by'            =>     $this->session->userdata('user_id'),
                        'created_time'          =>     date('Y-m-d H:i:s')
                        );
            //echo "<pre>"; print_r($data); exit;
            $this->db->trans_begin();
            $packing_material = $this->Common_model->insert_data('packing_material_category',$data);
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
                                                        <strong>Success!</strong> Packing Material Category has been added successfully! </div>');
                      
            }
        }
        else
        {
             $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> UserName already exist! Try Again. </div>');

        }
            
	        	
	       redirect(SITE_URL.'packing_material_category');
	}

/*Edit Packing Material Category details
Author:Srilekha
Time: 11.20AM 24-02-2017 */
	public function edit_category()
    {
        $category_id=@cmm_decode($this->uri->segment(2));
        if($category_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Packing Material category";
        $data['nestedView']['pageTitle'] = 'Edit Packing Material Category';
        $data['nestedView']['cur_page'] = 'packing_material_category';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/pm_category.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Packing Material Category', 'class' => '', 'url' => SITE_URL.'packing_material_category');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Packing Material Category', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_category';
        $data['display_results'] = 0;


        # Data
        $row = $this->Common_model->get_data('packing_material_category',array('pm_category_id'=>$category_id));
        
        $data['material_row'] = $row[0];
        $data['packing_type']=$this->Common_model->get_dropdown('packing_type', 'packing_type_id', 'name', array('status'=>1));
        $data['packing_unit']=$this->Common_model->get_dropdown('pm_unit', 'pm_unit', 'name', array('status'=>1));
        $data['type_selected']=$this->Common_model->get_value('packing_material_category',array('pm_category_id'=>$category_id),'packing_type_id');
        $data['unit_selected']=$this->Common_model->get_value('packing_material_category',array('pm_category_id'=>$category_id),'pm_unit');
        $this->load->view('packing_material_category/packing_material_category_view',$data);
    }

/*Update Packing Material Category details
Author:Srilekha
Time: 11.25AM 24-02-2017 */
     public function update_category()
    {
        $category_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($category_id=='')
        {
            redirect(SITE_URL.'packing_material_category');
            exit;
        }

        $material_name = $this->input->post('material_name');
        $unique = $this->Packing_material_category_m->is_categoryExist($material_name,$category_id);
        if($unique==0)
        {
            // GETTING INPUT TEXT VALUES
            $data = array( 
                        'name'                  =>     $material_name,
                        'packing_type_id'       =>     $this->input->post('type'),
                        'pm_unit'               =>     $this->input->post('unit'),
                        'modified_by'           =>     $this->session->userdata('user_id'),
                        'modified_time'         =>     date('Y-m-d H:i:s')
                    );

            $where = array('pm_category_id'=>$category_id);

            $this->db->trans_begin();
            $this->Common_model->update_data('packing_material_category',$data,$where);
            
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
                                                        <strong>Success!</strong> Packing Material Category  has been updated successfully! </div>');
            }
        
                
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> UserName already exist! Try Again. </div>');
        }
       
        redirect(SITE_URL.'packing_material_category');  
    }

/*Deactivate Packing Material Category details
Author:Srilekha
Time:11.28AM 24-02-2017 */
    public function deactivate_category($encoded_id)
    {
    
        $category_id=@cmm_decode($encoded_id);
        if($category_id==''){
            redirect(SITE_URL);
            exit;
        }
       
            $where = array('pm_category_id' => $category_id);
            //deactivating user
            $data_arr = array('status' => 2);
            $this->Common_model->update_data('packing_material_category',$data_arr, $where);
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Packing Material Category  has been De-Activated successfully!</div>');
            redirect(SITE_URL.'packing_material_category');           
        

    }

/*Activate Packing Material Category details
Author:Srilekha
Time: 11.30AM 24-02-2017 */
	public function activate_category($encoded_id)
    {
        $category_id=@cmm_decode($encoded_id);
        if($category_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('pm_category_id' => $category_id);
        //deactivating user
        $data_arr = array('status' => 1);
        $this->Common_model->update_data('packing_material_category',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Packing Material Category has been Activated successfully!</div>');
        redirect(SITE_URL.'packing_material_category');

    }

/*Download Category details
Author:Srilekha
Time: 12.12PM 24-02-2017 */
	public function download_category()
    {
        if($this->input->post('download_category')!='') {
            
            $search_params=array(
                'name' 		   => $this->input->post('material_name', TRUE),                
                              );
            $category = $this->Packing_material_category_m->category_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Packing Material Category Name','Packing Type','Packing Unit');
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
            if(count($category)>0)
            {
                
                foreach($category as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['name'].'</td>'; 
                    $data.='<td align="center">'.$row['type'].'</td>';   
                    $data.='<td align="center">'.$row['unit'].'</td>';                 
                    
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
            $xlFile='Packing_material_category'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
//Function to check the uniqueness of Category Name
    public  function is_categoryExist()
    {
        $material_name = $this->input->post('material_name');
        $category_id = $this->input->post('category_id');
        
        echo $this->Packing_material_category_m->is_categoryExist($material_name,$category_id);
    }


}