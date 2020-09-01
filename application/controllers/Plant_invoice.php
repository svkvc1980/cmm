<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 25th Feb 2017 09:00 AM

class Plant_invoice extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        
        $this->load->model("Plant_invoice_m");
        $this->load->model("Distributor_invoice_m");
	}
	public function manage_plant_invoice()
	{
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Unit Invoice ";
		$data['nestedView']['pageTitle'] = 'Manage Unit Invoice';
        $data['nestedView']['cur_page'] = 'manage_plant_invoice';
        $data['nestedView']['parent_page'] = 'manage_plant_invoice';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Unit Invoice', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_plant_invoice', TRUE);
        if($p_search!='') 
        {
            $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 
            $search_params=array(
                'invoice_number'       => $this->input->post('invoice_number', TRUE),                
                'from_date'          => $from_date,
                'to_date'            => $to_date,
                'plant_id' => $this->input->post('plant_id')
                );
            $this->session->set_userdata($search_params);
        } 
        else 
        {            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                'invoice_number'         => $this->session->userdata('invoice_number'),                
                'from_date'              => $this->session->userdata('from_date'),
                'to_date'                => $this->session->userdata('to_date'),
                'plant_id' =>$this->session->userdata('plant_id')
                    );
            }
            else 
            {
                $search_params=array(
                    'invoice_number'      => '',
                    'from_date'           => '',
                    'to_date'             => '',
                    'plant_id' => ''
                        );
                $this->session->set_userdata($search_params);
            }            
        }
        $data['searchParams'] = $search_params;

        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'manage_plant_invoice/';
        # Total Records
        $config['total_rows'] = $this->Plant_invoice_m->plant_invoice_total_num_rows($search_params);

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
        $data['plant_invoice_results'] = $this->Plant_invoice_m->plant_invoice_results($current_offset, $config['per_page'], $search_params);
        
        # Additional data
        $data['plant_list'] = $this->Plant_invoice_m->get_plant_list();
        $data['display_results'] = 1;
        $this->load->view('plant_invoice/plant_invoice_view',$data);
    } 
    public function plant_invoice_entry()
    {        
        
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Unit Invoice ";
        $data['nestedView']['pageTitle'] = 'Unit Invoice ';
        $data['nestedView']['cur_page'] = 'plant_invoice_entry';
        $data['nestedView']['parent_page'] = 'plant_invoice_entry';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/plant_invoice_generation.js"></script>';

        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/plant_invoice_entry.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Unit Invoice', 'class' => '', 'url' => SITE_URL.'manage_plant_invoice');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Entry', 'class' => '', 'url' => '');
        // Put Schemes in helper
        $data['schemes'] = $this->Plant_invoice_m->get_plant_schemes();
        $this->load->view('plant_invoice/plant_invoice_entry_view',$data);                                   
    }   
    public function plant_invoice_generation()
    {
        $do_numbers = $this->input->post('do_number',TRUE); 
        if(count($do_numbers) == 0){
            redirect(SITE_URL);
            exit;
        }
        $data['do_numbers'] = $do_numbers;
        $data['invoice_type'] =$this->input->post('invoice_type',TRUE);
        $data['scheme_id'] =$this->input->post('scheme_id',TRUE);
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Plant Invoice Generation";
        $data['nestedView']['pageTitle'] = 'Plant Invoice Generation';
        $data['nestedView']['cur_page'] = 'plant_invoice_generation';
        $data['nestedView']['parent_page'] = 'plant_invoice_generation';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/plant_invoice_generation.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Plant Invoice', 'class' => '', 'url' => SITE_URL.'manage_plant_invoice');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Invoice Entry', 'class' => '', 'url' => SITE_URL.'plant_invoice_entry');
        
        # Additional data        
            
            //print_r($do_numbers);exit;
            foreach ($do_numbers as $do_number)
            {   
                $do_details = $this->Plant_invoice_m->get_do_details($do_number); 

                //$do_details = $this->Common_model->get_data_row('do',array('do_number'=> $do_number));
                //echo '<pre>';print_r($do_details);exit;
                if(count($do_details) == 0){
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Sorry!</strong> DO Number : '.$do_number.' is not exist. </div>');       
                    redirect(SITE_URL.'plant_invoice_entry'); 
                    exit; 
                }
                if($do_details['status']>=3)
                {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Sorry!</strong> Invoice already generated for the DO Number: '.$do_number.' </div>');       
                    redirect(SITE_URL.'plant_invoice_entry');  
                    exit;
                }
                //echo '<pre>'; print_r($do_details);exit;
                $do_products = $this->Plant_invoice_m->get_do_products($do_details['do_number']);
                //echo '<pre>';print_r($do_products); exit; 
                foreach($do_products as $key => $prow)
                {
                    $tot_invoice_qty = get_do_product_invoice_qty($prow['order_id'],$do_details['do_id'],$prow['product_id']);
                    $do_quantity = $prow['do_quantity'];
                    $do_products[$key]['tot_invoice_qty']  = $tot_invoice_qty;
                    $do_products[$key]['pending_qty']  = ($do_quantity-$tot_invoice_qty);
                }
                $do_results[$do_details['do_id']]['do_number'] = $do_details['do_number'];
                $do_results[$do_details['do_id']]['do_id'] = $do_details['do_id'];
                $do_results[$do_details['do_id']]['do_date'] = $do_details['do_date'];
                $do_results[$do_details['do_id']]['do_products']=$do_products;

        
            }
            //echo"<pre>"; print_r($do_results);exit;
            $data['packing_material'] = $this->Common_model->get_data('packing_material',array('status'=>1));
            $data['stock_lifting_point'] = $do_products[0]['stock_lifting_point'];
            $data['stock_lifting_id'] = $do_products[0]['stock_lifting_id'];
            $data['do_results'] = $do_results;
            /*echo '<pre>';
                print_r($do_results);exit;*/
            $data['form_action'] = SITE_URL.'confirm_plant_invoice_generation';
            $data['flg']=1;

            if(@$this->input->post('cancel',TRUE) == 2)
            {
                $data['pos_data']=$_POST;
                echo '<pre>';
                print_r($data['pos_data']);exit;
                print_r($data['pos_data']);exit;
                $this->load->view('plant_invoice/eidt_plant_invoice_generation_view',$data); 
            }
            else
            {
                $this->load->view('plant_invoice/plant_invoice_generation_view',$data);  
            } 
        
                                    
    }
    public function view_plant_invoice_details()
    {
        $invoice_id = @cmm_decode($this->uri->segment(2));
        if($invoice_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Unit Invoice Details";
        $data['nestedView']['pageTitle'] = 'Unit Invoice Details';
        $data['nestedView']['cur_page'] = 'view_invoice_details';
        $data['nestedView']['parent_page'] = 'view_invoice_details';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Unit Invoice', 'class' => '', 'url' => SITE_URL.'manage_plant_invoice');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Unit Invoice Details', 'class' => '', 'url' => SITE_URL.'');
        
        # Additional data        
            
        
        $inv_products = $this->Plant_invoice_m->get_invoice_products($invoice_id);

        //echo '<pre>'; print_r($inv_products);exit;
        if($inv_products[0]['invoice_type_id'] == 2)
        {
            $data['free_products'] =$this->Distributor_invoice_m->get_free_products($inv_products[0]['invoice_id']);
            $data['free_gifts'] =$this->Distributor_invoice_m->get_free_gifts($inv_products[0]['invoice_id']);
        }
        $inv_dos= $this->Distributor_invoice_m->get_invoice_dos($invoice_id);
        $inv_obs= $this->Distributor_invoice_m->get_invoice_obs($invoice_id);
        //echo '<pre>'; print_r($inv_obs);exit;
        
        foreach ($inv_dos as $value) {
          $d[]=$value['do_number'];
          $do_date[] =$value['do_date'];
        }        
        $data['inv_dos'] =implode(',',$d);
        $data['inv_do_dates'] =implode(',',$do_date);

        foreach ($inv_obs as $value) {
          $ob[]=$value['order_number'];
          $ob_date[] =$value['order_date'];
        }

        $data['inv_obs'] =implode(',',$ob);
        $data['inv_ob_dates'] =implode(',',$ob_date);

        @$invoice_pm = $this->Common_model->get_data('invoice_pm',array('invoice_id'=>$invoice_id));

        $data['inv_products']= $inv_products;
        if(count($invoice_pm))
        {
            $data['invoice_pm'] = $invoice_pm;
        }

        $this->load->view('plant_invoice/invoice_details_view',$data);                              
    }    
    public function confirm_plant_invoice_generation()
    {
        /*echo '<pre>';
        print_r($_POST);exit;
        echo count(@$_POST['do_product']);exit;
        exit;*/
        $data['do_numbers']= $this->input->post('do_numbers',TRUE);
        if(count(@$_POST['do_product']) == 0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Sorry!</strong> Please Check Some Product,While Selecting For Invoice </div>');       
            redirect(SITE_URL.'plant_invoice_entry');

        }
        if(@$_POST['total_lifting_qty'] == 0 )
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Sorry!</strong> Lifting Quantity can not be empty </div>');       
            redirect(SITE_URL.'plant_invoice_entry');

        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Confirm Invoice Generation";
        $data['nestedView']['pageTitle'] = 'Confirm Invoice Generation';
        $data['nestedView']['cur_page'] = 'confirm_plant_invoice_generation';
        $data['nestedView']['parent_page'] = 'confirm_plant_invoice_generation';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/oil_stock_balance_entry.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Plant Invoice', 'class' => '', 'url' => SITE_URL.'manage_plant_invoice');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Entry', 'class' => 'active', 'url' => 'plant_invoice_entry');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Confirm Plant Invoice', 'class' => 'active', 'url' => '');

        # Data
        
        # Additional data        
        $data['data'] = $_POST;
        $do_product = $this->input->post('do_product');
        $lifting_qty = $this->input->post('lifting_qty');
        $products_qty_arr = array();
        foreach($do_product as $dop)
        {
            $dop_arr = explode('_',$dop);
            $do_id = $dop_arr[0];
            $order_id = $dop_arr[1];
            $product_id = $dop_arr[2];
            $lqty = $lifting_qty[$do_id][$order_id][$product_id];
            if(array_key_exists($product_id, $products_qty_arr))
            { 
                $products_qty_arr[$product_id] = $products_qty_arr[$product_id]+$lqty;
            }
            else{
                $products_qty_arr[$product_id] = $lqty;
            }

            //if(array_key_exists($product_id, search))
        }//exit;
        $products_arr =array_keys($products_qty_arr);
        //$schemes = $this->Common_model->get_data('free_gift_scheme',array('type_id>'=>1,'start_date<='=>date('Y-m-d'),'end_date>='=>date('Y-m-d')));
        if(@$this->input->post('invoice_type',TRUE) == 2 && (@$this->input->post('scheme_id',TRUE)!=''))
        {    
            $schemes = $this->Plant_invoice_m->get_schemes($this->input->post('scheme_id',TRUE));
            if(count($schemes)>0)
            {
                $fg_schemes = array();
                foreach ($schemes as $srow) {
                    $scheme_products = $this->Plant_invoice_m->get_scheme_products($srow['fg_scheme_id'],$products_arr);
                    //echo '<pre>';print_r($scheme_products);exit;
                    if($scheme_products)
                    {
                        foreach ($scheme_products as $sp_row) {
                            /*switch($sp_row['gift_type_id'])
                            {
                                case 1: // free packed product with us
                                    $scheme_gift_product = $this->Plant_invoice_m->get_scheme_gift_product($sp_row['fgs_product_id'],$sp_row['gift_type_id']);
                                break;
                                case 2: // free gift outside products
                                    $scheme_gift_product = $this->Plant_invoice_m->get_scheme_gift_product($sp_row['fgs_product_id'],$sp_row['gift_type_id']);
                                break;
                            }*/
                            $scheme_gift_product = $this->Plant_invoice_m->get_scheme_gift_product($sp_row['fgs_product_id'],$sp_row['gift_type_id']);
                            //print_r($scheme_gift_product); echo $this->db->last_query().'<br>';
                            if($scheme_gift_product)
                            {
                                $srow['scheme_product'][$sp_row['product_id']]=$sp_row;
                                $srow['gift_product'][$sp_row['product_id']]=$scheme_gift_product;
                            }
                            //echo '<pre';print_r($srow);exit;
                        }

                        $fg_schemes[]=$srow;
                    }
                    //echo '<pre>'; print_r($fg_schemes); exit;
                }
                $data['fg_schemes'] = $fg_schemes;
            }
        }
        //exit;
        //echo '<pre>'; print_r($lifting_qty);print_r($products_arr);print_r($fg_schemes); exit;
        $data['flg'] = 1;
        
        //echo '<pre>'; print_r($fg_schemes); exit;
        $data['product_tot_lifting_qty'] = $products_qty_arr;        
        $data['invoice_type'] = @$this->input->post('invoice_type',TRUE);
        $data['scheme_id']   = @$this->input->post('scheme_id',TRUE);
        $data['display_results'] = 0;
        $this->load->view('plant_invoice/confirm_plant_invoice_generation_view',$data);
    }    
    public function insert_plant_invoice_generation()
    {
        /*echo '<pre>';
        print_r($_POST);
        exit;*/
        //echo count($_POST['pm_id']);exit;
        $this->db->trans_begin();
        $invoice_number = get_plant_invoice_number();
        $data = array(
                        'invoice_number'    => $invoice_number,
                        'invoice_date'      => date('Y-m-d'),
                        'vehicle_number'    =>  $this->input->post('vehicle_number'),
                        'total'             => $this->input->post('grand_total'),
                        'invoice_type_id'      => $this->input->post('invoice_type'),
                        'plant_id'          => get_plant_id(),
                        'discount'          => 0,
                        'created_by'        => $this->session->userdata('user_id'),
                        'created_time'      =>  date('Y-m-d H:i:s')
                        );
        //print_r($data);exit;
        $invoice_id = $this->Common_model->insert_data('invoice',$data);
        $pm_id = $this->input->post('pm_id');
        $pm_quantity = $this->input->post('pm_quantity');
        if(@$pm_id[0] !='')
        {
            foreach ($pm_id as $key => $value) 
            {
                if(@$value!='' && @$pm_quantity[$key]!='' )
                {
                    // inserting data
                    $invoice_pm_data=array(
                        'pm_id' => $value,
                        'invoice_id' =>$invoice_id,
                        'quantity'   =>$pm_quantity[$key]
                        );
                    $in_pm_id = $this->Common_model->insert_data('invoice_pm',$invoice_pm_data);
                    // updating stock in plant PM
                    $plant_pm_count = $this->Common_model->get_data('plant_pm',array('plant_id'=>get_plant_id(),'pm_id' =>$value));
                   /* echo count($plant_pm_count).'--';
                    echo $this->db->last_query();*/
                    //exit;
                    if(count($plant_pm_count)>0)
                    { 
                        // UPdating Plant Pm 
                        $qry='UPDATE plant_pm SET quantity = quantity-"'.$pm_quantity[$key].'", updated_time= NOW() WHERE plant_id = "'.get_plant_id().'" AND pm_id = "'.$value.'"';
                        $r=$this->db->query($qry);  
                    }
                    else
                    {   // Inserting Into  Plant PM
                        $plant_pm_data =array(
                                'plant_id'      => get_plant_id(),
                                'pm_id'         => ($value),
                                'quantity'      => (-$pm_quantity[$key]),
                                'updated_time'  => date('Y-m-d H:i:s')
                                    );
                        $this->Common_model->insert_data('plant_pm',$plant_pm_data);

                    }
                }             
            }
        }
        //exit;
        $do_order_product = $this->input->post('do_order_product');
        $do_ob_product_id = $this->input->post('do_ob_product_id');
        $items_per_carton = $this->input->post('items_per_carton');
        $price = $this->input->post('price');
        $pending_qty = $this->input->post('pending_qty');
        $lifting_qty = $this->input->post('lifting_qty');
        $fg_scheme = $this->input->post('fg_scheme');
        $scheme_product = $this->input->post('scheme_product');
        $free_product = $this->input->post('free_product');
        $fp_items_per_carton = $this->input->post('fp_items_per_carton');
        $fg_lifting_qty = $this->input->post('fg_lifting_qty');
        $inv_do_arr = array(); $total_amount = 0; $do_ids = array();
            //looping do order product
            foreach ($do_order_product as $dop_val) {
                
                $dop_arr = explode('_',$dop_val);
                $do_id = $dop_arr[0];
                $order_id = $dop_arr[1];
                $product_id = $dop_arr[2];
                $d_o_val = $do_id.'_'.$order_id;
                if(!in_array($do_id, $do_ids))
                {
                    $do_ids[]=$do_id;
                }
                if(array_key_exists($d_o_val, $inv_do_arr))
                {
                    $invoice_do_id = $inv_do_arr[$d_o_val];
                }
                else
                {
                    // Prepare Invoice DO Data
                    $inv_do_data = array(
                                    'invoice_id'    => $invoice_id,
                                    'do_id'         => $do_id,
                                    'order_id'      => $order_id,
                                    'status'        => 1
                                );
                    // Inserting invoice do
                    $invoice_do_id = $this->Common_model->insert_data('invoice_do',$inv_do_data);
                    // pushing invoice_do_id into inv_do_arr
                    $inv_do_arr[$d_o_val] = $invoice_do_id;
                }
                // preparing do products data array
                $invoice_do_product_data = array(
                                    'invoice_do_id'     => $invoice_do_id,
                                    'product_id'        => $product_id,
                                    'quantity'          => $lifting_qty[$do_id][$order_id][$product_id],
                                    'do_ob_product_id'  => $do_ob_product_id[$do_id][$order_id][$product_id],
                                    'items_per_carton'  => $items_per_carton[$do_id][$order_id][$product_id],
                                    'status'            => 1
                                );
                // Inserting do products
                $this->Common_model->insert_data('invoice_do_product',$invoice_do_product_data);
                //echo $this->db->last_query().'<br>';
                // Updating invoice do product status
                $op_status = ($lifting_qty[$do_id][$order_id][$product_id]>=$pending_qty[$do_id][$order_id][$product_id])?3:2;
                $op_data = array('status'=>$op_status,'modified_by'=>$this->session->userdata('user_id'),'modified_time'=>date('Y-m-d H:i:s'));
                $op_where = array('do_ob_product_id'=>$do_ob_product_id[$do_id][$order_id][$product_id]);$this->db->where($op_where);
                $this->db->set('pending_qty', 'pending_qty-'.$lifting_qty[$do_id][$order_id][$product_id], FALSE);
                $this->db->set('status',$op_status);
                $this->db->set('modified_by',$this->session->userdata('user_id'));
                $this->db->set('modified_time',date('Y-m-d H:i:s'));
                $this->db->update('do_order_product');
                //$this->Common_model->update_data('do_order_product',$op_data,$op_where);
                /*echo 'lq:'.$lifting_qty[$do_id][$order_id][$product_id].'--pq:'.$pending_qty[$do_id][$order_id][$product_id].'<br>';
                echo $this->db->last_query().'<br>';*/
                // Updating Production in Plant_Production
                $qry='UPDATE plant_product SET quantity = quantity-"'.$lifting_qty[$do_id][$order_id][$product_id].'" WHERE plant_id = "'.get_plant_id().'" AND product_id = "'.$product_id.'"';
                $r=$this->db->query($qry);
                //echo $this->db->last_query().'<br>';
                $amount = $lifting_qty[$do_id][$order_id][$product_id]*$items_per_carton[$do_id][$order_id][$product_id]*$price[$do_id][$order_id][$product_id];
                $total_amount += $amount;
            }
            //exit;
            //looping do's
            foreach ($do_ids as $doID) {
                // update do Id status
                $this->Plant_invoice_m->updateDOStatus($doID);
                //echo $this->db->last_query().'<br>';
            }
            //echo '<pre>'; print_r($fg_scheme);
            //echo '<pre>'; print_r($free_product);
            //exit;
            if(isset($fg_scheme)&&count($fg_scheme)>0) // check if any scheme exists
            {
                //echo 'hi';
                //looping schemes 
                $fgs_queries =  '';
                    foreach ($fg_scheme as $fg_scheme_id)
                    {
                        $inv_sc_data = array(
                                        'invoice_id'    => $invoice_id,
                                        'fg_scheme_id'  => $fg_scheme_id,
                                        'status'        => 1,
                                        'created_by'    => $this->session->userdata('user_id'),
                                        'created_time'  => date('Y-m-d H:i:s')
                                        );
                        // Insert Invoice scheme
                        $invoice_scheme_id = $this->Common_model->insert_data('invoice_scheme',$inv_sc_data);
                        //$fgs_queries.=$this->db->last_query().'<br>';
                        // looping scheme product
                        foreach($fg_lifting_qty[$fg_scheme_id] as $key2 => $free_products_array)
                        {
                            // echo '<pre>';print_r($free_product[$fg_scheme_id]);exit;
                            // check if free packed product exist type - 1
                            if($key2 == 1)
                            {
                                foreach ($free_products_array as $free_product_id => $free_product_quantity) {
                                    $per_carton = $fp_items_per_carton[$fg_scheme_id][1][$free_product_id];
                                    $fp_qty = $fg_lifting_qty[$fg_scheme_id][1][$free_product_id];
                                    $inv_fp_data = array(
                                                    'invoice_scheme_id' => $invoice_scheme_id,
                                                    'item_type_id'      => 2,
                                                    'product_id'        => $free_product_id,
                                                    'quantity'          => $fp_qty,
                                                    'items_per_carton'  => @$per_carton,
                                                    'status'            => 1,
                                                    'created_by'        => $this->session->userdata('user_id'),
                                                    'created_time'      => date('Y-m-d H:i:s')
                                                    );
                                    // Insert free packed product
                                    $this->Common_model->insert_data('invoice_free_product',$inv_fp_data);
                                    //$fgs_queries .= $this->db->last_query().'<br>';
                                    // Convert fp qty to cartons
                                    //echo '<pre>';echo $this->db->last_query().'<br>';
                                    $fp_carton_qty = $fp_qty/$per_carton;
                                    // update plant product stock
                                    $qry='UPDATE plant_product SET quantity = quantity-"'.$fp_carton_qty.'", updated_time= NOW() WHERE plant_id = "'.$this->input->post('stock_lifting_id').'" AND product_id = "'.$free_product_id.'"';
                                    $r=$this->db->query($qry);
                                    //echo $this->db->last_query().'<br>';
                                }
                                 
                            }                                             

                            // check if free packed product exist type - 2
                            else
                            {
                                foreach ($free_products_array as $fr_gt_id => $fr_gf_qty) {
                                    $fg_qty = $fg_lifting_qty[$fg_scheme_id][2][$fr_gt_id];
                                    $inv_fg_data = array(
                                                    'invoice_scheme_id' => $invoice_scheme_id,
                                                    'free_gift_id'      => $fr_gt_id,
                                                    'quantity'          => $fg_qty,
                                                    'status'            => 1,
                                                    'created_by'        => $this->session->userdata('user_id'),
                                                    'created_time'      => date('Y-m-d H:i:s')
                                                    );
                                    // Insert free gift product
                                    $this->Common_model->insert_data('invoice_free_gift',$inv_fg_data);
                                    //echo '<pre>';echo $this->db->last_query().'<br>';
                                   // $fgs_queries .= $this->db->last_query().'<br>';
                                    // update plant free gift stock
                                    $qry='UPDATE plant_free_gift SET quantity = quantity-"'.$fg_qty.'", updated_time= NOW() WHERE plant_id = "'.$this->input->post('stock_lifting_id').'" AND free_gift_id = "'.$fr_gt_id.'"';
                                    $r=$this->db->query($qry);
                                    //echo $this->db->last_query().'<br>';
                                    //$fgs_queries .= $this->db->last_query().'<br>';
                                }
                                
                            }

                        }
                    }
            }
            //exit;
            /*echo $fgs_queries;
            exit;*/
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
           $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }
        else
        {
            //echo 'hi'; 
            //exit;
            $this->db->trans_commit();
            redirect(SITE_URL.'print_plant_invoice_details/'.cmm_encode($invoice_id)); exit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Invoice has been generated successfully with Invoice No: '.$invoice_number.'</div>');
        }
        redirect(SITE_URL.'manage_plant_invoice');
    }
    public function download_plant_invoice()
    {
        if($this->input->post('download_plant_invoice')!='') {
            
            $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 
            $search_params=array(
                'invoice_number'       => $this->input->post('invoice_number', TRUE),
                'from_date'          => $from_date,
                'to_date'            => $to_date,
                'plant_id' => $this->input->post('plant_id')
                );
            $invoice = $this->Plant_invoice_m->plant_invoice_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Invoice Number','Invoice Date','Total','Discount');
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
            if(count($invoice)>0)
            {                
                foreach($invoice as $row)
                {
                    
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    
                    $data.='<td align="center">'.$row['invoice_number'].'</td>';
                    $data.='<td align="center">'.date('Y-m-d',strtotime($row['time'])).'</td>';
                    $data.='<td align="center">'.$row['total'].'</td>';
                    $data.='<td align="center">'.$row['discount'].'</td>'; 
                    
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
            $xlFile='Invoice'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
    // mahesh 23rd Apr 2017 00:48 AM
    public function print_plant_invoice_list()
    {
        if($this->input->post('print_plant_invoice_list')!='') {
            
            $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 
            $search_params=array(
                'invoice_number'       => $this->input->post('invoice_number', TRUE),
                'from_date'          => $from_date,
                'to_date'            => $to_date,
                'plant_id' => $this->input->post('plant_id')
                );
            $data['invoice_results'] = $this->Plant_invoice_m->plant_invoice_details($search_params);
            //echo $this->db->last_query();
            $data['search_data'] = $search_params;
            $this->load->view('plant_invoice/print_plant_invoice_list',$data);
        }
    }
    public function print_plant_invoice_details()
    {        
        $invoice_id = $this->input->post('invoice_id');
        //echo $invoice_id;exit;

        if($invoice_id==''){
            redirect(SITE_URL);
            exit;
        }

        $inv_products = $this->Plant_invoice_m->get_invoice_products($invoice_id);
        if($inv_products[0]['invoice_type_id'] == 2)
        {
            $data['free_products'] =$this->Distributor_invoice_m->get_free_products($inv_products[0]['invoice_id']);
            $data['free_gifts'] =$this->Distributor_invoice_m->get_free_gifts($inv_products[0]['invoice_id']);
        }
        $inv_dos= $this->Plant_invoice_m->get_invoice_dos($invoice_id);
        
        foreach ($inv_dos as $value) {
          $d[]=$value['do_number'];
        }

        
        $data['inv_dos'] =implode(',',$d);
       // $data['inv_dos']=$inv_dos;
       // echo $data['inv_dos'];exit;
        //echo $this->db->last_query();exit; 
        /*echo '<pre>';
        print_r($inv_dos);exit;*/
        @$invoice_pm = $this->Common_model->get_data('invoice_pm',array('invoice_id'=>$invoice_id));
        // echo $this->db->last_query();exit;

        // echo '<pre>'; print_r($inv_products);exit; 
        $data['inv_products']= $inv_products;
        if(count($invoice_pm))
        {
            $data['invoice_pm'] = $invoice_pm;
        }
        

        $this->load->view('plant_invoice/print_plant_invoice_details',$data);
                                          
    }
    
}