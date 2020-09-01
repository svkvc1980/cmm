<?php //Koushik Helper
function get_c_and_f_block_id()
{
	return 4;
}
function getMRPpriceType() 
{
	return 2;
}

function get_current_serial_number_tanker($data)
{
	$financial_year = get_financial_year();
	$ci = & get_instance();
	$ci->db->select('max('.$data['value'].') as csno');
	$ci->db->from($data['table']);
	$ci->db->where('DATE('.$data['where'].')>=',$financial_year['start_date']);
	$ci->db->where('DATE('.$data['where'].')<=',$financial_year['end_date']);
	$ci->db->where('plant_id',$data['plant_id']);
	$res = $ci->db->get();
	if($res->num_rows()>0)
	{
		$row = $res->row_array();
		return $row['csno']+1;
	}
	else
	{
		return 1;
	}
}

function get_oil_stock_balance_entry_record()
{
	$ci = & get_instance();
	$date=date('Y-m-d');
	$plant_id = $ci->session->userdata('ses_plant_id');
	$ci->db->select('oil_stock_balance_id');
	$ci->db->from('oil_stock_balance');
	$ci->db->where('plant_id',$plant_id);
	$ci->db->where('date(on_date)',$date);
	$res = $ci->db->get();
	if($res->num_rows()>0)
	{
		return $res->num_rows();
	}
	else
	{
		return 0;
	}
}

function get_current_time()
{
	return date('H:i:s');
}

function get_dist_credit_debit()
{
	$ci = & get_instance();
	$ci->db->select('note_id');
	$ci->db->from('distributor_credit_debit_note');
	$ci->db->where('plant_id',$plant_id);

}

function get_admin_designation()
{
	return 8;
}

function get_executive_designation()
{
	return 2;
}

function get_deputy_manager_designation()
{
	return 10;
}
function get_manager_designation()
{
	return 3;
}
function get_vc_designation()
{
	return 1;
}

function get_production_designation()
{
	return 4;
}
function get_lab_technician_designation()
{
	return 5;
}
function get_weigh_bridge_designation()
{
	return 6;
}
function get_security_designation()
{
	return 7;
}
function get_latest_tanker_registration($tanker_in_number,$plant_id)
{
	$ci = & get_instance();
	$ci->db->from('tanker_register');
	$ci->db->where('tanker_in_number',$tanker_in_number);
	$ci->db->where('plant_id',$plant_id);
	$ci->db->order_by('in_time DESC');
	$ci->db->limit(1);
	$res = $ci->db->get();
	if($res->num_rows()>0)
	{
		return $res->row_array();
	}
	{
		return 0;
	}
}
function get_latest_tanker_type($tanker_in_number,$plant_id)
{
	$ci = & get_instance();
	$ci->db->select('tanker_type_id');
	$ci->db->from('tanker_register');
	$ci->db->where('tanker_in_number',$tanker_in_number);
	$ci->db->where('plant_id',$plant_id);
	$ci->db->order_by('in_time DESC');
	$ci->db->limit(1);
	$res = $ci->db->get();
	$result = $res->row_array();
	return $result['tanker_type_id'];
}
function get_latest_tanker_id($tanker_in_number,$plant_id)
{
	$ci = & get_instance();
	$ci->db->select('tanker_id');
	$ci->db->from('tanker_register');
	$ci->db->where('tanker_in_number',$tanker_in_number);
	$ci->db->where('plant_id',$plant_id);
	$ci->db->order_by('in_time DESC');
	$ci->db->limit(1);
	$res = $ci->db->get();
	$result = $res->row_array();
	return $result['tanker_id'];
}
function get_latest_tanker_type_id($tanker_in_number,$plant_id,$tanker_type_id)
{
	$ci = & get_instance();
	$ci->db->select('tanker_id');
	$ci->db->from('tanker_register');
	$ci->db->where('tanker_in_number',$tanker_in_number);
	$ci->db->where('plant_id',$plant_id);
	$ci->db->where('tanker_type_id',$tanker_type_id);
	$ci->db->order_by('in_time DESC');
	$ci->db->limit(1);
	$res = $ci->db->get();
	$result = $res->row_array();
	return $result['tanker_id'];
}

