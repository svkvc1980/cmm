<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Purchaseorder extends Base_controller 
{
    public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Purchaseorder_m");
        $this->load->model("Common_model");               
	}
    
    public function oil()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Purchase Order for Oils";
        $data['nestedView']['pageTitle'] = 'Purchase Order for Oils';
        $data['nestedView']['cur_page'] = 'oil';
        $data['nestedView']['parent_page'] = 'oil';

        /*# Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/.js"></script>';
        $data['nestedView']['css_includes'] = array();*/

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Purchase Order for Oils', 'class' => '', 'url' => SITE_URL);
         
        $data['broker'] = $this->Purchaseorder_m->getbroker();
        $data['agency'] = $this->Purchaseorder_m->getagency();
        //print_r($data['agency']);exit;
        $data['product'] = $this->Purchaseorder_m->getproduct();

        $po_id1  =  $this->Purchaseorder_m->get_po_id();
        $data['po_id'] = $po_id1['po_id']+1;
         
       
       
        # Additional data
        $data['portlet_title'] = 'Purchase Order for Oils';
        $data['form_action'] = SITE_URL.'';
        $data['displayResults'] = 0;
        $this->load->view('purchase order/oil',$data);
    }

    public function packing_material()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Purchase Order for Packing Material";
        $data['nestedView']['pageTitle'] = 'Purchase Order for Packing Material';
        $data['nestedView']['cur_page'] = 'packing_materiall';
        $data['nestedView']['parent_page'] = 'purchase_order';

        /*# Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/.js"></script>';
        $data['nestedView']['css_includes'] = array();*/

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Purchase Order for Oils', 'class' => '', 'url' => SITE_URL);
         
        $data['broker'] = $this->Purchaseorder_m->getbroker();
        $data['agency'] = $this->Purchaseorder_m->getagency();
        //print_r($data['agency']);exit;
        $data['packing'] = $this->Purchaseorder_m->getpackingmaterial();

        $po_id1  =  $this->Purchaseorder_m->get_po_id();
        $data['po_id'] = $po_id1['po_id']+1;
         
       
       
        # Additional data
        $data['form_action'] = SITE_URL.'';
        $data['displayResults'] = 0;
        $this->load->view('purchase order/packing_material',$data);
    }

    public function free_gifts()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Purchase Order for Free Gifts";
        $data['nestedView']['pageTitle'] = 'Purchase Order for Free Gifts';
        $data['nestedView']['cur_page'] = 'free_gift';
        $data['nestedView']['parent_page'] = 'purchase_order';

        /*# Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/.js"></script>';
        $data['nestedView']['css_includes'] = array();*/

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Purchase Order for Free Gifts', 'class' => '', 'url' => SITE_URL);
         
        $data['broker'] = $this->Purchaseorder_m->getbroker();
        $data['agency'] = $this->Purchaseorder_m->getagency();
        //print_r($data['agency']);exit;
        $data['product'] = $this->Purchaseorder_m->getproduct();

        $po_id1  =  $this->Purchaseorder_m->get_po_id();
        $data['po_id'] = $po_id1['po_id']+1;
         
       
       
        # Additional data
        $data['form_action'] = SITE_URL.'';
        $data['displayResults'] = 0;
        $this->load->view('purchase order/free_gifts',$data);
    }

}
