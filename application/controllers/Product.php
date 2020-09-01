<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Product extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Product_model");
        $this->load->model("Price_updation_model");
    }
    //Mounika 07th FEB 2017
    public function product()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Manage Product';
        $data['nestedView']['heading'] = "Manage Product";
        $data['nestedView']['cur_page'] = 'productt';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Product','class'=>'active','url'=>'');
        $data['product_packing_type'] = array(''=>'- Packing Type -')+$this->Common_model->get_dropdown('product_packing_type','product_packing_type_id','name');
        $data['oil_cotegory'] = array(''=>'- Loose Oil -')+$this->Common_model->get_dropdown('loose_oil','loose_oil_id','short_name');
        $data['denomination_list']=$this->Product_model->get_capacity();

        # Search Functionality
        $psearch=$this->input->post('search_product', TRUE);
        if($psearch!='') {
        $search_params=array(
            'product'                   =>   $this->input->post('product', TRUE),
            'status'			=>   $this->input->post('status',TRUE),
            'loose_oil_id'              =>   $this->input->post('oil_category', TRUE),
            'product_packing_type_id'   =>   $this->input->post('product_packing_type', TRUE),
            'capacity_id'               =>   $this->input->post('capacity_id', TRUE)
                              );
        $this->session->set_userdata($search_params);
        } else {
            
            if($this->uri->segment(2)!='')
            {
            $search_params=array(
            'product'                   =>   $this->session->userdata('product'),
            'status'			=>   $this->session->userdata('status'),
            'loose_oil_id'              =>   $this->session->userdata('loose_oil_id'),
            'product_packing_type_id'   =>   $this->session->userdata('product_packing_type_id'),
            'capacity_id'               =>   $this->session->userdata('capacity_id')
                              );
            }
            else {
                $search_params=array(
                    'product'                =>'',
                    'status'		     =>'',
                    'loose_oil_id'           =>'',
                    'product_packing_type_id'=>'',
                    'capacity_id'            =>''
                                  );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_params'] = $search_params;
        
         # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL .'product/';
        # Total Records
        $config['total_rows'] = $this->Product_model->product_total_num_rows($search_params);

        $config['per_page'] = getDefaultPerPageRecords();
        $data['total_rows'] = $config['total_rows'];
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        $current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        if ($data['pagination_links'] != '') {
            $data['last'] = $this->pagination->cur_page * $config['per_page'];
            if ($data['last'] > $data['total_rows']) {
                $data['last'] = $data['total_rows'];
            }
            $data['pagermessage'] = 'Showing ' . ((($this->pagination->cur_page - 1) * $config['per_page']) + 1) . ' to ' . ($data['last']) . ' of ' . $data['total_rows'];
        }
        $data['sn'] = $current_offset + 1;
        /* pagination end */

        # Loading the data array to send to View
        $data['product'] = $this->Product_model->Product_results($search_params,$config['per_page'], $current_offset);
        # print_r($data['product']); exit();
        # Additional data
        $data['display_results'] = 1;

        $this->load->view('product/product',$data);
    }
    public function add_product()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Add Product';
        $data['nestedView']['heading'] = "Add Product";
        $data['nestedView']['cur_page'] = 'productt';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/product.js"></script>';
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Product','class'=>'','url'=>SITE_URL.'product');
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Add Product','class'=>'active','url'=>'');

        # Data        
        $data['loose_oil'] = array(''=>'-Select Loose Oil Category-')+$this->Common_model->get_dropdown('loose_oil','loose_oil_id','name');
        $data['product_packing_type'] = array(''=>'-Select Product packing Category-')+$this->Common_model->get_dropdown('product_packing_type','product_packing_type_id','name');
        $data['capacity'] = $this->Product_model->get_capacity();
        # Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_product';      
        $this->load->view('product/product',$data);
    }
    public function insert_product()
    {
        // GETTING INPUT TEXT VALUES
    $data = array( 
        'loose_oil_id'           =>  $this->input->post('loose_oil', TRUE),
        'name'                   =>  $this->input->post('product', TRUE),
        'short_name'             =>  $this->input->post('short_name', TRUE),
        'description'            =>  $this->input->post('description', TRUE),
        'items_per_carton'       =>  $this->input->post('items_per_carton',TRUE),
        'oil_weight'             =>  $this->input->post('oil_weight',TRUE),
        'product_packing_type_id'=>  $this->input->post('product_packing_type',TRUE),               
        'created_by'             =>  $this->session->userdata('user_id'),
        'created_time'           =>  date('Y-m-d H:i:s') 
                  );
    $product_id = $this->Common_model->insert_data('product',$data);
    $data1 = array( 
        'product_id'        =>  $product_id,
        'capacity_id'       =>  $this->input->post('capacity', TRUE)
                  );
    $this->Common_model->insert_data('product_capacity',$data1);

        if ($product_id>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Product has been added successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'product'); 
    }
    public function edit_product()
    {
        $product_id=@cmm_decode($this->uri->segment(2));
        if($product_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Edit Product';
        $data['nestedView']['heading'] = "Edit Product";
        $data['nestedView']['cur_page'] = 'productt';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/product.js"></script>';
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Product','class'=>'active','url'=>SITE_URL.'product');
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Edit Product','class'=>'active','url'=>'');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_product';
        $data['display_results'] = 0;

        # Data
        $data['capacity'] = $this->Product_model->get_capacity();
        $data['loose_oil'] = array(''=>'-Select Loose Oil Category-')+$this->Common_model->get_dropdown('loose_oil','loose_oil_id','name');
        $data['product_packing_type'] = array(''=>'-Select Product packing Category-')+$this->Common_model->get_dropdown('product_packing_type','product_packing_type_id','name');
    
        $row = $this->Common_model->get_data('product',array('product_id'=>$product_id));
        $data['capacity_id'] = $this->Common_model->get_value('product_capacity',array('product_id'=>$product_id),'capacity_id');
        $data['product_row'] = $row[0];
        $this->load->view('product/product',$data);
    }
    public function update_product()
    {
        $product_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($product_id=='')
        {
            redirect(SITE_URL.'product');
            exit;
        }
        // GETTING INPUT TEXT VALUES
        $data = array( 
            'loose_oil_id'           =>  $this->input->post('loose_oil', TRUE),
            'name'                   =>  $this->input->post('product', TRUE),
            'short_name'             =>  $this->input->post('short_name', TRUE),
            'description'            =>  $this->input->post('description', TRUE), 
            'items_per_carton'       =>  $this->input->post('items_per_carton',TRUE),
            'oil_weight'             =>  $this->input->post('oil_weight',TRUE),
            'product_packing_type_id'=>  $this->input->post('product_packing_type',TRUE),               
            'modified_by'            =>  $this->session->userdata('user_id'),
            'modified_time'          =>  date('Y-m-d H:i:s')
                     ); 
        $where = array('product_id'=>$product_id);
        $this->Common_model->update_data('product',$data,$where);

        $data1 = array( 
            'product_id'           =>  $product_id,
            'capacity_id'          =>  $this->input->post('capacity', TRUE)
                      );
        
        $this->Common_model->update_data('product_capacity',$data1,$where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Product has been updated successfully! </div>');
        redirect(SITE_URL.'product'); 
    }
    public function deactivate_product()
    {
        $product_id=@cmm_decode($this->uri->segment(2));
        $where = array('product_id' => $product_id);
        $dataArr = array('status' => 2);
        $this->Common_model->update_data('product',$dataArr, $where);
        
        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Success!</strong> Product has been De-Activated successfully!
                             </div>');

        redirect(SITE_URL.'product');
    }
    public function activate_product()
    {
        $product_id=@cmm_decode($this->uri->segment(2));
        $where = array('product_id' => $product_id);
        $dataArr = array('status' => 1);
        $this->Common_model->update_data('product',$dataArr, $where);
        
        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Success!</strong> Product has been Activated successfully!
                             </div>');

        redirect(SITE_URL.'product');
    }

    public function download_product()
    {
        if($this->input->post('download_product')!='')
        {
            $search_params=array(
            'product'                   =>   $this->input->post('product', TRUE),
            'loose_oil_id'              =>   $this->input->post('oil_category', TRUE),
            'product_packing_type_id'   =>   $this->input->post('product_packing_type', TRUE),
            'capacity_id'               =>   $this->input->post('capacity_id', TRUE)
                              );
            $products = $this->Product_model->product_details($search_params);
            $header = '';
            $data ='';
            $titles = array('S.NO','Capacity','Loose Oil','Product');
            $data = '<table border="1">';
            $data.='<thead>';
            $data.='<tr>';
            foreach ( $titles as $title)
            {
                $data.= '<th align="center">'.$title.'</th>';
            }
            $data.='</tr>';
            $data.='</thead>';
            $data.='<tbody>';
            $j=1;
            if(count($products)>0)
            {
                foreach($products as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['capacity'].' '.$row['unit'].'</td>';
                    $data.='<td align="center">'.$row['loose_oil'].'</td>';
                    $data.='<td align="center">'.$row['product'].'</td>';
                    /*$data.='<td align="center">'.$row['description'].'</td>'; */            
                    $data.='</tr>';
                    $j++;
                }
            }
            else
            {
                $data.='<tr><td colspan="'.(count($titles)+1).'" align="center">No Results Found</td></tr>';
            }
            $data.='</tbody>';
            $data.='</table>';
            $time = date("Ymdhis");
            $xlFile='Product'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }

    /*prasad product price updation files */
    public function product_price()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="View Product Prices";
        $data['nestedView']['pageTitle'] = 'Price Updation';
        $data['nestedView']['cur_page'] = 'product_price';
        $data['nestedView']['parent_page'] = 'price_updation';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
         $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/price_updation.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Product price', 'class' => '', 'url' => ''); 

        $data['distributor'] = $this->Common_model->get_data('distributor_price_type',array('status'=>1),array('price_type_id','name'));

        //getting MRP id in distributor price type
        $row=$this->Common_model->get_data('distributor_price_type',array('name'=>'MRP'),array('price_type_id'));
        $data['mrp']=$row[0]; 

        //getting Raithu bazar id in distributor price type
        $row=$this->Common_model->get_data('distributor_price_type',array('name'=>'Raitu Bazar'),array('price_type_id'));
        $data['raitu_bazar']=$row[0];

        //destroying session price type created in update_product_price
        $this->session->unset_userdata('price_data');
        
        //getting plant except the headoffice and distributor
        $data['plant_results']=$this->Price_updation_model->get_plant();
        $data['flag']=1;
        $data['portlet_title'] = 'Product Price Updation';
       
        $this->load->view('product/update_price',$data);
    }

    /*
      * Function   :  View Product Price 
      * Developer  :  Prasad created on: 6th Feb 1 PM updated on:      
     */
    public function view_product_price()
    {
        //print_r($this->session->userdata('session_loose_oil_results'));exit;
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "View Product Prices";
        $data['nestedView']['pageTitle'] = 'Price Updation';
        $data['nestedView']['cur_page'] = 'view_product_price';
        $data['nestedView']['parent_page'] = 'product_price';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/price_updation.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Product price', 'class' => '', 'url' => SITE_URL . 'product_price');
         $data['nestedView']['breadCrumbOptions'][] = array('label' => 'View Product price', 'class' => '', 'url' => '');
        @$price_data = $_SESSION['price_data'];
        //echo '<pre>';print_r($price_data); exit;
        if($this->input->post('submit')||(isset($price_data)&&$price_data['distributor_type']!=''))
        {
            $data['distributor_type']=($this->input->post('price_type')!='')?$this->input->post('price_type'):$price_data['distributor_type'];
            
            //retreving price type name based on price type id
            $price_type=$this->Common_model->get_data_row('distributor_price_type',array('price_type_id'=>$data['distributor_type']),array('name'));
            $data['price_type_name']=$price_type['name'];
            $data['price_data'] = $price_data;
           
            //setting session for mrp price type
            $data['plant_id']=($this->input->post('plant_name')!='')?$this->input->post('plant_name'):$price_data['plant_id'];
            $mrp_plant=($this->input->post('mrp_plant')!='')?$this->input->post('mrp_plant'):@$price_data['mrp_plant'];
            $data['mrp_plant']  = $mrp_plant;
           
            if($data['plant_id'] !='')
            {
                $row=$this->Common_model->get_data('plant',array('plant_id'=>$data['plant_id']),array('name'));
                $ops_plant=$row[0]; 
                $ops_plant_name=' for '.$ops_plant['name']; 
            }
            elseif($mrp_plant==get_all_plants())
            {
                $ops_plant_name=' for all units ';   
                 
            }
            
            $data['portlet_title'] = $data['price_type_name'].' price updation '.@$ops_plant_name;
            if($mrp_plant==get_all_plants())
            {
                 $row=$this->Common_model->get_data('plant',array('plant_id'=>'3'),array('plant_id'));
                 $plant=$row[0]; 
                 $plant_name=$plant['plant_id']; 
                 $latest_details=$this->Price_updation_model->get_all_products_latest_price_plant($data['distributor_type'],$plant_name);
            }
            else
            {
                if($data['plant_id']>0)
                {  
                   $latest_details=$this->Price_updation_model->get_all_products_latest_price_plant($data['distributor_type'],$data['plant_id']);
                }
                else
                {   
                    $latest_details=$this->Price_updation_model->get_all_products_latest_price($data['distributor_type']);
                }
            }
            //get products
            $products=$this->Price_updation_model->get_products();
            foreach($products as $key =>$value)
            {   $product_results[$value['loose_oil_id']]['loose_oil_name']=$value['loose_oil_id'];
                $product_results[$value['loose_oil_id']]['product_name']=$value['name'];
                $results=$this->Price_updation_model->get_sub_products_by_products($value['loose_oil_id']);
                $product_results[$value['loose_oil_id']]['sub_products']=$results;

            }
            
            $latest_price_details=array();
            foreach($latest_details as $key =>$value )
            {
                $latest_price_details[$value['product_id']]['old_price']=$value['value'];
                $latest_price_details[$value['product_id']]['product_price_id']=$value['product_price_id'];
            }

            $data['latest_price_details']=$latest_price_details;
            $data['product_results']=$product_results; 
        }
      
        $data['flag']=2;
        $this->load->view('product/update_price',$data);
    }
    /*
      * Function   :  Update Product Price 
      * Developer  :  Prasad created on: 6th Feb 1 PM updated on:      
     */
    public function update_product_price()
    {

         # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "View Product Prices";
        $data['nestedView']['pageTitle'] = 'Price Updation';
        $data['nestedView']['cur_page'] = 'view_product_price';
        $data['nestedView']['parent_page'] = 'product_price';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Product price', 'class' => '', 'url' => SITE_URL . 'product_price'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'View Product price', 'class' => '', 'url' =>SITE_URL.'view_product_price'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Update Product price', 'class' => '', 'url' => ''); 
        
       
        if($this->input->post('submit'))
        {
            $distributor_type=$this->input->post('distributor_type');
            $plant_id=$this->input->post('plant_id');
            $product_id=$this->input->post('product_id');
            $new_price=$this->input->post('new_price');
            $start_date=$this->input->post('effective_date');
            $product_price_id=$this->input->post('product_price_id');
            $product=$this->input->post('product');
            $loose_oil=$this->input->post('loose_oil');
            $old_price=$this->input->post('old_price');
            $loose_oil_id=$this->input->post('loose_oil_id');
            $mrp_plant = $this->input->post('mrp_plant');
            $data['mrp_plant']=$mrp_plant;
            $data['portlet_title'] = $this->input->post('portlet_title');
           
            /*
               * checking whether the product price is updated on given start date
               * if any product price is updated already on given start date .it is redirected to main page
            */
                //forming array to view page for confirmation for updating price
                $loose_oil_results = array();
                if($mrp_plant==get_all_plants())
                {
                    foreach($new_price as $key =>$value)
                    {
                        if($value !='')
                        {  
                            if(array_key_exists(@$keys, $loose_oil_results))
                            {   
                                $loose_oil_results[$loose_oil_id[$key]] ['products'][$product_id[$key]] =array(
                                    'product_id'=> $product_id[$key],
                                    'distributor_type'=> $distributor_type,
                                    'plant_id'  =>  $plant_id,
                                    'new_price' =>  $value,
                                    'old_price' =>  $old_price[$key],
                                    'start_date'=> $start_date,
                                    'product_price_id'=> $product_price_id[$key],
                                    'product'=> $product[$key],
                                    'loose_oil'=> $loose_oil[$key],
                                    'loose_oil_id'=>$loose_oil_id[$key]
                                    );    
                                }    
                                else
                                {
                                    $loose_oil_results[$loose_oil_id[$key]] ['loose_oil']=$loose_oil[$key];
                                    $loose_oil_results[$loose_oil_id[$key]] ['products'][$product_id[$key]] =array(
                                        'product_id'=> $product_id[$key],
                                        'distributor_type'=> $distributor_type,
                                        'plant_id'  =>  $plant_id,
                                        'new_price' =>  $value,
                                        'old_price' =>  $old_price[$key],
                                        'start_date'=> $start_date,
                                        'product_price_id'=> $product_price_id[$key],
                                        'product'=> $product[$key],
                                        'loose_oil'=> $loose_oil[$key],
                                        'loose_oil_id'=>$loose_oil_id[$key]
                                        );
                                } 
                            }
                        }
                    }
                else
                {
                    foreach($new_price as $key =>$value)
                    {
                        if($value !='')
                        {  
                            if($value != $old_price[$key])
                            {
                                if(array_key_exists(@$keys, $loose_oil_results))
                                {   
                                    
                                    $loose_oil_results[$loose_oil_id[$key]] ['products'][$product_id[$key]] =array(
                                        'product_id'=> $product_id[$key],
                                        'distributor_type'=> $distributor_type,
                                        'plant_id'  =>  $plant_id,
                                        'new_price' =>  $value,
                                        'old_price' =>  $old_price[$key],
                                        'start_date'=> $start_date,
                                        'product_price_id'=> $product_price_id[$key],
                                        'product'=> $product[$key],
                                        'loose_oil'=> $loose_oil[$key],
                                        'loose_oil_id'=>$loose_oil_id[$key]
                                        );    
                                }    
                                else
                                {
                                    $loose_oil_results[$loose_oil_id[$key]] ['loose_oil']=$loose_oil[$key];
                                    $loose_oil_results[$loose_oil_id[$key]] ['products'][$product_id[$key]] =array(
                                        'product_id'=> $product_id[$key],
                                        'distributor_type'=> $distributor_type,
                                        'plant_id'  =>  $plant_id,
                                        'new_price' =>  $value,
                                        'old_price' =>  $old_price[$key],
                                        'start_date'=> $start_date,
                                        'product_price_id'=> $product_price_id[$key],
                                        'product'=> $product[$key],
                                        'loose_oil'=> $loose_oil[$key],
                                        'loose_oil_id'=>$loose_oil_id[$key]
                                        );
                                } 
                            }
                        }
                    }   
                }
            
            //sending array to view page with updated price
            $data['flag']=3;
           
            //$this->session->set_userdata('session_loose_oil_results',$loose_oil_results);
            //echo '<pre>';
            $_SESSION['price_data'] = $_POST;
            //print_r($_SESSION['price_data']); exit;
            $data['loose_oil_results']=$loose_oil_results;
           

        } 
       
         $this->load->view('product/update_price',$data);              
    }

    public function insert_latest_price()
    { 

        if($this->input->post('submit'))
        {   
            $mrp_plant=$this->input->post('mrp_plant');
            $product_id=$this->input->post('product_id');
            $distributor_type_id=$this->input->post('distributor_type');
            $plant_id=$this->input->post('plant_id');
            $product_price_id=$this->input->post('product_price_id');
            
            $new_price=$this->input->post('new_price');
            $start_date=$this->input->post('start_date');
           
            if($mrp_plant==get_all_plants())
             {
                $all_plants_ids=$this->Price_updation_model->get_plant();
                foreach($new_price as $key =>$value)
                 {
                    if($value !='')
                    {
                        $dat= array(

                            'product_id'=> $product_id[$key],
                            'price_type_id'=> $distributor_type_id,
                            'value'=> $new_price[$key],
                            'start_date'=>date('Y-m-d',strtotime($start_date[$key]))
                            );
                        foreach($all_plants_ids as $k1=>$v1)
                        {
                            //updating end date in product price
                            $plant_id=$v1['plant_id']; 
                            $dat['plant_id']=$plant_id;
                            
                            //updating each product end date based on each plant
                            $results=$this->Price_updation_model->get_latest_id_plant($plant_id,$mrp_plant);
                            foreach($results as $k2 =>$v2)
                             {
                               $this->Price_updation_model->update_product_date($dat,$v2['product_price_id']);
                              }
                            $res = $this->Price_updation_model->insert_latest_data($dat,$product_price_id[$key]);       
                        }
                    }
                }

             }
            else
            {   
                foreach($new_price as $key =>$value)
                 {
                    if($value !='')
                    {
                        $dat= array(

                            'product_id'=> $product_id[$key],
                            'price_type_id'=> $distributor_type_id,
                            'value'=> $new_price[$key],
                            'start_date'=>date('Y-m-d',strtotime($start_date[$key]))
                            );
                        if($plant_id!='')
                        {
                            $dat['plant_id']=$plant_id;
                        }
                        //updating end date in product price
                        $this->Price_updation_model->update_product_date($dat,$product_price_id[$key]);
                        $res = $this->Price_updation_model->insert_latest_data($dat,$product_price_id[$key]);       
                        
                    }
                }
            }
           
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <strong>Success!</strong> Product prices has been successfully updated!
                         </div>');

            redirect(SITE_URL.'product_price');
           
          }
    }
   //name unique..
    public  function is_product_name_Exist()
    {
        $name = $this->input->post('product_name');
        $product_id = $this->input->post('product_id');
        $capacity_id =$this->input->post('capacity_id');
        echo $this->Product_model->is_nameExist($name,$product_id,$capacity_id);
    }
   
}