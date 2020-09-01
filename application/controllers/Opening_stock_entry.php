<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Opening_stock_entry extends Base_controller 
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Quantity_updation_model");
    }
    public function product_quantity()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Opening Stock Entry for Products";
        $data['nestedView']['pageTitle'] = 'stock entry product';
        $data['nestedView']['cur_page'] = 'opening_stock_entry_product';
        $data['nestedView']['parent_page'] = 'opening_stock_entry';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
         $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/price_updation.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Opening Stock Entry for Products', 'class' => '', 'url' => ''); 
        $data['flag']=1;
        $data['portlet_title'] = 'Opening Stock Entry for Products';
       
        $this->load->view('update_quantity',$data);
    }
    /*
      * Function   :  View Product Price
     */
    public function view_product_quantity()
    {
        $plant_id = $this->input->post('plant_id',TRUE);
        if($plant_id =='')
        {
            redirect(SITE_URL); exit();
        }

        if($this->input->post('plant_id',TRUE))
        {
            //print_r($this->session->userdata('session_loose_oil_results'));exit;
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "stock updation for products";
            $data['nestedView']['pageTitle'] = 'stock updation for products';
            $data['nestedView']['cur_page'] = 'opening_stock_entry_product';
        $data['nestedView']['parent_page'] = 'opening_stock_entry';

            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/price_updation.js"></script>';
            $data['nestedView']['css_includes'] = array();

            # Breadcrumbs
            $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Opening stock entry for Products', 'class' => '', 'url' => SITE_URL . 'product_quantity');
            $data['nestedView']['breadCrumbOptions'][] = array('label' => 'products list', 'class' => '', 'url' => '');

          
                $plant_id=$this->input->post('plant_id');


                $products=$this->Quantity_updation_model->get_products();
                foreach($products as $key =>$value)
                {   
                    $product_results[$value['loose_oil_id']]['loose_oil_name']=$value['loose_oil_id'];
                    $product_results[$value['loose_oil_id']]['product_name']=$value['name'];
                    $product_results[$value['loose_oil_id']]['plant_id']=$plant_id;
                    $results=$this->Quantity_updation_model->get_sub_products_by_products($value['loose_oil_id']);
                    $product_results[$value['loose_oil_id']]['sub_products']=$results;
                }
            $data['plant_id']=$plant_id;
            @$product_id=$this->Common_model->get_data('plant_product',array('plant_id'=>$plant_id));
            @$loose_oil_id=$this->Common_model->get_data('plant_recovery_oil',array('plant_id'=>$plant_id));
            foreach($loose_oil_id as $key=> $value)
            {
                @$oil_result[$value['plant_id']][$value['loose_oil_id']]=$value['oil_weight'];
            }
            
            foreach($product_id as $key=>$value)
            {
                @$result[$value['plant_id']][$value['product_id']]=$value['quantity'];
                @$result_pouches[$value['plant_id']][$value['product_id']]=$value['loose_pouches'];
             
            } 
            //echo "<pre>"; print_r($product_results); exit;
            $data['results']=@$result;
            $data['oil_results']=@$oil_result;
            $data['pouches']=@$result_pouches;
            $data['block_id']=$this->Common_model->get_value('plant_block',array('plant_id'=>$plant_id),'block_id');
            $plant_name=$this->Common_model->get_value('plant',array('plant_id'=>$plant_id),'name');
            $data['loose_oil']=$this->Common_model->get_data('loose_oil',array('status'=>1,'loose_oil_id !=' => 8));

            $data['product_results']=$product_results;
            $data['portlet_title'] =$plant_name;
            $data['flag']=2;
            $this->load->view('update_quantity',$data);
        }
        else
        {
            redirect(SITE_URL.'product_quantity');
        }
        
    }

    public function insert_latest_quantity()
    { 
       
        $product_id=$this->input->post('product_id',TRUE);
        $quantity=$this->input->post('quantity',TRUE);
        $oil_weight=$this->input->post('oil_weight',TRUE);
        $pouches=$this->input->post('pouches');
        $plant_id=$this->session->userdata('ses_plant_id');
        $block_id = $this->session->userdata('block_id');
        $this->db->trans_begin();
        foreach($quantity as $key=>$value)
        {

            if($value !='')
            {
            	if($block_id == 2)
            	{
                if($pouches[$key]=='')
                {
                    $pouches[$key] = 'NULL'; 
                }
                }
                $query = 'select * from plant_product where product_id="'.$key.'" AND plant_id="'.$plant_id.'"';
                $count = $this->Common_model->get_no_of_rows($query);
                
                if($count>0)
                {
                    if($block_id == 2)
                    {
                    $qry='UPDATE plant_product set quantity='.$quantity[$key].',loose_pouches='.$pouches[$key].' where product_id='.$key.' and plant_id='.$plant_id;
                    
                    $this->db->query($qry);
                    }
                    else
                    {
                    	$qry='UPDATE plant_product set quantity='.$quantity[$key].' where product_id='.$key.' and plant_id='.$plant_id;
                    
                    $this->db->query($qry);
                    }
                }
                else
                {
                  
                   $products[] = array( 
                    'quantity'   =>  $quantity[$key],
                    'loose_pouches'    =>  $pouches[$key],
                    'plant_id'   =>  $this->input->post('plant_id'),                
                    'product_id' =>  $key,
                    'updated_time'=>date('Y-m-d H:i:s')
                    ); 
               }
                
            }
            else
            {
                $query='select * from plant_product where product_id="'.$key.'" AND plant_id="'.$plant_id.'"';
                $count = $this->Common_model->get_no_of_rows($query);
                if($count>0)
                {
                    $qry='DELETE FROM plant_product WHERE product_id='.$key.' and plant_id='.$plant_id;
                    $this->db->query($qry);
                }
            }

                
        } 
        foreach($products as $row)
        {
           
           $plant_id = $this->Common_model->insert_data('plant_product',$row);
        } 
        foreach($oil_weight as $key => $value)
        {
            $plant_id=$this->session->userdata('ses_plant_id');
            if($value !='')
            {
                $query='select * from plant_recovery_oil where loose_oil_id="'.$key.'" AND plant_id="'.$plant_id.'"';
                $count = $this->Common_model->get_no_of_rows($query);

                if($count>0)
                {
                    
                    $qry='UPDATE plant_recovery_oil set oil_weight='.$value.' where loose_oil_id='.$key.' and plant_id='.$plant_id;
                    $this->db->query($qry);
                }
                else
                {
                  
                   $data = array( 
                    'oil_weight'   =>  $value,
                    'plant_id'   =>  $plant_id,                
                    'loose_oil_id' =>  $key,
                    'updated_time'=>date('Y-m-d H:i:s')
                    );
                $this->Common_model->insert_data('plant_recovery_oil',$data);
               }
            }
            else
            {
                $query='select * from plant_recovery_oil where loose_oil_id="'.$key.'" AND plant_id="'.$plant_id.'"';
                $count = $this->Common_model->get_no_of_rows($query);
                if($count>0)
                {
                    $qry='DELETE FROM plant_recovery_oil WHERE loose_oil_id='.$key.' and plant_id='.$plant_id;
                    $this->db->query($qry);
                }
            }
        }  
        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <strong>Error!</strong> Something went wrong. Please check. </div>');

        }
        else
        {
            $this->db->trans_commit(); 
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <strong>Success!</strong>Stock Details has been added successfully! </div>');
        }
        redirect(SITE_URL.'product_quantity');
        
    } 
}