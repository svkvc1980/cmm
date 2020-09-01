<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Rollback_ob extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Rollback_ob_model");
	}

	public function ob_distributor()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage OB Distributor";
		$data['nestedView']['pageTitle'] = 'OB Distributor';
        $data['nestedView']['cur_page'] = 'Rollabck OB';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage DD', 'class' => 'active', 'url' => '');	

        $data['flag']=1;

        $this->load->view('rollback_ob/rollback_ob_distributor',$data);

    }

    public function rollback_ob_distributor()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage OB Distributor List";
        $data['nestedView']['pageTitle'] = 'OB Distributor List';
        $data['nestedView']['cur_page'] = 'Rollabck OB List';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OB Distributor', 'class' => 'active', 'url' => SITE_URL.'ob_distributor');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OB Distributor List', 'class' => 'active', 'url' => '');   

        $order_number=$this->input->post('order_number',TRUE);
        $order_id = $this->Rollback_ob_model->get_latest_order_id($order_number);
        if(!$order_id)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Order Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'ob_distributor');   
        }
        // chack order involved in do 
        $check = $this->Common_model->get_data('do_order',array('order_id'=>$order_id));
        if(count($check)>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Sorry!</strong> For this order do already raised. so first delete do. </div>');
            
            redirect(SITE_URL.'ob_distributor'); 
        }
        $results=$this->Rollback_ob_model->get_ob_data($order_id);  
        
        if(count($results)!='')
        {
          
            foreach($results as $key=>$value)
            {
                $product_do_qty = get_ob_product_do_qty($order_id,$value['product_id']);
                $ordered_qty = $value['quantity'];
                $results[$key]['pending_qty']  = ($ordered_qty-$product_do_qty);
            }
            $data['results']=$results;
            $data['distributor_list']=$this->Common_model->get_data('distributor',array('distributor_id!='=>0));
            $data['flag']=2;
        }
        else
        {
            
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Order Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'ob_distributor');
        }

        $this->load->view('rollback_ob/rollback_ob_distributor',$data);
    }

    public function insert_rollback_ob_distributor()
    {
        $distributor_id=$this->input->post('distributor_id',TRUE);
        $old_distributor_id=$this->input->post('old_distributor_id',TRUE);
        $order_number=$this->input->post('order_number',TRUE);
        $order_id=$this->input->post('order_id',TRUE);
        $existing_distributor_code=$this->input->post('distributor_code',TRUE);
            $new_distributor_code=$this->Common_model->get_value('distributor',array('distributor_id'=>$distributor_id),'distributor_code');
        if($distributor_id!='' && $distributor_id!=$old_distributor_id)
        {
            $this->db->trans_begin();
            $approval_number = get_approval_number();
            $issued_by = $this->session->userdata('block_designation_id');

            //echo $issued_by;exit;
            $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
            $pref = get_reporting_preference('change_ob_distributor','ob');
            // echo $this->db->last_query();exit;
            //echo '<pre>';print_r($pref);exit;
            if($issue_at=='')
            {
                $issue_at = $pref['issue_raised_by'];
            }
             $name="OB DISTRIBUTOR Has Changed From ".$existing_distributor_code." TO ".$new_distributor_code." For Order Number".$order_number;
           //echo $name;exit;
            $issue_closed_by = $pref['issue_closed_by'];
            if($issue_closed_by == $issued_by)
            {
                $status = 2;
                $issue_at = $issued_by;
                $single_level = 1;
            }
            else
            {
                $status = 1;
               $single_level =0;
            }

            
            $remarks = $this->input->post('remarks');
            $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                                   'approval_number'   => $approval_number,
                                   'primary_key'       => $order_id,
                                   'old_value'         => $old_distributor_id,
                                   'new_value'         => $distributor_id,
                                   'issue_at'          => $issue_at,
                                   'name'              => $name,
                                   'status'            => $status,
                                   'created_by'        => $this->session->userdata('user_id'),
                                   'created_time'      => date('Y-m-d H:i:s'));
            
            $approval_id = $this->Common_model->insert_data('approval_list',$approval_data);
            //echo $this->db->last_query();//exit;

            $approval_history_data = array('approval_id'       =>     $approval_id,
                                           'issued_by'         =>     $issued_by,
                                           'remarks'           =>     $remarks,
                                           'created_by'        =>     $this->session->userdata('user_id'),
                                           'created_time'      =>     date('Y-m-d H:i:s'));
            $this->Common_model->insert_data('approval_list_history',$approval_history_data);

            if($issue_closed_by == $issued_by)
            {
                //echo 'hello';exit;
                $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
                $pref_data = $this->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

                $old_distributor_id = $approval_data['old_value'];
                $new_distributor_id = $approval_data['new_value'];
                $order_id = $approval_data['primary_key'];                
                $name = $approval_data['name']; 

               
                $where=array('order_id'=>$order_id);
                $data=array(
                            'modified_by'       =>  $this->session->userdata('user_id'),
                            'modified_time'     =>  date('Y-m-d H:i:s')
                           );
                $this->Common_model->update_data('order',$data,$where);
                $qry='UPDATE distributor_order SET distributor_id='.$new_distributor_id.' WHERE order_id= '.$order_id;
                $this->db->query($qry);
                //echo $this->db->last_query().'<br>';exit;
                update_rb($approval_id,$name,$remarks,$single_level); //exit;   
                
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
                                    <strong>Success!</strong> OB Distributor Has Changed successfully From '.$existing_distributor_code.' To '.$new_distributor_code.' </div>');
                }
                redirect(SITE_URL.'ob_distributor');
            }
            if ($this->db->trans_status()===FALSE)
            { 

                $this->db->trans_rollback();
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>'); 
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Success!</strong> Change OB of Distributor Request successfully Raised With Request Number :'.$approval_number.' </div>');
            } 
            redirect(SITE_URL.'ob_distributor');
           

        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Select Another Distributor </div>');

            redirect(SITE_URL.'ob_distributor');
        }
        
    }

    public function ob_stocks()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage OB Stocks";
        $data['nestedView']['pageTitle'] = 'OB Stocks';
        $data['nestedView']['cur_page'] = 'Rollabck OB';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OB Stocks', 'class' => 'active', 'url' => '');   

        $data['flag']=1;

        $this->load->view('rollback_ob/rollback_ob_stocks',$data);

    }

    public function rollback_ob_stocks()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage OB Stocks List";
        $data['nestedView']['pageTitle'] = 'OB Stocks List';
        $data['nestedView']['cur_page'] = 'Rollabck OB List';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OB Stocks', 'class' => 'active', 'url' => SITE_URL.'ob_stocks');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OB Stocks List', 'class' => 'active', 'url' => '');   
        $order_number=$this->input->post('order_number',TRUE);
        $order_id = $this->Rollback_ob_model->get_latest_order_id($order_number);
        if(!$order_id)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Order Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'ob_distributor');   
        }
        // chack order involved in do 
        $check = $this->Common_model->get_data('do_order',array('order_id'=>$order_id));
        if(count($check)>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Sorry!</strong> For this order do already raised. so first delete do. </div>');
            
            redirect(SITE_URL.'ob_distributor'); 
        }
        $results=$this->Rollback_ob_model->get_ob_data($order_id); 
        
        if(count($results)!='')
        {
          
            foreach($results as $key=>$value)
            {
                $product_do_qty = get_ob_product_do_qty($order_id,$value['product_id']);
                $ordered_qty = $value['quantity'];
                $results[$key]['pending_qty']  = ($ordered_qty-$product_do_qty);
            }
            $data['results']=$results;
            $data['flag']=2;
        }
        else
        {
            
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Order Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'ob_stocks');
        }

        $this->load->view('rollback_ob/rollback_ob_stocks',$data);
    }
    public function insert_rollback_ob_stocks()
    {
        
        $old_distributor_id=$this->input->post('old_distributor_id',TRUE);
        $order_number=$this->input->post('order_number',TRUE);
        $order_id=$this->input->post('order_id',TRUE);
        $product_id=$this->input->post('product_id',TRUE);
        $old_stock=$this->input->post('old_stock',TRUE);
        $new_stock=$this->input->post('new_stock',TRUE);
        //$pending_qty=$this->input->post('pending_qty',TRUE);
        $existing_distributor_code=$this->input->post('distributor_code',TRUE);
        
        
            $this->db->trans_begin();
            $approval_number = get_approval_number();
            $issued_by = $this->session->userdata('block_designation_id');

            //echo $issued_by;exit;
            $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
            $pref = get_reporting_preference('change_ob_stock','ob');
            // echo $this->db->last_query();exit;
            //echo '<pre>';print_r($pref);exit;
            if($issue_at=='')
            {
                $issue_at = $pref['issue_raised_by'];
            }
            $name="Order Number ".$order_number." Having Product ".get_product_name($product_id)." Quantity Changed From".$old_stock." TO" .$new_stock;
           //echo $name;exit;
            $issue_closed_by = $pref['issue_closed_by'];
            if($issue_closed_by == $issued_by)
            {
                $status = 2;
                $issue_at = $issued_by;
                $single_level = 1;
            }
            else
            {
                $status = 1;
               $single_level =0;
            }

            $old_value = $order_id.','.$product_id;
            $new_value = $old_stock.','.$new_stock;
            $remarks = $this->input->post('remarks');
            $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                                   'approval_number'   => $approval_number,
                                   
                                   'old_value'         => $old_value,
                                   'new_value'         => $new_value,
                                   'issue_at'          => $issue_at,
                                   'name'              => $name,
                                   'status'            => $status,
                                   'created_by'        => $this->session->userdata('user_id'),
                                   'created_time'      => date('Y-m-d H:i:s'));
            
            $approval_id = $this->Common_model->insert_data('approval_list',$approval_data);
            //echo $this->db->last_query();//exit;

            $approval_history_data = array('approval_id'       =>     $approval_id,
                                           'issued_by'         =>     $issued_by,
                                           'remarks'           =>     $remarks,
                                           'created_by'        =>     $this->session->userdata('user_id'),
                                           'created_time'      =>     date('Y-m-d H:i:s'));
            $this->Common_model->insert_data('approval_list_history',$approval_history_data);

            if($issue_closed_by == $issued_by)
            {
                //echo 'hello';exit;
                $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
                $pref_data = $this->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

                $op_ids = $approval_data['old_value'];
                $old_new_stock = $approval_data['new_value'];
                
                $name = $approval_data['name']; 

                $ob_pro_id_arr = explode(",",$op_ids);
                //print_r($ob_pro_id_arr);exit;
                $order_id = $ob_pro_id_arr[0];
                $product_id = $ob_pro_id_arr[1];


                $old_new_data = explode(",",$old_new_stock);
                //print_r($ob_pro_id_arr);exit;
                $old_stock = $old_new_data[0];
                $new_stock = $old_new_data[1];

                $op_where=array('order_id'=>$order_id,'product_id'=>$product_id);
                /*$where=array('order_id'=>$order_id);
                $data=array(
                            'modified_by'       =>  $this->session->userdata('user_id'),
                            'modified_time'     =>  date('Y-m-d H:i:s')
                           );
                $this->Common_model->update_data('order',$data,$where);*/

                $op_data=array(
                            'quantity'          => $new_stock,
                            'modified_by'       =>  $this->session->userdata('user_id'),
                            'modified_time'     =>  date('Y-m-d H:i:s')
                           );
                $this->Common_model->update_data('order_product',$op_data,$op_where);


                
                //echo $this->db->last_query().'<br>';exit;
                update_rb($approval_id,$name,$remarks,$single_level); //exit;   
                
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
                                    <strong>Success!</strong> OB Stock Has Changed successfully For '.$name.' With Request Number :'.$approval_number.' </div>');
                }
                redirect(SITE_URL.'ob_stocks');
            }
            if ($this->db->trans_status()===FALSE)
            { 

                $this->db->trans_rollback();
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Something went wrong. Please check. </div>'); 
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Success!</strong> Change of OB Stock Request successfully Raised With Request Number :'.$approval_number.' </div>');
            } 
            redirect(SITE_URL.'ob_stocks');  
        
    }

    
    public function ob_activate()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage OB Stocks Activate";
        $data['nestedView']['pageTitle'] = 'OB Stocks Activate';
        $data['nestedView']['cur_page'] = 'Rollabck OB Activate';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OB Stocks Activate', 'class' => 'active', 'url' => '');   

        $data['flag']=1;

        $this->load->view('rollback_ob/rollback_ob_activate',$data);

    }

    public function rollback_ob_activate()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage OB Stocks List Activate";
        $data['nestedView']['pageTitle'] = 'OB Stocks List Activate';
        $data['nestedView']['cur_page'] = 'Rollabck OB List Activate';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OB Stocks Activate', 'class' => 'active', 'url' => SITE_URL.'ob_activate');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OB Stocks List Activate', 'class' => 'active', 'url' => '');   

        $order_number=$this->input->post('order_number',TRUE);
        $order_results=$this->Rollback_ob_model->get_order_id($order_number);
        $order_id=$order_results['order_id'];
        if($order_results['type']==1)
        {
            $results=$this->Rollback_ob_model->get_ob_data($order_id); 
            $data['type']=$order_results['type']; 
        }
        else
        {
            $results=$this->Rollback_ob_model->get_plant_ob_data($order_id);
            $data['type']=$order_results['type'];
        }
        if(count($results)!='')
        {
          
            foreach($results as $key=>$value)
            {
                $product_do_qty = get_ob_product_do_qty($order_id,$value['product_id']);
                $ordered_qty = $value['quantity'];
                $results[$key]['pending_qty']  = ($ordered_qty-$product_do_qty);
            }
            $data['results']=$results;
            $data['flag']=2;
        }
        else
        {
            
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Order Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'ob_activate');
        }

        $this->load->view('rollback_ob/rollback_ob_activate',$data);
    }

     public function insert_rollback_ob_activate()
    {
       
        $order_id = $this->input->post('order_id',TRUE);
        if($order_id == '')
        {
            redirect(SITE_URL.'ob_activate'); exit();
        }
        $order_number=$this->input->post('order_number');
        $order_details = $this->Common_model->get_data_row('order',array('order_id'=>$order_id));
        $remarks = $this->input->post('remarks',TRUE);
        $order_product_id=$this->input->post('order_product_id');
       
        $name="Order Booking is successfully activated for Order Number :( ".$order_number.") ";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('activate_order_booking','order_booking');
        if($issue_at=='')
        {
            $issue_at = $pref['issue_raised_by'];
        }

        $issue_closed_by = $pref['issue_closed_by'];
        if($issue_closed_by == $issued_by)
        {
            $status = 2;
            $issue_at = $issued_by;
        }
        else
        {
            $status = 1;
        }   
        $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                               'approval_number'   => $approval_number,
                               'primary_key'       => $order_id,
                               'old_value'         => json_encode($order_details),
                               'issue_at'          => $issue_at,
                               'name'              => $name,
                               'status'            => $status,
                               'created_by'        => $this->session->userdata('user_id'),
                               'created_time'      => date('Y-m-d H:i:s'));
        $this->db->trans_begin();
        $approval_id = $this->Common_model->insert_data('approval_list',$approval_data);

        $approval_history_data = array('approval_id'       =>     $approval_id,
                                       'issued_by'         =>     $issued_by,
                                       'remarks'           =>     $remarks,
                                       'created_by'        =>     $this->session->userdata('user_id'),
                                       'created_time'      =>     date('Y-m-d H:i:s'));
        $this->Common_model->insert_data('approval_list_history',$approval_history_data);

        if($issue_closed_by == $issued_by)
        {
            $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
            $pref_data = $this->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

            $primary_key = $approval_data['primary_key'];
           
            //updating status of order booking
            $this->Common_model->update_data('order',array('status'=>1),array('order_id'=> $order_id));
            //updating status of ob product
            foreach($order_product_id as $op_id )
            {
               $this->Common_model->update_data('order_product',array('status'=>1),array('order_product_id'=> $op_id));  
            }

            $update_approval_data = array('status'        => 2,
                                          'modified_by'   => $this->session->userdata('user_id'),
                                          'modified_time' => date('Y-m-d H:i:s'));
            $updata_approval_where = array('approval_id'  => $approval_id);
            $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);


            $daily_data=  array('activity'      =>  $name,
                                'created_by'    =>  $this->session->userdata('user_id'),
                                'created_time'  =>  date('Y-m-d H:i:s')
                                );
            $this->Common_model->insert_data('daily_corrections',$daily_data);
        }
        if ($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Error!</strong> Something went wrong. Please check. </div>'); 
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Success!</strong>Order Booking is successfully activated With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'ob_activate'); exit();
       
    }

    public function ob_product_activate()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage OB Product Activate";
        $data['nestedView']['pageTitle'] = 'OB Product Activate';
        $data['nestedView']['cur_page'] = 'Rollabck OB Product Activate';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OB Product Activate', 'class' => 'active', 'url' => '');   

        $data['flag']=1;

        $this->load->view('rollback_ob/rollback_ob_product_activate',$data);

    }

    public function rollback_ob_product_activate()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage OB Product List Activate";
        $data['nestedView']['pageTitle'] = 'OB Product List Activate';
        $data['nestedView']['cur_page'] = 'Rollabck OB Product List Activate';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OB Product Activate', 'class' => 'active', 'url' => SITE_URL.'ob_product_activate');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OB Product List Activate', 'class' => 'active', 'url' => '');   

        $order_number=$this->input->post('order_number',TRUE);
        $order_results=$this->Rollback_ob_model->get_order_id($order_number);
        $order_id=$order_results['order_id'];
        if($order_results['type']==1)
        {
            $results=$this->Rollback_ob_model->get_ob_data($order_id); 
            $data['type']=$order_results['type']; 
        }
        else
        {
            $results=$this->Rollback_ob_model->get_plant_ob_data($order_id);
            $data['type']=$order_results['type'];
        }  
        
        if(count($results)!='')
        {
          
            foreach($results as $key=>$value)
            {
                $product_do_qty = get_ob_product_do_qty($order_id,$value['product_id']);
                $ordered_qty = $value['quantity'];
                $results[$key]['pending_qty']  = ($ordered_qty-$product_do_qty);
            }
            $data['results']=$results;
            $data['flag']=2;
        }
        else
        {
            
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Order Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'ob_product_activate');
        }

        $this->load->view('rollback_ob/rollback_ob_product_activate',$data);
    }
    

     public function insert_rollback_product_ob_activate()
    {
       
        $order_id = $this->input->post('order_id',TRUE);
        if($order_id == '')
        {
            redirect(SITE_URL.'ob_product_activate'); exit();
        }
        $order_number  = $this->input->post('order_number');
        $remarks       = $this->input->post('remarks',TRUE);
        $order_product_id=$this->input->post('order_product_id');
        $name="Order Booking for products is successfully activated for Order Number :( ".$order_number.") ";
        foreach($order_product_id as $op_id)
        {    
            $op_ids[]=$op_id;
             
        }
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('activate_product_order_booking','order_booking');
        if($issue_at=='')
        {
            $issue_at = $pref['issue_raised_by'];
        }

        $issue_closed_by = $pref['issue_closed_by'];
        if($issue_closed_by == $issued_by)
        {
            $status = 2;
            $issue_at = $issued_by;
        }
        else
        {
            $status = 1;
        }   
        $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                               'approval_number'   => $approval_number,
                               'primary_key'       => $order_id,
                               'old_value'         => json_encode($op_ids),
                               'issue_at'          => $issue_at,
                               'name'              => $name,
                               'status'            => $status,
                               'created_by'        => $this->session->userdata('user_id'),
                               'created_time'      => date('Y-m-d H:i:s'));
        $this->db->trans_begin();
        $approval_id = $this->Common_model->insert_data('approval_list',$approval_data);

        $approval_history_data = array('approval_id'       =>     $approval_id,
                                       'issued_by'         =>     $issued_by,
                                       'remarks'           =>     $remarks,
                                       'created_by'        =>     $this->session->userdata('user_id'),
                                       'created_time'      =>     date('Y-m-d H:i:s'));
        $this->Common_model->insert_data('approval_list_history',$approval_history_data);

        if($issue_closed_by == $issued_by)
        {
            $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
            $pref_data = $this->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

            $primary_key = $approval_data['primary_key'];
           
           //updating status of ob product
            foreach($order_product_id as $op_id )
            {
               $this->Common_model->update_data('order_product',array('status'=>1),array('order_product_id'=> $op_id));  
            }

            $update_approval_data = array('status'        => 2,
                                          'modified_by'   => $this->session->userdata('user_id'),
                                          'modified_time' => date('Y-m-d H:i:s'));
            $updata_approval_where = array('approval_id'  => $approval_id);
            $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);


            $daily_data=  array('activity'      =>  $name,
                                'created_by'    =>  $this->session->userdata('user_id'),
                                'created_time'  =>  date('Y-m-d H:i:s')
                                );
            $this->Common_model->insert_data('daily_corrections',$daily_data);
        }
        if ($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Error!</strong> Something went wrong. Please check. </div>'); 
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Success!</strong>Order Booking is successfully activated With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'ob_product_activate'); exit();
       
    }

    public function ob_product_delete()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage OB Product Delete";
        $data['nestedView']['pageTitle'] = 'OB Product Delete';
        $data['nestedView']['cur_page'] = 'Rollabck OB Product Delete';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OB Product Delete', 'class' => 'active', 'url' => '');   

        $data['flag']=1;

        $this->load->view('rollback_ob/rollback_ob_product_delete',$data);

    }

    public function rollback_ob_product_delete()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage OB Product List Delete";
        $data['nestedView']['pageTitle'] = 'OB Product List Delete';
        $data['nestedView']['cur_page'] = 'Rollabck OB Product List Delete';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OB Product Delete', 'class' => 'active', 'url' => SITE_URL.'ob_product_delete');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OB Product List Delete', 'class' => 'active', 'url' => '');   

        $order_number=$this->input->post('order_number',TRUE);
         $order_results=$this->Rollback_ob_model->get_order_id($order_number);
        $order_id=$order_results['order_id'];
        if($order_results['type']==1)
        {
            $results=$this->Rollback_ob_model->get_ob_data($order_id); 
            $data['type']=$order_results['type']; 
        }
        else
        {
            $results=$this->Rollback_ob_model->get_plant_ob_data($order_id);
            $data['type']=$order_results['type'];
        }  
        
        if(count($results)!='')
        {
          
            foreach($results as $key=>$value)
            {
                $product_do_qty = get_ob_product_do_qty($order_id,$value['product_id']);
                $ordered_qty = $value['quantity'];
                $results[$key]['pending_qty']  = ($ordered_qty-$product_do_qty);
            }
            $data['results']=$results;
            $data['flag']=2;
        }
        else
        {
            
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Order Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'ob_product_delete');
        }

        $this->load->view('rollback_ob/rollback_ob_product_delete',$data);
    }

      public function change_rollback_ob_product_delete()
    {
       
        $order_id = $this->input->post('order_id',TRUE);
        if($order_id == '')
        {
            redirect(SITE_URL.'ob_product_delete'); exit();
        }
        $order_number  = $this->input->post('order_number');
        $remarks       = $this->input->post('remarks',TRUE);
        $order_product_id=$this->input->post('order_product_id');
        $name="Order Booking for products is successfully deleted for Order Number :( ".$order_number.") ";
        foreach($order_product_id as $op_id)
        {    
            $op_ids[]=$op_id;
             
        }
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('delete_order_booking_product','order_booking');
        if($issue_at=='')
        {
            $issue_at = $pref['issue_raised_by'];
        }

        $issue_closed_by = $pref['issue_closed_by'];
        if($issue_closed_by == $issued_by)
        {
            $status = 2;
            $issue_at = $issued_by;
        }
        else
        {
            $status = 1;
        }   
        $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                               'approval_number'   => $approval_number,
                               'primary_key'       => $order_id,
                               'old_value'         => json_encode($op_ids),
                               'issue_at'          => $issue_at,
                               'name'              => $name,
                               'status'            => $status,
                               'created_by'        => $this->session->userdata('user_id'),
                               'created_time'      => date('Y-m-d H:i:s'));
        $this->db->trans_begin();
        $approval_id = $this->Common_model->insert_data('approval_list',$approval_data);

        $approval_history_data = array('approval_id'       =>     $approval_id,
                                       'issued_by'         =>     $issued_by,
                                       'remarks'           =>     $remarks,
                                       'created_by'        =>     $this->session->userdata('user_id'),
                                       'created_time'      =>     date('Y-m-d H:i:s'));
        $this->Common_model->insert_data('approval_list_history',$approval_history_data);

        if($issue_closed_by == $issued_by)
        {
            $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
            $pref_data = $this->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

            $primary_key = $approval_data['primary_key'];
           
           //updating status of ob product
            foreach($order_product_id as $op_id )
            {
               $this->Common_model->delete_data('order_product',array('order_product_id'=> $op_id));  
            }

            $update_approval_data = array('status'        => 2,
                                          'modified_by'   => $this->session->userdata('user_id'),
                                          'modified_time' => date('Y-m-d H:i:s'));
            $updata_approval_where = array('approval_id'  => $approval_id);
            $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);


            $daily_data=  array('activity'      =>  $name,
                                'created_by'    =>  $this->session->userdata('user_id'),
                                'created_time'  =>  date('Y-m-d H:i:s')
                                );
            $this->Common_model->insert_data('daily_corrections',$daily_data);
        }
        if ($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Error!</strong> Something went wrong. Please check. </div>'); 
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Success!</strong>Order Booking products are successfully deleted With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'ob_product_delete'); exit();
       
    }
    public function ob_delete()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Delete Complete OB";
        $data['nestedView']['pageTitle'] = 'Delete Complete OB';
        $data['nestedView']['cur_page'] = 'Delete Complete OB';
        $data['nestedView']['parent_page'] = 'rollback';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Delete Complete OB', 'class' => 'active', 'url' => '');   

        $data['flag']=1;

        $this->load->view('rollback_ob/rollback_ob_delete',$data);

    }

    public function rollback_ob_delete()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Delete Complete OB";
        $data['nestedView']['pageTitle'] = 'Delete Complete OB';
        $data['nestedView']['cur_page'] = 'Delete Complete OB';
        $data['nestedView']['parent_page'] = 'rollabck';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Delete Complete OB', 'class' => 'active', 'url' => SITE_URL.'ob_activate');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'OB Details', 'class' => 'active', 'url' => '');   

        $order_number=$this->input->post('order_number',TRUE);
        $order_results=$this->Rollback_ob_model->get_order_id($order_number);
        $order_id=$order_results['order_id'];

        $ob_details = $this->Common_model->get_data_row('order',array('order_id'=>$order_id));
        if(count($ob_details)>0)
        {
             if($ob_details['status']!=1)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <strong>Error!</strong> D.O. Is Partially/Completely generated for order number : '.$order_number.' Please Check !!. </div>');
                
                redirect(SITE_URL.'ob_delete'); exit();
            }
        }
       
        if($order_results['type']==1)
        {
            $results=$this->Rollback_ob_model->get_ob_data($order_id); 
            $data['type']=$order_results['type']; 
        }
        else
        {
            $results=$this->Rollback_ob_model->get_plant_ob_data($order_id);
            $data['type']=$order_results['type'];
        }
        if(count($results)!='')
        {
          
            foreach($results as $key=>$value)
            {
                $product_do_qty = get_ob_product_do_qty($order_id,$value['product_id']);
                $ordered_qty = $value['quantity'];
                $results[$key]['pending_qty']  = ($ordered_qty-$product_do_qty);
            }
            $data['results']=$results;
            $data['flag']=2;
        }
        else
        {
            
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Order Number : '.$order_number.' Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'ob_delete'); exit();
        }

        $this->load->view('rollback_ob/rollback_ob_delete',$data);
    }

    public function insert_rb_ob_delete()
    {
        $order_id = $this->input->post('order_id',TRUE);
        if($order_id == '')
        {
            redirect(SITE_URL.'ob_delete'); exit();
        }
        $order_number  = $this->input->post('order_number');
        $remarks       = $this->input->post('remarks',TRUE);
        $name="Delete Complete Order Booking for Order Number :( ".$order_number.") ";

        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('delete_complete_ob','order_booking');
        if($issue_at=='')
        {
            $issue_at = $pref['issue_raised_by'];
        }

        $issue_closed_by = $pref['issue_closed_by'];
        if($issue_closed_by == $issued_by)
        {
            $status = 2;
            $issue_at = $issued_by;
        }
        else
        {
            $status = 1;
        }   
        $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                               'approval_number'   => $approval_number,
                               'primary_key'       => $order_id,
                               'issue_at'          => $issue_at,
                               'name'              => $name,
                               'status'            => $status,
                               'created_by'        => $this->session->userdata('user_id'),
                               'created_time'      => date('Y-m-d H:i:s'));
        $this->db->trans_begin();
        $approval_id = $this->Common_model->insert_data('approval_list',$approval_data);

        $approval_history_data = array('approval_id'       =>     $approval_id,
                                       'issued_by'         =>     $issued_by,
                                       'remarks'           =>     $remarks,
                                       'created_by'        =>     $this->session->userdata('user_id'),
                                       'created_time'      =>     date('Y-m-d H:i:s'));
        $this->Common_model->insert_data('approval_list_history',$approval_history_data);

        if($issue_closed_by == $issued_by)
        {
            $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
            $pref_data = $this->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

            $primary_key = $approval_data['primary_key'];
           
           //Delete Ob
            $this->Common_model->delete_data('order_product',array('order_id'=> $primary_key));  
            

            $available = $this->Common_model->get_data_row('distributor_order',array('order_id'=>$order_id));
            if(count($available)>0)
            {
                $this->Common_model->delete_data('distributor_order',array('order_id'=> $primary_key));   
            }
            else
            {
                $this->Common_model->delete_data('plant_order',array('order_id'=> $primary_key));   
            }
            $this->Common_model->delete_data('order',array('order_id'=> $primary_key)); 
            
            

            $update_approval_data = array('status'        => 2,
                                          'modified_by'   => $this->session->userdata('user_id'),
                                          'modified_time' => date('Y-m-d H:i:s'));
            $updata_approval_where = array('approval_id'  => $approval_id);
            $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);


            $daily_data=  array('activity'      =>  $name,
                                'created_by'    =>  $this->session->userdata('user_id'),
                                'created_time'  =>  date('Y-m-d H:i:s')
                                );
            $this->Common_model->insert_data('daily_corrections',$daily_data);
        }
        if ($this->db->trans_status()===FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Error!</strong> Something went wrong. Please check. </div>'); 
        }
        else
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Success!</strong>Order Booking are successfully deleted With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'ob_delete'); exit();
    }
    
}