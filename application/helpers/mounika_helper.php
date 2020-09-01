<?php //Mounika Helper

function get_file_extension($file_name)
{
	if($file_name!='')
	{
		$arr = explode('.',$file_name);
		return $arr[count($arr)-1];
	}
}

function get_tender_upload_path()
{
	return 'application/uploads/tenders/';
}
function get_tender_upload_url()
{
	return SITE_URL1.'application/uploads/tenders/';
}

function get_ocb_id()
{
	$ci=& get_instance();
	$row=$ci->Common_model->get_data('po_type',array('po_type_id'=>1),array('po_type_id'));
	$type=$row[0];
	$type_id=$type['po_type_id'];
	return $type_id;
}

function get_repeat_order_id()
{
	return 3;
}
function get_type($type)
{
	if($type==1)
	{
		return "Godown";
	}
	else
	{
		return "Counter Sales";
	}
}

function get_user_name($user_id)
{
	$ci= & get_instance();
	$ci->db->from('user');
	$ci->db->where('user_id',$user_id);
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['name'];
}
//Displaying tanker in's count in dashboard
function get_no_of_tanker_in()
{    
	$ci= & get_instance();
	$date=date('Y-m-d');
	$plant_id=$ci->session->userdata('ses_plant_id');
	$ci->db->select('count(tanker_id) as num');
	$ci->db->from('tanker_register');
	$ci->db->where('plant_id',$plant_id);
	$ci->db->where('date(in_time)',$date);
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}

function get_no_of_tanker_out()
{    
	$ci= & get_instance();
	$date=date('Y-m-d');
	$plant_id=$ci->session->userdata('ses_plant_id');
	$ci->db->select('count(tanker_id) as num');
	$ci->db->from('tanker_register');
	$ci->db->where('plant_id',$plant_id);
	$ci->db->where('date(in_time)',$date);
	$ci->db->where('status',6);
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}

//Displaying Sales count in Dashboard
function get_no_of_sales()
{
	$ci= & get_instance();
	$block_id=$ci->session->userdata('block_id');
	$date=date('Y-m-d');
	$ci->db->select('count(invoice_id) as num');
	$ci->db->from('invoice');
	$ci->db->where('date(invoice_date)',$date);
	if($block_id != 1)
	{
		$ci->db->where('plant_id',get_plant_id());
	}
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}

//Displaying Production count in Dashboard
function get_no_of_production_entry()
{
	$ci= & get_instance();
	$plant_id=$ci->session->userdata('ses_plant_id');
	$date=date('Y-m-d');
	$ci->db->select('count(plant_production_id) as num');
	$ci->db->from('plant_production');
	$ci->db->where('plant_id',$plant_id);
	$ci->db->where('date(production_date)',$date);
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}

function get_status($status)
	{
		switch($status)
		{
			case 1:
					return 'Pending';
					break;
			case 2:
					return 'PO Generated';
					break;
			case 3:
					return 'Rejected';
					break;
		}
	}
function get_po_status()
{
	 $po= array('1'=>'PO Pending','3'=>'PO Closed','10'=>'Rejected');
	 return $po;
}
function get_po_status_value($status)
{
	switch($status)
	{
		case 1:
				return 'Pending';
				break;
                case 2:
				return 'Pending';
				break;
		case 3: 
				return 'Closed';
				break;
		case 10:
				return 'Rejected';
				break;
	}
}
function get_po_pm_status()
{
	 $pm= array('1'=>'PO Pending','3'=>'PO Closed','10'=>'Rejected');
	 return $pm;
}
function get_po_pm_status_value($status)
{
	switch($status)
	{
		case 1:
				return 'Pending';
				break;
		case 2:	  
				return 'Pending';
				break;
		case 3: 
				return 'Closed';
				break;
		case 10:
				return 'Rejected';
				break;
	}
}



//Displaying Distributor DD verification Count in Dashboard
function get_dist_dd_entry()
{
	$ci= & get_instance();
	$ci->db->select('count(payment_id) as num');
	$ci->db->from('distributor_payment');
	$ci->db->where('status',1);
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}
//Dispalying C&F Credit/Debit Count in Dashboard
function get_candf_credit_debit_count()
{
	$ci= & get_instance();
	$ci->db->select('count(note_id) as num');
	$ci->db->from('c_and_f_credit_debit_note');
	$ci->db->where('status',1);
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}
//Displaying C&F DD verification Count in Dashboard
function get_candf_dd_entry()
{
	$ci= & get_instance();
	$date=date('Y-m-d');
	$ci->db->select('count(payment_id) as num');
	$ci->db->from('c_and_f_payment');
	$ci->db->where('date(payment_date)',$date);
	$ci->db->where('status',1);
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}
//Displaying Order Booking's Count in Dashboard
function get_order_booking_entry()
{
	$ci= & get_instance();
	$date=date('Y-m-d');
	$ci->db->select('count(order_id) as num');
	$ci->db->from('order');
	$ci->db->where('date(order_date)',$date);
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}
//Displaying Delivery Order Count in Dashboard
function get_delivery_order_entry()
{
	$ci= & get_instance();
	$date=date('Y-m-d');
	$ci->db->select('count(do_id) as num');
	$ci->db->from('do');
	$ci->db->where('date(do_date)',$date);
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}
//Dispalying Distributor Credit/Debit Count in Dashboard
function get_dist_credit_debit_entry()
{
	$ci= & get_instance();
	$date=date('Y-m-d');
	$ci->db->select('count(note_id) as num');
	$ci->db->from('distributor_credit_debit_note');
	$ci->db->where('date(on_date)',$date);
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}
//Dispalying C&F Credit/Debit Count in Dashboard
function get_candf_credit_debit_entry()
{
	$ci= & get_instance();
	$date=date('Y-m-d');
	$ci->db->select('count(note_id) as num');
	$ci->db->from('c_and_f_credit_debit_note');
	$ci->db->where('date(on_date)',$date);
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}

