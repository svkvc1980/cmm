<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Home extends Base_controller {

	public  function __construct() 
	{
        parent::__construct();
        $this->load->model('Stock_m');
        $this->load->model('Sales_model');
	}
	
	public function index()
{
	$designation_name = $this->session->userdata('designation_name');
	$data['nestedView']['heading']="$designation_name - Home";
	$data['nestedView']['cur_page'] = 'home';
	$data['nestedView']['parent_page'] = 'home';
	$data['nestedView']['pageTitle'] = 'AP Oil Fed - CMM';

	$data['nestedView']['js_includes'] = array();
	$data['nestedView']['css_includes'] = array();
	$data['nestedView']['css_includes'][] = '<link href="'.assets_url() .'pages/css/Home.css" rel="stylesheet" type="text/css" />';	
		
	//$_SESSION['login_id'] = '';
	# Breadcrumbs
	$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
	$data['stock_scroll']=$this->Stock_m->get_stock_details();
	$col=array_column($data['stock_scroll'],'tot_oil_weight');
	$data['sum']=array_sum($col);
		
	$plant = $this->Sales_model->get_plant_block();
        $sales_scroll = array();
        foreach ($plant as $key => $value) 
        {
            $sales_scroll[$key]['plant_name'] = $value['name'];
            $pending_qty = $this->Sales_model->get_sales_details($value['plant_id']);
            $sales_scroll[$key]['pending_qty'] = $pending_qty;
            
        }
        $data['sales_scroll'] = $sales_scroll;
		
	$this->load->view('home',$data);
		

}
	public function comingSoon()
	{
		$data['nestedView']['heading']="Coming Soon";
		$data['nestedView']['pageTitle'] = 'Coming Soon';
		$data['nestedView']['cur_page'] = 'home';
		$data['nestedView']['parent_page'] = 'home';
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();	
		$data['nestedView']['breadCrumbTite'] = 'Coming Soon';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Coming Soon','class'=>'active','url'=>SITE_URL));
		$this->load->view('coming_soon',$data);

	}

	public function changePassword()
	{	
		$data['nestedView']['heading'] ="Change Password";
		$data['nestedView']['cur_page'] = 'home';
		$data['nestedView']['parent_page'] = 'home';
		//$incFILE = "mod/ChangePassword.php";
		$data['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/changePassword.js"></script>';
		$data['nestedView']['css_includes'] = array();

		$data['nestedView']['pageTitle'] = 'Change password';

		# Breadcrumbs
		$data['nestedView']['breadCrumbTite'] = 'Change Password';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Change Password','class'=>'active','url'=>'');

		if($this->input->post('oldPassword') != '')
		{
			$oldpassword = @$this->input->post('oldPassword');
			$newpassword = @$this->input->post('newPassword');
			$cnewpassword = @$this->input->post('cnewPassword');

			if($newpassword != $cnewpassword)
			{
				$this->session->set_flashdata('response', '<div class="alert alert-danger">
                    <button class="close" data-close="alert"></button> New Password and Confirm New Password donot match. Please try again </div>');
				redirect(SITE_URL.'changePassword');				
			}
			else
			{
				$this->load->model('Login_model');
				$check = $this->Login_model->checkOldPassword($oldpassword, $this->session->userdata('user_id'));
				if($check)
				{
					$where = array('user_id' => $this->session->userdata('user_id'));
					$data = array('password' => md5($newpassword),
									'modified_by' => $this->session->userdata('user_id'),
									'modified_time' => date('Y-m-d H:i:s'));
					$this->Common_model->update_data('user', $data, $where);
					$this->session->set_flashdata('response', '<div class="alert alert-success">
	                    											<button class="close" data-close="alert"></button> Password Successfully changed
	                											</div>');
					redirect(SITE_URL);				
				}
				else
				{
					$this->session->set_flashdata('response', '<div class="alert alert-danger">
	                <button class="close" data-close="alert"></button> Old Password donot match with existing entry. Please try again </div>');
					redirect(SITE_URL.'changePassword');				
				}
			}
		}
		else
		{
			$this->load->view('user/changePassword', $data);
		}
	}

}