<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Profile extends Base_controller {
	public function __construct() 
    {
        parent::__construct();
        $this->load->model("Common_model");
        $this->load->model("Profile_m");
    }

/*Profile
Author:Srilekha
Time: 03.54PM 22-02-2017 */
	public function profile()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="User Profile";
        $data['nestedView']['pageTitle'] = 'User Profile';
        $data['nestedView']['cur_page'] = 'profile';
        $data['nestedView']['parent_page'] = 'home';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/free_sample.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'User Profile','class'=>'active','url'=>'');

        $user_id=$this->session->userdata('user_id');
        $designation_id=$this->Common_model->get_value('user',array('user_id'=>$user_id),'designation_id');
        $block_id=$this->Common_model->get_value('user',array('user_id'=>$user_id),'block_id');
        if($block_id==1 || $block_id==2 || $block_id==3 || $block_id==4)
        {
        	$data['flag']=1;
        	$data['ops']=$this->Profile_m->get_ops_details($block_id);
        }
        if($block_id==5)
        {
        	$data['flag']=2;
        	$data['distributor']=$this->Profile_m->get_distributor_details($block_id);
        	$distributor_id=$data['distributor'][0]['distributor_id'];
        	$data['bank_details']=$this->Profile_m->get_bank_details($distributor_id);
        }
        
        $data['product']=$this->Common_model->get_data('product', array('status'=>1));
        $data['freesample_type']=get_freesample_type();

        $this->load->view('profile/profile_view',$data);
	}

}