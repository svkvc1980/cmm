<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Packingmaterial extends Base_controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Packingmaterial_model");
        $this->load->model("Common_model");               
    }
    
    public function packing_material()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Purchase Order for Packing Materials";
        $data['nestedView']['pageTitle'] = 'Purchase Order for Packing Materials';
        $data['nestedView']['cur_page'] = 'packing_material';
        $data['nestedView']['parent_page'] = 'purchase_order';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Purchase Order for Packing Materials', 'class' => '', 'url' => SITE_URL);
         
        $data['broker'] = $this->Packingmaterial_model->getbroker();
        $data['agency'] = $this->Packingmaterial_model->getagency();
        //print_r($data['agency']);exit;
        $data['packing'] = $this->Packingmaterial_model->getpackingmaterial();

        # Additional data
        $data['form_action'] = SITE_URL.'';
        $data['displayResults'] = 0;
        $this->load->view('packing_material',$data);
    }

    //getting type dropdown based on agency using ajax
    public function ajax_agency_name()
    {
        if($this->input->post('supplier_id'))
        {
            $supplier_id =$this->input->post('supplier_id');
            echo json_encode($this->Packingmaterial_model->get_supplier_based_on_agency($supplier_id));
        }
    }
}
