<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

/*
	Created By 		:	Priyanka
	Date 			:	21st Feb 2017 11 AM
	Module 			:	Order Booking for Distributor 
*/
class Distributor_ob extends Base_controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->model("Distributor_ob_m");
	}

	public function distributor_ob()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Order Booking";
		$data['nestedView']['cur_page'] = 'distributor_ob';
		$data['nestedView']['parent_page'] = 'order_booking';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Distributor Order Booking';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Distributor Order Booking','class'=>'active','url'=>'');
		$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

		# Get Distributor Type Details
		$data['distributor_type'] = $this->Common_model->get_data('ob_type',array('status'=>1));
		//echo "<pre>"; print_r($data['distributor_type']);exit;

		# flag = 1 (Displaying Order Booking First form)
		$data['flag'] 	=	1;
		$data['welfare_schemes'] = $this->Distributor_ob_m->get_welfare_schemes();


		//print_r($data['welfare_schemes']);exit;

		$this->load->view('distributor_ob/distributor_ob',$data);
	}

	# Get Distibutor Pending Orders
	public function get_distributor_orders()
	{

		$ob_type_id 		= $this->input->post('ob_type_id',TRUE);
		$distributor_id 	= $this->input->post('distributor_id',TRUE);
		//$lifting_point_id 	= $this->input->post('lifting_point_id',TRUE);
		if($ob_type_id != '' && $distributor_id != '')
		{
			/*$order_id_data = $this->Distributor_ob_m->get_order_ids($ob_type_id,$distributor_id,$lifting_point_id);
			$order_id_arr  =  array_column($order_id_data,'order_id');*/
			# Get Orders based on Order Type, Distributor ID, Lifting Point
            $distributor_order_details = $this->Distributor_ob_m->get_distributor_orders($distributor_id,$ob_type_id);
            if(count($distributor_order_details) != '')
            {
               
               //echo"<pre>"; print_r($distributor_order);exit;
                $order_results = array();
                foreach($distributor_order_details as $key => $value)
                {
                    $order_results[$value['order_number']]['order_number']=$value['order_number'];
                    $order_results[$value['order_number']]['order_id']=$value['order_id'];
                    $order_results[$value['order_number']]['order_date']=$value['order_date'];
                    $order_results[$value['order_number']]['ob_lifting_point']=$value['ob_lifting_point'];
                    $results=$this->Distributor_ob_m->get_orderedProducts($value['order_id']);
                    foreach($results as $key => $prow)
                    {
                        $product_do_qty = get_ob_product_do_qty($value['order_id'],$prow['product_id']);
                        $ordered_qty = $prow['ordered_quantity'];
                        $results[$key]['do_qty']  = $product_do_qty;
                        $results[$key]['pending_qty']  = ($ordered_qty-$product_do_qty);
                    }
                    $order_results[$value['order_number']]['ordered_products']=$results;
                    //echo '<pre>';print_r($results);exit;
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
                            echo '<td>'.$value['pending_qty'].'</td>';
                            echo '</tr>';
                            echo '</tbody>';
                        }
                    }                   
                }
                echo "</table";
                echo '</div>';
            }
			else
			{
				echo '<h3 align="center">No Pending OBs</h3>';	
			}
		}

	}

	public function getDistributors()
	{
		$ob_type_id = $this->input->post('ob_type_id',TRUE);
		//Get the distributor type id by ob type id
		$distributor_type_id = $this->Common_model->get_value('ob_type',array('ob_type_id'=>$ob_type_id),'distributor_type_id');
    	echo $this->Distributor_ob_m->getDistributorList($distributor_type_id);
	}
	public function getStockLiftingUnit()
	{
		$distributor_id = $this->input->post('distributor_id',TRUE);
		
    	echo $this->Distributor_ob_m->getStockLiftingUnitList($distributor_id);
	}

	public function distributor_ob_products()
	{
		# order type id, distributor id,stocklifting id
		$order_type_id = $this->input->post('order_type');
		$stock_lifting_unit_id = $this->input->post('stock_lifting_unit_id');
		$distributor_id = $this->input->post('distributor_id');
		if($order_type_id =='' || $stock_lifting_unit_id == '' || $distributor_id == '')
		{
			redirect(SITE_URL.'distributor_ob'); exit();
		}
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Order Booking - Products";
		$data['nestedView']['cur_page'] = 'distributor_ob';
		$data['nestedView']['parent_page'] = 'order_booking';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Order Booking - Products';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Order Booking - Products','class'=>'active','url'=>'');
		$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';
		$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/distributor_order_booking.js"></script>';


		

		$data['order_type'] = $this->Common_model->get_value('ob_type', array('ob_type_id'=>$order_type_id), 'name');
		
		# Plant(Stock Lifting Unit)		
		$data['lifting_point_name'] = $this->Common_model->get_value('plant', array('plant_id'=>$stock_lifting_unit_id), 'name');
		$commission = $this->input->post('commission');
		$welfare_scheme = $this->input->post('welfare_scheme');
		$params = array(
						'stock_lifting_unit_id'	=> $stock_lifting_unit_id,
						'commission'			=> @$commission,
						'welfare_scheme'		=> @$welfare_scheme
						);
		$data['unit_price'] 	=	$this->Distributor_ob_m->get_unitPrice($order_type_id,$params);
		//echo '<pre>';print_r($data['unit_price']); exit;
		$mrp_price_type_id = getMRPpriceType();
		$data['mrp_price'] 	=	$this->Distributor_ob_m->get_MRPprice($mrp_price_type_id,$stock_lifting_unit_id);
		//print_r($data['mrp_price']); echo $this->db->last_query(); exit;
		# Get Distributor and Bank Guarantee Details
		$data['distributor_details'] = $this->Common_model->get_data('distributor',array('distributor_id'=>$distributor_id));
		$data['bank_guarantee_details'] = $this->Distributor_ob_m->get_bank_guarantee_details($distributor_id);

		# Fet bg_amount column in array format
		/*$bg_amount_column = array_column($data['bank_guarantee_details'],'bg_amount');
		$data['total_bg_amount'] = array_sum($bg_amount_column);*/
		$data['total_bg_amount'] = $this->Distributor_ob_m->get_total_bg_amount($distributor_id);
		$data['available_amount']    = $data['total_bg_amount'] + $data['distributor_details'][0]['sd_amount'] + $data['distributor_details'][0]['outstanding_amount'] ;

		# Get Loose Oil
		$loose_oil = $this->Common_model->get_data('loose_oil',array('status'=>1,'ob_status'=>1),'','rank ASC');
		foreach($loose_oil as $key => $value)
		{
			$product_results[$value['loose_oil_id']]['loose_oil_name']=$value['loose_oil_id'];
            $product_results[$value['loose_oil_id']]['product_name']=$value['name'];
            
             $results=$this->Distributor_ob_m->get_sub_products($value['loose_oil_id']);
            $product_results[$value['loose_oil_id']]['sub_products']=$results;
		}
	//echo "<pre>"; print_r($product_results);exit;

		# flag = 1 (Displaying Order Booking First form)
		$data['flag'] 	=	2;
		$data['product_results']=@$product_results;
		$data['stock_lifting_unit_id']=$stock_lifting_unit_id; 
		$data['order_type_id']=$order_type_id; 
		$this->load->view('distributor_ob/distributor_ob',$data);
	}

	public function view_distributor_ob_products()
	{
		$data['distributor_id']=$this->input->post('distributor_id');
		$data['stock_lifting_unit_id']=$this->input->post('stock_lifting_unit_id');
		$data['ob_type_id']=$this->input->post('ob_type_id');	
		if($data['distributor_id']=='' || $data['stock_lifting_unit_id']=='' || $data['ob_type_id']=='')
		{
			redirect(SITE_URL.'distributor_ob'); exit();
		}
		if(check_distributor_bg_expired($data['distributor_id']))
		{
			$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	            <strong>Error!</strong> You can\'t generate order booking. Distributor Bank Guarantee has been expired. Please renewal Bank Gurantee to enable Order booking. </div>');
			redirect(SITE_URL.'distributor_ob'); exit();
		}
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "View Products Details";
		$data['nestedView']['cur_page'] = 'distributor_ob';
		$data['nestedView']['parent_page'] = 'order_booking';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'View Products Details';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'View Products Details','class'=>'active','url'=>'');
		$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';
		if($this->input->post('submitOB'))
        {	
        	$grand_total=$this->input->post('grand_total');

        	if($grand_total == 0)
        	{
        		$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	            <strong>Error!</strong> No Products are selected . Please Raise Order. </div>');
        		redirect(SITE_URL.'distributor_ob');exit;
        	}    

        	$data['distributor_id']=$this->input->post('distributor_id');
        	$data['distributor_code']=$this->input->post('distributor_code');
        	$data['distributor_address']=$this->input->post('distributor_address');
        	$data['lifting_point_name']=$this->input->post('lifting_point_name');
        	$data['ob_type']=$this->input->post('ob_type');
        	$data['stock_lifting_unit_id']=$this->input->post('stock_lifting_unit_id');
        	$items_per_carton=$this->input->post('items_per_carton');
        	$data['ob_type_id']=$this->input->post('ob_type_id');	
        	$loose_oil_id=$this->input->post('loose_oil_id');
        	$loose_oil_name=$this->input->post('loose_oil_name');
        	$data['agency_name']=$this->input->post('agency_name');
        	$product_id=$this->input->post('product_id');
        	$product_name=$this->input->post('product_name');
        	$unit_price=$this->input->post('unit_price');
        	$added_price=$this->input->post('added_price');
        	$total_amount=$this->input->post('total_amount');
        	$quantity=$this->input->post('quantity');
        	$total_value=$this->input->post('total_value');
        	//print_r($data['ob_type_id']);exit;

        	 //forming array to view page for confirmation for Order Booking
                $product_results = array();
                foreach ($total_value as $key => $value) 
                {
                	if($value != '' && $value !=0)
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
        	
                //echo "<pre>";print_r($total_value);exit;
        }

		# flag = 1 (View Order Booking Products Details)
		$data['flag'] 	=	1;
		$data['product_results']=$product_results;
		//$data['product_results']=$product_results; 
		$this->load->view('distributor_ob/view_distributor_ob_products',$data);
	}

	public function insert_distributor_ob_products()
	{

		$distributor_id = $this->input->post('distributor_id');

		$order_number = get_distributor_ob_number();
		$distributor_order_data = array(
											
											'lifting_point' 	=>	$this->input->post('lifting_point'),
											'order_number' 	=>	$order_number,
											'order_date' 	=>	date('Y-m-d'),
											'created_by' 	=>	$this->session->userdata('user_id'),
											'created_time' 	=>	date('Y-m-d H:i:s'),
											'ob_type_id' 	=>	$this->input->post('ob_type_id'),
											'type'			=>	1,
											'status' 		=>	1
										);
		//Transaction begins here
		$this->db->trans_begin();
		// Inserting order details
		$order_id = $this->Common_model->insert_data('order',$distributor_order_data);	
		// Insert order distributor details
		$data2 = array(
						'distributor_id' 	=> $distributor_id,
						'order_id'			=> $order_id,
						'status'			=> 1);
		$this->Common_model->insert_data('distributor_order',$data2);
		
		
		$distributor_name = $this->input->post('distributor_name');		
		$lifting_point_name = $this->input->post('lifting_point_name');				
		$unit_price = $this->input->post('unit_price');
		$quantity = $this->input->post('quantity');
		$product_id = $this->input->post('product_id');
		$added_price = $this->input->post('added_price');
		$quantity = $this->input->post('quantity');
		$items_per_carton = $this->input->post('items_per_carton');

		//Inserting order product details
		foreach($unit_price as $key => $value)
		{
			if($value != '')
            { 
					 
	        	$results =array(
					        	
					            'product_id'		=> $product_id[$key],
					            'unit_price' 		=>  $unit_price[$key],
					            'add_price'			=> $added_price[$key],
					            'quantity'			=> $quantity[$key],	
					            'pending_qty'		=> $quantity[$key],	
					            'items_per_carton'	=> $items_per_carton[$key],
					            'order_id' 			=>	$order_id,
					            'status' 			=>	1,
					            'created_by'		=> $this->session->userdata('user_id'),
					            'created_time'		=> date('Y-m-d H:i:s')

					            );
			    $products[] = $results; 
	            $order_product_id = $this->Common_model->insert_data('order_product',$results);
            }                 
          	      	
		}
		/*$email = distributor_OB_mail($distributor_id,$products,$order_number);
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
        redirect(SITE_URL.'distributor_ob');

	}

	# Distributor OB  List
	public function distributor_ob_list()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['pageTitle'] = 'Distributor O.B. List';
		$data['nestedView']['heading'] = "Distributor O.B. List";
		$data['nestedView']['cur_page'] = 'distributor_ob_r';
		$data['nestedView']['parent_page'] = 'reports';
		$data['nestedView']['list_page'] = 'ob_reports';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Distributor O.B. List','class'=>'active','url'=>'');
		$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

		# Get OB Type Details
		$data['distributor_type'] = $this->Common_model->get_data('ob_type',array('status'=>1));
		$data['lifting_point'] = $this->Distributor_ob_m->get_lifting_point_list();
		$data['executive_list'] = $this->Common_model->get_data('executive','');
		$data['distributor_list'] = $this->Common_model->get_data('distributor','','','CAST(distributor_code AS unsigned) ASC');
		//echo "<pre>"; print_r($data['distributor_type']);exit;

		# Search Functionality
        $ob_search=$this->input->post('search_ob', TRUE);
        if($ob_search!='') 
        {
        	 $from_date=(($this->input->post('fromDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('fromDate', TRUE))):''; 
        	  $to_date=(($this->input->post('toDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('toDate', TRUE))):''; 

            $search_params=array(
            					    'ob_number'   		  => $this->input->post('ob_number',TRUE),
                					'order_type_id'       => $this->input->post('order_type_id', TRUE),
                					'distributor_id'      => $this->input->post('distributor_id', TRUE),
                					'lifting_point_id'    => $this->input->post('lifting_point_id', TRUE),
                					'executive_id'        => $this->input->post('executive_id', TRUE),
                					'status'              => $this->input->post('status', TRUE),
	                				'fromDate'            => $from_date,
	                				'toDate'              => $to_date           
                                );
            $this->session->set_userdata($search_params);

        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                					'ob_number'			   => $this->session->userdata('ob_number'),
                   					'order_type_id'        => $this->session->userdata('order_type_id'),
                   					'distributor_id'       => $this->session->userdata('distributor_id'),
                   					'lifting_point_id'     => $this->session->userdata('lifting_point_id'),
                   					'fromDate'         	   => $this->session->userdata('fromDate'),
                   					'toDate'        	   => $this->session->userdata('toDate'),
                   					'executive_id'         => $this->session->userdata('executive_id'),
                   					'status'        	   => $this->session->userdata('status'),
                    
                                    );
            }
            else {
                $search_params=array(
                					'ob_number'			   => '',
                     				'order_type_id'        => '',
                     				'distributor_id'       => '',
                     				'lifting_point_id'     => '',
                     				'fromDate'             => '',
                     				'toDate'               => '',
                     				'executive_id'		   => '',
                     				'status'               => 1 // Default pending OBs will display                    
                                    );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'distributor_ob_list/';
        # Total Records
        $config['total_rows'] = $this->Distributor_ob_m->distributor_ob_num_rows($search_params);

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
        $data['ob_results'] = $this->Distributor_ob_m->distributor_ob_results($current_offset, $config['per_page'], $search_params);
        
        # Additional data
        $data['display_results'] = 1;
		$this->load->view('distributor_ob/distributor_ob_list',$data);
	}

	# View Distributor OB Products Details
	public function view_distributor_ob()
	{
		$order_id   =  cmm_decode($this->uri->segment(2));
		if($order_id == '')
		{
			redirect(SITE_URL.'distributor_ob_list'); exit();
		}
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['pageTitle'] = 'Distributor O.B. List';
		$data['nestedView']['heading'] = "Distributor O.B. List";
		$data['nestedView']['cur_page'] = 'distributor_ob_r';
		$data['nestedView']['parent_page'] = 'reports';
		$data['nestedView']['list_page'] = 'ob_reports';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Distributor Order Booking','class'=>'active','url'=>'');
		$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

		# Get Distributor Type Details
		$data['distributor_type'] = $this->Common_model->get_data('ob_type',array('status'=>1));
		//echo "<pre>"; print_r($data['distributor_type']);exit;

		# Get Order id
		$data['order_details']  = $this->Distributor_ob_m->get_order_details($order_id);
		//print_r($data['order_details']);exit;
		# Get Order Number
		$data['order_number']   =  cmm_decode($this->uri->segment(3));

		# Get Order Date
		$data['order_date'] = $this->Common_model->get_value('order',array('order_number'=>$data['order_number']),'order_date');
		# Get Ordered Details based on Order Number
		$data['orderd_product_details']  = $this->Distributor_ob_m->get_distributor_ob_products($order_id);

		# Fet bg_amount column in array format
		$total_price_column = array_column($data['orderd_product_details'],'total_price');
		$data['grand_total'] = array_sum($total_price_column);
		//echo "<pre>"; print_r($data['orderd_product_details']);

		# flag = 1 (Displaying Order Booking First form)
		$data['flag'] 	=	1;
		$data['order_id'] = $order_id;
		$this->load->view('distributor_ob/view_distributor_ob',$data);
	}

	# Download OB List
    public function download_ob_list()
    {
        if($this->input->post('download_ob')!='') {
            $search_params=array(
            						'ob_number'			  => $this->input->post('ob_number', TRUE),
                                    'order_type_id'       => $this->input->post('order_type_id', TRUE),
                                    'distributor_id'      => $this->input->post('distributor_id', TRUE),
                                    'lifting_point_id'    => $this->input->post('lifting_point_id', TRUE),
                                    'fromDate'            => $this->input->post('fromDate', TRUE),
                                    'toDate'              => $this->input->post('toDate', TRUE),
                                    'executive_id'		  => $this->input->post('executive_id', TRUE),
                     				'status'              => 1 // Default pending OBs will display            
                                );
            $ob_list = $this->Distributor_ob_m->download_ob_list($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Order Number','order Date','Order Type','Distributor','Lifting Point');
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
            if(count($ob_list)>0)
            {
                
                foreach($ob_list as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['order_number'].'</td>';                   
                    $data.='<td align="center">'.$row['order_date'].'</td>';
                    $data.='<td align="center">'.$row['ob_type'].'</td>';                   
                    $data.='<td align="center">'.$row['distributor_name'].'</td>';                   
                    $data.='<td align="center">'.$row['lifting_point'].'</td>';                  
                    
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
            $xlFile='OBlist'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }

    # Print OB Products 
      # Print OB Products 
    public function print_distributor_ob_products()
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
        	$res=$this->Distributor_ob_m->get_order_id_count($order_no);
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

                redirect(SITE_URL.'single_do_ob_list');exit;
        	}
           
        }
        $data['order_details']  = $this->Distributor_ob_m->get_order_details($order_id);
		//print_r($data['order_details']);exit;
		# Get Order Number
		$data['order_number']   =  cmm_decode($this->uri->segment(3));

		# Get Order Date
		$data['order_date'] = $this->Common_model->get_value('order',array('order_number'=>$data['order_number']),'order_date');
		# Get Ordered Details based on Order Number
		$data['orderd_product_details']  = $this->Distributor_ob_m->get_distributor_ob_products($order_id);

		# Fet bg_amount column in array format
		$total_price_column = array_column($data['orderd_product_details'],'total_price');
		$data['grand_total'] = array_sum($total_price_column);
		//echo "<pre>"; print_r($data['orderd_product_details']);

		$data['order_id'] = $order_id;

        $this->load->view('distributor_ob/print_distributor_ob_products',$data);
        
    }

    # Print Distributor OB List
    public function print_distributor_ob_list()
    {
        if($this->input->post('print_ob')!='') {
            
            $search_params=array(
            						'ob_number'			  => $this->input->post('ob_number', TRUE),
                                    'order_type_id'       => $this->input->post('order_type_id', TRUE),
                                    'distributor_id'      => $this->input->post('distributor_id', TRUE),
                                    'lifting_point_id'    => $this->input->post('lifting_point_id', TRUE),
                                    'fromDate'            => $this->input->post('fromDate', TRUE),
                                    'toDate'              => $this->input->post('toDate', TRUE),
                                    'executive_id'		  => $this->input->post('executive_id', TRUE),
                     				'status'              => $this->input->post('status',TRUE)
                                );
                                
                                $data['search_data'] = $search_params;
            $data['ob_results'] = $this->Distributor_ob_m->download_ob_list($search_params);
            $this->load->view('distributor_ob/print_distributor_ob_list',$data);
            
        }
    }

}