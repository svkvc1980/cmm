<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Executive extends CI_Controller{

	public function __construct() 
    {
        parent::__construct();
        $this->load->model("Executive_m");

    }

/*Search Executive details
Author:Srilekha
Time: 10.56AM 01-03-2017 */
public function executive()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Executive List";
		    $data['nestedView']['pageTitle'] = 'Executive List';
        $data['nestedView']['cur_page'] = 'executive';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Executive List', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_executive', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'exe_name'      => $this->input->post('exe_name', TRUE),
                'exe_code'      => $this->input->post('exe_code', TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'exe_name'   => $this->session->userdata('exe_name'),
                    'exe_code'   => $this->session->userdata('exe_code')
                    
                                  );
            }
            else {
                $search_params=array(
                      'exe_name'    => '',
                      'exe_code'    => ''
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'executive/';
        # Total Records
        $config['total_rows'] = $this->Executive_m->executive_total_num_rows($search_params);

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
        $data['executive_results'] = $this->Executive_m->executive_results($current_offset, $config['per_page'], $search_params);

        # Additional data
        $data['display_results'] = 1;
        
        $this->load->view('executive/executive_view',$data);

    }
  
/*Executives details
Author:Srilekha
Time: 11.08AM 01-03-2017 */
  public function add_executive()
  {
    # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add Executives";
        $data['nestedView']['pageTitle'] = 'Add Executives';
        $data['nestedView']['cur_page'] = 'executives';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/executive.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Executive List', 'class' => '', 'url' => SITE_URL.'executive');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add Executive', 'class' => 'active', 'url' => '');

        $data['flag']=1;
        
        $data['state']= $this->Common_model->get_data('location',array('level_id'=>2,'status'=>1));
        $data['form_action'] = SITE_URL.'insert_executive';
        
        $this->load->view('executive/executive_view',$data);
  }
/*Insert Executive details
Author:Srilekha
Time: 11.23AM 01-03-2017 */
    public function insert_executive()
    {
        $email=$this->input->post('email',TRUE);
        if($email!='')
        {
            $mail=$this->input->post('email');
        }
        else
        {
            $mail='NULL';
        }
        $exe_code = $this->input->post('exe_code');
        $executive_id = 0;
        $unique = $this->Executive_m->is_executiveExist($exe_code,$executive_id);
        if($unique==0)
        {
            $password = md5('abc');
            $data=array(
                        'username'              =>    'executive_'.date('YmdHis'),
                        'password'              =>     $password,
                        'plant_id'              =>     3,
                        'block_id'              =>     6,
                        'designation_id'        =>     2,
                        'name'                  =>     $this->input->post('exe_name'),
                        'mobile'                =>     $this->input->post('mobile'),
                        'email'                 =>     $mail,
                        'address'               =>     $this->input->post('address'),
                        'status'                =>     1,
                        'created_by'            =>     $this->session->userdata('user_id'),
                        'created_time'          =>     date('Y-m-d H:i:s')
                        );
            //echo "<pre>"; print_r($data); exit;
            $this->db->trans_begin();
            $ex_user_id = $this->Common_model->insert_data('user',$data);
            

            $data=array(
                        'name'                  =>     $this->input->post('exe_name'),
                        'executive_code'        =>     $exe_code,
                        'mobile'                =>     $this->input->post('mobile'),
                        'address'               =>     $this->input->post('address'),
                        'alternate_mobile'      =>     $this->input->post('alt_mobile'),
                        'user_id'               =>     $ex_user_id,
                        'location_id'           =>     $this->input->post('city')

                       );
            $executive=$this->Common_model->insert_data('executive',$data);
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
                                                        <strong>Success!</strong> Executive has been added successfully! </div>');
                      
            }
        }
        else
        {
             $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> Executive Code already exist! Try Again. </div>');

        }
            
                
           redirect(SITE_URL.'executive');
    }
