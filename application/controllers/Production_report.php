<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 15th Nov 2016 09:00 AM

class Production_report extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Production_report_model");
    }

    //Mounika
    public function Production_report()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Production Report";
        $data['nestedView']['pageTitle'] = 'Production Report';
        $data['nestedView']['cur_page'] = 'production_report';
        $data['nestedView']['parent_page'] = 'production_report';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] =array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Production Report', 'class' => 'active', 'url' =>'');
        $data['loose_oil_list'] = $this->Common_model->get_data('loose_oil',array('status'=>1));
        
        $this->load->view('production_report/production_report',$data);
    }

    public function print_production_report()
    {
        if($this->input->post('submit',TRUE))
        {
            $data['start_date']= date('Y-m-d',strtotime($this->input->post('start_date')));
            $data['end_date']= date('Y-m-d',strtotime($this->input->post('end_date')));
            $loose_oil_id = $this->input->post('loose_oil_id',TRUE);
            if($loose_oil_id!='')
            {
                $data['loose_oil_name'] = $this->Common_model->get_value('loose_oil',array('loose_oil_id'=>$loose_oil_id),'name'); 
            }

            $data['production'] = $this->Production_report_model->get_production_details($data['start_date'],$data['end_date'],$loose_oil_id);

        }
        $this->load->view('production_report/print_production_report',$data);
    }
}
