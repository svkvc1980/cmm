<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Product_r extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Product_r_m");
    }

 public function product_r()
    {

        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Product Reports";
		$data['nestedView']['pageTitle'] = 'Product Reports';
        $data['nestedView']['cur_page'] = 'product_r';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Product Reports', 'class' => '', 'url' => '');	

        $this->load->view('product/product_r_view',$data);
    }

    public function print_product_report()
    {
        $submit = $this->input->post('submit',TRUE);
        if($submit!='')
        {

            $status = $this->input->post('status',TRUE);

            $product_list = $this->Product_r_m->get_products_list($status);
            $data['product_list'] = $product_list;
            $data['status'] = $status;
            $this->load->view('product/print_product_report',$data);
        }
        else
        {
            redirect(SITE_URL.'product_r'); exit();
        }
    }

}