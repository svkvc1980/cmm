<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';
/*
	Created By 		:	Priyanka
	Date 			:	5th March 2017 4:30 PM
	Module 			:	DO for Plants 
*/
class Plant_do extends Base_controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->model("Plant_do_m");
        $this->load->model("Delivery_order_m");
	}

	public function plant_do()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Delivery Order";
		$data['nestedView']['cur_page'] = 'plant_do';
		$data['nestedView']['parent_page'] = 'plant_do';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Delivery Order';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Delivery Order','class'=>'active','url'=>'');
		$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

		# Get Blocks(C & F and Stock Point) 
		$blocks = $this->Plant_do_m->get_blocks();
		$ops_cf_stock_blocks = $this->Plant_do_m->ops_cf_stock_blocks();
		
		# Get Product_id array
		$block_ids = array_column($blocks,'block_id');

		foreach($ops_cf_stock_blocks as $block_id=>$value)
		{
			$ops_cf_stock_ids[] = $value['block_id'];
		}
		foreach($block_ids as $key=>$block_id)
		{
			$block_name  = $this->Common_model->get_value('block',array('block_id'=>$block_id),'name');
			$plants 						   = $this->Plant_do_m->get_plants($block_id); 
			$plant_block[$block_id]['block_name'] = $block_name;
			$plant_block[$block_id]['plants']     = $plants;
		}
		foreach($ops_cf_stock_ids as $key=>$block_id)
		{
			$block_name  = $this->Common_model->get_value('block',array('block_id'=>$block_id),'name');
			$plants 						   = $this->Plant_do_m->get_plants($block_id); 
			$lifting_points[$block_id]['block_name'] = $block_name;
			$lifting_points[$block_id]['plants']     = $plants;
		}
		$data['plant_block'] =$plant_block;
		$data['lifting_points'] =$lifting_points;

		# flag = 1 (Displaying DO First form)
		$data['flag'] 	=	1;
		$this->load->view('plant_do/plant_do',$data);
	}

    public function get_plant_pending_dos()
    {
        $ob_type_id             = get_regular_type_id();
        $type                   = plant_order_type_id();
        $ordered_plant_id       = $this->input->post('ordered_plant_id',TRUE);
        $lifting_point_id       = $this->input->post('lifting_point_id',TRUE);
        
        # Get Orders based on Order Type, Lifting Point, Ordered Plant, Staus <=2
        $plant_order_details = $this->Plant_do_m->get_plant_pending_dos($ordered_plant_id,$ob_type_id);
        //echo '<pre>'; print_r($plant_order_details); exit;
        if(count($plant_order_details) != '')
        {
            if($ordered_plant_id != $lifting_point_id)
            {
                         
                foreach($plant_order_details as $key => $value)
                {
                    $order_results[$value['do_number']]['do_number']=$value['do_number'];
                    $order_results[$value['do_number']]['do_id']=$value['do_id'];
                    $order_results[$value['do_number']]['do_date']=$value['do_date'];
                    $order_results[$value['do_number']]['do_lifting_point']=$value['do_lifting_point'];
                    $results=$this->Plant_do_m->get_doProducts($value['do_id']);
                   /* foreach($results as $key => $prow)
                    {
                        $product_do_qty = get_ob_product_do_qtuantity($value['order_id'],$prow['product_id']);
                        $ordered_qty = $prow['ordered_quantity'];
                        $results[$key]['do_qty']  = $product_do_qty;
                        $results[$key]['pending_qty']  = ($ordered_qty-$product_do_qty);
                    }*/
                    $order_results[$value['do_number']]['do_products']=$results;
                    //echo"<pre>"; print_r($results);             
                }
                    echo '<h4>Pending DOs are:</h4>';
                    echo '<div class="table-scrollable">';
                    echo '<table class="table table-bordered table-striped table-hover mytable">';
                    
                    foreach($order_results as $order_id => $order_details)   
                    {
                        $order_date = date('d-m-Y',strtotime($order_details['do_date']));
                        if($order_details['do_products'] != '')
                        {
                            echo '<thead>';
                            echo '<th colspan="7">'.'DO Number : '.$order_details['do_lifting_point'].' / '.$order_details['do_number'].' / '.$order_date.'</th>';
                            echo '</thead>';
                            echo '<tr style="background-color:#cccfff">';
                            echo '<td>'.'Product'.'</td>';
                            echo '<td>'.'Price'.'</td>';
                            echo '<td>'.'Items Per Carton'.'</td>';
                            echo '<td>'.'Ordered Quantity'.'</td>';
                            echo '<td>'.'Pending Quantity'.'</td>';
                            echo '</tr>';
                            foreach($order_details['do_products'] as $key => $value)
                            {
                                $total=0;
                                $total_price  = $value['product_price'];
                                $total_value = ($total_price*($value['do_quantity']*$value['items_per_carton']));
                                echo '<tbody>';

                                echo '<tr>';
                                echo '<td>'.$value['product_name'].'</td>';
                                echo '<td>'.$total_price.'</td>';
                                echo '<td>'.$value['items_per_carton'].'</td>';
                                echo '<td>'.intval($value['do_quantity']).'</td>';
                                echo '<td>'.round($value['pending_qty']).'</td>';
                                echo '</tr>';
                                echo '</tbody>';
                            }
                        }                   
                    }
                    echo "</table";
                    echo '</div>';
               /* echo $this->db->last_query().'<br>'; */
                //echo"<pre>"; print_r($order_results);exit;
            }
        }  
        else
        {
             echo '<h3 align="center">No Pending DOs</h3>';
        }      
    }

	// Priyanka 5th March,17 05:16 pm
	public function plant_do_products()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Delivery Order";
		$data['nestedView']['cur_page'] = 'plant_do';
		$data['nestedView']['parent_page'] = 'plant_do';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Delivery Order';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Delivery Order','class'=>'active','url'=>'');

		$ordered_plant_id 				= $this->input->post('ordered_plant_id',TRUE);
		$lifting_point_id 				= $this->input->post('lifting_point_id',TRUE);
		$data['lifting_point_name'] 	= get_plant($lifting_point_id);
		$ob_type_id		  				= get_regular_type_id(); 
		$type 			  				= plant_order_type_id();

        // Get price type by ob type id
        $price_type_id =    $this->Common_model->get_value('ob_type', array('ob_type_id'=>$ob_type_id), 'price_type_id');
        $data['price_type'] = $price_type_id;
		//print_r($lifting_point_id);exit;

		if($ordered_plant_id != $lifting_point_id)
		{
			# Get Orders based on Order Type, Lifting Point, Ordered Plant, Staus <=2
	        $plant_order_details = $this->Plant_do_m->get_plant_ob_orders($ordered_plant_id,$ob_type_id,$type);
	      
	        foreach($plant_order_details as $key => $value)
	        {
	            $order_results[$value['order_number']]['order_number']=$value['order_number'];
	            $order_results[$value['order_number']]['order_id']=$value['order_id'];
	            $order_results[$value['order_number']]['order_date']=$value['order_date'];
                $order_results[$value['order_number']]['ob_lifting_point']=$value['ob_lifting_point'];
	            $results=$this->Plant_do_m->get_orderedProducts($value['order_id']);
	            foreach($results as $key => $prow)
                {
                    /*$product_do_qty = get_ob_product_do_qtuantity($value['order_id'],$prow['product_id']);
                    $ordered_qty = $prow['ordered_quantity'];
                    $results[$key]['do_qty']  = $product_do_qty;
                    $results[$key]['pending_qty']  = ($ordered_qty-$product_do_qty);*/
                    $product_price = get_product_price($prow['product_id'],$price_type_id,$value['order_date'],$lifting_point_id);
                    //echo $this->db->last_query().'<br>';
                    $results[$key]['product_price']  = $product_price;
                }
                $order_results[$value['order_number']]['ordered_products']=$results;
	            //echo"<pre>"; print_r($results);
	        }
	       /* echo $this->db->last_query().'<br>'; */
	        //echo"<pre>"; print_r($order_results);exit;
	    }
		else
		{
			$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                <strong>ERROR!</strong> There is a problem occured while selecting Lifting Point. Please try again. </div>');
    		redirect(SITE_URL.'plant_do');
		}

		# flag = 1 (Displaying DO First form)
		$data['flag'] 	=	2;
		$data['order_results'] = @$order_results;
		$data['lifting_point_id'] = @$lifting_point_id;
        $data['ordered_plant_id'] = @$ordered_plant_id;
		$this->load->view('plant_do/plant_do',$data);
	}

	// Priyanka 5th March,17 7:53 pm
    public function confirm_plant_do()
    {
        $submit = $this->input->post('generate_plant_do');
        $lifting_point_id = $this->input->post('lifting_point_id',TRUE);
        $ordered_plant_id = $this->input->post('ordered_plant_id',TRUE);
        $lifting_qty  = $this->input->post('lifting_qty');
        foreach ($lifting_qty as $key => $value) 
        {
            if($value !='')
            {
                $num_rows[] = $value;  
            }
            else
            {
                $num_rows = 0;
            }
           
        }
        if($num_rows == 0)
        {
             redirect(SITE_URL.'plant_do');
        }
        //print_r($ordered_plant_id);exit;
        if($submit!='')
        {
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Delivery Order Confirmation";
            $data['nestedView']['cur_page'] = 'delivery_order_confirmation';
            $data['nestedView']['parent_page'] = 'delivery_order';
            
            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['css_includes'] = array();
            
            # Breadcrumbs
            $data['nestedView']['pageTitle'] = 'Delivery Order';
            $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Delivery Order','class'=>'active','url'=>'');
            $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

            $order_product  = $this->input->post('order_product');
            $price  = $this->input->post('price');
            $ordered_qty  = $this->input->post('ordered_qty');
            $pending_qty  = $this->input->post('pending_qty');
            $lifting_qty  = $this->input->post('lifting_qty');
            $items_per_carton  = $this->input->post('items_per_carton');
            $do_products = array();
            //print_r($pending_qty);
            foreach ($order_product as $op_val) 
            {
                $op_arr = explode('_',$op_val);
                $order_id = $op_arr[0];
                $product_id = $op_arr[1];
                // Get product details
                $product = $this->Common_model->get_data_row('product',array('product_id'=>$product_id));
                $do_products[$op_val] = array(
                                            'order_id'          => $order_id,
                                            'product_id'        => $product_id,
                                            'product_name'      => $product['name'],
                                            'price'             => $price[$order_id][$product_id],
                                            'ordered_qty'       => $ordered_qty[$order_id][$product_id],
                                            'pending_qty'       => $pending_qty[$order_id][$product_id],
                                            'lifting_qty'       => $lifting_qty[$order_id][$product_id],
                                            'items_per_carton'  => $items_per_carton[$order_id][$product_id],
                                            'oil_weight'        => $product['oil_weight']
                                        );
            }
            $data['do_products']   =  $do_products;
            //echo '<pre>';print_r($do_products); exit;
            $data['do_number']  =   get_plant_do_number();
           
            $data['lifting_point_name'] = get_plant($lifting_point_id);
            $data['lifting_point_id']   = $lifting_point_id;
            $data['ordered_plant_id']   = @$ordered_plant_id;
            $this->load->view('plant_do/confirm_plant_do',$data);
        }
    }

    public function submit_plant_do()
    {

        $submit = $this->input->post('proceed_plant_do');
        $lifting_point_id = $this->input->post('lifting_point_id');
        $ordered_plant_id = $this->input->post('ordered_plant_id',TRUE);

        $price  = $this->input->post('price');
        $lifting_qty  = $this->input->post('lifting_qty');
        $ordered_qty  = $this->input->post('ordered_qty');
        $pending_qty  = $this->input->post('pending_qty');

        //print_r($ordered_plant_id);exit;
        $c_and_f_id = c_and_f_id();
        $block_id = $this->Common_model->get_value('plant_block',array('plant_id'=>$lifting_point_id),'block_id');
        //print_r($block_id);exit;
        if($submit!='')
        {
            //echo '<pre>'; print_r($_POST); exit;
            $order_product  = $this->input->post('order_product');   
            //$stock_lifting_unit_id = $this->input->post('stock_lifting_unit_id');         
            //print_r($pending_qty);exit;
            $items_per_carton  = $this->input->post('items_per_carton');
            $do_number = get_plant_do_number();
            $data = array(
                        'do_number'     =>  $do_number,
                        'do_date'       =>  date('Y-m-d'),
                        'lifting_point' =>  $lifting_point_id,
                        'status'        =>  1,
                        'created_by'    =>  $this->session->userdata('user_id'),
                        'created_time'  =>  date('Y-m-d H:i:s')
                        );
            //echo '<pre>'; print_r($_POST); exit;
            //Transaction begins here
            $this->db->trans_begin();
            // Inserting DO data
            $do_id = $this->Common_model->insert_data('do',$data);
            //echo $do_id.'<br>';
            $do_ob_arr = array(); $total_amount = 0; $order_ids = array();
            //looping order product
            foreach ($order_product as $op_val) {
                /*echo $op_val.'<br>';
                echo $this->db->last_query().'<br>';*/
                $op_arr = explode('_',$op_val);
                $order_id = $op_arr[0];
                $product_id = $op_arr[1];
                if(!in_array($order_id, $order_ids))
                {
                    $order_ids[]=$order_id;
                }
                if(array_key_exists($order_id, $do_ob_arr))
                {
                    $do_ob_id = $do_ob_arr[$order_id];
                }
                else
                {
                    // Prepare DO OB Data
                    $do_ob_data = array(
                                    'order_id'      => $order_id,
                                    'do_id'         => $do_id,
                                    'status'        => 1
                                );
                    // Inserting do order
                    $do_ob_id = $this->Common_model->insert_data('do_order',$do_ob_data);
                    // pushing do_ob_id into do_ob_arr
                    $do_ob_arr[$order_id] = $do_ob_id;
                }
                $product = $this->Common_model->get_data_row('product',array('product_id'=>$product_id));
                // Array data for generate mail to distributor 
                $do_products_for_mail = array(
                                            'product_id'        => $product_id,
                                            'product_name'      => $product['name'],
                                            'price'             => $price[$order_id][$product_id],
                                            'ordered_qty'       => $ordered_qty[$order_id][$product_id],
                                            'pending_qty'       => $pending_qty[$order_id][$product_id],
                                            'lifting_qty'       => $lifting_qty[$order_id][$product_id],
                                            'items_per_carton'  => $items_per_carton[$order_id][$product_id],
                                            'oil_weight'        => $product['oil_weight']
                                        );
                $do_products[] = $do_products_for_mail;
                // preparing do products data array
                $do_product_data = array(
                                    'do_ob_id'          => $do_ob_id,
                                    'product_id'        => $product_id,
                                    'product_price'     => $price[$order_id][$product_id],
                                    'quantity'          => $lifting_qty[$order_id][$product_id],
                                    'pending_qty'       => $lifting_qty[$order_id][$product_id],
                                    'items_per_carton'  => $items_per_carton[$order_id][$product_id],
                                    'status'            => 1
                                );
                // Inserting do products
                $this->Common_model->insert_data('do_order_product',$do_product_data);

                // Updating order product status
                $op_status = ($lifting_qty[$order_id][$product_id]>=$pending_qty[$order_id][$product_id])?3:2;
                //print_r($op_status);exit;
                $op_data = array('status'=>$op_status,'modified_by'=>$this->session->userdata('user_id'),'modified_time'=>date('Y-m-d H:i:s'));
                $op_where = array('order_id'=>$order_id,'product_id'=>$product_id);
                $this->db->where($op_where);
                $this->db->set('pending_qty', 'pending_qty-'.$lifting_qty[$order_id][$product_id], FALSE);
                $this->db->set('status',$op_status);
                $this->db->set('modified_by',$this->session->userdata('user_id'));
                $this->db->set('modified_time',date('Y-m-d H:i:s'));
                $this->db->update('order_product');
                //$this->Common_model->update_data('order_product',$op_data,$op_where);
                /*echo 'lq:'.$lifting_qty[$order_id][$product_id].'--pq:'.$pending_qty[$order_id][$product_id].'<br>';
                echo $this->db->last_query().'<br>';*/
                $amount = $lifting_qty[$order_id][$product_id]*$items_per_carton[$order_id][$product_id]*$price[$order_id][$product_id];
                $total_amount += $amount;
            }
            //print_r($order_ids);
            //looping orders
            foreach ($order_ids as $orderId) {
                // update order Id status
                $do_status = $this->Plant_do_m->updateOrderStatus($orderId);
                //echo $this->db->last_query().'<br>';
            }

            # update the data if the selected block is c_and_f
            if(@$block_id == @$c_and_f_id)
            {
            	 //Deduct total amount of DO from c_and_f outstanding amount
	            $qry = 'UPDATE c_and_f SET outstanding_amount = outstanding_amount - '.$total_amount.' WHERE plant_id = '.$lifting_point_id;
	            $this->db->query($qry);
	            // updating modified by, modified time in plant table
	            $udata = array('modified_by' => $this->session->userdata('user_id'),'modified_time' => date('Y-m-d H:i:s'));		            
	            $uwhere = array('plant_id'=>$lifting_point_id);
	            $this->Common_model->update_data('plant',$udata,$uwhere);
            }
            $lifing_point_name = $this->input->post('lifting_point_name',TRUE);
           /* $mail = plant_DO_mail($ordered_plant_id,$do_products,$do_number,$do_status,$lifing_point_name);
            echo "<pre>"; print_r($mail);exit;*/
            if($this->db->trans_status()===FALSE)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong> There is a problem occured while generating DO. Please try again. </div>');  
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Success!</strong>Delivery Order has been created successfully with DO Number: '.$do_number.' </div>');
            }
        }
        redirect(SITE_URL.'plant_do');
    }

    # 6th March 2017,6:15 AM
    # DO List 
    public function plant_do_list()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Unit D.O. List";
        $data['nestedView']['pageTitle'] = 'Unit D.O. List';
        $data['nestedView']['cur_page'] = 'plant_do_r';
        $data['nestedView']['parent_page'] = 'reports';
        $data['nestedView']['list_page'] = 'do_reports';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Unit D.O. List','class'=>'active','url'=>'');
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';
        
        # Get Blocks(C & F and Stock Point) 
        $blocks = $this->Plant_do_m->get_blocks();
        $ops_cf_stock_blocks = $this->Plant_do_m->ops_cf_stock_blocks();
        
        # Get Product_id array
        $block_ids = array_column($blocks,'block_id');

        foreach($ops_cf_stock_blocks as $block_id=>$value)
        {
            $ops_cf_stock_ids[] = $value['block_id'];
        }
        # Order For
        foreach($block_ids as $key=>$block_id)
        {
            $block_name  = $this->Common_model->get_value('block',array('block_id'=>$block_id),'name');
            $plants                            = $this->Plant_do_m->get_plants($block_id); 
            $plant_block[$block_id]['block_name'] = $block_name;
            $plant_block[$block_id]['plants']     = $plants;
        }

        # Data array for Lifting Point
        foreach($ops_cf_stock_ids as $key=>$block_id)
        {
            $block_name  = $this->Common_model->get_value('block',array('block_id'=>$block_id),'name');
            $plants = $this->Plant_do_m->get_plants($block_id); 
            $lifting_points[$block_id]['block_name'] = $block_name;
            $lifting_points[$block_id]['plants']     = $plants;
        }
        $data['plant_block'] =$plant_block;
        $data['lifting_points'] =$lifting_points;
        $data['product_list'] = $this->Delivery_order_m->get_product_list();

        # Search Functionality
        $search_plant_do=$this->input->post('search_plant_do', TRUE);
        if($search_plant_do!='') 
        {
            $from_date=(($this->input->post('fromDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('fromDate', TRUE))):''; 
            $to_date=(($this->input->post('toDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('toDate', TRUE))):'';

            $search_params=array(
                                    'do_number'           => $this->input->post('do_number', TRUE),
                                    'order_for'           => $this->input->post('order_plant', TRUE),
                                    'lifting_point_id'    => $this->input->post('lifting_point_id', TRUE),
                                    'fromDate'            => $from_date,
                                    'toDate'              => $to_date,
                                    'status'              => $this->input->post('status',TRUE),
                                    'product_id'	  => $this->input->post('product_id',TRUE)         
                                );
            $this->session->set_userdata($search_params);

        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                                    'do_number'            => $this->session->userdata('do_number'),
                                    'order_for'            => $this->session->userdata('order_for'),
                                    'lifting_point_id'     => $this->session->userdata('lifting_point_id'),
                                    'fromDate'             => $this->session->userdata('fromDate'),
                                    'toDate'               => $this->session->userdata('toDate'),
                                    'status'               => $this->session->userdata('status'),
                                    'product_id'	   => $this->session->userdata('product_id')
                    
                                    );
            }
            else {
                $search_params=array(
                                    'do_number'            => '',                               
                                    'order_for'            => '',
                                    'lifting_point_id'     => '',
                                    'fromDate'             => '',
                                    'toDate'               => '',
                                    'product_id'           => '',
                                    'status'               => 1 // Default displaying pending DO's                    
                                    );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'plant_do_list/';
        # Total Records
        $config['total_rows'] = $this->Plant_do_m->plant_do_num_rows($search_params);

        $config['per_page'] = 100;  //getDefaultPerPageRecords();
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
        $data['do_results'] = $this->Plant_do_m->plant_do_results($current_offset, $config['per_page'], $search_params);
        
        # Additional data
        $data['display_results'] = 1;
         $data['distributor_type'] = $this->Common_model->get_data('ob_type',array('status'=>1));

        $this->load->view('plant_do/plant_do_list',$data);
    }

    # 6th March 2017, 8:30 AM
    # DO View Products 
    public function view_plant_do_products()
    {
        $lifting_point_id   =   cmm_decode($this->uri->segment(2));
        $do_number = cmm_decode($this->uri->segment(3));
        if($do_number == '' || $lifting_point_id =='')
        {
            redirect(SITE_URL.'plant_do_list'); exit();
        }

        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Unit D.O. Products";
        $data['nestedView']['pageTitle'] = 'Unit D.O. Products';
        $data['nestedView']['cur_page'] = 'plant_do_r';
        $data['nestedView']['parent_page'] = 'reports';
        $data['nestedView']['list_page'] = 'do_reports';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Unit D.O. Products','class'=>'active','url'=>'');

        $do_status = $this->Common_model->get_value('do',array('do_number'=>$do_number),'status');
        $do_details = $this->Plant_do_m->get_do_details($do_number,$lifting_point_id);
        $do_products = $this->Plant_do_m->get_do_products($do_details['do_number'],$lifting_point_id,$do_status);
            foreach($do_products as $key => $prow)
            {
                $tot_invoice_qty = get_do_product_invoice_qty($prow['order_id'],$do_details['do_id'],$prow['product_id']);
                $do_quantity = $prow['do_quantity'];
                $do_products[$key]['raised_qty']  = $tot_invoice_qty;
                $do_products[$key]['pending_qty']  = ($do_quantity-$tot_invoice_qty);
            } 

        $data['do_products'] = $do_products;
        $data['do_details'] = $do_details;
        $data['lifting_point_id'] = $lifting_point_id;
        $data['do_number'] = $do_number;
        $this->load->view('plant_do/view_plant_do_products',$data);
    }

    # Print DO Products 
    public function print_plant_do_products()
    {
        # Get Order Id
        $lifting_point_id  =  cmm_decode($this->uri->segment(2));
        $do_number =  cmm_decode($this->uri->segment(3));
        if($do_number=='' || $lifting_point_id == '')
        {
            redirect(SITE_URL.'plant_do_list');
            exit;
        }  
            $do_status = $this->Common_model->get_value('do',array('do_number'=>$do_number),'status');
            $do_details = $this->Plant_do_m->get_do_details($do_number,$lifting_point_id);
            $do_products = $this->Plant_do_m->get_do_products($do_details['do_number'],$lifting_point_id,$do_status);
            //echo '<pre>';print_r($do_products); exit; 
            foreach($do_products as $key => $prow)
            {
                $tot_invoice_qty = get_do_product_invoice_qty($prow['order_id'],$do_details['do_id'],$prow['product_id']);
                $do_quantity = $prow['do_quantity'];
                $do_products[$key]['raised_qty']  = $tot_invoice_qty;
                $do_products[$key]['pending_qty']  = ($do_quantity-$tot_invoice_qty);
            } 

        $data['do_products'] = $do_products;
        $data['do_details'] = $do_details;
        $this->load->view('plant_do/print_plant_do_products',$data);
        
    }

    # Download DO List
    public function download_plant_do()
    {
        if($this->input->post('download_do')!='') {
            
           $search_params=array(
                                    'do_number'           => $this->input->post('do_number', TRUE),
                                    'order_for'           => $this->input->post('order_plant', TRUE),
                                    'lifting_point_id'    => $this->input->post('lifting_point_id', TRUE),
                                    'fromDate'            => $this->input->post('fromDate', TRUE),
                                    'toDate'              => $this->input->post('toDate', TRUE)            
                                );  
            $plant_do = $this->Plant_do_m->plant_do_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Order Number','Order Date','Order For','Lifting Point');
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
            if(count($plant_do)>0)
            {
                
                foreach($plant_do as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['do_number'].'</td>';
                    $data.='<td align="center">'.date('d-m-Y',strtotime($row['do_date'])).'</td>';
                    $data.='<td align="center">'.$row['plant_name'].'</td>';
                    $data.='<td align="center">'.$row['lifting_point_name'].'</td>';                   
                    $data.='</tr>';
                    $j++;
                }
            }
            else
            {
                $data.='<tr><td colspan="'.(count($titles)).'" align="center">No Results Found</td></tr>';
            }
            $data.='</tbody>';
            $data.='</table>';
            $time = date("Ymdhis");
            $xlFile='plant_DO_list'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }

    # Print DO List
    public function print_plant_do()
    {
        if($this->input->post('print_plant_do')!='') {
            
           $search_params=array(
                                    'do_number'           => $this->input->post('do_number', TRUE),
                                    'order_for'           => $this->input->post('order_plant', TRUE),
                                    'lifting_point_id'    => $this->input->post('lifting_point_id', TRUE),
                                    'fromDate'            => $this->input->post('fromDate', TRUE),
                                    'toDate'              => $this->input->post('toDate', TRUE)  ,
                                    'status'              => $this->input->post('status',TRUE),
                                    'product_id'	  => $this->input->post('product_id',TRUE)     
                                ); 
            $data['search_data'] = $search_params; 
            $data['do_results'] = $this->Plant_do_m->plant_do_details($search_params);
            $this->load->view('plant_do/print_plant_do_results',$data);
            
        }
    }
}