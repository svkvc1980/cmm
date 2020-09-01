<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

    # Created By      :   Priyanka
    # Date            :   1st March 2017 11:16 AM
    # Module          :   Stock Receiving Note for C & F and Stock Point

class Stock_receiving extends Base_controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Stock_receiving_m");
    }

    public function stock_receiving()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']		=	"Stock Receiving";
        $data['nestedView']['pageTitle'] 	=	'Stock Receiving';
        $data['nestedView']['cur_page']		=   'stock_receiving';
        $data['nestedView']['parent_page']  =   'stock_transfer';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Stock Receiving', 'class' => 'active', 'url' => 'bank');

        $data['flag'] = 1;

        $this->load->view('stock_receiving/stock_receiving',$data);
    }

    public function stock_rec_invoice_products()
    {
        # Invoice Num Array     
        $invoice_num_arr    =   $this->input->post('invoice_no',TRUE);
        $invoice_id_arr =   $this->Stock_receiving_m->get_invoice_ids($invoice_num_arr);        
        //echo "<pre>"; print_r($invoice_id_arr);exit;

    	# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Stock Receiving ";
        $data['nestedView']['pageTitle'] = 'Stock Receiving';
        $data['nestedView']['cur_page']     =   'stock_receiving';
        $data['nestedView']['parent_page']  =   'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Stock Receiving', 'class' => 'active', 'url' => '');

        
    	$plant_id = $this->session->userdata('ses_plant_id'); // C & F or Stock Point

    		if(count($invoice_id_arr) != '')
    		{
    			# Get Invoice Products,Free Gifts , Free Products based on Invoice Ids
	    		foreach($invoice_id_arr as $key => $value)
	    		{   
	    			$invoice_id =  	$value['invoice_id'];
	    			$invoice_number =  	$value['invoice_number'];		
	    			$invoice_scheme_id_arr = $this->Common_model->get_data('invoice_scheme',array('invoice_id'=>$invoice_id));
	    			//echo "<pre>";print_r($invoice_id_arr);exit;
	    			foreach($invoice_scheme_id_arr as $key => $value)
	    			{
	    				$invoice_scheme_id[] = $value['invoice_scheme_id'];    				  				
	    			}

	    			# Invoice Number
	    			$invoice_product_results[$invoice_id]['invoice_num']		 =	@$invoice_number;
	    			# All Products
	    			$all_product_results    						 			 =	$this->Stock_receiving_m->get_all_products(@$invoice_id);
                    //print_r($all_product_results); exit();
	    			$invoice_product_results[$invoice_id]['all_products']        =	$all_product_results;

	    			# Free Gifts Products
					$free_gift_results = $this->Stock_receiving_m->get_free_gifts(@$invoice_scheme_id,@$value['invoice_id']);
	    			$invoice_product_results[$invoice_id]['free_gifts']          =	$free_gift_results;

	    			# Free Products
	    			$free_product_results = $this->Stock_receiving_m->get_free_products(@$invoice_scheme_id,@$value['invoice_id']);
	    			$invoice_product_results[$invoice_id]['free_products']       =	$free_product_results;

                    #packing material
                    $pm_results = $this->Stock_receiving_m->get_packing_material($value['invoice_id']);
                    $invoice_product_results[$invoice_id]['packing_material'] =  $pm_results;
	    		}  

	    		//echo "<pre>"; print_r($invoice_product_results);exit;  
	    		$data['invoice_product_free_items_results']	=	$invoice_product_results;
    		}
    		else
    		{
    			$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                  <strong>ERROR!</strong> Invoice Number is invalid ! </div>');
        		redirect(SITE_URL.'stock_receiving'); 
    		}
    				
       //echo "<pre>"; print_r($invoice_product_results);exit;
        $data['flag'] = 2;
        $this->load->view('stock_receiving/stock_receiving',$data);
    }

    # Confirm Page
    public function confirm_products_free_gifts()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Confirm Stock Receiving ";
        $data['nestedView']['pageTitle'] = 'Stock Receiving';
        $data['nestedView']['cur_page']     =   'stock_receiving';
        $data['nestedView']['parent_page']  =   'Logistics';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Stock Receiving Products', 'class' => 'active', 'url' => 'stock_rec_invoice_products');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Confirm Stock Receiving', 'class' => 'active', 'url' => '');

        # Invoices
        $invoice_arr = $this->input->post('invoice_id',TRUE);
        $invoice_number_arr = $this->input->post('invoice_number',TRUE);
        $invoice_do_product_ids = $this->input->post('invoice_do_product_ids',TRUE);
        $data['invoice_number'] = $invoice_number_arr;
        # invoice product qtys
        $product_invoice_qty  = $this->input->post('product_invoice_qty',TRUE);
        //print_r($product_invoice_qty); exit();
        $product_received_qty = $this->input->post('product_received_qty',TRUE); 
        $invoice_product_ids  = $this->input->post('invoice_product_ids',TRUE);
        $items_per_carton_arr = $this->input->post('items_per_carton_arr',TRUE);
        $invoice_product_shortage     = $this->input->post('invoice_product_shortage',TRUE);
        //echo "<pre>"; print_r($_POST);exit;

        # invoice free product qtys
        $free_product_invoice_qty = $this->input->post('free_product_invoice_qty',TRUE);
        $free_product_received_qty = $this->input->post('free_product_received_qty',TRUE);
        $free_product_fg_scheme_id = $this->input->post('free_product_fg_scheme_id',TRUE);
        $free_product_ids          = $this->input->post('free_product_ids',TRUE);
        $free_product_items_per_carton = $this->input->post('free_product_items_per_carton',TRUE);
        $shortage     = $this->input->post('shortage',TRUE);

        # invoice free gift qtys   
        $free_gift_invoice_qty = $this->input->post('free_gift_invoice_qty',TRUE);  
        $free_gift_received_qty = $this->input->post('free_gift_received_qty',TRUE);
        $free_gift_fg_scheme_id = $this->input->post('free_gift_fg_scheme_id',TRUE);
        $free_gift_name         = $this->input->post('free_gift_name',TRUE);
        $free_gift_id           = $this->input->post('free_gift_id',TRUE);
        $free_gift_shortage     = $this->input->post('free_gift_shortage',TRUE);

        //invoice packing material
        $pm_invoice_qty=$this->input->post('pm_invoice_qty');
        $pm_shortage=$this->input->post('pm_shortage');
        $pm_id=$this->input->post('pm_id');
        $pm_name=$this->input->post('pm_name');
        $pm_unit=$this->input->post('pm_unit');

        # Check weather shortage>0 is in products and free products
        if(isset($invoice_product_shortage))
        {
            //print_r($invoice_product_shortage); exit();
            foreach($invoice_product_shortage as $invoice_id=>$product_shortage_val)
            {
                $shortage_val[] = ($product_shortage_val>0)?"have_shortage":"no_shortage";
            }
        }

         # Check weather shortage>0 is in products and free products
        if(isset($pm_shortage))
        {
            //print_r($invoice_product_shortage); exit();
            foreach($pm_shortage as $invoice_id=>$pm_shortage_val)
            {
                $pm_shortage_val[] = ($pm_shortage_val>0)?"have_shortage":"no_shortage";
            }
        }
        //print_r($shortage_val); exit();

       /* # Check weather shortage>0 is in products and free products
        if(isset($shortage))
        {
            foreach($shortage as $invoice_id=>$product_shortage_arr)
            {
                foreach($product_shortage_arr as $val)
                {
                   $shortage_val[] = ($val>0)?"have_shortage":"no_shortage";
                }
            }
        }

        # Check weather shortage>0 is in free gifts
        if(isset($free_gift_shortage))
        {
            foreach($free_gift_shortage as $invoice_id=>$free_gift_shortage_arr)
            {
                foreach($free_gift_shortage_arr as $val)
                {
                   $free_gift_shortage_val[] = ($val>0)?"have_shortage":"no_shortage";
                }
            }
        }*/
        $check_pm_shortage = (isset($pm_shortage)&&in_array("have_shortage", @$pm_shortage_val))?1:0;
        $check_shortage = (isset($shortage_val)&&in_array("have_shortage", @$shortage_val))?1:0;
        $free_gift_check_shortage = (isset($free_gift_shortage_val)&&in_array("have_shortage", $free_gift_shortage_val))?1:0;
        if($check_shortage>=1)
        {
            $data['shortage_div'] = 1;
        }
        //print_r($free_gift_check_shortage);exit;
        //print_r($invoice_arr); exit();
        foreach($invoice_arr as $key=>$invoice_id)
        {
            # Get product invoice qty arr by invoice id
            $invoice_do_product_id_arr = $invoice_do_product_ids[$invoice_id];
            //print_r($product_inv_qty_arr); exit();
            if(isset($invoice_do_product_id_arr))
            {
                if(count($invoice_do_product_id_arr)>0)
                {
                    
                    foreach ($invoice_do_product_id_arr as $invoice_do_product_id) 
                    {                                                 
                        //echo $inv_qty;exit;
                        $product_id = $invoice_product_ids[$invoice_do_product_id];
                        $all_products = array(
                                            'product_id'        => $product_id,
                                            'product_name'      => get_prod_name($product_id),
                                            'invoice_qty'       => $product_invoice_qty[$invoice_do_product_id]/$items_per_carton_arr[$invoice_do_product_id],
                                            'received_qty'      => $product_received_qty[$invoice_do_product_id],
                                            'shortage'          => $invoice_product_shortage[$invoice_do_product_id],
                                            'items_per_carton'  => $items_per_carton_arr[$invoice_do_product_id]
                                        ); 
                        $products_free_gift_results[$invoice_id]['invoice_num'] = $this->Common_model->get_value('invoice',array('invoice_id'=>$invoice_id),'invoice_number');
                        $products_free_gift_results[$invoice_id]['all_products'][$invoice_do_product_id]= $all_products;
                        
                    }
                }
            }
            //echo "<pre>";
            //print_r($products_free_gift_results); exit();

            # Get free product invoice qty arr by invoice id
            $free_product_inv_qty_arr = $free_product_invoice_qty[$invoice_id];
            if(isset($free_product_inv_qty_arr))
            {
                if(count($free_product_inv_qty_arr)>0)
                {
                    foreach($free_product_inv_qty_arr as $product_id=>$inv_qty)
                    {                        
                        $free_products = array(
                                                'product_id'        => $free_product_ids[$invoice_id][$product_id],
                                                'product_name'      => get_prod_name($product_id),
                                                'fg_scheme_id'      => $free_product_fg_scheme_id[$invoice_id][$product_id],
                                                'invoice_qty'       => $inv_qty,
                                                'received_qty'      => $free_product_received_qty[$invoice_id][$product_id],
                                                'shortage'          => $shortage[$invoice_id][$product_id],
                                                'items_per_carton'  => $free_product_items_per_carton[$invoice_id][$product_id]
                                            );
                        $products_free_gift_results[$invoice_id]['free_products'][$product_id]= $free_products;
                    }
                }
            }
            # Get pm invoice qty arr by invoice id
            $pm_inv_qty_arr = $pm_invoice_qty[$invoice_id];
            if(isset($pm_inv_qty_arr))
            {
                if(count($pm_inv_qty_arr)>0)
                {
                    foreach($pm_inv_qty_arr as $product_id=>$inv_qty)
                    {                        
                        $pm = array(
                                                'pm_id'        => $pm_id[$invoice_id][$product_id],
                                                'product_name'      => $pm_name[$invoice_id][$product_id],
                                                'pm_unit'           => $pm_unit[$invoice_id][$product_id],
                                                'invoice_qty'       => $inv_qty,
                                                'shortage'          => $pm_shortage[$invoice_id][$product_id]
                                               
                                            );
                        $products_free_gift_results[$invoice_id]['packing_material'][$product_id]= $pm;
                    }
                }
            }

            # Get free gift invoice qty arr by invoice id
            $free_gift_inv_qty_arr = $free_gift_invoice_qty[$invoice_id];
            if(isset($free_gift_inv_qty_arr))
            {
                if(count($free_gift_inv_qty_arr)>0)
                {
                    foreach($free_gift_inv_qty_arr as $product_id=>$inv_qty)
                    {
                        
                        $free_gifts = array(
                                                'product_id'      => $free_gift_id[$invoice_id][$product_id],
                                                'product_name'      => get_free_gift_name($product_id),
                                                'fg_scheme_id'      => $free_gift_fg_scheme_id[$invoice_id][$product_id],
                                                'invoice_qty'       => $inv_qty,
                                                'received_qty'      => $free_gift_received_qty[$invoice_id][$product_id],
                                                'shortage'          => $free_gift_shortage[$invoice_id][$product_id]
                                               
                                            );
                        $products_free_gift_results[$invoice_id]['free_gifts'][$product_id]= $free_gifts; 
                    }
                }
            }
        }
        //echo "<pre>"; print_r($products_free_gift_results);exit;
        $data['products_free_gift_results']  = $products_free_gift_results;
        $this->load->view('stock_receiving/confirm_stock_receiving',$data);
    }
    # Insert Products, Free Gifts, Free Products
    public function insert_products_free_gifts()
    {
    	$invoice_product_ids = $this->input->post('invoice_product_ids',TRUE);
        //print_r($invoice_product_ids); exit();
    	# invoice product qtys
    	$product_invoice_qty = $this->input->post('product_invoice_qty',TRUE);
    	$product_received_qty = $this->input->post('product_received_qty',TRUE); 
        //echo "<pre>"; print_r($product_received_qty);exit;
    	# invoice free gift qtys   
    	$free_gift_invoice_qty = $this->input->post('free_gift_invoice_qty',TRUE);	
    	$free_gift_received_qty = $this->input->post('free_gift_received_qty',TRUE);
    	$free_gift_fg_scheme_id = $this->input->post('free_gift_fg_scheme_id',TRUE);

    	# invoice free product qtys
    	$free_product_invoice_qty = $this->input->post('free_product_invoice_qty',TRUE);
    	$free_product_received_qty = $this->input->post('free_product_received_qty',TRUE);
    	$free_product_fg_scheme_id = $this->input->post('free_product_fg_scheme_id',TRUE);

        #invoice packing material qtys
        $pm_invoice_qty = $this->input->post('invoice_qty');
        $pm_id=$this->input->post('pm_id');
        $pm_shortage=$this->input->post('pm_shortage');

        # Shortages
        $invoice_product_shortage     = $this->input->post('invoice_product_shortage',TRUE);
        //$shortage     = $this->input->post('shortage',TRUE);
        $free_gift_shortage           = $this->input->post('free_gift_shortage',TRUE);
        //print_r($invoice_product_shortage);exit;

    	# Invoices
    	$invoice_arr = $this->input->post('invoice_id',TRUE);
        $invoice_do_product_ids = $this->input->post('invoice_do_product_ids',TRUE);
        //print_r($invoice_arr); exit();

        //print_r($shortage);exit;
        $remarks = $this->input->post('remarks',TRUE);
        $items_per_carton_arr = $this->input->post('items_per_carton_arr',TRUE);
        $free_product_items_per_carton = $this->input->post('free_product_items_per_carton',TRUE);


    	//echo "<pre>"; print_r($_POST);exit;

    	 # Stock Receipt Table Data
        $srn_number       =  get_current_serial_number(array('value'=>'srn_number','table'=>'stock_receipt','where'=>'on_date'));
        //$tanker_in_number =  $this->input->post('tanker_in_number',TRUE);
        //$tanker_id = $this->Common_model->get_value('tanker_register',array('tanker_in_number'=>$tanker_in_number),'tanker_id');
        $plant_id = $this->session->userdata('ses_plant_id'); // C & F or Stock Point
        $stock_receipt_data = array(
                                        'vehicle_number' => $this->input->post('vehicle_number',TRUE),
                                        'srn_number'    => $srn_number,
                                        'plant_id'      => $plant_id,
                                        'on_date'       => date('Y-m-d'),
                                        'remarks'       => $remarks,
                                        'created_by'    => $this->session->userdata('user_id'),
                                        'created_time'  => date('Y-m-d'),
                                        'status'        => 1,
                                   );
        $this->db->trans_begin();

        #Insert Into Stock Receipt Table -1
        $stock_receipt_id  = $this->Common_model->insert_data('stock_receipt',$stock_receipt_data);
        foreach($invoice_arr as $invoice_id)
        {
            //echo $key; exit();
            //print_r($invoice_id); exit();
            # Receipt Invoice Data
            $receipt_invoice_arr = array(
                                            'stock_receipt_id' => $stock_receipt_id,
                                            'invoice_id'       => $invoice_id,
                                            'status'           => 1,
                                            'modified_by'      => $this->session->userdata('user_id'),
                                            'modified_time'    => date('Y-m-d')
                                        );
            # Insert Into Receipt Invoice Table -2
            $receipt_invoice_id  = $this->Common_model->insert_data('receipt_invoice',$receipt_invoice_arr);

            # Get product invoice qty arr by invoice id
            $invoice_do_product_id_arr = $invoice_do_product_ids[$invoice_id];
            if(isset($invoice_do_product_id_arr))
            {
                if(count($invoice_do_product_id_arr)>0)
                {

                    foreach($invoice_do_product_id_arr as $invoice_do_product_id)
                    {
                        //echo $inv_qty; exit();
                        //echo $product_invoice_qty[$key][$k1][$product_id]; exit();
                        //echo $received_qty; exit();
                        # Invoice Qty and Received Qty in Cartons
                        $inv_qty_in_cartons = $product_invoice_qty[$invoice_do_product_id];
                        $received_qty_pounches = $product_received_qty[$invoice_do_product_id];
                        $received_qty_carton   = $items_per_carton_arr[$invoice_do_product_id];
                        $product_id = $invoice_product_ids[$invoice_do_product_id];
                        $received_qty = $received_qty_pounches / $received_qty_carton;  
                        $receipt_invoice_product_id  = $this->Common_model->insert_data('receipt_invoice_product',
                            array('receipt_invoice_id'=>$receipt_invoice_id,
                                  'product_id'=>$product_id,
                                  'invoice_do_product_id' => $invoice_do_product_id,
                                  'invoice_quantity'=>$inv_qty_in_cartons,
                                  'received_quantity'=>$received_qty));
                        
                        //echo $this->db->last_query().'<br>';   
                        # Insert (OR) Update Plant_Product based on plant_id & product_id
                        $this->Stock_receiving_m->insert_update_plant_product($plant_id,$product_id,$received_qty); 
                        //echo $this->db->last_query().'<br>';          
                        $products_free_prod_shortage[] = $invoice_product_shortage[$invoice_do_product_id];          
                    }
                }
            }
            //exit;
            # Get free product invoice qty arr by invoice id
            $free_product_inv_qty_arr = $free_product_invoice_qty[$invoice_id];
            if(isset($free_product_inv_qty_arr))
            {
                if(count($free_product_inv_qty_arr)>0)
                {
                    foreach($free_product_inv_qty_arr as $product_id=>$inv_qty)
                    {
                        $fg_scheme_id  = $free_product_fg_scheme_id[$invoice_id][$product_id];
                        //$received_qty  = $free_product_received_qty[$invoice_id][$product_id];
                        # Invoice and Received Qty in Cartons
                        $inv_qty_in_cartons = $inv_qty/$free_product_items_per_carton[$invoice_id][$product_id];                        
                        $received_qty_pounches = $free_product_received_qty[$invoice_id][$product_id];
                        $received_qty_carton   = $free_product_items_per_carton[$invoice_id][$product_id];
                        $received_qty = $received_qty_pounches / $received_qty_carton;  

                        $rf_product_id = $this->Common_model->insert_data('receipt_free_product',array('receipt_invoice_id'=>$receipt_invoice_id,'product_id'=>$product_id,'fg_scheme_id'=>$fg_scheme_id,'invoice_quantity'=>$inv_qty_in_cartons,'received_quantity'=>$received_qty));
                        $type_id       = $this->Common_model->get_value('free_gift_scheme',array('fg_scheme_id'=>$fg_scheme_id),'type_id');
                        $c_and_f_block_id  = get_c_and_f_block_id1(); 
                        $scheme_type_id = get_scheme_type_id();  
                        $stock_point_block_id  = get_stock_point_block_id();     
                        if(($this->session->userdata('block_id') == $c_and_f_block_id && @$type_id > $scheme_type_id) || ( $this->session->userdata('block_id') == $stock_point_block_id))
                        {
                            # Insert (OR) Update Plant Product based on plant_id & product_id
                            $this->Stock_receiving_m->insert_update_plant_product($plant_id,$product_id,$received_qty); 
                        }                       
                        
                    }
                }
            }

             # Get packing material invoice qty arr by invoice id
            $pm_inv_qty_arr = $pm_invoice_qty[$invoice_id];
            if(isset($pm_inv_qty_arr))
            {
                if(count($pm_inv_qty_arr)>0)
                {
                    foreach($pm_inv_qty_arr as $product_id=>$inv_qty)
                    {  
                       $plant_id=$this->session->userdata('ses_plant_id'); 
                       $packing_id=$pm_id[$invoice_id][$product_id];
                       $net_packing=$inv_qty-$pm_shortage[$invoice_id][$product_id];             
                        $qry = "INSERT INTO plant_pm(plant_id,pm_id,quantity,updated_time) 
                    VALUES (".$plant_id.",".$packing_id.",".$net_packing.",'".date('Y-m-d H:i:s')."')  
                    ON DUPLICATE KEY UPDATE quantity = quantity+VALUES(quantity),updated_time = VALUES(updated_time) ;";
                    $this->db->query($qry); 
                    }
                }
            }

            # Get free gift invoice qty arr by invoice id
            $free_gift_inv_qty_arr = $free_gift_invoice_qty[$invoice_id];
            if(isset($free_gift_inv_qty_arr))
            {
                if(count($free_gift_inv_qty_arr)>0)
                {
                    foreach($free_gift_inv_qty_arr as $product_id=>$inv_qty)
                    {
                        $fg_scheme_id  = $free_gift_fg_scheme_id[$invoice_id][$product_id];
                        $received_qty = $free_gift_received_qty[$invoice_id][$product_id];
                        
                        $rf_gift_id  = $this->Common_model->insert_data('receipt_free_gift',array('receipt_invoice_id'=>$receipt_invoice_id,'free_gift_id'=>$product_id,'fg_scheme_id'=>$fg_scheme_id,'invoice_quantity'=>$inv_qty,'received_quantity'=>$received_qty,'modified_by'=>12));
                        
                        $type_id = $this->Common_model->get_value('free_gift_scheme',array('fg_scheme_id'=>$fg_scheme_id),'type_id');
                        $c_and_f_block_id  = get_c_and_f_block_id1(); 
                        $scheme_type_id = get_scheme_type_id();  
                        $stock_point_block_id  = get_stock_point_block_id(); 
                        if(($this->session->userdata('block_id') == $c_and_f_block_id && @$type_id > $scheme_type_id) || ( $this->session->userdata('block_id') == $stock_point_block_id))
                        {
                            # Insert (OR) Update Plant Product based on plant_id & product_id
                            $this->Stock_receiving_m->insert_update_plant_free_gift($plant_id,$product_id,$received_qty); 
                        } 
                    }
                }
            }

            # Lit table insertion starts here
            // Get Invoice ids if shortage is >0 
            //echo $key; exit();
            //print_r($invoice_product_shortage); exit();
            /*foreach ($invoice_id as $k1 => $product_inv_qty_arr) 
            {
                foreach($product_inv_qty_arr as $product_id=>$inv_qty)
                {
                    $products_free_prod_shortage[] = $invoice_product_shortage[$key][$k1][$product_id];
                }
            }*/
                    //print_r($products_free_prod_shortage);exit;
                    //print_r($products_free_prod_shortage);exit;
                    $count =0;
                    if(isset($products_free_prod_shortage))
                    {
                        if(count($products_free_prod_shortage)>0)
                        {
                            foreach($products_free_prod_shortage as $shortage1)
                            {
                                if($shortage1 >0)
                                {
                                    $count++; //shortage count              
                                
                                }
                               
                            }
                        }
                    }
                    //echo $count; exit();
                    if(@$count>0)
                    {
                        // Get Invoice id for inserting value in loss_in_transit table
                        $lit_invoice_id = @$invoice_id;  
                    }
                    else
                    {
                        $lit_invoice_id = 0;
                    }
                    //print_r($lit_invoice_id);exit;
                    if(@$lit_invoice_id > 0)
                    {
                        //echo "fvs"; exit();
                        $transporter_name = $this->input->post('transporter_name',TRUE); 
                        $lr_number = $this->input->post('lr_number',TRUE); 
                        $lr_date =date('Y-m-d'); 
                        $remarks = $this->input->post('remarks',TRUE);  
                        $lit_id = $this->Common_model->insert_data('loss_in_transit',array('invoice_id'=>$lit_invoice_id,'transporter_name'=>$transporter_name,'lr_number'=>$lr_number,'lr_date'=>$lr_date,'remarks'=>$remarks,'created_by'=>12,'created_time'=>date("Y-m-d H:i:s")));
                    }
                   
                    #insert values in lit_product table
                    if(isset($lit_id)>0)
                    {
                        
                        foreach($invoice_do_product_id_arr as $invoice_do_product_id)
                        {
                            //echo $product_id; exit();
                            //echo $lit_id; 
                            $shortage_value = $invoice_product_shortage[$invoice_do_product_id];
                            if($shortage_value>0)
                            {
                                $lost_pouches = $shortage_value;
                                $product_id = $invoice_product_ids[$invoice_do_product_id];
                                # Insert lit product data
                                $this->Common_model->insert_data('lit_product',array('lit_id'=>$lit_id,'product_id'=>$product_id,'lost_pouches'=>$lost_pouches,'status'=>1));
                                //echo $this->db->last_query().'<br>';
                            }   
                            
                        }
                        //exit;

                    }
                    


        }

        /*# Update Tanker Register Table
        $trdata = array('status'=>2,'modified_by' => $this->session->userdata('user_id'),'modified_time' => date('Y-m-d H:i:s'));
        $trwhere = array('tanker_id'=>$tanker_id);
        $this->Common_model->update_data('tanker_register',$trdata,$trwhere);*/

        # Update Invoice Table
        foreach($invoice_arr as $invoice_id)
        {
            $trdata = array('status'=>2,'modified_by' => $this->session->userdata('user_id'),'modified_time' => date('Y-m-d H:i:s'));
            $trwhere = array('invoice_id'=>$invoice_id);
            $this->Common_model->update_data('invoice',$trdata,$trwhere);
        }

        //exit;
    	if($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <strong>Error!</strong> There is a problem occured while Inserting Details. Please try again. </div>');  
        }
        else
        {
            $this->db->trans_commit();
            //exit;
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong>Stock Received Details has been Inserted successfully with <b>SRN Number  '.$srn_number.' </b></div>');
        }
        redirect(SITE_URL.'stock_receiving');
    }

    public function stock_receiving_list()
    {

        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Stock Receiving List ";
        $data['nestedView']['pageTitle'] = 'Stock Receiving List';
        $data['nestedView']['cur_page']     =   'stock_receiving_r';
        $data['nestedView']['parent_page']  =   'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Stock Receiving List ', 'class' => 'active', 'url' => 'bank');

        # Search Functionality
        $srn_search=$this->input->post('search_srn', TRUE);
        //print_r($_POST);exit;
        if($srn_search!='') 
        {
            $search_params=array(
                                    'srn_number'          => $this->input->post('srn_number', TRUE),  
                                    'vehicle_number'      => $this->input->post('vehicle_number', TRUE),
                                    'invoice_number'      => $this->input->post('invoice_number', TRUE),                                 
                                    'fromDate'            => $this->input->post('fromDate', TRUE),
                                    'toDate'              => $this->input->post('toDate', TRUE)            
                                );
            $this->session->set_userdata($search_params);

        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                                    'srn_number'       	   => $this->session->userdata('srn_number'),
                                    'vehicle_number'      => $this->session->userdata('vehicle_number', TRUE),
                                    'invoice_number'      => $this->session->userdata('invoice_number', TRUE),  
                                    'fromDate'             => $this->session->userdata('fromDate'),
                                    'toDate'               => $this->session->userdata('toDate')
                    
                                    );
            }
            else {
                $search_params=array(
                                    'srn_number'           => '',
                                    'vehicle_number'       => '',
                                    'invoice_number'       => '',
                                    'fromDate'             => '',
                                    'toDate'               => ''                     
                                    );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'stock_receiving_list/';
        # Total Records
        $config['total_rows'] = $this->Stock_receiving_m->stock_receipt_num_rows($search_params);

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
        $data['srn_results'] = $this->Stock_receiving_m->stock_receipt_results($current_offset, $config['per_page'], $search_params);
        
        # Additional data
        $data['display_results'] = 1;
        $data['flag'] = 1;

        $this->load->view('stock_receiving/stock_receiving_list',$data);
    }

    public function view_srn_invoice_details()
    {
        $srn_number = cmm_decode($this->uri->segment(2));
        if($srn_number=='')
        {
            redirect(SITE_URL.'stock_receiving'); exit();
        }
    	# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "View SRN Invoice Details";
        $data['nestedView']['cur_page']     =   'stock_receiving_r';
        $data['nestedView']['parent_page']  =   'reports';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['pageTitle'] = 'View SRN Invoice Details';
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'View SRN Invoice Details','class'=>'active','url'=>'');
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

        $plant_id = $this->session->userdata('ses_plant_id');
        $data['srn_number'] 		= $srn_number;
 		$stock_receipt_data			= $this->Common_model->get_data('stock_receipt',array('srn_number'=>$srn_number));
 		$stock_receipt_id 			= $stock_receipt_data[0]['stock_receipt_id'];        
 		$data['srn_date'] 			= $stock_receipt_data[0]['on_date'];
 		$data['vehicle_number'] 					= $stock_receipt_data[0]['vehicle_number'];
 		//$data['tanker_in_number'] 	= $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id,'plant_id'=>$plant_id),'tanker_in_number');
 		$receipt_invoice_id_arr   	= $this->Common_model->get_data('receipt_invoice',array('stock_receipt_id'=>$stock_receipt_id));
 		$invoice_id_arr = array_column($receipt_invoice_id_arr,'invoice_id');
        //print_r($receipt_invoice_id_arr);exit;
 		//echo "<pre>"; print_r($receipt_invoice_id_arr);exit;	
 		if(@$receipt_invoice_id_arr != '')
 		{
 			foreach($receipt_invoice_id_arr as $key => $value)
			{
				$receipt_invoice_id_arr1[] = $value['receipt_invoice_id'];    				  				
			}

			foreach($receipt_invoice_id_arr1 as $key => $receipt_invoice_id)
			{	
				$invoice_number   =  $this->Stock_receiving_m->get_invoice_number($receipt_invoice_id);
				$invoice_results[$receipt_invoice_id]['invoice_number']		=	$invoice_number[0]['invoice_number'];
				//$receipt_invoice_id = $this->Common_model->get_value('receipt_invoice',array('stock_receipt_id'=>$stock_receipt_id),'receipt_invoice_id');
				
				# All Products
				$product_results 	=	$this->Stock_receiving_m->get_receipt_invoice_products($receipt_invoice_id);
				$invoice_results[$receipt_invoice_id]['product_details'] 	=   $product_results;
				
				# Free Gifts
				$free_gift_results  =   $this->Stock_receiving_m->get_receipt_free_gift($receipt_invoice_id);
				$invoice_results[$receipt_invoice_id]['free_gift_details'] 	=   $free_gift_results;

				# Free Products
				$free_product_results  =   $this->Stock_receiving_m->get_receipt_free_products($receipt_invoice_id);
				$invoice_results[$receipt_invoice_id]['free_product_details'] 	=   $free_product_results;
			}
            $count=0;
            foreach($receipt_invoice_id_arr1 as $key => $receipt_invoice_id)
            {
                $product_results    =   $this->Stock_receiving_m->get_receipt_invoice_products($receipt_invoice_id);
                foreach($product_results as $key=>$results)
                {
                    if($results['shortage'] >0)
                    {
                        $count++;
                    }
                }
            }
            if($count>0)
            {
                $lit_results = $this->Stock_receiving_m->get_lit_results($invoice_id_arr);
            }
	 		//echo "<pre>"; print_r($lit_results);exit;	 
 		}
        $data['lit_results']     = @$lit_results;
        $data['invoice_results'] = @$invoice_results;
    	$this->load->view('stock_receiving/view_srn_invoice_details',$data);
    }

    # Print SRN Invoice Details 
    public function print_srn_invoice_details()
    {
        # Get Order Id
        $srn_number  =  cmm_decode($this->uri->segment(2));
        if($srn_number=='')
        {
            redirect(SITE_URL);
            exit;
        }
        else
        {  
	        $data['srn_number'] 		= $srn_number;
	 		$stock_receipt_data			= $this->Common_model->get_data('stock_receipt',array('srn_number'=>$srn_number));
	 		$stock_receipt_id 			= $stock_receipt_data[0]['stock_receipt_id'];
	 		$data['srn_date'] 			= $stock_receipt_data[0]['on_date'];
	 		$data['vehicle_number'] 	= $stock_receipt_data[0]['vehicle_number'];
	 		//$data['tanker_in_number'] 	= $this->Common_model->get_value('tanker_register',array('tanker_id'=>$tanker_id),'tanker_in_number');
	 		$receipt_invoice_id_arr   	= $this->Common_model->get_data('receipt_invoice',array('stock_receipt_id'=>$stock_receipt_id));
	 		$invoice_id_arr = array_column($receipt_invoice_id_arr,'invoice_id');
            //print_r($receipt_invoice_id_arr);exit;
	 		//echo "<pre>"; print_r($receipt_invoice_id_arr);exit;	
	 		if(@$receipt_invoice_id_arr != '')
	 		{
	 			foreach($receipt_invoice_id_arr as $key => $value)
				{
					$receipt_invoice_id_arr1[] = $value['receipt_invoice_id'];    				  				
				}

				foreach($receipt_invoice_id_arr1 as $key => $receipt_invoice_id)
				{	
					$invoice_number   =  $this->Stock_receiving_m->get_invoice_number($receipt_invoice_id);
					$invoice_results[$receipt_invoice_id]['invoice_number']		=	$invoice_number[0]['invoice_number'];
					//$receipt_invoice_id = $this->Common_model->get_value('receipt_invoice',array('stock_receipt_id'=>$stock_receipt_id),'receipt_invoice_id');
					
					# All Products
					$product_results 	=	$this->Stock_receiving_m->get_receipt_invoice_products($receipt_invoice_id);
					$invoice_results[$receipt_invoice_id]['product_details'] 	=   $product_results;
					
					# Free Gifts
					$free_gift_results  =   $this->Stock_receiving_m->get_receipt_free_gift($receipt_invoice_id);
					$invoice_results[$receipt_invoice_id]['free_gift_details'] 	=   $free_gift_results;

					# Free Products
					$free_product_results  =   $this->Stock_receiving_m->get_receipt_free_products($receipt_invoice_id);
					$invoice_results[$receipt_invoice_id]['free_product_details'] 	=   $free_product_results;
				}
	 		//echo "<pre>"; print_r($invoice_results);exit;	 
 		}

        $count=0;
        foreach($receipt_invoice_id_arr1 as $key => $receipt_invoice_id)
        {
            $product_results    =   $this->Stock_receiving_m->get_receipt_invoice_products($receipt_invoice_id);
            foreach($product_results as $key=>$results)
            {
                if($results['shortage'] >0)
                {
                    $count++;
                }
            }
        }
        if($count>0)
        {
            $lit_results = $this->Stock_receiving_m->get_lit_results($invoice_id_arr);
        }

        $data['invoice_results'] = @$invoice_results;
        $data['lit_results']     = @$lit_results;
        $this->load->view('stock_receiving/print_srn_invoice',$data);
            
        }
    }

    # Download SRN List
    public function download_srn_list()
    {
        if($this->input->post('download_srn')!='') {
           $search_params=array(
                                    'srn_number'          => $this->input->post('srn_number', TRUE),
                                    'vehicle_number'      => $this->input->post('vehicle_number', TRUE),
                                    'invoice_number'      => $this->input->post('invoice_number', TRUE),                                    
                                    'fromDate'            => $this->input->post('fromDate', TRUE),
                                    'toDate'              => $this->input->post('toDate', TRUE)            
                                );
            $srn_list = $this->Stock_receiving_m->download_srn_list($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','SRN Number','Invoice Number','Vehicle Number','SRN Date');
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
            if(count($srn_list)>0)
            {
                
                foreach($srn_list as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['srn_number'].'</td>';  
                    $data.='<td align="center">'.$row['invoice_number'].'</td>';  
                    $data.='<td align="center">'.$row['vehicle_number'].'</td>';
                    $data.='<td align="center">'.$row['on_date'].'</td>'; 
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
            $xlFile='SRNinvoiceList'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
}