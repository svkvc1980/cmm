<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Daily_correction_report extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
       $this->load->model("Daily_correction_report_m");
	}
    public function daily_correction_report_search()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Daily correction Report Search";
        $data['nestedView']['pageTitle'] = 'Daily correction Report Search';
        $data['nestedView']['cur_page'] = 'daily_correction_report_search';
        $data['nestedView']['parent_page'] = 'daily_correction_report_search';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] =array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Daily correction Report Search ', 'class' => 'active', 'url' =>'');
        
        $this->load->view('daily_corrections/daily_correction_report_search',$data);
    }

    public function daily_correction_report(){

       
         # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Daily correction Report   ";
        $data['nestedView']['pageTitle'] = 'Daily correction Report';
        $data['nestedView']['cur_page'] = 'daily_correction_report';
        $data['nestedView']['parent_page'] = 'daily_correction_report';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] =array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Daily correction Report', 'class' => 'active', 'url' =>'');
                $p_search=$this->input->post('submit', TRUE);
        if($p_search!='') 
        {
            $from_date = date('Y-m-d',strtotime($this->input->post('from_date',TRUE)));
            
            $to_date = date('Y-m-d',strtotime($this->input->post('to_date',TRUE)));
            $data['daily_correction_report_row'] = $this->Daily_correction_report_m->daily_correction_report($from_date,$to_date);
            
            $data['from_date']=$from_date;
            $data['to_date']=$to_date;
            
        } 

         $this->load->view('daily_corrections/daily_correction_report',$data);

    }
}