<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 25th Feb 2017 09:00 AM

class Penalty_reports extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        
        $this->load->model("Penalty_reports_m");
       //$this->load->model("Distributor_invoice_m");
	}
	
    public function penalty_report()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Distributor Penalties";
        $data['nestedView']['pageTitle'] = 'Distributor Penalties';
        $data['nestedView']['cur_page'] = 'penalty_report';
        $data['nestedView']['parent_page'] = 'penalty_report';
        
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Distributor Penalties','class'=>'active','url'=>'');
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

        # Get OB Type Details  

        $data['distributor_list'] = $this->Common_model->get_data('distributor','','','CAST(distributor_code AS unsigned) ASC');
        $data['penalty_arr'] = $this->Common_model->get_data('ob_penalty',array('status'=>1));
        //echo "<pre>"; print_r($data['distributor_type']);exit;

        # Search Functionality
        $penalty_search=$this->input->post('penalty_search', TRUE);
        if($penalty_search!='') 
        {
            $from_date=(($this->input->post('fromDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('fromDate', TRUE))):''; 
            $to_date=(($this->input->post('toDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('toDate', TRUE))):''; 
            $data['after_days'] = ($this->input->post('days',TRUE) -1);
            $search_params=array(                                   
                'distributor_id'      => $this->input->post('distributor_id', TRUE),                                    
                'fromDate'            => $from_date,
                'toDate'              => $to_date,                                    
                'days'                => $this->input->post('days',TRUE)            
                                );
            $penalty_data = array();
            $data['search_params'] = $search_params ;
            //print_r( $data['search_params']);exit;
            $penalty_dist_ids = $this->Penalty_reports_m->get_distributor_ids($search_params);
            foreach ($penalty_dist_ids as $key => $value) 
            {
                $penalty_data[$value['distributor_id']] = $this->Penalty_reports_m->get_penalty_data($value['distributor_id'],$search_params); 
            }
            $data['penalty_data'] = $penalty_data ;
            $data['penalty_dist_ids'] = $penalty_dist_ids;
            $this->load->view('penalty_reports/print_penalty_report',$data);
        }
        else
        {
            $this->load->view('penalty_reports/penalty_reports_search_view',$data);
        }
        

        
    }
    public function consolidated_penalty_report()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Distributor Penalties";
        $data['nestedView']['pageTitle'] = 'Distributor Penalties';
        $data['nestedView']['cur_page'] = 'penalty_report';
        $data['nestedView']['parent_page'] = 'penalty_report';
        
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Distributor Penalties','class'=>'active','url'=>'');
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

        # Get OB Type Details  

        $data['distributor_list'] = $this->Common_model->get_data('distributor','','','CAST(distributor_code AS unsigned) ASC');
        $data['penalty_arr'] = $this->Common_model->get_data('ob_penalty',array('status'=>1));
        //echo "<pre>"; print_r($data['distributor_type']);exit;

        # Search Functionality
        $penalty_search=$this->input->post('penalty_search', TRUE);
        if($penalty_search!='') 
        {
            $from_date=(($this->input->post('fromDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('fromDate', TRUE))):''; 
            $to_date=(($this->input->post('toDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('toDate', TRUE))):''; 
            
            $search_params=array(              
                        'fromDate'            => $from_date,
                        'toDate'              => $to_date
                                );
            $penalty_data = array();
            $data['search_params'] = $search_params ;
            //print_r( $data['search_params']);exit;
            $penalty_dist_ids = $this->Penalty_reports_m->get_distributor_ids($search_params);
            if(count($penalty_dist_ids)>0)
            {
                foreach ($penalty_dist_ids as $key => $value) 
                {
                    $penalty_data[$value['distributor_id']] = $this->Penalty_reports_m->consolidated_get_penalty_data($value['distributor_id']); 
                }
                $data['penalty_data'] = $penalty_data ;
            }
            
            $data['penalty_dist_ids'] = $penalty_dist_ids;
            /*echo '<pre>';
            print_r($data['penalty_dist_ids']);
            print_r($data['penalty_data']);exit;*/
            $this->load->view('penalty_reports/print_consolidated',$data);
        }
        else
        {
            $this->load->view('penalty_reports/consolidated_pen_search_view',$data);
        }
        

        
    }


    public function dealerwise_penalty_report()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Distributorwise Penalty Report";
        $data['nestedView']['pageTitle'] = 'Distributorwise Penalty Report';
        $data['nestedView']['cur_page'] = 'dealerwise_penalty_report';
        $data['nestedView']['parent_page'] = 'dealerwise_penalty_report';
        
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Distributorwise Penalty Report','class'=>'active','url'=>'');
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

        # Get OB Type Details  

        $data['distributor_list'] = $this->Common_model->get_data('distributor','','','CAST(distributor_code AS unsigned) ASC');
        //echo "<pre>"; print_r($data['distributor_type']);exit;

        # Search Functionality
        $penalty_search=$this->input->post('penalty_search', TRUE);
        if($penalty_search!='') 
        {
            $from_date=(($this->input->post('fromDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('fromDate', TRUE))):''; 
            $to_date=(($this->input->post('toDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('toDate', TRUE))):''; 
            
            $search_params=array(                                   
                'distributor_id'      => $this->input->post('distributor_id', TRUE),                                    
                'fromDate'            => $from_date,
                'toDate'              => $to_date            
                                );
            $penalty_data = array();
            $data['search_params'] = $search_params ;
            //print_r( $data['search_params']);exit;
            $data['dist_data'] = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$search_params['distributor_id']));
            $data['penalty_data'] = $this->Penalty_reports_m->get_penalty_data($search_params['distributor_id'],$search_params);
            $this->load->view('penalty_reports/print_dealerwise_penalty_report',$data);
        }
        else
        {
            $this->load->view('penalty_reports/dealerwise_penalty_search_view',$data);
        }
        
    }
    
}