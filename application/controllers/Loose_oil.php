<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 /*Search Loose oil details
 Author:Roopa
 Time: 1.30PM 11-02-2017*/
class Loose_oil extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Loose_oil_m");
	}
	public function loose_oil()
	{           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Loose oil";
		$data['nestedView']['pageTitle'] = 'Manage Loose oil';
        $data['nestedView']['cur_page'] = 'loose_oil';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Loose_oil', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_loose_oil', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'name'             => $this->input->post('name', TRUE),
                'short_name'       => $this->input->post('short_name', TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'name'               => $this->session->userdata('name'),
                    'short_name'         => $this->session->userdata('short_name'),
                    
                                  );
            }
            else {
                $search_params=array(
                      'name'                => '',
                      'short_name'          => '',
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'loose_oil/';
        # Total Records
        $config['total_rows'] = $this->Loose_oil_m->loose_oil_total_num_rows($search_params);

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
        $data['loose_oil_results'] = $this->Loose_oil_m->loose_oil_results($current_offset, $config['per_page'], $search_params);
       
        # Additional data
        $data['display_results'] = 1;
        $this->load->view('product/loose_oil_view',$data);
    }
 /*Search Loose oil details
 Author:Roopa
 Time: 1.30PM 11-02-2017*/
    public function add_loose_oil()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Loose oil";
        $data['nestedView']['pageTitle'] = 'Add Loose oil';
        $data['nestedView']['cur_page'] = 'loose_oil';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/loose_oil.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage loose_oil', 'class' => '', 'url' => SITE_URL.'loose_oil');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New loose_oil', 'class' => 'active', 'url' => '');
        
        # Data
        
        # Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_loose_oil';
        $data['display_results'] = 0;
        $this->load->view('product/loose_oil_view',$data);
    }
 /*Search Loose oil details
 Author:Roopa
 Time: 1.30PM 11-02-2017*/
    public function insert_loose_oil()
    {
        $name = $this->input->post('name',TRUE);
        $loose_oil_id = 0;
        $unique = $this->Loose_oil_m->is_nameExist($name,$loose_oil_id);
        if($unique==0)
        {
             $data = array( 
                        'name'             =>$name,
                        'description'      =>$this->input->post('description',TRUE),
                        'short_name'       =>$this->input->post('short_name',TRUE),  
                        'created_by'       => $this->session->userdata('user_id'),
                        'created_time'     => date('Y-m-d H:i:s')                   
                        );        
            $loose_oil_id = $this->Common_model->insert_data('loose_oil',$data);
            if ($loose_oil_id>0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Success!</strong> Loose Oil has been added successfully! </div>');
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
                                                        <strong>Error!</strong> Loose oil already existed. Please check. </div>');       
            }

        // GETTING INPUT TEXT VALUES
       

        redirect(SITE_URL.'loose_oil');  
    }
 /*Search Loose oil details
 Author:Roopa
 Time: 1.30PM 11-02-2017*/
    public function edit_loose_oil()
    {
        $loose_oil_id=@cmm_decode($this->uri->segment(2));
        if($loose_oil_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Loose oil";
        $data['nestedView']['pageTitle'] = 'Edit Loose oil';
        $data['nestedView']['cur_page'] = 'loose_oil';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/loose_oil.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage loose oil', 'class' => '', 'url' => SITE_URL.'loose_oil');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit loose_oil', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_loose_oil';
        $data['display_results'] = 0;

        # Data
        $row = $this->Common_model->get_data('loose_oil',array('loose_oil_id'=>$loose_oil_id));
        $data['loose_oil_row'] = $row[0];        
        $this->load->view('product/loose_oil_view',$data);
    }
 /*Search Loose oil details
 Author:Roopa
 Time: 1.30PM 11-02-2017*/
    public function update_loose_oil()
    {
        $loose_oil_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($loose_oil_id==''){
            redirect(SITE_URL);
            exit;
        }
        $name = $this->input->post('name',TRUE);
        $unique = $this->Loose_oil_m->is_nameExist($name,$loose_oil_id);
        if($unique==0)
        {
            // GETTING INPUT TEXT VALUES
        $data = array( 
                    'name'              =>$name,
                    'description'       =>$this->input->post('description',TRUE),
                    'short_name'        =>$this->input->post('short_name',TRUE),  
                    'modified_by'       => $this->session->userdata('user_id'),
                    'modified_time'     => date('Y-m-d H:i:s')                    
                    );

        $where = array('loose_oil_id'=>$loose_oil_id);
        $res = $this->Common_model->update_data('loose_oil',$data,$where);
        if ($res)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Loose Oil has been updated successfully! </div>');
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
                                                    <strong>Error!</strong> Loose Oil already existed. Please check. </div>');       
        }

        
        redirect(SITE_URL.'loose_oil');  
    }  
 /*Search Loose oil details
 Author:Roopa
 Time: 1.30PM 11-02-2017*/
     public function deactivate_loose_oil($encoded_id)
    {    
        $loose_oil_id=@cmm_decode($encoded_id);
        if($loose_oil_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('loose_oil_id' => $loose_oil_id);
        //deactivating user
        $data_arr = array('status' => 2);
        $this->Common_model->update_data('loose_oil',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Loose Oil has been De-Activated successfully!</div>');
        redirect(SITE_URL.'loose_oil');
    }  
 /*Search Loose oil details
 Author:Roopa
 Time: 1.30PM 11-02-2017*/  
    public function activate_loose_oil($encoded_id)
    {
        $loose_oil_id=@cmm_decode($encoded_id);
        if($loose_oil_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('loose_oil_id' => $loose_oil_id);
        //deactivating user
        $data_arr = array('status' => 1);
        $this->Common_model->update_data('loose_oil',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Loose Oil has been Activated successfully!</div>');
            redirect(SITE_URL.'loose_oil');
    } 
 /*Search Loose oil details
 Author:Roopa
 Time: 1.30PM 11-02-2017*/   
    public function download_loose_oil()
    {
        if($this->input->post('download_loose_oil')!='') {
            
            $search_params=array(
                    'name'              =>$this->input->post('name',TRUE),
                    'description'       =>$this->input->post('description',TRUE),
                    'short_name'        =>$this->input->post('short_name',TRUE)
                              );
            $loose_oil = $this->Loose_oil_m->loose_oil_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','loose_oil');
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
            if(count($loose_oil)>0)
            {
                
                foreach($loose_oil as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['name'].'</td>';
                    $data.='<td align="center">'.$row['description'].'</td>';
                    $data.='<td align="center">'.$row['short_name'].'</td>';
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
            $xlFile='loose_oil_m'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
 /*Search Loose oil details
 Author:Roopa
 Time: 1.30PM 11-02-2017*/
    public  function is_looseoilExist()
    {
        $name = $this->input->post('looseoil_name');
        $loose_oil_id = $this->input->post('identity');
        echo $this->Loose_oil_m->is_nameExist($name,$loose_oil_id);
    }

}