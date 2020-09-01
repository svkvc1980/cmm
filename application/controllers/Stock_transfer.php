<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

/*
stock transfer
auther: nagarjuna
created on: 1st mar 2017 10AM
*/

class Stock_transfer extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Stock_transfer_m");
	}

    public function godown_to_countersale()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Godown To Counter Sale";
        $data['nestedView']['pageTitle'] = 'Godown To Counter Sale';
        $data['nestedView']['cur_page'] = 'godown_to_countersale';
        $data['nestedView']['parent_page'] = 'stock_transfer';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/godown_to_counter.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Godown To Counter Sale', 'class' => '', 'url' => '');
        $plant_id = $this->session->userdata('ses_plant_id');
        $plant_data = $this->Stock_transfer_m->get_product_id($plant_id);
        if(count($plant_data)!=0)
        {
            $data['product'] = $this->Stock_transfer_m->get_product_based_on_plant($plant_data);
        }
        
        $data['flag']=1;

        $data['form_action']=SITE_URL.'submit_godown_to_countersale';
        $this->load->view('stock_transfer/godown_to_countersale',$data);
    }

    public function submit_godown_to_countersale()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Godown To Counter Sale";
        $data['nestedView']['pageTitle'] = 'Godown To Counter Sale';
        $data['nestedView']['cur_page'] = 'godown_to_countersale';
        $data['nestedView']['parent_page'] = 'stock_transfer';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/godown_to_counter.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Godown To Counter Sale', 'class' => '', 'url' => '');
        
        $data['flag']=2;
        $products = $this->input->post('product');
        $quantities = $this->input->post('trans_qty');
        $remarks = $this->input->post('remarks');
        foreach($products as $key => $value)
        {
            if($value!=null)
            {
                $product_name=$this->Common_model->get_value('product',array('product_id'=>$value),'name');
                $product_qty[]= array(
                                    'product_id'    => $value,
                                    'qty'           => $quantities[$key],   
                                    'product_name'  => $product_name,
                                    'remarks'       => $remarks
                                );
            }

        } 
        $data['product_qty']=$product_qty;

        $this->load->view('stock_transfer/godown_to_countersale',$data);
    }

    //insertion of stock transfer (godown to countersale)
    public function insert_godown_to_countersale()
    {
        $plant_id   = $this->session->userdata('ses_plant_id');
        $products   = $this->input->post('products');
        $quantities = $this->input->post('qty');

        $dat = array(
                    'counter_id'    => get_plant_counter_sale_id(),
                    'remarks'       => $this->input->post('remarks'),
                    'st_type_id'    => 1,
                    'on_date'       => date('Y-m-d'),
                    'status'        => 1,
                    'created_by'    => $this->session->userdata('user_id'),
                    'created_time'  => date('Y-m-d H:i:s')
                    );

        $gst_id = $this->Common_model->insert_data('godown_stock_transfer',$dat);

        foreach($products as $key => $value)
        {
            
            if($value!=null)
            { 
                $items_per_carton = $this->Common_model->get_value('product', array('product_id' => $value), 'items_per_carton');
                $insert_value = round($quantities[$key]/$items_per_carton,2);
                $dat1 = array(
                                'gst_id'            => $gst_id,
                                'product_id'        => $value,
                                'quantity'          => $insert_value,
                                'items_per_carton'  => $items_per_carton,
                                'status'            => 1,
                                'modified_by'       => $this->session->userdata('user_id'),
                                'modified_time'     => date('Y-m-d H:i:s')
                                );

                $this->Common_model->insert_data('gst_product',$dat1);

                $counter_id = get_plant_counter_sale_id();
                //adding stock to plant counter table 
                $query = 'select * from plant_counter_product where product_id="'.$value.'" AND counter_id="'.$counter_id.'"';
                $count = $this->Common_model->get_no_of_rows($query);
                if($count>0)
                {
                    $qry = 'UPDATE plant_counter_product SET quantity=quantity+'.$insert_value.', updated_time = NOW() WHERE counter_id='.$counter_id.' and product_id='.$value;
                    $this->db->query($qry); 
                }
                else
                {
                    $insert_data = array('product_id'  => $value,
                                         'counter_id'=> $counter_id,
                                         'quantity'  => $insert_value,
                                         'loose_pouches' => 0,
                                         'updated_time' => date('Y-m-d H:i:s'));
                    $this->Common_model->insert_data('plant_counter_product',$insert_data);
                }
                
            }
            if ($this->db->trans_status()===FALSE)
            {
                $this->db->rollback();
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>'); 
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Success!</strong> Stock Transferred to Godown successfully </div>');
            }
        }
        redirect(SITE_URL.'godown_to_countersale');
    }

    public function get_godown_stock()
    {
        $plant_id   = $this->session->userdata('ses_plant_id');
        $product_id = $this->input->post('product');
        $godown_stock = $this->Stock_transfer_m->get_godown_stock($product_id, $plant_id);
    }

    //stock transfer from counter to godown
    public function countersale_to_godown()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Counter Sale To Godown";
        $data['nestedView']['pageTitle'] = 'Counter Sale To Godown';
        $data['nestedView']['cur_page'] = 'countersale_to_godown';
        $data['nestedView']['parent_page'] = 'stock_transfer';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/counter_to_godown.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Counter Sale To Godown', 'class' => '', 'url' => '');
         
        $plant_id = $this->session->userdata('ses_plant_id');
        $plant_data = $this->Stock_transfer_m->get_product_id($plant_id);
        if(count($plant_data)!=0)
        {
            $data['product'] = $this->Stock_transfer_m->get_product_based_on_plant($plant_data);
        }
        $data['flag']=1;

        $data['form_action']=SITE_URL.'submit_countersale_to_godown';
        $this->load->view('stock_transfer/countersale_to_godown',$data);
    }

    public function submit_countersale_to_godown()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Counter Sale To Godown";
        $data['nestedView']['pageTitle'] = 'Counter Sale To Godown';
        $data['nestedView']['cur_page'] = 'countersale_to_godown';
        $data['nestedView']['parent_page'] = 'stock_transfer';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/counter_to_godown.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Counter Sale To Godown', 'class' => '', 'url' => '');
        
        $data['flag']=2;
        $products = $this->input->post('product');
        $quantities = $this->input->post('trans_qty');
        $remarks = $this->input->post('remarks');
        foreach($products as $key => $value)
        {
            if($value!=null)
            {
                $product_name=$this->Common_model->get_value('product',array('product_id'=>$value),'name');
                $product_qty[]= array(
                                    'product_id'    => $value,
                                    'qty'           => $quantities[$key],   
                                    'product_name'  => $product_name,
                                    'remarks'       => $remarks
                                );
            }

        } 
        $data['product_qty']=$product_qty;

        $this->load->view('stock_transfer/countersale_to_godown',$data);
    }

    //insertion of stock transfer (godown to countersale)
    public function insert_countersale_to_godown()
    {
        $plant_id   = $this->session->userdata('ses_plant_id');
        $products   = $this->input->post('products');
        $quantities = $this->input->post('qty');

        $dat = array(
                    'counter_id'    => get_plant_counter_sale_id(),
                    'remarks'       => $this->input->post('remarks'),
                    'st_type_id'    => 2,
                    'on_date'       => date('Y-m-d'),
                    'status'        => 1,
                    'created_by'    => $this->session->userdata('user_id'),
                    'created_time'  => date('Y-m-d H:i:s')
                    );

        $gst_id = $this->Common_model->insert_data('godown_stock_transfer',$dat);

        foreach($products as $key => $value)
        {
            if($value!=null)
            { 
                $items_per_carton = $this->Common_model->get_value('product', array('product_id' => $value), 'items_per_carton');
                $dat1 = array(
                                'gst_id'            => $gst_id,
                                'product_id'        => $value,
                                'quantity'          => $quantities[$key],
                                'items_per_carton'  => $items_per_carton,
                                'status'            => 1,
                                'modified_by'       => $this->session->userdata('user_id'),
                                'modified_time'     => date('Y-m-d H:i:s')
                                );

                $this->Common_model->insert_data('gst_product',$dat1);

                $counter_id = get_plant_counter_sale_id();
                //adding stock to plant counter table 
                $qry = 'UPDATE plant_counter_product SET quantity=quantity-'.$quantities[$key].', updated_time = NOW() WHERE counter_id='.$counter_id.' and product_id='.$value;
                $this->db->query($qry); 
            }
            if ($this->db->trans_status()===FALSE)
            {
                $this->db->rollback();
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>'); 
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Success!</strong> Stock Transferred to Counter Sale successfully </div>');
            }
        }
        redirect(SITE_URL.'countersale_to_godown');
    }

    public function get_counter_stock()
    {
        $plant_id   = $this->session->userdata('ses_plant_id');
        $product_id = $this->input->post('product');
        $godown_stock = $this->Stock_transfer_m->get_counter_stock($product_id, $plant_id);
    }
}