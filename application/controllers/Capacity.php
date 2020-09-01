<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
/*Capacity 
  Author:Roopa
  Time: 11.00AM 24-02-2017 */ 
class Capacity extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Capacity_m");
	}
    /*Capacity details..
    Author:Roopa
    Time: 11.00AM 24-02-2017 */ 
	public function capacity()
	{           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Denomination";
		$data['nestedView']['pageTitle'] = 'Manage Denomination';
        $data['nestedView']['cur_page'] = 'capacity';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Denomination', 'class' => 'active', 'url' => '');	
        $data['unit'] = array('' =>'Select Unit')+$this->Common_model->get_dropdown('unit','unit_id','name');
        $p_search=$this->input->post('search_capacity', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'name' => $this->input->post('name', TRUE),
                'unit_id'       => $this->input->post('unit', TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'name'   => $this->session->userdata('name'),
                    'unit_id'         => $this->session->userdata('unit_id'),
                    
                                  );
            }
            else {
                $search_params=array(
                      'name'    => '',
                      'unit_id'          => '',
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'capacity/';
        # Total Records
        $config['total_rows'] = $this->Capacity_m->capacity_total_num_rows($search_params);

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
        $data['capacity_results'] = $this->Capacity_m->capacity_results($current_offset, $config['per_page'], $search_params);
       
        # Additional data
        $data['display_results'] = 1;

        $this->load->view('capacity/capacity_view',$data);

    }
    /*Adding Capacity details..
    Author:Roopa
    Time: 11.00AM 24-02-2017 */
    public function add_capacity()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add Denomination";
        $data['nestedView']['pageTitle'] = 'Add Denomination';
        $data['nestedView']['cur_page'] = 'capacity';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/capacity.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Denomination', 'class' => '', 'url' => SITE_URL.'capacity');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New Denomination', 'class' => 'active', 'url' => '');
        $data['unit'] = array('' =>'Select Unit')+$this->Common_model->get_dropdown('unit','unit_id','name');
        # Search Functionality
        # Data
        
        # Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_capacity';
        $data['display_results'] = 0;
        $this->load->view('capacity/capacity_view',$data);
    }
    /*Inserting Capacity details..
    Author:Roopa
    Time: 11.00AM 24-02-2017 */
    public function insert_capacity()
    {
        // GETTING INPUT TEXT VALUES
        $data = array( 
                    'name'       =>$this->input->post('name',TRUE),
                    'unit_id'       =>$this->input->post('unit',TRUE),  
                    'created_by'       => $this->session->userdata('user_id'),
                    'created_time'     => date('Y-m-d H:i:s')                   
                    );
       // print_r($_POST);
        $capacity_id = $this->Common_model->insert_data('capacity',$data);

        if ($capacity_id>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Capacity has been added successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'capacity');  
    }
    /*Editing Capacity details..
    Author:Roopa
    Time: 11.00AM 24-02-2017 */
    public function edit_capacity()
    {
        $capacity_id=@cmm_decode($this->uri->segment(2));
        if($capacity_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Denomination";
        $data['nestedView']['pageTitle'] = 'Edit Denomination';
        $data['nestedView']['cur_page'] = 'capacity';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/capacity.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Denomination', 'class' => '', 'url' => SITE_URL.'capacity');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Denomination', 'class' => 'active', 'url' => '');
        $data['unit'] = array('' =>'Select Unit')+$this->Common_model->get_dropdown('unit','unit_id','name');
        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_capacity';
        $data['display_results'] = 0;

        # Data
        $row = $this->Common_model->get_data('capacity',array('capacity_id'=>$capacity_id));
        $data['capacity_row'] = $row[0];
       
        
        $this->load->view('capacity/capacity_view',$data);
    }
    /*Updating Capacity details..
    Author:Roopa
    Time: 11.00AM 24-02-2017 */
    public function update_capacity()
    {
        $capacity_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($capacity_id==''){
            redirect(SITE_URL);
            exit;
        }
        // GETTING INPUT TEXT VALUES
        $data = array( 
                    'name'              =>$this->input->post('name',TRUE),
                    'unit_id'           =>$this->input->post('unit',TRUE),   
                    'modified_by'       => $this->session->userdata('user_id'),
                    'modified_time'     => date('Y-m-d H:i:s')                    
                    );

        $where = array('capacity_id'=>$capacity_id);
        $res = $this->Common_model->update_data('capacity',$data,$where);
        if ($res)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> capacity has been updated successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'capacity');  
    }
    /*Deactivate Capacity details..
    Author:Roopa
    Time: 11.00AM 24-02-2017 */
     public function deactivate_capacity($encoded_id)
    {
    
        $capacity_id=@cmm_decode($encoded_id);
        if($capacity_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('capacity_id' => $capacity_id);
        //deactivating user
        $data_arr = array('status' => 2);
        $this->Common_model->update_data('capacity',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> capacity has been De-Activated successfully!</div>');
        redirect(SITE_URL.'capacity');

    }
    /*Activate Capacity details..
    Author:Roopa
    Time: 11.00AM 24-02-2017 */
    public function activate_capacity($encoded_id)
    {
        $capacity_id=@cmm_decode($encoded_id);
        if($capacity_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('capacity_id' => $capacity_id);
        //deactivating user
        $data_arr = array('status' => 1);
        $this->Common_model->update_data('capacity',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> capacity has been Activated successfully!</div>');
            redirect(SITE_URL.'capacity');
    }
    /*Download Capacity details..
    Author:Roopa
    Time: 11.00AM 24-02-2017 */    
    public function download_capacity()
    {
        if($this->input->post('download_capacity')!='') {
            
            $search_params=array(
                    'name'       =>$this->input->post('name',TRUE),                   
                    'unit_id'       =>$this->input->post('unit',TRUE)
                              );
            $capacity = $this->Capacity_m->capacity_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','name','unit_id');
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
            if(count($capacity)>0)
            {
                
                foreach($capacity as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['name'].'</td>';
                    $data.='<td align="center">'.$row['unit_name'].'</td>';                  
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
            $xlFile='Capacity_m'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
    //name unique..
    public  function is_capacityExist()
    {
        $name = $this->input->post('capacity_name');
        $capacity_id = $this->input->post('identity');
        $unit_id =$this->input->post('unit_id');
        echo $this->Capacity_m->is_nameExist($name,$capacity_id,$unit_id);
    }
}