//Dispalying Pending DO's Count in Dashboard
function get_pending_do_count()
{
	$ci= & get_instance();
	$block_id = $ci->session->userdata('block_id');
	$ci->db->select('count(do_id) as num');
	$ci->db->from('do');
	$ci->db->where('status <',3);
	if($block_id != 1)
	{
		$ci->db->where('lifting_point',get_plant_id());
	}
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}
//Displaying Stock receiving Count in Dashboard
function get_stock_receiving_count()
{
	$ci= & get_instance();
	$date=date('Y-m-d');
	$ci->db->select('count(stock_receipt_id) as num');
	$ci->db->from('stock_receipt');
	$ci->db->where('date(on_date)',$date);
	$ci->db->where('plant_id',get_plant_id());
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}
//Displaying Godown Count in Dashboard
function get_godown_count()
{
	$ci= & get_instance();
	$date=date('Y-m-d');
	$ci->db->select('count(gst.gst_id) as num');
	$ci->db->from('godown_stock_transfer gst');
	$ci->db->join('plant_counter pc','gst.counter_id = pc.counter_id');
	$ci->db->where('date(gst.on_date)',$date);
	$ci->db->where('gst.st_type_id',1);
	$ci->db->where('pc.plant_id',get_plant_id());
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}
//Displaying Counter Count in Dashboard
function get_counter_count()
{
	$ci= & get_instance();
	$date=date('Y-m-d');
	$ci->db->select('count(gst.gst_id) as num');
	$ci->db->from('godown_stock_transfer gst');
	$ci->db->join('plant_counter pc','gst.counter_id = pc.counter_id');
	$ci->db->where('date(gst.on_date)',$date);
	$ci->db->where('gst.st_type_id',2);
	$ci->db->where('pc.plant_id',get_plant_id());
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}


// 26 Apr 2017 Displaying Bank Guarantee's Expired date in Stock Point Dashboard
function get_no_of_bank_guarantee_expired($distributor_id='')
{
	$ci= & get_instance();
	$date=date('Y-m-d');
	$ci->db->select('count(bg_id) as num');
	$ci->db->from('bank_guarantee');
	$ci->db->where('end_date<=',$date);
	$ci->db->where('status',1);
	if($distributor_id!='')
		$ci->db->where('distributor_id',$distributor_id);
    $result=$ci->db->get();
	$res=$result->row_array();
    return $res['num'];
}
//Displaying Agreement Expired date in Stock Point Dashboard
function get_no_of_agreements_expired($distributor_id='')
{
	$ci= & get_instance();
	$date=date('Y-m-d');
	$ci->db->select('count(distributor_id) as num');
	$ci->db->from('distributor');
	$ci->db->where('agreement_end_date<=',$date);
	if($distributor_id!='')
		$ci->db->where('distributor_id',$distributor_id);
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
	/*print_r($res);
	echo $ci->db->last_query();exit;*/
}
//Displaying Bank Guarantee's Going to Expired date in Stock Point Dashboard
function get_no_of_bank_guarantee_going_expire($distributor_id='')
{
	$ci= & get_instance();
	$no_of_days=get_preference("going_to_expire_days","general_settings");
	$date=date('Y-m-d',strtotime('+'.$no_of_days.' days'));
	$ci->db->select('count(bg_id) as num');
	$ci->db->from('bank_guarantee');
	$ci->db->where('end_date>=',date('Y-m-d'));
	$ci->db->where('end_date<=',$date);
	$ci->db->where('status',1);
	if($distributor_id!='')
		$ci->db->where('distributor_id',$distributor_id);
	$result=$ci->db->get();
	$res=$result->row_array();
    return $res['num'];
}
//Displaying Agreement Going to Expired date in Stock Point Dashboard
function get_no_of_agreements_going_expire($distributor_id='')
{
	$ci= & get_instance();
	$no_of_days=get_preference("going_to_expire_days","general_settings");
	$date=date('Y-m-d',strtotime('+'.$no_of_days.' days'));
	$ci->db->select('count(distributor_id) as num');
	$ci->db->from('distributor');
	$ci->db->where('agreement_end_date>=',date('Y-m-d'));
	$ci->db->where('agreement_end_date<=',$date);
	if($distributor_id!='')
		$ci->db->where('distributor_id',$distributor_id);
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}