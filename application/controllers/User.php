<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class User extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("User_model");
	}

    public function getplantList()
    {
        $blockid = $this->input->post('blockid',TRUE);
        echo $this->User_model->getplantList($blockid);
    }

    public function getdisignationList()
    {
        $blockid = $this->input->post('blockid',TRUE);
        echo $this->User_model->getdisignationList($blockid);
    }

    public function is_userExist()
    {
        //$block_id = $this->input->post('blockid',TRUE);
        $user_name = $this->input->post('usname',TRUE);
        //$plant_id = $this->input->post('plantid',TRUE);
        //$designation_id = $this->input->post('designationid',TRUE);
        $user_id = $this->input->post('userid',TRUE);
        echo $this->User_model->is_userExist($user_name,$user_id);
    }

	public function user()
	{
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="User List";
		$data['nestedView']['pageTitle'] = 'User List';
        $data['nestedView']['cur_page'] = 'user';
        $data['nestedView']['parent_page'] = 'system_management';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/user.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'User List', 'class' => 'active', 'url' => '');

        # Search Functionality
        $usearch=$this->input->post('searchUser', TRUE);
        if($usearch!='') 
        {
            $searchParams=array(
                'usnam'=> $this->input->post('usnam', TRUE),
                'bloid'=> $this->input->post('bloid', TRUE),
                'plaid'=> $this->input->post('plaid', TRUE),
                'deid' => $this->input->post('deid', TRUE),
                'flg'  => 1
                              );
            $this->session->set_userdata($searchParams);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
            $searchParams=array(
               'usnam'   => $this->session->userdata('usnam'),
               'bloid' => $this->session->userdata('bloid'),
               'plaid'   => $this->session->userdata('plaid'),
               'deid' => $this->session->userdata('deid'),
               'flg'  => 1
                              );
            }
            else {
                $searchParams=array(
                      'usnam' => '',
                      'bloid' => '',
                      'plaid' => '',
                      'deid'  => '',
                      'flg'   => ''
                                  );
                $this->session->set_userdata($searchParams);
            }
            
        }
        $data['search_data'] = $searchParams;
        if($searchParams['flg']== 1)
        {
        $data['plant'] = $this->User_model->get_plant_by_block($searchParams['bloid']);
        $data['designation'] = $this->User_model->get_designation_by_block($searchParams['bloid']);
        }


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'user/';
        # Total Records
        $config['total_rows'] = $this->User_model->user_total_num_rows($searchParams);

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
        $data['userResults'] = $this->User_model->user_results($current_offset, $config['per_page'], $searchParams);
        //print_r($data['userResults']); exit();
        
        # Additional data
        $data['blocklist'] = $this->User_model->get_block_list();
        $data['displayResults'] = 1;

        $this->load->view('user',$data);

    }
    public function usertab()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="User Selection";
        $data['nestedView']['pageTitle'] = 'User Selection';
        $data['nestedView']['cur_page'] = 'user';
        $data['nestedView']['parent_page'] = 'system_management';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/form-validation.min.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'User List', 'class' => '', 'url' =>SITE_URL.'user');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'User Selection', 'class' => 'active', 'url' => '');

        # Additional data
        $data['portlet_title'] = 'Select User Type';
        $data['flg'] = 10;
        $data['form_action'] = SITE_URL.'add_user';
        $data['displayResults'] = 0;

        $this->load->view('user',$data);

    }

    public function add_user()
    {
        $block_id=@cmm_decode($this->uri->segment(2));
        $data['block_name'] = $this->Common_model->get_value('block',array('block_id'=>$block_id),'name');
        $blockname = $data['block_name'];
        //echo $user_id; exit();
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add $blockname User";
        $data['nestedView']['pageTitle'] = "Add $blockname User";
        $data['nestedView']['cur_page'] = 'user';
        $data['nestedView']['parent_page'] = 'system_management';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/user.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'User', 'class' => '', 'url' => SITE_URL.'user');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'User Selection', 'class' => '', 'url' => SITE_URL.'usertab');   
        $data['nestedView']['breadCrumbOptions'][] = array('label' =>"Add $blockname User", 'class' => 'active', 'url' => '');

        # Additional data

        $data['blockid'] = $block_id;
        $data['portlet_title'] = 'Add New User';
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_user';
        $data['displayResults'] = 0;
        $this->load->view('user',$data);
    }

    //mahesh 20th jun 2016 03:45 pm
    public function insert_user()
    {
        // GETTING INPUT TEXT VALUES
        //$password = generatePassword($this->input->post('password',TRUE), $this->input->post('username',TRUE));
        $username = $this->input->post('user_name',TRUE);
        $user_id = 0;
        $check_user_availability = $this->User_model->check_user_availability($username,$user_id);
        if($check_user_availability==0)
        {
            $password = md5('abc');
            $data = array( 
                        'block_id'        =>   $this->input->post('block_id',TRUE),
                        'plant_id'        =>   $this->input->post('plant_id',TRUE),
                        'designation_id'  =>   $this->input->post('desig_id',TRUE),
                        'username'        =>   $username,
                        'name'            =>   $this->input->post('full_name',TRUE),
                        'password'        =>   $password,
                        'mobile'          =>   $this->input->post('mobile',TRUE),
                        'email'           =>   $this->input->post('email',TRUE),
                        'address'         =>   $this->input->post('address',TRUE),
                        'created_by'      =>   $this->session->userdata('user_id'),
                        'created_time'    =>   date('Y-m-d H:i:s'),
                        'status'          =>   1

                        );
            $user_id = $this->Common_model->insert_data('user',$data);

            if ($user_id>0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Success!</strong>User has been added successfully! </div>');
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
                                                    <strong>Error!</strong> UserName already Taken. Try New </div>'); 
        }
        

        redirect(SITE_URL.'user');  
    }

    public function edit_user()
    {
        $user_id=@cmm_decode($this->uri->segment(2));
        if($user_id==''){
            redirect(SITE_URL.'user');
            exit;
        }
        $block_id = $this->Common_model->get_value('user',array('user_id'=>$user_id),'block_id');
        $block_name = $this->Common_model->get_value('block',array('block_id'=>$block_id),'name'); 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit $block_name User";
        $data['nestedView']['pageTitle'] = "Edit $block_name User";
        $data['nestedView']['cur_page'] = 'user';
        $data['nestedView']['parent_page'] = 'system_management';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/user.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'User List', 'class' => '', 'url' => SITE_URL.'user');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' =>"Edit $block_name User", 'class' => 'active', 'url' => '');

        # Additional data
        $data['plant'] = $this->User_model->get_plant_by_block($block_id);
        $data['designation'] = $this->User_model->get_designation_by_block($block_id);
        $data['flg'] = 1;
        $data['flag'] = 2;
        $data['form_action'] = SITE_URL.'update_user';
        $data['displayResults'] = 0;

        # Data
        $row = $this->Common_model->get_data('user',array('user_id'=>$user_id));
        $data['lrow'] = $row[0];
        $this->load->view('user',$data);
    }

    //mahesh 20th jun 2016 03:45 pm
    public function update_user()
    {
        $user_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($user_id==''){
            redirect(SITE_URL);
            exit;
        }
        $username = $this->input->post('user_name',TRUE);
        $check_user_availability = $this->User_model->check_user_availability($username,$user_id);
        if($check_user_availability==0)
        {
            $data = array( 
                    'plant_id'        =>   $this->input->post('plant_id',TRUE),
                    'designation_id'  =>   $this->input->post('desig_id',TRUE),
                    'username'        =>   $this->input->post('user_name',TRUE),
                    'name'            =>   $this->input->post('full_name',TRUE),
                    'mobile'          =>   $this->input->post('mobile',TRUE),
                    'email'           =>   $this->input->post('email',TRUE),
                    'address'         =>   $this->input->post('address',TRUE),
                    'modified_by'      =>  $this->session->userdata('user_id'),
                    'modified_time'    =>  date('Y-m-d H:i:s'),
                    'status'          =>   1

                    );
            $where = array('user_id'=>$user_id);
            $res = $this->Common_model->update_data('user',$data,$where);

            if ($res)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Success!</strong>User has been updated successfully! </div>');
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
                                                    <strong>Error!</strong> UserName already Taken. Try New </div>'); 
        }
        // GETTING INPUT TEXT VALUES
        redirect(SITE_URL.'user');  
    }

    public function change_password()
    {
        $user_id=@cmm_decode($this->uri->segment(2));

        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Change Password";
        $data['nestedView']['pageTitle'] = 'Change Password';
        $data['nestedView']['cur_page'] = 'user';
        $data['nestedView']['parent_page'] = 'system_management';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
       $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/user.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'User', 'class' => '', 'url' => SITE_URL.'user');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'change Password', 'class' => 'active', 'url' => '');

        # User Data
        $row = $this->Common_model->get_data('user',array('user_id'=>$user_id));
        $data['lrrow'] = @$row[0];

        # Additional data
        $data['portlet_title'] = 'Forget Password';
        $data['flg'] = 3;
        $data['form_action'] = SITE_URL.'insert_new_password';
        $data['displayResults'] = 0;
        $this->load->view('user',$data);
    }

    public function insert_new_password()
    {
        $user_id=@cmm_decode($this->input->post('encoded_id',TRUE));

        if(isset($_POST['submitChangePassword']))
        {
            
            $new_password = $this->input->post('n_password');
            $confirm_password = $this->input->post('c_password');

            /*echo "ok";exit;*/
            //$password = generatePassword($this->input->post('n_password',TRUE), $this->input->post('username',TRUE));
            // GETTING INPUT TEXT VALUES
            if($new_password == $confirm_password)
            {
             $data = array( 
                    'password'                =>      md5($new_password),
                    'modified_by'             =>      $this->session->userdata('user_id'),
                    'modified_time'           =>      date('Y-m-d H:i:s')  
                    );
            $this->db->trans_begin();
            $where = array('user_id'=>$user_id);
            $res = $this->Common_model->update_data('user',$data,$where); 
            }
            

             if($this->db->trans_status() === FALSE)
             {
                $this->db->trans_rollback();
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Error!</strong> Invalid Old Password / Please Enter a Valid Password.</div>');
                redirect(SITE_URL.'change_password'); 
             }
             else
             {
                $this->db->trans_commit();
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Success!</strong> Password has been Updated successfully! </div>');
                redirect(SITE_URL.'user'); 
                
             }
             
        }
    }

    public function deactivate_user($encoded_id)
    {
    
        $user_id=@cmm_decode($encoded_id);
        if($user_id==''){
            redirect(SITE_URL.'user');
            exit;
        }
        $where = array('user_id' => $user_id);
        //deactivating user
        $data_arr = array('status' => 2);
        $this->Common_model->update_data('user',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong>User has been De-Activated successfully!</div>');
        redirect(SITE_URL.'user');

    }
    
    public function activate_user($encoded_id)
    {
        $user_id=@cmm_decode($encoded_id);
        if($user_id==''){
            redirect(SITE_URL.'user');
            exit;
        }
        $where = array('user_id' => $user_id);
        //deactivating user
        $data_arr = array('status' => 1);
        $this->Common_model->update_data('user',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong>User has been Activated successfully!</div>');
            redirect(SITE_URL.'user');

    }
    
    public function download_user()
    {
        if($this->input->post('downloadUser')!='') {
            
            $searchParams=array(
                'usnam'=> $this->input->post('usnam', TRUE),
                'bloid'=> $this->input->post('bloid', TRUE),
                'plaid'=> $this->input->post('plaid', TRUE),
                'deid' => $this->input->post('deid', TRUE));
            $users = $this->User_model->user_details($searchParams);
            
            $header = '';
            $data ='';
            $titles = array('S.No','User Name','Full Name','designation','Unit','Plant','Email','Mobile No.','address');
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
            if(count($users)>0)
            {
                
                foreach($users as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['username'].'</td>';
                    $data.='<td align="center">'.$row['full_name'].'</td>';
                    $data.='<td align="center">'.$row['designation'].'</td>';
                    $data.='<td align="center">'.$row['block_name'].'</td>';
                    $data.='<td align="center">'.$row['plant_name'].'</td>';
                    $data.='<td align="center">'.$row['email'].'</td>';
                    $data.='<td align="center">'.$row['mobile'].'</td>';
                    $data.='<td align="center">'.$row['address'].'</td>';
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
            $xlFile='user_'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }

}