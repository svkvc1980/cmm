<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';
class Exec_wise_dist_list_r extends Base_controller
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Exec_wise_dist_list_r_m");
    }
    public function exec_wise_dist_list()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Executive Wise DD Payments";
        $data['nestedView']['pageTitle'] = 'Executive Wise DD Payments';
        $data['nestedView']['cur_page'] = 'exec_wise_dist_list';
        $data['nestedView']['parent_page'] = 'reports';
        $data['nestedView']['list_page'] = 'payment_reports';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Executive Wise DD Payments','class'=>'active','url'=>'');

        # Get OB Type Details
       $data['executive_list'] = $this->Common_model->get_data('executive','');
       //echo "<pre>"; print_r($data['executive_list']);exit;



        $this->load->view('exec_dist_list/exec_wise_dist_list_r',$data);
    }
    public function view_exec_dist_list()
    {
    	if($this->input->post('submit',TRUE))
    	{
    		 $from_date=date('Y-m-d',strtotime($this->input->post('from_date',TRUE)));
    		 $to_date=date('Y-m-d',strtotime($this->input->post('to_date',TRUE)));
    		 
    		 $executive=$this->input->post('executive',TRUE);
    		 $data['from_date'] = $from_date;
    		 $data['to_date'] = $to_date;

    		 $data['executive_list'] = $this->Common_model->get_data_row('executive',array('executive_id'=>$executive));
             $data['results']=$this->Exec_wise_dist_list_r_m->view_exec_dist_list($executive,$to_date,$from_date);
             $this->load->view('exec_dist_list/print_exec_dist_list',$data);
       }

    }

}