function get_distributor_name($distributor_id)
{
	$ci = & get_instance();
	$ci->db->select('concat(d.distributor_code, " - (" ,d.agency_name,")") as agency_name');
	$ci->db->from('distributor d');
	$ci->db->where('d.distributor_id',$distributor_id);
	$ci->db->limit(1);
	$res = $ci->db->get();
	$result = $res->row_array();
	return $result['agency_name'];
}

function get_executive_name($executive_id)
{
	$ci = & get_instance();
	$ci->db->select('e.name');
	$ci->db->from('executive e');
	$ci->db->where('e.executive_id',$executive_id);
	$ci->db->limit(1);
	$res = $ci->db->get();
	$result = $res->row_array();
	return $result['name'];
}
function get_plant_name_by_id($plant_id)
{
	$ci = & get_instance();
	$ci->db->select('p.name');
	$ci->db->from('plant p');
	$ci->db->where('p.plant_id',$plant_id);
	$ci->db->limit(1);
	$res = $ci->db->get();
	$result = $res->row_array();
	return $result['name'];
}
function get_reporting_preference($name,$section)
{
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->where('section',$section);
	$ci->db->where('name',$name);
	$ci->db->from('reporting_preference');
	$query=$ci->db->get();
	$num = $query->num_rows();
	
	if($num>0)
	{
		$value = $query->row_array();
		return $value;
	}
}

function update_single_column_rollback($approval_id,$name,$remarks)
{
	$ci=& get_instance();
	$block_designation_id = $ci->session->userdata('block_designation_id');
	$approval_data = $ci->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
	$pref_data = $ci->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

	$update_data = array($pref_data['table_column'] => $approval_data['new_value']);
	$update_where = array($pref_data['table_primary_column'] => $approval_data['primary_key']);
	$ci->Common_model->update_data($pref_data['table_name'],$update_data,$update_where);

	$update_approval_data = array('status'        => 2,
								  'modified_by'	  => $ci->session->userdata('user_id'),
								  'modified_time' => date('Y-m-d H:i:s'));
	$updata_approval_where = array('approval_id'  => $approval_id);
	$ci->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

	if($block_designation_id != $pref_data['issue_raised_by'])
	{
	$insert_data = array('approval_id'   => $approval_id,
						 'issued_by'     => $ci->session->userdata('block_designation_id'),
						 'remarks'	     => $remarks,
						 'created_by'    =>  $ci->session->userdata('user_id'),
                         'created_time'  =>  date('Y-m-d H:i:s'));
	$ci->Common_model->insert_data('approval_list_history',$insert_data);
	}

	$daily_data=  array('activity'      =>  $name,
                        'created_by'    =>  $ci->session->userdata('user_id'),
                        'created_time'  =>  date('Y-m-d H:i:s')
                        );
    $ci->Common_model->insert_data('daily_corrections',$daily_data);
}

function get_approval_number()
{
	$ci = & get_instance();
	$ci->db->select('max(approval_number) as num');
	$ci->db->from('approval_list');
	$res = $ci->db->get();
	if($res->num_rows()>0)
	{
		$row = $res->row_array();
		return $row['num']+1;
	}
	else
	{
		return 1;
	}
}

function get_pending_approvals()
{
	$ci= & get_instance();
	$ci->db->select('count(al.approval_id) as num');
	$ci->db->from('approval_list al');
	$ci->db->where('al.issue_at',$ci->session->userdata('block_designation_id'));
	$ci->db->where('al.status',1);
	$result=$ci->db->get();
	$res=$result->row_array();
	return $res['num'];
}