/*Edit Executive details
Author:Srilekha
Time: 12.03PM 01-03-2017 */
	/*Edit Executive details
Author:Mounika*/
    public function edit_executive()
    {

        $exe_id=@cmm_decode($this->uri->segment(2));
        if($exe_id==''){
            redirect(SITE_URL.'executive');
            exit;
        }
       
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Executive";
        $data['nestedView']['pageTitle'] = "Edit Executive";
        $data['nestedView']['cur_page'] = 'executive';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/executive.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Executive List', 'class' => '', 'url' => SITE_URL.'executive');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' =>"Edit Executive", 'class' => 'active', 'url' => '');

        # Additional data
        
        $data['flag'] = 2;
        $data['form_action'] = SITE_URL.'update_executive';
        $data['display_results'] = 0;

        # Data
        
        $row = $this->Common_model->get_data('executive',array('executive_id'=>$exe_id));
        $user_id=$this->Common_model->get_value('executive',array('executive_id'=>$exe_id),'user_id'); 
        $data['email']=$this->Common_model->get_value('user',array('user_id'=>$user_id),'email');

        /*koushik*/
        $city_id = $row[0]['location_id'];

        $city_parent_id = $this->Common_model->get_value('location',array('location_id'=>$city_id),'parent_id');
        $data['city_parent_id'] = $city_id;
        $data['city'] = $this->Common_model->get_data('location',array('parent_id'=>$city_parent_id));

        $mandal_parent_id = $this->Common_model->get_value('location',array('location_id'=>$city_parent_id),'parent_id');
        $data['mandal_parent_id'] = $city_parent_id;
        $data['mandal'] = $this->Common_model->get_data('location',array('parent_id'=>$mandal_parent_id));

        $district_parent_id = $this->Common_model->get_value('location',array('location_id'=>$mandal_parent_id),'parent_id');
        $data['district_parent_id'] = $mandal_parent_id;
        $data['district'] = $this->Common_model->get_data('location',array('parent_id'=>$district_parent_id));

        $region_parent_id = $this->Common_model->get_value('location',array('location_id'=>$district_parent_id),'parent_id');
        $data['region_parent_id'] = $district_parent_id;
        $data['region'] = $this->Common_model->get_data('location',array('parent_id'=>$region_parent_id));

        $data['state_parent_id'] = $region_parent_id;
        $data['state']= $this->Common_model->get_data('location',array('level_id'=>2,'status'=>1));
        /*koushik*/

        $data['executive_row'] = $row[0];
        $this->load->view('executive/executive_view',$data);
    }

/*Update Executive details
Author:Srilekha
Time: 12.09PM 01-03-2017 */
    public function update_executive()
    {
        $exe_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($exe_id==''){
            redirect(SITE_URL);
            exit;
        }
        $email=$this->input->post('email',TRUE);
        if($email!='')
        {
            $mail=$this->input->post('email');
        }
        else
        {
            $mail='NULL';
        }
        $user_id=$this->Common_model->get_value('executive',array('executive_id'=>$exe_id),'user_id');
        
        $exe_code = $this->input->post('exe_code');
        $unique = $this->Executive_m->is_executiveExist($exe_code,$exe_id);

        if($unique==0)
        {
            $data=array(
                        'name'                  =>     $this->input->post('exe_name'),
                        'mobile'                =>     $this->input->post('mobile'),
                        'email'                 =>     $mail,
                        'address'               =>     $this->input->post('address'),
                        'status'                =>     1,
                        'modified_by'           =>     $this->session->userdata('user_id'),
                        'modified_time'         =>     date('Y-m-d H:i:s')
                        );
            $where = array('user_id'=>$user_id);
            $this->db->trans_begin();
            $user = $this->Common_model->update_data('user',$data,$where);
            $data=array(
                        'name'                  =>     $this->input->post('exe_name'),
                        'executive_code'        =>     $exe_code,
                        'mobile'                =>     $this->input->post('mobile'),
                        'address'               =>     $this->input->post('address'),
                        'alternate_mobile'      =>     $this->input->post('alt_mobile'),
                        'user_id'               =>     $user_id,
                        'location_id'           =>     $this->input->post('city')

                       );
            $where = array('executive_id'=>$exe_id);
            $executive=$this->Common_model->update_data('executive',$data,$where);
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
                                                        <strong>Success!</strong> Executive has been Updated successfully! </div>');
                      
            }
        }
        else
        {
             $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> Executive Code already exist! Try Again. </div>');

        } 

        redirect(SITE_URL.'executive');  
    }
