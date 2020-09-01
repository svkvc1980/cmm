<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

class Login extends CI_Controller {

	public  function __construct() 
	{
        parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Login_model');
	}

	public function login()
	{
		//print_r($_POST); exit;
		# Data Array to carry the require fields to View and Model
        $data['heading']="Login";
		$data['pageTitle'] = 'CMM - Login';
        $data['cur_page'] = 'login';
        $data['parent_page'] = 'login';

        # Load JS and CSS Files
        $data['js_includes'] = array();
        $data['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/form-samples.min.js"></script>';
        $data['css_includes'] = array();
        if($this->input->post('username') != '')
        {
        	$username = $this->input->post('username', TRUE);
        	$password = $this->input->post('password', TRUE);
        	if($username != '' && $password != '')
        	{
        		// Check if employee exists with the credentials given. Returns User ID if user exists and 0, if no user exists
        		$user_id = $this->Login_model->loginCheck($username, $password);
        		if($user_id != 0)
        		{

        			$userDetails = $this->Login_model->getUserDetails($user_id);
        			$sessionData = array(
        								'user_id' 			   => $user_id,
        								'block_id'			   => $userDetails['block_id'],
        								'block_name' 		   => $userDetails['block_name'],
        								'plant_name' 		   => $userDetails['plant_name'],
        								'designation_name'	   => $userDetails['designation_name'],
        								'userFullName' 		   => $userDetails['name'],
        								'ses_plant_id'		   => $userDetails['plant_id'],
        								'designation_id'       => $userDetails['designation_id'],
        								'block_designation_id' => $userDetails['block_designation_id']
        								);
        			if($userDetails['block_id']==5) // If logged in user is distributor
        			{
        				$distributor = $this->Common_model->get_data_row('distributor',array('user_id'=>$user_id));
        				$sessionData['distributor_id'] = $distributor['distributor_id'];
        				$sessionData['agency_name'] = $distributor['agency_name'];
        				$sessionData['concerned_person'] = $distributor['concerned_person'];
        				$sessionData['userFullName'] = $distributor['agency_name'].'('.$distributor['distributor_code'].')';
        				$sessionData['distributor'] = $distributor;
        			}
        			$this->session->set_userdata($sessionData);

					$user_log_data = array(
									'user_id'			=> $user_id,
									'login_time' 		=> date('Y-m-d H:i:s'),
									'ip_address' 		=> get_client_ip(),
									'user_agent'   		=> $_SERVER['HTTP_USER_AGENT'],
									'last_active'		=> date('Y-m-d H:i:s')
								);
					$this->db->insert('user_log',$user_log_data);

					redirect(SITE_URL);
        		}
        		else
        		{
					$this->session->set_flashdata('response', '<div class="alert alert-danger">
                    												<button class="close" data-close="alert"></button>
                    												<span> Username and Password did not match. </span>
                												</div>');
					redirect(SITE_URL.'login');
        		}
        	}
        	else
        	{
					$this->session->set_flashdata('response', '<div class="alert alert-danger">
                    												<button class="close" data-close="alert"></button>
                    												<span> Username or Password cannot be empty. </span>
                												</div>');
					redirect(SITE_URL.'login');
        	}
        }
        else
        {
			$this->load->view('user/login',$data);
        }
	}

	public function logout()
	{
		if($this->session->userdata('user_id')!='')
		{
			$log_qry = 'UPDATE user_log SET logout_time = "'.date('Y-m-d H:i:s').'" WHERE user_id = '.$this->session->userdata('user_id').' ORDER BY user_log_id DESC LIMIT 1';
			$this->db->query($log_qry);
		}
		$this->session->sess_destroy();
		//$_SESSION['user_id'] = '';
		redirect(SITE_URL.'login');

	}

	// mahesh 14th july 12:35 PM
	public function forgotPassword() {
		//print_r($_POST); exit;
		if($this->input->post('username',TRUE)!='')
		{
			$username = $this->input->post('username',TRUE);
			$this->db->select();
			$this->db->where('employee_number',$username);
			$query = $this->db->get('employee');
			if($query->num_rows() >0)
			{
				$row=$query->row_array();
				$to=$row['company_email'];
				if($to!='')
				{
					$subject='Reset Password Link - SPS';
					$message ='Hi '.@$row['first_name'].', <br><br>';
					$message.='<a href="'.SITE_URL.'resetPassword?reset='.sps_encode(@$row['employee_id']).'&st='.sps_encode(date('Y-m-d H:i:s')).'" target="_blank">Click to reset your Password</a>';
					$message .= '<br><br>Regards,<br>HRMS Team';
					$CC = "";
					
					$content = htmlspecialchars($message);
					$content = wordwrap($message);
					$content = wordwrap($message,70);
					//echo $to.'<br>'.$subject.'<br>'.$message; exit;
					
					$mail_status = send_email($to,$subject,$message);
					
					if($mail_status)
						$this->session->set_flashdata('response', '<div class="alert alert-success">
                    												<button class="close" data-close="alert"></button>
                    												<span> Reset Link Sent to Email. </span>
                												</div>');
					else
						$this->session->set_flashdata('response', '<div class="alert alert-danger">
                    												<button class="close" data-close="alert"></button>
                    												<span> Problem in sending Email. </span>
                												</div>');
				}
				else{

				$this->session->set_flashdata('response', '<div class="alert alert-danger">
                    												<button class="close" data-close="alert"></button>
                    												<span> Email doesnt exist for the user. </span>
                												</div>');
				}
				redirect(SITE_URL.'login');
			}					
			else 
			{
				$this->session->set_flashdata('response', '<div class="alert alert-danger">
                    												<button class="close" data-close="alert"></button>
                    												<span> Invalid Username. </span>
                												</div>');
				redirect(SITE_URL.'login');
			}
			
		}
	}

	// mahesh 14th july 12:48 pm
	public function resetPassword() {
		
		$hdata['pageTitle']="Reset Password";
		$hdata['currentPage']="reset_password";
		$hdata['externalCss']=array();
		
		$this->load->view('user/reset-password',@$hdata);
	}

	public function resetPasswordAction(){
		if($this->input->post('newPassword',TRUE)!='')
		{
			$newPassword = $this->input->post('newPassword',TRUE);
			$cnewPassword = $this->input->post('confirmPassword',TRUE);
			$encrypt_id = $this->input->post('encrypt_id',TRUE);
			$user_id=sps_decode($encrypt_id);
			if($user_id!=""){
				$data=array('password'=>md5($newPassword),'modified_by'=>$user_id,'modified_time'=>date('Y-m-d H:i:s'));
						$this->db->where('employee_id',$user_id);
						$this->db->update('employee',$data);
						$res = $this->db->affected_rows();
					if($res>0) {
							$this->session->set_flashdata('response', '<div class="alert alert-success">
                    												<button class="close" data-close="alert"></button>
                    												<span> Password has been reset successfully. </span>
                												</div>');
							redirect(SITE_URL.'login');
						}
					}
		}
	}


	//Function to check the uniqueness of Username
	public 	function is_usernameExist()
	{
		$username = $this->input->post('username');
		echo $this->Login_model->is_usernameExist($username);
  	}

  	public function registerUser()
  	{
  		if($this->input->post('username', TRUE) != '')
  		{
  			$data = array(
  						'role_id'			=> 6,
  						'username'			=> $this->input->post('username', TRUE),
  						'password'			=> md5($this->input->post('password', TRUE)),
  						'name'				=> $this->input->post('name', TRUE),
  						'address'			=> $this->input->post('address', TRUE),
  						'city'				=> $this->input->post('city', TRUE),
  						'phone'				=> $this->input->post('phone', TRUE),
  						'email'				=> $this->input->post('email', TRUE));
			$this->db->insert('user',$data);
			$user_id = $this->db->insert_id();
			$urhData = array(
							'user_id'		=> $user_id,
							'role_id'		=> 6
				);
			$this->db->insert('user_role_history',$urhData);
			$this->session->set_flashdata('response', '<div class="alert alert-success">
    												<button class="close" data-close="alert"></button>
    												<span> User has been successfully Created. </span>
												</div>');
			redirect(SITE_URL.'login');

  		}
  	}

  	//mahesh 8th Dec 2016 12:30 pm , updated on:
  	public function unauthorized_request()
  	{
		$data['nestedView']['heading']="Unauthorized Request";
		$data['nestedView']['cur_page'] = 'unauthorized_request';
		$data['nestedView']['parent_page'] = 'unauthorized_request';
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		$data['nestedView']['pageTitle'] = 'Smart Parking System - Unauthorized Request';

		# Breadcrumbs
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
		$data['nestedView']['breadCrumbOptions'][] = array('label' => 'Unauthorized Request', 'class' => 'active', 'url' =>'');

		# Additional data
        $data['portlet_title'] = 'Unauthorized Request';

		$this->load->view('user/unauthorized_request',$data);
  	}
  	
}
?>