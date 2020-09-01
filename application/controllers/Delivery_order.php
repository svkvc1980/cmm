<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

/*
    Created By      :   Priyanka
    Date            :   24th Feb 2017 12:38 PM
    Module          :   Delivery Order for Distributor 
*/
class Delivery_order extends Base_controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Delivery_order_m");
        $this->load->model("Plant_do_m");
    }

    public function delivery_order()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Delivery Order";
        $data['nestedView']['cur_page'] = 'delivery_order';
        $data['nestedView']['parent_page'] = 'delivery_order';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['pageTitle'] = 'Delivery Order';
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Delivery Order','class'=>'active','url'=>'');
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

        # Get Distributor Type Details
        $data['distributor_type'] = $this->Common_model->get_data('ob_type',array('status'=>1));
        //echo "<pre>"; print_r($data['distributor_type']);exit;

        # flag = 1 (Displaying Order Booking First form)
        $data['flag']   =   1;
        $this->load->view('delivery_orders/delivery_order',$data);
    }

    # Get Distibutor Pending DOs
    public function get_dist_pending_dos()
    {

        $ob_type_id         = $this->input->post('ob_type_id',TRUE);
        $distributor_id     = $this->input->post('distributor_id',TRUE);

        if($ob_type_id != '' && $distributor_id != '')
        {

            # Get Orders based on Order Type, Distributor ID, Lifting Point
            $distributor_do_details = $this->Delivery_order_m->get_distributor_pending_dos($distributor_id,$ob_type_id);
            //echo '<pre>';print_r($distributor_order_details); exit;
            if(count($distributor_do_details) != '')
            {
               
               //echo"<pre>"; print_r($distributor_order);exit;
                $do_results = array();
                foreach($distributor_do_details as $key => $value)
                {
                    $do_results[$value['do_number']]['do_number']=$value['do_number'];
                    $do_results[$value['do_number']]['do_id']=$value['do_id'];
                    $do_results[$value['do_number']]['do_date']=$value['do_date'];
                    $do_results[$value['do_number']]['do_lifting_point']=$value['do_lifting_point'];
                    $results=$this->Delivery_order_m->get_doProducts($value['do_id']);
                    $do_results[$value['do_number']]['do_products']=$results;
                    //echo '<pre>';print_r($results);exit;
                }
                //echo '<pre>';print_r($do_results);exit;
                echo '<h4>Pending DOs are:</h4>';
                //$ordered_products = $this->Distributor_ob_m->get_ordered_product_details($ob_type_id,$distributor_id,$lifting_point_id);
                echo '<div class="table-scrollable">';
                echo '<table class="table table-bordered table-striped table-hover mytable">';
                
                foreach($do_results as $do_number => $do_details)   
                {
                    if($do_details['do_products'] != '')
                    {
                        $do_date = date('d-m-Y',strtotime($do_details['do_date']));
                        echo '<thead>';
                        echo '<th colspan="7">'.'DO No : '.$do_details['do_lifting_point'].' / '.$do_details['do_number'].' / '.$do_date.'</th>';
                        echo '</thead>';
                        echo '<tr style="background-color:#cccfff">';
                        echo '<td>'.'Product'.'</td>';
                        echo '<td>'.'Price'.'</td>';
                        echo '<td>'.'Items Per Carton'.'</td>';
                        echo '<td>'.'DO Qty'.'</td>';
                        echo '<td>'.'Pending Qty'.'</td>';
                        echo '</tr>';
                        foreach($do_details['do_products'] as $key => $value)
                        {
                            $total=0;
                            $product_price  = $value['product_price'];
                            echo '<tbody>';

                            echo '<tr>';
                            echo '<td>'.$value['product_name'].'</td>';
                            echo '<td>'.$product_price.'</td>';
                            echo '<td>'.$value['items_per_carton'].'</td>';
                            echo '<td>'.round($value['quantity']).'</td>';
                            echo '<td>'.round($value['pending_qty']).'</td>';
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
                echo '<h3 align="center">No Pending DOs</h3>'; 
            }
        }

    }

    public function delivery_order_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Delivery Order";
        $data['nestedView']['cur_page'] = 'delivery_order';
        $data['nestedView']['parent_page'] = 'delivery_order';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['pageTitle'] = 'Delivery Order';
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Delivery Order','class'=>'active','url'=>'');
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

        # Get Distributor , Bank Guarantee, Lifting Point Details
        $ob_type_id = $this->input->post('order_type');
        $distributor_id = $this->input->post('distributor_id');
        $stock_lifting_unit_id = $this->input->post('stock_lifting_unit_id');
        $data['distributor_details'] = $this->Common_model->get_data('distributor',array('distributor_id'=>$distributor_id));
        $data['bank_guarantee_details'] = $this->Delivery_order_m->get_bank_guarantee_details($distributor_id);
        $stock_lifting_unit_id = $this->input->post('stock_lifting_unit_id');
        $data['lifting_point_name'] = $this->Common_model->get_value('plant', array('plant_id'=>$stock_lifting_unit_id), 'name');

        // Get price type by ob type id
        $price_type_id =    $this->Common_model->get_value('ob_type', array('ob_type_id'=>$ob_type_id), 'price_type_id');
        $data['price_type'] = $price_type_id;
        $data['do_for'] = $this->input->post('do_for');
        # Get bg_amount column in array format
        /*$bg_amount_column = array_column($data['bank_guarantee_details'],'bg_amount');
        $data['total_bg_amount'] = array_sum($bg_amount_column);*/
        $data['total_bg_amount'] = $this->Delivery_order_m->get_total_bg_amount($distributor_id);
        $data['available_amount']    = $data['total_bg_amount'] + $data['distributor_details'][0]['sd_amount'] + $data['distributor_details'][0]['outstanding_amount'] ;

        # Get Orders based on Order Type, Distributor ID, Lifting Point
        $distributor_order_details = $this->Delivery_order_m->get_distributor_orders($distributor_id,$ob_type_id);
       //echo"<pre>"; print_r($distributor_order);exit;
        $order_results = array();
        foreach($distributor_order_details as $key => $value)
        {
            $order_results[$value['order_number']]['order_number']=$value['order_number'];
            $order_results[$value['order_number']]['order_id']=$value['order_id'];
            $order_results[$value['order_number']]['order_date']=$value['order_date'];
            $order_results[$value['order_number']]['ob_lifting_point']=$value['ob_lifting_point'];
            $results=$this->Delivery_order_m->get_orderedProducts($value['order_id']);
           // echo '<pre>'; print_r($results); print_r($value); exit;
            foreach($results as $key => $prow)
            {
                $product_do_qty = get_ob_product_do_qty($value['order_id'],$prow['product_id']);
                // Get product price
                $product_price = get_product_price($prow['product_id'],$price_type_id,$value['order_date'],$stock_lifting_unit_id);
                $results[$key]['product_price']  = $product_price;
               // $results[$key]['pending_qty']  = ($ordered_qty-$product_do_qty);
            }
            $order_results[$value['order_number']]['ordered_products']=$results;
            //echo '<pre>';print_r($results);exit;
        }
        //echo "<pre>"; print_r($order_results);exit;

        # flag = 1 (Displaying Order Booking First form)
        $data['flag']   =   2;
        $data['order_results']   =  $order_results;
        $data['ob_type_id'] = $ob_type_id;
        $data['distributor_id'] = $distributor_id;
        $data['stock_lifting_unit_id'] = $stock_lifting_unit_id;
        $this->load->view('delivery_orders/delivery_order',$data);
    }

    // mahesh 25-02-2017 05:16 am
    public function confirm_delivery_order()
    {
        //echo '<pre>'; print_r($_POST); exit;
        $grand_total = $this->input->post('grand_total');
        $available_amt = $this->input->post('available_amt');
        if(check_distributor_bg_expired( $this->input->post('distributor_id')))
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong> You can\'t generate Delivery Order. Distributor Bank Guarantee has been expired. Please renewal Bank Gurantee to enable Delivery Order. </div>');
            redirect(SITE_URL.'delivery_order'); exit();
        }

        if($grand_total!='')
        {
            if(@$available_amt < @$grand_total)
            {
                 $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        <strong>Sorry!</strong> You Don\'t Have Enough Balance To Generate Delivery Order. </div>');  
               // exit;
                 
                redirect(SITE_URL.'delivery_order');

            }
        }

        $submit = $this->input->post('generate_do');
        if($submit!='')
        {
            /*echo '<pre>';
            print_r($_POST);
            exit;*/
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

            # Get Distributor , Bank Guarantee, Lifting Point Details
            $ob_type_id = $this->input->post('order_type');
            $distributor_id = $this->input->post('distributor_id');
            $stock_lifting_unit_id = $this->input->post('stock_lifting_unit_id');
            $data['distributor_details'] = $this->Common_model->get_data('distributor',array('distributor_id'=>$distributor_id));
            $data['bank_guarantee_details'] = $this->Delivery_order_m->get_bank_guarantee_details($distributor_id);
            $stock_lifting_unit_id = $this->input->post('stock_lifting_unit_id');
            $data['lifting_point_name'] = $this->Common_model->get_value('plant', array('plant_id'=>$stock_lifting_unit_id), 'name');

            # Get bg_amount column in array format
            $bg_amount_column = array_column($data['bank_guarantee_details'],'bg_amount');
            $data['total_bg_amount'] = array_sum($bg_amount_column);
            $data['available_amount']    = $data['total_bg_amount'] + $data['distributor_details'][0]['sd_amount'] + $data['distributor_details'][0]['outstanding_amount'] ;

            
            $order_product  = $this->input->post('order_product');
            $price  = $this->input->post('price');
            $ordered_qty  = $this->input->post('ordered_qty');
            $pending_qty  = $this->input->post('pending_qty');
            $lifting_qty  = $this->input->post('lifting_qty');
            $items_per_carton  = $this->input->post('items_per_carton');
            $do_products = array();
            foreach ($order_product as $op_val) {
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
            $data['do_number']  =   get_distributor_do_number();
            $data['ob_type_id'] = $this->input->post('ob_type_id');
            $data['distributor_id'] = $distributor_id;
            $data['stock_lifting_unit_id'] = $stock_lifting_unit_id;
            //For institutional
            $data['do_for'] = $this->input->post('do_for');
            $this->load->view('delivery_orders/delivery_order_confirmation',$data);
        }
    }

     // mahesh 25-02-2017 06:20 am
    public function submit_delivery_order()
    {
        if($_POST['gd_total'] < 0)
        {
             $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Sorry!</strong> Sorry You Don\'t Have Enough Balance To Generate Order. </div>');  
           // exit;
             
            redirect(SITE_URL.'delivery_order');

        }//exit;
        $submit = $this->input->post('proceed_do');
        if($submit!='')
        {
            //echo '<pre>'; print_r($_POST); exit;
            $distributor_id  = $this->input->post('distributor_id');
            $lifting_point_name  = $this->input->post('lifing_point_name');
            $order_product  = $this->input->post('order_product');
            $price  = $this->input->post('price');
            $lifting_qty  = $this->input->post('lifting_qty');
            $ordered_qty  = $this->input->post('ordered_qty');
            $pending_qty  = $this->input->post('pending_qty');
            $items_per_carton  = $this->input->post('items_per_carton');
            $stock_lifting_unit_id  = $this->input->post('stock_lifting_unit_id');
            $do_number = get_distributor_do_number();
            $data = array(
                        'do_number'     =>  $do_number,
                        'do_date'       =>  date('Y-m-d'),
                        'do_distributor_id' => $distributor_id,
                        'lifting_point' => $this->input->post('stock_lifting_unit_id'),
                        'status'        =>  1,
                        'created_by'    =>  $this->session->userdata('user_id'),
                        'created_time'  =>  date('Y-m-d H:i:s')
                        );
            $ob_type_id = $this->input->post('ob_type_id');
            // If Institutional or CST(institutional)
            if($ob_type_id==2||$ob_type_id==4)
            {
                $data['do_distributor_id'] = $this->input->post('do_for');
            }
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
                $do_products1[] = $do_products_for_mail;
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
            # Distributor Available Balance
            $bank_guarantee_details = $this->Delivery_order_m->get_bank_guarantee_details($distributor_id);
            $distributor_details = $this->Common_model->get_data('distributor',array('distributor_id'=>$distributor_id));
            # Get bg_amount column in array format
            $bg_amount_column = array_column($bank_guarantee_details,'bg_amount');
            $total_bg_amount= array_sum($bg_amount_column);
            $available_amount   = $total_bg_amount + $distributor_details[0]['sd_amount'] + $distributor_details[0]['outstanding_amount'] ;
           

            //print_r($order_ids);
            //looping orderes
            foreach ($order_ids as $orderId) {
                // update order Id status
                $do_status = $this->Delivery_order_m->updateOrderStatus($orderId);
                //echo $this->db->last_query().'<br>';
            }
            /*$email = distributor_DO_mail($distributor_id,$do_products1,$do_number,$available_amount,$do_status,$lifting_point_name);
            //print_r($email);exit;

            echo "<pre>"; print_r($email);exit;*/

            //Deduct total amount of DO from distributor outstanding amount
            $qry = 'UPDATE distributor SET outstanding_amount = outstanding_amount - '.$total_amount.' WHERE distributor_id = '.$distributor_id;
            $this->db->query($qry);
            
            // Modified By Maruthi on 27th April'17 12:10PM
            // inserting in distributor transaction table
            $outstanding_amount = $distributor_details[0]['outstanding_amount'];
            //echo $outstanding_amount.'<br>';
            $final_outstanding_amount = ($outstanding_amount - $total_amount);
            $dist_trans_data = array(
                            'distributor_id'        => $distributor_id,
                            'trans_type_id'         => 5,
                            'trans_amount'          => (-$total_amount),
                            'outstanding_amount'    => $final_outstanding_amount, 
                            'remarks'               => 'DO',
                            'trans_date'            => date('Y-m-d'),
                            'created_by'            =>  $this->session->userdata('user_id'),
                            'created_time'          => date('Y-m-d H:m:s')
                );
            //echo '<pre>';print_r($dist_trans_data);exit;
            $this->Common_model->insert_data('distributor_trans',$dist_trans_data);
            // updating modified by, modified time in user table
            $udata = array('modified_by' => $this->session->userdata('user_id'),'modified_time' => date('Y-m-d H:i:s'));
            $user_id = $this->Common_model->get_value('distributor',array('distributor_id'=>$distributor_id),'user_id');
            $uwhere = array('user_id'=>$user_id);
            $this->Common_model->update_data('user',$udata,$uwhere);

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
        redirect(SITE_URL.'delivery_order');
    }

    # Priyaka 26th Feb 9:20 PM
    # Distributor DO list
    public function distributor_do_list()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Distributor D.O. List";
        $data['nestedView']['pageTitle'] = 'Distributor D.O. List';
        $data['nestedView']['cur_page'] = 'distributor_do_r';
        $data['nestedView']['parent_page'] = 'reports';
        $data['nestedView']['list_page'] = 'do_reports';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Distributor D.O. List','class'=>'active','url'=>'');
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

        # Get OB Type Details
        $data['distributor_type'] = $this->Common_model->get_data('ob_type',array('status'=>1));
        $data['lifting_point'] = $this->Delivery_order_m->get_lifting_point_list();
        $data['product_list'] = $this->Delivery_order_m->get_product_list();
        $data['distributor_list'] = $this->Common_model->get_data('distributor','','','CAST(distributor_code AS unsigned) ASC');
        //echo "<pre>"; print_r($data['distributor_type']);exit;

        # Search Functionality
        $do_search=$this->input->post('search_do', TRUE);
        if($do_search!='') 
        {
             $from_date=(($this->input->post('fromDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('fromDate', TRUE))):''; 
              $to_date=(($this->input->post('toDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('toDate', TRUE))):''; 

            $search_params=array(
                                    'order_type_id'       => $this->input->post('order_type_id', TRUE),
                                    'distributor_id'      => $this->input->post('distributor_id', TRUE),
                                    'lifting_point_id'    => $this->input->post('lifting_point_id', TRUE),
                                    'fromDate'            => $from_date,
                                    'toDate'              => $to_date,
                                    'do_number'           => $this->input->post('do_number',TRUE),
                                    'product_id'          => $this->input->post('product_id',TRUE),
                                    'executive'           => $this->input->post('executive',TRUE),
                                    'status'              => $this->input->post('status',TRUE)            
                                );
            $this->session->set_userdata($search_params);

        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                                    'order_type_id'        => $this->session->userdata('order_type_id'),
                                    'distributor_id'       => $this->session->userdata('distributor_id'),
                                    'lifting_point_id'     => $this->session->userdata('lifting_point_id'),
                                    'fromDate'             => $this->session->userdata('fromDate'),
                                    'toDate'               => $this->session->userdata('toDate'),
                                    'do_number'            => $this->session->userdata('do_number'),
                                    'product_id'           => $this->session->userdata('product_id'),
                                    'executive'            => $this->session->userdata('executive'),
                                    'status'               => $this->session->userdata('status')

                    
                                    );
            }
            else {
                $search_params=array(
                                    'order_type_id'        => '',
                                    'distributor_id'       => '',
                                    'lifting_point_id'     => '',
                                    'fromDate'             => '',
                                    'toDate'               => '',
                                    'do_number'            => '',
                                    'product_id'           => '',
                                    'executive'           => '',
                                    'status'               => 1 // Default pending DOs will display                     
                                    );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'distributor_do_list/';
        # Total Records
        $config['total_rows'] = $this->Delivery_order_m->distributor_do_num_rows($search_params);

        $config['per_page'] = 100;
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
        $data['do_results'] = $this->Delivery_order_m->distributor_do_results($current_offset, $config['per_page'], $search_params);
        
        # Additional data
        $data['executives'] = $this->Common_model->get_data('executive');
        $data['display_results'] = 1;
        $this->load->view('delivery_orders/distributor_do_list',$data);
    }

   # View Distributor DO Products Details
    public function view_distributor_do()
    {
        $lifting_point_id  =  cmm_decode($this->uri->segment(2));
        $do_number  =  cmm_decode($this->uri->segment(3));
        if($lifting_point_id =='' || $do_number == '')
        {
            redirect(SITE_URL.'distributor_do_list'); exit();
        }

        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Distributor D.O. Products";
        $data['nestedView']['pageTitle'] = 'Distributor D.O. Products';
        $data['nestedView']['cur_page'] = 'distributor_do_r';
        $data['nestedView']['parent_page'] = 'reports';
        $data['nestedView']['list_page'] = 'do_reports';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Distributor D.O. Products','class'=>'active','url'=>'');
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/components-select2.js"></script>';

        $do_status = $this->Common_model->get_value('do',array('do_number'=>$do_number),'status');
        $do_details = $this->Delivery_order_m->get_do_details($do_number,$lifting_point_id);
        $do_products = $this->Delivery_order_m->get_do_products($do_number,$lifting_point_id,$do_status);
        if(count($do_products)>0)
        {
            foreach($do_products as $key => $prow)
            {
                $tot_invoice_qty = get_do_product_invoice_qty($prow['order_id'],$do_details['do_id'],$prow['product_id']);
                $do_quantity = $prow['do_quantity'];
                $do_products[$key]['raised_qty']  = $tot_invoice_qty;
                $do_products[$key]['pending_qty']  = ($do_quantity-$tot_invoice_qty);
            }
        }
        # flag = 1 (Displaying Order Booking First form)
        echo "<pre>";
        print_r($do_products); exit();
        $data['flag']   =   1;
        $data['do_products']   =   $do_products;
        $data['do_details'] = $do_details;
        $data['do_number']   =   $do_number;
        $data['lifting_point_id'] = $lifting_point_id;
        $this->load->view('delivery_orders/view_distributor_do_products_list',$data);
    }

    # Print DO Products 
    public function print_distributor_do_products()
    {
        # Get Order Id
        $do_id  =  cmm_decode($this->uri->segment(2));
        if($do_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
        else
        {  

            $do_number  =  cmm_decode($this->uri->segment(3));

            # Get Order_id based on do_id
           $order_id_arr = $this->Delivery_order_m->get_orders($do_id);

        foreach($order_id_arr as $key => $value)
        {
            //$do_results[$value['do_ob_id']]['do_ob_id']=$value['do_ob_id'];
            
            $do_ob_id  =  $this->Common_model->get_data('do_order',array('do_id'=>$value['do_id']));
            //echo "<pre>"; print_r($do_ob_id);exit;
            foreach($do_ob_id as $row) {
                //$do_results[$value['order_id']]['order_number']=$order_id;
                //$do_results[$value['do_ob_id']]['do_number']=$value['order_id'];
                $results=$this->Delivery_order_m->get_distributor_do_orders($value['order_id'],$row['do_id']);
                $do_results[$value['order_id']]['do_orders']=$results;
            }            
        }
            //$data['do_results'] = $this->Loose_oil_mrr_m->print_mrr_list_results($mrr_oil_id); 
           // echo $order_id;exit;
            $data['do_results']   =   $do_results;
            $this->load->view('delivery_orders/print_distributor_do_products',$data);
            
        }
    }

    # Download DO List
    public function download_do_list()
    {
        if($this->input->post('download_do')!='') {
            $from_date=(($this->input->post('fromDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('fromDate', TRUE))):''; 
            $to_date=(($this->input->post('toDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('toDate', TRUE))):''; 

            $search_params=array(
                                    'order_type_id'       => $this->input->post('order_type_id', TRUE),
                                    'distributor_id'      => $this->input->post('distributor_id', TRUE),
                                    'lifting_point_id'    => $this->input->post('lifting_point_id', TRUE),
                                    'fromDate'            => $from_date,
                                    'toDate'              => $to_date,
                                    'do_number'           => $this->input->post('do_number',TRUE),
                                    'product_id'          => $this->input->post('product_id',TRUE),
                                    'executive'           => $this->input->post('executive',TRUE),
                                    'status'              => $this->input->post('status',TRUE)            
                                );
            $do_list = $this->Delivery_order_m->download_do_list($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.No','DO Number','Distributor','lifting point','product','DO Qty','Pending Qty','Price','Value','Executive','Remarks','status');
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
            if(count($do_list)>0)
            {
                foreach($do_list as $row)
                {
                    
                    if($row['order_status']<=2) 
                    { 
                        $status = "Pending"; 
                    }
                    else 
                    {
                        $status = "completed"; 
                    }
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['do_number'].' / '.DateFormat($row['do_date']).'</td>';                   
                    $data.='<td align="center">'.$row['distributor_code'].' - ('.$row['agency_name'].')</td>';
                    $data.='<td align="center">'.$row['lifting_point'].'</td>';   
                    $data.='<td align="center">'.$row['product_name'].'</td>';  
                    $data.='<td align="right">'.$row['do_quantity'].'</td>';                   
                    $data.='<td align="right">'.$row['pending_qty'].'</td>'; 
                    $data.='<td align="right">'.price_format($row['product_price']).'</td>'; 
                    $data.='<td align="right">'.price_format($row['do_quantity']*$row['items_per_carton']*$row['product_price']).'</td>';
                    $data.='<td align="center">'.$row['executive_name'].'</td>';   
                    $data.='<td align="center">'.$row['remarks'].'</td>'; 
                    $data.='<td align="center">'.$status.'</td>';                
                    
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
            $xlFile='DOlist'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }

    # Print Distributor DO List
    public function print_distributor_do()
    {
        if($this->input->post('print_distributor_do')!='') {
            
           $from_date=(($this->input->post('fromDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('fromDate', TRUE))):''; 
            $to_date=(($this->input->post('toDate',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('toDate', TRUE))):''; 

            $search_params=array(
                                    'order_type_id'       => $this->input->post('order_type_id', TRUE),
                                    'distributor_id'      => $this->input->post('distributor_id', TRUE),
                                    'lifting_point_id'    => $this->input->post('lifting_point_id', TRUE),
                                    'fromDate'            => $from_date,
                                    'toDate'              => $to_date,
                                    'do_number'           => $this->input->post('do_number',TRUE),
                                    'product_id'          => $this->input->post('product_id',TRUE),
                                    'executive'           => $this->input->post('executive',TRUE),
                                    'status'              => $this->input->post('status',TRUE)
                                );
                             $data['search_data'] = $search_params;
            $data['do_results'] = $this->Delivery_order_m->download_do_list($search_params);
            $this->load->view('delivery_orders/print_distributor_do_results',$data);
            
        }
    }

    # Product wise pending DO list
    public function product_wise_pending_do()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Product Wise Pending D.O. Report";
        $data['nestedView']['pageTitle'] = 'Product Wise Pending D.O. Report';
        $data['nestedView']['cur_page'] = 'product_wise_pending_do';
        $data['nestedView']['parent_page'] = 'reports';
        $data['nestedView']['list_page'] = 'do_reports';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Product Wise Pending DO Report','class'=>'active','url'=>'');
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
            $plants      = $this->Plant_do_m->get_plants($block_id); 
            $lifting_points[$block_id]['block_name'] = $block_name;
            $lifting_points[$block_id]['plants']     = $plants;
        }
        $data['plant_block'] =$plant_block;
        $data['lifting_points'] =$lifting_points;



        $this->load->view('delivery_orders/report_product_wise_pending_do',$data);
    }

    # Print Product wise pending DO List
    public function print_product_wise_pending_do()
    {
        if($this->input->post('print_product_wise_pending_do')!='') {
            
            $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 

            $search_params=array(
                                    'lifting_point_id'    => $this->input->post('lifting_point_id', TRUE),
                                    'fromDate'            => $from_date,
                                    'toDate'              => $to_date            
                                );
            //echo '<pre>';print_r($search_params); exit;
            $data['search_params'] =    $search_params;
            $data['plant_name'] =   $this->Common_model->get_value('plant', array('plant_id'=>$this->input->post('lifting_point_id', TRUE)),'name');
            $data['loose_oils'] = $this->Common_model->get_data('loose_oil',array('status'=>1));

            //echo $this->db->last_query(); exit;
            $dop_results = $this->Delivery_order_m->product_wise_pending_do($search_params);
            // looping do products
            $oil_wise_records = array();
            if(count($dop_results)>0)
            {
                foreach($dop_results as $dop_row)
                {
                    if(array_key_exists(@$dop_row['loose_oil_id'], $oil_wise_records))
                    {
                        $oil_wise_records[@$dop_row['loose_oil_id']][@$dop_row['product_id']]= $dop_row;
                    }
                    else{
                        $oil_wise_records[@$dop_row['loose_oil_id']][@$dop_row['product_id']] = $dop_row;
                    }
                }
            }
            $data['do_results'] = $oil_wise_records;
            //echo '<pre>'; print_r($data['do_results']); exit;
            $this->load->view('delivery_orders/print_product_wise_pending_do',$data);
            
        }
    }

    //mahesh 16 may 2017, 09:53 PM
    public function get_institutions()
    {
        $agent_id = $this->input->post('distributor_id');
        // Get institutions under agent
        $results = $this->Common_model->get_data('distributor',array('agent_id'=>$agent_id));
        $data =  '<option value="">Select Agency</option>';
        if($results)
        {
            foreach ($results as $row) {
                $data .= '<option value="'.$row['distributor_id'].'">'.$row['distributor_code'].' - ('.$row['agency_name'].')</option>';
            }
        }

        echo $data;
    }
}