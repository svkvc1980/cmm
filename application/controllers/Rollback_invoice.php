<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Rollback_invoice extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Rollback_invoice_m");
    }
    //gowri
    //invoice Date Change 
    public function date_change()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Invoice Date Change';
        $data['nestedView']['heading'] = "Invoice Date Change";
        $data['nestedView']['cur_page'] = 'Invoice Date Change';
        $data['nestedView']['parent_page'] = 'date_change';
        $data['nestedView']['list_page'] = 'date_change';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Date Change','class'=>'active','url'=>'');
       
        

        $data['flag']=1;
        $this->load->view('rollback_invoice/rollback_invoice_view',$data);
    }

    public function date_change_details()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Invoice Date Change Details';
        $data['nestedView']['heading'] = "Invoice Date Change Details";
        $data['nestedView']['cur_page'] = 'Invoice Date Change Details';
        $data['nestedView']['parent_page'] = 'date_change';
        $data['nestedView']['list_page'] = 'date_change';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Invoice Date Change','class'=>'active','url'=>SITE_URL.'date_change'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Invoice Date Change Details','class'=>'active','url'=>'');

        $invoice_number=$this->input->post('invoice_id',TRUE);
        $invoice_id=$this->Rollback_invoice_m->get_invoice_id($invoice_number);
        $count_receipt_invoice = $this->Common_model->get_data('receipt_invoice',array('invoice_id'=>$invoice_id));
        $count_gatepass = $this->Common_model->get_data('gatepass_invoice',array('invoice_id'=>$invoice_id));
        if(count($count_receipt_invoice)>0 || count($count_gatepass)>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <strong>Error!</strong> Invoice is involved in Gatepass/StockReceiving. Please Check! </div>');
            redirect(SITE_URL.'date_change'); exit();
        }
        $invoice_type=$this->Rollback_invoice_m->get_invoice_type($invoice_id);
        //print_r($invoice_type) ; exit;
        if($invoice_type['type'] == 2)
        {
           
            $invoice_plant_products=$this->Rollback_invoice_m->get_invoice_do_product($invoice_id);
            
            if(count($invoice_plant_products)!='')
            {
                
                foreach($invoice_plant_products as $key => $value)
                {
                    $results['invoice_date']=$value['invoice_date'];
                    $results['vehicle_number']=$value['vehicle_number'];
                    $results['from']=$value['from'];
                    $results['to']=$value['to'];
                    $results['invoice_number']=$value['invoice_number'];
                    $results['invoice_id'] = $value['invoice_id'];
                    
                }
                //echo "<pre>"; print_r($invoice_plant_products); exit;
                $col=array_column($invoice_plant_products,'amount');
                $sum=array_sum($col);
                $data['sum']=$sum;
                $inv_dos= $this->Rollback_invoice_m->get_invoice_dos($invoice_id);
                $inv_obs= $this->Rollback_invoice_m->get_invoice_obs($invoice_id);
                foreach ($inv_dos as $value)
                {
                  $d[]=$value['do_number'];
                  $do_date[] =date('d-m-Y',strtotime($value['do_date']));
                }        
                $data['inv_dos'] =implode(', ',$d);
                $data['inv_do_dates'] =implode(', ',$do_date);
                $data['tin_num']=37280114257;
                foreach ($inv_obs as $value) 
                {
                  $ob[]=$value['order_number'];
                  $ob_date[] =date('d-m-Y',strtotime($value['order_date']));
                }
                
                $data['inv_obs'] =implode(', ',$ob);
                $data['inv_ob_dates'] =implode(', ',$ob_date);
                $data['results']=$results;
                $data['invoice_plant_product']=$invoice_plant_products;
                $data['flag']=3;
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <strong>Error!</strong> Invoice Number Is Not Exist. Please check. </div>');
                
                redirect(SITE_URL.'date_change');
            }
        }
        
        elseif($invoice_type['type']== 1)
        {
            $invoice_dist_products=$this->Rollback_invoice_m->get_invoice_do_distributor_product($invoice_id);
            
            if(count($invoice_dist_products)!='')
            {
                foreach($invoice_dist_products as $key => $value)
                {
                    $results['invoice_date']=$value['invoice_date'];
                    $results['distributor_code']=$value['distributor_code'];
                    $results['tin_num']=$value['vat_no'];
                    $results['mobile']=$value['mobile'];
                    $results['vehicle_number']=$value['vehicle_number'];
                    $results['amount']=$value['amount'];
                    $results['agency_name']=$value['agency_name'];
                    $results['address']=$value['address'];
                    $results['lifting']=$value['lifting'];
                    $results['location']=$value['distributor_place'];
                    $results['invoice_number']=$value['invoice_number'];
                    $results['invoice_id'] = $value['invoice_id'];
                    
                }
                $col=array_column($invoice_dist_products,'amount');
                $sum=array_sum($col);
                $data['sum']=$sum;
                $inv_dos= $this->Rollback_invoice_m->get_invoice_dos($invoice_id);
                $inv_obs= $this->Rollback_invoice_m->get_invoice_obs($invoice_id);
                foreach ($inv_dos as $value)
                {
                  $d[]=$value['do_number'];
                  $do_date[] =date('d-m-Y',strtotime($value['do_date']));
                }        
                $data['inv_dos'] =implode(', ',$d);
                $data['inv_do_dates'] =implode(', ',$do_date);

                foreach ($inv_obs as $value) 
                {
                  $ob[]=$value['order_number'];
                  $ob_date[] =date('d-m-Y',strtotime($value['order_date']));
                }
                
                $data['inv_obs'] =implode(', ',$ob);
                $data['inv_ob_dates'] =implode(', ',$ob_date);
                $data['results']=$results;
                $data['invoice_dist_product']=$invoice_dist_products;
                $data['flag']=2;
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <strong>Error!</strong> Invoice Number Is Not Exist. Please check. </div>');
                
                redirect(SITE_URL.'date_change');
            }
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Invoice Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'date_change');
        }
        
        
        
        $this->load->view('rollback_invoice/rollback_invoice_view',$data);
    }

   
    public function insert_rollback_date()
    {
        $invoice_id = $this->input->post('invoice_id',TRUE);
        if($invoice_id=='')
        {
            redirect(SITE_URL.'date_change'); exit();
        }
        $new_invoice_date = date('Y-m-d',strtotime($this->input->post('new_invoice_date',TRUE)));
        $invoice_details = $this->Common_model->get_data_row('invoice',array('invoice_id'=>$invoice_id));

        if($new_invoice_date == $invoice_details['invoice_date'])
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Same Combination Is Given .Please Check !</div>');
            redirect(SITE_URL.'date_change'); exit();
             
        }
        $remarks = $this->input->post('remarks',TRUE);
        $name="Invoice Date changed from :".format_date($invoice_details['invoice_date'])." TO :".format_date($new_invoice_date)." For Invoice Number : ".$invoice_details['invoice_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('change_invoice_date','invoice_details');
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
                               'primary_key'       => $invoice_id,
                               'old_value'         => $invoice_details['invoice_date'],
                               'new_value'         => $new_invoice_date,
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
            update_single_column_rollback($approval_id,$name,$remarks);
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
                            <strong>Success!</strong> Invoice Date Has Been Changed successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'date_change'); exit();
    }

    public function delete_invoice()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Invoice Delete';
        $data['nestedView']['heading'] = "Invoice Delete";
        $data['nestedView']['cur_page'] = 'Invoice Delete';
        $data['nestedView']['parent_page'] = 'date_change';
        $data['nestedView']['list_page'] = 'date_change';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Date Change','class'=>'active','url'=>'');
       
        

        $data['flag']=1;
        $this->load->view('rollback_invoice/rollback_invoice_delete_view',$data);
    }

    public function rollback_invoice_delete()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Invoice Delete Details';
        $data['nestedView']['heading'] = "Invoice Delete Details";
        $data['nestedView']['cur_page'] = 'Invoice Delete Details';
        $data['nestedView']['parent_page'] = 'date_change';
        $data['nestedView']['list_page'] = 'date_change';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Invoice Delete','class'=>'active','url'=>SITE_URL.'delete_invoice'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Invoice Delete Details','class'=>'active','url'=>'');

        $invoice_number=$this->input->post('invoice_id',TRUE);
        $invoice_id=$this->Rollback_invoice_m->get_invoice_id($invoice_number);
        $count_receipt_invoice = $this->Common_model->get_data('receipt_invoice',array('invoice_id'=>$invoice_id));
        $count_gatepass = $this->Common_model->get_data('gatepass_invoice',array('invoice_id'=>$invoice_id));
        if(count($count_receipt_invoice)>0 || count($count_gatepass)>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <strong>Error!</strong> Invoice is involved in Gatepass/StockReceiving. Please Check! </div>');
            redirect(SITE_URL.'delete_invoice'); exit();
        }
        $invoice_type=$this->Rollback_invoice_m->get_invoice_type($invoice_id);
        if($invoice_type['type'] == 2)
        {
           
            $invoice_plant_products=$this->Rollback_invoice_m->get_invoice_do_product($invoice_id);
            
            if(count($invoice_plant_products)!='')
            {
                
                foreach($invoice_plant_products as $key => $value)
                {
                    $results['invoice_date']=$value['invoice_date'];
                    $results['vehicle_number']=$value['vehicle_number'];
                    $results['from']=$value['from'];
                    $results['to']=$value['to'];
                    $results['invoice_number']=$value['invoice_number'];
                    $results['invoice_id']=$value['invoice_id'];
                    
                }
                //echo "<pre>"; print_r($invoice_plant_products); exit;
                $col=array_column($invoice_plant_products,'amount');
                $sum=array_sum($col);
                $data['sum']=$sum;
                $inv_dos= $this->Rollback_invoice_m->get_invoice_dos($invoice_id);
                $inv_obs= $this->Rollback_invoice_m->get_invoice_obs($invoice_id);
                foreach ($inv_dos as $value)
                {
                  $d[]=$value['do_number'];
                  $do_date[] =date('d-m-Y',strtotime($value['do_date']));
                }        
                $data['inv_dos'] =implode(', ',$d);
                $data['inv_do_dates'] =implode(', ',$do_date);
                $data['tin_num']=37280114257;
                foreach ($inv_obs as $value) 
                {
                  $ob[]=$value['order_number'];
                  $ob_date[] =date('d-m-Y',strtotime($value['order_date']));
                }
                
                $data['inv_obs'] =implode(', ',$ob);
                $data['inv_ob_dates'] =implode(', ',$ob_date);
                $data['results']=$results;
                $data['invoice_plant_product']=$invoice_plant_products;
                $data['flag']=3;
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <strong>Error!</strong> Invoice Number Is Not Exist. Please check. </div>');
                
                redirect(SITE_URL.'delete_invoice');
            }
        }
        elseif($invoice_type['type']== 1)
        {
            $invoice_dist_products=$this->Rollback_invoice_m->get_invoice_do_distributor_product($invoice_id);
            
            if(count($invoice_dist_products)!='')
            {
                foreach($invoice_dist_products as $key => $value)
                {
                    $results['invoice_date']=$value['invoice_date'];
                    $results['distributor_code']=$value['distributor_code'];
                    $results['tin_num']=$value['vat_no'];
                    $results['mobile']=$value['mobile'];
                    $results['vehicle_number']=$value['vehicle_number'];
                    $results['amount']=$value['amount'];
                    $results['agency_name']=$value['agency_name'];
                    $results['address']=$value['address'];
                    $results['lifting']=$value['lifting'];
                    $results['location']=$value['distributor_place'];
                    $results['invoice_number']=$value['invoice_number'];
                    $results['invoice_id']=$value['invoice_id'];
                    
                }
                $col=array_column($invoice_dist_products,'amount');
                $sum=array_sum($col);
                $data['sum']=$sum;
                $inv_dos= $this->Rollback_invoice_m->get_invoice_dos($invoice_id);
                $inv_obs= $this->Rollback_invoice_m->get_invoice_obs($invoice_id);
                foreach ($inv_dos as $value)
                {
                  $d[]=$value['do_number'];
                  $do_date[] =date('d-m-Y',strtotime($value['do_date']));
                }        
                $data['inv_dos'] =implode(', ',$d);
                $data['inv_do_dates'] =implode(', ',$do_date);

                foreach ($inv_obs as $value) 
                {
                  $ob[]=$value['order_number'];
                  $ob_date[] =date('d-m-Y',strtotime($value['order_date']));
                }
                
                $data['inv_obs'] =implode(', ',$ob);
                $data['inv_ob_dates'] =implode(', ',$ob_date);
                $data['results']=$results;
                $data['invoice_dist_product']=$invoice_dist_products;
                $data['flag']=2;
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <strong>Error!</strong> Invoice Number Is Not Exist. Please check. </div>');
                
                redirect(SITE_URL.'delete_invoice');
            }
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Invoice Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'delete_invoice');
        }
        
        
        
        $this->load->view('rollback_invoice/rollback_invoice_delete_view',$data);
    }

    public function delete_invoice_details()
    {
        $invoice_id = $this->input->post('invoice_id',TRUE);
        if($invoice_id=='')
        {
            redirect(SITE_URL.'delete_invoice'); exit();
        }
        $invoice_details = $this->Common_model->get_data_row('invoice',array('invoice_id'=>$invoice_id));
        $remarks = $this->input->post('remarks',TRUE);
        $name="Delete Invoice Details For Invoice Number : ".$invoice_details['invoice_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('delete_complete_invoice','invoice_details');
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
                               'primary_key'       => $invoice_id,
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
        //echo $issue_closed_by.'/'.$issued_by; exit();
        if($issue_closed_by == $issued_by)
        {
                $invoice_detail = $this->Rollback_invoice_m->get_invoice_detial($invoice_id);
                //update stock quantity
                foreach ($invoice_detail as $key => $value) 
                {
                    $qry='UPDATE plant_product set quantity=quantity+'.$value['quantity'].' where product_id='.$value['product_id'].' and plant_id='.$value['plant_id'];
                    $this->db->query($qry);

                }
                //update do quantity
                foreach ($invoice_detail as $key => $value) 
                {
                    $qry='UPDATE do_order_product set pending_qty=pending_qty+'.$value['quantity'].' , status = 2 where product_id='.$value['product_id'].' and do_ob_product_id ='.$value['do_ob_product_id'];
                    $this->db->query($qry);
                }

                //insert deleted info in deleted_invoice_details
                foreach ($invoice_detail as $key => $value) 
                {
                    $insert_value = array('invoice_number' => $value['invoice_number'],
                                          'invoice_id'     => $value['invoice_id'],
                                          'do_id'          => $value['do_id'],
                                          'order_id'       => $value['order_id'],
                                          'invoice_do_id'  => $value['invoice_do_id'],
                                          'product_id'     => $value['product_id'],
                                          'invoice_do_product_id' => $value['invoice_do_product_id'],
                                          'do_ob_product_id'      => $value['do_ob_product_id'],
                                          'items_per_carton'      => $value['items_per_carton'],
                                          'quantity'       => $value['quantity'],
                                          'created_by'     => $this->session->userdata('user_id'),
                                          'created_time'   => date('Y-m-d H:i:s'),
                                          'plant_id'       => $value['plant_id']);
                    $this->Common_model->insert_data('deleted_invoice_details',$insert_value);
                }

                //update do status
                $do_data = $this->Common_model->get_data('invoice_do',array('invoice_id'=>$invoice_id));
                foreach ($do_data as $key => $value) 
                {
                    $qry='UPDATE do set status = 2 where do_id='.$value['do_id'].'';
                    $this->db->query($qry);
                } 
                //delete from invoice_do_product
                foreach ($invoice_detail as $key => $value) 
                {
                    $this->Common_model->delete_data('invoice_do_product',array('invoice_do_product_id'=>$value['invoice_do_product_id']));
                }

                //delete from invoice_do
                $invoice_do_data = $this->Common_model->get_data('invoice_do',array('invoice_id'=>$invoice_id));
                foreach ($invoice_do_data as $key => $value) 
                {
                    $this->Common_model->delete_data('invoice_do',array('invoice_id'=>$value['invoice_id'])); 
                }

                //delete from invoice
                $this->Common_model->delete_data('invoice',array('invoice_id'=> $invoice_id));

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
                            <strong>Success!</strong> Invoice Details Has Been Deleted successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'delete_invoice'); exit();

    }

    public function invoice_product_delete()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Delete Invoice  Product';
        $data['nestedView']['heading'] = "Delete Invoice  Product";
        $data['nestedView']['cur_page'] = 'Delete Invoice  Product';
        $data['nestedView']['parent_page'] = 'date_change';
        $data['nestedView']['list_page'] = 'date_change';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Delete Invoice  Product','class'=>'active','url'=>'');
       
        

        $data['flag']=1;
        $this->load->view('rollback_invoice/rollback_invoice_product_delete_view',$data);
    }

    public function rollback_invoice_product_delete()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = ' Delete Invoice Product Details';
        $data['nestedView']['heading'] = "Delete Invoice Product Details";
        $data['nestedView']['cur_page'] = 'Delete Invoice Product Details';
        $data['nestedView']['parent_page'] = 'date_change';
        $data['nestedView']['list_page'] = 'date_change';
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Delete Invoice  Product','class'=>'active','url'=>SITE_URL.'invoice_product_delete'); 
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Delete Invoice Product Details','class'=>'active','url'=>'');

        $invoice_number=$this->input->post('invoice_id',TRUE);
        $invoice_id=$this->Rollback_invoice_m->get_invoice_id($invoice_number);
        $count_receipt_invoice = $this->Common_model->get_data('receipt_invoice',array('invoice_id'=>$invoice_id));
        $count_gatepass = $this->Common_model->get_data('gatepass_invoice',array('invoice_id'=>$invoice_id));
        if(count($count_receipt_invoice)>0 || count($count_gatepass)>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <strong>Error!</strong> Invoice is involved in Gatepass/StockReceiving. Please Check! </div>');
            redirect(SITE_URL.'invoice_product_delete'); exit();
        }
        $invoice_type=$this->Rollback_invoice_m->get_invoice_type($invoice_id);
        if($invoice_type['type'] == 2)
        {
           
            $invoice_plant_products=$this->Rollback_invoice_m->get_invoice_do_product($invoice_id);
            
            if(count($invoice_plant_products)!='')
            {
                
                foreach($invoice_plant_products as $key => $value)
                {
                    $results['invoice_date']=$value['invoice_date'];
                    $results['vehicle_number']=$value['vehicle_number'];
                    $results['from']=$value['from'];
                    $results['to']=$value['to'];
                    $results['invoice_number']=$value['invoice_number'];
                    $results['invoice_id']=$value['invoice_id'];
                    
                }
                //echo "<pre>"; print_r($invoice_plant_products); exit;
                $col=array_column($invoice_plant_products,'amount');
                $sum=array_sum($col);
                $data['sum']=$sum;
                $inv_dos= $this->Rollback_invoice_m->get_invoice_dos($invoice_id);
                $inv_obs= $this->Rollback_invoice_m->get_invoice_obs($invoice_id);
                foreach ($inv_dos as $value)
                {
                  $d[]=$value['do_number'];
                  $do_date[] =date('d-m-Y',strtotime($value['do_date']));
                }        
                $data['inv_dos'] =implode(', ',$d);
                $data['inv_do_dates'] =implode(', ',$do_date);
                $data['tin_num']=37280114257;
                foreach ($inv_obs as $value) 
                {
                  $ob[]=$value['order_number'];
                  $ob_date[] =date('d-m-Y',strtotime($value['order_date']));
                }
                
                $data['inv_obs'] =implode(', ',$ob);
                $data['inv_ob_dates'] =implode(', ',$ob_date);
                $data['results']=$results;
                $data['invoice_plant_product']=$invoice_plant_products;
                $data['flag']=3;
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <strong>Error!</strong> Invoice Number Is Not Exist. Please check. </div>');
                
                redirect(SITE_URL.'invoice_product_delete');
            }
        }
        elseif($invoice_type['type']== 1)
        {
            $invoice_dist_products=$this->Rollback_invoice_m->get_invoice_do_distributor_product($invoice_id);
            
            if(count($invoice_dist_products)!='')
            {
                foreach($invoice_dist_products as $key => $value)
                {
                    $results['invoice_date']=$value['invoice_date'];
                    $results['distributor_code']=$value['distributor_code'];
                    $results['tin_num']=$value['vat_no'];
                    $results['mobile']=$value['mobile'];
                    $results['vehicle_number']=$value['vehicle_number'];
                    $results['amount']=$value['amount'];
                    $results['agency_name']=$value['agency_name'];
                    $results['address']=$value['address'];
                    $results['lifting']=$value['lifting'];
                    $results['location']=$value['distributor_place'];
                    $results['invoice_number']=$value['invoice_number'];
                    $results['invoice_id']=$value['invoice_id'];
                    
                }
                $col=array_column($invoice_dist_products,'amount');
                $sum=array_sum($col);
                $data['sum']=$sum;
                $inv_dos= $this->Rollback_invoice_m->get_invoice_dos($invoice_id);
                $inv_obs= $this->Rollback_invoice_m->get_invoice_obs($invoice_id);
                foreach ($inv_dos as $value)
                {
                  $d[]=$value['do_number'];
                  $do_date[] =date('d-m-Y',strtotime($value['do_date']));
                }        
                $data['inv_dos'] =implode(', ',$d);
                $data['inv_do_dates'] =implode(', ',$do_date);

                foreach ($inv_obs as $value) 
                {
                  $ob[]=$value['order_number'];
                  $ob_date[] =date('d-m-Y',strtotime($value['order_date']));
                }
                
                $data['inv_obs'] =implode(', ',$ob);
                $data['inv_ob_dates'] =implode(', ',$ob_date);
                $data['results']=$results;
                $data['invoice_dist_product']=$invoice_dist_products;
                $data['flag']=2;
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <strong>Error!</strong> Invoice Number Is Not Exist. Please check. </div>');
                
                redirect(SITE_URL.'invoice_product_delete');
            }
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong>Error!</strong> Invoice Number Is Not Exist. Please check. </div>');
            
            redirect(SITE_URL.'invoice_product_delete');
        }
        
        
        $this->load->view('rollback_invoice/rollback_invoice_product_delete_view',$data);
    }

    public function delete_invoice_product()
    {
        $invoice_id = $this->input->post('invoice_id',TRUE);
        if($invoice_id=='')
        {
            redirect(SITE_URL.'invoice_product_delete'); exit();
        }
        $checked_items = $this->input->post('checkbox',TRUE);
        if(count($checked_items)<=0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong>  Please check Atleast One Product. </div>');
            redirect(SITE_URL.'invoice_product_delete'); exit();

        }

        $invoice_details = $this->Common_model->get_data_row('invoice',array('invoice_id'=>$invoice_id));
        $remarks = $this->input->post('remarks',TRUE);

        $product_name = array();
        foreach ($checked_items as $key => $value) 
        {
            $product_id = $this->Common_model->get_value('invoice_do_product',array('invoice_do_product_id'=>$value),'product_id');
            $product_name[] = $this->Common_model->get_value('product',array('product_id'=>$product_id),'name');
            
        }
        $product_name= implode(', ', $product_name);
        $name="Delete Invoiced Products : ".$product_name." From Invoice Number : ".$invoice_details['invoice_number']."";

        
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('delete_invoice_product','invoice_details');
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
                               'primary_key'       => $invoice_id,
                               'old_value'         => json_encode($checked_items),
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
            $invoice_detail = $this->Rollback_invoice_m->get_invoice_product_detial($checked_items);

            //cost for reducing the invoice amount
            $deduct_cost = 0;
            foreach ($invoice_detail as $key => $value) 
            {
                $cost_price = $this->Common_model->get_value('do_order_product',array('do_ob_product_id'=>$value['do_ob_product_id']),'product_price');
                $deduct_cost += ($value['items_per_carton']*$value['quantity']*$cost_price);
            }
            //update stock quantity
            foreach ($invoice_detail as $key => $value) 
            {
                $qry='UPDATE plant_product set quantity=quantity+'.$value['quantity'].' where product_id='.$value['product_id'].' and plant_id='.$value['plant_id'];
                $this->db->query($qry);

            }
            //update do quantity
            foreach ($invoice_detail as $key => $value) 
            {
                $qry='UPDATE do_order_product set pending_qty=pending_qty+'.$value['quantity'].' , status = 2 where product_id='.$value['product_id'].' and do_ob_product_id ='.$value['do_ob_product_id'];
                $this->db->query($qry);
            }

            //insert deleted info in deleted_invoice_details
            foreach ($invoice_detail as $key => $value) 
            {
                $insert_value = array('invoice_number' => $value['invoice_number'],
                                      'invoice_id'     => $value['invoice_id'],
                                      'do_id'          => $value['do_id'],
                                      'order_id'       => $value['order_id'],
                                      'invoice_do_id'  => $value['invoice_do_id'],
                                      'product_id'     => $value['product_id'],
                                      'invoice_do_product_id' => $value['invoice_do_product_id'],
                                      'do_ob_product_id'      => $value['do_ob_product_id'],
                                      'items_per_carton'      => $value['items_per_carton'],
                                      'quantity'       => $value['quantity'],
                                      'created_by'     => $this->session->userdata('user_id'),
                                      'created_time'   => date('Y-m-d H:i:s'),
                                      'plant_id'       => $value['plant_id']);
                $this->Common_model->insert_data('deleted_invoice_details',$insert_value);
            }

            //update do status
            $do_data = $this->Common_model->get_data('invoice_do',array('invoice_id'=>$invoice_id));
            foreach ($do_data as $key => $value) 
            {
                $qry='UPDATE do set status = 2 where do_id='.$value['do_id'].'';
                $this->db->query($qry);
                 
            } 
            //delete from invoice_do_product
            foreach ($invoice_detail as $key => $value) 
            {
                $this->Common_model->delete_data('invoice_do_product',array('invoice_do_product_id'=>$value['invoice_do_product_id']));
            }

            //delete from invoice_do
            $invoice_do_data = $this->Common_model->get_data('invoice_do',array('invoice_id'=>$invoice_id));
            foreach ($invoice_do_data as $key => $value) 
            {
                $count_idp = $this->Common_model->get_data('invoice_do_product',array('invoice_do_id'=>$value['invoice_do_id']));
                if(count($count_idp)==0)
                {
                    $this->Common_model->delete_data('invoice_do',array('invoice_id'=>$value['invoice_id'])); 
                }
            }

            //delete from invoice
            $count_id = $this->Common_model->get_data('invoice_do',array('invoice_id'=>$invoice_id));
            if(count($count_id)==0)
            {
                $this->Common_model->delete_data('invoice',array('invoice_id'=> $invoice_id));
            }
            else
            {
                $qry='UPDATE invoice set total=total-'.$deduct_cost.' where invoice_id='.$invoice_id.'';
                $this->db->query($qry);

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
                            <strong>Success!</strong> Invoiced Products : '.$product_name.' Has Been Deleted successfully With Request Number :'.$approval_number.' </div>');
        }
        redirect(SITE_URL.'invoice_product_delete'); exit();
    }
}