/*Deactivate Executive details
Author:Srilekha
Time: 12.18PM 01-03-2017 */
    public function deactivate_executive($encoded_id)
    {
    
        $exe_id=@cmm_decode($encoded_id);
        if($exe_id==''){
            redirect(SITE_URL.'executive');
            exit;
        }
            
            $user_id=$this->Common_model->get_value('executive',array('executive_id'=>$exe_id),'user_id');
            $where = array('user_id' => $user_id);
            //deactivating user
            $data_arr = array('status' => 2,
                          'modified_by'   => $this->session->userdata('user_id'),
                          'modified_time' => date('Y-m-d H:i:s')
                             );
            $this->Common_model->update_data('user',$data_arr, $where);
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Executive  has been Deactivated successfully!</div>');
            redirect(SITE_URL.'executive');           
        

    }

/*Insert Executive details
Author:Srilekha
Time: 12.39PM 01-03-2017 */
	public function activate_executive($encoded_id)
    {
        $exe_id=@cmm_decode($encoded_id);
        if($exe_id==''){
            redirect(SITE_URL.'executive');
            exit;
        }
        
       
            $user_id=$this->Common_model->get_value('executive',array('executive_id'=>$exe_id),'user_id');
            $where = array('user_id' => $user_id);
            //deactivating user
            $data_arr = array('status' => 1,
                          'modified_by'   => $this->session->userdata('user_id'),
                          'modified_time' => date('Y-m-d H:i:s')
                             );

            $this->Common_model->update_data('user',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Executive has been Activated successfully!</div>');
        redirect(SITE_URL.'executive');

    }
/*Download Executive details
Author:Srilekha
Time: 12.41PM 01-03-2017 */
	public function download_executive()
    {
        if($this->input->post('download_executive')!='') {
            $search_params=array(
                'exe_name'      => $this->input->post('name', TRUE),
                'exe_code'      => $this->input->post('exe_code', TRUE)
            
                              );
            $executive = $this->Executive_m->executive_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Executive Code','Name','Mobile','address','location');
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
            if(count($executive)>0)
            {
                
                foreach($executive as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['executive_code'].'</td>';
                    $data.='<td align="center">'.$row['name'].'</td>';                   
                    $data.='<td align="center">'.$row['mobile'].'</td>';                   
                    $data.='<td align="center">'.$row['address'].'</td>';
                    $data.='<td align="center">'.$row['city'].'</td>';
                    
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
            $xlFile='Executive'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
/*Getting Region Dropdown details
Author:Srilekha
Time: 12.00PM 01-03-2017 */
    public function getregionList()
    {
    	$state_id = $this->input->post('state_id',TRUE);
    	echo $this->Executive_m->getregionList($state_id);
    }
/*Getting District Dropdown details
Author:Srilekha
Time: 12.00PM 01-03-2017 */
    public function getdistrictList()
    {
    	$region_id = $this->input->post('region_id',TRUE);
    	echo $this->Executive_m->getdistrictList($region_id);
    }
/*Getting Area Dropdown details
Author:Srilekha
Time: 12.00PM 01-03-2017 */
    public function getareaList()
    {
    	$district_id = $this->input->post('district_id',TRUE);
    	echo $this->Executive_m->getareaList($district_id);
    }
/*Function to check the uniqueness of Category Name
Author:Srilekha
Time: 11.41AM 01-03-2017 */
    public  function is_executiveExist()
    {
        $exe_code = $this->input->post('exe_code');
        $exe_id = $this->input->post('exe_id');
    
        echo $this->Executive_m->is_executiveExist($exe_code,$exe_id);
    }

    //Executive Print
	//Mounika
    public function executive_print()
    {
        if($this->input->post('executive_print')!='') 
        {
            $search_params=array(
                'exe_name'      => $this->input->post('exe_name', TRUE),
                'exe_code'      => $this->input->post('exe_code', TRUE)
                            );
            
            $executive_print = $this->Executive_m->get_executive_print($search_params);
           
            $data['executive_print']=$executive_print;
            //echo $this->db->last_query();exit;
            //print_r($data['executive_print']);exit;
        }
       $this->load->view('executive/executive_print',$data);
    }

}
?>