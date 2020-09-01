<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
/*Created By Koushik*/

class Approval_list extends CI_Controller 
{
	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Approval_list_m");
        $this->load->model('Rollback_do_model');
         $this->load->model("Rollback_mrr_model");
         $this->load->model('Rollback_invoice_m');

	}

	public function approval_list()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Approval List";
        $data['nestedView']['pageTitle'] = 'Approval List';
        $data['nestedView']['cur_page'] = 'approval_list';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Approval List', 'class' => 'active', 'url' =>'');

        # Search Functionality
        $psearch=$this->input->post('searchapproval', TRUE);
        if($psearch!='') 
        {
        	$from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):'';
        	$to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):'';
            $searchParams=array(
                               'approval_number' => $this->input->post('approval_number', TRUE),
                               'label'			 => $this->input->post('label',TRUE),
                               'from_date'       => $from_date,
                               'to_date'		 => $to_date,
                               'status'			 => $this->input->post('status',TRUE),
                               'issue_at'		 => $this->input->post('issue_at',TRUE)
                               );
            $this->session->set_userdata($searchParams);
        } 
        else 
        {

        if($this->uri->segment(2)!='')
            {
            $searchParams=array(
                              'approval_number' => $this->session->userdata('approval_number'),
                              'label'			=> $this->session->userdata('label'),
                              'from_date'		=> $this->session->userdata('from_date'),
                              'to_date'			=> $this->session->userdata('to_date'),
                              'status'			=> $this->session->userdata('status'),
                              'issue_at'		=> $this->session->userdata('issue_at')
                              );
            }
            else {
                $searchParams=array(
                                    'approval_number' => '',
                                    'label'			  => '',
                                    'from_date'		  => '',
                                    'to_date'		  => '',
                                    'status'		  => 1,
                                    'issue_at'		  => ''
                                   );
                $this->session->set_userdata($searchParams);
            }
            
        }
        $data['search_data'] = $searchParams;


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'approval_list/';
        # Total Records
        $config['total_rows'] = $this->Approval_list_m->approval_total_num_rows($searchParams);

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
        $data['approvalResults'] = $this->Approval_list_m->approval_results($current_offset, $config['per_page'], $searchParams);
        
        # Additional data
        $data['label_list'] = $this->Common_model->get_data('reporting_preference',array('status'=>1));
       	$data['designation_list'] = $this->Approval_list_m->get_designation_list();
        $data['displayResults'] = 1;

        $this->load->view('approvals/approval_list',$data);

    }

    public function view_approval_information()
    {
    	$approval_id=@cmm_decode($this->uri->segment(2));
        if($approval_id=='')
        {
            redirect(SITE_URL.'approval_list'); exit();
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Approval Details";
        $data['nestedView']['pageTitle'] = 'Approval Details';
        $data['nestedView']['cur_page'] = 'approval_list';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Approval List', 'class' => 'active', 'url' =>SITE_URL.'approval_list');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Approval Details', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_approval_information';
        $data['displayResults'] = 0;

        # Data
        $data['approval_info'] = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
        $data['approval_hist_info'] = $this->Approval_list_m->get_approval_hist($approval_id);
        $this->load->view('approvals/approval_list',$data);
    }

    public function update_approval_information()
    {
    	
    	$approval_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($approval_id == '')
        {
            redirect(SITE_URL.'approval_list'); exit();
        }
        $submit = $this->input->post('submit',TRUE);
        $remarks = $this->input->post('remarks',TRUE);
        
        //approval details using approval_id
        $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
        $approval_number = $approval_data['approval_number'];

        //preference details using the rep_preference_id from approval details
        $pref_data = $this->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

        //session value of existing user (block_designation_id)
        $issued_by = $this->session->userdata('block_designation_id');

        //issue closed by value from preference table
        $issue_closed_by = $pref_data['issue_closed_by'];


        if($submit == 1)
        {
	     	//checking condition if issue_closed_by is same with present logged in User
	        if($issued_by == $issue_closed_by)
	        {
	        	$this->db->trans_begin();
	        	$preference_name = $pref_data['name'];
	        	switch ($preference_name)
	        	{
	        		case 'distributor_dd_name':
                        $old_dist = $approval_data['old_value'];
                        $new_dist = $approval_data['new_value'];
                        $old_dist_data = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$old_dist));
                        $new_dist_data = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$new_dist));
                        $payment_data = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$approval_data['primary_key']));

                        $old_dist_name = $old_dist_data['distributor_code'].' - ('.$old_dist_data['agency_name'].')';
                        $new_dist_name = $new_dist_data['distributor_code'].' - ('.$new_dist_data['agency_name'].')';
                        
                        $name = $name="Distributor Name Has Changed From :".$old_dist_name." TO :".$new_dist_name." For DD Number : ".$payment_data['dd_number']."";

                        $amount = $payment_data['amount'];
                        $old_dist_amount = $old_dist_data['outstanding_amount'];
                        $new_dist_amount = $new_dist_data['outstanding_amount'];

                        if($old_dist_amount=='')
                        { $reduce = 0 - $amount; }
                        else
                        { $reduce = $old_dist_amount - $amount; }

                        if($new_dist_amount=='')
                        { $increase = 0 + $amount; }
                        else
                        { $increase = $new_dist_amount + $amount; }

                        $updata_old_data = array('outstanding_amount' => $reduce);
                        $update_old_where = array('distributor_id' => $old_dist);
                        $this->Common_model->update_data('distributor',$updata_old_data,$update_old_where);

                        $updata_new_data = array('outstanding_amount' => $increase);
                        $update_new_where = array('distributor_id' => $new_dist);
                        $this->Common_model->update_data('distributor',$updata_new_data,$update_new_where);
			            update_single_column_rollback($approval_id,$name,$remarks);
					break;

                    case 'distributor_dd_amount':
                        $payment_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$payment_id));
                        $dist_details = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$dd_details['distributor_id']));
                        $name="Distributor DD Date changed from :".$dd_details['amount']." TO :".price_format($approval_data['new_value'])." For DD Number : ".$dd_details['dd_number']."";

                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                        if($old_value >= $new_value)
                        {
                            $reduce = $old_value-$new_value;
                            $outstanding_amount = $dist_details['outstanding_amount']-$reduce;
                        }
                        else
                        {
                            $increase = $new_value-$old_value;
                            $outstanding_amount = $dist_details['outstanding_amount']+$increase;
                        }
                        $update_dist_data = array('outstanding_amount'=> $outstanding_amount);
                        $update_dist_where = array('distributor_id' => $dist_details['distributor_id']);
                        $this->Common_model->update_data('distributor',$update_dist_data,$update_dist_where);

                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                    case 'distributor_dd_payment_type':
                        $payment_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$payment_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                        $old_name = $this->Common_model->get_value('payment_mode',array('pay_mode_id'=>$old_value),'name');
                        $new_name = $this->Common_model->get_value('payment_mode',array('pay_mode_id'=>$new_value),'name');
                        $name="Distributor DD Type changed from :".$old_name." TO :".$new_name." For DD Number : ".$dd_details['dd_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                    case 'distributor_dd_date':
                        $payment_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$payment_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                        $name="Distributor DD Date changed from :".format_date($old_value)." TO :".format_date($new_value)." For DD Number : ".$dd_details['dd_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                    case 'distributor_dd_number':
                        $payment_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$payment_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                        $name="Distributor DD Number changed from :".$old_value." TO :".$new_value." For DD Number : ".$dd_details['dd_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                    case 'distributor_dd_bank':
                        $payment_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$payment_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                         $old_name = $this->Common_model->get_value('bank',array('bank_id'=>$old_value),'name');
                        $new_name = $this->Common_model->get_value('bank',array('bank_id'=>$new_value),'name');
                        $name="Distributor DD Bank changed from :".$old_name." TO :".$new_name." For DD Number : ".$dd_details['dd_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;
                    
                    case 'po_oil_date':
                        $po_oil_id = $approval_data['primary_key'];
                        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                        $name="PO Oil Date has changed From :".format_date($old_value)." TO :".format_date($new_value)." For PO Oil Number : ".$po_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);

                    break;

                    case 'po_oil_quantity':
                        $po_oil_id = $approval_data['primary_key'];
                        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                        $name="PO Oil Quantity has changed From :".qty_format($old_value)." TO :".qty_format($new_value)." For PO Oil Number : ".$po_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                    case 'po_oil_price':
                        $po_oil_id = $approval_data['primary_key'];
                        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                        $name="PO Oil Price has changed From :".price_format($old_value)." TO :".price_format($new_value)." For PO Oil Number : ".$po_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                    case 'po_oil_name':
                        $po_oil_id = $approval_data['primary_key'];
                        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
                        $old_value = $this->Common_model->get_value('loose_oil',array('loose_oil_id'=>$approval_data['old_value']),'name');
                        $new_value = $this->Common_model->get_value('loose_oil',array('loose_oil_id'=>$approval_data['new_value']),'name');
                        $name="PO Oil Name has changed From :".$old_value." TO :".$new_value." For PO Oil Number : ".$po_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                    case 'po_oil_supplier':
                        $po_oil_id = $approval_data['primary_key'];
                        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
                        $old_value = $this->Common_model->get_value('supplier',array('supplier_id'=>$approval_data['old_value']),'agency_name');
                        $new_value = $this->Common_model->get_value('supplier',array('supplier_id'=>$approval_data['new_value']),'agency_name');
                        $remarks = $this->input->post('remarks',TRUE);
                        $name="PO Oil Supplier has changed From :".$old_value." TO :".$new_value." For PO Oil Number : ".$po_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                    case 'po_oil_broker':
                         $po_oil_id = $approval_data['primary_key'];
                         $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
                         $old_value = $this->Common_model->get_value('broker',array('broker_id'=>$approval_data['old_value']),'agency_name');
                        $new_value = $this->Common_model->get_value('broker',array('broker_id'=>$approval_data['new_value']),'agency_name');
                        $name="PO Oil Broker has changed From :".$old_value." TO :".$new_value." For PO Oil Number : ".$po_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                    case 'po_oil_plant':
                        $po_oil_id = $approval_data['primary_key'];
                        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
                        $old_value = $this->Common_model->get_value('plant',array('plant_id'=>$approval_data['old_value']),'name');
                        $new_value = $this->Common_model->get_value('plant',array('plant_id'=>$approval_data['new_value']),'name');
                        $name="PO Oil Plant has changed From :".$old_value." TO :".$new_value." For PO Oil Number : ".$po_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                    case 'po_oil_delete':
                        $primary_key = $approval_data['primary_key'];
                        $po_details = $this->Common_model->get_data_row('po_oil',array('po_oil_id'=>$po_oil_id));
                        $name="PO Oil Details  For PO Oil Number : ".$po_details['po_number']." Has been Deleted";
                        $this->Common_model->delete_data('po_oil',array('po_oil_id'=>$primary_key));

                        $update_approval_data = array('status'        => 2,
                                                      'modified_by'   => $this->session->userdata('user_id'),
                                                      'modified_time' => date('Y-m-d H:i:s'));
                        $updata_approval_where = array('approval_id'  => $approval_id);
                        $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

                        $insert_data = array('approval_id'   => $approval_id,
                                             'issued_by'     => $this->session->userdata('block_designation_id'),
                                             'remarks'       => $remarks,
                                             'created_by'    =>  $this->session->userdata('user_id'),
                                             'created_time'  =>  date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$insert_data);
                        
                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                            );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);
                    break;

                    case 'distributor_dd_delete':
                        $primary_key = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('distributor_payment',array('payment_id'=>$payment_id));
                        $name="DD Details  For DD Number : ".$dd_details['dd_number']." Has been Deleted";
                        $this->Common_model->delete_data('distributor_payment',array('payment_id'=>$primary_key));

                        $update_approval_data = array('status'        => 2,
                                                      'modified_by'   => $this->session->userdata('user_id'),
                                                      'modified_time' => date('Y-m-d H:i:s'));
                        $updata_approval_where = array('approval_id'  => $approval_id);
                        $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

                        $insert_data = array('approval_id'   => $approval_id,
                                             'issued_by'     => $this->session->userdata('block_designation_id'),
                                             'remarks'       => $remarks,
                                             'created_by'    =>  $this->session->userdata('user_id'),
                                             'created_time'  =>  date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$insert_data);

                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                            );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);
                    break;
                    
                    
                    case 'po_pm_date':
                        $po_pm_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('po_pm',array('po_pm_id'=>$po_pm_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                       // $remarks=    $approval_data['remarks'];
                        $name="PO Date changed from :".format_date($old_value)." TO :".format_date($new_value)." For PO Number : ".$dd_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                     case 'po_pm_quantity':
                        $po_pm_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('po_pm',array('po_pm_id'=>$po_pm_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                       // $remarks=    $approval_data['remarks'];
                        $name="PO PM Quantity has been changed from  :".$old_value." TO :".$new_value." For PO Number : ".$dd_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;
                    
                    case 'po_pm_price':
                        $po_pm_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('po_pm',array('po_pm_id'=>$po_pm_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                       // $remarks=    $approval_data['remarks'];
                        $name="PO price has been changed from :".$old_value." TO :".$new_value." For PO Number : ".$dd_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                     case 'po_pm_product':
                        $po_pm_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('po_pm',array('po_pm_id'=>$po_pm_id));
                        $old_value = $approval_data['old_value'];
                        $res=$this->Common_model->get_data_row('packing_material',array('pm_id'=>$old_value));
                        $old_value_name=$res['name'];
                        $new_value = $approval_data['new_value'];
                        $res1=$this->Common_model->get_data_row('packing_material',array('pm_id'=>$new_value));
                        $new_value_name=$res1['name'];

                       // $remarks=    $approval_data['remarks'];
                        $name="PO product has been changed from :".$old_value_name." TO :".$new_value_name." For PO Number : ".$dd_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;
                      case 'po_pm_supplier':
                        $po_pm_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('po_pm',array('po_pm_id'=>$po_pm_id));
                        $old_value = $approval_data['old_value'];
                        
                        $res=$this->Common_model->get_data_row('supplier',array('supplier_id'=>$old_value));
                        $old_value_name=$res['agency_name'];
                        $new_value = $approval_data['new_value'];
                      
                        $res1=$this->Common_model->get_data_row('supplier',array('supplier_id'=>$new_value));
                        $new_value_name=$res1['agency_name'];
                    

                       // $remarks=    $approval_data['remarks'];
                        $name="PO supplier has been changed from :".$old_value_name." TO :".$new_value_name." For PO Number : ".$dd_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                     case 'po_pm_unit':
                        $po_pm_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('po_pm',array('po_pm_id'=>$po_pm_id));
                        $old_value = $approval_data['old_value'];
                        
                        $res=$this->Common_model->get_data_row('plant',array('plant_id'=>$old_value));
                        $old_value_name=$res['name'];
                        $new_value = $approval_data['new_value'];
                      
                        $res1=$this->Common_model->get_data_row('plant',array('plant_id'=>$new_value));
                        $new_value_name=$res1['name'];
                    

                       // $remarks=    $approval_data['remarks'];
                        $name="PO Pm Unit has been changed from :".$old_value_name." TO :".$new_value_name." For PO Number : ".$dd_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;
                     case 'po_pm_delete':
                        $po_pm_id = $approval_data['primary_key'];
                        $po_details = $this->Common_model->get_data_row('po_pm',array('po_pm_id'=>$po_pm_id));
                        $name="PO PM Details  For PO PM Number : ".$po_details['po_number']." Has been Deleted";
                        $this->Common_model->delete_data('po_pm',array('po_pm_id'=>$po_pm_id));

                        $update_approval_data = array('status'        => 2,
                                                      'modified_by'   => $this->session->userdata('user_id'),
                                                      'modified_time' => date('Y-m-d H:i:s'));
                        $updata_approval_where = array('approval_id'  => $approval_id);
                        $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

                        $insert_data = array('approval_id'   => $approval_id,
                                             'issued_by'     => $this->session->userdata('block_designation_id'),
                                             'remarks'       => $remarks,
                                             'created_by'    =>  $this->session->userdata('user_id'),
                                             'created_time'  =>  date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$insert_data);
                        
                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                            );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);
                    break;
                    
                     case 'po_fg_date':
                        $po_fg_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('po_free_gift',array('po_fg_id'=>$po_fg_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                       // $remarks=    $approval_data['remarks'];
                        $name="PO Date changed from :".format_date($old_value)." TO :".format_date($new_value)." For PO Number : ".$dd_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                     case 'po_fg_quantity':
                        $po_fg_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('po_free_gift',array('po_fg_id'=>$po_fg_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                       // $remarks=    $approval_data['remarks'];
                        $name="PO PM Quantity has been changed from  :".$old_value." TO :".$new_value." For PO Number : ".$dd_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                     case 'po_fg_rate':
                        $po_fg_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('po_free_gift',array('po_fg_id'=>$po_fg_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                       // $remarks=    $approval_data['remarks'];
                        $name="PO Freegift price has been changed from :".$old_value." TO :".$new_value." For PO Number : ".$dd_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                      case 'po_fg_product':
                        $po_fg_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('po_free_gift',array('po_fg_id'=>$po_fg_id));
                        $old_value = $approval_data['old_value'];
                        $res=$this->Common_model->get_data_row('free_gift',array('free_gift_id'=>$old_value));
                        $old_value_name=$res['name'];
                        $new_value = $approval_data['new_value'];
                        $res1=$this->Common_model->get_data_row('free_gift',array('free_gift_id'=>$new_value));
                        $new_value_name=$res1['name'];

                       // $remarks=    $approval_data['remarks'];
                        $name="PO Freegift product has been changed from :".$old_value_name." TO :".$new_value_name." For PO Number : ".$dd_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                     case 'po_fg_supplier':
                        $po_fg_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('po_free_gift',array('po_fg_id'=>$po_fg_id));
                        $old_value = $approval_data['old_value'];
                        
                        $res=$this->Common_model->get_data_row('supplier',array('supplier_id'=>$old_value));
                        $old_value_name=$res['agency_name'];
                        $new_value = $approval_data['new_value'];
                      
                        $res1=$this->Common_model->get_data_row('supplier',array('supplier_id'=>$new_value));
                        $new_value_name=$res1['agency_name'];
                    

                       // $remarks=    $approval_data['remarks'];
                        $name="PO Freegift supplier has been changed from : ".$old_value_name." TO :".$new_value_name." For PO Number : ".$dd_details['po_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                     case 'delete_po_fg':
                        $po_fg_id = $approval_data['primary_key'];
                        $po_details = $this->Common_model->get_data_row('po_free_gift',array('po_fg_id'=>$po_fg_id));
                        $name="PO Freegift Details  For PO Number : ".$po_details['po_number']." Has been Deleted";
                        $this->Common_model->delete_data('po_free_gift',array('po_fg_id'=>$po_fg_id));

                        $update_approval_data = array('status'        => 2,
                                                      'modified_by'   => $this->session->userdata('user_id'),
                                                      'modified_time' => date('Y-m-d H:i:s'));
                        $updata_approval_where = array('approval_id'  => $approval_id);
                        $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

                        $insert_data = array('approval_id'   => $approval_id,
                                             'issued_by'     => $this->session->userdata('block_designation_id'),
                                             'remarks'       => $remarks,
                                             'created_by'    =>  $this->session->userdata('user_id'),
                                             'created_time'  =>  date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$insert_data);
                        
                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                            );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);
                    break;
                    
                      case 'mrr_oil_date':
                        $mrr_oil_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('mrr_oil',array('mrr_oil_id'=>$mrr_oil_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                       // $remarks=    $approval_data['remarks'];
                        $name="MRR Oil Date changed from :".format_date($old_value)." TO :".format_date($new_value)." For MRR Number : ".$dd_details['mrr_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                    case 'mrr_pm_date':
                        $mrr_pm_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('mrr_pm',array('mrr_pm_id'=>$mrr_pm_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                       // $remarks=    $approval_data['remarks'];
                        $name="MRR Packing Material Date changed from :".format_date($old_value)." TO :".format_date($new_value)." For MRR Number : ".$dd_details['mrr_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                    case 'mrr_fg_date':
                        $mrr_fg_id = $approval_data['primary_key'];
                        $dd_details = $this->Common_model->get_data_row('mrr_fg',array('mrr_fg_id'=>$mrr_fg_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                       // $remarks=    $approval_data['remarks'];
                        $name="MRR Freegift Date changed from :".format_date($old_value)." TO :".format_date($new_value)." For MRR Number : ".$dd_details['mrr_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;
                    
                    
                    
                     case 'mrr_oil_delete':
                        $mrr_oil_id = $approval_data['primary_key'];
                        $mrr_details = $this->Common_model->get_data_row('mrr_oil',array('mrr_oil_id'=>$mrr_oil_id));
                        $name="MRR Oil Details Of MRR Number : ".$mrr_details['mrr_number']." Has been Deleted";
                       // $this->Common_model->delete_data('po_pm',array('po_pm_id'=>$po_pm_id));

                    //retreving MRR plant details
                    $mrr_plant_details=$this->Rollback_mrr_model->get_mrr_oil_details($mrr_oil_id);
                    
                    //updating tanker register status 
                    $this->Common_model->update_data('tanker_register',array('status'=>4),array('tanker_id'=> $mrr_plant_details['tanker_id']));

                    //retreving plant oil stock balance details based on recent date
                    $oil_stock=$this->Rollback_mrr_model->get_mrr_oil_stock_balance($mrr_plant_details['plant_id'],$mrr_plant_details['loose_oil_id'],$mrr_plant_details['mrr_date']);
                  
                    $receipt_weight=$oil_stock['receipts']-$mrr_plant_details['net_weight'];

                    //reducing receipt weight in oil stock balance
                     $this->Common_model->update_data('oil_stock_balance',array('receipts'=>$receipt_weight),array('oil_stock_balance_id'=> $oil_stock['oil_stock_balance_id']));

                     //updating mrr oil history table
                    $mrr_results=$this->Common_model->get_data_row('mrr_oil',array('mrr_oil_id'=>$mrr_oil_id));
                    $mrr_history=array(
                        'mrr_oil_id'     => $mrr_results['mrr_oil_id'],
                        'tanker_oil_id'  => $mrr_results['tanker_oil_id'],
                        'mrr_number'     => $mrr_results['mrr_number'],
                        'ledger_number'  => $mrr_results['ledger_number'],
                        'folio_number'   => $mrr_results['folio_number'],
                        'remarks'        => $mrr_results['remarks'],
                        'mrr_date'       => $mrr_results['mrr_date'],
                        'created_by'     => $mrr_results['created_by'],
                        'created_time'   => $mrr_results['created_time'],
                        'oil_tank_id'    => $mrr_results['oil_tank_id']
                        );
                       $this->Common_model->insert_data('mrr_oil_history',$mrr_history);
                       $this->Common_model->delete_data('mrr_oil',array('mrr_oil_id'=>$mrr_oil_id));
                        $update_approval_data = array('status'        => 2,
                                                      'modified_by'   => $this->session->userdata('user_id'),
                                                      'modified_time' => date('Y-m-d H:i:s'));
                        $updata_approval_where = array('approval_id'  => $approval_id);
                        $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

                        $insert_data = array('approval_id'   => $approval_id,
                                             'issued_by'     => $this->session->userdata('block_designation_id'),
                                             'remarks'       => $remarks,
                                             'created_by'    =>  $this->session->userdata('user_id'),
                                             'created_time'  =>  date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$insert_data);
                        
                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                            );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);
                    break;

                    case 'mrr_pm_delete':
                        $mrr_pm_id = $approval_data['primary_key'];
                        $mrr_details = $this->Common_model->get_data_row('mrr_pm',array('mrr_pm_id'=>$mrr_pm_id));
                        $name="MRR PM Details Of MRR Number : ".$mrr_details['mrr_number']." Has been Deleted";
                       // $this->Common_model->delete_data('po_pm',array('po_pm_id'=>$po_pm_id));

                     //retreving MRR plant details
                    $mrr_plant_details=$this->Rollback_mrr_model->get_mrr_pm_details($mrr_pm_id);
                    
                    //updating tanker register status 
                    $this->Common_model->update_data('tanker_register',array('status'=>4),array('tanker_id'=> $mrr_plant_details['tanker_id']));

                    //retreving plant oil stock balance details based on recent date
                    $pm_stock=$this->Rollback_mrr_model->get_mrr_pm_stock_balance($mrr_plant_details['plant_id'],$mrr_plant_details['pm_id'],$mrr_plant_details['mrr_date']);
                    
                    if($mrr_plant_details['pm_category_id']==get_film_cat_id())
                    {
                        $film_results=$this->Common_model->get_data('mrr_pm_film',array('mrr_pm_id'=>$mrr_pm_id));

                        $receipt_weight=$pm_stock['receipts']-$film_results['received_quantity'];
                        $received_weight=$film_results['received_quantity'];
                    }
                    else
                    {
                         $receipt_weight=$pm_stock['receipts']-$mrr_plant_details['received_qty'];
                          $received_weight=$mrr_plant_details['received_qty'];
                    }

                    //reducing receipt weight in oil stock balance
                     $this->Common_model->update_data('pm_stock_balance',array('receipts'=>$receipt_weight),array('pm_stock_balance_id'=> $pm_stock['pm_stock_balance_id']));

                     //updating mrr pm history table
                    $mrr_results=$this->Common_model->get_data_row('mrr_pm',array('mrr_pm_id'=>$mrr_pm_id));
                    
                    $mrr_history=array(
                        'mrr_pm_id'     => $mrr_results['mrr_pm_id'],
                        'tanker_pm_id'  => $mrr_results['tanker_pm_id'],
                        'mrr_number'     => $mrr_results['mrr_number'],
                        'ledger_number'  => $mrr_results['ledger_number'],
                        'folio_number'   => $mrr_results['folio_number'],
                        'remarks'        => $mrr_results['remarks'],
                        'mrr_date'       => $mrr_results['mrr_date'],
                        'created_by'     => $mrr_results['created_by'],
                        'created_time'   => $mrr_results['created_time'],
                        'received_qty'    => $received_weight
                        );
                     $this->Common_model->insert_data('mrr_pm_history',$mrr_history);
                     if($mrr_plant_details['pm_category_id']==get_film_cat_id())
                    {
                       $this->Common_model->delete_data('mrr_pm_film',array('mrr_pm_id'=>$mrr_pm_id));
                    }
                    $this->Common_model->delete_data('mrr_pm',array('mrr_pm_id'=>$mrr_pm_id));
                    
                        $update_approval_data = array('status'        => 2,
                                                      'modified_by'   => $this->session->userdata('user_id'),
                                                      'modified_time' => date('Y-m-d H:i:s'));
                        $updata_approval_where = array('approval_id'  => $approval_id);
                        $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

                        $insert_data = array('approval_id'   => $approval_id,
                                             'issued_by'     => $this->session->userdata('block_designation_id'),
                                             'remarks'       => $remarks,
                                             'created_by'    =>  $this->session->userdata('user_id'),
                                             'created_time'  =>  date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$insert_data);
                        
                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                            );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);
                    break;

                    case 'delete_mrr_fg':
                        $mrr_fg_id = $approval_data['primary_key'];
                        $mrr_details = $this->Common_model->get_data_row('mrr_fg',array('mrr_fg_id'=>$mrr_fg_id));
                        $name="MRR Freegift Details Of MRR Number : ".$mrr_details['mrr_number']." Has been Deleted";
                       // $this->Common_model->delete_data('po_pm',array('po_pm_id'=>$po_pm_id));

                      //retreving MRR plant details
                        $mrr_plant_details=$this->Rollback_mrr_model->get_mrr_fg_details($mrr_fg_id);
                        
                        //updating tanker register status 
                        $this->Common_model->update_data('tanker_register',array('status'=>4),array('tanker_id'=> $mrr_plant_details['tanker_id']));

                        //retreving plant oil stock balance details based on recent date
                        $fg_stock=$this->Rollback_mrr_model->get_mrr_plant_fg_stock_balance($mrr_plant_details['plant_id'],$mrr_plant_details['free_gift_id']);
                      
                        $receipt_weight=$fg_stock['quantity']-$mrr_plant_details['received_qty'];

                        //reducing receipt weight in oil stock balance
                         $this->Common_model->update_data('plant_free_gift',array('quantity'=>$receipt_weight),array('plant_id'=> $fg_stock['plant_id'],'free_gift_id'=>$fg_stock['free_gift_id']));
                        $this->Common_model->delete_data('mrr_fg',array('mrr_fg_id'=>$mrr_fg_id));
                        $update_approval_data = array('status'        => 2,
                                                      'modified_by'   => $this->session->userdata('user_id'),
                                                      'modified_time' => date('Y-m-d H:i:s'));
                        $updata_approval_where = array('approval_id'  => $approval_id);
                        $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

                        $insert_data = array('approval_id'   => $approval_id,
                                             'issued_by'     => $this->session->userdata('block_designation_id'),
                                             'remarks'       => $remarks,
                                             'created_by'    =>  $this->session->userdata('user_id'),
                                             'created_time'  =>  date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$insert_data);
                        
                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                            );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);
                    break;
                    
                    case 'activate_order_booking':
                        $order_id = $approval_data['primary_key'];
                        $order_details = $this->Common_model->get_data_row('order',array('order_id'=>$order_id));
                        $name="Order Booking is successfully activated for : ".$order_details['order_number']." ";
                      //updating status of order booking
                        $this->Common_model->update_data('order',array('status'=>1),array('order_id'=> $order_id));
                        $order_product_id=$this->Common_model->get_data('order_product',array('order_id'=>$order_id));
                        //updating status of ob product
                        foreach($order_product_id as $op_id )
                        {
                           $this->Common_model->update_data('order_product',array('status'=>1),array('order_product_id'=> $op_id['order_product_id']));  
                        }
                        $update_approval_data = array('status'        => 2,
                                                      'modified_by'   => $this->session->userdata('user_id'),
                                                      'modified_time' => date('Y-m-d H:i:s'));
                        $updata_approval_where = array('approval_id'  => $approval_id);
                        $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

                        $insert_data = array('approval_id'   => $approval_id,
                                             'issued_by'     => $this->session->userdata('block_designation_id'),
                                             'remarks'       => $remarks,
                                             'created_by'    =>  $this->session->userdata('user_id'),
                                             'created_time'  =>  date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$insert_data);
                        
                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                            );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);
                    break;

                     case 'activate_product_order_booking':
                        $order_id = $approval_data['primary_key'];
                        $order_details = $this->Common_model->get_data_row('order',array('order_id'=>$order_id));
                        $name="Order Booking for product is successfully activated for Order Number : ".$order_details['order_number']." ";
                     
                        $op_ids=$approval_data['old_value'];
                        $order_product_id=json_decode($op_ids);
                        //updating status of ob product
                        foreach($order_product_id as $key => $op_id )
                        {  
                           
                           $this->Common_model->update_data('order_product',array('status'=>1),array('order_product_id'=> $op_id));  
                        } 
                        $update_approval_data = array('status'        => 2,
                                                      'modified_by'   => $this->session->userdata('user_id'),
                                                      'modified_time' => date('Y-m-d H:i:s'));
                        $updata_approval_where = array('approval_id'  => $approval_id);
                        $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

                        $insert_data = array('approval_id'   => $approval_id,
                                             'issued_by'     => $this->session->userdata('block_designation_id'),
                                             'remarks'       => $remarks,
                                             'created_by'    =>  $this->session->userdata('user_id'),
                                             'created_time'  =>  date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$insert_data);
                        
                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                            );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);
                    break;

                     case 'delete_order_booking_product':
                        $order_id = $approval_data['primary_key'];
                        $order_details = $this->Common_model->get_data_row('order',array('order_id'=>$order_id));
                        $name="Order Booking for product is successfully deleted for Order Number : ".$order_details['order_number']." ";
                     
                        $op_ids=$approval_data['old_value'];
                        $order_product_id=json_decode($op_ids);
                        //updating status of ob product
                        foreach($order_product_id as $key => $op_id )
                        {  
                           
                           $this->Common_model->delete_data('order_product',array('order_product_id'=> $op_id));  
                        } 
                        $update_approval_data = array('status'        => 2,
                                                      'modified_by'   => $this->session->userdata('user_id'),
                                                      'modified_time' => date('Y-m-d H:i:s'));
                        $updata_approval_where = array('approval_id'  => $approval_id);
                        $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

                        $insert_data = array('approval_id'   => $approval_id,
                                             'issued_by'     => $this->session->userdata('block_designation_id'),
                                             'remarks'       => $remarks,
                                             'created_by'    =>  $this->session->userdata('user_id'),
                                             'created_time'  =>  date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$insert_data);
                        
                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                            );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);
                    break;
                                        case 'change_ob_distributor':
                        $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
                        $pref_data = $this->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));
                        $single_level = 0;
                        $remarks = $this->input->post('remarks');
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
                    break;

                    case 'change_ob_stock':
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

                        $remarks = $this->input->post('remarks');
                        $single_level = 0;
                        
                        //echo $this->db->last_query().'<br>';exit;
                        update_rb($approval_id,$name,$remarks,$single_level); //exit; 
                    break;
                    
                    
	        	case 'delete_production':

                        // When Last Person Approved
                        // based on approval id get records in rb_production
                        $rb_production_data = $this->Common_model->get_data('rb_production',array('approval_id'=>$approval_id));
                        
                        $approval_list_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
                        $name = $approval_list_data['name'];

                        if(count($rb_production_data)>0)
                        {
                            foreach ($rb_production_data as $key => $rb_data)
                            {
                                $plant_id = $rb_production_data[0]['plant_id'];
                                // get production PM data other than film
                                $consumption =array();
                                $pdp_pm_result= $this->Common_model->get_data('production_pm',array('production_product_id'=>$rb_data['production_product_id']));
                                if(count($pdp_pm_result)>0)
                                {
                                    foreach ($pdp_pm_result as $key => $pdp_pm_data)
                                    {
                                        // Update Data in plant_pm
                                        $qry = 'UPDATE plant_pm SET quantity = quantity + "'.$pdp_pm_data['quantity'].'",updated_time ="'.date('Y-m-d H:i:s').'"  
                                                WHERE plant_id ="'.$plant_id.'" AND pm_id = "'.$pdp_pm_data['pm_id'].'"  ';
                                        $this->db->query($qry);
                                        //echo $this->db->last_query().'<br>';
                                        // Updating in pm_stock_balance                        
                                        $qry = 'UPDATE pm_stock_balance SET production = production - "'.$pdp_pm_data['quantity'].'",modified_by ="'.$this->session->userdata('user_id').'",
                                                modified_time ="'.date('Y-m-d H:i:s').'"  
                                                WHERE plant_id ="'.$plant_id.'" AND pm_id = "'.$pdp_pm_data['pm_id'].'"  AND closing_balance IS NULL ';
                                        $this->db->query($qry);
                                        //echo $this->db->last_query().'<br>';

                                    }
                                    // delete production_pm Data
                                    $qry = 'DELETE FROM production_pm WHERE  production_product_id = "'.$rb_data['production_product_id'].'"  ';
                                    $this->db->query($qry);
                                    //echo $this->db->last_query().'<br>';
                                }
                                // get production film consumption data
                                $pdp_pm_micron_result= $this->Common_model->get_data('production_pm_micron',array('production_product_id'=>$rb_data['production_product_id']));
                                if(count($pdp_pm_micron_result)>0)
                                {
                                    foreach ($pdp_pm_micron_result as $key => $pdp_pm__micron_data)
                                    {
                                        // Update Data in plant_pm
                                        $qry = 'UPDATE plant_pm SET quantity = quantity + "'.$pdp_pm__micron_data['quantity'].'",updated_time ="'.date('Y-m-d H:i:s').'"  
                                                WHERE plant_id ="'.$plant_id.'" AND pm_id = "'.$pdp_pm__micron_data['pm_id'].'"  ';
                                        $this->db->query($qry);
                                        //echo $this->db->last_query().'<br>';

                                        // Updating in pm_stock_balance                        
                                        $qry = 'UPDATE pm_stock_balance SET production = production - "'.$pdp_pm__micron_data['quantity'].'",
                                                modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"   
                                                WHERE plant_id ="'.$plant_id.'" AND pm_id = "'.$pdp_pm__micron_data['pm_id'].'"  AND closing_balance IS NULL ';
                                        $this->db->query($qry);
                                        //echo $this->db->last_query().'<br>';

                                        // Updateing in plant_film_stock
                                        $qry = 'UPDATE plant_film_stock SET quantity = quantity + "'.$pdp_pm__micron_data['quantity'].'",
                                                modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"   
                                                WHERE plant_id ="'.$plant_id.'" AND pm_id = "'.$pdp_pm__micron_data['pm_id'].'" 
                                                AND micron_id ="'.$pdp_pm__micron_data['micron_id'].'" ';
                                        $this->db->query($qry);   
                                        //echo $this->db->last_query().'<br>';                     
                                    }
                                    // delete production_pm_micron Data
                                    $qry = 'DELETE FROM production_pm_micron WHERE  production_product_id = "'.$rb_data['production_product_id'].'"  ';
                                    $this->db->query($qry);
                                   // echo $this->db->last_query().'<br>';
                                }
                                // delete production_product data
                                $qry = 'DELETE FROM production_product WHERE  production_product_id = "'.$rb_data['production_product_id'].'"  ';
                                $this->db->query($qry);
                                //echo $this->db->last_query().'<br>';

                                // update plant stock                 
                                $qry = 'UPDATE plant_product SET quantity = quantity - "'.$rb_data['quantity'].'" , updated_time ="'.date('Y-m-d H:i:s').'" 
                                        WHERE plant_id ="'.$plant_id.'" AND product_id = "'.$rb_data['product_id'].'"  ';
                                $this->db->query($qry);

                                // Update Oil Stock Balance                                
                                $oil_wt = get_oil_weight($rb_data['product_id']);
                                $items_per_carton = get_items_per_carton($rb_data['product_id']);
                                $production_oil = (($rb_data['quantity']*$oil_wt*$items_per_carton)/1000);
                                $qry ='UPDATE oil_stock_balance SET production = production - "'.$production_oil.'",
                                        modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"   
                                        WHERE plant_id = "'.$plant_id.'" AND loose_oil_id ='.get_loose_oil_id($rb_data['product_id']).' AND closing_balance IS NULL';
                                $this->db->query($qry); 
                                //echo $this->db->last_query().'<br>';
                                // Updating Approval List and history and daily corrections
                                //$remarks = 'Delete production';
                               
                               // echo $this->db->last_query().'<br>';exit;               
                            }
                            $single_level =0;
                            update_rb($approval_id,$name,$remarks,$single_level);
                        }
                    break;
                    case 'change_production_date':
                        //echo 'hello';exit;
                        $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
                        $pref_data = $this->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

                        $existing_production_date = $approval_data['old_value'];
                        $plant_production_date = $approval_data['new_value'];
                        $plant_production_id = $approval_data['primary_key'];
                        $name = $approval_data['name'];

                        $updata_new_data = array('production_date' => $plant_production_date);
                        $update_new_where = array('plant_production_id' => $plant_production_id);
                        $this->Common_model->update_data('plant_production',$updata_new_data,$update_new_where);
                        $remarks = $this->input->post('remarks');
                        $single_level = 0;
                        
                        //echo $this->db->last_query().'<br>';exit;
                        update_rb($approval_id,$name,$remarks,$single_level); //exit; 
                    break;
                    
                     case 'po_oil_lab_test_pass':
                        $lab_test_id = $approval_data['primary_key'];
                        $lab_details = $this->Common_model->get_data_row('po_oil_lab_test',array('lab_test_id'=>$lab_test_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                       // $remarks=    $approval_data['remarks'];
                        $name="PO Oil Lab Test is successfully passed For Test Number : ".$lab_details['test_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;

                    case 'po_pm_lab_test_pass':
                        $lab_test_id = $approval_data['primary_key'];
                        $lab_details = $this->Common_model->get_data_row('po_pm_lab_test',array('lab_test_id'=>$lab_test_id));
                        $old_value = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                       // $remarks=    $approval_data['remarks'];
                        $name="PO PM Lab Test is successfully passed For Test Number : ".$lab_details['test_number']."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    break;
                    case 'delete_do':
                        // When Last Person Approved
                        // based on approval id get records in approval_list                  
                        $approval_list_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
                        $name = $approval_list_data['name'];
                        $do_id = $approval_list_data['old_value'];
                        $inv_data = $this->Common_model->get_data('invoice_do',array('do_id'=>$do_id));
                        //echo count($inv_data);exit;
                        if(count($inv_data)>0)
                        {
                            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <strong>Sorry!</strong> For this DO invoice already raised. So please delete invoice First. Then Delete DO. </div>');
                            redirect(SITE_URL.'do_delete');
                        }
                        $do_order_products = $this->Rollback_do_model->get_doProducts($do_id);
                        if(@$do_order_products)
                        {
                            $order_data =  $this->Rollback_do_model->get_order_data($do_order_products[0]['order_id']);
                            $distributor_id = $order_data['distributor_id'];
                            $ob_type = $order_data['ob_type'];
                            //echo '<pre>'; print_r($order_data);exit;
                            $do_ob_product_id_arr = array();
                            $total_amount = 0;
                            foreach ($do_order_products as  $op_ids)
                            {
                                //$op_arr = explode('_',$op_ids);
                                $amount = $op_ids['do_qty']*$op_ids['product_price']*$op_ids['items_per_carton'];
                                $order_id = $op_ids['order_id'];
                                $product_id = $op_ids['product_id'];
                                $do_ob_product_id_arr[] = $op_ids['do_ob_product_id'];
                                // update order product data
                                    $qry = 'UPDATE order_product SET pending_qty = pending_qty +"'.$op_ids['do_qty'].'", status = 2
                                            ,modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"    
                                            WHERE order_id ="'.$order_id.'" AND product_id="'.$product_id.'" ';
                                    $this->db->query($qry);
                                    //echo $this->db->last_query().'<br>';

                                // update order data
                                    $qry = 'UPDATE `order` SET status = 2,modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"   
                                            WHERE order_id ="'.$order_id.'" ';
                                    $this->db->query($qry);
                                    //echo $this->db->last_query().'<br>';
                                $do_data = $this->Common_model->get_data_row('do',array('do_id'=>$do_id));
                                // inserting in rb_do
                                    $rb_do_data = array(
                                                'do_id'              =>$do_data['do_id'],
                                                'do_date'            =>$do_data['do_date'],
                                                'do_number'          =>$do_data['do_number'],
                                                'lifting_point'      =>$do_data['lifting_point'],
                                                'do_against_id'      =>$do_data['do_against_id'],
                                                'do_created_by'      =>$do_data['created_by'],
                                                'do_created_time'    =>$do_data['created_time'],
                                                'order_id'           =>$order_id,                                
                                                'product_id'         =>$product_id,
                                                'quantity'           =>$op_ids['do_qty'],   
                                                'pending_quantity'   =>$op_ids['pending_qty'],   
                                                'items_per_carton'   =>$op_ids['items_per_carton'],   
                                                'created_by'         =>$this->session->userdata('user_id'),
                                                'created_time'       =>date('Y-m-d H:i:s')
                                                
                                                    );
                                    
                              $this->Common_model->insert_data('rb_do',$rb_do_data);
                              $total_amount += $amount;  
                                    //echo $this->db->last_query().'<br>';       
                            }
                            //echo '<pre>'; print_r($do_ob_product_id_arr);//exit;
                            // delete data from do_order_product 
                                $do_ob_product_id_string = implode(",",$do_ob_product_id_arr);
                                //echo $do_ob_product_id_string;exit;
                                //echo $do_id;exit;
                                $qry = 'DELETE FROM do_order_product WHERE do_ob_product_id IN ('.$do_ob_product_id_string.')  ';
                                $this->db->query($qry);
                                //echo $this->db->last_query().'<br>';//exit;

                                //echo $this->db->affected_rows();exit;

                                //echo $this->db->last_query().'<br>';       
                            // deleting from do_order 
                                $qry = 'DELETE FROM do_order WHERE do_id ="'.$do_id.'" ';
                                $this->db->query($qry);
                                //echo $this->db->last_query().'<br>';       
                                //exit;
                            // deleting from do
                                $qry = 'DELETE FROM do WHERE do_id ="'.$do_id.'" ';
                                $this->db->query($qry);
                                //echo $this->db->last_query().'<br>';exit;
                            // updating amount
                            if($ob_type == 1)
                            {
                                // updating distributor outstanding amount 
                                $qry ='UPDATE distributor SET outstanding_amount = outstanding_amount + "'.$total_amount.'"                           
                                            WHERE distributor_id = "'.$distributor_id.'" ';
                                $this->db->query($qry);
                                //echo $this->db->last_query().'<br>';exit;
                                // inserting into dist transaction amount
                                $distributor_data = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$distributor_id));
                                $dist_trans_data = array(

                                        'distributor_id'        => $distributor_id,
                                        'trans_type_id'         => 5,
                                        'trans_amount'          => $total_amount,
                                        'outstanding_amount'    => ($distributor_data['outstanding_amount']),
                                        'remarks'               => 'DO Rollback',
                                        'trans_date'            => date('Y-m-d'),
                                        'created_by'            => $this->session->userdata('user_id'),
                                        'created_time'          => date('Y-m-d H:i:s')

                                    );
                                $this->Common_model->insert_data('distributor_trans',$dist_trans_data);
                                //echo $this->db->last_query().'<br>';exit;
                            }
                            $single_level =0;
                            $remarks = $this->input->post('remarks');
                            update_rb($approval_id,$name,$remarks,$single_level); //exit; 
                        }
                        else
                        {
                            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <strong>Sorry!</strong> For this DO  no products are available. </div>');
                            redirect(SITE_URL.'view_approval_information/'.cmm_encode(@$approval_id)); 
                        }

                    break;
                    
                    case 'delete_complete_ob':
                    {
                        $primary_key = $approval_data['primary_key'];
                        $order_number = $this->Common_model->get_value('order',array('order_id'=>$primary_key),'order_number');
                        $name="Delete Complete Order Booking for Order Number :( ".$order_number.") ";

                        $this->Common_model->delete_data('order_product',array('order_id'=> $primary_key));  
                        

                        $available = $this->Common_model->get_data_row('distributor_order',array('order_id'=>$primary_key));
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

                        $approval_history_data = array('approval_id'   =>   $approval_id,
                                               'issued_by'     =>   $issued_by,
                                               'remarks'       =>   $remarks,
                                               'created_by'    =>   $this->session->userdata('user_id'),
                                               'created_time'  =>   date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$approval_history_data);


                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                            );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);

                    }
                    break;

                    case 'delete_do_item':
                        // When Last Person Approved
                        // based on approval id get records in approval_list                  
                        $approval_list_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
                        $name = $approval_list_data['name'];
                        $do_ob_product_id = $approval_list_data['old_value'];
                        $inv_data = $this->Common_model->get_data('invoice_do_product',array('do_ob_product_id'=>$do_ob_product_id));
                        //echo count($inv_data);exit;
                        if(count($inv_data)>0)
                        {
                            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <strong>Sorry!</strong> For this DO invoice already raised. So please delete invoice First. Then Delete DO. </div>');
                            redirect(SITE_URL.'view_approval_information/'.cmm_encode(@$approval_id)); 
                        }
                        $do_order_products = $this->Rollback_do_model->get_doProducts_by_do_ob_product_id($do_ob_product_id);
                        //print_r($do_order_products);exit;
                        if(@$do_order_products)
                        {
                            $order_data =  $this->Rollback_do_model->get_order_data($do_order_products[0]['order_id']);
                            $distributor_id = $order_data['distributor_id'];
                            $ob_type = $order_data['ob_type'];
                            //echo '<pre>'; print_r($order_data);exit;
                            $do_ob_product_id_arr = array();
                            $do_ob_id_arr =array();
                            $total_amount = 0;
                            foreach ($do_order_products as  $op_ids)
                            {
                                //$op_arr = explode('_',$op_ids);
                                $amount = $op_ids['do_qty']*$op_ids['product_price']*$op_ids['items_per_carton'];
                                $order_id = $op_ids['order_id'];
                                $product_id = $op_ids['product_id'];
                                $do_ob_product_id_arr[] = $op_ids['do_ob_product_id'];
                                $do_ob_id = $op_ids['do_ob_id'];
                                // update order product data
                                    $qry = 'UPDATE order_product SET pending_qty = pending_qty +"'.$op_ids['do_qty'].'", status = 2
                                            ,modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"    
                                            WHERE order_id ="'.$order_id.'" AND product_id="'.$product_id.'" ';
                                    $this->db->query($qry);
                                    //echo $this->db->last_query().'<br>';

                                // update order data
                                    $qry = 'UPDATE `order` SET status = 2,modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"   
                                            WHERE order_id ="'.$order_id.'" ';
                                    $this->db->query($qry);
                                    //echo $this->db->last_query().'<br>';
                                $do_data = $this->Rollback_do_model->get_do_data_by_do_ob_product_id($do_ob_product_id);
                                //print_r($do_data);exit;
                                // inserting in rb_do
                                    $rb_do_data = array(
                                                'do_id'              =>$do_data['do_id'],
                                                'do_date'            =>$do_data['do_date'],
                                                'do_number'          =>$do_data['do_number'],
                                                'lifting_point'      =>$do_data['lifting_point'],
                                                'do_against_id'      =>$do_data['do_against_id'],
                                                'do_created_by'      =>$do_data['created_by'],
                                                'do_created_time'    =>$do_data['created_time'],
                                                'order_id'           =>$order_id,                                
                                                'product_id'         =>$product_id,
                                                'quantity'           =>$op_ids['do_qty'],   
                                                'pending_quantity'   =>$op_ids['pending_qty'],   
                                                'items_per_carton'   =>$op_ids['items_per_carton'],   
                                                'created_by'         =>$this->session->userdata('user_id'),
                                                'created_time'       =>date('Y-m-d H:i:s')
                                                
                                                    );
                                    
                              $this->Common_model->insert_data('rb_do',$rb_do_data);
                              $total_amount += $amount;  
                                    //echo $this->db->last_query().'<br>';       
                            }
                            //echo '<pre>'; print_r($do_ob_product_id_arr);//exit;
                            // delete data from do_order_product 
                                $do_ob_product_id_string = implode(",",$do_ob_product_id_arr);
                                //echo $do_ob_product_id_string;exit;
                                $qry = 'DELETE FROM do_order_product WHERE do_ob_product_id IN ('.$do_ob_product_id_string.')  ';
                                $this->db->query($qry);
                               // echo $this->db->last_query().'<br>';exit;

                                //echo $this->db->affected_rows();exit;

                                //echo $this->db->last_query().'<br>';       
                            // deleting from do_order 
                                //checking  condition and deleting do order
                                 $qry = 'SELECT * FROM do_order_product WHERE do_ob_id= "'.$do_ob_id.'" ';
                                 $res = $this->db->query($qry);
                                 if($res->num_rows() == 0)
                                 {
                                    $qry = 'DELETE FROM do_order WHERE do_ob_id= "'.$do_ob_id.'" ';
                                    $this->db->query($qry);
                                }
                                
                            // deleting from do
                                //checking  condition and deleting do 
                                 $do_order_data = $this->Common_model->get_data('do_order',array('do_id'=>$do_data['do_id']));
                                 if(count($do_order_data) == 0)
                                 {
                                    $qry = 'DELETE FROM do WHERE do_id ="'.$do_data['do_id'].'" ';
                                    $this->db->query($qry);
                                }
                                //echo $this->db->last_query().'<br>';exit;
                            // updating amount
                            if($ob_type == 1)
                            {
                                // updating distributor outstanding amount 
                                $qry ='UPDATE distributor SET outstanding_amount = outstanding_amount + "'.$total_amount.'"                           
                                            WHERE distributor_id = "'.$distributor_id.'" ';
                                $this->db->query($qry);
                                //echo $this->db->last_query().'<br>';exit;
                                // inserting into dist transaction amount
                                $distributor_data = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$distributor_id));
                                $dist_trans_data = array(

                                        'distributor_id'        => $distributor_id,
                                        'trans_type_id'         => 5,
                                        'trans_amount'          => $total_amount,
                                        'outstanding_amount'    => ($distributor_data['outstanding_amount']),
                                        'remarks'               => 'DO Rollback',
                                        'trans_date'            => date('Y-m-d'),
                                        'created_by'            => $this->session->userdata('user_id'),
                                        'created_time'          => date('Y-m-d H:i:s')

                                    );
                                $this->Common_model->insert_data('distributor_trans',$dist_trans_data);
                                //echo $this->db->last_query().'<br>';exit;
                            }
                            $single_level =0;
                            $remarks = $this->input->post('remarks');
                            update_rb($approval_id,$name,$remarks,$single_level); //exit; 
                        }
                        else
                        {
                            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <strong>Sorry!</strong> For this DO  no products are available. </div>');
                            redirect(SITE_URL.'view_approval_information/'.cmm_encode(@$approval_id)); 
                        }

                    break;
                    case 'reduce_do_stock':
                        // When Last Person Approved
                        // based on approval id get records in approval_list                  
                        $approval_list_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
                        $name = $approval_list_data['name'];
                        $old_qty = $approval_list_data['old_value'];
                        $new_qty = $approval_list_data['new_value'];
                        $do_ob_product_id = $approval_list_data['primary_key'];
                        $inv_data = $this->Common_model->get_data('invoice_do_product',array('do_ob_product_id'=>$do_ob_product_id));
                        //echo count($inv_data);exit;
                        if(count($inv_data)>0)
                        {
                            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <strong>Sorry!</strong> For this DO invoice already raised. So please delete invoice First. Then Delete DO. </div>');
                            redirect(SITE_URL.'view_approval_information/'.cmm_encode(@$approval_id)); 
                        }
                        $do_order_products = $this->Rollback_do_model->get_doProducts_by_do_ob_product_id($do_ob_product_id);
                        //print_r($do_order_products);exit;
                        if(@$do_order_products)
                        {
                            $order_data =  $this->Rollback_do_model->get_order_data($do_order_products[0]['order_id']);
                            $distributor_id = $order_data['distributor_id'];
                            $ob_type = $order_data['ob_type'];
                            //echo '<pre>'; print_r($order_data);exit;
                            $do_ob_product_id_arr = array();
                            $do_ob_id_arr =array();
                            $total_amount = 0;
                            foreach ($do_order_products as  $op_ids)
                            {
                                //$op_arr = explode('_',$op_ids);
                                $amount = $new_qty*$op_ids['product_price']*$op_ids['items_per_carton'];
                                $order_id = $op_ids['order_id'];
                                $product_id = $op_ids['product_id'];
                                $do_ob_product_id_arr[] = $op_ids['do_ob_product_id'];
                                $do_ob_id = $op_ids['do_ob_id'];
                                // update order product data
                                    $qry = 'UPDATE order_product SET pending_qty = pending_qty +"'.$new_qty.'", status = 2
                                            ,modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"    
                                            WHERE order_id ="'.$order_id.'" AND product_id="'.$product_id.'" ';
                                    $this->db->query($qry);

                                    $qry = 'UPDATE do_order_product SET quantity = "'.$new_qty.'",
                                                        pending_qty = pending_qty - "'.$new_qty.'",status = 1
                                            ,modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"    
                                            WHERE do_ob_product_id ="'.$do_ob_product_id.'" AND product_id="'.$product_id.'" ';
                                    $this->db->query($qry);
                                    //echo $this->db->last_query().'<br>';

                                // update order data
                                    $qry = 'UPDATE `order` SET status = 2,modified_by ="'.$this->session->userdata('user_id').'",modified_time ="'.date('Y-m-d H:i:s').'"   
                                            WHERE order_id ="'.$order_id.'" ';
                                    $this->db->query($qry);
                                    //echo $this->db->last_query().'<br>';
                                $do_data = $this->Rollback_do_model->get_do_data_by_do_ob_product_id($do_ob_product_id);
                                //print_r($do_data);exit;
                                // inserting in rb_do
                                    $rb_do_data = array(
                                                'do_id'              =>$do_data['do_id'],
                                                'do_date'            =>$do_data['do_date'],
                                                'do_number'          =>$do_data['do_number'],
                                                'lifting_point'      =>$do_data['lifting_point'],
                                                'do_against_id'      =>$do_data['do_against_id'],
                                                'do_created_by'      =>$do_data['created_by'],
                                                'do_created_time'    =>$do_data['created_time'],
                                                'order_id'           =>$order_id,                                
                                                'product_id'         =>$product_id,
                                                'quantity'           =>$new_qty,   
                                                'product_price'       =>$op_ids['product_price'],
                                                'pending_quantity'   =>($op_ids['pending_qty'] - $new_qty),   
                                                'items_per_carton'   =>$op_ids['items_per_carton'],   
                                                'created_by'         =>$this->session->userdata('user_id'),
                                                'created_time'       =>date('Y-m-d H:i:s')
                                                
                                                    );
                                    
                              $this->Common_model->insert_data('rb_do',$rb_do_data);
                              $total_amount += $amount;  
                                    //echo $this->db->last_query().'<br>';       
                            }
                                //echo $this->db->last_query().'<br>';exit;
                            // updating amount
                            if($ob_type == 1)
                            {
                                // updating distributor outstanding amount 
                                $qry ='UPDATE distributor SET outstanding_amount = outstanding_amount + "'.$total_amount.'"                           
                                            WHERE distributor_id = "'.$distributor_id.'" ';
                                $this->db->query($qry);
                                //echo $this->db->last_query().'<br>';exit;
                                // inserting into dist transaction amount
                                $distributor_data = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$distributor_id));
                                $dist_trans_data = array(

                                        'distributor_id'        => $distributor_id,
                                        'trans_type_id'         => 5,
                                        'trans_amount'          => $total_amount,
                                        'outstanding_amount'    => ($distributor_data['outstanding_amount']),
                                        'remarks'               => 'DO Rollback Reduce Stock',
                                        'trans_date'            => date('Y-m-d'),
                                        'created_by'            => $this->session->userdata('user_id'),
                                        'created_time'          => date('Y-m-d H:i:s')

                                    );
                                $this->Common_model->insert_data('distributor_trans',$dist_trans_data);
                                //echo $this->db->last_query().'<br>';exit;
                            }
                            $single_level =0;
                            $remarks = $this->input->post('remarks');
                            update_rb($approval_id,$name,$remarks,$single_level); //exit; 
                        }
                        else
                        {
                            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <strong>Sorry!</strong> For this DO  no products are available. </div>');
                            redirect(SITE_URL.'view_approval_information/'.cmm_encode(@$approval_id)); 
                        }

                    break;
                    case 'change_do_unit':
                        $approval_data = $this->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
                        $pref_data = $this->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

                        $old_val = $approval_data['old_value'];
                        $new_value = $approval_data['new_value'];
                        $do_id = $approval_data['primary_key'];                

                        $updata_new_data = array('lifting_point' => $new_value,'modified_by'=>$this->session->userdata('user_id'),'modified_time'=>date('Y-m-d H:i:s'),'remarks'=>$name);
                        $update_new_where = array('do_id' => $do_id);
                        $this->Common_model->update_data('do',$updata_new_data,$update_new_where);
                        //echo $this->db->last_query().'<br>';exit;
                        $single_level =0;
                        update_rb($approval_id,$name,$remarks,$single_level);
                    break;
                    
                    case 'change_invoice_date':
                    {
                        $primary_key = $approval_data['primary_key'];
                        $invoice_number = $this->Common_model->get_value('invoice',array('invoice_id'=>$primary_key),'invoice_number');
                        $name = "Invoice Date changed from :".format_date($approval_data['old_value'])." TO :".format_date($approval_data['new_value'])." For Invoice Number : ".$invoice_number."";
                        update_single_column_rollback($approval_id,$name,$remarks);
                    }
                    break;

                    case 'delete_complete_invoice':
                    {
                        $invoice_id = $approval_data['primary_key'];
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
                        //update do status
                        $do_data = $this->Common_model->get_data('invoice_do',array('invoice_id'=>$invoice_id));
                        foreach ($do_data as $key => $value) 
                        {
                            $qry='UPDATE do set status = 2 where do_id='.$value['do_id'].'';
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
                        
                        $approval_history_data = array('approval_id'   =>   $approval_id,
                                                       'issued_by'     =>   $issued_by,
                                                       'remarks'       =>   $remarks,
                                                       'created_by'    =>   $this->session->userdata('user_id'),
                                                       'created_time'  =>   date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$approval_history_data);

                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);
                    }
                    break;
                    case 'delete_invoice_product':
                    {
                        $invoice_id = $approval_data['primary_key'];
                        $checked_items = json_decode($approval_data['old_value']);
                        $invoice_details = $this->Common_model->get_data_row('invoice',array('invoice_id'=>$invoice_id));
                        $product_name = array();
                        foreach ($checked_items as $key => $value) 
                        {
                            $product_id = $this->Common_model->get_value('invoice_do_product',array('invoice_do_product_id'=>$value),'product_id');
                            $product_name[] = $this->Common_model->get_value('product',array('product_id'=>$product_id),'name');
                            
                        }
                        $product_name= implode(', ', $product_name);
                        $name="Delete Invoiced Products : ".$product_name." From Invoice Number : ".$invoice_details['invoice_number']."";
                        
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

                        $approval_history_data = array('approval_id'   =>   $approval_id,
                                                       'issued_by'     =>   $issued_by,
                                                       'remarks'       =>   $remarks,
                                                       'created_by'    =>   $this->session->userdata('user_id'),
                                                       'created_time'  =>   date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$approval_history_data);

                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);
                    }
                    break;
                    	case 'add_Stock_updation':
                    {
                        $product_id = $approval_data['primary_key'];
                        $plant_id = $approval_data['old_value'];
                        $new_quantity = $approval_data['new_value'];

                        $plant_name = $this->Common_model->get_value('plant',array('plant_id'=>$plant_id),'name');
                        $product_name = $this->Common_model->get_value('product',array('product_id'=>$product_id),'name');
                        $name="Stock Has Increased for Unit:".$plant_name." and product :".$product_name." With Sachets: ".$new_quantity."";

                        $items_per_carton = $this->Common_model->get_value('product',array('product_id'=>$product_id),'items_per_carton');
                        $new_qty = $new_quantity/$items_per_carton;
                        $insert_stock = array('plant_id'   =>   $plant_id,
                                              'product_id' =>   $product_id,
                                              'quantity'   =>   $new_qty,
                                              'type'       =>   1/*for increase*/,
                                              'status'     =>   1,
                                              'created_by' =>   $this->session->userdata('user_id'),
                                              'created_time'=>  date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('stock_updation',$insert_stock);

                        $qry = "INSERT INTO plant_product(plant_id, product_id, quantity) 
                                VALUES (".$plant_id.",".$product_id.",".$new_qty.")  
                                ON DUPLICATE KEY UPDATE quantity=quantity+VALUES(quantity);";
                        $this->db->query($qry);

                        $update_approval_data = array('status'        => 2,
                                                      'modified_by'   => $this->session->userdata('user_id'),
                                                      'modified_time' => date('Y-m-d H:i:s'));
                        $updata_approval_where = array('approval_id'  => $approval_id);
                        $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

                        $approval_history_data = array('approval_id'   =>   $approval_id,
                                                       'issued_by'     =>   $issued_by,
                                                       'remarks'       =>   $remarks,
                                                       'created_by'    =>   $this->session->userdata('user_id'),
                                                       'created_time'  =>   date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$approval_history_data);

                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                    );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);

                    }
                    break;

                    case 'reduce_stock_updation':
                    {
                        $product_id = $approval_data['primary_key'];
                        $plant_id = $approval_data['old_value'];
                        $new_quantity = $approval_data['new_value'];

                        $plant_name = $this->Common_model->get_value('plant',array('plant_id'=>$plant_id),'name');
                        $product_name = $this->Common_model->get_value('product',array('product_id'=>$product_id),'name');
                        $name="Stock Has Reduced for Unit:".$plant_name." and product :".$product_name." With Sachets: ".$new_quantity."";

                        $items_per_carton = $this->Common_model->get_value('product',array('product_id'=>$product_id),'items_per_carton');
                        $new_qty = $new_quantity/$items_per_carton;
                        $insert_stock = array('plant_id'   =>   $plant_id,
                                              'product_id' =>   $product_id,
                                              'quantity'   =>   $new_qty,
                                              'type'       =>   2/*for increase*/,
                                              'status'     =>   1,
                                              'created_by' =>   $this->session->userdata('user_id'),
                                              'created_time'=>  date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('stock_updation',$insert_stock);

                        $qry = "INSERT INTO plant_product(plant_id, product_id, quantity) 
                                VALUES (".$plant_id.",".$product_id.",".$new_qty.")  
                                ON DUPLICATE KEY UPDATE quantity=quantity-VALUES(quantity);";
                        $this->db->query($qry);

                        $update_approval_data = array('status'        => 2,
                                                      'modified_by'   => $this->session->userdata('user_id'),
                                                      'modified_time' => date('Y-m-d H:i:s'));
                        $updata_approval_where = array('approval_id'  => $approval_id);
                        $this->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

                        $approval_history_data = array('approval_id'   =>   $approval_id,
                                                       'issued_by'     =>   $issued_by,
                                                       'remarks'       =>   $remarks,
                                                       'created_by'    =>   $this->session->userdata('user_id'),
                                                       'created_time'  =>   date('Y-m-d H:i:s'));
                        $this->Common_model->insert_data('approval_list_history',$approval_history_data);

                        $daily_data=  array('activity'      =>  $name,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s')
                                    );
                        $this->Common_model->insert_data('daily_corrections',$daily_data);
                    }
                    break;
	        	default:
	        	break;
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
	                                <strong>Success!</strong> Rollback Changes has Been done successfully for Approval Number :'.$approval_number.' </div>');
	            }
	        	redirect(SITE_URL.'approval_list'); exit();

	        }
	        //if not matched with existing user block_designation_id
	        //update the approval_list with next waiting user
	        //insert the details entered by the existing user in approval_list_history table
	        else
	        {
	        	$issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
		        if($issue_at=='')
		        {
		            $issue_at = $issued_by;
		        }

		        $update_approval_list = array('issue_at'      =>   $issue_at,
		        							  'modified_by'   =>   $this->session->userdata('user_id'),
		        							  'modified_time' =>   date('Y-m-d H:i:s'));
		        $update_where = array('approval_id'  =>  $approval_id);
		        $this->db->trans_begin();
		        $this->Common_model->update_data('approval_list',$update_approval_list,$update_where);

	        	$approval_history_data = array('approval_id'   =>   $approval_id,
	                                           'issued_by'     =>   $issued_by,
	                                           'remarks'       =>   $remarks,
	                                           'created_by'    =>   $this->session->userdata('user_id'),
	                                           'created_time'  =>   date('Y-m-d H:i:s'));
	        	$this->Common_model->insert_data('approval_list_history',$approval_history_data);
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
	                                <strong>Success!</strong>  Details has been saved and Forwarded for Approval Number :'.$approval_number.' </div>');
	            }
	        	redirect(SITE_URL.'approval_list'); exit();
			}
		}
		else if($submit == 2)
		{
			$update_approval_list = array('status'        =>   3,
	        							  'modified_by'   =>   $this->session->userdata('user_id'),
	        							  'modified_time' =>   date('Y-m-d H:i:s'));
	        $update_where = array('approval_id'  =>  $approval_id);
	        $this->db->trans_begin();
	        $this->Common_model->update_data('approval_list',$update_approval_list,$update_where);

        	$approval_history_data = array('approval_id'   =>   $approval_id,
                                           'issued_by'     =>   $issued_by,
                                           'remarks'       =>   $remarks,
                                           'created_by'    =>   $this->session->userdata('user_id'),
                                           'created_time'  =>   date('Y-m-d H:i:s'));
        	$this->Common_model->insert_data('approval_list_history',$approval_history_data);
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
                                <strong>Success!</strong> Rollback Has been Rejected for Approval Number :'.$approval_number.' </div>');
            }
        	redirect(SITE_URL.'approval_list'); exit();
		}
    }
}