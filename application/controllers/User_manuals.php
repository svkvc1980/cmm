<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
/*user manuals 
  Author:Roopa
  Time: 12.00PM 27-04-2017 */ 
class User_manuals extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
	}
	public function user_manuals()
	{           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="User Manuals";
		$data['nestedView']['pageTitle'] = 'User Manuals';
        $data['nestedView']['cur_page'] = 'user_manuals';
        $data['nestedView']['parent_page'] = 'User Manuals';
        $data['nestedView']['list_page'] = 'User Manuals';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'User Manuals', 'class' => 'active', 'url' => '');	
        
        $this->load->view('user_manuals/user_manual',$data);

    }
   
}