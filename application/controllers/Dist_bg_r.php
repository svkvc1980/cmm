<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

	//Created by nagarjuna 20th-march-2017, 12:45PM

class Dist_bg_r extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Dist_bg_r_m");
	}

	public function dist_bg_r()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor Agreements";
		$data['nestedView']['pageTitle'] = "Distributor Agreements";
        $data['nestedView']['cur_page'] = 'dist_bg_view';
        $data['nestedView']['parent_page'] = 'dist_bg_view';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => "Distributor Agreements", 'class' => 'active', 'url' => '');

        $data['dist_bg'] = $this->Dist_bg_r_m->dist_bg_results();

        $this->load->view('distributor/dist_bg_view',$data);
	}

	public function print_dist_bg()
	{
        if($this->input->post('submit',TRUE))
        {
            $distributor_id = $this->input->post('distributor_id',TRUE);
            $from_date = date('Y-m-d',strtotime($this->input->post('from_date',TRUE)));
            $to_date = date('Y-m-d',strtotime($this->input->post('to_date',TRUE)));
            $status = $this->input->post('status',TRUE);
            $data['status'] = $status;
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;

            $data['distributor_results'] = $this->Dist_bg_r_m->get_dist_bg_details($distributor_id,$from_date, $to_date, $status);
        }
        
    	$this->load->view('distributor/print_dist_bg',$data);
    }

}