<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_controller extends CI_Controller {

	public  function __construct() 
	{
        parent::__construct();
        $this->Common_model->login_check();
	}

	function validateEditUrl($dataArray, $redirectUrl=0)
    {
        if(sizeof($dataArray)==0)
        {
        	redirect(SITE_URL.$redirectUrl);
        }
    }

}