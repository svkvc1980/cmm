<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

/*
	Created By 		:	Priyanka
	Date 			:	4th March 2017 3:30 PM
	Module 			:	Order Booking for Plants 
*/
class Plant_ob extends Base_controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->model("Plant_ob_m");
	}

	public function plant_ob()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Unit Order Booking";
		$data['nestedView']['pageTitle'] = 'Unit Order Booking';
		$data['nestedView']['cur_page'] = 'plant_ob';
		$data['nestedView']['parent_page'] = 'plant_ob';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Order Booking','class'=>'active','url'=>'');
		$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

		# Get Blocks(C & F and Stock Point) 
		$blocks = $this->Plant_ob_m->get_blocks();
		$ops_cf_stock_blocks = $this->Plant_ob_m->ops_cf_stock_blocks();
		
		# Get Product_id array
		$block_ids = array_column($blocks,'block_id');

		foreach($ops_cf_stock_blocks as $block_id=>$value)
		{
			$ops_cf_stock_ids[] = $value['block_id'];
		}
		foreach($block_ids as $key=>$block_id)
		{
			$block_name  = $this->Common_model->get_value('block',array('block_id'=>$block_id),'name');
			$plants 						   = $this->Plant_ob_m->get_plants($block_id); 
			$plant_block[$block_id]['block_name'] = $block_name;
			$plant_block[$block_id]['plants']     = $plants;
		}
		foreach($ops_cf_stock_ids as $key=>$block_id)
		{
			$block_name  = $this->Common_model->get_value('block',array('block_id'=>$block_id),'name');
			$plants 						   = $this->Plant_ob_m->get_plants($block_id); 
			$lifting_points[$block_id]['block_name'] = $block_name;
			$lifting_points[$block_id]['plants']     = $plants;
		}
		$data['plant_block'] =$plant_block;
		$data['lifting_points'] =$lifting_points;
		//destroying session data(product_data)
        $this->session->unset_userdata('products_data');
		# flag = 1 (Displaying Order Booking First form)
		$data['flag'] 	=	1;
		$this->load->view('plant_ob/plant_ob',$data);
	}

	public function get_plant_pending_obs()
	{
		//return 234;
		$ob_type_id 			= get_regular_type_id();
		$type 				 	= plant_order_type_id();
		$ordered_plant_id 		= $this->input->post('ordered_plant_id',TRUE);
		//$lifting_point_id 		= $this->input->post('lifting_point_id',TRUE);
		if($ordered_plant_id != '')
		{
			# Get Orders based on Order Type, Lifting Point, Ordered Plant, Staus <=2
	        $plant_order_details = $this->Plant_ob_m->get_plant_ob_orders($ordered_plant_id,$ob_type_id,$type);
	        if(count($plant_order_details) != '')
	        {
	            //if($ordered_plant_id != $lifting_point_id)
	            {
	                         
	                foreach($plant_order_details as $key => $value)
	                {
	                    $order_results[$value['order_number']]['order_number']=$value['order_number'];
	                    $order_results[$value['order_number']]['order_id']=$value['order_id'];
	                    $order_results[$value['order_number']]['order_date']=$value['order_date'];
	                    $order_results[$value['order_number']]['ob_lifting_point']=$value['ob_lifting_point'];
	                    $results=$this->Plant_ob_m->get_orderedProducts($value['order_id']);
	                    /*foreach($results as $key => $prow)
	                    {
	                        $product_do_qty = get_ob_product_do_qtuantity($value['order_id'],$prow['product_id']);
	                        $ordered_qty = $prow['ordered_quantity'];
	                        $results[$key]['do_qty']  = $product_do_qty;
	                        $results[$key]['pending_qty']  = ($ordered_qty-$product_do_qty);
	                    }*/
	                    $order_results[$value['order_number']]['ordered_products']=$results;
	                    //echo"<pre>"; print_r($results);             
	                }
	                    echo '<h4>Pending OBs are:</h4>';
	                    //$ordered_products = $this->Distributor_ob_m->get_ordered_product_details($ob_type_id,$distributor_id,$lifting_point_id);
	                    echo '<div class="table-scrollable">';
	                    echo '<table class="table table-bordered table-striped table-hover mytable">';
	                    
	                    foreach($order_results as $order_id => $order_details)   
	                    {
	                        if($order_details['ordered_products'] != '')
	                        {
	                        	$order_date = date('d-m-Y',strtotime($order_details['order_date']));
	                            echo '<thead>';
	                            echo '<th colspan="7">'.'Order Booking No : '.$order_details['ob_lifting_point'].' / '.$order_details['order_number'].' / '.$order_date.'</th>';
	                            echo '</thead>';
	                            echo '<tr style="background-color:#cccfff">';
	                            echo '<td>'.'Product'.'</td>';
	                            echo '<td>'.'Price'.'</td>';
	                            echo '<td>'.'Items Per Carton'.'</td>';
	                            echo '<td>'.'Ordered Quantity'.'</td>';
	                            echo '<td>'.'Pending Quantity'.'</td>';
	                            echo '</tr>';
	                            foreach($order_details['ordered_products'] as $key => $value)
	                            {
	                                $total=0;
	                                $total_price  = $value['unit_price']+$value['add_price'];
	                                $total_value = indian_format_price($total_price*($value['ordered_quantity']*$value['items_per_carton']));
	                                echo '<tbody>';

	                                echo '<tr>';
	                                echo '<td>'.$value['product_name'].'</td>';
	                                echo '<td>'.$total_price.'</td>';
	                                echo '<td>'.$value['items_per_carton'].'</td>';
	                                echo '<td>'.intval($value['ordered_quantity']).'</td>';
	                                echo '<td>'.intval($value['pending_qty']).'</td>';
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
	             echo '<h3 align="center">No Pending OBs</h3>';
	        }			
		}
	}

	public function plant_ob_products()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Order Booking";
		$data['nestedView']['cur_page'] = 'plant_ob';
		$data['nestedView']['parent_page'] = 'plant_ob';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Order Booking';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Order Booking','class'=>'active','url'=>'');

		@$products_data = $_SESSION['products_data'];
		//echo "<pre>"; print_r($products_data);exit;
		# order type id, distributor id,stocklifting id
		$order_plant_id = ($this->input->post('order_plant',TRUE) !='')?$this->input->post('order_plant',TRUE):$products_data['order_plant_id'];
		$lifting_point_id = ($this->input->post('lifting_point',TRUE) != '')?$this->input->post('lifting_point',TRUE):$products_data['lifting_point_id'];
		$block_id = $this->Common_model->get_value('plant_block',array('plant_id'=>$lifting_point_id),'block_id');
		$c_and_f_id = $this->Common_model->get_value('c_and_f',array('plant_id'=>$lifting_point_id),'c_and_f_id');
		
		# Bank Guarante details (C&F)
		$bank_gurantee_details = $this->Plant_ob_m->get_bank_guarantee_details($c_and_f_id);
		$bank_gurantee_amount_details = $this->Common_model->get_data('c_and_f',array('c_and_f_id',$c_and_f_id));
		//print_r($bank_gurantee_amount_details);exit;

		# Fet bg_amount column in array format
		$bg_amount_column = array_column($bank_gurantee_details,'bg_amount');
		$data['total_bg_amount'] = array_sum($bg_amount_column);
		//echo "<pre>"; print_r($bank_gurantee_details);exit;
		if((isset($products_data)&& $products_data['order_plant_id'] != $products_data['lifting_point_id']) || ($order_plant_id != $lifting_point_id))		
		{
			# Get Loose Oil
			$loose_oil = $this->Common_model->get_data('loose_oil',array('status'=>1,'ob_status'=>1),'','rank ASC');
			foreach($loose_oil as $key => $value)
			{
				$product_results[$value['loose_oil_id']]['loose_oil_name']=$value['loose_oil_id'];
	            $product_results[$value['loose_oil_id']]['loose_oil_name']=$value['name'];
	            $results=$this->Plant_ob_m->get_sub_products($value['loose_oil_id']);
	            $product_results[$value['loose_oil_id']]['sub_products']=$results;
			}			
			
			//echo "<pre>";print_r($product_results);exit;
		}
		else
		{
			$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>ERROR!</strong> There is a problem occured while selecting Lifting Point. Please try again.  </div>');
        	redirect(SITE_URL.'plant_ob');
		}
		
		$data['flag'] 	=	2;
		$data['product_results']		=	@$product_results;
		$data['lifting_point_id']  		= 	@$lifting_point_id;
		$data['order_plant_id']    		= 	@$order_plant_id;
		$data['block_id']          		=   @$block_id;
		$data['bank_gurantee_details']  =	@$bank_gurantee_details;
		$data['bank_gurantee_amount_details']  = @$bank_gurantee_amount_details;
		$this->load->view('plant_ob/plant_ob',$data);
	}

	public function confirm_plant_ob_products()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Order Booking";
		$data['nestedView']['cur_page'] = 'plant_ob';
		$data['nestedView']['parent_page'] = 'plant_ob';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Order Booking';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Order Booking','class'=>'active','url'=>'');

		

		# Ordered Plant id,stocklifting id
		$data['plant_id'] = $this->input->post('order_plant_id');
		$data['lifting_point_id'] = $this->input->post('lifting_point_id');

		# Generate order number based on lifting point
		$data['order_number'] = get_plant_ob_number();
		
		//print_r($data['order_number']);exit;
		$data['order_for']  = get_plant($data['plant_id']);
		$data['lifting_point']  = get_plant($data['lifting_point_id']);
		$total_value=$this->input->post('total_value');
		$count_value=[];
		foreach($total_value as $val)
		{
			if($val != '' && $val != 0)
			{
				$count_value = $val;
			}
		}
		//print_r(count($count_value));exit;
		if($this->input->post('submitPlantOB') && count($count_value) != '')
		{
			$product_id=$this->input->post('product_id');
        	$product_name=$this->input->post('product_name');
        	$unit_price=$this->input->post('unit_price');
        	$added_price=$this->input->post('added_price');
        	$items_per_carton=$this->input->post('items_per_carton');
        	$total_amount=$this->input->post('total_amount');
        	$quantity=$this->input->post('quantity');
        	$total_value=$this->input->post('total_value');
        	$grand_total=$this->input->post('grand_total');
        	//echo "<pre>"; print_r($total_value);exit;
        	$product_results = array();
            foreach ($total_value as $key => $value) 
            {
            	if($value != '' && $value!=0)
            	{ 
                	$product_results[$product_id[$key]]=array(
                	'product_name'=> $product_name[$key],	
                    'product_id'=> $product_id[$key],
                    'unit_price' =>  $unit_price[$key],
                    'added_price'=> $added_price[$key],
                    'total_price'=> $total_amount[$key],
                    'quantity'=> $quantity[$key],
                    'items_per_carton'=> $items_per_carton[$key],
                    'total_value'=>$total_value[$key]
                    );                        
            	}
            }
            $_SESSION['products_data'] = $_POST;
        	$data['product_results']  =  @$product_results;
        	# Session Data
        	
        	//echo "<pre>";print_r($unit_price);exit;
		}
		else
		{
			$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>ERROR!</strong> Please select products and raise order.  </div>');
        	$_SESSION['products_data'] = $_POST;
        	redirect(SITE_URL.'plant_ob_products');
		}
		
		$this->load->view('plant_ob/confirm_plant_ob_products',$data);
	}

	public function insert_plant_ob_products()
	{
		$ordered_plant_id = $this->input->post('ordered_plant_id');
		$lifting_point_id = $this->input->post('lifting_point_id');
		$ob_type_id = get_regular_type_id();
		$order_number = get_plant_ob_number();
		//print_r($order_number);exit;
		$lifting_point_name = $this->input->post('lifting_point_name');				
		$unit_price = $this->input->post('unit_price');
		$quantity = $this->input->post('quantity');
		$product_id = $this->input->post('product_id');
		$added_price = $this->input->post('added_price');
		$items_per_carton = $this->input->post('items_per_carton');

		//echo "<pre>"; print_r($ordered_plant_id);exit;
		$plant_order_data = array(											
									'lifting_point' =>	$lifting_point_id,
									'order_number' 	=>	$order_number,
									'order_date' 	=>	date('Y-m-d'),
									'created_by' 	=>	$this->session->userdata('user_id'),
									'created_time' 	=>	date('Y-m-d'),
									'ob_type_id' 	=>	$ob_type_id,
									'type'			=>	2,
									'status' 		=>	1
										);
		//Transaction begins here
		$this->db->trans_begin();
		// Inserting order details
		$order_id = $this->Common_model->insert_data('order',$plant_order_data);	
		// Insert order distributor details
		$data2 = array(
						'plant_id' 			=> $ordered_plant_id,
						'order_id'			=> $order_id,
						'status'			=> 1);
		$this->Common_model->insert_data('plant_order',$data2);

		//Inserting order product details
		foreach($unit_price as $key => $value)
		{
			if($value != '')
            { 					 
	        	$results =array(
					        	
					            'product_id'	=> 	$product_id[$key],
					            'unit_price'    =>  $unit_price[$key],
					            'add_price'     =>  $added_price[$key],
					            'quantity'      =>  $quantity[$key],
					            'pending_qty'	=> $quantity[$key],	
					            'items_per_carton'=>$items_per_carton[$key],
					            'order_id' 		=>	$order_id,
					            'status' 		=>	1

					            ); 
	            $order_product_id = $this->Common_model->insert_data('order_product',$results);
	            # ob_products for mail

	            $ob_products[] = $results;
            }                 
          	      	
		}

		/*$email = plants_OB_mail($ordered_plant_id,$ob_products,$order_number);
		echo "<pre>"; print_r($email);exit;*/

		if($this->db->trans_status()===FALSE)
	    {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong> There is a problem occured while generating order. Please try again. </div>');  
	    }
	    else
	    {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong>Order has been Placed successfully with Order Booking Number: '.$order_number.'  </div>');
	    }
        redirect(SITE_URL.'plant_ob');

	}


	# 5th March 2017,11:57 PM
	# Order Booking List 
	public function plant_ob_list()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Unit O.B. List";
		$data['nestedView']['pageTitle'] = 'Unit O.B. List';
		$data['nestedView']['cur_page'] = 'plant_ob_r';
		$data['nestedView']['parent_page'] = 'reports';
		$data['nestedView']['list_page'] = 'ob_reports';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Unit O.B. List','class'=>'active','url'=>'');
		$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';
		
		# Get Blocks(C & F and Stock Point) 
		$blocks = $this->Plant_ob_m->get_blocks();
		$ops_cf_stock_blocks = $this->Plant_ob_m->ops_cf_stock_blocks();
		
		# Get Product_id array
		$block_ids = array_column($blocks,'block_id');

		# Get ops and c&f stock ids array
		$ops_cf_stock_ids = array_column($ops_cf_stock_blocks,'block_id');

		/*foreach($ops_cf_stock_blocks as $block_id=>$value)
		{
			$ops_cf_stock_ids[] = $value['block_id'];
		}*/
		# Order For
		foreach($block_ids as $key=>$block_id)
		{
			$block_name  = $this->Common_model->get_value('block',array('block_id'=>$block_id),'name');
			$plants = $this->Plant_ob_m->get_plants($block_id); 
			$plant_block[$block_id]['block_name'] = $block_name;
			$plant_block[$block_id]['plants']     = $plants;
		}

		# Data array for Lifting Point
		foreach($ops_cf_stock_ids as $key=>$block_id)
		{
			$block_name  = $this->Common_model->get_value('block',array('block_id'=>$block_id),'name');
			$plants 						   = $this->Plant_ob_m->get_plants($block_id); 
			$lifting_points[$block_id]['block_name'] = $block_name;
			$lifting_points[$block_id]['plants']     = $plants;
		}
		$data['plant_block'] =$plant_block;
		$data['lifting_points'] =$lifting_points;

		# Search Functionality
        $search_plant_ob=$this->input->post('search_plant_ob', TRUE);
        if($search_plant_ob!='') 
        {
        	$from_date=(($this->input->post('fromDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('fromDate', TRUE))):''; 
        	$to_date=(($this->input->post('toDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('toDate', TRUE))):'';

            $search_params=array(
            						'ob_number'           => $this->input->post('ob_number', TRUE),
                					'order_for'           => $this->input->post('order_for', TRUE),
                					'lifting_point_id'    => $this->input->post('lifting_point_id', TRUE),
	                				'fromDate'            => $from_date,
	                				'toDate'              => $to_date,
	                				'status'	      => $this->input->post('status',TRUE)          
                                );
            $this->session->set_userdata($search_params);

        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                					'ob_number'     	   => $this->session->userdata('ob_number'),
                   					'order_for'     	   => $this->session->userdata('order_for'),
                   					'lifting_point_id'         => $this->session->userdata('lifting_point_id'),
                   					'fromDate'         	   => $this->session->userdata('fromDate'),
                   					'toDate'        	   => $this->session->userdata('toDate'),
                   					'status'	           => $this->session->userdata('status')
                    				);
            }
            else {
                $search_params=array(
                				'ob_number'            => '',                     			
                     				'order_for'            => '',
                     				'lifting_point_id'     => '',
                     				'fromDate'             => '',
                     				'toDate'               => '',
                     				'status'			   => 1 // Default pending OB's will display                   
                                    );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'plant_ob_list/';
        # Total Records
        $config['total_rows'] = $this->Plant_ob_m->plant_ob_num_rows($search_params);

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
        $data['ob_results'] = $this->Plant_ob_m->plant_ob_results($current_offset, $config['per_page'], $search_params);
        
        # Additional data
        $data['display_results'] = 1;
        $data['distributor_type'] = $this->Common_model->get_data('ob_type',array('status'=>1));

		$this->load->view('plant_ob/plant_ob_list',$data);
	}

	# 6th March 2017,1:20 AM
	# Order Booking View Products 
	public function view_plant_ob_products()
	{
		$order_id 	=	cmm_decode($this->uri->segment(2));
		$order_number  =  cmm_decode($this->uri->segment(3));
		if($order_id =='' || $order_number == '')
		{
			redirect(SITE_URL.'plant_ob_list'); exit();
		}

		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "View Plant Products";
		$data['nestedView']['cur_page'] = 'view_plant_ob_products';
		$data['nestedView']['parent_page'] = 'plant_ob';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'View Plant Products';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'View Plant Products','class'=>'active','url'=>'');
		$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';
		
		
		$data['order_id'] = $order_id;
		$data['order_number'] = $order_number;
		$data['order_details']  = $this->Plant_ob_m->get_order_details($order_id);

		# Get Order Date
		$data['order_date'] = $this->Common_model->get_value('order',array('order_number'=>$data['order_number']),'order_date');
		# Get Ordered Details based on Order Number
		$data['orderd_product_details']  = $this->Plant_ob_m->get_plant_ob_products($order_id);

		# Fet bg_amount column in array format
		$total_price_column = array_column($data['orderd_product_details'],'total_price');
		$data['grand_total'] = array_sum($total_price_column);
		//echo "<pre>"; print_r($data['orderd_product_details']);

		//print_r($data['order_details']);exit;

		$this->load->view('plant_ob/view_plant_ob_products',$data);
	}

	# Print OB Products 
    # Print OB Products 
    public function print_plant_ob_products()
    {
    	if($this->uri->segment(2) !='' && $this->uri->segment(3) !='')	
    	{
       		# Get Order Id
        	$order_id  =  cmm_decode($this->uri->segment(2));
	        # Get Order Number
			$data['order_number']   =  cmm_decode($this->uri->segment(3));
			//page redirection 
			$data['cancel_type']=1;
		}
        else
        {
        	$order_no = $this->input->post('order_number');
        	//checking whether order id exists or not
        	$res=$this->Plant_ob_m->get_order_id_count($order_no);
        	$count=$res[1];
        	if($count >0)
        	{
        		$order_results=$res[0];
        		$order_id=$order_results['order_id'];
        		$data['order_number']=$order_results['order_number'];
        		$data['cancel_type']=2;
        	}
        	else
        	{
        		$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong>Incorrect Order Booking Number!
                             </div>');

                redirect(SITE_URL.'single_plant_ob_list');exit;
        	}
           
        }
        $data['order_details']  = $this->Plant_ob_m->get_order_details($order_id);
		# Get Order Date
		$data['order_date'] = $this->Common_model->get_value('order',array('order_number'=>$data['order_number']),'order_date');
		# Get Ordered Details based on Order Number
		$data['orderd_product_details']  = $this->Plant_ob_m->get_plant_ob_products($order_id);

		# Fet bg_amount column in array format
		$total_price_column = array_column($data['orderd_product_details'],'total_price');
		$data['grand_total'] = array_sum($total_price_column);

	    $this->load->view('plant_ob/print_plant_ob_products',$data);
            
       
    }

    # Download ob list
    public function download_plant_ob()
    {
        if($this->input->post('download_ob')!='') {
            
           $search_params=array(
            						'ob_number'     	  => $this->input->post('ob_number', TRUE),
                					'order_for'     	  => $this->input->post('order_plant', TRUE),
                					'lifting_point_id'    => $this->input->post('lifting_point_id', TRUE),
	                				'fromDate'            => $this->input->post('fromDate', TRUE),
	                				'toDate'              => $this->input->post('toDate', TRUE) ,
	                				'ob_type_id'		  => $this->input->post('ob_type_id',TRUE),
	                				'status'			  => $this->input->post('status',TRUE)           
                                );  
            $plant_ob = $this->Plant_ob_m->plant_ob_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Order Number','Order Date','Order For','Lifting Point','ob Type','status');
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
            if(count($plant_ob)>0)
            {
                
                foreach($plant_ob as $row)
                {
                	 if($row['order_status']<=2) { $status = "Pending"; }
                                                else { $status = "completed";}
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['order_number'].'</td>';
                    $data.='<td align="center">'.date('d-m-Y',strtotime($row['order_date'])).'</td>';
                    $data.='<td align="center">'.$row['plant_name'].'</td>';
                    $data.='<td align="center">'.$row['lifting_point_name'].'</td>';    
                    $data.='<td align="center">'.$row['ob_type_name'].'</td>'; 
                    $data.='<td align="center">'.$status.'</td>';                 
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
            $xlFile='plant_Ob_list'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }

    # Print Distributor OB List
    public function print_unit_ob_list()
    {
        if($this->input->post('print_ob_list')!='') {
            
            $from_date=(($this->input->post('fromDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('fromDate', TRUE))):''; 
        	$to_date=(($this->input->post('toDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('toDate', TRUE))):'';

            $search_params=array(
            						'ob_number'     	  => $this->input->post('ob_number', TRUE),
                					'order_for'     	  => $this->input->post('order_for', TRUE),
                					'lifting_point_id'    => $this->input->post('lifting_point_id', TRUE),
	                				'fromDate'            => $from_date,
	                				'toDate'              => $to_date,
	                				'status'			  => $this->input->post('status',TRUE)          
                                );
            $data['search_data'] = $search_params;
            $data['ob_results'] = $this->Plant_ob_m->plant_ob_details($search_params);
            $this->load->view('plant_ob/print_unit_ob_list',$data);
            
        }
    }
}