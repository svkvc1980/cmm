<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

class Individual_do_list extends Base_controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->model("Individual_do_list_m");
	}

	/*
    * individual distributor delivery order report 
    * -------mastan--------
    */
    public function individual_distributor_do()
    {
        $data['nestedView']['heading']="Distributor Delivery Order List";
        $data['nestedView']['pageTitle'] = 'Delivery Order List';
        $data['nestedView']['cur_page'] = 'do_list';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Delivery Order List', 'class' => '', 'url' => '');

        $this->load->view('delivery_orders/individual_distributor_do',$data);  
    }

    public function individual_distributor_do_detail()
    {
        $do_no = $this->input->post('order_number');
        $dist_do = $this->Individual_do_list_m->get_individual_dist_do($do_no);
        $data['dist_do']=$dist_do;
        foreach ($dist_do as $value) {
          $order_no[]=$value['order_number'];
          $order_date[] =date('d-m-Y',strtotime($value['order_date']));
        }        
        $data['order_no'] =implode(',',array_unique($order_no));
        $data['order_date'] =implode(',',array_unique($order_date));
       // print_r($data['dist_do']); die;
        $this->load->view('delivery_orders/print_individual_distributor_do',$data); 
    }

    /*
    * individual Unit delivery order report 
    * -------mastan--------
    */
    public function individual_unit_do()
    {
        $data['nestedView']['heading']="Unit Delivery Order List";
        $data['nestedView']['pageTitle'] = 'Unit Order List';
        $data['nestedView']['cur_page'] = 'do_list';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Delivery Order List', 'class' => '', 'url' => '');

        $this->load->view('delivery_orders/individual_unit_do',$data);  
    }

    public function individual_unit_do_detail()
    {
        $do_no = $this->input->post('order_number');
        $data['unit_do'] = $this->Individual_do_list_m->get_individual_unit_do($do_no);
        #print_r($data['unit_do']); die;
        $this->load->view('delivery_orders/print_individual_unit_do',$data); 
    }
}